<?php

namespace App\Repository\Eloquent;

use App\Model\User;
use App\Models\ProjectDocumentRevisions;
use App\Repository\CorrespondenceFileRepositoryInterface;
use App\Repository\ProjectDocumentRevisionsRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Builder;

class ProjectDocumentRevisionsRepository extends BaseRepository implements ProjectDocumentRevisionsRepositoryInterface
{

   /**
    * UserRepository constructor.
    *
    * @param ProjectDocumentRevisions $model
    */
   public function __construct(ProjectDocumentRevisions $model)
   {
       parent::__construct($model);
   }
    /**
    * @param int $document_id
    * @return Collection
    */

    public function get_revisions_of_document($document_id): Collection
    {
        return $this->model->where('project_document_id',$document_id)->with(['user:id,name','project:projects.id','document:id'])->get();
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


    /**
    * @param array $data
    * @return bool
    */

    public function create_comment($data): bool
    {
       // dd($data);
       unset($data['_token']);
        return $this->model->comments()->insert($data);
    }

    /**
    * @param int $id
    * @return Model
    */
    public function get_revision_comments($id): Model{
         return $this->model->with(['comments:revision_id,user_id,comment', 'comments.user:id,name'])->find($id);
         
    }

}