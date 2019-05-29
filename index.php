<?php
// Paramètres de connexion
include_once("dbConfig.php");

// Ouverture connexion
$mysqli = new mysqli(DB_HOST, DB_LOGIN, DB_PWD, DB_NAME); mysqli_set_charset($mysqli, "utf8");

$nom_societe = NULL;
$departement = NULL;
$id_magasin = NULL;

// Ouvre session
session_start();

// Récupère dans session
if (isset($_SESSION['nom_societe'])) {
	$nom_societe = $_SESSION['nom_societe'];
}
if (isset($_SESSION['departement'])) {
	$departement = $_SESSION['departement'];
}
if (isset($_SESSION['id_magasin'])) {
	$id_magasin = $_SESSION['id_magasin'];
}
?>

<!DOCTYPE html>

<html>
	<!-- En tête -->
	<head>
		<!-- Fichiers CSS -->
		<link rel='stylesheet' type='text/css' href='./css/index.css' media='screen' />
		<link rel='stylesheet' type='text/css' href='./css/general.css' media='screen' />

		<!-- Fichiers Javascripts -->
		<script type='text/javascript' src='./js/jquery-2.0.3.min.js'></script>
		<script type='text/javascript' src='./js/tri-donnees.js'></script>


		<!-- Encodage UTF8 pour les accents -->
		<meta charset='UTF-8'>

		<!-- Icône de l'onglet -->
		<link rel='icon' type='image/png' href='./images/radiopad.png' />

		<!-- Titre de l'onglet -->
		<title> HyperPad Gestion </title>
	</head>



	<!-- Corps du document -->
	<body>
		<nav>
			<ul>
				<ul>
					<li id="li_0" onclick="document.location.href='index.php'" style="background-color: #2098D1;"> HyperPad Gestion </li>
					<li id="li_1" onclick="document.location.href='valider_pret_retour.php'"> Valider un prêt ou un retour </li>
					<li id="li_2" onclick="document.location.href='rechercher.php?search=pret_jour&nb_result_display=20'"> Rechercher </li>
					<li id="li_3" onclick="document.location.href='problemes_radio.php'"> Signalement </li>
					<li onclick="document.location.href='statistiques.php'"> Statistiques </li>
					<li id="li_4" onclick="document.location.href='admin.php'"> Admin </li>
				</ul>
			</ul>
		</nav>

		<h2 class="section_title"> Liste des Radiopads NON-rendus </h2>

<?php
if($nom_societe == NULL || $departement == NULL || $id_magasin == NULL){
	header("Location: get_config.php");
} else {
	echo "<h2> $nom_societe $departement </h2>";

	//Construction de la requete
	$query_pas_rendu = "SELECT * FROM `prets` WHERE `date_retour` = '0000-00-00 00:00:00' AND `id_magasin` = '$id_magasin' ORDER BY `date_pret` DESC;";
	//On lance la requete en base de données
	$result_pas_rendu = $mysqli->query($query_pas_rendu);
	if($result_pas_rendu){
		$nbLignes = $result_pas_rendu->num_rows;
	} else {
		$nbLignes = 0;
	}

	echo "
	<div class='info_tab'>
	<div class='circle circle_red'> . </div>
	<p style='color: red'> Prêts du jour </p>
	<div class='circle circle_black'> . </div>
	<p> Prêts des jours antérieurs </p>
	</div>
	<table class='tab_search avectri'>
	<thead>
		<tr class='th'>
			<th class='entete selection' data-tri='1' data-type='num'> Code utilisateur </th>
			<th class='entete'> Nom </th>
			<th class='entete'> Prenom </th>
			<th class='entete'> Code radiopad </th>
			<th class='entete'> Date prêt </th>
			<th class='entete'> Date retour </th>
		</tr>
	</thead>
	<tbody>
	";

	if($nbLignes !=0){

		while ($infos = $result_pas_rendu->fetch_assoc()) {
			echo "<tr>";
			$id_utilisateur = $infos['id_utilisateur'];

			//Récupération du nom et prénom de l'utilisateur
			$query_user_info = "SELECT * FROM `utilisateurs` WHERE `id`= '$id_utilisateur' AND `id_magasin` = '$id_magasin';";
			$result_user_info = $mysqli->query($query_user_info);

			if($result_user_info){
				while ($user = $result_user_info->fetch_assoc()) {
					$nom = $user['nom'];
					$prenom = $user['prenom'];
				}

				$result_user_info->close();
			} else{
				$nom = "";
				$prenom = "";
			}

			$id_radiopad = $infos['id_radiopad'];
			$date_pret = $infos['date_pret'];
			$date_retour = $infos['date_retour'];
			$date = date('Y-m-d', time());
			if($date_pret >= "$date 00:00:00" && $date_pret <= "$date 23:59:59"){
				$style = "style= 'color: red;'";
			} else {
				$style = "";
			}

			if($date_retour == '0000-00-00 00:00:00'){
				$date_retour = "non rendu";
			}

			echo "<td class='color' $style> $id_utilisateur </td>";
			echo "<td class='color' $style> $nom </td>";
			echo "<td class='color' $style> $prenom </td>";
			echo "<td class='color' $style> $id_radiopad </td>";
			echo "<td class='color' $style> $date_pret </td>";
			echo "<td class='color' id='date_retour' $style> $date_retour </td>";

			echo "<td class='td_action'>
			<form action='prets.php' method='post'>
				<input style='display: none' type='text' name='user_code' value='$id_utilisateur'>
				<input style='display: none' type='text' name='radio_code' value='$id_radiopad'>
				<input style='display: none' type='text' name='page' value='index.php'>
				<input class='action' type='submit' value='Valider retour'>
			</form>
			</td>";


			echo "</tr>";
		}


		//Destruction des résultats
		$result_pas_rendu->close();
	} else {
		echo "<tr>";
			echo "<td style='color: white'> . </td>";
			echo "<td>  </td>";
			echo "<td>  </td>";
			echo "<td>  </td>";
			echo "<td>  </td>";
			echo "<td>  </td>";
		echo "</tr>";
	}

	echo "
	</tbody>
	</table>";
}
?>

	</body>
</html>

<?php
// Fermeture connection
$mysqli->close();
?>
