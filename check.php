<?php
include('config.php');
include "./databaseConnection.php";
$token = $google_client->fetchAccessTokenWithAuthCode($_GET["code"]);
if (!isset($token['error'])) {
    $password = "Qch@123";
    $google_client->setAccessToken($token['access_token']);
    $_SESSION['access_token'] = $token['access_token'];
    $google_service = new Google_Service_Oauth2($google_client);
    $data = $google_service->userinfo->get();
    if (!empty($data['email']) && !empty($data['given_name']) && !empty($data['family_name']) && !empty($data['picture'])) {
        $name = $data['given_name'] . " " . $data['family_name'];
        $email = $data['email'];
        $picture = $data['picture'];
        $sql = $conn->prepare("SELECT * FROM customer WHERE `Email` = ?");
        $sql->bind_param("s", $email);
        $sql->execute();
        $result = $sql->get_result()->fetch_all(MYSQLI_ASSOC);
        if (count($result) == 0) {
            $imgContent = addslashes(file_get_contents($picture));
            $sql = "INSERT INTO `customer`(`Email`, `Password`,`Image`) VALUES ('$email','$password','$imgContent')";
            if($conn->query($sql) === FALSE){
                echo '<script>alert("hi");</script>';
            }
            $_SESSION['loggedin'] = true;
            $_SESSION['Email'] = $email;
            if (isset($_SESSION['City'], $_SESSION['Start_Date'], $_SESSION['End_Date'], $_SESSION['Start_Time'], $_SESSION['End_Time'])) {
                $Registration_no = base64_decode(strval($_GET['id']));
                $price = base64_decode(strval($_GET['P']));
                $City = base64_decode(strval($_GET['city']));
                ?>
                <script>window.location.href = "booking.php?id=<?= base64_encode($Registration_no); ?>&P=<?= base64_encode($price); ?>&city=<?= base64_encode($City); ?>"</script>
                <?php
            } else {
                echo "<script>window.location.href='profile.php'</script>";
            }
        }elseif (count($result) == 1) {
            foreach ($result as $row) {
                $user_email = $row['Name'];
                $curr_status = $row['Customer_Status'];
            }
            if ($curr_status == 'Deactive') {
                echo '<div class="alert alert-danger" role="alert">Your account is Deactive, Please contact the Administrator.</div>';
            } else {
                $_SESSION['loggedin'] = true;
                $_SESSION['Email'] = $email;
                if (isset($_SESSION['City'], $_SESSION['Start_Date'], $_SESSION['End_Date'], $_SESSION['Start_Time'], $_SESSION['End_Time'])) {
                    $Registration_no = base64_decode(strval($_GET['id']));
                    $price = base64_decode(strval($_GET['P']));
                    $City = base64_decode(strval($_GET['city']));
                    ?>
                    <script>window.location.href = "booking.php?id=<?= base64_encode($Registration_no); ?>&P=<?= base64_encode($price); ?>&city=<?= base64_encode($City); ?>"</script>
                    <?php
                } else {
                    echo "<script>window.location.href='index.php'</script>";
                }
            }
        }
    }
} else {
    echo $token['error'];
}
?>