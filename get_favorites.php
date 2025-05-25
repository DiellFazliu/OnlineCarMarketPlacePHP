<?php
session_start();
require_once 'db.php';

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode([]);
    exit();
}

$userId = $_SESSION['user_id'];

function getUserFavoritesWithDetails($db, $userId) {
    $favorites = [];
    $query = "SELECT c.*, ci.image_url 
              FROM favorite_cars fc
              JOIN cars c ON fc.car_id = c.car_id
              LEFT JOIN carimages ci ON c.car_id = ci.car_id AND ci.is_main = true
              WHERE fc.user_id = ?";
    $stmt = $db->prepare($query);
    $stmt->execute([$userId]);
    
    if ($stmt) {
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $favorites[] = $row;
        }
    }
    return $favorites;
}

$favorites = getUserFavoritesWithDetails($db, $userId);
echo json_encode($favorites);
?>