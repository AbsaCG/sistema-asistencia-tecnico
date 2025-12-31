<?php

require __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Student;
use App\Models\Teacher;
use App\Models\Course;
use App\Models\TechnicalCareer;
use App\Models\User;

echo "╔═══════════════════════════════════════════════════════════════╗" . PHP_EOL;
echo "║       RESUMEN COMPLETO DEL SISTEMA DE ASISTENCIA ISTP         ║" . PHP_EOL;
echo "╚═══════════════════════════════════════════════════════════════╝" . PHP_EOL . PHP_EOL;

// ESTADÍSTICAS GENERALES
echo "📊 ESTADÍSTICAS GENERALES" . PHP_EOL;
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━" . PHP_EOL;
echo "  👥 Total usuarios: " . User::count() . PHP_EOL;
echo "  🎓 Estudiantes: " . Student::count() . PHP_EOL;
echo "  👨‍🏫 Profesores: " . Teacher::count() . PHP_EOL;
echo "  📚 Unidades Didácticas: " . Course::count() . PHP_EOL;
echo "  🏛️  Carreras Técnicas: " . TechnicalCareer::count() . PHP_EOL;
echo PHP_EOL;

// PROFESORES
echo "👨‍🏫 PROFESORES REGISTRADOS" . PHP_EOL;
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━" . PHP_EOL;
$teachers = Teacher::with('user')->orderBy('code')->get();
foreach ($teachers as $teacher) {
    echo sprintf(
        "  [%s] %s" . PHP_EOL . "        📧 %s | 🆔 DNI: %s" . PHP_EOL . "        🎯 %s" . PHP_EOL,
        $teacher->code,
        $teacher->user->name,
        $teacher->user->email,
        $teacher->dni,
        $teacher->specialization
    );
}
echo PHP_EOL;

// CARRERAS Y SUS CURSOS
echo "🎓 CARRERAS TÉCNICAS Y UNIDADES DIDÁCTICAS" . PHP_EOL;
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━" . PHP_EOL;
$careers = TechnicalCareer::withCount('courses')->orderBy('name')->get();
foreach ($careers as $career) {
    echo sprintf("  📌 %s (%s)", $career->name, $career->code) . PHP_EOL;
    echo sprintf("     Unidades: %d | Créditos: %d | Duración: %d ciclos" . PHP_EOL,
        $career->courses_count,
        $career->total_credits,
        $career->duration_semesters
    );
    
    if ($career->courses_count > 0) {
        $courses = Course::where('technical_career_id', $career->id)
            ->orderBy('cycle')
            ->orderBy('code')
            ->get();
        foreach ($courses as $course) {
            $cycleRoman = match($course->cycle) {
                1 => 'I',
                2 => 'II',
                3 => 'III',
                4 => 'IV',
                5 => 'V',
                6 => 'VI',
                default => '—'
            };
            echo sprintf(
                "        • [%s] %s (Ciclo %s, %d créditos, %d hrs/semana)" . PHP_EOL,
                $course->code,
                $course->name,
                $cycleRoman,
                $course->credits,
                $course->hours
            );
        }
    }
    echo PHP_EOL;
}

// CURSOS TRANSVERSALES
$transversalCourses = Course::whereNull('technical_career_id')->get();
if ($transversalCourses->count() > 0) {
    echo "  📌 UNIDADES TRANSVERSALES (Todas las carreras)" . PHP_EOL;
    foreach ($transversalCourses as $course) {
        $cycleRoman = match($course->cycle) {
            1 => 'I',
            2 => 'II',
            3 => 'III',
            default => '—'
        };
        echo sprintf(
            "     • [%s] %s (Ciclo %s, %d créditos, %d hrs/semana)" . PHP_EOL,
            $course->code,
            $course->name,
            $cycleRoman,
            $course->credits,
            $course->hours
        );
    }
    echo PHP_EOL;
}

// ESTUDIANTES
echo "👨‍🎓 ESTUDIANTES POR CARRERA" . PHP_EOL;
echo "━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━" . PHP_EOL;
$students = Student::with(['user', 'technicalCareer'])->get();
$studentsByCareer = $students->groupBy('technical_career_id');

foreach ($careers as $career) {
    $careerStudents = $studentsByCareer->get($career->id, collect());
    echo sprintf("  🎓 %s: %d estudiantes" . PHP_EOL, $career->name, $careerStudents->count());
    
    if ($careerStudents->count() > 0) {
        foreach ($careerStudents as $student) {
            echo sprintf(
                "     • %s [%s] - DNI: %s" . PHP_EOL,
                $student->user->name ?? 'Sin nombre',
                $student->code ?? 'Sin código',
                $student->dni ?? '—'
            );
        }
    }
}

echo PHP_EOL;
echo "╔═══════════════════════════════════════════════════════════════╗" . PHP_EOL;
echo "║                    SISTEMA LISTO PARA USAR                    ║" . PHP_EOL;
echo "║          http://127.0.0.1:8000 - Instituto ISTP               ║" . PHP_EOL;
echo "╚═══════════════════════════════════════════════════════════════╝" . PHP_EOL;
