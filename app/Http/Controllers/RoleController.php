<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProjectRequest;
use App\Http\Requests\UserRequest;
use App\Models\Contractor;
use App\Models\Permission;
use App\Models\Project;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use View;


class RoleController extends Controller
{




    public function index(){
        $roles = Role::with('permissions')->get();
        return view('metsl.pages.roles.index', get_defined_vars());
    }

    public function create(Request $request){

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

        return view('metsl.pages.roles.create', get_defined_vars());
    }



    public function store(Request  $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:roles,name',
            "permissions"    => "required|array",
            "permissions.*"  => "required|distinct",
        ]);
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $role = Role::create([
            'name' => $request->name,
        ]);
        if($request->permissions){
            $role->permissions()->sync($request->permissions);
        }
        return redirect()->route('roles.create')->with('success' , 'Role created successfully');
    }

    public function edit(Request $request , $id){

        $role = Role::where('id' , $id)->with('permissions')->first();
 
  
        $permissions = Permission::all();
       // $c = Contractor::where('id',23)->with('user.permissions')->first();
        //dd($c->user->permissions);

        return view('metsl.pages.roles.edit', get_defined_vars());
    }

    public function update(Request  $request , $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:roles,name,'.$id,
            "permissions"    => "required|array",
            "permissions.*"  => "required|distinct",
        ]);
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $role = Role::where('id' , $id)->first();
        $role->name = $request->name;
        $role->save();
        if($request->permissions){
            $role->permissions()->sync($request->permissions);
        }
        return redirect()->back()->with('success' , 'Role updated successfully');
    }

    public function destroy($id){
        $role = Role::where('id' , $id)->first();
        
        $role->permissions()->detach();
        Role::where('id' , $id)->delete();
        return redirect()->back()->with('success' , 'Item deleted successfully');

        
    }


}
