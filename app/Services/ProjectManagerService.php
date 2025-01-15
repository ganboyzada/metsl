<?php

namespace App\Services;

use App\Repository\ProjectManagerRepositoryInterface;
use Illuminate\Support\Facades\Storage;

class ProjectManagerService
{
    public function __construct(
        protected ProjectManagerRepositoryInterface $ProjectManagerRepository
    ) {
    }

    public function create(array $data)
    {
        \DB::beginTransaction();
        try {         
            if(isset($data['image']) && $data['image'] != NULL){
                $file = $data['image'];
                $fileName = md5(time()).'.'.$file->extension();            
                $data['image'] = $fileName;

            }else{
                $data['image'] = NULL;
            }


            $data['status'] = 1;

            $model =  $this->ProjectManagerRepository->create($data);
            
           // $path = Storage::disk('public')->path('/projectManager' . $model->id);
            $path = Storage::disk('public')->path('projectManager'.$model->id);
            
            \File::makeDirectory($path, $mode = 0777, true, true);
        
            if ($data['image'] != NULL) {
                //dd($model->image);
                // Store the file in the directory
                Storage::disk('public')->putFileAs('projectManager' . $model->id, $file, $data['image']);
            }          

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
            if(isset($data['image']) && $data['image'] != NULL){
                $file = $data['image'];
                $fileName = md5(time()).'.'.$file->extension();            
                $data['image'] = $fileName;
            }
            $data['status'] = 1;
            $id = $data['userable_id'];
            $model =  $this->ProjectManagerRepository->update($data , $id);
            
           // $path = Storage::disk('public')->path('/projectManager' . $model->id);
            $path = Storage::disk('public')->path('projectManager'.$id);
            
            \File::makeDirectory($path, $mode = 0777, true, true);
        
            if(isset($data['image']) && $data['image'] != NULL){
                //dd($model->image);
                // Store the file in the directory
                Storage::disk('public')->putFileAs('projectManager' . $id, $file, $data['image']);
            }          

            \DB::commit();
        // all good
        } catch (\Exception $e) {
            \DB::rollback();
            throw new \Exception($e->getMessage());
        }            
        return $model;
    }

    public function delete($id)
    {
        return $this->ProjectManagerRepository->delete($id);
    }

    public function all()
    {
        return $this->ProjectManagerRepository->with(['user:id,userable_id,userable_type'])->all();

       // return $this->ProjectManagerRepository->with(['user:id,userable_id,userable_type'])->query()->get();
    }

    public function projectsOfProjectManager($id)
    {
        return $this->ProjectManagerRepository->projects_of_project_manger($id);
    }

    public function changeStatus($id , $status)
    {
        return $this->ProjectManagerRepository->change_status($id , $status);
        
    }

    public function find($id)
    {
        return $this->ProjectManagerRepository->find($id);
    }
}