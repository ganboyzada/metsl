<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserProjectRequest;
use App\Http\Requests\UserRequest;
use App\Models\Contractor;
use App\Models\Permission;
use App\Models\Project;
use App\Models\Role;
use App\Models\User;
use App\Services\ClientService;
use App\Services\CompanyService;
use App\Services\ContractorService;
use App\Services\DesignTeamService;
use App\Services\ProjectFileService;
use App\Services\ProjectManagerService;
use App\Services\ProjectService;
use App\Services\UserService;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use View;


class StakeholderController extends Controller
{
    public function __construct(
        protected UserService $userService,
        protected ProjectService $projectService ,
        protected ContractorService $contractorService ,
        protected ClientService $clientService ,
        protected DesignTeamService $designTeamService ,
        protected ProjectManagerService $projectmanagerService ,

        )
    {
    }

    public function stakeholders(Request $request){
        $id = Session::get('projectID');
        $stakeholders = $this->userService->getAllProjectStakeholders($id , $request);

     
        return $stakeholders;
    }


    public function update(UserProjectRequest $request){
        \DB::beginTransaction();
        if($request->validated()){
            try{         
                $data = $request->validated();
                //dd($data);
                $user = $this->userService->update($data);
                $user = $this->userService->find($data['user_id']);
                
                \DB::commit();
                // all good
            } catch (\Exception $e) {
                \DB::rollback();
                return response()->json(['error' => $e->getMessage()]);
            }              
             return response()->json(['success' => 'Form submitted successfully.' ]);

        }

    }

    public function destroy(Request $request , $id){
        $project_id = Session::get('projectID');
        $project = $this->projectService->find($project_id);
        $project->stakholders()->detach($id);
        //$user = $this->userService->find($id);
        //$user->userable()->delete();
      //  $this->userService->delete($id);

        

    }
}