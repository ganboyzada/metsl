<?php

namespace App\Http\Controllers;

use App\Enums\CorrespondenceStatusEnum;
use App\Enums\RevisionStatusEnum;
use App\Http\Requests\CorrespondenceRequest;
use App\Http\Requests\DrawingRequest;
use App\Http\Requests\MeetingPlaningRequest;
use App\Http\Requests\PunchListRequest;
use App\Services\ClientService;
use App\Services\ContractorService;
use App\Services\DesignTeamService;
use App\Services\DocumentService;
use App\Services\MeetingPlaningService;
use App\Services\ProjectDocumentFilesService;
use App\Services\ProjectDocumentRevisionsService;
use App\Services\ProjectDrawingsService;
use App\Services\ProjectManagerService;
use App\Services\ProjectService;
use App\Services\PunchListFilesService;
use App\Services\PunchListService;
use App\Services\UserService;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use View;


class PunchListController extends Controller
{
    public function __construct(

        protected PunchListService $punchListService,
        protected userService $userService,
        protected PunchListFilesService $punchListFilesService,
        protected ProjectDocumentFilesService $projectDocumentFilesService,
        protected ProjectDrawingsService $projectDrawingsService,
        protected ProjectService $projectService , 
   

        )
    {
    }

    public function imageUI(){
        return view('metsl.pages.punch-list.image_ui',get_defined_vars());
    }

        public function upload(Request $request)
    {
        $data = $request->input('image');
        $imageName = $request->input('name');

        $project_id = $request->input('project_id');
        $punch_list_id = $request->input('punch_list_id');

        if (preg_match('/^data:image\/(\w+);base64,/', $data, $type)) {
            $data = substr($data, strpos($data, ',') + 1);
            $type = strtolower($type[1]); // jpg, png, gif

            $imageName = pathinfo($imageName, PATHINFO_FILENAME) . '.' . $type;
            $data = base64_decode($data);

            Storage::disk('public')->put("project$project_id/punch_list$punch_list_id/$imageName", $data);

            return response()->json(['success' => true, 'filename' => $imageName]);
        }

        return response()->json(['error' => 'Invalid image data'], 400);
    }

    public function create(){
        if (Session::has('projectID') && Session::has('projectName')){
            $id = Session::get('projectID');
            $drawings = $this->projectDrawingsService->all($id);
         
          //  $next_number =  $this->correspondenceService->getNextNumber($type , $id);
          $files = $this->projectDocumentFilesService->getNewestFilesByProjectId( $id);

        }
        return view('metsl.pages.punch-list.create',get_defined_vars());
    }

    public function drawings(){
        if (Session::has('projectID') && Session::has('projectName')){
            $id = Session::get('projectID');
            $drawings = $this->projectDrawingsService->all($id);
         

          //  $next_number =  $this->correspondenceService->getNextNumber($type , $id);

        }
        return view('metsl.pages.punch-list.drawings',get_defined_vars());
    }
    

    public function edit($id){
        $punch_list_id = $id;
        $punch_list = $this->punchListService->find($punch_list_id);
      //  return $punch_list;

        /*$distribution_members = $this->userService->getUsersOfProjectID(Session::get('projectID') , '');
        $responsible = $this->userService->getUsersOfProjectID(Session::get('projectID') , '');
        
        $distribution_members = $distribution_members['users'];
        $responsible = $responsible['users'];*/
      // return $punch_list;
        return view('metsl.pages.punch-list.view', get_defined_vars());
    }


    public function view($id){
        $punch_list_id = $id;
        $punch_list = $this->punchListService->find($punch_list_id);
        /*$distribution_members = $this->userService->getUsersOfProjectID(Session::get('projectID') , '');
        $responsible = $this->userService->getUsersOfProjectID(Session::get('projectID') , '');
        
        $distribution_members = $distribution_members['users'];
        $responsible = $responsible['users'];*/
      // return $punch_list;
        return view('metsl.pages.punch-list.view', get_defined_vars());
    }

    public function store(PunchListRequest  $request)
    {


        if($request->validated()){
            \DB::beginTransaction();
            try{
                $all_data = request()->all();
               // dd($all_data);
                $all_data['created_by'] = \Auth::user()->id;
                $all_data['closed_by'] = \Auth::user()->id;

                $all_data['project_id'] = Session::get('projectID');
                $all_data['status'] = 0;
                $all_data['date_notified_at'] = date('Y-m-d');
                $model = $this->punchListService->create($all_data);
            \DB::commit();
            // all good
            } catch (\Exception $e) {
                \DB::rollback();
                return response()->json(['error' => $e->getMessage()]);
            }

                       
            return response()->json(['success' => 'Form submitted successfully.' , 'data'=>$model]);

        }
    }


    public function create_drawings(DrawingRequest  $request)
    {

        if($request->validated()){
            \DB::beginTransaction();
            try{
                $all_data = request()->all();


                $all_data['project_id'] = Session::get('projectID');

                $model = $this->projectDrawingsService->createBulkFiles($all_data['project_id'] ,$all_data['title'],$all_data['description'] ,$all_data['docs']);
            \DB::commit();
            // all good
            } catch (\Exception $e) {
                \DB::rollback();
                return response()->json(['error' => $e->getMessage()]);
            }

                       
            return response()->json(['success' => 'Form submitted successfully.' , 'data'=>$model]);

        }
    }

