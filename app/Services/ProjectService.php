<?php

namespace App\Services;

use App\Models\Client;
use App\Models\Contractor;
use App\Models\DesignTeam;
use App\Models\ProjectManager;
use App\Repository\ProjectRepositoryInterface;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class ProjectService
{
    public function __construct(
        protected ProjectRepositoryInterface $ProjectRepository,
        protected UserService $userService,
        protected ProjectFileService $projectFileService
    ) {
    }

    public function create(array $data)
    {
        \DB::beginTransaction();
        try {
            if(isset($data['logo']) && $data['logo'] != NULL){
                $file = $data['logo'];
                $fileName = md5(time()).'.'.$file->extension();            
                $data['logo'] = $fileName;

            }else{
                $data['logo'] = NULL;
            }

            $model =  $this->ProjectRepository->create($data);

            $path = Storage::disk('public')->path('project'.$model->id);
            
            \File::makeDirectory($path, $mode = 0777, true, true);
        
            if($data['logo'] != NULL){
                Storage::disk('public')->putFileAs('project' . $model->id, $file, $fileName);

            }
            if(isset($data['docs'])){
                $this->projectFileService->createBulkFiles($model->id , $data);
            }
            (isset($data['all_stakholders']) && count($data['all_stakholders']) > 0) ? $this->userService->createRolePermissionsOfUser($model->id , $data['all_stakholders']) : '';
             
            
            \DB::commit();
        } catch (\Exception $e) {
            \DB::rollback();
            throw new \Exception($e->getMessage());
        }
            
            

        return $model;
    }

    public function update(array $data)
    {
        \DB::beginTransaction();
        try {
            if(isset($data['logo']) && $data['logo'] != NULL){
                $file = $data['logo'];
                $fileName = md5(time()).'.'.$file->extension();            
                $data['logo'] = $fileName;

            }
            $id = $data['id'];

            $this->ProjectRepository->update($data , $id);
            $model = $this->ProjectRepository->find($id);

            $path = Storage::disk('public')->path('project'.$model->id);
            
            \File::makeDirectory($path, $mode = 0777, true, true);
        
            if(isset($data['logo']) && $data['logo'] != NULL){
                Storage::disk('public')->putFileAs('project' . $model->id, $file, $fileName);

            }
            if(isset($data['docs'])){
                $this->projectFileService->createBulkFiles($model->id , $data);
            }
            dd($data['all_stakholders']);
            (isset($data['all_stakholders']) && count($data['all_stakholders']) > 0) ? $this->userService->createRolePermissionsOfUser($model->id , $data['all_stakholders']) : '';
             
            
            \DB::commit();
        } catch (\Exception $e) {
            \DB::rollback();
            throw new \Exception($e->getMessage());
        }
            
            

        return $model;
    }

    public function all()
    {
        if(checkIfUserHasThisPermission(Session::get('projectID') ,'view_all_projects')){
            return $this->ProjectRepository->with(['user'])->all();
        }else{
            return $this->ProjectRepository->projects_of_user();
        }
        
        
    }

    public function projectsOfCompany($company_id)
    {
        return $this->ProjectRepository->projects_of_company($company_id);
    }

    public function changeStatus($id , $status)
    {
        return $this->ProjectRepository->change_status($id , $status);
        
    }

    public function find($id)
    {
        $project =  $this->ProjectRepository->with([
        'stakholders',
        'stakholders.allRoles'=>function($query) use($id){
            $query->wherePivot('project_id',$id);
        },
        'stakholders.allPermissions'=>function($query)use($id){
            $query->wherePivot('project_id',$id);
        },
       // 'stakholders.company',
        'files'

         
        ])->find($id);


        $clients = $project->stakholders->filter(function($user){
            if($user->pivot->type == 'client'){
                return $user;
            }
        });
        $project->clients = $clients;

        $contractors = $project->stakholders->filter(function($user){
            if($user->pivot->type == 'contractor'){
                return $user;
            }
        });
        $project->contractors = $contractors;


        $projectMangers = $project->stakholders->filter(function($user){
            if($user->pivot->type == 'projectManager'){
                return $user;
            }
        });
        $project->projectMangers = $projectMangers;

        $designTeams = $project->stakholders->filter(function($user){
            if($user->pivot->type == 'designTeam'){
                return $user;
            }
        });
        $project->designTeams = $designTeams;



        $clients_permissions = $project->clients->map(function($client){
            if($client->allPermissions->count() > 0){
                $permissions = $client->allPermissions->map(function($permission){
                    return $permission->name;
                });
                return [
                    'id'=> $client->id,
                    'name' => $client->name,
                    'company'=> $client->pivot->company_id,
                    'specialty'=> $client->pivot->specialty,
                    'office_phone'=> $client->pivot->office_phone,
                    'role'=>$client->allRoles[0]?->name??null,
                    'job_title'=>$client->allRoles[0]?->pivot->job_title?? null,
                    'type'=>'client',
                    'permissions' => $permissions
                ];
            }else{
                return [
                    'id'=> $client->id,
                    'name' => $client->name,
                    'company'=> $client->pivot->company_id,
                    'specialty'=> $client->pivot->specialty,
                    'office_phone'=> $client->pivot->office_phone,
                    'job_title'=> '',
                    'role'=>'',
                    'type'=>'client',
                    'permissions' => []
                ];
            }

            
        });
        $project->clients_permissions = $clients_permissions->values();       

        $contractors_permissions = $project->contractors->map(function($contractor){
            if($contractor->allPermissions->count() > 0){
                $permissions = $contractor->allPermissions->map(function($permission){
                    return $permission->name;
                });
                return [
                    'id'=> $contractor->id,
                    'name' => $contractor->name,
                    'company'=> $contractor->pivot->company_id,
                    'specialty'=> $contractor->pivot->specialty,
                    'office_phone'=> $contractor->pivot->office_phone,

                    'role'=>$contractor->allRoles[0]->name,
                    'job_title'=>$contractor->allRoles[0]->pivot->job_title,
                    'type'=>'contractor',
                    'permissions' => $permissions
                ];
            }else{
                return [
                    'id'=> $contractor->id,
                    'name' => $contractor->name,
                    'company'=> $contractor->pivot->company_id,
                    'specialty'=> $contractor->pivot->specialty,
                    'office_phone'=> $contractor->pivot->office_phone,
                      'role'=>'',
                    'job_title'=> '',
                    'type'=>'contractor',
                    'permissions' => []
                ];
            }

            
        });
        $project->contractors_permissions = $contractors_permissions->values();



        $design_teams_permissions = $project->designTeams->map(function($design_team){
            if($design_team->allPermissions->count() > 0){
                $permissions = $design_team->allPermissions->map(function($permission){
                    return $permission->name;
                });
                return [
                    'id'=> $design_team->id,
                    'name' => $design_team->name,
                    'company'=> $design_team->pivot->company_id,
                    'specialty'=> $design_team->pivot->specialty,
                    'office_phone'=> $design_team->pivot->office_phone,
                    'role'=>$design_team->allRoles[0]->name,
                    'job_title'=>$design_team->allRoles[0]->pivot->job_title,
                    'type'=>'designTeam',
                    'permissions' => $permissions
                ];
            }else{
                return [
                    'id'=> $design_team->id,
                    'name' => $design_team->name,
                    'company'=> $design_team->pivot->company_id,
                    'specialty'=> $design_team->pivot->specialty,
                    'office_phone'=> $design_team->pivot->office_phone,
                    'job_title'=>'',
                    'role'=>'',
                    'type'=>'designTeam',
                    'permissions' => []
                ];
            }

            
        });
        $project->design_teams_permissions = $design_teams_permissions->values();

        $project_managers_permissions = $project->projectMangers->map(function($project_manager){
            if($project_manager->allPermissions->count() > 0){
                $permissions = $project_manager->allPermissions->map(function($permission){
                    return $permission->name;
                });
                return [
                    'id'=> $project_manager->id,
                    'name' => $project_manager->name,
                                        'company'=> $project_manager->pivot->company_id,
                    'specialty'=> $project_manager->pivot->specialty,
                    'office_phone'=> $project_manager->pivot->office_phone,
                    'role'=>$project_manager->allRoles[0]->name,
                    'job_title'=>$project_manager->allRoles[0]->pivot->job_title,
                    'type'=>'projectManager',
                    'permissions' => $permissions
                ];
            }else{
                return [
                    'id'=> $project_manager->id,
                    'name' => $project_manager->name,
                                        'company'=> $project_manager->pivot->company_id,
                    'specialty'=> $project_manager->pivot->specialty,
                    'office_phone'=> $project_manager->pivot->office_phone,
                    'role'=>'',
                    'job_title'=> '',
                    'type'=>'projectManager',
                    'permissions' => []
                ];
            }

            
        });
        $project->project_managers_permissions = $project_managers_permissions->values();  
          

        return $project;
        
    }

    public function find_api($id)
    {
        $project =  $this->ProjectRepository->with([
        'stakholders','user'
        
        // ,'correspondences'=>function($query){
        //     $query->where('status','!=', 'Closed');
        // }
        
        // ,'punchLists'=>function($query){
        //     $query->orderBy('id', 'desc');
        // }

         
        ])->find($id);

       return $project;
        
    }
    public function delete($id)
    {
        try{
            return $this->ProjectRepository->delete($id);
        }catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

}