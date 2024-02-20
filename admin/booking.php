<!DOCTYPE html>
<html lang="en">
<head>
    <title>Booking</title>
    <?php
    include './headerLinks.php';
    include './sessionWithoutLogin.php';
    include './databaseConnection.php';
    ?>
</head>
<body id="page-top">
<div id="wrapper">
    <?php
    include './sidebar.php';
    ?>
    <div id="content-wrapper" class="d-flex flex-column">
        <?php
        include './header.php';
        ?>
        <script>
            function Checkboxseleted() {
                alert('Please Select any one check box!');
            }

            $(document).ready(function () {
                $('#Car').DataTable();
            });

            function showMap(email) {
                window.location.href = 'showMap.php?email=' + email;
            }
        </script>
        <!-- Begin Page Content -->
        <div class="container-fluid">
            <main>
                <form method="post" enctype="multipart/form-data">
                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h2 class="m-0 font-weight-bold text-primary">Booking</h2>
                        </div>
                        <?php
                        $userRole = $_SESSION['role_id'];
                        if ($userRole == '1') {
                            $tableHeaders = array(
                                'Booking_Id', 'Email', 'Registration_No', 'City_Id', 'Start_Date', 'End_Date', 'Start_Time', 'End_Time', 'Security_Deposit', 'Selected_Kms', 'Booking_Amount', 'Offer', 'Total_Amount', 'Booking_Date', 'Status', 'See_Map'
                            );
                        } else {
                            $tableHeaders = array(
                                'Booking_Id', 'Email', 'Registration_No', 'Start_Date', 'End_Date', 'Start_Time', 'End_Time', 'Security_Deposit', 'Selected_Kms', 'Booking_Amount', 'Offer', 'Total_Amount', 'Booking_Date', 'Status', 'See_Map'
                            );
                        }

                        $customHeaders = array(
                            'Booking_Id' => ' Booking Id',
                            'Email' => 'Email',
                            'Registration_No' => 'Car Registration',
                            'City_Id' => 'City',
                            'Start_Date' => 'Start Date',
                            'End_Date' => 'End Date',
                            'Start_Time' => 'Start Time',
                            'End Time' => 'End Time',
                            'Security_Deposit' => 'Security Deposit',
                            'Selected_Kms' => 'Selected Kms',
                            'Booking_Amount' => 'Booking Amount',
                            'Offer' => 'Offer',
                            'Total_Amount' => 'Total Amount',
                            'Booking_Date' => 'Booking Date',
                            'Status' => 'Status',
                            'See_Map' => 'See Map'
                        );

                        $selectedColumns = isset($_POST['selected_columns']) ? $_POST['selected_columns'] : $tableHeaders;
                        ?>
                        <div id="Reportresult"></div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable">
                                    <thead>
                                    <tr style=" position: sticky;">
                                        <?php
                                        foreach ($tableHeaders as $header) {
                                            $displayName = isset($customHeaders[$header]) ? $customHeaders[$header] : $header;
                                            echo "<th scope=\"col\">$displayName</th>";
                                        }
                                        ?>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    if (isset($_SESSION['city_id'])) {
                                        $city_id = $_SESSION['city_id'];
                                        $query = "SELECT * FROM booking WHERE City_Id = '$city_id'";
                                    } else {
                                        $query = "SELECT * FROM booking";
                                    }
                                    $result = $conn->query($query);

                                    if ($result->num_rows > 0) {
                                        while ($row = $result->fetch_assoc()) {
                                            echo "<tr>";
                                            foreach ($tableHeaders as $header) {
                                                if (in_array($header, $selectedColumns)) {
                                                    $bookingId = $row['Booking_Id'];
                                                    $Booking_start_date = $row['Start_Date'];
                                                    $Booking_end_date = $row['End_Date'];
                                                    $current_date = date('Y-m-d');

                                                    if ($current_date < $Booking_start_date) {
                                                        $booking_status = 'Pending';
                                                    } elseif ($current_date >= $Booking_start_date && $current_date <= $Booking_end_date) {
                                                        $booking_status = 'Current';
                                                    } elseif ($current_date > $Booking_end_date) {
                                                        $booking_status = 'Completed';
                                                    }

                                                    $sql_update = "UPDATE booking SET Status='$booking_status' WHERE  Booking_Id ='$bookingId'";
                                                    if ($conn->query($sql_update) === TRUE) {

                                                    } else {
                                                        echo "<script>alert(Error updating booking record: . $conn->error)</script>";
                                                    }

                                                    if ($header === 'Status') {
                                                        $Status = $row['Status'];

                                                        if ($Status == 'Completed') {
                                                            echo "<td><span class='badge' style='background-color: #36b9cc;'>$Status</span></td>";
                                                        } else if ($Status == 'Current') {
                                                            echo "<td><span class='badge' style='background-color: #17a673;'>$Status</span></td>";
                                                        } else {
                                                            echo "<td><span class='badge' style='background-color: #4e73df;'>$Status</span></td>";
                                                        }
                                                    } elseif ($header === 'See_Map') {

                                                        $edate = $row['End_Date'];
                                                        $sdate = $row['Start_Date'];
                                                        $email = $row['Email'];
                                                        echo "<form method='post' action='showMap.php'>";
                                                        echo "<input type='hidden' name='email' value='".$email."'>";
                                                        echo "<input type='hidden' name='sdate' value='".$sdate."'>";
                                                        echo "<input type='hidden' name='edate' value='".$edate."'>";
                                                        echo "<td><button type='submit'><i class='fa fa-map-marked-alt'></i></button></td>";
                                                        echo "</form>";
                                                    } else {
                                                        echo "<td>{$row[$header]}</td>";
                                                    }
                                                }
                                            }
                                            echo "</tr>";
                                        }
                                    }
                                    ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </form>
                <script>
                    function toggleForm() {
                        var formContainer = document.getElementById('formContainer');
                        if (formContainer.style.display === 'none' || formContainer.style.display === '') {
                            formContainer.style.display = 'block';
                        } else {
                            formContainer.style.display = 'none';
                        }
                    }

                    function updateDisplayedColumns() {
                        var checkboxes = document.querySelectorAll('input[name="selected_columns[]"]');
                        var tableHeaders = document.querySelectorAll('th');
                        var tableRows = document.querySelectorAll('tbody tr');

                        checkboxes.forEach(function (checkbox, index) {
                            var isChecked = checkbox.checked;
                            var columnHeader = tableHeaders[index];
                            columnHeader.style.display = isChecked ? 'table-cell' : 'none';

                            tableRows.forEach(function (row) {
                                var cells = row.querySelectorAll('td');
                                var cell = cells[index];
                                cell.style.display = isChecked ? 'table-cell' : 'none';
                            });
                        });
                    }
                </script>
                <?php
                if (isset($_POST['Car_delete'])) {
                    if (isset($_POST['delete'])) {
                        foreach ($_POST['delete'] as $deleteid) {
                            $deleteCar = $conn->prepare("DELETE from car WHERE Registration_No=?");
                            $deleteCar->bind_param("s", $deleteid);
                            try {
                                $deleteCar->execute();
                            } catch (mysqli_sql_exception $e) {
                                $errorMessage = $e->getMessage();
                                echo "<script>alert('$errorMessage');</script>";
                            }
                        }
                        echo "<script>window.location.href='car.php'</script>";
                    } else {
                        echo '<script>Checkboxseleted();</script>';
                    }
                }
                ?>
            </main>
            <div class="container">
                <button id="moreButton" class="btn btn-primary" onclick="toggleForm()">More Option</button>
                <div id="formContainer" style="display: none;">
                    <form method="post" onchange="updateDisplayedColumns()" id="option">
                        <?php
                        foreach ($tableHeaders as $header) {
                            $isChecked = in_array($header, $selectedColumns) || $header === 'Name' || $header === 'Email';
                            $disabled = $header === 'Registration_No' ? 'disabled' : '';
                            $checked = $isChecked ? 'checked' : '';
                            ?>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" name="selected_columns[]"
                                       value="<?php echo $header; ?>" <?php echo $checked; ?> <?php echo $disabled; ?>>
                                <label class="form-check-label"><?php echo $header; ?></label>
                            </div>
                            <?php
                        }
                        ?>
                    </form>
                </div>
            </div>
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
