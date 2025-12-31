<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require __DIR__ . '/../bootstrap/app.php';

$kernel = $app->make(\Illuminate\Contracts\Http\Kernel::class);
$request = \Illuminate\Http\Request::create('/dashboard', 'GET');
$request->setUserResolver(function () {
    return \App\Models\User::first();
});

try {
    $response = $kernel->handle($request);
    echo "✓ Dashboard route works\n";
    echo "Status: " . $response->getStatusCode() . "\n";
    
    // Check if response contains props
    $content = $response->getContent();
    if (strpos($content, '"props"') !== false) {
        echo "✓ Props found in response\n";
    }
    if (strpos($content, '"auth"') !== false) {
        echo "✓ Auth data found in response\n";
    }
    if (strpos($content, 'Dashboard') !== false) {
        echo "✓ Dashboard component found\n";
    }
    
    // Extract the props
    preg_match('/"props":\{([^}]+)\}/i', $content, $matches);
    if (!empty($matches)) {
        echo "Props content: " . substr($matches[0], 0, 100) . "...\n";
    }
    
} catch (\Exception $e) {
    echo "✗ Error: " . $e->getMessage() . "\n";
}
