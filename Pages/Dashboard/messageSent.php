<?php
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
   
        <h1 class="text-center">Message has been sent successfully!</h1>
       
        <div class="text-center">

            <br>

            <a class="btn btn-primary" href="../../Pages/Dashboard/physicianDashboard.php">View Dashboard</a>
        </div>
        <br>
    </div>