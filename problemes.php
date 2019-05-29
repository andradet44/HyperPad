<?php
include_once("send_mail.php");

// Ouvre session
session_start();

$nom_societe = NULL;
$id_magasin = NULL;
$mail_admin = NULL;

// Récupère dans session
if (isset($_SESSION['id_magasin'])) {
  $id_magasin = $_SESSION['id_magasin'];
}
if (isset($_SESSION['nom_societe'])) {
  $nom_societe = $_SESSION['nom_societe'];
}
if (isset($_SESSION['mail_admin'])) {
  $mail_admin = $_SESSION['mail_admin'];
}

if($id_magasin == NULL){
	header("Location: index.php?message=vide");
} else{

  // Paramètres de connexion
  include_once("dbConfig.php");
  // Ouverture connexion
  $mysqli = new mysqli(DB_HOST, DB_LOGIN, DB_PWD, DB_NAME);

  $action = NULL;
  if (isset($_POST['action'])) {
  	$action = $_POST['action'];
  }

  if($action == "defaillance"){
    insert_defaillance();
  } else if($action == "reparation"){
    reparation();
  } else if($action == "panne"){
		insert_prob();
	} else if($action == "sup_defaillance"){
		sup_defaillance();
	}



  // Fermeture connection
  $mysqli->close();
}

function insert_defaillance(){
  global $mail_admin, $nom_societe, $id_magasin, $mysqli;
  $nom_societe = strtolower($nom_societe);

  $id_radio = NULL;
  if (isset($_POST['code_radio'])) {
    $id_radio = $_POST['code_radio'];
  }

  $type_panne = NULL;
  if (isset($_POST['type_panne'])) {
    $type_panne = $_POST['type_panne'];
  }

  $message = "
  <!DOCTYPE html>
  <html>
  <head>
  </head>
  <body>
  ";

  $date = date("d-m-Y");

  if($type_panne == 'Radiopad PERDU'){
    $query_insert_prob = "INSERT INTO `pannes_radiopads` (`id_radiopad`, `panne`, `date_reparation`, `id_magasin`)
    VALUES ('$id_radio', 'PERDU', '0', '$id_magasin');";
    $result_insert_prob = $mysqli->query($query_insert_prob);

    $query_mod_status = "UPDATE `radiopads` SET `etat` = 'PERDU' WHERE `id_radio` = '$id_radio' AND `id_magasin` = '$id_magasin';";
    $mysqli->query($query_mod_status);

    $message .= "<h1> Le Radiopad $id_radio a été signalé comme PERDU le $date </h1> </body> </html>";
  } else if($type_panne == 'Radiopad RETROUVE'){
    $query_mod_date = "UPDATE `pannes_radiopads` SET `date_reparation` = CURRENT_TIMESTAMP WHERE `id_radio` = '$id_radio' AND `date_reparation` = '0000-00-00 00:00:00' AND `id_magasin` = '$id_magasin';";
    $mysqli->query($query_mod_date);

    $query_mod_status = "UPDATE `radiopads` SET `etat` = 'PROD' WHERE `id_radio` = '$id_radio' AND `etat` = 'PERDU' AND `id_magasin` = '$id_magasin';";
    $mysqli->query($query_mod_status);

    $message .= "<h1> Le Radiopad $id_radio a été signalé comme RETROUVE le $date </h1> </body> </html>";
  } else {
    $query_insert_prob = "INSERT INTO `defaillances_radiopads` (`id_radiopad`, `panne`, `id_magasin`)
    VALUES ('$id_radio', '$type_panne', '$id_magasin');";
    $result_insert_prob = $mysqli->query($query_insert_prob);

    $message .= "<h1> Défaillance signalée sur le Radiopad $id_radio : $type_panne </h1> </body> </html>";
  }

  $subject = "Radiopad";
  $nom_societe = "HyperPad.".$nom_societe;
  send_mail($mail_admin, $message,  $subject, $nom_societe);
  header("Location: problemes_radio.php?message=insert_prob_ok");
}

function insert_prob(){
  global $id_magasin, $mysqli;

	$id_radio = NULL;
	if (isset($_POST['code_radio'])) {
		$id_radio = $_POST['code_radio'];
	}

	$type_panne = NULL;
	if (isset($_POST['type_panne'])) {
		$type_panne = $_POST['type_panne'];
	}

  $query_insert_prob = "INSERT INTO `pannes_radiopads` (`id_radiopad`, `panne`, `date_reparation`, `id_magasin`)
  VALUES ('$id_radio', '$type_panne', '0', '$id_magasin');";
  $result_insert_prob = $mysqli->query($query_insert_prob);

	$query_delete = "DELETE FROM `defaillances_radiopads` WHERE `id_radiopad` = '$id_radio' AND `id_magasin` = '$id_magasin' AND `panne` = '$type_panne'";
	$mysqli->query($query_delete);

  //STATUS A envoyer en réparation
  $query_mod_status = "UPDATE `radiopads` SET `etat` = 'REPARER' WHERE `id_radio` = '$id_radio' AND `id_magasin` = '$id_magasin';";
  $mysqli->query($query_mod_status);

	if($result_insert_prob){
  	header("Location: defaillances.php?message=insert_prob_ok");
	}
}

function reparation(){
  global $id_magasin, $mysqli;

  $id_radio = NULL;
  if (isset($_POST['code_radio'])) {
    $id_radio = $_POST['code_radio'];
  }

	$type_panne = NULL;
  if (isset($_POST['type_panne'])) {
    $type_panne = $_POST['type_panne'];
  }

	$date_panne = NULL;
	if (isset($_POST['date_panne'])) {
		$date_panne = $_POST['date_panne'];
	}

	if($type_panne == NULL && $date_panne == NULL){
		$query_reparation = "UPDATE `pannes_radiopads` SET `date_reparation` = CURRENT_TIMESTAMP WHERE `id_radiopad`='$id_radio' AND `id_magasin`='$id_magasin';";
	} else{
		$query_reparation = "UPDATE `pannes_radiopads` SET `date_reparation` = CURRENT_TIMESTAMP WHERE `id_radiopad`='$id_radio'
		AND `id_magasin`='$id_magasin' AND `date_panne` = '$date_panne' AND `panne` = '$type_panne';";
	}

  $result_reparation = $mysqli->query($query_reparation);
  $nbLignes = $mysqli->affected_rows;

  //STATUS A envoyer en réparation
  $query_mod_status = "UPDATE `radiopads` SET `etat` = 'STOCK' WHERE `id_radio` = '$id_radio' AND `id_magasin` = '$id_magasin';";
  $mysqli->query($query_mod_status);

  if($nbLignes > 0){
    header("Location: pannes.php?message=reparation_ok");
  }

}

function sup_defaillance(){
  global $id_magasin, $mysqli;

	$id_radio = NULL;
	if (isset($_POST['code_radio'])) {
		$id_radio = $_POST['code_radio'];
	}

	$type_panne = NULL;
	if (isset($_POST['type_panne'])) {
		$type_panne = $_POST['type_panne'];
	}


	$query_delete = "DELETE FROM `defaillances_radiopads` WHERE `id_radiopad` = '$id_radio' AND `id_magasin` = '$id_magasin' AND `panne` = '$type_panne'";
	$mysqli->query($query_delete);

	header("Location: defaillances.php?message=delete_panne_ok");
}

?>
