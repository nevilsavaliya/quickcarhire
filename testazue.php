<?php
//session_start();
//$servername = "bkervzwjsr4vk9ln1dop-mysql.services.clever-cloud.com";
//$username = "uk4aenfo1gspdujt";
//$password = "P5mkIXVclvxUHwlTzxP9";
//$dbname = "bkervzwjsr4vk9ln1dop";
//
//// Create connection
//$conn = new mysqli($servername, $username, $password, $dbname);
//
//// Check connection
//if ($conn->connect_error) {
//    die("Connection failed: " . $conn->connect_error);
//}
//


// Function to run when start date and time match current date and time
function on_booking_match($booking_data)
{
    // Implement your desired logic here
    echo "Booking match found: ";
    print_r($booking_data);
}

// Connect to MySQL database
$servername = "localhost";
$username = "root";
$password = "";
$database = "quickcarhire1";

$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Execute the SQL query
$sql = "SELECT * FROM booking";
$result = $conn->query($sql);

// Get current date and time
$current_datetime = date('Y-m-d H:i:s');

// Check for matching bookings
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $start_datetime = $row["Start_Date"] . " " . $row["Start_Time"];
        if (date('Y-m-d H:i', strtotime($start_datetime)) == date('Y-m-d H:i', strtotime($current_datetime))) {
            echo 'hi';
            on_booking_match($row);
        }

    }
} else {
    echo "0 results";
}

// Close database connection
$conn->close();


