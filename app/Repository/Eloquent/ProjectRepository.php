<?php

namespace App\Repository\Eloquent;

use App\Mail\StakholderEmail;
use App\Models\Permission;
use App\Models\Project;
use App\Models\Role;
use App\Models\User;
use App\Repository\ProjectRepositoryInterface;
use Illuminate\Support\Collection;

class ProjectRepository extends BaseRepository implements ProjectRepositoryInterface
{

   /**
    * UserRepository constructor.
    *
    * @param Project $model
    */
   public function __construct(Project $model)
   {
       parent::__construct($model);
   }

    /**
    * @param integer $id
    * @return Collection
    */
    public function projects_of_company($company_id) :Collection
    {
        return $this->model->where('company_id',$company_id)->get();
    }



    /**
    * @return Collection
    */
    public function clients_of_project() :Collection
    {
        return $this->model->with('clients')->get();
    }

    /**
    * @return Collection
    */
    public function contractors_of_project() :Collection
    {
        return $this->model->with('contractors')->get();
    }


    /**
    * @return Collection
    */
    public function project_managers_of_project() :Collection
    {
        return $this->model->with('projectMangers')->get();
    }



    /**
    * @return Collection
    */
    public function design_teams_of_project() :Collection
    {
        return $this->model->with('designTeams')->get();
    }    

   /**
    * @param integer $id
    * @return bool
    */
    public function change_status($id , $status) :bool
    {
        return $this->model->where('id',$id)->update(['status'=>$status]);
    }


   /**
    * @param integer $id
    * @param array $contractors
    */
    public function add_contractors_to_project($id , $contractors) :void
    {

        $project = $this->find($id);
        $project->contractors()->attach($contractors);
    }

       /**
    * @param integer $id
    * @param array $clients
    */
    public function add_clients_to_project($id , $clients) :void
    {

        $project = $this->find($id);
        $project->clients()->attach($clients);
    }


    /**
    * @param integer $id
    * @param array $designTeam
    */
    public function add_design_team_to_project($id , $designTeam) :void
    {

        $project = $this->find($id);
        $project->designTeams()->attach($designTeam);
    }

     /**
    * @param integer $id
    * @param array $projectManager
    */
    public function add_project_manager_to_project($id , $projectManager) :void
    {

        $project = $this->find($id);
        $project->projectMangers()->attach($projectManager);
    }


  
 
}