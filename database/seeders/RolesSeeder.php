<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            [
                'name' => 'admin',
                'slug' => 'admin',
                'permissions' => json_encode([
                    'manage-system', 'manage-users', 'manage-students', 
                    'manage-teachers', 'manage-courses', 'manage-schedules',
                    'register-attendance', 'view-all-attendances', 'manage-justifications',
                    'view-reports', 'manage-settings', 'view-logs'
                ]),
            ],
            [
                'name' => 'teacher',
                'slug' => 'teacher',
                'permissions' => json_encode([
                    'manage-students', 'manage-courses', 'manage-schedules',
                    'register-attendance', 'view-all-attendances', 'manage-justifications',
                    'view-reports'
                ]),
            ],
            [
                'name' => 'student',
                'slug' => 'student',
                'permissions' => json_encode([
                    'view-attendance', 'create-justification'
                ]),
            ],
            [
                'name' => 'staff',
                'slug' => 'staff',
                'permissions' => json_encode([
                    'register-attendance', 'view-all-attendances', 'view-reports'
                ]),
            ],
        ];

        foreach ($roles as $roleData) {
            Role::updateOrCreate(
                ['slug' => $roleData['slug']],
                $roleData
            );
        }

        $this->command->info('✅ Roles creados/actualizados correctamente');
        $this->command->info('   • Admin: Acceso total');
        $this->command->info('   • Teacher: Gestión académica');
        $this->command->info('   • Student: Consulta personal');
        $this->command->info('   • Staff: Registro administrativo');
    }
}

