<?php
include 'db_conn.php';

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $passenger_name = $conn->real_escape_string($_POST['passenger_name']);
    $from_city_code = $conn->real_escape_string($_POST['from_city_code']);
    $to_city_code = $conn->real_escape_string($_POST['to_city_code']);
    $flight_number = $conn->real_escape_string($_POST['flight_number']);
    $seat_number = $conn->real_escape_string($_POST['seat_number']);
    $no_of_iv = $conn->real_escape_string($_POST['no_of_iv']);
    $no_of_pax = $conn->real_escape_string($_POST['no_of_pax']);
    $date_of_flight = $_POST['date_of_flight'];

    // SQL query to update passenger details
    $sql = "UPDATE passengerdetails 
SET passenger_name='$passenger_name', 
    from_city_code='$from_city_code', 
    to_city_code='$to_city_code', 
    flight_number='$flight_number', 
    no_of_iv='$no_of_iv', 
    no_of_pax='$no_of_pax', 
    seat_number='$seat_number', 
    date_of_flight='$date_of_flight' 
WHERE id='$id'";


    if ($conn->query($sql) === TRUE) {
        echo '<script>alert("Record updated successfully!");</script>';
        // Redirect to the same page after successful update
        header("Location: airline_report.php");
        exit();
    } else {
        echo "Error updating record: " . $conn->error;
    }
}
