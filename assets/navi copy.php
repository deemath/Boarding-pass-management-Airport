<!DOCTYPE html>
<html lang="en">  

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Navigation Bar</title>
    <link rel="stylesheet" href="../bootstrap-5.3.3-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <!-- notification icon  -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

    <style>
        @font-face {
            font-family: 'Acumin Variable Concept';
            src: url('../assets/font/AcuminVariableConcept-WideExtraLight.ttf');
        }

        .navbar {
            background: #000; /* Black background color */
            font-family: 'Acumin Variable Concept', sans-serif;
            text-transform: uppercase;
            font-weight: lighter; 
            font-size: larger;
        }

        .navbar-nav .nav-link {
            color: white !important;
        }

        .vl {
            border-left: 1px solid white;
            height: 80px;
            align-self: center;
        }

        .ms-auto {
            margin-left: auto !important;
        }

        .sizeicon {
            font-size: 50px;
            align-self: center;
        }

        .Administrator {
            font-family: 'Acumin Variable Concept', sans-serif !important;
            text-transform: capitalize !important;
            font-weight: initial !important;
            font-size: medium !important;
            padding: 0;
            margin: 0;
            align-self: center;
        }

        .nav-item-center {
            display: flex;
            align-items: center;
        }

        .navbar-toggler {
            border: none;
        }

        .navbar-toggler:focus {
            outline: none;
        }

        .img-icon {
            width: 50px; /* Adjust width as needed */
            height: 50px; /* Adjust height as needed */
            margin-left: 5px; /* Adjust margin as needed */
        }

        .datetime-container {
            display: flex;
            flex-direction: column;
            align-items: right;
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <!-- <a class="nav-link" aria-current="page" href=""> <img src="img/BP_Icon.png" alt="Logo" width="70" height="70" class="d-inline-block align-text-top"> </a> -->
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                       <a class="nav-link" href="index.php"><img src="img/BP_Header.png" alt="BP_Header" class="img_dashbord"></a>
                    </li>
                </ul> 

                <ul class="navbar-nav ms-auto">
                    

                    <!-- Container for date and time -->
                    <li class="nav-item nav-item-center ps-2 datetime-container">
                    <span id="date" class="text-white" style="font-size: 24px;"></span>
                    <span id="time" class="text-white" style="font-size: 34px;"></span>
                    </li>

                    <li class="nav-item nav-item-center ps-2">
                        <div class="vl"></div>
                    </li>

                    <li class="nav-item nav-item-center ps-2">
                       <img src="img/Admin.png" alt="UN Icon" class="img-icon">
                    </li>
                </ul>
            </div>
        </div>
    </nav>



    
    <script defer src="./bootstrap-5.3.3-dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function logout() {
            return confirm("Are you sure you want to log out?");
        }

        // Function to get the current date and time
        function updateDateTime() {
            const now = new Date();
            const dateOptions = {
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            };
            const timeOptions = {
                hour: '2-digit',
                minute: '2-digit',
                // second: '2-digit'
            };
            document.getElementById('date').innerHTML = now.toLocaleDateString('en-US', dateOptions);
            document.getElementById('time').innerHTML = now.toLocaleTimeString('en-US', timeOptions);
        }

        // Update the date and time every second
        setInterval(updateDateTime, 1000);

        // Initial call to display date and time immediately on page load
        updateDateTime();
    </script>
</body>

</html>
