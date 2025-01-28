<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LogIn</title>
    <link rel="icon" type="image/x-icon" href="img/BP_Icon.png">
    <!-- <link rel="stylesheet" href="./bootstrap-5.3.3-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../bootstrap-5.3.3-dist/paper.css">
    <link rel="stylesheet" href="css/style.css"> -->
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
            font-family: 'Acumin Variable Concept', sans-serif !important;
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

        .box_log {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
            font-family: 'Acumin Variable Concept', sans-serif !important;

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
                <div class="d-flex justify-content-center">
                    <div class="col-4">
                        <div class="box_log">
                            <form action="./login_run.php" method="post" class="m-3">
                                <div class="mb-4">
                                    <input type="text" required class="form-control border border-black rounded inpu_pading" id="username" name="name" placeholder="Username" aria-label="username" aria-describedby="addon-wrapping">
                                </div>
                                <div class="mb-4" style="text-align: left;">
                                    <input type="password" required class="form-control border border-black rounded inpu_pading" id="password" name="password" autocomplete="off" placeholder="Password" aria-label="password" aria-describedby="addon-wrapping">
                                    <div class="d-flex align-items-center text-start mt-2">
                                        <input type="checkbox" id="showPassword" class="form-check-input border border-black" onclick="myFunction()">
                                        <label for="showPassword" class="text-black ms-2">Show Password</label>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-center">
                                    <button type="submit" name="submit" class="btn btn-primary col-6 rounded inpu_pading_btn">
                                        <span class="fw-bold">Submit</span>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                </div>
            </div>

        </main>

        <footer class="footer">
            <?php include './assets/footer.php'; ?>
        </footer>
    </div>
    <script>
        function myFunction() {
            var x = document.getElementById("password");
            if (x.type === "password") {
                x.type = "text";
            } else {
                x.type = "password";
            }
        }
    </script>
</body>

</html>