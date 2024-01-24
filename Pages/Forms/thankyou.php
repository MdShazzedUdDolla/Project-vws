<?php
include "../../API/PhysiciansAPI/articles.php";
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thank You</title>
    <!-- <link rel="stylesheet" href="../../Style/VWS_CSS/vendor.css">
    <link rel="stylesheet" href="../../Style/VWS_CSS/custom_dashboard.css"> -->
    <link rel="" href="../../Assets/vendor/bootstrap/css/bootstrap.min.css">
    <style>
        .alert-warning {
            color: #856404;
            background-color: #fff3cd;
            border-color: #ffeeba;
            text-align: center;
        }

        .alert-danger {
            color: #721c24;
            background-color: #f8d7da;
            border-color: #f5c6cb;
            text-align: center;
        }

        .alert-success {
            color: #155724;
            background-color: #d4edda;
            border-color: #c3e6cb;
            text-align: center;
        }
        .alert-info {
        color: #0c5460;
        background-color: #d1ecf1;
        border-color: #bee5eb;
        text-align: center;
        }
    </style>
</head>

<body>
    <?php 
include_once "../../Components/general/header.php";
?>
    <?php
include_once "../../Components/general/sidebar.php";
 
?>
    <div id="main">
   
        <h1 class="text-center">Thank You For Submitting the Form</h1>
        <?php if(isset($_GET['response'])) {
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }
              $response = base64_decode($_GET['response']);
              echo $response;
              echo "<div></div>";
              $message="
            <div class='alert-info'>
            Individual scores on the PSS can range from 0 to 40 with higher scores indicating higher perceived stress.
            <ol>
            <li>Scores ranging from 0-13 would be considered low stress.</li>
            <li>Scores ranging from 14-26 would be considered moderate stress.</li>
            <li>Scores ranging from 27-40 would be considered high perceived stress.</li>
            </ol>
            </div>";
              echo $message;
              echo "<div></div>";
        }
      
       
        ?>
        <div class="text-center">

            <br>
            <?php 
                if($_SESSION['privilege_level']==3){
                    ?>
                     <a class="btn btn-primary" href="../../Pages/Dashboard/patientDashboard.php">View Health Measure</a>
               <?php }else{
             ?>   
                    <a class="btn btn-primary" href="../../Pages/Dashboard/physicianDashboard.php">View Health Measure</a>
             <?php  }
            ?>
           
        </div>
        <br>
        <div class="text-center">
            <a class="btn btn-primary" href="../../Pages/Dashboard/graphing.php">View Health Measure on Graph</a>
        </div>
    </div>