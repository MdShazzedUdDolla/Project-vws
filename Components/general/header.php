<?php


if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')   
    $url = "https://";   
else  
    $url = "http://";   
// Append the host(domain name, ip) to the URL.   
$url.= $_SERVER['HTTP_HOST'];   


//echo $url;
function redirect($url, $statusCode = 303)
{
   header('Location: ' . $url, true, $statusCode);
   die();
}


if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 1800)) {
  // last request was more than 30 minutes ago
  session_unset();     // unset $_SESSION variable for the run-time 
  session_destroy();   // destroy session data in storage
}
$_SESSION['LAST_ACTIVITY'] = time(); // update last activity time stamp

/*
time stamp to regenerate the session ID periodically to avoid attacks on sessions like session fixation:
*/ 
if (!isset($_SESSION['CREATED'])) {
  $_SESSION['CREATED'] = time();
} else if (time() - $_SESSION['CREATED'] > 1800) {
  // session started more than 30 minutes ago
  session_regenerate_id(true);    // change session ID for the current session and invalidate old session ID
  $_SESSION['CREATED'] = time();  // update creation time
}


if (isset($_POST["logout_pressed"])) {
  session_destroy();
 
  redirect($url);
  die();//this is in case the browser didnt allow auto redirect. Should be added to all the other redirect in source code as well if missing(alternative is to use exit())
}


$username= "";

if(isset($_SESSION['loggedin']) && $_SESSION['loggedin']==true && isset($_SESSION['username']) && $_SESSION['username'] != "" && $_SESSION['username'] != null){
  $username = $_SESSION['username'];
}
else{
   echo "Not logged in ";
   if (session_status() === PHP_SESSION_NONE) {
   
  }else{
    session_destroy();
  }
  redirect($url);
   die(); //this is incase the browser didnt allow auto redirect

}
?>
<style>
    #main {
    transition: margin-left .5s; /* If you want a transition effect */
    padding: 20px;
    margin-left: 250px;
    }

    /* On smaller screens, where height is less than 450px, change the style of the sidenav (less padding and a smaller font size) */
    @media screen and (max-height: 450px) {
    .sidebar {padding-top: 15px;}
    .sidebar a {font-size: 18px;}
    }

    .openbtn {
    font-size: 20px;
    cursor: pointer;
    background-color: #111;
    color: white;
    padding: 10px 15px;
    border: none;
    }

    .openbtn:hover {
    background-color: #444;
    }
    .header {
    overflow: hidden;
    }
    .content {
    padding: 16px;
    }

    .sticky {
    position: fixed;
    top: 0;
    width: 100%;
    }

    .sticky + .content {
    padding-top: 60px;
    }
    body {
  margin: 0;
  /* font-size: 28px;
  font-family: Arial, Helvetica, sans-serif; */
}

.header {
  /* background-color: #f1f1f1; */
  /* padding: 30px; */
  /* text-align: center; */
  z-index: 1;
  margin-left: auto; 
  width: auto;
}
.container{
    z-index: 0;
    margin-top: 5%; 

}


</style>
<link rel="stylesheet" href="../../Style/VWS_CSS/patient_dashboard.css">
<link rel="stylesheet" href="../../Style/VWS_CSS/vendor.css">
<link rel="stylesheet" href="../../Style/VWS_CSS/custom_dashboard.css">
<script src="../../Js_Script/VWS_JS/app.js"></script>
<script src="../../Js_Script/VWS_JS/vendor.js"></script>
<script>
    /* Set the width of the sidebar to 250px and the left margin of the page content to 250px */
function openNav() {
  document.getElementById("mySidebar").style.width = "250px";
  document.getElementById("main").style.marginLeft = "250px";
  document.getElementById('closebtn').style.visibility = "";
  document.getElementById('openbtn').style.visibility = "hidden";
}

/* Set the width of the sidebar to 0 and the left margin of the page content to 0 */
function closeNav() {
  document.getElementById("mySidebar").style.width = "0";
  document.getElementById("main").style.marginLeft = "0";
  document.getElementById('closebtn').style.visibility = "hidden";
  document.getElementById('openbtn').style.visibility = "";
}
window.onscroll = function() {myFunction()};

var navbar = document.getElementById("navbar");
var sticky = navbar.offsetTop;

function myFunction() {
  if (window.pageYOffset >= sticky) {
    navbar.classList.add("sticky")
  } else {
    navbar.classList.remove("sticky");
  }
}

</script>
<nav id="navbar" name="navbar" style="background-color: #3a4651;" class="navbar sticky-top navbar-dark bg-dark">
 
    <div class="navbar-brand" >
    <!-- <span class="navbar-toggler-icon"></span> -->
    <button id='closebtn' class="openbtn" onclick="closeNav()">&#9776; </button>
    <button id='openbtn' class="openbtn" onclick="openNav()" style="visibility: hidden;">&#9776; </button>
    </div>
    <?php 
                  
                  if($_SESSION['privilege_level'] == 3){
                      $DashboardUrl = "../../Pages/Dashboard/patientDashboard.php";
                     
                  }else{
                      $DashboardUrl = "../../Pages/Dashboard/physicianDashboard.php";
                  }
              ?>
    <a href = "<?php echo $DashboardUrl ?>" style="text-decoration: none">
    <h3 style="text-align:center; margin-left: 0; 
    margin-right: 0; float: center; color:azure" >Virtual Wellness System</h3></a>
    <div style=" margin-right:5%; float: right;" class="dropdown show">
    <a class="btn btn-dark dropdown-toggle dropleft" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    <span class="name">
         <?php echo $username ?> 
        </span>
    </a>

    <div  class="dropdown-menu " aria-labelledby="navbarDarkDropdownMenuLink">
        <a style="text-decoration:none" class="dropdown-item" href="../../Pages/Dashboard/viewProfile.php">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>    
        Profile</a>
                <form method="POST">
                    <a style="text-decoration:none" class="dropdown-item" onclick="this.parentNode.submit()" href="#">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-log-out"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg>
                        Logout </a>
                        <input type="hidden" name="logout_pressed"/>
                </form>
    </div>
    </div>


    <!-- <div class="dropdown">
        <button class="btn btn-dark dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
          Dropdown
        </button>
        <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="dropdownMenuButton">
            <li><a class="dropdown-item" href="#">Option 1</a></li>
            <li><a class="dropdown-item" href="#">Option 2</a></li>
            <li><a class="dropdown-item" href="#">Option 3</a></li>
        </ul>
    </div> -->
</nav>