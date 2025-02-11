<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\Permission;
class RolePermissionCorrespondenceTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //$permissoion = Permission::where('name' , 'assign_correspondence')->orWhere('name','assign correspondence')->first();
        $role = Role::where('name' , 'correspondence')->first();
        /*if(isset($permissoion->id)){
            $role->permissions()->detach($permissoion->id);
        }
        Permission::where('name' , 'assign_correspondence')->delete();
        */
        $enums_list = \App\Enums\CorrespondenceTypeEnum::cases();
        foreach ($enums_list as $enum) {
            $permission = Permission::create(['name' => 'create_'.$enum->value,'guard_name' => 'sanctum']);
            $role->givePermissionTo($permission); 

            $permission = Permission::create(['name' => 'reply_'.$enum->value,'guard_name' => 'sanctum']);
            $role->givePermissionTo($permission); 



            $permission = Permission::create(['name' => 'view_'.$enum->value,'guard_name' => 'sanctum']);
            $role->givePermissionTo($permission);             
        }
       
        
    }
}
