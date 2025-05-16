<?php
session_start();
// Check if user is logged in, if not, redirect UP to index.php
if (!isset($_SESSION['user_id'])) {
    header("Location: ../faqs.html"); // Go UP to the root folder for index.php
    exit();
}
// REMOVED the self-redirect: header("Location: faqs.php"); exit();
?>