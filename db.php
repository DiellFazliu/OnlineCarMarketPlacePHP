<?php
$host = 'switchyard.proxy.rlwy.net';
$port = '33345';
$db   = 'railway';
$user = 'postgres';
$pass = 'bpsELXfRwyqjyxghAUnKvuRygaQcSXSc';

try {
    $dsn = "pgsql:host=$host;port=$port;dbname=$db;";
    $pdo = new PDO($dsn, $user, $pass, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
} catch (PDOException $e) {
    die(json_encode(['error' => $e->getMessage()]));
}
?>