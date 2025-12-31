<?php
$host = '127.0.0.1';
$port = 3306;
$user = 'root';
$pass = '';
$dbname = 'proyecto_asistencia';
try {
    $pdo = new PDO("mysql:host={$host};port={$port}", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->exec("CREATE DATABASE IF NOT EXISTS `{$dbname}` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
    echo "CREATED\n";
} catch (PDOException $e) {
    echo "ERR: " . $e->getMessage() . PHP_EOL;
    exit(1);
}
