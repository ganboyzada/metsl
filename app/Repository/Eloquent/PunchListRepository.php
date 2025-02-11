<?php

namespace App\Repository\Eloquent;

use App\Mail\StakholderEmail;
use App\Models\Permission;
use App\Models\PunchList;
use App\Models\ProjectDocumentFiles;
use App\Models\ProjectDocumentRevisions;
use App\Models\Role;
use App\Models\User;
use App\Repository\PunchListRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class PunchListRepository extends BaseRepository implements PunchListRepositoryInterface
{

   /**
    * UserRepository constructor.
    *
    * @param PunchList $model
    */
   public function __construct(PunchList $model)
   {
       parent::__construct($model);
   }


    /**
    * @param array $data 
    * @param Model $punshList 
    * 
    */
    public function add_users_to_Punch_list($data , $punshList)
    {
        try{
            if(!$punshList){
                throw new \Exception('Record not find'); 
            }
            $d = $punshList->users()->sync($data['participates']);
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
    public function get_all_project_Punch_list($project_id , $request): Collection{
        $data = $request->all();
       // dd($data);
        $punchLists =  $this->model->where('project_id',$project_id);
        if(isset($data['assignee'])){
            $punchLists=$punchLists->when($data['assignee'] , function($q) use($data){
                $q->where(function($query) use($data){
                    $query->whereIn('responsible_id',$data['assignee']);
                    $query->orWhereHas('users',function($q) use($data){
                        $q->whereIn('users.id',$data['assignee']);
                    }); 
                });
           
            });
        }

        if(isset($data['closed_by'])){
            $punchLists=$punchLists->when($data['closed_by'] , function($q) use($data){
                $q->where(function($query) use($data){
                    //$query->whereHas('closedByUser',function($q) use($data){
                        $query->whereIn('closed_by ',$data['closed_by']);
                    ///});
                });    

            });            
        }

        if(isset($data['creator'])){
            $punchLists=$punchLists->when($data['creator'] , function($q) use($data){
                $q->where(function($query) use($data){
                   // $query->whereHas('createdByUser',function($q) use($data){
                        $query->whereIn('created_by',$data['creator']);
                   // });
                });    
            });
        }
        if(isset($data['creation_date'])){


            $punchLists=$punchLists->when($data['creation_date'] , function($q) use($data){
                $q->where(function($query) use($data){
                $query->whereDate('created_at',$data['creation_date']);
                });
                        
            }) ;  
        }
        
        if(isset($data['date_notified'])){

            $punchLists=$punchLists->when($data['date_notified'] , function($q) use($data){
                $q->where(function($query) use($data){
                $query->whereDate('date_notified_at',$data['date_notified']); 
                });               
            }) ; 
        }
        
        if(isset($data['date_resolved'])){

            $punchLists=$punchLists->when($data['date_resolved'] , function($q) use($data){
                $q->where(function($query) use($data){
                $query->whereDate('date_resolved_at',$data['date_resolved']);
                });
                        
            }) ; 
        }
        if(isset($data['due_date'])){     
            
            $punchLists=$punchLists->when($data['due_date'] , function($q) use($data){
                $q->where(function($query) use($data){
                $query->whereDate('due_date',$data['due_date']);
                });
                        
            }) ; 
        }
        
        if(isset($data['status'])){
            $punchLists=$punchLists->when($data['status'] , function($q) use($data){
                $q->where(function($query) use($data){
                    $query->where('status',$data['status']);
                });
                        
            }) ;
        }
        if(isset($data['priority'])){    
            $punchLists=$punchLists->when($data['priority'] , function($q) use($data){
                $q->where(function($query) use($data){
                $query->where('priority',$data['priority']);
                });
                        
            }) ; 
        }          
        $punchLists=$punchLists->when($data['search'] , function($q) use($data){
        $q->where(function($query) use($data){
                $query->whereAny(
                    [
                        'number',
                        'title',
                        'date_notified_at',
                        'location',
                        'date_resolved_at',
                        'description',
                        'due_date',
                        'status',
                       ],
                    'LIKE',
                    "%".$data['search']."%"
                );
            
        });

        });

        if(checkIfUserHasThisPermission($project_id , 'view_all_punch_list')){

            $punchLists=$punchLists->with(['responsible:id,name', 'createdByUser:id,name'])->get();
  
            return $punchLists;
        }        
        else if(!auth()->user()->is_admin){

            $punchLists = $punchLists->where(function($q){
                $q->whereHas('users', function ($query) {
                    $query->where('user_id', auth()->user()->id);
                });

                $q->orwhere('responsible_id',auth()->user()->id);
                $q->orwhere('created_by',auth()->user()->id);

                
            });

            $punchLists=$punchLists->with(['responsible:id,name', 'createdByUser:id,name'])->get();
  
            return $punchLists;
              

        }

        
    }

    
     /**
    * @param int $project_id
    * @return Collection
    * 
    */
    public function get_status_pie_chart($project_id): Collection
    {
        return $this->model->where('project_id',$project_id)->select('status',\DB::raw('count(*) as count_rows'))
        ->groupBy('status')->get();
    }  

 
}