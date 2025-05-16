<?php
session_start(); // Start the session

// Assuming user email is stored in session
$userEmail = $_SESSION['userEmail']; // This line stays as is

$host = "localhost";
$user = "root";
$pass = ""; 
$db = "login";

$connection = new mysqli($host, $user, $pass, $db);

$playerId = "";
$playerFirstName = "";
$playerLastName = "";
$playerSchool = "";
$playerPosition = "";
$playerEmail = ""; // Variable for email

$errorMessage = "";
$successMessage = "";

// Fetching player details
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (!isset($_GET['playerId'])) {
        header("location: players.php");
        exit;
    }

    $playerId = $_GET["playerId"];
    $sql = "SELECT * FROM players WHERE playerId='$playerId'";
    $result = $connection->query($sql);
    $row = $result->fetch_assoc();

    if (!$row) {
        header("location: players.php");
        exit;
    }

    // Pre-fill the form with existing data
    $playerFirstName = $row['playerFirstName'];
    $playerLastName = $row['playerLastName'];
    $playerSchool = $row['playerSchool'];
    $playerPosition = $row['playerPosition'];
    $playerEmail = $row['email']; // Fetch the email

} else {
    // POST method for updating player details
    $playerId = $_POST['playerId'];
    $playerFirstName = $_POST['playerFirstName'];
    $playerLastName = $_POST['playerLastName'];
    $playerSchool = $_POST['playerSchool'];
    $playerPosition = $_POST['playerPosition'];
    $playerEmail = $_POST['playerEmail']; // Get email from form

    if (empty($playerId) || empty($playerFirstName) || empty($playerLastName) || empty($playerSchool) || empty($playerPosition) || empty($playerEmail)) {
        $errorMessage = "All fields are required.";
    } else {
        // Update query
        $sql = "UPDATE players SET 
                playerFirstName='$playerFirstName', 
                playerLastName='$playerLastName', 
                playerSchool='$playerSchool', 
                playerPosition='$playerPosition',
                email='$playerEmail' 
                WHERE playerId='$playerId'";
        $result = $connection->query($sql);

        if (!$result) {
            $errorMessage = "Error updating player: " . $connection->error;
        } else {
            $successMessage = "Player updated successfully.";
            header("location: players.php");
            exit;
        }
    }
}

$connection->close(); // Close the connection
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Player</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="Styles/updatePlayer.css">
</head>
<body>

    <div class="container my-5">
        <h2>Update Player</h2>

        <?php if (!empty($errorMessage)): ?>
            <div class='alert alert-warning alert-dismissible fade show' role='alert'>
                <strong><?php echo $errorMessage; ?></strong>
                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
            </div>
        <?php endif; ?>

        <form method="post">
            <input type="hidden" name="playerId" value="<?php echo htmlspecialchars($playerId); ?>">

            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">First Name</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="playerFirstName" value="<?php echo htmlspecialchars($playerFirstName); ?>">
                </div>
            </div>

            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Last Name</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="playerLastName" value="<?php echo htmlspecialchars($playerLastName); ?>">
                </div>
            </div>

            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">School</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="playerSchool" value="<?php echo htmlspecialchars($playerSchool); ?>">
                </div>
            </div>

            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Position</label>
                <div class="col-sm-6">
                    <select class="form-control" name="playerPosition">
                        <option value="Setter" <?php if ($playerPosition === 'Setter') echo 'selected'; ?>>Setter</option>
                        <option value="Middle Blocker" <?php if ($playerPosition === 'Middle Blocker') echo 'selected'; ?>>Middle Blocker</option>
                        <option value="Libero" <?php if ($playerPosition === 'Libero') echo 'selected'; ?>>Libero</option>
                        <option value="Left-Wing Spiker" <?php if ($playerPosition === 'Left-Wing Spiker') echo 'selected'; ?>>Left-Wing Spiker</option>
                        <option value="Right-Wing Spiker" <?php if ($playerPosition === 'Right-Wing Spiker') echo 'selected'; ?>>Right-Wing Spiker</option>
                    </select>
                </div>
            </div>

            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Email</label>
                <div class="col-sm-6">
                    <input type="email" class="form-control" name="playerEmail" value="<?php echo htmlspecialchars($playerEmail); ?>">
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