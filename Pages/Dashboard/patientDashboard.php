

<?php
include_once "../../API/PatientAPI/general_func.php";
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$res = checkForPrevRecord($_SESSION['user_auto_key']);
if(!$res) {
   
    include_once "../../Pages/Forms/chooseSurvey.php";
}else{
    include "../../Components/general/dashboard.php";

}

//session_start();
//$username = $_SESSION['username'];
//console_log($username);
//console_log($_SESSION['username']. ' in patient dashboard');


?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>