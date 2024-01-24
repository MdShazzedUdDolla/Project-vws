<script src="https://www.google.com/recaptcha/api.js" async defer></script>
<?php 
  include_once "security/Cryptor.php";
  require_once "config.php";
  include_once "../../API/Database/security/sanitization.php";









//https://www.php.net/manual/en/function.password-hash.php

$username  = $email = $fname = $lname = $phone = "";
$username_err = $password_err = $login_err =  $confirm_password_err  = $email_err = $firstname_err = $lastname_err = $phone_err =  $SecAns_err ="";

$queries = [
"SELECT username_enc,password, privilege_level, verified, USR_AUTO_KEY, (select cr.consentSigned from consent_record as cr where cr.USR_AUTO_KEY = user.USR_AUTO_KEY )  FROM user WHERE username = SHA2(?, 224) or email_hash_Index  = SHA2(?, 224)",

];
function auth(){
    $san = new  sanitization();
    global $queries ,$username , $password , $email,
    $username_err , $password_err , $login_err ;
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
      }
 
    // Check if the user is already logged in, if yes then redirect him to welcome page
    if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true && $_SESSION['username'] != ""){
        //header("location: ../../index.php");
        //session_start();
        $_SESSION['username'] = $username;
        // console_log($_SESSION['username'] . ' in auth()');
        /*
        Might fix login issue?
        */
        if($username == ""){
            session_destroy();
            header("location: ../../index.php");
        }
        else{
            header("location: ../../Pages/Dashboard/patientDashboard.php");
        }
        exit;
    }
    $conn = startConnection(); 
    // Define variables and initialize with empty values
    global $username , $password,
    $username_err , $password_err , $login_err ;
     
    // Processing form data when form is submitted
    if($_SERVER["REQUEST_METHOD"] == "POST"){
     
        $tempUsername= $san->sanitize_data(trim($_POST["username"]), 'string');
        // Check if username is empty
        if(empty($tempUsername)){
            $username_err = "Please enter username.";
        } else{
            $username = $tempUsername;
        }
        
        $tempPassword = $san->sanitize_data(trim($_POST["password"]), 'string');
        // Check if password is empty
        if(empty($tempPassword)){
            $password_err = "Please enter your password.";
        } else{
            $password = $tempPassword;
        }
        
        //recaptcha 
        $secret = "6LfPPRklAAAAADNmwGMSRnxAE8a8A6eGkg3V2mrb";
        $response = $_POST['g-recaptcha-response'];
        $remoteip = $_SERVER['REMOTE_ADDR'];
        $url = "https://www.google.com/recaptcha/api/siteverify?secret=$secret&response=$response&remoteip=$remoteip";
        $data = file_get_contents($url);
        $row = json_decode($data, true);
        //validate recaptcha
        if($row['success'] == "true"){
        // Validate credentials
        if(empty($username_err) && empty($password_err)){
            include_once "security/encKey.php";
            $encryption_key = getKey(); //this will becoming from a file in root after deployment 
            $cipher_method = 'aes-256-cfb';
            $cryptor = new Cryptor($encryption_key, $cipher_method);

            // Prepare a select statement
            $sql = $queries[0];
            
            if($stmt = mysqli_prepare($conn, $sql)){
                // Bind variables to the prepared statement as parameters
              
                mysqli_stmt_bind_param($stmt, "ss", $param_username, $param_username);
              
                // Set parameters
                $param_username = $san->sanitize_data(trim($_POST["username"]), 'string');
                // Attempt to execute the prepared statement
                if(mysqli_stmt_execute($stmt)){
                   
                    // Store result
                    mysqli_stmt_store_result($stmt);
           
                    // Check if username exists, if yes then verify password
                    if(mysqli_stmt_num_rows($stmt) == 1){                    
                        // Bind result variables
                        mysqli_stmt_bind_result($stmt,$username_enc, $hashed_password, $privilege_level, $result_verification, $usr_auto_key, $consent);
                       
                        if(mysqli_stmt_fetch($stmt)){
                        
                         
                          $pepper = getPepper();
                          $pwd_peppered = hash_hmac("sha256", $password, $pepper);

                            if(password_verify($pwd_peppered, $hashed_password)){
                                // Password is correct, so start a new session
                                    
                                if($result_verification == 1 && $consent==1){
                                    session_start();
                                    $_SESSION['username'] = $cryptor->decrypt($username_enc);
                                    $_SESSION['privilege_level'] = $privilege_level; 
                                    $_SESSION['user_auto_key'] = $usr_auto_key;

                                    //header("location: ../../Pages/Dashboard/patientDashboard.php");
                                    header("location: askSecQuestion.php");
                                    }else{
                                        $email_sql = "SELECT email, USR_AUTO_KEY FROM user WHERE username = SHA2(?, 224)";
                                        $my_result  = SafeRunSelect($conn, $email_sql, [$username]);

                                        
                                       

                                        if($my_result != null){        
                                            $row = $my_result->fetch_assoc();
                                            $email_enc = $row['email'];
                                            $email = $cryptor->decrypt($email_enc);
                                            $_SESSION['email'] = $email;
                                            $_SESSION['only_once'] = 1;
                                            $_SESSION['verify_signin'] = 1;
                                            $_SESSION['user_auto_key'] = $row['USR_AUTO_KEY'];
                                        }
                                        echo '<div class="alert alert-danger" role="alert">';
                                        echo "User is not verified<br>";
                                        echo "<a href='reg_verification.php'>click here to get verified.</a>";
                                        echo '</div>';


                                   
                                    }
                                    //header("location: ../../index.php");
                               
                              
                            } else{
                                // Password is not valid, display a generic error message
                                $login_err = "Invalid username or password.";
                            }
                        }
                    } else{
                        // Username doesn't exist, display a generic error message
                        $login_err = "Invalid username or password.";
                    }
                } else{
                    echo "Oops! Something went wrong. Please try again later.";
                }
    
                // Close statement
                //mysqli_stmt_close($verify_stmt);
                mysqli_stmt_close($stmt);
            }
        }
    }
    else {
        // recaptcha is not verified. show error message
      $login_err = "Prove that you are not a robot!!";
    }
        // Close connection
        mysqli_close($conn);
    }
}




