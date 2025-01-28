<?php
// include 'db_conn.php';
include "./db_conn.php";

session_start();

// Create a database connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
date_default_timezone_set("Asia/Colombo");

$entered_by = $_SESSION['Dname'];

$date = date('m/d/Y H:i:s', time());

// $conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Passenger Details</title>
    <link rel="icon" type="image/x-icon" href="img/BP_Icon.png">
    <link href="./bootstrap_icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="./bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="./DataTables/datatables.min.css">

    <style>
        @font-face {
            font-family: 'Acumin Variable Concept';
            src: url('./assets/font/AcuminVariableConcept-WideExtraLight.ttf');
        }

        html,
        body {
            background: #ECF0F1;
            /* off white background color */
            height: 100%;
            margin: 0;
            padding: 0;
            font-family: 'Acumin Variable Concept', sans-serif;
            overflow-y: hidden;
            /* Prevent scrolling of the entire page */
        }

        .page {
            display: flex;
            flex-direction: column;
            height: 100vh;
            /* Full viewport height */
            position: relative;
            overflow-y: auto;
            /* Enable scrolling within .page if content exceeds viewport height */
        }

        .content {
            flex: 1;
            /* Adjust to occupy remaining space */
            display: flex;
            flex-direction: column;
            align-items: center;
            /* Center content horizontally */
            justify-content: center;
            /* Center content vertically */
        }

        .img_dashbord {
            height: auto;
            /* Adjust image height */
            max-width: 80%;
            /* Ensure images don't exceed container width */
        }

        .para_text_ {
            font-size: 15px;
        }

        .col {
            flex: 1 1 150px;
            /* Allow columns to grow and shrink */
            max-width: 250px;
            /* Set a maximum width for columns */
            display: flex;
            justify-content: center;
            /* Center content horizontally */
            align-items: center;
            /* Center content vertically */
        }
    </style>
</head>

<body>

    <div class="page">
        <div class="header">
            <?php include './assets/navi.php'; ?>
        </div>

        <main class="content">

            <?php
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $id = isset($_POST['id']) ? mysqli_real_escape_string($conn, $_POST['id']) : '';
                if (!empty($id)) {
                    // echo $id;
            ?>
                    <div class="container">
                        <div class="form-container">
                            <br>
                            <div style='display: flex; justify-content: space-between'>
                                <h2><b>Passenger Update History</b></h2>
                                <a href="main-menu.html" onclick="history.back(); return false;" class="btn btn-danger" aria-label="Go back to the main menu">
                                    Back To Main Menu
                                </a>
                            </div>
                            <hr>
                            <?php
                            $sql = "SELECT * FROM passengerdetails_old where id = $id ORDER BY update_time DESC";
                            $result = $conn->query($sql);
                            if ($result->num_rows > 0) {
                                // output data of each row
                                while ($row = $result->fetch_assoc()) {
                                    // echo date_default_timezone_get();

                            ?>
                                    <div class="pt-3 px-5">
                                        <table class="table table-striped text-center table-bordered border-black">
                                            <tbody>

                                                <tr>
                                                    <th>Last Update</th>
                                                    <td><?php echo $row["update_time"]; ?></td>
                                                    <th>Updated by</th>
                                                    <td><?php echo $row["updated_by"]; ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Passenger ID</th>
                                                    <td><?php echo $row["id"]; ?></td>
                                                    <th>Passenger Name</th>
                                                    <td><?php echo $row["passenger_name"]; ?></td>
                                                </tr>
                                                <tr>
                                                    <th>From city code</th>
                                                    <td><?php echo $row["from_city_code"]; ?></td>
                                                    <th>To city code</th>
                                                    <td><?php echo $row["to_city_code"]; ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Flight number</th>
                                                    <td><?php echo $row["flight_number"]; ?></td>
                                                    <th>Seat number</th>
                                                    <td><?php echo $row["seat_number"]; ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Date of flight</th>
                                                    <td><?php echo $row["date_of_flight"]; ?></td>
                                                    <th>Airline numeric code</th>
                                                    <td><?php echo $row["airline_numeric_code"]; ?></td>
                                                </tr>

                                                <tr>
                                                    <th>No of iv</th>
                                                    <td><?php echo $row["no_of_iv"]; ?></td>
                                                    <th>No of pax</th>
                                                    <td><?php echo $row["no_of_pax"]; ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Card number</th>
                                                    <td><?php echo $row["card_number"]; ?></td>
                                                    <th>Entered by</th>
                                                    <td><?php echo $row["entered_by"]; ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Captured time</th>
                                                    <td><?php echo $row["captured_time"]; ?></td>
                                                    <th>Captured date</th>
                                                    <td><?php echo $row["captured_date"]; ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Remark</th>
                                                    <td colspan="3"><?php echo $row["remarks"]; ?></td>
                                                    
                                                </tr>

                                            </tbody>
                                        </table>
                                        <hr>
                                    </div>
                            <?php     }
                            } else {
                                echo "0 results";
                            }
                            ?>
                        </div>
                    </div>
                    <br>
            <?php
                } else {
                    echo "<p>Invalid ID provided.</p>";
                }
            } else {
                echo "<p>No edit history available for the provided CIP ID.</p>";
            }
            ?>


        </main>

        <footer class="footer">
            <?php include './assets/footer.php'; ?>
        </footer>
    </div>
    <script src="./bootstrap/jquery-3.7.1.min.js"></script>
    <script src="./bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="./DataTables/datatables.min.js"></script>
    <!-- Initialize DataTables -->
    <script>
        $(document).ready(function() {
            $('#example').DataTable();
        });
    </script>
</body>

</html>