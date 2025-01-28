<?php
include "./db_conn.php";

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
    <title>Admin Dashboard</title>
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

        .row {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            /* Center columns horizontally */
            align-items: center;
            /* Center columns vertically */
            height: 100%;
            /* Make the row take the full height of the container */
        }

        .col-3 {
            display: flex;
            flex-direction: column;
            align-items: center;
            /* Center content horizontally */
            justify-content: center;
            /* Center content vertically */
            margin-bottom: 20px;
            /* Add margin to separate the rows */
        }

        .col-3 p {
            margin-top: 10px;
            /* Space between image and text */
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
                <div class="row justify-content-center my-2">
                    <div class="col-2 text-center mx-3">
                        <a href="barcode.php">
                            <img src="img/Scan.png" alt="Scan" class="img_dashbord">
                        </a>
                    </div>
                    <div class="col-2 text-center mx-3">
                        <a href="full_report.php">
                            <img src="img/Full_Report.png" alt="Full Report" class="img_dashbord">
                        </a>
                    </div>
                    <div class="col-2 text-center mx-3">
                        <a href="report.php">
                            <img src="img/Today_Report.png" alt="Today Report" class="img_dashbord">
                        </a>
                    </div>
                    <div class="col-2 text-center mx-3">
                        <a href="airline_report.php">
                            <img src="img/Airline_Report.png" alt="Airline report" class="img_dashbord">
                        </a>
                    </div>
                    <div class="col-2 text-center mx-3">
                        <a href="./user_create.php">
                            <img src="./img/Create User.png" alt="create user" class="img_dashbord">
                        </a>
                    </div>


                    <div class="container text-center" style="font-size: 24px;">
                        <div class="row">
                            <div class="col-2 mx-3 ">
                                Scan Barcode
                            </div>
                            <div class="col-2 mx-3">
                                Full Report
                            </div>
                            <div class="col-2 mx-3">
                                Today Report
                            </div>
                            <div class="col-2 mx-3">
                                Airline Report
                            </div>
                            <div class="col-2 mx-3">
                                Create User </div>
                        </div>
                    </div>

                </div>
            </div>
            <!-- <div class="container row">
                <div class="col-2 d-flex flex-column align-items-center mx-3" style="font-size: 24px;">
                    <a href="barcode.php" class="d-flex justify-content-center align-items-center" style="height: 100%;">
                        <img src="img/Scan.png" alt="Scan" class="img_dashbord">
                    </a>
                    <p style="padding-top: 90px;">Scan barcode</p>

                </div>
                <div class="col-2 text-center mx-3" style="font-size: 24px;">
                    <a href="full_report.php">
                        <img src="img/Full_Report.png" alt="Full Report" class="img_dashbord">
                    </a>
                    <p>Full Report</p>
                </div>
                <div class="col-2 text-center mx-3" style="font-size: 24px;">
                    <a href="report.php">
                        <img src="img/Today_Report.png" alt="Today Report" class="img_dashbord">
                    </a>
                    <p style="padding-top: 82px;">Today Report</p>
                </div>
                <div class="col-2 text-center mx-3" style="font-size: 24px;">
                    <a href="airline_report.php">
                        <img src="img/Airline_Report.png" alt="Airline report" class="img_dashbord">
                    </a>
                    <p> Airline Report
                    </p>
                </div>
                <div class="col-2 text-center mx-3" style="font-size: 24px;">
                    <a href="./user_create.php">
                        <img src="img/Airline_Report.png" alt="Airline report" class="img_dashbord">
                    </a>
                    <p>Create User
                    </p>
                </div>
            </div> -->

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