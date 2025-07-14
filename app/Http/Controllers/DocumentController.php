<?php

namespace App\Http\Controllers;

use App\Enums\CorrespondenceStatusEnum;
use App\Enums\RevisionStatusEnum;
use App\Http\Requests\CorrespondenceRequest;
use App\Http\Requests\DocumentRequest;
use App\Http\Requests\PackageRequest;

use App\Http\Requests\SubFolderRequest;
use App\Services\ClientService;
use App\Services\ContractorService;
use App\Services\DesignTeamService;
use App\Services\DocumentService;
use App\Services\ProjectDocumentFilesService;
use App\Services\ProjectDocumentRevisionsService;
use App\Services\ProjectFileService;
use App\Services\ProjectManagerService;
use App\Services\ProjectService;
use App\Services\UserService;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use View;


class DocumentController extends Controller
{
    public function __construct(
        protected ProjectService $projectService , 
        protected ContractorService $contractorService ,
        protected ClientService $clientService ,
        protected DesignTeamService $designTeamService ,
        protected ProjectManagerService $projectmanagerService ,
        protected UserService $userService,
        protected DocumentService $documentService,
        protected ProjectDocumentRevisionsService $projectDocumentRevisionsService,
        protected ProjectDocumentFilesService $projectDocumentFilesService

        )
    {
    }



    public function store(DocumentRequest  $request)
    {
        if($request->validated()){
            \DB::beginTransaction();
            try{
                
                $all_data = request()->all();
                dd($all_data);
                $all_data['created_by'] = \Auth::user()->id;

                $all_data['created_date'] = date('Y-m-d');
                $all_data['status'] = 0;

                $model = $this->documentService->create($all_data);
            \DB::commit();
            // all good
            } catch (\Exception $e) {
                \DB::rollback();
                return response()->json(['error' => $e->getMessage()]);
            }

                       
            return response()->json(['success' => 'Form submitted successfully.' , 'data'=>$model]);

        }
    }

    public function getreviewers(Request $request){
        if (Session::has('projectID') && Session::has('projectName')){
            $id = Session::get('projectID');     
            $reviewers = $this->userService->getUsersOfProjectID($id , 'review_documents');
            $accessibles = $this->userService->getUsersOfProjectID($id , 'add_documents');
		
            $users = $reviewers['users'];
            $accessibles = $accessibles['users'];

            return ['users'=>$users , 'accessibles'=>$accessibles];
        }

    }


    public function ProjectDocuments(Request $request){
        $id = Session::get('projectID');
        $documents = $this->documentService->getAllProjectDocuments($id , $request); 
		$documents->map(function($row){
			$startDate = Carbon::parse($row->created_date);

			$endDate = Carbon::parse(date('Y-m-d'));
			if($startDate->diffInDays($endDate) > 0){
				return $row->created_date = $startDate->diffInDays($endDate).' days ago';
			}
			
		});	
			
        return $documents;
    }

    public function ProjectDocumentsPackages(Request $request){
        $id = Session::get('projectID');
        $packages = $this->documentService->getAllProjectDocumentsPackages($id , $request); 
		$packages->map(function($row){
			$startDate = Carbon::parse($row->created_at);
            $endDate = Carbon::now(); // أفضل من date('Y-m-d') لأنه يضمن تنسيق Carbon

            if ($startDate->diffInDays($endDate) > 0) {
                $daysAgo = $startDate->diffInDays($endDate);
                return  $row->created_date = (int)$daysAgo . ' days ago';
            }
			
		});	
			
        return $packages;  
    }

    public function ProjectDocumentsPackage(Request $request , $id){
        $package_detail = $this->documentService->getPackage($id , $request);
       // return $package;
        	$package_detail->subFolders->map(function($row){
			$startDate = Carbon::parse($row->created_at);
            $endDate = Carbon::now(); // أفضل من date('Y-m-d') لأنه يضمن تنسيق Carbon

            if ($startDate->diffInDays($endDate) > 0) {
                $daysAgo = $startDate->diffInDays($endDate);
                return  $row->created_date = (int)$daysAgo . ' days ago';
            }
			
		});	
        //return $package;
        return view('metsl.pages.documents.package', compact('package_detail'));
    }

