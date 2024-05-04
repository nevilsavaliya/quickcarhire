<!DOCTYPE html>
<html lang="en">
<head>
    <title>Booking</title>
    <?php
    include './headerLinks.php';
    include './sessionWithoutLogin.php';
    include './databaseConnection.php';
    ?>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.2.0/dist/leaflet.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine@latest/dist/leaflet-routing-machine.css" />
    <style>
        #map {
            height: 700px;
        }
    </style>
</head>
<body id="page-top">

<script src="https://unpkg.com/leaflet@1.2.0/dist/leaflet.js"></script>
<script src="https://unpkg.com/leaflet-routing-machine@latest/dist/leaflet-routing-machine.js"></script>
<?php

// Assuming you have a database connection established.
// Replace these with your actual database credentials.
include "databaseConnection.php";

// Function to fetch data based on email and date
function fetchData($conn, $email, $date) {
    $sql = "SELECT * FROM `user_locations` WHERE `email` = '$email' AND `date` = '$date' ORDER BY `time` ASC";
    $result = $conn->query($sql);
    $data = array();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
    }

    return $data;
}

// Get email and date from the URL
$email = $_POST['email'] ?? '';
$sdate = $_POST['sdate'] ?? '';
$edate = $_POST['edate'] ?? '';

if (!empty($email) && !empty($sdate) && !empty($edate)){
    $userData = fetchData($conn, $email, $sdate);
    $conn->close();
    //

} else {
    echo "Email and date parameters are required.";
}

?>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        <?php
        echo "var map = L.map('map').setView([" . $userData[0]['latitude'] . ", " . $userData[0]['longitude'] . "], 13);";
        ?>

        L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        var routingControl = L.Routing.control({
            waypoints: [
                <?php
                foreach ($userData as $key => $value) {
                    echo "L.latLng(" . $value['latitude'] . ", " . $value['longitude'] . "),";
                }
                ?>
            ]
        }).addTo(map);

    });
</script>
<div id="wrapper">
    <?php
    include './sidebar.php';
    ?>
    <div id="content-wrapper" class="d-flex flex-column">
        <?php
        include './header.php';
        ?>
        <!-- Begin Page Content -->
        <div class="container-fluid">
            <main>
                <form method="post" enctype="multipart/form-data">
                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h2 class="m-0 font-weight-bold text-primary">Booking</h2>
                        </div>
                        <div id="Reportresult"></div>
                        <div class="card-body">
                            <div id="map"></div>
                        </div>
                    </div>
                </form>
            </main>
        </div>
    </div>
</div>
</div>
<script>
    $(document).ready(function () {
        $('#dataTable').DataTable({
            "order": [[4, 'desc']]
        });
    });
</script>
<?php include './footerLinks.php'; ?>
</body>
</html>
