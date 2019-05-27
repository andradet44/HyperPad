<?php
$message = NULL;
if (isset($_GET['message'])) {
	$message = $_GET['message'];
}

if($message == "insert_prob_ok") $message_div = "<div class='green'> Panne enregistrée </div>";
if($message == "reparation_ok") $message_div = "<div class='green'> Réparation enregistrée </div>";


// Paramètres de connexion
include_once("dbConfig.php");

// Ouverture connexion
$mysqli = new mysqli(DB_HOST, DB_LOGIN, DB_PWD, DB_NAME);
?>

<!DOCTYPE html>

<html>
	<!-- En tête -->
	<head>
		<!-- Fichiers CSS -->
		<link rel='stylesheet' type='text/css' href='./css/general.css' media='screen' />
		<link rel='stylesheet' type='text/css' href='./css/defaillances.css' media='screen' />

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
					<li id="li_0" onclick="document.location.href='index.php'"> HyperPad Gestion </li>
					<li id="li_1" onclick="document.location.href='valider_pret_retour.php'"> Valider un prêt ou un retour </li>
					<li id="li_2" onclick="document.location.href='rechercher.php?search=pret_jour&nb_result_display=20'"> Rechercher </li>
					<li id="li_3" onclick="document.location.href='problemes_radio.php'"> Signalement </li><li onclick="document.location.href='statistiques.php'"> Statistiques </li>
					<li id="li_4" onclick="document.location.href='admin.php'" style="background-color: #2098D1;"> Admin </li>
					<li id="li_5" onclick="document.location.href='parametres.php'"> Paramètres </li>
				</ul>
			</ul>
		</nav>

		<h2 class="section_title"> Liste des défaillances signalés </h2>

		
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
	<div id='div_message'>
	</div>

	<table class='tab_search avectri'>
	<thead>
	<tr class='th'>
	<th class='entete selection' data-tri='1' data-type='num'> Code Radiopad </th>
	<th class='entete'> Problème </th>
	<th class='entete'> Date Problème </th>
	</tr>
	</thead>
	<tbody>
	";


		$query_prob_radio = "SELECT * FROM `defaillances_radiopads` WHERE `id_magasin` = '$id_magasin';";
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

					echo "<tr>";

					echo "<td class='color'> $id_radio </td>";
					echo "<td class='color'> $panne </td>";
					echo "<td class='color'> $date_panne </td>";
					echo "<td class='td_action'>
					<form action='problemes.php' method='post'>
						<input style='display: none' type='text' name='code_radio' value='$id_radio'>
						<input style='display: none' type='text' name='type_panne' value='$panne'>
						<input style='display: none' type='text' name='date_panne' value='$date_panne'>
						<input style='display: none' type='text' name='action' value='panne'>
						<input class='action' type='submit' value='Valider Panne'>
					</form>
					</td>";
					echo "</tr>";
				}

		$result_prob_radio->close();
	} else {
		echo "<tr>";
		echo "<td style='color: white;' > . </td>";
		echo "<td >  </td>";
		echo "<td >  </td>";
		echo "<td style='color: white; background: white'>
			<input style='color: white; background: white; border-style: none;' type='submit' value='Valider Réparation'>
		 </td>";
		echo "</tr>";
	}

		echo "
		</tbody>
		</table>";

}

?>

<script type="text/javascript">
	// On affiche le message
	document.getElementById('div_message').innerHTML = "<?php echo $message_div ?>";

	// On l'efface 5 secondes plus tard
	setTimeout(function() {
		if(document.getElementById('div_message').innerHTML != ""){
			document.getElementById('div_message').innerHTML = "";
		}
	},5000);

</script>

	</body>
</html>
<?php
// Fermeture connection
$mysqli->close();
?>
