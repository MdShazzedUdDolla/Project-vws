<?php
include_once "../../API/SurveryAPI/pyschologyFormFunctions.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link rel="stylesheet" href="../../Assets/vendor/bootstrap/css/bootstrap.min.css">
   <title>Psychology Survey Form</title>

   <style>
      .alert-warning {
      color: #856404;
      background-color: #fff3cd;
      border-color: #ffeeba;
      }
      .alert-danger {
      color: #721c24;
      background-color: #f8d7da;
      border-color: #f5c6cb;
      }
      .alert-success {
      color: #155724;
      background-color: #d4edda;
      border-color: #c3e6cb;
      }
      .alert-info {
        color: #0c5460;
        background-color: #d1ecf1;
        border-color: #bee5eb;
        text-align: center;
        }
   </style>
   <script src="../../Js_Script/VWS_JS/psyForm.js"></script>

</head>

<body>
   <?php 
include_once "../../Components/general/header.php";
?>
   <?php 
include_once "../../Components/general/sidebar.php"
?>
   <div id="main">
      <div style="text-align:center; width:100%; ">
         <h5>Perceived Stress Scale</h5>
      </div>
      <div class="alert-info">
      <p>A more precise measure of personal stress can be determined by using a variety of instruments that have been
         designed to help measure individual stress levels. The first of these is called the <b>Perceived Stress
            Scale</b>.</p>
      <p>The Perceived Stress Scale (PSS) is a classic stress assessment instrument. The tool, while originally
         developed in 1983, remains a popular choice for helping us understand how different situations affect our
         feelings and our perceived stress. The questions in this scale ask about your feelings and thoughts during the
         last month. In each case, you will be asked to indicate how often you felt or thought a certain way. Although
         some of the questions are similar, there are differences between them and you should treat each one as a
         separate question. The best approach is to answer fairly quickly. That is, don’t try to count up the number of
         times you felt a particular way; rather indicate the alternative that seems like a reasonable estimate.</p>

      <hr>
      </div>
      <div style="text-align:center; width:100%; ">
         <h5>0 -never&nbsp;&nbsp;1 -almost never&nbsp;&nbsp;2 -sometimes&nbsp;&nbsp;3 -fairly
            often&nbsp;&nbsp;4 -very often</h5>
      </div>

      <?php 
  //get questions of the form
  $rows = getQuestions();
   //print_r($rows);
  
  ?>
      <form method="post" action="../../API/SurveryAPI/psychological_submit.php">
         <table class="table table-bordered table-striped">

            <tr>
               <td>1. <?php echo $rows[1][1]?></td>

               <td>
                  <?php  $html = getScale(1); echo $html;?>
               </td>
            </tr>
            <tr>
               <td>2. <?php echo $rows[2][1]?></td>
               <td>
                  <?php  $html = getScale(2); echo $html ;?>
               </td>
            </tr>
            <tr>
               <td>3. <?php echo $rows[3][1]?> </td>

               <td>
                  <?php  $html = getScale(3); echo $html ;?>
               </td>
            </tr>
            <tr>
               <td>4.<?php echo $rows[4][1]?> </td>

               <td>

                  <?php  $html = getScale(4); echo $html ;?>

               </td>
            </tr>
            <tr>
               <td>5. <?php echo $rows[5][1]?></td>

               <td>
                  <?php  $html = getScale(5); echo $html ;?>
               </td>
            </tr>
            <tr>
               <td>6.<?php echo $rows[6][1]?></td>

               <td>
                  <?php  $html = getScale(6); echo $html ;?>
               </td>
            </tr>
            <tr>
               <td>7. <?php echo $rows[7][1]?></td>

               <td>
                  <?php  $html = getScale(7); echo $html ;?>
               </td>
            </tr>
            <tr>
               <td>8. <?php echo $rows[8][1]?></td>

               <td>
                  <?php  $html = getScale(8); echo $html ;?>
               </td>
            </tr>
            <tr>
               <td>9. <?php echo $rows[9][1]?></td>

               <td>
                  <?php  $html = getScale(9); echo $html ;?>

               </td>
            </tr>
            <tr>
               <td>10. <?php echo $rows[10][1]?></td>

               <td>
                  <?php  $html = getScale(10); echo $html ;?>
               </td>
            </tr>
         </table>
         <hr>
         <div style="text-align:center; width:100%; ">
            <h5>Figuring Your PSS Score</h5>
         </div>
         <div class="alert-info">
         <p>The Perceived Stress Scale is interesting and important because your perception of what is happening
            in your life is most important. Consider the idea that two individuals could have the exact same events
            and experiences in their lives for the past month. Depending on their perception, total score could put
            one of those individuals in the low stress category and the total score could put the second person in
            the high stress category.</p>
            </div>
          
            <div style="width:100%; margin:0"class="justify-content">
            <button style="float:right" class="btn btn-primary" name="submit" type="submit" > Calculate score &
               submit </button>
              
            </div>
            <hr>
         <ol>
            <li>How your score is calculated : reverse your scores for questions 4, 5, 7, and 8. On these 4
               questions, change the scores like
               this: 0 = 4, 1 = 3, 2 = 2, 3 = 1, 4 = 0.</li> 
            <li>Now add up your scores for each item to get a total. </li>
            <input type="hidden" name="user_auto_key" id="user_auto_key"
               value="<?php echo $_SESSION['user_auto_key']?>">
            <li>
               Individual scores on the PSS can range from 0 to 40 with higher scores indicating higher perceived
            </li>
            stress.

            </li>
         </ol>
        
    
            <p><b>Disclaimer:</b><em>The scores on the following self-assessment do not reflect any particular diagnosis
                  or course of treatment.
                  They are meant as a tool to help assess your level of stress. If you have any further concerns about
                  your current well
                  being, you may contact EAP and talk confidentially to one of our specialists.
                  State</em></p>
        

      </form>
</body>

</html>