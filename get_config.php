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
$result_test = "false";
$ip_match = "";

$client_IP = $_SERVER['REMOTE_ADDR'];

//Récupération des IP réseau dans la base de données
$query_parametre = "SELECT * FROM `parametres`;";
$result_parametre = $mysqli->query($query_parametre);

while ($parametre = $result_parametre->fetch_assoc()) {
	$ip_reseau = $parametre['ip_reseau'];

	//Transforme en tableau
	$liste_ip = explode(',', $ip_reseau);

	if($ip_reseau != ""){
		//Pour chaque IP réseau on test si le client appartient au réseau
		foreach ($liste_ip as $key => $ip) {
			if($result_test == "false"){
				$result_test = isOnNetwork($client_IP, $ip);
				$ip_match = $ip;
			}
		}
	}
}


if($result_test == "true"){
	$query_parametre = "SELECT * FROM `parametres` WHERE `ip_reseau` LIKE '%$ip_match%';";
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
	}
} else{
	header("Location: parametres.php?first_config=true");
}


function isOnNetwork ($IP, $CIDR) {
	settype($CIDR,'string');
	$CIDR = str_replace(" ", "", $CIDR);

 $netAndMask = explode ("/", $CIDR);
 $mask = $netAndMask[1];
 $net = $netAndMask[0];

 $ip_net = ip2long ($net);
 $ip_mask = ~((1 << (32 - $mask)) - 1);

 $ip_ip = ip2long ($IP);

 $ip_ip_net = $ip_ip & $ip_mask;

 if($ip_ip_net == $ip_net) return "true";

 return "false";
 }



// Fermeture connection
$mysqli->close();

?>
