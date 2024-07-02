<?php

header('Content-Type: application/json');

// Function to get the client IP address
function get_client_ip() {
    $ipaddress = '';
    if (isset($_SERVER['HTTP_CLIENT_IP'])) {
        $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
    } else if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else if (isset($_SERVER['HTTP_X_FORWARDED'])) {
        $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
    } else if (isset($_SERVER['HTTP_FORWARDED_FOR'])) {
        $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
    } else if (isset($_SERVER['HTTP_FORWARDED'])) {
        $ipaddress = $_SERVER['HTTP_FORWARDED'];
    } else if (isset($_SERVER['REMOTE_ADDR'])) {
        $ipaddress = $_SERVER['REMOTE_ADDR'];
    } else {
        $ipaddress = 'UNKNOWN';
    }
    return $ipaddress;
}

$visitor_name = isset($_GET['visitor_name']) ? $_GET['visitor_name'] : 'Guest';

// Get client IP
$client_ip = get_client_ip();

// Using a free API service to get location
$location_api_url = "http://ip-api.com/json/{$client_ip}";
$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, $location_api_url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$location_data = curl_exec($ch);

if (curl_errno($ch)) {
    $error = curl_error($ch);
    $city = 'Unknown';
} else {
    $location_data = json_decode($location_data, true);
    if ($location_data['status'] == 'success') {
        $city = $location_data['city'];
        $error = null;
    } else {
        $city = 'Unknown';
        $error = isset($location_data['message']) ? $location_data['message'] : 'Unknown error';
    }
}

curl_close($ch);

$response = [
    "client_ip" => $client_ip,
    "location" => $city,
    "greeting" => "Hello, {$visitor_name}!",
    "error" => $error
];

echo json_encode($response);

?>
