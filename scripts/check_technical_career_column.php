<?php
$db = new PDO('mysql:host=127.0.0.1;dbname=proyecto_asistencia', 'root', '');
$result = $db->query("SHOW COLUMNS FROM students LIKE 'technical_career_id'");
$column = $result->fetch(PDO::FETCH_ASSOC);

if ($column) {
    echo "✓ La columna technical_career_id ya existe\n";
    echo "Tipo: " . $column['Type'] . "\n";
} else {
    echo "✗ La columna technical_career_id NO existe, necesita migración\n";
}
?>
