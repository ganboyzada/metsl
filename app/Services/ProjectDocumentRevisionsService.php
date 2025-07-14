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


            
            $path = Storage::disk('public')->path('/project'.$data['project_id'].'/documents'.$project_document_id.'/revisions');            
            \File::makeDirectory($path, $mode = 0777, true, true);  
            $preview_image = NULL;
            if(isset($data['file']) && $data['file'] != NULL){
                Storage::disk('public')->putFileAs('project'.$data['project_id'].'/documents'.$project_document_id.'/revisions/', $file, $fileName);
                
                
                $extension = $file->getClientOriginalExtension();
                $mimeType = $file->getMimeType();
                if ($extension === 'pdf' && $mimeType === 'application/pdf') {
                        $pdfFullPath = storage_path('app/public/project'.$project_id.'/documents'.$project_document_id.'/revisions/'.$fileName);
                        $pdf = new \Spatie\PdfToImage\Pdf($pdfFullPath);

                        // Save first page as image
                        $imageName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)  . '.jpg';
                        $imagePath = storage_path('app/public/project'.$project_id.'/documents'.$project_document_id.'/revisions/'.$imageName);

                        $pdf->setPage(1)->saveImage($imagePath);
                        $preview_image = $imageName;
                }elseif (in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'webp']) && str_starts_with($mimeType, 'image/')) {
                    $preview_image = $fileName;

                }             


            }   
            $data['preview_image'] = $preview_image;
            //dd($data);
            $modal =  $this->projectDocumentRevisionsRepository->create($data);
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
            if(isset($data['image']) && $data['image'] != NULL){
                $file = $data['image'];
                $fileName = time().'_'.$file->getClientOriginalName();            
                $data['image'] = $fileName;

            }else{
                $data['image'] = NULL;
            }

            $path = Storage::disk('public')->path('/project'.$data['project_id'].'/documents'.$data['project_document_id'].'/comments');            
            \File::makeDirectory($path, $mode = 0777, true, true);  
            if(isset($data['image']) && $data['image'] != NULL){
                Storage::disk('public')->putFileAs('project'.$data['project_id'].'/documents'.$data['project_document_id'].'/comments/', $file, $fileName);
                
            }
        //dd($data);
        return $this->projectDocumentRevisionsRepository->create_comment($data);

    }

    public function getRevisionComments($id,$type){
        return $this->projectDocumentRevisionsRepository->get_revision_comments($id,$type);

    }

    public function updateStatus($id , $status){
        return $this->projectDocumentRevisionsRepository->change_status($id , $status);

    }

}