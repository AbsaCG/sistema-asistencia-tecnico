<?php

require __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Program;
use App\Models\TechnicalCareer;

echo "=== Carreras Técnicas ===\n";
$careers = TechnicalCareer::all();
foreach ($careers as $career) {
    echo "ID: {$career->id} - {$career->name}\n";
}

echo "\n=== Programas ===\n";
$programs = Program::all();
if ($programs->count() > 0) {
    foreach ($programs as $program) {
        echo "ID: {$program->id} - {$program->name}\n";
    }
} else {
    echo "No hay programas registrados\n";
}
