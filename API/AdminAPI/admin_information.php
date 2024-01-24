<?php

include_once "../../API/Database/config.php";
include "../../API/AdminApi/debug.php";
function getUsers(){
    $conn = startConnection();
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    $sql = "SELECT USR_AUTO_KEY, first_name, last_name from user order by first_name, last_name";
    $result  = runSelect($conn, $sql);
    $html = "<datalist id='patients' name='patients' style='height:5.1em;overflow:hidden'>
    <option data-value='0' value='0' disabled>Select a participant</option>
    ";
    if ($result!= null) {
        include_once "../../API/Database/security/encKey.php";
        include_once "../../API/Database/security/Cryptor.php";
        $encryption_key = getKey(); //this will becoming from a file in root after deployment 
   
        $cipher_method = 'aes-256-cfb';
   
        $cryptor = new Cryptor($encryption_key, $cipher_method);
        while($row = mysqli_fetch_assoc($result)) {
            $fname = $cryptor->decrypt($row["first_name"]);
            $lname = $cryptor->decrypt($row["last_name"]);
            $html .= "<option name='option' data-value='".$row['USR_AUTO_KEY']."'value='".$fname.' '.$lname ."'>"."</option>";
        }
      
    }else{
        $html .= "<option name='option' data-value='0' value='No users available'  hidden disabled >"."</option>";
    }
    $html .= "</datalist>";
    closeConnection($conn);
   // echo '<input hidden name="user_auto_key" id="user_auto_key" value="" > ';
    return $html;
}


function updateUserPrivilegeLevel($id, $privilege){
  //  print_r($_POST);
    if($id == ''){
        return "Participant not selected";
    }

    $conn = startConnection();
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    $sql = "UPDATE user SET privilege_level = $privilege WHERE USR_AUTO_KEY = $id";
    runUpdate($conn, $sql);

    if ($conn->query($sql) === TRUE) {
        return "OK";
    } else{
        return "Failed to update";
    }
}

function getEmail($auto_key){
    include_once "../../API/Database/security/encKey.php";
    include_once "../../API/Database/security/Cryptor.php";
    $encryption_key = getKey(); //this will becoming from a file in root after deployment 

    $cipher_method = 'aes-256-cfb';

    $cryptor = new Cryptor($encryption_key, $cipher_method);




    if($auto_key == ''){
        return 'Email is not found';
    }
    $conn = startConnection();
    if (!$conn){
        die("Connection failed: " . mysqli_connect_error());
    }
    $sql = "SELECT email FROM user WHERE USR_AUTO_KEY = $auto_key";
    $result = runSelect($conn, $sql);

    $row = mysqli_fetch_assoc($result);

    $email = $cryptor->decrypt($row['email']);

    return $email;
}


function validateAdminPagePass($pass){
    include_once "../../API/Database/security/encKey.php";
    if($pass == getAdminPass()){
        return true;
    }else{
        return false;
    }

}

function deleteUserById($id){
    $conn = startConnection();
        if($id == '' || $id==0){
            $sql = "SELECT 1 FROM user WHERE USR_AUTO_KEY = ?";
            //echo $sql;

            $result = SafeRunSelect($conn, $sql, [$id]);
            $exist = false;
            if ($result != null) {
                $fnr_auto_key = array();
                $row = mysqli_fetch_assoc($result);
                $exist = $row['1']==1 ? true : false;

                }
            //check with database to verify
            if($exist==false){
                return "Participant not selected";
            }
            
        }

       
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }


        // get FNR_AUTO_KEY linked with USR_AUTO_KEY
        $sql = "SELECT FNR_AUTO_KEY FROM functional_capacity_record WHERE USR_AUTO_KEY = ?";
        //echo $sql;
        $result = SafeRunSelect($conn, $sql, [$id]);
        $paramList = "";
        if ($result != null) {
            $fnr_auto_key = array();
            while ($row = mysqli_fetch_assoc($result)) {
                array_push($fnr_auto_key , $row['FNR_AUTO_KEY'] );
                //echo $row['FNR_AUTO_KEY'] ;
                $paramList .= '?,';
            }
          
        // $row = mysqli_fetch_assoc($result);
           $paramList = substr($paramList, 0, -1);

        } else {
            $fnr_auto_key = '';
        }

       // print_r($_POST);
        if (!empty($id)) {
        // delete data from timed_balancing_test table where FNR_AUTO_KEY equals BSI_AUTO_KEY
        if(!empty($paramList)){
            $sql = "DELETE FROM timed_balancing_test WHERE FNR_AUTO_KEY in  (".$paramList.")";
        //echo $sql;
        $res = SafeRunDelete($conn, $sql, $fnr_auto_key);
        }
        // delete data from other tables
        $sql = "DELETE FROM perceived_stress_record WHERE USR_AUTO_KEY = ?";
        $res = SafeRunDelete($conn, $sql, [$id]);
        if(!empty($paramList)){
            $sql = "DELETE FROM aerobic_cardiovascular_fitness WHERE FNR_AUTO_KEY in ( ".$paramList." ) ";
            $res = SafeRunDelete($conn, $sql, $fnr_auto_key);
        }
        $sql = "DELETE FROM functional_capacity_record WHERE USR_AUTO_KEY = ?";
        $res = SafeRunDelete($conn, $sql, [$id]);
        $sql = "DELETE FROM basic_info WHERE USR_AUTO_KEY = ?";
        $res = SafeRunDelete($conn, $sql, [$id]);
        $sql = "DELETE FROM consent_record WHERE USR_AUTO_KEY = ?";
        $res = SafeRunDelete($conn, $sql, [$id]);

        // delete user from user table
        $sql = "DELETE FROM user WHERE USR_AUTO_KEY = ?";
        $resFinal = SafeRunDelete($conn, $sql, [$id]);
       // echo $res;
        if ($resFinal == TRUE) {
            //echo "OK";
            return "OK";
        } else{
           // echo "Failed to delete";
            return "Failed to delete";
        }
    }
}
   



?>