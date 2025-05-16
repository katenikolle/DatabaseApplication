<?php
session_start();
// Check if user is logged in, if not, redirect to index.php
if (!isset($_SESSION['user_id'])) {
    header("Location: index.html");
    exit();
}
include("connect.php"); // Include DB connection if needed for homepage content later
?>
