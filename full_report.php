<?php
include 'db_conn.php';

session_start();

// Check if the user is logged in
if (!isset($_SESSION['FULLNAME'])) {
    // Display alert
    echo "<script>";
    echo "alert('Logging in is required to access the form.');";
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
<!-- <!DOCTYPE html> -->
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Passenger Details</title>
    <link rel="icon" type="image/x-icon" href="img/BP_Icon.png">
    <!-- <link rel="stylesheet" href="../bootstrap-5.3.3-dist/paper.css"> -->
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
            height: 100%;
            margin: 0;
            padding: 0;
            font-family: 'Acumin Variable Concept', sans-serif;
            overflow-y: hidden;
        }

        .page {
            display: flex;
            flex-direction: column;
            height: 100vh;
            position: relative;
            overflow-y: auto;
        }

        .content {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        .img_dashbord {
            height: auto;
            max-width: 80%;
        }

        .para_text_ {
            font-size: 15px;
        }
    </style>
</head>

<body>
    <!-- <a href="./full_report.php"></a> -->
    <div class="page">
        <div class="header">
            <?php include './assets/navi.php'; ?>
        </div>

        <main class="content">
            <div class="container">
                <br>
                <?php
                // Default values for date inputs
                $dateFromDefault = date('Y-m-d');
                // $dateFromDefault = date('Y-m-d', strtotime('-1 month'));
                $dateToDefault = date('Y-m-d');

                // Initialize date variables
                $dateFrom = $dateFromDefault;
                $dateTo = $dateToDefault;

                // Check if a date range is submitted
                if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
                    $dateFrom = $_POST['date_from'];
                    $dateTo = $_POST['date_to'];

                    // Check date validation
                    if ($dateFrom > $dateTo) {
                        echo "<div class='alert alert-danger'>From Date must be earlier than To Date.</div>";
                    }
                }

                // Initialize the SQL query
                $sql = "SELECT * FROM passengerdetails";

                // Check if both dates are provided and format them for SQL
                if (!empty($dateFrom) && !empty($dateTo)) {
                    $sql .= " WHERE date_of_flight BETWEEN '" . $conn->real_escape_string($dateFrom) . "' AND '" . $conn->real_escape_string($dateTo) . "'";
                }

                // Add ordering to the query
                $sql .= " ORDER BY date_of_flight DESC, flight_number ASC";

                // Display header and download link
                echo "<div style='display: flex; justify-content: space-between'>";
                echo "<h2><b>All Passenger Details</b></h2>";
                echo "<a href='generate_all_passengers_pdf.php?dateFrom=" . $dateFrom . "&dateTo=" . $dateTo . "' class='btn btn-primary'>Download All Passenger PDF</a>";
                echo "</div><br>";

                // Filter form
                ?>
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
                <?php
                if ($dateFrom == $dateTo) {
                    $filter_date = "Date: " . $dateFrom;
                } else {
                    $filter_date = "Date From: " . $dateFrom . " | Date To: " . $dateTo;
                }
                ?>
                <?php echo $filter_date; ?>
                <hr>
                <?php
                // Execute the query and check for errors
                if ($result = $conn->query($sql)) {
                    // Display table only if there are records
                    if ($result->num_rows > 0) { ?>
                        <table id='example' class='table table-striped cell-border ' style='width:100%'>
                            <thead>
                                <tr class="align-middle">
                                    <th class="text-center">ID</th>
                                    <th class="text-center">Passenger Name</th>
                                    <th class="text-center">From</th>
                                    <th class="text-center">To</th>
                                    <th class="text-center">Flight Num</th>
                                    <th class="text-center">Date of Flight</th>
                                    <th class="text-center">Seat Num</th>
                                    <th class="text-center">NO of IV</th>
                                    <th class="text-center">NO of PAX</th>
                                    <th class="text-center">Type</th>
                                    <!-- <th class="text-center">Captured Date</th> -->
                                    <!-- <th class="text-center">Captured Time</th> -->
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody class='table-group-divider text-uppercase'>
                                <?php $counter = 1;
                                while ($row = $result->fetch_assoc()) { ?>
                                    <tr>
                                        <td class="text-center align-middle"><?php echo $counter; ?></td>
                                        <td class="text-center align-middle"><?php echo htmlspecialchars($row["passenger_name"]); ?></td>
                                        <td class="text-center align-middle"><?php echo htmlspecialchars($row["from_city_code"]); ?></td>
                                        <td class="text-center align-middle"><?php echo htmlspecialchars($row["to_city_code"]); ?></td>
                                        <td class="text-center align-middle"><?php echo htmlspecialchars($row["flight_number"]); ?></td>
                                        <td class="text-center align-middle"><?php echo htmlspecialchars($row["date_of_flight"]); ?></td>
                                        <td class="text-center align-middle"><?php echo htmlspecialchars($row["seat_number"]); ?></td>
                                        <td class="text-center align-middle"><?php echo htmlspecialchars($row["no_of_iv"]); ?></td>
                                        <td class="text-center align-middle"><?php echo htmlspecialchars($row["no_of_pax"]); ?></td>
                                        <td class="text-center align-middle"><?php echo htmlspecialchars($row["card_number"]); ?></td>
                                        <!-- <td class="text-start align-middle"><?php echo htmlspecialchars($row["captured_date"]); ?><br><?php echo htmlspecialchars($row["captured_time"]); ?> </td> -->
                                        <!-- <td class="text-center align-middle"></td> -->
                                        <td class="text-center align-middle">
                                            <div class="d-flex justify-content-center align-items-center">
                                                <!-- View Button -->
                                                <button type="button" class="btn btn-secondary btn-sm me-2" data-bs-toggle="modal" data-bs-target="#passengerModal<?php echo $row['id']; ?>">
                                                    <i class="bi bi-eye"></i>
                                                </button>

                                                <!-- Conditional Edit Button -->
                                                <?php if (($_SESSION['USER_TYPE'] == 'Admin') || ($_SESSION['USER_TYPE'] == 'User' && $row["date_of_flight"] == $dateFromDefault)): ?>
                                                    <a href="update_form_table.php?id=<?php echo $row['id']; ?>" class="btn btn-success btn-sm me-2">
                                                        <i class="bi bi-pencil-square"></i>
                                                    </a>
                                                <?php endif; ?>

                                                <!-- Conditional Delete Button with no extra margin on bottom -->
                                                <?php if (($_SESSION['USER_TYPE'] == 'Admin') || ($_SESSION['USER_TYPE'] == 'User' && $row["date_of_flight"] == $dateFromDefault)): ?>
                                                    <form method="post" action="./delete_pax_data.php" onsubmit="return confirmAction()" class="mb-0">
                                                        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                                        <input type="hidden" name="link" value="./full_report.php">
                                                        <button type="submit" class="btn btn-danger btn-sm me-2" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete">
                                                            <i class="bi bi-trash-fill"></i>
                                                        </button>
                                                    </form>
                                                <?php endif; ?>
                                                <?php if (($_SESSION['USER_TYPE'] == 'Admin')): ?>
                                                    <form method="post" action="./view_edit_history.php" class="mb-0">
                                                        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                                        <button type="submit" class="btn btn-primary btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="update history">
                                                            <i class="bi bi-clock-history"></i> </button>
                                                    </form>
                                                <?php endif; ?>
                                            </div>
                                        </td>
                                    </tr>
                                    <div class='modal fade' id='passengerModal<?php echo $row["id"]; ?>' tabindex='-1' aria-labelledby='passengerModalLabel<?php echo $row["id"]; ?>' aria-hidden='true'>
                                        <div class='modal-dialog'>
                                            <div class='modal-content'>
                                                <div class='modal-header'>
                                                    <h5 class='modal-title' id='passengerModalLabel<?php echo $row["id"]; ?>'>Passenger Details</h5>
                                                    <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                                                </div>
                                                <div class='modal-body'>
                                                    <p>ID: <?php echo htmlspecialchars($row["id"]); ?></p>
                                                    <p>Passenger Name: <?php echo htmlspecialchars($row["passenger_name"]); ?></p>
                                                    <p>From City Airport Code: <?php echo htmlspecialchars($row["from_city_code"]); ?></p>
                                                    <p>To City Airport Code: <?php echo htmlspecialchars($row["to_city_code"]); ?></p>
                                                    <p>Flight Number: <?php echo htmlspecialchars($row["flight_number"]); ?></p>
                                                    <p>Date of Flight: <?php echo htmlspecialchars($row["date_of_flight"]); ?></p>
                                                    <p>Seat Number: <?php echo htmlspecialchars($row["seat_number"]); ?></p>
                                                    <p>NO of IV: <?php echo htmlspecialchars($row["no_of_iv"]); ?></p>
                                                    <p>NO of PAX: <?php echo htmlspecialchars($row["no_of_pax"]); ?></p>
                                                    <p>Captured Date: <?php echo htmlspecialchars($row["captured_date"]); ?></p>
                                                    <p>Captured Time: <?php echo htmlspecialchars($row["captured_time"]); ?></p>
                                                    <p>Type: <?php echo htmlspecialchars($row["card_number"]); ?></p>
                                                    <p>Entered by: <?php echo htmlspecialchars($row["entered_by"]); ?></p>
                                                    <p>Last updated by: <?php echo htmlspecialchars($row["updated_by"]); ?></p>
                                                    <p>Last update time: <?php echo htmlspecialchars($row["update_time"]); ?></p>
                                                    <p>Remarks: <?php echo htmlspecialchars($row["remarks"]); ?></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php $counter++;
                                } ?>
                            </tbody>
                        </table>
                <?php } else {
                        echo "<div'>No passenger records found for the selected date range.</div>";
                    }
                } else {
                    echo "Error: " . $conn->error;
                }
                $conn->close();
                ?>
            </div>
        </main>
        <?php include './assets/footer.php'; ?>
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

    <!-- Initialize DataTables -->
    <script>
        let airlineName = "<?php echo $airlineName; ?>";
        let filter_date = "<?php echo $filter_date; ?>";
        let paxCountn = "<?php echo $paxCountn; ?>";
        let User = "<?php echo ($_SESSION['Dname']); ?>";

        new DataTable('#example', {
            dom: 'Bfrtip', // Enables buttons at the top
            buttons: [{
                extend: 'pdf', // Export to PDF
                responsive: true,
                title: `Airline Report ${airlineName} ${filter_date}`, // Dynamic Title
                orientation: 'landscape', // Orientation
                pageSize: 'A4', // Page size
                exportOptions: {
                    columns: [1, 4, 5, 6, 9, 10]
                },
                customize: function(doc) {
                    // Set specific column widths for better responsiveness
                    doc.content[1].table.widths = [
                        '25%', // Column 1 width
                        '20%', // Column 4 width
                        '15%', // Column 5 width
                        '12%', // Column 6 width
                        '5%', // Column 9 width
                        '23%' // Column 10 width
                    ];

                    // Center-align all table header text and apply borders
                    doc.content[1].table.body[0].forEach(cell => {
                        cell.alignment = 'center';
                        cell.fontSize = 12;
                        cell.bold = true;
                        cell.border = [true, true, true, true];
                    });

                    // Center-align all body text
                    doc.content[1].table.body.forEach(row => {
                        row.forEach(cell => {
                            cell.alignment = 'center';
                            cell.fontSize = '12';
                            cell.margin = [0, 0, 0, 5];
                            cell.border = [true, true, true, true];
                            cell.text = cell.text.toUpperCase();
                        });
                    });

                    // Calculate total number of passengers (assume column 5 contains passenger counts)
                    let totalPassengers = 0;
                    doc.content[1].table.body.slice(1).forEach(row => {
                        totalPassengers += parseInt(row[4].text, 10) || 0; // Safely parse values
                    });

                    // Add the total passenger count below the table
                    doc.content.push({
                        text: `Total Number of Passengers: ${totalPassengers}`,
                        alignment: 'left',
                        fontSize: 12,
                        bold: true,
                        margin: [10, 30, 0, 0] // Margin top for spacing
                    });
                    // // Add the total passenger count below the table
                    // doc.content.push({
                    //     text: `Total Number of Passengers: ${paxCountn}`,
                    //     alignment: 'left',
                    //     fontSize: 12,
                    //     bold: true,
                    //     margin: [10, 10, 0, 0] // Margin top for spacing
                    // });

                    // Add a header
                    doc.content.unshift({
                        stack: [{
                                text: `User: ${User}`,
                                style: 'headeruser',
                                alignment: 'right',
                            },
                            {
                                text: 'Airport & Aviation Services (Sri Lanka) (Private) Limited',
                                style: 'headerLarge',
                                bold: true
                            },
                            {
                                text: 'Araliya Lounge',
                                style: 'headerMedium',
                                bold: true
                            },
                            {
                                text: `Passenger Details for Airline: ${airlineName}`,
                                style: 'headerSmall',
                                bold: true
                            }
                        ],
                        alignment: 'center',
                        margin: [0, 0, 0, 20]
                    });

                    // Add a footer
                    doc.footer = function(currentPage, pageCount) {
                        return {
                            stack: [{
                                    text: 'Copyright © 2010 Airport & Aviation (Sri Lanka) Limited. All rights reserved.',
                                    alignment: 'left',
                                    style: 'footerStyle1',
                                    margin: [10, 0, 0, 2]
                                },
                                {
                                    columns: [{
                                            text: 'Powered by IT Division',
                                            alignment: 'left',
                                            style: 'footerStyle2',
                                            margin: [10, 0, 0, 0]
                                        },
                                        {
                                            text: 'Page ' + currentPage + ' of ' + pageCount,
                                            alignment: 'right',
                                            style: 'footerStyle2',
                                            margin: [0, 0, 10, 0]
                                        }
                                    ]
                                }
                            ],
                            margin: [10, 0, 10, 10]
                        };
                    };

                    // Add styles for footer and headers
                    doc.styles = {
                        headeruser: {
                            fontSize: 10,
                            margin: [0, 0, 0, 10]
                        },
                        headerLarge: {
                            fontSize: 16,
                            margin: [0, 0, 0, 10]
                        },
                        headerMedium: {
                            fontSize: 14,
                            margin: [0, 0, 0, 10]
                        },
                        headerSmall: {
                            fontSize: 12,
                            margin: [0, 0, 0, 20]
                        },
                        footerStyle1: {
                            fontSize: 9,
                            bold: true
                        },
                        footerStyle2: {
                            fontSize: 9,
                            italics: true
                        }
                    };
                }
            }, 'copy', 'csv', 'excel', 'print']
        });
    </script>

    <script>
        function confirmAction() {
            // Display a confirmation dialog
            return confirm("Are you sure you want to delete this data?");
        }
    </script>
</body>

</html>