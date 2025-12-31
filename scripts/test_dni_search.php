<?php

require __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Student;

echo "=== Prueba de búsqueda de DNI ===\n\n";

// Probar con el DNI del estudiante principal
$testDnis = ['99999999', '70000001', '70000002'];

foreach ($testDnis as $dni) {
    echo "Buscando DNI: {$dni}\n";
    
    $student = Student::with('technicalCareer', 'user')
        ->where('dni', $dni)
        ->first();
    
    if ($student) {
        echo "  ✓ Encontrado: {$student->user->name}\n";
        echo "  Código: {$student->student_code}\n";
        echo "  Carrera: {$student->technicalCareer->name}\n";
    } else {
        echo "  ✗ No encontrado\n";
    }
    echo "\n";
}
