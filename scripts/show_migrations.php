<?php
$db = new PDO('mysql:host=127.0.0.1;dbname=proyecto_asistencia','root','');
foreach ($db->query('SELECT * FROM migrations ORDER BY id') as $row) {
    echo $row['id'].' - '.$row['migration'].' - '.$row['batch'].PHP_EOL;
}
?>