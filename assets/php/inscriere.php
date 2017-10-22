<?php
header('Content-type: text/json');

// EDIT THE 2 LINES BELOW AS REQUIRED
$send_email_to = "contact@teenlabs.ro, alina.iotu@gmail.com, diana@ap3.ro";
$email_subject = "Un nou inscris";

function send_email($email,$name,$phone,$subject,$contactmessage,$ip) {

  global $send_email_to;
  global $email_subject;

  $headers = "MIME-Version: 1.0" . "\r\n";
  $headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";
  $headers .= "From: ".$email. "\r\n";

  $message = "<strong>Email: </strong>".$email."<br>";
  $message .= "<strong>Name: </strong>".$nume." ".$prenume."<br>";
  $message .= "<strong>Phone: </strong>".$tel."<br>";
  $message .= "<strong>Subject: </strong>".$subject."<br>";

  $message .= "<strong>Message: </strong>"."Nume: ".$nume."<br>";
  $message .= "<strong>Message: </strong>"."Prenume: ".$contactmessage."<br>";
  $message .= "<strong>Message: </strong>"."Clasa: ".$contactmessage."<br>";
  $message .= "<strong>Message: </strong>"."Liceu: ".$contactmessage."<br>";
  $message .= "<strong>Message: </strong>"."Email: ".$contactmessage."<br>";
  $message .= "<strong>Message: </strong>"."Telefon: ".$contactmessage."<br>";
  $message .= "<strong>Message: </strong>"."Facebook: ".$contactmessage."<br>";
  $message .= "<strong>Message: </strong>"."Nume parinte/tutore: ".$contactmessage."<br>";
  $message .= "<strong>Message: </strong>"."Prenume parinte/tutore: ".$contactmessage."<br>";
  $message .= "<strong>Message: </strong>"."Email parinte/tutore: ".$contactmessage."<br>";
  $message .= "<strong>Message: </strong>"."Telefon parinte/tutore: ".$contactmessage."<br>";
  $message .= "<strong>Message: </strong>"."Motivatie: ".$contactmessage."<br>";

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
  $namec = $_POST['nume'];
  $phonec = $_POST['tel'];
  $subjectc = $_POST['subject'];
  $contactmessagec = $_POST['message'];

  $clientIp = get_client_ip();

  send_email($emailc,$namec,$phonec,$subjectc,$contactmessagec,$clientIp);

  echo 'true';

} else {
  echo 'false';
}

die();

?>
