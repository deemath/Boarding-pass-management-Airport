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
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve the airline IATA code from the query parameter
$airline = isset($_GET['airline']) ? $conn->real_escape_string($_GET['airline']) : '';

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
// If IATA code is provided, fetch relevant airline name
if ($airline) {
    // Query to fetch the airline name using the IATA code
    $airlineSql = "SELECT AirlineName FROM airlines_details WHERE IATA = '$airline'";
    $airlineResult = $conn->query($airlineSql);

    // If the airline exists, retrieve the airline name
    if ($airlineResult && $airlineResult->num_rows > 0) {
        $airlineRow = $airlineResult->fetch_assoc();
        $airlineName = $airlineRow['AirlineName'];
    } else {
        $airlineName = "Unknown Airline";
    }
}
// // Check if a date range is submitted
// // if (isset($_POST['submit'])) {
//     if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
//     // $dateFrom = isset($_POST['date_from']) ? $_POST['date_from'] : '';
//     // $dateTo = isset($_POST['date_to']) ? $_POST['date_to'] : '';
//     $dateFrom = $_POST['date_from'];
//     $dateTo = $_POST['date_to'];

// Query to fetch passenger details within the date range
$sql = "SELECT * FROM passengerdetails WHERE LEFT(flight_number, 2) = '$airline'";
if ($dateFrom && $dateTo) {
    $sql .= " AND date_of_flight BETWEEN '$dateFrom' AND '$dateTo'";
}
$sql .= " ORDER BY date_of_flight DESC";  // Ensure ORDER BY is always appended correctly
$result = $conn->query($sql);
// }
//  else 
//  {
//     // Query to fetch all passenger details by default
//     $sql = "SELECT * FROM passengerdetails WHERE LEFT(flight_number, 2) = '$airline' ORDER BY captured_date DESC";
//     $result = $conn->query($sql);
// }

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Airline Report</title>
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
            /* Removed height and overflow-y to allow scrolling */
            margin: 0;
            padding: 0;
            height: 100%;
            font-family: 'Acumin Variable Concept', sans-serif;
        }

        /* Optionally, if you need a fixed height container with its own scrolling */
        .content-container {
            max-height: 100vh;
            /* Adjust as needed */
            overflow-y: auto;
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
        .fa_sml{
            font-size: 12px !important;
        }
    </style>
</head>

<body>
    <div class="header">
        <?php include './assets/navi.php'; ?>
    </div>
    <main class="content">
        <div class="container mt-4">
            <div style="display: flex; justify-content: space-between">
                <h3><b><?php echo htmlspecialchars($airlineName); ?> - ALL Details</b></h3>
                <div>
                    <?php
                    // echo "Date From:" . $dateFrom . " | " . "Date To:" . $dateTo;
                    ?>

                    <!-- Trigger Button -->
                    <button type="button" class="btn btn-primary fa_sml" data-bs-toggle="modal" data-bs-target="#email_loung_am">
                        Send Mail Lounge.am
                    </button>
                    <button type="button" class="btn btn-primary fa_sml" data-bs-toggle="modal" data-bs-target="#email_loung_airline">
                        Send Mail Airline
                    </button>

                    <a href="generate_all_passengers_airline_pdf.php?dateFrom=<?php echo $dateFrom; ?>&dateTo=<?php echo $dateTo; ?>&airline=<?php echo htmlspecialchars($airline); ?>&airlineName=<?php echo htmlspecialchars($airlineName); ?>"
                        class="btn btn-primary fa_sml">
                        Download PDF for All <?php echo htmlspecialchars($airlineName); ?>
                    </a>
                    <!-- echo "<a href='generate_all_passengers_pdf.php?dateFrom=" . $dateFrom . "&dateTo=" . $dateTo . "' class='btn btn-primary'>Download All Passenger PDF</a>"; -->

                </div>
            </div>

            <br>

            <!-- Date Range Filter Form -->
            <form method="POST" action="">
                <div class="row mb-3">
                    <div class="col">
                        <label for="date_from" class="form-label">From Date:</label>
                        <input type="date" class="form-control" id="date_from" name="date_from"
                            value="<?php echo htmlspecialchars($dateFrom); ?>">
                    </div>
                    <div class="col">
                        <label for="date_to" class="form-label">To Date:</label>
                        <input type="date" class="form-control" id="date_to" name="date_to"
                            value="<?php echo htmlspecialchars($dateTo); ?>">
                    </div>
                </div>
                <button type="submit" name="submit" class="btn btn-primary">Filter</button>
                <a href="?airline=<?php echo htmlspecialchars($airline); ?>" class="btn btn-secondary">Clear Date Filter</a>
            </form>
            <br>
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
            if (isset($result) && $result->num_rows > 0) {
                echo "<table id='example' class='table table-striped cell-border'>";
                echo "<thead>
                <tr>
                <th class='text-center align-middle'>ID</th>
                <th class='text-center align-middle'>Passenger Name</th>
                <th class='text-center align-middle'>From</th>
                <th class='text-center align-middle'>To</th>
                <th class='text-center align-middle'>Flight Number</th>
                <th class='text-center align-middle'>Date of Flight</th>
                <th class='text-center align-middle'>Seat No</th>
                <th class='text-center align-middle'>Type</th>
                <th class='text-center align-middle'>#iv</th>
                <th class='text-center align-middle'>#pax</th>
                <th class='text-center align-middle'>Time</th>
                <th class='text-center align-middle'>Actions</th>
                </tr>
                </thead>";
                echo "<tbody class='table-group-divider text-uppercase'>";

                $counter = 1;
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td class='text-center align-middle'>" . $counter . "</td>";
                    echo "<td class='text-center align-middle'>" . htmlspecialchars($row["passenger_name"]) . "</td>";
                    echo "<td class='text-center align-middle'>" . htmlspecialchars($row["from_city_code"]) . "</td>";
                    echo "<td class='text-center align-middle'>" . htmlspecialchars($row["to_city_code"]) . "</td>";
                    echo "<td class='text-center align-middle'>" . htmlspecialchars($row["flight_number"]) . "</td>";
                    echo "<td class='text-center align-middle'>" . htmlspecialchars($row["date_of_flight"]) . "</td>";
                    echo "<td class='text-center align-middle'>" . htmlspecialchars($row["seat_number"]) . "</td>";
                    echo "<td class='text-center align-middle'>" . htmlspecialchars($row["card_number"]) . "</td>";
                    echo "<td class='text-center align-middle'>" . htmlspecialchars($row["no_of_iv"]) . "</td>";
                    echo "<td class='text-center align-middle'>" . htmlspecialchars($row["no_of_pax"]) . "</td>";
                    echo "<td class='text-center align-middle'>" . htmlspecialchars($row["captured_date"]) . '<b> || </b>' . htmlspecialchars($row["captured_time"]) . "</td>";

                    echo "<td class='text-center align-middle'>";
                    echo "<div class='d-flex justify-content-center align-items-center p-2'>";
                    echo "<button type='button' class='btn btn-secondary btn-sm me-2' data-bs-toggle='modal' data-bs-target='#passengerModal" . $row["id"] . "'><i class='bi bi-eye'></i></button>"; // View icon button

                    // Conditionally render the Edit button
                    if (($_SESSION['USER_TYPE'] == 'Admin') || ($_SESSION['USER_TYPE'] == 'User' && $row["date_of_flight"] == $dateFromDefault)): ?>
                        <a href="./update_from_day_airlines.php?id=<?php echo $row['id']; ?>" class="btn btn-success btn-sm me-2">
                            <i class="bi bi-pencil-square"></i>
                        </a>
                    <?php endif;


                    // Conditionally render the Delete button
                    if (($_SESSION['USER_TYPE'] == 'Admin') || ($_SESSION['USER_TYPE'] == 'User' && $row["date_of_flight"] == $dateFromDefault)) {
                        echo "<form method='post' action='./delete_pax_data.php' onsubmit='return confirmAction()' class='mb-0 me-2'>";
                        echo "<input type='hidden' name='id' value='" . $row['id'] . "'>";
                        echo "<input type='hidden' name='link' value='./airline_report.php'>";
                        echo "<button type='submit' class='btn btn-danger btn-sm' data-bs-toggle='tooltip' data-bs-placement='top' title='Delete'>";
                        echo "<i class='bi bi-trash-fill'></i>";
                        echo "</button>";
                        echo "</form>";
                    } ?>
                                                <?php if (($_SESSION['USER_TYPE'] == 'Admin')): ?>
                    <form method="post" action="./view_edit_history.php" class="mb-0">
                        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                        <button type="submit" class="btn btn-primary btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="update history">
                            <i class="bi bi-clock-history"></i> </button>
                    </form>
                    <?php endif; ?>
            <?php

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
                    // Modal for updating passenger details


                }

                echo "</tbody></table>";
            } else {
                echo "<p>No records found for $airlineName</p>";
            }
            ?>
            <div style="display: flex; justify-content: end">
                <button type="button" onclick="window.location.href='./airline_report.php'"
                    style="background: #f44336; color: white; padding: 10px 15px; border: none; border-radius: 5px; cursor: pointer; margin-left: 10px;">Back
                    To Main Menu</button>
            </div>
            <br>
        </div>
    </main>
    <!-- Modal -->
    <?php $subject =  $airlineName . " Details " . $filter_date; ?>

    <div class="modal fade" id="email_loung_am" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body ">
                    <form method="POST" id="emailForm" action="email.php" enctype="multipart/form-data">
                        <input type="file" id="airline_report_lm" class="form-control mb-2" name="file[]" required>
                        <input type="email" id="email" name="email" value="lounge.am@airport.lk" class="form-control mb-2" placeholder="Enter recipient email" required>
                        <input type='hidden' name='subject' value='<?php echo $subject; ?>'>
                        <input type='hidden' name='message' value='<?php echo $subject; ?>'>
                        <button class="btn btn-primary mb-2 " name="sendmail" id="sendmail" type="submit">Send Mail Lounge.am</button>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="email_loung_airline" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <form method="POST" id="emailForm" action="email.php" enctype="multipart/form-data">
                        <input type="file" id="airline_report_lm" class="form-control mb-2" name="file[]" required>
                        <?php
                        // Prepare the query to get airline emails
                        $stmt = $conn->prepare("SELECT airline_email FROM airlines_email WHERE IATA = ?");
                        $stmt->bind_param("s", $airline);
                        $stmt->execute();
                        $result = $stmt->get_result();

                        $emailList = [];
                        if ($result && $result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                $emailList[] = htmlspecialchars($row["airline_email"], ENT_QUOTES, 'UTF-8');
                            }
                            // Convert email array to a semicolon-separated string
                            $emails = implode(';', $emailList);
                        } else {
                            $emails = '';
                        }
                        ?>
                        <input type="hidden" id="email" name="email"
                            value="<?php echo $emails; ?>"
                            class="form-control mb-2" placeholder="Enter recipient email(s)" required>
                        <input type="hidden" name="subject"
                            value='<?php echo $subject; ?>'
                            class="form-control mb-2" placeholder="Subject">
                        <input type="hidden" name="message"
                           value='<?php echo $subject; ?>'
                            class="form-control mb-2" placeholder="Message">
                        <button class="btn btn-primary mb-2" name="sendmail" id="sendmail" type="submit">
                            Send Mail Airline
                        </button>
                    </form>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
