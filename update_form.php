<?php
include 'db_conn.php';

// Create a database connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Update logic
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $passenger_name = $_POST['passenger_name'];
    $from_city_code = $_POST['from_city_code'];
    $to_city_code = $_POST['to_city_code'];
    $flight_number = $_POST['flight_number'];
    $date_of_flight = $_POST['date_of_flight'];
    $seat_number = $_POST['seat_number'];
    $no_of_iv = $_POST['no_of_iv']; // New field for NO of IV
    $no_of_pax = $_POST['no_of_pax']; // New field for NO of pax

    $sql = "UPDATE passengerdetails SET 
                passenger_name='$passenger_name', 
                from_city_code='$from_city_code', 
                to_city_code='$to_city_code', 
                flight_number='$flight_number', 
                date_of_flight='$date_of_flight', 
                seat_number='$seat_number',
                no_of_iv='$no_of_iv', 
                no_of_pax='$no_of_pax' 
            WHERE id='$id'";

    if ($conn->query($sql) === TRUE) {
        
        echo '<script>alert("Record updated successfully!"); window.location.href = "index.php";</script>';
       
    } else {
        echo "Error updating record: " . $conn->error;
    }
}




// Fetch the record to be updated
$row = null;
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM passengerdetails WHERE id='$id'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        echo "No record found";
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en"> 

<head>  
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>index page</title>
    <link rel="stylesheet" href="./bootstrap-5.3.3-dist/css/bootstrap.min.css">
    <link rel="icon" type="image/x-icon" href="img/BP_Icon.png">
    <link rel="stylesheet" href="../bootstrap-5.3.3-dist/paper.css">
    <style>
        @font-face { 
            font-family: 'Acumin Variable Concept';
            src: url('./assets/font/AcuminVariableConcept-WideExtraLight.ttf');
        }
 
        html,
        body {
            background: #ECF0F1; /* off white background color */
            height: 100%;
            margin: 0;
            padding: 0;
            font-family: 'Acumin Variable Concept', sans-serif;
            overflow-y: hidden; /* Prevent scrolling of the entire page */
        }

        .page {
            display: flex;
            flex-direction: column; 
            height: 100vh; /* Full viewport height */
            position: relative;
            overflow-y: auto; /* Enable scrolling within .page if content exceeds viewport height */
        }

        .content {
            flex: 1; /* Adjust to occupy remaining space */
            display: flex;
            flex-direction: column;
            align-items: center; /* Center content horizontally */
            justify-content: center; /* Center content vertically */
        }

        .img_dashbord {
            height: auto; /* Adjust image height */
            max-width: 80%; /* Ensure images don't exceed container width */
        }

        .para_text_ {
            font-size: 15px;
        }




        .col {
            flex: 1 1 150px; /* Allow columns to grow and shrink */
            max-width: 250px; /* Set a maximum width for columns */
            display: flex;
            justify-content: center; /* Center content horizontally */
            align-items: center; /* Center content vertically */
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
                <div class="form-container">
                    <h2><b>Update Passenger Details</b></h2>
                    <?php if ($row): ?>
                    <form action="" method="post">
                        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                        <div class="mb-3">
                            <label for="passenger_name" class="form-label">Passenger Name</label>
                            <input type="text" class="form-control" id="passenger_name" name="passenger_name" value="<?php echo $row['passenger_name']; ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="from_city_code" class="form-label">From City Airport Code</label>
                            <input type="text" class="form-control" id="from_city_code" name="from_city_code" value="<?php echo $row['from_city_code']; ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="to_city_code" class="form-label">To City Airport Code</label>
                            <input type="text" class="form-control" id="to_city_code" name="to_city_code" value="<?php echo $row['to_city_code']; ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="flight_number" class="form-label">Flight Number</label>
                            <input type="text" class="form-control" id="flight_number" name="flight_number" value="<?php echo $row['flight_number']; ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="date_of_flight" class="form-label">Date of Flight</label>
                            <input type="date" class="form-control" id="date_of_flight" name="date_of_flight" value="<?php echo $row['date_of_flight']; ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="seat_number" class="form-label">Seat Number</label>
                            <input type="text" class="form-control" id="seat_number" name="seat_number" value="<?php echo $row['seat_number']; ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="no_of_iv" class="form-label">NO of IV</label>
                            <input type="text" class="form-control" id="no_of_iv" name="no_of_iv" value="<?php echo $row['no_of_iv']; ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="no_of_pax" class="form-label">NO of pax</label>
                            <input type="text" class="form-control" id="no_of_pax" name="no_of_pax" value="<?php echo $row['no_of_pax']; ?>" required>
                        </div>
                        <button type="submit" name="update" class="btn btn-primary">Update</button>
                    </form>
                    <?php else: ?>
                    <p>No record found to update.</p>
                    <?php endif; ?>
                </div>
            </div>
            
        </main>

        <footer class="footer">
            <?php include './assets/footer.php'; ?>
        </footer>
</div>
  
   
</body>
</html> 