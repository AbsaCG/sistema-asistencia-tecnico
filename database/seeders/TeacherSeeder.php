<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use App\Models\Teacher;
use Illuminate\Support\Facades\Hash;

class TeacherSeeder extends Seeder
{
    public function run(): void
    {
        $teacherRole = Role::where('name', 'Docente')->first();
        
        $teachers = [
            [
                'name' => 'Carlos Mendoza García',
                'email' => 'carlos.mendoza@istp.edu.pe',
                'dni' => '45123456',
                'code' => 'DOC001',
                'specialization' => 'Ingeniería Agropecuaria',
            ],
            [
                'name' => 'María Elena Torres',
                'email' => 'maria.torres@istp.edu.pe',
                'dni' => '45234567',
                'code' => 'DOC002',
                'specialization' => 'Contabilidad y Finanzas',
            ],
            [
                'name' => 'Juan Pablo Quispe',
                'email' => 'juan.quispe@istp.edu.pe',
                'dni' => '45345678',
                'code' => 'DOC003',
                'specialization' => 'Desarrollo de Software',
            ],
            [
                'name' => 'Ana Lucía Flores',
                'email' => 'ana.flores@istp.edu.pe',
                'dni' => '45456789',
                'code' => 'DOC004',
                'specialization' => 'Gastronomía y Arte Culinario',
            ],
            [
                'name' => 'Roberto Salazar Pérez',
                'email' => 'roberto.salazar@istp.edu.pe',
                'dni' => '45567890',
                'code' => 'DOC005',
                'specialization' => 'Enfermería Técnica',
            ],
            [
                'name' => 'Patricia Vega Ramos',
                'email' => 'patricia.vega@istp.edu.pe',
                'dni' => '45678901',
                'code' => 'DOC006',
                'specialization' => 'Matemáticas Aplicadas',
            ],
            [
                'name' => 'Luis Alberto Cáceres',
                'email' => 'luis.caceres@istp.edu.pe',
                'dni' => '45789012',
                'code' => 'DOC007',
                'specialization' => 'Comunicación',
            ],
            [
                'name' => 'Sandra Paola Huamán',
                'email' => 'sandra.huaman@istp.edu.pe',
                'dni' => '45890123',
                'code' => 'DOC008',
                'specialization' => 'Desarrollo de Software',
            ],
        ];

        foreach ($teachers as $teacherData) {
            // Crear usuario
            $user = User::create([
                'name' => $teacherData['name'],
                'email' => $teacherData['email'],
                'password' => Hash::make('password'),
                'role_id' => $teacherRole->id,
            ]);

            // Crear registro de teacher
            Teacher::create([
                'user_id' => $user->id,
                'code' => $teacherData['code'],
                'dni' => $teacherData['dni'],
                'specialization' => $teacherData['specialization'],
                'phone' => '9' . str_pad(rand(10000000, 99999999), 8, '0'),
                'address' => 'Dirección de ejemplo',
                'active' => true,
            ]);
        }

        $this->command->info('✅ ' . count($teachers) . ' profesores creados exitosamente');
    }
}
