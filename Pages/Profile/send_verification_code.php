<?php 
include_once "../../API/Database/config.php";
include_once "../../API/Database/security/encKey.php";
include_once "../../API/Database/security/Cryptor.php";
use PHPMailer\PHPMailer\PHPMailer; 
use PHPMailer\PHPMailer\Exception; 
use PHPMailer\PHPMailer\SMTP; 


function send_verification($code){

  // console_log("This is the code in send_verification_code " . $code);



//Using PHPMailer to send a password reset request
//Taken straight from the readme

  
//This is required for php mailer v6
require "../../Assets/vendor/autoload.php";
//or search database for username when we are redirected from sign in without verification
if (isset($_SESSION['email'])) {
  $email = $_SESSION['email'];
} else {
  $conn = startConnection();
  $user_auto_key = $_SESSION['user_auto_key'];
  $sql = "SELECT email FROM user WHERE usr_auto_key = ?";
  $result = SafeRunSelect($conn, $sql, [$user_auto_key]);
  if($result!=null){
    $encryption_key = getKey();
    $cipher_method = 'aes-256-cfb';
    $cryptor = new Cryptor($encryption_key, $cipher_method);
    
    while ($row = $result->fetch_assoc()) {
      $email = $cryptor->decrypt($row['email']);
    }
 
    closeConnection($conn);
}


}
//echo $email;
// console_log("This is in send_verification_code " . $email);

$mail = new PHPMailer(true); 
$mail->isSMTP();
//$link = startConnection();



/*
$query = "SELECT email FROM user WHERE username = ?";
                    $stm = $link->prepare($query);
                    $stm->bind_param("s", $username);
                    $stm->execute();
                    $result = $stm->get_result();
*/
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


    //Passing the temporary password information into a separate database table

    $mail->Subject = 'Verification Number'; 
    //This will be a problem, the link will work on my local machine but will not with yours need to figure out a way to construct a proper link
    $mail->Body    = "Your passcode is: $code<br><br> This email is to validate your email used to create your account. You can ignore this email if you did not submit this request.<br> 
    Use this passcode to verify your email.<br>Passcode expires in 20 minutes.<br>Do not reply to this email.";
    $mail->AltBody = 'reset password'; 
    $mail->send(); 

    Header( 'Location: ../Profile/reg_verification.php?success=1' );
  } catch (Exception $e) { 
    //echo "<script>alert('I am here');</script";
    $errorMessage = "Message could not be sent. Mailer Error: {$mail->ErrorInfo}".$email;
    //echo $errorMessage;
    header("location: register.php?error=" . urlencode($errorMessage) . "?mail=" . urlencode($email));
    exit(urlencode($errorMessage) . "?mail=" . urlencode($email));
    //echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}"; 
  } 
}
?> 