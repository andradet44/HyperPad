<?php
// Paramètres de connexion
include_once("dbConfig.php");

// Ouverture connexion
$mysqli = new mysqli(DB_HOST, DB_LOGIN, DB_PWD, DB_NAME);

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
		<link rel='stylesheet' type='text/css' href='./css/general.css' media='screen' />
		<link rel='stylesheet' type='text/css' href='./css/liste_radio.css' media='screen' />

		<!-- Fichiers Javascripts -->
		<script type='text/javascript' src='./js/jquery-2.0.3.min.js'></script>
		<script type='text/javascript' src='./js/search.js'></script>


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

		<h2 class="section_title"> Liste des Radiopads </h2>
<?php
if($nom_societe == NULL || $departement == NULL || $id_magasin == NULL){
	header("Location: index.php");
} else {
	echo "<h2> $nom_societe $departement </h2>";

	echo "<input class='input search' id='search' type='text' placeholder='Code radiopad'>";

	echo "
	<table id='tab_search' class='tab_search avectri'>
	<thead>
		<tr class='th'>
		<th class='entete selection' data-tri='1' data-type='num'> Code Radiopad </th>
		<th class='entete'> SN </th>
		<th class='entete'> Etat </th>
		<th class='entete'> Affectation </th>
		<th class='entete'> Changement batterie </th>
		</tr>
	</thead>
	<tbody>
	";

	//Récupération du nom et prénom de l'utilisateur
	$query_radio_info = "SELECT * FROM `radiopads` WHERE `id_magasin` = '$id_magasin' ORDER BY `id_radio` ASC;";
	$result_radio_info = $mysqli->query($query_radio_info);

	if($result_radio_info){
			while ($radio = $result_radio_info->fetch_assoc()) {
				$radio_code = $radio['id_radio'];
				$sn = $radio['sn'];
				$etat = $radio['etat'];
				$affectation = $radio['affectation'];
				$batterie = $radio['batterie'];
				$batterie = format_date($batterie);

				$etat_affichage = "";
				if($etat == 'PROD') $etat_affichage = "<option style='color: red' value='PROD' selected='selected'> En PROD </option>";
				if($etat == 'STOCK') $etat_affichage = "<option style='color: red' value='STOCK' selected='selected'> En Stock</option>";
				if($etat == 'REPARATION') $etat_affichage = "<option style='color: red' value='REPARATION' selected='selected'> En Réparation </option>";
				if($etat == 'REBUS') $etat_affichage = "<option style='color: red' value='REBUS' selected='selected'> Au Rebus </option>";
				if($etat == 'REPARER') $etat_affichage = "<option style='color: red' value='REPARER' selected='selected'> A Envoyer en réparation </option>";
				if($etat == 'PERDU') $etat_affichage = "<option style='color: red' value='PERDU' selected='selected'> Perdu </option>";


				echo "<tr id='$radio_code' class='tr'>";

				echo "<td class='color code'> $radio_code </td>";
				echo "<td class='color'> $sn </td>";
				echo "<td class='color'>
				<select class='input' name='etat1$radio_code'>
					echo $etat_affichage;
					<option value='PROD'> En PROD </option>
					<option value='STOCK'> En Stock </option>
					<option value='REPARATION'> En Réparation </option>
					<option value='REBUS'> Au Rebus </option>
					<option value='REPARER'> A Envoyer en réparation </option>
					<option value='PERDU'> Perdu </option>
				</select>
				</td>";
				echo "<td class='color'> <input class='input' type='text' name='affectation1$radio_code' value='$affectation'> </td>";
				echo "<td class='color'> <input class='input' type='text' name='nouv_batterie1$radio_code' value='$batterie'> </td>";
				echo "<td class='td_action color'>
								<form action='admin_functions.php' method='post'>
									<input type='hidden' id='etat1$radio_code' name='etat' value='$etat'>
									<input type='hidden' id='affectation1$radio_code' name='affectation' value='$affectation'>
									<input type='hidden' id='nouv_batterie1$radio_code' name='nouv_batterie' value='$batterie'>
									<input type='hidden' name='code_radio' value='$radio_code'>
									<input type='hidden' name='action' value='mod_radio_base'>
									<input class='action' type='submit' value='Valider'>
								</form>
							</td>";
				echo "</tr>";
			}



	$result_radio_info->close();
	} else {
		echo "<tr>";
			echo "<td style='color: white'> . </td>";
			echo "<td> </td>";
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

	jQuery('.input').keyup(function() {
		var name = jQuery(this).attr('name');
		var valeur = jQuery(this).val();

		jQuery('#'+name).val(valeur);
	});

	jQuery('.input').click(function() {
		var name = jQuery(this).attr('name');
		var valeur = jQuery(this).val();

		jQuery('#'+name).val(valeur);
	});
</script>

	</body>
</html>

<?php
// Fermeture connection
$mysqli->close();
?>
