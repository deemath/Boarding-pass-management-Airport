<?php
// Include FPDF library and database connection
include 'db_conn.php';

session_start();
if (!isset($_SESSION['Dname'])) {
    die("Access denied. Please log in.");
}

class PDF extends FPDF
{
    function Header()
    {
        $this->SetFont('Arial', '', 9);
        $this->Cell(0, 10, 'User: ' . htmlspecialchars($_SESSION['Dname'], ENT_QUOTES, 'UTF-8'), 0, 1, 'R');
        $this->SetFont('Arial', 'B', 14);
        $this->Cell(0, 10, 'Airport & Aviation Services (Sri Lanka) (Private) Limited', 0, 1, 'C');
        $this->SetFont('Arial', '', 12);
        $this->Cell(0, 8, 'Araliya Lounge', 0, 1, 'C');
        $this->SetFont('Arial', 'B', 14);
        $this->Cell(0, 10, 'Daily Airline Summary', 0, 1, 'C');
        $this->Ln(5);
    }

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
}

// Initialize PDF
$pdf = new PDF('L', 'mm', 'A4');
$pdf->AddPage();
$pdf->SetFont('Arial', '', 12);

// ------ Date and Shift -----------------------------------------------------------------------------------------------------
$pdf->SetFont('Arial', '', 12);
$currentDate = date('Y-m-d');
$pdf->Cell(140, 10, 'Date: ' . $currentDate, 0, 0, 'L');

// Determine Shift (Example logic: Morning 6 AM - 6 PM, Night 6 PM - 6 AM)
$currentHour = date('H');
$shift = ($currentHour >= 6 && $currentHour < 18) ? 'Day' : 'Night';
$pdf->Cell(30, 10, 'Shift: ' . $shift, 0, 1, 'R');
$pdf->Ln(1); // Add some space after the date and shift

// Query Data for Today's Summary
$today = date('Y-m-d');
$sql = "
    SELECT 
        ad.AirlineName,
        pd.flight_number,
        pd.seat_number,
        SUM(pd.no_of_iv) AS total_no_iv,
        SUM(pd.no_of_pax) AS total_no_of_pax
    FROM 
        passengerdetails pd
    JOIN 
        airlines_details ad ON LEFT(pd.flight_number, 2) = ad.IATA
    WHERE 
        pd.date_of_flight = ?
    GROUP BY 
        ad.AirlineName, pd.flight_number
    ORDER BY 
        ad.AirlineName, pd.flight_number;
";
$stmt = $conn->prepare($sql);
$stmt->bind_param('s', $today);
$stmt->execute();
$result = $stmt->get_result();

// Render Table in PDF
if ($result->num_rows > 0) {
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(10, 10, "No", 1, 0, 'C');
    $pdf->Cell(50, 10, "Airline", 1, 0, 'C');
    $pdf->Cell(40, 10, "Flight No", 1, 0, 'C');
    $pdf->Cell(40, 10, "Seat No", 1, 0, 'C');
    $pdf->Cell(40, 10, "No. of IV", 1, 0, 'C');
    $pdf->Cell(40, 10, "No. of Pax", 1, 1, 'C');

    $pdf->SetFont('Arial', '', 11);
    $serialNo = 1;
    $sum_no_of_iv = 0;
    $sum_no_of_pax = 0;
    $previousAirline = ''; // Keep track of the last airline name

    while ($row = $result->fetch_assoc()) {
        $pdf->Cell(10, 10, $serialNo++, 1, 0, 'C');

        // Display Airline Name using MultiCell (centered horizontally and vertically)
        if ($row['AirlineName'] !== $previousAirline) {
            $airlineHeight = 10; // Adjust height as needed
            $x = $pdf->GetX(); // Store X position
            $y = $pdf->GetY(); // Store Y position
            $pdf->MultiCell(50, $airlineHeight, $row['AirlineName'], 1, 'C');
            $pdf->SetXY($x + 50, $y); // Reset X and Y for the next cell
            $previousAirline = $row['AirlineName'];
        } else {
            $pdf->Cell(50, 10, '', 0, 0, 'C'); // Empty cell without border
        }

        $pdf->Cell(40, 10, strtoupper($row['flight_number']), 1, 0, 'C');
        $pdf->Cell(40, 10, strtoupper($row['seat_number']), 1, 0, 'C');
        $pdf->Cell(40, 10, $row['total_no_iv'], 1, 0, 'C');
        $pdf->Cell(40, 10, $row['total_no_of_pax'], 1, 1, 'C');

        $sum_no_of_iv += $row["total_no_iv"];
        $sum_no_of_pax += $row["total_no_of_pax"];
    }
    $pdf->SetFont('Arial', 'B', 12);

    // Total label cell
    $pdf->Cell(140, 10, 'Total', 1, 0, 'L');

    // Other columns
    $pdf->Cell(40, 10, $sum_no_of_iv, 1, 0, 'C');
    $pdf->Cell(40, 10, $sum_no_of_pax, 1, 0, 'C');
} else {
    $pdf->Cell(0, 10, "No data available for today.", 0, 1, 'C');
}

// Output PDF
$currentDate = date('Y-m-d');
$filename = 'Daily_Airline_Summary' . $currentDate . '.pdf';
$pdf->Output('D', $filename);
