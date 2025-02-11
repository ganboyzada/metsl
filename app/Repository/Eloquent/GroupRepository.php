<?php

namespace App\Repository\Eloquent;

use App\Models\Group;
use App\Repository\GroupRepositoryInterface;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Session;

class GroupRepository extends BaseRepository implements GroupRepositoryInterface
{

   /**
    * UserRepository constructor.
    *
    * @param Group $model
    */
   public function __construct(Group $model)
   {
       parent::__construct($model);
   }



   /**
    * @param integer $id
    * @return Collection
    */
    public function all_groups($project_id) :Collection
    {
        if(checkIfUserHasThisPermission(Session::get('projectID') , 'create_task_planner')){
            return $this->model->where('project_id',$project_id)->get(['id', 'name','color']);
        }
        
    }
 
 
}