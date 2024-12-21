<?php

namespace App\Services;

use App\Repository\CorrespondenceFileRepositoryInterface;
use App\Repository\PunchListFilesRepositoryInterface;
use App\Repository\ProjectDocumentFilesRepositoryInterface;
use Illuminate\Support\Facades\Storage;

class PunchListFilesService
{
    public function __construct(
        protected PunchListFilesRepositoryInterface $punchListFilesRepository
    ) {
    }

    public function createBulkFiles($project_id , $punchlist_id ,  $uploadeedfiles)
    {
        \DB::beginTransaction();
        try {         
            $docs = array_map(function($file) use($project_id , $punchlist_id , $uploadeedfiles ){
                $fileName = $file->getClientOriginalName();
                Storage::disk('public')->putFileAs($file, 'project'.$project_id.'/punch_list'.$punchlist_id.'/'.$fileName);


                return ['file'=>$fileName , 'punch_list_id'=>$punchlist_id, 'type'=>$file->extension() , 'size'=>$file->getSize()];

            } , $uploadeedfiles);

            $model = $this->punchListFilesRepository->create_bulk_files($docs);
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
            return $this->punchListFilesRepository->delete($id);
        }catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

}