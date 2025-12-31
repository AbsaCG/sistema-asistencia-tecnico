<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "\n===== ESTUDIANTES EN LA BASE DE DATOS =====\n";
$students = DB::table('students')
    ->join('users', 'students.user_id', '=', 'users.id')
    ->select('students.dni', 'students.code', 'users.name')
    ->limit(10)
    ->get();

foreach ($students as $s) {
    echo sprintf("DNI: %-12s | Code: %-15s | Name: %s\n", $s->dni, $s->code, $s->name);
}
echo "=============================================\n";
