<?php
header('Content-type: text/json');

// EDIT THE 2 LINES BELOW AS REQUIRED

$send_email_to = "contact@teenlabs.ro, alina.iotu@gmail.com";
$email_subject = "Yuhuu, un nou inscris";

function send_email($email,$nume,$prenume,$clasa,$liceu,$tel,$facebook,$pnume,$pprenume,$pemail,$ptel,$motivatie,$ip) {

  global $send_email_to;
  global $email_subject;

  $headers = "MIME-Version: 1.0" . "\r\n";
  $headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";
  $headers .= "From: ".$email. "\r\n";

  $message = "<strong>Email: </strong>".$email."<br>";

  $message .= "<strong>Nume: </strong>".$nume."<br>";
  $message .= "<strong>Prenume: </strong>".$prenume."<br>";
  $message .= "<strong>Clasa: </strong>".$clasa."<br>";
  $message .= "<strong>Liceu: </strong>".$liceu."<br>";
  $message .= "<strong>Email: </strong>".$email."<br>";
  $message .= "<strong>Telefon: </strong>".$tel."<br>";
  $message .= "<strong>Facebook: </strong>".$facebook."<br>";
  $message .= "<strong>Nume parinte/tutore: </strong>".$pnume."<br>";
  $message .= "<strong>Prenume parinte/tutore: </strong>".$pprenume."<br>";
  $message .= "<strong>Email parinte/tutore: </strong>".$pemail."<br>";
  $message .= "<strong>Telefon parinte/tutore: </strong>".$ptel."<br>";
  $message .= "<strong>Motivatie: </strong>".$motivatie."<br>";

  $message .= "<strong>Client ip = </strong>".$ip."<br>";

  @mail($send_email_to, $email_subject, $message, $headers);

  return true;
}

function get_client_ip() {
    $ipaddress = '';
    if ($_SERVER['HTTP_CLIENT_IP'])
        $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
    else if($_SERVER['HTTP_X_FORWARDED_FOR'])
        $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
    else if($_SERVER['HTTP_X_FORWARDED'])
        $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
    else if($_SERVER['HTTP_FORWARDED_FOR'])
        $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
    else if($_SERVER['HTTP_FORWARDED'])
        $ipaddress = $_SERVER['HTTP_FORWARDED'];
    else if($_SERVER['REMOTE_ADDR'])
        $ipaddress = $_SERVER['REMOTE_ADDR'];
    else
        $ipaddress = 'UNKNOWN';
    return $ipaddress;
}

// campuri obligatorii

if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {

  $emailc = $_POST['email'];
  $numec = $_POST['nume'];
  $prenumec = $_POST['prenume'];
  $clasac = $_POST['clasa'];
  $liceuc = $_POST['liceu'];
  $telc = $_POST['tel'];
  $facebookc = $_POST['facebook'];
  $pnumec = $_POST['pnume'];
  $pprenumec = $_POST['pprenume'];
  $pemailc = $_POST['pemail'];
  $ptelc = $_POST['ptel'];
  $motivatiec = $_POST['motivatie'];

  $clientIp = get_client_ip();

  send_email($emailc,$numec,$prenumec,$clasac,$liceuc,$telc,$facebookc,$pnumec,$pprenumec,$pemailc,$ptelc,$motivatiec,$clientIp);

  echo 'true';

} else {
  echo 'false';
}

die();

?>
