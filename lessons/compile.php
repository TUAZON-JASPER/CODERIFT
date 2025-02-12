<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $cppCode = $_POST['cppCode'];  // Get the C++ code from the POST request

    // Define JDoodle API credentials
    $clientId = '7799cd1d9f760c197f53eabb939af6ea';
    $clientSecret = 'b44a7bf904a8a59ce8c59bd54b390955f203bab4fe1073d6dcac75d337bd95a';

    // Prepare data for JDoodle API
    $postData = json_encode([
        'clientId' => $clientId,
        'clientSecret' => $clientSecret,
        'script' => $cppCode,
        'language' => 'cpp',
        'versionIndex' => '0'  // Use the latest version
    ]);

    // Send the request to JDoodle API
    $url = 'https://api.jdoodle.com/v1/execute';
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);

    $response = curl_exec($ch);
    if (curl_errno($ch)) {
        // If there is a CURL error, return it in the response
        $errorMessage = curl_error($ch);
        echo json_encode(['status' => 'error', 'message' => 'CURL Error: ' . $errorMessage]);
        exit();
    }
    curl_close($ch);

    // Decode the response
    $responseData = json_decode($response, true);
    if ($responseData === null) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid JSON response from API.']);
        exit();
    }

    // Check if the response contains output and show it, or return an error message
    if (isset($responseData['output'])) {
        echo json_encode(['status' => 'success', 'output' => $responseData['output']]);
    } else {
        // If no output found, check for an error message
        $errorMessage = isset($responseData['error']) ? $responseData['error'] : 'Unknown error';
        echo json_encode(['status' => 'error', 'message' => 'Error: ' . $errorMessage]);
    }
}
?>
