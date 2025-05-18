<?php
session_start(); // Start the session at the very beginning of the file


$adminEmail = '1206knikolle@gmail.com';

// Check if the user is logged in
if (!isset($_SESSION['email'])) { // Using 'email' consistent with your index.php
    header("Location: index.php"); // Redirect to login page if not logged in
    exit();
}

$userEmail = $_SESSION['email']; // The email of the currently logged-in user
$isAdministrator = ($userEmail === $adminEmail); // Check if the logged-in user is the administrator

$host = "localhost";
$user = "root";
$pass = "";
$db = "login";

$connection = new mysqli($host, $user, $pass, $db);

// Check connection
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

$playerId = "";
$playerFirstName = "";
$playerLastName = "";
$playerSchool = "";
$playerPosition = "";
$playerEmail = ""; // Variable for email associated with the player record (from DB)

$errorMessage = "";
$successMessage = "";
$isEditable = false; // Initialize to false by default

// Fetching player details
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (!isset($_GET['playerId'])) {
        header("location: players.php");
        exit;
    }

    $playerId = $_GET["playerId"];

    // Use prepared statement for fetching to prevent SQL injection
    $stmt_fetch = $connection->prepare("SELECT * FROM players WHERE playerId=?");
    $stmt_fetch->bind_param("i", $playerId);
    $stmt_fetch->execute();
    $result = $stmt_fetch->get_result();
    $row = $result->fetch_assoc();
    $stmt_fetch->close();

    if (!$row) {
        header("location: players.php");
        exit;
    }

    // Pre-fill the form with existing data
    $playerFirstName = $row['playerFirstName'];
    $playerLastName = $row['playerLastName'];
    $playerSchool = $row['playerSchool'];
    $playerPosition = $row['playerPosition'];
    $playerEmail = $row['email']; // Fetch the email associated with this player record

    // Determine editability based on logged-in user and player's email
    // *** FIX: Use $adminEmail instead of hardcoded string ***
    if ($isAdministrator || ($playerEmail === $userEmail)) {
        $isEditable = true; // Admin can edit, or if player's email matches logged-in user's email
    } else {
        $isEditable = false; // User can only view if not admin and not their own record
        $errorMessage = "You do not have permission to edit this player's record."; // Inform the user
    }

} else { // POST method for updating player details
    // Re-check authorization for POST requests to prevent direct POST attempts
    $playerId = $_POST['playerId'] ?? '';

    // Fetch the player's current email from the database to verify authorization
    // Use prepared statement for security
    $stmt_check = $connection->prepare("SELECT email FROM players WHERE playerId = ?");
    $stmt_check->bind_param("i", $playerId);
    $stmt_check->execute();
    $result_check_owner = $stmt_check->get_result();
    $row_check_owner = $result_check_owner->fetch_assoc();
    $stmt_check->close();

    // *** FIX: Use $adminEmail instead of hardcoded string ***
    if (!$row_check_owner || (!$isAdministrator && $userEmail !== $row_check_owner['email'])) {
        $errorMessage = "You are not authorized to update this player's record.";
        // Stop further processing if unauthorized
        // Re-fetch data to display correctly for 'view' mode after an unauthorized POST attempt
        if ($row_check_owner) { // If player exists, load its data for display
             $playerFirstName = $_POST['playerFirstName'] ?? '';
             $playerLastName = $_POST['playerLastName'] ?? '';
             $playerSchool = $_POST['playerSchool'] ?? '';
             $playerPosition = $_POST['playerPosition'] ?? '';
             $playerEmail = $row_check_owner['email']; // Use DB email for display
        } else { // If player doesn't exist, redirect
             header("location: players.php");
             exit();
        }

        $isEditable = false; // Ensure it remains view-only if unauthorized
    } else {
        // If authorized, proceed with update
        $playerFirstName = $_POST['playerFirstName'] ?? '';
        $playerLastName = $_POST['playerLastName'] ?? '';
        $playerSchool = $_POST['playerSchool'] ?? '';
        $playerPosition = $_POST['playerPosition'] ?? '';
        $playerEmail = $_POST['playerEmail'] ?? ''; // Get email from form (should match the player's email)

        if (empty($playerId) || empty($playerFirstName) || empty($playerLastName) || empty($playerSchool) || empty($playerPosition) || empty($playerEmail)) {
            $errorMessage = "All fields are required.";
        } else {
            // Use prepared statements for security!
            $stmt_update = $connection->prepare("UPDATE players SET playerFirstName=?, playerLastName=?, playerSchool=?, playerPosition=?, email=? WHERE playerId=?");
            $stmt_update->bind_param("sssssi", $playerFirstName, $playerLastName, $playerSchool, $playerPosition, $playerEmail, $playerId);

            if ($stmt_update->execute()) {
                $successMessage = "Player updated successfully.";
                header("location: players.php");
                exit;
            } else {
                $errorMessage = "Error updating player: " . $stmt_update->error;
            }
            $stmt_update->close();
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
        <h2><?php echo $isEditable ? "Edit" : "View"; ?> Player</h2>

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
                    <input type="text" class="form-control" name="playerFirstName" value="<?php echo htmlspecialchars($playerFirstName); ?>" <?php echo $isEditable ? '' : 'readonly'; ?>>
                </div>
            </div>

            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Last Name</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="playerLastName" value="<?php echo htmlspecialchars($playerLastName); ?>" <?php echo $isEditable ? '' : 'readonly'; ?>>
                </div>
            </div>

            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">School</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="playerSchool" value="<?php echo htmlspecialchars($playerSchool); ?>" <?php echo $isEditable ? '' : 'readonly'; ?>>
                </div>
            </div>

            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Position</label>
                <div class="col-sm-6">
                    <select class="form-control" name="playerPosition" <?php echo $isEditable ? '' : 'disabled'; ?>>
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
                    <input type="email" class="form-control" name="playerEmail" value="<?php echo htmlspecialchars($playerEmail); ?>" <?php echo $isAdministrator ? '' : 'readonly'; ?>>
                </div>
            </div>

            <?php if (!empty($successMessage)): ?>
                <div class='alert alert-success alert-dismissible fade show' role='alert'>
                    <strong><?php echo $successMessage; ?></strong>
                    <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                </div>
            <?php endif; ?>

            <?php if ($isEditable): ?>
                <div class="row mb-3">
                    <div class="offset-sm-3 col-sm-3 d-grid">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                    <div class="col-sm-3 d-grid">
                        <a class="btn btn-outline-primary" href="players.php" role="button">Cancel</a>
                    </div>
                </div>
            <?php else: ?>
                <div class="row mb-3">
                    <div class="offset-sm-3 col-sm-6 d-grid">
                        <a class="btn btn-outline-primary" href="players.php" role="button">Back to Players</a>
                    </div>
                </div>
            <?php endif; ?>
        </form>
    </div>

</body>
</html>