<?php

namespace App\Services;

use App\Repository\ContractorRepositoryInterface;
use Illuminate\Support\Facades\Storage;

class ContractorService
{
    public function __construct(
        protected ContractorRepositoryInterface $ContractorRepository
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
            $model =  $this->ContractorRepository->create($data);
            
            $path = Storage::disk('public')->path('contractor'.$model->id);
            
            \File::makeDirectory($path, $mode = 0777, true, true);
        
            if($data['image'] != NULL){
                Storage::disk('public')->putFileAs('contractor' . $model->id, $file, $fileName);

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
            $model =  $this->ContractorRepository->update($data , $id);
            
            $path = Storage::disk('public')->path('contractor'.$id);
            
            \File::makeDirectory($path, $mode = 0777, true, true);
        
            if(isset($data['image']) && $data['image'] != NULL){
                Storage::disk('public')->putFileAs('contractor' . $id, $file, $fileName);

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
        return $this->ContractorRepository->delete($id);
    }

    public function all()
    {
        return $this->ContractorRepository->with(['user:id,userable_id,userable_type'])->all();

        // return $this->ContractorRepository->with(['user:id,userable_id,userable_type'])->query()->get();
       // return $this->ContractorRepository->all();

    }

    public function projectsOfContractor($id)
    {
        return $this->ContractorRepository->with(['projects:id,name'])->projects_of_contractor($id);
    }

    public function changeStatus($id , $status)
    {
        return $this->ContractorRepository->change_status($id , $status);
        
    }

    public function find($id)
    {
        return $this->ContractorRepository->find($id);
    }
}