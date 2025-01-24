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
                      //  dd($row->permissions);
                        $role = Role::create(['name' =>  $row->role, 'guard_name'=> 'sanctum']); 
                        $role->syncPermissions($row->permissions);  
                    }
                    $user = $this->find($row->id); 
                    $user->roles()->wherePivot('project_id',$project_id)->detach();
                    $user->roles()->attach($role->id, ['project_id'=>$project_id , 'job_title'=>$row->job_title ?? NULL]);
                    $user->permissions()->wherePivot('project_id',$project_id)->detach();
                    $user->permissions()->attach($role->permissions, ['project_id'=>$project_id]);
                    
                }

                
            }
            
            //$project_name = 'asd2';
            //$m = \Mail::to('marina3mad100@gmail.com')->send(new StakholderEmail($project_name));               
            $project =  Project::find($project_id);
            $project->stakholders()->sync($users);

           // dd('ok');
        }
        //throw new \Exception('eror');
    } 
    
    /**
     * @param int $project_id
    * @param int $permission_id
    * @return Collection
    */    
    public function get_users_of_project($project_id , $permission_id): Collection
    {
        if($permission_id != ''){
            return $this->model->whereHas('projects', function ($query) use ($project_id) {
                $query->where(function ($q) use ($project_id) {
                    $q->where('projects.id',$project_id);
                });
            })
            ->with(['allPermissions'=>function($query)use($project_id , $permission_id){
                $query->wherePivot('project_id',$project_id);
                $query->wherePivot('permission_id',$permission_id);
                }])
                
                ->with(['allRoles'=>function($query)use($project_id , $permission_id){
                    $query->wherePivot('project_id',$project_id);

                }])

                ->get(['id', 'name']);
        }else{
            return $this->model->whereHas('projects', function ($query) use ($project_id) {
                $query->where(function ($q) use ($project_id) {
                    $q->where('projects.id',$project_id);
                });
            })->with('allPermissions')->with('allRoles')->get(['id', 'name']);
        }

    }

   /**
    * @param int $project_id
    * @param \Request $request
    * @return Collection
    */ 
    public function get_stakeholders_of_project($project_id , $request):Collection    
    {   
        $data = $request->all();
       return $this->model->whereHas('projects', function ($query) use ($project_id) {
            $query->where('projects.id',$project_id);
            
       })
       
       //->whereRelation('projects', 'projects.id', '=', $project_id)
        ->with('userable')
        ->when($request->search , function($query) use($request){
            $query->where(function($q) use($request){
                $q->where('name', 'LIKE', "%".$request->search."%");
                $q->orwhere('email', 'LIKE', "%".$request->search."%");
                $q->orWhereHas('userable',function($q)use($request){
                    $q->where('first_name', 'LIKE', "%".$request->search."%");
                    $q->orwhere('last_name', 'LIKE', "%".$request->search."%");
                    $q->orwhere('mobile_phone', 'LIKE', "%".$request->search."%");
                    $q->orwhere('office_phone', 'LIKE', "%".$request->search."%");
                    $q->orwhere('specialty', 'LIKE', "%".$request->search."%");
    
                });
            });

    
        })
        ->get();
        
    }
  
}