<?php
$message = NULL;
if (isset($_GET['message'])) {
	$message = $_GET['message'];
}

$login = NULL;
$pwd = NULL;

if (isset($_POST['login'])) {
	$login = $_POST['login'];
}
if (isset($_POST['pwd'])) {
	$pwd = $_POST['pwd'];
}

$message_div = "";

if($message == "invalide") $message_div = "<div class='red'> Le magasin ne se trouve pas en base de données. Vérifiez votre saisie ou signalez le problème à l'admin. </div>";

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
		<link rel='stylesheet' type='text/css' href='./css/index.css' media='screen' />
		<link rel='stylesheet' type='text/css' href='./css/general.css' media='screen' />

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

<?php
$nom_societe = NULL;
$departement = NULL;

if($message == NULL){
	// Ouvre session
	session_start();

	// Récupère dans session
	if (isset($_SESSION['nom_societe'])) {
		$nom_societe = $_SESSION['nom_societe'];
	}
	if (isset($_SESSION['departement'])) {
		$departement = $_SESSION['departement'];
	}
}


if($login == NULL || $pwd == NULL){
		// if($nom_societe != NULL && $departement != NULL){
		// 	echo "";
		// }
	echo "
	<div id='popup1' class='overlay'>
	<div class='popup'>
	<div class='content'>

	<h2> $nom_societe $departement </h2>
	<h2 > Identifiez vous pour accéder à l'interface d'administration </h2>

	<div id='overlay'>
	<div id='div_message'>

	</div>
	</div>

	<form class='depart_soc' action='login.php' method='post'>
	<div class='departement'>
	<label> Login : </label>
	<input type='text' name='login' value='$login'>
	</div>

	<div class='societe'>
	<label> Mot de passe : </label>
	<input type='text' name='pwd' value='$pwd'>

</div>
<input type='submit' id='valider_modal' value='Se connecter'>
</form>
</div>
</div>
</div>
" ;
}

?>
<script type="text/javascript">
	// On affiche le message
	document.getElementById('div_message').innerHTML = "<?php echo $message_div ?>";
</script>

</body>
</html>
<?php
// Fermeture connection
$mysqli->close();
?>