    public function getAllPunchListByDrawingId(Request $request , $drawing_id){
        $project_id = Session::get('projectID');
        $punchLists = $this->punchListService->getAllProjectPunchListByDrawingId($project_id , $drawing_id);
        $punchLists->map(function($row){

            $row->x = $row->pin_x;
            $row->y = $row->pin_y;

            return $row;
        });
     

        return $punchLists;

    }

    public function update(PunchListRequest  $request)
    {

        if($request->validated()){
            \DB::beginTransaction();
            try{
                $all_data = request()->all();
                //$all_data['created_by'] = \Auth::user()->id;

                //$all_data['project_id'] = Session::get('projectID');

                $model = $this->punchListService->update($all_data);
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
       // dd('ok');
        if (Session::has('projectID') && Session::has('projectName')){
            $id = Session::get('projectID');     
            $next_number =  $this->punchListService->getNextNumber($id);

            $distribution_members = $this->userService->getUsersOfProjectID($id , 'distribution_members_punch_list');
            $responsible = $this->userService->getUsersOfProjectID($id , 'responsible_punch_list');
			
            $distribution_members = $distribution_members['users'];
            $responsible = $responsible['users'];

            return ['distribution_members'=>$distribution_members, 'responsible'=>$responsible  , 'next_number'=>$next_number];
        }

    }

    public function getAllParticipates(Request $request){
        if (Session::has('projectID') && Session::has('projectName')){
            $id = Session::get('projectID');     
            $all = $this->userService->getUsersOfProjectID($id , '');             
            return ['users'=>$all['users']];
        }

    }



    public function getStatusPeriorityOption(Request $request){
        if (Session::has('projectID') && Session::has('projectName')){
            $id = Session::get('projectID');     
            $priority_list = [];           
            $statusPieChart = $this->punchListService->getStatusPieChart($id);
            $enums_list = \App\Enums\PunchListPriorityEnum::cases();
            foreach ($enums_list as $enum){
                $priority_list[] = ['label'=>$enum->name , 'value'=>$enum->value];
            }
            $status_list = [];
            $status_list_labels = [];
            $status_list_colors = [];
            $status_list_values = [];
            $enums_list = \App\Enums\PunchListStatusEnum::cases();
            foreach ($enums_list as $enum){
                $status_list[] = ['label'=>$enum->text() , 'value'=>$enum->value];
                $status_list_labels[] = $enum->text();
                $status_list_colors[] = $enum->color();
                $status_list_values[] = $statusPieChart[$enum->text()] ?? 0;

            }                 
            return ['priority'=> $priority_list, 
            'status'=> $status_list , 'status_list_labels'=>$status_list_labels , 
            'status_list_colors'=>$status_list_colors , 'statusPieChart'=>$status_list_values];
        }

    }
    public function PunchList(Request $request){
        $id = Session::get('projectID');
        $punchLists = $this->punchListService->getAllProjectPunchList($id , $request);
        $punchLists->map(function($row){

            $row->status_text = $row->status->text();
            $row->status_color = $row->status->color();

            $row->priority_text = $row->priority->color();
            return $row;
        });
     
        return $punchLists;
    }


    public function drawings_search(Request $request){
        $id = Session::get('projectID');
        $drawings = $this->projectDrawingsService->search_drawings($id , $request);
        $drawings->map(function($row){

            $row->image = Storage::url('project'.$row->project_id.'/drawings/'.$row->image);
            return $row;
        });
     
        return $drawings;
    }


    public function destroy($id){
       // dd('ok');
        $this->punchListService->delete($id);
        
    }
    public function delete_drawings($id){
        $this->projectDrawingsService->delete($id);
       // return redirect()->back()->with('success' , 'Item deleted successfully');
    }

    public function delete_assigned_drawings($punchlist_id , $id){
        try{
            $punch_list = $this->punchListService->find($punchlist_id);
            return $punch_list->drawings()->detach($id);
        }catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
        

    }
    public function destroyFile($id){
        $this->punchListFilesService->delete($id);
        return redirect()->back()->with('success' , 'Item deleted successfully');
    }

    public function store_reply(Request $request){
        $data = $request->all();
        $err = $request->validate([
            'description_reply' => 'required|string|max:255',
            'title' => 'required|',
            'punch_list_id' => 'required',
           
        ]);
        $data['created_by'] = \Auth::user()->id;
        $data['created_date'] = date('Y-m-d');
        $data['description'] = $request->description_reply;

    
        if($data['docs'] != NULL){
            $file = $data['docs'];
            $fileName = $file->getClientOriginalName();
    
            $path = Storage::disk('public')->path('project'.$data['project_id'].'/punch_list'.$data['punch_list_id'].'/replies');
                
            \File::makeDirectory($path, $mode = 0777, true, true);
    
            Storage::disk('public')->putFileAs( 'project'.$data['project_id'].'/punch_list'.$data['punch_list_id'].'/replies', $file, $fileName);
            $data['file'] = $fileName;
   
        } 
        

        //dd($err);
        $model = \App\Models\PunchlistReplies::create($data);
        return response()->json(['success' => 'Form submitted successfully.' , 'data'=>$model]);
    }

    public function change_status(Request $request){
        if($request->status == 2){
            \App\Models\PunchList::where('id',$request->id)->update(['status'=>$request->status,'date_resolved_at'=>Carbon::now()->format('Y-m-d')]);

        }else{
            \App\Models\PunchList::where('id',$request->id)->update(['status'=>$request->status]);

        }
        return response()->json(['success' => 'Form changed successfully.' ]);
    }

}