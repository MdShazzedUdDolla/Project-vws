<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../Assets/vendor/bootstrap/css/bootstrap.min.css">
     <link rel="stylesheet" type="text/css" href="../../Style/VWS_CSS/reg_verification.css">
    <title>Verification </title>
</head>
<body>

</body>
</html>


<!DOCTYPE html>
<html lang="en">
<head>


    <meta charset="UTF-8">
    <title>Verification</title>

     <!-- Bootstrap CSS -->
     <link rel="stylesheet" href="../../Assets/vendor/bootstrap/css/bootstrap.min.css">
     <link rel="stylesheet" type="text/css" href="../../Style/VWS_CSS/reg_verification.css">

</head>
<body>


    <?php
      
        include_once "../../Components/general/loginRegNavbar.php";

    ?>
    <div id="main_cont">
        <br>
        <br>
        <span id="verification_text">Verification Successful</span>
        <br>
        <p>Your email adress is verified. Thank you.</p>
        <?php 
            if(isset($_GET['updateProfile']) && $_GET['updateProfile'] == 1){
                $url =  "../../Pages/Dashboard/ViewProfile.php";
                $msg = "Back to profile";
            }else{
                $url =  "signin.php";
                $msg = "Back to Login";
            }
        ?>
           <a class="btn btn-primary" id="redirect_link" href="<?php echo $url;?>"><?php echo $msg;?></php></a>
          

    </div>
</body>

</html>
