<?php

namespace App\Services;

use App\Repository\DocumentRepositoryInterface;
use App\Repository\MeetingPlaningFilesRepositoryInterface;
use App\Repository\MeetingPlaningRepositoryInterface;
use App\Repository\ProjectDocumentFilesRepositoryInterface;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Storage;

class MeetingPlaningService
{
    public function __construct(
        protected MeetingPlaningRepositoryInterface $meetingPlaningRepository,
        protected UserService $userService,
        protected MeetingPlaningFilesService $meetingPlaningFilesService

        ) {
    }

    public function getNextNumber($id){
        // dd($type);
         $count = $this->meetingPlaningRepository->get_next_number($id);
         if($count){
             return 'Meeting_'.$count+1;    
         }else{
             return 'Meeting_1';
         }
     }
    public function create(array $data)
    {
        \DB::beginTransaction();
        try {
            $project_id = $data['project_id'];
            $modal =  $this->meetingPlaningRepository->create($data);
            $path = Storage::url('/project'.$data['project_id'].'/meeting_planing'.$modal->id);
            
            \File::makeDirectory($path, $mode = 0777, true, true);  
           $users =  $this->meetingPlaningRepository->add_users_to_meeting_planing($data,$modal );
          // dd($users);
            if(isset($data['docs'])){
                
                $this->meetingPlaningFilesService->createBulkFiles($data['project_id'] , $modal->id ,$data['docs']);
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
            $this->meetingPlaningRepository->update($data , $id);
            $modal = $this->meetingPlaningRepository->find($data['id']);
            $path = Storage::url('/project'.$data['project_id'].'/meeting_planing'.$modal->id);
            
            \File::makeDirectory($path, $mode = 0777, true, true);  
           $users =  $this->meetingPlaningRepository->add_users_to_meeting_planing($data,$modal );
          // dd($users);
            if(isset($data['docs'])){
                
                $this->meetingPlaningFilesService->createBulkFiles($data['project_id'] , $modal->id ,$data['docs']);
            }           
            \DB::commit();
        } catch (\Exception $e) {
            \DB::rollback();
            throw new \Exception($e->getMessage());
        }
            
            

        return $modal;
    }

    public function getAllProjectMeetingPlaning($project_id , $request){
        return $this->meetingPlaningRepository->get_all_project_meeting_planing($project_id , $request);

    }


    public function getAllProjectMeetingActions($project_id , $request){
        return $this->meetingPlaningRepository->get_all_project_meeting_planing_has_action_to_user($project_id , $request);

    }

    public function find($meeting_planing_id){
        $punch_list =  $this->meetingPlaningRepository->with([ 'users:name' , 'files','notes.assignee'])->find($meeting_planing_id);
        return $punch_list;
    }

    public function delete($id)
    {
        try{
            return $this->meetingPlaningRepository->delete($id);
        }catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

}