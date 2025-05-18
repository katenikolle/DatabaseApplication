<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
include 'connect.php';

// Initialize error messages from URL parameters
$loginError = isset($_GET['login_error']) ? htmlspecialchars($_GET['login_error']) : '';
$registerError = isset($_GET['register_error']) ? htmlspecialchars($_GET['register_error']) : '';

// Handle login
if (isset($_POST['signIn'])) {
    $email = $_POST['email'];
    $password = md5($_POST['password']);

    $sql = "SELECT * FROM users WHERE email='$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if ($row['password'] === $password) {
            $_SESSION['email'] = $row['email'];
            header("Location: homepage.php");
            exit();
        } else {
            header("Location: index.php?login_error=" . urlencode("Incorrect password."));
            exit();
        }
    } else {
        header("Location: index.php?login_error=" . urlencode("Email address not registered."));
        exit();
    }
}

// Handle registration
if (isset($_POST['signUp'])) {
    $firstName = $_POST['fName'];
    $lastName = $_POST['lName'];
    $email = $_POST['email'];
    $password = md5($_POST['password']);
    $confirmPassword = md5($_POST['confirmPassword']); // Hash for comparison

    // Check if passwords match
    if ($password !== $confirmPassword) {
        header("Location: index.php?register_error=" . urlencode("Passwords do not match!"));
        exit();
    }
    

    $checkEmail = "SELECT * FROM users WHERE email='$email'";
    $result = $conn->query($checkEmail);

    if ($result->num_rows > 0) {
        header("Location: index.php?register_error=" . urlencode("Email Address Already Exists!"));
        exit();
    } else {
        $insertQuery = "INSERT INTO users (firstName, lastName, email, password) VALUES ('$firstName', '$lastName', '$email', '$password')";
        if ($conn->query($insertQuery) === TRUE) {
            header("Location: index.php?success=registration_successful");
            exit();
        } else {
            header("Location: index.php?register_error=" . urlencode("Error: " . $conn->error));
            exit();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Haikyuu</title>
    <link rel="stylesheet" href="Styles/intro.css">
    <style>
        /* Basic styling for error messages */
        .error-message {
            color: red;
            background-color: #ffe5e5;
            border: 1px solid red;
            padding: 10px;
            margin: 10px 0;
            text-align: center;
        }
        .success-message {
            color: green;
            background-color: #e5ffe5;
            border: 1px solid green;
            padding: 10px;
            margin: 10px 0;
            text-align: center;
        }
    </style>
</head>
<body>
    <img class="backgroundIndex" src="IndexPictures/volleyhaikyuu.png">

    <div class="container" id="signUp" style="display: none;">
    <h1 class="form-title">Register</h1>
    <form method="post" action="index.php">
        <div class="input-group">
            <input type="text" name="fName" id="fName" placeholder="First Name" required>
            <label for="fName">First Name</label>
        </div>
        <div class="input-group">
            <input type="text" name="lName" id="lName" placeholder="Last Name" required>
            <label for="lName">Last Name</label>
        </div>
        <div class="input-group">
            <input type="text" name="email" id="email" placeholder="Email Address" required>
            <label for="email">Email Address</label>
        </div>
        <div class="input-group">
            <input type="password" name="password" id="password" placeholder="Password" required>
            <label for="password">Password</label>
        </div>
        <div class="input-group">
            <input type="password" name="confirmPassword" id="confirmPassword" placeholder="Re-enter Password" required>
            <label for="confirmPassword">Re-enter Password</label>
        </div>
        <input type="submit" class="btn" value="Sign Up" name="signUp">
    </form>
    <div class="links">
        <p>Already have an account?</p>
        <button id="signInButton">Sign In</button>
    </div>
    <?php if ($registerError): ?>
        <div class="error-message"><?php echo $registerError; ?></div>
    <?php endif; ?>
</div>

    <div class="container" id="signIn" style="display: block;">
        <h1 class="form-title">Sign In</h1>
        <form method="post" action="index.php"> <div class="input-group">
                <input type="text" name="email" id="signInEmail" placeholder="Email Address" required>
                <label for="signInEmail">Email Address</label>
            </div>
            <div class="input-group">
                <input type="password" name="password" id="signInPassword" placeholder="Password" required>
                <label for="signInPassword">Password</label>
            </div>
           
            <input type="submit" class="btn" value="Sign In" name="signIn">
        </form>
        <div class="links">
            <p>Don't have an account?</p>
            <button id="signUpButton">Register Now</button>
        </div>
        <?php if ($loginError): ?>
            <div class="error-message"><?php echo $loginError; ?></div>
        <?php endif; ?>
        <?php if (isset($_GET['success']) && $_GET['success'] === 'registration_successful'): ?>
            <div class="success-message">Registration successful! You can now sign in.</div>
        <?php endif; ?>
    </div>

    <script src="Scripts/script.js"></script>
</body>
</html>