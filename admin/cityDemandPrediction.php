<?php
include './headerLinks.php';
include './sessionWithoutLogin.php';
include './databaseConnection.php';
?>
<html lang="en">

<head>
    <!-- Include necessary CSS and JS libraries -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js"></script>
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

            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <label for="citySelector">Select City:</label>
                        <select id="citySelector" class="form-control">
                            <!-- Populate this dynamically with your car registration numbers -->
                            <option value="select City:">Select City</option>
                            <?php
                               $query = "SELECT * FROM city";
                               $result = $conn->query($query);
                               $id = 1;
                               while ($row = mysqli_fetch_array($result)) {
                                   $city = $row['City'];
                                   $City_Id = $row['City_Id'];
                                   ?>
                                   <option value="<?= $City_Id; ?>">
                                       <?= $city; ?>
                                   </option>
                                   <?php
                                   $id++;
                               }
                            ?>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="weekSelector">Select Week:</label>
                        <select id="weekSelector" class="form-control">
                            <option value="1">Week 1</option>
                            <option value="2">Week 2</option>
                            <!-- Add more options as needed -->
                        </select>
                    </div>
                   
                </div>

                <div class="row mt-3">
                    <div class="col-md-12">
                        <canvas id="myLineChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
</body>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- jsPDF library -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.3/jspdf.umd.min.js"></script>

