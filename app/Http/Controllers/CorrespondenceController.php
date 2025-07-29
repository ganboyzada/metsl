<?php

namespace App\Http\Controllers;

use App\Enums\CorrespondenceStatusEnum;
use App\Http\Requests\CorrespondenceReject;
use App\Http\Requests\CorrespondenceRequest;
use App\Http\Requests\ProjectRequest;
use App\Http\Requests\UserRequest;
use App\Models\Contractor;
use App\Models\Permission;
use App\Models\Project;
use App\Models\Role;
use App\Models\User;
use App\Services\ClientService;
use App\Services\CompanyService;
use App\Services\ContractorService;
use App\Services\CorrespondenceFileService;
use App\Services\CorrespondenceService;
use App\Services\DesignTeamService;
use App\Services\ProjectDocumentFilesService;
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


class CorrespondenceController extends Controller
{
    public function __construct(
        protected ProjectService $projectService , 
        protected ContractorService $contractorService ,
        protected ClientService $clientService ,
        protected DesignTeamService $designTeamService ,
        protected ProjectManagerService $projectmanagerService ,
        protected UserService $userService,
        protected CorrespondenceService $correspondenceService,
        protected CorrespondenceFileService $correspondenceFileService,
        protected ProjectDocumentFilesService $projectDocumentFilesService
       

        )
    {
    }



    public function create(Request $request){
        if (Session::has('projectID') && Session::has('projectName')){
            $id = Session::get('projectID');
            $type = $request->type;
            
            
           // return $related_correpondence;
            $reply_child_correspondence_id = NULL;



            $reply_correspondence_id = $request->correspondece ?? NULL;
            if($reply_correspondence_id != NULL){
                $this_correpondence = $this->correspondenceService->edit($request->correspondece);
                if(isset($this_correpondence->id) && $this_correpondence->reply_correspondence_id != NULL){
                    $reply_correspondence_id = $this_correpondence->reply_correspondence_id;
                    $reply_child_correspondence_id = $this_correpondence->id;                    
                }
                $reply_correspondence = $this->correspondenceService->edit($reply_correspondence_id);
                //dd($reply_correspondence->assignees()->pluck('users.id')->toArray());
                //return $reply_correspondence;

            }
            if($reply_child_correspondence_id == NULL){
                $last_reply_correspondence = $this->correspondenceService->getLastReplyCorrespondence($id , $reply_correspondence_id);
                if(isset($last_reply_correspondence->id)){
                    $reply_child_correspondence_id = $last_reply_correspondence->id;
                }
            }


            $related_correpondences = $this->correspondenceService->allCorrespondenceExceptNCR($id , $reply_correspondence_id);
          //  $next_number =  $this->correspondenceService->getNextNumber($type , $id);
          $files = $this->projectDocumentFilesService->getNewestFilesByProjectId( $id);

        }
        
        return view('metsl.pages.correspondence.create', get_defined_vars());
    }

    public function store(CorrespondenceRequest  $request)
    {
        if($request->validated()){
            \DB::beginTransaction();
            try{
                $all_data = request()->all();
                $all_data['created_by'] = \Auth::user()->id;
                $all_data['due_date'] = Carbon::now()->addDays((int)$all_data['due_days'])->toDateString();

                $all_data['created_date'] = date('Y-m-d');
                if($all_data['reply_correspondence_id'] == NULL){
                    $all_data['number'] =  $this->correspondenceService->getNextNumber($all_data['type'] , Session::get('projectID'));

                }else{
                    $old = $this->correspondenceService->edit($all_data['reply_correspondence_id']);
                    $all_data['number'] =  'Replying to '.$old->number??'';
                    $all_data['status'] =  $old->status;
                    $all_data['changed_by'] = $old->changed_by??NULL;
                    $all_data['due_days'] =  $old->due_days??5;
                    $all_data['due_date'] =  $old->due_date??NULL;
                    $all_data['assignees'] = $old->assignees()->pluck('users.id')->toArray();
                    $all_data['distribution'] = $old->distributionMembers()->pluck('users.id')->toArray();
                    if($all_data['reply_child_correspondence_id']   == NULL){
                        $all_data['reply_child_correspondence_id'] = $all_data['reply_correspondence_id'];
                    }
                    
                }
               // dd($all_data);
                $model = $this->correspondenceService->create($all_data);
                if($all_data['reply_correspondence_id'] != NULL && $old->first_reply_date == NULL){
                    $old->first_reply_date = Carbon::now()->toDateString();
                    $old->save();
                }





                // if($all_data['reply_correspondence_id'] != NULL){
                //     $new_data['id'] = $all_data['reply_correspondence_id'];
                //     $new_data['status'] = $all_data['status'];
                //     $new_data['project_id'] = $all_data['project_id'];
                //     $this->correspondenceService->update_status($new_data);
                // }

            \DB::commit();
            // all good
            } catch (\Exception $e) {
                \DB::rollback();
                return response()->json(['error' => $e->getMessage()]);
            }

                       
            return response()->json(['success' => 'Form submitted successfully.' , 'data'=>$model]);

        }
    }

