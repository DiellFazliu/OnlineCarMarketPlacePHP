<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    die("Duhet të jeni i kyçur për të bërë një blerje.");
}

$user_id = $_SESSION['user_id'];

if (!isset($_POST['car_id']) || !is_numeric($_POST['car_id'])) {
    die("ID e makinës nuk është e vlefshme.");
}

$car_id = intval($_POST['car_id']);

$stmt = $conn->prepare("SELECT make, model, variant, base_price, customs_fee, registration_fee, delivery_fee, service_fee FROM Cars WHERE car_id = ?");
$stmt->bind_param("i", $car_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("Makina nuk u gjet.");
}

$row = $result->fetch_assoc();

$make = $row['make'];
$model = $row['model'];
$variant = $row['variant'];
$base_price = $row['base_price'];
$customs_fee = $row['customs_fee'];
$registration_fee = $row['registration_fee'];
$delivery_fee = $row['delivery_fee'];
$service_fee = $row['service_fee'];

$total_price = $base_price + $customs_fee + $registration_fee + $delivery_fee + $service_fee;

$stmt = $conn->prepare("INSERT INTO Purchases (user_id, car_id, price_at_purchase) VALUES (?, ?, ?)");
$stmt->bind_param("iid", $user_id, $car_id, $total_price);

if ($stmt->execute()) {
    $user_stmt = $conn->prepare("SELECT email FROM Users WHERE user_id = ?");
    $user_stmt->bind_param("i", $user_id);
    $user_stmt->execute();
    $user_result = $user_stmt->get_result();
    $user_data = $user_result->fetch_assoc();

    if ($user_data) {
        $to = $user_data['email'];
        $subject = "Konfirmim Blerje - CarMarketplace";

        $message = "Përshëndetje,\n\n";
        $message .= "Ju sapo keni blerë makinën: $make $model $variant\n";
        $message .= "Çmimi total i blerjes: €" . number_format($total_price, 2) . "\n\n";
        $message .= "Faleminderit që zgjodhët Autosfera.\n";
        $message .= "Ju urojmë udhëtime të mbarë!";

        $headers = "From: Autosfera <support@carapp.com>\r\n";
        $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

        if (mail($to, $subject, $message, $headers)) {
            echo "Blerja u regjistrua dhe email-i i konfirmimit u dërgua në $to.";
        } else {
            echo "Blerja u regjistrua, por ndodhi një gabim në dërgimin e email-it.";
        }
    }
} else {
    echo "Gabim gjatë regjistrimit të blerjes.";
}
?>