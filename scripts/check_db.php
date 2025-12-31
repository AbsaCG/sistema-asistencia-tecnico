<?php
$host = '127.0.0.1';
$port = 3306;
$user = 'root';
$pass = '';
$dbname = 'proyecto_asistencia';

try {
    $pdo = new PDO("mysql:host={$host};port={$port};dbname={$dbname}", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "=== ROLES ===" . PHP_EOL;
    $stmt = $pdo->query("SELECT id, name, slug FROM roles");
    $roles = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo "Total: " . count($roles) . PHP_EOL;
    foreach ($roles as $r) {
        echo "  [{$r['id']}] {$r['name']} ({$r['slug']})" . PHP_EOL;
    }
    
    echo PHP_EOL . "=== USERS ===" . PHP_EOL;
    $stmt = $pdo->query("SELECT id, name, email, role_id, password FROM users");
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo "Total: " . count($users) . PHP_EOL;
    foreach ($users as $u) {
        echo "  [{$u['id']}] {$u['name']} ({$u['email']}) - role_id: {$u['role_id']}" . PHP_EOL;
        echo "       Password hash: " . substr($u['password'], 0, 20) . "..." . PHP_EOL;
    }
    
} catch (PDOException $e) {
    echo "ERR: " . $e->getMessage() . PHP_EOL;
    exit(1);
}
