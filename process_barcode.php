<?php
include 'db_conn.php';

// Enable MySQLi exception reporting
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

date_default_timezone_set("Asia/Colombo");

session_start();
$entered_by = $_SESSION['Dname'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $barcodeData = $_POST['barcode']; // Get the barcode from the form
    $vcard_d = $_POST['vcard_d'];

    // Check if the value is set and whether it's "Airlines"
    if ($vcard_d == "") {
        $vcard_nam = "Airlines";
    } else {
        $vcard_nam = htmlspecialchars($vcard_d);
    }

    // Parse the barcode data based on the IATA BCBP standard
    $passengerName = trim(substr($barcodeData, 2, 19));
    $fromCityCode = substr($barcodeData, 30, 3);
    $toCityCode = substr($barcodeData, 33, 3);
    $flightNumber = trim(substr($barcodeData, 36, 7));

    // Extract the first two letters of the flight number
    $airlineCode = substr($flightNumber, 0, 2);

    try {
        // Query the airlines_details table to check if the airline code exists
        $checkStmt = $conn->prepare("SELECT COUNT(*) FROM airlines_details WHERE IATA = ?");
        $checkStmt->bind_param("s", $airlineCode);
        $checkStmt->execute();
        $checkStmt->bind_result($count);
        $checkStmt->fetch();
        $checkStmt->close();

        // Validate the airline code
        if ($count === 0) {
            throw new Exception('Not valid barcode: Invalid flight number.');
        }

        $dateOfFlightJulian = (int) substr($barcodeData, 44, 5);
        $currentYear = date('Y');

        // Calculate the date from the Julian date
        $dateOfFlightFormatted = date('Y-m-d', strtotime("$currentYear-01-01 +" . ($dateOfFlightJulian - 1) . " days"));

        $seatNumber = trim(substr($barcodeData, 48, 4));
        $airlineNumericCode = substr($barcodeData, 56, 3);

        // Check if entry is present
        $checkEntryStmt = $conn->prepare("SELECT COUNT(*) FROM passengerdetails WHERE passenger_name = ? AND flight_number = ? AND date_of_flight = ? AND seat_number = ?");
        $checkEntryStmt->bind_param("ssss", $passengerName, $flightNumber, $dateOfFlightFormatted, $seatNumber);
        $checkEntryStmt->execute();
        $checkEntryStmt->bind_result($entryCount);
        $checkEntryStmt->fetch();
        $checkEntryStmt->close();

        // If the entry already exists
        if ($entryCount > 0) {
            throw new Exception('This boarding pass has already been scanned.');
        }

        // Get the current date and time
        $currentDate = date('Y-m-d');
        $currentTime = date('H:i:s');

        // Prepare the SQL statement
        $stmt = $conn->prepare("INSERT INTO passengerdetails (passenger_name, from_city_code, to_city_code, flight_number, seat_number, airline_numeric_code, date_of_flight, card_number, captured_date, captured_time, entered_by) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssssssss", $passengerName, $fromCityCode, $toCityCode, $flightNumber, $seatNumber, $airlineNumericCode, $dateOfFlightFormatted, $vcard_nam, $currentDate, $currentTime, $entered_by);

        // Execute the statement
        if ($stmt->execute()) {
            $lastId = $stmt->insert_id; // Get the last inserted ID

            if ($lastId > 0) {
                // Success message
                header("Location: barcode.php?status=success&message=Passenger added successfully!");
            } else {
                // Error message for ID <= 0
                header("Location: barcode.php?status=error&message=Error: Unable to process the request.");
            }
        } else {
            throw new Exception('Error: ' . $stmt->error);
        }

        $stmt->close();
    } catch (Exception $e) {
        // Redirect with error message
        header("Location: barcode.php?status=error&message=" . urlencode($e->getMessage()));
    }
}

$conn->close();
?>
