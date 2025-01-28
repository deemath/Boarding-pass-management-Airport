<?php
require('db_conn.php');
session_start();

$airline = isset($_GET['airline']) ? $conn->real_escape_string($_GET['airline']) : '';
$airlineName = isset($_GET['airlineName']) ? $conn->real_escape_string($_GET['airlineName']) : '';
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

if ($airline) {
    $sql = "SELECT * FROM passengerdetails WHERE LEFT(flight_number, 2) = '$airline' AND date_of_flight BETWEEN '$dateFrom' AND '$dateTo' ORDER BY date_of_flight DESC";
    $result = $conn->query($sql);

    // Get count of records where card_number is 'Airlines'
    $sqlcard = "SELECT COUNT(*) AS card_count 
    FROM passengerdetails 
    WHERE card_number = 'Airlines' 
    AND date_of_flight BETWEEN '$dateFrom' AND '$dateTo' 
    AND LEFT(flight_number, 2) = '$airline'";
    $result1 = mysqli_query($conn, $sqlcard);
    $countcard = mysqli_fetch_assoc($result1);
    // Access the count value from the associative array
    $cardCount = $countcard['card_count'];

    // Get count of records where card_number is 'Airlines'
    $sqlcount_n = "SELECT COUNT(*) AS card_count FROM passengerdetails WHERE card_number != 'Airlines' 
    AND date_of_flight BETWEEN '$dateFrom' AND '$dateTo' AND LEFT(flight_number, 2) = '$airline'";
    $result2 = mysqli_query($conn, $sqlcount_n);
    $countcardn = mysqli_fetch_assoc($result2);
    // Access the count value from the associative array
    $cardCountn = $countcardn['card_count'];

    // Get count of records where pax
    $sql_paxcount = "SELECT SUM(no_of_pax) AS no_of_pax_c FROM passengerdetails WHERE  date_of_flight BETWEEN '$dateFrom' AND '$dateTo' AND LEFT(flight_number, 2) = '$airline'";
    $result_pax_c = mysqli_query($conn, $sql_paxcount);
    $count_pax = mysqli_fetch_assoc($result_pax_c);
    // Access the count value from the associative array
    $paxCountn = $count_pax['no_of_pax_c'];

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
            $this->Ln(5);
        }
    }

    // Initialize PDF
    $pdf = new PDF('L', 'mm', 'A4');
    $pdf->AliasNbPages();
    $pdf->AddPage();
    $pdf->SetFont('Arial', 'B', 12);

    // PDF Header
    $pdf->Cell(0, 10, 'Passenger Details for Airline: ' . htmlspecialchars($airlineName), 0, 1, 'C');
    $pdf->Ln(10);
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(230, 10, $filter_date2, 0, 0, 'L');
    $pdf->Cell(30, 10, 'Shift: Day / Night', 0, 1, 'R');
    $pdf->Ln(5);

    // Table headers
    $pdf->SetFont('Arial', 'B', 12);
    // $pdf->Cell(15, 10, 'ID', 1, 0, 'C');
    $pdf->Cell(90, 10, 'Passenger Name', 1, 0, 'C');
    $pdf->Cell(25, 10, 'Flight No', 1, 0, 'C');
    $pdf->Cell(30, 10, 'Date of Flight', 1, 0, 'C');
    $pdf->Cell(20, 10, 'Seat No', 1, 0, 'C');
    $pdf->Cell(15, 10, 'From', 1, 0, 'C');
    $pdf->Cell(15, 10, 'To', 1, 0, 'C');
    $pdf->Cell(40, 10, 'Type', 1, 0, 'C');
    // $pdf->Cell(35, 10, 'Type', 1, 0, 'C');
    $pdf->Cell(20, 10, '#IV', 1, 0, 'C');
    $pdf->Cell(20, 10, '#PAX', 1, 0, 'C');
    $pdf->Ln();

    // Check if there are passengers
    $totalPassengers = $result->num_rows;
    if ($totalPassengers > 0) {
        while ($row = $result->fetch_assoc()) {
            $pdf->SetFont('Arial', '', 12);

            // $pdf->Cell(15, 10, $row['id'], 1, 0, 'C');
            $pdf->Cell(90, 10, $row['passenger_name'], 1, 0, 'C');
            $pdf->Cell(25, 10, $row['flight_number'], 1, 0, 'C');
            $pdf->Cell(30, 10, $row['date_of_flight'], 1, 0, 'C');
            $pdf->Cell(20, 10, $row['seat_number'], 1, 0, 'C');
            $pdf->Cell(15, 10, $row['from_city_code'], 1, 0, 'C');
            $pdf->Cell(15, 10, $row['to_city_code'], 1, 0, 'C');
            $pdf->Cell(40, 10, $row['card_number'], 1, 0, 'C');
            // $pdf->Cell(35, 10, $row['card_number'], 1, 0, 'C');
            $pdf->Cell(20, 10, $row['no_of_iv'], 1, 0, 'C');
            $pdf->Cell(20, 10, $row['no_of_pax'], 1, 0, 'C');
            $pdf->Ln();
        }
    } else {
        // Display "No records found" message in an empty row
        $pdf->Cell(0, 10, 'No records found.', 1, 1, 'C');
    }
    $pdf->Ln(10);
    $pdf->SetFont('Arial', 'B', 12);

    $pdf->Cell(50, 10, 'Total Passengers', 1, 0, 'L');
    $pdf->Cell(20, 10, $paxCountn, 1, 0, 'C');
    $pdf->Ln();
    $pdf->Cell(50, 10, 'Total Airlines Count', 1, 0, 'L');
    $pdf->Cell(20, 10, $cardCount, 1, 0, 'C');
    $pdf->Ln();
    $pdf->Cell(50, 10, 'Total Card Count', 1, 0, 'L');
    $pdf->Cell(20, 10, $cardCountn, 1, 0, 'C');
    $currentDate = date('Y-m-d');
    $pdf->Output('D', 'All_Passengers_' . $airlineName . '_' . $filter_date . '.pdf');
} else {
    echo 'Airline code not provided.';
}
