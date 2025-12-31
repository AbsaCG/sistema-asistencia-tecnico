<?php
$host = '127.0.0.1';
$port = 3306;
$user = 'root';
$pass = '';
$dbname = 'proyecto_asistencia';
try {
    $pdo = new PDO("mysql:host={$host};port={$port};dbname={$dbname}", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $pdo->query("SHOW TABLES");
    $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);
    foreach ($tables as $t) {
        echo $t . PHP_EOL;
    }
} catch (PDOException $e) {
    echo "ERR: " . $e->getMessage() . PHP_EOL;
    exit(1);
}
