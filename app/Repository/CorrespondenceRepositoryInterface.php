<?php
namespace App\Repository;

use App\Model\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

interface CorrespondenceRepositoryInterface
{

    /**
    * @param string $type 
    * @param int $projectID 
    * @return mixed
    */
    public function get_next_number($type , $projectID): mixed;  
    
    
        /**
    * @param array $data 
    * @param Model $correspondence 
    * 
    */
    public function add_users_to_correspondence($data , $correspondence): void;  

            /**
    * @param int $project_id
    * @param \Request $request
    * @return Collection
    * 
    */
    public function get_all_project_correspondence($project_id , $request): Collection;  
}