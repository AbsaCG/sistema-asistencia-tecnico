<?php

require __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\User;
use App\Models\Student;

echo "=== DIAGNÓSTICO DEL SISTEMA ===\n\n";

// 1. Verificar usuarios
echo "1. USUARIOS Y ROLES:\n";
$users = User::with('role')->get();
foreach ($users as $user) {
    echo "   • {$user->email} => Rol: " . ($user->role ? $user->role->slug : 'sin rol') . "\n";
}

// 2. Verificar estudiantes
echo "\n2. ESTUDIANTES CON DNI:\n";
$students = Student::with('user')->limit(5)->get();
foreach ($students as $student) {
    echo "   • DNI: {$student->dni} => " . ($student->user ? $student->user->name : 'Sin usuario') . "\n";
}

// 3. Verificar archivos build
echo "\n3. ARCHIVOS BUILD:\n";
$manifestPath = __DIR__ . '/../public/build/manifest.json';
if (file_exists($manifestPath)) {
    $manifest = json_decode(file_get_contents($manifestPath), true);
    echo "   ✓ Manifest.json existe\n";
    echo "   • Landing: " . ($manifest['resources/js/Pages/Landing.vue']['file'] ?? 'No encontrado') . "\n";
    echo "   • AppLayout: " . ($manifest['resources/js/Layouts/AppLayout.vue']['file'] ?? 'No encontrado') . "\n";
} else {
    echo "   ✗ Manifest.json NO existe\n";
}

// 4. Verificar ruta de registro
echo "\n4. RUTA DE REGISTRO:\n";
$routes = Route::getRoutes();
$found = false;
foreach ($routes as $route) {
    if (str_contains($route->uri(), 'api/attendance/register')) {
        echo "   ✓ Ruta encontrada: POST /api/attendance/register\n";
        $found = true;
        break;
    }
}
if (!$found) {
    echo "   ✗ Ruta NO encontrada\n";
}

echo "\n=== FIN DEL DIAGNÓSTICO ===\n";
