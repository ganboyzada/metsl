<?php

namespace App\Services;

use App\Repository\DesignTeamRepositoryInterface;
use Illuminate\Support\Facades\Storage;

class DesignTeamService
{
    public function __construct(
        protected DesignTeamRepositoryInterface $DesignTeamRepository
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
            $model =  $this->DesignTeamRepository->create($data);
            
            $path = Storage::disk('public')->path('designTeam'.$model->id);
            
            \File::makeDirectory($path, $mode = 0777, true, true);
        
            if($data['image'] != NULL){
                Storage::disk('public')->putFileAs('designTeam' . $model->id, $file, $fileName);

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
            $model =  $this->DesignTeamRepository->update($data , $id);
            
            $path = Storage::disk('public')->path('designTeam'.$id);
            
            \File::makeDirectory($path, $mode = 0777, true, true);
        
            if(isset($data['image']) && $data['image'] != NULL){
                Storage::disk('public')->putFileAs('designTeam' . $id, $file, $fileName);

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
        return $this->DesignTeamRepository->delete($id);
    }

    public function all()
    {
        return $this->DesignTeamRepository->with(['user:id,userable_id,userable_type'])->all();
    }

    public function projectsOfDesignTeam($id)
    {
        return $this->DesignTeamRepository->projects_of_design_team($id);
    }

    public function changeStatus($id , $status)
    {
        return $this->DesignTeamRepository->change_status($id , $status);
        
    }

    public function find($id)
    {
        return $this->DesignTeamRepository->find($id);
    }
}