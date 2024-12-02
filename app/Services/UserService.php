<?php

namespace App\Services;

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

    public function update(array $data, $id)
    {
        return $this->userRepository->update($data, $id);
    }

    public function delete($id)
    {
        return $this->userRepository->delete($id);
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


}