<?php
include_once("send_mail.php");

// Paramètres de connexion
include_once("dbConfig.php");
// Ouverture connexion
$mysqli = new mysqli(DB_HOST, DB_LOGIN, DB_PWD, DB_NAME); mysqli_set_charset($mysqli, "utf8");

//On récupère les paramètres en base de données
$query_parametre = "SELECT * FROM `parametres`;";
$result_parametre = $mysqli->query($query_parametre);

if($result_parametre){
	while ($parametre = $result_parametre->fetch_assoc()) {
		$id_magasin = $parametre['id_magasin'];
		$nom_societe = $parametre['nom_societe'];
		$mail_admin = $parametre['mail_admin'];
	}
} else {
 	$id_magasin = NULL;
	$nom_societe = NULL;
	$mail_admin = NULL;
}

if($id_magasin != NULL && $nom_societe != NULL && $mail_admin != NULL){
	verifier_non_rendu();
}


// Fermeture connection
$mysqli->close();

function verifier_non_rendu(){
	global $mysqli, $id_magasin, $nom_societe, $mail_admin, $fichier_liste, $feuille;

	//Construction de la requete
	$query_pas_rendu = "SELECT * FROM `prets` WHERE `date_retour` = '0000-00-00 00:00:00' AND `id_magasin` = '$id_magasin' ORDER BY `date_pret` DESC;";
	//On lance la requete en base de données
	$result_pas_rendu = $mysqli->query($query_pas_rendu);
	if($result_pas_rendu){
		$nbLignes = $result_pas_rendu->num_rows;
	} else {
		$nbLignes = 0;
	}

	if($nbLignes !=0){
		$date = date("d-m-Y");
		$message = "
		<!DOCTYPE html>
		<html>
		<head>
			<title> HyperPad </title>
			<style media='screen'>
			table{
				display: block;
				width: 98%;
				margin: auto;
				margin-top: 60px;
				text-align: center;
			}


			td, th{
				width: 14vw;
				padding: 8px;
				background-color: #f2f2f2;
				border-radius: 5px;
			}

			th{
				cursor: pointer;
			}

			tr:hover > .color{
				background-color: #2098D1;
				color: white;
			}

			.entete{
				background-color: #4CAF50;
				border-style: solid;
				border-width: 0px 0px 2px 0px;
				font-weight: bold;
				font-size: 20px;
				color: white;
				cursor: pointer;
			}
		</style>
		</head>
		<body>
		<h1> Liste radiopads non rendus" .$date ."</h1>
		<table class='tab_search avectri'>
		<thead>
			<tr class='th'>
				<th class='entete selection' data-tri='1' data-type='num'> Code utilisateur </th>
				<th class='entete'> Nom </th>
				<th class='entete'> Prenom </th>
				<th class='entete'> Code radiopad </th>
				<th class='entete'> Date prêt </th>
			</tr>
		</thead>
		<tbody>
		";

		while ($infos = $result_pas_rendu->fetch_assoc()) {
			$message .= "<tr>";
			$id_utilisateur = $infos['id_utilisateur'];


			//Récupération du nom et prénom de l'utilisateur
			$query_user_info = "SELECT * FROM `utilisateurs` WHERE `id`= '$id_utilisateur' AND `id_magasin` = '$id_magasin';";
			$result_user_info = $mysqli->query($query_user_info);

			if($result_user_info){
				while ($user = $result_user_info->fetch_assoc()) {
					$nom = $user['nom'];
					$prenom = $user['prenom'];
					$non_rendu = $user['non_rendu'];
					$non_rendu += 1;
					//On incrémente le nombre de fois que la personne n'a pas rendu les radiopads
					$query_update = "UPDATE `utilisateurs` SET `non_rendu` ='$non_rendu' WHERE `id`= '$id_utilisateur' AND `id_magasin` = '$id_magasin';";
					$mysqli->query($query_update);
				}

				$result_user_info->close();
			} else{
				$nom = "";
				$prenom = "";
			}

			$id_radiopad = $infos['id_radiopad'];
			$date_pret = $infos['date_pret'];

			$message .= "<td class='color'> $id_utilisateur </td>";
			$message .="<td class='color'> $nom </td>";
			$message .= "<td class='color'> $prenom </td>";
			$message .= "<td class='color'> $id_radiopad </td>";
			$message .= "<td class='color'> $date_pret </td>";
			$message .= "</tr>";
		}
		$message .= "</tbody>";
		$message .= "</table></body></html>";


	} else {
		$message = NULL;
	}

	$subject = "Liste des Radiopads non rendus le ".$date;
	$from = "HyperPad.".$nom_societe;


	if($message != NULL){
		// send_mail($mail_admin, $message,  $subject, $from);
	}
}
?>
