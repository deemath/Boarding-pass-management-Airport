<?php
include "./db_conn.php";

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id']) && isset($_POST['link'])) {
    $id = intval($_POST['id']);
    $link = $_POST['link'];  // Retrieve link as a string

    $sql = "DELETE FROM passengerdetails WHERE id = ?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            echo "<script>alert('Deleted successfully.'); window.location.href = '$link';</script>";
        } else {
            echo "<script>alert('Error: " . $stmt->error . "'); window.location.href = '$link';</script>";
        }
        $stmt->close();
    } else {
        echo "<script>alert('Error preparing statement.'); window.location.href = '$link';</script>";
    }
    $conn->close();
} else {
    echo "<script>alert('Invalid request.'); window.location.href = '$link';</script>";
}
?>
