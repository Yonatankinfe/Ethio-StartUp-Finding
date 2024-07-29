<?php
// Include session management and database connection
include("../../Files/entConditionalLogout.php");
include("../../Files/conn.php");

// Use the existing connection
$conn = $conn;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $feedback = $_POST['feedback'];
    $userId = $_SESSION['Backer_userId'];
    
    // Fetch the username using the userId
    $stmt = $conn->prepare("SELECT username FROM users WHERE userId = ?");
    if ($stmt === false) {
        die("Prepare failed: " . $conn->error);
    }
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $stmt->bind_result($username);
    $stmt->fetch();
    $stmt->close();
    
    // Insert the feedback into the feedback table
    $stmt = $conn->prepare("INSERT INTO feedback (username, feedback) VALUES (?, ?)");
    if ($stmt === false) {
        die("Prepare failed: " . $conn->error);
    }
    $stmt->bind_param("ss", $username, $feedback);
    
    if ($stmt->execute()) {
        $message = "Feedback submitted successfully.";
    } else {
        $message = "Error submitting feedback: " . $stmt->error;
    }
    
    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Submit Feedback</title>
    <link rel="stylesheet" href="feedback.css">
</head>
<body>
    <div class="container">
        <h2>Submit Feedback</h2>
        <?php if (isset($message)) { echo "<p class='message'>$message</p>"; } ?>
        <form action="feedback.php" method="POST">
            <textarea name="feedback" rows="5" placeholder="Enter your feedback" required></textarea>
            <button type="submit">Submit</button>
        </form>
    </div>
</body>
</html>