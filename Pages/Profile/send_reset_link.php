<link rel="stylesheet" href="../../Assets/vendor/bootstrap/css/bootstrap.min.css">
<?php 
use PHPMailer\PHPMailer\PHPMailer; 
use PHPMailer\PHPMailer\Exception; 
use PHPMailer\PHPMailer\SMTP;


require_once "../../API/Database/config.php";
require_once "../../API/AdminAPI/debug.php";

//if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {

function send_reset_link($POST){


$email = $POST['email'];

  
  // The request is using the POST method

//Using PHPMailer to send a password reset request
//Taken straight from the readme

  
//This is required for php mailer v6
require "../../Assets/vendor/autoload.php"; 

//TODO: first check if the user exist with that email
$email = filter_input(INPUT_POST, "email");
$mail = new PHPMailer(true); 
$mail->isSMTP();
$link = startConnection();
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
    $mail->addAddress($email);
    //if you get ssl errors uncomment this and try again
    $mail->SMTPOptions = array(
      'ssl' => array(
      'verify_peer' => false,
      'verify_peer_name' => false,
      'allow_self_signed' => true
      )
      );

    //Adding a temporary key and expdate to pass information over for the user to reset their password
    $output = '';

    $expFormat = mktime(date("H"), date("i"), date("s"), date("m"), date("d") + 1, date("Y"));
    $expDate = date("Y-m-d H:i:s", $expFormat);
    $key = md5(time());
    $addKey = substr(md5(uniqid(rand(), 1)), 3, 10);
    $key = $key . $addKey;               
    
    //Passing the temporary password information into a separate database table
    mysqli_query($link, "INSERT INTO `password_reset_temp` (`email`, `key`, `expDate`) VALUES ('" . $email . "', '" . $key . "', '" . $expDate . "');");

    $mail->Subject = 'Password Reset'; 
    //This will be a problem, the link will work on my local machine but will not with yours need to figure out a way to construct a proper link

    $url = '';
    if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
      $url = "https://";
    }
    else {
      $url = "http://";
    }

    $url .= $_SERVER['HTTP_HOST'];

    $url .= $_SERVER['REQUEST_URI'];

    $url = str_replace("reset_pass.php", "forget.php", $url);

    $url .= '?key=' . $key . '&email=' . $email . '&action=reset';

    //console_log($url);

    //$mail->Body    = '<p><a href="http://localhost/repo/VWS/Pages/Profile/forget.php?key=' . $key . '&email=' . $email . '&action=reset" target="_blank">http://localhost/repo/VWS/Pages/Profile/forget.php?key=' . $key . '&email=' . $email . '&action=reset</a></p>';
    $mail->Body = "<p><a href='$url' target='_blank'>$url</a></p>";
    $mail->AltBody = 'reset password'; 
    $mail->send(); 

    echo '<div class="center"><div style="text-align: center;" class="alert alert-success center" role="alert"> <span>Email has been sent</span> </div></div>';
  } catch (Exception $e) { 
    //echo '<div class="col-lg-4 center alert alert-danger" role="alert">
        //Message could not be sent. Mailer Error:'. $mail->ErrorInfo.'</div>'; 
        echo '<div class="center"><div style="text-align: center;" class="alert alert-danger center" role="alert"> <span>Message could not be sent mailer error</span> </div></div>';
    
    
} 
  
}
?> 