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

            $model =  $this->ProjectManagerRepository->create($data);
            
            $path = Storage::url('projectManager'.$model->id);
            
            \File::makeDirectory($path, $mode = 0777, true, true);
        
            if($data['image'] != NULL){
                $file->move(('storage/projectManager'.$model->id.'/'),$model->image);

            } 
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
        return $this->ProjectManagerRepository->update($data, $id);
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