<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verification</title>

     <!-- Bootstrap CSS -->
     <link rel="stylesheet" href="../../Assets/vendor/bootstrap/css/bootstrap.min.css">
     <link rel="stylesheet" type="text/css" href="../../Style/VWS_CSS/reg_verification.css">
     
</head>
<body>


    <?php 
        // ini_set('display_errors', 1);
        // ini_set('display_startup_errors', 1);
        // error_reporting(E_ALL);
        include_once "../../Components/general/loginRegNavbar.php";
    
    ?>
    <div id="main_cont">
        <br>
        <br>
        <span id="verification_text">Verification Successful</span>
        <br>
       
           <!-- <a class="btn btn-primary" id="redirect_link" href="signin.php">Back to Login</a>-->         
           <?php
          
                function checkForConsent(){
                    if (session_status() === PHP_SESSION_NONE) {
                        session_start();
                    }
                  
                    if(isset($_SESSION['user_auto_key'])){
                        $user_auto = $_SESSION['user_auto_key'];
                        $sql= "SELECT consentSigned from consent_record where USR_AUTO_KEY = ?";
                        include_once "../../API/Database/config.php";
                        $conn = startConnection();
                       
                        $res = SafeRunSelect($conn, $sql, [$user_auto]);
                        if($res!=null){
                           $row = $res->fetch_assoc();
                           if($row['consentSigned']!=1){
                                echo ' <p>Almost there! To view the consent form and accept the terms and conditions, please click Next.</p>';
                                //to show during sign in if the user had skipped the consent form
                                echo ' <a class="btn btn-primary" href="../../Pages/Forms/consentForm.php">Next</a>
                                ';
                           }else{
                            echo ' <p>Your email was successfully verified. You can click on the sign in button to return back to login page.</p>';
                                echo ' <a class="btn btn-primary" href="../../Pages/Profile/signin.php">Sign in</a>
                            ';
                           }
                        }else{
                            //to show during registration where user hasnt signed the consent record yet
                            echo ' <p>Almost there! To view the consent form and accept the terms and conditions, please click Next.</p>';
                            echo ' <a class="btn btn-primary" href="../../Pages/Forms/consentForm.php">Next</a>
                            ';
                        }
                    }
                   
                }
                checkForConsent();
           ?>
          
    </div>
</body>

</html>