<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Course;
use App\Models\TechnicalCareer;

class CourseSeeder extends Seeder
{
    public function run(): void
    {
        // Obtener carreras
        $careers = TechnicalCareer::all()->keyBy('code');

        $courses = [
            // Producción Agropecuaria
            ['code' => 'PA-UD01', 'name' => 'Fundamentos de Agricultura', 'career_code' => 'PA-2024', 'cycle' => 1, 'credits' => 4, 'hours' => 6],
            ['code' => 'PA-UD02', 'name' => 'Manejo de Suelos', 'career_code' => 'PA-2024', 'cycle' => 1, 'credits' => 3, 'hours' => 4],
            ['code' => 'PA-UD03', 'name' => 'Producción Animal', 'career_code' => 'PA-2024', 'cycle' => 2, 'credits' => 4, 'hours' => 6],
            ['code' => 'PA-UD04', 'name' => 'Sistemas de Riego', 'career_code' => 'PA-2024', 'cycle' => 2, 'credits' => 3, 'hours' => 4],
            ['code' => 'PA-UD05', 'name' => 'Gestión Agropecuaria', 'career_code' => 'PA-2024', 'cycle' => 3, 'credits' => 4, 'hours' => 5],

            // Contabilidad
            ['code' => 'CONT-UD01', 'name' => 'Contabilidad Básica', 'career_code' => 'CONT-2024', 'cycle' => 1, 'credits' => 4, 'hours' => 6],
            ['code' => 'CONT-UD02', 'name' => 'Matemática Financiera', 'career_code' => 'CONT-2024', 'cycle' => 1, 'credits' => 3, 'hours' => 4],
            ['code' => 'CONT-UD03', 'name' => 'Contabilidad de Costos', 'career_code' => 'CONT-2024', 'cycle' => 2, 'credits' => 4, 'hours' => 6],
            ['code' => 'CONT-UD04', 'name' => 'Tributación', 'career_code' => 'CONT-2024', 'cycle' => 2, 'credits' => 4, 'hours' => 5],
            ['code' => 'CONT-UD05', 'name' => 'Auditoría', 'career_code' => 'CONT-2024', 'cycle' => 3, 'credits' => 4, 'hours' => 6],

            // Desarrollo de Software
            ['code' => 'DEVSW-UD01', 'name' => 'Fundamentos de Programación', 'career_code' => 'DEVSW-2024', 'cycle' => 1, 'credits' => 4, 'hours' => 8],
            ['code' => 'DEVSW-UD02', 'name' => 'Algoritmos y Estructuras de Datos', 'career_code' => 'DEVSW-2024', 'cycle' => 1, 'credits' => 4, 'hours' => 8],
            ['code' => 'DEVSW-UD03', 'name' => 'Programación Orientada a Objetos', 'career_code' => 'DEVSW-2024', 'cycle' => 2, 'credits' => 4, 'hours' => 8],
            ['code' => 'DEVSW-UD04', 'name' => 'Bases de Datos', 'career_code' => 'DEVSW-2024', 'cycle' => 2, 'credits' => 4, 'hours' => 6],
            ['code' => 'DEVSW-UD05', 'name' => 'Desarrollo Web', 'career_code' => 'DEVSW-2024', 'cycle' => 3, 'credits' => 4, 'hours' => 8],
            ['code' => 'DEVSW-UD06', 'name' => 'Ingeniería de Software', 'career_code' => 'DEVSW-2024', 'cycle' => 3, 'credits' => 3, 'hours' => 5],

            // Gastronomía
            ['code' => 'GAST-UD01', 'name' => 'Técnicas Culinarias Básicas', 'career_code' => 'GAST-2024', 'cycle' => 1, 'credits' => 5, 'hours' => 8],
            ['code' => 'GAST-UD02', 'name' => 'Higiene y Manipulación de Alimentos', 'career_code' => 'GAST-2024', 'cycle' => 1, 'credits' => 3, 'hours' => 4],
            ['code' => 'GAST-UD03', 'name' => 'Cocina Internacional', 'career_code' => 'GAST-2024', 'cycle' => 2, 'credits' => 5, 'hours' => 8],
            ['code' => 'GAST-UD04', 'name' => 'Pastelería y Repostería', 'career_code' => 'GAST-2024', 'cycle' => 2, 'credits' => 4, 'hours' => 6],
            ['code' => 'GAST-UD05', 'name' => 'Gestión de Restaurantes', 'career_code' => 'GAST-2024', 'cycle' => 3, 'credits' => 3, 'hours' => 4],

            // Enfermería Técnica
            ['code' => 'ENFER-UD01', 'name' => 'Anatomía y Fisiología', 'career_code' => 'ENFER-2024', 'cycle' => 1, 'credits' => 4, 'hours' => 6],
            ['code' => 'ENFER-UD02', 'name' => 'Enfermería Básica', 'career_code' => 'ENFER-2024', 'cycle' => 1, 'credits' => 5, 'hours' => 8],
            ['code' => 'ENFER-UD03', 'name' => 'Farmacología', 'career_code' => 'ENFER-2024', 'cycle' => 2, 'credits' => 4, 'hours' => 5],
            ['code' => 'ENFER-UD04', 'name' => 'Enfermería en Emergencias', 'career_code' => 'ENFER-2024', 'cycle' => 2, 'credits' => 4, 'hours' => 6],
            ['code' => 'ENFER-UD05', 'name' => 'Cuidados Intensivos', 'career_code' => 'ENFER-2024', 'cycle' => 3, 'credits' => 5, 'hours' => 8],

            // Unidades transversales (para todas las carreras)
            ['code' => 'GEN-UD01', 'name' => 'Comunicación Efectiva', 'career_code' => null, 'cycle' => 1, 'credits' => 2, 'hours' => 3],
            ['code' => 'GEN-UD02', 'name' => 'Matemática Básica', 'career_code' => null, 'cycle' => 1, 'credits' => 3, 'hours' => 4],
            ['code' => 'GEN-UD03', 'name' => 'Computación e Informática', 'career_code' => null, 'cycle' => 1, 'credits' => 2, 'hours' => 4],
            ['code' => 'GEN-UD04', 'name' => 'Ética Profesional', 'career_code' => null, 'cycle' => 2, 'credits' => 2, 'hours' => 2],
        ];

        foreach ($courses as $courseData) {
            $career = null;
            if ($courseData['career_code']) {
                $career = $careers->get($courseData['career_code']);
            }

            Course::create([
                'code' => $courseData['code'],
                'name' => $courseData['name'],
                'technical_career_id' => $career ? $career->id : null,
                'cycle' => $courseData['cycle'],
                'credits' => $courseData['credits'],
                'hours' => $courseData['hours'],
                'description' => 'Unidad didáctica del plan de estudios',
            ]);
        }

        $this->command->info('✅ ' . count($courses) . ' unidades didácticas creadas exitosamente');
    }
}
