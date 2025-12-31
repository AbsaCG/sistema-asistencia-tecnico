<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Faculty;
use App\Models\Program;

class UniversityStructureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Faculties
        $engineeringFaculty = Faculty::create([
            'name' => 'Facultad de Ingeniería',
            'slug' => 'ingenieria',
            'description' => 'Facultad responsable de programas de ingeniería',
            'dean_name' => 'Dr. Carlos Rodríguez',
            'dean_email' => 'dean.engineering@university.edu',
            'is_active' => true,
        ]);

        $sciencesFaculty = Faculty::create([
            'name' => 'Facultad de Ciencias',
            'slug' => 'ciencias',
            'description' => 'Facultad de ciencias exactas y naturales',
            'dean_name' => 'Dra. María González',
            'dean_email' => 'dean.sciences@university.edu',
            'is_active' => true,
        ]);

        $businessFaculty = Faculty::create([
            'name' => 'Facultad de Administración',
            'slug' => 'administracion',
            'description' => 'Facultad de administración y negocios',
            'dean_name' => 'Lic. Roberto Martínez',
            'dean_email' => 'dean.business@university.edu',
            'is_active' => true,
        ]);

        $humanitiesFaculty = Faculty::create([
            'name' => 'Facultad de Humanidades',
            'slug' => 'humanidades',
            'description' => 'Facultad de letras y humanidades',
            'dean_name' => 'Dra. Laura Pérez',
            'dean_email' => 'dean.humanities@university.edu',
            'is_active' => true,
        ]);

        // Create Programs under Engineering
        Program::create([
            'faculty_id' => $engineeringFaculty->id,
            'name' => 'Ingeniería en Sistemas',
            'slug' => 'ing-sistemas',
            'code' => 'ISC-2024',
            'duration_semesters' => 8,
            'total_credits' => 240,
            'description' => 'Programa de Ingeniería en Sistemas Computacionales',
            'coordinator_email' => 'coord.sistemas@university.edu',
            'is_active' => true,
        ]);

        Program::create([
            'faculty_id' => $engineeringFaculty->id,
            'name' => 'Ingeniería Civil',
            'slug' => 'ing-civil',
            'code' => 'ICVL-2024',
            'duration_semesters' => 10,
            'total_credits' => 280,
            'description' => 'Programa de Ingeniería Civil',
            'coordinator_email' => 'coord.civil@university.edu',
            'is_active' => true,
        ]);

        Program::create([
            'faculty_id' => $engineeringFaculty->id,
            'name' => 'Ingeniería Electrónica',
            'slug' => 'ing-electronica',
            'code' => 'IELC-2024',
            'duration_semesters' => 8,
            'total_credits' => 240,
            'description' => 'Programa de Ingeniería Electrónica',
            'coordinator_email' => 'coord.electronica@university.edu',
            'is_active' => true,
        ]);

        // Create Programs under Sciences
        Program::create([
            'faculty_id' => $sciencesFaculty->id,
            'name' => 'Licenciatura en Física',
            'slug' => 'lic-fisica',
            'code' => 'LFIS-2024',
            'duration_semesters' => 8,
            'total_credits' => 240,
            'description' => 'Programa de Licenciatura en Física',
            'coordinator_email' => 'coord.fisica@university.edu',
            'is_active' => true,
        ]);

        Program::create([
            'faculty_id' => $sciencesFaculty->id,
            'name' => 'Licenciatura en Química',
            'slug' => 'lic-quimica',
            'code' => 'LQUIM-2024',
            'duration_semesters' => 8,
            'total_credits' => 240,
            'description' => 'Programa de Licenciatura en Química',
            'coordinator_email' => 'coord.quimica@university.edu',
            'is_active' => true,
        ]);

        // Create Programs under Business
        Program::create([
            'faculty_id' => $businessFaculty->id,
            'name' => 'Administración de Empresas',
            'slug' => 'adm-empresas',
            'code' => 'ADE-2024',
            'duration_semesters' => 8,
            'total_credits' => 240,
            'description' => 'Programa de Administración de Empresas',
            'coordinator_email' => 'coord.adm@university.edu',
            'is_active' => true,
        ]);

        Program::create([
            'faculty_id' => $businessFaculty->id,
            'name' => 'Contabilidad',
            'slug' => 'contabilidad',
            'code' => 'CONT-2024',
            'duration_semesters' => 8,
            'total_credits' => 240,
            'description' => 'Programa de Contabilidad',
            'coordinator_email' => 'coord.contabilidad@university.edu',
            'is_active' => true,
        ]);

        // Create Programs under Humanities
        Program::create([
            'faculty_id' => $humanitiesFaculty->id,
            'name' => 'Licenciatura en Letras',
            'slug' => 'lic-letras',
            'code' => 'LLET-2024',
            'duration_semesters' => 8,
            'total_credits' => 240,
            'description' => 'Programa de Licenciatura en Letras',
            'coordinator_email' => 'coord.letras@university.edu',
            'is_active' => true,
        ]);

        Program::create([
            'faculty_id' => $humanitiesFaculty->id,
            'name' => 'Historia',
            'slug' => 'historia',
            'code' => 'HIST-2024',
            'duration_semesters' => 8,
            'total_credits' => 240,
            'description' => 'Programa de Historia',
            'coordinator_email' => 'coord.historia@university.edu',
            'is_active' => true,
        ]);
    }
}
