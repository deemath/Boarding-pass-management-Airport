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
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Airline Email Details</title>
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

        .box_log {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
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
                <br>
                <div style="display: flex; justify-content: space-between">
                    <h2><b>All Airlines Email Details</b></h2>
                    <a href="./add_new_airline_email.php" class="btn btn-primary">Create New Airline Email</a>
                </div>
                <br>
                <table id='example' class='table table-striped cell-border text-center' style='width:100%'>
                    <thead>
                        <tr>
                            <th class="text-center">No</th>
                            <th class="text-center">Airline Name</th>
                            <th class="text-center">IATA</th>
                            <th class="text-center">Email</th>
                            <th class="text-center">Entered By</th>
                            <th class="text-center">Capture Time</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody class='table-group-divider'>
                        <?php

                        $a = "SELECT airlines_email.*, airlines_details.AirlineName
FROM airlines_email
INNER JOIN airlines_details ON airlines_email.IATA=airlines_details.IATA;";
                        $result1 = $conn->query($a);

                        if ($result1->num_rows > 0) {
                            // output data of each row
                            $count = 1;
                            while ($row1 = $result1->fetch_assoc()) {
                        ?>
                                <td class="text-center"><?php echo $count ?></td>
                                <td class="text-center"><?php echo $row1["AirlineName"]; ?></td>
                                <td class="text-center"><?php echo $row1["IATA"]; ?></td>
                                <td class="text-center"><?php echo $row1["airline_email"] ?></td>
                                <td class="text-center"><?php echo $row1["entered_by"] ?></td>
                                <td class="text-center"><?php echo $row1["cap_time"] ?></td>

                                <td class="row">
                                    <div class="d-flex justify-content-center">
                                        <form method="post" class="col" action="./delete_airline_mail.php" onsubmit="return confirmAction()">
                                            <input type="hidden" name="ae_id" value="<?php echo $row1['ae_id']; ?>">
                                            <button type="submit" class="btn btn-danger btn-sm" id="myTooltip" data-bs-toggle="tooltip" data-bs-placement="top" title="View and Update User">
                                                <i class="bi bi-trash-fill"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>

                                </tr>
                                <!-- $counter++; -->
                        <?php
                                $count++;
                            }
                        } else {
                            echo "0 results";
                        }
                        $conn->close();
                        ?>
                    </tbody>
                </table>

            </div>
            <br>
            <br>
        </main>

        <footer class="footer">
            <?php include './assets/footer.php'; ?>
        </footer>
    </div>

    <!-- Modal -->
    
    <script>
        function confirmAction() {
            // Display a confirmation dialog
            return confirm("Are you sure you want to delete this mail?");
        }
    </script>
    <!-- JavaScript -->

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
        function myFunction() {
            var x = document.getElementById("password");
            if (x.type === "password") {
                x.type = "text"
            } else {
                x.type = "password"
            }
        }
    </script>
    <script>
        // Initialize the tooltip on the button
        const myTooltipEl = document.getElementById('myTooltip');
        const tooltip = bootstrap.Tooltip.getOrCreateInstance(myTooltipEl);

        // Add event listener for when the tooltip is hidden
        myTooltipEl.addEventListener('hidden.bs.tooltip', () => {
            console.log("Tooltip is hidden");
            // You can do something here when the tooltip is hidden
        });

        // Hide the tooltip programmatically (optional)
        tooltip.hide();
    </script>


</body>

</html>