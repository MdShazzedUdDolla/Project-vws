<?php
require_once "../../API/Database/userProfile.php";
addUser();

global 
$username , $email, $fname, $lname, $phone,
$username_err , $password_err , $confirm_password_err, $email_err, $phone_err, $firstname_err, $lastname_err , $phone_err ,  $SecAns_err;
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sign Up</title>

    <link rel="stylesheet" href="../../Style/VWS_CSS/passwordStrength.css">
    <link rel="shortcut icon" type="image/png" href="../../Assets/img/favicon-16x16.png">
 
</head>
<body>
<?php

if (isset($_GET["error"])) {
    $errorMessage = $_GET["error"];
    echo '<div class="center"><div style="text-align: center;" class="alert alert-danger center" role="alert"> <span>Invalid Email</span> </div></div>';
  if(isset($_GET['email'])){
    $email = $_GET['email'];
    
  }
  // display error message to user 
}

?>

<?php
      include_once "../../Components/general/loginRegNavbar.php"
  ?>

    
    <div class="container" >
    <div class="wrapper">
        <h2>Register</h2>
        <p>Please fill this form to create an account.</p>
        <form id="reg-form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" onsubmit="return checkPasswordsMatch()">
            <div class="form-group">
                <label class="form-label">Username</label>
                <input type="text" name="username" class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>" required>
                <span class="invalid-feedback"><?php echo $username_err; ?></span>
            </div>    
            <div class="form-group">
                <label class="form-label">First Name</label>
                <input type="text" pattern="[A-Za-z]+" title="enter only alphabetical characters" name="fname" class="form-control <?php echo (!empty($firstname_err)) ? 'is-invalid' : ''; ?>"  
                value="<?php echo $fname; ?>"
                required>
                <span class="invalid-feedback"><?php echo $firstname_err; ?></span>
            </div>   
            <div class="form-group">
                <label class="form-label">Last Name</label>
                <input type="text"  pattern="[A-Za-z]+" title="enter only alphabetical characters" name="lname" class="form-control <?php echo (!empty($lastname_err)) ? 'is-invalid' : ''; ?>" 
                value="<?php echo $lname; ?>"
                required>
                <span class="invalid-feedback"><?php echo $lastname_err; ?></span>
                <span class="invalid-feedback"></span>
            </div>   
            <div class="form-group">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>" 
                value="<?php echo $email; ?>"
                required/>
                <span class="invalid-feedback"><?php echo $email_err; ?></span>
            </div>
            <div class="form-group">
                <br>
                <div class="alert alert-warning" role="alert">
                                    Password must have at least 6 characters and contain at least one capital letter, one small letter, one number, and one special character:such as @, $, !, %, *, ? 
                </div>
                <label class="form-label">Password</label>
                <input type="password" name="password" id="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>"  required onkeyup="checkPasswordStrength(this.value)">
                <span class="invalid-feedback"><?php echo $password_err; ?></span>
                <div  id="password-strength"></div>
            </div>
            <div class="form-group">
                <label class="form-label">Confirm Password</label>
                <input type="password" name="confirm_password" id="confirm_password" class="form-control <?php echo (!empty($confirm_password_err)) ? 'is-invalid' : ''; ?>" required>
                <span class="invalid-feedback"><?php echo $confirm_password_err; ?></span>
            </div>
            <div class="form-group">
                <label class="form-label" for="phone">Phone number input</label>
                <input type="tel" name='phone' id="phone" class="form-control <?php echo (!empty($phone_err)) ? 'is-invalid' : ''; ?>" pattern="\+1-\d{3}-\d{3}-\d{4}" title="Please enter a valid phone number in the format: +1-123-456-7890" placeholder="+1-123-456-7890" 
                value="<?php echo $phone; ?>"
                required />
                <span class="invalid-feedback"><?php echo $phone_err; ?></span>
            </div>
            <div>
                <label class="form-label">Security question:</label>
                    <select class="form-select" name ="securityQuestion" id="securityQuestion" required >
                    <?php 
                        $options = getAllSecurityQuestion();
                        echo $options;
                    ?>
                    </select>
            </div>

            <div>
            <div class="form-group">
                <label class="form-label">Security Answer</label>
                
                <input type="text" name="securityAnswer" id="securityAnswer" class="form-control <?php echo (!empty($SecAns_err)) ? 'is-invalid' : ''; ?>"  required/>
                <span class="invalid-feedback"><?php echo $SecAns_err; ?></span>
               
            </div>
            <div>
             

            <br/>
         
            <button class="btn btn-dark" type="submit"  value="Submit" name="adduser" id="adduser"> Submit</button>
              
             <a class="btn btn-dark" href="../../index.php">Cancel</a>.</p>
        </form>
    </div>  
    <label> Already have an account?<a href ="signin.php">Sign in</a> </label>
    </div>  
    <script type="text/javascript" src="../../Js_Script/VWS_JS/passwordStrengh.js"></script>
</body>
</html>