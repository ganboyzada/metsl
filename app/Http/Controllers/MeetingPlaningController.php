<?php

namespace App\Http\Controllers;

use App\Enums\CorrespondenceStatusEnum;
use App\Enums\MeetingPlanStatusEnum;
use App\Enums\RevisionStatusEnum;
use App\Http\Requests\CorrespondenceRequest;
use App\Http\Requests\DocumentRequest;
use App\Http\Requests\MeetingPlaningRequest;
use App\Http\Requests\TypeRequest;
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
use Barryvdh\DomPDF\Facade\Pdf;


class MeetingPlaningController extends Controller
{
    public function __construct(

        protected MeetingPlaningService $meetingPlaningService,
        protected userService $userService,
        protected MeetingPlaningFilesService $meetingPlaningFilesService

        )
    {
    }


    public function downloadPdf($id){

        $meeting_id = $id;
        $meeting = $this->meetingPlaningService->find($meeting_id);
       // return $meeting;

        $planned_date = $meeting->planned_date;
        $start_time = $meeting->start_time;
        $duration_minutes = (int)$meeting->duration; // Duration as an integer

        $meeting_start = Carbon::createFromFormat('Y-m-d H:i:s', $planned_date.' '.$start_time);
        $meeting_end = $meeting_start->copy()->addMinutes($duration_minutes);
        $now = Carbon::now();

        //dd($meeting_start.'-'.$meeting_end.'-'.$now);
        // Determine meeting status dynamically
        $meeting->old_status = $meeting->status ;
        $meeting_status = null;
        //dd($meeting->status);
        //dd($now->between($meeting_start, $meeting_end));
        if ($now->lessThan($meeting_start) && $meeting->status->value == MeetingPlanStatusEnum::PLANNED->value) {
            $meeting_status = MeetingPlanStatusEnum::PLANNED;
        } elseif ($now->between($meeting_start, $meeting_end) && $meeting->status->value == MeetingPlanStatusEnum::PLANNED->value) {
            $meeting_status = MeetingPlanStatusEnum::ONGOING;
        } elseif ($now->greaterThan($meeting_end) ||  $meeting->status->value == MeetingPlanStatusEnum::PUBLISHED->value) {
            $meeting_status = MeetingPlanStatusEnum::PUBLISHED;
        }



        //dd($meeting_status);
        $meeting->status = $meeting_status ;


        //return $meeting;
        $reviewers = $this->userService->getUsersOfProjectID($meeting->project_id , 'participate_in_meetings');


    $pdf = Pdf::loadView('metsl.pages.meeting-minutes.pdf', compact('meeting','reviewers'));
    return $pdf->download('meeting_'.$id.'.pdf');
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

        $planned_date = $meeting->planned_date;
        $start_time = $meeting->start_time;
        $duration_minutes = (int)$meeting->duration; // Duration as an integer

        $meeting_start = Carbon::createFromFormat('Y-m-d H:i:s', $planned_date.' '.$start_time);
        $meeting_end = $meeting_start->copy()->addMinutes($duration_minutes);
        $now = Carbon::now();

        //dd($meeting_start.'-'.$meeting_end.'-'.$now);
        // Determine meeting status dynamically
        $meeting->old_status = $meeting->status ;
        $meeting_status = null;
        //dd($meeting->status);
        //dd($now->between($meeting_start, $meeting_end));
        if ($now->lessThan($meeting_start) && $meeting->status->value == MeetingPlanStatusEnum::PLANNED->value) {
            $meeting_status = MeetingPlanStatusEnum::PLANNED;
        } elseif ($now->between($meeting_start, $meeting_end) && $meeting->status->value == MeetingPlanStatusEnum::PLANNED->value) {
            $meeting_status = MeetingPlanStatusEnum::ONGOING;
        } elseif ($now->greaterThan($meeting_end) ||  $meeting->status->value == MeetingPlanStatusEnum::PUBLISHED->value) {
            $meeting_status = MeetingPlanStatusEnum::PUBLISHED;
        }



        //dd($meeting_status);
        $meeting->status = $meeting_status ;


        //return $meeting;
        $reviewers = $this->userService->getUsersOfProjectID($meeting->project_id , 'participate_in_meetings');
			
        $users = $reviewers['users'];
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
           // $next_number =  $this->meetingPlaningService->getNextNumber($id);

            $reviewers = $this->userService->getUsersOfProjectID($id , 'participate_in_meetings');
			
            $users = $reviewers['users'];

            return ['users'=>$users ];
        }

    }


    public function ProjectMeeetings(Request $request){
        $id = Session::get('projectID');
        $meetingPlanings = $this->meetingPlaningService->getAllProjectMeetingPlaning($id , $request);
        $meetingPlanings->map(function($row){

            $planned_date = $row->planned_date;
            $start_time = $row->start_time;
            $duration_minutes = (int)$row->duration; // Duration as an integer
    
            $meeting_start = Carbon::createFromFormat('Y-m-d H:i:s', $planned_date.' '.$start_time);
            $meeting_end = $meeting_start->copy()->addMinutes($duration_minutes);
            $now = Carbon::now();
    
            //dd($meeting_start.'-'.$meeting_end.'-'.$now);
            // Determine meeting status dynamically
            $meeting_status = null;

    
            if ($now->lessThan($meeting_start) && $row->status->value == MeetingPlanStatusEnum::PLANNED->value) {
                $meeting_status = MeetingPlanStatusEnum::PLANNED;
            } elseif ($now->between($meeting_start, $meeting_end) && $row->status->value == MeetingPlanStatusEnum::PLANNED->value) {
                $meeting_status = MeetingPlanStatusEnum::ONGOING;
            } elseif ($now->greaterThan($meeting_end) ||  $row->status->value == MeetingPlanStatusEnum::PUBLISHED->value) {
                $meeting_status = MeetingPlanStatusEnum::PUBLISHED;
            }  
            $row->status_text = ($meeting_status->name == 'PUBLISHED' && $row->status->value == MeetingPlanStatusEnum::PLANNED->value )? ' Ready To '.$meeting_status->text() : $meeting_status->text();
            $row->color = $meeting_status->color();

            $row->status = $meeting_status ;
            return $row;
        });
     
        return $meetingPlanings;
    }



    public function ProjectMeeetingsHasActions(Request $request){
        $id = Session::get('projectID');
        $meetingPlanings = $this->meetingPlaningService->getAllProjectMeetingActions($id , $request);
        $meetingPlanings->map(function($row){

            $planned_date = $row->planned_date;
            $start_time = $row->start_time;
            $duration_minutes = (int)$row->duration; // Duration as an integer
    
            $meeting_start = Carbon::createFromFormat('Y-m-d H:i:s', $planned_date.' '.$start_time);
            $meeting_end = $meeting_start->copy()->addMinutes($duration_minutes);
            $now = Carbon::now();
    
            //dd($meeting_start.'-'.$meeting_end.'-'.$now);
            // Determine meeting status dynamically
            $meeting_status = null;

    
            if ($now->lessThan($meeting_start) && $row->status->value == MeetingPlanStatusEnum::PLANNED->value) {
                $meeting_status = MeetingPlanStatusEnum::PLANNED;
            } elseif ($now->between($meeting_start, $meeting_end) && $row->status->value == MeetingPlanStatusEnum::PLANNED->value) {
                $meeting_status = MeetingPlanStatusEnum::ONGOING;
            } elseif ($now->greaterThan($meeting_end) ||  $row->status->value == MeetingPlanStatusEnum::PUBLISHED->value) {
                $meeting_status = MeetingPlanStatusEnum::PUBLISHED;
            }  
            $row->status_text = ($meeting_status->name == 'PUBLISHED' && $row->status->value == MeetingPlanStatusEnum::PLANNED->value )? ' Ready To '.$meeting_status->text() : $meeting_status->text();
            $row->color = $meeting_status->color();

            $row->status = $meeting_status ;
            return $row;
        });
     
        return response()->json($meetingPlanings);
    }

    public function destroy($id){
        $this->meetingPlaningService->delete($id);
        
    }
    public function destroyFile($id){
        $this->meetingPlaningFilesService->delete($id);
        return redirect()->back()->with('success' , 'Item deleted successfully');
    }


    public function store_type(TypeRequest  $request)
    {
        if($request->validated()){
            \DB::beginTransaction();
            try{
                $all_data = request()->all();
                $type = \App\Models\MeetingTypes::create($all_data);  
                         
            \DB::commit();            
            } catch (\Exception $e) {
                \DB::rollback();
                return response()->json(['error' => $e->getMessage()]);
            }
        
            return response()->json(['success' => 'Form submitted successfully.' , 'data'=>$type]);

        }
    }  

    public function store_notes(){

        $data = request()->all();

        $all_data = [];
        $meeting = \App\Models\MeetingPlan::find($data['meeting_id']);
        $meeting->notes()->delete();
        
        if(count($data['note']) > 0){
           
            foreach($data['note'] as $index=>$note){
                $insert_arr = [];
                $insert_arr['note'] = $note; 
                $insert_arr['type'] = isset($data['type'][$index]) ? 'action' : 'note';
                $insert_arr['assign_user_id'] = $data['assign_user_id'][$index]; 
                $insert_arr['deadline'] = $data['deadline'][$index]; 
                $insert_arr['created_by'] = \Auth::user()->id; 
                $insert_arr['created_date'] = date('Y-m-d'); 
                $insert_arr['meeting_id'] = $data['meeting_id'];
                $all_data[]=$insert_arr;
            }
        }

        \App\Models\MeetingPlanNotes::insert($all_data);
        if(count($data['note']) > 0 && $data['status']== MeetingPlanStatusEnum::PUBLISHED->value){
           // dd(MeetingPlanStatusEnum::PUBLISHED->value);
            $meeting->status = MeetingPlanStatusEnum::PUBLISHED->value;
            $meeting->save();
        }
        return response()->json(['success' => 'Form submitted successfully.']);
    }

}