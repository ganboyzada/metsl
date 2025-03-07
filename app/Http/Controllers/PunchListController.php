<?php

namespace App\Http\Controllers;

use App\Enums\CorrespondenceStatusEnum;
use App\Enums\RevisionStatusEnum;
use App\Http\Requests\CorrespondenceRequest;
use App\Http\Requests\DocumentRequest;
use App\Http\Requests\MeetingPlaningRequest;
use App\Http\Requests\PunchListRequest;
use App\Services\ClientService;
use App\Services\ContractorService;
use App\Services\DesignTeamService;
use App\Services\DocumentService;
use App\Services\MeetingPlaningService;
use App\Services\ProjectDocumentRevisionsService;
use App\Services\ProjectManagerService;
use App\Services\ProjectService;
use App\Services\PunchListFilesService;
use App\Services\PunchListService;
use App\Services\UserService;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use View;


class PunchListController extends Controller
{
    public function __construct(

        protected PunchListService $punchListService,
        protected userService $userService,
        protected PunchListFilesService $punchListFilesService

        )
    {
    }

    public function create(){
        return view('metsl.pages.punch-list.create');
    }

    public function edit($id){
        $punch_list_id = $id;
        $punch_list = $this->punchListService->find($punch_list_id);
        /*$distribution_members = $this->userService->getUsersOfProjectID(Session::get('projectID') , '');
        $responsible = $this->userService->getUsersOfProjectID(Session::get('projectID') , '');
        
        $distribution_members = $distribution_members['users'];
        $responsible = $responsible['users'];*/
      // return $punch_list;
        return view('metsl.pages.punch-list.view', get_defined_vars());
    }


    public function view($id){
        $punch_list_id = $id;
        $punch_list = $this->punchListService->find($punch_list_id);
        /*$distribution_members = $this->userService->getUsersOfProjectID(Session::get('projectID') , '');
        $responsible = $this->userService->getUsersOfProjectID(Session::get('projectID') , '');
        
        $distribution_members = $distribution_members['users'];
        $responsible = $responsible['users'];*/
      // return $punch_list;
        return view('metsl.pages.punch-list.view', get_defined_vars());
    }

    public function store(PunchListRequest  $request)
    {

        if($request->validated()){
            \DB::beginTransaction();
            try{
                $all_data = request()->all();
                $all_data['created_by'] = \Auth::user()->id;
                $all_data['closed_by'] = \Auth::user()->id;

                $all_data['project_id'] = Session::get('projectID');
                $all_data['status'] = 0;
                $all_data['date_notified_at'] = date('Y-m-d');
                $model = $this->punchListService->create($all_data);
            \DB::commit();
            // all good
            } catch (\Exception $e) {
                \DB::rollback();
                return response()->json(['error' => $e->getMessage()]);
            }

                       
            return response()->json(['success' => 'Form submitted successfully.' , 'data'=>$model]);

        }
    }


    public function update(PunchListRequest  $request)
    {

        if($request->validated()){
            \DB::beginTransaction();
            try{
                $all_data = request()->all();
                //$all_data['created_by'] = \Auth::user()->id;

                //$all_data['project_id'] = Session::get('projectID');

                $model = $this->punchListService->update($all_data);
            \DB::commit();
            // all good
            } catch (\Exception $e) {
                \DB::rollback();
                return response()->json(['error' => $e->getMessage()]);
            }

                       
            return response()->json(['success' => 'Form submitted successfully.' , 'data'=>$model]);

        }
    }    

    public function getParticipates(Request $request){
        if (Session::has('projectID') && Session::has('projectName')){
            $id = Session::get('projectID');     
            $next_number =  $this->punchListService->getNextNumber($id);

            $distribution_members = $this->userService->getUsersOfProjectID($id , 'distribution_members_punch_list');
            $responsible = $this->userService->getUsersOfProjectID($id , 'responsible_punch_list');
			
            $distribution_members = $distribution_members['users'];
            $responsible = $responsible['users'];

            return ['distribution_members'=>$distribution_members, 'responsible'=>$responsible  , 'next_number'=>$next_number];
        }

    }

    public function getAllParticipates(Request $request){
        if (Session::has('projectID') && Session::has('projectName')){
            $id = Session::get('projectID');     
            $all = $this->userService->getUsersOfProjectID($id , '');             
            return ['users'=>$all['users']];
        }

    }



    public function getStatusPeriorityOption(Request $request){
        if (Session::has('projectID') && Session::has('projectName')){
            $id = Session::get('projectID');     
            $priority_list = [];           
            $statusPieChart = $this->punchListService->getStatusPieChart($id);
            $enums_list = \App\Enums\PunchListPriorityEnum::cases();
            foreach ($enums_list as $enum){
                $priority_list[] = ['label'=>$enum->name , 'value'=>$enum->value];
            }
            $status_list = [];
            $status_list_labels = [];
            $status_list_colors = [];
            $status_list_values = [];
            $enums_list = \App\Enums\PunchListStatusEnum::cases();
            foreach ($enums_list as $enum){
                $status_list[] = ['label'=>$enum->text() , 'value'=>$enum->value];
                $status_list_labels[] = $enum->text();
                $status_list_colors[] = $enum->color();
                $status_list_values[] = $statusPieChart[$enum->text()] ?? 0;

            }                 
            return ['priority'=> $priority_list, 
            'status'=> $status_list , 'status_list_labels'=>$status_list_labels , 
            'status_list_colors'=>$status_list_colors , 'statusPieChart'=>$status_list_values];
        }

    }
    public function PunchList(Request $request){
        $id = Session::get('projectID');
        $punchLists = $this->punchListService->getAllProjectPunchList($id , $request);
        $punchLists->map(function($row){

            $row->status_text = $row->status->text();
            $row->status_color = $row->status->color();

            $row->priority_text = $row->priority->color();
            return $row;
        });
     
        return $punchLists;
    }

    public function destroy($id){
        $this->punchListService->delete($id);
        
    }
    public function destroyFile($id){
        $this->punchListFilesService->delete($id);
        return redirect()->back()->with('success' , 'Item deleted successfully');
    }

    public function store_reply(Request $request){
        $data = $request->all();
        $err = $request->validate([
            'description_reply' => 'required|string|max:255',
            'title' => 'required|',
            'punch_list_id' => 'required',
           
        ]);
        $data['created_by'] = \Auth::user()->id;
        $data['created_date'] = date('Y-m-d');
        $data['description'] = $request->description_reply;

    
        if($data['docs'] != NULL){
            $file = $data['docs'];
            $fileName = $file->getClientOriginalName();
    
            $path = Storage::disk('public')->path('project'.$data['project_id'].'/punch_list'.$data['punch_list_id'].'/replies');
                
            \File::makeDirectory($path, $mode = 0777, true, true);
    
            Storage::disk('public')->putFileAs( 'project'.$data['project_id'].'/punch_list'.$data['punch_list_id'].'/replies', $file, $fileName);
            $data['file'] = $fileName;
   
        } 
        

        //dd($err);
        $model = \App\Models\PunchlistReplies::create($data);
        return response()->json(['success' => 'Form submitted successfully.' , 'data'=>$model]);
    }

    public function change_status(Request $request){
        if($request->status == 2){
            \App\Models\PunchList::where('id',$request->id)->update(['status'=>$request->status,'date_resolved_at'=>Carbon::now()->format('Y-m-d')]);

        }else{
            \App\Models\PunchList::where('id',$request->id)->update(['status'=>$request->status]);

        }
        return response()->json(['success' => 'Form changed successfully.' ]);
    }

}