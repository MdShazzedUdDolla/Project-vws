<link rel="stylesheet" href="../../Assets/vendor/bootstrap/css/bootstrap.css">
<link rel="stylesheet" type="text/css" href="../../Style/VWS_CSS/reg_verification.css">
<title>Consent submit form</title>
<?php 

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


require_once "../../API/Database/config.php";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    include_once "../../Components/general/loginRegNavbar.php";
    include_once "../../API/Database/security/sanitization.php";
    // create a new connection
    $conn = startConnection();
    $san = new  sanitization();
    //print_r($_POST);
    //sanitize to see if they are int
    $user_auto_key = $_POST['user_auto_key'];


    $agreement = 0;
    if(isset($_POST['option1'])){
        $agreement =  $san->sanitize_data($_POST['option1'], 'int'); 
    }
   
    if(isset($agreement) && is_numeric($agreement)==true  && $agreement==1){
         $answer1 = 1;
    }
    else {
        echo '<div class="alert alert-warning" role="alert">
        there was a problem with your consent form. Pleaase try again.
        </div>';
        die();
    }

    $invalidData = 0;

     $rec_email = 0;
     $email =  $address = NULL;
     if(isset($_POST['getEmailResult'])==true && isset($_POST['email'])==true && strcmp($_POST['email'], '')!=0 ){
        $rec_email = 1;
        $email = $san->sanitize_data($_POST['email'], 'email');
        $invalidData = $email == false  ? 1 : 0;
     }
   
    
     $rec_mail=0;
     if(isset($_POST['getMailResult'])==true && isset($_POST['address'])==true && strcmp($_POST['address'], '')!=0 ) {
        $rec_mail = 1;
       
        $address = $san->sanitize_data($_POST['address'], 'string');
        $invalidData =  $address == false ? 1 : 0;
        $address = $san->sanitize($address);
     }

    
     //TODDO:string sanitize 
     $sig1 = $_POST['sig1']; //participant signature required
     include_once "../../API/Database/security/encKey.php";
     include_once "../../API/Database/security/Cryptor.php";
     $encryption_key = getKey(); //this will becoming from a file in root after deployment 
     $cipher_method = 'aes-256-cfb';
     
 
     $cryptor = new Cryptor($encryption_key, $cipher_method);
    
     if($email!=null){
       
        $email=$cryptor->encrypt($email);
     }
     if($address!=null){
       
        $address=$cryptor->encrypt($address);
     }
    
     

    if($answer1== 1 &&  $invalidData==0){
        
     $sql = "INSERT INTO consent_record(CNR_AUTO_KEY, USR_AUTO_KEY,
     consentSigned, 
     receive_result_email, email_result,receive_mail_result , mail_address, sig_participant)
     VALUES (?,?, ? , ?,?,?,?,?) 
     on duplicate key update consentSigned=?, receive_result_email= ? ,email_result = ? ,receive_mail_result=? , mail_address=?, sig_participant=?";
    $result = SafeRunInsert($conn, $sql ,
    [NULL, $user_auto_key, $answer1,$rec_email,$email, $rec_mail, $address, $sig1, $answer1,$rec_email,$email, $rec_mail, $address, $sig1]);
       
    if($result==true){
    
     
       
        echo '<div id="main_cont">
            <br>
            <br>
            <span id="verification_text" >Registration completed</span>
            <br>
            <br>
           
               <a class="btn btn-primary" href="../../Pages/Profile/signin.php">Sign in</a>
            
        </div>';
  
        }else{
            echo "failed";
        }

    }else{
        //maybe tell something about them not being able to participate if they dont consent 
        echo '<div class="alert alert-warning" role="alert">
        there was a problem with your consent form. Pleaase try again.
        </div>';
        die();
    }
}
?>
