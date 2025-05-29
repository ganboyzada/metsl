<?php

namespace App\Services;

use App;
use App\Repository\CompanyRepositoryInterface;
use Illuminate\Support\Facades\Storage;

class CompanyService
{
    public function __construct(
        protected CompanyRepositoryInterface $CompanyRepository
    ) {
    }

    public function create(array $data)
    {
        
        
            if(isset($data['logo']) && $data['logo'] != NULL){
                $file = $data['logo'];
                $fileName = md5(time()).'.'.$file->extension();            
                $data['logo'] = $fileName;

            }else{
                 $data['logo'] = NULL;
            }

           $model =  $this->CompanyRepository->create($data);
            
            $path = Storage::url('company'.$model->id);
            
            \File::makeDirectory($path, $mode = 0777, true, true);
        
            if($data['logo'] != NULL){
                $file->move(('storage/company'.$model->id.'/'),$model->logo);

            } 
        return $model;
    }

    public function update(array $data, $id)
    {
        return $this->CompanyRepository->update($data, $id);
    }

    public function delete($id)
    {
        return $this->CompanyRepository->delete($id);
    }

    public function all()
    {
       // $d = $this->CompanyRepository->with(['projects'])->query()->get();

        return $this->CompanyRepository->all();
    }

    public function changeStatus($id)
    {
        $model = $this->CompanyRepository->find($id);
        if($model->staus == 1){
            return $this->CompanyRepository->change_status($id , 0);
        }else{
            return $this->CompanyRepository->change_status($id , 1);
        }
        
    }

    public function find($id)
    {
        return $this->CompanyRepository->find($id);
    }

    public function get_work_packages(){
        $packages = App\Models\WorkPackages::all();
        return $packages;
    }
}