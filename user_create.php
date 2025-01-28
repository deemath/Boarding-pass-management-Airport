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
    <title>Users Details</title>
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
                    <h2><b>All User Deatails</b></h2>
                    <a href="./create_new_user.php" class="btn btn-primary">Create New User</a>
                </div>
                <br>
                <table id='example' class='table table-striped cell-border text-center' style='width:100%'>
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Name</th>
                            <th>Display Name</th>
                            <th>Email</th>
                            <th>Phone Number</th>
                            <th>User Type</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody class='table-group-divider'>

                        <tr>
                            <?php

                            $sql = "SELECT * FROM user";
                            $result = $conn->query($sql);

                            if ($result->num_rows > 0) {
                                // output data of each row
                                $count = 1;
                                while ($row = $result->fetch_assoc()) {
                            ?>
                                    <td><?php echo $count ?></td>
                                    <td><?php echo $row["name"] ?></td>
                                    <td><?php echo $row["displayName"] ?></td>
                                    <td><?php echo $row["email"] ?></td>
                                    <td><?php echo $row["tele"] ?></td>
                                    <td><?php echo $row["user_type"] ?></td>
                                    <td class="row">
                                        <div class="d-flex justify-content-center">
                                            <form method="post" class="col" action="./view_user.php">
                                                <input type="hidden" name="user_id" value="<?php echo $row["user_id"] ?>">
                                                <button type="submit" class="btn btn-primary btn-sm" id="myTooltip" data-bs-toggle="tooltip" data-bs-placement="top" title="View and Update User">
                                                    <i class="bi bi-eye-fill"></i>
                                                </button>
                                            </form>
                                            <form method="post" class="col" action="./delete_user_run.php" onsubmit="return confirmAction()">
                                                <input type="hidden" name="user_id" value="<?php echo $row['user_id']; ?>">
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
    <script>
        function confirmAction() {
            // Display a confirmation dialog
            return confirm("Are you sure you want to delete this user?");
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