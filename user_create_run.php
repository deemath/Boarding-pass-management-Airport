<?php 
include "./db_conn.php";

// Start a session if not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitize inputs (even though basic validation is done on the frontend, this is for security)
    $name = trim($_POST['name']);
    $displayName = trim($_POST['displayName']);
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $tele = filter_var(trim($_POST['tele']), FILTER_SANITIZE_NUMBER_INT);
    $password = trim($_POST['password']);
    $user_type = trim($_POST['user_type']);

    // Validate the email format
    // if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    //     echo "<script>alert('Invalid email format.'); window.location.href = './user_create.php';</script>";
    //     exit();
    // }

    // Check if the email and name already exist in the database
    $email_name_check_stmt = $conn->prepare("SELECT email, name FROM user WHERE email = ? AND name = ?");
    if ($email_name_check_stmt === false) {
        echo "<script>alert('Prepare failed: " . $conn->error . "'); window.location.href = './user_create.php';</script>";
        exit();
    }

    $email_name_check_stmt->bind_param("ss", $email, $name);
    $email_name_check_stmt->execute();
    $email_name_check_stmt->store_result();

    if ($email_name_check_stmt->num_rows > 0) {
        // Email and name already exist, show error message
        echo "<script>alert('Email and Name combination already exists. Please use a different email or name.'); window.location.href = './user_create.php';</script>";
        $email_name_check_stmt->close();
        exit();
    }

    $email_name_check_stmt->close();

    // Comment out password hashing if it's not needed
    // $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $hashed_password = $password;

    // Prepare and bind statement to insert data
    $stmt = $conn->prepare("INSERT INTO user (name, displayName, email, tele, password, user_type) VALUES (?, ?, ?, ?, ?, ?)");
    if ($stmt === false) {
        echo "<script>alert('Prepare failed: " . $conn->error . "'); window.location.href = './user_create.php';</script>";
        exit();
    }

    $stmt->bind_param("ssssss", $name, $displayName, $email, $tele, $hashed_password, $user_type);

    // Execute the statement and check if successful
    if ($stmt->execute()) {
        // Retrieve the inserted user_id
        $user_id = $stmt->insert_id;

        // Store session variables if needed
        // $_SESSION['user_id'] = $user_id;
        // $_SESSION['displayName'] = $displayName;
        // $_SESSION['user_type'] = $user_type;

        // Redirect on success with a success message
        echo "<script>alert('Registration completed successfully.'); window.location.href = './user_create.php';</script>";
    } else {
        // Display error if something went wrong during the query execution
        echo "<script>alert('Error: " . $stmt->error . "'); window.location.href = './user_create.php';</script>";
    }

    $stmt->close();
    $conn->close();
} else {
    // If the form was not submitted, redirect to the form page
    header("Location: ./user_create.php");
    exit();
}
?>
