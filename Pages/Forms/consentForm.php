<?php
session_start();
?>
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
  <title>Consent Form</title>
  <style>
    #main {
      margin: 0;
      padding-left: 15px;
      box-sizing: border-box;
    }

    .check .input {
      opacity: 1;
      height: inherit;
      width: inherit;
      overflow: visible;
    }

    .switch {
      position: relative;
      display: inline-block;
      width: 60px;
      height: 34px;
    }

    .switch input {
      opacity: 0;
      width: 0;
      height: 0;
    }

    .slider {
      position: absolute;
      cursor: pointer;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background-color: #ccc;
      -webkit-transition: .4s;
      transition: .4s;
    }

    .slider:before {
      position: absolute;
      content: "";
      height: 26px;
      width: 26px;
      left: 4px;
      bottom: 4px;
      background-color: white;
      -webkit-transition: .4s;
      transition: .4s;
    }

    input:checked+.slider {
      background-color: #2196F3;
    }

    input:focus+.slider {
      box-shadow: 0 0 1px #2196F3;
    }

    input:checked+.slider:before {
      -webkit-transform: translateX(26px);
      -ms-transform: translateX(26px);
      transform: translateX(26px);
    }

    /* Rounded sliders */
    .slider.round {
      border-radius: 34px;
    }

    .slider.round:before {
      border-radius: 50%;
    }
  </style>
</head>

<body>
  <?php 
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
        include_once "../../Components/general/loginRegNavbar.php";
    
    ?>

  <div id="main">

    <h1>Appendix B: LETTER OF INFORMED CONSENT</h1>
    <h2>Connections for Healthy Living </h2>
    <p>I have read and understand the Background Information Sheet.</p>
    <p>I understand that I have the right to withdraw from the research study at any time without reason, and I will
      receive no penalty.</p>
    <form action="../../API/SurveryAPI/consent_submit.php" method="post">

      <table>

        <?php
        $conn = startConnection();
        $sql = "SELECT CNS_AUTO_KEY, question FROM consent_form_questions";
        $result = $conn->query($sql);
        while ($row = $result->fetch_row()) {
          $rows[] = $row;
        } ?>

        <?php
        //print_r($rows);

        ?>
        <tr>
          <th>Participant Consent Checklist</th>
        </tr>
        <tr>
          <td><?php echo $rows[0][1]; ?></td>

          <td>
            <input hidden name="user_auto_key" id="user_auto_key" value="<?php echo $_SESSION['user_auto_key']; ?>">
          </td>

        </tr>
        <tr>
          <td><?php echo $rows[1][1]; ?> </td>

        </tr>
        <tr>
          <td><?php echo $rows[2][1]; ?> </td>

        </tr>
        <tr>
          <td><?php echo $rows[3][1]; ?></td>

        </tr>
        <tr>
          <td><?php echo $rows[4][1]; ?></td>

        </tr>
        <tr>
          <td><?php echo $rows[5][1]; ?></td>

        </tr>
        <tr>
          <td><?php echo $rows[6][1]; ?></td>

        </tr>
        <tr>
          <td><?php echo $rows[7][1]; ?></td>

        </tr>
        <tr>
          <td> <?php echo $rows[8][1]; ?></td>

        </tr>
        <tr>
          <td><?php echo $rows[9][1]; ?> </td>

        </tr>
        <tr>
          <td><?php echo $rows[10][1]; ?> </td>

        </tr>
        <tr>
          <td>
            <br>
            <br>

            <label><b>By sliding this you consent to participate in this program:</b></label>
            <div class="check">
              <label class="switch">
                <input required type="checkbox" class="input" name="option1" id="option1" value="1">
                <span class="slider round"> </span>
              </label>
            </div>
          </td>
        </tr>
      </table>
      <br>

      <div id="signature1" name="signature1">
        <input id="sig1" name="sig1" type="signiture_participant" placeholder="Type your full legal name" required>
      </div>
      <div id="signaturetitle1">
        Signature of Participant
      </div><br>
      <label for="date">Date:</label>
      <input type="date" id="date" name="dateParticipiant" min="2023-01-01"><br>
      <script>
        document.getElementById("date").value = new Date().toISOString().slice(0, 10);
      </script>
      <div>If you would like to request the results of the study, please complete the following:</div><br>
      <div class="form-check form-switch">
        <input name="getEmailResult" id="getEmailResult" class="form-check-input" type="checkbox">
        <label class="form-check-label" for="getEmailResult"> I would like the results of the study by email</label>
      </div>

      <input class="form-control" style="width:40%; visibility:hidden" type="email" id="email" name="email"
        placeholder="email@example.com"><br>
      <div>
        <div class="form-check form-switch">
          <input name="getMailResult" id="getMailResult" class="form-check-input" type="checkbox">
          <label class="form-check-label" for="getMailResult"> I would like the results of the study by mail</label>
        </div>

      </div>
      <label for="address">Mailing address:</label>
      <textarea rows="3" class="form-control" style="width:40%; visibility:hidden" id="address" name="address"
        placeholder="Example: Marcus DuBois
      6587 Roller Derby Lane
      Toronto, ON M1R-0E9
      Canada"></textarea>
      <br>
      <input style="float:right; width:15%" id="check" class="btn btn-primary" type="submit" value="Submit">
      <br> 
      <br>
    </form>
  </div>
</body>

</html>

<script>
  const checkMail = document.getElementById('getMailResult');
  const mailAddress = document.getElementById('address');
  checkMail.addEventListener('change', e => {
    if (e.target.checked === true) {
      //console.log("Checkbox is checked - boolean value: ", e.target.checked)
      mailAddress.style.visibility = '';
    }
    if (e.target.checked === false) {
      // console.log("Checkbox is not checked - boolean value: ", e.target.checked)
      mailAddress.style.visibility = 'hidden';
      mailAddress.value = '';
    }
  });
  const checkEmail = document.getElementById('getEmailResult');
  const EmailAddress = document.getElementById('email');
  checkEmail.addEventListener('change', e => {
    if (e.target.checked === true) {
      //console.log("Checkbox is checked - boolean value: ", e.target.checked)
      EmailAddress.style.visibility = '';
       // Set the email input field as required
    EmailAddress.required = true;
    }
    if (e.target.checked === false) {
      // console.log("Checkbox is not checked - boolean value: ", e.target.checked)
      EmailAddress.style.visibility = 'hidden';
      EmailAddress.value = '';
    }
  });
</script>