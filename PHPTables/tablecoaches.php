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

$sql = "SELECT * FROM coaches"; // Adjust table name and fields as necessary
$result = $connection->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>{$row['coachId']}</td>
                <td>{$row['coachFirstName']}</td>
                <td>{$row['coachLastName']}</td>
                <td>{$row['coachSchool']}</td>
                <td>
                    <a href='editCoach.php?coachId={$row['coachId']}' class='btn btn-dark' title='Edit'>
                        <i class='fas fa-edit'></i> <!-- Edit icon -->
                    </a>
                </td>
              </tr>";
    }
} else {
    echo "<tr><td colspan='6'> No coaches found</td></tr>";
}

$connection->close();
?>