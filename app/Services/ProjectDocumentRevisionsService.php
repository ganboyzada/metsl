<?php

namespace App\Services;

use App\Repository\CorrespondenceFileRepositoryInterface;
use App\Repository\ProjectDocumentFilesRepositoryInterface;
use App\Repository\ProjectDocumentRevisionsRepositoryInterface;
use Illuminate\Support\Facades\Storage;

class ProjectDocumentRevisionsService
{
    public function __construct(
        protected ProjectDocumentRevisionsRepositoryInterface $projectDocumentRevisionsRepository
    ) {
    }

    public function create(array $data)
    {
        \DB::beginTransaction();
        try {
            $project_id = $data['project_id'];
            $project_document_id = $data['project_document_id'];
            if(isset($data['file']) && $data['file'] != NULL){
                $file = $data['file'];
                $fileName = $file->getClientOriginalName();            
                $data['file'] = $fileName;

            }else{
                $data['file'] = NULL;
            }


            $modal =  $this->projectDocumentRevisionsRepository->create($data);
            $path = Storage::disk('public')->path('/project'.$data['project_id'].'/documents'.$project_document_id.'/revisions'.$modal->id);            
            \File::makeDirectory($path, $mode = 0777, true, true);  

            if(isset($data['file']) && $data['file'] != NULL){
                Storage::disk('public')->putFileAs('project'.$data['project_id'].'/documents'.$project_document_id.'/revisions/', $file, $fileName);


            }           
            \DB::commit();
        } catch (\Exception $e) {
            \DB::rollback();
            throw new \Exception($e->getMessage());
        }
            
            

        return $modal;
    }

    public function getRevisionsOfDocument($document_id): mixed
    {
       return  $this->projectDocumentRevisionsRepository->get_revisions_of_document($document_id);

    }

    public function createComment($data){
        return $this->projectDocumentRevisionsRepository->create_comment($data);

    }

    public function getRevisionComments($id){
        return $this->projectDocumentRevisionsRepository->get_revision_comments($id);

    }

    public function updateStatus($id , $status){
        return $this->projectDocumentRevisionsRepository->change_status($id , $status);

    }

}