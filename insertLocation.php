<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "quickcarhire1";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userId = $_POST['userId'];
    $latitude = $_POST['latitude'];
    $longitude = $_POST['longitude'];
    $currentDate = date("Y-m-d");
    $currentTime = date("H:i:s");

    $sql = "INSERT INTO `user_locations`(`email`, `latitude`, `longitude`, `date`, `time`) VALUES ('$userId','$latitude','$longitude','$currentDate','$currentTime')";
    $conn->query($sql);

} else {
    echo "Invalid request";
}
?>
