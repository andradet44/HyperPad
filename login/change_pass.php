<?php
$login = NULL;
$actualPwd = NULL;
$pwd = NULL;
$pwdConfirm = NULL;

if (isset($_POST['login'])) {
	$login = $_POST['login'];
}
if (isset($_POST['actualPwd'])) {
	$actualPwd = $_POST['actualPwd'];
}
if (isset($_POST['pwd'])) {
	$pwd = $_POST['pwd'];
}
if (isset($_POST['pwdConfirm'])) {
	$pwdConfirm = $_POST['pwdConfirm'];
}

$message = NULL;
if (isset($_GET['message'])) {
	$message = $_GET['message'];
}

if($message == 'loginORmdp') {$message_div = "<div class='red'> Login et/ou mot de passe invalide(s) </div>"; $type = "error";}
if($message == 'error')  {$message_div = "<div class='red'> Vérifiez votre saisie </div>"; $type = "error";}
if($message == 'mdp')  {$message_div = "<div class='red'> Les mots de passes ne correspondent pas </div>"; $type = "error";}

if($pwd != $pwdConfirm){
	header('Location: change_pass.php?message=mdp');
}

// Paramètres de connexion
include_once("../dbConfig.php");

// Ouverture connexion
$mysqli = new mysqli(DB_HOST, DB_LOGIN, DB_PWD, DB_NAME); mysqli_set_charset($mysqli, "utf8");

if($pwd == $pwdConfirm && $login != NULL && $pwd != NULL && $pwdConfirm != NULL && $actualPwd != NULL){
	$salt = "sdK2mqlOs4dUibu8qHsmiOm6AqZs5DdkGN4KvghM3dqkfN5Dhqdm7hSFG8Kgv9qm";

	// Hachage pwd
	$pwd = hash("sha256", $pwd . $salt);
	$actualPwd = hash("sha256", $actualPwd . $salt);

	//Vérification du mot de passe actuel
	$query_verify_actual_pass = "SELECT * FROM `admins` WHERE `password`='$actualPwd' AND `username` = '$login';";
	$result = $mysqli->query($query_verify_actual_pass);
	if($result){
		$nb_results = $result->num_rows;
	} else {
		$nb_results = 0;
	}

	if($nb_results > 0){
		//COnstruction de la requete
		$query_pass = "UPDATE `admins` SET `password` = '$pwd' WHERE `username` = '$login';";
		$mysqli->query($query_pass);
		$nbLignes = $mysqli->affected_rows;
	} else{
		header("Location: change_pass.php?message=loginORmdp");
	}

} else{
	$nbLignes = 0;
}

if($nbLignes > 0){
	// Ouvre session
	session_start();

	// Enregistre dans session
	$_SESSION['user_id'] = $user_id;
	$_SESSION['login'] = $login;

	header("Location: ../admin.php?message=changed");
}

// Fermeture connection
$mysqli->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
	<title>Login</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->
	<link rel="icon" type="image/png" href="images/icons/favicon.ico"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/css-hamburgers/hamburgers.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="css/util.css">
	<link rel="stylesheet" type="text/css" href="css/main.css">
<!--===============================================================================================-->
<script src="../js/sweetalert/dist/sweetalert2.all.min.js"></script>
</head>
<body>
	<div class="limiter">

		<div class="container-login100">
			<div class="wrap-login100">
				<div class="login100-pic js-tilt" data-tilt>
					<img src="images/img-01.png" alt="IMG">
				</div>

				<form class="login100-form validate-form" action="change_pass.php" method="post" >
					<span class="login100-form-title">
						<?php echo "<h2 onclick="."document.location.href="."'../index.php' style='color: red; cursor: pointer'> Ficopad Gestion </h2>"; ?>
					</span>


					<div class="wrap-input100 validate-input" data-validate = "Entrez votre nom d'utilisateur">
						<input class="input100" type="text" name="login" placeholder="Nom d'utilisateur">
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-envelope" aria-hidden="true"></i>
						</span>
					</div>

					<div class="wrap-input100 validate-input" data-validate = "Entrez votre mot de passe Actuel">
						<input class="input100" type="password" name="actualPwd" placeholder="Mot de passe Actuel">
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-lock" aria-hidden="true"></i>
						</span>
					</div>

					<div class="wrap-input100 validate-input" data-validate = "Entrez votre Nouveau mot de passe">
						<input class="input100" type="password" name="pwd" placeholder="Nouveau mot de passe">
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-lock" aria-hidden="true"></i>
						</span>
					</div>

					<div class="wrap-input100 validate-input" data-validate = "Confirmez votre mot de passe">
						<input class="input100" type="password" name="pwdConfirm" placeholder="Confirmer mot de passe">
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-lock" aria-hidden="true"></i>
						</span>
					</div>

					<div class="container-login100-form-btn">
						<button class="login100-form-btn">
							Confirmer le changement
						</button>
					</div>
				</form>
			</div>
		</div>
	</div>




<!--===============================================================================================-->
	<script src="vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/bootstrap/js/popper.js"></script>
	<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/tilt/tilt.jquery.min.js"></script>
	<script >
		$('.js-tilt').tilt({
			scale: 1.1
		})
	</script>
<!--===============================================================================================-->
	<script src="js/main.js"></script>

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
	</script>

</body>
</html>
