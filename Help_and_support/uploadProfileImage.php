<?php
session_start(); // Ensure session is started

// Include the database connection
include("../../Files/conn.php");

// Check if the user is logged in
if (!isset($_SESSION['Backer_userId'])) {
    echo "No file or user session found.";
    exit();
}

$message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_FILES['profileImage']) && $_FILES['profileImage']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['profileImage']['tmp_name'];
        $fileName = $_FILES['profileImage']['name'];
        $fileSize = $_FILES['profileImage']['size'];
        $fileType = $_FILES['profileImage']['type'];
        $fileNameCmps = explode(".", $fileName);
        $fileExtension = strtolower(end($fileNameCmps));

        // Define allowed file extensions
        $allowedExtensions = array('jpg', 'jpeg', 'png', 'gif');

        if (in_array($fileExtension, $allowedExtensions)) {
            // Define upload path
            $uploadPath = '../../uploads/' . $fileName; // Adjust path according to your directory structure

            // Ensure the uploads directory exists
            if (!is_dir(dirname($uploadPath))) {
                mkdir(dirname($uploadPath), 0755, true);
            }

            // Move the file to the upload directory
            if (move_uploaded_file($fileTmpPath, $uploadPath)) {
                // Update user profile image path in the database
                $userId = $_SESSION['Backer_userId']; // Ensure this is set during login

                // Prepare the SQL statement
                $stmt = $conn->prepare("UPDATE users SET profileImage = ? WHERE userId = ?");
                if ($stmt === false) {
                    die("Prepare failed: " . $conn->error);
                }
                
                $stmt->bind_param("si", $uploadPath, $userId);

                if ($stmt->execute()) {
                    $message = "Profile image successfully uploaded.";
                } else {
                    $message = "Error updating profile image path in database: " . $stmt->error;
                }

                $stmt->close();
            } else {
                $message = "Error moving the uploaded file. Check directory permissions.";
            }
        } else {
            $message = "Invalid file type. Only JPG, JPEG, PNG, and GIF files are allowed.";
        }
    } else {
        $message = "No file uploaded or there was an upload error.";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Profile Image</title>
    <link rel="stylesheet" href="uploadProfileImage.css"> <!-- Link to your CSS file -->
</head>
<body>
    <div class="container">
        <h2>Upload Profile Image</h2>

        <?php if (!empty($message)) { echo "<p class='message'>$message</p>"; } ?>

        <!-- Form to upload profile image -->
        <form action="uploadProfileImage.php" method="POST" enctype="multipart/form-data">
            <input type="file" name="profileImage" accept="image/*" required>
            <button type="submit">Upload</button>
        </form>
    </div>
</body>
</html>
