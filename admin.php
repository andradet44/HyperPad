<?php
$message = NULL;
if (isset($_GET['message'])) {
	$message = $_GET['message'];
}
$result = NULL;
if (isset($_GET['result'])) {
	$result = $_GET['result'];
}
$nb_radio = NULL;
if (isset($_GET['nb_radio'])) {
	$nb_radio = $_GET['nb_radio'];
}
$code_radio1 = NULL;
if (isset($_GET['code_radio1'])) {
	$code_radio1 = $_GET['code_radio1'];
}
$code_radio2 = NULL;
if (isset($_GET['code_radio2'])) {
	$code_radio2 = $_GET['code_radio2'];
}
$info_magasin = NULL;
if (isset($_GET['info_magasin'])) {
	$info_magasin = $_GET['info_magasin'];
}

if($message == NULL) {$message_div = ""; $type = "";}
if($message == "add_ko") {$message_div = "<div class='red'> Veuillez vérifier votre saisie </div>"; $type = "error";}
if($message == "add_fournisseur_ko") {$message_div = "<div class='red'> Le fournisseur existe déjà ou les données ne sont pas correctes </div>"; $type = "error";}
if($message == "del_ko") {$message_div = "<div class='red'> Veuillez vérifier votre saisie </div>"; $type = "error";}
if($message == "mod_ko") {$message_div = "<div class='red'> Les modifications n'ont pas été prises en compte. Veuillez vérifier votre saisie </div>"; $type = "error";}
if($message == "mag_exist") {$message_div = "<div class='red'> Le magasin que vous essayez d'ajouter existe déjà en base de données </div>"; $type = "error";}

if($message == "add_user_ok") {$message_div = "<div class='green'> Utilisateur ajouté avec succès </div>"; $type = "success";}
if($message == "add_fournisseur_ok") {$message_div = "<div class='green'> Fournisseur ajouté avec succès </div>"; $type = "success";}
if($message == "del_user_ok") {$message_div = "<div class='green'> Utilisateur supprimé avec succès </div>"; $type = "success";}
if($message == "add_radio_ok") {$message_div = "<div class='green'> Radiopad ajouté avec succès </div>"; $type = "success";}
if($message == "add_radio_plage_ok") {$message_div = "<div class='green'> $nb_radio Radiopad(s) ajouté(s) avec succès </div>"; $type = "success";}
if($message == "del_radio_ok") {$message_div = "<div class='green'> Radiopad supprimé avec succès </div>"; $type = "success";}
if($message == "add_mag_ok") {$message_div = "<div class='green'> Magasin ajouté avec succès </div>"; $type = "success";}
if($message == "del_mag_ok") {$message_div = "<div class='green'> Magasin supprimé avec succès </div>"; $type = "success";}
if($message == "sup_avant_date_ok") {$message_div = "<div class='green'> $result prêt(s) supprimé(s) avec succès  </div>"; $type = "success";}
if($message == "pas_pret") {$message_div = "<div class='red'> Aucun prêt trouvé avant cette date </div>"; $type = "info";}
if($message == "set_purge_ok") {$message_div = "<div class='green'> Le changement a été pris en compte </div>"; $type = "success";}
if($message == "mod_user") {$message_div = "<div class='green'> Les modifications apportées à l'utilisateur ont bien été enregistrées </div>"; $type = "success";}
if($message == "mod_radio") {$message_div = "<div class='green'> Les modifications apportées au Radiopad ont bien été enregistrées </div>"; $type = "success";}



///Permet de garder les champs remplis après erreur de l'utilisateur
$user_code = NULL;
if (isset($_GET['user_code'])) {
	$user_code = $_GET['user_code'];
}
$user_code_del = NULL;
if (isset($_GET['user_code_del'])) {
	$user_code_del = $_GET['user_code_del'];
}
$nom = NULL;
if (isset($_GET['nom'])) {
	$nom = $_GET['nom'];
}
$prenom = NULL;
if (isset($_GET['prenom'])) {
	$prenom = $_GET['prenom'];
}
$fonction = NULL;
if (isset($_GET['fonction'])) {
	$fonction = $_GET['fonction'];
}

