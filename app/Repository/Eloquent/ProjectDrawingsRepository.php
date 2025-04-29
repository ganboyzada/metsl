<?php

namespace App\Repository\Eloquent;

use App\Model\User;
use App\Models\ProjectDocumentFiles;
use App\Models\ProjectDrawings;
use App\Repository\CorrespondenceFileRepositoryInterface;
use App\Repository\ProjectDocumentFilesRepositoryInterface;
use App\Repository\ProjectDrawingsRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class ProjectDrawingsRepository extends BaseRepository implements ProjectDrawingsRepositoryInterface
{

   /**
    * UserRepository constructor.
    *
    * @param ProjectDrawings $model
    */
   public function __construct(ProjectDrawings $model)
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
    * @param int $project_id 
    * @param \Request $request
    * @return Collection
    * 
    */
    public function searchDrawings($project_id , $request): Collection{
        $modal =  $this->model->where('project_id',$project_id)
        ->when($request->search , function($query) use($request){
            $query->where(function($q) use($request){
                $q->whereAny(
                    [
                        'title',
              
                        'description'
                       ],
                    'LIKE',
                    "%".$request->search."%"
                );

            });


        })->get();
        return $modal;

    }
 


}