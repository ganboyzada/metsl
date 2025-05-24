<?php

namespace App\Http\Controllers\Api\V1;

use App\Enums\PunchListStatusEnum;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProjectResource;
use App\Http\Resources\UserProfileResource;
use App\Models\Correspondence;
use App\Models\ProjectDocument;
use App\Models\PunchList;
use App\Services\ProjectService;
use Carbon\Carbon;
use DateTime;
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


    public function getStaticsesDocuments($projectId){
        $data = [];

        $project_document_count = ProjectDocument::join('project_document_files','project_document_files.project_document_id','=','project_documents.id')
        ->where('project_documents.status',1)
        ->where('project_document_files.status',0)
        ->where('project_documents.project_id',$projectId);
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
        ->where('project_documents.status',1)
        ->where('project_document_revisions.status',0)
        ->where('project_documents.project_id',$projectId);
        
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

        
        $data['submittals']['pending'] = $project_document_count + $project_document_revision_count;    
        
        
        $project_document_count = ProjectDocument::join('project_document_files','project_document_files.project_document_id','=','project_documents.id')
        ->where('project_documents.status',1)
        ->where('project_document_files.status',1)
        ->where('project_documents.project_id',$projectId);
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
        ->where('project_documents.status',1)
        ->where('project_document_revisions.status',1)
        ->where('project_documents.project_id',$projectId);
        
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

        
        $data['submittals']['accepted'] = $project_document_count + $project_document_revision_count;  


        $project_document_count = ProjectDocument::join('project_document_files','project_document_files.project_document_id','=','project_documents.id')
        ->where('project_documents.status',1)
        ->where('project_document_files.status',2)
        ->where('project_documents.project_id',$projectId);
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
        ->where('project_documents.status',1)
        ->where('project_document_revisions.status',2)
        ->where('project_documents.project_id',$projectId);
        
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

        
        $data['submittals']['rejected'] = $project_document_count + $project_document_revision_count;
        
        return $data;
    
    }


    public function getStaticsesCorrespondences($projectId){
        $correspondence_count = Correspondence::where('status','!=','CLOSED')->where('project_id',$projectId)
        ->where('status','Open' );
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
        

        $data['correspondence']['open'] = $correspondence_count;


        $correspondence_count = Correspondence::where('status','!=','CLOSED')->where('project_id',$projectId)
        ->where('status','Closed' );
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
        

        $data['correspondence']['closed'] = $correspondence_count;


        $correspondence_count = Correspondence::where('status','!=','CLOSED')->where('project_id',$projectId)
        ->where('status','!=','Closed' )->where('status','!=','Open' );
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
        

        $data['correspondence']['issued_and_draft'] = $correspondence_count;
        return $data;



    }

    public function getStaticsesPuchList($projectId){
        $punlist_count = PunchList::where('project_id',$projectId)
        ->where('status', PunchListStatusEnum::PENDING->value);

        if(checkIfUserHasThisPermission($projectId , 'view_all_punch_list')){

            $punlist_count =  $punlist_count->count();
  
        }        
        else 
        if(!auth()->user()->is_admin){

            $punlist_count = $punlist_count->where(function($q){
                $q->whereHas('users', function ($query) {
                    $query->where('user_id', auth()->user()->id);
                });

                $q->orwhere('responsible_id',auth()->user()->id);
                $q->orwhere('created_by',auth()->user()->id);

                
            });

            $punlist_count =  $punlist_count->count();

  
        
        }

        
        $data['snag_list']['pending'] = $punlist_count;


        $punlist_count = PunchList::where('project_id',$projectId)
        ->where('status', PunchListStatusEnum::REVIEW->value);


        if(checkIfUserHasThisPermission($projectId , 'view_all_punch_list')){


            $punlist_count =  $punlist_count->get();

        }        
        else
         if(!auth()->user()->is_admin){

            $punlist_count = $punlist_count->where(function($q){
                $q->whereHas('users', function ($query) {
                    $query->where('user_id', auth()->user()->id);
                });

                $q->orwhere('responsible_id',auth()->user()->id);
                $q->orwhere('created_by',auth()->user()->id);

                
            });
            $punlist_count =  $punlist_count->get();
        }

        $punlist_count =  $punlist_count->count();
        $data['snag_list']['review'] = $punlist_count;

        $punlist_count = PunchList::where('project_id',$projectId)
        ->where('status', PunchListStatusEnum::CLOSED->value);

        if(checkIfUserHasThisPermission($projectId , 'view_all_punch_list')){

            $punlist_count =  $punlist_count->get();
  
        }        
        else
         if(!auth()->user()->is_admin){

            $punlist_count = $punlist_count->where(function($q){
                $q->whereHas('users', function ($query) {
                    $query->where('user_id', auth()->user()->id);
                });

                $q->orwhere('responsible_id',auth()->user()->id);
                $q->orwhere('created_by',auth()->user()->id);

                
            });

            $punlist_count =  $punlist_count->get(); 
              

        }


        $punlist_count =  $punlist_count->count();
        $data['snag_list']['closed'] = $punlist_count;
        return $data;

       

    }
    public function getStaticses($projectId){
        //$documents = $this->getStaticsesDocuments($projectId);
        $puchLists = $this->getStaticsesPuchList($projectId);
        //$correspondences = $this->getStaticsesCorrespondences($projectId);
        //$data = [...$documents , ...$puchLists , ...$correspondences];

        return $this->sendResponse(
            $puchLists,
            "Fetch All Statics."
        );


    }
  


  
}
