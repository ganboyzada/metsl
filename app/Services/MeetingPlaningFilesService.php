<?php

namespace App\Services;

use App\Repository\CorrespondenceFileRepositoryInterface;
use App\Repository\MeetingPlaningFilesRepositoryInterface;
use App\Repository\ProjectDocumentFilesRepositoryInterface;
use Illuminate\Support\Facades\Storage;

class MeetingPlaningFilesService
{
    public function __construct(
        protected MeetingPlaningFilesRepositoryInterface $meetingPlaningFilesRepository
    ) {
    }

    public function createBulkFiles($project_id , $meetingplaning_id ,  $uploadeedfiles)
    {
        \DB::beginTransaction();
        try {         
            $docs = array_map(function($file) use($project_id , $meetingplaning_id , $uploadeedfiles ){
                $fileName = $file->getClientOriginalName();
                Storage::disk('public')->putFileAs($file, 'project'.$project_id.'/meeting_planing'.$meetingplaning_id.'/'.$fileName);


                return ['file'=>$fileName , 'meeting_id'=>$meetingplaning_id, 'type'=>$file->extension() , 'size'=>$file->getSize() ];

            } , $uploadeedfiles);

            $model = $this->meetingPlaningFilesRepository->create_bulk_files($docs);
            \DB::commit();
        // all good
        } catch (\Exception $e) {
            \DB::rollback();
            //dd($e);
            throw new \Exception($e->getMessage());
        }            
        return $model;
    }

    public function delete($id)
    {
        try{
            return $this->meetingPlaningFilesRepository->delete($id);
        }catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

}