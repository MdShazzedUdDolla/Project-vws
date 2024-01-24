<?php
// Import necessary files
include_once "../../API/PhysiciansAPI/fetchDataForGraph.php";

?>



<!DOCTYPE html>
<html lang="en">

<?php
  //  $result = getData($_POST, true);
  //  print_r($result) ;

?>





<head>
<meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <!--<meta name="viewport" content="width=device-width, initial-scale=1.0">-->
     <!-- the title of the web page -->
     
     <title>Graph for physician</title>
     <style>
      /* Graph styles for different screen sizes */
        canvas#graph{
          position: relative;
          display: flex;
          border: 1px solid black;
          float: right;
          width: 65%;
          max-width: 68.7%;
          min-height: 93% !important;
          max-height: 93% !important;
        }
        #main {
          height: 80%;
          width: 80%;
          justify-content: center;
          max-height: 80%;
          top: 50%;
          left: 50%;
          margin-right: -50%;
          min-width: 80%;
          transform: translate(4%, 4%);
        }
        select {
          width: 60%;
          float: right;
        }
        /* Media queries for different screen sizes */
        @media (max-width: 1700px){
          canvas#graph {
            width: 700px !important;
          }
        }
        @media (max-width: 1600px) {
          canvas#graph {
            width: 650px !important;
          }
          #main{
            transform: translate(2%, 4%);
          }
        }

        @media (max-width: 1423px) {
          canvas#graph {
            width: 600px !important;
          }
          #main{
            transform: translate(2%, 4%);
          }
        }

        @media (max-width: 1380px) {
          canvas#graph {
            width: 550px !important;
          }
        }

        @media (max-width: 1300px){
          canvas#graph {
            width: 500px !important;
          }
          #main{
            transform: translate(2%, 4%);
          }
        }

        
        @media (max-width: 1240px){
          canvas#graph {
            width: 450px !important;
          }
          #main{
            transform: translate(2%, 4%);
          }
        }

        @media (max-width: 1180px){
          canvas#graph {
            width: 400px !important;
          }
          #main{
            transform: translate(2%, 4%);
          }
        }

        @media (max-width: 1110px){
          canvas#graph {
            width: 350px !important;
          }
          #main{
            transform: translate(2%, 4%);
          }
        }

        @media (max-width: 1050px){
          canvas#graph {
            width: 300px;
          }
          #main{
            transform: translate(2%, 4%);
          }
        }

        @media (max-width: 1000px){
          canvas#graph {
            width: 250px;
          }
          #main{
            transform: translate(2%, 4%);
          }
        }
        @media (max-height: 900px){
          #main{
            background-color: transparent;
            border: none !important;
          }
          #health_measures{
            display: none;
          }
        }


    </style>
 
     <!-- Bootstrap CSS -->
     <!-- include Bootstrap CSS for styling -->
     <link rel="stylesheet" href="../../Assets/vendor/bootstrap/css/bootstrap.min.css">
      <!-- custom CSS for styling the dropdown menu -->
     <link rel="stylesheet" href="../../Style/VWS_CSS/dropdown.css">
     <!-- include Chart.js library for creating charts -->
     <script type="text/javascript" src="../../Js_Script/VWS_JS/chart.js"></script>
     <script src="../../Js_Script/jquery/chart.js"></script>
   
     <script src="../../Js_Script/jquery/jquery3.6.1.js"></script>
     <script src="../../Js_Script/jquery/JQuery_multiSelect.js"></script>
     
   
    
     <?php
     include_once "../../Components/general/header.php";
     include_once "../../Components/general/sidebar.php";
     ?>
</head>
<!-- the body of the web page -->
<body>     



<br>
<br>
<!-- a container for the graph and filters -->
<div id="main" style="margin-right:5% "  class="container-fluid container-graph">

