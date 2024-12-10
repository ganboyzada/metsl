<?php

namespace App\Http\Controllers;

use App\Enums\CorrespondenceStatusEnum;
use App\Enums\RevisionStatusEnum;
use App\Http\Requests\CorrespondenceRequest;
use App\Http\Requests\DocumentRevisionRequest;
use App\Http\Requests\RevisionRequest;
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

class DocumentRevisionController extends Controller
{
    public function __construct(
        protected ProjectDocumentRevisionsService $documentRevisionService
        )
    {
    }

    public function store(DocumentRevisionRequest  $request)
    {
        if($request->validated()){
            \DB::beginTransaction();
            try{
                $all_data = request()->all();
                $all_data['user_id'] = \Auth::user()->id;
                $all['project_id'] = Session::get('projectID');
                $all_data['upload_date'] = date('Y-m-d');
                $model = $this->documentRevisionService->create($all_data);
            \DB::commit();
            // all good
            } catch (\Exception $e) {
                \DB::rollback();
                return response()->json(['error' => $e->getMessage()]);
            }

                       
            return response()->json(['success' => 'Form submitted successfully.' , 'data'=>$model]);

        }
    }

    
    public function store_comment(RevisionRequest  $request)
    {
        if($request->validated()){
            \DB::beginTransaction();
            try{
                $all_data = request()->all();
                $all_data['user_id'] = \Auth::user()->id;

                $all_data['created_date'] = date('Y-m-d');

                $model = $this->documentRevisionService->createComment($all_data);
            \DB::commit();
            // all good
            } catch (\Exception $e) {
                \DB::rollback();
                return response()->json(['error' => $e->getMessage()]);
            }

                       
            return response()->json(['success' => 'Form submitted successfully.' , 'data'=>$model]);

        }
    }

    public function revisionComments($revision_id){
        return $this->documentRevisionService->getRevisionComments($revision_id);
    }

    public function update_status(Request $request){
        return $this->documentRevisionService->updateStatus($request->id , $request->status);
    }


    

}

?>