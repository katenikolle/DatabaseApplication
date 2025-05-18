<?php
$host = "localhost";
$user = "root";
$pass = ""; 
$db = "login";

$connection = new mysqli($host, $user, $pass, $db);

// Check connection
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

// Query to count players in each school
$countSql = "SELECT playerSchool, COUNT(*) as playerCount FROM players GROUP BY playerSchool";
$countResult = $connection->query($countSql);

$playerCounts = [];
if ($countResult->num_rows > 0) {
    while ($row = $countResult->fetch_assoc()) {
        $playerCounts[$row['playerSchool']] = $row['playerCount'];
    }
}

// Close the connection
$connection->close();

// Return the player counts as a JSON response
header('Content-Type: application/json');
echo json_encode($playerCounts);
?>