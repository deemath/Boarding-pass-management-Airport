<?php
include "./db_conn.php";

// Start a session if not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Check if the form was submitted with a valid user_id
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['user_id'])) {
    // Sanitize the user_id to prevent SQL injection
    $user_id = intval($_POST['user_id']);

    // Prepare the SQL statement for deletion
    $sql = "DELETE FROM user WHERE user_id = ?";

    if ($stmt = $conn->prepare($sql)) {
        // Bind the user_id parameter
        $stmt->bind_param("i", $user_id);

        // Execute the query
        if ($stmt->execute()) {
            echo "<script>alert('User deleted successfully.'); window.location.href = './user_create.php';</script>";
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
} else {
    echo "<script>alert('Invalid request.'); window.location.href = './user_create.php';</script>";
}
?>
