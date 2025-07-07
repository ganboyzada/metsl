<?php

namespace App\Repository\Eloquent;

use App\Enums\MeetingPlanStatusEnum;
use App\Mail\StakholderEmail;
use App\Models\MeetingPlan;
use App\Models\Permission;
use App\Models\ProjectDocumentFiles;
use App\Models\ProjectDocumentRevisions;
use App\Models\Role;
use App\Models\User;
use App\Repository\MeetingPlaningRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class MeetingPlaningRepository extends BaseRepository implements MeetingPlaningRepositoryInterface
{

   /**
    * UserRepository constructor.
    *
    * @param MeetingPlan $model
    */
   public function __construct(MeetingPlan $model)
   {
       parent::__construct($model);
   }


    /**
    * @param array $data 
    * @param Model $meetingPlaning 
    * 
    */
    public function add_users_to_meeting_planing($data , $meetingPlaning)
    {
        try{
            if(!$meetingPlaning){
                throw new \Exception('Record not find'); 
            }
            //return   $meetingPlaning->users();
            $d = $meetingPlaning->users()->sync($data['participates']);
        }catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }    
    }

           /**
    * @param int $projectID 
    * @return mixed
    */
    public function get_next_number($projectID): mixed
    {
        return $this->model->where('project_id',$projectID)->count();
    } 

        /**
    * @param int $project_id 
    * @param \Request $request
    * @return LengthAwarePaginator
    * 
    */
    public function get_all_project_meeting_planing_Planned($project_id , $request): LengthAwarePaginator{

        $meetingPlanings =  $this->model->where('project_id',$project_id)
        ->where('status',MeetingPlanStatusEnum::PLANNED->value)

        ->select('meeting_plans.*');

        // if(auth()->user()->is_admin || checkIfUserHasThisPermission($project_id , 'view_all_meeting_planing')){
        //     $meetingPlanings = $meetingPlanings->with(['users:id,name'])->paginate(10);

        //     return $meetingPlanings;
        // }
        // else
         if(!auth()->user()->is_admin){

               $meetingPlanings = $meetingPlanings->where(function($q){
                    $q->whereHas('users', function ($query) {
                        $query->where('user_id', auth()->user()->id);
                    });

                   // $q->orwhere('created_by', auth()->user()->id);
                   
                });
            
            $meetingPlanings = $meetingPlanings->with(['users:id,name'])->paginate(10);

            return $meetingPlanings;  
            

        }
    }




    /**
    * @param int $project_id 
    * @param \Request $request
    * @return LengthAwarePaginator
    * 
    */
    public function get_all_project_meeting_planing_has_action_to_user($project_id , $request): LengthAwarePaginator{
        $meetingPlanings =  $this->model->join('meeting_plan_notes','meeting_plan_notes.meeting_id','=','meeting_plans.id')
        ->where('project_id',$project_id)->where('meeting_plan_notes.type','action')
        ->where('closed',0)
        //->where('status',MeetingPlanStatusEnum::PLANNED->value)
        
        ->select('meeting_plans.*','meeting_plan_notes.note', 'meeting_plan_notes.deadline', 'meeting_plan_notes.id as note_id');

          if(auth()->user()->is_admin || checkIfUserHasThisPermission($project_id , 'view_all_meeting_planing')){
            $meetingPlanings = $meetingPlanings->with(['users:id,name'])->paginate(10);

            return $meetingPlanings;
        }
        else if(!auth()->user()->is_admin){

                $meetingPlanings = $meetingPlanings->where(function($q){
                    $q->where('assign_user_id',auth()->user()->id);
                    $q->orwhere('created_by', auth()->user()->id);
                   
                });   
            

          //  $meetingPlanings = $meetingPlanings->orwhere('created_by', auth()->user()->id);         
            
            $meetingPlanings = $meetingPlanings->with(['users:id,name'])->paginate(10);

            return $meetingPlanings;  
            

        }
    }

    /**
    * @param int $project_id 
    * @param \Request $request
    * @return LengthAwarePaginator
    * 
    */
    public function get_all_project_meeting_planing($project_id , $request): LengthAwarePaginator{
        $data = $request->all();
        if( $data['end_date'] == ''){
         
            $data['end_date'] = date_format(\Carbon\Carbon::today(), 'Y-m-d');
        }
        $meetingPlanings =  $this->model->where('project_id',$project_id)

            ->when($data['search'] , function($q) use($data){
                    $q->where(function($query) use($data){
                        $query->whereAny(
                            [
                                'number',
                                'name',
                                'link',
                                'location',
                                'planned_date',
                                'purpose',
                                'start_time',
                                'duration',
                                'timezone'
                            ],
                            'LIKE',
                            "%".$data['search']."%"
                        );
                        $query->orWhereHas('users',function($q)use($data){
                            $q->where('name', 'LIKE', "%".$data['search']."%");
                        });
                    });
                        

                       
                        /*
                        $query->orWhereHas('users',function($q)use($data){
                            $q->where('name', 'LIKE', "%".$data['search']."%");
                        });
                        */

            })

            ->when($data['start_date'] , function($query) use($data){
                $query->where(function($q) use($data){
    
                $q->whereBetween('planned_date', [$data['start_date'], $data['end_date']]);
    
                });

                       
            });
            if(checkIfUserHasThisPermission($project_id , 'view_all_meeting_planing')){
                $meetingPlanings = $meetingPlanings->with(['users:id,name'])->paginate(10);
  
                return $meetingPlanings;
            }
            else if(!auth()->user()->is_admin){

                $meetingPlanings = $meetingPlanings->where(function($q){
                    $q->whereHas('users', function ($query) {
                        $query->where('user_id', auth()->user()->id);
                    });
                    $q->orwhere('created_by', auth()->user()->id);

    
                    
                });
                
    
                
                
                $meetingPlanings = $meetingPlanings->with(['users:id,name'])->paginate(10);
  
                return $meetingPlanings;  
                
    
            }



    }

    
 
}