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
$currentDate = date('Y-m-d'); // Current date in YYYY-MM-DD format
$nextDate = date('Y-m-d', strtotime('+1 day')); // Next date (+1 day)
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Manual Reservation</title>
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
                    <h2><b>Add Manual Reservation</b></h2>
                    <a href="./barcode.php" class="btn btn-primary">Go Back Page</a>
                </div>
                <br>
                <form action="./add_reservation_run.php" method="post" id="add_reservation">
                    <div class="box_log rounded-3">
                        <div class="row p-1">
                            <div class="col-6">
                                <div class="mb-3">
                                    <div class="row d-flex justify-content-between align-items-center">
                                        <label for="passenger_name" class="form-label col-auto">Passenger Name</label>
                                        <span class="error col-auto text-right text-danger" id="passenger_nameError"></span>
                                    </div>
                                    <input type="text" class="form-control border border-black " id="passenger_name" name="passenger_name">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mb-3">
                                    <div class="row d-flex justify-content-between align-items-center">
                                        <label for="flight_number" class="form-label  col-auto">Flight number</label>
                                        <span class="error col-auto text-right text-danger" id="flight_numberError"></span>
                                    </div>
                                    <input type="text" class="form-control border border-black " id="flight_number" name="flight_number">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mb-3">
                                    <div class="row d-flex justify-content-between align-items-center">
                                        <label for="from_city_code" class="form-label col-auto">From city code</label>
                                        <span class="error col-auto text-right text-danger" id="from_city_codeError"></span>
                                    </div>
                                    <input type="text" class="form-control border border-black " id="from_city_code" name="from_city_code">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mb-3">
                                    <div class="row d-flex justify-content-between align-items-center">
                                        <label for="to_city_code" class="form-label col-auto">To city code</label>
                                        <span class="error col-auto text-right text-danger" id="to_city_codeError"></span>
                                    </div>
                                    <input type="text" class="form-control border border-black " id="to_city_code" name="to_city_code">
                                </div>
                            </div>

                            <div class="col-6">
                                <div class="mb-3">
                                    <div class="row d-flex justify-content-between align-items-center">
                                        <label for="date_of_flight" class="form-label  col-auto">Date of flight</label>
                                        <span class="error col-auto text-right text-danger" id="date_of_flightError"></span>
                                    </div>
                                    <select id="date_of_flight" name="date_of_flight" class="form-select border border-black">
                                        <option value="<?php echo $currentDate; ?>"><?php echo $currentDate; ?></option>
                                        <option value="<?php echo $nextDate; ?>"><?php echo $nextDate; ?></option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mb-3">
                                    <div class="row d-flex justify-content-between align-items-center">
                                        <label for="seat_number" class="form-label  col-auto">Seat Number</label>
                                        <span class="error col-auto text-right text-danger" id="seat_numberError"></span>
                                    </div>
                                    <input type="text" class="form-control border border-black " id="seat_number" name="seat_number">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mb-3">
                                    <div class="row d-flex justify-content-between align-items-center">
                                        <label for="airline_numeric_code" class="form-label  col-auto">Airline numeric code</label>
                                        <span class="error col-auto text-right text-danger" id="airline_numeric_codeError"></span>
                                    </div>
                                    <input type="text" class="form-control border border-black " id="airline_numeric_code" name="airline_numeric_code">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mb-3">
                                    <div class="row d-flex justify-content-between align-items-center">
                                        <label for="no_of_iv" class="form-label  col-auto">No of iv</label>
                                        <span class="error col-auto text-right text-danger" id="no_of_ivError"></span>
                                    </div>
                                    <input type="text" class="form-control border border-black " id="no_of_iv" name="no_of_iv">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mb-3">
                                    <div class="row d-flex justify-content-between align-items-center">
                                        <label for="no_of_pax" class="form-label  col-auto">No of pax</label>
                                        <span class="error col-auto text-right text-danger" id="no_of_paxError"></span>
                                    </div>
                                    <input type="text" class="form-control border border-black " id="no_of_pax" name="no_of_pax">
                                </div>
                            </div>

                            <div class="col-6">
                                <div class="mb-1">
                                    <label for="exampleFormControlInput1" class="form-label">Card</label>
                                    <select class="form-select border border-black" name="vcard_d" id="vcard_d">
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
                            </div>
                            <div class="col-12">
                                <div class="mb-3">
                                    <div class="row d-flex justify-content-between align-items-center">
                                        <label for="remarks" class="form-label  col-auto">Remarks</label>
                                    </div>
                                    <textarea class="form-control order border-black" maxlength="485" id="remarks" name="remarks"></textarea>
                                    <!-- <span class="col-auto text-right " id="">word limit 485</span> -->
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-center ">
                            <button type="submit" class="btn btn-primary mb-3">SUBMIT</button>
                        </div>
                    </div>
                </form>
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
        document.getElementById("add_reservation").addEventListener("submit", function(event) {
            event.preventDefault(); // Prevent form submission

            // Clear previous error messages
            clearErrors();

            let isValid = true; // Flag to track validation status

            // Validate name
            const passenger_name = document.getElementById("passenger_name").value.trim();
            if (passenger_name === "") {
                showError("passenger_nameError", "Passenger Name is required.");
                isValid = false;
            } // Check if the name contains any non-alphanumeric characters
            else if (/[^a-zA-Z0-9 ]/.test(passenger_name)) {
                showError("passenger_nameError", "Only letters and numbers allowed.");
                isValid = false;
            }

            // Validate to_city_code
            const from_city_code = document.getElementById("from_city_code").value.trim();
            if (from_city_code === "") {
                showError("from_city_codeError", "From city code is required.");
                isValid = false;
            } // Check if the name contains any non-alphanumeric characters
            else if (/[^a-zA-Z0-9 ]/.test(from_city_code)) {
                showError("from_city_codeError", "Only letters and numbers allowed.");
                isValid = false;
            }

            // Validate  (to_city_code)
            const to_city_code = document.getElementById("to_city_code").value.trim();
            if (to_city_code === "") {
                showError("to_city_codeError", "To city code is required.");
                isValid = false;
            } // Check if the name contains any non-alphanumeric characters
            else if (/[^a-zA-Z0-9 ]/.test(to_city_code)) {
                showError("to_city_codeError", "Only letters and numbers allowed.");
                isValid = false;
            }

            // Validate  (flight_number)
            const flight_number = document.getElementById("flight_number").value.trim();
            if (flight_number === "") {
                showError("flight_numberError", "Flight number is required.");
                isValid = false;
            } // Check if the name contains any non-alphanumeric characters
            else if (/[^a-zA-Z0-9 ]/.test(flight_number)) {
                showError("flight_numberError", "Only letters and numbers allowed.");
                isValid = false;
            }

            // Validate  (date_of_flight)
            const date_of_flight = document.getElementById("date_of_flight").value.trim();
            if (date_of_flight === "") {
                showError("date_of_flightError", "To city code is required.");
                isValid = false;
            } // Check if the name contains any non-alphanumeric characters
            // else if (/[^a-zA-Z0-9]/.test(date_of_flight)) {
            //     showError("date_of_flightError", "Only letters and numbers allowed.");
            //     isValid = false;
            // }
            // Validate  (seat_number)
            const seat_number = document.getElementById("seat_number").value.trim();
            if (seat_number === "") {
                showError("seat_numberError", "Seat number is required.");
                isValid = false;
            } // Check if the name contains any non-alphanumeric characters
            else if (/[^a-zA-Z0-9 ]/.test(seat_number)) {
                showError("seat_numberError", "Only letters and numbers allowed.");
                isValid = false;
            }
            // Validate  (airline_numeric_code)
            const airline_numeric_code = document.getElementById("airline_numeric_code").value.trim();
            if (airline_numeric_code === "") {
                showError("airline_numeric_codeError", "Airline numeric is required.");
                isValid = false;
            } // Check if the name contains any non-alphanumeric characters
            else if (/0-9]/.test(airline_numeric_code)) {
                showError("airline_numeric_codeError", "Only numbers allowed.");
                isValid = false;
            }
            // Validate  (no_of_iv)
            const no_of_iv = document.getElementById("no_of_iv").value.trim();
            if (no_of_iv === "") {
                showError("no_of_ivError", "No of iv is required.");
                isValid = false;
            } // Check if the name contains any non-alphanumeric characters
            else if (/[^0-9]/.test(no_of_iv)) {
                showError("no_of_ivError", "Only numbers allowed.");
                isValid = false;
            }
            // Validate  (no_of_pax)
            const no_of_pax = document.getElementById("no_of_pax").value.trim();
            if (no_of_pax === "") {
                showError("no_of_paxError", "No of pax is required.");
                isValid = false;
            } // Check if the name contains any non-alphanumeric characters
            else if (/[^0-9]/.test(no_of_pax)) {
                showError("no_of_paxError", "Only numbers allowed.");
                isValid = false;
            }

            // If form is valid, submit the form
            if (isValid) {
                document.getElementById("add_reservation").submit(); // Submit the form if validation passes
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