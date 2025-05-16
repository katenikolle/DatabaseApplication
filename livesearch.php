<?php
$host = "localhost";
$user = "root";
$pass = ""; 
$db = "login";

$connection = new mysqli($host, $user, $pass, $db);

if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

// Get the search query
$q = $_GET["q"];

// Prepare the SQL statement
$sql = "SELECT * FROM players WHERE playerFirstName LIKE ? OR playerLastName LIKE ?";
$stmt = $connection->prepare($sql);
$searchTerm = "%" . $q . "%";
$stmt->bind_param("ss", $searchTerm, $searchTerm);
$stmt->execute();
$result = $stmt->get_result();

// Check if any results were returned
if ($result->num_rows > 0) {
    // Output data of each row
    while($row = $result->fetch_assoc()) {
        echo "<div>
                <strong>ID:</strong> " . $row["playerID"] . " - 
                <strong>Name:</strong> " . $row["playerFirstName"] . " " . $row["playerLastName"] . " - 
                <strong>School:</strong> " . $row["playerSchool"] . " - 
                <strong>Position:</strong> " . $row["playerPosition"] . "
              </div>";
    }
} else {
    echo "No results found.";
}

// Close the connection
$stmt->close();
$connection->close();
?>