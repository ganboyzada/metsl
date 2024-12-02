<?php

namespace App\Repository\Eloquent;

use App\Model\User;
use App\Models\DesignTeam;
use App\Repository\DesignTeamRepositoryInterface;
use App\Repository\Eloquent\BaseRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class DesignTeamRepository extends BaseRepository implements DesignTeamRepositoryInterface
{

   /**
    * UserRepository constructor.
    *
    * @param DesignTeam $model
    */
   public function __construct(DesignTeam $model)
   {
       parent::__construct($model);
   }

    /**
    * @param integer $id 
    * @return DesignTeam
    */
    public function projects_of_design_team($id) :Model
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