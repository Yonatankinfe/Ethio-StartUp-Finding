<?php
    include("../../Files/conn.php");
    include("../../Files/backerConditionalLogout.php");

    $userId = $_SESSION['Backer_userId'];

    $backerId = $_SESSION['backerId'];

    $sql_projects ="SELECT project.*, contribution.amount, contribution.date, contribution.transactionType
                    FROM contribution
                    INNER JOIN project ON contribution.projectId = project.projectId
                    WHERE contribution.backerId = $backerId";
    $result_projects = $conn->query($sql_projects);

    if ($result_projects === FALSE) {
        die("Error: " . $conn->error);
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portfolio Page</title>
    <link rel="stylesheet" href="portfolio.css">
    <link rel="stylesheet" href="../../Files/header_and_footer.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/jquery.dataTables.min.css" />
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
    <script src="../../Files/datatable.js" defer></script>
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
        <h1>Projects You Have Backed</h1>
            <table id="myTable">
                <thead>
                    <tr>
                        <th>Project ID</th>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Funding Goals</th>
                        <th>Current Funds</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php     
                        if ($result_projects->num_rows > 0) {
                            while($row = $result_projects->fetch_assoc()) { 
                                if($row['transactionType'] != "refund"){
                    ?>
                                <tr>
                                    <td><?php echo $row['projectId']; ?></td>
                                    <td><?php echo $row['title']; ?></td>
                                    <td><?php echo $row['description']; ?></td>
                                    <td><?php echo $row['fundingGoals']; ?></td>
                                    <td><?php echo $row['currentFunds']; ?></td>
                                    <td><?php echo $row['status']; ?></td>
                                </tr>
                    <?php 
                        }
                            }
                                }
                    ?>
                </tbody>
            </table>

        <h1>Contribution Details</h1>
            <table id="myTable1">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Contribution Amount</th>
                        <th>Contribution Date</th>
                        <th>Transaction Type</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $result_projects->data_seek(0);
                        if ($result_projects->num_rows > 0) {
                            while($row = $result_projects->fetch_assoc()) {  ?>
                                <tr>
                                    <td><?php echo $row['title']; ?></td>
                                    <td><?php echo $row['amount']; ?></td>
                                    <td><?php echo $row['date']; ?></td>
                                    <td><?php echo $row['transactionType']; ?></td>
                                </tr>
                    <?php }} ?>
                </tbody>
            </table>
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
