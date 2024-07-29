<?php
    include("../../Files/conn.php");
    include("../../Files/backerConditionalLogout.php");

    $amount = $_POST['amount'];
    $email = $_POST['email'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $phone_number = $_POST['phone_number'];
    $projectId = $_POST['projectId'];

    $_SESSION['projectId'] = $projectId;

    // Generate a unique transaction reference
    $tx_ref = 'chewatatest-' . uniqid();
    $_SESSION['tx_ref'] = $tx_ref;

    // Retrieve entrepreneur's subaccount ID from the database
    $query = "  SELECT u.subaccount_id
                FROM project AS p
                INNER JOIN entrepreneur AS e ON p.entId = e.entId
                INNER JOIN users AS u ON e.userId = u.userId
                WHERE p.projectId = ?";

    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $projectId);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    $entrepreneur_subaccount_id = $row['subaccount_id'];
    $platform_subaccount_id = 'a5174b4b-8d8d-42f4-ba14-4e7a6202e23d';

    $curl = curl_init();

    curl_setopt_array($curl, array(
    CURLOPT_URL => 'Your Api key ',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'POST',
    CURLOPT_POSTFIELDS =>'{
        "amount":"'.$amount.'",
        "currency": "ETB",
        "email": "'.$email.'",
        "first_name": "'.$first_name.'",
        "last_name": "'.$last_name.'",
        "phone_number": "'.$phone_number.'",
        "tx_ref": "'.$tx_ref.'",
        "callback_url": "https://webhook.site/077164d6-29cb-40df-ba29-8a00e59a7e60",
        "return_url": "http://localhost/Final_project_code/Backer/Payment/display.php?payment_status=success",
        "customization[title]": "Payment for my favourite merchant",
        "customization[description]": "I love online payments.",
        "split" => [
            "type" => "percentage",
            "subaccounts" => [
                [
                    "id" => "'.$entrepreneur_subaccount_id.'",
                    "percentage" => "93" // 93% to the project owner
                ],
                [
                    "id" => "'.$platform_subaccount_id.'",
                    "percentage" => "7" // 7% to your platform
                ]
            ]
        ],
    }',
    CURLOPT_HTTPHEADER => array(
        'Authorization: Bearer CHASECK_TEST-D6mS09BV1IhLCzMevZF1CrdpUv7tYgT8',
        'Content-Type: application/json'
    ),
    CURLOPT_SSL_VERIFYPEER => false, // Disable SSL certificate verification
    ));

    $response = curl_exec($curl);

    if (curl_errno($curl)) {
        $error_msg = curl_error($curl);
    }

    curl_close($curl);

    if (isset($error_msg)) {
        echo "<script> console.error(".json_encode($error_msg)."); </script>";
    } else {
        $response_data = json_decode($response, true); // Decode JSON response

        if (isset($response_data['data']['checkout_url'])) {
            $checkoutUrl = htmlspecialchars($response_data['data']['checkout_url']);
            echo "<a href='$checkoutUrl'>$checkoutUrl</a>"; // Display the checkout URL
        } else {
            echo "No checkout URL found in the response.";
        }
    }

?>