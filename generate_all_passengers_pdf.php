
<?php
// Database connection settings
include 'db_conn.php';
session_start();

// Create a database connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

class PDF extends FPDF
{
    function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 9);
        $date = date("m-d-Y");
        $this->Cell(0, 7, utf8_decode('Copyright © 2010 Airport & Aviation (Sri Lanka) Limited. All rights reserved.'), 0, 0, 'L');
        $this->Cell(0, 7, $date, 0, 1, 'R');
        $this->Cell(0, 7, 'Powered by IT Division', 0, 0, 'L');
        $this->Cell(0, 7, 'Page ' . $this->PageNo(), 0, 0, 'R');
    }

    function Header()
    {
        $this->SetFont('Arial', '', 9);
        $this->Cell(0, 10, 'User: ' . htmlspecialchars($_SESSION['Dname'], ENT_QUOTES, 'UTF-8'), 0, 1, 'R');
        $this->SetFont('Arial', 'B', 14);
        $this->Cell(0, 10, 'Airport & Aviation Services (Sri Lanka) (Private) Limited', 0, 1, 'C');
        $this->SetFont('Arial', '', 12);
        $this->Cell(0, 8, 'Araliya Lounge', 0, 1, 'C');
        $this->SetFont('Arial', 'B', 14);
        $this->Cell(0, 10, 'FULL REPORT', 0, 1, 'C');
        $this->Ln(5);
    }
}
// Retrieve date parameters
$dateTo = isset($_GET['dateTo']) ? $conn->real_escape_string($_GET['dateTo']) : '';
$dateFrom = isset($_GET['dateFrom']) ? $conn->real_escape_string($_GET['dateFrom']) : '';

if ($dateFrom == $dateTo) {
    $filter_date = $dateFrom;
} else {
    $filter_date = $dateFrom . " | " . $dateTo;
}
if ($dateFrom == $dateTo) {
    $filter_date2 = "Date: " . $dateFrom;
} else {
    $filter_date2 = "Date From: " . $dateFrom . " | Date To: " . $dateTo;
}
// Create new PDF document
$pdf = new PDF('L', 'mm', 'A4');
$pdf->AliasNbPages();
$pdf->AddPage();

$pdf->SetFont('Arial', '', 12);
$pdf->Cell(240, 10,  $filter_date2, 0, 0, 'L');
$pdf->Cell(30, 10, 'Shift: Day / Night', 0, 1, 'R');
$pdf->Ln(5);

// Set font for table headers
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(15, 10, 'No', 1, 0, 'C');
$pdf->Cell(85, 10, 'Passenger Name', 1, 0, 'C');
$pdf->Cell(25, 10, 'Flight No', 1, 0, 'C');
$pdf->Cell(30, 10, 'Date of Flight', 1, 0, 'C');
$pdf->Cell(20, 10, 'Seat No', 1, 0, 'C');
$pdf->Cell(15, 10, 'From', 1, 0, 'C');
$pdf->Cell(15, 10, 'To', 1, 0, 'C');
$pdf->Cell(40, 10, 'Type', 1, 0, 'C');
// $pdf->Cell(35, 10, 'Card Name', 1, 0, 'C');
$pdf->Cell(15, 10, '#IV', 1, 0, 'C');
$pdf->Cell(15, 10, '#PAX', 1, 0, 'C');
$pdf->Ln();

$pdf->SetFont('Arial', '', 12);


// Data retrieval query
$sql = "SELECT * FROM passengerdetails";
if (!empty($dateFrom) && !empty($dateTo)) {
    $sql .= " WHERE date_of_flight BETWEEN '" . $dateFrom . "' AND '" . $dateTo . "'";
}
$sql .= " ORDER BY date_of_flight DESC, flight_number ASC";

$result = $conn->query($sql);

// Get count of records where card_number is 'Airlines'
$sqlcard = "SELECT COUNT(*) AS card_count FROM passengerdetails WHERE card_number = 'Airlines' AND date_of_flight BETWEEN '" . $dateFrom . "' AND '" . $dateTo . "'";
$result1 = mysqli_query($conn, $sqlcard);
$countcard = mysqli_fetch_assoc($result1);
// Access the count value from the associative array
$cardCount = $countcard['card_count'];

