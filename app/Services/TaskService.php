<?php

namespace App\Services;

use App\Models\Client;
use App\Models\Contractor;
use App\Models\DesignTeam;
use App\Models\ProjectManager;
use App\Repository\GroupRepositoryInterface;
use App\Repository\ProjectRepositoryInterface;
use App\Repository\TaskRepositoryInterface;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Storage;

class TaskService
{
    public function __construct(
        protected TaskRepositoryInterface $taskRepository
        ) {
    }

    public function create(array $data)
    {
        \DB::beginTransaction();
        try {
            if(isset($data['file']) && $data['file'] != NULL){
                $file = $data['file'];
                $fileName = $file->getClientOriginalName();            
                $data['file'] = $fileName;

            }else{
                $data['file'] = NULL;
            }

            $model =  $this->taskRepository->create($data);
            $path = Storage::url('/project'.$data['project_id'].'/tasks');
            \File::makeDirectory($path, $mode = 0777, true, true);
        
            if($data['file'] != NULL){
                Storage::disk('public')->putFileAs('project' . $data['project_id'].'/tasks', $file, $fileName);

            }
            $this->taskRepository->add_users_to_task($data,$model );
            
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

            $this->taskRepository->update($data , $id);
            $model = $this->taskRepository->find($id);

   
            
            \DB::commit();
        } catch (\Exception $e) {
            \DB::rollback();
            throw new \Exception($e->getMessage());
        }
            
            

        return $model;
    }
    public function allTasksAssigned($project_id){
        return $this->taskRepository->all_tasks_assigned($project_id);

    }
    public function allTasks($project_id)
    {
        return $this->taskRepository->all_tasks($project_id);
    }


    public function find($id)
    {
        $group =  $this->taskRepository->find($id);

        return $group;
        
    }

    public function delete($id)
    {
        try{
            return $this->taskRepository->delete($id);
        }catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

}