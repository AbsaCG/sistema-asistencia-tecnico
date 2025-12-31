<?php

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\User;
use Illuminate\Support\Facades\Auth;

echo "=== VERIFICACIÓN DE MIDDLEWARE CheckRole ===" . PHP_EOL . PHP_EOL;

$admin = User::where('email', 'admin@istp.edu.pe')->first();
$profesor = User::where('email', 'profesor@istp.edu.pe')->first();
$estudiante = User::where('email', 'estudiante@istp.edu.pe')->first();

if ($admin) {
    $admin->load('role');
    echo "ADMINISTRADOR:" . PHP_EOL;
    echo "- Email: {$admin->email}" . PHP_EOL;
    echo "- Role: {$admin->role->name} (slug: {$admin->role->slug})" . PHP_EOL;
    echo "- hasRole('admin'): " . ($admin->hasRole('admin') ? '✅ TRUE' : '❌ FALSE') . PHP_EOL;
    echo "- hasRole('teacher'): " . ($admin->hasRole('teacher') ? '✅ TRUE' : '❌ FALSE') . PHP_EOL;
    echo "- hasRole('student'): " . ($admin->hasRole('student') ? '✅ TRUE' : '❌ FALSE') . PHP_EOL;
    echo PHP_EOL;
}

if ($profesor) {
    $profesor->load('role');
    echo "PROFESOR:" . PHP_EOL;
    echo "- Email: {$profesor->email}" . PHP_EOL;
    echo "- Role: {$profesor->role->name} (slug: {$profesor->role->slug})" . PHP_EOL;
    echo "- hasRole('admin'): " . ($profesor->hasRole('admin') ? '✅ TRUE' : '❌ FALSE') . PHP_EOL;
    echo "- hasRole('teacher'): " . ($profesor->hasRole('teacher') ? '✅ TRUE' : '❌ FALSE') . PHP_EOL;
    echo "- hasRole('student'): " . ($profesor->hasRole('student') ? '✅ TRUE' : '❌ FALSE') . PHP_EOL;
    echo PHP_EOL;
}

if ($estudiante) {
    $estudiante->load('role');
    echo "ESTUDIANTE:" . PHP_EOL;
    echo "- Email: {$estudiante->email}" . PHP_EOL;
    echo "- Role: {$estudiante->role->name} (slug: {$estudiante->role->slug})" . PHP_EOL;
    echo "- hasRole('admin'): " . ($estudiante->hasRole('admin') ? '✅ TRUE' : '❌ FALSE') . PHP_EOL;
    echo "- hasRole('teacher'): " . ($estudiante->hasRole('teacher') ? '✅ TRUE' : '❌ FALSE') . PHP_EOL;
    echo "- hasRole('student'): " . ($estudiante->hasRole('student') ? '✅ TRUE' : '❌ FALSE') . PHP_EOL;
    echo PHP_EOL;
}

echo "=== RUTAS QUE REQUIEREN ROLES ===" . PHP_EOL;
echo "- /academic/* → role:admin" . PHP_EOL;
echo "- /students/* → role:admin,teacher" . PHP_EOL;
echo "- /teachers/* → role:admin" . PHP_EOL;
echo "- /attendance/* → role:admin,teacher,staff" . PHP_EOL;
echo "- /reports/* → role:admin,teacher,staff" . PHP_EOL;
echo "- /settings/* → role:admin" . PHP_EOL;
