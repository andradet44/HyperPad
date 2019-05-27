<?php
$id_magasin = NULL;

// Ouvre session
session_start();

if (isset($_SESSION['id_magasin'])) {
	$id_magasin = $_SESSION['id_magasin'];
}

if($id_magasin == NULL){
	header("Location: index.php");
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
		<link rel='stylesheet' type='text/css' href='./css/statistiques.css' media='screen' />
		<link rel='stylesheet' type='text/css' href='./css/general.css' media='screen' />

		<!-- Encodage UTF8 pour les accents -->
		<meta charset='UTF-8'>

		<script type='text/javascript' src='./js/chartjs/dist/Chart.bundle.js'></script>
		<script type='text/javascript' src='./js/chartjs/dist/utils.js'></script>

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
					<li id="li_2" onclick="document.location.href='rechercher.php'"> Rechercher </li>
					<li id="li_3" onclick="document.location.href='problemes_radio.php'"> Signalement </li>
					<li onclick="document.location.href='statistiques.php'" style="background-color: #2098D1;"> Statistiques </li>
					<li id="li_4" onclick="document.location.href='admin.php'"> Admin </li>
				</ul>
			</ul>
		</nav>

		<h2 class="section_title"> Statistiques </h2>

		<div class="graphic_container">
			<div class='graphique graph_left'> <canvas id="canvas"></canvas> </div>
			<div class='graphique graph_right'> <canvas id="canvas1"></canvas> </div>
			<div class='graphique graphic_bottom'> <canvas id="canvas2"></canvas> </div>
		</div>

<script>
window.onload = function () {

//-----------------------------------------------------------------------------------------------------------------------//
//-------------------------------------------------GRAPHIQUE NON RENDUS--------------------------------------------------//
//-----------------------------------------------------------------------------------------------------------------------//

<?php
//Récupération du nom et prénom de l'utilisateur
$query_user_info = "SELECT * FROM `utilisateurs` WHERE `non_rendu` > 0 AND `id_magasin` = '$id_magasin';";
$result_user_info = $mysqli->query($query_user_info);

$i = 0;
$labels = "";
$data = "";

if($result_user_info){
	while ($user = $result_user_info->fetch_assoc()) {
		$nom = $user['nom'];
		$prenom = $user['prenom'];
		$non_rendu = $user['non_rendu'];

		$labels .= "'" . $nom . $prenom . "',";
		$data .= "'" . $non_rendu . "',";

		$i += 1;
		if($i >= 20) break;
	}

	$labels = substr($labels, 0, -1);
	$data = substr($data, 0, -1);

	$result_user_info->close();
?>

	var color = Chart.helpers.color;
	var horizontalBarChartData = {
	labels: [<?php echo $labels; ?>],
	datasets: [{
		label: 'Nombre de fois',
		backgroundColor: color(window.chartColors.blue).alpha(0.5).rgbString(),
		borderColor: window.chartColors.blue,
		borderWidth: 1,
		data: [<?php echo $data; ?>]
	}]
	};

	var ctx = document.getElementById('canvas').getContext('2d');
	window.myHorizontalBar = new Chart(ctx, {
		type: 'horizontalBar',
		data: horizontalBarChartData,
		options: {
			elements: {
				rectangle: {
					borderWidth: 2,
				}
			},
			responsive: true,
			legend: {
				position: 'right',
			},
			title: {
				display: true,
				text: 'Nombre de radiopads non rendus en fin de journée',
				fontSize: 28
			}
		}
	});
<?php } ?>

//-----------------------------------------------------------------------------------------------------------------------//
//-------------------------------------------------GRAPHIQUE PANNES------------------------------------------------------//
//-----------------------------------------------------------------------------------------------------------------------//
<?php

$query_pannes = "SELECT * FROM `pannes_radiopads` WHERE `id_magasin` = '$id_magasin' GROUP BY `id_radiopad`;";
$result_pannes = $mysqli->query($query_pannes);
$nbLignes = $result_pannes->num_rows;

$labels = "";
$data = "";

if($nbLignes > 0 && $result_pannes){
	while ($panne = $result_pannes->fetch_assoc()) {
		$id_radio = $panne['id_radiopad'];

		$query_nb_pannes = "SELECT COUNT(id_radiopad) AS nb_pannes FROM `pannes_radiopads` WHERE `id_radiopad` = '$id_radio';";
		$result_nb_pannes = $mysqli->query($query_nb_pannes);

		if($result_nb_pannes){
			while ($radio = $result_nb_pannes->fetch_assoc()) {
				$nb_pannes = $radio['nb_pannes'];

				$labels .= "'" . $id_radio . "',";
				$data .= "'" . $nb_pannes . "',";

			}
			$result_nb_pannes->close();
		}
	}
	$result_pannes->close();

	$labels = substr($labels, 0, -1);
	$data = substr($data, 0, -1);
?>

	var color1 = Chart.helpers.color;
	var horizontalBarChartData1 = {
	labels: [<?php echo $labels; ?>],
	datasets: [{
		label: 'Nombre de pannes',
		backgroundColor: color1(window.chartColors.red).alpha(0.5).rgbString(),
		borderColor: window.chartColors.red,
		borderWidth: 1,
		data: [<?php echo $data; ?>]
	}]
	};

	var ctx1 = document.getElementById('canvas1').getContext('2d');
	window.myHorizontalBar = new Chart(ctx1, {
		type: 'horizontalBar',
		data: horizontalBarChartData1,
		options: {
			elements: {
				rectangle: {
					borderWidth: 2,
				}
			},
			responsive: true,
			legend: {
				position: 'right',
			},
			title: {
				display: true,
				text: 'Nombre de pannes par radiopad',
				fontSize: 28
			}
		}
	});

<?php } ?>
//-----------------------------------------------------------------------------------------------------------------------//
//-------------------------------------------------GRAPHIQUE STATUS RADIOPADS--------------------------------------------//
//-----------------------------------------------------------------------------------------------------------------------//

<?php
$query_radio0 = "SELECT COUNT(`id_radio`) AS nb_status FROM `radiopads` WHERE `id_magasin` = '$id_magasin' AND `etat` = 'PROD';";
$query_radio1 = "SELECT COUNT(`id_radio`) AS nb_status FROM `radiopads` WHERE `id_magasin` = '$id_magasin' AND `etat` = 'REBUS';";
$query_radio2 = "SELECT COUNT(`id_radio`) AS nb_status FROM `radiopads` WHERE `id_magasin` = '$id_magasin' AND `etat` = 'REPARATION';";
$query_radio3 = "SELECT COUNT(`id_radio`) AS nb_status FROM `radiopads` WHERE `id_magasin` = '$id_magasin' AND `etat` = 'REPARER';";
$query_radio4 = "SELECT COUNT(`id_radio`) AS nb_status FROM `radiopads` WHERE `id_magasin` = '$id_magasin' AND `etat` = 'STOCK';";
$query_radio5 = "SELECT COUNT(`id_radio`) AS nb_status FROM `radiopads` WHERE `id_magasin` = '$id_magasin' AND `etat` = 'PERDU';";

$data = [];
$data[0] = 0; // PROD
$data[1] = 0; //REBUS
$data[2] = 0; //REPARATION
$data[3] = 0; //REPARER
$data[4] = 0; //STOCK
$data[5] = 0; //PERDU


$result_radio0 = $mysqli->query($query_radio0);
if($result_radio0){
	while ($radio = $result_radio0->fetch_assoc()) {
		$nb_status = $radio['nb_status'];
		$data[0] =  $nb_status;
	}
	$result_radio0->close();
}
$result_radio1 = $mysqli->query($query_radio1);
if($result_radio1){
	while ($radio = $result_radio1->fetch_assoc()) {
		$nb_status = $radio['nb_status'];
		$data[1] =  $nb_status;
	}
	$result_radio1->close();
}
$result_radio2 = $mysqli->query($query_radio2);
if($result_radio2){
	while ($radio = $result_radio2->fetch_assoc()) {
		$nb_status = $radio['nb_status'];
		$data[2] =  $nb_status;
	}
	$result_radio2->close();
}
$result_radio3 = $mysqli->query($query_radio3);
if($result_radio3){
	while ($radio = $result_radio3->fetch_assoc()) {
		$nb_status = $radio['nb_status'];
		$data[3] =  $nb_status;
	}
	$result_radio3->close();
}
$result_radio4 = $mysqli->query($query_radio4);
if($result_radio4){
	while ($radio = $result_radio4->fetch_assoc()) {
		$nb_status = $radio['nb_status'];
		$data[4] =  $nb_status;
	}
	$result_radio4->close();
}
$result_radio5 = $mysqli->query($query_radio5);
if($result_radio5){
	while ($radio = $result_radio5->fetch_assoc()) {
		$nb_status = $radio['nb_status'];
		$data[5] =  $nb_status;
	}
	$result_radio5->close();
}
?>

	var config = {
			type: 'pie',
			data: {
				datasets: [{
					data: [<?php
					echo $data[0] . ",";
					echo $data[1] . ",";
					echo $data[2] . ",";
					echo $data[3] . ",";
					echo $data[4] . ",";
					echo $data[5];
					?>],
					backgroundColor: [
						window.chartColors.green,
						window.chartColors.blue,
						window.chartColors.orange,
						window.chartColors.red,
						'red',
						'black',
					],
					label: 'Nombre de radiopads par status'
				}],
				labels: ['En PROD', 'En Stock', 'En Réparation', 'Au Rebus', 'A Envoyer en réparation', 'Perdu']
			},
			options: {
				responsive: true,

				title: {
					display: true,
					text: 'Nombre de radiopads par status',
					fontSize: 28
				}
			}
		};

		var ctx2 = document.getElementById('canvas2').getContext('2d');
		window.myPie = new Chart(ctx2, config);


		// On redirige vers la page d'accueil au bout de 120 000 ms = 2 minutes
		setTimeout(function() {
			document.location.href = "index.php";
		},120000);
}


</script>

	</body>
</html>
<?php
// Fermeture connection
$mysqli->close();
?>
