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
        protected ProjectDocumentFilesService $projectDocumentFilesService,
        protected ProjectDocumentRevisionsService $projectDocumentRevisionsService

        ) {
    }


    public function create(array $data)
    {
        \DB::beginTransaction();
        try {
            $project_id = $data['project_id'];
            $files = [];
            $old_numbers = [];
            $old_files = [];
            $document_files = $this->projectDocumentFilesService->getAllFiles($project_id);
            if($document_files->count()  > 0){
                foreach($document_files as $file){
                    $old_numbers[$file->ProjectDocument->number] = array('id'=>$file->id , 
                    'project_document_id'=>$file->project_document_id , 
                    'document_number'=>$file->ProjectDocument->number ,
                    'file'=>$file->file
                );
                    $old_files[$file->file] = array('id'=>$file->id , 
                    'project_document_id'=>$file->project_document_id , 
                    'document_number'=>$file->ProjectDocument->number ,
                    'file'=>$file->file
                );
                }
            }

            $revisions = [];
            $news = [];
            if(isset($data['docs'])){
                foreach($data['docs'] as $doc){
                    if(array_key_exists($doc->getClientOriginalName() , $old_files)){
                        $revisions[] = array('id'=> $old_files[$doc->getClientOriginalName()]['id'] ,
                         'project_document_id'=> $old_files[$doc->getClientOriginalName()]['project_document_id'] ,
                         'doc'=>$doc , 'number'=>$old_files[$doc->getClientOriginalName()]['document_number']);
                    }
                    
                    else if( array_key_exists($data['number'], $old_numbers)){
                        $revisions[] = array('id'=> $old_numbers[$data['number']]['id'] ,
                         'project_document_id'=> $old_numbers[$data['number']]['project_document_id'] ,
                         'doc'=>$doc , 'number'=>$old_numbers[$data['number']]['document_number']);
                    }
                    else{
                        $news[] = $doc;
                    }                   
                    
                }
            }
            
            if(count($news) > 0){

                foreach($news as $file_new){
                    $document =  $this->documentRepository->create($data);
                    $path = Storage::url('/project'.$data['project_id'].'/documents'.$document->id);
                    
                    \File::makeDirectory($path, $mode = 0777, true, true);  
                    if(in_array(-1 , $data['reviewers'])){
                        $reviewers = collect($this->userService->getUsersOfProjectID($project_id , 'review_documents')['users'])->pluck('id')->toArray();
                        $data['reviewers'] = $reviewers;
                       // dd($data['reviewers']);

                    }

                    $users =  $this->documentRepository->add_users_to_document($data,$document );
        
                

                    $document_id = $document->id;
                        
                    $this->projectDocumentFilesService->createBulkFiles($data['project_id'] 
                    , $document->id ,[$file_new]);
                                    
                }
    
            }
            if(count($revisions) > 0){
                foreach($revisions as $revision){
                    $new_data['project_id'] = $project_id;
                    $new_data['project_document_id'] = $revision['project_document_id'];
                    $new_data['file'] = $revision['doc'];
                    $new_data['project_document_file_id'] = $revision['id'];
                    $new_data['title'] = $data['title'];
                    $new_data['user_id'] = \Auth::user()->id;
                    $new_data['status'] = 0;
                    $new_data['upload_date'] = date('Y-m-d');
                   // dd($new_data);
                    $this->projectDocumentRevisionsService->create($new_data);
                }
            }
          
            \DB::commit();
        } catch (\Exception $e) {
            \DB::rollback();
            throw new \Exception($e->getMessage());
        }
            
            

        return $document ?? null;
    }

    public function update(array $data)
    {
        \DB::beginTransaction();
        try {
            $project_id = $data['project_id'];
            $id = $data['id'];
            $this->documentRepository->update($data , $id);
            $document =  $this->documentRepository->find($data['id']);
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

    public function getAllProjectDocumentsPackages($project_id , $request){
        return $this->documentRepository->get_all_project_documents_packages($project_id , $request);

    }
    public function getPackage($project_id , $id){
        return $this->documentRepository->get_package($project_id , $id);
    }

    public function getSubFolder($id , $request){
        return $this->documentRepository->get_sub_folder($id , $request);
    }
    public function getAllProjectDocumentsAssigned($project_id , $request){
        return $this->documentRepository->get_all_project_documents_assigned($project_id , $request);

    }


    public function getDetailOfDocument($document_id){

       return $this->documentRepository->with(['files','reviewers','user'])->find($document_id);

    }

    public function delete($id)
    {
        try{
            return $this->documentRepository->delete($id);
        }catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }  
    
    public function updateStatus($id , $status){
        return $this->documentRepository->change_status($id , $status);

    }

}