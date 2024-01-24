<?php
    include "MultiFactorVerification.php";
    include_once "../../API/Database/userProfile.php";
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
   
    if(!isset($_SESSION['user_auto_key'])){
        echo "Your session timed out. Try logging in again.";
        die();
    } else {
        $user_auto_key = $_SESSION['user_auto_key'];
    }
    
    $quetion = getSecurityQuestion($user_auto_key);
    
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['verify'])) {
        $verification = trim(filter_input(INPUT_POST, 'verification'));
        $code = $_SESSION['code'];
        $timestamp = $_SESSION['timestamp'];
     //code is valid for 20 mins (20*60=1200)
        if($verification == $code && time() - $timestamp <= 1200) {
            $verifyAns = verifySecAnswer($user_auto_key);
            if($verifyAns == false) {
                $security_err = "There was an error verifying your security question. Try again.";
            } else {
                $_SESSION["loggedin"] = true;
                if($_SESSION['privilege_level'] == 3) {
                    header("location: ../../Pages/Dashboard/patientDashboard.php");
                } else {
                    header("location: ../../Pages/Dashboard/physicianDashboard.php");
                }
            }
        } else {
            $code_err = "The verification code is invalid or has expired. Try again.";
        }
    } else {
        if(isset($_POST['resend'])) {
            $code = bin2hex(random_bytes(2));
            send_verification($code);
            $_SESSION['code'] = $code;
            $_SESSION['timestamp'] = time();
            $sent_msg = "Verification code sent again.";
        } else {
            $code = bin2hex(random_bytes(2));
            send_verification($code);
            $_SESSION['code'] = $code;
            $_SESSION['timestamp'] = time();
        }
    }
?>

<!DOCTYPE HTML>
<html>
    <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        .input-group {
  display: flex;
}

.input-group input[type="text"] {
  flex: 1;
  display: inline-block;
  margin-right: 10px;
}

.input-group button[type="submit"] {
  display: inline-block;
}
        </style>
    <!-- <link rel="stylesheet" type="text/css" href="../../Style/VWS_CSS/reset-pass.css"> -->
    <link rel="stylesheet" href="../../Assets/vendor/bootstrap/css/bootstrap.min.css">
    
    <?php
      include_once "../../Components/general/loginRegNavbar.php"
  ?>
    </head>
    <body>
        <div  class="center">
        <form  method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
            <div class="text-center">
                <br>
            <h1>Please answer the security question you created.</h1>
            <br>
            <br>
            <div class="container">
            <input class="form-control" type="text" name="secQuestion" value="<?php echo    $quetion; ?>" disabled>
            <br>
            <input type="password" id="securityques" name = "securityques" class="form-control <?php echo (!empty($security_err)) ? 'is-invalid' : ''; ?>" placeholder="Answer" required>
            <span style="font-size: small;" class="invalid-feedback"><?php echo $security_err; ?></span>
            <br>
            <br>
            <div class="input-group">
             <input type="text" name="verification" id="verification" class="form-control <?php echo (!empty($code_err)) ? 'is-invalid' : ''; ?>" placeholder="Enter the code sent to your email" required />
             <span style="font-size: small;" class="invalid-feedback"><?php echo $code_err; ?></span>
             <button  type="button" class="btn btn-primary" onClick="sendAgain()">Send Again</button>
             <div id="sent"></div>
             <input type="hidden" name="button_pressed" value="1" /> 
            </div>
            <br>
            <button class="btn btn-primary" id="verify" type="submit" name="verify">Verify</button>
        
            <a class="btn btn-primary" href="../../index.php"> Cancel</a>
            <!-- <button class="btn btn-primary" id="back" action="action" onclick="window.history.go(-1); return false;" type="submit">Cancel</button> -->
            </div>
        </div>
        </form>
</div>

</body>
</html>
<script>
  document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('securityques').focus();
  });
</script>
<script type="text/javascript" src="../../Js_Script/jquery/jquery3.6.1.js"></script>
<script>
            function sendAgain() {
                $.ajax({
                    url: '',
                    type: 'POST',
                    data: { resend: true },
                    success: function(response) {
                        window.location.reload(true);
                    }
                });
                var divSent = document.getElementById("sent");
                divSent.innerHTML = "<div class=\"alert alert-success\" role=\"alert\">Verification code sent again.</div>";
            }
        </script>