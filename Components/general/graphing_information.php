<?php 
include_once "../../API/Database/config.php";
include "../../API/AdminApi/debug.php";





/* <!--
<li>
<label>
  <input type="checkbox" value="Vejle" name="city" />Milwaukee</label>
</li>
<li>
<label>
  <input type="checkbox" value="Horsens" name="city" />Denver</label>
</li>
<li>
<label>
  <input type="checkbox" value="Kolding" name="city" />Boston</label>
</li>
<li>
<label>
  <input type="checkbox" value="Kolding" name="city" />LA</label>
</li>
*/
function getTerms(){
    $conn = startConnection();
    $sql = "Select * from terms";
    $result  = runSelect($conn, $sql);
    $html ="";
    if($result != null){
        while ($row = $result->fetch_assoc()){
            //$html .= "<option value='".$row['TRM_AUTO_KEY']."'>".$row['term']."</option>";
            $html .= "<li><label><input type=checkbox value=".$row['TRM_AUTO_KEY'].' '.'name='.$row['term'].'/>'. $row['term'].'</label>'.'</li>';
        }
        closeConnection($conn);
    }
   // console_log($html);
    return $html;
}
//functional_capacity_record
function getParticipant($tableNameForSurvey){
    $conn = startConnection();
    $sql ="SELECT DISTINCT (SELECT CONCAT(u.first_name,' ', u.last_name) from user as u where fc.USR_AUTO_KEY = u.USR_AUTO_KEY ) as participant, fc.USR_AUTO_KEY FROM $tableNameForSurvey as fc;";
    $result  = runSelect($conn, $sql);

    $html = '';
    if($result != null){
        include_once "../../API/Database/security/encKey.php";
        include_once "../../API/Database/security/Cryptor.php";
        $encryption_key = getKey(); //this will becoming from a file in root after deployment 
   
        $cipher_method = 'aes-256-cfb';
   
        $cryptor = new Cryptor($encryption_key, $cipher_method);

        while ($row = $result->fetch_assoc()){
            $names_enc = explode(' ', $row['participant']);
            $first_name = $cryptor->decrypt($names_enc[0]);
            $second_name = $cryptor->decrypt($names_enc[1]);
            $username = $row['USR_AUTO_KEY'];
            $html .= "<li><label><input type=checkbox value=" . $username . ':' . $first_name . ' ' . $second_name . ' ' . 'name=partic[]/>' . $first_name . ' ' . $second_name . '</label>' . '</li>';
           // $html .= "<option value='".$username.':'.$first_name . $second_name."'>".$first_name . ' ' . $second_name."</option>";
        }
        closeConnection($conn);
    }
   // console_log($html);
    $html .= '</select>';
    return $html;
}


function getHealthInformation($tableNameForSurvey, $csv = false){
    error_reporting(E_ALL ^ E_WARNING); 
    $conn = startConnection();
    $sql = "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME IN ('functional_capacity_gpuser_date') and COLUMN_NAME not in( 'USR_AUTO_KEY', 'TIME_ADD_UPDATE', 'username', 'first_name', 'last_name', 'DATE_ENTRY' ); ";
    $result = runSelect($conn, $sql);
    $html = '';
    if ($result != null) {
        while ($row = $result->fetch_array()) {
          if(strpos($row[0], '_KEY') || $row[0] == 'sex' || $row[0] == 'formula_result' || $row[0] == 'time_completed' || $row[0] == 'TIME_ADD_UPDATE' || $row[0] == 'comment' || $row[0] == 'date_of_birth'){
            continue;
          } else {

            if($csv){
              $html .= "<li><label><input type=checkbox value=" . $row[0] . ' ' . 'name=csv_info[]/>' . $row[0] . '</label>' . '</li>';
            } else {
              $html .= "<li><label><input type=checkbox value=" . $row[0] . ' ' . 'name=hm[]/>' . $row[0] . '</label>' . '</li>';
            }
          }
        }
      }

    return $html;
}


