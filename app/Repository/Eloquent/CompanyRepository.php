<?php

namespace App\Repository\Eloquent;

use App\Model\User;
use App\Models\Company;
use App\Repository\ClientRepositoryInterface;
use App\Repository\CompanyRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

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