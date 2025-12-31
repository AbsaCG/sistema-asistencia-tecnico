<?php
// Bootstrap the framework and invoke the Api\GateController::register directly for testing
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';

// Set up request
use Illuminate\Http\Request;
use Illuminate\Foundation\Bootstrap\HandleCors;

$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

$payload = ['dni' => '99999999', 'location' => 'Prueba Script'];
$request = Request::create('/api/attendance/gate', 'POST', $payload);

// Route the request through the kernel so container and middleware available
$response = $kernel->handle($request);

echo "HTTP STATUS: " . $response->getStatusCode() . PHP_EOL;
echo $response->getContent() . PHP_EOL;

$kernel->terminate($request, $response);
