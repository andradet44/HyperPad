<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require './Classes/PHPMailer/src/Exception.php';
require './Classes/PHPMailer/src/PHPMailer.php';
require './Classes/PHPMailer/src/SMTP.php';

function send_mail($mail_admin, $message, $subject, $from, $reply_for = ""){
  if($reply_for == "") $reply_for = $mail_admin;

  $from2 = $from . "@gbh.fr";
  $mail = new PHPmailer();

  // Paramètres SMTP
 //$mail->IsSMTP(); // activation des fonctions SMTP
 //$mail->SMTPAuth = false; // on l’informe que ce SMTP nécessite une autentification
 /*$mail->SMTPSecure = 'ssl';*/ // protocole utilisé pour sécuriser les mails 'ssl' ou 'tls'
 $mail->Host = "smtp.gbh.fr"; // définition de l’adresse du serveur SMTP : 25 en local, 465 pour ssl et 587 pour tls
 $mail->Port = 25; // définition du port du serveur SMTP
 // $mail->Username = "utilisateur@domaine.fr"; // le nom d’utilisateur SMTP
 // $mail->Password = "motdepassse"; // son mot de passe SMTP

// Paramètres du mail
 $mail->AddAddress($mail_admin,'Admin'); // ajout du destinataire
 $mail->From = "$from2"; // adresse mail de l’expéditeur
 $mail->FromName = "$from"; // nom de l’expéditeur
 $mail->AddReplyTo("$reply_for","Responsable informatique"); // adresse mail et nom du contact de retour
 $mail->IsHTML(true); // envoi du mail au format HTML
 $mail->Subject = "$subject"; // sujet du mail
 $mail->Body = "$message"; // le corps de texte du mail en HTML
 $mail->AltBody = "$message"; // le corps de texte du mail en texte brut si le HTML n'est pas supporté

 if(!$mail->Send()) { // envoi du mail
 echo "Mailer Error: " . $mail->ErrorInfo; // affichage des erreurs, s’il y en a
 }
 else {
 echo  "Le message a bien été envoyé !";
 }
}
?>
