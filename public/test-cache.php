<!DOCTYPE html>
<html>
<head>
    <title>Test de Caché - ISTP</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 40px; background: #f5f5f5; }
        .card { background: white; padding: 30px; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); max-width: 800px; margin: 0 auto; }
        h1 { color: #4f46e5; margin-bottom: 20px; }
        .success { color: #10b981; font-weight: bold; font-size: 18px; }
        .info { background: #eff6ff; padding: 15px; border-radius: 5px; margin: 20px 0; }
        .code { background: #1f2937; color: #10b981; padding: 15px; border-radius: 5px; font-family: monospace; }
        .button { display: inline-block; padding: 12px 24px; background: #4f46e5; color: white; text-decoration: none; border-radius: 8px; margin: 10px 5px; }
        .button:hover { background: #4338ca; }
        .timestamp { color: #6b7280; font-size: 14px; }
    </style>
</head>
<body>
    <div class="card">
        <h1>🎓 Test de Assets - ISTP Control</h1>
        
        <div class="success">
            ✅ Servidor funcionando correctamente
        </div>
        
        <div class="info">
            <strong>Timestamp del servidor:</strong> 
            <span class="timestamp"><?php echo date('Y-m-d H:i:s'); ?></span>
        </div>
        
        <h2>Assets Compilados:</h2>
        <div class="code">
            <?php
            $manifestPath = __DIR__ . '/build/manifest.json';
            if (file_exists($manifestPath)) {
                $manifest = json_decode(file_get_contents($manifestPath), true);
                echo "✓ Manifest encontrado\n\n";
                echo "AppLayout: " . ($manifest['_AppLayout-BSVZZxUz.js']['file'] ?? 'No encontrado') . "\n";
                echo "Landing: " . ($manifest['resources/js/Pages/Landing.vue']['file'] ?? 'No encontrado') . "\n";
                echo "Dashboard: " . ($manifest['resources/js/Pages/Dashboard/Index.vue']['file'] ?? 'No encontrado') . "\n";
                echo "App JS: " . ($manifest['resources/js/app.js']['file'] ?? 'No encontrado') . "\n";
            } else {
                echo "✗ Manifest no encontrado";
            }
            ?>
        </div>
        
        <h2>Instrucciones:</h2>
        <ol>
            <li><strong>CTRL + SHIFT + R</strong> - Hard refresh (Windows/Linux)</li>
            <li><strong>CMD + SHIFT + R</strong> - Hard refresh (Mac)</li>
            <li>O abre el navegador en modo incógnito</li>
        </ol>
        
        <div style="text-align: center; margin-top: 30px;">
            <a href="/" class="button">🏠 Ir al Landing</a>
            <a href="/login" class="button">🔑 Ir al Login</a>
            <a href="/dashboard" class="button">📊 Ir al Dashboard</a>
        </div>
        
        <div class="info" style="margin-top: 30px;">
            <strong>Cambios recientes:</strong><br>
            • Sidebar mejorado con menús categorizados por rol<br>
            • Dashboard con acciones rápidas (botones de colores)<br>
            • Registro de asistencia funcionando<br>
            • AppLayout actualizado con emojis y mejor navegación
        </div>
    </div>
</body>
</html>
