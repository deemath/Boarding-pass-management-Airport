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
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Passenger Details</title>
    <link rel="stylesheet" href="./bootstrap-5.3.3-dist/css/bootstrap.min.css">
    <link rel="icon" type="image/x-icon" href="img/BP_Icon.png">
    <link rel="stylesheet" href="../bootstrap-5.3.3-dist/paper.css">
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
                <br>
                <?php
                // Default values for date inputs
                $dateFromDefault = date('Y-m-d', strtotime('-1 month')); // Set to 1 month ago
                $dateToDefault = date('Y-m-d'); // Set to today

                // Initialize date variables
                $dateFrom = $dateFromDefault;
                $dateTo = $dateToDefault;

                // Check if a date range is submitted
                if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
                    $dateFrom = $_POST['date_from'];
                    $dateTo = $_POST['date_to'];
                }

                if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
                    $dateFrom = $_POST['date_from'];
                    $dateTo = $_POST['date_to'];

                    // Check date validation
                    if ($dateFrom > $dateTo) {
                        echo "<div class='alert alert-danger'>From Date must be earlier than To Date.</div>";
                    } else {
                        // Initialize the SQL query
                        $sql = "SELECT * FROM passengerdetails";

                        // Check if both dates are provided and format them for SQL
                        if (!empty($dateFrom) && !empty($dateTo)) {
                            // Prepare the SQL query with the date filter
                            $sql .= " WHERE captured_date BETWEEN '" . $conn->real_escape_string($dateFrom) . "' AND '" . $conn->real_escape_string($dateTo) . "'";
                        }

                        // Add ordering to the query
                        $sql .= " ORDER BY date_of_flight DESC, flight_number ASC";

                ?>

                <div style="display: flex; justify-content: space-between">
                    <h2><b>All Passenger Details</b></h2>
                    <a href="generate_all_passengers_pdf.php?dateFrom=<?php echo ($dateFrom); ?>&dateTo=<?php echo ($dateTo); ?>" class="btn btn-primary">Download All Passenger PDF</a>
                </div>
                <br>
                

                <form method="POST" action="">
                    <div class="row mb-3">
                        <div class="col">
                            <label for="date_from" class="form-label">From Date:</label>
                            <input type="date" class="form-control" id="date_from" name="date_from" required
                                value="<?php echo htmlspecialchars($dateFrom); ?>">
                        </div>
                        <div class="col">
                            <label for="date_to" class="form-label">To Date:</label>
                            <input type="date" class="form-control" id="date_to" name="date_to" required
                                value="<?php echo htmlspecialchars($dateTo); ?>">
                        </div>
                    </div>
                    <button type="submit" name="submit" class="btn btn-primary">Filter</button>
                    <a href="./full_report.php" class="btn btn-secondary">Clear Date Filter</a>
                </form>

                <br>
                <?php
                // Check if a date range is submitted
                
                        // Execute the query and check for errors
                        if ($result = $conn->query($sql)) {
                            // Display table only if there are records
                            if ($result->num_rows > 0) {
                                echo "<table id='example' class='table table-striped cell-border text-center align-middle' style='width:100%'>";
                                // Table headers
                                echo "<thead>";
                                echo "<tr>";
                                echo "<th class='text-center align-middle'>ID</th>";
                                echo "<th class='align-middle'>Passenger Name</th>";
                                echo "<th class='align-middle'>From</th>";
                                echo "<th class='align-middle'>To</th>";
                                echo "<th class='align-middle'>Flight Number</th>";
                                echo "<th class='align-middle'>Date of Flight</th>";
                                echo "<th class='align-middle'>Seat Number</th>";
                                echo "<th class='align-middle'>NO of IV</th>";
                                echo "<th class='align-middle'>NO of PAX</th>";
                                echo "<th class='align-middle'>Captured Date</th>";
                                echo "<th class='align-middle'>Captured Time</th>";
                                echo "<th class='align-middle'>Action</th>"; // Action column
                                echo "</tr>";
                                echo "</thead>";
                                echo "<tbody class='table-group-divider'>";

                                // Output data of each row
                                $counter = 1;
                                while ($row = $result->fetch_assoc()) {
                                    echo "<tr>";
                                    echo "<td>" . $counter . "</td>";
                                    echo "<td>" . htmlspecialchars($row["passenger_name"]) . "</td>";
                                    echo "<td>" . htmlspecialchars($row["from_city_code"]) . "</td>";
                                    echo "<td>" . htmlspecialchars($row["to_city_code"]) . "</td>";
                                    echo "<td>" . htmlspecialchars($row["flight_number"]) . "</td>";
                                    echo "<td>" . htmlspecialchars($row["date_of_flight"]) . "</td>";
                                    echo "<td>" . htmlspecialchars($row["seat_number"]) . "</td>";
                                    echo "<td>" . htmlspecialchars($row["no_of_iv"]) . "</td>";
                                    echo "<td>" . htmlspecialchars($row["no_of_pax"]) . "</td>";
                                    echo "<td>" . htmlspecialchars($row["captured_date"]) . "</td>";
                                    echo "<td>" . htmlspecialchars($row["captured_time"]) . "</td>";

                                    echo "<td class='d-flex p-2'>";
                                    echo "<button type='button' class='btn btn-secondary btn-sm me-2' data-bs-toggle='modal' data-bs-target='#passengerModal" . $row["id"] . "'><i class='bi bi-eye'></i></button>"; // View icon button
                                    echo "<a href='update_form_table.php?id=" . $row["id"] . "' class='btn btn-success btn-sm me-2'><i class='bi bi-pencil-square'></i></a>"; // Edit icon button
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
                                    echo "<p>ID: " . htmlspecialchars($row["id"]) . "</p>";
                                    echo "<p>Passenger Name: " . htmlspecialchars($row["passenger_name"]) . "</p>";
                                    echo "<p>From City Airport Code: " . htmlspecialchars($row["from_city_code"]) . "</p>";
                                    echo "<p>To City Airport Code: " . htmlspecialchars($row["to_city_code"]) . "</p>";
                                    echo "<p>Flight Number: " . htmlspecialchars($row["flight_number"]) . "</p>";
                                    echo "<p>Date of Flight: " . htmlspecialchars($row["date_of_flight"]) . "</p>";
                                    echo "<p>Seat Number: " . htmlspecialchars($row["seat_number"]) . "</p>";
                                    echo "<p>No of IV: " . htmlspecialchars($row["no_of_iv"]) . "</p>";
                                    echo "<p>No of PAX: " . htmlspecialchars($row["no_of_pax"]) . "</p>";
                                    echo "<p>Captured Date: " . htmlspecialchars($row["captured_date"]) . "</p>";
                                    echo "<p>Captured Time: " . htmlspecialchars(date('h:i:s A', strtotime($row["captured_time"]))) . "</p>";
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
                                echo "<div>No records found</div>";
                            }

                            // Close the result set
                            $result->free();
                        } else {
                            echo "<div>Error executing query: " . $conn->error . "</div>";
                        }
                    }
                }

                // Close the database connection
                $conn->close();
                ?>

            </div>

        </main>



        <footer class="footer">
            <?php include './assets/footer.php'; ?>
        </footer>
    </div>

    <!-- JavaScript -->
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/2.0.0/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.0.0/js/dataTables.bootstrap5.js"></script>

    <script>
        $(document).ready(function() {
            // Initialize DataTable
            $('#example').DataTable();
        });

        // Function to handle deleting passenger
        function deletePassenger(passengerId) {
            if (confirm('Are you sure you want to delete this passenger?')) {
                $.ajax({
                    url: 'delete_passenger.php?action=delete&passenger_id=' + passengerId,
                    type: 'GET',
                    success: function(response) {
                        // Reload the page to reflect changes
                        location.reload();
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                        alert('Error deleting passenger. Please try again.');
                    }
                });
            }
        }
    </script>

</body>

</html>