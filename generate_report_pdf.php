<?php
// Include necessary libraries and files
//require('./fpdf186/fpdf.php'); // Adjust the path as needed
include 'db_conn.php';

// Start session and validate user
session_start();
if (!isset($_SESSION['Dname'])) {
    // die("Access denied. Please log in.");
}

// Extend FPDF to create custom Footer
class PDF extends FPDF
{
    // Footer method
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
    // Header function
    function Header()
    {
        // Set font for header
        $this->SetFont('Arial', '', 9);
        // User name aligned to the right corner
        $this->Cell(0, 10, 'User: ' . htmlspecialchars($_SESSION['Dname'], ENT_QUOTES, 'UTF-8'), 0, 1, 'R');

        // Center-aligned content
        $this->SetFont('Arial', 'B', 14);
        $this->Cell(0, 10, 'Airport & Aviation Services (Sri Lanka) (Private) Limited', 0, 1, 'C');
        $this->SetFont('Arial', '', 12);
        $this->Cell(0, 8, 'Araliya Lounge', 0, 1, 'C');
        $this->SetFont('Arial', 'B', 14);
        $this->Cell(0, 10, 'DAILY SUMMARY REPORT', 0, 1, 'C');
        $this->Ln(5); // Add some space after the header
    }
}

// Create a database connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    // Log the error instead of displaying it
    error_log("Connection failed: " . $conn->connect_error);
    die("Sorry, we're experiencing technical difficulties. Please try again later.");
}

// Create new PDF document
$pdf = new PDF('L', 'mm', 'A4');
$pdf->AliasNbPages(); // To use {nb} for total pages
$pdf->AddPage();


// ------ Date and Shift -----------------------------------------------------------------------------------------------------
$pdf->SetFont('Arial', '', 12);
$currentDate = date('Y-m-d');
$pdf->Cell(240, 10, 'Date: ' . $currentDate, 0, 0, 'L');

// Determine Shift (Example logic: Morning 6 AM - 6 PM, Night 6 PM - 6 AM)
$currentHour = date('H');
$shift = ($currentHour >= 6 && $currentHour < 18) ? 'Day' : 'Night';
$pdf->Cell(30, 10, 'Shift: ' . $shift, 0, 1, 'R');
$pdf->Ln(5); // Add some space after the date and shift

// Set font for table headers
$pdf->SetFont('Arial', 'B', 12);

// Table header
$header = array('Sr No', 'Passenger Name', 'Flight No', 'Date of Flight', 'Seat No', 'From', 'T0', 'Type', '#IV', '#PAX');
$w = array(15, 85, 25, 30, 20, 15, 15, 40, 15, 15); // Column widths

for ($i = 0; $i < count($header); $i++) {
    $pdf->Cell($w[$i], 10, $header[$i], 1, 0, 'C');
}
$pdf->Ln();

// Set font for table body
$pdf->SetFont('Arial', '', 12);

// Data retrieval query
// $sql = "SELECT passenger_name, flight_number, date_of_flight, no_of_iv, no_of_pax 
$sql = "SELECT * 
        FROM passengerdetails 
        WHERE date_of_flight = CURDATE() ORDER BY date_of_flight DESC, flight_number ASC";

$result = $conn->query($sql);

// Initialize ID counter and sum variables
$id = 1;
$sum_no_of_iv = 0;
$sum_no_of_pax = 0;


// Get count of records where card_number is 'Airlines'
$sqlcard = "SELECT COUNT(*) AS card_count FROM passengerdetails WHERE card_number = 'Airlines' AND date_of_flight = CURDATE()";
$result1 = mysqli_query($conn, $sqlcard);
$countcard = mysqli_fetch_assoc($result1);
// Access the count value from the associative array
$cardCount = $countcard['card_count'];

// Get count of records where card_number is 'Airlines'
$sqlcount_n = "SELECT COUNT(*) AS card_count FROM passengerdetails WHERE card_number != 'Airlines' AND date_of_flight = CURDATE()";
$result2 = mysqli_query($conn, $sqlcount_n);
$countcardn = mysqli_fetch_assoc($result2);
// Access the count value from the associative array
$cardCountn = $countcardn['card_count'];

