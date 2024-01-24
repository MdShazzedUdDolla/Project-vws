<?php

/**
 * This file contains the main configuration for creating connection to database and running sql queries
 * 
 */
 //in production they shoudl be stored more securely, different methods for storing DB credentials are provided in security documentation
define('HOST_NAME',"localhost");
define('USERNAME',"root");
define('PASSWORD',"");
define('DB_NAME',"VWS");

$debug = false;//change this to true only during development
if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')   
    $url = "https://";   
else  
    $url = "http://";   
// Append the host(domain name, ip) to the URL.   
$url.= $_SERVER['HTTP_HOST'];   
$url.="/Pages/Error/ServerError.php";

 function startConnection(){
   
    global $debug,$url;
	// $servername = "localhost";
	// $username = "root";
	// $password = "";
    // $dbname = "VWS";
   
  
	// Create connection
    try{
        $conn = new mysqli(HOST_NAME, USERNAME, PASSWORD, DB_NAME);
        if ($conn->connect_error) {

            if($debug==true){
                die("Connection failed: " . $conn->connect_error);
            }else{
                 redirect2($url);
                die("Server Error, Please try again later ");
            }
        }else{
            return $conn;
        }
    }catch(Exception $e){
        if($debug==true){
            echo "Error: " . $e->getMessage();
        }else{
            redirect2($url);
           
            die("Server Error, Please try again later ");
           
        }
       
    }
    /**
     * This is how we access the databse info which will be save in the deployment server in httpd.conf  file 
     * 
     * This is how we save those values on httpd.conf
     * 
     * php_value mysql.default.user      myusername
     * php_value mysql.default.password  mypassword
     * php_value mysql.default.host      server
     * 
     *  mysqli(ini_get("mysql.default.user"),ini_get("mysql.default.password"),ini_get("mysql.default.host"));

     * **/ 


	// Check connection
    
	
	// Display connection
	// echo "Connected successfully";

}
function redirect2($url, $statusCode = 303)
{
   header('Location: ' . $url, true, $statusCode);
   die();
}
//TODO: could be best to include user and password in a seprate database ?
function CustomStartConnection($server_name ,$user_name, $psw, $db_name){
    global $debug,$url;
	// Create connection
    try{
        $conn = new mysqli($server_name, $user_name, $psw, $db_name);
        if ($conn->connect_error) {

            if($debug==true){
                die("Connection failed: " . $conn->connect_error);
            }else{
                 redirect2($url);
                die("Server Error, Please try again later ");
            }
        }else{
            return $conn;
        }
    }catch(Exception $e){
        if($debug==true){
            echo "Error: " . $e->getMessage();
        }else{
            redirect2($url);
           
            die("Server Error, Please try again later ");
           
        }
       
    }
}

   
 
/*
this function will be used for queries that contain users parameters
*/ 
function SafeRunSelect($conn, $sql, $data){
    global $debug,$url;
    //sanatize (data)
    //$result = $conn->prepare($sql);
    if (!($st = $conn->prepare($sql) )) {
        if($debug==true){
        die( "Can't prepare the statement :(" );
        }else{
            redirect2($url);
           
            die("Server Error, Please try again later ");
        }
    }
   // create the types string dynamically and bind an array
    $types = str_repeat('s', count($data)); // returns sss...
    $st->bind_param($types, ...$data); 

    // execute and fetch the rows
    if($st->execute()){
      
        if ($result = $st->get_result()) {
            mysqli_stmt_close($st);
            if($result->num_rows>0){  
                return $result; //to retrieve the result in a two dimensional array use result -> fetch_all(MYSQLI_ASSOC);
            }else{
                // echo "number of rows was 0 ";
                return null;
            }
            
        } else {
            echo "not result";
            mysqli_stmt_close($st);
            closeConnection($conn);
            //return null;
        }
    }else{
        redirect2($url);
           
        die("Server Error, Please try again later ");
        //echo "There was a problem. Please try again.";
    }

}

function SafeRunInsert($conn, $sql, $data){
    global $debug,$url;
    if (!($st = $conn->prepare($sql) )) {
        if($debug==true){
            die( "Can't prepare the statement :(" );
            }else{
                redirect2($url);
               
                die("Server Error, Please try again later ");
            }
    }
   // create the types string dynamically and bind an array
    $types = str_repeat('s', count($data)); // returns sss...
    $st->bind_param($types, ...$data); 

    // execute and fetch the rows
    if($st->execute()){  
        // echo "
        // <div class='alert alert-success' role='alert'>
        // New record created successfully
        // </div>
        // ";
        mysqli_stmt_close($st);
        return true;
    } else {
        if($debug==true){
            echo "Error: ". mysqli_error($conn);
            }else{
                mysqli_stmt_close($st);
                closeConnection($conn);
                redirect2($url);
               
                die("Server Error, Please try again later ");
            }
      
        mysqli_stmt_close($st);
        closeConnection($conn);
    }
}