function getHealthValues($healthMeasure, $username, $before_date, $after_date, $admin, $multiple_users = false){

   $conn = startConnection();

  if($username == "Select participant"){
    return array();
  }

  $sql = '';
    $fix_after_date = $after_date . ' 23:59:59';

    if($before_date == null || $after_date == null){
      $sql .= "SELECT $healthMeasure  FROM functional_capacity_gpuser_date where USR_AUTO_KEY = $username";
    }
    else{
      $sql .= "SELECT $healthMeasure FROM functional_capacity_gpuser_date where USR_AUTO_KEY = $username and TIME_ADD_UPDATE >= '$before_date' and TIME_ADD_UPDATE <= '$fix_after_date'";
    }

  $result = runSelect($conn, $sql);

  if($result == null){
    return array();
  }




    $res = array();

    $i = 0;

    if ($result != null) {


      while ($row = $result->fetch_array()) {

        array_push($res, $row[$healthMeasure]);
      }

      closeConnection($conn);
    }

    if(!empty($increment)){
      array_push($increment, $res[0]);
      $res = $increment;
    }

    return $res;
}




function getDates($username, $before_date, $after_date, $admin)
{
  if($username == "Select participant"){
    return array();
  }

  $conn = startConnection();
  $sql = '';
  $fix_after_date = $after_date . ' 23:59:59';


  if ($before_date == null || $after_date == null) {
      $sql .= "SELECT TIME_ADD_UPDATE FROM basic_info as bi where bi.USR_AUTO_KEY = '$username'";
  }
  else {
      $sql .= "SELECT TIME_ADD_UPDATE FROM basic_info as bi where bi.USR_AUTO_KEY = '$username' and bi.TIME_ADD_UPDATE >= '$before_date' and bi.TIME_ADD_UPDATE <= '$fix_after_date'";
  }

  $result = runSelect($conn, $sql);

  $res = array();

  if($result == null){
    return array();
  }else{
    while ($row = $result->fetch_array()) {
      array_push($res, $row['TIME_ADD_UPDATE']);
    }
  }

  closeConnection($conn);

  return $res;
}



function checkEmpty($user_key)
{
  //error_reporting(E_ALL ^ E_WARNING); 

  $conn = startConnection();
  $sql = "SELECT USR_AUTO_KEY FROM functional_capacity_gpuser_date WHERE USR_AUTO_KEY = $user_key";
  $result = runSelect($conn, $sql);

  
  if($result == null || $result->num_rows == 0){
    return true;
  }else{
    return false;
  }
  
  
}


function getAverageData($gender, $hm, $before_date, $after_date){
  $conn = startConnection();
  $sql = '';

  if($before_date == null || $after_date == null){
    $sql .= "SELECT $hm from functional_capacity_gpsexdate where sex = '$gender'";
  }
  else{
    $sql .= "SELECT $hm from functional_capacity_gpsexdate where sex = '$gender' and TIME_ADD_UPDATE >= '$before_date' and TIME_ADD_UPDATE <= '$after_date'";
  }

  $result = runSelect($conn, $sql);

  if($result == null){
    return array();
  }

    $res = array();
    $i = 0;
    if ($result != null) {

      while ($row = $result->fetch_array()) {

        array_push($res, $row[$hm]);
      }
      closeConnection($conn);
    }


    return $res;
}

function getGenderDates($gender, $before_date, $after_date){
  $conn = startConnection();
  $sql = '';

  if ($before_date == null || $after_date == null || $before_date == '' || $after_date == '') {
    $sql .= "SELECT TIME_ADD_UPDATE FROM functional_capacity_gpsexdate where sex = '$gender'";
  }
  else {
    $sql .= "SELECT TIME_ADD_UPDATE FROM functional_capacity_gpsexdate where sex = '$gender' and TIME_ADD_UPDATE >= '$before_date' and TIME_ADD_UPDATE <= '$after_date'";
  }

  $result = runSelect($conn, $sql);

  $res = array();

  if($result == null){
    return array();
  }else{
    while ($row = $result->fetch_array()) {
      array_push($res, $row['TIME_ADD_UPDATE']);
    }
  }

  return $res;
}








?>

