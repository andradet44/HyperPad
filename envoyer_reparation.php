<?php
$message = NULL;
if (isset($_GET['message'])) {
	$message = $_GET['message'];
}

$ids_radios = NULL;
if (isset($_GET['ids_radios'])) {
	$ids_radios = $_GET['ids_radios'];
}

$code_rep = NULL;
if (isset($_GET['code_rep'])) {
	$code_rep = $_GET['code_rep'];
}

$message_div = "";
$type = "";
if($message == "vide") {$message_div = "<div class='red'> Veuillez vérifier votre saisie </div>"; $type = "error";}


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
		<link rel='stylesheet' type='text/css' href='./css/envoyer_reparation.css' media='screen' />

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

		<h2 class="section_title"> Liste des Radiopads à envoyer en réparation  </h2>


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
	echo "<h2> $nom_societe $departement </h2>

	<div class='gauche'>
		<input style='display: block' class='input search' id='search' type='text' placeholder='Code radiopad'>

		<input style='background: #2098D1' class='input ok' id='cocher_tout' type='button' value='Cocher/Décocher tout'>
	</div>

	<div class='droite'>
	<form class='envoyer_rep' action='reparations.php' method='post'>
		<div class='reparateur'>
			<label class='container'>
			Réparateur :
			</label>
			<input class='input' type='text' name='code_rep' list='repCodes' placeholder='Code réparateur' autocomplete='off' value='$code_rep' required>

			<input id='envoyer_reparation' class='input ok' type='submit' value='Envoyer en Réparation'>
		</div>

		<div class='coli'>
			<h1 style='color: red; font-size: 30px; margin-bottom: 10px;'> Expédition </h1>
			<label class='container'>
				<input id='non_check' type='checkbox' name='chronoposte' value='true' checked>
				<span class='checkmark douane'></span>
				Attestation de valeur
			</label>

			<label class='container'> Numéro LTA :
			</label>
			<input class='input' type='text' name='lta' placeholder='Numéro LTA'>

			<label class='container'> Dimensions :
			</label>
			<input class='input' type='text' name='dimensions' placeholder='Dimensions'>

		</div>

		";

?>
		<datalist id='repCodes'>
<?php

				$query_users = "SELECT * FROM `utilisateurs` WHERE `id_magasin` = '$id_magasin' AND `fonction` = 'REPARATEUR' ORDER BY `nom` ASC;";

				//On lance la requete en base de données
				$result_users = $mysqli->query($query_users);

				if($result_users){
					while ($user = $result_users->fetch_assoc()) {
						echo "<option value='".$user['id']." ".$user['nom']."'>";
					}
					// Destruction résultat
					$result_users->close();
				}
?>
		</datalist>

