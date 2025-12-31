<?php

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\User;
use App\Models\Role;

echo "=== VERIFICACIÓN DE ROLES Y PERMISOS ===" . PHP_EOL . PHP_EOL;

echo "ROLES EN BASE DE DATOS:" . PHP_EOL;
$roles = Role::all();
foreach ($roles as $r) {
    echo "- ID: {$r->id} | Nombre: {$r->name} | Slug: {$r->slug}" . PHP_EOL;
}

echo PHP_EOL . "USUARIO ADMINISTRADOR:" . PHP_EOL;
$admin = User::where('email', 'admin@istp.edu.pe')->first();
if ($admin) {
    $admin->load('role');
    echo "- Email: {$admin->email}" . PHP_EOL;
    echo "- role_id: {$admin->role_id}" . PHP_EOL;
    echo "- Role Name: " . ($admin->role ? $admin->role->name : 'NULL') . PHP_EOL;
    echo "- Role Slug: " . ($admin->role ? $admin->role->slug : 'NULL') . PHP_EOL;
    echo PHP_EOL;
    echo "PRUEBAS DE MÉTODOS:" . PHP_EOL;
    echo "- hasRole('admin'): " . ($admin->hasRole('admin') ? 'TRUE' : 'FALSE') . PHP_EOL;
    echo "- hasRole('Admin'): " . ($admin->hasRole('Admin') ? 'TRUE' : 'FALSE') . PHP_EOL;
    echo "- hasRole('Administrador'): " . ($admin->hasRole('Administrador') ? 'TRUE' : 'FALSE') . PHP_EOL;
    echo "- isAdmin(): " . ($admin->isAdmin() ? 'TRUE' : 'FALSE') . PHP_EOL;
    
    if ($admin->role) {
        echo PHP_EOL . "COMPARACIÓN:" . PHP_EOL;
        echo "- strtolower('{$admin->role->name}') = '" . strtolower($admin->role->name) . "'" . PHP_EOL;
        echo "- strtolower('admin') = 'admin'" . PHP_EOL;
        echo "- ¿Son iguales? " . (strtolower($admin->role->name) === 'admin' ? 'SÍ' : 'NO') . PHP_EOL;
    }
} else {
    echo "- Admin no encontrado" . PHP_EOL;
}
