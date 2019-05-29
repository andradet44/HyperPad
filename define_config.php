<?php
$departement = NULL;
if (isset($_POST['departement'])) {
	$departement = $_POST['departement'];
}
$nom_societe = NULL;
if (isset($_POST['nom_societe'])) {
	$nom_societe = $_POST['nom_societe'];
}
$mail_admin = NULL;
if (isset($_POST['mail_admin'])) {
	$mail_admin = $_POST['mail_admin'];
}
$id_magasin = NULL;
if (isset($_POST['id_magasin'])) {
	$id_magasin = $_POST['id_magasin'];
}

// Paramètres de connexion
include_once("dbConfig.php");

// Ouverture connexion
$mysqli = new mysqli(DB_HOST, DB_LOGIN, DB_PWD, DB_NAME); mysqli_set_charset($mysqli, "utf8");

//récupération des informations du magasin
$query_magasins = "SELECT * FROM `magasins` WHERE `departement` = '$departement' AND `nom` = '$nom_societe';";
$result_magasins = $mysqli->query($query_magasins);

if($result_magasins){
  $nb_results = $result_magasins->num_rows;

  while ($magasin = $result_magasins->fetch_assoc()) {
		$id_magasin = $magasin['id_magasin'];
    $alias_magasin = $magasin['alias'];
  }

  $result_magasins->close();
} else{
  $id_magasin = '';
}


//récupération des informations du magasin
$query_par = "SELECT * FROM `parametres` WHERE `id_magasin` = '$id_magasin';";
$result_par = $mysqli->query($query_par);

if($result_par){
	$nb_par = $result_par->num_rows;
} else {
	$nb_par = 0;
}

$client_IP = $_SERVER['REMOTE_ADDR'];
if($nb_par == 0){
	//On insére les nouveaux paramètres
	$query_insert = "INSERT INTO `parametres` (`id`, `id_magasin`, `ip_client`, `nom_societe`, `departement`, `alias_magasin`, `mail_admin`)
	VALUES (NULL, '$id_magasin', '$client_IP', '$nom_societe', '$departement', '$alias_magasin', '$mail_admin');";
	$mysqli->query($query_insert);
} else if($nb_par > 0){
	$query_update0 = "UPDATE `parametres` SET `ip_client` = '' WHERE `ip_client` = '$client_IP';";
	$mysqli->query($query_update0);

	$query_update1 = "UPDATE `parametres` SET `ip_client` = '$client_IP' WHERE `id_magasin` = '$id_magasin';";
	$mysqli->query($query_update1);

	$query_update2 = "UPDATE `parametres` SET `mail_admin` = '$mail_admin' WHERE `id_magasin` = '$id_magasin';";
	$mysqli->query($query_update2);
}

header("Location: get_config.php");


// Fermeture connection
$mysqli->close();

?>
