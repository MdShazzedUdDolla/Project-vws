
<?php
include_once "../../API/Database/security/Cryptor.php";
require_once "../../API/Database/config.php";
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$_SESSION['table'] = 0;
?>


<?php

/*
display the table based on the category selected
*/
function getData($table)
{
       // get the options of which type of participant 
       if (isset($_GET['options'])) {
        $selectedOption = $_GET['options'];
        $selectedView = $_GET['options'];
        if( $_GET['options']==1){
            $selectedView = $table==5 ?  4 : 1;
        }
      }
      else{
      
        $selectedOption = "1"; // set option to 1 (All particpant)
        $selectedView = $table==5 ?  4 : 1;
      }
    
    $sqlTable = setSqltable($table, $selectedOption); // seting the select statement for sql based on category
    
 
    
    $sqlView = setSqlview($selectedView); // getting the view for the selected option


      $sql = $sqlTable.$sqlView; // appending the select statement and the from statement for the table
    

//echo $sql;
    $conn = startConnection();
    $result = runSelect($conn, $sql);
    include_once "../../API/Database/security/encKey.php";
    $encryption_key = getKey(); //this will becoming from a file in root after deployment 
  
    $cipher_method = 'aes-256-cfb';

    echo "<thead>";
    if ($result != null) {
        $sortingArrows = sortingArrow();
        if($table==1) // displaying thr headers for table 1 
        {

            if($selectedOption == 2||$selectedOption == 3) // colspan the header based on selectedoption
                {
                    echo "<tr>
                    <th colspan='8' style='text-align: center'> General Information </th> </tr>";
                }
            else
            {
                echo "<tr>
            <th colspan='7' style='text-align: center'> General Information</th> </tr>";
            }   
            // display column for table 1
            echo "<tr>";
           
            if($selectedOption==1){
                echo "<th>First Name $sortingArrows </th><th>Last Name $sortingArrows</th>";
            }else{
                echo "<th>Sex</th>";
            }
          
        //     $plusbtn = '<button style="float:right;" onclick="hideColumn(3)">
        //     <svg width="24" height="24" viewBox="0 0 24 24">
        //       <rect x="11" width="2" height="24" rx="1" fill="#ffffff"/>
        //       <rect y="11" width="24" height="2" rx="1" fill="#ffffff"/>
        //     </svg>
        //   </button>';
        $plusbtn = "";
            echo "<th>Blood Pressure Systolic  $sortingArrows</th><th>Blood Pressure Diastolic  $sortingArrows </th>".
                        "<th>Weight  $sortingArrows</th><th> Resting Heart Rate  $sortingArrows </th><th> Date Entry $sortingArrows </th>";
        }

        elseif($table ==2) // displaying thr headers for table 2
        {
        
            if($selectedOption == 2||$selectedOption == 3)// colspan the header based on selectedoption
                {
                    echo " <tr><th colspan='11' style='text-align: center'>Flexibility </th></tr>";
                }
            else
            {
                echo " <tr><th colspan='10' style='text-align: center'>Flexibility </th></tr>";
            } 
            // display column for table 2
        echo "<tr>";
        if($selectedOption==1){
            echo "<th rowspan = '2'>First Name  $sortingArrows</th><th rowspan = '2'>Last Name  $sortingArrows</th>";
        }else{
            echo "<th rowspan = '2'>Sex </th>";
        }

       
        echo "<th colspan='2'>Back Scratch Test (distance in +/ - cm)  </th>";
        echo "<th colspan='2'>Grip Strength (kg)</th><th colspan='2'>Plank Test</th><th colspan='2'>Half Kneeling Dorsiflexion Ankle Test </th></tr>";
        echo "<tr><th>Right  $sortingArrows</th><th>Left $sortingArrows </th>";
        echo "<th>Right  $sortingArrows </th><th>Left  $sortingArrows</th><th> Time Duration   $sortingArrows</th><th>RPE Scale(6-22)  $sortingArrows</th> ";
        echo "<th>Right Ankle(cm)  $sortingArrows</th><th>Left Ankle(cm)  $sortingArrows</th> </th><th  colspan='2'> Date Entry $sortingArrows </th> ";
        
    
        }
        elseif($table == 3) // displaying thr headers for table 3
        {  
            if($selectedOption == 2||$selectedOption == 3)// colspan the header based on selectedoption
                {
                    echo " <tr><th colspan='11' style='text-align: center'>Timed Balancing Test  $sortingArrows</th></tr>";
                }
            else
            { echo " <tr><th colspan='10' style='text-align: center'>Timed Balancing Test  $sortingArrows</th></tr>";
            } 

            // display column for table 3
            echo "<tr>";
            if($selectedOption==1){
                echo "<th rowspan = '2'>First Name  $sortingArrows</th><th rowspan = '2'>Last Name  $sortingArrows</th>";
            }else{
                echo "<th rowspan = '2'>Sex </th>";
            }
         
            
            echo "<th colspan='2'>Tandem</th>";
            echo "<th colspan='2'>Single leg(Left)</th><th colspan='2'>Single leg(right)</th><th colspan='2'>Total time</th></tr>";
            echo "<tr><th>Eyes Open  $sortingArrows</th><th>Eyes closed  $sortingArrows</th>";
            echo "<th>Eyes Open  $sortingArrows</th><th>Eyes closed  $sortingArrows</th><th> Eyes Open   $sortingArrows</th><th>Eyes closed  $sortingArrows</th> ";
            echo "<th>Eyes Open  $sortingArrows</th><th>Eyes closed  $sortingArrows</th> </th><th  colspan='2'> Date Entry $sortingArrows </th>";
            
        }
        elseif($table == 4) // displaying thr headers for table 4
        {
            if($selectedOption == 2||$selectedOption == 3)// colspan the header based on selectedoption
            {
                echo "<tr>
                <th colspan='8' style='text-align: center'> Aerobic Cardiovascular Fitness Assessment  $sortingArrows</th> </tr>";
            }
            else
            { 
                
                echo "<tr>
                <th colspan='7' style='text-align: center'> Aerobic Cardiovascular Fitness Assessment</th> </tr>";
            } 
              // display column for table 4
            echo "<tr><th colspan='6' style='text-align: center'>1 Mile Walking Test </th></tr>";
            echo "<tr>";
            if($selectedOption==1){
                echo "<th>First Name  $sortingArrows</th><th>Last Name  $sortingArrows</th>";
            }else{
                echo "<th>Sex </th>";
            }
           
            echo "<th> Time To Walk one mile (distance=1.625km)  $sortingArrows</th><th>Post Walk Heart Rate  $sortingArrows</th>";
            echo "<th>RPE (6-22)  $sortingArrows</th> <th>VO2  $sortingArrows</th> </th><th> Date Entry $sortingArrows </th>";
        
            echo "</tr>";
        }
        elseif($table == 5) // displaying thr headers for table 4
        {
            if($selectedOption == 2||$selectedOption == 3)// colspan the header based on selectedoption
            {
                echo "<tr>
                <th colspan='3' style='text-align: center'> Perceived Stress Record </th> </tr>";
            }
            else
            { 
                
                echo "<tr>
                <th colspan='4' style='text-align: center'> Perceived Stress Record</th> </tr>";
            } 
       
            echo "<tr>";
            if($selectedOption==1){
                echo "<th>First Name  $sortingArrows</th><th>Last Name  $sortingArrows</th>";
            }else{
                echo "<th>Sex </th>";
            }
           
            echo "<th> Calculated PSS  $sortingArrows</th>";
            echo "<th> Date Entry $sortingArrows </th>";
        
            echo "</tr>";
        }
        // extra column 'sex' based on selected option
       
        echo "</tr>";

        echo "</thead><tbody>";
        while ($row = mysqli_fetch_assoc($result)) {

            if($selectedOption==2 || $selectedOption ==3){}else{
            $cryptor = new Cryptor($encryption_key, $cipher_method);
                //decrypt first and last name
                $firstname = $cryptor->decrypt($row["first_name"]);
                $lastname =  $cryptor->decrypt($row["last_name"]);
          
            }
           
            if($table ==1) // display rows based on the selected table
            {   
                echo"<tr>";
                if($selectedOption == 2||$selectedOption == 3) 
                {
                echo "<td>".$row['sex']."</td>";

                }else{
                    echo " <td>" . $firstname . "</td><td>" . $lastname. "</td>";
                }

             
                echo " <td>" . $row["Systolic_Blood_Pressure"] . "</td><td>" . $row["Diastolic_Blood_Pressure"] . "</td>";
                echo " <td>" . $row["Weight"] . "</td><td>" . $row["Resting_Heart_Rate"] . "</td>";
                echo " <td>" . $row["DATE_ENTRY"] . "</td>" ;
                echo "</tr>";

            }
            elseif($table ==2) // display rows based on the selected table
            {
                

                echo"<tr>";
                if($selectedOption == 2||$selectedOption == 3) 
                {
                echo "<td>".$row['sex']."</td>";

                }else{
                    echo " <td>" . $firstname . "</td><td>" . $lastname. "</td>";
                }
            echo " <td>" . $row["Right_Back_Scratch"] . "</td><td>" . $row["Left_Back_Scratch"] . "</td>";
            echo " <td>" . $row["Right_Grip_Strength"] . "</td><td>" . $row["Left_Grip_Strength"] . "</td>";
            echo " <td>" . $row["Plank_Duration"] . "</td><td>" . $row["Plank_RPE"] . "</td>";
            echo " <td>" . $row["Right_Ankle_Test"] . "</td><td>" . $row["Left_Ankle_Test"] . "</td>";
            echo " <td>" . $row["DATE_ENTRY"] . "</td>" ;
            echo "</tr>";

            }
            elseif($table == 3) // display rows based on the selected table
            {
                echo "<tr>";
                if($selectedOption == 2||$selectedOption == 3) 
                {
                echo "<td>".$row['sex']."</td>";

                }else{
                    echo " <td>" . $firstname . "</td><td>" . $lastname. "</td>";
                }
                echo " <td>" . $row["Tandon_eye_open"] . "</td><td>" . $row["Tandon_eye_close"] . "</td>";
                echo " <td>" . $row["Right_Leg_eye_open"] . "</td><td>" . $row["Right_Leg_eye_close"] . "</td>";
                echo " <td>" . $row["Left_Leg_eye_open"] . "</td><td>" . $row["Left_Leg_eye_close"] . "</td>";
                echo " <td>" . $row["Total_eye_open"] . "</td><td>" . $row["Total_eye_close"] . "</td>";
                echo " <td>" . $row["DATE_ENTRY"] . "</td>" ;
                echo "</tr>";
            }
           
            elseif($table == 4) // display rows based on the selected table
            {
                  
               


                echo "<tr>";
                if($selectedOption == 2||$selectedOption == 3) 
                {
                echo "<td>".$row['sex']."</td>";

                }else{
                    echo " <td>" . $firstname . "</td><td>" . $lastname. "</td>";
                }
                echo " <td>" . $row["Time_Completed_1Mile"] . "</td><td>" . $row["RPE"] . "</td>";
                echo " <td>" . $row["VO2"] . "</td><td>" . $row["Post_Walk_HeartRate"] . "</td>";
                echo " <td>" . $row["DATE_ENTRY"] . "</td>" ;
                echo "</tr>";
            }
           

            elseif($table == 5) // display rows based on the selected table
            {
                  
                echo "<tr>";
                if($selectedOption == 2||$selectedOption == 3) 
                {
                echo "<td>".$row['sex']."</td>";

                }else{
                    echo " <td>" . $firstname . "</td><td>" . $lastname. "</td>";
                }
                echo " <td>" . $row["calculatedResult"] . "</td>";
                echo " <td>" . $row["DATE_ENTRY"] . "</td>" ;
                echo "</tr>";
            }
           
        }   
         echo "</tbody>";
    } else {
        $_SESSION['table'] = 1;
        
    }

        
}

        /*
        function to set sql select statement based on the category
        */
