<?php

namespace App\Repository\Eloquent;

use App\Model\User;
use App\Models\ProjectManager;
use App\Repository\ProjectManagerRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class ProjectManagerRepository extends BaseRepository implements ProjectManagerRepositoryInterface
{

   /**
    * UserRepository constructor.
    *
    * @param ProjectManager $model
    */
   public function __construct(ProjectManager $model)
   {
       parent::__construct($model);
   }

    /**
    *  @param integer $id 
    * @return ProjectManager
    */
    public function projects_of_project_manger($id) :Model
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