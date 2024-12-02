<?php
namespace App\Repository;

use App\Model\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

interface DesignTeamRepositoryInterface
{

    /**
    *  @param integer $id 
    * @return \App\Models\DesignTeam
    */

    public function projects_of_design_team($id): Model;


    /**
    * @param integer $id
    * @return bool
    */

    public function change_status($id , $status): bool;
}