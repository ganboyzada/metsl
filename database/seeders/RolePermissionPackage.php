<?php
namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\Permission;
class RolePermissionPackage extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $role = Role::create(['name' => 'Package','guard_name' => 'sanctum']);
        $permission = Permission::create(['name' => 'create_package','guard_name' => 'sanctum']);
        $role->givePermissionTo($permission); 
        $permission = Permission::create(['name' => 'ediet_package','guard_name' => 'sanctum']);
        $role->givePermissionTo($permission);
       
        
    }
}

