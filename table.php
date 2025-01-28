<?php
include 'db_conn.php';

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
            background: #ECF0F1; /* off white background color */
            height: 100%;
            margin: 0;
            padding: 0;
            font-family: 'Acumin Variable Concept', sans-serif;
            overflow-y: hidden; /* Prevent scrolling of the entire page */
        }

        .page {
            display: flex;
            flex-direction: column;
            height: 100vh; /* Full viewport height */
            position: relative;
            overflow-y: auto; /* Enable scrolling within .page if content exceeds viewport height */
        }

        .content {
            flex: 1; /* Adjust to occupy remaining space */
            display: flex;
            flex-direction: column;
            align-items: center; /* Center content horizontally */
            justify-content: center; /* Center content vertically */
        }
 
        .para_text_ {
            font-size: 15px;
        }
    </style>
</head>
<body>

<div class="page">
    <div class="header">
        <?php 
        // include './assets/navi 1.php';
         ?>
    </div>

    <main class="content">
        <div class="container">
            <h2><b>Passenger Details</b></h2>
            <br>
            <?php
            // Data retrieval query
            $sql = "SELECT * FROM passengerdetails";
            $result = $conn->query($sql);

            // Display table only if there are records
            if ($result->num_rows > 0) {
                echo "<table id='example' class='table table-striped cell-border' style='width:100%'>";
                // Table headers
                echo "<thead>";
                echo "<tr>";
                echo "<th>ID</th>";
                echo "<th>Passenger Name</th>";
                echo "<th>From City Airport Code</th>";
                echo "<th>To City Airport Code</th>";
                echo "<th>Flight Number</th>";
                echo "<th>Date of Flight</th>";
                echo "<th>Seat Number</th>";
                echo "<th>NO of IV</th>";
                echo "<th>NO if PAX</th>";

                echo "<th>Action</th>"; // action column
                echo "</tr>";
                echo "</thead>";
                echo "<tbody class='table-group-divider'>";

                // Output data of each row
                $counter = 1;
                while ($row = $result->fetch_assoc()) { 
                    echo "<tr>";
                    echo "<td>" . $counter . "</td>";
                    echo "<td>" . $row["passenger_name"] . "</td>"; 
                    echo "<td>" . $row["from_city_code"] . "</td>";
                    echo "<td>" . $row["to_city_code"] . "</td>";
                    echo "<td>" . $row["flight_number"] . "</td>";
                    echo "<td>" . $row["date_of_flight"] . "</td>";
                    echo "<td>" . $row["seat_number"] . "</td>";
                    echo "<td>" . $row["no_of_iv"] . "</td>";
                    echo "<td>" . $row["no_of_pax"] . "</td>";

                    echo "<td class='d-flex p-2'>";
                    echo "<button type='button' class='btn btn-secondary btn-sm me-2' data-bs-toggle='modal' data-bs-target='#passengerModal" . $row["id"] . "'><i class='bi bi-eye'></i></button>"; // View icon button
                    echo "<a href='update_form.php?id=" . $row["id"] . "' class='btn btn-success btn-sm me-2'><i class='bi bi-pencil-square'></i></a>"; // Edit icon button
                    echo "<button class='btn btn-danger btn-sm' onclick='deletePassenger(" . $row["id"] . ")'><i class='bi bi-trash3'></i></button>"; // Delete icon button
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
                    echo "<p>Captured Date: " . $row["captured_date"] . "</p>";
                    echo "<p>Captured Time: " . date('h:i:s A', strtotime($row["captured_time"])) . "</p>";
                    

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
        </div>
    </main>

    <footer class="footer">
        <?php
        // include 'assets/footer.php'; 
         ?>
    </footer>
</div>

<!-- JavaScript -->
<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
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
