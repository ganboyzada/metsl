<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProjectRequest;
use App\Http\Requests\UserRequest;
use App\Jobs\SendUserEmail;
use App\Mail\StakholderEmail;
use App\Models\Company;
use App\Models\Contractor;
use App\Models\Permission;
use App\Models\Project;
use App\Models\Role;
use App\Models\User;
use App\Services\ClientService;
use App\Services\CompanyService;
use App\Services\ContractorService;
use App\Services\DesignTeamService;
use App\Services\ProjectFileService;
use App\Services\ProjectManagerService;
use App\Services\ProjectService;
use App\Services\UserService;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use View;


class ProjectController extends Controller
{
    public function __construct(
        protected ProjectService $projectService , 
        protected ContractorService $contractorService ,
        protected ClientService $clientService ,
        protected DesignTeamService $designTeamService ,
        protected ProjectManagerService $projectmanagerService ,
        protected UserService $userService,
        protected ProjectFileService $projectFileService

        )
    {
    }

    public function detail(Request $request){
        // $users = \App\Models\User::all();
        // foreach($users as $user){
        //     SendUserEmail::dispatch('test' , 'testt' , 'marina3mad100@gmail.com' ,'');
        // }
    //    dd(checkIfUserHasThisPermission(3 , 'view_RFC'));
    //      $enums_list = \App\Enums\CorrespondenceTypeEnum::cases();
    //             foreach ($enums_list as $enum) {
    //                 //if(checkIfUserHasThisPermission(3 , 'view_'.$enum->value)){
    //                     print('view_'.$enum->value);
    
    //                // }
    //             }

    //       return;      

       // phpinfo();
        // $project = $this->projectService->find($request->id);
        if (Session::has('projectID') && Session::has('projectName')){
            $id = Session::get('projectID');
        }    

        // $project_name = 'asd2';
        // $job_title = 'asd3';
        // $email = 'marina3mad100@gmail.com';
        // $pass = '12345678';
        // $m = \Mail::to('marina3mad100@gmail.com')->send(new StakholderEmail($project_name , $job_title , $email ,$pass ));
       // return $request->session()->all();
//  $pdfFullPath = storage_path('app/public/HAL-OV-FF-1002.pdf');

//     if (!file_exists($pdfFullPath)) {
//         return response()->json([
//             'error' => 'PDF file not found at path: ' . $pdfFullPath
//         ], 404);
//     }

//     try {
//         $pdf = new \Spatie\PdfToImage\Pdf($pdfFullPath);

//         // Save first page as image
//         $imageName = 'HAL-OV-FF-1002.jpg';
//         $imagePath = storage_path('app/public/' . $imageName);

//         $pdf->setPage(1)->saveImage($imagePath);

//         return response()->json([
//             'message' => 'PDF uploaded and first page converted to image.',
//             'image' => asset('storage/' . $imageName),
//         ]);
//     } catch (\Exception $e) {
//         return response()->json([
//             'error' => 'Conversion failed: ' . $e->getMessage()
//         ], 500);
//     }       
       return view('metsl.pages.projects.project', get_defined_vars());
    }
    
    public function storeIdSession(Request $request){
         session(['projectID' => $request->projectID]);
         session(['projectName' => $request->projectName]);

         Session::put('projectID', $request->projectID);
         Session::put('projectName', $request->projectName);

         cookie('projectName', 'ttt', 60);
         cookie('projectID', $request->projectID, 60);

         $request->session()->put('projectID', $request->projectID);
         $request->session()->put('projectName', $request->projectName);

        return response()->json(['success' => 'Form submitted successfully.' , 'data'=>session('projectID')]);
    }

    public function allProjects(){
        $projects = $this->projectService->all();

       // dd($this->contractorService->projectsOfContractor(1)[0]->projects);
        return view('metsl.pages.projects.projects', get_defined_vars());
    }

    public function create(Request $request){
        //$proj = \App\Models\Project::where('id' , 3)->with('stakholders.roles')->first();
        //$proj = \App\Models\User::where('id' , 3)->with('roles.pivot.project')->first();
       // $proj = \App\Models\Project::where('id' , 3)->with('usersViaRole')->first();
      // $proj = \App\Models\User::with(['roles.pivot.project' => function ($query) {
        //$query->where('id', 3);
        //}])->where('users.id' , 3)->first();

        //$roles = \App\Models\ModelHasRoles::where('project_id',3)->where('model_id',3)
        //->with('role')->get();
        //print('<pre>');
        //$user  = \App\Models\User::where('id' , 3)->with('userable')->first();
        //dd($user->userable);
		
		
		//$proj = Project::with('contractors')->where('id',6)->first();
		//return $proj;
        
        if(checkIfUserHasThisPermission(Session::get('projectID') ,'create_projects')){
            // $clients = $this->clientService->all();
            // $contractors = $this->contractorService->all();
            // $design_teams = $this->designTeamService->all();
            // $project_managers = $this->projectmanagerService->all();

            $users =  $this->userService->all();
            $companies = Company::where('active', true)->get()->keyBy('id');
            $roles = Role::with('permissions')->get();
            $role_permission_arr = [];
            if($roles->count() > 0){
                foreach($roles as $role){
                    $role_permission_arr[$role->name] = $role->permissions->pluck('name')->toArray();
                }
            }
            $permissions = Permission::all();
        // $c = Contractor::where('id',23)->with('user.permissions')->first();
            //dd($c->user->permissions);

            return view('metsl.pages.projects..wizard.project-wizard', get_defined_vars());
        }
    }


