<link rel="stylesheet" href="../../Assets/vendor/bootstrap/css/bootstrap.css">

<?php 
ini_set('max_execution_time', 300); //max run time for 5, increase to send more emails. 

include "../../API/PhysiciansAPI/communication_information.php";
require_once "../../API/Database/config.php";
require "../../Assets/vendor/autoload.php";
include_once "../../API/AdminAPI/emailSender.php";
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if($_SERVER["REQUEST_METHOD"] == "POST"){

    // create a new connection
    $conn = startConnection();

$title = $_POST['title'];
$message = $_POST['message'];

//$mail = new PHPMailer(true);
try {

$mailObjArray = array();
  $mail = createNewMailObj("Study Result");
  array_push($mailObjArray, $mail);
  // All Recipients
  /** Free Gmail account — If you use a free Gmail account, you are limited to sending a maximum of 500 emails in a 24-hour period, 
   * and a maximum of 100 addresses per email. Paid Google Workspace account — 
   * If you use a paid Google Workspace account, you are limited to sending a maximum of 2,000 emails in a 24-hour period**/
  $limitRecepient = 5;
  $count = 0;
 
  if (isset($_POST['radio-group']) && $_POST['radio-group'] === 'all') {
  $emails = getEmailAddresses('consent_record');
  if (!empty($emails)) {
      foreach ($emails as $email) {
          $email = trim($email);
          if (!empty($email)) {
            
            if($count < $limitRecepient){
                $mail->addAddress($email);
                $count++;
            }else{
                $count = 0;
                $mail = createNewMailObj("Study Result");
                array_push($mailObjArray, $mail);
                //make a new mail object and add it an array 
            }
            
          }
      }
  }
}
//Email address of selected participants
if (isset($_POST['radio-group']) && $_POST['radio-group'] === 'user-filter') {
    $selected_participants = $_POST['partic'];
    $emails = getEmailsForSelectedParticipants($selected_participants);
    if (!empty($emails)) {
        foreach ($emails as $email) {
            $email = trim($email);
            if (!empty($email)) {
                $mail->addAddress($email);
            }
        }
    }
  }


  if(isset($_FILES['attachment']) && !empty($_FILES['attachment']['name'])){
    $file_name = $_FILES['attachment']['name'];
    $file_tmp = $_FILES['attachment']['tmp_name'];
    $file_size = $_FILES['attachment']['size'];
    $file_type = $_FILES['attachment']['type'];
    $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

    // Check if the file is a PDF
    if ($file_ext !== 'pdf') {
        echo 'Error: Only PDF files are allowed';
        exit;
    }


   $mailObjArray = attachFile($mailObjArray, $file_tmp,$file_name);
  
   $body = "Title: $title<br> Message: $message<br> Attachment: $file_name<br>";
   $mailObjArray = setEmailBody($mailObjArray, $body);
} else {
  
   $body = "Title: $title<br> Message: $message<br>";
   $mailObjArray = setEmailBody($mailObjArray, $body);
}


sendMail($mailObjArray);

header("location: ../../Pages/Dashboard/messageSent.php");
exit("Message has been sent");
}
 catch (Exception $e) {
 // echo "Message could not be sent. Error: {$mail->ErrorInfo}";
 
 $errors = seeErrors($mailObjArray);
  header("location: ../../Pages/Dashboard/communicationDashboard.php?Error=Something went wrong. Please try again.$errors");
  exit("Message could not be sent.");
}
}
?>