<?php
use App\Models\Permission;
use App\Models\User;



if (!function_exists('checkIfUserHasThisPermission')) {
    function checkIfUserHasThisPermission($project_id , $permission_item = '')
    {
		//dd($project_id);
        $permission = Permission::where('name' , $permission_item)->first();
        $permission_id = (isset($permission->id)) ? $permission->id :'';

        $auth_user_id = \Auth::user()->id;
       
        
        $user = User::join('model_has_permissions','model_id','=','users.id')
       // ->join('projects_users','projects_users.user_id','=','users.id')
        ->where('users.id',$auth_user_id)
        ->where('model_has_permissions.project_id',$project_id)
               
         ->where('model_has_permissions.permission_id',$permission_id)
       // ->select('users.id')
        ->first();


        if(isset($user->id) || auth()->user()->is_admin){
            //dd($project_id);
            //dd($user);
            return true;
        }
    


        return false;
    }
}

?>