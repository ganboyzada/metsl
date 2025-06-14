<?php

namespace App\Repository\Eloquent;

use App\Enums\CorrespondenceStatusEnum;
use App\Enums\CorrespondenceTypeEnum;
use App\Mail\StakholderEmail;
use App\Models\Correspondence;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use App\Repository\CorrespondenceRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class CorrespondenceRepository extends BaseRepository implements CorrespondenceRepositoryInterface
{

   /**
    * UserRepository constructor.
    *
    * @param Correspondence $model
    */
   public function __construct(Correspondence $model)
   {
       parent::__construct($model);
   }

       /**
    * @param string $type 
    * @param int $projectID 
    * @return mixed
    */
    public function get_next_number($type , $projectID): mixed
    {
        $model = $this->model->where('project_id',$projectID)->where('reply_correspondence_id',NULL)
        ->orderby('id','desc')->first();
        //dd($model);
        if(isset($model->number)){
            $number = explode('-', $model->number);
            return (int)$number[1] + 1; 
        }else{
            return 1;
        }
        //return $this->model->where('type',$type)->where('project_id',$projectID)->count();
    } 


      /**
    * @param int $id 
    * @return bool
    */
    public function close($id): bool
    {
        try{
            return $this->model->where(function($q)use($id){
                $q->where('id',$id);
                $q->orWhere('reply_correspondence_id',$id);
            })
            
            ->update(['status'=>CorrespondenceStatusEnum::CLOSED->value , 'changed_by'=>auth()->user()->id]);
        }catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
        //return $this->model->where('type',$type)->where('project_id',$projectID)->count();
    } 

          /**
    * @param int $id 
    * @return bool
    */
    public function accept($id): bool
    {
        try{
            return $this->model->where(function($q)use($id){
                $q->where('id',$id);
                $q->orWhere('reply_correspondence_id',$id);
            })
            
            ->update(['status'=>CorrespondenceStatusEnum::ACCEPTED->value , 'changed_by'=>auth()->user()->id]);
        }catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
        //return $this->model->where('type',$type)->where('project_id',$projectID)->count();
    } 
             /**
    * @param int $id 
    * @return bool
    */
    public function reject($id): bool
    {
        try{
            return $this->model->where(function($q)use($id){
                $q->where('id',$id);
                $q->orWhere('reply_correspondence_id',$id);
            })
            
            ->update(['status'=>CorrespondenceStatusEnum::REJECTED->value , 'changed_by'=>auth()->user()->id]);
        }catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
        //return $this->model->where('type',$type)->where('project_id',$projectID)->count();
    }
    /**
    * @param int $project_id
    * @param int $reply_correspondence_id
    * @return Collection
    * 
    */
    public function get_correspondence_except_NCR($project_id , $reply_correspondence_id): Collection{
        return $this->model->where('project_id',$project_id)->where('id','!=',$reply_correspondence_id)
        ->where('type', '!=', CorrespondenceTypeEnum::NCR->value)
            ->where('project_id', $project_id)
            ->whereNull('reply_correspondence_id')
            ->get();
    }

    /**
    * @param array $data 
    * @param Model $correspo$this->model->where('project_id',$project_id)->ndence 
    * 
    */
    public function add_users_to_correspondence($data , $correspondence): void
    {
        try{
            if(!$correspondence){
                throw new \Exception('Record not find'); 
            }
            $correspondence->assignees()->sync($data['assignees']);
            if(isset($data['distribution']) && count($data['distribution']) > 0){
                $correspondence->DistributionMembers()->sync($data['distribution']);
            }
            
            if($correspondence->reply_correspondence_id == NULL){
                $correspondence->forwards()->sync($data['assignees']);
            }else{

                $parent = $this->model->find($correspondence->reply_correspondence_id);
                if($parent->created_by == auth()->user()->id){
                    $correspondence->forwards()->sync($data['assignees']);
                }else{
                    $correspondence->forwards()->sync([$parent->created_by]);
                }
                
            }
        }catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }    
       // dd('ok');
    }

   /**
    * @param array $data 
    * @param Model $correspondence 
    * 
    */
    public function add_Linked_documents_to_correspondence($data , $correspondence): void
    {
        try{
            if(!$correspondence){
                throw new \Exception('Record not find'); 
            }
            //dd($data['linked_documents']);
            if(isset($data['linked_documents']) && count($data['linked_documents']) > 0){
                $correspondence->documentFiles()->detach();
                foreach($data['linked_documents'] as $doc){
                    $ids = explode('-' , $doc);
                    $file_id = $ids[0];
                    $revision_id = $ids[1] ?? NULL;
                    $correspondence->documentFiles()->attach($file_id, ['revision_id'=>$revision_id]);

                }
            }
            

        }catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }    
       // dd('ok');
    }


    /**
    * @param int $project_id 
    * @param \Request $request
    * @return LengthAwarePaginator
    * 
    */
    public function get_all_project_correspondence($project_id , $request): LengthAwarePaginator{
        $sub = \DB::raw('(select  reply_correspondence_id as replyCorespondenceId  , MAX(created_date) as last_upload_date
         from correspondences where reply_correspondence_id is not null group by reply_correspondence_id)last_upload_table');

        $modal =  $this->model->where('project_id',$project_id)->where('reply_correspondence_id',NULL)
        ->leftjoin($sub,function($join){
            $join->on('last_upload_table.replyCorespondenceId','=','id');       
        })
        ->when($request->search , function($query) use($request){
            $query->where(function($q) use($request){
                $q->whereAny(
                    [
                        'number',
                        'subject',
                        'type',
                        'created_date',
                        'description'
                       ],
                    'LIKE',
                    "%".$request->search."%"
                );
                $q->orWhereHas('CreatedBy',function($q)use($request){
                    $q->where('name', 'LIKE', "%".$request->search."%");
                });
    
                $q->orWhereHas('assignees',function($q)use($request){
                    $q->where('name', 'LIKE', "%".$request->search."%");
                });

                /*$q->orWhereHas('ReceivedFrom',function($q)use($request){
                    $q->where('name', 'LIKE', "%".$request->search."%");
                });*/

                $q->orWhereHas('distributionMembers',function($q)use($request){
                    $q->where('name', 'LIKE', "%".$request->search."%");
                });
            });

            /*$query->orWhereHas('CreatedBy',function($q)use($request){
                $q->where('name', 'LIKE', "%".$request->search."%");
            });

            $query->orWhereHas('assignees',function($q)use($request){
                $q->where('name', 'LIKE', "%".$request->search."%");
            });
            */

        });

        if(!auth()->user()->is_admin){

            $modal = $modal->where(function($q)use($project_id){
                $q->whereHas('assignees', function ($query) {
                    $query->where('user_id', auth()->user()->id);
                });

                $q->orWhereHas('distributionMembers', function ($query) {
                    $query->where('user_id', auth()->user()->id);
                });
                
                $q->orwhere('created_by', auth()->user()->id);


                $enums_list = \App\Enums\CorrespondenceTypeEnum::cases();
                foreach ($enums_list as $enum) {
                    if(checkIfUserHasThisPermission($project_id , 'view_'.$enum->value)){
                        $q = $q->orwhere('type' , $enum->value);
    
                    }
                }




            });
            



            $modal = $modal->with(['assignees:id,name' , 'CreatedBy:id,name' , 'ChangedBy:id,name'])->paginate(10);

            return $modal;           

        }else{
            $modal = $modal->with(['assignees:id,name' , 'CreatedBy:id,name' , 'ChangedBy:id,name'])->paginate(10);

            return $modal;
        }
        

    }
    /**
    * @param int $project_id 
    * @param \Request $request
    * @return LengthAwarePaginator
    * 
    */
    public function get_all_project_correspondence_open($project_id , $request): LengthAwarePaginator{
        // $sub = \DB::raw('(select  reply_correspondence_id as replyCorespondenceId  , MAX(created_date) as last_upload_date
        //  from correspondences where reply_correspondence_id is not null group by reply_correspondence_id)last_upload_table');

        $modal =  $this->model->where('project_id',$project_id)
        //->where('reply_correspondence_id',NULL)
        // ->leftjoin($sub,function($join){
        //     $join->on('last_upload_table.replyCorespondenceId','=','id');       
        // })
        ->where('status','!=',CorrespondenceStatusEnum::CLOSED->value)
        ->where(function($q)use ($project_id){
            if(!auth()->user()->is_admin){
                // $q->where(function($query)use ($project_id){
                //     $query->where('changed_by', '!=',NULL);
                //     $query->where('created_by', auth()->user()->id);
                // });

                $q->where(function($query)use ($project_id){
                    $query->whereNotIn('id', function($query) use ($project_id) {
                    $query->select('reply_child_correspondence_id')
                    ->from('correspondences')
                    ->whereNotNull('reply_child_correspondence_id')
                    ->where('project_id', $project_id);
                    })->where('created_by','!=', auth()->user()->id);
                });

            }else{
                // $q->where(function($query)use ($project_id){
                //     $query->where('changed_by', '!=',NULL);
                // });

                $q->where(function($query)use ($project_id){
                    $query->whereNotIn('id', function($query) use ($project_id) {
                    $query->select('reply_child_correspondence_id')
                    ->from('correspondences')
                    ->whereNotNull('reply_child_correspondence_id')
                    ->where('project_id', $project_id);
                    });
                });

            }


            

            // $q->orWhereHas('distributionMembers', function ($query) {
            //         $query->where('user_id', auth()->user()->id);
            //     });
        });
        
         

        if(!auth()->user()->is_admin){

            $modal = $modal->where(function($q)use($project_id){
                $q->whereHas('assignees', function ($query) {
                    $query->where('user_id', auth()->user()->id);
                });

                $q->orWhereHas('distributionMembers', function ($query) {
                    $query->where('user_id', auth()->user()->id);
                });
                
                $q->orWhereHas('forwards', function ($query) {
                    $query->where('user_id', auth()->user()->id);
                    
                });


                  $q->orwhere(function($query)use($project_id){
                      $query->where('changed_by', '!=',NULL);
                    $query->where('created_by', auth()->user()->id);
                  });


                // $enums_list = \App\Enums\CorrespondenceTypeEnum::cases();
                // foreach ($enums_list as $enum) {
                //     if(checkIfUserHasThisPermission($project_id , 'view_'.$enum->value)){
                //         $q = $q->orwhere('type' , $enum->value);
    
                //     }
                // }




            });
            



            $modal = $modal->orderBy('id', 'desc')->with(['assignees:id,name' , 'CreatedBy:id,name' , 'ChangedBy:id,name'])->paginate(10);

            return $modal;           

        }else{
            $modal = $modal->orderBy('id', 'desc')->with(['assignees:id,name' , 'CreatedBy:id,name' , 'ChangedBy:id,name'])->paginate(10);

            return $modal;
        }
        

    }
    
    /**
    * @param int $project_id
    * @param int $corespondence_id 
    * @return Collection
    * 
    */
    public function get_correspondence_replies($project_id , $corespondence_id): Collection{
        return $this->model->where('project_id',$project_id)->where('reply_correspondence_id',$corespondence_id)
        
        ->with(['assignees:id,name' , 'CreatedBy:id,name' , 'ChangedBy:id,name'])->get();
    }  

  
    /**
    * @param int $project_id
    * @param int $corespondence_id 
    * @return mixed
    * 
    */
    public function get_last_reply_correspondence($project_id , $corespondence_id): mixed{
        return $this->model->where('project_id',$project_id)->where('reply_correspondence_id',$corespondence_id)
        
        ->where('reply_correspondence_id','!=',NULL)->where('reply_child_correspondence_id','!=',NULL)->orderBy('id', 'desc')->first();
    }  

        /**
    * @param int $project_id
    * @param int $corespondence_id 
    * @return Collection
    * 
    */
    public function get_correspondence_parent($project_id , $corespondence_id): Collection{
        return $this->model->where('project_id',$project_id)->where('id',$corespondence_id)
        
        ->with(['assignees:id,name' , 'CreatedBy:id,name' , 'ChangedBy:id,name'])->get();
    }  
        /**
    * @param Request $request 
    * @return bool
    * 
    */

    public function update_due_days($request):bool{
        $parent = $this->model->find($request->id);
        $due_date = date('Y-m-d', strtotime($parent->due_date. ' + '.(int)$request->due_days.' days'));
        $due_days = $parent->due_days + (int)$request->due_days;
        return $this->model->where('reply_correspondence_id' , $request->id)->update(['due_days' => $due_days , 'due_date' => $due_date]);
    }
 
}