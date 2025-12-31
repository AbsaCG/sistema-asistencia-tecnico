<?php

require __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Course;
use App\Models\TechnicalCareer;

echo "=== CURSOS Y SUS CARRERAS ===" . PHP_EOL . PHP_EOL;

$courses = Course::with('technicalCareer')->get();

$withCareer = 0;
$withoutCareer = 0;

foreach ($courses as $course) {
    $careerName = $course->technicalCareer ? $course->technicalCareer->name : 'Sin carrera';
    $careerId = $course->technical_career_id ?? 'null';
    
    echo "• {$course->code} - {$course->name} (ID Carrera: {$careerId}) -> {$careerName}" . PHP_EOL;
    
    if ($course->technical_career_id) {
        $withCareer++;
    } else {
        $withoutCareer++;
    }
}

echo PHP_EOL . "Resumen:" . PHP_EOL;
echo "  • Con carrera: {$withCareer}" . PHP_EOL;
echo "  • Sin carrera: {$withoutCareer}" . PHP_EOL;
