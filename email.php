<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require './vendor/autoload.php'; 



if (isset($_POST['sendmail'])) {
    // Instantiate PHPMailer
    $mail = new PHPMailer(true);
       $mail->IsSMTP(); // telling the class to use SMTP
         
     $mail->SMTPOptions = array(
                        'ssl' => array(
                            'verify_peer' => false,
                            'verify_peer_name' => false,
                            'allow_self_signed' => true
                            )
    );

    try {
      
        $mail->SMTPAuth = true;
        $mail->Host = 'mail.airport.lk'; // Set the SMTP server to send through
        $mail->SMTPAuth = true; // Enable SMTP authentication
        $mail->Username = 'webadmin@airport.lk'; // SMTP username
        $mail->Password = 'ant@aasl'; // SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Enable TLS encryption
        $mail->Port = 587; // TCP port to connect to

        
        //check if multile emails or one
        $emailList = $_POST['email'];
        
        $emailArray = explode(";", $emailList);
       foreach ($emailArray as $email => $name) {          
            $mail->AddAddress($name, ''); 
        }
        
        
        
        // Recipients
        $mail->setFrom('webadmin@airport.lk', 'Webadmin');
      //  $mail->addAddress($emailArray); 
        
        // CC addresses
       $cc = array(
            'janindu.it@airport.lk' => 'janindu',
            // 'lounge.am@airport.lk' => 'lounge.am',
            'aaslitse@gmail.com' => 'aaslitse'
        );

        // Add CC recipients
        foreach ($cc as $email => $name) {
            $mail->addCC($email, $name); // Use addCC
        }
        
      //  $mail->addCC('dil116@gmail.com', 'dd');
        // Subject and body
        $subject = htmlspecialchars($_POST['subject']);
        $message = htmlspecialchars($_POST['message']);
        $mail->Subject = $subject;
        $mail->Body    = $message;
        
 
        
        

        // Attachments
        if (!empty($_FILES['file']['name'][0])) {
            foreach ($_FILES['file']['tmp_name'] as $key => $tmp_name) {
                $file_name = $_FILES['file']['name'][$key];
                $file_tmp = $_FILES['file']['tmp_name'][$key];
                $mail->addAttachment($file_tmp, $file_name);
            }
        }

        // Send the email
        $mail->send();
     
        echo "<script type='text/javascript'>
                alert('Email Sent Successfully..');
                window.location.href ='airline_report.php';
              </script>";
      
        
    } catch (Exception $e) {
       
        echo "<script type='text/javascript'>
                alert('Email could not be sent. Mailer Error: {$mail->ErrorInfo}');
                window.location.href ='airline_report.php';
              </script>";
    }
}
?>
