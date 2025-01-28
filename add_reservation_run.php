<?php
include 'db_conn.php';

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
date_default_timezone_set("Asia/Colombo");

session_start();
$entered_by = $_SESSION['Dname'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // $vcard_d = $_POST['vcard_d'];
    // $passenger_name = $_POST['passenger_name'];
    // $flight_number = $_POST['flight_number'];
    // $from_city_code = $_POST['from_city_code'];
    // $to_city_code = $_POST['to_city_code'];
    // $date_of_flight = $_POST['date_of_flight'];
    // $seat_number = $_POST['seat_number'];
    // $airline_numeric_code = $_POST['airline_numeric_code'];
    // $no_of_iv = $_POST['no_of_iv'];
    // $no_of_pax = $_POST['no_of_pax'];
    $vcard_d = preg_replace('/[^a-zA-Z0-9]/', '', trim($_POST['vcard_d']));
    $passenger_name = preg_replace('/[^a-zA-Z0-9 ]/', '', trim($_POST['passenger_name']));
    $flight_number = preg_replace('/[^a-zA-Z0-9 ]/', '', trim($_POST['flight_number']));
    $from_city_code = preg_replace('/[^a-zA-Z]/', '', trim($_POST['from_city_code']));
    $to_city_code = preg_replace('/[^a-zA-Z]/', '', trim($_POST['to_city_code']));
    $date_of_flight = preg_replace('/[^0-9\-]/', '', trim($_POST['date_of_flight']));
    $seat_number = preg_replace('/[^a-zA-Z0-9]/', '', trim($_POST['seat_number']));
    $airline_numeric_code = preg_replace('/[^0-9]/', '', trim($_POST['airline_numeric_code']));
    $no_of_iv = preg_replace('/[^0-9]/', '', trim($_POST['no_of_iv']));
    $no_of_pax = preg_replace('/[^0-9]/', '', trim($_POST['no_of_pax']));
    $remarks =trim($_POST['remarks']);


    // Check if the value is set and whether it's "Airlines"
    if ($vcard_d == "") {
        $vcard_nam = "Airlines";
    } else {
        $vcard_nam = htmlspecialchars($vcard_d);
    }

    // Parse the barcode data based on the IATA BCBP standard
    // $passengerName = trim(substr($barcodeData, 2, 19));
    // $fromCityCode = substr($barcodeData, 30, 3);
    // $toCityCode = substr($barcodeData, 33, 3);
    // $flightNumber = trim(substr($barcodeData, 36, 7));

    // Extract the first two letters of the flight number
    // $airlineCode = substr($flightNumber, 0, 2);

    // Query the airlines_details table to check if the airline code exists
    // $checkStmt = $conn->prepare("SELECT COUNT(*) FROM airlines_details WHERE IATA = ?");
    // if ($checkStmt === false) {
    //     die("Prepare failed: " . htmlspecialchars($conn->error));
    // }

    // $checkStmt->bind_param("s", $airlineCode);
    // $checkStmt->execute();
    // $checkStmt->bind_result($count);
    // $checkStmt->fetch();
    // $checkStmt->close();

    // // Validate the airline code
    // if ($count === 0) {
    //     echo '<script>alert("Not valid barcode: Invalid flight number."); window.location.href = "barcode.php";</script>';
    //     exit(); // Stop further execution
    // }

    // $dateOfFlightJulian = (int) substr($barcodeData, 44, 5);
    // $currentYear = date('Y');

    // // Calculate the date from the Julian date without any increments
    // $dateOfFlightFormatted = date('Y-m-d', strtotime("$currentYear-01-01 +" . ($dateOfFlightJulian - 1) . " days"));
    // $dateOfFlightReadable = date('F jS', strtotime($dateOfFlightFormatted));

    // $seatNumber = trim(substr($barcodeData, 48, 4));
    // $airlineNumericCode = substr($barcodeData, 56, 3);

    //check if entry is present
    $checkEntryStmt = $conn->prepare("SELECT COUNT(*) FROM passengerdetails WHERE passenger_name = ? AND flight_number = ? AND date_of_flight = ? AND seat_number = ?");
    $checkEntryStmt->bind_param("ssss", $passenger_name, $flight_number, $date_of_flight, $seat_number);
    $checkEntryStmt->execute();
    $checkEntryStmt->bind_result($entryCount);
    $checkEntryStmt->fetch();
    $checkEntryStmt->close();

    // If the entry already exists
    if ($entryCount > 0) {
        echo '<script>alert("Entry already exists."); window.location.href = "./add_reservation.php";</script>';
        exit(); // Stop further execution
    }

    // Get the current date and time
    $currentDate = date('Y-m-d');
    $currentTime = date('H:i:s'); // 12-hour format with AM/PM

    // Prepare the SQL statement
    $stmt = $conn->prepare("INSERT INTO passengerdetails (passenger_name, from_city_code, to_city_code, flight_number, seat_number, airline_numeric_code, date_of_flight, card_number, captured_date, captured_time, no_of_iv, no_of_pax, remarks, entered_by) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssssssssss", $passenger_name, $from_city_code, $to_city_code, $flight_number, $seat_number, $airline_numeric_code, $date_of_flight, $vcard_nam, $currentDate, $currentTime, $no_of_iv, $no_of_pax, $remarks, $entered_by);

    // Execute the statement
    if ($stmt->execute()) {
        echo '<script>alert("Passenger added successfully!"); window.location.href = "./add_reservation.php";</script>';
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}
$conn->close();
