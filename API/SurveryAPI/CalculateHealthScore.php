<?php
    function calculateDeviation($numbers, $num) {
        $sum = 0;
        foreach ($numbers as $n) {
        $sum += abs($n - $num);
        }
        $avg_deviation = $sum / count($numbers);
        $percent_deviation = ($avg_deviation / $num) * 100;
        return $percent_deviation;
    }

    /*
    This function uses linear regression to calculate the slope of the line that best fits the data.
     The slope can be positive, indicating an upward trend, negative, indicating a downward trend, or zero, indicating no trend.
    */ 
  function detectTrend($data) {
    $n = count($data);
    $x_sum = array_sum(range(1, $n)); // Sum of 1 to n
    $y_sum = array_sum($data); // Sum of y values
    $xy_sum = 0; // Sum of x*y values
    $x2_sum = 0; // Sum of x^2 values
  
    // Calculate sums of x*y and x^2 values
    for ($i = 0; $i < $n; $i++) {
      $xy_sum += ($i+1) * $data[$i];
      $x2_sum += pow($i+1, 2);
    }
  
    // Calculate slope and intercept of linear regression line
    $slope = ($n*$xy_sum - $x_sum*$y_sum) / ($n*$x2_sum - pow($x_sum, 2));
    $intercept = ($y_sum - $slope*$x_sum) / $n;
  
    // Check the sign of the slope to determine the trend
    if ($slope > 0) {
      return "Upward trend";
    } elseif ($slope < 0) {
      return "Downward trend";
    } else {
      return "No trend";
    }
  }
  
?>