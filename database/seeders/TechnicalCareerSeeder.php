<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\TechnicalCareer;

class TechnicalCareerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Carreras de Agropecuaria
        TechnicalCareer::create([
            'name' => 'Producción Agropecuaria',
            'slug' => 'produccion-agropecuaria',
            'code' => 'PA-2024',
            'description' => 'Técnico superior en producción y gestión agropecuaria',
            'duration_semesters' => 4,
            'total_credits' => 120,
            'coordinator_name' => 'Ing. Juan Rojas',
            'coordinator_email' => 'juan.rojas@istp.edu.pe',
            'requirements' => 'Tener educación secundaria completa',
            'tuition_amount' => 450.00,
            'is_active' => true,
        ]);

        TechnicalCareer::create([
            'name' => 'Ganadería',
            'slug' => 'ganaderia',
            'code' => 'GAN-2024',
            'description' => 'Técnico en crianza y producción ganadera',
            'duration_semesters' => 4,
            'total_credits' => 120,
            'coordinator_name' => 'Ing. Carlos Mendoza',
            'coordinator_email' => 'carlos.mendoza@istp.edu.pe',
            'requirements' => 'Secundaria completa, aptitud física',
            'tuition_amount' => 450.00,
            'is_active' => true,
        ]);

        // Carreras de Administración y Negocios
        TechnicalCareer::create([
            'name' => 'Contabilidad',
            'slug' => 'contabilidad',
            'code' => 'CONT-2024',
            'description' => 'Técnico superior en contabilidad y gestión contable',
            'duration_semesters' => 4,
            'total_credits' => 120,
            'coordinator_name' => 'CPC. María García',
            'coordinator_email' => 'maria.garcia@istp.edu.pe',
            'requirements' => 'Secundaria completa, conocimientos básicos de matemática',
            'tuition_amount' => 400.00,
            'is_active' => true,
        ]);

        TechnicalCareer::create([
            'name' => 'Administración de Empresas',
            'slug' => 'administracion-empresas',
            'code' => 'ADM-2024',
            'description' => 'Técnico superior en administración y gestión empresarial',
            'duration_semesters' => 4,
            'total_credits' => 120,
            'coordinator_name' => 'Lic. Pedro López',
            'coordinator_email' => 'pedro.lopez@istp.edu.pe',
            'requirements' => 'Secundaria completa',
            'tuition_amount' => 400.00,
            'is_active' => true,
        ]);

        TechnicalCareer::create([
            'name' => 'Marketing Digital',
            'slug' => 'marketing-digital',
            'code' => 'MDIG-2024',
            'description' => 'Técnico en marketing digital y comercio electrónico',
            'duration_semesters' => 4,
            'total_credits' => 120,
            'coordinator_name' => 'Lic. Ana Suárez',
            'coordinator_email' => 'ana.suarez@istp.edu.pe',
            'requirements' => 'Secundaria completa, manejo básico de computadora',
            'tuition_amount' => 400.00,
            'is_active' => true,
        ]);

        // Carreras de Informática y Computación
        TechnicalCareer::create([
            'name' => 'Desarrollo de Software',
            'slug' => 'desarrollo-software',
            'code' => 'DEVSW-2024',
            'description' => 'Técnico superior en desarrollo de aplicaciones web y móviles',
            'duration_semesters' => 4,
            'total_credits' => 120,
            'coordinator_name' => 'Ing. Roberto Silva',
            'coordinator_email' => 'roberto.silva@istp.edu.pe',
            'requirements' => 'Secundaria completa, interés en programación',
            'tuition_amount' => 500.00,
            'is_active' => true,
        ]);

        TechnicalCareer::create([
            'name' => 'Soporte Técnico en TI',
            'slug' => 'soporte-tecnico-ti',
            'code' => 'STTI-2024',
            'description' => 'Técnico en soporte, mantenimiento y administración de redes',
            'duration_semesters' => 4,
            'total_credits' => 120,
            'coordinator_name' => 'Ing. Luis Fernández',
            'coordinator_email' => 'luis.fernandez@istp.edu.pe',
            'requirements' => 'Secundaria completa, conocimiento de Windows/Linux',
            'tuition_amount' => 480.00,
            'is_active' => true,
        ]);

        // Carreras de Hotelería y Turismo
        TechnicalCareer::create([
            'name' => 'Administración de Hoteles y Turismo',
            'slug' => 'admin-hoteles-turismo',
            'code' => 'AHT-2024',
            'description' => 'Técnico superior en administración hotelera y gestión turística',
            'duration_semesters' => 4,
            'total_credits' => 120,
            'coordinator_name' => 'Lic. Patricia Romero',
            'coordinator_email' => 'patricia.romero@istp.edu.pe',
            'requirements' => 'Secundaria completa, habilidades de servicio al cliente',
            'tuition_amount' => 420.00,
            'is_active' => true,
        ]);

        TechnicalCareer::create([
            'name' => 'Gastronomía',
            'slug' => 'gastronomia',
            'code' => 'GAST-2024',
            'description' => 'Técnico en cocina y artes culinarias',
            'duration_semesters' => 4,
            'total_credits' => 120,
            'coordinator_name' => 'Chef. Francisco Díaz',
            'coordinator_email' => 'francisco.diaz@istp.edu.pe',
            'requirements' => 'Secundaria completa, pasión por la cocina',
            'tuition_amount' => 480.00,
            'is_active' => true,
        ]);

        // Carreras de Salud
        TechnicalCareer::create([
            'name' => 'Enfermería Técnica',
            'slug' => 'enfermeria-tecnica',
            'code' => 'ENFER-2024',
            'description' => 'Técnico superior en enfermería y cuidados de salud',
            'duration_semesters' => 4,
            'total_credits' => 120,
            'coordinator_name' => 'Lic. Enf. Rosa Campos',
            'coordinator_email' => 'rosa.campos@istp.edu.pe',
            'requirements' => 'Secundaria completa, vacunación al día',
            'tuition_amount' => 520.00,
            'is_active' => true,
        ]);
    }
}
