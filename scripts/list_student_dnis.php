<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';

use App\Models\Student;

echo "DNIs registrados en la base de datos:\n";
echo "======================================\n\n";

$students = Student::with('user', 'technicalCareer')
    ->select('id', 'dni', 'student_code', 'user_id', 'technical_career_id')
    ->orderBy('student_code')
    ->get();

foreach ($students as $student) {
    echo "DNI: '{$student->dni}' (length: " . strlen($student->dni) . ")\n";
    echo "  Código: {$student->student_code}\n";
    echo "  Nombre: " . ($student->user->name ?? 'SIN NOMBRE') . "\n";
    echo "  Carrera: " . ($student->technicalCareer->name ?? 'SIN CARRERA') . "\n";
    echo "---\n";
}

echo "\nTotal de estudiantes: " . $students->count() . "\n";
