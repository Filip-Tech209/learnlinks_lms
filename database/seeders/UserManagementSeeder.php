<?php

namespace Database\Seeders;

use App\Models\{User, Role, Permission};
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserManagementSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Define and Create Permissions
        $manageUsers = Permission::create(['permission_name' => 'manage_users']);
        $manageCourses = Permission::create(['permission_name' => 'manage_courses']);
        $gradeAssessments = Permission::create(['permission_name' => 'grade_assessments']);

        // 2. Create Roles
        $adminRole = Role::create(['role_name' => 'Super Administrator']);
        $instructorRole = Role::create(['role_name' => 'Instructor']);
        $studentRole = Role::create(['role_name' => 'Student']);

        // 3. Populate Pivot Table (permission_role)
        // Admin gets all permissions
        $adminRole->permissions()->attach([
            $manageUsers->id, 
            $manageCourses->id, 
            $gradeAssessments->id
        ]);

        // Instructor gets specific permissions
        $instructorRole->permissions()->attach([
            $manageCourses->id, 
            $gradeAssessments->id
        ]);

        // 4. Create Sample Users
        User::create([
            'name' => 'System Admin',
            'email' => 'admin@learnlink.com',
            'password' => Hash::make('password123'),
            'role_id' => $adminRole->id,
            'status' => 'active',
        ]);

        User::create([
            'name' => 'John Instructor',
            'email' => 'instructor@learnlink.com',
            'password' => Hash::make('password123'),
            'role_id' => $instructorRole->id,
            'status' => 'active',
        ]);

        User::create([
            'name' => 'Mark Student',
            'email' => 'mark@learnlink.com',
            'password' => Hash::make('password123'),
            'role_id' => $studentRole->id,
            'status' => 'active',
        ]);

        User::create([
            'name' => 'Inactive Student',
            'email' => 'inactive@learnlink.com',
            'password' => Hash::make('password123'),
            'role_id' => $studentRole->id,
            'status' => 'suspended',
        ]);
    }
}