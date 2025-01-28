<?php
session_start(); // Start the session
require_once('./db_conn.php'); // Database connection

if (isset($_POST['submit'])) {
    $username = $_POST['name'];
    $password = $_POST['password'];

    // Prepare the SQL statement to prevent SQL injection
    $stmt = $conn->prepare("SELECT * FROM user WHERE name = ? ");
    $stmt->bind_param("s", $username); // Bind parameters
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $admin = $result->fetch_assoc();

        // Verify the password (assuming it's hashed)
        // (password_verify($password, $admin['password'])) {
        if ($password === $admin['password']) {
            // Password is correct, set session variables
            $_SESSION['FULLNAME'] = $admin['name'];
            $_SESSION['Dname'] = $admin['displayName'];
            $_SESSION['USER_TYPE'] = $admin['user_type'];

            // Redirect based on user type
            if ($_SESSION['USER_TYPE'] === "Admin") {
                header("Location: ./admin_dashboard.php");
                // echo "<script>
                //         alert('Login successful! Redirecting to admin home.');
                //         window.location.href='./admin_dashboard.php';
                //       </script>";
                exit();
            } elseif ($_SESSION['USER_TYPE'] === "User") {
                header("Location: ./user_dashboard.php");
                // echo "<script>
                //         alert('Login successful! Redirecting to home.');
                //         window.location.href='./user_dashboard.php';
                //       </script>";
                exit();
            }
        } else {
            // Invalid password
            echo "<script>alert('Invalid password. Please try again.'); window.location.href='./index.php';</script>";
            exit();
        }
    } else {
        // User not found
        echo "<script>alert('User not found. Please check your username.'); window.location.href='./index.php';</script>";
        exit();
    }
} else {
    // Redirect to login if accessed without submitting the form
    header("Location: ./index.php");
    exit();
}
