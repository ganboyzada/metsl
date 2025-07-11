<?php

namespace App\Repository\Eloquent;

use App\Enums\PunchListStatusEnum;
use App\Mail\StakholderEmail;
use App\Models\Permission;
use App\Models\ProjectDocumentFiles;
use App\Models\ProjectDocumentRevisions;
use App\Models\PunchList;
use App\Models\WorkPackages;
use App\Models\User;
use App\Repository\PunchListRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class PunchListRepository extends BaseRepository implements PunchListRepositoryInterface
{

   /**
    * UserRepository constructor.
    * @param PunchList $model
    * @param WorkPackages $modelWorkPackages
    */
   public function __construct(PunchList $model , WorkPackages $modelWorkPackages)
   {
       parent::__construct($model , $modelWorkPackages);
   }

    /**
    * @param array $data 
    * @param Model $punshList 
    * @param array $assignees_has_permission
    */
    public function add_assignees_to_Punch_list($data , $punshList , $assignees_has_permission)
    {
        try{
            if(!$punshList){
                throw new \Exception('Record not find'); 
            }
           // dd($assignees_has_permission);
            //$user_of_workpackage = $punshList->package()->companies()->users()->pluck('id')->toArray();
            $users_of_work_packages = $this->model2->join('company_work_packages', 'company_work_packages.work_package_id', '=', 'work_packages.id')
            ->join('projects_users', 'projects_users.company_id', '=', 'company_work_packages.company_id')
            
            ->join('companies', 'companies.id', '=', 'projects_users.company_id')
            //->where('companies.active', 1)
            ->whereIN('projects_users.user_id', $assignees_has_permission)
            ->where('work_packages.id', $punshList->work_package_id)
            ->select('projects_users.user_id')->pluck('projects_users.user_id')->toArray();

            //dd($users_of_work_packages);
   
            $d = $punshList->assignees()->sync($users_of_work_packages);
           
        }catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }    
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
    * @param array $data 
    * @param Model $punchlist 
    * 
    */
    public function add_Linked_documents_to_punchlist($data , $punchlist): void
    {
        try{
            if(!$punchlist){
                throw new \Exception('Record not find'); 
            }
            //dd($data['linked_documents']);
            if(isset($data['linked_documents']) && count($data['linked_documents']) > 0){
                $punchlist->documentFiles()->detach();
                foreach($data['linked_documents'] as $doc){
                    $ids = explode('-' , $doc);
                    $file_id = $ids[0];
                    $revision_id = $ids[1] ?? NULL;
                    $punchlist->documentFiles()->attach($file_id, ['revision_id'=>$revision_id]);

                }
            }
            

        }catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }    
       // dd('ok');
    }


           /**
    * @param int $projectID 
    * @return int
    */
    public function get_next_number($projectID): int
    {
        $model = $this->model->where('project_id',$projectID)->orderby('id','desc')->first();
        //dd($model);
        if(isset($model->number)){
            return (int)$model->number + 1; 
        }else{
            return 1;
        }
        
    } 


    /**
    * @param int $project_id 
    * @param \Request $request
    * @return LengthAwarePaginator
    * 
    */
    public function get_all_project_Punch_list($project_id , $request): LengthAwarePaginator{
        $data = $request->all();
       // dd($data);
        $punchLists =  $this->model->where('project_id',$project_id);
        if(isset($data['assignee'])){
            $punchLists=$punchLists->when($data['assignee'] , function($q) use($data){
                $q->where(function($query) use($data){
                    $query->WhereHas('assignees',function($q) use($data){
                        $q->whereIn('users.id',$data['assignee']);
                    }); 
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

        if(isset($data['work-package'])){    
            $punchLists=$punchLists->when($data['work-package'] , function($q) use($data){
                $q->where(function($query) use($data){
                $query->where('work_package_id',$data['work-package']);
                });
                        
            }) ; 
        }  

        if(isset($data['search'])){        
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

            $q->orWhere(function($query) use($data){
                    $query->WhereHas('drawing',function($q) use($data){
                        $q->whereAny(
                        [
                            'title',
                            'description'
                        ],
                        'LIKE',
                        "%".$data['search']."%"
                    );
                    }); 
                });

            });
        }

        if(checkIfUserHasThisPermission($project_id , 'view_all_punch_list')){

            $punchLists=$punchLists->with(['package:id,name', 'createdByUser:id,name' , 'drawing:id,title'])->paginate(10);
  
            return $punchLists;
        }        
        else if(!auth()->user()->is_admin){

            $punchLists = $punchLists->where(function($q){
                $q->whereHas('users', function ($query) {
                    $query->where('user_id', auth()->user()->id);
                });

                $q->orWhereHas('assignees',function($query){
                     $query->where('user_id', auth()->user()->id);
                    }); ;
                $q->orwhere('created_by',auth()->user()->id);

                
            });

            $punchLists=$punchLists->with(['package:id,name', 'createdByUser:id,name' , 'drawing:id,title'])->paginate(10);
  
            return $punchLists;
              

        }

        
    }

  /**
    * @param int $project_id 
    * @param \Request $request
    * @return LengthAwarePaginator
    * 
    */
    public function get_all_project_Punch_list_open($project_id , $request): LengthAwarePaginator{
        $data = $request->all();
       // dd($data);
        $punchLists =  $this->model->where('project_id',$project_id)
        ->where('status','!=',PunchListStatusEnum::CLOSED->value);
        
        if(auth()->user()->is_admin){

            $punchLists=$punchLists->with(['package:id,name', 'createdByUser:id,name'])->paginate(10);
  
            return $punchLists;
        }        
        else if(!auth()->user()->is_admin){

            $punchLists = $punchLists->where(function($q){
                // $q->whereHas('users', function ($query) {
                //     $query->where('user_id', auth()->user()->id);
                // });

                $q->Where( function ($query) {
                    $query->where('status',PunchListStatusEnum::PENDING->value);
                    $query->whereHas('assignees', function ($query) {
                         $query->where('user_id', auth()->user()->id);
                    });
                });

                $q->orWhere( function ($query) {
                    $query->where('status','!=',PunchListStatusEnum::CLOSED->value);
                    $query->where('created_by',auth()->user()->id);
                });

                
               // $q->orwhere('created_by',auth()->user()->id);

                
            });

            $punchLists=$punchLists->with(['package:id,name', 'createdByUser:id,name'])->paginate(10);
  
            return $punchLists;
              

        }

        
    }    
    /**
    * @param int $project_id 
    * @param \Request $request
    * @return LengthAwarePaginator
    * 
    */
    public function get_all_project_Punch_list_paginate($project_id , $request): LengthAwarePaginator{
  
        $punchLists =  $this->model->where('project_id',$project_id);

        if(isset($request->search)){   
            $search = $request->search;     
            $punchLists=$punchLists->when($search , function($q) use($search){
            $q->where(function($query) use($search){
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
                        "%".$search."%"
                    );

                
            });

            $q->orWhere(function($query) use($search){
                    $query->WhereHas('drawing',function($q) use($search){
                        $q->whereAny(
                        [
                            'title',
                            'description'
                        ],
                        'LIKE',
                        "%".$search."%"
                    );
                    }); 
                });

            });
        } 

        if(checkIfUserHasThisPermission($project_id , 'view_all_punch_list')){

            $punchLists=$punchLists->paginate(10);
  
            return $punchLists;
        }        
        else if(!auth()->user()->is_admin){

            $punchLists = $punchLists->where(function($q){
                $q->whereHas('users', function ($query) {
                    $query->where('user_id', auth()->user()->id);
                });

                $q->orwhereHas('assignees', function ($query) {
                    $query->where('user_id', auth()->user()->id);
                });
                $q->orwhere('created_by',auth()->user()->id);

                
            });

            $punchLists=$punchLists->paginate(perPage: 10);
  
            return $punchLists;
              

        }

        
    }


        /**
    * @param int $project_id 
    * @param int $id 
    * @param \Request $request
    * @return LengthAwarePaginator
    * 
    */
    public function get_all_project_Punch_list_by_drawing_id($project_id ,$id , $request): LengthAwarePaginator{
  
        $punchLists =  $this->model->where('project_id',$project_id)->where('drawing_id',$id);

        if(isset($request->search)){   
            $search = $request->search;     
            $punchLists=$punchLists->when($search , function($q) use($search){
            $q->where(function($query) use($search){
                    $query->whereAny(
                        [
                            'number'
                        ],
                        'LIKE',
                        "%".$search."%"
                    );

                
            });

            // $q->orWhere(function($query) use($search){
            //         $query->WhereHas('drawing',function($q) use($search){
            //             $q->whereAny(
            //             [
            //                 'title',
            //                 'description'
            //             ],
            //             'LIKE',
            //             "%".$search."%"
            //         );
            //         }); 
            //     });

            });
        } 

        if(checkIfUserHasThisPermission($project_id , 'view_all_punch_list')){

            $punchLists=$punchLists->paginate(10);
  
            return $punchLists;
        }        
        else if(!auth()->user()->is_admin){

            $punchLists = $punchLists->where(function($q){
                $q->whereHas('users', function ($query) {
                    $query->where('user_id', auth()->user()->id);
                });

                $q->orwhereHas('assignees', function ($query) {
                    $query->where('user_id', auth()->user()->id);
                });
                $q->orwhere('created_by',auth()->user()->id);

                
            });

            $punchLists=$punchLists->paginate(perPage: 10);
  
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