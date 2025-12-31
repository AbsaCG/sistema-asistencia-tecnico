<?php

require __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\TechnicalCareer;

echo "=== CÓDIGOS DE CARRERAS ===" . PHP_EOL . PHP_EOL;

$careers = TechnicalCareer::select('id', 'name', 'code')->get();

foreach ($careers as $career) {
    echo "ID: {$career->id} | Código: {$career->code} | Nombre: {$career->name}" . PHP_EOL;
}
