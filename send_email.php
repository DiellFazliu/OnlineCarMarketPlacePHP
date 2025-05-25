<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

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
    echo "Gabim në dërgimin e email-it: {$mail->ErrorInfo}";
}
?>