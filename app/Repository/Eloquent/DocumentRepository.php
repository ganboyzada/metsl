<?php

namespace App\Repository\Eloquent;

use App\Mail\StakholderEmail;
use App\Models\Permission;
use App\Models\ProjectDocument;
use App\Models\ProjectDocumentFiles;
use App\Models\ProjectDocumentRevisions;
use App\Models\Role;
use App\Models\User;
use App\Repository\DocumentRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class DocumentRepository extends BaseRepository implements DocumentRepositoryInterface
{

   /**
    * UserRepository constructor.
    *
    * @param ProjectDocument $model
    */
   public function __construct(ProjectDocument $model)
   {
       parent::__construct($model);
   }


    /**
    * @param array $data 
    * @param Model $document 
    * 
    */
    public function add_users_to_document($data , $document)
    {
        try{
            if(!$document){
                throw new \Exception('Record not find'); 
            }
            $d = $document->reviewers()->sync($data['reviewers']);
        }catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }    
    }


    /**
    * @param int $project_id 
    * @param \Request $request
    * @return Collection
    * 
    */
    public function get_all_project_documents($project_id , $request): Collection{

        $query =  $this->model->where('project_id',$project_id)->withCount('revisions');


        //dd($query->get());
       // ->addSelect(['last_upload_date' => ProjectDocumentRevisions::select('upload_date')
        //->whereColumn('project_document_revisions.project_document_id', 'project_documents.id')->orderBy('upload_date', 'desc')->take(1)])

      //  ->addSelect(['max_size' => ProjectDocumentFiles::select(\DB::raw('SUM(size) as max_size'))
       // ->whereColumn('project_document_files.project_document_id', 'project_documents.id')->take(1)])->withCount('revisions');
       // ->get();
       // $query =  $this->model->where('project_id',$project_id)
        //->addSelect(['last_upload_date' => ProjectDocumentRevisions::select('upload_date')->whereColumn('project_document_id ', 'project_documents.id')->latest()->take(1)])
       // ->with(['files' , 'revisions','LastRevisionDate']);
        if(isset($request->DocNO) && $request->DocNO != ''){
            $query->where('number' ,'LIKE', '%'.$request->DocNO.'%');
        }

        if(isset($request->package_id) && $request->package_id != 0){
            $query->where('package_id' , $request->package_id);
        }

       if(isset($request->orderBy) && ($request->orderBy == 'number' || $request->orderBy == 'created_date')){
            $query= $query->orderBy($request->orderBy , $request->orderDirection);       
        }
    
     
        else if(isset($request->orderBy) && $request->orderBy == 'upload_date'){
            $sub2 = \DB::raw('(select project_document_id , MAX(created_at) as last_upload_date from project_document_revisions group by project_document_id)last_upload_table');
            $query = $query->leftjoin($sub2,function($join){
                $join->on('last_upload_table.project_document_id','=','id');       
            });
            $query= $query->orderby('last_upload_date' , $request->orderDirection);

        }
    
       
        else if(isset($request->orderBy) && $request->orderBy == 'size'){
            $sub1 = \DB::raw('(select project_document_id , SUM(size) as max_size from project_document_files group by project_document_id)max_table');

            $query = $query->leftjoin($sub1,function($join){
                    $join->on('max_table.project_document_id','=','id');       
            });
            $query= $query->orderby('max_size' , $request->orderDirection);


        }



        if(checkIfUserHasThisPermission($project_id , 'view_all_documents')){
            return $query->get();
        }else if(!auth()->user()->is_admin){
            $query = $query->where(function($q){
                $q->whereHas('reviewers', function ($query) {
                    $query->where('user_id', auth()->user()->id);
                });

                $q->orwhere('created_by', auth()->user()->id);

                
            });
            return $query->get();

        }
          
        
   

    
    
    }

    
    /**
    * @param integer $id
    * @return bool
    */
    public function change_status($id , $status) :bool
    {
        //throw new \Exception('error');
        return $this->model->where('id',$id)->update(['status'=>$status]);
    }  
 
}