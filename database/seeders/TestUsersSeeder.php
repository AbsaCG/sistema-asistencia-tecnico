<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Teacher;
use App\Models\Student;

class TestUsersSeeder extends Seeder
{
    public function run(): void
    {
        // Crear usuario profesor de prueba
        $teacherUser = User::firstOrCreate(
            ['email' => 'profesor@istp.edu.pe'],
            [
                'name' => 'Profesor de Prueba',
                'password' => bcrypt('password'),
                'role_id' => 2, // Teacher
                'active' => true,
            ]
        );

        if (!Teacher::where('user_id', $teacherUser->id)->exists()) {
            Teacher::create([
                'user_id' => $teacherUser->id,
                'code' => 'DOC9999',
                'dni' => '99999999',
                'phone' => '999999999',
                'address' => 'Dirección de prueba',
                'specialization' => 'General',
                'active' => true,
            ]);
        }

        // Crear usuario estudiante de prueba
        $studentUser = User::firstOrCreate(
            ['email' => 'estudiante@istp.edu.pe'],
            [
                'name' => 'Estudiante de Prueba',
                'password' => bcrypt('password'),
                'role_id' => 4, // Student
                'active' => true,
            ]
        );

        if (!Student::where('user_id', $studentUser->id)->exists()) {
            Student::create([
                'user_id' => $studentUser->id,
                'dni' => '88888888',
                'code' => 'EST20259999',
                'student_code' => 'EST20259999',
                'email' => 'estudiante@istp.edu.pe',
                'technical_career_id' => 1, // Primera carrera
                'semester' => 1,
                'phone' => '888888888',
                'birth_date' => '2005-01-01',
                'address' => 'Dirección de prueba',
                'active' => true,
            ]);
        }

        $this->command->info('✅ Usuarios de prueba creados:');
        $this->command->info('   - profesor@istp.edu.pe / password');
        $this->command->info('   - estudiante@istp.edu.pe / password');
        $this->command->info('   - admin@istp.edu.pe / password (ya existe)');
    }
}
