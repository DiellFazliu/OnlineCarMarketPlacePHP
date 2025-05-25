<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json');
include 'db.php'; 

$brand = isset($_GET['brand']) ? trim($_GET['brand']) : '';
$model = isset($_GET['model']) ? trim($_GET['model']) : '';

$query = "
    SELECT 
        Cars.*, 
        CarImages.image_url AS main_image
    FROM Cars
    LEFT JOIN CarImages 
        ON Cars.car_id = CarImages.car_id AND CarImages.is_main = TRUE
    WHERE 1=1
";

$params = [];

if ($brand !== '') {
    $query .= " AND LOWER(Cars.make) = LOWER(?)";
    $params[] = $brand;
}
if ($model !== '') {
    $query .= " AND LOWER(Cars.model) = LOWER(?)";
    $params[] = $model;
}

$query .= " ORDER BY Cars.created_at DESC LIMIT 50";

$stmt = $db->prepare($query);
$stmt->execute($params);

$cars = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($cars);
?>