<?php

require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\User;

$teacherUsers = User::whereHas('role', function($q) {
    $q->where('name', 'teacher');
})->get();

echo "=== USUARIOS CON ROL TEACHER ===\n";
echo "Total: " . $teacherUsers->count() . "\n\n";

foreach ($teacherUsers as $user) {
    echo "ID: {$user->id} | Nombre: {$user->name} | Email: {$user->email}\n";
}

echo "\n=== TABLA TEACHERS ===\n";
echo "Total registros: " . DB::table('teachers')->count() . "\n";
