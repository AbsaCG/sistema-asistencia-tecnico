<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

$users = DB::table('users')
    ->join('roles', 'users.role_id', '=', 'roles.id')
    ->select('users.name', 'users.email', 'roles.slug as role')
    ->get();

echo "Usuarios en la base de datos:\n";
echo str_repeat("=", 60) . "\n";
foreach ($users as $user) {
    echo sprintf("%-30s %-30s %s\n", $user->email, $user->name, $user->role);
}
echo str_repeat("=", 60) . "\n";