$code_radio = NULL;
if (isset($_GET['code_radio'])) {
	$code_radio = $_GET['code_radio'];
}
$code_radio_del = NULL;
if (isset($_GET['code_radio_del'])) {
	$code_radio_del = $_GET['code_radio_del'];
}
$sn = NULL;
if (isset($_GET['sn'])) {
	$sn = $_GET['sn'];
}
$mac = NULL;
if (isset($_GET['mac'])) {
	$mac = $_GET['mac'];
}
$etat = NULL;
if (isset($_GET['etat'])) {
	$etat = $_GET['etat'];
}
$radiopad = NULL;
if (isset($_GET['radiopad'])) {
	$radiopad = $_GET['radiopad'];
}
$modele = NULL;
if (isset($_GET['modele'])) {
	$modele = $_GET['modele'];
}
$date_achat = NULL;
if (isset($_GET['date_achat'])) {
	$date_achat = $_GET['date_achat'];
}
$departement_add = NULL;
if (isset($_GET['departement_add'])) {
	$departement_add = $_GET['departement_add'];
}
$nom_mag = NULL;
if (isset($_GET['nom_mag'])) {
	$nom_mag = $_GET['nom_mag'];
}
$alias = NULL;
if (isset($_GET['alias'])) {
	$alias = $_GET['alias'];
}
$enseigne = NULL;
if (isset($_GET['enseigne'])) {
	$enseigne = $_GET['enseigne'];
}

$magasin = NULL;
if (isset($_GET['magasin'])) {
	$magasin = $_GET['magasin'];
}


$nom_societe = NULL;
$departement = NULL;
$id_magasin  = NULL;

// Ouvre session
session_start();

// Récupère dans session
if (isset($_SESSION['id_magasin'])) {
	$id_magasin = $_SESSION['id_magasin'];
}
if (isset($_SESSION['nom_societe'])) {
	$nom_societe = $_SESSION['nom_societe'];
}
if (isset($_SESSION['departement'])) {
	$departement = $_SESSION['departement'];
}
$nb_annees_purge = NULL;
if (isset($_SESSION['nb_annees_purge'])) {
	$nb_annees_purge = $_SESSION['nb_annees_purge'];
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
	header("Location: ./login/login.php");
}

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
		<link rel='stylesheet' type='text/css' href='./css/admin.css' media='screen' />
		<link rel='stylesheet' type='text/css' href='./css/general.css' media='screen' />

		<!-- Fichiers Javascripts -->
		<script type='text/javascript' src='./js/jquery-2.0.3.min.js'></script>
		<script type='text/javascript' src='./js/ajax.js'></script>
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
					<li id="li_4" onclick="document.location.href='parametres.php'"> Paramètres </li>
				</ul>
			</ul>
		</nav>

		<h2 class="section_title"> Admin <a class='logout' href='logOut.php'> Se déconnecter </a></h2>
<?php

			echo "<h2> $nom_societe $departement </h2>";

