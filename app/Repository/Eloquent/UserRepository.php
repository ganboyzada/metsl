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
        
        $project =  Project::find($project_id);
        $users_ids = $project->stakholders()->pluck('users.id')->toArray();
        //$project->stakholders()->detach();
       // dd($all_stakholders);
        $users = [];
        if(count($all_stakholders) > 0){
            foreach($all_stakholders as $row){
                $users[] = $row->id;
                if($row->role != '' && count($row->permissions) > 0){
                    $role = Role::where(['name' =>  $row->role])->first(); 
                    if (!isset($role->id)) {
                      //  dd($row->permissions);
                        $role = Role::create(['name' =>  $row->role, 'guard_name'=> 'sanctum']); 
                         
                    }
                    $role->syncPermissions($row->permissions); 
                    $user = $this->find($row->id); 
                    $user->roles()->wherePivot('project_id',$project_id)->detach();
                    $user->roles()->attach($role->id, ['project_id'=>$project_id , 'job_title'=>$row->job_title ?? NULL]);
                    $user->permissions()->wherePivot('project_id',$project_id)->detach();
                    //dd($role->permissions);
                    $user->permissions()->attach($role->permissions, ['project_id'=>$project_id]);
                    //if(count($users_ids) > 0){
                        if(!in_array($row->id , $users_ids)){
                            $project->stakholders()->attach($row->id, ['company_id'=>($row->company != '' ? $row->company : NULL) , 'office_phone'=>$row->office_phone ?? NULL , 
                            'specialty'=>$row->specialty ?? NULL , 'type'=>$row->type ?? NULL  ]);

                        }
                   // }
                            
                    
                }
                

                
            }
            
            //$project_name = 'asd2';
            //$m = \Mail::to('marina3mad100@gmail.com')->send(new StakholderEmail($project_name));               

            

            //$project->stakholders()->sync($users);

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
                ->with(['company:id,name'])
                ->select(['id', 'name','company_id' ])->get();
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
    * @param int $permission_id
    * @return Model
    */    
    public function check_if_user_of_project_has_this_permission($project_id , $permission_id): Model
    {
        $auth_user_id = \Auth::user()->id;
            return $this->model->where('users.id',$auth_user_id)->whereHas('projects', function ($query) use ($project_id) {
                $query->where(function ($q) use ($project_id) {
                    $q->where('projects.id',$project_id);
                });
            })
            ->with(['allPermissions'=>function($query)use($project_id , $permission_id){
                $query->wherePivot('project_id',$project_id);
                $query->wherePivot('permission_id',$permission_id);
                }])
                ->select('users.id')
                ->first();
       

    }

   /**
    * @param int $project_id
    * @param \Request $request
    * @return Collection
    */ 
    public function get_stakeholders_of_project($project_id , $request):Collection    
    {   
        $data = $request->all();
       return $this->model->join('projects_users', 'users.id', '=', 'projects_users.user_id')
       ->leftjoin('companies', 'companies.id', '=', 'projects_users.company_id')
       ->where('projects_users.project_id', $project_id)
       ->select('users.*', 'companies.name as company_name','projects_users.id as project_user_id')
       
    //    ->whereHas('projects', function ($query) use ($project_id) {
    //         $query->where('projects.id',$project_id);
            
    //    })
       ->with(['projects'=>function($query)use($project_id){
        $query->wherePivot('project_id',$project_id);
        }])
       
       //->whereRelation('projects', 'projects.id', '=', $project_id)
       // ->with('userable' , 'company')
        ->with(['allRoles'=>function($query)use($project_id){
                    $query->wherePivot('project_id',$project_id);

                }])
        ->when($request->search , function($query) use($request){
            $query->where(function($q) use($request){
                $q->where('name', 'LIKE', "%".$request->search."%");
                $q->orwhere('email', 'LIKE', "%".$request->search."%");
                // $q->orWhereHas('userable',function($q)use($request){
                //     $q->where('first_name', 'LIKE', "%".$request->search."%");
                //     $q->orwhere('last_name', 'LIKE', "%".$request->search."%");
                //     $q->orwhere('mobile_phone', 'LIKE', "%".$request->search."%");
                //     $q->orwhere('office_phone', 'LIKE', "%".$request->search."%");
                //     $q->orwhere('specialty', 'LIKE', "%".$request->search."%");
    
                // });
            });

    
        })
        ->get();
        
    }

/**
    * @param \Request $request
    * @return Collection
    */ 
    public function search($request): Collection{
        return $this->model->where(function($q) use($request){
            $q->where('name', 'LIKE', "%".$request->search."%");
            $q->orwhere('email', 'LIKE', "%".$request->search."%"); 
        })->get(['id', 'name', 'mobile_phone','email','profile_photo_path']);
    }
  
}