<?php
namespace App\Repository;

use App\Model\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

interface MeetingPlaningRepositoryInterface
{


        /**
    * @param array $data 
    * @param Model $meetingPlaning 
    * 
    */
    public function add_users_to_meeting_planing($data , $meetingPlaning);  

            /**
    * @param int $project_id
    * @param \Request $request
    * @return LengthAwarePaginator
    * 
    */
    public function get_all_project_meeting_planing($project_id , $request): LengthAwarePaginator; 
    
    /**
    * @param int $projectID 
    * @return mixed
    */
    public function get_next_number($projectID): mixed;


}