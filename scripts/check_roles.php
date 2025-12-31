<?php

require __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Role;

echo "=== ROLES EN LA BASE DE DATOS ===" . PHP_EOL . PHP_EOL;

$roles = Role::all();

if ($roles->isEmpty()) {
    echo "⚠️  No hay roles en la tabla roles" . PHP_EOL;
} else {
    foreach ($roles as $role) {
        echo "ID: {$role->id} | Nombre: {$role->name}" . PHP_EOL;
    }
    echo PHP_EOL . "Total de roles: " . $roles->count() . PHP_EOL;
}
