<?php

namespace App\Repository\Eloquent;

use App\Model\User;
use App\Repository\ProjectRepositoryInterface;
use Illuminate\Support\Collection;
use App\Models\Contractor;
use App\Repository\ContractorRepositoryInterface;
use \Illuminate\Database\Eloquent\Model;

class ContractorRepository extends BaseRepository implements ContractorRepositoryInterface
{

   /**
    * UserRepository constructor.
    *
    * @param Contractor $model
    */
   public function __construct(Contractor $model)
   {
       parent::__construct($model);
   }

    /**
    * @param integer $id
    * @return Contractor
    */
    public function projects_of_contractor($id): Model
    {
        return $this->model->where('id',$id)->with($this->with)->first();
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