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
    


}