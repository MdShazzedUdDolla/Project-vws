<?php
include "../../API/PatientAPI/Patient_Info.php";
if (session_status() === PHP_SESSION_NONE) {
   

    session_start();
   
 
}
$user_auto_key = $_SESSION['user_auto_key'];
global $username_err, $email_err, $firstname_err , $lastname_err, $phone_err;

updateProfile($user_auto_key);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EditProfile</title>
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
    <div class = "container">
            <h1>Profile</h1>
            <!-- forms to update the user profile information -->
            <!-- call updateProfile() function to update user profile information -->
            <form method="post" id ="EditProfile" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                <div class="form-group">
                    <label for="username">Username:</label>
                    <input style="width:70%; float: right" type="text" name="username" id="username" value="<?php echo $usernameUpdate?>" class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>"
                    required autofocus=""   autocomplete='off'>
                    <span class="invalid-feedback"><?php echo $username_err; ?></span>
                </div>
                <div class="form-group">
                    <label for="firstname">First Name:</label>
                    <input style="width:70%; float: right" pattern="[A-Za-z]+" title="enter only alphabetical characters" type="text" name="firstname" id="firstname" value="<?php echo $firstname?>" class="form-control <?php echo (!empty($firstname_err)) ? 'is-invalid' : ''; ?>"
                    required >
                    <span class="invalid-feedback"><?php echo $firstname_err; ?></span>
                </div>
                <div class="form-group">
                    <label for="lastname">Last Name:</label>
                    <input style="width:70%; float: right" pattern="[A-Za-z]+" title="enter only alphabetical characters" type="text" name="lastname" id="lastname" value="<?php echo $lastname?>"  class="form-control <?php echo (!empty($lastname_err)) ? 'is-invalid' : ''; ?>"
                    required >
                    <span class="invalid-feedback"><?php echo $lastname_err; ?></span>
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input  style="width:70%; float: right" type="email" name="email" id="email" value="<?php echo $email?>"  class="form-control <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>"
                    required>
                    <input name="original_email" id="original_email" value="<?php echo $email?>" hidden>
                    <span class="invalid-feedback"><?php echo $email_err; ?></span>
                </div>
            
                <div class="form-group">
                    <label for="phone">Phone:</label>
                    <input style="width:70%; float: right" type="tel" name="phone" pattern="\+1-\d{3}-\d{3}-\d{4}" title="example:+1-123-456-7890" placeholder="+1-123-456-7890" id="phone"value="<?php echo $phone?>" class="form-control <?php echo (!empty($phone_err)) ? 'is-invalid' : ''; ?>" required
                    
                    >
                    <span class="invalid-feedback"><?php echo $phone_err; ?></span>
                </div>

                <div class="form-group">
                    <button class="btn btn-primary" name="updateProfile" type="submit" value="submit">UPDATE</button>
                    <button class="btn btn-primary" name="Cancel" type="submit" value="Cancel" onclick="window.location.href='viewProfile.php'">Cancel</button> 
                </div>
            </form>
         
    </div>
</div>
</body>
</html>