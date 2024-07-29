<?php
    include("../../Files/conn.php");
    include("../../Files/backerConditionalLogout.php");

    $userId = $_SESSION['Backer_userId'];

    // Retrieve projectId from session or URL parameter
    if (isset($_GET['projectId'])) {
        $_SESSION['projectId'] = $_GET['projectId'];
        $projectId = $_SESSION['projectId'];
    } else if (isset($_SESSION['projectId'])) {
        $projectId = $_SESSION['projectId'];
    } else {
        die("Project ID not found.");
    }

    // Use $projectId in your query or for any other purpose
    $select = "SELECT project.*, users.*
            FROM project
            INNER JOIN entrepreneur ON project.entId = entrepreneur.entId
            INNER JOIN users ON entrepreneur.userId = users.userId
            WHERE project.projectId = ?";

    if ($stmt = $conn->prepare($select)) {
        $stmt->bind_param("i", $projectId);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $username = $row["username"];
            $fName = $row["fName"];
            $lName = $row["lName"];
            $email = $row["email"];
            $phone = $row["phone"];
            $title = $row["title"];
        } else {
            die("No project found with the provided ID.");
        }
        $stmt->close();
    } else {
        die("Error preparing statement: " . $conn->error);
    }

    // Retrieve team members associated with the project
    $select_team = "SELECT * FROM projectTeam WHERE projectId = ?";
    $teamMembers = [];
    if ($stmt_team = $conn->prepare($select_team)) {
        $stmt_team->bind_param("i", $projectId);
        $stmt_team->execute();
        $result_team = $stmt_team->get_result();
        while ($team_row = $result_team->fetch_assoc()) {
            $teamMembers[] = $team_row;
        }
        $stmt_team->close();
    } else {
        die("Error preparing statement: " . $conn->error);
    }

    // Retrieve files associated with the project
    $select_files = "SELECT * FROM uploadedFile WHERE projectId = ?";
    $uploadedFiles = [];
    if ($stmt_files = $conn->prepare($select_files)) {
        $stmt_files->bind_param("i", $projectId);
        $stmt_files->execute();
        $result_files = $stmt_files->get_result();
        while ($file_row = $result_files->fetch_assoc()) {
            $uploadedFiles[] = $file_row;
        }
        $stmt_files->close();
    } else {
        die("Error preparing statement: " . $conn->error);
    }

    // Retrieve backers associated with the project
    $select_backer ="SELECT contribution.*, users.username AS backer_username
                    FROM  contribution
                    INNER JOIN backer ON contribution.backerId = backer.backerId
                    INNER JOIN users ON backer.userId = users.userId
                    WHERE contribution.projectId = ?";

    if ($stmt_backer = $conn->prepare($select_backer)) {
        $stmt_backer->bind_param("i", $projectId);
        $stmt_backer->execute();
        $result_backer = $stmt_backer->get_result();
        $stmt_backer->close();
    } else {
        die("Error preparing statement: " . $conn->error);
    }

    if (isset($_GET['payment_status']) && $_GET['payment_status'] === 'success') {
        // Verifying payment details
        $tx_ref = $_SESSION['tx_ref'];

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.chapa.co/v1/transaction/verify/'.$tx_ref.'',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer CHASECK_TEST-D6mS09BV1IhLCzMevZF1CrdpUv7tYgT8'
            ),
            CURLOPT_SSL_VERIFYPEER => false, // Disable SSL certificate verification
        ));

        $response = curl_exec($curl);

        if (curl_errno($curl)) {
            $error_msg = curl_error($curl);
            echo "<script> console.error(" . json_encode($error_msg) . "); </script>";
        } else {
            $responseData = json_decode($response, true);
            if (json_last_error() === JSON_ERROR_NONE) {

                // Extract amount, status, and tx_ref
                $amount = htmlspecialchars($responseData['data']['amount']);
                $status = htmlspecialchars($responseData['data']['status']);
                $reference = htmlspecialchars($responseData['data']['reference']);
                $tx_ref1 = htmlspecialchars($responseData['data']['tx_ref']);

                $backerId = $_SESSION['backerId'];

                $insert = $conn -> prepare("INSERT INTO contribution (backerId, projectId, amount, transactionType, contributionStatus, MERCHANTTxRef, CHAPAtx_ref)
                                            VALUES (?, ?, ?, ?, ?, ?, ?)");
                if ($insert) {
                    $insert->bind_param("iidssss", $backerId, $projectId, $amount, 'contribution', $status, $tx_ref1, $reference);
                    if ($insert->execute()) {
                        //User sends a message
                        $stmt_log = $conn->prepare("INSERT INTO UserActivityLog (userId, activityType, description) 
                                                    VALUES (?, 'Contribution Made', '" . $username . "' contributed to " . $title . "' campaign)");
                        $stmt_log->bind_param("i", $userId);
                        $stmt_log->execute();

                        echo '<script> alert("Contributed to capmaign successfully."); </script>';
                    } else {
                        echo 'Failed to insert message into database.';
                    }
                    $insert->close();
                } else {
                    die('Error: ' . $conn->error);
                }
                $conn->close();
            } else {
                echo "Error: " . (isset($responseData['message']) ? htmlspecialchars($responseData['message']) : 'Unknown error');
            }

        }

        curl_close($curl);

    }

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Display Project</title>
    <link rel="stylesheet" href="./display.css">
    <link rel="stylesheet" href="../../Files/header_and_footer.css">
    <script src="../../Files/header_and_footer.js" defer></script>
</head>

<body>
    <header style="background-color: #FFD700; color: #005246;">
        <img src="../../Icons/logo.png" alt="logo" class="logo">
        <p class="name">Startup Funding Platform</p>
        <img src="<?php echo $_SESSION['Backer_profileImage']; ?>" alt="profile" class="profile" onclick="toggleMenu()">
        <div class="dropdown-content" id="submenu">
            <div class="dropdown" style="background-image: linear-gradient(to bottom, #ffd700, #f1cd2e, #e4c342, #d6b951, #c8af5e, #b1a55d, #9c9b5c, #89905c, #698154, #4a724e, #2a624a, #005246);">
                <div class="user-info">
                    <img src="<?php echo $_SESSION['Backer_profileImage']; ?>" alt="profile">
                    <h3 id="userName"> <?php echo $_SESSION['Backer_username']; ?> </h3>
                </div>

                <hr>

                <a href="#profile" class="dropdown-link">
                    <img src="../../Icons/profile_icon.png" alt="icon">
                    <p> Edit Profile </p>
                    <span>></span>
                </a>
                <a href="../../Home/login.php" class="dropdown-link">
                    <img src="../../Icons/setting_icon.png" alt="icon">
                    <p> Settings & Privacy </p>
                    <span>></span>
                </a>
                <a href="../Help_and_support/help.php" class="dropdown-link">
                    <img src="../../Icons/help_icon.png" alt="icon">
                    <p> Help & Support </p>
                    <span>></span>
                </a>
                <a href="../../Home/logout.php" class="dropdown-link">
                    <img src="../../Icons/logout_icon.jpg" alt="icon">
                    <p>Logout</p>
                    <span>></span>
                </a>
            </div>
        </div>
        <div class="navLinks">
            <a href="../Dashboard/dashboard.php" class="links" style="color: #005246;">Dashboard</a>
            <a href="../Discover/discover.php" class="links" style="color: #005246;">Discover</a>
            <a href="../Portifolio/portfoliopage.php" class="links" style="color: #005246;">Portfolio</a>  
            <a href="../Help_and_support/help.php" class="links" style="color: #005246;">Help and Support</a>
        </div>
    </header>

    <div class="container">
        <div class="title">
            <?php
                if ($row) {
                    echo "<span class='head'>" . htmlspecialchars($row["title"]) . "</span>";
                    echo "<span class='description'>" . htmlspecialchars($row["description"]) . "</span><br>";
                }
            ?>
        </div>
        <div class="promo">
            <div class="campaignLogo">
                <?php
                    foreach ($uploadedFiles as $file) {
                        echo "<span><img src='" . htmlspecialchars($file["content"]) . "' alt='Image' class='promoVid'></span><br>";
                    }
                ?>
            </div>
            <div class="funds">
                <div class="line"> </div>
                    <?php
                        if ($row) {
                            $timezone = new DateTimeZone('Africa/Addis_Ababa'); // Set timezone to Ethiopia
                            $currentDate = new DateTime('now', $timezone); // Initialize with current date and time in Ethiopia timezone
                            $endDate = new DateTime(htmlspecialchars($row["endDate"]));
                            $interval = $currentDate->diff($endDate);
                            if($interval->invert == 0){
                                $remaining = $interval->format('%a days to go'); // %a gives the total number of days
                            } else {
                                $remaining = "The deadline has passed for this project";
                            }                            
                            echo "<span class='status'>" . htmlspecialchars($row["status"]) . "</span><br>";
                            echo "<span> <p class='fundingGoal'>" . htmlspecialchars($row["currentFunds"]) . " ETB</p>";
                            echo "<p class='currentAmount'> funded of " . htmlspecialchars($row["fundingGoals"]) . " ETB goal </p></span><br>";
                            $total = 0;
                            if ($result_backer->num_rows > 0) {
                                    while ($row_backer = $result_backer->fetch_assoc()) {
                                        if($row_backer['contributionId'] != NULL){
                                            $total++;
                                        }
                                    }
                            }
                            echo "<span> <p class='remaining'>" . $total . " </p>backers</span><br>";
                            echo "<span> <p class='remaining'>" . $remaining . " </p></span><br>";
                            echo "<button onclick='redirect()'> Back This Project </button>";
                            echo "<span class='warning'> All or nothing. This project will only be funded if it reaches its goal by ".$row["endDate"]."</span>";
                        }
                    ?>
            </div>
        </div>
        <div class="tabBoxContainer">
            <div class="tabBox">
                <div>
                    <button class="tabButton" data-choice="Campaign" data-default="true"> Campaign </button>
                    <button class="tabButton" data-choice="Rewards"> Rewards </button>
                    <button class="tabButton" data-choice="Updates"> Updates </button>
                    <button class="tabButton" data-choice="Comments"> Comments </button>
                    <div class="tline"></div>
                </div>
                <button class="back" onclick="redirect()"> Back This Project </button>
            </div>
        </div>
        <div class="contentBox"></div>

    </div>
    <footer style="background-color: #FFD700; color: #005246;">
        <ul>
            <li><h2>Company</h2></li>
            <li>About</li>
            <li>Code of Conduct</li>
            <li>Terms and Privacy</li>
            <li>Refund, Cancellation and Access Policy</li>
        </ul>
        <ul>
            <li><h2>Resources</h2></li>
            <li>Blogs</li>
            <li>FAQs</li>
        </ul>
        <ul>
            <li><h2>On Social</h2></li>
            <li>Instagram</li>
            <li>Facebook</li>
            <li>Twitter</li>
            <li>Youtube</li>
        </ul>
    </footer>

    <script>
       document.addEventListener('DOMContentLoaded', function() {

        // Add a click event listener to each tab button
        document.querySelectorAll('.tabButton').forEach(button => {
            button.addEventListener('click', function() {
                // Get the choice from the clicked button
                var choice = this.dataset.choice;

                // Send the choice to the server using AJAX
                var xhr = new XMLHttpRequest();
                xhr.open('POST', 'display_choice.php', true);
                xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                xhr.onload = function() {
                    if (this.status == 200) {
                        var contentBox = document.querySelector('.contentBox');
                        // Update the contentBox with the response from the server
                        console.log(this.responseText);
                        if(this.responseText == "No Rewards Yet." || this.responseText == "No Updates Yet." || this.responseText == "No Comments Yet."){
                            document.querySelector('.contentBox').innerHTML = this.responseText;
                            contentBox.classList.add('empty');
                        } else{
                            document.querySelector('.contentBox').innerHTML = this.responseText;
                            contentBox.classList.remove('empty');
                        }
                    }
                };
                xhr.send('choice=' + choice);

                // Update the underline position and width
                var line = document.querySelector('.tline');
                line.style.width = this.offsetWidth + "px";
                line.style.left = this.offsetLeft + "px";
            });
       });

        // Load the default tab content on page load
        var defaultButton = document.querySelector('.tabButton[data-default="true"]');
        if (defaultButton) {
            var choice = defaultButton.dataset.choice;
            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'display_choice.php', true);
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            xhr.onload = function() {
                if (this.status == 200) {
                    document.querySelector('.contentBox').innerHTML = this.responseText || "Not yet";
                }
            };
            xhr.send('choice=' + choice);

            var line = document.querySelector('.tline');
            line.style.width = defaultButton.offsetWidth + "px";
            line.style.left = defaultButton.offsetLeft + "px";
        }

        });
        function redirect(){
            document.getElementById("popup").style.display = "block";
        }
        function closePopup() {
            document.getElementById("popup").style.display = "none";
        }
    </script>
        <div id="popup" class="popup">
        <span class="close" onclick="closePopup()">&times;</span>
        <h2>Payment Form</h2>
        <div class="payment_form">
            <form action="payment.php" method="post">
                <input type="hidden" name="projectId" value="<?php echo $projectId; ?>">
                <div class="items" id="item1">
                    <label for="first_name">First Name</label>
                    <input type="text" id="first_name" name="first_name" value="<?php echo $fName; ?>">
                </div>
                <div class="items" id="item2">
                    <label for="last_name">Last Name</label>
                    <input type="text" id="last_name" name="last_name" value="<?php echo $lName; ?>">
                </div>
                <div class="items" id="item3">
                    <label for="phone_number">Phone Number</label>
                    <input type="text" id="phone_number" name="phone_number" value="<?php echo $phone; ?>">
                </div>
                <div class="items" id="item4">
                    <label for="email">Email*(optional)</label>
                    <input type="email" id="email" name="email" value="<?php echo $email; ?>">
                </div>
                <div class="items" id="item5">
                    <label for="amount">Amount</label>
                    <input type="number" id="amount" name="amount" placeholder="100 ETB" required>
                </div>
                <button type="submit">Contribute</button>
            </form>
        </div>
    </div>
</body>
</html>
