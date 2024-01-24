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
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
        include_once "../../Components/general/loginRegNavbar.php";
    
    ?>
    <div id="main_cont">
        <br>
        <br>
        <span id="verification_text">Registration Successful</span>
        <br>
          <a class="btn btn-primary" id="redirect_link" href="signin.php">Back to Login</a>
          
    </div>
</body>

</html>