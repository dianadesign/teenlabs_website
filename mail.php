<?php
$fname1 = $_POST['fname1'];
$pname1 = $_POST['pname1'];
$clasa = $_POST['clasa'];
$email1 = $_POST['email1'];
$phone1 = $_POST['phone1'];
$facebook = $_POST['facebook'];
$liceu = $_POST['liceu'];
$fname2 = $_POST['fname2'];
$pname2 = $_POST['pname2'];
$email2 = $_POST['email2'];
$phone2 = $_POST['phone2'];
$motivatie = $_POST['motivatie'];
$formcontent=" De la: $fname1 $pname1 \n clasa: $clasa \n liceu: $liceu \n Telefon: $phone1 \n Email: $email1 \n Facebook: $facebook \n Datele parintelui: $fname2 $pname2 \n $phone2 \n $email2 \n motivatie: $motivatie /n";
$recipient = "contact@teenlabs.ro, alina.iotu@gmail.com";
$subject = "Un nou participant";
mail($recipient, $subject, $formcontent) or die("Error!");
echo "Super tare! Te-ai inscris intr-o super experienta practica! In cel mai scurt timp vei fi contactat de echipa Teen Labs." . " -" . "<a href='index.html' style='text-decoration:none;color:#ff0099;'> Return Home</a>";
?>
