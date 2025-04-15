<?php

namespace Database\Seeders;

// path: database/seeders/RoleSeeder.php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        // Create roles
        $admin = Role::create(['name' => 'admin']);
        $teacher = Role::create(['name' => 'teacher']);
        $student = Role::create(['name' => 'student']);

        // Create permissions
        Permission::create(['name' => 'manage-users']);
        Permission::create(['name' => 'manage-students']);
        Permission::create(['name' => 'assign-marks']);
        Permission::create(['name' => 'manage-homework']);
        Permission::create(['name' => 'view-performance']);

        // Assign permissions
        $admin->givePermissionTo(['manage-users', 'manage-students']);
        $teacher->givePermissionTo(['manage-students', 'assign-marks', 'manage-homework']);
        $student->givePermissionTo(['view-performance']);
    }
}