?>
		<section class='section1'>
			<div id="div_message">

			</div>

			  <div class="container">
					<!-- Ajouter un utilisateur -->
					<h1 class="division_search"> Utilisateurs <span class="caret"> </span></h1>
					<div class="div_forms">

						<h3> Ajouter un utilisateur </h3>

						<form  id="0" action="admin_functions.php" method="post">
							<label class="place_holder" for="fournisseur"> S'agit t'il d'un fournisseur ?
								<select class="input" id="fournisseur" name="fournisseur">
									<option value="NON"> Non </option>
									<option value="OUI"> Oui </option>
								</select>
							</label>

							<div class="two">
								<label id='label_user_code' class="place_holder" for="user"> Code utilisateur </label>
								<input class="input" id="user_code" type="text" name="user_code" value="<?php echo $user_code ?>" autocomplete="off" required>

								<label style='display: none;' class="place_holder" id="label_societe_fournisseur" for="societe_fournisseur"> Société </label>
								<input style='display: none;' class="input" id="societe_fournisseur" type="text" name="societe_fournisseur" required>

								<label class="place_holder" for="nom"> Nom</label>
								<input class="input" id="nom" type="text" name="nom" value="<?php echo $nom ?>" required>


							</div>


							<div class="two">
								<label class="place_holder" for="prenom"> Prenom</label>
								<input class="input" id="prenom" type="text" name="prenom" value="<?php echo $prenom ?>" required>

								<label id='label_fonction' class="place_holder" for="fonction"> Fonction</label>
								<select class="input" id="fonction" name="fonction" value="<?php echo $fonction ?>">
									<option value="EMPLOYE COMMERCIAL"> Employée(e) Commercial(e)</option>
									<option value="VENDEUR"> Vendeur </option>
									<option value="BOUCHEUR"> Boucheur </option>
									<option value="COMPTABLE"> Comptable </option>
									<option value="STAGIAIRE"> Stagiaire </option>

									<option value="RESP INFORMATIQUE"> Responsable Informatique </option>
									<option value="ADJ RESP INFORMATIQUE"> Adjoint Responsable Informatique </option>

									<option value="RESP CAISSE"> Responsable Caisse </option>
									<option value="ADJ RESP CAISSE"> Adjoint Responsable Caisse </option>
									<option value="HOTE CAISSE"> Hote ou Hotesse de Caisse </option>

									<option value="CHEF RAYON FRAIS"> Chef de Rayon Frais </option>
									<option value="CHEF RAYON SURGELE"> Chef de Rayon Surgelé </option>
									<option value="CHEF RAYON FRUITS LEGUMES"> Chef de Rayon Fruits et légumes </option>
									<option value="CHEF RAYON STAND"> Chef de Rayon Stand </option>
									<option value="CHEF RAYON BOULANGERIE PATISSERIE"> Chef de Rayon Boulangerie Patisserie </option>
									<option value="CHEF RAYON EPICERIE"> Chef de Rayon Epicerie </option>
									<option value="CHEF RAYON LIQUIDE"> Chef de Rayon Liquide </option>
									<option value="CHEF RAYON DPH"> Chef de Rayon DPH </option>
									<option value="CHEF RAYON TEXTILLE"> Chef de Rayon Textille </option>
									<option value="CHEF RAYON BAZAR"> Chef de Rayon Bazar </option>
									<option value="CHEF RAYON EPCS"> Chef de Rayon EPCS </option>

									<option value="ADJ CHEF RAYON FRAIS"> Adjoint Chef de Rayon Frais </option>
									<option value="ADJ CHEF RAYON SURGELE"> Adjoint Chef de Rayon Surgelé </option>
									<option value="ADJ CHEF RAYON FRUITS LEGUMES"> Adjoint Chef de Rayon Fruits et légumes </option>
									<option value="ADJ CHEF RAYON STAND"> Adjoint Chef de Rayon Stand </option>
									<option value="ADJ CHEF RAYON BOULANGERIE PATISSERIE"> Adjoint Chef de Rayon Boulangerie Patisserie </option>
									<option value="ADJ CHEF RAYON EPICERIE"> Adjoint Chef de Rayon Epicerie </option>
									<option value="ADJ CHEF RAYON LIQUIDE"> Adjoint Chef de Rayon Liquide </option>
									<option value="ADJ CHEF RAYON DPH"> Adjoint Chef de Rayon DPH </option>
									<option value="ADJ CHEF RAYON TEXTILLE"> Adjoint Chef de Rayon Textille </option>
									<option value="ADJ CHEF RAYON BAZAR"> Adjoint Chef de Rayon Bazar </option>
									<option value="ADJ CHEF RAYON EPCS"> Adjoint Chef de Rayon EPCS </option>
									<option value="DIRECTION"> Direction </option>

								</select>
							</div>


							<div class="two">
								<label id='label_secteur' class="place_holder" for="secteur"> Secteur </label>
								<select class="input" id="secteur" name="secteur">
									<option value="PGC"> PGC </option>
									<option value="APLS"> APLS </option>
									<option value="BAZAR"> Bazar </option>
									<option value="TEXTILE"> Textile </option>
									<option value="MARCHE"> Marché </option>
									<option value="EPCS"> EPCS </option>
									<option value="PRESSE"> Presse </option>
								</select>
								<input id='action_user' class="input" type="hidden" name="action" value="add_user">

							</div>

							<input class="ok" style="display: block" type="submit" value="Ajouter utilisateur">
						</form>

						<h3> Modifier les informations d'un utilisateur </h3>


						<input class="ok" onclick="document.location.href='liste_users.php'" style="display: block" type="submit" value="Lister les utilisateurs">


						<h3> Supprimer un utilisateur </h3>

						<!-- Supprimer un utilisateur -->
						<form id="1" action="admin_functions.php" method="post">
							<div class="two">
								<label class="place_holder"> Code utilisateur </label>
								<input class="input" id="user" type="text" name="user_code" list="userCodes" value="<?php echo $user_code_del ?>" autocomplete="off" required>
								<input class="input" type="hidden" name="action" value="del_user">
								<datalist id="userCodes">
