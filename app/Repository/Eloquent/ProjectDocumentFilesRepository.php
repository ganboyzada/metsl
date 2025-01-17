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
    * @param integer $id
    * @return bool
    */
    public function change_status($id , $status) :bool
    {
        return $this->model->where('id',$id)->update(['status'=>$status]);
    }

       /**
    * @param integer $project_id
    * @return Collection
    */
    public function project_document_files($project_id): Collection
    {
        return $this->model->whereRelation('project', 'projects.id', '=', $project_id)->get(['project_document_id', 'file' , 'id']);
    }

}