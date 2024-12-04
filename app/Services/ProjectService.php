<?php

namespace App\Services;

use App\Repository\ProjectRepositoryInterface;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Storage;

class ProjectService
{
    public function __construct(
        protected ProjectRepositoryInterface $ProjectRepository,
        protected UserService $userService,
        protected ProjectFileService $projectFileService
    ) {
    }

    public function create(array $data)
    {
        \DB::beginTransaction();
        try {
            if(isset($data['logo']) && $data['logo'] != NULL){
                $file = $data['logo'];
                $fileName = md5(time()).'.'.$file->extension();            
                $data['logo'] = $fileName;

            }else{
                $data['logo'] = NULL;
            }

            $model =  $this->ProjectRepository->create($data);

            $path = Storage::url('/project'.$model->id);
            
            \File::makeDirectory($path, $mode = 0777, true, true);
        
            if($data['logo'] != NULL){
                $file->move(('storage/project'.$model->id.'/'),$model->logo);

            }


            if(isset($data['docs'])){
                $this->projectFileService->createBulkFiles($model->id , $data);


            }
            (isset($data['all_stakholders']) && count($data['all_stakholders']) > 0) ? $this->userService->createRolePermissionsOfUser($model->id , $data['all_stakholders']) : '';
             
            
            \DB::commit();
        } catch (\Exception $e) {
            \DB::rollback();
            throw new \Exception($e->getMessage());
        }
            
            

        return $model;
    }

    public function update(array $data, $id)
    {
        return $this->ProjectRepository->update($data, $id);
    }

    public function delete($id)
    {
        return $this->ProjectRepository->delete($id);
    }

    public function all()
    {
        return $this->ProjectRepository->all();
    }

    public function projectsOfCompany($company_id)
    {
        return $this->ProjectRepository->projects_of_company($company_id);
    }

    public function changeStatus($id , $status)
    {
        return $this->ProjectRepository->change_status($id , $status);
        
    }

    public function find($id)
    {
        return $this->ProjectRepository->find($id);
    }

}