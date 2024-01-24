<?php
 require_once "../../API/Database/userProfile.php";
// need an API for user login

global $username , $password ,
$username_err , $password_err , $login_err ;


if (session_status() === PHP_SESSION_NONE) {
  session_start();
}



auth();



?>
 <script src="https://www.google.com/recaptcha/api.js" async defer></script>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>sign in</title>
    <link rel="shortcut icon" type="image/png" href="../../Assets/img/favicon-16x16.png">
  
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="../../Assets/vendor/bootstrap/css/bootstrap.min.css">
</head>
<body class="text-center">
<?php
      include_once "../../Components/general/loginRegNavbar.php"
  ?>
    <div class="container">
    <br>
    <?php
        if(!empty($login_err)){
            echo '<div class="alert alert-danger">' . $login_err . '</div>';
        }
        ?>
     <form class="form-signin" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
      <h1><strong>Virtual Wellness System</Strong><br></h1>
        <hr>
      <h2 lass="h1 mb-3 font-weight-normal">User Login</h1>

      <label for="username" class="sr-only">Username/Email</label>
      <input type="text" class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" required autofocus=""   autocomplete='off'
    placeholder='Enter your username or the email you registered with'  id='username' name='username'>


      <span class="invalid-feedback"><?php echo $username_err; ?></span>

      <br />
      <label for="inputPassword" class="sr-only">Password</label>
      <input type="password" id="password" name = "password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" placeholder="Password" required>
      <span class="invalid-feedback"><?php echo $password_err; ?></span>
      <br>
      <div class="g-recaptcha" data-sitekey="6LfPPRklAAAAAGem6SArS43Et8FaFIpwUK2gF3Kf"></div>
      <br>


      <div class="checkbox mb-3">
        <label>
          <!-- we need to create the page for forget password-->
          <a href="../Profile/reset_pass.php">forgot password?<br></a>
          <p>Don't have an account?<a href="../../Pages/Profile/register.php"> Sign Up</a></p>

        </label>
      </div>
      <button class="btn btn-lg btn-primary btn-block" type="submit">
        <!-- icone -->
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
        stroke-linejoin="round" class="feather feather-activity"><path d="M14 22h5a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2h-5">
        </path><polyline points="11 16 15 12 11 8"></polyline><line x1="15" y1="12" x2="3" y2="12"></line></svg>
      Sign in
    </button>

    </form>



</div>


</body>

</html>
