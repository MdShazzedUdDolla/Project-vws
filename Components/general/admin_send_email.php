<?php
use PHPMailer\PHPMailer\PHPMailer; 
use PHPMailer\PHPMailer\Exception; 
use PHPMailer\PHPMailer\SMTP; 
//whether ip is from the share internet
function sendEmail($email, $username){

if(empty($email)){
    return "Email is empty";
}

$ip = '';

if(!empty($_SERVER['HTTP_CLIENT_IP'])) {
$ip = $_SERVER['HTTP_CLIENT_IP'];
}
//whether ip is from the proxy
elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
}
//whether ip is from the remote address
else{
$ip = $_SERVER['REMOTE_ADDR'];
}

echo 'User Real IP Address - '.$ip;

//This is required for php mailer v6
require "../../Assets/vendor/autoload.php";

$mail = new PHPMailer(true); 
$mail->isSMTP();
try { 
  //Taken straight from the readme, except using a gmail smtp server to send the email
    $mail->SMTPDebug = 0;  
    $mail->Mailer='smtp';                                      
    $mail->isSMTP();                                             
    $mail->Host       = 'smtp.gmail.com';                     
    $mail->SMTPAuth   = true;                              
    $mail->Username   = 'virtualwellnesssystem@gmail.com';                  
    $mail->Password   = 'iklalemiucmyvhgj';                         
    $mail->SMTPSecure = 'tls';                               
    $mail->Port       = '587';   
    $mail->IsHTML(TRUE);
    $mail->setFrom('virtualwellnesssystem@gmail.com', 'VWS');
    // console_log($email);
    $mail->addAddress($email);            
   //if you get ssl errors uncomment this and try again
   $mail->SMTPOptions = array(
    'ssl' => array(
    'verify_peer' => false,
    'verify_peer_name' => false,
    'allow_self_signed' => true
    )
    );
    $mail->Subject = 'User Privileges Changed'; 
    $mail->Body    = 'Privileges have been changed, user making the changes was ' . $username . ' with IP address ' . $ip;
    $mail->AltBody = 'Privileges have changed'; 
    $mail->send(); 
  } catch (Exception $e) { 
    //echo "<script>alert('I am here');</script";
    $errorMessage = "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    header("location: register.php?error=" . urlencode($errorMessage) . "?mail=" . urlencode($email));
    //echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}"; 
  } 
}

?>