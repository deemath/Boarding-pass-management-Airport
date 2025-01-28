<?php
require '../scripts/phpmailer/PHPMailerAutoload.php';
// require '.\scripts\phpmailer\PHPMailerAutoload.php';

if (isset($_POST['sendmail'])) {
    $mail = new PHPMailer(true);

    // Send mail using Gmail
    //if($send_using_gmail){
    $mail->IsSMTP(); // telling the class to use SMTP

    //ADD BELOW LINES FROM HERE
    $mail->SMTPOptions = array(
        'ssl' => array(
            'verify_peer' => false,
            'verify_peer_name' => false,
            'allow_self_signed' => true
        )
    );

    // Retrieve form data
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $subject = filter_var($_POST['subject'], FILTER_SANITIZE_STRING);
    $fileSize = $_FILES['airline_report_lm']['size'];

    $mail->SMTPAuth = true; // enable SMTP authentication
    //  $mail->SMTPSecure = "ssl"; // sets the prefix to the servier
    $mail->Host = "mail.airport.lk"; // sets GMAIL as the SMTP server
    $mail->Port = 587; // set the SMTP port for the GMAIL server
    $mail->Username = "webadmin@airport.lk"; // GMAIL username
    $mail->Password = "ant@aasl"; // GMAIL password
    //}

    // Typical mail data
    $mail->addAddress($_POST['email']);
    $mail->SetFrom("webadmin@airport.lk", "webadmin");
    $mail->CharSet  = 'UTF-8';

    $mail->isHTML(true); // Set email format to HTML

    $mail->Subject = $subject;
    $mail->Body = $message;

    if (!empty($_FILES['file']['name'][0])) {
        foreach ($_FILES['file']['tmp_name'] as $key => $tmp_name) {
            $file_name = $_FILES['file']['name'][$key];
            $file_tmp = $_FILES['file']['tmp_name'][$key];
            $mail->addAttachment($file_tmp, $file_name);
        }
    }

    try {
        $mail->Send();

        // Database connection
        include "./conn.php";


        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Update mail_info in applicant table
        $updateQuery = "UPDATE applicant SET mail_info = 'Sent' WHERE applicant_id = ?";
        $stmt = $conn->prepare($updateQuery);
        $stmt->bind_param("s", $applicant_id);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            echo "<script type='text/javascript'>
                alert('Email Sent Successfully and Database Updated.');
                window.location.href ='./select_applicant.php';
                </script>";
        } else {
            echo "<script type='text/javascript'>
                alert('Email Sent Successfully but Database Update Failed.');
                window.location.href ='./select_applicant.php';
                </script>";
        }

        $stmt->close();
        $conn->close();
    } catch (Exception $e) {
        echo $e;
    }
}
?>
<script>
    // Function to update date and time
    function updateDateTime() {
        var now = new Date();
        var datetimeElement = document.getElementById('datetime');
        datetimeElement.innerHTML = now.toLocaleString();
    }

    // Update date and time every second
    setInterval(updateDateTime, 1000);

    // Initial call to display date and time
    updateDateTime();
</script>
</body>
</html>
