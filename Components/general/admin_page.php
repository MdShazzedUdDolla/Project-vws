<?php
    include_once "header.php";
    include_once "sidebar.php";
    include "../../API/AdminAPI/admin_information.php";
    include "admin_send_email.php";

?>

<?php

//Only errors and not warnings
//error_reporting(E_ERROR | E_PARSE);

//this is for someone who manually tries to copy paste url without logging in
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if(isset($_SESSION)==false || isset($_SESSION['privilege_level'])==false || $_SESSION['privilege_level']!=1){
    header("Location: ../../Pages/Error/UnauthorizedAccess.php");
   
    exit("Unauthorized Access detected.");
}
if($_SESSION["admin_status"] != 1 || $_SESSION["admin_status"] == null){
    header("Location: ../../Pages/Error/UnauthorizedAccess.php");
    echo '<div style="position: relative; left: 10%;" class="container" id="main">';
    http_response_code(404);
    echo '<h1>You do not have permission to view this file</h1>';
    exit();
    echo '</div>';
}
?>

<script>
/** 
if (sessionStorage.getItem('admin_status') != 1) {
  var xhr = new XMLHttpRequest();
  xhr.open("GET", "nonexistent_page.php", true);
  xhr.onreadystatechange = function() {
    if (xhr.readyState == 4 && xhr.status == 404) {

    }
  }
  xhr.send();
}
*/
</script>


<!DOCTYPE html>
<html>
<head>
<title>Admin page</title>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/multi-select/0.9.12/js/jquery.multi-select.min.js"></script>
<link rel="stylesheet" href="../../Style/VWS_CSS/dropdown.css">
<script type='text/javascript' src='../../Js_Script/VWS_JS/findIndexDatalist.js'></script>
</head>
<body>
<?php
$status1 = '';
$status2 = '';

//put this part at the top to keep dropdowns undated with the changes for delete
if($_SERVER['REQUEST_METHOD'] === 'POST' && (isset($_POST['submit']))){
    //print_r($_POST);
    $participant_id = $_POST['user_auto_key'];

    $new_privilege_level = '';

    if(isset($_POST['radio-group'])){
        switch($_POST['radio-group']){
            case 'user-filter':
                $new_privilege_level = '3';
                break;
            case 'physician-filter':
                $new_privilege_level = '2';
                break;
            case 'admin-filter':
                $new_privilege_level = '1';
                break;
            default:
                $new_privilege_level = '';
                break;
        }
    }

    if(isset($participant_id) && isset($new_privilege_level)){
        $status1 = updateUserPrivilegeLevel($participant_id, $new_privilege_level);
    }
     //Assuming we are sending email to user making the change but this can be any email we want
   //  $email = getEmail($_SESSION['user_auto_key']);
     //sendEmail($email, $username);
}
if ($_SERVER['REQUEST_METHOD'] === 'POST' && (isset($_POST['delete']))) {
    //print_r($_POST);
    $participant_id_delete = $_POST['user_auto_key'];

    if (isset($participant_id_delete)) {
        $status2 = deleteUserById($participant_id_delete);
    }
    }


?>
<div id="main">
<div class="container">    
<div style="top:8%; position: relative;" class="warning_message"></div>
    <form style="position: relative; top: 15%;" id="form" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
    
        <div style="top: 10%; position: relative;" class="row align-items-start">
            
            <div class="col">
            <label style="top: 15%;">Please select a participant to modify privileges</label>  
            <br>
            <br>
           
                <input class="form-control" type="text" autocomplete="off" list="patients"  id="nameDropUpdate"  name="participants" value="" placeholder="Search for user "  />
    
                <?php
                //get the nameDrop datalist
                    $html = getUsers();
                    echo $html;
                ?>
         
            <span id="further_warning_styling"></span>  
            </div>
        </div>

        <br>
        <br>

        <div style="top: 15%; position: relative;" class="row align-items-center">
            <div class="col">
                <div class="form-group col-11">
                    <input type="radio" name="radio-group" id="user-filter" value="user-filter" checked>
                    <label for="gender-filter">User</label>
                </div>
            </div>
            <div class="col">
                <div style="left: 2%;" class="form-group col-11">
                    <input type="radio" name="radio-group" id="physician-filter" value="physician-filter">
                    <label for="user-filter">Physician</label>
                </div>
            </div>
            <div class="col">
                <div class="form-group col-11">
                    <input type="radio" name="radio-group" id="admin-filter" value="admin-filter">
                    <label for="user-filter">Admin</label>
                </div>
            </div>
        </div>

        <br>
        
        <div style="top: 15%; position: relative;" class="row align-items-end">
            <div class="col">
                <input type="submit" name="submit" class="btn btn-primary" name="updateButton" id="updateButton" value="Update" />
            </div>
        </div>

        <br>
        <div style="top: 10%; position: relative;" class="row align-items-start">
            
            <div class="col">
            <label style="top: 15%;">Please select a participant to delete from the database</label>  
            <br>
            <br>
            <input class="form-control" type="text" autocomplete="off" list="patients"  id="nameDropDelete"  name="deleteparticipant" value="" placeholder="Search for user " />
            <span id="further_warning_styling-delete"></span>  
            </div>
        </div>
        <br>
        
        <div style="top: 15%; position: relative;" class="row align-items-end">
            <div class="col">
                <input type="submit" name="delete" class="btn btn-primary" name="deleteButton" id="deleteButton" value="Delete" />
            </div>
        </div>
        <input hidden name="user_auto_key" id="user_auto_key" value="" >
    </form>
    </div>
</div>







</body>
</html>




<script>
let info1 = <?php echo json_encode($status1); ?>;


if (typeof info1 !== "undefined") {
    if (info1 == "OK") {
        $(".warning_message").append("<div class='alert alert-success' role='alert'>User updated</div>");
    }else if(info1 == "Participant not selected"){
        $(".warning_message").append("<div class='alert alert-danger' role='alert'>Participant not selected</div>");
        $("#participant-dropdown").css("border", "2px solid red");
        $("#participant-dropdown").css("color", "red");
        $("#further_warning_styling").append("!");
        $("#further_warning_styling").css("color", "red");
    }else if(info1 == "Failed to update"){
        $(".warning_message").append("<div class='alert alert-success' role='alert'>Database failure</div>");
    }
}

let info2 = <?php echo json_encode($status2); ?>;


if (typeof info2 !== "undefined") {
    if (info2 == "OK") {
        $(".warning_message").append("<div class='alert alert-success' role='alert'>User deleted</div>");
    }else if(info2 == "Participant not selected"){
        $(".warning_message").append("<div class='alert alert-danger' role='alert'>Participant not selected</div>");
        $("#participant-dropdown-delete").css("border", "2px solid red");
        $("#participant-dropdown-delete").css("color", "red");
        $("#further_warning_styling-delete").append("!");
        $("#further_warning_styling-delete").css("color", "red");
    }else if(info2 == "Failed to delete"){
        $(".warning_message").append("<div class='alert alert-success' role='alert'>Database failure</div>");
    }
}

</script>