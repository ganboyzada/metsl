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

    public function update(array $data, $id)
    {
        return $this->correspondenceRepository->update($data, $id);
    }

    public function delete($id)
    {
        return $this->correspondenceRepository->delete($id);
    }

    public function all()
    {
        return $this->correspondenceRepository->all();
    }


    public function changeStatus($id , $status)
    {
        return $this->correspondenceRepository->change_status($id , $status);
        
    }

    public function find($id)
    {
        return $this->correspondenceRepository->with(['assignees:id,name,userable_id,userable_type' , 'DistributionMembers:id,name,userable_id,userable_type', 'ReceivedFrom:id,name,userable_id,userable_type','ReceivedFrom.userable:id,image' ,'assignees.userable:id,image','DistributionMembers.userable:id,image', 'files:id,correspondence_id,file'])->find($id);
        
    }
    public function getAllProjectCorrespondence($project_id , $request){
        return $this->correspondenceRepository->get_all_project_correspondence($project_id , $request);

    }

}