<?php
include("../Files/conn.php");
session_start();

if (isset($_POST['register'])) {
    $fname = $_POST['fname'];
    $mname = $_POST['mname'];
    $lname = $_POST['lname'];
    $dob = $_POST['dob'];
    $gender = $_POST['gender'];
    $email = $_POST['email'];
    $uname = $_POST['uname'];
    $pword = $_POST['pword'];
    $phone = $_POST['phone'];
    $atype = $_POST['atype'];

    $business_name = $atype === 'Entrepreneur' ? $_POST['business_name'] : NULL;
    $account_name = $atype === 'Entrepreneur' ? $fname . " " . $mname . " " . $lname : NULL;

    $expertise = $atype === 'Advisor' ? $_POST['expertise'] : NULL;
    $experience = $atype === 'Advisor' ? $_POST['experience'] : NULL;

    $activation_token = bin2hex(random_bytes(16));
    $activation_token_Hash = hash("sha256", $activation_token);

    // Hash the password using bcrypt
    $hashed_pword = password_hash($pword, PASSWORD_BCRYPT);

    // Handle the profile image upload
    $target_dir = __DIR__ . "/uploads/";
    $target_file = $target_dir . basename($_FILES["profile"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    $errors = [];

    // Check if image file is an actual image or fake image
    if (isset($_POST["register"])) {
        $check = getimagesize($_FILES["profile"]["tmp_name"]);
        if ($check === false) {
            $errors[] = "File is not an image.";
            $uploadOk = 0;
        }
    }

    // Check file size
    if ($_FILES["profile"]["size"] > 500000) {
        $errors[] = "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    // Allow certain file formats
    $allowedTypes = ["jpg", "png", "jpeg", "gif"];
    if (!in_array($imageFileType, $allowedTypes)) {
        $errors[] = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        $errors[] = "Sorry, your file was not uploaded.";
    } else {
        if (!move_uploaded_file($_FILES["profile"]["tmp_name"], $target_file)) {
            $errors[] = "Sorry, there was an error uploading your file.";
        } else {
            $profileImage = "/uploads/" . basename($_FILES["profile"]["name"]);
        }
    }

    // Validate age is 18 or older
    $dobDate = new DateTime($dob);
    $currentDate = new DateTime();
    $age = $dobDate->diff($currentDate)->y;

    if ($age < 18) {
        $errors[] = "You must be at least 18 years old to register.";
    }

    if (empty($errors)) {
        // Prepare an insert statement
        $stmt = $conn->prepare("INSERT INTO users (fName, mName, lName, gender, dob, username, password, email, phone, accountType, profileImage, userStatus, business_name, account_name, account_activation_hush) 
                                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'pending', ?, ?, ?)");
        $stmt->bind_param("ssssssssssssss", $fname, $mname, $lname, $gender, $dob, $uname, $hashed_pword, $email, $phone, $atype, $profileImage, $business_name, $account_name, $activation_token_Hash);
        $stmt->execute();

        // Get the user ID of the newly registered user
        $userId = $stmt->insert_id;

        if ($atype === 'Advisor') {
            $advstmt = $conn->prepare("INSERT INTO advisor (userId, expertiseArea, experience) 
                                    VALUES (?, ?, ?)");
            $advstmt->bind_param("sss", $userId, $expertise, $experience);
            $advstmt->execute();
        } elseif ($atype === 'Admin') {
            $admstmt = $conn->prepare("INSERT INTO admin (userId) 
                                    VALUES (?)");
            $admstmt->bind_param("s", $userId);
            $admstmt->execute();
        } elseif ($atype === 'Backer') {
            $bstmt = $conn->prepare("INSERT INTO backer (userId) 
                                    VALUES (?)");
            $bstmt->bind_param("s", $userId);
            $bstmt->execute();
        } elseif ($atype === 'Entrepreneur') {
            $estmt = $conn->prepare("INSERT INTO entrepreneur (userId) 
                                    VALUES (?)");
            $estmt->bind_param("s", $userId);
            $estmt->execute();

            // Chapa test mode bank details
            $api_key = 'CHASECK_TEST-D6mS09BV1IhLCzMevZF1CrdpUv7tYgT8';
            $bank_code = '32735b19-bb36-4cd7-b226-fb7451cd98f0';
            $account_number = rand(10000000, 99999999); // Adjusted range to ensure 8 digits

            // Create Chapa subaccount for the project owner
            $curl = curl_init();

            curl_setopt_array($curl, [
                CURLOPT_URL => 'https://api.chapa.co/v1/subaccount',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => json_encode([
                    "business_name" => $business_name,
                    "account_name" => $account_name,
                    "bank_code" => $bank_code,
                    "account_number" => $account_number,
                    "split_value" => 0.93,
                    "split_type" => "percentage"
                ]),
                CURLOPT_HTTPHEADER => [
                    'Authorization: Bearer ' . $api_key,
                    'Content-Type: application/json'
                ],
                CURLOPT_SSL_VERIFYPEER => false // Disable SSL certificate verification
            ]);

            $response = curl_exec($curl);

            if (curl_errno($curl)) {
                $error_msg = curl_error($curl);
                echo "<script> console.error(" . json_encode($error_msg) . "); </script>";
            }

            curl_close($curl);

            if (isset($error_msg)) {
                echo "<script> console.error(" . json_encode($error_msg) . "); </script>";
            } else {
                $subaccount_response = json_decode($response, true); // Decode JSON response
                echo "<script> console.log(" . json_encode($subaccount_response) . "); </script>"; // Debugging line

                if (isset($subaccount_response['data']['subaccount_id'])) {
                    $project_owner_subaccount_id = $subaccount_response['data']['subaccount_id'];
                } else {
                    // Handle error in subaccount creation
                    echo "<script>alert('Error creating Chapa subaccount. Please try again.'); window.location.href = 'Register.php';</script>";
                }
            }
        } else {
            $project_owner_subaccount_id = NULL;
        }

        // Print the subaccount ID to verify it's correct
        echo "<script> console.log('Subaccount ID: " . $project_owner_subaccount_id . "'); </script>";

        // Store the subaccount ID in the database
        $stmt_sub = $conn->prepare("UPDATE users SET subaccount_id = ? WHERE userId = ?");
        $stmt_sub->bind_param("si", $project_owner_subaccount_id, $userId);

        if ($stmt_sub->execute()) {
            $mail = require("./mailer.php");

            $mail->setFrom("noreply@example.com");
            $mail->addAddress($email);
            $mail->Subject = "Account Activation";
            $mail->Body = <<<END
                                Click <a href="http://localhost/Final_project_code/Home/activate-account.php?token=$activation_token">here</a> to activate your account.
                             END;

            try {
                $mail->send();
                echo "<script> alert('Registration successful! Please check your email to activate your account.'); window.location.href = 'Login.php'; </script>";
            } catch (Exception $e) {
                echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }
        } else {
            echo "<script> alert('Error storing subaccount ID. Please try again.'); window.location.href = 'Register.php'; </script>";
        }
    } else {
        echo "<script> alert('" . implode(", ", $errors) . "'); window.location.href = 'Register.php'; </script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Form</title>
    <link rel="stylesheet" href="register.css">
</head>
<body>
    <div class="container">
        <form id="registrationForm" action="register.php" method="POST" enctype="multipart/form-data">
            <div class="step active">
                <h2>Step 1: Personal Information</h2>
                <label for="fname">First Name:</label>
                <input type="text" id="fname" name="fname" required>

                <label for="mname">Middle Name:</label>
                <input type="text" id="mname" name="mname" required>

                <label for="lname">Last Name:</label>
                <input type="text" id="lname" name="lname" required>

                <label for="dob">Date of Birth:</label>
                <input type="date" id="dob" name="dob" required>

                <label for="gender">Gender:</label>
                <input type="radio" id="male" name="gender" value="Male" required> Male
                <input type="radio" id="female" name="gender" value="Female" required> Female

                <button type="button" onclick="nextStep()">Next</button>
            </div>

            <div class="step hide">
                <h2>Step 2: Account Information</h2>
                <label for="uname">Username:</label>
                <input type="text" id="uname" name="uname" required>

                <label for="pword">Password:</label>
                <input type="password" id="pword" name="pword" required>

                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>

                <label for="phone">Phone Number:</label>
                <input type="text" id="phone" name="phone" required>

                <label for="atype">Account Type:</label>
                <select id="atype" name="atype" onchange="toggleFields()" required>
                    <option value="">Select</option>
                    <option value="Admin">Admin</option>
                    <option value="Advisor">Advisor</option>
                    <option value="Backer">Backer</option>
                    <option value="Entrepreneur">Entrepreneur</option>
                </select>

                <div id="entrepreneurFields" style="display:none;">
                    <label for="business_name">Business Name:</label>
                    <input type="text" id="business_name" name="business_name">
                </div>

                <div id="advisorFields" style="display:none;">
                    <label for="expertise">Expertise Area:</label>
                    <input type="text" id="expertise" name="expertise">

                    <label for="experience">Experience (years):</label>
                    <input type="number" id="experience" name="experience">
                </div>

                <label for="profile">Profile Image:</label>
                <input type="file" id="profile" name="profile" accept="image/*" required>

                <button type="button" onclick="prevStep()">Previous</button>
                <button type="button" onclick="nextStep()">Next</button>
            </div>

            <div class="step hide">
                <h2>Step 3: Confirm Information</h2>
                <p>First Name: <span id="confirmFname"></span></p>
                <p>Middle Name: <span id="confirmMname"></span></p>
                <p>Last Name: <span id="confirmLname"></span></p>
                <p>Gender: <span id="confirmGender"></span></p>
                <p>Date of Birth: <span id="confirmDob"></span></p>
                <p>Username: <span id="confirmUname"></span></p>
                <p>Email: <span id="confirmEmail"></span></p>
                <p>Phone Number: <span id="confirmPhone"></span></p>
                <p>Account Type: <span id="confirmAtype"></span></p>
                <div id="confirmEntrepreneurFields" style="display:none;">
                    <p>Business Name: <span id="confirmBusinessName"></span></p>
                </div>
                <div id="confirmAdvisorFields" style="display:none;">
                    <p>Expertise Area: <span id="confirmExpertiseArea"></span></p>
                    <p>Experience: <span id="confirmExperience"></span></p>
                </div>

                <button type="button" onclick="prevStep()">Previous</button>
                <button type="submit" name="register">Register</button>
            </div>
        </form>

        <div class="progress-bar">
            <div class="step-indicator completed"></div>
            <div class="step-indicator"></div>
            <div class="step-indicator"></div>
        </div>
    </div>

    <script>
        let currentStep = 0;
        const formSteps = document.querySelectorAll(".step");
        const progressSteps = document.querySelectorAll(".step-indicator");

        function nextStep() {
            if (currentStep < formSteps.length - 1) {
                currentStep++;
                showCurrentStep();
            }
        }

        function prevStep() {
            if (currentStep > 0) {
                currentStep--;
                showCurrentStep();
            }
        }

        function toggleFields() {
            const atype = document.getElementById('atype').value;
            const entrepreneurFields = document.getElementById('entrepreneurFields');
            const advisorFields = document.getElementById('advisorFields');

            if (atype === 'Entrepreneur') {
                entrepreneurFields.style.display = 'block';
                advisorFields.style.display = 'none';
            } else if (atype === 'Advisor') {
                advisorFields.style.display = 'block';
                entrepreneurFields.style.display = 'none';
            } else {
                entrepreneurFields.style.display = 'none';
                advisorFields.style.display = 'none';
            }
        }

        function showCurrentStep() {
            formSteps.forEach((step, index) => {
                step.classList.toggle("active", index === currentStep);
                step.classList.toggle("hide", index !== currentStep);
            });

            progressSteps.forEach((progressStep, index) => {
                if (index < currentStep) {
                    progressStep.classList.add("completed");
                } else {
                    progressStep.classList.remove("completed");
                }
            });

            if (currentStep === 2) {
                document.getElementById('confirmFname').innerText = document.querySelector("[name='fname']").value;
                document.getElementById('confirmMname').innerText = document.querySelector("[name='mname']").value;
                document.getElementById('confirmLname').innerText = document.querySelector("[name='lname']").value;
                document.getElementById('confirmGender').innerText = document.querySelector("[name='gender']:checked").value;
                document.getElementById('confirmDob').innerText = document.querySelector("[name='dob']").value;
                document.getElementById('confirmUname').innerText = document.querySelector("[name='uname']").value;
                document.getElementById('confirmEmail').innerText = document.querySelector("[name='email']").value;
                document.getElementById('confirmPhone').innerText = document.querySelector("[name='phone']").value;
                document.getElementById('confirmAtype').innerText = document.querySelector("[name='atype']").value;
                
                if (document.getElementById('atype').value === 'Entrepreneur') {
                    document.getElementById('confirmBusinessName').innerText = document.querySelector("[name='business_name']").value;
                    document.getElementById('confirmEntrepreneurFields').style.display = 'block';
                } else {
                    document.getElementById('confirmEntrepreneurFields').style.display = 'none';
                }

                if (document.getElementById('atype').value === 'Advisor') {
                    document.getElementById('confirmExpertiseArea').innerText = document.querySelector("[name='expertise']").value;
                    document.getElementById('confirmExperience').innerText = document.querySelector("[name='experience']").value;
                    document.getElementById('confirmAdvisorFields').style.display = 'block';
                } else {
                    document.getElementById('confirmAdvisorFields').style.display = 'none';
                }
            }
        }
    </script>
</body>
</html>