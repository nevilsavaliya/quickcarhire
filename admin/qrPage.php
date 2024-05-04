<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QR Code Scanner</title>

    <!-- Include necessary header links, session handling, and database connection -->
    <?php
    include './headerLinks.php';
    include './sessionWithoutLogin.php';
    include './databaseConnection.php';
    ?>

    <script src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>
</head>
<body id="page-top">
<div id="wrapper">
    <!-- Include the sidebar -->
    <?php
    include './sidebar.php';
    ?>

    <div id="content-wrapper" class="d-flex flex-column">
        <!-- Include the header -->
        <?php
        include './header.php';
        ?>

        <h3 style="margin: 25px; color: black">QR Code Scanner</h3>
        <div style="display: flex; align-items: flex-start;">
            <video id="video" width="550" height="300" autoplay></video>
            <div style="margin-left: 20px; max-width: 1000px;">
                <div id="qrData" style="color: black;"></div>
            </div>
        </div>

        <script>
            const video = document.getElementById('video');
            const qrDataElement = document.getElementById('qrData');
            const scanner = new Instascan.Scanner({ video: video });

            scanner.addListener('scan', function (content) {
                console.log('QR Code data:', content);
                // Display the QR code data on the page
                try {
                    const qrData = JSON.parse(content);
                    let formattedContent = "<p>Scanned QR Code data:</p>";
                    Object.entries(qrData).forEach(([key, value]) => {
                        formattedContent += "<p><strong>" + key + "</strong>: " + value + "</p>";
                    });
                    qrDataElement.innerHTML = formattedContent;
                } catch (error) {
                    console.error('Error parsing QR code data:', error);
                    qrDataElement.textContent = 'Error: Invalid QR code data';
                }
            });

            Instascan.Camera.getCameras().then(function (cameras) {
                if (cameras.length > 0) {
                    scanner.start(cameras[0]);
                } else {
                    console.error('No cameras found.');
                }
            }).catch(function (e) {
                console.error('Error accessing camera:', e);
            });
        </script>
    </div>
</div>
</body>
</html>
