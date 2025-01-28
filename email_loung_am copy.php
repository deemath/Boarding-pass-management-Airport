<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/phpmailer/src/PHPMailer.php';
require __DIR__ . '/phpmailer/src/Exception.php';
require __DIR__ . '/phpmailer/src/SMTP.php';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $recipientEmail = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);

    if (!$recipientEmail) {
        echo "Invalid email address.";
        exit;
    }

    if (isset($_FILES['airline_report_lm']) && $_FILES['airline_report_lm']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['airline_report_lm']['tmp_name'];
        $fileName = basename($_FILES['airline_report_lm']['name']);
        $fileSize = $_FILES['airline_report_lm']['size'];
        $fileType = mime_content_type($fileTmpPath);

        // Validate file type (e.g., only allow PDF)
        if ($fileType !== 'application/pdf') {
            echo "Only PDF files are allowed.";
            exit;
        }

        // Validate file size (e.g., limit to 2MB)
        if ($fileSize > 2 * 1024 * 1024) {
            echo "File size exceeds the 2MB limit.";
            exit;
        }

        // Initialize PHPMailer
        $mail = new PHPMailer(true);

        try {
            // Server Settings
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'janidugaurinda2020@gmail.com'; // Use env variable in production
            $mail->Password   = 'lmdmmcbrpeshkofp'; // Use env variable in production
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = 587;

            // Recipients
            $mail->setFrom('ceylonparadise123@gmail.com', 'Airport');
            $mail->addReplyTo('ceylonparadise123@gmail.com', 'Airport');
            $mail->addAddress($recipientEmail);

            // Attach the file
            $mail->addAttachment($fileTmpPath, $fileName);

            // Email content
            $mail->isHTML(true);
            $mail->Subject = 'Airline Report';
            $mail->Body    = '<p>Please find the attached Airline Report PDF.</p>';

            // Send the email
            $mail->send();
            echo "Email sent successfully.";
        } catch (Exception $e) {
            echo "Failed to send email. Error: " . $mail->ErrorInfo;
        }
    } else {
        echo "Failed to upload file.";
    }
} else {
    echo "Invalid request.";
}
?>
