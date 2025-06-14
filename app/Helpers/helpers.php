<?php
use App\Models\Permission;
use App\Models\User;



if (!function_exists('checkIfUserHasThisPermission')) {
    function checkIfUserHasThisPermission($project_id , $permission_item = '')
    {
        $permission = Permission::where('name' , $permission_item)->first();
        $permission_id = (isset($permission->id)) ? $permission->id :'';

        $auth_user_id = \Auth::user()->id;
		//dd($permission_id);
        if($permission_item == 'create_projects' || $permission_item  == 'view_all_projects' ||  $permission_item  == 'modify_presets' ||  $permission_item  == 'modify_companies'){
            $user = User::join('model_has_permissions','model_id','=','users.id')
        // ->join('projects_users','projects_users.user_id','=','users.id')
            ->where('users.id',$auth_user_id)                
            ->where('model_has_permissions.permission_id',$permission_id)
        // ->select('users.id')
            ->first();
        }else{
            $user = User::join('model_has_permissions','model_id','=','users.id')
        // ->join('projects_users','projects_users.user_id','=','users.id')
            ->where('users.id',$auth_user_id)
            ->where('model_has_permissions.project_id',$project_id)
                
            ->where('model_has_permissions.permission_id',$permission_id)
        // ->select('users.id')
            ->first();
        }

       
        



        if(isset($user->id) || auth()->user()->is_admin){
            //dd($project_id);
            //dd($user);
            return true;
        }
    


        return false;
    }
}

?>