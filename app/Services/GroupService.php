<?php

namespace App\Services;

use App\Models\Client;
use App\Models\Contractor;
use App\Models\DesignTeam;
use App\Models\ProjectManager;
use App\Repository\GroupRepositoryInterface;
use App\Repository\ProjectRepositoryInterface;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Storage;

class GroupService
{
    public function __construct(
        protected GroupRepositoryInterface $groupRepository
        ) {
    }

    public function create(array $data)
    {
        \DB::beginTransaction();
        try {
           /* if(isset($data['file']) && $data['file'] != NULL){
                $file = $data['file'];
                $fileName = $file->getClientOriginalName();            
                $data['file'] = $fileName;

            }else{
                $data['file'] = NULL;
            }*/

            $model =  $this->groupRepository->create($data);

            
            \DB::commit();
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

            $id = $data['id'];

            $this->groupRepository->update($data , $id);
            $model = $this->groupRepository->find($id);

   
            
            \DB::commit();
        } catch (\Exception $e) {
            \DB::rollback();
            throw new \Exception($e->getMessage());
        }
            
            

        return $model;
    }

    public function allGroups($project_id)
    {
        return $this->groupRepository->all_groups($project_id);
    }


    public function find($id)
    {
        $group =  $this->groupRepository->find($id);

        return $group;
        
    }

    public function delete($id)
    {
        try{
            return $this->groupRepository->delete($id);
        }catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

}