
<?php
    include_once "header.php";
    include_once "sidebar.php"
?>
<?php
include "../../API/AdminAPI/debug.php";
//session_start();

  // Check if user is not logged in, destroy session, redirect to index.php and exit with message
if($_SESSION['username'] == null){
    session_destroy();
    header("location: ../../index.php");
    exit("You are not logged in");
}
$username = $_SESSION['username'];
//console_log($username . ' in dashboard.php');
?>

<script type="text/javascript">
jQuery(document).ready(function($){
// Check if health score is not null
if($("#health_score").val() != null){
        // Get health score value and convert it to integer
        let value = $("#health_score").html();
        var value_int = value.match(/\d+/);
        // Check if value_int is undefined or null
        if(value_int == undefined || value_int == null){
            //alert("Why");
        }
         // Set color of health score based on value
        if(value_int < 50){
            $("#health_score").css("color", "red");
            $("#health_score_message").html("<span>Your health score is terrible!</span>");
            $("#health_score_message").css("color", "red");
        } else if(value_int >= 50 && value_int <= 75){
            $("#health_score").css("color", "yellow");
            $("#health_score_message").html("<span>Your health score is alright!</span>");
            $("#health_score_message").css("color", "yellow");
        } else{
            $("#health_score").css("color", "green");
            $("#health_score_message").html("<span>Your health score is good!</span>");
            $("#health_score_message").css("color", "green");
        }
        
    }
});
</script>




<script type="text/javascript">



$(function(){

    // on click, load the data dynamically into the #result div
    for(var i = 0; i < 100; i++){
        $("#option" + i ).click(function(e){
            e.stopImmediatePropagation();


            var data = $(this).val();
            var data_array = data.split("~");
            var selected_key = data_array[0];
            var orig_key = data_array[1];

            $("#" + orig_key).html(selected_key);

            var string_arr = JSON.stringify(data_array[2]);
            var array = JSON.parse(data_array[2]);

            var healthy_arr = JSON.stringify(data_array[3]);
            var health_range = JSON.parse(data_array[3]);




            var values = array[selected_key];

            var length = values.length;


            // Define empty arrays to hold healthy and warning ranges
            var healthy_range = [];
            var warning_range = [];
            for(var j = 0; j < values.length / 2; j++){
                if (selected_key in health_range) {
                    if (values.length == 2) {
                        healthy_range.push(health_range[selected_key][j]);
                        warning_range.push(health_range[selected_key][j + 1]);
                    } else {
                        healthy_range.push(health_range[selected_key][j]);
                        warning_range.push(health_range[selected_key][j + 2]);
                    }
                }
            }
            // If the length of the healthy or warning range arrays is 0, set default values
            if(healthy_range.length == 0 || warning_range.length == 0){
                healthy_range.push(100);
                healthy_range.push(109);

                warning_range.push(110);
                warning_range.push(119);
            }




            for(var j = 0; j < length/2; j++){
                var category_value = "change-category-" + orig_key + j;

                var position = 40;
                //$("#change-category-" + orig_key + j).html();
                //need ajax before it
                var mydata = {

                    skey:orig_key,
                    selectkey:selected_key,
                    valarr : values,
                    category: category_value,
                    index:j,
                    healthyrange:healthy_range,
                    warningrange:warning_range}
                      // Send an AJAX request to the PHP script to display the health bar
                    $.ajax({
                        type: "POST",
                        async: false,
                        url: "../../Components/general/display_healthbar.php",
                        data: mydata,
                        success: function(msg){
                        // $('#tableResults').load(document.URL + ' #tableResults>*')
                        //var divgrab = document.getElementById("change-category-" + orig_key + j).innerHTML = msg;
                        // Update the div with the response from the PHP script
                        var divgrab = document.getElementById("change-category-" + orig_key + j).innerHTML = msg;
                        if(j == 1){
                            document.getElementById("change-category-" + orig_key + j).style.left = "10%";
                        }
                        if(length == 2){
                        var divgrabsecond = document.getElementById("change-category-" + orig_key + 1).innerHTML = '';
                        document.getElementById("change-category-" + orig_key + 1).style.left = "10%";
                        }
                        
                        }
                    });
                
                position -= 20;
            }





        });
    }

});

</script>  




<?php

if(isset($_POST['item_selected'])){
    $selected_item = $_POST['item_selected'];
}

require_once "../../API/PatientAPI/health_data.php";
include "../../API/PatientAPI/health_ranges.php";
include "progress_bar.php";
?>



