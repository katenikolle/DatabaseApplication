<?php
session_start(); // Start the session

// Ensure user email is stored in session
$userEmail = $_SESSION['userEmail']; // Logged-in user's email

$host = "localhost";
$user = "root";
$pass = ""; 
$db = "login";

$connection = new mysqli($host, $user, $pass, $db);

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$playerFirstName = "";
$playerLastName = "";
$playerSchool = "";
$playerPosition = "";
$email = ""; // Variable for email
$errorMessage = "";
$successMessage = "";

// Check if the email already exists
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $playerFirstName = $_POST['playerFirstName'];
    $playerLastName = $_POST['playerLastName'];
    $playerSchool = $_POST['playerSchool'];
    $playerPosition = $_POST['playerPosition'];
    $email = $_POST['email']; // Get email from form

    do {
        if (empty($playerFirstName) || empty($playerLastName) || empty($playerSchool) || empty($playerPosition) || empty($email)) {
            $errorMessage = "All fields are required.";
            break;
        }

        // Check if email already exists
        $sqlCheckEmail = "SELECT * FROM players WHERE email='$email'";
        $resultCheck = $connection->query($sqlCheckEmail);
        
        if ($resultCheck->num_rows > 0) {
            $errorMessage = "This email is already associated with another player.";
            break;
        }

        // Add new player to database
        $sql = "INSERT INTO players (playerFirstName, playerLastName, playerSchool, playerPosition, email)
                VALUES ('$playerFirstName', '$playerLastName', '$playerSchool', '$playerPosition', '$email')";
        $result = $connection->query($sql);

        if (!$result) {
            $errorMessage = "Invalid query: " . $connection->error;
            break;
        }

        $playerFirstName = "";
        $playerLastName = "";
        $playerSchool = "";
        $playerPosition = "";
        $email = ""; // Clear the email field
        $successMessage = "Player added successfully.";

        header("location: players.php");
        exit;

    } while (false);
}

$connection->close(); // Close the connection
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Player</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="Styles/updatePlayer.css">
</head>
<body>

    <div class="container my-5">
        <h2>New Player</h2>

        <?php if (!empty($errorMessage)): ?>
            <div class='alert alert-warning alert-dismissible fade show' role='alert'>
                <strong><?php echo $errorMessage; ?></strong>
                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
            </div>
        <?php endif; ?>

        <form method="post">
            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">First Name</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="playerFirstName" value="<?php echo $playerFirstName; ?>">
                </div>
            </div>

            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Last Name</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="playerLastName" value="<?php echo $playerLastName; ?>">
                </div>
            </div>

            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">School</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="playerSchool" value="<?php echo $playerSchool; ?>">
                </div>
            </div>

            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Position</label>
                <div class="col-sm-6">
                    <select class="form-control" name="playerPosition">
                        <option>Select</option>
                        <option value="Setter">Setter</option>
                        <option value="Middle Blocker">Middle Blocker</option>
                        <option value="Libero">Libero</option>
                        <option value="Left-Wing Spiker">Left-Wing Spiker</option>
                        <option value="Right-Wing Spiker">Right-Wing Spiker</option>
                    </select>
                </div>
            </div>

            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Email</label>
                <div class="col-sm-6">
                    <input type="email" class="form-control" name="email" value="<?php echo htmlspecialchars($email); ?>">
                </div>
            </div>

            <?php if (!empty($successMessage)): ?>
                <div class='alert alert-success alert-dismissible fade show' role='alert'>
                    <strong><?php echo $successMessage; ?></strong>
                    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                </div>
            <?php endif; ?>

            <div class="row mb-3">
                <div class="offset-sm-3 col-sm-3 d-grid">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
                <div class="col-sm-3 d-grid">
                    <a class="btn btn-outline-primary" href="players.php" role="button">Cancel</a>
                </div>
            </div>
        </form>
    </div>

</body>
</html>