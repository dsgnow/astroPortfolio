<?php




use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require '../COMPOSER/vendor/autoload.php';
$email = new PHPMailer(TRUE);

require_once('tcpdf.php');

// include '../../connection.php';


// $name = mysqli_real_escape_string($conn, $_POST['form_name']);
// $emailSender = mysqli_real_escape_string($conn, $_POST['form_emailSender']);
// $message = mysqli_real_escape_string($conn, $_POST['form_message']);


           

          $mail = new PHPMailer(TRUE);

          //try {


             $mail->CharSet = 'UTF-8'; 
             
            
             $mail->setFrom('rekrutacjadsgnow@gmail.com');
             $mail->Username = "rekrutacjadsgnow@gmail.com";
             $mail->Password = "recrutnow";


             $mail->addAddress('rekrutacjadsgnow@gmail.com'); /*$emailSender*/
             $mail->Subject = 'Rekrutacja'; /*$name*/
             $mail->Body = 'Wiadomość'; /*$message*/
             $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->Port = 587;
            $mail->SMTPAuth = true;
            $mail->SMTPSecure = 'tls';
           
             /* Enable SMTP debug output. */
             $mail->SMTPDebug = 0;

           

            if($mail->send()) {
            echo "ok";
            } else {
            echo "error";
            }
         

   
















 
  








?>