function SafeRunUpdate($conn, $sql, $data){
    global $debug,$url;
    if (!($st = $conn->prepare($sql) )) {
        if($debug==true){
            die( "Can't prepare the statement :(" );
            }else{
                redirect2($url);
               
                die("Server Error, Please try again later ");
            }
      
    }
   // create the types string dynamically and bind an array
    $types = str_repeat('s', count($data)); // returns sss...
    $st->bind_param($types, ...$data); 

    // execute and fetch the rows
    if($st->execute()){
        // echo "
        // <div class='alert alert-success' role='alert'>
        // New record created successfully
        // </div>
        // ";
        mysqli_stmt_close($st);
        return true;
    } else {
        if($debug==true){
            echo "Error: ". mysqli_error($conn);
            }else{
                mysqli_stmt_close($st);
                closeConnection($conn);
                redirect2($url);
               
                die("Server Error, Please try again later ");
            }
      
        mysqli_stmt_close($st);
        closeConnection($conn);
    }		
}

function SafeRunDelete($conn, $sql, $data){
    global $debug,$url; 
    if (!($st = $conn->prepare($sql) )) {
        if($debug==true){
            die( "Can't prepare the statement :(" );
            }else{
                redirect2($url);
               
                die("Server Error, Please try again later ");
            }
    }
   // create the types string dynamically and bind an array
    $types = str_repeat('s', count($data)); // returns sss...
    $st->bind_param($types, ...$data); 

    // execute and fetch the rows
    if($st->execute()){
        // echo "
        // <div class='alert alert-success' role='alert'>
        // New record created successfully
        // </div>
        // ";
        mysqli_stmt_close($st);
        return true;
    } else {
        if($debug==true){
            echo "Error: ". mysqli_error($conn);
            }else{
                mysqli_stmt_close($st);
                closeConnection($conn);
                redirect2($url);
               
                die("Server Error, Please try again later ");
            }
      
        mysqli_stmt_close($st);
        closeConnection($conn);
    }		
}

/**
 * Do not use it for queries with user data
 * 
 */
function runSelect($conn, $sql){

    global $debug,$url;
    try{
        $result = $conn->query($sql);
     }catch(Exception $e){

        if($debug==true){
            echo "Error: ". $e->getMessage();
        }else{
            echo "There was an error. Please try again later $sql";
            closeConnection($conn);
            redirect2($url);
            die("Server Error, Please try again later ");
        }
  
   
  
       
    //     die("Server Error, Please try again later ");
    }


    if ($result) {
        if ($result->num_rows > 0) {
            return $result;
        } else {
            closeConnection($conn);
           // echo("No results");
        }
    } else {

        if($debug==true){
            echo "Error: ". mysqli_error($conn);
            }else{
                closeConnection($conn);
                redirect2($url);
               
                die("Server Error, Please try again later ");
            }
        closeConnection($conn);
        
    }
}
/**
 * This function can safely be used if the query passed to it is completely made by developers
 * (NO USER DATA SHOULD BE USED IN THE QUERY) * 
 */
function runInsert($conn, $sql){
    global $debug,$url;
    if (mysqli_query($conn, $sql)) {
        echo "
        <div class='alert alert-success' role='alert'>
        New record created successfully
        </div>
        ";
    } else {

    if($debug==true){
        echo "Error: ". mysqli_error($conn);
    }else{
       
            closeConnection($conn);
            redirect2($url);
           
            die("Server Error, Please try again later ");
    }

    }
}
/**
 * Do not use it for queries with user data
 */
function runUpdate($conn, $sql){
    global $debug,$url;
    $result ='';
    if ($conn->query($sql) === TRUE) {
        $result = "Record updated successfully";
        echo $result;
    } else {
        
            if($debug==true){
                $result = "Error updating record" ;
                echo $result. $conn->error;
                return $result;		
                }else{
            
                    closeConnection($conn);
                    redirect2($url);
                
                    die("Server Error, Please try again later ");
                }
            closeConnection($conn);
    }


}
/**
 * Do not use it for queries with user data
 */
function runDelete($conn, $sql){
    global $debug,$url;
    if ($conn->query($sql) === TRUE) {
    $result = "Record deleted successfully";
    } else {
        if($debug==true){
            $result = "Error deleting record: " . $conn->error;
            return $result;		
            }else{
        
                closeConnection($conn);
                redirect2($url);
            
                die("Server Error, Please try again later ");
            }
        closeConnection($conn);

    }

}




function closeConnection($conn){
	// Close connection
    try{
        mysqli_close($conn); 
    }catch(Exception $e){
        //if already closed do nothing
    }

}



?>