<!-- html2pdf library -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
<script>
    Chart.defaults.global.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
        Chart.defaults.global.defaultFontColor = '#858796';

        function number_format(number, decimals, dec_point, thousands_sep) {
            // *     example: number_format(1234.56, 2, ',', ' ');
            // *     return: '1 234,56'
            number = (number + '').replace(',', '').replace(' ', '');
            var n = !isFinite(+number) ? 0 : +number,
                prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
                sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
                dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
                s = '',
                toFixedFix = function (n, prec) {
                    var k = Math.pow(10, prec);
                    return '' + Math.round(n * k) / k;
                };
            // Fix for IE parseFloat(0.55).toFixed(0) = 0;
            s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
            if (s[0].length > 3) {
                s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
            }
            if ((s[1] || '').length < prec) {
                s[1] = s[1] || '';
                s[1] += new Array(prec - s[1].length + 1).join('0');
            }
            return s.join(dec);
        }

    //     $(document).ready(function () {
    //         // Function to fetch demand data for the selected car and week using Ajax and update the line chart
    //         function fetchDemandData(selectedCar, selectedWeek) {
    //             $.ajax({
    //                 url: './ajax/fetchDemandData.php',
    //                 method: 'POST',
    //                 data: {
    //                     car: selectedCar,
    //                     week: selectedWeek
    //                 },
    //                dataType: 'json',
    //                 success: function (data) {
    //                     console.log(data);
    //                     updateChart(data);
    //                 },
    //                 error: function (error) {
    //                     console.error('Error fetching demand data:', error);
    //                 }
    //             });
    //         }

    //         // Function to update the line chart with the provided data
    //         function updateChart(data) {
    //             var ctx = document.getElementById("myLineChart").getContext("2d");
    //             var myLineChart = new Chart(ctx, {
    //                 type: 'line',
    //                 data: {
    //                     labels: data.labels,
    //                     datasets: [{
    //                         label: "Demand",
    //                         lineTension: 0.3,
    //                         backgroundColor: "rgba(78, 115, 223, 0.05)",
    //                         borderColor: "rgba(78, 115, 223, 1)",
    //                         pointRadius: 3,
    //                         pointBackgroundColor: "rgba(78, 115, 223, 1)",
    //                         pointBorderColor: "rgba(78, 115, 223, 1)",
    //                         pointHoverRadius: 3,
    //                         pointHoverBackgroundColor: "rgba(78, 115, 223, 1)",
    //                         pointHoverBorderColor: "rgba(78, 115, 223, 1)",
    //                         pointHitRadius: 10,
    //                         pointBorderWidth: 2,
    //                         data: data.demand,
    //                     }],
    //                 },
    //                 options: {
    //                     maintainAspectRatio: false,
    //                     layout: {
    //                         padding: {
    //                             left: 10,
    //                             right: 25,
    //                             top: 25,
    //                             bottom: 0
    //                         }
    //                     },
    //                     scales: {
    //                         xAxes: [{
    //                             time: {
    //                                 unit: 'date'
    //                             },
    //                             gridLines: {
    //                                 display: false,
    //                                 drawBorder: false
    //                             },
    //                             ticks: {
    //                                 maxTicksLimit: 7
    //                             }
    //                         }],
    //                         yAxes: [{
    //                             ticks: {
    //                                 maxTicksLimit: 5,
    //                                 padding: 10,
    //                                 callback: function (value, index, values) {
    //                                     return number_format(value);
    //                                 }
    //                             },
    //                             gridLines: {
    //                                 color: "rgb(234, 236, 244)",
    //                                 zeroLineColor: "rgb(234, 236, 244)",
    //                                 drawBorder: false,
    //                                 borderDash: [2],
    //                                 zeroLineBorderDash: [2]
    //                             }
    //                         }]
    //                     },
    //                     legend: {
    //                         display: false
    //                     },
    //                     tooltips: {
    //                         backgroundColor: "rgb(255,255,255)",
    //                         bodyFontColor: "#858796",
    //                         titleMarginBottom: 10,
    //                         titleFontColor: '#6e707e',
    //                         titleFontSize: 14,
    //                         borderColor: '#dddfeb',
    //                         borderWidth: 1,
    //                         xPadding: 15,
    //                         yPadding: 15,
    //                         displayColors: false,
    //                         intersect: false,
    //                         mode: 'index',
    //                         caretPadding: 10,
    //                         callbacks: {
    //                             label: function (tooltipItem, chart) {
    //                                 var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
    //                                 return datasetLabel + ': ' + number_format(tooltipItem.yLabel);
    //                             }
    //                         }
    //                     }
    //                 }
    //             });
    //         }

    //         // Fetch initial demand data for the default car and week
    //         var defaultData = {
    //             labels: ["Past Week 4", "Past Week 3", "Past Week 2", "Past Week 1", "Future Week 1", "Future Week 2", "Future Week 3", "Future Week 4"],
    //             demand: [5, 0, 1, 0, -3, -5, -6, -8]
    //         };

    //         updateChart(defaultData);

    //         // Event listener for car selection
    //         $('#carSelector').on('change', function () {
    //             var selectedCar = $(this).val();
    //             var selectedWeek = $('#weekSelector').val();

    //             // fetchDemandData(selectedCar, selectedWeek);
    //             updateChart();
    //         });

    //         // Event listener for week selection
    //         $('#weekSelector').on('change', function () {
    //             var selectedWeek = $(this).val();
    //             var selectedCar = $('#carSelector').val();

    //             // fetchDemandData(selectedCar, selectedWeek);
    //             updateChart();
    //         });
    //     });

    // ----------------------------------------------------------------
    function updateChart() {

        if (window.myChart) {
            window.myChart.destroy();
        }

        var selectedCity = $('#citySelector').val();
        var selectedWeek = $('#weekSelector').val();

        $.ajax({
            url: './ajax/fetchCityDemandData.php',
            method: 'POST',
            data: {
                city: selectedCity,
                week: selectedWeek
            },
            dataType: 'json',
            success: function(data) {
                console.log(data);
                data.demand.forEach(function(value, index) {
                    console.log('Type of data.demand[' + index + ']:', typeof value);
                });
                const myLineChart = {
                    type: 'line',
                    data: {
                        labels: data.labels,
                        datasets: [{
                            label: "Demand",
                            lineTension: 0.3,
                            backgroundColor: "rgba(78, 115, 223, 0.05)",
                            borderColor: "rgba(78, 115, 223, 1)",
                            pointRadius: 3,
                            pointBackgroundColor: "rgba(78, 115, 223, 1)",
                            pointBorderColor: "rgba(78, 115, 223, 1)",
                            pointHoverRadius: 3,
                            pointHoverBackgroundColor: "rgba(78, 115, 223, 1)",
                            pointHoverBorderColor: "rgba(78, 115, 223, 1)",
                            pointHitRadius: 10,
                            pointBorderWidth: 2,
                            data: data.demand,
                        }],
                    },
                    options: {
                        maintainAspectRatio: false,
                        layout: {
                            padding: {
                                left: 10,
                                right: 25,
                                top: 25,
                                bottom: 0
                            }
                        },
                        scales: {
                            xAxes: [{
                                time: {
                                    unit: 'date'
                                },
                                gridLines: {
                                    display: false,
                                    drawBorder: false
                                },
                                ticks: {
                                    maxTicksLimit: 7
                                }
                            }],
                            yAxes: [{
                                ticks: {
                                    maxTicksLimit: 5,
                                    padding: 10,
                                    callback: function(value, index, values) {
                                        return number_format(value);
                                    }
                                },
                                gridLines: {
                                    color: "rgb(234, 236, 244)",
                                    zeroLineColor: "rgb(234, 236, 244)",
                                    drawBorder: false,
                                    borderDash: [2],
                                    zeroLineBorderDash: [2]
                                }
                            }]
                        },
                        legend: {
                            display: false
                        },
                        tooltips: {
                            backgroundColor: "rgb(255,255,255)",
                            bodyFontColor: "#858796",
                            titleMarginBottom: 10,
                            titleFontColor: '#6e707e',
                            titleFontSize: 14,
                            borderColor: '#dddfeb',
                            borderWidth: 1,
                            xPadding: 15,
                            yPadding: 15,
                            displayColors: false,
                            intersect: false,
                            mode: 'index',
                            caretPadding: 10,
                            callbacks: {
                                label: function(tooltipItem, chart) {
                                    var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
                                    return datasetLabel + ': ' + number_format(tooltipItem.yLabel);
                                }
                            }
                        }
                    }
                };

                const ctx = document.getElementById("myLineChart").getContext("2d");
                window.myChart = new Chart(ctx, myLineChart);
            },
            error: function(error) {
                console.error('Error fetching demand data:', error);
            }
        });
    }
    // Event listener for car selection
    $('#citySelector').on('change', function() {
        var selectedCity = $(this).val();
        var selectedWeek = $('#weekSelector').val();

        // fetchDemandData(selectedCar, selectedWeek);
        updateChart();
    });

    // Event listener for week selection
    $('#weekSelector').on('change', function() {
        var selectedWeek = $(this).val();
        var selectedCar = $('#citySelector').val();

        // fetchDemandData(selectedCar, selectedWeek);
        updateChart();
    });
</script>

</script>