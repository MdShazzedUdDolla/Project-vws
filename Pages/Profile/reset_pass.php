<?php
  require_once "../../API/Database/config.php";
  require_once "../../API/AdminAPI/debug.php";
  include "send_reset_link.php";


  if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['home'])) {
    header('location: ../../Pages/Profile/signin.php');
  }


?>
<!DOCTYPE HTML>
<html>
    <head>
    <title>Reset password form</title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <link rel="stylesheet" type="text/css" href="../../Style/VWS_CSS/reset-pass.css"> -->
    <link rel="stylesheet" href="../../Assets/vendor/bootstrap/css/bootstrap.min.css">
    <?php
      include_once "../../Components/general/loginRegNavbar.php"
  ?>
    </head>
    <body>
        <div  class="container">
        <form  method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"])?>">
            <div class="text-center">
                <br>
            <h1>Enter email address to send password link</h1>
            <div class="form-group mb-2 ">
            <input class="form-control " type="text" name="email">
           <br>
            <button class="btn btn-primary" id="resend_email" type="submit" name="submit"> Submit email</button>
        
            <button class="btn btn-primary" id="back" name="home" action="action">Cancel</button>
            </div>
            </div>
        </form>
</div>
    </body>
</html>
<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {

    $email = $_POST['email'];
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo '<div class="center"><div style="text-align: center;" class="alert alert-danger center" role="alert"> Email does not have the right format</div>';
       
    } else {
    $conn = startConnection();
    $sql = 'SELECT email, verified from user where email_hash_Index = SHA2(?, 224)';
    $result = SafeRunSelect($conn, $sql,[$email]);



    if ($result == null) {
        echo '<div class="center"><div style="text-align: center;" class="alert alert-danger center" role="alert"> <span>Email does not exist in the system</span> </div></div>';
        return;
    } else {
        while ($row = mysqli_fetch_assoc($result)) {
        
            $verify_flag = $row['verified']==1? true : false;
        }
    }

    closeConnection($conn);

    
        if($verify_flag == false){
            echo '<div class="center"><div style="text-align: center;" class="alert alert-danger center" role="alert"> <span>Make sure email is properly verified</span> 
            <br>
            <a class="btn btn-primary"href="reg_verification.php">click here to get verified.</a>
            </div>';
        } 
        
        else{
            
                send_reset_link($_POST);
            
        }
    }
}


?>






