

<?php 
include_once "../Database/config.php";
include_once "../Database/security/sanitization.php";
if($_SERVER["REQUEST_METHOD"] == "POST"){
   
    $san = new  sanitization();
   
    $validInput = true;
    $user_auto_key =  $san->sanitize_data($_POST["user_auto_key"], 'int');
    $Scale1 =  $san->sanitize_data($_POST["Scale1"], 'int');
    $Scale2 =  $san->sanitize_data($_POST["Scale2"], 'int');
    $Scale3 = $san->sanitize_data($_POST["Scale3"], 'int');
    $Scale4 = $san->sanitize_data($_POST["Scale4"], 'int');
    $Scale4  = reverseScore($Scale4);
    $Scale5 = $san->sanitize_data($_POST["Scale5"], 'int');
    $Scale5 = reverseScore($Scale5);
    $Scale6 = $san->sanitize_data($_POST["Scale6"], 'int');
    $Scale7 = $san->sanitize_data($_POST["Scale7"], 'int');
    $Scale7 = reverseScore($Scale7);
    $Scale8 = $san->sanitize_data($_POST["Scale8"], 'int');
    $Scale8 = reverseScore($Scale8);
    $Scale9 = $san->sanitize_data($_POST["Scale9"], 'int');
    $Scale10 = $san->sanitize_data($_POST["Scale10"], 'int');


 //echo $Scale1 . $Scale2 . $Scale3 . $Scale4 . $Scale5 . $Scale6 . $Scale7 . $Scale8 . $Scale9 . $Scale10;
//get the rest of scales
    $validInput = is_numeric_array([$Scale1 , $Scale2 , $Scale3 , $Scale4 , $Scale5 , $Scale6 , $Scale7 , $Scale8 , $Scale9 ,  $Scale10]);
    if($validInput==false){
        echo '<div class="alert alert-danger" role="alert">
        Something went wrong. Please try again.
        <a class="btn btn-primary" href="../../Pages/Dashboard/patientDashboard.php">Go back to Dashboard</a>
        </div>';
        exit;
    }
    
    $answer = $Scale1 + $Scale2 + $Scale3 + $Scale4 + $Scale5 + $Scale6 + $Scale7 + $Scale8 + $Scale9 +  $Scale10;
    $conn = startConnection();
    $sql = "INSERT INTO `perceived_stress_record`( `USR_AUTO_KEY`, `Q1_ans`, `Q2_ans`, `Q3_ans`, `Q4_ans`, 
    `Q5_ans`, `Q6_ans`, `Q7_ans`, `Q8_ans`, `Q9_ans`, `Q10_ans`, `calculatedResult`) 
    VALUES (?,?,?,?,?,?,?,?,?,?,?,?)";
    $result = SafeRunInsert($conn, $sql, [$user_auto_key, $Scale1 , $Scale2,$Scale3,$Scale4,$Scale5,$Scale6,$Scale7,$Scale8,$Scale9,$Scale10 , $answer]);
//do the insert in database
// 
// Scores ranging from 0-13 would be considered low stress.
// Scores ranging from 14-26 would be considered moderate stress.
// Scores ranging from 27-40 would be considered high perceived stress.
if($result==true){

 
   
    
    if($answer<14){ 
        $response = '<div class=" alert-warning" role="alert">Your stress level is low. Your score was'.$answer.'
        </div>';
        $enc_response = base64_encode($response);
    }
    if($answer>=14 && $answer<27){ 
        $response = '<div class=" alert-success" role="alert">Your stress level is moderate. Your score was '. $answer.
        '</div>';
        $enc_response = base64_encode($response);
    }
    if($answer>=27 && $answer<41){ 
        $response = '<div class=" alert-danger" role="alert">Your stress level is high. Your score was '. $answer.'
        </div>';
        $enc_response = base64_encode($response);
    }
    header("location: ../../Pages/Forms/thankyou.php?response=$enc_response");
    exit("Thanks for submitting the form $answer");
}else{
    //show error message
    echo '<div class="alert alert-danger" role="alert">
    Something went wrong. Please try again.
    <a class="btn btn-primary" href="../../Pages/Dashboard/patientDashboard.php">Go back to Dashboard</a>
    </div>';
}



}
function reverseScore($score){
    if(is_numeric($score)==false){
        return false;
    }
    switch($score){
        case 0: return 4;
        case 1: return 3;
        case 2 : return 2;
        case 3: return 1;
        case 4: return 0;
    }
    }

    function is_numeric_array($array) {
        foreach ($array as $value) {
          if (!is_numeric($value)) {
            return false;
          }
        }
        return true;
      }
?>               