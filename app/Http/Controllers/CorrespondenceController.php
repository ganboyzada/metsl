<?php

namespace App\Http\Controllers;

use App\Enums\CorrespondenceStatusEnum;
use App\Http\Requests\CorrespondenceRequest;
use App\Http\Requests\ProjectRequest;
use App\Http\Requests\UserRequest;
use App\Models\Contractor;
use App\Models\Permission;
use App\Models\Project;
use App\Models\Role;
use App\Models\User;
use App\Services\ClientService;
use App\Services\CompanyService;
use App\Services\ContractorService;
use App\Services\CorrespondenceFileService;
use App\Services\CorrespondenceService;
use App\Services\DesignTeamService;
use App\Services\ProjectDocumentFilesService;
use App\Services\ProjectManagerService;
use App\Services\ProjectService;
use App\Services\UserService;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use View;


class CorrespondenceController extends Controller
{
    public function __construct(
        protected ProjectService $projectService , 
        protected ContractorService $contractorService ,
        protected ClientService $clientService ,
        protected DesignTeamService $designTeamService ,
        protected ProjectManagerService $projectmanagerService ,
        protected UserService $userService,
        protected CorrespondenceService $correspondenceService,
        protected CorrespondenceFileService $correspondenceFileService,
        protected ProjectDocumentFilesService $projectDocumentFilesService
       

        )
    {
    }



    public function create(Request $request){
        if (Session::has('projectID') && Session::has('projectName')){
            $id = Session::get('projectID');
            $type = $request->type;
            $reply_correspondence_id = $request->correspondece ?? NULL;
            if($reply_correspondence_id != NULL){
                $reply_correspondence = $this->correspondenceService->edit($reply_correspondence_id);

            }
          //  $next_number =  $this->correspondenceService->getNextNumber($type , $id);
          $files = $this->projectDocumentFilesService->getNewestFilesByProjectId( $id);

        }
        
        return view('metsl.pages.correspondence.create', get_defined_vars());
    }

    public function store(CorrespondenceRequest  $request)
    {
        if($request->validated()){
            \DB::beginTransaction();
            try{
                $all_data = request()->all();
                $all_data['created_by'] = \Auth::user()->id;

                $all_data['created_date'] = date('Y-m-d');

                $model = $this->correspondenceService->create($all_data);
                if($all_data['reply_correspondence_id'] != NULL){
                    $new_data['id'] = $all_data['reply_correspondence_id'];
                    $new_data['status'] = $all_data['status'];
                    $new_data['project_id'] = $all_data['project_id'];
                    $this->correspondenceService->update_status($new_data);
                }

            \DB::commit();
            // all good
            } catch (\Exception $e) {
                \DB::rollback();
                return response()->json(['error' => $e->getMessage()]);
            }

                       
            return response()->json(['success' => 'Form submitted successfully.' , 'data'=>$model]);

        }
    }

    public function edit($id){
        $correspondece = $this->correspondenceService->edit($id);
          $files = $this->projectDocumentFilesService->getNewestFilesByProjectId( Session::get('projectID'));

        return view('metsl.pages.correspondence.edit', get_defined_vars());

    }

    public function update(CorrespondenceRequest  $request)
    {
        if($request->validated()){
            \DB::beginTransaction();
            try{
                $all_data = request()->all();
               // $all_data['created_by'] = \Auth::user()->id;

                //$all_data['created_date'] = date('Y-m-d');

                $model = $this->correspondenceService->update($all_data);
            \DB::commit();
            // all good
            } catch (\Exception $e) {
                \DB::rollback();
                return response()->json(['error' => $e->getMessage()]);
            }

                       
            return response()->json(['success' => 'Form submitted successfully.' , 'data'=>$model]);

        }
    }

    public function getUsers(Request $request){
        if (Session::has('projectID') && Session::has('projectName')){
            $id = Session::get('projectID');     
			$all = $this->userService->getUsersOfProjectID($id , '');
            $assigness = $this->userService->getUsersOfProjectID($id , 'reply_'.$request->type);
			$distributions = $this->userService->getUsersOfProjectID($id , 'distribution_members_correspondence');
			
            $assigned_users = $assigness['users'];
            $destrbution_users = $distributions['users'];
            $users = $all['users'];
            $id = Session::get('projectID');
            $next_number =  $this->correspondenceService->getNextNumber($request->type , $id);
            return ['assigned_users'=>$assigned_users , 'destrbution_users'=>$destrbution_users , 'users'=>$users , 'next_number'=>$next_number];
        }

    }


    public function ProjectCorrespondence(Request $request){
        $id = Session::get('projectID');
        dd($id);
        $correspondeces = $this->correspondenceService->getAllProjectCorrespondence($id , $request);
        $correspondeces->map(function($row){
            return $row->status_color = [CorrespondenceStatusEnum::from($row->status) , CorrespondenceStatusEnum::from($row->status)->color()];
        });
     
        return $correspondeces;
    }

    public function ProjectCorrespondenceOpen(Request $request){
        $id = Session::get('projectID');
        //dd($id);
        $correspondeces = $this->correspondenceService->getAllProjectCorrespondenceOpen($id , $request);
        $correspondeces->map(function($row){
            return $row->status_color = [CorrespondenceStatusEnum::from($row->status) , CorrespondenceStatusEnum::from($row->status)->color()];
        });
     
        return $correspondeces;
    }

    public function find($id){
        $correspondece = $this->correspondenceService->find($id);
        
        if($correspondece->reply_correspondence_id == NULL){
            $others_correspondeces_realated = $this->correspondenceService->getCorrespondenceReplies($correspondece->project_id , $correspondece->id)->map(function($row){
                $row->status_color = [CorrespondenceStatusEnum::from($row->status) , CorrespondenceStatusEnum::from($row->status)->color()];
                return $row;
            });
        }else{
            $others_correspondeces_realated = $this->correspondenceService->getCorrespondenceParent($correspondece->project_id , $correspondece->reply_correspondence_id)->map(function($row){
                $row->status_color = [CorrespondenceStatusEnum::from($row->status) , CorrespondenceStatusEnum::from($row->status)->color()];
                return $row;
            });

        }
        return view('metsl.pages.correspondence.view', get_defined_vars());

    }

    
    public function destroy($id){
        $this->correspondenceService->delete($id);
        
    }
    public function destroyFile($id){
        $this->correspondenceFileService->delete($id);
        return redirect()->back()->with('success' , 'Item deleted successfully');
    }
}