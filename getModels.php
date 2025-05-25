<?php
$config = include 'config.php';

try {
    $dsn = "pgsql:host={$config['db']['host']};port={$config['db']['port']};dbname={$config['db']['name']}";
    $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false
    ];
    
    $db = new PDO($dsn, $config['db']['user'], $config['db']['pass'], $options);

    $brand = $_GET['brand'] ?? '';

    if (!$brand) {
        throw new Exception("Brand not specified");
    }

    $stmt = $db->prepare("SELECT DISTINCT model FROM Cars WHERE make = :brand ORDER BY model ASC");
    $stmt->execute(['brand' => $brand]);
    $models = $stmt->fetchAll(PDO::FETCH_COLUMN);

    header('Content-Type: application/json');
    echo json_encode($models);

} catch (Exception $e) {
    error_log("Error: " . $e->getMessage());
    http_response_code(500);
    echo json_encode([]);
}
?>