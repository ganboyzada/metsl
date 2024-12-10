<?php

namespace App\Repository\Eloquent;

use App\Mail\StakholderEmail;
use App\Models\Permission;
use App\Models\MeetingPlan;
use App\Models\ProjectDocumentFiles;
use App\Models\ProjectDocumentRevisions;
use App\Models\Role;
use App\Models\User;
use App\Repository\MeetingPlaningRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
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
    * @return Collection
    * 
    */
    public function get_all_project_meeting_planing($project_id , $request): Collection{
        $data = $request->all();
        if( $data['end_date'] == ''){
         
            $data['end_date'] = date_format(\Carbon\Carbon::today(), 'Y-m-d');
        }
        $meetingPlanings =  $this->model->where('project_id',$project_id)
        ->where(function($searchquery) use($data){
                $searchquery->where(function($searchquery2) use($data){
                    $searchquery2->when($data['search'] , function($query) use($data){
                        $query->where(function($q) use($data){
                            $q->whereAny(
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
                        });  
                        
                        $query->orWhereHas('users',function($q)use($data){
                            $q->where('name', 'LIKE', "%".$data['search']."%");
                        });

                    });

                });

                $searchquery->orwhere(function($searchquery2) use($data){
                    $searchquery2->when($data['start_date'] , function($query) use($data){
                        $query->where(function($q) use($data){
            
                        $q->orwhereBetween('start_time', [$data['start_date'], $data['end_date']]);
            
                    });
                });
            });    
        })->with(['users:id,name'])->get();
  
      return $meetingPlanings;
    }

    
  
 
}