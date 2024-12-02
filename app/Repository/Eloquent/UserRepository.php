<?php

namespace App\Repository\Eloquent;

use App\Models\ModelHasRoles;
use App\Models\Project;
use App\Models\User;
use App\Repository\UserRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use App\Models\Permission;
use App\Models\Role;


class UserRepository extends BaseRepository implements UserRepositoryInterface
{

   /**
    * UserRepository constructor.
    *
    * @param User $model
    */
   public function __construct(User $model)
   {
       parent::__construct($model);
   }

    /**
     * @param int $project_id
    * @param array $all_stakholders
    */
    public function create_role_permisions_set_of_user($project_id , $all_stakholders) :void
    {
        $users = [];
        if(count($all_stakholders) > 0){
            foreach($all_stakholders as $row){
                $users[] = $row->id;
                if($row->role != '' && count($row->permissions) > 0){
                    $role = Role::where(['name' =>  $row->role])->first(); 
                    if (!isset($role->id)) {
                        $role = Role::create(['name' =>  $row->role]);                    
                        $role->syncPermissions($row->permissions);  
                    }
                    $user = User::find($row->id);       

                    $user->roles()->attach($role->id, ['project_id'=>$project_id]);
                    
                    $user->permissions()->attach($role->permissions, ['project_id'=>$project_id]);
                    
                }

                
            }
            //$project_name = 'asd2';
            //$m = \Mail::to('marina3mad100@gmail.com')->send(new StakholderEmail($project_name));               
            $project =  $this->find($project_id);
            $project->stakholders()->sync($users);
        }
        //throw new \Exception('eror');
    }  


  
}