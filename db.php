<?php
$host = 'switchyard.proxy.rlwy.net';
$port = '33345';
$db   = 'railway';
$user = 'postgres';
$pass = 'bpsELXfRwyqjyxghAUnKvuRygaQcSXSc';

try {
    $dsn = "pgsql:host=$host;port=$port;dbname=$db;";
    $pdo = new PDO($dsn, $user, $pass, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);

    echo "Connected to PostgreSQL successfully!";
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>