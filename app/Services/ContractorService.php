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

            $model =  $this->ContractorRepository->create($data);
            
            $path = Storage::url('contractor'.$model->id);
            
            \File::makeDirectory($path, $mode = 0777, true, true);
        
            if($data['image'] != NULL){
                $file->move(('storage/contractor'.$model->id.'/'),$model->image);

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
        return $this->ContractorRepository->update($data, $id);
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