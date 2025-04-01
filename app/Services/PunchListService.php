<?php

namespace App\Services;


use App\Repository\PunchListRepositoryInterface;
use App\Services\PunchListFilesService;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Storage;

class PunchListService
{
    public function __construct(
        protected PunchListRepositoryInterface $punchListRepository,
        protected UserService $userService,
        protected PunchListFilesService $punchListFilesService

        ) {
    }

    public function getNextNumber($id){
        // dd($type);
         $count = $this->punchListRepository->get_next_number($id);
         if($count){
             return 'punch_list_'.$count+1;    
         }else{
             return 'punch_list_1';
         }
     }
    public function create(array $data)
    {
        \DB::beginTransaction();
        try {
            $project_id = $data['project_id'];
            $modal =  $this->punchListRepository->create($data);
            $path = Storage::url('/project'.$data['project_id'].'/punch_list'.$modal->id);
            
            \File::makeDirectory($path, $mode = 0777, true, true);  
           $users =  $this->punchListRepository->add_users_to_Punch_list($data,$modal );
          // dd($users);
            if(isset($data['docs'])){
                
                $this->punchListFilesService->createBulkFiles($data['project_id'] , $modal->id ,$data['docs']);
            }           
            \DB::commit();
        } catch (\Exception $e) {
            \DB::rollback();
            throw new \Exception($e->getMessage());
        }
            
            

        return $modal;
    }



    public function update(array $data)
    {
        \DB::beginTransaction();
        try {
            $project_id = $data['project_id'];
            $id = $data['id'];
            $this->punchListRepository->update($data , $id);
            $modal =  $this->punchListRepository->find($data['id']);
            $path = Storage::url('/project'.$data['project_id'].'/punch_list'.$modal->id);
            
            \File::makeDirectory($path, $mode = 0777, true, true);  
           $users =  $this->punchListRepository->add_users_to_Punch_list($data,$modal );
          // dd($users);
            if(isset($data['docs'])){
                
                $this->punchListFilesService->createBulkFiles($data['project_id'] , $modal->id ,$data['docs']);
            }           
            \DB::commit();
        } catch (\Exception $e) {
            \DB::rollback();
            throw new \Exception($e->getMessage());
        }
            
            

        return $modal;
    }

    public function getAllProjectPunchList($project_id , $request){
        return $this->punchListRepository->get_all_project_Punch_list($project_id , $request);

    }
    public function getAllProjectPunchListPaginate($project_id){
        return $this->punchListRepository->get_all_project_Punch_list_paginate($project_id);

    }
    public function getStatusPieChart($project_id){
        $data =  $this->punchListRepository->get_status_pie_chart($project_id)->map(function($row){
            $row->status_text = $row->status->text();
            return $row;
        });
        $status_counts = [];
        if($data->count() > 0){
            foreach($data as $row){
                $status_counts[$row->status->text()] = $row->count_rows;
            }

        }
        
        return $status_counts;


    }

    public function edit($punch_list_id){
        $punch_list =  $this->punchListRepository->with([ 'users:id' , 'files'])->find($punch_list_id);
        $punch_list->priority_val = $punch_list->priority->value;
        $punch_list->status_val = $punch_list->status->value;
        return $punch_list;
    }

    public function find($punch_list_id){
        $punch_list =  $this->punchListRepository->with([ 'users.userable' , 'files' , 'responsible.userable' ,'replies.user'])->find($punch_list_id);
        $punch_list->priority_val = $punch_list->priority->value;
        $punch_list->status_val = $punch_list->status->value;
        return $punch_list;
    }
    public function delete($id)
    {
        try{
            return $this->punchListRepository->delete($id);
        }catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }
}