<?php

namespace App\Services;

use App\Repository\CorrespondenceFileRepositoryInterface;
use App\Repository\ProjectDocumentFilesRepositoryInterface;
use Illuminate\Support\Facades\Storage;

class ProjectDocumentFilesService
{
    public function __construct(
        protected ProjectDocumentFilesRepositoryInterface $projectDocumentFilesRepository
    ) {
    }

    public function createBulkFiles($project_id , $document_id ,  $uploadeedfiles)
    {
        \DB::beginTransaction();
        try {         
            $docs = array_map(function($file) use($project_id , $document_id , $uploadeedfiles ){
                $fileName = $file->getClientOriginalName();
                Storage::disk('public')->putFileAs($file, 'project'.$project_id.'/documents'.$document_id.'/'.$fileName);


                return ['file'=>$fileName , 'project_document_id'=>$document_id, 'type'=>$file->extension() , 'size'=>$file->getSize()];

            } , $uploadeedfiles);

            $model = $this->projectDocumentFilesRepository->create_bulk_files($docs);
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