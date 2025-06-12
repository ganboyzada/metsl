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
         return $count;
     }
    public function create(array $data , $assignees_has_permission = [])
    {
        \DB::beginTransaction();
        try {
            $project_id = $data['project_id'];
            $modal =  $this->punchListRepository->create($data);
           // $modal->drawings()->sync($data['drawings']);
            $path = Storage::url('/project'.$data['project_id'].'/punch_list'.$modal->id);
            
            \File::makeDirectory($path, $mode = 0777, true, true);  

			if($modal->work_package_id != NULL && count($assignees_has_permission) > 0){
                $assignees =  $this->punchListRepository->add_assignees_to_Punch_list($data,$modal, $assignees_has_permission);
            }

            if(isset($data['participates']) &&  count($data['participates']) > 0){
                $users =  $this->punchListRepository->add_users_to_Punch_list($data,$modal );

            }

            if(isset($data['linked_documents']) &&  count($data['linked_documents']) > 0){
                $this->punchListRepository->add_Linked_documents_to_punchlist($data,$modal);
            }
           
		   
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
          //  $project_id = $data['project_id'];
            $id = $data['id'];
            $this->punchListRepository->update($data , $id);
            $modal =  $this->punchListRepository->find($data['id']);
        //     $path = Storage::url('/project'.$data['project_id'].'/punch_list'.$modal->id);
            
        //     \File::makeDirectory($path, $mode = 0777, true, true);  
        //    $users =  $this->punchListRepository->add_users_to_Punch_list($data,$modal );
        //     if(isset($data['docs'])){
                
        //         $this->punchListFilesService->createBulkFiles($data['project_id'] , $modal->id ,$data['docs']);
        //     }           
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
    public function getAllProjectPunchListOpen($project_id , $request){
        return $this->punchListRepository->get_all_project_Punch_list_open($project_id , $request);

    }
    public function getAllProjectPunchListPaginate($project_id,$request){
        return $this->punchListRepository->get_all_project_Punch_list_paginate($project_id,$request);

    }

 public function getAllProjectPunchListByDrawingIdApi($project_id,$id,$request){
        return $this->punchListRepository->get_all_project_Punch_list_by_drawing_id($project_id,$id,$request);

    }


    public function getAllProjectPunchListByDrawingId($project_id , $drawing_id , $current_punchlist_id){
        if($current_punchlist_id == NULL){
            return $this->punchListRepository->where(['project_id' => $project_id , 'drawing_id' => $drawing_id])->all();

        }else{
            return $this->punchListRepository->where(['project_id' => $project_id , 'drawing_id' => $drawing_id , 'id' => $current_punchlist_id])->all();

        }

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
        $punch_list =  $this->punchListRepository->with([ 'users:id' , 'files','documentFiles'])->find($punch_list_id);
        $punch_list->priority_val = $punch_list->priority->value;
        $punch_list->status_val = $punch_list->status->value;
        return $punch_list;
    }

    public function find($punch_list_id){
        $punch_list =  $this->punchListRepository->with([ 'users' , 'files'  ,'replies.user','documentFiles','drawing',
        'assignees','package.companies', 'responsible'])->find($punch_list_id);
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