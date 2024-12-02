<?php

namespace App\Repository\Eloquent;

use App\Model\User;
use App\Models\ProjectFile;
use App\Repository\ProjectFileRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class ProjectFileRepository extends BaseRepository implements ProjectFileRepositoryInterface
{

   /**
    * UserRepository constructor.
    *
    * @param ProjectFile $model
    */
   public function __construct(ProjectFile $model)
   {
       parent::__construct($model);
   }
    /**
    * @param array $data
    * @return bool
    */

    public function create_bulk_files($data): bool
    {
        return $this->model->insert($data);
    }
   /**
    * @param integer $id
    * @return bool
    */
    public function change_status($id , $status) :bool
    {
        return $this->model->where('id',$id)->update(['status'=>$status]);
    }

}