<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
// Bootstrapping facades
Illuminate\Support\Facades\App::setFacadeApplication($app);

use Illuminate\Http\Request;
use App\Http\Controllers\Api\GateController;

$payload = ['dni' => '99999999', 'location' => 'ScriptDirect'];
$request = Request::create('/api/attendance/gate', 'POST', $payload);

$controller = new GateController();
$response = $controller->register($request);

if ($response instanceof Illuminate\Http\JsonResponse) {
    echo $response->getStatusCode() . PHP_EOL;
    echo $response->getContent() . PHP_EOL;
} else {
    var_dump($response);
}
