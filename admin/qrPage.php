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

    <!-- Include the Instascan library -->
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
                    <p id="qrData" style="color: black;"></p>
                </div>
            </div>

            <!--            <div>-->
<!---->
<!--            <video id="video" width="550" height="300" autoplay></video><br><br>-->
<!--            <p id="qrData" style="color: black; width: 1000px; font-weight: bold" ></p> // New element to display QR code data -->
<!--            </div>-->

            <script>
                const video = document.getElementById('video');
                const qrDataElement = document.getElementById('qrData');
                const scanner = new Instascan.Scanner({ video: video });

                scanner.addListener('scan', function (content) {
                    console.log('QR Code data:', content);
                    // Display the QR code data on the page
                    const contentWithoutBraces = content.replace(/[{()}"]/g, '').replace(/:/g, ': ');
                    const dataArray = contentWithoutBraces.split(',');
                    // Format the content for display
                    const formattedContent = dataArray
                        .map(item => {
                            const [key, value] = item.split(':');
                            return `<p><strong>${key.trim()}</strong>: ${value.trim()}</p>`;
                        })
                        .join('');

                    // Display the QR code data on the page
                    qrDataElement.innerHTML = `<p>Scanned QR Code data:</p>${formattedContent}`;
                    // qrDataElement.innerHTML = dataArray.map(item => '<p>' + item + '</p>').join('');
                    // qrDataElement.innerHTML = '\nScanned QR Code data: ' + dataArray + '\n';

                    // You can send the QR code data to the server here if needed
                });

                Instascan.Camera.getCameras().then(function (cameras) {
                    if (cameras.length > 0) {
                        scanner.start(cameras[0]);
                    } else {
                        console.error('No cameras found.');
                    }
                }).catch(function (e) {
                    console.error(e);
                });
            </script>
        </div>
    </div>
</body>
</html>
