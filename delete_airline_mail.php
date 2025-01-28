<?php
include "./db_conn.php";

// Start a session if not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Check if the form was submitted with a valid ae_id
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['ae_id'])) {
    // Sanitize the ae_id to prevent SQL injection
    $ae_id = intval($_POST['ae_id']);

    // Prepare the SQL statement for deletion
    $sql = "DELETE FROM airlines_email WHERE ae_id = ?";

    if ($stmt = $conn->prepare($sql)) {
        // Bind the ae_id parameter
        $stmt->bind_param("s", $ae_id);

        // Execute the query
        if ($stmt->execute()) {
            echo "<script>alert('deleted successfully.'); window.location.href = './airline_email.php';</script>";
        } else {
            echo "<script>alert('Error: " . $stmt->error . "'); window.location.href = './airline_email.php';</script>";
        }

        // Close the prepared statement
        $stmt->close();
    } else {
        echo "<script>alert('Error preparing statement.'); window.location.href = './airline_email.php';</script>";
    }

    // Close the database connection
    $conn->close();
} else {
    echo "<script>alert('Invalid request.'); window.location.href = './airline_email.php';</script>";
}
?>