    public function store_user(UserRequest $request){
        \DB::beginTransaction();
        if($request->validated()){
            try{         
                $data = $request->validated();
                if(isset($data['user_id']) && $data['user_id'] != NULL){
                    $user = $this->userService->update($data);
                    $user = $this->userService->find($data['user_id']);
                }else{
                  //  dd('ok');
                    $user = $this->userService->create($data);
                }
                
                //dd($data['user_type']);
                // $data['user_name']=$data['first_name'].' '.$data['last_name'];
                // if($data['user_type'] == 'client'){
                //     $model = $this->clientService->create($data);
                //     $user = $this->userService->create($data);
                //     $model->user()->save($user);                
                // }else if($data['user_type'] == 'contractor'){
                //     $model = $this->contractorService->create($data);
                //     $user = $this->userService->create($data);
                //     $model->user()->save($user);
                // }else if($data['user_type'] == 'designTeam'){
                //     $model = $this->designTeamService->create($data);
                //     $user = $this->userService->create($data);
                //     $model->user()->save($user);                
                // }else if($data['user_type'] == 'projectManager'){
                //     $model = $this->projectmanagerService->create($data);
                //     $user = $this->userService->create($data);
                //     $model->user()->save($user);                
                // }
                
                \DB::commit();
                // all good
            } catch (\Exception $e) {
                \DB::rollback();
                return response()->json(['error' => $e->getMessage()]);
            }              
             return response()->json(['success' => 'Form submitted successfully.' , 'data'=>$user , 'user'=>$user]);

        }

    }

    public function search(Request $request){
        $users = $this->userService->search($request);
        return response()->json($users);

    }

    public function store(ProjectRequest  $request)
    {
        
        if($request->validated()){
            \DB::beginTransaction();
            try{
                $all_data = request()->all();
                $all_data['all_stakholders'] = json_decode($all_data['all_stakholders']);
                $all_data['created_by'] = \Auth::user()->id;
                $model = $this->projectService->create($all_data);
            \DB::commit();
            // all good
            } catch (\Exception $e) {
                \DB::rollback();
                return response()->json(['error' => $e->getMessage()]);
            }

                       
            return response()->json(['success' => 'Form submitted successfully.' , 'data'=>$model]);

        }
    }

    public function edit(Request $request , $id){
        $project = $this->projectService->find($id);
        //return $project;
        // $clients = $this->clientService->all();
        // $contractors = $this->contractorService->all();
        // $design_teams = $this->designTeamService->all();
        // $project_managers = $this->projectmanagerService->all();
        $users =  $this->userService->all();
        $companies = Company::where('active', true)->get()->keyBy('id');
        $roles = Role::with('permissions')->get();
        $role_permission_arr = [];
        if($roles->count() > 0){
            foreach($roles as $role){
                $role_permission_arr[$role->name] = $role->permissions->pluck('name')->toArray();
            }
        }
        $permissions = Permission::all();
       // $c = Contractor::where('id',23)->with('user.permissions')->first();
        //dd($c->user->permissions);
        //return get_defined_vars();
        return view('metsl.pages.projects..wizard.project-wizard-edit', get_defined_vars());
    }

    public function update(ProjectRequest  $request)
    {
        
        if($request->validated()){
            \DB::beginTransaction();
            try{
                $all_data = request()->all();
                $all_data['all_stakholders'] = json_decode($all_data['all_stakholders']);
                $model = $this->projectService->update($all_data);
            \DB::commit();
            // all good
            } catch (\Exception $e) {
                \DB::rollback();
                return response()->json(['error' => $e->getMessage()]);
            }
                       
            return response()->json(['success' => 'Form submitted successfully.' , 'data'=>$model]);

        }
    }

    public function destroy($id){
        $this->projectService->delete($id);
        //return redirect()->back()->with('success' , 'Item deleted successfully');

        
    }
    public function destroyFile($id){
        $this->projectFileService->delete($id);
        return redirect()->back()->with('success' , 'Item deleted successfully');
    }

}
