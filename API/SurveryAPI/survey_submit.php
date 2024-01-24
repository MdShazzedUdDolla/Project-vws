<link rel="stylesheet" href="../../Assets/vendor/bootstrap/css/bootstrap.css">
<link rel="stylesheet" type="text/css" href="../../Style/VWS_CSS/reg_verification.css">

<?php
require_once "../../API/Database/config.php";
include_once "../../API/Database/security/sanitization.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

  $san = new  sanitization();
       
  // create a new connection

  $conn = startConnection();

  $invalidData = 0;
  $errorString = "";
  $user_auto_key = $_POST['user_auto_key'];
  if (empty(trim($user_auto_key))) {
    $invalidData =1;
    $errorString .="usernameError=*Invalid username was provided";
    // header("Location: ../../Pages/Forms/surveyForm.php?usernameError=*Invalid username was provided");
    // exit("Invalid username was provided");
  }

  $dt = validateDate($_POST['age']);

  if($dt==true){
   
    $date_of_birth = $_POST['age'];
   
  }else{
    if($invalidData==1){
      $errorString .="&dateError=*Invalid date format was provided";
    }
    else{
      $errorString .="dateError=*Invalid date format was provided";
    }
    $invalidData=1;
  }
  
 
  $weight = $san->sanitize_data($_POST['weight'], 'float'); 
  if(is_numeric($weight)==false || $weight<=0){
    if($invalidData==1){
      $errorString .="&WeightError=*Invalid weight was provided";
    }
    else{
      $errorString .="WeightError=*Invalid weight was provided";
    }
    $invalidData=1;
  }
  $heartRate = $san->sanitize_data($_POST['heartRate'], 'int');
  if(is_numeric($heartRate)==false || $heartRate<=0 || $heartRate>300 ){
    if($invalidData==1){
      $errorString .="&heartRateError=*Invalid heartRate was provided";
    }
    else{
      $errorString .="heartRateError=*Invalid heartRate was provided";
    }
    $invalidData=1;
  }

  $bloodPressure_sys = $san->sanitize_data($_POST['bloodPressure_sys'], 'int');
  if(is_numeric($bloodPressure_sys)==false || $bloodPressure_sys<=0){
    if($invalidData==1){
      $errorString .="&bloodPressure_sysError=*Invalid bloodPressure_sys was provided";
    }
    else{
      $errorString .="bloodPressure_sysError=*Invalid bloodPressure_sys was provided";
    }
    $invalidData=1;
  }
  
  $bloodPressure_dias = $san->sanitize_data($_POST['bloodPressure_dias'], 'int');
  if(is_numeric($bloodPressure_dias)==false || $bloodPressure_dias<=0){
    if($invalidData==1){
      $errorString .="&bloodPressure_diasError=*Invalid bloodPressure_dias was provided";
    }
    else{
      $errorString .="bloodPressure_diasError=*Invalid bloodPressure_dias was provided";
    }
    $invalidData=1;
  }

  $rightScratchTest = $san->sanitize_data($_POST['rightScratchTest'], 'int'); 
  if(is_numeric($rightScratchTest)==false || $rightScratchTest < 0){
    if($invalidData==1){
      $errorString .="&rightScratchTestError=*Invalid rightScratchTest was provided";
    }
    else{
      $errorString .="rightScratchTestError=*Invalid rightScratchTest was provided";
    }
    $invalidData=1;
  }
 
  $leftScratchTest = $san->sanitize_data($_POST['leftScratchTest'], 'int'); 
  if(is_numeric($leftScratchTest)==false || $leftScratchTest < 0){
    if($invalidData==1){
      $errorString .="&leftScratchTestError=*Invalid leftScratchTest was provided";
    }
    else{
      $errorString .="leftScratchTestError=*Invalid leftScratchTest was provided";
    }
    $invalidData=1;
  }
  
  $leftHand = $san->sanitize_data($_POST['leftHand'], 'int'); 
  if(is_numeric($leftHand)==false || $leftHand<0){
    if($invalidData==1){
      $errorString .="&leftHandError=*Invalid leftHand was provided";
    }
    else{
      $errorString .="leftHandError=*Invalid leftHand was provided";
    }
    $invalidData=1;
  }
 
  $rightHand = $san->sanitize_data($_POST['rightHand'], 'int'); 
  if(is_numeric($rightHand)==false || $rightHand<0){
    if($invalidData==1){
      $errorString .="&rightHandError=*Invalid rightHand was provided";
    }
    else{
      $errorString .="rightHandError=*Invalid rightHand was provided";
    }
    $invalidData=1;
  }
 
  $plankTime = $san->sanitize_data($_POST['plankTime'], 'int'); 
  if(is_numeric($plankTime)==false || $plankTime<0){
    if($invalidData==1){
      $errorString .="&plankTimeError=*Invalid plankTime was provided";
    }
    else{
      $errorString .="plankTimeError=*Invalid plankTime was provided";
    }
    $invalidData=1;
  }
 
  $invalidRange = $_POST['EnduranceRPE']!=0 && ($_POST['EnduranceRPE']<6 || $_POST['EnduranceRPE'] >22);
  $PlankRPE = $san->sanitize_data($_POST['EnduranceRPE'], 'int');
  if(is_numeric($PlankRPE)==false || $PlankRPE<0 || $invalidRange==true){
    if($invalidData==1){
      $errorString .="&EnduranceRPEError=*Invalid EnduranceRPE was provided";
    }
    else{
      $errorString .="EnduranceRPEError=*Invalid EnduranceRPE was provided";
    }
    $invalidData=1;
  }
 
  $leftAnkle = $san->sanitize_data($_POST['leftAnkle'], 'int');
  if(is_numeric($leftAnkle)==false || $leftAnkle < 0 ){
    if($invalidData==1){
      $errorString .="&leftAnkleError=*Invalid leftAnkle was provided";
    }
    else{
      $errorString .="leftAnkleError=*Invalid leftAnkle was provided";
    }
    $invalidData=1;
  }

  $rightAnkle = $san->sanitize_data($_POST['rightAnkle'], 'int');
  if(is_numeric($rightAnkle)==false || $rightAnkle<0){
    if($invalidData==1){
      $errorString .="&rightAnkleError=*Invalid rightAnkle was provided";
    }
    else{
      $errorString .="rightAnkleError=*Invalid rightAnkle was provided";
    }
    $invalidData=1;
  }

  $tandemOpen = $san->sanitize_data($_POST['tandemOpen'], 'int');
  if(is_numeric($tandemOpen)==false || $tandemOpen<0){
    if($invalidData==1){
      $errorString .="&tandemOpenError=*Invalid tandemOpen was provided";
    }
    else{
      $errorString .="tandemOpenError=*Invalid tandemOpen was provided";
    }
    $invalidData=1;
  }

  $tandemClosed = $san->sanitize_data($_POST['tandemClosed'], 'int');
  if(is_numeric($tandemClosed)==false || $tandemClosed < 0){
    if($invalidData==1){
      $errorString .="&tandemClosedError=*Invalid tandemClosed was provided";
    }
    else{
      $errorString .="tandemClosedError=*Invalid tandemClosed was provided";
    }
    $invalidData=1;
  }

  $totalOpen = $san->sanitize_data($_POST['totalOpen'], 'int');
  if(is_numeric($totalOpen)==false || $totalOpen <0){
    if($invalidData==1){
      $errorString .="&totalOpenError=*Invalid totalOpen was provided";
    }
    else{
      $errorString .="totalOpenError=*Invalid totalOpen was provided";
    }
    $invalidData=1;
  }

  $totalClosed = $san->sanitize_data($_POST['totalClosed'], 'int');
  if(is_numeric($totalClosed)==false || $totalClosed<0){
    if($invalidData==1){
      $errorString .="&totalClosedError=*Invalid totalClosed was provided";
    }
    else{
      $errorString .="totalClosedError=*Invalid totalClosed was provided";
    }
    $invalidData=1;
  }

  $leftOpen = $san->sanitize_data($_POST['leftOpen'], 'int');
  if(is_numeric($leftOpen)==false || $leftOpen<0){
    if($invalidData==1){
      $errorString .="&leftOpenError=*Invalid leftOpen was provided";
    }
    else{
      $errorString .="leftOpenError=*Invalid leftOpen was provided";
    }
    $invalidData=1;
  }
 

  $leftClosed = $san->sanitize_data($_POST['leftClosed'], 'int');
  if(is_numeric($leftClosed)==false || $leftClosed<0){
    if($invalidData==1){
      $errorString .="&leftClosedError=*Invalid leftClosed was provided";
    }
    else{
      $errorString .="leftClosedError=*Invalid leftClosed was provided";
    }
    $invalidData=1;
  }
 
  $rightOpen = $san->sanitize_data($_POST['rightOpen'], 'int');
  if(is_numeric($rightOpen)==false || $rightOpen < 0){
    if($invalidData==1){
      $errorString .="&rightOpenError=*Invalid rightOpen was provided";
    }
    else{
      $errorString .="rightOpenError=*Invalid rightOpen was provided";
    }
    $invalidData=1;
  }
 
  $rightClosed = $san->sanitize_data($_POST['rightClosed'], 'int');
  if( is_numeric($rightClosed)==false || $rightClosed < 0){
    if($invalidData==1){
      $errorString .="&rightClosedError=*Invalid rightClosed was provided";
    }
    else{
      $errorString .="rightClosedError=*Invalid rightClosed was provided";
    }
    $invalidData=1;
  }

  $walkingTimeMin = $san->sanitize_data($_POST['walkingTime'], 'int');
  $walkingTimeSec = $san->sanitize_data($_POST['walkingTimeSec'], 'int');
  if(is_numeric($walkingTimeSec)==false || is_numeric($walkingTimeMin)==false || $walkingTimeMin < 0 || $walkingTimeSec < 0){
    if($invalidData==1){
      $errorString .="&walkingTimeError=*Invalid walkingTime was provided";
    }
    else{
      $errorString .="walkingTimeError=*Invalid walkingTime was provided";
    }
    $invalidData=1;
  }else{
    $walkingTime = $walkingTimeMin*60 + $walkingTimeSec;
  }
  
  $PostWalkHeartRate = $san->sanitize_data($_POST['PostWalkHeartRate'], 'int');
  if(is_numeric($PostWalkHeartRate)==false || $PostWalkHeartRate < 0){
    if($invalidData==1){
      $errorString .="&PostWalkHeartRateError=*Invalid PostWalkHeartRate was provided";
    }
    else{
      $errorString .="PostWalkHeartRateError=*Invalid PostWalkHeartRate was provided";
    }
    $invalidData=1;
  }


  $invalidRange = $_POST['RPE']!=0 && ($_POST['RPE']<6 || $_POST['RPE'] >22);
  $RPE = $san->sanitize_data($_POST['RPE'], 'float');
  if(is_numeric($RPE)==false || $RPE<0 || $invalidRange==true){
    if($invalidData==1){
      $errorString .="&RPEError=*Invalid RPE was provided";
    }
    else{
      $errorString .="RPEError=*Invalid RPE was provided";
    }
    $invalidData=1;
  }
  
  $sex = $san->sanitize_data($_POST['sex'], 'int'); 
  if(!($sex==1 ||$sex==2 )){
    if($invalidData==1){
      $errorString .="&SexError=*Invalid gender was provided";
    }
    else{
      $errorString .="SexError=*Invalid gender was provided";
    }
    $invalidData=1;
  }
 
 
  include_once "../Database/security/encKey.php";
  include_once "../Database/security/Cryptor.php";
  $encryption_key = getKey(); //this will becoming from a file in root after deployment 
  $cipher_method = 'aes-256-cfb';
  $cryptor = new Cryptor($encryption_key, $cipher_method);
 
  $comment = $san->sanitize_data($_POST['comments'], 'string');
  $comment = $san->sanitize($comment);
  echo $comment;
  $comment = $cryptor->encrypt($comment) ;

 
  $vo2 = $san->sanitize_data($_POST["VO2"], 'float');
  if(is_numeric($vo2)==false || $vo2 < 0){
    if($invalidData==1){
      $errorString .="&VO2Error=*Invalid VO2 was provided";
    }
    else{
      $errorString .="VO2Error=*Invalid VO2 was provided";
    }
    $invalidData=1;
  }

  if($invalidData==1){
     header("Location: ../../Pages/Forms/surveyForm.php?$errorString");
    // print_r($_POST);
     exit("$errorString");
  }

  $sql1 = "INSERT INTO basic_info(BSI_AUTO_KEY, USR_AUTO_KEY, bloodPressure_sys, bloodPressure_dias, weight, Resting_Heart_Rate, date_of_birth) 
     VALUES (?, ?, ? ,?, ?, ?,?);";
  //first insert the basic information into the basic_info table
  $result = SafeRunInsert($conn, $sql1, [NULL, $user_auto_key, $bloodPressure_sys, $bloodPressure_dias, $weight, $heartRate, $date_of_birth]);
  $BSI_AUTO_KEY =  mysqli_insert_id($conn); //the auto increment identifier of last inserted

  //print_r([NULL, $user_auto_key, $bloodPressure_sys, $bloodPressure_dias, $weight, $heartRate, $date_of_birth]);
  //check if it was successful
  if ($result == true) {
    //echo "SUCCESS 1";
    $sql = "INSERT INTO 
        functional_capacity_record
        (FNR_AUTO_KEY,USR_AUTO_KEY, BSI_AUTO_KEY, Lback_scratch, Rback_scratch, Lgrip_strength, Rgrip_strength,Plank_Duration, Plank_RPE, Lankle_test, Rankle_test, comment)
                            VALUES (?,?,?,?,?,?,?,?,?,?,?,?)";
    $result = SafeRunInsert($conn, $sql, [
      NULL, $user_auto_key, $BSI_AUTO_KEY, $leftScratchTest, $rightScratchTest,
      $leftHand, $rightHand, $plankTime, $PlankRPE, $leftAnkle, $rightAnkle, $comment
    ]);

    // print_r([
    //   NULL, $user_auto_key, $BSI_AUTO_KEY, $leftScratchTest, $rightScratchTest,
    //   $leftHand, $rightHand, $plankTime, $PlankRPE, $leftAnkle, $rightAnkle, $comment
    // ]);
    $FNR_AUTO_KEY = mysqli_insert_id($conn);
    if ($result == true) {
      //echo "SUCCESS 2";
      $sql = "INSERT INTO aerobic_cardiovascular_fitness(ACF_AUTO_KEY, FNR_AUTO_KEY, time_completed, RPE, sex, PostWalkHeartRate, VO2 )
            VALUES (?,?,?,?,?,?,?)";
      $result = SafeRunInsert($conn, $sql, [NULL, $FNR_AUTO_KEY, $walkingTime, $RPE, $sex, $PostWalkHeartRate, $vo2]);
      
      //print_r([NULL, $FNR_AUTO_KEY, $walkingTime, $RPE, $sex, $PostWalkHeartRate, $vo2]);
      if ($result == true) {
        //echo "SUCCESS 3";
        $sql = "INSERT INTO timed_balancing_test(TBT_AUTO_KEY, FNR_AUTO_KEY, tandon_eye_open, tandon_eye_close, LLeg_eye_open, LLeg_eye_close,
                 RLeg_eye_open, RLeg_eye_close, total_eye_open, total_eye_close)
                 VALUES (?,?,?,?,?,?,?,?,?,?)";
        $result = SafeRunInsert($conn, $sql, [NULL, $FNR_AUTO_KEY, $tandemOpen, $tandemClosed, $leftOpen, $leftClosed, $rightOpen, $rightClosed, $totalOpen, $totalClosed]);

       // print_r( [NULL, $FNR_AUTO_KEY, $tandemOpen, $tandemClosed, $leftOpen, $leftClosed, $rightOpen, $rightClosed, $totalOpen, $totalClosed]);
        closeConnection($conn);

        header("location: ../../Pages/Forms/thankyou.php ");
        exit("Thanks for submitting the form");
      }
    }
  } else {
    echo '<div class="alert alert-danger" role="alert">
      Something went wrong. Please try again.
      <a class="btn btn-primary" href="../../Pages/Dashboard/patientDashboard.php">Go back to Dashboard</a>
      </div>';
  }
}

function validateDate($date, $format = 'Y-m-d'){
  $d = DateTime::createFromFormat($format, $date);
  return $d && $d->format($format) === $date;
}
?>