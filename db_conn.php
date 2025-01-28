<?php 
require('fpdf186/fpdf.php');

// Database connection settings
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "boardingpassdb";
//  $servername = "192.168.1.60";
// $username = "Bdp_user";
//  $password = "@#45GilJak";
//  $dbname = "Boardingpassdb";

// Create a database connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


