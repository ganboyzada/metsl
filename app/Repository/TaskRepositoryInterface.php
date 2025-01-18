<?php
namespace App\Repository;

use App\Model\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

interface TaskRepositoryInterface
{
    /**
    * @param integer $project_id
    * @return Collection
    */

    public function all_tasks($project_id): Collection;


    /**
    * @param array $data 
    * @param Model $task 
    * 
    */
    public function add_users_to_task($data , $task): void;  
}