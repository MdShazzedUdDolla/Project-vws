<?php
include "../../API/PatientAPI/Patient_Info.php";
if (session_status() === PHP_SESSION_NONE) {
   

    session_start();
   
 
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>ViewProfile</title>
    <link rel="" href="../../Assets/vendor/bootstrap/css/bootstrap.min.css"> 
   

</head>


<body>
<?php 
include_once "../../Components/general/header.php";
?>
<?php
include_once "../../Components/general/sidebar.php";
 
?>
<div id="main">
<div class="container">
<form action = "../../Pages/Dashboard/editProfile.php" >
    <!-- display the user profle information -->
            <h1>Profile</h1>
            <div><p>Username: <span><?php echo $_SESSION['username']?></span></p></div>            
            <div><p>First Name: <span><?php echo $firstname?></span></p></div>
            <div><p>Last Name: <span ><?php echo $lastname?></span></p></div>
            <div><p>Email: <span ></span><?php echo $email?></p></div>
            <div><p>Phone: <span ></span><?php echo $phone?></p></div>
            <div class="form-group">
                <button class="btn btn-primary" name="navToEdit" type="submit">EDIT PROFILE</button>
            </div>
        </form>
        <?php
            if(isset($_GET['reverify'])){
            $_SESSION['email'] = $email;
            $_SESSION['only_once']=1;

            ?> 
             <!-- verification of email if it is updated -->
                        <div class="alert alert-success" role="alert">
                                        Email was updated. Please click <a href="../../Pages/Profile/verification.php?updateProfile=1">here</a> to verify new email!
                        </div>
            <?php
                }
            ?>
        </div>
        <br>
          <br>
        
         
</div>

</body>
</html>