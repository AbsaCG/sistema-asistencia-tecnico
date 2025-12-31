<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\User;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Roles
        $adminRole = Role::create([
            'name' => 'Administrador',
            'slug' => 'admin',
            'permissions' => json_encode([]),
        ]);

        $teacherRole = Role::create([
            'name' => 'Docente',
            'slug' => 'teacher',
            'permissions' => json_encode([]),
        ]);

        $parentRole = Role::create([
            'name' => 'Apoderado',
            'slug' => 'parent',
            'permissions' => json_encode([]),
        ]);

        $studentRole = Role::create([
            'name' => 'Estudiante',
            'slug' => 'student',
            'permissions' => json_encode([]),
        ]);

        $userRole = Role::create([
            'name' => 'Usuario',
            'slug' => 'user',
            'permissions' => json_encode([]),
        ]);

        // Create Permissions and attach to roles (normalized)
        $perms = [
            'manage_users', 'manage_roles', 'manage_students', 'manage_teachers',
            'manage_attendance', 'generate_reports', 'manage_settings', 'manage_permissions',
            'register_attendance', 'view_students', 'view_reports', 'view_own_classes',
            'view_own_student_attendance', 'view_own_reports', 'view_own_attendance',
            'submit_justifications', 'view_own_schedule'
        ];

        $permissionMap = [];
        foreach ($perms as $p) {
            $permissionMap[$p] = \App\Models\Permission::firstOrCreate(['slug' => $p], ['name' => $p, 'description' => '']);
        }

        // attach permissions to roles
        $adminRole->permissionModels()->sync([
            $permissionMap['manage_users']->id,
            $permissionMap['manage_roles']->id,
            $permissionMap['manage_students']->id,
            $permissionMap['manage_teachers']->id,
            $permissionMap['manage_attendance']->id,
            $permissionMap['generate_reports']->id,
            $permissionMap['manage_settings']->id,
            $permissionMap['manage_permissions']->id,
        ]);

        $teacherRole->permissionModels()->sync([
            $permissionMap['register_attendance']->id,
            $permissionMap['view_students']->id,
            $permissionMap['view_reports']->id,
            $permissionMap['view_own_classes']->id,
        ]);

        $parentRole->permissionModels()->sync([
            $permissionMap['view_own_student_attendance']->id,
            $permissionMap['view_own_reports']->id,
        ]);

        $studentRole->permissionModels()->sync([
            $permissionMap['view_own_attendance']->id,
            $permissionMap['view_own_schedule']->id,
            $permissionMap['submit_justifications']->id,
        ]);

        // Create Admin User
        User::create([
            'name' => 'Administrador',
            'email' => 'admin@istp.edu.pe',
            'password' => bcrypt('password'),
            'role_id' => $adminRole->id,
            'active' => true,
        ]);

        // Create Sample Teacher User
        User::create([
            'name' => 'Prof. Ana García',
            'email' => 'ana@example.com',
            'password' => bcrypt('password'),
            'role_id' => $teacherRole->id,
            'active' => true,
        ]);

        // Create Sample Parent User
        User::create([
            'name' => 'Juan Pérez Apoderado',
            'email' => 'padre@example.com',
            'password' => bcrypt('password'),
            'role_id' => $parentRole->id,
            'active' => true,
        ]);

        // Create Sample Student User
        $studentUser = User::create([
            'name' => 'Carlos Estudiante',
            'email' => 'estudiante@example.com',
            'password' => bcrypt('password'),
            'role_id' => $studentRole->id,
            'active' => true,
        ]);

        // Create Student record linked to user
        // Need to get a program first
        $firstProgram = \App\Models\Program::first();
        if ($firstProgram) {
            \App\Models\Student::create([
                'user_id' => $studentUser->id,
                'dni' => '99999999',
                'code' => 'EST-2024-001',
                'program_id' => $firstProgram->id,
                'status' => 'active',
            ]);
        }
    }
}
