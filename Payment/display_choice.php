<?php
    include("../../Files/conn.php");
    include("../../Files/backerConditionalLogout.php");

     $userId = $_SESSION['Backer_userId'];

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['choice'])) {
        $choice = $_POST['choice'];
    

        // Retrieve projectId from session or URL parameter
        if (isset($_SESSION['projectId'])) {
            $projectId = $_SESSION['projectId'];
        } else if (isset($_GET['projectId'])) {
            $_SESSION['projectId'] = $_GET['projectId'];
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
        $select_backer = "SELECT contribution.*, users.username AS backer_username
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

        // Retrieve reviews associated with the project
        $select_reviews = "SELECT reviews.*, users.username AS reviewer_username
        FROM reviews
        INNER JOIN users ON reviews.userId = users.userId
        WHERE reviews.projectId = ?";

        if ($stmt_reviews = $conn->prepare($select_reviews)) {
        $stmt_reviews->bind_param("i", $projectId);
        $stmt_reviews->execute();
        $result_reviews = $stmt_reviews->get_result();
        $stmt_reviews->close();
        } else {
        die("Error preparing statement: " . $conn->error);
        }

        $selectUser = "SELECT project.*, users.username 
                            FROM project
                            INNER JOIN entrepreneur ON project.entId = entrepreneur.entId
                            INNER JOIN users ON entrepreneur.userId = users.userId 
                            WHERE entrepreneur.userId = ?";
        $stmtUser = $conn->prepare($selectUser);
        $stmtUser->bind_param("i", $userId);
        $stmtUser->execute();
        $resultuser = $stmtUser->get_result();
        if (!$resultuser) {
            die('Error: ' . $conn->error);
        }

        switch($choice){
            case 'Campaign':
                echo '  <div class="display"> 
                        <div class="sidebar">';
    
                echo '  </div>
                        <div class="content">';
                        if ($row) {
                            foreach ($uploadedFiles as $file) {
                                $fileExtension = pathinfo($file["content"], PATHINFO_EXTENSION);
                                switch (strtolower($fileExtension)) {
                                    case "jpg":
                                    case "jpeg":
                                    case "png":
                                    case "gif":
                                        echo "<span><img src='" . htmlspecialchars($file["content"]) . "' alt='Image' class='upload_img'></span><br>";
                                        break;
                                    case "mp4":
                                    case "webm":
                                    case "ogg":
                                        echo "<span class='upload_video'><video controls><source src='" . htmlspecialchars($file["content"]) . "' type='video/mp4'>Your browser does not support the video tag.</video></span><br>";
                                        break;
                                    case "pdf":
                                        echo "<span class='upload_pdf'><a href='" . htmlspecialchars($file["content"]) . "'>Download PDF</a></span><br>";
                                        break;
                                    default:
                                        echo "<span class='upload_file'><a href='" . htmlspecialchars($file["content"]) . "'>Download File</a></span><br>";
                                        break;
                                }
                            }
                            echo "<span class='category'>Category: " . htmlspecialchars($row["category"]) . "</span><br>";
                            if (!empty($teamMembers)) {
                                echo "<span class='team'>Team Members: ";
                                foreach ($teamMembers as $member) {
                                    echo htmlspecialchars($member["memberEmail"]) . "<br>";
                                }
                                echo "</span>";
                            }
                        }
                echo '  </div>
                        <div class="detail">';
                    if ($row) {
                        echo "<img src='" . htmlspecialchars($row["profileImage"]) . "' alt='profile' class='profilePhoto'><br><br>";
                        echo "<span class='fullname'>" . htmlspecialchars($row["fName"]) . " " . htmlspecialchars($row["mName"]) . "</span><br>";
                        $total = 0;
                        if ($resultuser->num_rows > 0) {
                            while ($row_user = $resultuser->fetch_assoc()) {
                                    $total++;
                            }
                        }
                        echo "<span class='created'>" . $total . " created </span><br><br>";
                        echo "<span class='email'>Email: " . htmlspecialchars($row["email"]) . "</span><br>";
                        echo "<span class='phone'>Phone: " . htmlspecialchars($row["phone"]) . "</span><br>"; 
                    }
                echo '  </div>
                    </div>';
            break;
            case 'Rewards':
                if ($result_reviews->num_rows > 0) {

                } else {
                    echo "No Rewards Yet.";
                }
            break;
            case 'Updates':
                if ($result_reviews->num_rows > 0) {

                } else {
                    echo "No Updates Yet.";
                }
            break;
            case 'Comments':
                if ($result_reviews->num_rows > 0) {
                    while ($row_review = $result_reviews->fetch_assoc()) {
                        echo "<div class='review'>";
                        echo "<span class='uname'>" . htmlspecialchars($row_review["reviewer_username"]) . "</span><br>";
                        echo "<span class='rating'>Rating: " . htmlspecialchars($row_review["rating"]) . "</span>&nbsp;&nbsp;";
                        echo "<span class='date'>" . htmlspecialchars($row_review["timeStamp"]) . "</span><br>";
                        echo "<span class='content'>" . htmlspecialchars($row_review["content"]) . "</span><br>";
        
                        if (!is_null($row_review["response"])) {
                            echo "<div class='response'>";
                            echo "<span class='uname'>" . htmlspecialchars($username) . "</span><br>";
                            echo "<span class='date'>" . htmlspecialchars($row_review["rtimeStamp"]) . "</span><br>";
                            echo "<span class='response_content'>" . htmlspecialchars($row_review["response"]) . "</span><br>";
                            echo "</div>";
                        }
        
                        echo "</div>";
                    }
                } else {
                    echo "No Comments Yet.";
                }
            break;
        }

    }
?>