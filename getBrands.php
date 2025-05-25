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

    // Query distinct makes (brands)
    $stmt = $db->query("SELECT DISTINCT make FROM Cars ORDER BY make ASC");
    $brands = $stmt->fetchAll(PDO::FETCH_COLUMN);

    // Return JSON
    header('Content-Type: application/json');
    echo json_encode($brands);

} catch (PDOException $e) {
    error_log("Database query error: " . $e->getMessage());
    http_response_code(500);
    echo json_encode([]);
}
?>