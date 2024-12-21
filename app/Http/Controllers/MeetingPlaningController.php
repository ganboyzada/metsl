<?php

namespace App\Http\Controllers;

use App\Enums\CorrespondenceStatusEnum;
use App\Enums\RevisionStatusEnum;
use App\Http\Requests\CorrespondenceRequest;
use App\Http\Requests\DocumentRequest;
use App\Http\Requests\MeetingPlaningRequest;
use App\Services\ClientService;
use App\Services\ContractorService;
use App\Services\DesignTeamService;
use App\Services\DocumentService;
use App\Services\MeetingPlaningFilesService;
use App\Services\MeetingPlaningService;
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


class MeetingPlaningController extends Controller
{
    public function __construct(

        protected MeetingPlaningService $meetingPlaningService,
        protected userService $userService,
        protected MeetingPlaningFilesService $meetingPlaningFilesService

        )
    {
    }

    public function create(){
        return view('metsl.pages.meeting-minutes.create');
    }

    public function store(MeetingPlaningRequest  $request)
    {

        if($request->validated()){
            \DB::beginTransaction();
            try{
                $all_data = request()->all();
                $all_data['created_by'] = \Auth::user()->id;

                $all_data['project_id'] = Session::get('projectID');

                $model = $this->meetingPlaningService->create($all_data);
            \DB::commit();
            // all good
            } catch (\Exception $e) {
                \DB::rollback();
                return response()->json(['error' => $e->getMessage()]);
            }

                       
            return response()->json(['success' => 'Form submitted successfully.' , 'data'=>$model]);

        }
    }

    public function edit($id){
        $meeting_id = $id;
        $meeting = $this->meetingPlaningService->find($meeting_id);
        /*$distribution_members = $this->userService->getUsersOfProjectID(Session::get('projectID') , '');
        $responsible = $this->userService->getUsersOfProjectID(Session::get('projectID') , '');
        
        $distribution_members = $distribution_members['users'];
        $responsible = $responsible['users'];*/
      // return $punch_list;
        return view('metsl.pages.meeting-minutes.edit', get_defined_vars());
    }

    public function update(MeetingPlaningRequest  $request)
    {

        if($request->validated()){
            \DB::beginTransaction();
            try{
                $all_data = request()->all();
                //$all_data['created_by'] = \Auth::user()->id;

                //$all_data['project_id'] = Session::get('projectID');

                $model = $this->meetingPlaningService->update($all_data);
            \DB::commit();
            // all good
            } catch (\Exception $e) {
                \DB::rollback();
                return response()->json(['error' => $e->getMessage()]);
            }

                       
            return response()->json(['success' => 'Form submitted successfully.' , 'data'=>$model]);

        }
    }

    public function getParticipates(Request $request){
        if (Session::has('projectID') && Session::has('projectName')){
            $id = Session::get('projectID');     
            $next_number =  $this->meetingPlaningService->getNextNumber($id);

            $reviewers = $this->userService->getUsersOfProjectID($id , '');
			
            $users = $reviewers['users'];

            return ['users'=>$users , 'next_number'=>$next_number];
        }

    }


    public function ProjectMeeetings(Request $request){
        $id = Session::get('projectID');
        $meetingPlanings = $this->meetingPlaningService->getAllProjectMeetingPlaning($id , $request);
        $meetingPlanings->map(function($row){

            $row->status_text = $row->status->text();
            $row->color = $row->status->color();
            return $row;
        });
     
        return $meetingPlanings;
    }

    public function destroy($id){
        $this->meetingPlaningService->delete($id);
        
    }
    public function destroyFile($id){
        $this->meetingPlaningFilesService->delete($id);
        return redirect()->back()->with('success' , 'Item deleted successfully');
    }

}