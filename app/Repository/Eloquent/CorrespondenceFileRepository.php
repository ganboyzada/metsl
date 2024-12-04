<?php

namespace App\Repository\Eloquent;

use App\Model\User;
use App\Models\CorrespondenceFile;
use App\Repository\CorrespondenceFileRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class CorrespondenceFileRepository extends BaseRepository implements CorrespondenceFileRepositoryInterface
{

   /**
    * UserRepository constructor.
    *
    * @param CorrespondenceFile $model
    */
   public function __construct(CorrespondenceFile $model)
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