<?php

										$query_users = "SELECT * FROM `utilisateurs` WHERE `id_magasin` = '$id_magasin';";

										//On lance la requete en base de données
										$result_users = $mysqli->query($query_users);

										if($result_users){
											while ($user = $result_users->fetch_assoc()) {
												echo "<option value='".$user['id']." ".$user['nom']." ".$user['prenom']."'>";
											}
											// Destruction résultat
											$result_users->close();
										}
?>
								</datalist>
							</div>

							<input class="ok" style="display: block" type="submit" value="Supprimer utilisateur">

						</form>
					</div>
				</div>

				<div class="container">
					<h1 class="division_search"> Prêts et Retours <span class="caret"> </span></h1>

					<div class="div_forms">
						<h3> Supprimer tous les prêts et Retours avant le (date) </h3>

						<form id="2" action="admin_functions.php" method="post">
							<div class="two">
								<label class="place_holder"> date </label>
								<input class="input" type="hidden" name="action" value="sup_avant_date">
								<input class="input" type="input" name="sup_avant_date" placeholder="jj/mm/aaaa" required>
							</div>


							<input class="ok" style="display: block" type="submit" value="Supprimer">
						</form>

						<h3> Supprimer tous les prêts et Retours au bout de X années </h3>

						<form id="2" action="admin_functions.php" method="post">
							<div class="two">
								<label class="place_holder"> Nombre d'années </label>
								<p style='color: red; background: white'> Une fois défini, tous les prêts et retours datant de X années ou plus seront supprimés automatiquement
									au démarrage de l'application.
								Laisser en blanc pour annuler la suppression automatique.</p>
								<input class="input" type="hidden" name="action" value="def_annees_purge">
								<input class="input" type="number" min="0" name="nb_annees" value="<?php echo $nb_annees_purge ?>">
							</div>


							<input class="ok" style="display: block" type="submit" value="Valider changement">
						</form>
					</div>
				</div>

			  <div class="container">
					<h1 class="division_search">  Radiopads <span class="caret"> </span></h1>

					<div class="div_forms">

						<h3> Défaillances et pannes </h3>

						<div class="two">
								<input onclick="document.location.href='defaillances.php'" style='background: red' class="ok" style="display: block" type="submit" value="Liste défaillances signalées">

								<input onclick="document.location.href='pannes.php'" style='background: red' class="ok" style="display: block" type="submit" value="Liste pannes">
						</div>

						<div class="two">
								<input onclick="document.location.href='historique_pannes.php'" class="ok" style="display: block" type="submit" value="Historique">
						</div>


							<h3> Supprimer toutes les pannes avant le (date) </h3>

							<form action="admin_functions.php" method="post">
								<div class="two">
									<label class="place_holder"> date: </label>
									<input class="input" type="hidden" name="action" value="sup_panne_avant_date">
									<input class="input" type="input" name="sup_panne_avant_date" placeholder="jj/mm/aaaa" required>
								</div>
								<input class="ok" style="display: block" type="submit" value="Supprimer">
							</form>

						<h3> Ajouter un Radiopad </h3>

						<form id="3" action="admin_functions.php" method="post">
							<div class="two">
								<label class="place_holder"> Code radiopad </label>
								<input id='code_radio' class="input" type="text" name="code_radio" value="<?php echo $code_radio ?>" autocomplete="off" required>

								<label class="place_holder"> SN </label>
								<input class="input" type="text" name="sn" value="<?php echo $sn ?>" required>

							</div>

							<div class="two">
								<label class="place_holder"> Modèle </label>
								<input class="input" type="text" name="modele" list="modeles" value="<?php echo $modele ?>">
								<datalist id="modeles">
<?php
									$query_modeles = "SELECT * FROM `radiopads` WHERE `id_magasin` = '$id_magasin' GROUP BY `modele`;";

									//On lance la requete en base de données
									$result_modeles = $mysqli->query($query_modeles);

									if($result_modeles){
										while ($radio = $result_modeles->fetch_assoc()) {
											echo "<option value='".$radio['modele']."'>";
										}
										// Destruction résultat
										$result_modeles->close();
									}
