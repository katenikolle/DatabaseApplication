<?php
session_start();
// Check if user is logged in, if not, redirect to coaches.html
if (!isset($_SESSION['user_id'])) {
    header("Location: ../coaches.php"); // Redirect to coaches.html
    exit();
}
?>