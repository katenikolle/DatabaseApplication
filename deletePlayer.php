<?php
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

    // Use prepared statement to prevent SQL injection
    $stmt = $conn->prepare("DELETE FROM players WHERE playerId = ?");
    $stmt->bind_param("i", $playerId); // 'i' indicates the type is integer

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