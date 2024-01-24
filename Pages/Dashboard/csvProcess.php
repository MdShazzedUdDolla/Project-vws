

<?php
    /*
    header('Content-Description: File Transfer');
    header('Content-Type: application/csv');
    header("Content-Disposition: attachment; filename=page-data-export.csv");
    header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
    $handle = fopen('php://output', 'w');
    ob_clean(); // clean slate
    include_once "../../API/Database/config.php";
    include_once "../../API/Database/security/Cryptor.php";
    //TODO: implement not pulling a profile when admin is pulling data for multiple users
    //$user_auto = $_GET['user_auto_key'];
    //$username = $_GET['username'];
    $conn = startConnection();
    $data = $_GET['data'];
    $count = 0;

    foreach($data as $key => $value){

      $cond = $key != 'csv' && $key != 'mult_flag' && $key != 'data' && $key != 'names';

      if(is_numeric($key) && $key != 'csv' && ($key != 'male' && $key != 'female')){
        $sql = "SELECT u.first_name, u.last_name, u.phone, u.email FROM user as u where u.USR_AUTO_KEY = ?";
        $userResult = SafeRunSelect($conn, $sql , [$key]);
        if($userResult!=null){
            include_once "../../API/Database/security/encKey.php";
            $encryption_key = getKey(); //this will becoming from a file in root after deployment 
            $cipher_method = 'aes-256-cfb';
            $cryptor = new Cryptor($encryption_key, $cipher_method);
            $user = mysqli_fetch_assoc($userResult); 
            $firstname = $cryptor->decrypt($user["first_name"]);
            $lastname =  $cryptor->decrypt($user["last_name"]); 
            $email = $cryptor->decrypt($user["email"]);  
            $phone = $cryptor->decrypt($user["phone"]);
            fputcsv($handle, ['Patient profile:']);
            fputcsv($handle, ["First name","Last name", "Email", "Phone"]);
            fputcsv($handle, [$firstname, $lastname, $email, $phone]);
        }
    }
       if($cond && is_numeric($key) == false){
            fputcsv($handle, ["Health Data Summary:"]);
            //$count++;
        }
        //foreach($data as $key => $value){
        if($cond){
            if($key == 'male' || $key == 'female'){
              fputcsv($handle, ["Gender Averages"]);
              fputcsv($handle, [$key]);
                foreach($value as $key => $inner_value){
                fputcsv($handle, [$key]);
                fputcsv($handle, $inner_value);
                }
            }
            else if($multiple_users){
                fputcsv($handle, [$data['data'][0]]);
                fputcsv($handle, $value);
            }else{
                if(is_numeric($key) == false){
                    fputcsv($handle, [$key]);
                    fputcsv($handle, $value);
                }
            }
                
        }
        //}
        //}//$result = $_GET['data'];
   }
    ob_flush(); // dump buffer
    fclose($handle);
    die();
    */		
?>


<?php

header('Content-Description: File Transfer');
header('Content-Type: application/csv');
header("Content-Disposition: attachment; filename=page-data-export.csv");
header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
$handle = fopen('php://output', 'w');
ob_clean(); // clean slate
include_once "../../API/Database/config.php";
include_once "../../API/Database/security/Cryptor.php";
//$user_auto = $_GET['user_auto_key'];
//$username = $_GET['username'];
$conn = startConnection();
$data = $_GET['data'];
$session = $_GET['session'];
$key = $session['user_auto_key'];
$count = 0;

    foreach($data as $entry){
        if(empty($entry['key'])){
            break;
        }
        $sql = "SELECT u.first_name, u.last_name, u.phone, u.email FROM user as u where u.USR_AUTO_KEY = ?";
        $userResult = SafeRunSelect($conn, $sql , [$entry['key']]);
        if($userResult!=null){
            include_once "../../API/Database/security/encKey.php";
            $encryption_key = getKey(); //this will becoming from a file in root after deployment 
            $cipher_method = 'aes-256-cfb';
            $cryptor = new Cryptor($encryption_key, $cipher_method);
            $user = mysqli_fetch_assoc($userResult); 
            $firstname = $cryptor->decrypt($user["first_name"]);
            $lastname =  $cryptor->decrypt($user["last_name"]); 
            $email = $cryptor->decrypt($user["email"]);  
            $phone = $cryptor->decrypt($user["phone"]);
            fputcsv($handle, ['Patient profile:']);
            fputcsv($handle, ["First name","Last name", "Email", "Phone"]);
            fputcsv($handle, [$firstname, $lastname, $email, $phone]);
        }
    }

    fputcsv($handle, ["Dates"]);
    $dates = array();
    foreach ( $entry['date'] as $date ){
        array_push( $dates,$date);
    }
    fputcsv($handle, $dates);



$count_once = 0;
$initial_hm = '';
foreach ($data as $entry) {
    fputcsv($handle, ["Health Measure"]);
    fputcsv($handle, [$entry['name']]);
    if($count_once == 0){
        fputcsv($handle, [$entry['hm']]);
        $initial_hm = $entry['hm'];
        $count_once++;
    }
    else if($count_once > 0){
        if($entry['hm'] == ''){
            fputcsv($handle, [$initial_hm]);
        }else{
            fputcsv($handle, [$entry['hm']]);
        }
    }
    $dataRow = array();
    foreach ($entry['data'] as $data){
        array_push($dataRow,$data); 
    }
    fputcsv($handle, $dataRow);
    
}

ob_flush(); // dump buffer
fclose($handle);
die();


?>