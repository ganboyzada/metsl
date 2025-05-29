<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;
use App\Models\WorkPackages;
use App\Models\PunchList;
use App\Services\UserService;


class CompanyController extends Controller
{
	
	
    public function __construct(
        protected userService $userService, 
  

        )
    {
    }
    // Display a listing of the companies
    public function index()
    {
        $companies = Company::all();
        
        return view('metsl.pages.companies.index', compact('companies'));
    }

    // Show the form for creating a new company
    public function create()
    {
        $packages = WorkPackages::all();
        return view('metsl.pages.companies.create',compact('packages'));
    }

    // Store a newly created company in storage
    public function store(Request $request)
    {
        $data = $request->all();
        $data['active'] = ($request->active) ? true : false;      
        $err = $request->validate([
            'name' => 'required|string|max:255',
            'specialty' => 'required|string|max:255',
            'phone' => 'nullable|string|max:15',
            'email' => 'nullable|email|max:255',
            'address' => 'nullable|string|max:255',
            'work_packages' => 'required|array',
        ]);
        //dd($err);
        $modal = Company::create($data);
        $modal->packages()->sync($request->work_packages);
        return redirect()->route('companies')->with('success', 'Company created successfully.');
    }

    // Show the form for editing the specified company
    public function edit($id)
    {
        $packages = WorkPackages::all();
        $company = Company::with('packages')->findOrFail($id);
        $selected = $company->packages->pluck('id')->toArray();
        return view('metsl.pages.companies.edit', compact('company','packages','selected'));
    }

    // Update the specified company in storage
    public function update(Request $request, $id)
    {
        $data = $request->all();
        $data['active'] = ($request->active) ? true : false;
        $request->validate([
            'name' => 'required|string|max:255',
            'specialty' => 'required|string|max:255',
            'phone' => 'nullable|string|max:15',
            'email' => 'nullable|email|max:255',
            'address' => 'nullable|string|max:255',
            'work_packages' => 'required|array',
            //'active' => 'boolean',
        ]);
        ///dd($request->all());
        $company = Company::findOrFail($id);
		$old_package = $company->packages()->pluck('work_packages.id')->toArray();
		
        $company->update($data);
		
		
		if(count($old_package) > 0 ){
			foreach($old_package as $old){
				if(!in_array($old , $request->work_packages)){
				$snags = PunchList::where('work_package_id',$old)->get();
				if($snags->count() > 0){
					foreach($snags as $snag){
						$users_of_work_packages = WorkPackages::join('company_work_packages', 'company_work_packages.work_package_id', '=', 'work_packages.id')
						->join('users', 'users.company_id', '=', 'company_work_packages.company_id')
						
						->where('work_packages.id', $old)->where('users.company_id',$id)
						->select('users.id')->pluck('users.id')->toArray();
						
						//dd($users_of_work_packages);
						\DB::table('punch_list_assignees')->where('punch_list_id',$snag->id)
						->whereIn('user_id',$users_of_work_packages)->delete();
					}
				}
						
					
				}
			}
		}
		//dd('ok');
		// 
		
		
		if(count($request->work_packages) > 0){
			foreach($request->work_packages as $package_id){
				if(!in_array($package_id  , $old_package)){
					$snags = PunchList::where('work_package_id',$package_id)->get();
					if($snags->count() > 0){
						
						foreach($snags as $snag){
							$assignees_has_permission = collect($this->userService->getUsersOfProjectID($snag->project_id , 'responsible_punch_list')['users'])->pluck('id')->toArray();

							$users_of_work_packages = \DB::table('users')->join('companies','companies.id','=','users.company_id')
							->where('users.company_id',$id)->whereIn('users.id',$assignees_has_permission)
							->select('users.id')->pluck('users.id')->toArray();
							

							 

							//dd($users_of_work_packages);
							
							//$d = $snag->assignees()->attach($users_of_work_packages);
							if(count($users_of_work_packages) > 0){
								foreach($users_of_work_packages as $userId){
									
									$chk = \DB::table('punch_list_assignees')->where(['punch_list_id'=>$snag->id , 'user_id'=>$userId])->first();
									if(!isset($chk->$id)){
										\DB::table('punch_list_assignees')->insert(['punch_list_id'=>$snag->id , 'user_id'=>$userId]);
									}
									
									
								}
							}
							
							
				
						}
							
					}
					
					
					
				}
			
			}
		}
		
		$company->packages()->sync($request->work_packages);

		
		return redirect()->back()->with('success', 'Company updated successfully.');
    }

    // Remove the specified company from storage
    public function destroy($id)
    {
        $company = Company::findOrFail($id);
        $company->delete();
        return redirect()->route('companies')->with('success', 'Company deleted successfully.');
    }
}