function setSqltable($number, $selectedOption)
{
    $includeUser = "first_name,last_name,";
    //echo $selectedOption;
    if($selectedOption ==2 || $selectedOption == 3){
        $includeUser = "";
    }
    switch($number)
        {
            case "1":
                $sql = "SELECT  $includeUser ROUND(Systolic_Blood_Pressure, 0) as Systolic_Blood_Pressure, ROUND(Diastolic_Blood_Pressure,0) as Diastolic_Blood_Pressure, ROUND(Weight, 2) as Weight, ROUND(Resting_Heart_Rate, 0) as Resting_Heart_Rate, DATE_ENTRY ";                
                break;
            case "2":
                $sql = "SELECT  $includeUser ROUND(Left_Back_Scratch, 0) as Left_Back_Scratch, ROUND(Right_Back_Scratch, 0) as Right_Back_Scratch, ROUND(Right_Grip_Strength, 0) as Right_Grip_Strength,ROUND(Left_Grip_Strength, 0) as Left_Grip_Strength, ROUND( Plank_Duration, 2) as Plank_Duration,ROUND(Plank_RPE, 2) as Plank_RPE , ROUND(Left_Ankle_Test, 0) as Left_Ankle_Test, ROUND(Right_Ankle_Test, 0) as Right_Ankle_Test, DATE_ENTRY ";                
                break;
            case "3":
                $sql = "SELECT  $includeUser ROUND(Tandon_eye_open, 2) as Tandon_eye_open, ROUND(Tandon_eye_close, 2) as Tandon_eye_close, ROUND(Right_Leg_eye_open, 2) as Right_Leg_eye_open ,ROUND(Right_Leg_eye_close, 2) as Right_Leg_eye_close, ROUND(Left_Leg_eye_open, 2) as Left_Leg_eye_open, ROUND(Left_Leg_eye_close, 2) as Left_Leg_eye_close, ROUND(Total_eye_open, 2) as Total_eye_open, ROUND(Total_eye_close, 2) as Total_eye_close, DATE_ENTRY ";
                 break;
            case "4":
                $sql = "SELECT  $includeUser ROUND(Time_Completed_1Mile,2) as Time_Completed_1Mile, ROUND(RPE, 2) as RPE, ROUND(VO2, 2) as VO2, ROUND(Post_Walk_HeartRate, 2) as Post_Walk_HeartRate, DATE_ENTRY ";
                break;
            case "5":
                $sql = "SELECT  $includeUser calculatedResult, DATE_ENTRY ";
                break;

        }

        //echo $sql;
    return $sql;

}
/*
get svg to sort table based on column values
*/
function sortingArrow(){

    return '<span type="button" style="padding: 10px;" onclick="sortTable(this, \'asc\');" id="asc1">&#x2191;</span><span type="button" onclick="sortTable(this, \'desc\');" id="desc1">&#x2193;</span>';
}

/*
        function to set sql from statement based on the option
        */
function setSqlview($view)
{
    switch($view)
        {
            case "1":
                $sql = " FROM functional_capacity_gpuser_date;";                
                break;
            case "2":
                $sql = " ,sex FROM `functional_capacity_gpsexdate`; ";                
                break;
            case "3":
                $sql = " ,sex FROM `functional_capacity_gpsex` ; ";
                 break;
            case "4":
                $sql = "  from perceived_stress_record_gpuser_date ; ";
                    break;


        }

    return $sql;

}


?>