    public function ProjectDocumentsPackageSubfolder(Request $request , $id){
        $package_subfolder = $this->documentService->getSubFolder($id , $request);
        $package_detail = $this->documentService->getPackage($package_subfolder->id , $request);
        //return $package_subfolder;
        return view('metsl.pages.documents.package_subfolder', compact('package_subfolder','package_detail'));
    }


        public function ProjectDocumentsPackageSubfolders(Request $request , $id){
        $package = $this->documentService->getPackage($id , $request);
       // return $package;
        	$package->subFolders->map(function($row){
			$startDate = Carbon::parse($row->created_at);
            $endDate = Carbon::now(); // أفضل من date('Y-m-d') لأنه يضمن تنسيق Carbon

            if ($startDate->diffInDays($endDate) > 0) {
                $daysAgo = $startDate->diffInDays($endDate);
                return  $row->created_date = (int)$daysAgo . ' days ago';
            }
			
		});	
        //return $package;
        return $package->subFolders;
    }

    public function ProjectDocumentsAssigned(Request $request){
        $id = Session::get('projectID');
        $documents = $this->documentService->getAllProjectDocumentsAssigned($id , $request); 
		$documents->map(function($row){
			$startDate = Carbon::parse($row->created_date);

			$endDate = Carbon::parse(date('Y-m-d'));
			if($startDate->diffInDays($endDate) > 0){
				return $row->created_date = $startDate->diffInDays($endDate).' days ago';
			}
			
		});	
			
        return response()->json($documents);
    }

    public function edit($document_id){
        $detail =  $this->documentService->getDetailOfDocument($document_id);
 
        return $detail;
        
    }

    public function update(DocumentRequest  $request)
    {
        if($request->validated()){
            \DB::beginTransaction();
            try{
                $all_data = request()->all();
               // $all_data['created_by'] = \Auth::user()->id;

                //$all_data['created_date'] = date('Y-m-d');

                $model = $this->documentService->update($all_data);
            \DB::commit();
            // all good
            } catch (\Exception $e) {
                \DB::rollback();
                return response()->json(['error' => $e->getMessage()]);
            }

                       
            return response()->json(['success' => 'Form submitted successfully.' , 'data'=>$model]);

        }
    }

    public function ProjectDocumentsRevisions($document_id){
        $revisions =  $this->projectDocumentRevisionsService->getRevisionsOfDocument($document_id);
        $revisions->map(function($row){			
            $row->status_text = $row->status->text();
            $row->color = $row->status->color();
            $row->hover = $row->status->hover();
            $row->dataFeather = $row->status->dataFeather();
           // dd($row->ProjectDocument->project);
           if($row->file != NULL){
            $row->file = Storage::url('project'.$row->project->id.'/documents'.$row->project_document_id.'/revisions/'.$row->file);
            $row->preview_image = Storage::url('project'.$row->project->id.'/documents'.$row->project_document_id.'/revisions/'.$row->preview_image);

           }
            return $row;
	
			
		});	
        return $revisions;
        
    }

    public function delete($id){
        $this->documentService->delete($id);
        
    }
    public function delete_file($id){
        $this->projectDocumentFilesService->delete($id);
    }

    public function store_package(PackageRequest  $request)
    {
        if($request->validated()){
            \DB::beginTransaction();
            try{
                $all_data = request()->all();
                $package = \App\Models\Package::create($all_data);  
                $package->assignees()->sync($all_data['accessibles']);         
            \DB::commit();            
            } catch (\Exception $e) {
                \DB::rollback();
                return response()->json(['error' => $e->getMessage()]);
            }
        
            return response()->json(['success' => 'Form submitted successfully.' , 'data'=>$package]);

        }
    }
    
    public function store_subfolder(SubFolderRequest  $request){
       if($request->validated()){
            \DB::beginTransaction();
            try{
                $all_data = request()->all();
                $package = \App\Models\PackageSubFolders::create($all_data);  
            \DB::commit();            
            } catch (\Exception $e) {
                \DB::rollback();
                return response()->json(['error' => $e->getMessage()]);
            }
        
            return response()->json(['success' => 'Form submitted successfully.' , 'data'=>$package]);

        }
    }
    
    public function update_status(Request $request){
        return $this->documentService->updateStatus($request->id , $request->status);
    }

}