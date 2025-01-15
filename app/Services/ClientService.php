<?php

namespace App\Services;

use App\Repository\ClientRepositoryInterface;
use Illuminate\Support\Facades\Storage;

class ClientService
{
    public function __construct(
        protected ClientRepositoryInterface $ClientRepository
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

            $model =  $this->ClientRepository->create($data);
            
            $path = Storage::disk('public')->path('client' . $model->id);

            // Create the directory
            \File::makeDirectory($path, $mode = 0777, true, true);

            if ($data['image'] != NULL) {
                // Store the file in the directory
                Storage::disk('public')->putFileAs('client' . $model->id, $file, $data['image']);
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
        return $this->ClientRepository->update($data, $id);
    }

    public function delete($id)
    {
        return $this->ClientRepository->delete($id);
    }

    public function all()
    {
        return $this->ClientRepository->with(['user:id,userable_id,userable_type'])->all();
    }

    public function projectsOfClient($id)
    {
        return $this->ClientRepository->projects_of_client($id);
    }

    public function changeStatus($id , $status)
    {
        return $this->ClientRepository->change_status($id , $status);
        
    }

    public function find($id)
    {
        return $this->ClientRepository->find($id);
    }
}