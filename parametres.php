<?php
$first_config = NULL;
if (isset($_GET['first_config'])) {
	$first_config = $_GET['first_config'];
}

$id_magasin = NULL;

if($first_config == NULL){
	// Ouvre session
	session_start();

	if (isset($_SESSION['id_magasin'])) {
		$id_magasin = $_SESSION['id_magasin'];
	}


	$login = NULL;
	$user_id = NULL;

	// Récupère dans session
	if (isset($_SESSION['login'])) {
		$login = $_SESSION['login'];
	}
	if (isset($_SESSION['user_id'])) {
		$user_id = $_SESSION['user_id'];
	}

	if($login == NULL || $user_id == NULL){
		header("Location: admin.php");
	}
}



// Paramètres de connexion
include_once("dbConfig.php");

// Ouverture connexion
$mysqli = new mysqli(DB_HOST, DB_LOGIN, DB_PWD, DB_NAME); mysqli_set_charset($mysqli, "utf8");
?>

<!DOCTYPE html>

<html>
	<!-- En tête -->
	<head>
		<!-- Fichiers CSS -->
		<link rel='stylesheet' type='text/css' href='./css/parametres.css' media='screen' />
		<link rel='stylesheet' type='text/css' href='./css/general.css' media='screen' />

		<!-- Fichiers Javascripts -->
		<script type='text/javascript' src='./js/jquery-2.0.3.min.js'></script>
		<script type='text/javascript' src='./js/ajax2.js'></script>

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
					<li id="li_0" onclick="document.location.href='index.php'"> HyperPad Gestion </li>
					<li id="li_1" onclick="document.location.href='valider_pret_retour.php'"> Valider un prêt ou un retour </li>
					<li id="li_2" onclick="document.location.href='rechercher.php'"> Rechercher </li>
					<li id="li_3" onclick="document.location.href='pannes.php'"> Signalement </li>
					<li onclick="document.location.href='statistiques.php'"> Statistiques </li>
					<li id="li_4" onclick="document.location.href='admin.php'"> Admin </li>
					<li id="li_4" onclick="document.location.href='parametres.php'" style="background-color: #2098D1;"> Paramètres </li>
				</ul>
			</ul>
		</nav>

		<h2 class="section_title"> Parametres </h2>

<?php

		echo "
		<div id='popup1' class='overlay'>
			<div class='popup'>
				<div class='content'>

			<h2 > Paramètres </h2>

			<div id='overlay'>
				<div id='div_message'>

				</div>
			</div>

			<form class='depart_soc' action='define_config.php' method='post'>
			<div class='departement'>
				<label> Département : </label>
				<select class='' name='departement' id='departement'>";

				$query_departement = "SELECT * FROM `magasins` GROUP BY `departement` ORDER BY `id_magasin` ASC ;";
				$result_departement = $mysqli->query($query_departement);

				if($result_departement){
					while ($magasin = $result_departement->fetch_assoc()) {
						$departement = $magasin['departement'];
						echo "<option value='$departement'> $departement </option>";
					}

					$result_departement->close();
				}

				echo "</select>
				</div>

				<div class='societe'>
				<label> Nom de la société : </label>
				<select name='nom_societe' id='nom_societe'>";



					$query_societe = "SELECT * FROM `magasins`;";
					$result_societe = $mysqli->query($query_societe);

					if($result_societe){
						while ($societe = $result_societe->fetch_assoc()) {
							$nom = $societe['nom'];
							echo "<option value='$nom'> $nom </option>";
						}
						$result_societe->close();
					}

					$mail_admin = NULL;
					$ip_reseau = NULL;
					if($id_magasin == NULL){
						$id_magasin = 0;
					}

					$query_mail = "SELECT * FROM `parametres` WHERE `id_magasin` = '$id_magasin';";
					$result_mail = $mysqli->query($query_mail);

					if($result_mail){
						while ($parametre = $result_mail->fetch_assoc()) {
							$mail_admin = $parametre['mail_admin'];
							$ip_reseau = $parametre['ip_reseau'];
						}
						$result_mail->close();
					}

					echo "</select>
					</div>

					<div class='ip_reseau'>
						<label> Adresse Réseau avec masque (ex : 10.100.101.0/24) : </label>
						<p style='color: red'> Pour saisir plusieurs adresses réseau, veuillez les séparer par des virgules </p>
						<textarea id='ip_reseau' rows='3' cols='80' name='ip_reseau' placeholder='10.100.100.0/24, 10.100.101.0/24, 10.100.102.0/24'>$ip_reseau</textarea>
					</div>

					<div class='mail'>
						<label> Adresse E-mail de l'admin : </label>
						<input id='mail_admin' type='text' name='mail_admin' value='$mail_admin'>
					</div>
					<input onclick=" . '"' . "document.location.href='index.php'" . '"' . "type='button' id='annuler_modal' value='Annuler'>
				<input type='submit' id='valider_modal' value='Valider'>
			</form>
			</div>
			<p style='color: red'> HyperPad V. 1.1  </p>
		</div>
	</div>
		" ;
?>

	</body>
</html>
<?php
// Fermeture connection
$mysqli->close();
?>
