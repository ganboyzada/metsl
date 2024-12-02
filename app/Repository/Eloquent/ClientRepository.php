<?php

namespace App\Repository\Eloquent;

use App\Model\User;
use App\Models\Client;
use App\Repository\ClientRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class ClientRepository extends BaseRepository implements ClientRepositoryInterface
{

   /**
    * UserRepository constructor.
    *
    * @param Client $model
    */
   public function __construct(Client $model)
   {
       parent::__construct($model);
   }

    /**
    * @param integer $id  
    * @return Client
    */
    public function projects_of_client($id) :Model
    {
        return $this->model->where('id',$id)->with(['projects:id,name'])->select()->first();
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