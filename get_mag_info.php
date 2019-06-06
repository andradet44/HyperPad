<?php
// AJAX 1
$donneesClient = json_decode($_POST['donneesClient'], true);
$nom_societe = $donneesClient['nom_societe'];
$departement = $donneesClient['departement'];

// Paramètres de connexion
include_once("dbConfig.php");

// Ouverture connexion
$mysqli = new mysqli(DB_HOST, DB_LOGIN, DB_PWD, DB_NAME); mysqli_set_charset($mysqli, "utf8");

$query = "SELECT * FROM `parametres` WHERE `nom_societe` = '$nom_societe' AND `departement`='$departement';";
$result = $mysqli->query($query);

$mail_admin = NULL;
$ip_reseau = NULL;

if($result){
  while ($parametre = $result->fetch_assoc()) {
    $mail_admin = $parametre['mail_admin'];
    $ip_reseau = $parametre['ip_reseau'];
  }
  $result->close();
}

// AJAX 1
$objetJSON = array();
$objetJSON[] = array("mail_admin" => $mail_admin, "ip_reseau" => $ip_reseau);




// Serialize
$donneesServeur = json_encode($objetJSON);

// Serialize et envoie reponse
echo "$donneesServeur";

// Fermeture connection
$mysqli->close();




?>
