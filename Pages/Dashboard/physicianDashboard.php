<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Physician Dashboard</title>
    <link rel="stylesheet" href="../../Style/VWS_CSS/searchbar.css">
    <link rel="" href="../../Assets/vendor/bootstrap/css/bootstrap.min.css"> 

   <script type="text/javascript">
      updateVariables();
  
   </script>
</head>
<body>
<?php 
include_once "../../Components/general/header.php";
include_once "../../Components/general/sidebar.php";
include_once "../../API/PhysiciansAPI/fetchDataforTable.php";
require_once "../../API/Database/config.php";
?>
<div id="main">
        
    <h1 class="text-center"> Measurement Dashboard</h1>
   
    <br>
    <div class="row">
      <diV class="col">
      <div class="d-flex justify-content-center">
      <!-- Radio button to display what type Participants to select -->
      <form id="changeMode">
      <label for="option1" class="btn btn-secondary"><input type="radio" id="option1" name="options"
      onclick="document.getElementById('changeMode').submit();"
      value="1" checked><h5>All Participants</h5></label>

      <label for="option2" class="btn btn-secondary">
    <input type="radio" id="option2" name="options" onclick="document.getElementById('changeMode').submit();"
    value="2"<?php if(isset($_GET['options']) && $_GET['options'] == '2') echo 'checked'; ?>><h5>Display based on sex</h5></label>

          
      </form>
      </div>
    </diV>
    </div>

    <!-- button for selecting the category of health measures -->
        <div class="d-flex justify-content-center">
      
            
            <button style="margin:15px" class ="btn btn-primary "onclick="displayTable('table1','dropdown1')">
            <h4>General Information </h4>
            </button>
            
            <button style="margin:15px" class ="btn btn-secondary "onclick="displayTable('table2','dropdown2')">
            <h4> Flexibility </h4>
            </button>
            
            
            <button style="margin:15px" class ="btn btn-info "onclick="displayTable('table3','dropdown3')">
            <h4> Timed Balancing Test</h4>
            </button>
            
            <button style="margin:15px" class ="btn btn-warning "onclick="displayTable('table4','dropdown4')">
            <h4>Aerobic Cardiovascular Fitness Assessment</h4>
            </button>
            <?php
              if(!(isset($_GET['options']) && $_GET['options']==2)){
            ?>
            <button style="margin:15px" class ="btn btn-dark "onclick="displayTable('table5','dropdown5')">
            <h4>Perceived Stress Scale</h4>
            </button>
           <?php } ?>
        
        </div>
        <!-- search bar to look for Participants based on first or last name -->
        <input type="text" id="myInput" onkeyup="myFunction()" placeholder="Search for Participants First or Last Names..">
        
        <div>total number of pages:<span id="TotalNumPages"></span>  
        <div style="margin-left:10%" class="btn-group" role="group" aria-label="Button group with nested dropdown">
        <!-- exportcsv function to export csv file based on the selected option  -->
        <div class="btn-group" role="group">
          <button id="btnGroupDrop1" type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Export as CSV
          </button>
          <!-- four options to export csv -->
            <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
            <button class="dropdown-item" type="button" id="all" onclick="exportCSV(this.id)">All Participants - All Health Measure</button>
            <button class="dropdown-item" type="button"id="allParticipants-currentMeasure" onclick="exportCSV(this.id)">All Participant - Current Measure</button>
            <button class="dropdown-item" type="button"  id="currentParticipants-currentMeasure" onclick="exportCSV(this.id)">Current Participant - Current Measure</button>
            <button class="dropdown-item" type="button"  id="currentParticipants-All" onclick="exportCSV(this.id)">Current Participant - All Measure</button>
            </div>
            <!-- the measures for the table general information  -->
            <div name="dropdown" id="dropdown1" class="btn-group" role="group" style="margin-left:5%" >
          <button id="btnGroupDrop2" type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Select Measure
          </button>
            <div id="dropdownMenu" class="dropdown-menu" aria-labelledby="btnGroupDrop1">
           <button class="dropdown-item" type="button" id="systolic" onclick="document.getElementById('checkbox-systolic').click()">
              <input type="checkbox" id="checkbox-systolic" onclick="col(this,2,2)" checked>BP-sys</input>
            </button>
            <button class="dropdown-item" type="button" id="diastolic" onclick="document.getElementById('checkbox-diastolic').click()">
              <input type="checkbox" id="checkbox-diastolic" onclick="col(this,1,3)" checked>BP-dia</input>
            </button>

            <button class="dropdown-item" type="button" id="weight" onclick="document.getElementById('checkbox-weight').click()">
              <input type="checkbox" id="checkbox-weight" onclick="col(this,1,4)" checked>weight</input>
            </button>

            <button class="dropdown-item" type="button" id="HR" onclick="document.getElementById('checkbox-HR').click()">
              <input type="checkbox" id="checkbox-HR" onclick="col(this,1,5)" checked>heart rate</input>
            </button>
            </div>
        </div>
         <!-- the measures for the table Flexibility  -->
        <div name="dropdown" id="dropdown2" class="btn-group" role="group" style="margin-left:5%;display:none">
          <button id="btnGroupDrop2" type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Select Measure
          </button>
            <div id="dropdownMenu" class="dropdown-menu" aria-labelledby="btnGroupDrop1">
            <button class="dropdown-item" type="button" id="systolic" onclick="document.getElementById('checkbox-back-scratch').click()">
              <input type="checkbox" id="checkbox-back-scratch" onclick="col(this,2,2)" checked>Back Scratch Test</input>
            </button>

            <button class="dropdown-item" type="button" id="diastolic" onclick="document.getElementById('checkbox-grip-strength').click()">
              <input type="checkbox" id="checkbox-grip-strength" onclick="col(this,3,4)" checked>Grip Strength</input>
            </button>

            <button class="dropdown-item" type="button" id="weight" onclick="document.getElementById('checkbox-plank-test').click()">
              <input type="checkbox" id="checkbox-plank-test" onclick="col(this,4,6)" checked>Plank Test</input>
            </button>

            <button class="dropdown-item" type="button" id="HR" onclick="document.getElementById('checkbox-ankle-test').click()">
              <input type="checkbox" id="checkbox-ankle-test" onclick="col(this,5,7)" checked>Half kneeling dorsification ankle Test</input>
            </button>

            </div>
        </div>
         <!-- the measures for the table Timed Balancing Test  -->
        <div name="dropdown" id="dropdown3" class="btn-group" role="group" style="margin-left:5%;display:none">
          <button id="btnGroupDrop2" type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Select Measure
          </button>
            <div id="dropdownMenu" class="dropdown-menu" aria-labelledby="btnGroupDrop1">
            <button class="dropdown-item" type="button" id="systolic" onclick="document.getElementById('checkbox-tandem').click()">
              <input type="checkbox" id="checkbox-tandem" onclick="col(this,2,2)" checked>Tandem</input>
            </button>

            <button class="dropdown-item" type="button" id="diastolic" onclick="document.getElementById('checkbox-single-leg-left').click()">
              <input type="checkbox" id="checkbox-single-leg-left" onclick="col(this,3,4)" checked>Single Leg(left)</input>
            </button>

            <button class="dropdown-item" type="button" id="weight" onclick="document.getElementById('checkbox-single-leg-right').click()">
              <input type="checkbox" id="checkbox-single-leg-right" onclick="col(this,4,6)" checked>Single Leg(Right)</input>
            </button>

            <button class="dropdown-item" type="button" id="HR" onclick="document.getElementById('checkbox-total-time').click()">
              <input type="checkbox" id="checkbox-total-time" onclick="col(this,5,7)" checked>Total time</input>
            </button>

            </div>
        </div>
         <!-- the measures for the table Aerobic Cardiovascular Fitness Assessment -->
        <div name="dropdown" id="dropdown4" class="btn-group" role="group" style="margin-left:5%;display:none">
          <button id="btnGroupDrop2" type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Select Measure
          </button>
            <div id="dropdownMenu" class="dropdown-menu" aria-labelledby="btnGroupDrop1">
            <button class="dropdown-item" type="button" id="systolic" onclick="document.getElementById('checkbox-time-to-walk').click()">
              <input type="checkbox" id="checkbox-time-to-walk" onclick="col(this,6,2)" checked>Time to walk 1 Mile</input>
            </button>

            <button class="dropdown-item" type="button" id="diastolic" onclick="document.getElementById('checkbox-post-walk-heart-rate').click()">
              <input type="checkbox" id="checkbox-post-walk-heart-rate" onclick="col(this,6,3)" checked>Post walk heart rate</input>
            </button>

            <button class="dropdown-item" type="button" id="weight" onclick="document.getElementById('checkbox-rpe').click()">
              <input type="checkbox" id="checkbox-rpe" onclick="col(this,6,4)" checked>RPE</input>
            </button>

            <button class="dropdown-item" type="button" id="HR" onclick="document.getElementById('checkbox-v02').click()">
              <input type="checkbox" id="checkbox-v02" onclick="col(this,6,5)" checked>V02</input>
            </button>

            </div>
        </div>
        <?php
              if(!(isset($_GET['options']) && $_GET['options']==2)){
            ?>
             <!-- the measures for the table Perceived Stress Scale   -->
        <div name="dropdown" id="dropdown5" class="btn-group" role="group" style="margin-left:5%" >
          <button id="btnGroupDrop2" type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Select Measure
          </button>
            <div id="dropdownMenu" class="dropdown-menu" aria-labelledby="btnGroupDrop1">
              <button class="dropdown-item" type="button" id="PSS" onclick="document.getElementById('checkbox-PSS').click()">
                  <input type="checkbox" id="checkbox-PSS" onclick="col(this,1,2)" checked>Calculated PSS</input>
              </button>
            </div>
        </div>
        <?php } ?>
        </div>
        </div>
          <!-- number of rows for the table -->
        <lable style='margin-left:20%; ' for='rowPerPage' >Number of rows per page:  </lable>
        <input  type='number' id='rowPerPage' onchange='updateRowPerPage(this.value)' value='25' min='1'>
      </div>
       
        <hr>

                <!-- table to display based on selected category -->
                    <table name="table" id="table1" class="table table-bordered table-hover" style="border-width: 4px;" class="datatable">
                     
                   <?php
                        getData(1); //display table General Information
                        ?>
                    </table>

                    <table name="table" id="table2"  class="table table-bordered table-hover" style="display:none; border-width: 4px;"class="datatable">
                        <?php
                        getData(2); //display table flexbility
                        ?> 
                    </table>

                    <table name="table" id="table3" class="table table-bordered table-hover" style="display:none; border-width: 4px;"class="datatable">
                    <?php getData(3); //display table Timed Balancing Test
                    ?>
                    </table>

                    <table name="table" id="table4" class="table table-bordered table-hover" style="display:none"class="datatable">
              
                        <?php getData(4); //display table Aerobic Cardiovascular Fitness Assessment
                        ?>
                    </table>

                    <?php
                      if(!(isset($_GET['options']) && $_GET['options']==2)){
                    ?>
                    <table name="table" id="table5" class="table table-bordered table-hover" style="display:none"class="datatable">
              
                        <?php getData(5); //display table Perceived Stress Scale
                        ?>
                    </table>

                   <?php } ?>
          <!-- display text when no information is uploaded -->
        <?php if($_SESSION['table']==1)
        {
            echo "<h3>No information at the moment</h3>";
        } 
        else{?>
       
          <!-- pagination buttons -->
        <div class ="text-center">
          <button class="btn btn-primary" onclick="goFirstPage()" id="firstPage"> 1</button>
          <button class ="btn btn-primary" onclick="goBack()" id="prevButton"><<</button>
          <button class="btn btn-primary" id="prevTwoBtn" onclick="goPrevTwo()"></button>
          <button class="btn btn-primary" id="prevOneBtn" onclick="goPrevOne()"></button>
          <input class ="btn btn-primary" value="1" id="pageNum" disabled >
          <button class="btn btn-primary" id="nextOneBtn" onclick="goNextOne()"></button>
          <button class="btn btn-primary" id="nextTwoBtn" onclick="goNextTwo()"></button>
          <button class ="btn btn-primary" onclick="goNext()" id="nextButton">>></button>
          <button class ="btn btn-primary" onclick="goLastPage()" id="lastPage"></button>
           </div>
      <?php } ?>
