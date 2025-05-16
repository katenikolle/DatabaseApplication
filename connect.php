<?php
$host = "localhost";
$user = "root"; // Your database username
$pass = ""; // Your database password
$db = "login"; // Your database name

$conn = new mysqli($host, $user, $pass, $db);

// Check connection
if ($conn->connect_error) {
    error_log("Database connection failed: " . $conn->connect_error);
    die("Database connection error. Please try again later.");
}

$conn->set_charset("utf8mb4");
?>