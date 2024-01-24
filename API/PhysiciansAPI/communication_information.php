<?php 
include_once "../../API/Database/config.php";
include "../../API/AdminApi/debug.php";

function getParticipant($tableNameForSurvey){
    $conn = startConnection();
    $sql ="SELECT DISTINCT (SELECT CONCAT(u.first_name,' ', u.last_name) from user as u where fc.USR_AUTO_KEY = u.USR_AUTO_KEY ) as participant, fc.USR_AUTO_KEY FROM $tableNameForSurvey as fc  WHERE fc.receive_result_email = 1;";
    $result  = runSelect($conn, $sql);
    /*
    $html ='<select class="form-select" name="selected_participant" id="selected_participant" role="">';
    $html .= "<option hidden selected >Select participant</option>";
    */
    $html = '';
    if($result != null){
        include_once "../../API/Database/security/encKey.php";
        include_once "../../API/Database/security/Cryptor.php";
        $encryption_key = getKey(); //this will becoming from a file in root after deployment 
   
        $cipher_method = 'aes-256-cfb';
   
        $cryptor = new Cryptor($encryption_key, $cipher_method);

        while ($row = $result->fetch_assoc()){
            $names_enc = array();
            
            if (isset($row['participant']) && strpos($row['participant'], ' ') !== false) {
                $names_enc = explode(' ', $row['participant']);
            }else{
                continue;
            }
            
            $first_name = $cryptor->decrypt($names_enc[0]);
            $second_name = $cryptor->decrypt($names_enc[1]);
            $username = $row['USR_AUTO_KEY'];
            $html .= "<li><label><input type=checkbox value=" . $username . ':' . $first_name . ' ' . $second_name . ' ' . 'name=partic[]/>' . $first_name . ' ' . $second_name . '</label>' . '</li>';
           // $html .= "<option value='".$username.':'.$first_name . $second_name."'>".$first_name . ' ' . $second_name."</option>";
        }
        closeConnection($conn);
    }
    //console_log($html);
    $html .= '</select>';
    return $html;
}

function getEmailAddresses($tableNameForSurvey) {
    $conn = startConnection();
    $sql = "SELECT DISTINCT fc.email_result FROM $tableNameForSurvey as fc WHERE fc.receive_result_email = 1";
    $result  = runSelect($conn, $sql);
    $emails = array();
    if($result != null){
        include_once "../../API/Database/security/encKey.php";
        include_once "../../API/Database/security/Cryptor.php";
        $encryption_key = getKey(); //this will becoming from a file in root after deployment 
        $cipher_method = 'aes-256-cfb';
        $cryptor = new Cryptor($encryption_key, $cipher_method);
        while ($row = $result->fetch_assoc()){
            if(!isset($row['email_result'])){ continue;}
            $email=$cryptor->decrypt($row['email_result']);
            array_push($emails, $email);
        }
        closeConnection($conn);
    }
    return $emails;
}

function getEmailsForSelectedParticipants($selectedParticipants) {
    $conn = startConnection();

    // Convert the selected participants array into a comma-separated list of user IDs
    $participantIds = implode(',', array_map(function($participant) {
        $parts = explode(':', $participant);
        return count($parts) >= 2 ? $parts[0] : ''; // Check that the array has at least two elements
    }, $selectedParticipants));


    // Build and execute the SQL query to retrieve the email addresses for the selected participants
    $sql = "SELECT email_result FROM consent_record WHERE receive_result_email = 1 AND USR_AUTO_KEY IN ($participantIds)";
    $result = runSelect($conn, $sql);

    $emails = array();
    if ($result != null) {
        // Extract the email addresses from the query results and add them to the emails array
        include_once "../../API/Database/security/encKey.php";
        include_once "../../API/Database/security/Cryptor.php";
        $encryption_key = getKey(); //this will becoming from a file in root after deployment 
        $cipher_method = 'aes-256-cfb';
        
    
        $cryptor = new Cryptor($encryption_key, $cipher_method);
        
        while ($row = $result->fetch_assoc()) {
            $email=$cryptor->decrypt($row['email_result']);
            array_push($emails,$email);
        }
        closeConnection($conn);
    }

    return $emails;
}
?>