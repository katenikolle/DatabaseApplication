
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Haikyuu</title>
    <link rel="stylesheet" href="Styles/homepage.css">
</head>

<body>

<?php
session_start();
include 'connect.php'; // Include the database connection

if (isset($_SESSION['email'])) {
    $email = $_SESSION['email'];
    $query = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");

    // Removed the while loop that displayed the welcome message
} else {
    echo "You are not logged in.";
}
?>

    <div class="header">
        <div class="left-section">
            <img class= "Haikyuu-Logo" src="HomepagePictures/Haikyuu-Logo.png">
        </div>

        <div class="right-section">
            <a href="PHPCodes/home.php">
                <button class = "home"> Home </button>
                    </a>
                    
                    <a href="PHPCodes/players.php">
                <button class="players">Players</button>
                    </a>
                    
                    <a href="PHPCodes/coaches.php">
                <button class="coaches">Coaches</button>
                    </a>
                    
                    <a href="PHPCodes/school.php">
                <button class="school">School</button>
                    </a>
                    
                    <a href="PHPCodes/faqs.php">
                <button class="faqs">FAQs</button>
                    </a>
                
            <div class="dropdown">
                <button class="account">Account</button>
                <div class="dropdown-content">
                    <a href="index.php" class="logout">Logout</a>
                </div>
            </div>
        </div>
    <div>  
 </div>
 </div>

        <div class = "headerPicture"> 
            <img class = "Haikyuu-Banner" src="HomepagePictures/wallhaven-1jmdwg.png">
        </div>

        <div class = "paragraphContainer" lang="en" >
            <div class = containerOne>
            <h2 class="headerOne">
                About
            </h2>

            <p class = "paragraphOne">
                Our platform provides registered users with the ability to view, update, 
                edit, and delete information about players, coaches, and schools from the 
                Haikyuu anime. We strive to offer a comprehensive resource for fans to engage 
                with the intricacies of this popular series.
            </p>

            <p class = "paragraphTwo">
                Our objective is to facilitate an interactive 
                experience that allows users to explore and manage 
                the extensive details of the Haikyuu universe effectively.
            </p>
            </div>

            <div class = "containerTwo" >
                <img class ="hinataShoyoOne" src="HomepagePictures/hinatashoyoone.jpg">
        </div>
    </div>

    <div class="paragraphContainerTwo" lang="en">
        <div class = "containerOneTwo">
            <img class="hinatapunch" src="HomepagePictures/hinatapunch.gif">
        </div>

        <div class = "containerTwoTwo">
         <h2 class = "headerTwo">
            Contact Us
         </h2> 
         <p class = "paragraphThree">
            Kate Nikolle F. Galucan | CCC151 Project Database Application
         </p>  
        </div>
    </div>

    <script src = ""></script>
</body>

</html>
