<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Haikyuu</title>
    <link rel="stylesheet" href="Styles/coaches.css">
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
                    <a href="logout.php" class="logout">Logout</a>
                </div>
            </div>
        </div>
    <div>  
 </div>
 </div>

</div>

<div class="bgPageCoaches">
    <div class ="CoachTable">
    <h1 class = "CoachTableHeader"> List of Coaches </h1>

    <br>
        <table class="table table-hover">
            <thead>
                <tr>
                    <th> Coach ID</th>
                    <th> First Name </th>
                    <th> Last Name </th>
                    <th> School </th>
                    <th> Actions </th>
                </tr>
            </thead>

            <tbody>
                <?php include "PHPTables/tablecoaches.php"; ?>
            </tbody>
        </table>
    </div>
</div> 

<!-- Edit Coach Modal -->
<div class="modal fade" id="editCoachModal" tabindex="-1" aria-labelledby="editCoachModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editCoachModalLabel">Edit Coach</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editCoachForm">
                    <input type="hidden" name="coachId" id="coachId">
                    <div class="mb-3">
                        <label for="coachFirstName" class="form-label">First Name</label>
                        <input type="text" class="form-control" name="coachFirstName" id="coachFirstName" required>
                    </div>
                    <div class="mb-3">
                        <label for="coachLastName" class="form-label">Last Name</label>
                        <input type="text" class="form-control" name="coachLastName" id="coachLastName" required>
                    </div>
                    <div class="mb-3">
                        <label for="coachSchool" class="form-label">School</label>
                        <input type="text" class="form-control" name="coachSchool" id="coachSchool" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
                <div id="modalMessage" class="mt-3"></div>
            </div>
        </div>
    </div>
</div>
</body>