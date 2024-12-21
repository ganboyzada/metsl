<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\Permission;
class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {


        $role = Role::create(['name' => 'correspondence','guard_name' => 'sanctum']);
        $permission = Permission::create(['name' => 'add correspondence','guard_name' => 'sanctum']);
        $role->givePermissionTo($permission); 

        $permission = Permission::create(['name' => 'assign correspondence','guard_name' => 'sanctum']);
        $role->givePermissionTo($permission);

        $permission = Permission::create(['name' => 'distribution members correspondence','guard_name' => 'sanctum']);
        $role->givePermissionTo($permission);
        
        $permission = Permission::create(['name' => 'view  all RFI correspondence','guard_name' => 'sanctum']);
        $role->givePermissionTo($permission);

        $permission = Permission::create(['name' => 'view  all RFV correspondence','guard_name' => 'sanctum']);
        $role->givePermissionTo($permission);

        $permission = Permission::create(['name' => 'view  all RFC correspondence','guard_name' => 'sanctum']);
        $role->givePermissionTo($permission);



        $role = Role::create(['name' => 'documents','guard_name' => 'sanctum']);
        $permission = Permission::create(['name' => 'view all documents','guard_name' => 'sanctum']);
        $role->givePermissionTo($permission); 

        $permission = Permission::create(['name' => 'add documents','guard_name' => 'sanctum']);
        $role->givePermissionTo($permission);


        $permission = Permission::create(['name' => 'review documents','guard_name' => 'sanctum']);
        $role->givePermissionTo($permission);
		
		
        $permission = Permission::create(['name' => 'add document revision','guard_name' => 'sanctum']);
        $role->givePermissionTo($permission);	

        $permission = Permission::create(['name' => 'view all document revisions','guard_name' => 'sanctum']);
        $role->givePermissionTo($permission);

        $permission = Permission::create(['name' => 'add revision comment','guard_name' => 'sanctum']);
        $role->givePermissionTo($permission);



        $role = Role::create(['name' => 'metting planing','guard_name' => 'sanctum']);
        $permission = Permission::create(['name' => 'view all meeting planing','guard_name' => 'sanctum']);
        $role->givePermissionTo($permission);

        $permission = Permission::create(['name' => 'add meeting planing','guard_name' => 'sanctum']);
        $role->givePermissionTo($permission); 
		
		$permission = Permission::create(['name' => 'participate meeting planing','guard_name' => 'sanctum']);
        $role->givePermissionTo($permission); 

        $role = Role::create(['name' => 'punch list','guard_name' => 'sanctum']);
        $permission = Permission::create(['name' => 'view all punch list','guard_name' => 'sanctum']);
        $role->givePermissionTo($permission);

        $permission = Permission::create(['name' => 'add punch list','guard_name' => 'sanctum']);
        $role->givePermissionTo($permission); 
		
		$permission = Permission::create(['name' => 'distribution members punch list','guard_name' => 'sanctum']);
        $role->givePermissionTo($permission); 

		$permission = Permission::create(['name' => 'responsible punch list','guard_name' => 'sanctum']);
        $role->givePermissionTo($permission); 
		
    }
}
