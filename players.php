<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Haikyuu</title>

    <link rel="stylesheet" href="Styles/players.css">
    <link rel ="stylesheet" href="Styles/pagination.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
</head>

<body>
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
                <a href="index.html" class="logout">Logout</a>
            </div>
        </div>
    </div>
<div>  
</div>
</div>

    <div class="bgPagePlayer">
        <div class="PlayerTable">
            <h1 class="PlayerTableHeader">List of Players</h1>

            <div class="searchAndButton">
    <div class="searchField">
        <form>
            <input type="text" size="20" onkeyup="showResult(this.value)" placeholder="Search a player">
            <div id="livesearch"></div>
        </form>
    </div>

    <div class="dropdown">
        <button id="positionButton" onclick="myFunction()" class="dropbtn"><i class="fa fa-filter"></i> Position</button>
        <div id="myDropdown" class="dropdown-content">
            <a href="#" data-value="" onclick="filterPlayersByPosition('')">All Positions</a> 
            <a href="#" data-value="Setter">Setter</a>
            <a href="#" data-value="Middle Blocker">Middle Blocker</a>
            <a href="#" data-value="Libero">Libero</a>
            <a href="#" data-value="Left-Wing Spiker">Left-Wing Spiker</a>
            <a href="#" data-value="Right-Wing Spiker">Right-Wing Spiker</a>
        </div>
    </div>

    <div class="newPlayerButton">       
        <a class="btn btn-dark" href="createPlayer.php" role="button"><i class='far fa-id-badge'></i> New Player</a>
    </div>
    </div>

    <div class="buttonBelow">
    <!-- Sorting Buttons -->

    <!-- Large Spacer -->
    <div class="spacer"></div>

    <div class="backupButtonContainer">
        <button class="btn btn-secondary" onclick="manualBackup()"><i class="fa fa-save"></i> Backup</button>
    </div>
</div>


            <br>
            <table class="table table-hover" id="myTable">
                <thead>
                    <tr>
                        <th>Player ID</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>School</th>
                        <th>Position</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php include "PHPTables/tableplayers.php"; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="pagination">
        <button id="prev" onclick="changePage(-1)" disabled>Previous</button>
        <span id="page-info">Page 1</span>
        <button id="next" onclick="changePage(1)">Next</button>
    </div>

    <script src ="Scripts/searchFilter.js"></script>
    <script src="Scripts/pagination.js"></script>
    <script src = "Scripts/manualBackup.js"></script>
    <script src = "Scripts/dropdownLogout.js"></script>

    <script>
        // Automatic backup every 5 minutes
        setInterval(() => {
            manualBackup();
            alert('Automatic backup completed!');
        }, 5 * 60 * 1000); // 5 minutes in milliseconds
    </script>

</body>
</html>