<?php
//Permet de faire des recherches dans la base
$search = NULL;
if (isset($_GET['search'])) {
	$search = $_GET['search'];
}

$user_code = NULL;
if (isset($_GET['user_code'])) {
	$user_code = $_GET['user_code'];
}

$radio_code = NULL;
if (isset($_GET['radio_code'])) {
	$radio_code = $_GET['radio_code'];
}

$search_date_pret = NULL;
if (isset($_GET['search_date_pret'])) {
	$search_date_pret = $_GET['search_date_pret'];
}
$search_date_pret2 = NULL;
if (isset($_GET['search_date_pret2'])) {
	$search_date_pret2 = $_GET['search_date_pret2'];
}

$search_date_retour = NULL;
if (isset($_GET['search_date_retour'])) {
	$search_date_retour = $_GET['search_date_retour'];
}
$search_date_retour2 = NULL;
if (isset($_GET['search_date_retour2'])) {
	$search_date_retour2 = $_GET['search_date_retour2'];
}

$nb_result_display = 20;
if (isset($_GET['nb_result_display'])) {
	$nb_result_display = $_GET['nb_result_display'];
}

$nom_societe = NULL;
$departement = NULL;
$id_magasin  = NULL;

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

if($nom_societe == NULL || $departement == NULL || $id_magasin  == NULL){
  header("Location: index.php");
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
		<link rel='stylesheet' type='text/css' href='./css/general.css' media='screen' />
		<link rel='stylesheet' type='text/css' href='./css/rechercher.css' media='screen' />

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
					<li id="li_2" onclick="document.location.href='rechercher.php?search=pret_jour&nb_result_display=20'" style="background-color: #2098D1;"> Rechercher </li>
					<li id="li_3" onclick="document.location.href='problemes_radio.php'"> Signalement </li><li onclick="document.location.href='statistiques.php'"> Statistiques </li>
					<li id="li_4" onclick="document.location.href='admin.php'"> Admin </li>
				</ul>
			</ul>
		</nav>

		<h2 class="section_title"> Rechercher </h2>
		<?php echo "<h2> $nom_societe $departement </h2>"; ?>

		<section class='section1'>

			<form class="form_rechercher" action="rechercher.php" method="get">
				<h1 class="division_search"> Recherches simples </h1>
				  <div class="container">
				    <input type="radio" class="hidden" id="input1" name="search" checked="checked" value="pret_jour">
				    <label class="entry" for="input1"><div class="circle"></div><div class="entry-label">Tous les prêts du jour</div></label>
				    <input type="radio" class="hidden" id="input2" name="search" value="pret_sans_retour">
				    <label class="entry" for="input2"><div class="circle"></div><div class="entry-label">Tous les prêts du jour sans retour</div></label>
				    <input type="radio" class="hidden" id="input3" name="search" value="pret_avec_retour">
				    <label class="entry" for="input3"><div class="circle"></div><div class="entry-label">Tous les prêts du jour avec retour</div></label>
				    <div class="highlight"></div>
				    <div class="overlay"></div>
					</div>

				<label class="place_holder"> Nombre de résultats à afficher : </label>
				<input class="input" name="nb_result_display"  type="number" value="<?php echo $nb_result_display ?>" min="1" style="margin-bottom: 10px; width: 50px; text-align: center">

				<input class="ok" style="display: block" type="submit" value="Rechercher">

				<h1 class="division_search"> Rechercher par date </h1>

				<label class="place_holder"> date de pret : </label>
				<input class="input" name="search_date_pret" value="<?php echo  $search_date_pret?>" placeholder="jj/mm/aaaa" type="date" style="margin-bottom: 10px; text-align: center">
				<input class="input" name="search_date_pret2" value="<?php echo  $search_date_pret2?>" placeholder="jj/mm/aaaa" type="date" style="margin-bottom: 10px; text-align: center">

				<label class="place_holder"> date de retour : </label>
				<input class="input" name="search_date_retour" value="<?php echo  $search_date_retour?>"  type="date" placeholder="jj/mm/aaaa" style="margin-bottom: 10px; text-align: center">
				<input class="input" name="search_date_retour2" value="<?php echo  $search_date_retour2?>"  type="date" placeholder="jj/mm/aaaa" style="margin-bottom: 10px; text-align: center">

				<input class="ok" style="display: block" type="submit" value="Rechercher">

				<h1 class="division_search"> Rechercher par code </h1>

				<label class="place_holder"> Nom ou code utilisateur </label>
				<input class="input" id="user" type="text" value="<?php echo  $user_code?>" name="user_code" list="userCodes" value="">

				<label class="place_holder"> Code Radiopad </label>
				<input class="input" id="radio" type="text" value="<?php echo  $radio_code?>" name="radio_code" list="radioCodes" value="">

				<!-- Liste de suggestion des codes utilisateurs -->
					<datalist id="userCodes">
<?php
											//Requete sql
											$query_users = "SELECT * FROM `utilisateurs` WHERE `id_magasin` = '$id_magasin' ORDER BY `nom`, `prenom` ASC;";
											//On lance la requete en base de données
											$result_users = $mysqli->query($query_users);

											while ($user = $result_users->fetch_assoc()) {
												echo "<option value='".$user['id']." ".$user['nom']." ".$user['prenom']."'>";
											}

											// Destruction résultat
											$result_users->close();
?>
					</datalist>

					<!-- Liste de suggestion des codes radiopads -->
					<datalist id="radioCodes">
<?php
											//Requete sql
											$query_radios = "SELECT * FROM `radiopads` WHERE `id_magasin` = '$id_magasin';";

											//On lance la requete en base de données
											$result_radios = $mysqli->query($query_radios);

											while ($radio = $result_radios->fetch_assoc()) {
												echo "<option value='".$radio['id_radio']."'>";
											}

											// Destruction résultat
											$result_radios->close();
?>
					</datalist>

				<input class="ok" style="display: block" type="submit" value="Rechercher">
			</form>


		</section>

		<section class="section2">
<?php

					echo "
					<form class='clean_search_form' action='rechercher.php' method='post'>
						<input class='clean_search ok' type='submit' value='effacer les résultats de la recherche'>
					</form>";
					// <th class='entete'> Nom </th>
					// <th class='entete'> Prénom </th>
					echo "
					<table class='tab_search avectri'>
					<thead>
						<tr class='th'>
							<th class='entete selection' data-tri='1' data-type='num'> Utilisateur </th>

							<th class='entete'> Code radio </th>
							<th class='entete'> Date prêt </th>
							<th class='entete'> Date retour </th>
						</tr>
					</thead>
					<tbody>
					";


					//Recherches par date ou codes
					if($search == "search_date_pret" && $search_date_pret != "" && $search_date_pret != NULL){
						//Transforme le format date en français en format date en anglais
						$search_date_pret = format_date($search_date_pret);

						$query_search = "SELECT * FROM `prets` WHERE `date_pret` LIKE '%$search_date_pret%' AND `id_magasin` = '$id_magasin' ORDER BY `date_pret` DESC;";

						if($search_date_pret2 != NULL){
							$search_date_pret2 = format_date($search_date_pret2);
							$query_search = "SELECT * FROM `prets` WHERE `date_pret` between '$search_date_pret 00:00:00' AND '$search_date_pret2 23:59:59'
							AND `id_magasin` = '$id_magasin' ORDER BY `date_pret` DESC;";
						}

						$msg_search = "";
					} else if($search == "search_date_retour" && $search_date_retour != "" && $search_date_retour != NULL){
						//Transforme le format date en français en format date en anglais
						$search_date_retour = format_date($search_date_retour);

						$query_search = "SELECT * FROM `prets` WHERE `date_retour` LIKE '%$search_date_retour%' AND `id_magasin` = '$id_magasin' ORDER BY `date_pret` DESC;";

						if($search_date_retour2 != NULL){
							$search_date_retour2 = format_date($search_date_retour2);
							$query_search = "SELECT * FROM `prets` WHERE `id_magasin` = '$id_magasin' AND `date_retour`
							between '$search_date_retour 00:00:00' AND '$search_date_retour2 23:59:59' ORDER BY `date_pret` DESC;";
						}


						$msg_search = "";
					} else if($search == "user_code/radio_code"){
						if($radio_code != "" && $radio_code != NULL && $user_code != "" && $user_code != NULL){
							//Recherche par code radiopad et code utilisateur
							if (preg_replace('~\D~', '', $user_code) != ""){
								$user_code = preg_replace('~\D~', '', $user_code);
								$query_search = "SELECT * FROM `prets` WHERE `id_utilisateur` = '$user_code'
								AND `id_radiopad` = '$radio_code' AND `id_magasin` = '$id_magasin' ORDER BY `date_pret` DESC";
							} else if (preg_replace('~\D~', '', $user_code) == ""){
								$query_search = "SELECT * FROM `prets` INNER JOIN `utilisateurs` ON `prets`.`id_utilisateur` = `utilisateurs`.`id`
								 WHERE `id_radiopad` = '$radio_code' AND `prets`.`id_magasin` = '$id_magasin'
								 AND (`nom` LIKE '%$user_code%' OR `prenom` LIKE '%$user_code%') ORDER BY `date_pret` DESC;";
							} else{
								$query_search = "";
							}
						} else if(($radio_code == "" || $radio_code == NULL) && $user_code != "" && $user_code != NULL){
							//Recherche par code utilisateur seulement
							if (preg_replace('~\D~', '', $user_code) != ""){
								$user_code = preg_replace('~\D~', '', $user_code);
								$query_search = "SELECT * FROM `prets` WHERE `id_utilisateur` = '$user_code' AND `id_magasin` = '$id_magasin' ORDER BY `date_pret` DESC;";
							} else if (preg_replace('~\D~', '', $user_code) == ""){
								$query_search = "SELECT * FROM `prets` INNER JOIN `utilisateurs` ON `prets`.`id_utilisateur` = `utilisateurs`.`id`
								WHERE `prets`.`id_magasin` = '$id_magasin' AND `nom` LIKE '%$user_code%' OR `prenom` LIKE '%$user_code%' ORDER BY `date_pret` DESC;";
							} else{
								$query_search = "";
							}
						} else if(($user_code == "" || $user_code == NULL) && $radio_code != "" && $radio_code != NULL){
							//Recherche par code radiopad seulement
							$query_search = "SELECT * FROM `prets` WHERE `id_radiopad` = '$radio_code' AND `id_magasin` = '$id_magasin' ORDER BY `date_pret` DESC";
						} else{
							$query_search = "";
						}
						$msg_search = "";
					} else {
						$query_search = "";
					}


					//On vérifie s'il y a eu une requete
					if($query_search != ""){
						//On lance la requete en base de données
						$result_search = $mysqli->query($query_search);
					} else {
						$result_search = "";
					}

					if($result_search != ""){
						while ($found = $result_search->fetch_assoc()) {
							echo "<tr>";
							$id_utilisateur = $found['id_utilisateur'];

							//Récupération du nom et prénom de l'utilisateur
							$query_user_info = "SELECT * FROM `utilisateurs` WHERE `id`='$id_utilisateur' AND `id_magasin` = '$id_magasin';";
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

							$id_radiopad = $found['id_radiopad'];
							$date_pret = $found['date_pret'];
							$date_retour = $found['date_retour'];

							if($date_retour == '0000-00-00 00:00:00'){
								$date_retour = "non rendu";
							}

							echo "<td class='color'> $id_utilisateur - ";
							echo "$nom ";
							echo "$prenom </td>";
							echo "<td class='color'> $id_radiopad </td>";
							echo "<td class='color'> $date_pret </td>";
							echo "<td class='color'> $date_retour </td>";


							echo "</tr>";
						}
						if($result_search) $result_search->close();
					}


					//Recherches simples
					$query_all = "SELECT * FROM `prets` ORDER BY `date_pret` DESC";
					$result_all = $mysqli->query($query_all);

					if(isset($result_all)){
						$i = 0;
						while ($all = $result_all->fetch_assoc()) {
							$actual_id = $all['id'];


							//Construction de la requete
							if($search == "pret_jour"){
								$query_search = "SELECT * FROM `prets` WHERE (SELECT DATEDIFF(CURRENT_TIMESTAMP,
									(SELECT `date_pret` FROM `prets` WHERE `id` = '$actual_id'))) = 0 AND `id` = '$actual_id'
									AND `id_magasin` = '$id_magasin' ORDER BY `date_pret` DESC;";
								$msg_search = "afficher tout";
							} else if($search == "pret_sans_retour"){
								$query_search = "SELECT * FROM `prets` WHERE (SELECT DATEDIFF(CURRENT_TIMESTAMP,
									(SELECT `date_pret` FROM `prets` WHERE `id` = '$actual_id'))) = 0 AND `id` = '$actual_id' AND
									`id_magasin` = '$id_magasin' AND `date_retour` = '0000-00-00 00:00:00' ORDER BY `date_pret` DESC;";
								$msg_search = "Afficher tous les prêts sans retour";

							} else	if($search == "pret_avec_retour"){
								$query_search = "SELECT * FROM `prets` WHERE (SELECT DATEDIFF(CURRENT_TIMESTAMP,
									(SELECT `date_pret` FROM `prets` WHERE `id` = '$actual_id'))) = 0 AND `id` = '$actual_id' AND
									`id_magasin` = '$id_magasin' AND `date_retour` != '0000-00-00 00:00:00' ORDER BY `date_pret` DESC;";
								$msg_search = "Afficher tous les prêts avec retour ";

							} else {
								$query_search = "";
							}

							//On vérifie s'il y a eu une requete
							if($query_search){
								//On lance la requete en base de données
								$result_search = $mysqli->query($query_search);
							} else {
								$result_search = "";
							}

							if($result_search != ""){
								while ($found = $result_search->fetch_assoc()) {
									$i +=1;
									echo "<tr>";
									$id_utilisateur = $found['id_utilisateur'];

									//Récupération du nom et prénom de l'utilisateur
									$query_user_info = "SELECT * FROM `utilisateurs` WHERE `id`='$id_utilisateur';";
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

									$id_radiopad = $found['id_radiopad'];
									$date_pret = $found['date_pret'];
									$date_retour = $found['date_retour'];

									if($date_retour == '0000-00-00 00:00:00'){
										$date_retour = "non rendu";
									}

									echo "<td class='color'> $id_utilisateur - ";
									echo "$nom ";
									echo "$prenom </td>";
									echo "<td class='color'> $id_radiopad </td>";
									echo "<td class='color'> $date_pret </td>";
									echo "<td class='color'> $date_retour </td>";


									echo "</tr>";
									break;
								}
								$result_search->close();
							}
							if($i >= $nb_result_display) break;
						}
						//Destruction des résultats
						$result_all->close();
					}
					echo "
					</tbody>
					</table>";