function addUser(){
    //print_r($_POST);
    $san = new  sanitization();
    global 
    $username , $password , $confirm_password, $email, $fname, $lname, $phone,
    $username_err , $password_err , $confirm_password_err, $email_err,$firstname_err, $lastname_err, $phone_err, $SecAns_err;
    $conn = startConnection();
    // Processing form data when form is submitted
    if($_SERVER["REQUEST_METHOD"] == "POST"){
      
     
        // Validate username
        $tempUsername = $san->sanitize_data(trim($_POST["username"]), 'string');
        if(empty($tempUsername)){
            $username_err = "Please enter a username.";
        } elseif(!preg_match('/^[a-zA-Z0-9_]+$/', $tempUsername)){
            $username_err = "Username can only contain letters, numbers, and underscores.";
        } else{
           
            $sql = "SELECT 1 FROM user WHERE username = SHA2(?, 224) ";
         
                 $param_username = $tempUsername;
              
                    $result  = SafeRunSelect($conn, $sql, [$param_username]);
                    if($result !=null){
                        $username_err = "This username is already taken.";
                    } else{

                        $username = $tempUsername;
                    }
        }


        //validate email address
        $tempEmail = $san->sanitize_data(trim($_POST["email"]), 'email');
        if(empty($tempEmail)){
            $email_err = "Please enter an email.";
        }else{
            $sql = "SELECT 1 FROM user WHERE email_hash_Index = SHA2(?, 224) ";
         
                $param_email = $tempEmail;
         
               $result  = SafeRunSelect($conn, $sql, [$param_email]);
               if($result !=null){
                   $email_err = "This email is already taken.";
               } else{

                   $email = $tempEmail;
               }
        }
              
        
        // Validate password
        $tempPassword = $san->sanitize_data(trim( $_POST["password"] ),'string');
        if(empty($tempPassword)){
            $password_err = "Please enter a password.";     
        } 
       // Check if password meets complexity requirements
        elseif (preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[`~!@#$%^&*_+=-?])[A-Za-z\d`~!@#$%^&*_+=-?]{6,}$/',  $tempPassword)) {
     
            $password =  $tempPassword;
        } else{
            // Password meets requirements
            $password_err =  "Password must have at least 6 characters and contain at least one capital letter, one small letter, one number, and one special character:such as @, $, !, %, *, ?";
           
        }
        
        // Validate confirm password
        $tempPassword2 = $san->sanitize_data( trim( $_POST["confirm_password"] ),'string');
        if(empty($tempPassword2)){
            $confirm_password_err = "Please confirm password.";     
        } else{
            $confirm_password =  $tempPassword2;
            if(empty($password_err) && ($password != $confirm_password)){
                $confirm_password_err = "Password did not match.";
            }
        }

         //validate first name and last name
        $tempFname = $san->sanitize_data(trim($_POST["fname"]),'string');
        if(!ctype_alpha($tempFname)){ 
            $firstname_err = "First name can only contain letters";
        }else if (empty($tempFname)){
            $firstname_err = "Last name can't be empty";
        }else{
            $fname = $tempFname;
        }

        $tempLname = $san->sanitize_data(trim($_POST["lname"]),'string');
        if(!ctype_alpha($tempLname)){ 
            $lastname_err = "Last name can only contain letters";
        }else if (empty($tempLname)){
            $lastname_err = "Last name can't be empty";
        }
        else{
            $lname = $tempLname;
        }

        //validate phone number
        $tempPhone= $san->sanitize_data(trim($_POST["phone"]),'string');
        if($tempPhone==false){
            $phone_err="Wrong phone format";
        }else{
            $phone = $tempPhone;
        }

        //sanitize security question & answer
        $tempSecAns = $san->sanitize_data(trim($_POST["securityAnswer"]),'string');
        if(empty($tempSecAns)){
            $SecAns_err = "Please enter an answer for security question.";     
        } 
        $tempSecQues = $san->sanitize_data(trim($_POST["securityQuestion"]),'int');
        // Check input errors before inserting in database
        if(empty($username_err) && empty($password_err) && empty($confirm_password_err)&& empty($email_err)&& empty($firstname_err)&& empty($lastname_err) && empty($SecAns_err) &&  $tempSecQues!=false){
            
            // Prepare an insert statement
            $sql = "INSERT INTO user(username,username_enc, password, first_name, last_name, email,email_hash_Index, phone) VALUES (SHA2(?, 224),?,?,?,?,?,SHA2(?, 224),?)";
      
                // Set parameters
                include_once "security/encKey.php";
                $encryption_key = getKey(); //this will becoming from a file in root after deployment 
                $cipher_method = 'aes-256-cfb';
             
        
                $cryptor = new Cryptor($encryption_key, $cipher_method);
                $pepper = getPepper();
                $pwd_peppered = hash_hmac("sha256", $password, $pepper);
               
                $param_password =  password_hash($pwd_peppered, PASSWORD_BCRYPT );
                // password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
                $param_email =  $cryptor->encrypt($email);
                $param_fname =    $cryptor->encrypt($fname); 
                $param_lname =  $cryptor->encrypt($lname); 
                $param_phone = $cryptor->encrypt($tempPhone) ;
                $param_secQ = $tempSecQues;
                $param_secA =  $cryptor->encrypt($tempSecAns); 

                //Note: username  need to be hashed instead of being encrypted since that will allow us to search them in where statements later in ohter features
               //To hash them we used SHA2(? , 224) from mysql hashing
                $param_username = $username;
                $param_username_enc = $cryptor->encrypt($username); 

                $exResult = SafeRunInsert($conn, $sql,[$param_username,$param_username_enc, $param_password, $param_fname,$param_lname, $param_email,$email ,$param_phone]);
                $USR_AUTO_KEY =  mysqli_insert_id($conn); //the auto increment identifier of last inserted
                if($exResult){
                    // $sql = "INSERT INTO link_user_questions(SCQ_AUTO_KEY, USR_AUTO_KEY, security_ans) VALUES ($param_secQ, $USR_AUTO_KEY, SHA2($param_secA, 224)])";
                    // echo $sql;
                    SafeRunInsert($conn, "INSERT INTO link_user_questions(SCQ_AUTO_KEY, USR_AUTO_KEY, security_ans) VALUES (?, ?, ?)", [$param_secQ, $USR_AUTO_KEY, $param_secA]);

                    session_start();
                    //ask if this is necessary
                    $_SESSION['username'] = $username;
                    $_SESSION['user_auto_key'] = $USR_AUTO_KEY;
                    $_SESSION['email'] = $email;
                    $_SESSION['only_once'] = 1;
                    $_SESSION['verification'] = 0;
                    header("location: reg_verification.php");
                } else{
                    echo "Oops! Something went wrong. Please try again later.";
                }
    
                // Close statement
                //mysqli_stmt_close($stmt);
            //}
        }
        
        // Close connection
        mysqli_close($conn);
    }
}

    


function getSecurityQuestion($user_auto_key){

    $sql = "SELECT (SELECT sq.question from security_questions as sq where sq.SCQ_AUTO_KEY = lq.SCQ_AUTO_KEY) as question FROM link_user_questions as lq where lq.USR_AUTO_KEY = ? ; ";
    $conn = startConnection();
    $result = SafeRunSelect($conn, $sql,[$user_auto_key]);
    $question = "";
    if($result !=null) {

        $row = mysqli_fetch_assoc($result);
        $question = $row['question'];


        closeConnection($conn);
    }

    return $question;
}

function verifySecAnswer($user_auto_key){
    $sql = "SELECT security_ans FROM link_user_questions as lq where lq.USR_AUTO_KEY = ?   ";
    $conn = startConnection();
    $secAns = $_POST['securityques'];
    
    $result = SafeRunSelect($conn, $sql,[$user_auto_key]);
    $question = "";
    if($result !=null) {

        $row = mysqli_fetch_assoc($result);
        $answer = $row['security_ans'];

       include_once "security/encKey.php";
        $encryption_key = getKey(); //this will becoming from a file in root after deployment 
        $cipher_method = 'aes-256-cfb';
     
        $cryptor = new Cryptor($encryption_key, $cipher_method);

        $dec_ans = $cryptor->decrypt($answer);
   
        if(strcmp($dec_ans,$secAns)==0){
          return true;
        }else{
           
            return false;
        }


        closeConnection($conn);
    }

    return false;
}


function getAllSecurityQuestion(){
    $sql = "SELECT * FROM security_questions ";
    $conn = startConnection();
    $result = runSelect($conn, $sql);
    $html = "";
    if($result!=null){
        while($row = $result->fetch_assoc()){
            $html .= "<option value='".$row['SCQ_AUTO_KEY']."'>". $row['question'] ."</option>";
        }

        closeConnection($conn);
    }

    return $html;
}
?>