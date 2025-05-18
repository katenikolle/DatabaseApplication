<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

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

// Query to fetch players
$sql = "SELECT * FROM players"; // Adjust table name and fields as necessary
$result = $connection->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>{$row['playerId']}</td>
                <td>{$row['playerFirstName']}</td>
                <td>{$row['playerLastName']}</td>
                <td>{$row['playerSchool']}</td>
                <td>{$row['playerPosition']}</td>
                <td>
                    <a href='editPlayer.php?playerId={$row['playerId']}' class='btn btn-dark' title='Edit'>
                        <i class='fas fa-edit'></i> <!-- Edit icon -->
                    </a>
                    <a href='deletePlayer.php?playerId={$row['playerId']}' class='btn btn-danger' title='Delete' onclick=\"return confirm('Are you sure you want to delete this player?');\">
                        <i class='fas fa-trash-alt'></i> <!-- Delete icon -->
                    </a>
                </td>
            </tr>";
    }
} else {
    echo "<tr><td colspan='6'>No players found.</td></tr>";
}

// Close the connection
$connection->close();
?>