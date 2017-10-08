<?php
$mail = $_POST['mail'];
$formcontent=" O noua persoana s-a inscris in comunitatea Teen Labs. Email: $mail.";
$recipient = "newsletter@teenlabs.ro";
$subject = "Un nou mail";
mail($recipient, $subject, $formcontent) or die("Error!");
header("location:index.html");
?>