<?php
//TODO: proposer que les radiopads qui sont disponibles en fonctions de leurs etat
//Permet d'afficher des messages
$message = NULL;
if (isset($_GET['message'])) {
	$message = $_GET['message'];
}

$message_div = "";
$type = "";
if($message == "insert_prob_ok") {$message_div = "<div class='green'> Votre Signalement a bien été pris en compte </div>"; $type = "success";}

$nom_societe = NULL;
$departement = NULL;


// Ouvre session
session_start();

// Recupère dans session
if (isset($_SESSION['nom_societe'])) {
	$nom_societe = $_SESSION['nom_societe'];
}
if (isset($_SESSION['departement'])) {
	$departement = $_SESSION['departement'];
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
		<link rel='stylesheet' type='text/css' href='./css/general.css' media='screen' />
		<link rel='stylesheet' type='text/css' href='./css/problemes_radio.css' media='screen' />

		<!-- Fichiers Javascripts -->
		<script type='text/javascript' src='./js/web.js'></script>
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
				<li onclick="document.location.href='valider_pret_retour.php'"> Valider un prêt ou un retour </li>
				<li onclick="document.location.href='rechercher.php?search=pret_jour&nb_result_display=20'"> Rechercher </li>
				<li onclick="document.location.href='problemes_radio.php'" style="background-color: #2098D1;"> Signalement </li>
				<li onclick="document.location.href='statistiques.php'"> Statistiques </li>
				<li onclick="document.location.href='admin.php'"> Admin </li>
			</ul>
		</nav>
		</div>


			<h2 class="section_title"> Signaler une defaillance radiopad </h2>

<?php
			if($nom_societe != NULL && $departement != NULL){
				echo "<h2> $nom_societe $departement </h2>";


				$query_id_soc = "SELECT * FROM `magasins` WHERE `departement` = '$departement' AND `nom`='$nom_societe';";
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

<section class='section1'>
				<div class="container">
					<h3> Signaler une panne Radiopad </h3>

					<form action="problemes.php" method="post">

							<label class="place_holder"> Code Radiopad </label>
							<input class="input" id="user" type="text" name="code_radio" list="radioCodes"  autocomplete="off" required>
							<input class="input" type="hidden" name="action" value="defaillance">


							<datalist id="radioCodes">
<?php
									$query_radios = "SELECT * FROM `radiopads` WHERE `id_magasin` = '$id_magasin';";

									//On lance la requete en base de donnees
									$result_radios = $mysqli->query($query_radios);

									if($result_radios){
										while ($radio = $result_radios->fetch_assoc()) {
											echo "<option value='".$radio['id_radio']."'>";
										}
										// Destruction resultat
										$result_radios->close();
									}
?>
							</datalist>

							<label class="place_holder"> Type de Signalement : </label>
							<p class="p_red"> Selectionnez le type de Signalement dans la liste ou décrire en quelques mots</p>
							<input class="input" id="user" type="text" name="type_panne" list="pannes" autocomplete="off" required>
							<datalist id="pannes">
								<optgroup label="Perdu/Retrouvé">
									<option value='Radiopad PERDU'>
									<option value='Radiopad RETROUVE'>
								</optgroup>

								<optgroup label="Matériel">
									<option value='MATERIEL : Tete laser HS'>
									<option value='MATERIEL : PB Scan / Laser'>
									<option value='MATERIEL : PB Charge Alimentation'>
									<option value='MATERIEL : Bip en continue'>
									<option value='MATERIEL : MATERIEL : PB Porte arriere'>
									<option value='MATERIEL : MATERIEL : Ecran HS'>
									<option value='MATERIEL : MATERIEL : PB Tactile'>
									<option value='MATERIEL : MATERIEL : PB Wifi'>
									<option value='MATERIEL : PB Bouton/Clavier'
									<option value='MATERIEL : PB USB'>
								</optgroup>

								<optgroup label="Logiciel">
									<option value='LOGICIEL : Impossible de demarrer l’application METI'>
									<option value='LOGICIEL : Compte utilisateur METI Desactive'>
									<option value='LOGICIEL : Je suis deconnecte de METI de façon intempestive'>
									<option value='LOGICIEL : Ne dispose pas du menu METI souhaite'>
									<option value='LOGICIEL : L’application Pricer ne fonctionne pas'>
									<option value='LOGICIEL : Ne dispose pas de l’application « meti_radiopad »'>
									<option value='LOGICIEL : Erreur Windev sur l’application « meti_radiopad »'>
									<option value='LOGICIEL : Ne dispose pas de l’outil « Vidage »'>
									<option value='LOGICIEL : Ne dispose pas de l’application PRICER'>
									<option value='LOGICIEL : Ce n’est pas le bureau Windows habituel'>
									<option value='LOGICIEL : Ça ne clique pas là ou je veux'>
								</optgroup>

							</datalist>

						<input class="ok" type="submit" value="Valider">
					</form>

				</div>
</section>

<aside>
	<img class='astuce' src="./images/astuce.png">
	<h3 > Astuces Radiopad </h3>
	<h1> Un probleme de connexion à METI sur le Radiopad ? </h1>
	<p> -> Redémarrez le Radiopad <img class='astuce1' src="./images/astuce11.png"></p>

	<p> Appuyez les 3 boutons en même temps : </p>
	<p class='yellow'> <mark> 1 + 9 + BOUTON ROUGE </mark> </p>
	<p> Pensez à vérifier le niveau de batterie. Si < à 30% ou 1 barre = Problème de connexion WIFI </p>

	<h1> Vous ne pouvez pas cliquer à l'endroit souhaité ? </h1>
	<p> -> Faire un calibrage de l'écran <img class='astuce1' src="./images/astuce22.png"></p>

	<p> Appuyez les 2 boutons en même temps : </p>
	<p> <mark> FUNC + ESC </mark> </p>
	<p> Laisser le stylet appuyé aux endroits indiqués puis valider avec le bouton "ENT" </p>
</aside>

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
				setTimeout(function(){
					if(message != ""){
						message = "";
						document.location.href = "index.php";
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
