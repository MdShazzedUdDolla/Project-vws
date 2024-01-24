
<?php 
 include_once "../../API/Database/security/Cryptor.php";
 include_once "../../API/Database/security/encKey.php";
 
function getUsernameField($sessionArr){
   
    if($sessionArr['privilege_level'] == 3){
        $labelTxt = "Username: ";
        echo '<label for="nameDrop">'. $labelTxt.'</label>';
        $usernameTxt = $sessionArr['username'];
        $autokey = $sessionArr['user_auto_key'];
        echo '<input type="text"  autocomplete="off" id="namePatient"   value="'. $usernameTxt.'"  required readonly>';
     }else{

     echo "<script type='text/javascript' src='../../Js_Script/VWS_JS/findIndexDatalist.js'></script>";
      $labelTxt = "Patient name: ";
      echo '<label for="nameDrop">'. $labelTxt.' </label> ';
      $usernameTxt = "";
      $autokey = 0;
      
      $sql = "SELECT USR_AUTO_KEY, u.first_name , u.last_name FROM user as u where privilege_level= 3; ";
      $conn = startConnection();
      $result = runSelect($conn, $sql);
      if($result!=null){

        $html = "<datalist id='patients' name='patients' style='height:5.1em;overflow:hidden'>";
        while($row = $result->fetch_assoc()){
         
            $cipher_method = 'aes-256-cfb';
            
            $encryption_key = getKey(); //this will becoming from a file in root after deployment 
            $cryptor = new Cryptor($encryption_key, $cipher_method);
            $fname = $cryptor->decrypt($row["first_name"]);
            $cryptor = new Cryptor($encryption_key, $cipher_method);
            $lname = $cryptor->decrypt($row["last_name"]);
            $html .= "<option name='option' data-value='".$row['USR_AUTO_KEY']."'value='".$fname.' '.$lname ."'>"."</option>";
        }
            $html .= "</datalist>";
            closeConnection($conn);
        }else{
            $html = "<option name='option' data-value='0' value='No users available'  hidden disabled >"."</option>";
        }
      
      

        echo $html;
        echo '<input type="text" autocomplete="off" list="patients"  id="nameDrop"  id="nameDrop"  value="" placeholder="Search for user "  required>';
      
     }

     echo '<input hidden name="user_auto_key" id="user_auto_key" value="'.$autokey.'" > ';
}

?>