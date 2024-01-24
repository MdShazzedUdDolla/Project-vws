


<?php 

// The relative path to the file you want to send the request to
$relative_path = 'VWS/API/SurveryAPI/survey_submit.php';

// The full URL of the file
//https://stackoverflow.com/questions/6560512/send-http-request-with-curl-to-local-file
$url  = 'http://localhost:8000/API/SurveryAPI/survey_submit.php';
//'https://' . $_SERVER['HTTP_HOST'] . '/' . $relative_path;

//run the test like this : php -f /path/to/curl/script.php
//echo $url;

// Data to send in the request body
$data = array(

    "user_auto_key" => 35,
    "age"=>"2023-02-07",
    "weight"=>60,
    "heartRate"=>110,
    "bloodPressure_sys"=>100,
    "bloodPressure_dias"=>100,
    "rightScratchTest"=>15,
    "leftScratchTest"=>17,
    "leftHand"=>10,
    "rightHand"=>10,
    "plankTime"=>10,
   // "scale"=>10,
    "leftAnkle"=>20,
    "rightAnkle"=>20,
    "tandemOpen"=>20,
    "tandemClosed"=> 30,

    "totalOpen"=>30,
    "leftOpen"=>40,
    "leftClosed"=>50,

    "rightOpen"=>50,
    "rightClosed"=>30,
    "totalClosed"=>30,
  //  "walkingTime"=>30,
    "RPE"=>10,
    "sex" => 1,
    "comments"=> "nth",



);

// Encode the data as JSON
// $data_json = json_encode($data);


// Initialize a cURL session
$ch = curl_init($url);

// Set the request method to POST
curl_setopt($ch, CURLOPT_POST, true);

// Set the POST data
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

// Set the response to be returned as a string
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// Execute the cURL request
$response = curl_exec($ch);

// Check for errors
if (curl_errno($ch)) {
    // An error occurred
    echo 'cURL error: ' . curl_error($ch);
} else {
    // The request was successful
    print ($response) ;
   // $fp = fopen("logs.log", 'a')or die("Unable to open file!");
    $title = "\n ================= Running Test for Survey database functions . Date : " . date("Y-m-d"). "=================";
    
   // file_put_contents("logs2.log", $response);
   

     //fwrite($fp,$title);
     if(str_contains($response, "Form submitted successfully")){
       // fwrite($fp, "Form submitted successfully");
        file_put_contents("logs2.log", $title."\nForm submitted successfully.");
     }else{
        file_put_contents("logs2.log", $title."\nTest Failed. Here is the complete response : ". $response);
     }
    
   // fclose($fp);
    

   
}

// Close the cURL session
curl_close($ch);





?>