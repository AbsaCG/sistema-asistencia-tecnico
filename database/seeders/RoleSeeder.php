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
            'permissions' => json_encode([
                'manage_users', 'manage_roles', 'manage_students', 'manage_teachers',
                'manage_attendance', 'generate_reports', 'manage_settings', 'manage_permissions'
            ]),
        ]);

        $teacherRole = Role::create([
            'name' => 'Docente',
            'slug' => 'teacher',
            'permissions' => json_encode([
                'register_attendance', 'view_students', 'view_reports', 'view_own_classes'
            ]),
        ]);

        $parentRole = Role::create([
            'name' => 'Apoderado',
            'slug' => 'parent',
            'permissions' => json_encode([
                'view_own_student_attendance', 'view_own_reports'
            ]),
        ]);

        $userRole = Role::create([
            'name' => 'Usuario',
            'slug' => 'user',
            'permissions' => json_encode([]),
        ]);

        // Create Admin User
        User::create([
            'name' => 'Administrador',
            'email' => 'admin@example.com',
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
    }
}
