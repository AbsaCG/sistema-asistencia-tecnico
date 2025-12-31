<?php

require __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\Schema;

echo "=== ESTRUCTURA DE LA TABLA COURSES ===" . PHP_EOL . PHP_EOL;

$columns = Schema::getColumnListing('courses');

echo "Columnas existentes:" . PHP_EOL;
foreach ($columns as $column) {
    echo "  - $column" . PHP_EOL;
}
