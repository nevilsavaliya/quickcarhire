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
include 'phpqrcode/qrlib.php';

$Bid = base64_decode(strval($_GET['Bid']));

// Load the HTML template for the invoice
$html = file_get_contents('invoice_bill_template.html');

$query = "SELECT * FROM booking WHERE Booking_Id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $Bid);
$stmt->execute();
$result = $stmt->get_result()->fetch_assoc();
$stmt->close();

$bookingId = $result['Booking_Id'];
$Booking_start_date = $result['Start_Date'];
$Booking_end_date = $result['End_Date'];
$Start_time = $result['Start_Time'];
$End_time = $result['End_Time'];
$Security_deposit = $result['Security_Deposit'];
$Selected_Kms = $result['Selected_Kms'];
$Booking_Amount = $result['Booking_Amount'];
$Offer = $result['Offer'];
$Total_amount = $result['Total_Amount'];

$R_no = $result['Registration_No'];
$Email_id = $result['Email'];

$query1 = "SELECT * FROM car WHERE Registration_No = ?";
$stmt1 = $conn->prepare($query1);
$stmt1->bind_param("s", $R_no);
$stmt1->execute();
$result1 = $stmt1->get_result()->fetch_assoc();
$stmt1->close();

$img = $result1['Image'];
$name = $result1['Name'];
$Brand = $result1['Brand'];
$charge = $result1['Charge_Cost'];

$city = $result1['City_Id'];
$query2 = "SELECT * FROM customer WHERE Email = ?";
$stmt2 = $conn->prepare($query2);
$stmt2->bind_param("s", $Email_id);
$stmt2->execute();
$result2 = $stmt2->get_result()->fetch_assoc();
$stmt2->close();

$cname = $result2['Name'];
$cphone = $result2['Mobile'];
$dl = $result2['Driving_Licence'];
$an = $result2['AadharCard'];

$query3 = "SELECT * FROM city WHERE City_Id = ?";
$stmt3 = $conn->prepare($query3);
$stmt3->bind_param("s", $city);
$stmt3->execute();
$result3 = $stmt3->get_result()->fetch_assoc();
$stmt3->close();

$City = $result3['City'];
$ciMobile = $result3['Mobile'];
$ciEmail = $result3['Email'];
$ciAddress = $result3['Address'];

//// Generate QR code
//$data = 'Hello, world!';
$data = [
    'Booking_id' => $bookingId,
    'CarId' => $R_no,
    'CarName' => $name,
    'BrandName' => $Brand,
    'Seleceted_KMS' => $Selected_Kms,
    'Offer' => $Offer,
    'Total_amount'=>$Total_amount,
    'Booking_amount'=>$Booking_Amount,
    'EmailId' => $Email_id,
    'Name'=> $cname,
    'ContacctNo' => $cphone,
    'City' => $City,
    'CityEmail' => $ciEmail

];
$jsonData = json_encode($data);
$filename = 'qrcode.png';
QRcode::png($jsonData, $filename, 'L', 50, 50 );

// Convert HTML to PDF using TCPDF
require_once('./pdf/tcpdf.php');
$pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8');
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetHeaderData('Quick Car Hire', 0, '', '', array(0, 0, 0), array(255, 255, 255));
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
$pdf->SetAutoPageBreak(FALSE, PDF_MARGIN_BOTTOM);
$pdf->SetFont('dejavusans', '', 10, '', true);
$pdf->AddPage();

// Add QR code to PDF
// $imagePath =  $filename;
//$x = 50; // X-coordinate
//$y = 50; // Y-coordinate
//$width = 50; // Image width
//$height = 50; // Image height

// Replace placeholders in the HTML template with actual data
$html = str_replace('{{booking_id}}', $bookingId, $html);
$html = str_replace('{{start_date}}', $Booking_start_date, $html);
$html = str_replace('{{end_date}}', $Booking_end_date, $html);
$html = str_replace('{{start_time}}', $Start_time, $html);
$html = str_replace('{{end_time}}', $End_time, $html);
$html = str_replace('{{security_deposit}}', $Security_deposit, $html);
$html = str_replace('{{selected_kms}}', $Selected_Kms, $html);
$html = str_replace('{{offer}}', $Offer, $html);
$html = str_replace('{{total}}', $Total_amount, $html);
$html = str_replace('{{booking}}', $Booking_Amount, $html);

$html = str_replace('{{img}}', '<img src="' . $filename . '" alt="QR Code">', $html);

$html = str_replace('{{email}}', $Email_id, $html);
$html = str_replace('{{customer_name}}', $cname, $html);
$html = str_replace('{{customer_contact}}', $cphone, $html);
$html = str_replace('{{customer_an}}', $an, $html);
$html = str_replace('{{customer_dl}}', $dl, $html);
$html = str_replace('{{city}}', $City, $html);
$html = str_replace('{{city_mobile}}', $ciMobile, $html);
$html = str_replace('{{city_email}}', $ciEmail, $html);
$html = str_replace('{{city_address}}', $ciAddress, $html);
$html = str_replace('{{registration_no}}', $R_no, $html);
$html = str_replace('{{car_image}}',$img, $html);
$html = str_replace('{{car_name}}', $name, $html);
$html = str_replace('{{car_brand}}', $Brand, $html);
$html = str_replace('{{charge}}', $charge, $html);


//$pdf->Image($imagePath, $x, $y, $width, $height);

// Output the HTML content
$pdf->writeHTML($html, true, false, true, false, '');

// Output PDF content directly to the browser with proper headers
$pdf->Output('QuickcarHire.pdf', 'D');

exit();
?>