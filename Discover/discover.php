<?php
    include("../../Files/conn.php");
    include("../../Files/backerConditionalLogout.php");

    $userId = $_SESSION['Backer_userId'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Discover New Projects</title>
    <link rel="stylesheet" href="discover.css">
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
        <div class="header">
            <h1>Discover New Projects</h1>
            <form method="GET" action="">
                <input type="text" name="search" placeholder="Search projects by title" required>
                <button type="submit">Search</button>
            </form>
        </div>
        <div class="projects-grid">
            <?php
                // Fetch projects from the database
                $sql_projects = "SELECT * FROM project";

                // Check if a search query is submitted
                if (isset($_GET['search']) && !empty($_GET['search'])) {
                    $search = $conn->real_escape_string($_GET['search']);
                    $sql_projects .= " WHERE title LIKE '%$search%'";
                }

                $result_projects = $conn->query($sql_projects);

                if ($result_projects->num_rows > 0) {
                    while ($row_project = $result_projects->fetch_assoc()) {
                        echo "<div class='project-card'>";
                        echo "<h2>" . htmlspecialchars($row_project["title"]) . "</h2>";
                        echo "<p><strong>Funding Goal:</strong> $" . htmlspecialchars($row_project["fundingGoals"]) . "</p>";
                        echo "<div class='progress-bar' style='width: " . htmlspecialchars($row_project["currentFunds"] / $row_project["fundingGoals"] * 100) . "%;'></div>";
                        echo "<a href='../Payment/display.php?projectId=" . htmlspecialchars($row_project["projectId"]) . "' class='learn-more-btn'>Learn More</a>";
                        echo "</div>";
                    }
                } else {
                    echo "No projects found.";
                }

                $conn->close();
            ?>
        </div>
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
            <li onclick="location.href = '/nice/Backer/Portifolio/portfoliopage.php'">Blogs</li>
            <li onclick="location.href = '/nice/Backer/Help_and_support/help.php'">FAQS</li>
        </ul>
        <ul>
            <li><h2>On Social</h2></li>
            <li>Instagram</li>
            <li>Facebook</li>
            <li>Twitter</li>
            <li>Youtube</li>
        </ul>
    </footer>
</body>
</html>