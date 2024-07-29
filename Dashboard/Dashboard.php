<?php
    include("../../Files/conn.php");
    include("../../Files/backerConditionalLogout.php");

    $userId = $_SESSION['Backer_userId'];
    $backerId = "";

    // Fetch Backer ID
    if ($stmt = $conn->prepare("SELECT backerId 
                                FROM backer 
                                WHERE userId = ?")) {
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $stmt->bind_result($backerId);
        $stmt->fetch();
        $_SESSION['backerId'] = $backerId;
        $stmt->close();
    } else {
        die("Error: " . $conn->error);
    }

    // Fetch username
    if ($stmt = $conn->prepare("SELECT * 
                                FROM users 
                                WHERE userId = ?")) {
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();

        $row = $result->fetch_assoc();

        $_SESSION['Backer_username'] =  htmlspecialchars($row["username"]);
        $_SESSION['Backer_profileImage'] =  htmlspecialchars($row["profileImage"]);
        $result->data_seek(0);
    } else {
        die("Error: " . $conn->error);
    }

// Query for contributions by a specific backer
$sql_contributions = "SELECT contributionId, projectId, backerId, amount, date FROM contribution WHERE backerId = $backerId";
$result_contributions = $conn->query($sql_contributions);

if ($result_contributions === FALSE) {
    die("Error: " . $conn->error);
}

$totalFundsContributed = 0;

// Display contributions and calculate total funds
if ($result_contributions->num_rows > 0) {
    while($row = $result_contributions->fetch_assoc()) {
        $totalFundsContributed += $row["amount"];
    }
}

// Query for number of projects backed by the backer
$sql_projects_backed = "SELECT COUNT(DISTINCT projectId) as projectsBacked FROM contribution WHERE backerId = $backerId";
$result_projects_backed = $conn->query($sql_projects_backed);

if ($result_projects_backed === FALSE) {
    die("Error: " . $conn->error);
}

if ($result_projects_backed->num_rows > 0) {
    $row = $result_projects_backed->fetch_assoc();
    $projectsBacked = $row["projectsBacked"];
} else {
    $projectsBacked = 0;
}

// Query for active projects (assuming active means projects that have received contributions)
$sql_active_projects = "SELECT COUNT(DISTINCT projectId) as activeProjects FROM contribution";
$result_active_projects = $conn->query($sql_active_projects);

if ($result_active_projects === FALSE) {
    die("Error: " . $conn->error);
}

if ($result_active_projects->num_rows > 0) {
    $row = $result_active_projects->fetch_assoc();
    $activeProjects = $row["activeProjects"];
} else {
    $activeProjects = 0;
}
// Fetch three random projects
$sql_recommendations = "SELECT * FROM project ORDER BY RAND() LIMIT 3";
$result_recommendations = $conn->query($sql_recommendations);

if ($result_recommendations === FALSE) {
    die("Error: " . $conn->error);
}

$recommendations = [];
if ($result_recommendations->num_rows > 0) {
    while($row = $result_recommendations->fetch_assoc()) {
        $recommendations[] = $row;
    }
}

// User is logged in, get the username and image path
$username = "Backer " . $backerId; // Displaying backerId as username
$imagePath = "images/user.png"; // Default image path

// Check if an uploaded image exists for the user
$uploadDir = "uploads/";
if (file_exists($uploadDir . $backerId . ".png")) {
    $imagePath = $uploadDir . $backerId . ".png";
}

// Handle image upload
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["profileImage"])) {
    // Ensure the uploads directory exists and is writable
    if (!file_exists($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    $targetFile = $uploadDir . $backerId . ".png";
    if (move_uploaded_file($_FILES["profileImage"]["tmp_name"], $targetFile)) {
        $imagePath = $targetFile;
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Your Dashboard</title>
    <link rel="stylesheet" href="styles.css">
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
        <div class="dashboard">
            <h1>Welcome, <?php echo htmlspecialchars($_SESSION['Backer_username']); ?></h1>
            <div class="cards">
                <div class="card card1">
                    <h2>Projects Backed</h2>
                    <h3><?php echo $projectsBacked; ?></h3>
                </div>
                <div class="card card2">
                    <h2>Total Funds Contributed</h2>
                    <h3><?php echo number_format($totalFundsContributed, 2); ?> ETB</h3>
                </div>
                <div class="card card3">
                    <h2>Active Projects</h2>
                    <h3><?php echo $activeProjects; ?></h3>
                </div>
            </div>
            <div class="recommendations">
    <h2>Recommendations</h2>
    <div class="cards">
        <?php foreach ($recommendations as $project): ?>
            <div class="card recommendation-card" onclick="window.location.href='../Payment/display.php?projectId=<?php echo htmlspecialchars($project['projectId']); ?>'">
                <h3><?php echo htmlspecialchars($project['title']); ?></h3>
                <p><strong>Funding Goal:</strong> <?php echo htmlspecialchars($project['fundingGoals']); ?> ETB</p>
                <div class="progress-bar" style="width: <?php echo htmlspecialchars($project['currentFunds'] / $project['fundingGoals'] * 100); ?>%;"></div>
                <a href="../Payment/display.php?projectId=<?php echo htmlspecialchars($project['projectId']); ?>" class="learn-more-btn">Learn More</a>
            </div>
        <?php endforeach; ?>
    </div>
</div>


            


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
