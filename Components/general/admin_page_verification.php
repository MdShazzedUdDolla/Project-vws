



<!DOCTYPE html>
<html lang="en">
<head>
    <title>Admin page verification</title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="../../Js_Script/jquery/jquery3.6.1.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/multi-select/0.9.12/js/jquery.multi-select.min.js"></script>
    <link rel="stylesheet" href="../../Style/VWS_CSS/dropdown.css">
    <?php

    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    if(isset($_SESSION)==false || isset($_SESSION['privilege_level'])==false || $_SESSION['privilege_level']!=1){
        header("Location: ../../Pages/Error/UnauthorizedAccess.php");
       
        exit("Unauthorized Access detected.");
    }
    $info = '';
    if($_SERVER['REQUEST_METHOD'] === 'POST' && (isset($_POST['submit']))){
        include_once "../../API/AdminAPI/admin_information.php";
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
          }
        if(isset($_POST['admin_password_reg']) && !empty($_POST['admin_password_reg'])){
            $info = $_POST['admin_password_reg'];
            //Where are we setting admin password?
            $res = validateAdminPagePass($info);
            if($res==true){
                $_SESSION['admin_status'] = 1; // set admin status session variable

                //Potential problem if user has javascript disabled this will not work but I ran into problems using php header since
                //it is already defined in header.php, and don't want to use output buffering
                
              //  echo "<script>window.location.href='admin_page.php';</script>"; // redirect to admin page
              header("location: admin_page.php");
              exit("there was a problem redirecting to admin page");
            }else{
                $_SESSION['admin_status'] = 0;
                $info = "failure";
            }
        }else{
            $_SESSION['admin_status'] = 0;
            $info = "Information not set";
        }
      }
?>
</head>
<body>

<?php
include_once "header.php";
include_once "sidebar.php";

?>


<div   id="main">
    <div class="container">
    <div style="position: relative; top: 15%;" class="row align-items-center">
        <div class="col align-self-center">  
            <label>In order to modify user privileges please enter the administration password</label>
            <br>
            <br>
            <br>
            <div class="warning_admin_message"></div>
            <br>

            <label>Administration Password</label>
            <br>
            <form id="form" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                <input class="form-control" type="text" id="name" name="admin_password_reg">
                <span id="further_warning_styling"></span>   
                <br>
                <br>
                <input type="submit" name="submit" class="btn btn-primary" name="verificationbutton" id="verificationbutton" />
            </form>
        </div>
    </div>
    </div>
</div>


<script>
let info = <?php echo json_encode($info); ?>;


if (typeof info !== "undefined") {
    if (info == "Information not set") {
        $(".warning_admin_message").append("<div class='alert alert-danger' role='alert'>Please enter admin information</div>");
        $("#name").css("border", "2px solid red");
        $("#name").css("color", "red");
        $("#further_warning_styling").append("!");
        $("#further_warning_styling").css("color", "red");
    }
     else if(info == "failure"){
        $(".warning_admin_message").append("<div class='alert alert-danger' role='alert'>Incorrect admin information entered</div>");
        $("#name").css("border", "2px solid red");
        $("#name").css("color", "red");
        $("#further_warning_styling").append("!");
        $("#further_warning_styling").css("color", "red");
    }
}





</script>


</body>
</html>


