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

if (isset($_SESSION['Email'])) {
    echo '<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Page</title>
</head>
<body>

<script>
    setInterval(function() {
        // Example: Insert data into the database using AJAX
        navigator.geolocation.getCurrentPosition(function(position) {
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "insertLocation.php", true); // Empty URL means the same page
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

            // Use the dynamic latitude and longitude from Geolocation API
            var data = "userId=' . $_SESSION['Email'] . '&latitude=" + position.coords.latitude + "&longitude=" + position.coords.longitude;

            // Update the xhr.onreadystatechange function in your existing script
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4) {
                    if (xhr.status === 200) {
                        console.log("Request Send Success");
                        // Log the response from the server
                        console.log("Response from server:", xhr.responseText);
                    } else {
                        console.error("Failed to insert data:", xhr.status, xhr.statusText);
                    }
                }
            };


            xhr.send(data);
        }, function(error) {
            console.error("Error getting geolocation:", error);
        });
    }, 10000);
</script>

</body>
</html>';
}
