
<?php
require_once "../../API/Database/config.php";
include "../../Components/general/graphing_information.php";
?>
<?php
function getData($POST, $csv)
{
        $gender = "Gender not set";
        


        $selected_partic = [];
        if(!empty($POST['partic'])){
            $selected_partic = $POST['partic'];
        }
        else if(!empty($POST['gender'])){
            $selected_partic = $POST['gender'];
            $gender = "Gender set";
        }
        else{
            if($_SESSION['privilege_level'] != 3){
                return "Select participant";
            }
        }

        if (!empty($POST['gender']) && isset($POST['gender'])){
            $gender = $POST['gender'];
        }

        if($csv && !empty($POST['csv_info'])){
            $selected_hm = $POST['csv_info'];
        }



        if (!empty($POST['hm'])) {
            $selected_hm = $POST['hm'];
        }else{
            return "hm not selected";
        }



        $before_date = $POST['before_date'];
        $after_date = $POST['after_date'];
        $fix_after_date = $after_date . ' 23:59:59';
        $admin = false;

        $name_array = [];
        $user_array = [];

        if ($_SESSION['privilege_level'] != 3) {
         if (!empty($POST['partic']) || !empty($POST['gender'])) {
            for($i = 0; $i < count($selected_partic); $i++){
                $pair = explode(":", $selected_partic[$i]);

                
                $username = $pair[0];


                $admin = true;
                $name = $pair[1];
                array_push($user_array, $username);
                array_push($name_array, $name);
            }
         }
        }else{
                $username = $_SESSION['user_auto_key'];
                //echo $username;
                array_push($user_array, $username);
        }

        $max_count = 0;

        if(count($user_array) > 1 && count($selected_hm) > 1){
            return "Invalid functionality";
        }

        $mult_users = false;

        if(count($user_array) > count($selected_hm)){
            $max_count = count($user_array);
            $mult_users = true;

        }else{
            $max_count = count($selected_hm);
            $mult_users = false;
        }





        $userData = [];
        $count_once = 0;
        if(isset($selected_hm)){
            $userObject = new stdClass();        
                for($j = 0; $j < $max_count; $j++){
                    if($gender != "Gender not set"){
                        $userObject = new stdClass();
                        if($count_once == 0){
                            $userObject->title = $selected_hm[0];
                        }
                        if($count_once == 0 && $csv){
                            $userObject->csv = 'true';
                            $userObject->gender = 'true';
                            $count_once++;
                        }
                        $userObject->hm = $selected_hm[0];
                        $userObject->name = $user_array[$j];
                        $userObject->data = getAverageData($user_array[$j], $selected_hm[0], $before_date, $fix_after_date);
                        $userObject->date = getGenderDates($user_array[$j], $before_date, $fix_after_date);
                        if($userObject->data!=null){
                            $userData[] = $userObject;
                        }
                        
                        }
                    else{
                        $userObject = new stdClass();
                        if($count_once == 0 && $csv){
                            $userObject->csv = 'true';
                        }
                        $userObject->hm = $selected_hm[$j];
                        $userObject->key = $user_array[$j];
                        if($mult_users){
                            if($count_once == 0){
                                $userObject->title = $selected_hm[0];
                                $count_once++;
                            }
                            $userObject->name = $name_array[$j];
                            $userObject->data = getHealthValues($selected_hm[0], $user_array[$j], $before_date, $after_date, $admin, true);
                            $userObject->date = getDates($user_array[$j], $before_date, $after_date, $admin);
                        }else{
                            if($count_once == 0){
                                if($_SESSION['privilege_level'] != 3){
                                    $userObject->title = $name_array[0];
                                }else{
                                    $userObject->title = '';
                                }
                                $count_once++;
                            }
                            $userObject->name = $selected_hm[$j];
                            $userObject->data = getHealthValues($selected_hm[$j], $user_array[0], $before_date, $after_date, $admin, true);
                            $userObject->date = getDates($user_array[0], $before_date, $after_date, $admin);
                        }
                        $userData[] = $userObject;
                    }
                        }
                    }

                
            $value_length = count($userData);
            $empty_count = 0;
            foreach($userData as $entry){
               if(empty($entry->date)){
                    //echo $value[$empty_count];
                    $empty_count++;
               }
            }
            
            if($empty_count == $value_length){
                //checkEmpty($user_key)
                $empty = checkEmpty($_SESSION['user_auto_key']);
    
                if($empty){
                return "empty";
                }else{
                return "invalidDateRange";
                }
            }
            



                return $userData;


            
            

        }
                




?>
