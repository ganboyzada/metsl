<?php

namespace App\Services;

use App\Enums\CorrespondenceTypeEnum;
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
            return $type.'-'.$count;    
        
    }

    public function create(array $data)
    {
        \DB::beginTransaction();
        try {

            $correspondence =  $this->correspondenceRepository->create($data);
            if(isset($data['related_correspondences']) && count($data['related_correspondences']) > 0){
                $correspondence->relatedCorrespondences()->sync($data['related_correspondences']);
            }
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


    public function update_status(array $data)
    {
        
        \DB::beginTransaction();
        try {
            $project_id = $data['project_id'];
            $id = $data['id'];

            $this->correspondenceRepository->update($data , $id);
            $correspondence = $this->correspondenceRepository->find($data['id']);
           
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

    public function close($id)
    {
        try{
            return $this->correspondenceRepository->close($id);
        }catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function accept($id)
    {
        try{
            return $this->correspondenceRepository->accept($id);
        }catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function reject($request)
    {
        try{
            $data = $request->all();
            $correspondence = $this->edit($request->id);

            $correspondence->reject_reason = $data['reject_reason'];


            $path = Storage::url('/project'.$correspondence->project_id.'/correspondence'.$correspondence->id);
            
            \File::makeDirectory($path, $mode = 0777, true, true); 
            
            if(isset($data['reject_file']) && $data['reject_file'] != NULL){
                $file = $data['reject_file'];
                $fileName = time().'_'.$file->getClientOriginalName();
 
    
                Storage::disk('public')->putFileAs( 'project'.$correspondence->project_id.'/correspondence'.$correspondence->id, $file, $fileName);
            
                $correspondence->reject_file = $fileName;
            } 

            $correspondence->save();


            return $this->correspondenceRepository->reject($request->id);
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
    
    public function allCorrespondenceExceptNCR($project_id ,$reply_correspondence_id){
        return $this->correspondenceRepository->get_correspondence_except_NCR($project_id , $reply_correspondence_id);
    }

    public function edit($id)
    {
        return $this->correspondenceRepository->with([
            'assignees' , 
        'distributionMembers',
         'ReceivedFrom', 
         
         'files:id,correspondence_id,file,size',
         'documentFiles',
         'relatedCorrespondences'
         
         ])->find($id);
        
    }

    public function find($id)
    {
        return $this->correspondenceRepository->with([
            'assignees' , 
        'distributionMembers',
         'ReceivedFrom', 
         
         'files:id,correspondence_id,file,size',
         'documentFiles'
         
         ])->find($id);
        
    }
    public function getAllProjectCorrespondence($project_id , $request){
       // return $project_id;
        return $this->correspondenceRepository->get_all_project_correspondence($project_id , $request);

    }

    public function getAllProjectCorrespondenceOpen($project_id , $request){
        return $this->correspondenceRepository->get_all_project_correspondence_open($project_id , $request);

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

    public function updateDueDays($request){
        return $this->correspondenceRepository->update_due_days($request);
    }  
    
    public function getLastReplyCorrespondence($project_id , $correspondence_id){
        return $this->correspondenceRepository->get_last_reply_correspondence($project_id , $correspondence_id);
    }

}