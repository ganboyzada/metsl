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
        $role = Role::create(['name' => 'viewer','guard_name' => 'sanctum']);
        $permission = Permission::create(['name' => 'view','guard_name' => 'sanctum']);
        $role->givePermissionTo($permission);


        $role = Role::create(['name' => 'editor','guard_name' => 'sanctum']);
        $permission = Permission::create(['name' => 'edit','guard_name' => 'sanctum']);
        $role->givePermissionTo($permission);


        $role = Role::create(['name' => 'approver','guard_name' => 'sanctum']);
        $permission = Permission::create(['name' => 'approve','guard_name' => 'sanctum']);
        $role->givePermissionTo($permission);

        $role = Role::create(['name' => 'correspondence','guard_name' => 'sanctum']);
        $permission = Permission::create(['name' => 'assign correspondence','guard_name' => 'sanctum']);
        $role->givePermissionTo($permission);

        $permission = Permission::create(['name' => 'Distribution Members correspondence','guard_name' => 'sanctum']);
        $role->givePermissionTo($permission);
        
        $permission = Permission::create(['name' => 'view RFI correspondence','guard_name' => 'sanctum']);
        $role->givePermissionTo($permission);

        $permission = Permission::create(['name' => 'view RFV correspondence','guard_name' => 'sanctum']);
        $role->givePermissionTo($permission);

        $permission = Permission::create(['name' => 'view RFC correspondence','guard_name' => 'sanctum']);
        $role->givePermissionTo($permission);



    }
}
