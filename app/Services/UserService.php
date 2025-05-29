<?php

namespace App\Services;

use App\Models\Permission;
use App\Repository\UserRepositoryInterface;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;


class UserService
{
    public function __construct(
        protected UserRepositoryInterface $userRepository
    ) {
    }

    public function create(array $data)
    {
        \DB::beginTransaction();
        try {
            
            
            $data['name'] = $data['first_name'].'_'.$data['last_name'];
            $data['password'] = Hash::make('password');
            $model =  $this->userRepository->create($data);

            //$this->userRepository->create_role_permisions_of_user($model->id , $data);
           
            \DB::commit();
        // all good
        } catch (\Exception $e) {
            \DB::rollback();
            throw new \Exception($e->getMessage());
        }
            
            

        return $model;
    }

    public function update(array $data)
    {
        \DB::beginTransaction();
        try {
            
            $data['name'] = $data['first_name'].'_'.$data['last_name'];
            $data['password'] = Hash::make('password');
            $id = $data['user_id'];
            $user = $this->userRepository->find($data['user_id']);

            $model =  $this->userRepository->update($data , $id);
          // dd($user);
            if($user->company_id != NULL && $user->company_id != $data['company_id']){
             //  dd($user);
                $company = \App\Models\Company::with('packages')->find($user->company_id);
                if($company->packages->count() > 0){
                    foreach($company->packages as $package){

                        // dd(\DB::table('punch_list_assignees')
                        // ->join('punch_lists', 'punch_lists.id', '=', 'punch_list_assignees.punch_list_id')
                        // ->where('punch_lists.work_package_id',$package->id)
                        // ->where('punch_lists.project_id',Session::get('projectID'))
						// ->where('user_id',$data['user_id'])->get());
                        \DB::table('punch_list_assignees')
                        ->join('punch_lists', 'punch_lists.id', '=', 'punch_list_assignees.punch_list_id')
                        ->where('punch_lists.work_package_id',$package->id)
                        ->where('punch_lists.project_id',Session::get('projectID'))
						->where('user_id',$data['user_id'])->delete();
                    }
                }
            }

            if($data['company_id'] != NULL){
                $company = \App\Models\Company::with('packages')->find($data['company_id']);
                $snags = \App\Models\PunchList::where('project_id',Session::get('projectID'))
                ->whereIn('work_package_id', $company->packages->pluck('id')->toArray())->get();
				$assignees_has_permission = collect($this->getUsersOfProjectID(Session::get('projectID') , 'responsible_punch_list')['users'])->pluck('id')->toArray();

                if($snags->count() > 0 && in_array($data['user_id'],$assignees_has_permission) ){
                    foreach($snags as $snag){
                        $chk = \DB::table('punch_list_assignees')->where(['punch_list_id'=>$snag->id , 'user_id'=>$data['user_id']])->first();
                        if(!isset($chk->id)){
                            \DB::table('punch_list_assignees')->insert(['punch_list_id'=>$snag->id , 'user_id'=>$data['user_id']]);

                        }
                        
                       // $snag->assignees()->sync($data['user_id']);
                    }
                }
            }

            //$this->userRepository->create_role_permisions_of_user($model->id , $data);
           
            \DB::commit();
        // all good
        } catch (\Exception $e) {
            \DB::rollback();
            throw new \Exception($e->getMessage());
        }
            
            

        return $model;
    }

    public function all()
    {
        return $this->userRepository->all();
    }

    public function find($id)
    {
        return $this->userRepository->find($id);
    }

    public function createRolePermissionsOfUser($project_id , $all_stakholders){
        return $this->userRepository->create_role_permisions_set_of_user($project_id , $all_stakholders);
    }

    public function getUsersOfProjectID($project_id , $permission_item = ''){
        $usArrers = [];
        $permission = Permission::where('name' , $permission_item)->first();
        $permission_id = (isset($permission->id)) ? $permission->id :'';

        $auth_user_id = \Auth::user()->id;
        $users = $this->userRepository->get_users_of_project($project_id , $permission_id);
        if($users->count() > 0){
            foreach($users as $user){
               // if($auth_user_id != $user->id){
                    if(isset($user->allRoles[0])){
                        $job_title = $user->allRoles[0]->pivot->job_title != NULL ?' - ('. $user->allRoles[0]->pivot->job_title.')' : '';
                    } else{
                        $job_title='';
                    }
                    $user->name = $user->name.' '.$job_title;
                    if($permission_id != '' && $user->allPermissions->count() > 0 ){
                        $usArrers[] = $user;
                    }else if($permission_item == ''){
                        $usArrers[] = $user;
                    } 
                //}

            }
        }

    


        return ['users'=> $usArrers];

    }



    public function checkIfUserHasThisPermission($project_id , $permission_item = ''){
        $usArrers = [];
        $permission = Permission::where('name' , $permission_item)->first();
        $permission_id = (isset($permission->id)) ? $permission->id :'';

        $auth_user_id = \Auth::user()->id;
        $user = $this->userRepository->check_if_user_of_project_has_this_permission($project_id , $permission_id);
        if(isset($user->id) && $user->allPermissions->count() > 0){
            return true;
        }
    


        return false;

    }









    public function getAllProjectStakeholders($project_id , $request){
        $all_stakholders = $this->userRepository->get_stakeholders_of_project($project_id , $request);
        return $all_stakholders;
    }

    public function delete($id)
    {
        try{
            return $this->userRepository->delete($id);
        }catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

}