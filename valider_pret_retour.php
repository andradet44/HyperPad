<?php
//Permet d'afficher des messages
$message = NULL;
if (isset($_GET['message'])) {
	$message = $_GET['message'];
}

$message_div = "";
$type = "";

if($message == "vide") {$message_div = "<div class='red'> Code ou Nom utilisateur/code radiopad invalide(s) </div>"; $type = "error";}
if($message == "pret") {$message_div = "<div class='green'> Prêt validé </div>"; $type = "success";}
if($message == "retour") {$message_div = "<div class='green'> Retour validé </div>"; $type = "success";}
if($message == "pas_rendu") {$message_div = "<div class='red'> Ce radiopad ne peut pas être prété/rendu par quelqu'un d'autre car il n'a pas encore été rendu </div>"; $type = "error";}

$nom_societe = NULL;
$departement = NULL;


// Ouvre session
session_start();

// Récupère dans session
if (isset($_SESSION['nom_societe'])) {
	$nom_societe = $_SESSION['nom_societe'];
}
if (isset($_SESSION['departement'])) {
	$departement = $_SESSION['departement'];
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
		<link rel='stylesheet' type='text/css' href='./css/valider_pret_retour.css' media='screen' />

		<!-- Fichiers Javascripts -->
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
				<li onclick="document.location.href='index.php'"> HyperPad Gestion </li>
				<li onclick="document.location.href='valider_pret_retour.php'" style="background-color: #2098D1;"> Valider un prêt ou un retour </li>
				<li onclick="document.location.href='rechercher.php?search=pret_jour&nb_result_display=20'"> Rechercher </li>
				<li onclick="document.location.href='problemes_radio.php'"> Signalement </li>
				<li onclick="document.location.href='statistiques.php'"> Statistiques </li>
				<li onclick="document.location.href='admin.php'"> Admin </li>
			</ul>
		</nav>
		</div>


			<h2 class="section_title"> Insérer un prêt ou un retour </h2>

<?php
			if($nom_societe != NULL && $departement != NULL){
				echo "<h2> $nom_societe $departement </h2>";


				$query_id_soc = "SELECT * FROM `magasins` WHERE `departement` = '$departement' AND `nom`='$nom_societe'";
				$result_id_soc = $mysqli->query($query_id_soc);

				if($result_id_soc){
					while ($magasin = $result_id_soc->fetch_assoc()) {
						$id_magasin = $magasin['id_magasin'];
					}
					$result_id_soc->close();
				}


			} else{
				header("Location: index.php");
			}
?>


			<form class="pret_retour" action="prets.php" method="post">
				<label id="user_label" for="user"> Code utilisateur </label>
				<input id="user" type="text" name="user_code" list="userCodes" autocomplete="off" required>
				<input style='display: none' type='text' name='page' value='valider_pret_retour.php'>

				<label  id="radio_label" for="radio"> Code Radiopad </label>
				<input  id="radio" type="text" name="radio_code" list="radioCodes" autocomplete="off" required>

				<!-- Liste de suggestion des codes utilisateurs -->
					<datalist id="userCodes">
<?php
											$fournisseurs = [];
											$i = 0;
											//Requete sql
											$query_users = "SELECT * FROM `utilisateurs` WHERE `id_magasin` = '$id_magasin' ORDER BY `nom`, `prenom` ASC;";
											//On lance la requete en base de données
											$result_users = $mysqli->query($query_users);

											while ($user = $result_users->fetch_assoc()) {
												if($user['fonction'] != 'FOURNISSEUR' && $user['fonction'] != 'REPARATEUR'){
													echo "<option value='".$user['id']." ".$user['nom']." ".$user['prenom']."'>";
												} else if($user['fonction'] == 'FOURNISSEUR'){
													$fournisseurs[$i] = $user;
													$i ++;
												}
											}

											// Destruction résultat
											$result_users->close();

											echo "<option value='-----------FOURNISSEURS---------------------------------'>";

											foreach ($fournisseurs as $user) {
												echo "<option value='".$user['id']." ".$user['nom']." ".$user['prenom']."'>";
											}
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
					<input class="valider_pret_retour" type="submit" value="Valider Prêt/Retour">
			</form>

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
						if("<?php echo $message ?>" == "pret" || "<?php echo $message ?>" == "retour"){
							document.location.href = "index.php";
						}
					}
				},5000);

				// On redirige vers la page d'accueil au bout de 120 000 ms = 2 minutes
				setTimeout(function() {
					document.location.href = "index.php";
				},120000);

			</script>

	</body>
</html>


<?php
// Fermeture connection
$mysqli->close();
?>
