<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Teacher;
use App\Models\Student;
use App\Models\Course;
use App\Models\Attendance;
use App\Models\TechnicalCareer;
use Carbon\Carbon;

class CompleteDataSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Crear 8 profesores
        $teacherNames = [
            ['Carlos Mendoza García', 'carlos.mendoza@istp.edu.pe'],
            ['María Elena Torres', 'maria.torres@istp.edu.pe'],
            ['Juan Pablo Quispe', 'juan.quispe@istp.edu.pe'],
            ['Ana Lucía Flores', 'ana.flores@istp.edu.pe'],
            ['Roberto Salazar Pérez', 'roberto.salazar@istp.edu.pe'],
            ['Patricia Vega Ramos', 'patricia.vega@istp.edu.pe'],
            ['Luis Alberto Cáceres', 'luis.caceres@istp.edu.pe'],
            ['Sandra Paola Huamán', 'sandra.huaman@istp.edu.pe'],
        ];

        foreach ($teacherNames as $index => $teacher) {
            $user = User::create([
                'name' => $teacher[0],
                'email' => $teacher[1],
                'password' => bcrypt('password'),
                'role_id' => 2, // Teacher
                'active' => true,
            ]);

            Teacher::create([
                'user_id' => $user->id,
                'code' => 'DOC' . str_pad($index + 1, 4, '0', STR_PAD_LEFT),
                'dni' => '7' . str_pad($index + 5000000, 7, '0', STR_PAD_LEFT),
                'phone' => '9' . rand(10000000, 99999999),
                'address' => 'Av. Principal ' . rand(100, 999),
                'specialization' => $this->getSpecialization($index),
                'active' => true,
            ]);
        }

        // 2. Obtener carreras
        $careers = TechnicalCareer::all();

        // 3. Crear 50 estudiantes distribuidos en las carreras
        $firstNames = ['Juan', 'María', 'Carlos', 'Ana', 'Luis', 'Rosa', 'Pedro', 'Carmen', 'José', 'Laura', 'Miguel', 'Sofia', 'Diego', 'Valentina', 'Andrés', 'Camila', 'Roberto', 'Isabella', 'Fernando', 'Lucía'];
        $lastNames = ['García', 'Rodríguez', 'Martínez', 'López', 'González', 'Pérez', 'Sánchez', 'Ramírez', 'Torres', 'Flores', 'Rivera', 'Gómez', 'Díaz', 'Cruz', 'Morales', 'Jiménez', 'Hernández', 'Medina', 'Castro', 'Vargas'];

        for ($i = 1; $i <= 80; $i++) {
            $firstName = $firstNames[array_rand($firstNames)];
            $lastName1 = $lastNames[array_rand($lastNames)];
            $lastName2 = $lastNames[array_rand($lastNames)];
            $fullName = "$firstName $lastName1 $lastName2";
            
            $career = $careers->random();
            $semester = rand(1, 6);
            
            $user = User::create([
                'name' => $fullName,
                'email' => strtolower(str_replace(' ', '.', $firstName . '.' . $lastName1)) . $i . '@estudiante.istp.edu.pe',
                'password' => bcrypt('password'),
                'role_id' => 4, // Student
                'active' => true,
            ]);

            Student::create([
                'user_id' => $user->id,
                'dni' => '7' . str_pad(rand(1000000, 9999999), 7, '0', STR_PAD_LEFT),
                'code' => 'EST' . date('Y') . str_pad($i, 4, '0', STR_PAD_LEFT),
                'student_code' => 'EST' . date('Y') . str_pad($i, 4, '0', STR_PAD_LEFT),
                'email' => $user->email,
                'technical_career_id' => $career->id,
                'semester' => $semester,
                'phone' => '9' . rand(10000000, 99999999),
                'birth_date' => Carbon::now()->subYears(rand(18, 25))->subDays(rand(0, 365)),
                'address' => 'Calle ' . rand(1, 50) . ' #' . rand(100, 999),
                'active' => true,
            ]);
        }

        // 4. Crear 30 cursos
        $courseNames = [
            ['Matemática I', 'MAT101'],
            ['Comunicación', 'COM101'],
            ['Computación Básica', 'INF101'],
            ['Inglés I', 'ING101'],
            ['Matemática II', 'MAT102'],
            ['Química General', 'QUI101'],
            ['Física I', 'FIS101'],
            ['Biología', 'BIO101'],
            ['Estadística', 'EST101'],
            ['Contabilidad Básica', 'CON101'],
            ['Administración I', 'ADM101'],
            ['Marketing', 'MKT101'],
            ['Programación I', 'PRG101'],
            ['Base de Datos', 'BDD101'],
            ['Redes', 'RED101'],
            ['Cocina Básica', 'COC101'],
            ['Pastelería', 'PAS101'],
            ['Nutrición', 'NUT101'],
            ['Enfermería Básica', 'ENF101'],
            ['Anatomía', 'ANA101'],
            ['Ganadería', 'GAN101'],
            ['Agricultura', 'AGR101'],
            ['Veterinaria Básica', 'VET101'],
            ['Turismo I', 'TUR101'],
            ['Hotelería', 'HOT101'],
            ['Gestión Empresarial', 'GES101'],
            ['Economía', 'ECO101'],
            ['Derecho Laboral', 'DER101'],
            ['Ética Profesional', 'ETI101'],
            ['Emprendimiento', 'EMP101'],
        ];

        $teachers = Teacher::all();
        
        foreach ($courseNames as $index => $course) {
            Course::create([
                'code' => $course[1],
                'name' => $course[0],
                'description' => "Curso de {$course[0]} para la carrera técnica",
            ]);
        }

        // 5. Crear registros de asistencia de los últimos 30 días
        $students = Student::all();
        $statuses = ['present', 'absent', 'late'];
        
        for ($day = 29; $day >= 0; $day--) {
            $date = Carbon::today()->subDays($day);
            
            // 80% de los estudiantes registran asistencia cada día
            $studentsForDay = $students->random(intval($students->count() * 0.8));
            
            foreach ($studentsForDay as $student) {
                // 85% presente, 10% tarde, 5% ausente
                $rand = rand(1, 100);
                if ($rand <= 85) {
                    $status = 'present';
                } elseif ($rand <= 95) {
                    $status = 'late';
                } else {
                    $status = 'absent';
                }
                
                Attendance::create([
                    'student_id' => $student->id,
                    'course_assignment_id' => null,
                    'date' => $date,
                    'time' => Carbon::createFromTime(rand(7, 9), rand(0, 59), 0)->format('H:i:s'),
                    'status' => $status,
                    'registered_by' => 1,
                    'notes' => $status === 'late' ? 'Llegó tarde' : ($status === 'absent' ? 'Inasistencia' : 'Presente'),
                    'attendance_source' => 'in_class',
                    'location' => 'Entrada Principal',
                    'device_token' => null,
                ]);
            }
        }

        $this->command->info('✅ Datos de prueba creados:');
        $this->command->info("   - 8 profesores");
        $this->command->info("   - 80 estudiantes");
        $this->command->info("   - 30 cursos");
        $this->command->info("   - " . Attendance::count() . " registros de asistencia (últimos 30 días)");
    }

    private function getSpecialization($index)
    {
        $specializations = [
            'Matemática',
            'Comunicación',
            'Computación',
            'Inglés',
            'Contabilidad',
            'Administración',
            'Gastronomía',
            'Enfermería',
        ];
        
        return $specializations[$index] ?? 'General';
    }
}
