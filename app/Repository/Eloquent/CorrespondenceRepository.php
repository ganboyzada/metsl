<?php

namespace App\Repository\Eloquent;

use App\Mail\StakholderEmail;
use App\Models\Correspondence;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use App\Repository\CorrespondenceRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
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
        return $this->model->where('type',$type)->where('project_id',$projectID)->count();
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
    * @param int $project_id 
    * @param \Request $request
    * @return Collection
    * 
    */
    public function get_all_project_correspondence($project_id , $request): Collection{
        $sub = \DB::raw('(select  reply_correspondence_id as replyCorespondenceId  , MAX(created_date) as last_upload_date
         from correspondences where reply_correspondence_id is not null group by reply_correspondence_id)last_upload_table');

        return $this->model->where('project_id',$project_id)->where('reply_correspondence_id',NULL)
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
                        'recieved_date',
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

                $q->orWhereHas('ReceivedFrom',function($q)use($request){
                    $q->where('name', 'LIKE', "%".$request->search."%");
                });

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

        })
        ->with(['assignees:id,name' , 'CreatedBy:id,name'])->get();
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