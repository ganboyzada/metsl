<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\Permission;
class RolePermissionTaskPlanner extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $role = Role::create(['name' => 'Task Planner','guard_name' => 'sanctum']);
        $permission = Permission::create(['name' => 'create_task_planner','guard_name' => 'sanctum']);
        $role->givePermissionTo($permission); 

        $permission = Permission::create(['name' => 'assign_task','guard_name' => 'sanctum']);
        $role->givePermissionTo($permission);
       
        
    }
}
