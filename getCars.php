<?php
require 'db.php';

header('Content-Type: application/json');

try {
    $stmt = $pdo->query("
        SELECT Cars.*, 
               (SELECT image_url FROM CarImages WHERE CarImages.car_id = Cars.car_id AND is_main = TRUE LIMIT 1) AS main_image 
        FROM Cars
        ORDER BY created_at DESC
        LIMIT 100
    ");

    $cars = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($cars);
} catch (PDOException $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
?>
