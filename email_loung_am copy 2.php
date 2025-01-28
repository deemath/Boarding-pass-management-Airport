<?php
require '../scripts/phpmailer/PHPMailerAutoload.php';

if (isset($_POST['sendmail'])) {
    $mail = new PHPMailer(true);

    // Configure SMTP
    $mail->IsSMTP();
    $mail->SMTPOptions = array(
        'ssl' => array(
            'verify_peer' => false,
            'verify_peer_name' => false,
            'allow_self_signed' => true
        )
    );
    $mail->SMTPAuth = true;
    $mail->Host = "mail.airport.lk";
    $mail->Port = 587;
    $mail->Username = "webadmin@airport.lk";
    $mail->Password = "ant@aasl";
    
    // Set email details
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $subject = filter_var($_POST['subject'], FILTER_SANITIZE_STRING);
    $message = filter_var($_POST['message'], FILTER_SANITIZE_STRING); // Add this field in your form

    $mail->addAddress($email);
    $mail->SetFrom("webadmin@airport.lk", "webadmin");
    $mail->CharSet = 'UTF-8';
    $mail->isHTML(true);
    $mail->Subject = $subject;
    // $mail->Body = $message;

    // Handle file attachments
    if (!empty($_FILES['airline_report_lm']['name'][0])) {
        foreach ($_FILES['airline_report_lm']['tmp_name'] as $key => $tmp_name) {
            $file_name = $_FILES['airline_report_lm']['name'][$key];
            $file_tmp = $_FILES['airline_report_lm']['tmp_name'][$key];
            $mail->addAttachment($file_tmp, $file_name);
        }
    }

    try {
        if ($mail->Send()) {
            // Database update (optional)
            // include "./conn.php";
            // $updateQuery = "UPDATE applicant SET mail_info = 'Sent' WHERE applicant_id = ?";
            // $stmt = $conn->prepare($updateQuery);
            // $stmt->bind_param("s", $applicant_id);
            // $stmt->execute();

            // Provide appropriate feedback
            echo "<script>
                    alert('Email Sent Successfully.');
                    window.location.href = 'airline_passenger.php';
                  </script>";
        } else {
            echo "<script>
                    alert('Failed to send email.');
                    window.location.href = 'airline_passenger.php';
                  </script>";
        }
    } catch (Exception $e) {
        echo "<script>
                alert('Mailer Error: {$e->getMessage()}');
                window.location.href = 'airline_passenger.php';
              </script>";
    }
}
?>