// Table body
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // Check for page break
        if ($pdf->GetY() > 260) { // Adjust based on page size and margins
            $pdf->AddPage();
            // Reprint table headers on new page
            $pdf->SetFont('Arial', 'B', 12);
            for ($i = 0; $i < count($header); $i++) {
                $pdf->Cell($w[$i], 10, $header[$i], 1, 0, 'C');
            }
            $pdf->Ln();
            $pdf->SetFont('Arial', '', 12);
        }

        $pdf->Cell(15, 10, $id, 1, 0, 'C');
        $pdf->Cell(85, 10, htmlspecialchars($row["passenger_name"], ENT_QUOTES, 'UTF-8'), 1, 0, 'C');
        $pdf->Cell(25, 10, htmlspecialchars($row["flight_number"], ENT_QUOTES, 'UTF-8'), 1, 0, 'C');
        $pdf->Cell(30, 10, $row["date_of_flight"], 1, 0, 'C');
        $pdf->Cell(20, 10, $row["seat_number"], 1, 0, 'C');
        $pdf->Cell(15, 10, $row["from_city_code"], 1, 0, 'C');
        $pdf->Cell(15, 10, $row["to_city_code"], 1, 0, 'C');
        $pdf->Cell(40, 10, $row["card_number"], 1, 0, 'C');
        $pdf->Cell(15, 10, $row["no_of_iv"], 1, 0, 'C');
        $pdf->Cell(15, 10, $row["no_of_pax"], 1, 0, 'C');
        $pdf->Ln();
        $id++; // Increment ID counter

        // Sum the NO of IV and NO of PAX
        $sum_no_of_iv += (int)$row["no_of_iv"];
        $sum_no_of_pax += (int)$row["no_of_pax"];
    }

    // Add totals row
    // Check if there's enough space for the totals row
    if ($pdf->GetY() > 260) {
        $pdf->AddPage();
        // Reprint table headers on new page
        $pdf->SetFont('Arial', 'B', 12);
        for ($i = 0; $i < count($header); $i++) {
            $pdf->Cell($w[$i], 10, $header[$i], 1, 0, 'C');
        }
        $pdf->Ln();
    }

    $pdf->SetFont('Arial', 'B', 12);

    $pdf->Cell(245, 10, 'Total', 1, 0, 'L');
    // // Placeholder for Airlines and Card counts
    // $x = $pdf->GetX(); // Get current X position
    // $y = $pdf->GetY(); // Get current Y position
    // $pdf->MultiCell(35, 5, "Airlines: $cardCount\nCard: $cardCountn", 1, 'L');

    // Move back to the X position after MultiCell
    // $pdf->SetXY($x + 35, $y);

    $pdf->Cell(15, 10, $sum_no_of_iv, 1, 0, 'C');
    $pdf->Cell(15, 10, $sum_no_of_pax, 1, 0, 'C');
    $pdf->Ln();

    $pdf->Ln(10);
    $pdf->Cell(50, 10, 'Total Airlines Count', 1, 0, 'L');
    $pdf->Cell(20, 10, $cardCount, 1, 0, 'C');
    $pdf->Ln();
    $pdf->Cell(50, 10, 'Total Card Count', 1, 0, 'L');
    $pdf->Cell(20, 10, $cardCountn, 1, 0, 'C');

} else {
    $pdf->SetFont('Arial', 'I', 12);
    $pdf->Cell(array_sum($w), 10, 'No records found for today.', 1, 1, 'C');
}

// Close the database connection
$conn->close();

// Output PDF document
// Generate current date in YYYY-MM-DD format
$currentDate = date('Y-m-d');

// Set the output filename to include the date
$filename = 'DAILY_REPORT_' . $currentDate . '.pdf';

// Output the PDF document
$pdf->Output('D', $filename); // 'D' forces download
