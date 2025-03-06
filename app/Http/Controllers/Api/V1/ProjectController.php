<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProjectResource;
use App\Http\Resources\UserProfileResource;
use App\Models\Correspondence;
use App\Models\ProjectDocument;
use App\Models\PunchList;
use App\Services\ProjectService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function __construct(
        protected ProjectService $projectService

        )
    {
    }
    /**
     * Display a listing of the resource.
     */
    public function myProjects(Request $request)
    {
       $projects = $this->projectService->all();
      // return $projects;
       //return ProjectResource::collection($projects);
       $res = $this->getList($projects, $request, 'Project');
        return $this->sendResponse(
            $res,
            "Fetch All Projects."
        );
       // return $users;
    }


    /**
     * Display the specified resource.
     */
    public function projectDetail(string $id)
    {
        $project =  $this->projectService->find_api($id);
        return $this->sendResponse(new ProjectResource($project), "project retrieved successfully."); 
    }


    public function getStaticses($projectId){
        $date = Carbon::now(); // Get current date
        $newDate = $date->addWeek(); // Add one week

        $project_document_count = ProjectDocument::join('project_document_files','project_document_files.project_document_id','=','project_documents.id')
        ->where('project_documents.status',1)->where('project_document_files.status',1)->where('project_documents.project_id',$projectId)
        ->whereBetween('project_document_files.created_at', [$date, $newDate]);
        if(checkIfUserHasThisPermission($projectId , 'view_all_documents')){
           $project_document_count =  $project_document_count->count();
        }else if(!auth()->user()->is_admin){
            //dd(auth()->user()->packages()->pluck('packages.id')->toArray());
            $project_document_count = $project_document_count->where(function($q){
                $q->whereHas('reviewers', function ($query) {
                    $query->where('user_id', auth()->user()->id);
                });

                $q->orwhere('created_by', auth()->user()->id);
                $q->orWhere(function($q){
                        $q->whereIn('package_id', auth()->user()->packages()->pluck('packages.id')->toArray());
                });

                
            });

            
            $project_document_count =  $project_document_count->count();

        }        

        $project_document_revision_count = ProjectDocument::join('project_document_revisions','project_document_revisions.project_document_id','=','project_documents.id')
        ->where('project_documents.status',1)->where('project_document_revisions.status',1)->where('project_documents.project_id',$projectId)
        ->whereBetween('project_document_revisions.created_at', [$date, $newDate]);
        
        if(checkIfUserHasThisPermission($projectId , 'view_all_documents')){
            $project_document_revision_count =  $project_document_revision_count->count();
        }else if(!auth()->user()->is_admin){
            //dd(auth()->user()->packages()->pluck('packages.id')->toArray());
            $project_document_revision_count = $project_document_revision_count->where(function($q){
                $q->whereHas('reviewers', function ($query) {
                    $query->where('user_id', auth()->user()->id);
                });

                $q->orwhere('created_by', auth()->user()->id);
                $q->orWhere(function($q){
                        $q->whereIn('package_id', auth()->user()->packages()->pluck('packages.id')->toArray());
                });

                
            });

            
           $project_document_revision_count =  $project_document_revision_count->count();

        } 

        $data = [];
        $data['submittals']['next_week'] = $project_document_count + $project_document_revision_count;



        $punlist_count = PunchList::where('status',2)->where('project_id',$projectId)
        ->whereBetween('date_resolved_at', [$date, $newDate]);


        if(checkIfUserHasThisPermission($projectId , 'view_all_punch_list')){

            $punlist_count =  $punlist_count->count();
  
        }        
        else if(!auth()->user()->is_admin){

            $punlist_count = $punlist_count->where(function($q){
                $q->whereHas('users', function ($query) {
                    $query->where('user_id', auth()->user()->id);
                });

                $q->orwhere('responsible_id',auth()->user()->id);
                $q->orwhere('created_by',auth()->user()->id);

                
            });

             $punlist_count =  $punlist_count->count();
  
              

        }


        $data['snag_list']['next_week'] = $punlist_count;

        $correspondence_count = Correspondence::where('status','!=','CLOSED')->where('project_id',$projectId)
        ->whereBetween('created_at', [$date, $newDate]);
        if(!auth()->user()->is_admin){

            $correspondence_count = $correspondence_count->where(function($q)use($projectId){
                $q->whereHas('assignees', function ($query) {
                    $query->where('user_id', auth()->user()->id);
                });

                $q->orWhereHas('distributionMembers', function ($query) {
                    $query->where('user_id', auth()->user()->id);
                });
                
                $q->orwhere('created_by', auth()->user()->id);


                $enums_list = \App\Enums\CorrespondenceTypeEnum::cases();
                foreach ($enums_list as $enum) {
                    if(checkIfUserHasThisPermission($projectId , 'view_'.$enum->value)){
                        $correspondence_count = $correspondence_count->orwhere('type' , $enum->value);
    
                    }
                }




            });
            



            $correspondence_count = $correspondence_count->count();


        }else{
            $correspondence_count = $correspondence_count->count();

        }
        

        $data['correspondence']['next_week'] = $correspondence_count;


        $yesterday = Carbon::yesterday();
        $oneWeekBeforeYesterday = $yesterday->subWeek();


        $project_document_count = ProjectDocument::join('project_document_files','project_document_files.project_document_id','=','project_documents.id')
        ->where('project_documents.status',1)->where('project_document_files.status',1)->where('project_documents.project_id',$projectId)
        ->whereBetween('project_document_files.created_at', [$oneWeekBeforeYesterday,$yesterday]);
        if(checkIfUserHasThisPermission($projectId , 'view_all_documents')){
           $project_document_count =  $project_document_count->count();
        }else if(!auth()->user()->is_admin){
            //dd(auth()->user()->packages()->pluck('packages.id')->toArray());
            $project_document_count = $project_document_count->where(function($q){
                $q->whereHas('reviewers', function ($query) {
                    $query->where('user_id', auth()->user()->id);
                });

                $q->orwhere('created_by', auth()->user()->id);
                $q->orWhere(function($q){
                        $q->whereIn('package_id', auth()->user()->packages()->pluck('packages.id')->toArray());
                });

                
            });

            
            $project_document_count =  $project_document_count->count();

        }        

        $project_document_revision_count = ProjectDocument::join('project_document_revisions','project_document_revisions.project_document_id','=','project_documents.id')
        ->where('project_documents.status',1)->where('project_document_revisions.status',1)->where('project_documents.project_id',$projectId)
        ->whereBetween('project_document_revisions.created_at', [$oneWeekBeforeYesterday,$yesterday]);
        
        if(checkIfUserHasThisPermission($projectId , 'view_all_documents')){
            $project_document_revision_count =  $project_document_revision_count->count();
        }else if(!auth()->user()->is_admin){
            //dd(auth()->user()->packages()->pluck('packages.id')->toArray());
            $project_document_revision_count = $project_document_revision_count->where(function($q){
                $q->whereHas('reviewers', function ($query) {
                    $query->where('user_id', auth()->user()->id);
                });

                $q->orwhere('created_by', auth()->user()->id);
                $q->orWhere(function($q){
                        $q->whereIn('package_id', auth()->user()->packages()->pluck('packages.id')->toArray());
                });

                
            });

            
           $project_document_revision_count =  $project_document_revision_count->count();

        } 

        $data['submittals']['prev_week'] = $project_document_count + $project_document_revision_count;



        $punlist_count = PunchList::where('status',2)->where('project_id',$projectId)
        ->whereBetween('date_resolved_at', [$oneWeekBeforeYesterday,$yesterday]);


        if(checkIfUserHasThisPermission($projectId , 'view_all_punch_list')){

            $punlist_count =  $punlist_count->count();
  
        }        
        else if(!auth()->user()->is_admin){

            $punlist_count = $punlist_count->where(function($q){
                $q->whereHas('users', function ($query) {
                    $query->where('user_id', auth()->user()->id);
                });

                $q->orwhere('responsible_id',auth()->user()->id);
                $q->orwhere('created_by',auth()->user()->id);

                
            });

             $punlist_count =  $punlist_count->count();
  
              

        }


        $data['snag_list']['prev_week'] = $punlist_count;

        $correspondence_count = Correspondence::where('status','!=','CLOSED')->where('project_id',$projectId)
        ->whereBetween('created_at', [$oneWeekBeforeYesterday,$yesterday]);
        if(!auth()->user()->is_admin){

            $correspondence_count = $correspondence_count->where(function($q)use($projectId){
                $q->whereHas('assignees', function ($query) {
                    $query->where('user_id', auth()->user()->id);
                });

                $q->orWhereHas('distributionMembers', function ($query) {
                    $query->where('user_id', auth()->user()->id);
                });
                
                $q->orwhere('created_by', auth()->user()->id);


                $enums_list = \App\Enums\CorrespondenceTypeEnum::cases();
                foreach ($enums_list as $enum) {
                    if(checkIfUserHasThisPermission($projectId , 'view_'.$enum->value)){
                        $correspondence_count = $correspondence_count->orwhere('type' , $enum->value);
    
                    }
                }




            });
            



            $correspondence_count = $correspondence_count->count();


        }else{
            $correspondence_count = $correspondence_count->count();

        }
        

        $data['correspondence']['prev_week'] = $correspondence_count;


        return $this->sendResponse(
            $data,
            "Fetch All Statics."
        );


    }
  


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try{
            $user =  $this->userService->find($id);
        }catch (\Exception $e) {
            return $this->sendError("User does not exist");
        }
        
        $user->userable->delete();
        $this->userService->delete($id);
  

        return $this->sendResponse([], "user deleted successfully.");



    }
}
