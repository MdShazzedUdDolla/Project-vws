<?php
/*
$health_range ($min_value, $max_value)
$warning_range ($min_value, $max_value)
*/
function displayHealth($value, $health_range, $warning_range, $label, $no_range = false, $suffix = "")
{
    if (!$no_range && is_numeric($value)) {
        $max_value = 300;
        $min_value = 0;

        $old_value = 0;
        $m_value = $value;



        $healthy_range_min = $health_range[0];
        $healthy_range_max = $health_range[1];
        $warning_range_min = $warning_range[0];
        $warning_range_max = $warning_range[1];

        $boundary_values = array($healthy_range_min, $healthy_range_max, $warning_range_min, $warning_range_max);
        sort($boundary_values);

        //$min_value = $boundary_values[0];
        //$max_value = $boundary_values[3];
        
        if($boundary_values[0] < $min_value){
            if($boundary_values[0] < 0){
                console_log($boundary_values[0] . ' + ' . ' 5');
                $min_value = $boundary_values[0] - 5;
                console_log($min_value . ' this is when min value is changed');
            }else{
                $min_value = $boundary_values[0];
            }
            
        }
        if($boundary_values[3] > $max_value){
            $max_value = $boundary_values[3];
        }
        if($value < $min_value){
            $value = $min_value;
        }

        $reverse = false;

        if($boundary_values[3] <= 0){
            $max_value = 10;
        }
        
        if($min_value < 0){
            $healthy_range_min -= $min_value;
            $healthy_range_max -= $min_value;
            $warning_range_min -= $min_value;
            $warning_range_max -= $min_value;
            $healthy_range_min = abs($healthy_range_min);
            $healthy_range_max = abs($healthy_range_max);
            $warning_range_min = abs($warning_range_min);
            $warning_range_max = abs($warning_range_max);
            $old_value = $value;
            $value -= $min_value;
            $max_value -= $min_value;
            $min_value -= $min_value;
            $reverse = true;
        }
        /*
        console_log($min_value . ' this is min');
        console_log($max_value . ' this is max');
        */
        /*
        console_log($healthy_range_min);
        console_log($healthy_range_max);
        console_log($warning_range_min);
        console_log($warning_range_max);
        */
        /*
        for ($j = 0; $j < count($health_range); $j++) {
            console_log($health_range[$j]);
        }
        for ($j = 0; $j < count($warning_range); $j++) {
            console_log($warning_range[$j]);
        }
        */

        //echo $value;
        //echo $max_value;
        
        $selector_width = ($value / $max_value) * 100;
        /*
        console_log($max_value . ' this is max');
        console_log($selector_width . ' this is the selector width');

        console_log($healthy_range_max . ' this is healthy range max');
        */
        $start_width = $healthy_range_max / $max_value;
        $start_width *= 100;

        //console_log('this is warning range min ' . $warning_range_min);
        //console_log('this is max value '. $max_value);
        $reverse_start_width = ($warning_range_min / $max_value) * 100;
        //console_log('this is reverse start width ' . $reverse_start_width);
        if($start_width < 0){
            $start_width *= -1;
        }
        $start_val = $max_value * $start_width;

        $width_selector = .2;
        $warning_width = (($warning_range_max - $warning_range_min) / $max_value) * 100;


        if ($warning_width < 0) {
            $warning_width *= -1;
        }
        $rest_width = 100 - ($warning_width + $start_width);
        $reverse_rest_width = 100 - ($reverse_start_width + $warning_width);
        /*
        console_log($start_width);
        console_log($warning_width);
        console_log($rest_width);

        console_log('This is reverse start width ' . $reverse_start_width);
        console_log('This is reverse rest width ' . $reverse_rest_width);
        */
        if($boundary_values[3] <= 0){
        }
    }else{
        $no_range = true;
    }
    ?>


<?php

        if ($no_range) {
            ?><span style="text-align: center; font-size: 25px;"><?php echo $value . ' ' . $suffix ?></span><?php
        } 
        else{
            if(!$reverse) {
            ?>
<?php
                if ($value >= $warning_range_max) {
                    ?><span style='font-size: 25px;color: red; text-shadow: black 0px 0px 2px;'><?php echo $label ?></span><?php
                } else if ($value >= $warning_range_min && $value <= $warning_range_max) {
                    ?><span style="font-size: 25px;color: yellow; text-shadow: black 0px 0px 6px;"><?php echo $label ?></span><?php
                } else {
                    ?><span style="font-size: 25px; color: green; text-shadow: black 0px 0px 2px;"><?php echo $label ?></span><?php
                }
            } else if($reverse){
                if ($value <= $warning_range_max){
                    ?><span style="font-size: 25px;color: red; text-shadow: black 0px 0px 2px;"><?php echo $label ?></span><?php
                } else if ($value <= $warning_range_min && $value >= $warning_range_max) {
                    ?><span style="font-size: 25px;color: yellow; text-shadow: black 0px 0px 6px;"><?php echo $label ?></span><?php
                } else {
                    ?><span style="font-size: 25px;color: green; text-shadow: black 0px 0px 2px;"><?php echo $label ?></span><?php
                }
            }?>


<?php if ($reverse) { ?>



<div style='width: 350px;' class="progress">
    <div class="progress-bar bg-danger" role="progressbar" style="width: <?php echo $reverse_start_width?>%" aria-valuenow="20" aria-valuemin=<?php echo $min_value ?> aria-valuemax=<?php echo $warning_range_min ?>></div>
    <div class='progress-bar bg-warning' role='progressbar' style="width:<?php echo $warning_width?>%" aria-valuenow="30" aria-valuemin=<?php echo $warning_range_min ?> aria-valuemax=<?php echo $warning_range_max ?>></div>
    <div class='progress-bar bg-success' role='progressbar' style="width:<?php echo $reverse_rest_width?>%" aria-valuenow="0" aria-valuemin=<?php echo $warning_range_max ?> aria-valuemax=<?php echo $max_value ?>></div>
</div>


<div style='width: 350px;' class="progress">
    <div role="progressbar" style="width: <?php echo $selector_width ?>%; background-color: transparent;" aria-valuenow="<?php echo $selector_width ?>" aria-valuemin="<?php echo $min_value ?>" aria-valuemax="<?php echo $max_value ?>"></div>
    <div class="progress-bar bg-dark" role="progressbar" style="width: <?php echo $width_selector ?>%;" aria-valuenow="<?php echo $value ?>" aria-valuemin=<?php echo $min_value ?> aria-valuemax=<?php echo  $max_value ?>></div>
    <div role="progressbar" style="width: <?php echo $rest_width - $width_selector ?>%; background-color: transparent;" aria-valuenow="<?php echo $start_val ?>" aria-valuemin="<?php echo $min_value ?>" aria-valuemax="<?php echo $max_value ?>"></div>

</div>
<span style="font-size: 25px;"><?php echo $old_value ?></span>
<?php } else { ?>

<div style='width: 350px;' class="progress">
    <div class="progress-bar bg-success" role="progressbar" style="width: <?php echo $start_width ?>%" aria-valuenow="0" aria-valuemin=<?php echo $healthy_range_min ?> aria-valuemax=<?php echo $healthy_range_max ?>></div>
    <div class="progress-bar bg-warning" role="progressbar" style="width: <?php echo $warning_width ?>%" aria-valuenow="30" aria-valuemin=<?php echo $warning_range_min ?> aria-valuemax=<?php echo $warning_range_max ?>></div>
    <div class="progress-bar bg-danger" role="progressbar" style="width: <?php echo $rest_width ?>%" aria-valuenow="20" aria-valuemin=<?php echo $warning_range_max ?> aria-valuemax=<?php echo $max_value ?>></div>
</div>

<div style='width: 350px;' class="progress">
    <div role="progressbar" style="width: <?php echo $selector_width ?>%; background-color: transparent;" aria-valuenow="<?php echo $selector_width ?>" aria-valuemin=<?php echo $min_value ?> aria-valuemax="<?php echo $max_value ?>"></div>
    <div class="progress-bar bg-dark" role="progressbar" style="width: <?php echo $width_selector ?>%;" aria-valuenow="<?php echo $value ?>" aria-valuemin=<?php echo $min_value ?> aria-valuemax=<?php echo $max_value ?>></div>
    <div role="progressbar" style="width: <?php echo $rest_width - $width_selector ?>%; background-color: transparent;" aria-valuenow="<?php echo $start_val ?>" aria-valuemin="<?php echo $min_value ?>" aria-valuemax="<?php echo $max_value ?>"></div>
</div>
<span style="font-size: 25px;"><?php echo $value ?></span>

<?php
                }
        }
    }
?>
