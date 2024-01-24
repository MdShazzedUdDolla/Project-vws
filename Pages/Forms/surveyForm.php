<?php
 require_once "../../API/Database/config.php";

// echo print_r($_POST);



?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Functional capacity form</title>
   <style>
    /* input:invalid {
      border: 2px solid red;
    }

    input:invalid:focus {
      outline: none;
      border: 2px solid red;
    } --> */

    span.required {
      color: red;
      margin-left: 5px;
    }
     .invalid-input {
      border-color: red;
    }
    .invalid {
      color: red;
      font-size: 12px;
    
      padding: 10px;
    }
  </style>
  <script>
        function onlyNumbers(evt) {
            var ASCIICode = (evt.which) ? evt.which : evt.keyCode
            if (ASCIICode > 31 && (ASCIICode < 48 || ASCIICode > 57))
                return false;
            return true;
        }
    </script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script type="text/javascript" src="../../Js_Script/jquery/jquery3.6.1.js"></script>
</head>


<body>
<?php 
include_once "../../Components/general/header.php";
?>
<?php 
include_once "../../Components/general/sidebar.php"
?>

<div id='main'>
    <form action="../../API/SurveryAPI/survey_submit.php" method="post" id="survey">
    <p style="text-align:center"><b>Participant's Information</b></p>   
    <table class="table table-bordered">
       <tr>
        <td>
       

        <?php 
            include_once "../../API/SurveryAPI/surveyFormFunctions.php";
            getUsernameField($_SESSION);
              
            ?>
  
 
            <br>
            <span class="invalid"><?php if(isset($_GET['usernameError'])){ echo $_GET['usernameError'];} ?></span>
      
            
        </td>
        <td>
            <label for="age">Date of birth:<span class="required">*</span></label>
            <input  type="date" id="age" name="age"
   
        required>
        <br>
            <span class="invalid"><?php if(isset($_GET['dateError'])){ echo $_GET['dateError'];} ?></span>
      
        </td>
      
        <td>
            <label style="display: inline-block;" for="weight">Weight:<span class="required">*</span></label>
            <input style="display: inline-block;"  type="number" id="weight" name="weight" step="0.01" required min="0">
           
            
            <select style="display: inline-block;" class="dropdown"  id="weightUnit" name="weightUnit">
              <option value='1'>lb</option>
              <option value='2'>kg</option>
            </select>
            <span class="invalid"><?php if(isset($_GET['WeightError'])){ echo $_GET['WeightError'];} ?></span>
          </td>
       </tr> 
       


       <tr>
      <td>
            <label for="sex">sex:<span class="required">*</span></label>
            <select class="dropdown"  id="sex" name="sex">
              <option value='1'>Male</option>
              <option value='2'>Female</option>
            </select>
            <br>
            <span class="invalid"><?php if(isset($_GET['SexError'])){ echo $_GET['SexError'];} ?></span>
            
        </td>
        <td>
            <label for="heartRate">Resting Heart Rate (bpm): <span class="required">*</span></label>
            <input  type="number" id="heartRate" name="heartRate" onkeypress="return onlyNumbers(event)" required ><br>
            <br>
            <span class="invalid"><?php if(isset($_GET['heartRateError'])){ echo $_GET['heartRateError'];} ?></span>
          </td>
        <td>
            <label for="bloodPressure">Blood Pressure (systolic / diastolic):	<span class="required">*</span></label>
            <br>
            <input   type="number" id="bloodPressure_dias" name="bloodPressure_dias" onkeypress="return onlyNumbers(event)" required placeholder="systolic" min="0">
            <input    type="number" id="bloodPressure_sys" name="bloodPressure_sys" onkeypress="return onlyNumbers(event)" required placeholder="diastolic" min="0">
            <br>
            <span class="invalid"><?php if(isset($_GET['bloodPressure_sysError'])){ echo $_GET['bloodPressure_sysError'];} ?></span>
            <span class="invalid"><?php if(isset($_GET['bloodPressure_diasError'])){ echo $_GET['bloodPressure_diasError'];} ?></span>
          </td>
          </td>
       </tr> 
       
    </table>
        <p style="text-align:center"><b>Flexibility, Strength, and Estimated Maximum Oxygen Consumption (VO2max)</b></p> 
        <p style="text-align:center"><b>Assessments</b></p> 
        <p>Back Scratch Test (distance in +/ - cm) :</p> 
        <table  class="table table-bordered">
            <tr>
            <td><label for="rightScratchTest">Right :</label>
                <input  type="number" id="rightScratchTest" name="rightScratchTest" onkeypress="return onlyNumbers(event)" value="0"></td>
            <td><label for="leftScratchTest">Left :</label>
                    <input  type="number" id="leftScratchTest" name="leftScratchTest" onkeypress="return onlyNumbers(event)" value="0"></td> 
           </tr>
           </table>
           <p>Grip Strength Test (kg):</p> 
           <table class="table table-bordered">
               <tr>
               <td><label for="leftHand">Left Hand :</label>
                   <input  type="number" id="leftHand" name="leftHand" onkeypress="return onlyNumbers(event)" value="0" min="0"></td>
                   <td>
                    <label for="rightHand">Right Hand :</label>
                    <input  type="number" id="rightHand" name="rightHand" onkeypress="return onlyNumbers(event)" value="0" min="0"></td>
                    <span class="invalid"><?php if(isset($_GET['rightHandError'])){ echo $_GET['rightHandError'];} ?></span>
                  </tr>
              </table>
              <p>Plank Test: </p> 
              <table class="table table-bordered">
                  <tr>
                  <td>
                    <label for="plankTime">Time Duration (Seconds):</label>
                    <input  type="number" id="plankTime" name="plankTime" onkeypress="return onlyNumbers(event)" value="0" min="0">
                    <br>
                    <span class="invalid"><?php if(isset($_GET['plankTimeError'])){ echo $_GET['plankTimeError'];} ?></span>
                  </td>
                  <td>
                      <label for="EnduranceRPE">RPE Scale(6-22) :</label>
                      <input  type="number" id="EnduranceRPE" name="EnduranceRPE" onkeypress="return onlyNumbers(event)" value="0"  max="22">
                      <br>
                      <span class="invalid"><?php if(isset($_GET['EnduranceRPEError'])){ echo $_GET['EnduranceRPEError'];} ?></span>
                  </td>
                 </tr>
                 </table>
                 <p>Half Kneeling Dorsiflexion Ankle Test: </p> 
              <table class="table table-bordered">
                  <tr>
                    <td>
                      <label for="leftAnkle">Left Ankle(cm) :</label>
                      <input  type="number" id="leftAnkle" name="leftAnkle" onkeypress="return onlyNumbers(event)" value="0" min=0>
                      <br>
                      <span class="invalid"><?php if(isset($_GET['leftAnkleError'])){ echo $_GET['leftAnkleError'];} ?></span>
                    </td>
                    <td>
                      <label for="rightAnkle">Right Ankle(cm):</label>
                      <input  type="number" id="rightAnkle" name="rightAnkle" onkeypress="return onlyNumbers(event)" value="0" min=0>
                      <br>
                      <span class="invalid"><?php if(isset($_GET['rightAnkleError'])){ echo $_GET['rightAnkleError'];} ?></span>
                    </td>
                 </tr>
                 </table>
                 <p>Timed Balancing Test (Seconds): </p> 
              <table class="table table-bordered">
                <tr>
                    <td>Tandem</td>
                    <td>Single Leg (Left)</td>
                    <td>Single Leg (Right)</td>
                    <td>Total Time:</td>      
                 </tr>
                  <tr>
                    <td>
                      <label for="tandemOpen">Eyes Open :</label>
                      <input  type="number" id="tandemOpen" name="tandemOpen" onkeypress="return onlyNumbers(event)" value="0" min="0">
                      <br>
                      <span class="invalid"><?php if(isset($_GET['tandemOpenError'])){ echo $_GET['tandemOpenError'];} ?></span>
                    </td>
                    <td>
                      <label for="leftOpen">Eyes Open:</label>
                      <input  type="number" id="leftOpen" name="leftOpen" onkeypress="return onlyNumbers(event)" value="0" min="0">
                      <br>
                      <span class="invalid"><?php if(isset($_GET['leftOpenError'])){ echo $_GET['leftOpenError'];} ?></span>
                    </td>
                    <td>
                      <label for="rightOpen">Eyes Open:</label>
                      <input  type="number" id="rightOpen" name="rightOpen" onkeypress="return onlyNumbers(event)" value="0" min="0" >
                      <br>
                      <span class="invalid"><?php if(isset($_GET['rightOpenError'])){ echo $_GET['rightOpenError'];} ?></span>
                    </td>
                    <td>
                      <label for="totalOpen">Eyes Open:</label>
                      <input  type="number" id="totalOpen" name="totalOpen" onkeypress="return onlyNumbers(event)" value="0" min="0">
                      <br>
                      <span class="invalid"><?php if(isset($_GET['totalOpenError'])){ echo $_GET['totalOpenError'];} ?></span>
                    </td>
                 </tr>
                 <tr>
                    <td>
                      <label for="tandemClosed">Eyes Closed :</label>
                      <input  type="number" id="tandemClosed" name="tandemClosed" onkeypress="return onlyNumbers(event)" value="0" min="0">
                      <br>
                      <span class="invalid"><?php if(isset($_GET['tandemClosedError'])){ echo $_GET['tandemClosedError'];} ?></span>
                    </td>
                    <td>
                      <label for="leftClosed">Eyes Closed:</label>
                      <input  type="number" id="leftClosed" name="leftClosed" onkeypress="return onlyNumbers(event)" value="0" min="0">
                      <br>
                      <span class="invalid"><?php if(isset($_GET['leftClosedError'])){ echo $_GET['leftClosedError'];} ?></span>
                    </td>
                    <td>
                      <label for="rightClosed">Eyes Closed:</label>
                      <input  type="number" id="rightClosed" name="rightClosed" onkeypress="return onlyNumbers(event)" value="0" min="0">
                      <br>
                      <span class="invalid"><?php if(isset($_GET['rightClosedError'])){ echo $_GET['rightClosedError'];} ?></span>
                    </td>
                    <td>
                      <label for="totalClosed">Eyes Closed:</label>
                      <input  type="number" id="totalClosed" name="totalClosed" onkeypress="return onlyNumbers(event)" value="0" min="0">
                      <br>
                      <span class="invalid"><?php if(isset($_GET['totalClosedError'])){ echo $_GET['totalClosedError'];} ?></span>
                    </td>
                 </tr>
                 </table>
                 <p style="text-align:center"><b>Aerobic Cardiovascular Fitness Assessment</b></p> 
                 <div style="font-weight:bold; color:#000" class="alert alert-warning" role="alert">
                  To calculate VO2 make sure that all the parameters required to calculate it are all set. That includes:
                  Sex
                  ,Weight
                  ,Date of Birth
                  ,Time to walk one mile
                  ,Post Walk Heart Rate
                 <br>
                 To automatically calculate VO2 just click on the field and if all the required parameters are set , VO2 will be set.

                </div>
                 <p>1 Mile Walking Test</p>   
                 <table class="table table-bordered">
                  <tr>
                    <td>
                    <label label for="walkingTime">Time To Walk one mile (distance=1.625km)(Min:Sec) </label>
                    </td>
                  <td>
                    Minutes:Seconds
                    <hr>
                    <input  style="width:33%" type="number" id="walkingTime" name="walkingTime" onkeypress="return onlyNumbers(event)" value="0"  min="0" placeholder="Minutes">:
                    <input style="width:33%" type="number" id="walkingTimeSec" name="walkingTimeSec" onkeypress="return onlyNumbers(event)" value="0"  min="0" max="59" placeholder="Seconds">
                    <br>
                    <span class="invalid"><?php if(isset($_GET['walkingTimeError'])){ echo $_GET['walkingTimeError'];} ?></span>
                  </td>
                  <td>
                    <label label for="walkingTime">Post Walk Heart Rate:</label>
                    </td>
                  <td>
                    <input  type="number" id="PostWalkHeartRate" name="PostWalkHeartRate" onkeypress="return onlyNumbers(event)" value="0" min="0" >
                    <br>
                    <span class="invalid"><?php if(isset($_GET['PostWalkHeartRateError'])){ echo $_GET['PostWalkHeartRateError'];} ?></span>
                  </td>
                  </tr>
                  <tr>
                    <td>
                    <label for="RPE">RPE (6-22):</label>
                    </td>
                  <td>
                    <input  type="number" id="RPE" name="RPE"  step="0.01" value="0"   max="22">
                    <br>
                    <span class="invalid"><?php if(isset($_GET['RPEError'])){ echo $_GET['RPEError'];} ?></span>
                  </td>
                  <td> 
                  <label for="VO2">VO2 :</label>
                  
                  </td>
                  <td> 
                    <input  type="number" id="VO2" name="VO2"  onfocus="calculateRPE(this)" step="0.0001" value="0" readonly>
                  <p style="color:#dc3545;" id='feedback_VO2'></p>
                  <br>
                    <span class="invalid"><?php if(isset($_GET['VO2Error'])){ echo $_GET['VO2Error'];} ?></span>
                </td>
                  </tr>
                  <tr>
                    <td>  <label for="comments">Additional Comments:</label></td>
                  <td colspan="4">
                
                    <textarea id="comments" name="comments" rows="4" cols="50"></textarea>
                  </td>
                  </tr>
                   
                    
                </table>
        <br>
        <input style="float:right" id="check" class="btn btn-primary" type="submit" value="Submit" >
        <script>
          function calculateRPE(vo2Element){
            let weight = document.getElementById('weight').value;
            //if kg then convert to Ib
            var weightUnit  = document.getElementById('weightUnit').selectedIndex;
            if(weightUnit==1){
              weight = 2.2046226218*weight;
            }
            var heartRate  = document.getElementById('PostWalkHeartRate').value;

            var birthDate = new Date(document.getElementById('age').value);
            const currentDate = new Date();

            const ageInMilliseconds = currentDate - birthDate;
            const age = ageInMilliseconds / (1000 * 60 * 60 * 24 * 365.25); // 365.25 days in a year to account for leap years

          
            //Min : sec
            var walkingTime = parseFloat(document.getElementById('walkingTime').value);
            var walkingTimeSec = parseFloat(document.getElementById('walkingTimeSec').value);
            var mileTime = walkingTime + walkingTimeSec/60;
            
            const selectBox = document.getElementById("sex");
            const selectedOption = selectBox.options[selectBox.selectedIndex].value;
            var vo2 = 0;

            // console.log(
            //   "weight:"+weight+"heartRate:" + heartRate+ "age:" + age + "birthDate:"+birthDate + "gender"+ selectedOption

            // );
            if(selectedOption==1){
              vo2 = -0.09*(weight) -0.4*(age) -1.7*(mileTime) -0.13*(heartRate) + 109.67;
            }else{
              vo2 = -0.06*(weight) -0.28*(age) -1.56*(mileTime) -0.09*(heartRate) + 87.64;
            }

          if(weight > 0 && heartRate > 0  && age >= 0 && mileTime>0 ){
            vo2Element.value =vo2.toFixed(4); ;
            document.getElementById("feedback_VO2").display = "none";
            document.getElementById("feedback_VO2").innerHTML = "";
            document.getElementById("VO2").style.borderColor = "";

            document.getElementById('weight').style.borderColor= "";
           document.getElementById('age').style.borderColor= "";
           document.getElementById('walkingTime').style.borderColor= ""; 
           document.getElementById('walkingTimeSec').style.borderColor= ""; 
           document.getElementById("sex").style.borderColor= ""; 
           document.getElementById('PostWalkHeartRate').style.borderColor= ""; 
          }else{
            document.getElementById("feedback_VO2").display = "block";
            document.getElementById("feedback_VO2").innerHTML = "One or more of the parameters not set yet.";
            document.getElementById("VO2").style.borderColor = "#dc3545";
            document.getElementById("VO2").value = "0";
            //console.log("one or more of param not specified");

           document.getElementById('weight').style.borderColor= "#dc3545";
           document.getElementById('age').style.borderColor= "#dc3545";
           document.getElementById('walkingTime').style.borderColor= "#dc3545"; 
           document.getElementById('walkingTimeSec').style.borderColor= "#dc3545"; 
           document.getElementById("sex").style.borderColor= "#dc3545"; 
           document.getElementById('PostWalkHeartRate').style.borderColor= "#dc3545"; 
          }
          }
      </script>
    </form> 
    </div>        
</body>
</html>