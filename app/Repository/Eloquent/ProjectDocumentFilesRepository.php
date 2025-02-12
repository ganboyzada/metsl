<?php

namespace App\Repository\Eloquent;

use App\Model\User;
use App\Models\ProjectDocumentFiles;
use App\Repository\CorrespondenceFileRepositoryInterface;
use App\Repository\ProjectDocumentFilesRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class ProjectDocumentFilesRepository extends BaseRepository implements ProjectDocumentFilesRepositoryInterface
{

   /**
    * UserRepository constructor.
    *
    * @param ProjectDocumentFiles $model
    */
   public function __construct(ProjectDocumentFiles $model)
   {
       parent::__construct($model);
   }
    /**
    * @param array $data
    * @return bool
    */

    public function create_bulk_files($data): bool
    {
        try{
            return $this->model->insert($data);
        }catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }  
    }
 

       /**
    * @param integer $project_id
    * @return Collection
    */
    public function project_document_files($project_id): Collection
    {
        return $this->model->whereRelation('project', 'projects.id', '=', $project_id)->with('ProjectDocument')->get(['project_document_id', 'file' , 'id']);
    }

    /**
    * @param integer $project_id
    * @return Collection
    */
    public function get_newest_files_by_project_document_id($project_id): Collection
    {
        $sub2 = \DB::raw('(select MAX(project_document_revisions.id) as revision_id ,project_document_id ,project_document_file_id  , file , MAX(project_document_revisions.created_at) as last_upload_date from project_document_revisions
        join project_documents on project_documents.id = project_document_revisions.project_document_id
        where project_documents.project_id = '.$project_id.' 
        group by project_document_id)last_upload_table');


        return $this->model->leftjoin($sub2,function($join){
            $join->on('last_upload_table.project_document_id','=','project_document_files.project_document_id');
            $join->on('last_upload_table.project_document_file_id','=','project_document_files.id');       
        })
        ->whereRelation('project', 'projects.id', '=', $project_id)
        ->with(['ProjectDocument:id,title,number'])
        ->get(['last_upload_date','project_document_files.project_document_id','project_document_files.id as file_id', 'project_document_files.file'
        
        , 'last_upload_table.revision_id as revisionid' , 'last_upload_table.file as revision_file' ]);

        
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