<!doctype html>
<html class="no-js" lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title> Virtual Wellness System </title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="apple-touch-icon" href="apple-touch-icon.png">
        <script>
            var themeSettings = (localStorage.getItem('themeSettings')) ? JSON.parse(localStorage.getItem('themeSettings')) :
            {};
            var themeName = themeSettings.themeName || '';
        </script>
        
    </head>
    <body>




                <div style="background-color: transparent;" id="main">
                <article class="content dashboard-page">
                    <div class="container container-dashboard">
                        <span class="col-12" id="health_measures">Health Measures</span>
                        <hr>
                        <br>

                        <div style="width:100%; display: inline-block" class="row">
                            <div class="col-12">
                                <span style="text-shadow: black 0px 0px 2px;" id="health_score" value="<?php echo "76"?>">Your health score is: <?php echo '76'?></span>
                            </div>
                        </div> 
                        
                        <div style="width:100%; display: inline-block" class="row">
                            <div class="col-12">
                                <span style="text-shadow: black 0px 0px 2px;" id="health_score_message"></span>
                            </div>
                        </div>  

                        <?php
                        $count = 0;
                        $internal_count = 0;
                        $max_rows = 4;
                        if (!$failed_connection) {
                            foreach ($health_display as $key => $value) {
                                $length = count($value);
                                $label = $length / 2;
                                if ($count == $max_rows) {
                                    break;
                                }
                                ?>
                        <div style="width:100%; display: inline-block" class="row">
                            <div style="float: left;" class="col-md-4 item category">
                            <a class="btn btn-dark dropdown-toggle dropleft" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="name">=</span>
                            </a>
                                <div class="dropdown-menu " aria-labelledby="navbarDarkDropdownMenuLink">
                                    
                                    <?php
                                        //echo json_encode($key . ' ' . $key_orig . ' ' . $value_orig . ' ' . $health_display)
                                         foreach ($health as $key_orig => $value_orig) {?><?php
                                        ?>
                                                <form id="form" method="POST" action=server.self>
                                                    <select name="select" id=<?php echo "option" . $internal_count?>>
                                                            <!-- Change this to not be terrible -->
                                                            <option value=<?php echo $key_orig . '~' . $key . '~' . json_encode($health) . '~' . json_encode($health_range)?> id="option-item"><?php echo $key_orig?></option>
                                                            <input type="hidden" name="key" value=<?php echo $key?>>
                                                    </select>
                                                </form>
                                    <?php
                                        $internal_count++;
                                         } ?>
                                
                                </div>
                                <br>
                                <span id=<?php echo $key?> style="font-size: .7em;"><?php echo $key; ?></span>
                            </div>
                            <?php
                            $length = count($value);
                            $div_count = 4;
                            for ($i = 0; $i < 2; $i++) { ?>
                                <?php if($i == 0){?>
                                    <div style="right: 20%;" class="col-md-4 item category" id=<?php echo "change-category-" . $key . $i?>>
                                <?php } ?>
                                <?php if($i != 0){ ?>
                                    <div style="left: 10%;" class="col-md-4 item category" id=<?php echo "change-category-" . $key . $i?>>
                                <?php } ?>
                                    <?php
                                    //This is to set the second div for items containing two pieces of information
                                    if($i == 1 && $length == 2){
                                        break;
                                    }
                                    $length = count($value);
                                    
                                    $disable = false;
                                    $suffix = '';
                                    $healthy_range = [100, 109];
                                    $warning_range = [110, 119];
                                    if (array_key_exists($key, $health_range)) {
                                        if ($length == 2) {
                                            $healthy_range = array_replace($healthy_range, $health_range[$key][$i]);
                                            $warning_range = array_replace($warning_range, $health_range[$key][$i + 1]);
                                        } else {
                                            $healthy_range = array_replace($healthy_range, $health_range[$key][$i]);
                                            $warning_range = array_replace($warning_range, $health_range[$key][$i + 2]);
                                        }
                                    }
                                    if ($length == 2) {
                                        if ($value[1] == "weight") {
                                            $disable = true;
                                            $suffix = 'lbs';
                                        } else if ($value[1] == "mileWalkingTestTime") {
                                            $disable = true;
                                        }
                                        displayHealth($value[$i], $healthy_range, $warning_range, $value[$i + 1], $disable, $suffix);
                                    } else {
                                        displayHealth($value[$i], $healthy_range, $warning_range, $value[$i + 2], $disable, $suffix);
                                    }
                                    ?>
                                </div>
                            <?php } ?>
                        </div>
                        <br>
                        <br>
                        <?php $count++;
                              $div_count += 4;
                            }
                        }?><?php if($failed_connection){ ?>
                            <span style="font-size: 2em;">Please enter survey information</span>
                           <?php 
                        }?>

                        
                
                    </div>
            </div>

    </body>
</html>


