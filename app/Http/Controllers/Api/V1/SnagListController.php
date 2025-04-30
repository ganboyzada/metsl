<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\PunchListRequest;
use App\Http\Requests\ReplyRequest;
use App\Http\Requests\StatusRequest;
use App\Http\Resources\ProjectResource;
use App\Http\Resources\punchListResource;
use App\Http\Resources\ReplyResource;
use App\Http\Resources\UserProfileResource;
use App\Models\Correspondence;
use App\Models\ProjectDocument;
use App\Models\PunchList;
use App\Services\ProjectDocumentFilesService;
use App\Services\ProjectDrawingsService;
use App\Services\ProjectService;
use App\Services\PunchListService;
use App\Services\UserService;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class SnagListController extends Controller
{
    public function __construct(
        protected ProjectService $projectService,
        protected PunchListService $punchListService,
        protected UserService $userService,
        protected ProjectDocumentFilesService $projectDocumentFilesService,
        protected ProjectDrawingsService $projectDrawingsService,

        )
    {
    }

    public function checkPermission(Request $request){
        $project_id = $request->project_id;
        $permission = $request->permission;
        $punch_list_id = $request->punch_list_id;

        
        if($punch_list_id != null){
            $punch_list = $this->punchListService->find($punch_list_id);

        }
        
        if($permission == 'reply' && isset($punch_list->id)){
            if(checkIfUserHasThisPermission($project_id ,'responsible_punch_list') ||
            checkIfUserHasThisPermission($project_id ,'distribution_members_punch_list') ||
            $punch_list->created_by == auth()->user()->id
            ){
                return $this->sendResponse(['status' => true], "You are allowed to add reply.");

            }
            return $this->sendResponse(['status' => false], "You are not allowed to add reply.");

        }
        else if($permission == 'update'  && isset($punch_list->id)){
            if(checkIfUserHasThisPermission($project_id ,'responsible_punch_list') ||
            checkIfUserHasThisPermission($project_id ,'distribution_members_punch_list') ||
            $punch_list->created_by == auth()->user()->id
            ){
                return $this->sendResponse(['status' => true], "You are allowed to update.");

            }
            return $this->sendResponse(['status' => false], "You are not allowed to update.");

        }

        else if($permission == 'delete' && isset($punch_list->id)){
            if( $punch_list->created_by == auth()->user()->id){

                return $this->sendResponse(['status' => true], "You are allowed to delete.");

            }
            return $this->sendResponse(['status' => false], "You are not allowed to delete.");

        }        
        else if($permission == 'create'){
            
            if(checkIfUserHasThisPermission($project_id ,'add_punch_list')){

                return $this->sendResponse(['status' => true], "You are allowed to create.");

            }
            return $this->sendResponse(['status' => false], "You are not allowed to create.");
        }

        return $this->sendResponse(['status' => false], "You are not allowed.");

    }

    public function getSnagList(Request $request , $project_id){
        $punchLists = $this->punchListService->getAllProjectPunchListPaginate($project_id);
        $res = $this->getList($punchLists, $request, 'punchList');
        // $result['data'] = $res->items();
        // $result['pagination'] =  [
        //         'current_page' => $res->currentPage(),
        //         'total_pages' => $res->lastPage(),
        //         'per_page' => $res->perPage(),
        //         'total' => $res->total()
        // ];
        return $this->sendResponse(
            $res,
            "Fetch All SnalLists."
        );

    }

    public function getSnagListDetail(Request $request , $punch_list_id){
        $punch_list = $this->punchListService->find($punch_list_id);
        return $this->sendResponse(new punchListResource($punch_list), "Punch List retrieved successfully.");        
    }

    public function statusPeriorityOptions($id){
        $statusEnums = \App\Enums\PunchListStatusEnum::cases();
        $perioritiesEnums = \App\Enums\PunchListPriorityEnum::cases();   
        $status = [];
        foreach ($statusEnums as $enum){
            $status[(string) $enum->value] = $enum->text();
        }
        $periorities = [];
        foreach ($perioritiesEnums as $enum){
            $periorities[$enum->value] = $enum->text();
        }

        $linked_documents = [];
        $files = $this->projectDocumentFilesService->getNewestFilesByProjectId( $id);
       // return $files;
        if($files->count() > 0){
            foreach($files as $file){
                if($file->revisionid == NULL || $file->revisionid == 0){
                    $url = asset(Storage::url('project'.$id.'/documents'.$file->project_document_id.'/'.$file->file));
                }else{
                    $url = asset(Storage::url('project'.$id.'/documents'.$file->project_document_id.'/revisions/'.$file->file));
                }
                $linked_documents[] = [
                    'id' => $file->file_id.'-'.$file->revisionid,
                    'file' => $file->projectDocument->number,
                    'url'=>$url
                ];
            }

        }
        $res = ['status' => (object) $status , 'periorities' => $periorities , 'linked_documents' => $linked_documents];
        return $this->sendResponse(
            $res,
            "Fetch All options."
        );


    }

    public function storeReply(ReplyRequest $request){
        $punch_list = $this->punchListService->find($request->punch_list_id);
        if(checkIfUserHasThisPermission($request->project_id ,'responsible_punch_list') ||
            checkIfUserHasThisPermission($request->project_id ,'distribution_members_punch_list') ||
            $punch_list->created_by == auth()->user()->id
            ){

               // dd($punch_list->created_by);
                if(($punch_list->created_by != auth()->user()->id) && ($request->status == 0 || $request->status == 2)){
                    return $this->sendError("this status of admin or creator only .", [], 401);
                }
                $data = $request->all();
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
                
                if($request->status == 2){
                    \App\Models\PunchList::where('id',$request->punch_list_id)->update(['status'=>$request->status,'date_resolved_at'=>Carbon::now()->format('Y-m-d')]);
        
                }else{
                    \App\Models\PunchList::where('id',$request->punch_list_id)->update(['status'=>$request->status]);
        
                }   
                //dd($err);
                $model = \App\Models\PunchlistReplies::create($data);
                $reply = \App\Models\PunchlistReplies::with(['punchList','user'])->find($model->id);
                return $this->sendResponse([new ReplyResource($reply)], "You are successfully Add Reply.");

            }
        return $this->sendResponse(['status' => false], "You are not allowed to add reply.");

    }

    public function updateStatus(StatusRequest $request){

        $punch_list = $this->punchListService->find($request->punch_list_id);
        
        if(checkIfUserHasThisPermission($punch_list->project_id ,'responsible_punch_list') ||
            checkIfUserHasThisPermission($punch_list->project_id ,'distribution_members_punch_list') ||
            $punch_list->created_by == auth()->user()->id
            ){

            if($request->status == 2){
                \App\Models\PunchList::where('id',$request->punch_list_id)->update(['status'=>$request->status,'date_resolved_at'=>Carbon::now()->format('Y-m-d')]);

            }else{
                \App\Models\PunchList::where('id',$request->punch_list_id)->update(['status'=>$request->status]);

            }
            $punch_list = $this->punchListService->find($request->punch_list_id);
            return $this->sendResponse(new punchListResource($punch_list), "Punch List retrieved successfully."); 
        }
        return $this->sendResponse(['status' => false], "You are not allowed to update.");
    }



    public function getParticipates($project_id){
            
            $next_number =  $this->punchListService->getNextNumber($project_id);

            $distribution_members = $this->userService->getUsersOfProjectID($project_id , 'distribution_members_punch_list');
            $responsible = $this->userService->getUsersOfProjectID($project_id , 'responsible_punch_list');
			
            $distribution_members = $distribution_members['users'];
            $responsible = $responsible['users'];

            $res =  ['distribution_members'=>$distribution_members, 'responsible'=>$responsible  , 'next_number'=>$next_number];
            return $this->sendResponse($res, "Data retrieved successfully."); 
        

    }


    public function store(PunchListRequest  $request)
    {

        if($request->validated()){
            \DB::beginTransaction();
            try{
                $all_data = request()->all();
                $all_data['created_by'] = \Auth::user()->id;
                $all_data['closed_by'] = \Auth::user()->id;

                $all_data['status'] = 0;
                $all_data['date_notified_at'] = date('Y-m-d');
               // dd($all_data);
                $model = $this->punchListService->create($all_data);
            \DB::commit();
            // all good
            } catch (\Exception $e) {
                \DB::rollback();
                return $this->sendError( $e->getMessage());
            }

                       
            $punch_list = $this->punchListService->find($model->id);
            return $this->sendResponse(new punchListResource($punch_list), "Punch List created successfully."); 

        }
    }


    public function destroy($id){

        $punch_list = $this->punchListService->find($id);
        if(isset($punch_list->id) && $punch_list->created_by == auth()->user()->id){
            try{
                $this->punchListService->delete($id);
                return $this->sendResponse(['status' => true], "deleted successfully.");
            } catch (\Exception $e) {
                \DB::rollback();
                return $this->sendError( $e->getMessage());
            }
        }
        return $this->sendResponse(['status' => false], "You are not allowed to add reply.");
        
    }
 

    public function getDrawings(Request $request , $id){
        $drawings = $this->projectDrawingsService->search_drawings($id , $request);
        $res = $this->getList($drawings, $request, 'Drawing');

        return $this->sendResponse(
            $res,
            "Fetch All Drawings."
        );

    }


    public function getSnagsDrawing(Request $request , $project_id, $id){
        $punchLists = $this->punchListService->getAllProjectPunchListByDrawingId($project_id , $id);
        $res = $this->getList($punchLists, $request, 'punchList');
        // $result['data'] = $res->items();
        // $result['pagination'] =  [
        //         'current_page' => $res->currentPage(),
        //         'total_pages' => $res->lastPage(),
        //         'per_page' => $res->perPage(),
        //         'total' => $res->total()
        // ];
        return $this->sendResponse(
            $res,
            "Fetch All SnalLists."
        );
    }
  
}
