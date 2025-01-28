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
    <title>Create New Airline Email</title>
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
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
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
                    <h2><b>Create New Airline Email</b></h2>
                    <a href="./airline_email.php" class="btn btn-primary">Go Back Page</a>
                </div>
                <br>
                <br>
                <form action="./airlines_email_add_run.php" method="post" id="">
                    <div class="box_log rounded-3">
                        <div class="row p-1">
                            <div class="col-6">
                                <div class="mb-1">
                                    <label for="exampleFormControlInput1" class="form-label">Select Airline</label>
                                    <select class="form-select border border-black" name="IATA" id="IATA" required>
                                        <option value="">Choose</option>
                                        <?php
                                        $sql = "SELECT * FROM airlines_details ORDER BY AirlineName ASC";
                                        $result = $conn->query($sql);
                                        if ($result && $result->num_rows > 0) {// Populate dropdown with card details
                                            while ($row = $result->fetch_assoc()) {
                                                echo '<option value="' . htmlspecialchars($row["IATA"]) . '">' . htmlspecialchars($row["AirlineName"]) . '</option>';
                                            }
                                        } else {// Show a default "No cards available" message if no results
                                            echo '<option value="">No cards available</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>

                            <div class="col-6">
                                <div class="mb-3">
                                    <div class="row d-flex justify-content-between align-items-center">
                                        <label for="exampleFormControlInput1" class="form-label col-auto">Email</label>
                                        <span class="error col-auto text-right text-danger" id="airline_emailError"></span>
                                    </div>
                                    <input type="email" class="form-control border border-black " required id="airline_email" name="airline_email">
                                </div>
                            </div>

                        </div>
                        <div class="d-flex justify-content-center ">
                            <button type="submit" class="btn btn-primary mb-3">SUBMIT</button>
                        </div>
                    </div>
                </form>
                <br>
                

            </div>
            <br>
            <br>
        </main>



        <footer class="footer">
            <?php include './assets/footer.php'; ?>
        </footer>
    </div>

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

    </script>
    <script>
        document.getElementById("airine_mail").addEventListener("submit", function(event) {
            event.preventDefault(); // Prevent form submission

            // Clear previous error messages
            clearErrors();

            let isValid = true; // Flag to track validation status

            // Validate name
            const name = document.getElementById("name").value.trim();
            if (name === "") {
                showError("nameError", "Name is required.");
                isValid = false;
            }

            // Validate displayName
            const displayName = document.getElementById("displayName").value.trim();
            if (displayName === "") {
                showError("displayNameError", "Display Name is required.");
                isValid = false;
            }

            // Validate phone number (tele)
            const tele = document.getElementById("tele").value.trim();
            if (tele === "") {
                showError("teleError", "Phone number is required.");
                isValid = false;
            }

            // Validate email
            const email = document.getElementById("email").value.trim();
            const emailPattern = /^[^\s@]+@[^\s@]/; // Simple email pattern
            if (email === "") {
                showError("emailError", "Email is required.");
                isValid = false;
            } else if (!emailPattern.test(email)) {
                showError("emailError", "Please enter a valid email.");
                isValid = false;
            }

            // Validate password
            const password = document.getElementById("password").value;
            if (password.length < 3) {
                showError("passwordError", "Password must be at least 3 characters long.");
                isValid = false;
            }

            // If form is valid, submit the form
            if (isValid) {
                document.getElementById("create_user").submit(); // Submit the form if validation passes
            }
        });

        // Function to display error messages
        function showError(errorId, message) {
            const errorElement = document.getElementById(errorId);
            errorElement.textContent = message;
        }

        // Function to clear error messages
        function clearErrors() {
            const errorElements = document.querySelectorAll('.error');
            errorElements.forEach(element => {
                element.textContent = '';
            });
        }
    </script>

</body>

</html>