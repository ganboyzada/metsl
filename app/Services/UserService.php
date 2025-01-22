<?php

namespace App\Services;

use App\Models\Permission;
use App\Repository\UserRepositoryInterface;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;

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
            $model =  $this->userRepository->update($data , $id);

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

        $users = $this->userRepository->get_users_of_project($project_id , $permission_id);
        foreach($users as $user){
            $job_title = $user->allRoles[0]->pivot->job_title != NULL ?' - ('. $user->allRoles[0]->pivot->job_title.')' : '';
            $user->name = $user->name.' '.$job_title;
            if($permission_id != '' && $user->allPermissions->count() > 0 ){
                $usArrers[] = $user;
            }else if($permission_item == ''){
                $usArrers[] = $user;
            } 
        }
    


        return ['users'=> $usArrers];

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