<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Reset Password</title>
        <link rel="stylesheet" href="../../Assets/vendor/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="../../Style/VWS_CSS/passwordStrength.css">
        <style>
            .center-align {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            }
        </style>
        <script>
        function goBack() {
        window.history.back();
        }
        </script>
    </head>
    <body>
    <?php
      include_once "../../Components/general/loginRegNavbar.php"
  ?>
        <div class="container-fluid">
            <div class="row">
               
                <div style="width: 500px" class="center-align">
                    <?php
                    include('../../API/Database/config.php');
                    include('../../API/Database/security/sanitization.php');
                    $link = startConnection();
                    if (isset($_GET["key"]) && isset($_GET["email"]) && isset($_GET["action"]) && ($_GET["action"] == "reset") && !isset($_POST["action"])) {
                        $key = $_GET["key"];
                        $email = $_GET["email"];
                        $curDate = date("Y-m-d H:i:s");
                        $sql = "SELECT * FROM password_reset_temp as pt where pt.key = ? and pt.email = ?";
                      
                        $result = SafeRunSelect($link, $sql, [$key, $email]);

                        if ($result==null) {
                            $error = '<h2>Invalid Link</h2>';
                        } else {
                            $row = mysqli_fetch_assoc($result);
                            $expDate = $row['expDate'];
                            if ($expDate >= $curDate) {
                                ?> 
                                <h2>Reset Password</h2>   
                                <form id="reg-form" method="post" action="" name="update" onsubmit="return checkPasswordsMatch()">

                                    <input type="hidden" name="action" value="update" class="form-control"/>

                                    <div class="alert alert-warning" role="alert">
                                    Password must have atleast 6 characters and contain at least one capital letter, one small letter, one number, and one special character:such as @, $, !, %, *, ?
                                    </div>
                                    <div class="form-group">
                                        <label><strong>Enter New Password:</strong></label>
                                        <input type="password" id="password" name="password" class="form-control" onkeyup="checkPasswordStrength(this.value)"/>
                                       
                                    </div>
                                    <div  id="password-strength"></div>
                                    <div class="form-group">
                                        <label><strong>Re-Enter New Password:</strong></label>
                                        <input type="password" id="confirm_password" name="confirm_password"  class="form-control"/>
                                    </div>
                                    <input type="hidden" name="email" value="<?php echo $email; ?>"/>
                                    <div class="form-group">
                                        <br>
                                        <a class="btn btn-primary" href="../../index.php"> Cancel</a>
                                        <input type="submit" id="reset" value="Reset Password"  class="btn btn-primary"/>
                                    </div>
                                    <div style="position: relative;bottom: 70%; left: 39%">
                                        <input style="position: relative;left: 50%;bottom: 45px;" type="submit" id="home-btn" name="home" value="Home"  class="btn btn-primary"/>
                                    </div>

                                </form>
                                <?php
                            } else {
                                //$error .= "<h2>Link Expired</h2>>";
                            }
                        }
                       
                    }


                    if (isset($_POST["email"]) && isset($_POST["action"]) && ($_POST["action"] == "update")) {


                        $san = new  sanitization();
                        if(isset($_POST["home"])){
                            header('location: ../../Pages/Profile/signin.php');
                        }

                        $error = "";
                        $password = mysqli_real_escape_string($link, $_POST["password"]);
                        $password =  $san->sanitize_data(trim( $_POST["password"] ),'string'); 
                        
                        $confirm_password = mysqli_real_escape_string($link, $_POST["confirm_password"]);
                        $confirm_password = $san->sanitize_data(trim( $_POST["confirm_password"] ),'string'); 
                        

                        $password_err = "";

                        // Validate password
                        if(empty($password)){
                            $password_err = "Please enter a password.";     
                        } elseif(strcmp($password, $confirm_password) != 0){
                            $password_err = "Passwords don't match.";
                        }
                         // Check if password meets complexity requirements
                        elseif (preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[`~!@#$%^&*_+=-?])[A-Za-z\d`~!@#$%^&*_+=-?]{6,}$/', $password)) {
                           // if match then done
                        } else{
                            // Password meets requirements
                            $password_err =  "Password must have atleast 6 characters and contain at least one capital letter, one small letter, one number, and one special character:such as @, $, !, %, *, ?";
                        
                        }
                        if(strcmp($password_err, "") == 0) {
                       

                        $email = $san->sanitize_data(trim($_POST["email"]), 'email'); 
                        $curDate = date("Y-m-d H:i:s");
                       
                        if ($error != "") {
                            //echo $error;
                        } else {
                            include_once "../../API/Database/security/encKey.php";
                          
                            $encryption_key = getKey();  
                            $pepper = getPepper();
                            $pwd_peppered = hash_hmac("sha256", $password, $pepper);
                            $param_password =  password_hash($pwd_peppered, PASSWORD_BCRYPT);
                       
                        
                            $sql = "UPDATE user as u SET u.password = ? where u.email_hash_Index = SHA2(?, 224) ";
                          
                            $result = SafeRunUpdate($link, $sql , [$param_password, $email ]);
                            $sql = "DELETE FROM password_reset_temp WHERE email=?";
                            $result2 = SafeRunDelete($link, $sql , [$email]);
                            if($result==true && $result2==true){
                                echo 
                                '<div class="alert alert-success" role="alert">
                                <p>Congratulations! Your password has been updated successfully.</p>
                                <a class="btn btn-primary" href="signin.php"> Go to sign in page</a>
                                </div>
                                ';
                            }else {
                                echo '<div class="alert alert-success" role="alert">
                                    There was an error updating your password reset. Please Try agaian later.
                                    <a class="btn btn-primary" href="signin.php"> Go to sign in page</a>
                                </div>'; 
                            }
                     

                           
                            }
                        }else{
                            echo '<div class="alert alert-warning" role="alert">'.
                            $password_err.'
                        </div>
                        <button class="btn btn-primary" onclick="goBack()">Go Back</button>

                        '; 
                        }
                        
                    }
                    ?>

                </div>
                </div>
                
            </div>
        </div>

        <script type="text/javascript" src="../../Js_Script/VWS_JS/passwordStrengh.js"></script>
    </body>
</html>