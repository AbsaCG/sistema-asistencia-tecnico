<?php
$db = new PDO('mysql:host=127.0.0.1', 'root', '');

// Dropear BD existente
$db->exec("DROP DATABASE IF EXISTS proyecto_asistencia");
echo "✓ Base de datos eliminada\n";

// Recrear BD
$db->exec("CREATE DATABASE proyecto_asistencia CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
echo "✓ Base de datos recreada\n";

// Verificar
$result = $db->query("SHOW DATABASES LIKE 'proyecto_asistencia'");
if ($result->fetch()) {
    echo "✓ Verificación OK - proyecto_asistencia existe\n";
} else {
    echo "✗ Error en creación\n";
}
?>
