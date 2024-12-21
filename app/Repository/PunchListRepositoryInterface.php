<?php
namespace App\Repository;

use App\Model\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

interface PunchListRepositoryInterface
{


        /**
    * @param array $data 
    * @param Model $punshList 
    * 
    */
    public function add_users_to_Punch_list($data , $punshList);  

            /**
    * @param int $project_id
    * @param \Request $request
    * @return Collection
    * 
    */
    public function get_all_project_Punch_list($project_id , $request): Collection; 
    
    /**
    * @param int $projectID 
    * @return mixed
    */
    public function get_next_number($projectID): mixed;

        /**
    * @param int $project_id
    * @return Collection
    * 
    */
    public function get_status_pie_chart($project_id): Collection;
    
 
}