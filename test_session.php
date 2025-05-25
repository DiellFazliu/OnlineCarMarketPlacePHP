<?php
session_start();
if (isset($_SESSION['role'])) {
    echo "User is logged in with ID: " . $_SESSION['role'];
} else {
    echo "No user logged in";
}
?>