<?php
namespace App\Repository;

use App\Model\User;
use Illuminate\Support\Collection;
use App\Models\Role;
use App\Models\Permission;
interface RoleRepositoryInterface
{

    /**
    * @param integer $id
    * @return Collection
    */

    public function projects_of_company($company_id): Collection;


    /**
    * @return Collection
    */

    public function clients_of_project(): Collection;

    /**
    * @return Collection
    */

    public function contractors_of_project(): Collection;

    
    /**
    * @return Collection
    */

    public function project_managers_of_project(): Collection;


    
    /**
    * @return Collection
    */

    public function design_teams_of_project(): Collection;
    
    /**
    * @param integer $id
    * @return bool
    */

    public function change_status($id , $status): bool;

    
    /**
    * @param integer $id
    * @param array $contractors
    */
    public function add_contractors_to_project($id , $contractors): void;

        /**
    * @param integer $id
    * @param array $clients
    */
    public function add_clients_to_project($id , $clients): void;
    
        /**
    * @param integer $id
    * @param array $designTeam
    */
    public function add_design_team_to_project($id , $designTeam): void;

        
        /**
    * @param integer $id
    * @param array $projectManager
    */
    public function add_project_manager_to_project($id , $projectManager): void;
}