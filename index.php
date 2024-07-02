<?php

header('Content-Type: application/json');

$visitor_name = isset($_GET['visitor_name']) ? $_GET['visitor_name'] : 'Guest';

header('Content-Type: application/json');

// Function to get the client IP address
function get_client_ip() {
    $ipaddress = '';
    if (isset($_SERVER['HTTP_CLIENT_IP']))
        $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
    else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
        $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
    else if(isset($_SERVER['HTTP_X_FORWARDED']))
        $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
    else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
        $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
    else if(isset($_SERVER['HTTP_FORWARDED']))
        $ipaddress = $_SERVER['HTTP_FORWARDED'];
    else if(isset($_SERVER['REMOTE_ADDR']))
        $ipaddress = $_SERVER['REMOTE_ADDR'];
    else
        $ipaddress = 'UNKNOWN';
    return $ipaddress;
}

$visitor_name = isset($_GET['visitor_name']) ? $_GET['visitor_name'] : 'Guest';

// Get client IP
$client_ip = get_client_ip();

// Get location data
$location_api_url = "https://api.ip2location.io/?key=45C8DDB02866299AFFBBE509C3CC87DA&ip={$client_ip}";
$location_data = json_decode(file_get_contents($location_api_url), true);
$city = $location_data['city'];

$response = [
    "client_ip" => $client_ip,
    "location" => $city,
    "greeting" => "Hello, {$visitor_name}!, the temperature is {$temperature} degrees Celsius in {$city}"
];

echo json_encode($response);
?>

