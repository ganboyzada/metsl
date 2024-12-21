<?php

namespace App\Http\Controllers;

use App\Enums\CorrespondenceStatusEnum;
use App\Enums\RevisionStatusEnum;
use App\Http\Requests\CorrespondenceRequest;
use App\Http\Requests\DocumentRequest;
use App\Services\ClientService;
use App\Services\ContractorService;
use App\Services\DesignTeamService;
use App\Services\DocumentService;
use App\Services\ProjectDocumentRevisionsService;
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
        protected ProjectDocumentRevisionsService $projectDocumentRevisionsService

        )
    {
    }



    public function store(DocumentRequest  $request)
    {
        if($request->validated()){
            \DB::beginTransaction();
            try{
                $all_data = request()->all();
                $all_data['created_by'] = \Auth::user()->id;

                $all_data['created_date'] = date('Y-m-d');

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
            $reviewers = $this->userService->getUsersOfProjectID($id , 'review documents');
			
            $users = $reviewers['users'];

            return ['users'=>$users];
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

    public function ProjectDocumentsRevisions($document_id){
        $revisions =  $this->projectDocumentRevisionsService->getRevisionsOfDocument($document_id);
        $revisions->map(function($row){			
            $row->status_text = $row->status->text();
            $row->color = $row->status->color();
            $row->hover = $row->status->hover();
            $row->dataFeather = $row->status->dataFeather();
           // dd($row->ProjectDocument->project);
            $row->file = Storage::url('project'.$row->project->id.'/documents'.$row->project_document_id.'/revisions/'.$row->file);
            return $row;
	
			
		});	
        return $revisions;
        
    }

}