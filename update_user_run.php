<?php
include "./db_conn.php";

// Start a session if not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitize inputs
    $name = trim($_POST['name']);
    $displayName = trim($_POST['displayName']);
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $tele = filter_var(trim($_POST['tele']), FILTER_SANITIZE_NUMBER_INT);
    $password = trim($_POST['password']);
    $user_type = trim($_POST['user_type']);
    $user_id = trim($_POST['user_id']);

    // SQL query using a prepared statement
    $sql = "UPDATE user SET name = ?, displayName = ?, email = ?, tele = ?, password = ?, user_type = ? WHERE user_id = ?";
    
    if ($stmt = $conn->prepare($sql)) {
        // Bind parameters to the SQL query
        $stmt->bind_param("ssssssi", $name, $displayName, $email, $tele, $password, $user_type, $user_id);

        // Execute the query
        if ($stmt->execute()) {
            echo "<script>alert('Update completed successfully.'); window.location.href = './user_create.php';</script>";
        } else {
            echo "<script>alert('Error: " . $stmt->error . "'); window.location.href = './user_create.php';</script>";
        }

        // Close the prepared statement
        $stmt->close();
    } else {
        echo "<script>alert('Error preparing statement.'); window.location.href = './user_create.php';</script>";
    }

    // Close the database connection
    $conn->close();
}
