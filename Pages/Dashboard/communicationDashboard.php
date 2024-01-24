<?php 
include "../../API/PhysiciansAPI/communication_information.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Send Study Results</title>
   
    <link rel="stylesheet" href="../../Assets/vendor/bootstrap/css/bootstrap.min.css">
     <link rel="stylesheet" href="../../Style/VWS_CSS/dropdown.css">
     <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.js"></script>
     <script src="https://cdnjs.cloudflare.com/ajax/libs/multi-select/0.9.12/js/jquery.multi-select.min.js"></script>
  <style>
    .d-none {
  display: none;
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
    <h1 class="text-center">Send Study Results</h1>
<form method="post"  enctype="multipart/form-data" action="../../API/PhysiciansAPI/communication_submit.php" method="post">

<br>
 <div class="row">
  <?php
  if(isset($_GET['Error']) && strcmp($_GET['Error'], "")!=0){
    echo '<div class="alert alert-danger" role="alert">
 '.$_GET['Error'].'
  </div>';
  }
  ?>
 <br>
  <div  class="form-group col-6">
  <div class="input-group mb-3">
  <input type="radio" style="width: 1.5em; height: 1.5em;" name="radio-group"  id="opted-in" value="all" checked>
  <span style="margin-right: 10px;"></span>
  <label for="opted-in" style="font-size:20px">Send email to all opted-in users</label>
  </div>
  </div>
  <br>

 <br>
 <div class="form-group col-6">
 <div class="input-group mb-3">
  <input type="radio" style="width: 1.5em; height: 1.5em;" name="radio-group" id="user-filter" value="user-filter">
  <span style="margin-right: 10px;"></span>
  <div id="partic-dropdown" class="checkbox-dropdown" >
    <span>Select participant</span>
    <ul class="checkbox-dropdown-list">
    <?php 
            $html = getParticipant('consent_record');
            echo $html;
          ?> 
    </ul>
  </div>
  <div class="alert alert-danger d-none" role="alert" id="partic-warning"></div>
</div>
 </div>
 

  <div class="form-input py-2">
<div class="form-group">
        <h2> Subject:</h2>
          <input type="text" class="form-control" name="title" id="title" placeholder="Email title" required>
        </div>  
        <div class="form-group">
        <h3> Message:</h3>
          <textarea class="form-control" name="message" id="message" 
                 placeholder="Email body" required></textarea>
        </div>  
        <div class="form-group">
        <h4> Attach File(pdf only):</h4>
          <input type="file" class="form-control" name="attachment" id="attachment" accept=".pdf"
                 placeholder="File">
        </div>  
        <div class="form-group">
                <button class="btn btn-primary" name="submit_email" id="submit_email" type="submit">SEND</button>
            </div>
</div>
</form>
</div>
</body>
</html>
<script>
$(document).ready(function(){
  $("#partic-dropdown").addClass("disabled");

  
  $('input[type="radio"]').change(function() {
    if ($(this).attr('id') == 'user-filter') {
      $("#partic-dropdown").removeClass("disabled");
    } else {
      $("#partic-dropdown").addClass("disabled");

    }
  });

});

$(".checkbox-dropdown").click(function () {
      $(this).toggleClass("is-active");
    });

    $(document).click(function(e){
      // Check if click was triggered on or within #menu_content

      if ($(e.target).closest("#partic-dropdown").length > 0)  {
          return false;
      }
      if($("#partic-dropdown").hasClass("is-active")){
        $("#partic-dropdown").toggleClass("is-active");
      }
    });

    $(".checkbox-dropdown ul").click(function(e) {
      e.stopPropagation();
      });

      // Get references to the necessary DOM elements
const sendButton = document.querySelector('button[type="submit"]');
const userFilter = document.getElementById('user-filter');
const participantDropdown = document.getElementById('partic-dropdown');
const participantWarning = document.getElementById('partic-warning');

// Add an event listener to the send button
sendButton.addEventListener('click', function(event) {
  // Check if the user filter is selected but no participants are checked
  if (userFilter.checked && participantDropdown.querySelectorAll('input:checked').length === 0) {
    // Display an error message in the participant warning span
    participantWarning.textContent = 'Please select at least one participant.';
    // Remove the d-none class to show the error message
    participantWarning.classList.remove('d-none');
    // Prevent the form from being submitted
    event.preventDefault();
  }
  else {
  // Add the d-none class to hide the error message and the red alert block
  participantWarning.classList.add('d-none');
  }

});

</script>

