<?php

namespace App\Repository\Eloquent;

use App\Enums\CorrespondenceStatusEnum;
use App\Mail\StakholderEmail;
use App\Models\Correspondence;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use App\Repository\CorrespondenceRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
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
    * @param array $data 
    * @param Model $correspondence 
    * 
    */
    public function add_users_to_correspondence($data , $correspondence): void
    {
        try{
            if(!$correspondence){
                throw new \Exception('Record not find'); 
            }
            $correspondence->assignees()->sync($data['assignees']);
            $correspondence->DistributionMembers()->sync($data['distribution']);
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
                        $modal = $modal->orwhere('type' , $enum->value);
    
                    }
                }




            });
            



            $modal = $modal->with(['assignees:id,name' , 'CreatedBy:id,name'])->paginate(10);

            return $modal;           

        }else{
            $modal = $modal->with(['assignees:id,name' , 'CreatedBy:id,name'])->paginate(10);

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
        $sub = \DB::raw('(select  reply_correspondence_id as replyCorespondenceId  , MAX(created_date) as last_upload_date
         from correspondences where reply_correspondence_id is not null group by reply_correspondence_id)last_upload_table');

        $modal =  $this->model->where('project_id',$project_id)->where('reply_correspondence_id',NULL)
        ->leftjoin($sub,function($join){
            $join->on('last_upload_table.replyCorespondenceId','=','id');       
        })
        ->where('status',CorrespondenceStatusEnum::OPEN->value);

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
                        $modal = $modal->orwhere('type' , $enum->value);
    
                    }
                }




            });
            



            $modal = $modal->with(['assignees:id,name' , 'CreatedBy:id,name'])->paginate(10);

            return $modal;           

        }else{
            $modal = $modal->with(['assignees:id,name' , 'CreatedBy:id,name'])->paginate(10);

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
        
        ->with(['assignees:id,name' , 'CreatedBy:id,name'])->get();
    }  



        /**
    * @param int $project_id
    * @param int $corespondence_id 
    * @return Collection
    * 
    */
    public function get_correspondence_parent($project_id , $corespondence_id): Collection{
        return $this->model->where('project_id',$project_id)->where('id',$corespondence_id)
        
        ->with(['assignees:id,name' , 'CreatedBy:id,name'])->get();
    }  
 
}