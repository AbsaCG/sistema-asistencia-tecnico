<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Student;
use App\Models\User;
use App\Models\TechnicalCareer;

class StudentSeeder extends Seeder
{
    public function run(): void
    {
        // Obtener la primera carrera técnica para asignar a los estudiantes
        $career = TechnicalCareer::first();
        
        if (!$career) {
            echo "No hay carreras técnicas disponibles. Ejecuta primero TechnicalCareerSeeder.\n";
            return;
        }

        // Obtener el usuario estudiante que ya existe
        $studentUser = User::where('email', 'estudiante@example.com')->first();
        
        if ($studentUser) {
            // Verificar si ya existe el estudiante
            $existingStudent = Student::where('user_id', $studentUser->id)->first();
            
            if (!$existingStudent) {
                Student::create([
                    'user_id' => $studentUser->id,
                    'dni' => '99999999',
                    'student_code' => 'EST-2024-001',
                    'technical_career_id' => $career->id,
                    'student_status' => 'activo',
                    'semester' => 1,
                    'birth_date' => '2000-01-01',
                    'active' => true,
                ]);
                echo "Estudiante Carlos creado con DNI: 99999999\n";
            }
        }

        // Crear 10 estudiantes de prueba adicionales
        $studentRole = \App\Models\Role::where('slug', 'student')->first();
        
        for ($i = 1; $i <= 10; $i++) {
            $dni = str_pad(70000000 + $i, 8, '0', STR_PAD_LEFT);
            
            // Verificar si ya existe
            $existingUser = User::where('email', "estudiante{$i}@example.com")->first();
            
            if (!$existingUser) {
                $user = User::create([
                    'name' => "Estudiante Test {$i}",
                    'email' => "estudiante{$i}@example.com",
                    'password' => bcrypt('password'),
                    'role_id' => $studentRole->id,
                    'active' => true,
                ]);

                Student::create([
                    'user_id' => $user->id,
                    'dni' => $dni,
                    'student_code' => "EST-2024-" . str_pad($i + 1, 3, '0', STR_PAD_LEFT),
                    'technical_career_id' => $career->id,
                    'student_status' => 'activo',
                    'semester' => 1,
                    'birth_date' => '2000-0' . ($i % 9 + 1) . '-15',
                    'active' => true,
                ]);
                
                echo "Estudiante {$i} creado con DNI: {$dni}\n";
            }
        }
    }
}