<?php
	echo "
		<input id='list_id_radio' type='hidden' name='list_id_radio' value='$ids_radios'>
		<input id='dates_probleme' type='hidden' name='dates_probleme' value='$ids_radios'>
		<input id='problemes' type='hidden' name='problemes' value='$ids_radios'>

		</form>
		</div>";

	echo "
	<table id='tab_search' class='tab_search avectri'>
	<thead>
	<tr class='th'>
	<td style='background: white; width: 50px;'>  </td>
	<th class='entete selection' data-tri='1' data-type='num'> Code Radiopad </th>
	<th class='entete'> Problème </th>
	<th class='entete'> Date Problème </th>
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


					echo "<tr id='$id_radio' class='tr'>";

					echo "<td class='td_action'>
						<label class='container'>
							<input id='$id_radio' type='checkbox'>
							<span class='checkmark'></span>
						</label>
					</td>";
					echo "<td class='color code'> $id_radio </td>";
					echo "<td id='panne$id_radio' class='color'> $panne </td>";
					echo "<td id='date_panne$id_radio' class='color'> $date_panne </td>";
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

	var isCocher = false;

	jQuery("#cocher_tout").click(function() {
		if(isCocher == false){
			isCocher = true;
			get_all();
		} else{
			remove_all();
			isCocher = false;
		}

		cocherTout(isCocher);
	});

	jQuery("input").click(function() {
		var input = jQuery(this);
		var list_id_radio = jQuery('#list_id_radio');
		var valeur = list_id_radio.val();

		var dates_probleme = jQuery("#dates_probleme");
		var val_dates_probleme = dates_probleme.val();
		valeur_dates_problemes = val_dates_probleme;

		var problemes = jQuery("#problemes");
		var val_problemes = problemes.val();
		valeur_problemes = val_problemes;

		var id = input[0].id;

		if(input[0].type == 'checkbox' && id != 'non_check'){
			if(input[0].checked == true){
				valeur += id;
				valeur += ',';
				list_id_radio.val(valeur);

				var date_panne = jQuery("#date_panne"+id)[0].innerHTML;
				valeur_dates_problemes += date_panne;
				valeur_dates_problemes += ',';
				dates_probleme.val(valeur_dates_problemes);

				var panne = jQuery("#panne"+id)[0].innerHTML;
				valeur_problemes += panne;
				valeur_problemes += ',';
				problemes.val(valeur_problemes);
			} else {
				valeur = valeur.replace(id + ',', '');
				list_id_radio.val(valeur);

				var date_panne = jQuery("#date_panne"+id)[0].innerHTML;
				valeur_dates_problemes = valeur_dates_problemes.replace(date_panne + ',', '');
				dates_probleme.val(valeur_dates_problemes);

				var panne = jQuery("#panne"+id)[0].innerHTML;
				valeur_problemes = valeur_problemes.replace(panne + ',', '');
				problemes.val(valeur_problemes);
			}
		}
	});

	function cocherTout(etat){
		var cases = document.getElementsByTagName('input');   // on recupere tous les INPUT

		for(var i=1; i<cases.length; i++){ //On les parcours
		 if(cases[i].type == 'checkbox'){ //On teste s'il s'agit d'un input de type checkbox
		 var id = cases[i].id;
			 if(id != 'non_check'){
				 cases[i].checked = etat; //On coche ou on décoche
			 }
		 }
		}
	}

	function get_all(){
		var cases = document.getElementsByTagName('input'); // on recupere tous les INPUT

		var list_id_radio = jQuery('#list_id_radio');
		var valeur = list_id_radio.val();

		var dates_probleme = jQuery("#dates_probleme");
		var val_dates_probleme = dates_probleme.val();
		valeur_dates_problemes = val_dates_probleme;

		var problemes = jQuery("#problemes");
		var val_problemes = problemes.val();
		valeur_problemes = val_problemes;

		for(var i=1; i<cases.length; i++){ //On les parcours
		 if(cases[i].type == 'checkbox'){  //On teste s'il s'agit d'un input de type checkbox
			 if(cases[i].checked == false){
				 var id = cases[i].id;

				 valeur += cases[i].id;
				 valeur += ',';
				 list_id_radio.val(valeur);

				 var id = cases[i].id;

				 if(id != 'non_check'){
					 var date_panne = jQuery("#date_panne"+id)[0].innerHTML;
					 valeur_dates_problemes += date_panne;
					 valeur_dates_problemes += ',';
					 dates_probleme.val(valeur_dates_problemes);

					 var panne = jQuery("#panne"+id)[0].innerHTML;
					 valeur_problemes += panne;
					 valeur_problemes += ',';
					 problemes.val(valeur_problemes);
				 }

			 }
		 }
		}
	}

	function remove_all(){
		var list_id_radio = jQuery('#list_id_radio');
		list_id_radio.val('');

		var dates_probleme = jQuery("#dates_probleme");
		dates_probleme.val('');

		var problemes = jQuery("#problemes");
		problemes.val('');
	}

</script>

	</body>
</html>
<?php
// Fermeture connection
$mysqli->close();
?>
