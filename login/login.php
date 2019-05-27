<?php
$login = NULL;
$pwd = NULL;

if (isset($_POST['login'])) {
	$login = $_POST['login'];
}
if (isset($_POST['pwd'])) {
	$pwd = $_POST['pwd'];
}

// Paramètres de connexion
include_once("../dbConfig.php");

// Ouverture connexion
$mysqli = new mysqli(DB_HOST, DB_LOGIN, DB_PWD, DB_NAME);

$salt = "sdK2mqlOs4dUibu8qHsmiOm6AqZs5DdkGN4KvghM3dqkfN5Dhqdm7hSFG8Kgv9qm";

// Hachage pwd
$pwd = hash("sha256", $pwd . $salt);

//COnstruction de la requete
$query_user = "SELECT * FROM `admins` WHERE `username` = '$login' AND `password` = '$pwd';";
$result_user = $mysqli->query($query_user);


if($result_user){
	$nbLignes = $result_user->num_rows;
		while ($user = $result_user->fetch_assoc()) {
			$user_id = $user['id'];
		}

	// Destruction résultat
	$result_user->close();
} else {
	$nbLignes = 0;
}


if($nbLignes == 1){
	// Ouvre session
	session_start();

	// Enregistre dans session
	$_SESSION['user_id'] = $user_id;
	$_SESSION['login'] = $login;

	header("Location: ../admin.php");
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
</head>
<body>

	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100">
				<div class="login100-pic js-tilt" data-tilt>
					<img src="images/img-01.png" alt="IMG">
				</div>

				<form class="login100-form validate-form" action="login.php" method="post" >
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

					<div class="wrap-input100 validate-input" data-validate = "Entrez votre mot de passe">
						<input class="input100" type="password" name="pwd" placeholder="Mot de passe">
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-lock" aria-hidden="true"></i>
						</span>
					</div>

					<div class="container-login100-form-btn">
						<button class="login100-form-btn">
							Login
						</button>
					</div>

					 <div class="text-center p-t-12"> <!-- TODO: Faire en sorte que l'admin puisse changer le mot de passe directement via l'application -->
						<span class="txt1">
							Changer le
						</span>
						<a class="txt2" href="change_pass.php">
							mot de passe
						</a>
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

</body>
</html>