?>
								</datalist>

								<label class="place_holder"> Date d'achat </label>
								<input class="input" type="date" placeholder="jj/mm/aaaa" name="date_achat" value="<?php echo $date_achat ?>">
							</div>

							<div class="two">
								<label class="place_holder"> Etat </label>
								<select class='input' name='etat' value='<?php echo $etat ?>'>
									<option value='PROD'> En PROD </option>
									<option value='STOCK'> En Stock </option>
									<option value='REPARATION'> En Réparation </option>
									<option value='REBUS'> Au Rebus </option>
									<option value='REPARER'> A Envoyer en réparation </option>
								</select>

							</div>

							<div class="two">
								<label class="place_holder"> Adresse MAC </label>
								<input class="input" type="text" name="mac" value="<?php echo $mac ?>">
								<input class="input" type="hidden" name="action" value="add_radio">
							</div>

							<input class="ok" style="display: block" type="submit" value="Ajouter Radiopad">
						</form>

						<h3> Ajouter une plage de Radiopads </h3>

						<form id="4" action="admin_functions.php" method="post">
							<div class="two">
								<label class="place_holder"> De </label>
								<input class="input" type="number" min="0" name="code_radio1" value="<?php echo $code_radio1; ?>" required>
							</div>

							<div class="two">
								<label class="place_holder"> Jusqu'à </label>
								<input class="input" type="number" min="0" name="code_radio2" value="<?php echo $code_radio2; ?>" required>

								<input class="input" type="hidden" name="action" value="add_plage_radio">

							</div>

							<input class="ok" style="display: block" type="submit" value="Ajouter Radiopads">
						</form>

						<h3> Modifier les informations d'un Radiopad </h3>

							<input class="ok" style="display: block;" type="submit" onclick="document.location.href='liste_radio.php'" value="Lister les Radiopads">

						<h3> Installation d'un Radiopad </h3>

							<input class="ok" style="display: block;" type="submit" onclick="document.location.href='Installation.php'" value="Installation d'un Radiopad">


						<h3> Supprimer un Radiopad </h3>

						<form id="5" action="admin_functions.php" method="post">
							<div class="two">
								<label class="place_holder"> Code Radiopad </label>
								<input class="input" id="radio" type="text" name="code_radio" list="radioCodes" value="<?php echo $code_radio_del; ?>" required>
								<input class="input" type="hidden" name="action" value="del_radio">


								<datalist id="radioCodes">
	<?php
										$query_radios = "SELECT * FROM `radiopads` WHERE `id_magasin` = '$id_magasin';";

										//On lance la requete en base de données
										$result_radios = $mysqli->query($query_radios);

										if($result_radios){
											while ($radio = $result_radios->fetch_assoc()) {
												echo "<option value='".$radio['id_radio']."'>";
											}
											// Destruction résultat
											$result_radios->close();
										}
	?>
								</datalist>
							</div>

							<input class="ok" style="display: block" type="submit" value="Supprimer Radiopad">
						</form>


					</div>
					</div>
				</div>

				<div class="container">
					<h1 class="division_search">  Magasins <span class="caret"> </span></h1>

					<div class="div_forms">
						<h3> Ajouter un Magasin </h3>

						<form id="6" action="admin_functions.php" method="post">
							<div class="two">
								<label class="place_holder"> Département </label>
								<input class="input" type="input" name="departement" value="<?php echo $departement_add ?>" required>

								<label class="place_holder"> Nom </label>
								<input class="input" type="input" name="nom_mag" value="<?php echo $nom_mag ?>" required>

							</div>

							<div class="two">
								<label class="place_holder"> Alias </label>
								<input class="input" type="input" name="alias" value="<?php echo $alias ?>" required>

								<label class="place_holder"> Enseigne </label>
								<input class="input" type="input" name="enseigne" value="<?php echo $enseigne ?>" required>
								<input class="input" type="hidden" name="action" value="add_mag">
							</div>

							<input class="ok" style="display: block" type="submit" value="Ajouter Magasin">
						</form>

						<h3> Supprimer un Magasin </h3>

						<form id="form_supp_mag" onsubmit="if(shown == false) {confirm_form(); return false;} else{return true}" action="admin_functions.php" method="post">
							<div class="two">
								<label class="place_holder"> Magasin </label>
								<input class="input" id="id_magasin" type="text" name="info_magasin" list="magasins" value="<?php echo $info_magasin; ?>" autocomplete="off" required>
								<input class="input" type="hidden" name="action" value="del_mag">


								<datalist id="magasins">
	<?php
										$query_magasins = "SELECT * FROM `magasins`;";

										//On lance la requete en base de données
										$result_magasins = $mysqli->query($query_magasins);

										if($result_magasins){
											while ($magasin = $result_magasins->fetch_assoc()) {
												$id = $magasin['id_magasin'];
												$departement = $magasin['departement'];
												$nom = $magasin['nom'];

												echo "<option value='$id - $nom $departement'>";
											}
											// Destruction résultat
											$result_magasins->close();
										}
	?>
								</datalist>
							</div>

							<input class="ok"  style="display: block;" type="button" onclick='show_message()' value="Supprimer Magasin">
							<!-- <button  class="ok" style="display: block; margin-left: 30px; margin-top: 30px;" type="button" name="button">  </button> -->

						</form>

					</div>
				</div>

		</section>

		<div id='message' id='popup1' class='overlay'>
			<div class='popup'>
				<div class='content'>
					<h2> En supprimant un magasin, vous supprimez aussi toutes les données liées a celui-ci. </h2>
					<h2> Voulez-vous continuer ? </h2>

					<input onclick='confirm_form()' class="ok" style="display: inline-block; background: red" type="submit" value="Confirmer">
					<input onclick='hide_message()' class="ok" style="display: inline-block" type="submit" value="Annuler">
				</div>
			</div>
		</div>

