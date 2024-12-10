<?php
namespace App\Repository;

use App\Model\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

interface MeetingPlaningRepositoryInterface
{


        /**
    * @param array $data 
    * @param Model $document 
    * 
    */
    public function add_users_to_meeting_planing($data , $document);  

            /**
    * @param int $project_id
    * @param \Request $request
    * @return Collection
    * 
    */
    public function get_all_project_meeting_planing($project_id , $request): Collection; 
    
    /**
    * @param int $projectID 
    * @return mixed
    */
    public function get_next_number($projectID): mixed;
}