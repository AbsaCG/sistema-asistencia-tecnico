<?php

require __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Student;
use App\Models\User;

echo "=== Estudiantes Registrados ===\n\n";

$students = Student::with('user')->get();

if ($students->isEmpty()) {
    echo "No hay estudiantes registrados.\n";
} else {
    echo "Total de estudiantes: " . $students->count() . "\n\n";
    
    foreach ($students as $student) {
        echo "ID: {$student->id}\n";
        echo "DNI: {$student->dni}\n";
        echo "Código: {$student->student_code}\n";
        echo "Nombre: " . ($student->user ? $student->user->name : 'Sin usuario') . "\n";
        echo "Email: " . ($student->user ? $student->user->email : 'Sin usuario') . "\n";
        echo "Estado: {$student->student_status}\n";
        echo "---\n\n";
    }
}
