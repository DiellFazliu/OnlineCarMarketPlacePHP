<?php
session_start();
require 'vendor/autoload.php';
require 'db.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

function error_handler($errno, $errstr, $errfile, $errline) {
    $gabim_tekst = "Gabim PHP [$errno]: $errstr në $errfile në linjën $errline";
    error_log($gabim_tekst);
    echo "Gabim u shfaq: $errstr në linjën $errline";

    return true;
}

set_error_handler("error_handler");

if (!isset($_SESSION['user'])) {
    echo "Gabim: Nuk jeni i kyçur.";
    exit;
}

$car_id = intval($_POST['car_id'] ?? 0);

if (!$car_id) {
    echo "Gabim: Nuk u dhënë ID e makinës.";
    exit;
}

$stmt = $db->prepare('SELECT make, model, variant, (base_price + customs_fee + registration_fee + delivery_fee + service_fee) AS total_price FROM cars WHERE car_id = :id');
$stmt->execute(['id' => $car_id]);
$car = $stmt->fetch();

if (!$car) {
    echo "Gabim: Makina nuk u gjet.";
    exit;
}

$user_email = $_SESSION['email'];
$make = $car['make'];
$model = $car['model'];
$variant = $car['variant'];
$total_price = $car['total_price'];

if (!filter_var($user_email, FILTER_VALIDATE_EMAIL)) {
    echo "Gabim: Adresa e email-it nuk është valide. Ju lutem përdorni një email të saktë për blerjen.";
    exit;
}

$blerje_log = "blerjet.log";
$line = "[" . date("Y-m-d H:i:s") . "] $user_email ka blerë: $make $model $variant për €" . number_format($total_price, 2) . "\n";

if ($file = fopen($blerje_log, 'a')) {
    fwrite($file, $line);
    fclose($file);
} else {
    echo "Gabim: Nuk u arrit të ruhet blerja në fajll.";
}

$mail = new PHPMailer(true);

try {
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'albin.maqastena@student.uni-pr.edu';
    $mail->Password   = 'sbxw xzvu bwvc pvvt';
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port       = 587;

    $mail->setFrom('autosfera@gmail.com', 'Autosfera');
    $mail->addAddress($user_email);

    $mail->isHTML(false);
    $mail->Subject = 'Konfirmim Blerje - CarMarketplace';
    $mail->Body    = "Përshëndetje,\n\nJu sapo keni blerë makinën: $make $model $variant\nÇmimi total: €" . number_format($total_price, 2) . "\n\nFaleminderit që zgjodhët Autosfera.\nJu urojmë udhëtime të mbarë!";

    $mail->send();
    echo 'Email i konfirmimit u dërgua me sukses.';
} catch (Exception $e) {
    echo "Gabim në dërgimin e email-it: " . $mail->ErrorInfo . ". Ju lutem kontrolloni email-in tuaj ose përdorni një tjetër email.";
}
?>