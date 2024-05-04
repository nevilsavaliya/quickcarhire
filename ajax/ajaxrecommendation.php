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

$City = $_SESSION['City'];
$sdate = $_SESSION['Start_Date'];
$edate = $_SESSION['End_Date'];

$kms = $_POST['button_value'];
$_SESSION['kms'] = $kms;

$customer_email = $_SESSION['Email'];
$sql_customer = "SELECT Name FROM customer WHERE Email = '$customer_email'";
$result_customer = $conn->query($sql_customer);

if ($result_customer) {
    if ($result_customer->num_rows > 0) {
        $row = $result_customer->fetch_assoc();
        $customer_name = $row["Name"];

        // Step 3: Fetch top car brands of the user based on their email
        $sql_top_brands = "SELECT c.Brand, COUNT(*) AS total_bookings
                                                        FROM booking b
                                                        INNER JOIN car c ON b.Registration_No = c.Registration_No
                                                        WHERE b.Email = '$customer_email'
                                                        GROUP BY c.Brand
                                                        ORDER BY total_bookings DESC
                                                        LIMIT 1";

        $result_top_brands = $conn->query($sql_top_brands);

        if ($result_top_brands) {
            if ($result_top_brands->num_rows > 0) {
                $top_car_brands = [];
                while ($row = $result_top_brands->fetch_assoc()) {
                    $top_car_brands[] = $row['Brand'];
                }

                // Step 4: Construct API URL with top car brands and customer name
                $api_url = "http://127.0.0.1:8080/recommendation?name=" . urlencode($customer_name) . "&brand=" . urlencode(implode(",", $top_car_brands));

                // Step 5: Fetch data from the API URL
                $api_data = file_get_contents($api_url);
                if ($api_data !== false) {
                    // Step 6: Display API response
                    $api_data_array = json_decode($api_data, true);
                    if (isset($api_data_array['recommendations'])) {
                        foreach ($api_data_array['recommendations'] as $car) {
                            $car_model = $car['model'];

                            // Step 7: Fetch car details using car model name if it exists in the database
                            $stmt = $conn->prepare("SELECT * FROM car WHERE Name = ?");
                            $stmt->bind_param("s", $car_model);
                            $stmt->execute();
                            $result_car = $stmt->get_result();

                            if ($result_car->num_rows > 0) {
                                while ($row = $result_car->fetch_assoc()) {
                                    $Registration_no = $row['Registration_No'];
                                    $Car_name = $row['Name'];
                                    $Brand = $row['Brand'];
                                    $Image = $row['Image'];
                                    $Car_hire_cost = $row['Hire_Cost'];
                                    $TotalBooked = $row['Total_Booked'];
                                    $Category_id = $row['Category_Id'];

                                    // Fetch category details
                                    $stmt_category = $conn->prepare("SELECT * FROM car_category WHERE Category_Id = ?");
                                    $stmt_category->bind_param("s", $Category_id);
                                    $stmt_category->execute();
                                    $result_category = $stmt_category->get_result();
                                    if ($result_category->num_rows > 0) {
                                        while ($row_category = $result_category->fetch_assoc()) {
                                            $Category_name = $row_category['Category_Name'];
                                            $Seats = $row_category['Seats'];
                                            $Fuel = $row_category['Fuel'];
                                            $Transmission = $row_category['Transmission'];
                                            ?>
                                            <div class="col-4 col-md-4 col-xl-4">
                                                <div class="car">
                                                    <div class="splide splide--card car__slider splide--loop splide--ltr splide--draggable is-active is-initialized" id="splide02">
                                                        <div class="splide__track" id="splide02-track" style="padding-left: 0px; padding-right: 0px;">
                                                            <img src="images/carimg/<?php echo $Image; ?>" style="height: 200px;" alt="Refresh">
                                                        </div>
                                                    </div>
                                                    <div class="car__title">
                                                        <h3 class="car__name">
                                                            <?php echo $Car_name; ?>
                                                        </h3>
                                                        <span class="car__year"><?php echo $Brand; ?></span>
                                                    </div>
                                                    <ul class="car__list">
                                                        <li>
                                                            <i class="fa-solid fa-user-group" style="color: #189cf4;"></i>&nbsp;&nbsp;
                                                            <span><?php echo $Seats; ?> Seats</span>
                                                        </li>

                                                        <li>
                                                            <i class="fa-solid fa-car-side" style="color: #189cf4;"></i>&nbsp;&nbsp;
                                                            <span><?php echo $Category_name; ?></span>
                                                        </li>
                                                        <li>
                                                            <i class="fa-solid fa-gas-pump" style="color: #189cf4;"></i>&nbsp;&nbsp;
                                                            <span><?php echo $Fuel; ?></span>
                                                        </li>
                                                        <li>
                                                            <i class="fa-solid fa-gears" style="color: #189cf4;"></i>&nbsp;&nbsp;
                                                            <span><?php echo $Transmission; ?></span>
                                                        </li>

                                                    </ul>
                                                    <div class="car__footer">
                                                            <span class="car__price">
                                                                <i class="fa-solid fa-indian-rupee-sign"></i>
                                                                <?php
                                                                $price = $Car_hire_cost * $kms;
                                                                echo $price;
                                                                ?>
                                                            </span>

                                                        <?php
                                                        if (isset($_SESSION['loggedin'])) {
                                                            ?>
                                                            <a href="booking.php?id=<?= base64_encode($Registration_no); ?>&P=<?= base64_encode($price); ?>&city=<?= base64_encode($City); ?>" class="car__more">
                                                                <span>Rent now</span>
                                                            </a>
                                                            <?php
                                                        } else {
                                                            ?>
                                                            <a href="login.php?id=<?= base64_encode($Registration_no); ?>&P=<?= base64_encode($price); ?>&city=<?= base64_encode($City); ?>" class="car__more">
                                                                <span>Rent now</span>
                                                            </a>
                                                            <?php
                                                        }
                                                        ?>
                                                    </div>
                                                </div>
                                            </div>


                                            <?php

                                            // Display car details
                                            //                                                                                echo "<div class='car'>";
                                            //                                                                                echo "<div class='car__title'>";
                                            //                                                                                echo "<div class='splide__track' id='splide02-track' style='padding-left: 0px; padding-right: 0px;'>
                                            //                            <img src='images/carimg/$Image' style='height: 200px;' alt='Refresh'>
                                            //                        </div>";
                                            //                                                                                echo "<h3 class='car__name'>$Car_name</h3>";
                                            //                                                                                echo "<span class='car__year'>$Brand</span>";
                                            //                                                                                echo "</div>";
                                            //                                                                                echo "<ul class='car__list'>";
                                            //                                                                                echo "<li><span>Registration No: $Registration_no</span></li>";
                                            //                                                                                echo "<li><span>Category: $Category_name</span></li>";
                                            //                                                                                echo "<li><span>Seats: $Seats</span></li>";
                                            //                                                                                echo "<li><span>Fuel: $Fuel</span></li>";
                                            //                                                                                echo "<li><span>Transmission: $Transmission</span></li>";
                                            //                                                                                echo "<li><span>Hire Cost: $Car_hire_cost</span></li>";
                                            //                                                                                echo "<li><span>Total Booked: $TotalBooked</span></li>";
                                            //                                                                                echo "<li><span><a href='car.php'>Rent now</a></span></li>";
                                            //                                                                                echo "</ul>";
                                            //                                                                                echo "</div>";
                                        }
                                    } else {
                                        echo "<script>alert('Category not found.');</script>";
                                    }
                                }
                            }
                        }
                    } else {
                        echo "No recommendations found.";
                    }
                } else {
                    echo "Failed to fetch data from API.";
                }
            } else {
                echo "No bookings found for the user.";
            }
        } else {
            echo "Error executing top brands query: " . $conn->error;
        }
    } else {
        echo "Customer not found.";
    }
} else {
    echo "Error executing customer query: " . $conn->error;
}

?>