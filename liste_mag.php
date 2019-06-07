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

$message = NULL;
if (isset($_GET['message'])) {
	$message = $_GET['message'];
}

if($message == NULL) {$message_div = ""; $type = "";}
if($message == "success") {$message_div = "<div class='green'> Modification prise en compte </div>"; $type = "success";}
if($message == "error") {$message_div = "<div class='red'> Veuillez vérifier votre saisie </div>"; $type = "error";}
?>

<!DOCTYPE html>

<html>
	<!-- En tête -->
	<head>
		<!-- Fichiers CSS -->
		<link rel='stylesheet' type='text/css' href='./css/general.css' media='screen' />
		<link rel='stylesheet' type='text/css' href='./css/liste_radio.css' media='screen' />

		<!-- Fichiers Javascripts -->
		<script type='text/javascript' src='./js/jquery-2.0.3.min.js'></script>
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
					<li id="li_3" onclick="document.location.href='problemes_radio.php'"> Signalement </li>
					<li onclick="document.location.href='statistiques.php'"> Statistiques </li>
					<li id="li_4" onclick="document.location.href='admin.php'" style="background-color: #2098D1;"> Admin </li>
				</ul>
			</ul>
		</nav>

		<h2 class="section_title"> Liste des Magasins </h2>

<?php
if($nom_societe == NULL || $departement == NULL || $id_magasin == NULL){
	header("Location: index.php");
} else {
	echo "<h2> $nom_societe $departement </h2>";

	echo "<input class='input search' id='search' type='text' placeholder='Nom '>";

	echo "
	<table id='tab_search' class='tab_search avectri'>
	<thead>
		<tr class='th'>
		<th class='entete'> Magasin </th>
		<th class='entete'> Département </th>
		<th class='entete'> Alias </th>
		<th class='entete'> Adresse </th>
		</tr>
	</thead>
	<tbody>
	";

	//Récupération du nom et prénom de l'utilisateur
	$query_mag_info = "SELECT * FROM `magasins` ORDER BY `id_magasin` ASC;";
	$result_mag_info = $mysqli->query($query_mag_info);

	if($result_mag_info){
		while ($mag = $result_mag_info->fetch_assoc()) {
			$id = $mag['id_magasin'];
			$departement_mag = $mag['departement'];
			$adresse_mag = $mag['adresse'];
			$alias_mag = $mag['alias'];
			$nom = $mag['nom'];
			echo "<tr id='$nom' class='tr'>";

			echo "<td class='color code'> $id - $nom</td>";
			echo "<td class='color'> $departement_mag </td>";
			echo "<td class='color'> $alias_mag </td>";
			echo "<td class='color'> <textarea class='input' name='adresse$id' rows='8' cols='50'>$adresse_mag</textarea> </td>";

			echo "<td class='td_action color'>
						<form action='admin_functions.php' method='post'>
							<textarea  style='display: none' id='adresse$id' name='adresse_mag' rows='8' cols='50'>$adresse_mag</textarea>
							<input type='hidden' name='id_mag' value='$id'>

							<input type='hidden' name='action' value='mod_mag_base'>
							<input class='action' type='submit' value='Valider'>
						</form>
						</td>";
			echo "</tr>";
		}
		$result_mag_info->close();
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

function format_date($date){
	$date = explode('-',$date);
	$date = array_reverse($date);
	$date = implode('/',$date);
	return "$date";
}

?>

<script type="text/javascript">
	jQuery('input').keyup(function() {
		var name = jQuery(this).attr('name');
		var valeur = jQuery(this).val();

		jQuery('#'+name).val(valeur);
	});

	jQuery('.input').click(function() {
		var name = jQuery(this).attr('name');
		var valeur = jQuery(this).val();

		jQuery('#'+name).val(valeur);
	});

	jQuery('textarea').keyup(function() {
		var name = jQuery(this).attr('name');
		var valeur = jQuery(this).val();

		jQuery('#'+name).val(valeur);
	});

	jQuery('textarea').click(function() {
		var name = jQuery(this).attr('name');
		var valeur = jQuery(this).val();

		jQuery('#'+name).val(valeur);
	});


	// On affiche les messages
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
