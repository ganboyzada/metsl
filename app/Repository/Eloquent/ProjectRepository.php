<?php

namespace App\Repository\Eloquent;

use App\Mail\StakholderEmail;
use App\Models\Permission;
use App\Models\Project;
use App\Models\Role;
use App\Models\User;
use App\Repository\ProjectRepositoryInterface;
use Illuminate\Support\Collection;

class ProjectRepository extends BaseRepository implements ProjectRepositoryInterface
{

   /**
    * UserRepository constructor.
    *
    * @param Project $model
    */
   public function __construct(Project $model)
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

   /**
    * @return Collection
    */
    public function projects_of_user() :Collection{
        return $this->model->with(['user'])->whereHas('stakholders', function ($query) {
            $query->where(function ($q) {
                $q->where('user_id', auth()->user()->id);
            });
        })->get();

    }
 
 
}