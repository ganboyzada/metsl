<?php

namespace App\Services;

use App\Repository\CorrespondenceFileRepositoryInterface;
use Illuminate\Support\Facades\Storage;

class CorrespondenceFileService
{
    public function __construct(
        protected CorrespondenceFileRepositoryInterface $correspondenceFileRepository
    ) {
    }

    public function createBulkFiles($project_id , $correspondence_id ,  $data)
    {
        \DB::beginTransaction();
        try {         
            $docs = array_map(function($file) use($project_id , $correspondence_id){
                $fileName = $file->getClientOriginalName();
                //$file->move(('storage/project'.$project_id.'/'),$fileName);
                Storage::disk('public')->putFileAs($file, 'project'.$project_id.'/correspondence'.$correspondence_id.'/'.$fileName);


                return ['file'=>$fileName , 'correspondence_id'=>$correspondence_id , 'type'=>$file->extension()];

            } , $data['docs']);

            $model = $this->correspondenceFileRepository->create_bulk_files($docs);
            \DB::commit();
        // all good
        } catch (\Exception $e) {
            \DB::rollback();
            //dd($e);
            throw new \Exception($e->getMessage());
        }            
        return $model;
    }

}