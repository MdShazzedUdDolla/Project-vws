<?php

include "send_verification_code.php";

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$email = $_SESSION['email'];
$only_once = $_SESSION['only_once'];

if ($only_once == 1) {
    $code = bin2hex(random_bytes(2));
    $_SESSION['code'] = $code;
    $_SESSION['code_timestamp'] = time(); // set timestamp when code is generated
    send_verification($code);
    $_SESSION['only_once'] = 0;
// code is valid for 20 mins(20*60=1200)
} elseif (isset($_SESSION['code_timestamp']) && time() < $_SESSION['code_timestamp'] + 1200) {
    // check if code is still valid (less than 1 minute has passed)
    $code = $_SESSION['code'];
} else {
    // code has expired, generate a new one
    $code = bin2hex(random_bytes(2));
    $_SESSION['code'] = $code;
    $_SESSION['code_timestamp'] = time(); // set new timestamp
    send_verification($code);
    echo "Passcode has expired and a new one has been sent to your email address.";
}

?>

<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">
    <title>Verification</title>
     <!-- Bootstrap CSS -->
     <link rel="stylesheet" href="../../Assets/vendor/bootstrap/css/bootstrap.min.css">
     <link rel="stylesheet" type="text/css" href="../../Style/VWS_CSS/reg_verification.css">
     <link rel="stylesheet" type="text/css" href="../../Style/VWS_CSS/email_verif.css">
</head>

<body>
<?php
      include_once "../../Components/general/loginRegNavbar.php"
  ?>

    <div id="main_cont">
        <br>
        <h4>
        <span id="verification_info" > Welcome! </span> </h4>
        <br>
        <!-- displaying code sent message -->
        <?php 
                    if ( isset($_GET['success']) && $_GET['success'] == 1 )
                    {
                       ?>
        
        <h4>Verification Code has been sent. If you don't see the message please check your spam folder as well.</h4>
        <?php
                    }
        ?>
        <!-- displaying resent code -->
        <?php 
                    if ( isset($_GET['success1']) && $_GET['success1'] == 1 )
                    {
                       ?>
        
        <h4>Verification Code has been sent Again</h4>
        <?php
                    }
        ?>
        <span id="welcome" > Please enter the verification code sent to the registered email ID </span>
        
        <div class="form-group">
            <form method="post" id="email">
            <div class="form-group col-lg-4 center">
                <input type="text" name="verify" id="verification" placeholder="Verification" class="form-control" />
        
                <?php
                    if (isset($_POST["verify"])) {
                        $verification = filter_input(INPUT_POST, 'verify');
                        $code = $_SESSION['code'];
                       // console_log($code);
                        if($verification == $code){
                            echo "It matches";
                            $_SESSION['verification'] = 1;
                            $username = $_SESSION['user_auto_key'];
                            //console_log($username);
                            require_once ("../../API/Database/config.php");
                            $link = startConnection();
                            //$username = trim($username);
                            $sql = "UPDATE user SET verified = 1 WHERE USR_AUTO_KEY = ?";
                            $stmt = mysqli_prepare($link, $sql);
                            mysqli_stmt_bind_param($stmt, "s", $username);
                            if(mysqli_stmt_execute($stmt)){
                                //console_log($username);
                                header("location: reg_verification_success.php");
                            }else{
                                echo "Authorization failed";
                               // console_log($username);
                            }
                            
                        }
                        else{
                            echo "It does not match";
                        }
                    }
                ?>
                <br>
                <input type="submit" class="btn btn-primary" name="verificationbutton" id="verificationbutton" />
                
                <span class="invalid-feedback"></span>
            </form>
        </div>
        <br>
        <form method="post">
            
            <button  id="resend_verification"  type="submit" class ="btn btn-primary" style="text-decoration: none;color:white">Resend Verification Code</button>
            <input type="hidden" name="button_pressed" value="1" /> 
            
        </div>
        </form>
        <?php
if (isset($_POST['button_pressed'])) {
    $code = bin2hex(random_bytes(2));
    $_SESSION['code'] = $code;
    $_SESSION['code_timestamp'] = time(); // set timestamp when code is generated
    send_verification($code);
  // code is valid for 20 mins(20*60=1200)
if (isset($_SESSION['code_timestamp']) && time() < $_SESSION['code_timestamp'] + 1200) {
    // check if code is still valid (less than 1 minute has passed)
    $code = $_SESSION['code'];
} else {
    // code has expired, generate a new one
    $code = bin2hex(random_bytes(2));
    $_SESSION['code'] = $code;
    $_SESSION['code_timestamp'] = time(); // set new timestamp
    send_verification($code);
    echo "Passcode has expired and a new one has been sent to your email address.";
}
unset($_POST['button_pressed']);
header('Location: ../Profile/reg_verification.php?success1=1');
echo " Message sent";
exit();
}
?>
    

</body>

</html>