<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProjectRequest;
use App\Http\Requests\UserRequest;
use App\Models\Contractor;
use App\Services\ClientService;
use App\Services\CompanyService;
use App\Services\ContractorService;
use App\Services\DesignTeamService;
use App\Services\ProjectManagerService;
use App\Services\ProjectService;
use App\Services\UserService;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use App\Models\Permission;
use App\Models\Role;
use View;


class ProjectController extends Controller
{
    public function __construct(
        protected ProjectService $projectService , 
        protected ContractorService $contractorService ,
        protected ClientService $clientService ,
        protected DesignTeamService $designTeamService ,
        protected ProjectManagerService $projectmanagerService ,
        protected UserService $userService

        )
    {
    }

    public function allProjects(){
        $projects = $this->projectService->all();

       // dd($this->contractorService->projectsOfContractor(1)[0]->projects);
        return view('metsl.pages.projects.projects', get_defined_vars());
    }

    public function create(){
        //$proj = \App\Models\Project::where('id' , 3)->with('stakholders.roles')->first();
        //$proj = \App\Models\User::where('id' , 3)->with('roles.pivot.project')->first();
       // $proj = \App\Models\Project::where('id' , 3)->with('usersViaRole')->first();
      // $proj = \App\Models\User::with(['roles.pivot.project' => function ($query) {
        //$query->where('id', 3);
        //}])->where('users.id' , 3)->first();

        //$roles = \App\Models\ModelHasRoles::where('project_id',3)->where('model_id',3)
        //->with('role')->get();
        //print('<pre>');
        //$user  = \App\Models\User::where('id' , 3)->with('userable')->first();
        //dd($user->userable);
        $clients = $this->clientService->all();
        $contractors = $this->contractorService->all();
        //dd($contractors[0]->user->id);
        $design_teams = $this->designTeamService->all();
        $project_managers = $this->projectmanagerService->all();
        $roles = Role::with('permissions')->get();
        $role_permission_arr = [];
        if($roles->count() > 0){
            foreach($roles as $role){
                $role_permission_arr[$role->name] = $role->permissions->pluck('name')->toArray();
            }
        }
        $permissions = Permission::all();
       // $c = Contractor::where('id',23)->with('user.permissions')->first();
        //dd($c->user->permissions);

        return view('metsl.pages.projects..wizard.project-wizard', get_defined_vars());
    }


    public function store_user(UserRequest $request){
        \DB::beginTransaction();
        if($request->validated()){
            try{         
                $data = $request->validated();
                //dd($data['user_type']);
                $data['user_name']=$data['first_name'].'_'.$data['last_name'];
                if($data['user_type'] == 'client'){
                    $model = $this->clientService->create($data);
                    $user = $this->userService->create($data);
                    $model->user()->save($user);                
                }else if($data['user_type'] == 'contractor'){
                    $model = $this->contractorService->create($data);
                    $user = $this->userService->create($data);
                    $model->user()->save($user);
                }else if($data['user_type'] == 'designTeam'){
                    $model = $this->designTeamService->create($data);
                    $user = $this->userService->create($data);
                    $model->user()->save($user);                
                }else if($data['user_type'] == 'projectManager'){
                // dd('ok');
                    $model = $this->projectmanagerService->create($data);
                    $user = $this->userService->create($data);
                    $model->user()->save($user);                
                }
                
                \DB::commit();
                // all good
            } catch (\Exception $e) {
                \DB::rollback();
                return response()->json(['error' => $e->getMessage()]);
            }              
             return response()->json(['success' => 'Form submitted successfully.' , 'data'=>$model , 'user'=>$user]);

        }

    }

    public function store(ProjectRequest  $request)
    {
        if($request->validated()){
            \DB::beginTransaction();
            try{
                $all_data = request()->all();
                $all_data['all_stakholders'] = json_decode($all_data['all_stakholders']);
                $model = $this->projectService->create($all_data);
            \DB::commit();
            // all good
            } catch (\Exception $e) {
                \DB::rollback();
                return response()->json(['error' => $e->getMessage()]);
            }

                       
            return response()->json(['success' => 'Form submitted successfully.' , 'data'=>$model]);

        }
    }



}