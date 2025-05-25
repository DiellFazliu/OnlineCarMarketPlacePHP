<?php
if (!isset($user_email) || !filter_var($user_email, FILTER_VALIDATE_EMAIL)) {
    die("Email i përdoruesit nuk është i vlefshëm.");
}

if (!isset($make, $model, $variant, $total_price)) {
    die("Të dhënat e makinës ose çmimi mungojnë.");
}

$to = $user_email;
$subject = "Konfirmim Blerje - CarMarketplace";

$message = "Përshëndetje,\n\n";
$message .= "Ju sapo keni blerë makinën: $make $model $variant\n";
$message .= "Çmimi total i blerjes: €" . number_format($total_price, 2) . "\n\n";
$message .= "Faleminderit që zgjodhët Autosfera.\n";
$message .= "Ju urojmë udhëtime të mbarë!";

$headers = "From: Autosfera <support@carapp.com>\r\n";
$headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

if (mail($to, $subject, $message, $headers)) {
    echo "Email i konfirmimit është dërguar në $to.";
} else {
    echo "Gabim: Email-i nuk u dërgua.";
}
?>