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

		<h2 class="section_title"> Liste des Utilisateurs </h2>

<?php
if($nom_societe == NULL || $departement == NULL || $id_magasin == NULL){
	header("Location: index.php");
} else {
	echo "<h2> $nom_societe $departement </h2>";

	echo "<input class='input search' id='search' type='text' placeholder='Code Utilisateur'>";

	echo "
	<table id='tab_search' class='tab_search avectri'>
	<thead>
		<tr class='th'>
		<th class='entete selection' data-tri='1' data-type='num'> Code utilisateur </th>
		<th class='entete'> Nom </th>
		<th class='entete'> Prénom </th>
		<th class='entete'> Fonction </th>
		<th class='entete'> Secteur </th>
		<th class='entete'> Non rendus </th>
		</tr>
	</thead>
	<tbody>
	";

	//Récupération du nom et prénom de l'utilisateur
	$query_user_info = "SELECT * FROM `utilisateurs` WHERE `id_magasin` = '$id_magasin' ORDER BY `id` ASC;";
	$result_user_info = $mysqli->query($query_user_info);

	if($result_user_info){
		while ($user = $result_user_info->fetch_assoc()) {
			$user_code = $user['id'];
			$nom = $user['nom'];
			$prenom = $user['prenom'];
			$fonction = $user['fonction'];
			$secteur = $user['secteur'];
			$non_rendu = $user['non_rendu'];
			echo "<tr id='$user_code' class='tr'>";

			echo "<td class='color code'> $user_code </td>";
			echo "<td class='color'> $nom </td>";
			echo "<td class='color'> $prenom </td>";
			echo "<td class='color'>

			<select class='input' name='fonction1$user_code'>
				<option value='EMPLOYE COMMERCIAL'> Employée(e) Commercial(e)</option>

				<option value='$fonction' selected='selected'> $fonction </option>
				<option value='VENDEUR'> Vendeur </option>
				<option value='BOUCHEUR'> Boucheur </option>
				<option value='COMPTABLE'> Comptable </option>
				<option value='STAGIAIRE'> Stagiaire </option>

				<option value='RESP INFORMATIQUE'> Responsable Informatique </option>
				<option value='ADJ RESP INFORMATIQUE'> Adjoint Responsable Informatique </option>

				<option value='RESP CAISSE'> Responsable Caisse </option>
				<option value='ADJ RESP CAISSE'> Adjoint Responsable Caisse </option>
				<option value='HOTE CAISSE'> Hote ou Hotesse de Caisse </option>

				<option value='CHEF RAYON FRAIS'> Chef de Rayon Frais </option>
				<option value='CHEF RAYON SURGELE'> Chef de Rayon Surgelé </option>
				<option value='CHEF RAYON FRUITS LEGUMES'> Chef de Rayon Fruits et légumes </option>
				<option value='CHEF RAYON STAND'> Chef de Rayon Stand </option>
				<option value='CHEF RAYON BOULANGERIE PATISSERIE'> Chef de Rayon Boulangerie Patisserie </option>
				<option value='CHEF RAYON EPICERIE'> Chef de Rayon Epicerie </option>
				<option value='CHEF RAYON LIQUIDE'> Chef de Rayon Liquide </option>
				<option value='CHEF RAYON DPH'> Chef de Rayon DPH </option>
				<option value='CHEF RAYON TEXTILLE'> Chef de Rayon Textille </option>
				<option value='CHEF RAYON BAZAR'> Chef de Rayon Bazar </option>
				<option value='CHEF RAYON EPCS'> Chef de Rayon EPCS </option>

				<option value='ADJ CHEF RAYON FRAIS'> Adjoint Chef de Rayon Frais </option>
				<option value='ADJ CHEF RAYON SURGELE'> Adjoint Chef de Rayon Surgelé </option>
				<option value='ADJ CHEF RAYON FRUITS LEGUMES'> Adjoint Chef de Rayon Fruits et légumes </option>
				<option value='ADJ CHEF RAYON STAND'> Adjoint Chef de Rayon Stand </option>
				<option value='ADJ CHEF RAYON BOULANGERIE PATISSERIE'> Adjoint Chef de Rayon Boulangerie Patisserie </option>
				<option value='ADJ CHEF RAYON EPICERIE'> Adjoint Chef de Rayon Epicerie </option>
				<option value='ADJ CHEF RAYON LIQUIDE'> Adjoint Chef de Rayon Liquide </option>
				<option value='ADJ CHEF RAYON DPH'> Adjoint Chef de Rayon DPH </option>
				<option value='ADJ CHEF RAYON TEXTILLE'> Adjoint Chef de Rayon Textille </option>
				<option value='ADJ CHEF RAYON BAZAR'> Adjoint Chef de Rayon Bazar </option>
				<option value='ADJ CHEF RAYON EPCS'> Adjoint Chef de Rayon EPCS </option>
				<option value='DIRECTION'> Direction </option>

			</select>
			</td>";
			echo "<td class='color'> <input class='input' type='text' name='secteur1$user_code' value='$secteur'> </td>";
			echo "<td class='color'> <input class='input' type='text' name='non_rendu1$user_code' value='$non_rendu'> </td>";
			echo "<td class='td_action color'>
						<form action='admin_functions.php' method='post'>
							<input type='hidden' name='user_code' value='$user_code'>
							<input type='hidden' name='nom' value='$nom'>
							<input type='hidden' name='prenom' value='$prenom'>
							<input type='hidden' id='fonction1$user_code' name='fonction' value='$fonction'>
							<input type='hidden' id='secteur1$user_code' name='secteur' value='$secteur'>
							<input type='hidden' id='non_rendu1$user_code' name='non_rendu' value='$non_rendu'>

							<input type='hidden' name='action' value='mod_user_base'>
							<input class='action' type='submit' value='Valider'>
						</form>
						</td>";
			echo "</tr>";
		}
		$result_user_info->close();
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
</script>

	</body>
</html>

<?php
// Fermeture connection
$mysqli->close();
?>
