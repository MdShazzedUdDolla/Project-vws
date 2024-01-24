<?php

    function combine($health, $left, $right, $key, $label, $reverse = false){
        $next_key = '';


        if (str_contains($key, $left)) {
            $search_string = str_replace($left, '', $key);
            if($reverse){
                $next_key = $right . $search_string  . $next_key;
            } else {
                $next_key = $next_key . $search_string . $right;
            }
            
        } else if (str_contains($key, $right)) {
            $search_string = str_replace($right, '', $key);
            if($reverse){
                $next_key = $left . $search_string  . $next_key;
            } else {
                $next_key = $next_key . $search_string . $left;
            }
            
        }

        $combine_values = array($health[$key], $health[$next_key], $key, $next_key);
        unset($health[$key]);
        unset($health[$next_key]);
        $label = $key;
        $label = str_replace($left, '', $label);
        $label = str_replace($right, '', $label);

        $health += array($label => $combine_values);

        return $health;
    }






 ?>





<?php


//For production would be best to turn this on
error_reporting(E_ALL ^ E_WARNING);


include_once "../../API/Database/config.php";

$failed_connection = false;
error_reporting(E_ALL ^ E_WARNING); 
$link = startConnection();

//console_log($username);

if ($username != null || $username != ''){
    $stm = $link->prepare("SELECT * FROM basic_info as bi, functional_capacity_record as fc , aerobic_cardiovascular_fitness as acf where bi.USR_AUTO_KEY = (SELECT USR_AUTO_KEY from user where username = SHA2(?, 224)) and fc.BSI_AUTO_KEY= bi.BSI_AUTO_KEY and fc.FNR_AUTO_KEY = acf.FNR_AUTO_KEY ORDER BY fc.FNR_AUTO_KEY DESC LIMIT 1;");
    $stm->bind_param("s", $username);
    $stm->execute();
    
    $result = $stm->get_result();
    $row = array();
    $i = 0;
    $health = $result->fetch_assoc();
    if(is_null($health)){
        $failed_connection = true;
    } else {
        $health_keys = array_keys($health);
    }
    if (!is_null($health)) {
        $length = count($health);

        foreach ($health as $key => $value) {       
            //strpos($key, '_KEY') || $key == 'sex' || $key == 'formula_result' || $key == 'time_completed' || $key == 'TIME_ADD_UPDATE' || $key == 'comment' || $key == 'date_of_birth'
            if ($key == "BSI_AUTO_KEY" || $key=="FNR_AUTO_KEY" || $key == "ACF_AUTO_KEY" || $key == "USR_AUTO_KEY" || $key == "username" || $key == "TIME_ADD_UPDATE" || $key == "date_of_birth" || $key == "sex" || $key == "formula_result" || $key == "time_completed" || $key == "comment" || $key == "date_of_birth") {
                unset($health[$key]);
            } 
            else if (str_contains($key, "_sys") || str_contains($key, "_dias")) {
                $health = combine($health, "_sys", "_dias", $key, $label);
            } else if (str_contains($key, "Lback_") || str_contains($key, "Rback_")) {
                $health = combine($health, "Lback_", "Rback_", $key, $label, true);
            } else if (str_contains($key, "Lankle_") || str_contains($key, "Rankle_")) {
                $health = combine($health, "Lankle_", "Rankle_", $key, $label, true);
            } else if (str_contains($key, "Lgrip_") || str_contains($key, "Rgrip_")) {
                $health = combine($health, "Lgrip_", "Rgrip_", $key, $label, true);
            }  else {
                $combine_values = array($health[$key], $key);
                $health[$key] = $combine_values;
            }

        }
    }
    $health_display = $health;
    closeConnection($link);
}







?>