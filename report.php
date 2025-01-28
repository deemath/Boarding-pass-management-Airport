<?php
include 'db_conn.php';

session_start();

// Check if the user is logged in
if (!isset($_SESSION['FULLNAME'])) {
    // Display alert
    echo "<script>";
    echo "alert('Logging in is required to access  form.');";
    echo "window.location.href = './index.php';";
    echo "</script>";
    exit; // Ensure script stops execution after displaying alert and redirecting
}
// Create a database connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize sum variables
$sum_no_of_iv = 0;
$sum_no_of_pax = 0;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Report</title>
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
    </style>
</head>

<body>
    <div class="page">
        <div class="header">
            <?php include './assets/navi.php'; ?>
        </div>

        <main class="content">
            <div class="container">
                <h2><b>Today Details</b></h2>
                <br>
                <?php
                // Data retrieval query
                $sql = "SELECT * FROM passengerdetails WHERE date_of_flight = CURDATE() ORDER BY date_of_flight DESC, flight_number ASC"; // show only the ones currently captured today
                $result = $conn->query($sql);
                $dateFromDefault = date('Y-m-d');

                // Display table only if there are records
                if ($result->num_rows > 0) {
                    echo "<table id='example' class='table table-striped cell-border ' style='width:100%'>";
                    // Table headers
                    echo "<thead>";
                    echo "<tr>";
                    echo "<th class='text-center align-middle'>ID</th>";
                    echo "<th class='text-center align-middle'>Passenger Name</th>";
                    echo "<th class='text-center align-middle'>From </th>";
                    echo "<th class='text-center align-middle'>To </th>";
                    echo "<th class='text-center align-middle'>Flight Number</th>";
                    echo "<th class='text-center align-middle'>Date of Flight</th>";
                    echo "<th class='text-center align-middle'>Seat Number</th>";
                    echo "<th class='text-center align-middle'>NO of IV</th>";
                    echo "<th class='text-center align-middle'>NO of PAX</th>";
                    echo "<th class='text-center align-middle'>Type</th>";
                    echo "<th class='text-center align-middle'>Action</th>";
                    echo "</tr>";
                    echo "</thead>";
                    echo "<tbody class='table-group-divider text-uppercase'>";

                    // Output data of each row
                    $counter = 1;
                    while ($row = $result->fetch_assoc()) {
                        // Sum the NO of IV and NO of PAX
                        $sum_no_of_iv += $row["no_of_iv"];
                        $sum_no_of_pax += $row["no_of_pax"];

                        echo "<tr>";
                        echo "<td class='text-center align-middle'>" . $counter . "</td>";
                        echo "<td class='text-center align-middle'>" . $row["passenger_name"] . "</td>";
                        echo "<td class='text-center align-middle'>" . $row["from_city_code"] . "</td>";
                        echo "<td class='text-center align-middle'>" . $row["to_city_code"] . "</td>";
                        echo "<td class='text-center align-middle'>" . $row["flight_number"] . "</td>";
                        echo "<td class='text-center align-middle'>" . $row["date_of_flight"] . "</td>";
                        echo "<td class='text-center align-middle'>" . $row["seat_number"] . "</td>";
                        echo "<td class='text-center align-middle'>" . $row["no_of_iv"] . "</td>";
                        echo "<td class='text-center align-middle'>" . $row["no_of_pax"] . "</td>";
                        echo "<td class='text-center align-middle'>" . $row["card_number"] . "</td>";


                        echo "<td class='text-center align-middle'>";
                        echo "<div class='d-flex p-2'>";
                        echo "<button type='button' class='btn btn-secondary btn-sm me-2' data-bs-toggle='modal' data-bs-target='#passengerModal" . $row["id"] . "'><i class='bi bi-eye'></i></button>"; // View icon button

                        if (($_SESSION['USER_TYPE'] == 'Admin') || $_SESSION['USER_TYPE'] == 'User' && $row["date_of_flight"] == $dateFromDefault): ?>
                            <a href="./update_from_day.php?id=<?php echo $row['id']; ?>" class="btn btn-success btn-sm me-2">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                        <?php endif;
                        if (($_SESSION['USER_TYPE'] == 'Admin') || ($_SESSION['USER_TYPE'] == 'User' && $row["date_of_flight"] == $dateFromDefault)): ?>
                            <form method="post" action="./delete_pax_data.php" onsubmit="return confirmAction()" class="mb-0">
                                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                <input type="hidden" name="link" value="./report.php">
                                <button type="submit" class="btn btn-danger btn-sm me-2" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete">
                                    <i class="bi bi-trash-fill"></i>
                                </button>
                            </form>
                        <?php endif;
                        ?>
                        <?php if (($_SESSION['USER_TYPE'] == 'Admin')): ?>
                            <form method="post" action="./view_edit_history.php" class="mb-0">
                                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                <button type="submit" class="btn btn-primary btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="update history">
                                    <i class="bi bi-clock-history"></i> </button>
                            </form>
                        <?php endif; ?>

                <?php
                        // echo "<a href='./update_from_day.php?id=" . $row["id"] . "' class='btn btn-success btn-sm me-2'><i class='bi bi-pencil-square'></i></a>"; 
                        // Edit icon button
                        // echo "<button class='btn btn-danger btn-sm' onclick='deletePassenger(" . $row["id"] . ")'><i class='bi bi-trash3'></i></button>"; 
                        echo "</div>";
                        echo "</td>";

                        echo "</tr>";

                        // Modal for displaying passenger details
                        echo "<div class='modal fade' id='passengerModal" . $row["id"] . "' tabindex='-1' aria-labelledby='passengerModalLabel" . $row["id"] . "' aria-hidden='true'>";
                        echo "<div class='modal-dialog'>";
                        echo "<div class='modal-content'>";
                        echo "<div class='modal-header'>";
                        echo "<h5 class='modal-title' id='passengerModalLabel" . $row["id"] . "'>Passenger Details</h5>";
                        echo "<button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>";
                        echo "</div>";
                        echo "<div class='modal-body'>";
                        // Display all details of the passenger
                        echo "<p>ID: " . $row["id"] . "</p>";
                        echo "<p>Passenger Name: " . $row["passenger_name"] . "</p>";
                        echo "<p>From City Airport Code: " . $row["from_city_code"] . "</p>";
                        echo "<p>To City Airport Code: " . $row["to_city_code"] . "</p>";
                        echo "<p>Flight Number: " . $row["flight_number"] . "</p>";
                        echo "<p>Date of Flight: " . $row["date_of_flight"] . "</p>";
                        echo "<p>Seat Number: " . $row["seat_number"] . "</p>";
                        echo "<p>No of iv: " . $row["no_of_iv"] . "</p>";
                        echo "<p>No of pax: " . $row["no_of_pax"] . "</p>";
                        echo "<p>Captured Date: " . $row["captured_date"] . "</p>";
                        echo "<p>Captured Time: " . $row["captured_time"] . "</p>";
                        echo "<p>Type: " . $row["card_number"] . "</p>";
                        echo "<p>Entered by: " . $row["entered_by"] . "</p>";
                        echo "<p>Last updated by: " . $row["updated_by"] . "</p>";
                        echo "<p>Last update time: " . $row["update_time"] . "</p>";
                        echo "<p>Remarks: " . $row["remarks"] . "</p>";


                        echo "</div>";
                        echo "<div class='modal-footer'>";
                        echo "<button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Close</button>";
                        echo "</div>";
                        echo "</div>";
                        echo "</div>";
                        echo "</div>";

                        $counter++;
                    }
                    echo "</tbody>";
                    echo "</table>";
                } else {
                    echo "No records found";
                }

                // Close the database connection
                $conn->close();
                ?>
                <div class="mt-4">
                    <p><strong>Total NO of IV:</strong> <?php echo $sum_no_of_iv; ?></p>
                    <p><strong>Total NO of PAX:</strong> <?php echo $sum_no_of_pax; ?></p>
                </div>
                <div class="d-flex justify-content-start align-items-center gap-2">
                    <a href="generate_report_pdf.php" class="btn btn-primary" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Download Daily Summary">Download PDF</a>
                    <form action="./ddddd.php" method="post">
                        <button class="btn btn-success" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Download Daily Airline Summary">Download Daily Airline Summary</button>
                    </form>
                </div>

            </div>
        </main>
        <br>

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
    <script>
        function confirmAction() {
            // Display a confirmation dialog
            return confirm("Are you sure you want to delete this data?");
        }
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
            const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))
        });
    </script>
    <!-- Button tool tip ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- -->

</body>

</html>