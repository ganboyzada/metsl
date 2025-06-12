<?php
namespace App\Repository;

use App\Model\User;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;


interface UserRepositoryInterface
{

        /**
    * @param int $project_id 
    * @param array $all_stakholders
    */
    public function create_role_permisions_set_of_user($project_id , $all_stakholders): void; 
    

    /**
    * @param int $project_id
    * @param int $permission_id
    * @return Collection
    */    
    public function get_users_of_project($project_id , $permission_id): Collection;


        /**
    * @param int $project_id
    * @param int $permission_id
    * @return Model
    */    
    public function check_if_user_of_project_has_this_permission($project_id , $permission_id): Model;

    /**
     * @param int $project_id
     *  @param \Request $request
    * @return Collection
    */ 
    public function get_stakeholders_of_project($project_id , $request): Collection;
    /**
    * @param \Request $request
    * @return Collection
    */ 
    public function search($request): Collection;
}