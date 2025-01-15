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
        $permission = Permission::create(['name' => 'add_correspondence','guard_name' => 'sanctum']);
        $role->givePermissionTo($permission); 

        $permission = Permission::create(['name' => 'assign_correspondence','guard_name' => 'sanctum']);
        $role->givePermissionTo($permission);

        $permission = Permission::create(['name' => 'distribution_members_correspondence','guard_name' => 'sanctum']);
        $role->givePermissionTo($permission);
        
        $permission = Permission::create(['name' => 'view_all_RFI_correspondence','guard_name' => 'sanctum']);
        $role->givePermissionTo($permission);

        $permission = Permission::create(['name' => 'view_all_RFV_correspondence','guard_name' => 'sanctum']);
        $role->givePermissionTo($permission);

        $permission = Permission::create(['name' => 'view_all_RFC_correspondence','guard_name' => 'sanctum']);
        $role->givePermissionTo($permission);



        $role = Role::create(['name' => 'documents','guard_name' => 'sanctum']);
        $permission = Permission::create(['name' => 'view_all_documents','guard_name' => 'sanctum']);
        $role->givePermissionTo($permission); 

        $permission = Permission::create(['name' => 'add_documents','guard_name' => 'sanctum']);
        $role->givePermissionTo($permission);


        $permission = Permission::create(['name' => 'review_documents','guard_name' => 'sanctum']);
        $role->givePermissionTo($permission);
		
		
        $permission = Permission::create(['name' => 'add_document_revision','guard_name' => 'sanctum']);
        $role->givePermissionTo($permission);	

        $permission = Permission::create(['name' => 'view_all_document_revisions','guard_name' => 'sanctum']);
        $role->givePermissionTo($permission);

        $permission = Permission::create(['name' => 'add_revision_comment','guard_name' => 'sanctum']);
        $role->givePermissionTo($permission);



        $role = Role::create(['name' => 'metting planing','guard_name' => 'sanctum']);
        $permission = Permission::create(['name' => 'view_all_meeting_planing','guard_name' => 'sanctum']);
        $role->givePermissionTo($permission);

        $permission = Permission::create(['name' => 'add_meeting_planing','guard_name' => 'sanctum']);
        $role->givePermissionTo($permission); 
		
		$permission = Permission::create(['name' => 'participate_in_meetings','guard_name' => 'sanctum']);
        $role->givePermissionTo($permission); 

        $role = Role::create(['name' => 'punch list','guard_name' => 'sanctum']);
        $permission = Permission::create(['name' => 'view_all_punch_list','guard_name' => 'sanctum']);
        $role->givePermissionTo($permission);

        $permission = Permission::create(['name' => 'add_punch_list','guard_name' => 'sanctum']);
        $role->givePermissionTo($permission); 
		
		$permission = Permission::create(['name' => 'distribution_members_punch_list','guard_name' => 'sanctum']);
        $role->givePermissionTo($permission); 

		$permission = Permission::create(['name' => 'responsible_punch_list','guard_name' => 'sanctum']);
        $role->givePermissionTo($permission); 
		
    }
}