// Get count of records where card_number is 'Airlines'
$sqlcount_n = "SELECT COUNT(*) AS card_count FROM passengerdetails WHERE card_number != 'Airlines' AND date_of_flight BETWEEN '" . $dateFrom . "' AND '" . $dateTo . "'";
$result2 = mysqli_query($conn, $sqlcount_n);
$countcardn = mysqli_fetch_assoc($result2);
// Access the count value from the associative array
$cardCountn = $countcardn['card_count'];


// Get count of records where pax
$sql_paxcount = "SELECT SUM(no_of_pax) AS no_of_pax_c FROM passengerdetails WHERE  date_of_flight BETWEEN '$dateFrom' AND '$dateTo' ";
$result_pax_c = mysqli_query($conn, $sql_paxcount);
$count_pax = mysqli_fetch_assoc($result_pax_c);
// Access the count value from the associative array
$paxCountn = $count_pax['no_of_pax_c'];


// Initialize ID counter and sum variables
$id = 1;
$sum_no_of_iv = 0;
$sum_no_of_pax = 0;

// Table body
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $pdf->Cell(15, 10, $id, 1, 0, 'C');
        $pdf->Cell(85, 10, $row["passenger_name"], 1, 0, 'C');
        $pdf->Cell(25, 10, $row["flight_number"], 1, 0, 'C');
        $pdf->Cell(30, 10, $row["date_of_flight"], 1, 0, 'C');
        $pdf->Cell(20, 10, $row["seat_number"], 1, 0, 'C');
        $pdf->Cell(15, 10, $row["from_city_code"], 1, 0, 'C');
        $pdf->Cell(15, 10, $row["to_city_code"], 1, 0, 'C');
        $pdf->Cell(40, 10, $row["card_number"], 1, 0, 'C');
        // $pdf->Cell(35, 10, $row["card_number"], 1, 0, 'C');
        $pdf->Cell(15, 10, $row["no_of_iv"], 1, 0, 'C');
        $pdf->Cell(15, 10, $row["no_of_pax"], 1, 0, 'C');
        $pdf->Ln();
        $id++;

        $sum_no_of_iv += $row["no_of_iv"];
        $sum_no_of_pax += $row["no_of_pax"];
    }

    $pdf->SetFont('Arial', 'B', 12);

    // Total label cell
    $pdf->Cell(245, 10, 'Total', 1, 0, 'L');

    // // Placeholder for Airlines and Card counts
    // $x = $pdf->GetX(); // Get current X position
    // $y = $pdf->GetY(); // Get current Y position
    // $pdf->MultiCell(35, 5, "Airlines: $cardCount\nCard: $cardCountn", 1, 'L');

    // Move back to the X position after MultiCell
    // $pdf->SetXY($x + 35, $y);

    // Other columns
    $pdf->Cell(15, 10, $sum_no_of_iv, 1, 0, 'C');
    $pdf->Cell(15, 10, $sum_no_of_pax, 1, 0, 'C');

    // Move to the next line
    $pdf->Ln();

    // Add totals row
    // $pdf->SetFont('Arial', 'B', 12);
    // $pdf->Cell(235, 10, 'Total Airlines Count', 1, 0, 'L');
    // $pdf->Cell(35, 10, $cardCount, 1, 0, 'C');
    // $pdf->Ln();

    // $pdf->SetFont('Arial', 'B', 12);
    // $pdf->Cell(235, 10, 'Total Card Count', 1, 0, 'L');
    // $pdf->Cell(35, 10, $cardCountn, 1, 0, 'C');
    $pdf->Ln(10);
    $pdf->Cell(50, 10, 'Total Airlines Count', 1, 0, 'L');
    $pdf->Cell(20, 10, $cardCount, 1, 0, 'C');
    $pdf->Ln();
    $pdf->Cell(50, 10, 'Total Card Count', 1, 0, 'L');
    $pdf->Cell(20, 10, $cardCountn, 1, 0, 'C');

    // Move to the next line
    // $pdf->Ln();

} else {
    $pdf->Cell(0, 10, 'No records found', 1, 1, 'C');
}

// Close the database connection
$conn->close();

// Set the output filename to include the date
$currentDate = date('Y-m-d');
$filename = 'FULL_REPORT_' . $filter_date . '.pdf';

// Output the PDF document
$pdf->Output('D', $filename);
?>
