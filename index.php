<?php

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


// Get location and temperature (mock data for now)

// Using a free API service to get location and weather data
$location_api_url = "https://api.ip2location.io/?key=45C8DDB02866299AFFBBE509C3CC87DA&ip={$client_ip}";
$location_data = json_decode(file_get_contents($location_api_url), true);
$city = $location_data['city'];

$temperature = 35; // Replace with actual data from an API

$response = [
    "client_ip" => get_client_ip(),
    "location" => $location,
    "greeting" => "Hello, $visitor_name!, the temperature is $temperature degrees Celsius in $location"
];

echo json_encode($response);

