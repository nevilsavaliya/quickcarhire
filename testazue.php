<?php
session_start();
$servername = "bkervzwjsr4vk9ln1dop-mysql.services.clever-cloud.com";
$username = "uk4aenfo1gspdujt";
$password = "P5mkIXVclvxUHwlTzxP9";
$dbname = "bkervzwjsr4vk9ln1dop";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

