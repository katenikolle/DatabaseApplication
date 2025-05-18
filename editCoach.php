<?php
session_start(); // Start the session

// Assuming user email is stored in session
$userEmail = $_SESSION['email']; // This line retrieves the user's email from the session

$allowedEmail = "1206knikolle@gmail.com"; // Set the allowed email

$host = "localhost";
$user = "root";
$pass = ""; 
$db = "login";

$connection = new mysqli($host, $user, $pass, $db);

$coachId = "";
$coachFirstName = "";
$coachLastName = "";
$coachSchool = ""; // Keep this, but it won't be editable

$errorMessage = "";
$successMessage = "";

// Check if the user is authorized to edit
if ($userEmail !== $allowedEmail) {
    header("Location: coaches.php?error=" . urlencode("You are not authorized to edit coaches."));
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    // GET method
    if (!isset($_GET['coachId'])) {
        header("location: coaches.php");
        exit;
    }

    $coachId = $_GET["coachId"];
    $sql = "SELECT * FROM coaches WHERE coachId='$coachId'";
    $result = $connection->query($sql);
    $row = $result->fetch_assoc();

    if (!$row) {
        header("location: coaches.php");
        exit;
    }

    // Pre-fill the form with existing data
    $coachFirstName = $row['coachFirstName'];
    $coachLastName = $row['coachLastName'];
    $coachSchool = $row['coachSchool']; // Fetch, but don't let user edit

} else {
    // POST method
    $coachId = $_POST['coachId'];
    $coachFirstName = $_POST['coachFirstName'];
    $coachLastName = $_POST['coachLastName'];
    // coachSchool remains unchanged

    if (empty($coachId) || empty($coachFirstName) || empty($coachLastName)) {
        $errorMessage = "First name and Last name are required.";
    } else {
        $sql = "UPDATE coaches SET 
                coachFirstName='$coachFirstName', 
                coachLastName='$coachLastName'
                WHERE coachId='$coachId'";

        $result = $connection->query($sql);

        if (!$result) {
            $errorMessage = "Error updating coach: " . $connection->error;
        } else {
            $successMessage = "Coach updated successfully.";
            header("location: coaches.php");
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
    <title>Update Coach</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="Styles/updatePlayer.css">
</head>
<body>
    <div class="container my-5">
        <h2>Update Coach</h2>

        <?php if (!empty($errorMessage)): ?>
            <div class='alert alert-warning alert-dismissible fade show' role='alert'>
                <strong><?php echo $errorMessage; ?></strong>
                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
            </div>
        <?php endif; ?>

        <form method="post">
            <input type="hidden" name="coachId" value="<?php echo htmlspecialchars($coachId); ?>">

            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">First Name</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="coachFirstName" value="<?php echo htmlspecialchars($coachFirstName); ?>">
                </div>
            </div>

            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">Last Name</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="coachLastName" value="<?php echo htmlspecialchars($coachLastName); ?>">
                </div>
            </div>

            <div class="row mb-3">
                <label class="col-sm-3 col-form-label">School</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control" name="coachSchool" value="<?php echo htmlspecialchars($coachSchool); ?>" readonly>
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
                    <a class="btn btn-outline-primary" href="coaches.php" role="button">Cancel</a>
                </div>
            </div>
        </form>
    </div>
</body>
</html>