    public function close($id){
        $correspondece = $this->correspondenceService->close($id);
    }

    public function accept($id){
        $correspondece = $this->correspondenceService->accept($id);
    }
    public function reject(CorrespondenceReject  $request){
       $correspondece = $this->correspondenceService->reject($request);
       return response()->json(['success' => 'Form submitted successfully.' , 'data'=>$this->correspondenceService->edit($request->id)]);
    }

    public function delay(Request $request){
        $correspondece = $this->correspondenceService->edit($request->id);
        $correspondece->due_date = date('Y-m-d', strtotime($correspondece->due_date. ' + '.(int)$request->due_days.' days'));
        $correspondece->due_days = $correspondece->due_days + (int)$request->due_days;
        $correspondece->save();
       // dd($this->correspondenceService->edit($request->id));
        $correspondece = $this->correspondenceService->updateDueDays($request);

        return response()->json(['success' => 'Form submitted successfully.' , 'data'=>$correspondece]);

    }
    public function edit($id){
        $correspondece = $this->correspondenceService->edit($id);
          $files = $this->projectDocumentFilesService->getNewestFilesByProjectId( Session::get('projectID'));

        return view('metsl.pages.correspondence.edit', get_defined_vars());

    }

    public function update(CorrespondenceRequest  $request)
    {
        if($request->validated()){
            \DB::beginTransaction();
            try{
                $all_data = request()->all();
               // $all_data['created_by'] = \Auth::user()->id;

                //$all_data['created_date'] = date('Y-m-d');

                $model = $this->correspondenceService->update($all_data);
            \DB::commit();
            // all good
            } catch (\Exception $e) {
                \DB::rollback();
                return response()->json(['error' => $e->getMessage()]);
            }

                       
            return response()->json(['success' => 'Form submitted successfully.' , 'data'=>$model]);

        }
    }

    public function getUsers(Request $request){
        if (Session::has('projectID') && Session::has('projectName')){
            $id = Session::get('projectID');     
			$all = $this->userService->getUsersOfProjectID($id , '');
            $assigness = $this->userService->getUsersOfProjectID($id , 'reply_'.$request->type);
			$distributions = $this->userService->getUsersOfProjectID($id , 'distribution_members_correspondence');
			
            $assigned_users = $assigness['users'];
            $destrbution_users = $distributions['users'];
            $users = $all['users'];
            $id = Session::get('projectID');
            $next_number =  $this->correspondenceService->getNextNumber($request->type , $id);
            return ['assigned_users'=>$assigned_users , 'destrbution_users'=>$destrbution_users , 'users'=>$users , 'next_number'=>$next_number];
        }

    }


    public function ProjectCorrespondence(Request $request){
        $id = session('projectID');
        //dd(session('projectID'));
        $correspondeces = $this->correspondenceService->getAllProjectCorrespondence($id , $request);
        // $correspondeces->map(function($row){
        //     return $row->status_color = [CorrespondenceStatusEnum::from($row->status) , CorrespondenceStatusEnum::from($row->status)->color()];
        // });

            $correspondeces->map(function($row){
            $row->status_color = [CorrespondenceStatusEnum::from($row->status) , CorrespondenceStatusEnum::from($row->status)->text_color()];
            $status_value = $row->status_color[0]->value;
            $dueDate = Carbon::parse($row->due_date); // example due date
            $first_reply_date = Carbon::parse($row->first_reply_date)??Carbon::now();
                
            // Compare dates
            if ($first_reply_date != NULL &&$first_reply_date->greaterThan($dueDate)) {
                $diff = $first_reply_date->diffInDays($dueDate);
                $st = $row->first_reply_date == NULL ? '(NO Replies)' : '' ;

                $row->label = "<span class='text-xs font-bold text-red-500 '>  ".(INT)($diff)." </span>";
                if($row->status == CorrespondenceStatusEnum::OPEN->value){
                    $row->label2 = "<span class=' text-xs font-bold text-red-500 '>Open</span>";
                }else{
                    $row->label2 = "<span class=' text-xs font-bold ".$row->status_color[1]."  '>".$row->status_color[0]->value."</span>";

                }
            } else if($first_reply_date != NULL) {
                $diff = $first_reply_date->diffInDays($dueDate);
                $st = $row->first_reply_date == NULL ? '(NO Replies)' : '' ;
                if($diff == 0){
                    $diff = $first_reply_date->diffInDays($dueDate);
                    $row->label = "<span class=' text-xs font-bold text-orange-500'>  ".(INT)$diff."  </span>";
                    $row->label2 = "<span class=' text-xs font-bold ".$row->status_color[1]."  '>".$row->status_color[0]->value."</span>";


                }else{
                    $diff = $first_reply_date->diffInDays($dueDate);
                    $row->label = "<span class='text-xs font-bold text-green-500'>  ".(INT)($diff)."  </span>";
                    $row->label2 = "<span class=' text-xs font-bold  ".$row->status_color[1]."  '>".$row->status_color[0]->value."</span>";


                }
                
            }
            
            return $row;
        });    
        return $correspondeces;
    }

