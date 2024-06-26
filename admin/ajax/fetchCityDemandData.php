<?php
include '../databaseConnection.php';

function getCarRentalDemand($conn, $cityId, $week)
{
    $daysAgoStart = $week * 7;
    $daysAgoEnd = $daysAgoStart - 7;
    $pastDate1 = new DateTime();
    $pastDate1->sub(new DateInterval("P{$daysAgoStart}D"));
    $pastDate1 = $pastDate1->format('Y-m-d');

    $pastDate2 = new DateTime();
    $pastDate2->sub(new DateInterval("P{$daysAgoEnd}D"));
    $pastDate2 = $pastDate2->format('Y-m-d');

    $sql = "SELECT COUNT(*) as count FROM `booking` WHERE City_Id = '$cityId' AND `Booking_Date` BETWEEN '$pastDate1' AND '$pastDate2'";
    
    // Add this line for debugging
    //echo "SQL Query: $sql\n";

    $result = $conn->query($sql);

    if ($result === false) {
        die("Error executing query: " . $conn->error);
    }

    $row = $result->fetch_assoc();
    
    // Add this line for debugging
    //var_dump($row);

    return (int)$row['count'];
}


class LinearRegression
{
    protected $slope;
    protected $intercept;

    public function train($x, $y)
    {
        // Calculate slope and intercept using linear regression formulas
        $n = count($x);
        $sumX = array_sum($x);
        $sumY = array_sum($y);
        $sumXY = 0;
        $sumXX = 0;

        for ($i = 0; $i < $n; $i++) {
            $sumXY += ($x[$i] * $y[$i]);
            $sumXX += ($x[$i] * $x[$i]);
        }

        $this->slope = ($n * $sumXY - $sumX * $sumY) / ($n * $sumXX - $sumX * $sumX);
        $this->intercept = ($sumY - $this->slope * $sumX) / $n;
    }

    public function predict($x)
    {
        return $this->slope * $x + $this->intercept;
    }
}

// Example: Fetching City_Id and week dynamically (you may replace this with your actual user input mechanism)
$cityId = isset($_POST['city']) ? $_POST['city'] : 'GJ29'; // Assuming default city ID is 'GJ29'
$targetWeek = isset($_POST['week']) ? $_POST['week'] : 8;

$sql = "SELECT * FROM `city` WHERE City_Id='$cityId'";
$dataset = [];
$data = [];
$cityArray = $conn->query($sql);

while ($city = $cityArray->fetch_assoc()) {
    $cityId = $city['City_Id'];
    //echo "City ID: " . $city['City_Id'] . "\n"; // Add this line
    $dataset[0] = getCarRentalDemand($conn, $cityId, 4);
    $dataset[1] = getCarRentalDemand($conn, $cityId, 3);
    $dataset[2] = getCarRentalDemand($conn, $cityId, 2);
    $dataset[3] = getCarRentalDemand($conn, $cityId, 1);
    $predictWeek = 5;
    $weeks = array_keys($dataset);
    $demandCounts = array_values($dataset);
    $regression = new LinearRegression();
    $regression->train($weeks, $demandCounts);
    $predictedDemand = $regression->predict($predictWeek);
    $dataset[4] = round($predictedDemand);
    $predictWeek = 6;
    $predictedDemand = $regression->predict($predictWeek);
    $dataset[5] = round($predictedDemand);
    $predictWeek = 7;
    $predictedDemand = $regression->predict($predictWeek);
    $dataset[6] = round($predictedDemand);
    $predictWeek = 8;
    $predictedDemand = $regression->predict($predictWeek);
    $dataset[7] = round($predictedDemand);
    foreach ($dataset as &$value) {
        if ($value < 0) {
            $value = 0;
        }
    }
}

// Output JSON for JavaScript consumption
header('Content-Type: application/json');
echo json_encode(['labels' => ["Past Week 4", "Past Week 3", "Past Week 2", "Past Week 1", "Future Week 1", "Future Week 2", "Future Week 3", "Future Week 4"], 'demand' => $dataset]);

?>
