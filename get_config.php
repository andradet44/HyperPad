<?php
// Paramètres de connexion
include_once("dbConfig.php");

// Ouverture connexion
$mysqli = new mysqli(DB_HOST, DB_LOGIN, DB_PWD, DB_NAME); mysqli_set_charset($mysqli, "utf8");

// Ouvre session
session_start();

$nom_societe = NULL;
$departement = NULL;
$id_magasin = NULL;

$client_IP = $_SERVER['REMOTE_ADDR'];

$query_parametre = "SELECT * FROM `parametres` WHERE `ip_client` = '$client_IP';";
$result_parametre = $mysqli->query($query_parametre);
$nb_results = $result_parametre->num_rows;

if($nb_results > 0){
	while ($parametre = $result_parametre->fetch_assoc()) {
		$id_magasin = $parametre['id_magasin'];
		$nom_societe = $parametre['nom_societe'];
		$departement = $parametre['departement'];
		$alias_magasin = $parametre['alias_magasin'];
		$mail_admin = $parametre['mail_admin'];
		$nb_annees_purge = $parametre['nombre_annees_purge'];

    $_SESSION['id_magasin'] = $id_magasin;
    $_SESSION['nom_societe'] = $nom_societe;
    $_SESSION['departement'] = $departement;
		$_SESSION['mail_admin'] = $mail_admin;
    $_SESSION['alias_magasin'] = $alias_magasin;
		$_SESSION['nb_annees_purge'] = $nb_annees_purge;

	}
	$result_parametre->close();

	if($nb_annees_purge != "" && $nb_annees_purge >= 0){
		header("Location: admin_functions.php?action=sup_avant_date&nb_annees=$nb_annees_purge&first_config=yes");
	} else{
		header("Location: index.php");
	}

} else{
	header("Location: parametres.php?first_config=true");
}



// Fermeture connection
$mysqli->close();

?>
