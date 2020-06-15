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


             $attachment = $pdf->Output('confirmation'.$numerZleceniaNew.'.pdf', 'S');
             $mail->CharSet = 'UTF-8'; 
             
            
             $mail->setFrom('zamowienia@a5print.pl', 'A5 Print');
             $mail->Username = "zamowienia@a5print.pl";
             $mail->Password = "Gadania5";

             $mail->addAddress('nades90@gmail.com'); /*$emailSender*/
             $mail->Subject = 'Rekrutacja'; /*$name*/
             $mail->Body = 'Wiadomość'; /*$message*/
             $mail->IsSMTP();
             $mail->Host = 's37.hekko.pl';
             $mail->Port = 587;
             $mail->SMTPAuth = true;
             $mail->SMTPSecure = 'tls';
           
             /* Enable SMTP debug output. */
             $mail->SMTPDebug = 0;

             $mail->UsernamePotw = "zamowienia@a5print.pl";
             $mail->PasswordPotw = "Gadania5";

            if($mail->send()) {
            echo "ok";
            } else {
            echo "error";
            }
         

   
















 
  








?>
