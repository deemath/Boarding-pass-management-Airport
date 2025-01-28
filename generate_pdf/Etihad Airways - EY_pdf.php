<?php 
require('../fpdf186/fpdf.php');

// Database connection settings
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "BoardingPassDB";

// Create a database connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create new PDF document
$pdf = new FPDF('P', 'mm', 'A4');
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 20);

// Title
$pdf->Cell(71, 10, '', 0, 0);
$pdf->Cell(59, 5, 'EY Flits Details', 0, 0);
$pdf->Cell(59, 10, '', 0, 1);

// Set font for table headers
$pdf->SetFont('Arial', 'B', 12);

// Table header
// $pdf->Cell(10, 10, 'ID', 1);
$pdf->Cell(60, 10, 'Passenger Name', 1);
$pdf->Cell(25, 10, 'From', 1); 
$pdf->Cell(25, 10, 'To', 1);   
$pdf->Cell(30, 10, 'Flight Number', 1);
$pdf->Cell(30, 10, 'Date of Flight', 1);
$pdf->Cell(30, 10, 'Seat Number', 1);
$pdf->Ln();

// Set font for table body
$pdf->SetFont('Arial', '', 12);

// Data retrieval query
// $sql = "SELECT * FROM PassengerDetails";
$sql = "SELECT * FROM passengerdetails WHERE flight_number LIKE '%EY%'"; 

$result = $conn->query($sql);

// Table body
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // $pdf->Cell(10, 10, $row["id"], 1);
        $pdf->Cell(60, 10, $row["passenger_name"], 1);
        $pdf->Cell(25, 10, $row["from_city_code"], 1); 
        $pdf->Cell(25, 10, $row["to_city_code"], 1);   
        $pdf->Cell(30, 10, $row["flight_number"], 1);
        $pdf->Cell(30, 10, $row["date_of_flight"], 1);
        $pdf->Cell(30, 10, $row["seat_number"], 1);
        $pdf->Ln();
    }
} else {
    $pdf->Cell(0, 10, 'No records found', 1, 1, 'C');
}

// Close the database connection
$conn->close();

// Output PDF document
$pdf->Output('EY_Flits_Details.pdf', 'D');
?>
