<?php

namespace App\Repository\Eloquent;

use App\Model\User;
use App\Models\ProjectDocumentFiles;
use App\Models\ProjectDocumentRevisions;
use App\Repository\CorrespondenceFileRepositoryInterface;
use App\Repository\ProjectDocumentRevisionsRepositoryInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class ProjectDocumentRevisionsRepository extends BaseRepository implements ProjectDocumentRevisionsRepositoryInterface
{

   /**
    * UserRepository constructor.
    *
    * @param ProjectDocumentRevisions $model
    * @param ProjectDocumentFiles $model2
    */
   public function __construct(ProjectDocumentRevisions $model , ProjectDocumentFiles $model2)
   {
       parent::__construct($model , $model2);
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
       if($data['file_type'] == 'revision'){
        unset($data['_token'],$data['file_type'],$data['project_id'],$data['number']);
        return $this->model->comments()->insert($data);

       }else{
        unset($data['_token'],$data['file_type'],$data['project_id'],$data['number']);
        return $this->model2->comments()->insert($data);

       }
       
    }

    /**
    * @param int $id
    * @param string $type
    * @return Model
    */
    public function get_revision_comments($id,$type): Model{
        if($type == 'revision'){
   
             return $this->model->with([
                'comments' => function ($query): void {
                    $query->select('revision_id', 'user_id', 'comment', 'image', 'project_document_id', 'type', 'id')
                        ->orderBy('id', 'desc');
                },
                'comments.user:id,name'
            ])->find($id);

        }else{
            //return $this->model2->with(['comments:file_id,user_id,comment,image,project_document_id,type', 'comments.user:id,name'])->find($id);

            return $this->model2->with([
            'comments' => function ($query) {
                $query->select('id', 'file_id', 'user_id', 'comment', 'image', 'project_document_id', 'type', 'id')
                    ->orderBy('id', 'desc');
            },
            'comments.user:id,name'
        ])->find($id);

        }
        
         
    }

}