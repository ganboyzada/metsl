<?php
namespace App\Repository;

use App\Model\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
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
    * @param array $data 
    * @param Model $punchlist 
    * 
    */
    public function add_Linked_documents_to_punchlist($data , $punchlist): void;

            /**
    * @param int $project_id
    * @param \Request $request
    * @return LengthAwarePaginator
    * 
    */
    public function get_all_project_Punch_list($project_id , $request): LengthAwarePaginator; 
    
    /**
    * @param int $project_id 
    * @param \Request $request
    * @return LengthAwarePaginator
    * 
    */
    public function get_all_project_Punch_list_open($project_id , $request): LengthAwarePaginator;
     /**
    * @param int $project_id 
    * @param \Request $request
    * @return LengthAwarePaginator
    * 
    */
    public function get_all_project_Punch_list_paginate($project_id , $request): LengthAwarePaginator;

  /**
    * @param int $project_id 
    * @param int $id 
    * @param \Request $request
    * @return LengthAwarePaginator
    * 
    */
    public function get_all_project_Punch_list_by_drawing_id($project_id ,$id , $request): LengthAwarePaginator ;   

    /**
    * @param int $projectID 
    * @return int
    */
    public function get_next_number($projectID): int;

        /**
    * @param int $project_id
    * @return Collection
    * 
    */
    public function get_status_pie_chart($project_id): Collection;
    
 
}