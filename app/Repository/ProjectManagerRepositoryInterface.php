<?php
namespace App\Repository;

use App\Model\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

interface ProjectManagerRepositoryInterface
{

    /**
    *  @param integer $id 
    * @return \App\Models\ProjectManager
    */

    public function projects_of_project_manger($id): Model;


    /**
    * @param integer $id
    * @return bool
    */

    public function change_status($id , $status): bool;
}