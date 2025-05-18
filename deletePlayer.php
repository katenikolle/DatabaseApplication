<?php
session_start(); // Start the session

// Assuming user email is stored in session
$userEmail = $_SESSION['email'];

if (isset($_GET['playerId'])) {
    $playerId = $_GET['playerId'];

    $host = "localhost";
    $user = "root";
    $pass = ""; 
    $db = "login";

    $conn = new mysqli($host, $user, $pass, $db);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Fetch player details to check email
    $sql = "SELECT email FROM players WHERE playerId='$playerId'";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();

    if (!$row) {
        header("Location: players.php");
        exit;
    }

    // Check if the logged-in user is allowed to delete
    if ($row['email'] !== $userEmail && $userEmail !== '1206knikolle@gmail.com') {
        header("Location: players.php");
        exit;
    }

    // Use prepared statement to prevent SQL injection
    $stmt = $conn->prepare("DELETE FROM players WHERE playerId = ?");
    $stmt->bind_param("i", $playerId);

    if ($stmt->execute()) {
        // Deletion successful
        header("Location: players.php");
        exit;
    } else {
        // Handle error (optional)
        echo "Error deleting player: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
} else {
    // Redirect if playerId is not set
    header("Location: players.php");
    exit;
}
?>