<?php
require 'db.php';

$carId = $_GET['id'] ?? 1;

$sql = "SELECT * FROM cars WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->execute([$carId]);

$car = $stmt->fetch(PDO::FETCH_ASSOC);
echo json_encode($car);
?>