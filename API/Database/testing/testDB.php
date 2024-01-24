<?php 


/**
 * This file runs some tests on whether the main APIS for creating connection , selecting , inserting and updating work properly. 
 * Since this file needs a database to work with , it is not part of github automation and can be run manually from terminal .
 * We have added the date to the logs . some of the dates are manully formatted just for the purpose of seeing how the log files will look like.
 * We will be working on automating running this test in future when MVP is  done. 
 */
$config_path = "../config.php";
require_once $config_path ; 
$fp = fopen('testConfig.log', 'a')or die("Unable to open file!");
$title = "\n ================= Running Test for config database functions . Date : " . date("Y-m-d"). "=================";

fwrite($fp,$title);
fclose($fp);
testCreateConnection();
testCreateCustomConnection();
testRunSelect();
estSafeRunSelect();
testSafeRunInsert();
testSafeRunUpdate();


function testCreateConnection(){
    $fp = fopen('testConfig.log', 'a')or die("Unable to open file!");

    $conn = startConnection();
    if($conn instanceof  mysqli){
        echo "Connection established. Test passed";
        fwrite($fp, "\n Connection established. Test passed");
    }else {
        echo "test for connection failed";
        fwrite($fp, "\n test for connection failed");
    }
    fclose($fp);
}


function testCreateCustomConnection(){
    $fp = fopen('testConfig.log', 'a')or die("Unable to open file!");
    $conn = CustomStartConnection("localhost","root", "", "VWS2" );
    if($conn instanceof  mysqli){
        echo "<br>\nConnection established. Test passed for Custom Connection function";
        fwrite($fp, "\n Connection established. Test passed for Custom Connection function");
    }else {
        echo "<br>\ntest for connection failed";
        fwrite($fp, "\n test for connection failed");
    }
    fclose($fp);
}

function testRunSelect(){
    $fp = fopen('testConfig.log', 'a')or die("Unable to open file!");
    $sql = "SELECT 1 from user limit 1";
    $conn = CustomStartConnection("localhost","root", "", "vws2" );
    $result = runSelect($conn, $sql);

    if($result!=null){
        while($row = $result->fetch_assoc()){
            if($row[1] == 1){
                echo "<br>\nData selected successfully. Test passed for runSelect function";
                fwrite($fp, "\nData selected successfully. Test passed for runSelect function");
            }else {
                echo "<br>\nWrong data selected";
            }
        }
    }
    fclose($fp);
}


function estSafeRunSelect(){
    $fp = fopen('testConfig.log', 'a')or die("Unable to open file!");
    $sql = "SELECT 1 from user where 1= ? limit 1";
    $conn = CustomStartConnection("localhost","root", "", "vws2" );
    $result = SafeRunSelect($conn, $sql, [1]);

    if($result!=null){
        while($row = $result->fetch_assoc()){
            if($row[1] == 1){
                echo "<br>\nData selected successfully. Test passed for SafeRunSelect function";
                fwrite($fp, "\nData selected successfully. Test passed for SafeRunSelect function");
            }else {
                echo "<br>\nWrong data selected";
                fwrite($fp, "\nWrong data selected");
            }
        }
    }
    fclose($fp);
}



function testSafeRunInsert(){
    $fp = fopen('testConfig.log', 'a')or die("Unable to open file!");
    $sql = "INSERT INTO `user`( `username`, `password`, `first_name`, `last_name`, `email`, `phone`, `privilege_level`, `verified`) VALUES (?,?,?,?,?,?,?,?); ";
    $conn = CustomStartConnection("localhost","root", "", "vws2" );
    $result = SafeRunInsert($conn, $sql, ['usernameTest','testPass','fname_test','fname_last','test@email.com','903-222-222',2,'1']);

    if($result == true){
        echo "\nInsert statement executed successfully";
    }else {
        echo "\nsomething wrong happened. test failed.";
        return;
    }
    $sql2 = "select 1 from user where username='usernameTest'";
    $res = runSelect($conn, $sql2);
    if($result!=null){
        while($row = $res->fetch_assoc()){
            if($row[1] == 1){
                echo "<br>\nData that was inserted exist. Test passed for SafeRunInsert function";
                fwrite($fp, "\nData that was inserted exist. Test passed for SafeRunInsert function");
            }else {
                echo "<br>\nWrong data selected.Test failed";
                fwrite($fp, "\nWrong data selected.Test failed");
            }
        }
    }
    fclose($fp);
    $sql = "DELETE FROM `user` WHERE username='usernameTest'";
    $res = runDelete($conn, $sql);
}

function testSafeRunUpdate(){
    $fp = fopen('testConfig.log', 'a')or die("Unable to open file!");
    $sql = "INSERT INTO `user`( `username`, `password`, `first_name`, `last_name`, `email`, `phone`, `privilege_level`, `verified`) VALUES (?,?,?,?,?,?,?,?); ";
    $conn = CustomStartConnection("localhost","root", "", "vws2" );
    $result = SafeRunInsert($conn, $sql, ['usernameTest_update','testPass','fname_test','fname_last','test@email.com','903-222-222',2,'1']);


    $sql2 = "UPDATE user set username= ? where username='usernameTest_update'";
    $resUpdate = SafeRunUpdate($conn, $sql2 , ["usernameTest_update2"]);
    if($resUpdate == true){
        echo "\n Update statement executed successfully";
    }else {
        echo "\nsomething wrong happened. test failed.";
        return;
    }
    $sql2 = "select 1 from user where username='usernameTest_update2'";
    $res = runSelect($conn, $sql2);
    if($result!=null){
        while($row = $res->fetch_assoc()){
            if($row[1] == 1){
                echo "<br>\nData that was updated . Test passed for SafeRunUpdate function";
                fwrite($fp, "\nData that was updated . Test passed for SafeRunUpdate function");
            }else {
                echo "<br>\n Test failed SafeRunUpdate";
                fwrite($fp, "\nTest failed SafeRunUpdate");
            }
        }
    }

   $sql3 = "DELETE FROM `user` WHERE username='usernameTest_update2'";
   $res = runDelete($conn, $sql3);

    fclose($fp);
}


?>