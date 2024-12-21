<?php

namespace App\Repository\Eloquent;

use App\Model\User;
use App\Models\MeetingPlanfiles;
use App\Models\PunchListFiles;
use App\Repository\CorrespondenceFileRepositoryInterface;
use App\Repository\PunchListFilesRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class PunchListFilesRepository extends BaseRepository implements PunchListFilesRepositoryInterface
{

   /**
    * UserRepository constructor.
    *
    * @param PunchListFiles $model
    */
   public function __construct(PunchListFiles $model)
   {
       parent::__construct($model);
   }
    /**
    * @param array $data
    * @return bool
    */

    public function create_bulk_files($data): bool
    {
        try{
            return $this->model->insert($data);
        }catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }            
    }
   /**
    * @param integer $id
    * @return bool
    */
    public function change_status($id , $status) :bool
    {
        return $this->model->where('id',$id)->update(['status'=>$status]);
    }

}