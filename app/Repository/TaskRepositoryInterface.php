<?php
namespace App\Repository;

use App\Model\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

interface TaskRepositoryInterface
{
    /**
    * @param integer $project_id
    * @return Collection
    */

    public function all_tasks($project_id): Collection;
  /**
    * @param integer $id
    * @return LengthAwarePaginator
    */
    public function all_tasks_assigned($project_id) :LengthAwarePaginator;

    /**
    * @param array $data 
    * @param Model $task 
    * 
    */
    public function add_users_to_task($data , $task): void;  
}