<?php
// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // To set the API endpoint URL, please log in to your PHP CRM account. 
	//You can find the API endpoint URL in the login section of the PHP CRM dashboard.
    $url = "#";

    // Validate form fields
    $name = trim($_POST["name"]);
    $email = trim($_POST["email"]);
    $phone = trim($_POST["phone"]);
    $date = trim($_POST["date"]);
    $time = trim($_POST["time"]);
    $service = trim($_POST["service"]);
    $comment = isset($_POST["comment"]) ? trim($_POST["comment"]) : "";

    // Prepare data for POST request
    $data = [
        'name' => $name,
        'email' => $email,
        'phone' => $phone,
        'date' => $date,
        'time' => $time,
        'service' => $service,
        'comment' => $comment
    ];

    // Initialize cURL session
    $curl = curl_init();

    // Set cURL options
    curl_setopt_array($curl, [
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
//        CURLOPT_SSL_VERIFYPEER => false, // Assuming you're using self-signed SSL certificate in local environment
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => http_build_query($data),
    ]);

    // Execute the request and get the response
    $response = curl_exec($curl);

    // Check for errors
    if ($response === false) {
        $error = curl_error($curl);
        // Handle cURL error
        echo json_encode([
            'status' => 500,
            'error' => 'Error in scheduling appointment: ' . $error
        ]);
    } else {
        // Decode JSON response
        $responseData = json_decode($response, true);

        // Check if response contains success message
        if (isset($responseData['messages']['success'])) {
            // Return success response
            echo json_encode([
                'status' => 200,
                'messages' => [
                    'success' => $responseData['messages']['success']
                ]
            ]);
        } elseif (isset($responseData['messages']['error'])) {
            // Return error response
            echo json_encode([
                'status' => 400,
                'error' => $responseData['messages']['error']
            ]);
        } else {
            // Unknown error occurred
            echo json_encode([
                'status' => 500,
                'error' => 'Unknown error occurred.'
            ]);
        }
    }

    // Close cURL session
    curl_close($curl);
} else {
    // Invalid request method
    http_response_code(405);
    echo json_encode([
        'status' => 405,
        'error' => 'Method Not Allowed'
    ]);
}
?>