<?php 

    // Get count of records where card_number is 'Airlines'
    $sqlcard = "SELECT COUNT(*) AS card_count 
    FROM passengerdetails 
    WHERE card_number = 'Airlines' 
    AND date_of_flight BETWEEN '$dateFrom' AND '$dateTo' 
    AND LEFT(flight_number, 2) = '$airline'";
    $result1 = mysqli_query($conn, $sqlcard);
    $countcard = mysqli_fetch_assoc($result1);
    // Access the count value from the associative array
    $cardCount = $countcard['card_count'];

    // Get count of records where card_number is 'Airlines'
    $sqlcount_n = "SELECT COUNT(*) AS card_count FROM passengerdetails WHERE card_number != 'Airlines' 
    AND date_of_flight BETWEEN '$dateFrom' AND '$dateTo' AND LEFT(flight_number, 2) = '$airline'";
    $result2 = mysqli_query($conn, $sqlcount_n);
    $countcardn = mysqli_fetch_assoc($result2);
    // Access the count value from the associative array
    $cardCountn = $countcardn['card_count'];

    // Get count of records where card_number is 'Airlines'
    $sql_paxcount = "SELECT SUM(no_of_pax) AS no_of_pax_c FROM passengerdetails WHERE  date_of_flight BETWEEN '$dateFrom' AND '$dateTo' AND LEFT(flight_number, 2) = '$airline'";
    $result_pax_c = mysqli_query($conn, $sql_paxcount);
    $count_pax = mysqli_fetch_assoc($result_pax_c);
    // Access the count value from the associative array
    $paxCountn = $count_pax['no_of_pax_c'];

    // echo $cardCount;
    // echo $cardCountn;
    // echo $paxCountn;
