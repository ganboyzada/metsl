<?php

namespace App\Services;

use App\Repository\DocumentRepositoryInterface;
use App\Repository\ProjectDocumentFilesRepositoryInterface;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Storage;

class DocumentService
{
    public function __construct(
        protected DocumentRepositoryInterface $documentRepository,
        protected UserService $userService,
        protected ProjectDocumentFilesService $projectDocumentFilesService

        ) {
    }


    public function create(array $data)
    {
        \DB::beginTransaction();
        try {
            $project_id = $data['project_id'];
            $document =  $this->documentRepository->create($data);
            $path = Storage::url('/project'.$data['project_id'].'/documents'.$document->id);
            
            \File::makeDirectory($path, $mode = 0777, true, true);  

           $users =  $this->documentRepository->add_users_to_document($data,$document );
          // dd($users);


            if(isset($data['docs'])){
                $document_id = $document->id;
                
                $this->projectDocumentFilesService->createBulkFiles($data['project_id'] , $document->id ,$data['docs']);
            }           
            \DB::commit();
        } catch (\Exception $e) {
            \DB::rollback();
            throw new \Exception($e->getMessage());
        }
            
            

        return $document;
    }


    public function getAllProjectDocuments($project_id , $request){
        return $this->documentRepository->get_all_project_documents($project_id , $request);

    }

}