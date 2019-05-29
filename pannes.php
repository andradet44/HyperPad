<?php
$message = NULL;
if (isset($_GET['message'])) {
	$message = $_GET['message'];
}

$message_div = "";
$type = "";
if($message == "reparation_ok") {$message_div = "<div class='green'> Réparation validée </div>"; $type = "success";}


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
		<link rel='stylesheet' type='text/css' href='./css/general.css' media='screen' />
		<link rel='stylesheet' type='text/css' href='./css/pannes.css' media='screen' />

		<!-- Fichiers Javascripts -->
		<script type='text/javascript' src='./js/jquery-2.0.3.min.js'></script>
		<script type='text/javascript' src='./js/tri-donnees.js'></script>
		<script type='text/javascript' src='./js/search.js'></script>
		<script src="./js/sweetalert/dist/sweetalert2.all.min.js"></script>


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
					<li id="li_2" onclick="document.location.href='rechercher.php?search=pret_jour&nb_result_display=20'"> Rechercher </li>
					<li id="li_3" onclick="document.location.href='problemes_radio.php'"> Signalement </li><li onclick="document.location.href='statistiques.php'"> Statistiques </li>
					<li id="li_4" onclick="document.location.href='admin.php'" style="background-color: #2098D1;"> Admin </li>
					<li id="li_5" onclick="document.location.href='parametres.php'"> Paramètres </li>
				</ul>
			</ul>
		</nav>

		<h2 class="section_title"> Liste des pannes NON-réparées </h2>


<?php
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

if($nom_societe != NULL && $departement != NULL){
	echo "<h2> $nom_societe $departement </h2>";

	echo "
	<input class='input search' id='search' type='text' placeholder='Code radiopad'>

	<table id='tab_search' class='tab_search avectri'>
	<thead>
	<tr class='th'>
	<th class='entete selection' data-tri='1' data-type='num'> Code Radiopad </th>
	<th class='entete'> Problème </th>
	<th class='entete'> Date Problème </th>
	<th class='entete'> Status </th>
	<th class='entete'> Date Réparation </th>
	</tr>
	</thead>
	<tbody>
	";


		$query_prob_radio = "SELECT * FROM `pannes_radiopads` WHERE `id_magasin` = '$id_magasin' AND `date_reparation` = '0000-00-00 00:00:00' ORDER BY `id_radiopad`, `date_panne` DESC";
		$result_prob_radio = $mysqli->query($query_prob_radio);
		if($result_prob_radio){
			$nb_results = $result_prob_radio->num_rows;
		} else{
			$nb_results = 0;
		}

		if($nb_results > 0){
				while ($prob = $result_prob_radio->fetch_assoc()) {
					$id_radio = $prob['id_radiopad'];
					$panne = $prob['panne'];
					$date_panne = $prob['date_panne'];
					$date_reparation = $prob['date_reparation'];

					$query_status = "SELECT * FROM `radiopads` WHERE `id_radio` = '$id_radio' AND `id_magasin` = '$id_magasin';";
					$result_status = $mysqli->query($query_status);
					if($result_status){
						while ($status = $result_status->fetch_assoc()) {
							$etat = $status['etat'];
							if($etat == 'PROD') $etat_affichage = "En PROD";
							if($etat == 'STOCK') $etat_affichage = "En Stock";
							if($etat == 'REPARATION') $etat_affichage = "En Réparation";
							if($etat == 'REBUS') $etat_affichage = "Au Rebus";
							if($etat == 'REPARER') $etat_affichage = "A Envoyer en réparation";
							if($etat == 'PERDU') $etat_affichage = "Perdu";
						}
						$result_status->close();
					}

					if($date_reparation == "0000-00-00 00:00:00"){
						$date_reparation = "Non Réparé";
					}

					echo "<tr id='$id_radio' class='tr'>";

					echo "<td class='color code'> $id_radio </td>";
					echo "<td class='color'> $panne </td>";
					echo "<td class='color'> $date_panne </td>";
					echo "<td class='color'> $etat_affichage </td>";
					echo "<td class='color'> $date_reparation </td>";
					echo "<td class='td_action'>
					<form action='problemes.php' method='post'>
						<input style='display: none' type='text' name='code_radio' value='$id_radio'>
						<input style='display: none' type='text' name='type_panne' value='$panne'>
						<input style='display: none' type='text' name='date_panne' value='$date_panne'>
						<input style='display: none' type='text' name='action' value='reparation'>
						<input class='action' type='submit' value='Valider Réparation'>
					</form>
					</td>";
					echo "</tr>";
				}

		$result_prob_radio->close();
	}

		echo "
		</tbody>
		</table>";

}

?>

<script type="text/javascript">
	// On affiche le message
	var message = "<?php echo $message_div ?>";
	var type = "<?php echo $type ?>";

	if(message != ""){
		Swal.fire(
			message,
			'',
			type
		)
	}

	// On l'efface 5 secondes plus tard
	setTimeout(function() {
		if(message != ""){
			message = "";
		}
	},5000);

</script>

	</body>
</html>
<?php
// Fermeture connection
$mysqli->close();
?>
