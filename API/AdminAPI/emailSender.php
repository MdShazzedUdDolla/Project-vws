<?php 
use PHPMailer\PHPMailer\PHPMailer; 
use PHPMailer\PHPMailer\Exception; 
use PHPMailer\PHPMailer\SMTP;
function createNewMailObj($subject ,
$SMTPDebug=0, $Mailer='smtp', $Host='smtp.gmail.com', $smtpAuth = true,
$Username='virtualwellnesssystem@gmail.com',$Password ='iklalemiucmyvhgj',
$SMTPSecure = 'tls', $port ='587', $IsHtml=true, $address = 'virtualwellnesssystem@gmail.com', $name='VWS',
$verify_peer = false, $verify_peer_name = false, $allow_self_signed = true 
){

    $mail = new PHPMailer(true);
    $mail->SMTPDebug = $SMTPDebug;  
    $mail->Mailer=$Mailer;                                      
    $mail->isSMTP();                                             
    $mail->Host       = $Host;                     
    $mail->SMTPAuth   = $smtpAuth;                              
    $mail->Username   = $Username;                  
    $mail->Password   = $Password;                         
    $mail->SMTPSecure = $SMTPSecure;                               
    $mail->Port       = $port;   
    $mail->IsHTML($IsHtml);
    $mail->setFrom($address, $name); 
    

    $mail->SMTPOptions = array(
        'ssl' => array(
        'verify_peer' => $verify_peer,
        'verify_peer_name' => $verify_peer_name,
        'allow_self_signed' => $allow_self_signed
        )
        );
        $mail->Subject = $subject;
        $mail->isHTML(true);
    return $mail;
}

function sendMail($mailObjArr){
    foreach($mailObjArr as $mail){
        $mail->send();
    }
    return $mailObjArr;
}


function attachFile($mailObjArr,$file_tmp, $file_name ){
    foreach($mailObjArr as $mail){
        $mail->addStringAttachment(file_get_contents($file_tmp), $file_name);
    }
 
    return $mailObjArr;
}

function setEmailBody($mailObjArr,$body ){
    foreach($mailObjArr as $mail){
        $mail->Body= $body;
    }
 
    return $mailObjArr;
}

function seeErrors($mailObjArr ){
    $error = "";
    foreach($mailObjArr as $mail){
        $error .= $mail->ErrorInfo;
    }
 
    return $error;
}

?>