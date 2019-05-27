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

// Paramètres de connexion
include_once("dbConfig.php");

// Ouverture connexion
$mysqli = new mysqli(DB_HOST, DB_LOGIN, DB_PWD, DB_NAME);

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


//On supprime pour insérer les nouveaux paramètres
$query_delete = "DELETE FROM `parametres` WHERE 1;";
$mysqli->query($query_delete);

//On insére les nouveaux paramètres
$query_insert = "INSERT INTO `parametres` (`id`, `id_magasin`, `nom_societe`, `departement`, `alias_magasin`, `mail_admin`)
VALUES (NULL, '$id_magasin', '$nom_societe', '$departement', '$alias_magasin', '$mail_admin');";
$mysqli->query($query_insert);

header("Location: get_config.php");


// Fermeture connection
$mysqli->close();

?>