<!-- a form for selecting filters and submitting the form -->
<form id="graphFilter" name="graphFilter" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
   <!-- a heading for the filter section -->

  <span class="col-12" id="health_measures">Graphing</span>
  <!-- a horizontal line for separating the heading from the filters -->
  <hr style="border: 1px solid black;"></hr>

   <!-- a vertical line for separating the graph and the filters -->
  <div class="vl"></div>
  
  <!-- a canvas element for displaying the graph -->
  <canvas id="graph"></canvas>

  <!-- a script for fixing the resolution of the graph on high-resolution displays -->
  <script type="text/javascript" src="graph_resolution_fix.js"></script>


<br>

<!-- a row for selecting health measures -->
<div class="row">
   <!-- a warning message for when no health measures are selected -->
  <span style="left: 12%; font-size: 2em;" id="hm-warning" class="col-1"></span>
      <div style="text-align: left; left: -.5%;" class="col-10">

       <!-- a custom dropdown menu for selecting health measures -->
        <div id="hm-dropdown" class="checkbox-dropdown">
          <span>Choose Health Measures</span>
          <ul class="checkbox-dropdown-list">
            <?php
             // PHP code for retrieving health measures from a database and creating list items for them
            $html = getHealthInformation('functional_capacity_record');
            echo $html;
            ?>
          </ul>
          
        </div>
      </div>
    </div>


    <br>
  <!-- a row for displaying a warning message when no health measures are selected -->
<div style="position: relative; right: 1%;" class="row hm-dropdown-danger" id="hm-dropdown-danger">
</div>





<?php
  // PHP code for checking if the user has admin privileges
  if($_SESSION['privilege_level'] != 3) {?>
  <br>
  <br>
  <br>
   <!-- a row for selecting a filter by gender or by user -->
  <div class="row">
     <!-- Left side column for gender filter -->
  <div style="left: -5%;" class="form-group col-6">
    <input type="radio" name="radio-group" id="gender-filter" value="gender-filter">
    <label for="gender-filter">Filter by gender</label>
  </div>
    <!-- Right side column for user filter -->
  <div style="left: 5%;" class="form-group col-6">
    <input type="radio" name="radio-group" id="user-filter" value="user-filter" checked>
    <label for="user-filter">Filter by user</label>
  </div>
</div>
  <div class="form-row">
    <div class="form-group col-6">
      <div style="left: -4%;" id="gender-dropdown" class="checkbox-dropdown">
            <span style="text-align: left;">Select Gender Averages</span>
            <ul class="checkbox-dropdown-list">       
              <li style="text-align: left;"><label><input type=checkbox value="male" name=gender[]/>Male</label></li>
              <li style="text-align: left;"><label><input type=checkbox value="female" name=gender[]/>Female</label></li>
            </ul>
      </div>
    </div>
      <div class="form-group col-6">
        <div style="left: -4%;" id="partic-dropdown" class="checkbox-dropdown">
        
          <span>Select participant</span>
          
          <ul class="checkbox-dropdown-list">       
            <?php 
            $html = getParticipant('functional_capacity_record');
            echo $html;
            ?>
          </ul>

        </div>
        <span style="left: 12%; font-size: 2em;" id="partic-warning" class="col-1"></span>
        
      </div>
  </div>

  <br>
  <?php }?> 

  <?php
    //Formatting to make user graph look like admin one
   if($_SESSION['privilege_level'] == 3) {?> 
    <br>
    <br>
    <br>
  <?php } ?>


    <br>
    <div style="position: relative; bottom:-10%;" class="row csv-danger">
    </div>

    <div class="row">
      <div style="position: relative; right: 1%;" class="row partic-dropdown-danger" id="partic-dropdown-danger">
    </div>
  <!-- A row for displaying date range selection -->
  <div class="row">

    <div style="position: relative; left: -10%;" class="col-11">
      <label style="position: relative; left: 17%;">Dates</label>
    </div>
  </div>

  <!-- A form row for selecting the start and end dates -->
  <br>
  <div class="form-row">
   <!--<div class="form-group">-->
    <div class="form-group col-5">
      <label style="position: relative; left: 5%;">Start Date</label>
      <br>
        <input style="position: relative; left: 8%;" class="form-control" type="date" name="before_date" id="before_date"></input>
        
    </div> 

    <div style="left: 5%;" class="form-group col-7">
      <label style="position: relative; left: 5%;">End Date</label>
      <br>
        <input style="position: relative; width: 70%;  left: 11%;" class="form-control" type="date" name="after_date" id="after_date"></input>
    </div>
   <!-- </div> -->
  </div>
  <?php
  //Formatting to make user graph look like admin one
   if($_SESSION['privilege_level'] == 3) {?> 
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
  <?php } ?>

  <br>



  <br>





  <div class="form-row">
    <div class="col-10">
        <br>
      
        <input style="position: relative; font-size: .7em; width: 45%; left: -1%; top: 45%;" type="submit" name="csv" class="btn btn-info" id="csv-button" value="Download CSV"></input>
        <input style="position: relative; font-size: .7em;  width: 45%; left: 18%; top: 45%;" type="submit" name="submit" class="btn btn-dark" value="Submit Information" id="submit-button" onclick="getData()"></input>
    </div>
  </div>
  <br>


  <!-- //ask where this is set -->
    <input type="hidden" name="user-type" value="<?php echo $_SESSION['isAdmin'];?>">
    

    
  </form>

 

