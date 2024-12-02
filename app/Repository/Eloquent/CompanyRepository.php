<?php

namespace App\Repository\Eloquent;

use App\Model\User;
use App\Repository\CompanyRepositoryInterface;
use Illuminate\Support\Collection;
use App\Models\Company;

class CompanyRepository extends BaseRepository implements CompanyRepositoryInterface
{

   /**
    * UserRepository constructor.
    *
    * @param Company $model
    */
   public function __construct(Company $model)
   {
       parent::__construct($model);
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