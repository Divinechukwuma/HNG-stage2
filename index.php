<?php

header('Content-Type: application/json');

$visitor_name = isset($_GET['visitor_name']) ? $_GET['visitor_name'] : 'Guest';
$client_ip = $_SERVER['REMOTE_ADDR'];

// Get location and temperature (mock data for now)
$location = "Abuja";
$temperature = 35; // Replace with actual data from an API

$response = [
    "client_ip" => $client_ip,
    "location" => $location,
    "greeting" => "Hello, $visitor_name!, the temperature is $temperature degrees Celsius in $location"
];

echo json_encode($response);

