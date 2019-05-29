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
if (isset($_SESSION['alias_magasin'])) {
	$alias_magasin = $_SESSION['alias_magasin'];
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
?>

<!DOCTYPE html>

<html>
	<!-- En tête -->
	<head>
		<!-- Fichiers CSS -->
		<link rel='stylesheet' type='text/css' href='./css/general.css' media='screen' />
		<link rel='stylesheet' type='text/css' href='./css/admin.css' media='screen' />
		<style media="screen">
			table{
				display: block;s
				width: 90%;
				margin: auto;
			}
			td{
				width: 28%;
				padding: 0;
			}
			.input1{
				height: 40px;
				border-style: none;
				background: #f2f2f2;
				color: #000;
				border: 0;
				border-radius: 6px;
				text-align: center;
				border-style: solid;
				border-color: black;
				border-width: 1px;
			}
		</style>

		<!-- Fichiers Javascripts -->
		<script type='text/javascript' src='./js/jquery-2.0.3.min.js'></script>


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

		<h2 class="section_title"> Installation Radiopad </h2>

<?php
if($nom_societe == NULL || $departement == NULL || $id_magasin == NULL){
	header("Location: index.php");
} else {
	echo "<h2> $nom_societe $departement </h2>";
?>

<div class="container">
	<!-- Ajouter un utilisateur -->
	<h1 class="division_search"> Paramètres </h1>
	<p style='color: red; width: 100%; text-align: center; margin-bottom: 30px; background: white; border-radius: 5px;'>
		Choisissez les Paramètres souhaités et cliquez sur 'télécharger les ressources'
	</p>
	<div class="div_forms">

		<h3> Configuration basique </h3>

		<form action="ressources.php" method="post" enctype="multipart/form-data">
			<div class="two">
				<label  class="place_holder" for="radio_code"> Code Radiopad </label>
				<select class="input" id="radio_code" name="radio_code" required>
<?php
						//Requete sql
						$query_radios = "SELECT * FROM `radiopads` WHERE `id_magasin` = '$id_magasin';";

						//On lance la requete en base de données
						$result_radios = $mysqli->query($query_radios);

						while ($radio = $result_radios->fetch_assoc()) {
							echo "<option value='" . $radio['id_radio'] ."'>" . $radio['id_radio'] . "</option>";
						}

						// Destruction résultat
						$result_radios->close();
?>
				</select>

				<input type="hidden" name="alias_magasin" value="<?php echo strtolower($alias_magasin); ?>" required>

				<label class="place_holder" for="modele"> Modèle </label>
				<select class="input" id="modele" name="modele" required>
					<option value="MC32N0"> MC32N0 </option>
					<option value="MC3090"> MC3090 </option>
					<option value="MC3190"> MC3190 </option>
				</select>
			</div>

			<div class="two">
				<label class="place_holder" for="ip_serveur_meti"> IP Serveur METI Radiopad </label>
				<input class="input" id="ip_serveur_meti" type="text" name="ip_serveur_meti" value='10.10.10.196' required>

				<label class="place_holder" for="ip_serveur_radiopad"> IP Serveur Radiopad </label>
				<input class="input" id="ip_serveur_radiopad" type="text" name="ip_serveur_radiopad" value='10.10.10.196' required>
			</div>

			<div class="two">
				<label class="place_holder" for="fuseau_horaire"> Fuseau Horaire </label>
				<select class="input" id="fuseau_horaire" name="fuseau_horaire" required>
					<option value="(GMT-03:00) Cayenne, Fortaleza">(GMT-03:00) Cayenne, Fortaleza </option>
					<option value="(UTC-04:00) Caracas">(UTC-04:00) Caracas </option>
				</select>

				<label class="place_holder" for="ip_serveur_pricer"> IP Serveur Pricer </label>
				<input class="input" id="ip_serveur_pricer" type="text" name="ip_serveur_pricer" value='10.50.91.93' required>
			</div>

			<h3> Paramètres secondaires </h3>
			<div class="two">
				<label class="place_holder" for="volume"> Volume général </label>
				<select class="input" id="volume" name="volume" required>
					<option value="0"> Pas de son </option>
					<option value="1" selected="selected"> Faible </option>
					<option value="2"> Moyen </option>
					<option value="3"> Max </option>
				</select>

				<label class="place_holder" for="key"> Volume des touches </label>
				<select class="input" id="key" name="key" required>
					<option value="0"> Pas de son </option>
					<option value="1" selected="selected"> Faible </option>
					<option value="2"> Moyen </option>
					<option value="3"> Max </option>
				</select>
			</div>

			<div class="two">
				<label class="place_holder" for="screen"> Volume applications </label>
				<select class="input" id="screen" name="screen" required>
					<option value="0"> Pas de son </option>
					<option value="1" selected="selected"> Faible </option>
					<option value="2"> Moyen </option>
					<option value="3"> Max </option>
				</select>
			</div>

			<div class="two">
				<label class="place_holder" for="icone_heure">
					<input style='width: 20px; height: 20px; margin-right: 5px;' type="checkbox" id="icone_heure" name="icone_heure" checked>
				 	Afficher l’icône de l’heure
				</label>

				<label class="place_holder" for="icone_batterie">
					<input style='width: 20px; height: 20px; margin-right: 5px;' type="checkbox" id="icone_batterie" name="icone_batterie" checked>
					Afficher l’icône Batterie
				</label>
			</div>

			<div class="two">
				<label class="place_holder" for="icone_clavier">
					<input style='width: 20px; height: 20px; margin-right: 5px;' type="checkbox" id="icone_clavier" name="icone_clavier" checked>
					Afficher l’icône clavier ALPHA ou NUMERIQUE
				</label>

				<label class="place_holder" for="icone_reseau">
					<input style='width: 20px; height: 20px; margin-right: 5px;' type="checkbox" id="icone_reseau" name="icone_reseau" checked>
					Afficher icone signal réseau
				</label>
			</div>


			<h3> Vidage LAN </h3>

			<div class="two">
				<label class="place_holder" for="ip_serveur_pricer"> IP Serveur FTP </label>
				<input class="input" id="ip_serveur_ftp" type="text" name="ip_serveur_ftp" value='10.10.10.192' required>

				<label class="place_holder" for="userName"> Nom d'utilisateur </label>
				<input class="input" id="userName" type="text" name="userName" value='RadiopadRCC' required>
			</div>

			<div class="two">
				<label class="place_holder" for="password"> Mot de passe </label>
				<input class="input" id="password" type="password" name="password" required>

				<label class="place_holder" for="dossier"> Dossier de dépôt </label>
				<input class="input" id="dossier" type="text" name="dossier" value='/Vidages_Radiopad/' required>
			</div>


			<h3> Ajouter un lien Applicatif de type web </h3>

			<table>
				<thead>
					<tr class='th'>
						<th class='entete'> Nom de l'application </th>
						<th class='entete'> Description </th>
						<th class='entete'> Lien vers l'application </th>
						<th class='ok back_red' id='add_line'> Ajouter un lien </th>
					</tr>
				</thead>
				<tbody id='tbody'>
				</tbody>
			</table>

			<input id="nb_lignes" type="hidden" name="nb_lignes" value='0'>

			<h3> WIFI </h3>
			<p style='color: red; width: 100%; text-align: center; margin-bottom: 30px; background: white; border-radius: 5px;'>
				Il est nécessaire d'envoyer les fichiers de configuration WIFI dans les deux cas suivants : <br>
					- C'est la première installation dans ce magasin. <br>
					- Les configurations WIFI ont changé.
			</p>

			<label class="place_holder" for="wcs_options"> Fichier WCS_OPTIONS.REG </label>
			<input class="input" type="file" name="wcs_options" />

			<label class="place_holder" for="wcs_profiles"> Fichier WCS_PROFILES.REG </label>
			<input class="input" type="file" name="wcs_profiles" />


			<input class="ok" style="display: block" type="submit" value="Télécharger les Ressources">
		</form>
	</div>
</div>
<?php

}
?>
	<script type="text/javascript">
		id = 0, nb_lignes_global = 0;
		jQuery('#add_line').click(function(){
			add_line();
		});

		function add_line(){
			var nom_app = "nom_app" + id;
			var description = "description" + id;
			var lien = "lien" + id;

			var tbody = jQuery('#tbody');
			var tr = "<tr id='tr" + id + "'> <td> <input class='input1' type='text' name='" + nom_app + "' required> </td> <td> <input class='input1' type='text' name='" + description + "' required> </td> <td> <input class='input1' type='text' name='" + lien + "' value='10.10.10.48:7404/Nom Application' required> </td> <td onclick='del_line(" + id + ")' class='ok back_red'> Supprimer </td> </tr>";
			tbody.append(tr);

			id += 1;
			nb_lignes_global += 1;
			jQuery('#nb_lignes').val(nb_lignes_global);
			console.log(nb_lignes_global);
		}

		function del_line(id){
			var element = jQuery('#tr' + id);
			element.remove();
		}
	</script>

	</body>
</html>

<?php
// Fermeture connection
$mysqli->close();
?>