</div>

<input type="hidden" id="currentTable" value="table1">


</body>
<!-- script to dispay the selected category -->
<script>
/*
this function display the selected table and measures
@param tableId- the ID of the selected table
@param dropdownId- the ID of the selected measures   
*/
function displayTable(tableId, dropdownId) {
  
  var tables = document.getElementsByTagName('table');
  var currentTable = document.getElementById("currentTable");
  var dropdowns = document.getElementsByName("dropdown");

  for (var i = 0; i < tables.length; i++) {
    if (tables[i].id === tableId) {
      tables[i].style.display = 'table';
      currentTable.value =  tables[i].id;
      //console.log("this is id:"+tables[i].id);

    } else {
      tables[i].style.display = 'none';
    }
  }

  for (var j = 0; j < dropdowns.length; j++) {
    if (dropdowns[j].id === dropdownId) {
      dropdowns[j].style.display = 'block';
      //console.log("this is id:"+dropdowns[j].id);
    } else {
      dropdowns[j].style.display = 'none';
      //console.log("this is id hide:"+dropdowns[j].id);
    }
  }

  updateVariables();
  showPage(0);
}


</script>
<!-- script to search for Participants -->
<script>
  var searchValue = ''; // To store the searched value to use for exporting 
function myFunction() {
  // Declare variables
  var input, filter, table, tr, td1,td2, txtValue1, txtValue2,txtValue3;
  input = document.getElementById("myInput");
  filter = input.value.toUpperCase();
  var tables = document.getElementsByTagName('table');

  for (var j = 0; j < tables.length; j++) {
    
  table = tables[j];
  tr = table.getElementsByTagName("tr");

  // Loop through all table rows, and hide those who don't match the search query
  for (var i = 0; i < tr.length; i++) {
    td1 = tr[i].getElementsByTagName("td")[0];
    td2 = tr[i].getElementsByTagName("td")[1];
    if (td1 || td2) {
        txtValue1 = td1.textContent || td1.innerText;
        txtValue2 = td2.textContent || td2.innerText;
        txtValue3 = (td1.textContent + " " +td2.textContent) || (td1.innerText + " "+ td2.innerText)
        if (txtValue1.toUpperCase().indexOf(filter) > -1 || txtValue2.toUpperCase().indexOf(filter) > -1 || txtValue3.toUpperCase().indexOf(filter) > -1) {
          tr[i].style.display = "";
        } else {
          tr[i].style.display = "none";
        }
    }
  }
  searchValue =input.value;
}

}
</script>
<script>
              displayTable('table1', 'dropdown1');
</script>
<script type="text/javascript" src="../../Js_Script/VWS_JS/pagination.js"></script>
<script type="text/javascript" src="../../Js_Script/VWS_JS/exportcsv.js"></script>
<script src="../../Js_Script/VWS_JS/hide_unhideColumn.js"></script>
<script src="../../Js_Script/VWS_JS/sortTable.js"></script>