?>

    <script src="./bootstrap/jquery-3.7.1.min.js"></script>
    <script src="./bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="./DataTables/datatables.min.js"></script>

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
    <script>
        function confirmAction() {
            // Display a confirmation dialog
            return confirm("Are you sure you want to delete this data?");
        }
    </script>
    <!-- <script>
        document.getElementById("send_mail_LM").addEventListener("click", function() {
            let dataTable = $('#example').DataTable();
            dataTable.button('.buttons-pdf').trigger(); // Trigger PDF generation

            // Wait for PDF to be generated and download the file
            setTimeout(() => {
                let pdfBlob = dataTable.buttons.exportData().pdfBlob;
                let formData = new FormData(document.getElementById("emailForm"));

                // Append the PDF file to the form
                formData.append("airline_report_lm", new File([pdfBlob], "AirlineReport.pdf", {
                    type: "application/pdf"
                }));

                // Send the form via AJAX
                fetch('./email_loung_am copy.php', {
                    method: 'POST',
                    body: formData
                }).then(response => {
                    if (response.ok) {
                        alert("Email sent successfully!");
                    } else {
                        alert("Failed to send email.");
                    }
                }).catch(error => {
                    console.error("Error:", error);
                });
            }, 1000); // Adjust timeout as needed
        });
    </script> -->

</body>

</html>