<script type="text/javascript">
	shown = false;
	sent = false;
	message = jQuery("#message");
	message.hide();

	function show_message(key){
	console.log('show');
		var valeur = jQuery("#id_magasin").val();
		if(valeur == ''){

		} else {
			var message = jQuery("#message");
			message.show();
			shown = true;
		}
	}

	function hide_message(){
		var message = jQuery("#message");
		message.hide();
		shown = false;
	}

	function confirm_form(){
		if(shown == false){
			console.log('false');
			shown = true;
			show_message();
		} else if(sent == false){
			var formulaire = jQuery("#form_supp_mag");
			formulaire.submit();
			sent = true;
		}
	}

	if(!"<?php echo $message_div; ?>"){
		jQuery("h1").parent().children('div').toggle();
	}

	jQuery("h1").click(function() {
		// //Plier/Déplier les parties
		jQuery(this).parent().children('div').toggle();

		//Fait tourner la fleche
		var toggler = jQuery(this).children('span');
		var i;

		for (i = 0; i < toggler.length; i++) {
				toggler[i].classList.toggle("caret-down");
		}
	});

	jQuery("#fournisseur").click(function() {
		var valeur = jQuery(this).val();
		var code_user = 	jQuery("#user_code");
		var label_code_user = jQuery("#label_user_code");

		var fonction = 	jQuery("#fonction");
		var label_fonction = jQuery("#label_fonction");

		var secteur = 	jQuery("#secteur");
		var label_secteur = jQuery("#label_secteur");

		var nom = jQuery("#nom");
		var prenom = jQuery("#prenom");

		var label_societe_fournisseur = jQuery("#label_societe_fournisseur");
		var societe_fournisseur = jQuery("#societe_fournisseur");

		var action_user = jQuery("#action_user");

		if(valeur == "OUI"){
			action_user.val('add_fournisseur');

			code_user.hide();
			code_user.removeAttr('required');
			label_code_user.hide();

			fonction.hide();
			fonction.removeAttr('required');
			label_fonction.hide();

			secteur.hide();
			secteur.removeAttr('required');
			label_secteur.hide();

			nom.removeAttr('required');
			prenom.removeAttr('required');

			label_societe_fournisseur.show();
			societe_fournisseur.show();
		} else if(valeur == "NON"){
			action_user.val('add_user');

			code_user.show();
			code_user.attr('required', '');
			label_code_user.show();

			fonction.show();
			fonction.attr('required', '');
			label_fonction.show();

			secteur.show();
			secteur.attr('required', '');
			label_secteur.show();

			nom.attr('required', '');
			prenom.attr('required', '');

			label_societe_fournisseur.hide();
			societe_fournisseur.hide();
		}
	});


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
