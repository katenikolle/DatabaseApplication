<?php

$host = "localhost";
$user = "root";
$pass = ""; 
$db = "login";

$connection = new mysqli($host, $user, $pass, $db);

$coachId = "";
$coachFirstName = "";
$coachLastName = "";
$coachSchool = "";

$errorMessage = "";
$successMessage = "";

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    //GET method
    if (!isset($_GET['coachId'])) {
        header("location: coaches.php");
        exit;
    }

    $coachId = $_GET["coachId"];
    $sql = "SELECT * FROM coaches WHERE coachId='$coachId'"; // Fixed variable reference
    $result = $connection->query($sql);
    $row = $result->fetch_assoc();

    if (!$row) {
        header("location: coaches.php");
        exit;
    }

    // Pre-fill the form with existing data
    $coachFirstName = $row['coachFirstName'];
    $coachLastName = $row['coachLastName'];
    $coachSchool = $row['coachSchool'];

} else {
    //POST method
    $coachId = $_POST['coachId'];
    $coachFirstName = $_POST['coachFirstName'];
    $coachLastName = $_POST['coachLastName'];
    $coachSchool = $_POST['coachSchool'];

    if (empty($coachId) || empty($coachFirstName) || empty($coachLastName) || empty($coachSchool)) {
        $errorMessage = "All the fields are required.";
    } else {
        $sql = "UPDATE coaches SET 
        coachFirstName='$coachFirstName', 
        coachLastName='$coachLastName', 
        coachSchool='$coachSchool' 

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

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Coach</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script>
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
                    <input type="text" class="form-control" name="coachSchool" value="<?php echo htmlspecialchars($coachSchool); ?>">
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