<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\User;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\TechnicalCareer;
use App\Models\Course;
use App\Models\Attendance;

echo "=== RESUMEN DE BASE DE DATOS ===" . PHP_EOL . PHP_EOL;
echo "USUARIOS:" . PHP_EOL;
echo "- Total: " . User::count() . PHP_EOL;
echo "- Profesores: " . Teacher::count() . PHP_EOL;
echo "- Estudiantes: " . Student::count() . PHP_EOL . PHP_EOL;
echo "CONTENIDO:" . PHP_EOL;
echo "- Carreras técnicas: " . TechnicalCareer::count() . PHP_EOL;
echo "- Cursos: " . Course::count() . PHP_EOL;
echo "- Asistencias totales: " . Attendance::count() . PHP_EOL . PHP_EOL;

$totalAttendance = Attendance::count();
$present = Attendance::where('status', 'present')->count();
$late = Attendance::where('status', 'late')->count();
$absent = Attendance::where('status', 'absent')->count();

echo "ASISTENCIAS POR ESTADO:" . PHP_EOL;
echo "- Presentes: $present (" . round($present / $totalAttendance * 100, 1) . "%)" . PHP_EOL;
echo "- Tarde: $late (" . round($late / $totalAttendance * 100, 1) . "%)" . PHP_EOL;
echo "- Ausentes: $absent (" . round($absent / $totalAttendance * 100, 1) . "%)" . PHP_EOL . PHP_EOL;

echo "TOP 5 CARRERAS CON MÁS ESTUDIANTES:" . PHP_EOL;
$careers = TechnicalCareer::withCount('students')->orderBy('students_count', 'desc')->take(5)->get();
foreach ($careers as $career) {
    echo "- {$career->name}: {$career->students_count} estudiantes" . PHP_EOL;
}
