<?php 
include "./db_conn.php";

// Start a session if not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
date_default_timezone_set("Asia/Colombo");

$entered_by = $_SESSION['Dname'];

$date = date('m/d/Y H:i:s', time());
// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitize inputs (even though basic validation is done on the frontend, this is for security)
    $IATA = trim($_POST['IATA']);
    $airlines_email = trim($_POST['airline_email']);
   
    // echo $IATA;
    // echo $airlines_email;


    // Validate the email format
    // if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    //     echo "<script>alert('Invalid email format.'); window.location.href = './airline_email.php';</script>";
    //     exit();
    // }

    // Check if the email and name already exist in the database
    $email_name_check_stmt = $conn->prepare("SELECT airline_email FROM airlines_email WHERE airline_email = ? ");
    if ($email_name_check_stmt === false) {
        echo "<script>alert('Prepare failed: " . $conn->error . "'); window.location.href = './airline_email.php';</script>";
        exit();
    }

    $email_name_check_stmt->bind_param("s", $airlines_email);
    $email_name_check_stmt->execute();
    $email_name_check_stmt->store_result();

    if ($email_name_check_stmt->num_rows > 0) {
        // Email and name already exist, show error message
        echo "<script>alert('Email  already exists.'); window.location.href = './airline_email.php';</script>";
        $email_name_check_stmt->close();
        exit();
    }

    $email_name_check_stmt->close();


    // Prepare and bind statement to insert data
    $stmt = $conn->prepare("INSERT INTO airlines_email (IATA, airline_email, entered_by, cap_time) VALUES (?, ?, ?, ?)");
    if ($stmt === false) {
        echo "<script>alert('Prepare failed: " . $conn->error . "'); window.location.href = './airline_email.php';</script>";
        exit();
    }

    $stmt->bind_param("ssss", $IATA, $airlines_email, $entered_by, $date);

    // Execute the statement and check if successful
    if ($stmt->execute()) {
        // Retrieve the inserted user_id
        $user_id = $stmt->insert_id;

        // Store session variables if needed
        // $_SESSION['user_id'] = $user_id;
        // $_SESSION['displayName'] = $displayName;
        // $_SESSION['user_type'] = $user_type;

        // Redirect on success with a success message
       echo "<script>alert('Email Add successfully.'); window.location.href = './airline_email.php';</script>";
    } else {
        // Display error if something went wrong during the query execution
        echo "<script>alert('Error: " . $stmt->error . "'); window.location.href = './airline_email.php';</script>";
    }

    $stmt->close();
    $conn->close();
} else {
    // If the form was not submitted, redirect to the form page
    header("Location: ./airline_email.php");
    exit();
}
?>
