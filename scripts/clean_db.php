<?php
$db = new PDO('mysql:host=127.0.0.1;dbname=proyecto_asistencia', 'root', '');

// Disable FK checks
$db->exec("SET FOREIGN_KEY_CHECKS=0");

// Get all tables
$result = $db->query("SHOW TABLES");
while ($row = $result->fetch(PDO::FETCH_NUM)) {
    $db->exec("DROP TABLE IF EXISTS " . $row[0]);
    echo "✓ Tabla " . $row[0] . " eliminada\n";
}

// Reset migrations batch
$db->exec("SET FOREIGN_KEY_CHECKS=1");
echo "✓ Todas las tablas eliminadas\n";
?>