    public function ProjectCorrespondenceOpen(Request $request){
        $id = Session::get('projectID');
        //dd($id);
        $correspondeces = $this->correspondenceService->getAllProjectCorrespondenceOpen($id , $request);
        $correspondeces->map(function($row){
            $row->status_color = [CorrespondenceStatusEnum::from($row->status) , CorrespondenceStatusEnum::from($row->status)->color()];
        
               $dueDate = Carbon::parse($row->due_date); // example due date
            $today = Carbon::today();

            // Compare dates
            if ($today->greaterThan($dueDate)) {
                $diff = $today->diffInDays($dueDate);
                $row->label = "<span class='px-3 py-1 rounded-full text-xs font-bold bg-red-500 text-white'>  ".($diff)." </span>";
                if($row->status == CorrespondenceStatusEnum::OPEN->value){
                    $row->label2 = "<span class='px-3 py-1 rounded-full text-xs font-bold bg-red-500 text-white'>Open</span>";
                }else{
                    $row->label2 = "<span class='px-3 py-1 rounded-full text-xs font-bold ".$row->status_color[1]."  '>".$row->status_color[0]->value."</span>";

                }
            } else {
                $diff = $today->diffInDays($dueDate);
                if($diff == 0){
                    $diff = $today->diffInDays($dueDate);
                    $row->label = "<span class='px-3 py-1 rounded-full text-xs font-bold bg-orange-500 text-white'>  ".$diff." </span>";
                    $row->label2 = "<span class='px-3 py-1 rounded-full text-xs font-bold ".$row->status_color[1]."  '>".$row->status_color[0]->value."</span>";


                }else{
                    $diff = $today->diffInDays($dueDate);
                    $row->label = "<span class='px-3 py-1 rounded-full text-xs font-bold bg-green-500 text-white'>  ".($diff)." </span>";
                    $row->label2 = "<span class='px-3 py-1 rounded-full text-xs font-bold  ".$row->status_color[1]."  '>".$row->status_color[0]->value."</span>";


                }
                
            }
            
            return $row;
        });
     
  

        //return $correspondeces;
        return response()->json($correspondeces);
        
    }

    public function find($id){
        $correspondece = $this->correspondenceService->find($id);
        //dd($correspondece->reply_child_correspondence_id );
        if($correspondece->reply_correspondence_id == NULL){
            $others_correspondeces_realated = $this->correspondenceService->getCorrespondenceReplies($correspondece->project_id , $correspondece->id)->map(function($row){
                $row->status_color = [CorrespondenceStatusEnum::from($row->status) , CorrespondenceStatusEnum::from($row->status)->color()];
                return $row;
            });
        }else{
            if($correspondece->reply_child_correspondence_id == $correspondece->reply_correspondence_id){
                $others_correspondeces_realated = $this->correspondenceService->getCorrespondenceParent($correspondece->project_id , $correspondece->reply_correspondence_id)->map(function($row){
                    $row->status_color = [CorrespondenceStatusEnum::from($row->status) , CorrespondenceStatusEnum::from($row->status)->color()];
                    return $row;
                });

            }else{
                $others_correspondeces_realated = $this->correspondenceService->getCorrespondenceParent($correspondece->project_id , $correspondece->reply_child_correspondence_id)->map(function($row){
                    $row->status_color = [CorrespondenceStatusEnum::from($row->status) , CorrespondenceStatusEnum::from($row->status)->color()];
                    return $row;
                });
            }


        }
        //dd($correspondece);
        return view('metsl.pages.correspondence.view', get_defined_vars());

    }

    
    public function destroy($id){
        $this->correspondenceService->delete($id);
        
    }
    public function destroyFile($id){
        $this->correspondenceFileService->delete($id);
        return redirect()->back()->with('success' , 'Item deleted successfully');
    }
}