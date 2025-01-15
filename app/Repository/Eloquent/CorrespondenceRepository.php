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
        return $this->model->where('project_id',$project_id)
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

    
  
 
}