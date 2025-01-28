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
    <title>Scan Barcode</title>
    <link rel="icon" type="image/x-icon" href="img/BP_Icon.png">
    <!-- <link rel="stylesheet" href="css/style.css"> -->
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
            <div class="container" style="margin-top: 1px; margin-bottom: 35px;">
                <?php
                if (isset($_GET['status']) && isset($_GET['message'])) {
                    $status = $_GET['status'];
                    $message = $_GET['message'];

                    if ($status === 'success') {
                        echo '<div class="alert alert-success" role="alert">'  . "<i class='bi bi-check-circle-fill'></i> <span class='pe-4 font-monospace'> ". htmlspecialchars($message) . '</span></div>';
                    } elseif ($status === 'error') {
                        echo '<div class="alert alert-danger" role="alert">' . "<i class='bi bi-x-circle-fill'></i> <span class='pe-4 font-monospace'> ". htmlspecialchars($message) . '</span></div>';
                    }
                }
                ?>
                <form action="process_barcode.php" method="post"
                    style="background: white; padding: 20px; border-radius: 10px; box-shadow: 0 0 10px rgba(0,0,0,0.1);">
                    <div style="margin-bottom: 15px;">
                        <label for="barcode" style="display: block; margin-bottom: 5px; font-weight: bold;">Enter
                            Barcode:</label>
                        <input type="text" id="barcode" name="barcode" autofocus required
                            style="width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px;">
                    </div>
                    <div class="row">
                        <div class="col d-flex align-items-center justify-content-start gap-1 form-check ms-3">
                            <input class="form-check-input border border-secondary" type="checkbox" id="Vcard" name="Vcard" value="" onclick="ShowdropCard()">
                            <label class="form-label mb-0" for="Vcard">Invitation Card</label>

                            <select class="form-select border border-secondary" name="vcard_d" id="vcard_d" style="width: auto; display: none;">
                                <option value="">Choose</option>
                                <?php
                                // Run the query to get card details
                                $sql = "SELECT * FROM card_details";
                                $result = $conn->query($sql);

                                if ($result && $result->num_rows > 0) {
                                    // Populate dropdown with card details
                                    while ($row = $result->fetch_assoc()) {
                                        echo '<option value="' . htmlspecialchars($row["card_name"]) . '">' . htmlspecialchars($row["card_name"]) . '</option>';
                                    }
                                } else {
                                    // Show a default "No cards available" message if no results
                                    echo '<option value="">No cards available</option>';
                                }

                                $conn->close();
                                ?>
                            </select>

                        </div>
                        <div class="col d-flex align-items-center justify-content-end gap-1 form-check ms-3">
                            <button type="submit"
                                style="background: #4CAF50; color: white; padding: 10px 15px; border: none; border-radius: 5px; cursor: pointer;">Submit</button>
                            <a href="./add_reservation.php" class="link-offset-2 link-underline link-underline-opacity-0"
                                style="background: #3659a4; color: white; padding: 10px 15px; border: none; border-radius: 5px; cursor: pointer; margin-left: 10px;">Manual Reservation</a>
                            <?php
                            // Check if the user type is set in the session
                            $userType = isset($_SESSION['USER_TYPE']) ? $_SESSION['USER_TYPE'] : '';

                            // Determine the appropriate link based on the user type
                            $link = './user_dashboard.php'; // Default link

                            if ($userType === 'Admin') {
                                $link = './admin_dashboard.php'; // Link for Admin
                            } elseif ($userType === 'User') {
                                $link = './user_dashboard.php'; // Link for User
                            }
                            ?>
                            <button type="button"
                                onclick="window.location.href='<?php echo $link; ?>'"
                                style="background: #f44336; color: white; padding: 10px 15px; border: none; border-radius: 5px; cursor: pointer; margin-left: 10px;">
                                Back To Main Menu
                            </button>
                        </div>
                    </div>
                </form>
            </div>
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
    <script>
        function ShowdropCard() {
            // Get the checkbox
            var checkBox = document.getElementById("Vcard");
            // Get the dropdown
            var select = document.getElementById("vcard_d");

            if (checkBox.checked) {
                select.style.display = "block";
                select.required = true;
            } else {
                select.style.display = "none";
                select.required = false;
                select.value = "Airlines"; // Ensure to reset to the "Choose..." option
            }
        }
    </script>

</body>

</html>