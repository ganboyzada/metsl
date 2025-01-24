<?php

namespace App\Services;

use App\Repository\CorrespondenceRepositoryInterface;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Storage;

class CorrespondenceService
{
    public function __construct(
        protected CorrespondenceRepositoryInterface $correspondenceRepository,
        protected UserService $userService,
        protected CorrespondenceFileService $correspondenceFileService
    ) {
    }


    public function getNextNumber($type , $id){
       // dd($type);
        $count = $this->correspondenceRepository->get_next_number($type , $id);
        if($count){
            return $type.'-00'.$count+1;    
        }else{
            return $type.'-001';
        }
    }

    public function create(array $data)
    {
        \DB::beginTransaction();
        try {

            $correspondence =  $this->correspondenceRepository->create($data);
            $this->correspondenceRepository->add_users_to_correspondence($data,$correspondence );
            $this->correspondenceRepository->add_Linked_documents_to_correspondence($data,$correspondence );

            $path = Storage::url('/project'.$data['project_id'].'/correspondence'.$correspondence->id);
            
            \File::makeDirectory($path, $mode = 0777, true, true);        

            if(isset($data['docs'])){
                $this->correspondenceFileService->createBulkFiles($data['project_id'],$correspondence->id , $data);
            }           
            \DB::commit();
        } catch (\Exception $e) {
            \DB::rollback();
            throw new \Exception($e->getMessage());
        }
            
            

        return $correspondence;
    }

    public function update(array $data)
    {
        
        \DB::beginTransaction();
        try {
            $project_id = $data['project_id'];
            $id = $data['id'];

            $this->correspondenceRepository->update($data , $id);
            $correspondence = $this->correspondenceRepository->find($data['id']);
            $this->correspondenceRepository->add_users_to_correspondence($data,$correspondence );

            $this->correspondenceRepository->add_Linked_documents_to_correspondence($data,$correspondence );


            $path = Storage::url('/project'.$data['project_id'].'/correspondence'.$correspondence->id);
            
            \File::makeDirectory($path, $mode = 0777, true, true);        

            if(isset($data['docs'])){
                $this->correspondenceFileService->createBulkFiles($data['project_id'],$correspondence->id , $data);
            }           
            \DB::commit();
        } catch (\Exception $e) {
            \DB::rollback();
            throw new \Exception($e->getMessage());
        }
        return $correspondence;
    }

    public function delete($id)
    {
        try{
            return $this->correspondenceRepository->delete($id);
        }catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function all()
    {
        return $this->correspondenceRepository->all();
    }


    public function changeStatus($id , $status)
    {
        return $this->correspondenceRepository->change_status($id , $status);
        
    }

    public function edit($id)
    {
        return $this->correspondenceRepository->with([
            'assignees' , 
        'distributionMembers',
         'ReceivedFrom', 
         
         'files:id,correspondence_id,file,size',
         'documentFiles'
         
         ])->find($id);
        
    }

    public function find($id)
    {
        return $this->correspondenceRepository->with([
            'assignees.userable' , 
        'distributionMembers.userable',
         'ReceivedFrom.userable', 
         
         'files:id,correspondence_id,file,size',
         'documentFiles'
         
         ])->find($id);
        
    }
    public function getAllProjectCorrespondence($project_id , $request){
        return $this->correspondenceRepository->get_all_project_correspondence($project_id , $request);

    }

    public function getCorrespondenceParent($project_id , $correspondence_id){
        return $this->correspondenceRepository->get_correspondence_parent($project_id , $correspondence_id)->map(function($correspondence){
            $correspondence->assignees = implode(',',$correspondence->assignees->map(function($assignee){
                return $assignee->name; 
            })->all());

            return $correspondence;
        });

    }

    public function getCorrespondenceReplies($project_id , $correspondence_id){
        return $this->correspondenceRepository->get_correspondence_replies($project_id , $correspondence_id)->map(function($correspondence){
            $correspondence->assignees = implode(',',$correspondence->assignees->map(function($assignee){
                return $assignee->name; 
            })->all());
            return $correspondence;


        });

    }

}