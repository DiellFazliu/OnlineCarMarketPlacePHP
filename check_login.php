<?php
session_start();

if (isset($_SESSION['user'])) {
    echo json_encode(['logged_in' => true]);
} else {
    echo json_encode(['logged_in' => false]);
}
?>