</div>
    
    




<!--<script src="../../Js_Script/VWS_JS/asyncRequest.js"></script>-->



<script>
// Define the function downloadCSV that will trigger an AJAX request to csvProcess.php
// to generate and download a CSV file with the data passed as parameters.
function downloadCSV(data, session, gender_toggle) {

    // Copy the values of the parameters to local variables.
  var my_data = data;
  var my_session = session;
  var this_gender_toggle = gender_toggle;

   // Send an AJAX request with the data, session, and gender_toggle as parameters.
  $.ajax({
    url: 'csvProcess.php',
    method: 'GET',
    data: {
      data: my_data,
      session: my_session,
      gender_toggle: this_gender_toggle
    },
    success: function(response) {
      // Create a Blob object with the response received from the server.
      var blob = new Blob([response]);

      // Create a link to download the CSV file
      var link = document.createElement('a');
      link.href = window.URL.createObjectURL(blob);
      link.download = 'page-data-export.csv';

      // Trigger the download
      link.click();
    },
    error: function(jqXHR, textStatus, errorThrown) {
      // Handle any errors that occur during the AJAX request
      console.error('Error: ' + textStatus + ', ' + errorThrown);
    }
  });
}



// When the DOM is ready, add event listeners for the radio buttons and CSV button
$(document).ready(function(){
  $("#gender-dropdown").addClass("disabled");

  $('#csv-button').click(function() {
    //downloadCsv();
  });

  // Add a change event listener for radio buttons.
  $('input[type="radio"]').change(function() {
    if ($(this).attr('id') == 'gender-filter') {
      $("#gender-dropdown").removeClass("disabled");
      $("#partic-dropdown").addClass("disabled");
    } else if ($(this).attr('id') == 'user-filter') {
      $("#gender-dropdown").addClass("disabled");
      $("#partic-dropdown").removeClass("disabled");
    }
  });

});







</script>









<script>
  // When a checkbox-dropdown is clicked, toggle its is-active class.
    $(".checkbox-dropdown").click(function () {
      $(this).toggleClass("is-active");
    });

    $(document).click(function(e){
      // Check if click was triggered on or within #menu_content

      if( ($(e.target).closest("#hm-dropdown").length > 0) || ($(e.target).closest("#partic-dropdown").length > 0) || ($(e.target).closest("#gender-dropdown").length > 0) ) {
          return false;
      }

        // Close the dropdowns that are currently open.
      if($("#hm-dropdown").hasClass("is-active")){
        $("#hm-dropdown").toggleClass("is-active");
      }

      if($("#csv-dropdown").hasClass("is-active")){
        $("#csv-dropdown").toggleClass("is-active");
      }

      
      if($("#partic-dropdown").hasClass("is-active")){
        $("#partic-dropdown").toggleClass("is-active");
      }

      if($("#gender-dropdown").hasClass("is-active")){
        $("#gender-dropdown").toggleClass("is-active");
      }

    });
      // Add a click event listener to the checkbox-dropdown ul elements to stop the event from propagating.
      $(".checkbox-dropdown ul").click(function(e) {
      e.stopPropagation();
      });
