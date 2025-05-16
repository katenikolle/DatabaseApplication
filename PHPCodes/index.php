<?php
session_start();
// Redirect to homepage if already logged in
if (isset($_SESSION['user_id'])) {
    header("Location: homepage.html");
    exit(); // IMPORTANT: Stop script execution after redirect
}

$error = $_GET['error'] ?? null;
$success = $_GET['success'] ?? null;
?>