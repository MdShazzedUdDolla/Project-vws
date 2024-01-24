



<?php



session_start();
include_once "../../API/Database/security/Cryptor.php";
include_once "../../API/Database/security/sanitization.php";
include "../../API/Database/config.php";
$link = startConnection();
if (!$link) {
    die("Connection failed: " . mysqli_connect_error());
}

if(!isset($_SESSION['user_auto_key'])){
       
     echo "Your session timed out . Try logging in again";
     die();
 }else{
     $user_auto_key = $_SESSION['user_auto_key'];
 }


$sql = "SELECT first_name, last_name,email,phone, username FROM user where USR_AUTO_KEY= ?";
$result = SafeRunSelect($link, $sql , [$user_auto_key]);

if($result !=null) {


     include_once "../../API/Database/security/encKey.php";
     $encryption_key = getKey(); //this will becoming from a file in root after deployment 
  
     $cipher_method = 'aes-256-cfb';
  

     $cryptor = new Cryptor($encryption_key, $cipher_method);

     

     $user = mysqli_fetch_assoc($result);
     $usernameUpdate =  $_SESSION['username'] ;
     $firstname = $cryptor->decrypt($user["first_name"]);
     $lastname =  $cryptor->decrypt($user["last_name"]); 
     $email = $cryptor->decrypt($user["email"]);  
     $phone = $cryptor->decrypt($user["phone"]);  


     closeConnection($link);
   
}

$username_err = $email_err = $firstname_err = $lastname_err = $phone_err = "";

function updateProfile ($user_auto_key){

     if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['updateProfile'])  ){
          global $username_err, $email_err, $firstname_err , $lastname_err, $phone_err;
          include_once "../../API/Database/security/encKey.php";
          $encryption_key = getKey(); //this will becoming from a file in root after deployment 
          $cipher_method = 'aes-256-cfb';
          $cryptor = new Cryptor($encryption_key, $cipher_method);

          $san = new  sanitization();
       
          // Validate username
          $conn = startConnection();
          $tempUsername = $san->sanitize_data(trim($_POST["username"]), 'string');
          if(empty($tempUsername)){
               $username_err = "Please enter a username.";
          } elseif(!preg_match('/^[a-zA-Z0-9_]+$/', trim($_POST["username"]))){
               $username_err = "Username can only contain letters, numbers, and underscores.";
       
          } else{
          
                    $sql = "SELECT USR_AUTO_KEY FROM user WHERE username = SHA2(?, 224) ";
          
                    $param_username = $tempUsername;
               
                    $result  = SafeRunSelect($conn, $sql, [$param_username]);
                    if($result !=null){
                         $row = mysqli_fetch_assoc($result);
                         if($user_auto_key!=$row['USR_AUTO_KEY']){
                         $username_err = "This username is already taken.";
                         }else{
                              //username should not be encrypted , instead it is hashed in the query
                              $username = $tempUsername; 
                              $username_enc = $cryptor->encrypt($username);
                         }
                        
                    } else{
                         //username should not be encrypted , instead it is hashed in the query
                         $username = $tempUsername; 
                         $username_enc = $cryptor->encrypt($username);
                    }
          }


          $tempFname = $san->sanitize_data(trim($_POST["firstname"]),'string');
          if(!ctype_alpha($tempFname) || empty($tempFname)){ 
              $firstname_err = "First name can only contain letters";
          }else if (empty($tempFname)){
              $firstname_err = "Last name can't be empty";
          }else{
               $firstname = $cryptor->encrypt($tempFname);
          }
  
          $tempLname = $san->sanitize_data(trim($_POST["lastname"]),'string');
          if(!ctype_alpha($tempLname) || empty($tempLname)){ 
              $lastname_err = "Last name can only contain letters";
          }else if (empty($tempLname)){
              $lastname_err = "Last name can't be empty";
          }
          else{
               $lastname = $cryptor->encrypt($tempLname);
          }

         

        
          //$lastname = $cryptor->encrypt($_POST["lastname"]);
          //$email = $_POST["email"];

          //validate email address
          $tempEmail = $san->sanitize_data(trim($_POST["email"]), 'email');
          if(empty($tempEmail)){
               $email_err = "Please enter an email.";
          }else{
               $sql = "SELECT USR_AUTO_KEY FROM user WHERE email_hash_Index = SHA2(?, 224) ";
          
               $param_email1 = trim($_POST["email"]);
          
               $result  = SafeRunSelect($conn, $sql, [$param_email1]);
               if($result !=null){
                    $row = mysqli_fetch_assoc($result);
                    if($user_auto_key!=$row['USR_AUTO_KEY']){
                         $email_err = "This email is already taken.";
                    }else{
                         $email = $tempEmail;
                         $param_email = $cryptor->encrypt($email);
                    }
               
               }else{
                         $email = $tempEmail;
                         $param_email = $cryptor->encrypt($email);
               }

          }


          
          //allows + - and numbers, removes other characters
          $phone = filter_var( trim($_POST["phone"]) , FILTER_SANITIZE_NUMBER_INT );
          $phone = $cryptor->encrypt($phone);
              
          
         



          if(empty($username_err) && empty($email_err) && empty($firstname_err) && empty($lastname_err) && empty($phone_err)){
               $sql = "UPDATE user SET username=SHA2(?, 224),username_enc=?,first_name=?,last_name=?,email=?,phone=?, email_hash_Index=SHA2(?, 224) where USR_AUTO_KEY = ?";
          
               $result = SafeRunUpdate($conn, $sql, [$username,$username_enc, $firstname, $lastname, $param_email, $phone, $email, $user_auto_key]);
               if($result==true){
                    $_SESSION['username'] = $_POST["username"];
                   // print_r($_POST);
                    if(strcmp($_POST['original_email'], $_POST['email'])!=0){
                    $sql = "UPDATE user SET verified = 0 WHERE USR_AUTO_KEY = ?";
                    $res = SafeRunUpdate($conn, $sql, [$user_auto_key]);
                    closeConnection($conn);
                    header("location: viewProfile.php?reverify=1");
                    exit();
                    }
                    closeConnection($conn);
                    header("location: viewProfile.php ");
                    exit();
                    
              
               }
               

          }
     }else if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['Cancel']) ) {
          header("Location: viewProfile.php");
          exit();
     }
}

?>