?>
		</section>

		<script type="text/javascript">
		//Permet de garder une case cochée après le rechargement de la page
		var input_radio1 = document.getElementById('input1');
		var input_radio2 = document.getElementById('input2');
		var input_radio3 = document.getElementById('input3');

		var search = "<?php echo $search?>";

		if( search == "pret_jour"){
			input_radio1.checked="checked";
		}else if(search == "pret_sans_retour"){
			input_radio2.checked="checked";
		}else if(search == "pret_avec_retour"){
			input_radio3.checked="checked";
		}

		//Permet de gérer quel type de recherche l'utilisateur fait

		//On détecte quand l'utilisateur clique
		jQuery("input").click(function() {
			var name = jQuery(this).attr("name");
			var user = document.getElementById("user");
			var radio = document.getElementById("radio");

			if(name == "search_date_pret"){
				input_radio1.value = "search_date_pret";
				input_radio2.value = "search_date_pret";
				input_radio3.value = "search_date_pret";
			} else if(name == "search_date_retour"){
				input_radio1.value = "search_date_retour";
				input_radio2.value = "search_date_retour";
				input_radio3.value = "search_date_retour";
			}else if(name == "user_code"){
				input_radio1.value = "user_code/radio_code";
				input_radio2.value = "user_code/radio_code";
				input_radio3.value = "user_code/radio_code";
			}else if(name == "radio_code"){
				input_radio1.value = "user_code/radio_code";
				input_radio2.value = "user_code/radio_code";
				input_radio3.value = "user_code/radio_code";
			}
		});

		//On détecte quand l'utilisateur écrit
		jQuery("input").on('input',function(){
			var name = jQuery(this).attr("name");
			var user = document.getElementById("user");
			var radio = document.getElementById("radio");

			if(name == "search_date_pret" || name == "search_date_pret2"){
				input_radio1.value = "search_date_pret";
				input_radio2.value = "search_date_pret";
				input_radio3.value = "search_date_pret";
			} else if(name == "search_date_retour" || name == "search_date_retour2"){
				input_radio1.value = "search_date_retour";
				input_radio2.value = "search_date_retour";
				input_radio3.value = "search_date_retour";
			}else if(name == "user_code"){
				input_radio1.value = "user_code/radio_code";
				input_radio2.value = "user_code/radio_code";
				input_radio3.value = "user_code/radio_code";
			}else if(name == "radio_code"){
				input_radio1.value = "user_code/radio_code";
				input_radio2.value = "user_code/radio_code";
				input_radio3.value = "user_code/radio_code";
			}
		});

		// On redirige vers la page d'accueil au bout de 120 000 ms = 2 minutes
		setTimeout(function() {
			document.location.href = "index.php";
		},120000);
		</script>

	</body>
</html>


<?php
function format_date($date){
	$date = explode('/',$date);
	$date = array_reverse($date);
	$date = implode('-',$date);
	return "$date";
}



// Fermeture connection
$mysqli->close();
?>
