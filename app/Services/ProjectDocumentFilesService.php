<?php

namespace App\Services;

use App\Repository\CorrespondenceFileRepositoryInterface;
use App\Repository\ProjectDocumentFilesRepositoryInterface;
use Carbon\Carbon;
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
                Storage::disk('public')->putFileAs('project'.$project_id.'/documents'.$document_id, $file, $fileName);


                return ['file'=>$fileName , 'project_document_id'=>$document_id, 'type'=>$file->extension() , 'size'=>$file->getSize(), 'created_at'=>Carbon::now() , 'status'=>0];

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

    public function delete($id)
    {
        try{
            return $this->projectDocumentFilesRepository->delete($id);
        }catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function getAllFiles($project_id)
    {
        return $this->projectDocumentFilesRepository->project_document_files($project_id);
    }

    public function getNewestFilesByProjectId($project_id)
    {
        return $this->projectDocumentFilesRepository->get_newest_files_by_project_document_id($project_id);
    }

    public function updateStatus($id , $status){
        return $this->projectDocumentFilesRepository->change_status($id , $status);

    }

}