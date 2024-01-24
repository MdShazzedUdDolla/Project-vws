<?php
require_once "progress_bar.php";
require_once "../../API/AdminAPI/debug.php";



?>

<?php
 //print_r($_POST);
 $key = $_POST['skey'];
 $value = $_POST['valarr'];
 $i = $_POST['index'];
 $select_key = $_POST['selectkey'];
 $health_range = $_POST['healthyrange'];
 $warn_range = $_POST['warningrange'];
$category = $_POST['category'];
 //console_log($key . ' adfasdf');

 $col_num = $i * 4;
?>

<?php
//for($i = 0; $i < count($value)/2; $i++) { ?>

<?php
    //print_r($_POST);
    //console_log($health_range);
    $length = count($value);
    //console_log("change-category-" . $key . $i);
    $disable = false;
    $suffix = '';
    //echo $warn_range[1];
    if ($length == 2) {
        if ($value[1] == "weight") {
            $disable = true;
            $suffix = 'lbs';
        } else if ($value[1] == "mileWalkingTestTime") {
            $disable = true;
        }
        displayHealth($value[$i], $health_range[$i], $warn_range[$i], $value[$i + 1], $disable, $suffix);
    } else {
        displayHealth($value[$i], $health_range[$i], $warn_range[$i], $value[$i + 2], $disable, $suffix);
    }
?>