</script>

<script>
// Define the function displayError that adds a warning message to an element and displays an error message.
// This function takes two parameters, a message and an element.
// The function sets the border color and font color of the element to red, appends a warning symbol to the element, and appends an error message to a specific element with a class of "alert-danger".
// It also creates a chart with a specific ID after displaying the error message.
function displayError(message, element) {
  $(element).css({
    "border": "2px solid red",
    "color": "red"
  });
  $(element + "-warning").append("!");
  $(element + "-danger").append("<div class='alert alert-danger' role='alert'>" + message + "</div>");

  const box = document.getElementById('graph');
    const width = box.clientWidth;
    const height = box.clientHeight;
    chart_one = makeChart(canvas,width, height);
}
</script>




</body>
</html>


<script type="text/javascript">
  // This script creates a chart using data received from a PHP script through an AJAX call.
// It checks if the data is invalid and calls the displayError function if it is.
// It also creates a CSV file if the "csv" key in the data is set to "true".
// Finally, it creates a chart with the received data.
  canvas = fix_resolution();
    let data =  <?php 
        // This PHP script checks if the POST request was made and either returns the data or a message indicating the page has loaded.
     if ($_SERVER['REQUEST_METHOD'] === 'POST' && (isset($_POST['submit']) || isset($_POST['csv']))) {
      if(isset($_POST['csv'])){
        $result = getData($_POST, true);
        echo json_encode($result);

      }else{
        $result = getData($_POST, false);
        echo json_encode($result);
      }
     }
    else {
      
      echo json_encode("Page loaded");
    }
     ?>
    // The session data is retrieved and stored in a variable.
    let session = <?php echo json_encode($_SESSION); ?>

     // If the data is "Page loaded", a chart is created with default values.
    if(data == "Page loaded"){
    const element = document.getElementById('graph');
    const width = element.clientWidth;
    const height = element.clientHeight;
    chart_one = makeChart(canvas, width, height);
    }

      // If the data is invalid, the displayError function is called with an appropriate error 
    if (data == 'Invalid HM Count' || data == 'hm not selected' || data == 'empty' || data == 'Invalid functionality' || data == "invalidDateRange") {
      if (data == 'Invalid HM Count') {
        displayError('Please enter one health measure for gender averages', '#hm-dropdown');
      } else if (data == 'hm not selected') {
        displayError('Please select a health measure', '#hm-dropdown');
      } else if (data == 'empty') {
        displayError('Please enter survey information', '#hm-dropdown');
      } else if (data == 'Invalid functionality') {
        displayError('Please select only 1 health measure', '#partic-dropdown');
      } else if (data == "invalidDateRange"){
        displayError('Please enter a valid date', '#partic-dropdown');
      }
    }
    else if (data == "Select participant") {
      displayError('Select a participant', '#partic-dropdown');
    }

     //console.log(data); // Output the value of the data variable to the console

     // Check if the user has requested to download the data as a CSV file
    if(data[0].csv == 'true'){
      // Set the gender toggle flag to false by default
      gender_toggle = false;
      if(data[0].gender == 'true'){
        gender_toggle = true;
      }
        // Call the downloadCSV function, passing in the data, session, and gender toggle flag as parameters

      downloadCSV(data, session, gender_toggle);
    }
    // Create an empty array to store the graph data
    var graphData = [];

    // Loop through the data and push each item into the graphData array
    for (var i = 0; i < data.length; i++) {
      graphData.push({name: data[i].name, values: data[i].data,  date: data[i].date});
    }

    // Get the graph element and its dimensions
    const element = document.getElementById('graph');
    const width = element.clientWidth;
    const height = element.clientHeight;

    // Call the makeUserChart function, passing in the canvas element, the graphData array, the title from the first item in the data array, and the graph element's dimensions as parameters. Store the resulting chart in the chart_one variable.
    chart_one = makeUserChart(canvas, graphData, data[0].title, width, height);
    
</script>



