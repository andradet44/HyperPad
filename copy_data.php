<?php
// Paramètres de connexion
include_once("dbConfig.php");

//Connexion à l'ancienne base de données pour pouvoir copier les données vers la nouvelle
// Ouverture connexion
$mysqli_old = new mysqli(DB_HOST, DB_LOGIN, DB_PWD, "hyp_mag_fic");

//Connexion à la nouvelle base de données pour pouvoir insérer les données copiées
// Ouverture connexion
$mysqli_new = new mysqli(DB_HOST, DB_LOGIN, DB_PWD, DB_NAME);


//Requete sql
$query_radios = "SELECT * FROM `radiopad`;";

//On lance la requete en base de données
$result_radios = $mysqli_old->query($query_radios);

while ($radio = $result_radios->fetch_assoc()) {
		$id_radio = $radio['Id'];
		$sn = $radio['Sn'];
		$pn = $radio['Pn'];
		$mag = $radio['Mag'];

	//Requete permettant d'insérer les données copiées
	$query_insert = "INSERT INTO `radiopads` (`id_radio`, `sn`, `pn`, `mag`) VALUES ('$id_radio', '$sn', '$pn', '$mag');";

	//On lance la requete en base de données
	$mysqli_new->query($query_insert);
}

// Destruction résultat
$result_radios->close();


///////////////On complète la base de données avec les données contenues dans le fichier excel
// sleep(5);

//Lecture du fichier excel pour compléter les données
require_once './Classes/PHPExcel/IOFactory.php';

// Chargement du fichier Excel
$objPHPExcel = PHPExcel_IOFactory::load("radiopad.xlsx");

/**
* récupération de la première feuille du fichier Excel
* @var PHPExcel_Worksheet $sheet
*/
$sheet = $objPHPExcel->getSheet(0);

echo '<table border="1">';

// On boucle sur les lignes
$line = 0;

//Permet de vérifier qu'on insère pas deux fois la même chose
$last_id_radio = 9999;

//Contiendra les données pour construire les requetes
$array_query_data = array(
	"derniere_utilisation" => "",
	"etat" => "",
	"radiopad" => "",
	"mac" => "",
	"sn" => "",
	"modele" => "",
	"date_achat" => ""
);

//On boucle sur les lignes du fichier excel
foreach($sheet->getRowIterator() as $row) {
	$i = 0;



	 //Permet de sauter la première ligne du fichier excel
	 echo '<tr>';
	 if($line != 0){
	   // On boucle sur les cellules de la ligne
	   foreach ($row->getCellIterator() as $cell) {
		 	//On compare les sn pour insérer les données manquantes à leurs bonnes places
	      echo '<td>';
				// //Récupération colonne "Dernière utilisation"
				if($i == 3){
					$derniere_utilisation = PHPExcel_Style_NumberFormat::toFormattedString($cell->getValue(), 'YYYY-MM-DD HH:i:ss');
					echo $derniere_utilisation;

					if($derniere_utilisation == null){
						$derniere_utilisation = "";
					}

					//Rempli le tableau pour pouvoir construire les requetes
					$array_query_data['derniere_utilisation'] = $derniere_utilisation;
				}

				//Récupération colonne "etat"
				if($i == 4){
					$etat = $cell->getValue();
					echo $etat;

					if($etat == null){
						$etat = "";
					}

					//Rempli le tableau pour pouvoir construire les requetes
					$array_query_data['etat'] = $etat;
				}

				//Récupération colonne "radiopad"
				if($i == 5){
					$radiopad = $cell->getValue();
					echo $radiopad;

					if($radiopad == null){
						$radiopad = "";
					}

					//Rempli le tableau pour pouvoir construire les requetes
					$array_query_data['radiopad'] = $radiopad;
				}

				//Récupération colonne "mac adresse"
				if($i == 6){
					$mac = $cell->getValue();
					echo $mac;

					if($mac == null){
						$mac = "";
					}

					//Rempli le tableau pour pouvoir construire les requetes
					$array_query_data['mac'] = $mac;
				}

				//Récupération colonne "sn"
				if($i == 7){
					$sn = $cell->getValue();
					echo $sn;

					if($sn == null){
						$sn = "";
					}

					//Rempli le tableau pour pouvoir construire les requetes
					$array_query_data['sn'] = $sn;
				}

				//Récupération colonne "modele"
				if($i == 8){
					$modele = $cell->getValue();
					echo $modele;

					if($modele == null){
						$modele = "";
					}

					//Rempli le tableau pour pouvoir construire les requetes
					$array_query_data['modele'] = $modele;
				}

				//Récupération colonne "date achat"
				if($i == 9){
					//On récupère la date et on la formate afin d'avoir un timestamp comme dans la base de données
					$date_achat = PHPExcel_Style_NumberFormat::toFormattedString($cell->getValue(), 'YYYY-MM-DD HH:i:ss');
					echo $date_achat;

					if($date_achat == null){
						$date_achat = "";
					}

					//Rempli le tableau pour pouvoir construire les requetes
					$array_query_data['date_achat'] = $date_achat;
				}

				}

	      echo '</td>';
				$i +=1;
	   }

   	echo '</tr>';

		//On met les données dans des variables pour les manipuler plus facilement
		$derniere_utilisation = $array_query_data['derniere_utilisation'];
		$etat = $array_query_data['etat'];
		$radiopad = $array_query_data['radiopad'];
		$mac = $array_query_data['mac'];
		$sn = $array_query_data['sn'];
		$modele = $array_query_data['modele'];
		$date_achat = $array_query_data['date_achat'];


		//Update de la table radiopads
		if($sn != ""){
			//Construction de la requete
			$mysqli_new->query("UPDATE `radiopads` SET `etat` = '$etat' WHERE `sn` = '$sn';");
			$mysqli_new->query("UPDATE `radiopads` SET `radiopad` = '$radiopad' WHERE `sn` = '$sn';");
			$mysqli_new->query("UPDATE `radiopads` SET `mac` = '$mac' WHERE `sn` = '$sn';");
			$mysqli_new->query("UPDATE `radiopads` SET `modele` = '$modele' WHERE `sn` = '$sn';");
			$mysqli_new->query("UPDATE `radiopads` SET `date_achat` = '$date_achat' WHERE `sn` = '$sn';");
		}


		// //Update de la table status_radiopads
		// //On fait une requete select pour avoir l'id du radiopad en question pour l'insérer dans l'autre table
		// $result_radio = $mysqli_new->query("SELECT `id_radio` FROM `radiopads` WHERE `sn` =  '$sn' AND `radiopad` ='$radiopad';");
		//
		// if($result_radio){
		// 	while ($radio = $result_radio->fetch_assoc()) {
		// 		$id_radio = $radio['id_radio'];
		// 	}
		//
		// 	//Destruction du résultat de la requete
		// 	$result_radio->close();
		// } else {
		// 	$id_radio = 'NULL';
		// }
		//
		// if($id_radio != "NULL" && $id_radio != $last_id_radio){
		// 	//Insertion des données
		// 	$mysqli_new->query("INSERT INTO `status_radiopads` (`id_radiopads`, `vidage_LAN`, `EAN`, `DHCP`, `probleme`, `date_probleme`, `date_reparation`)
		// 	VALUES ($id_radio, '$lan', '$ean', '$dhcp', '', '', '');");
		// 	$last_id_radio = $id_radio;
		// }
	}

	 $line += 1;
}
echo '</table>';


// Fermeture connection ancienne base
$mysqli_old->close();

// Fermeture connection nouvelle base
$mysqli_new->close();


echo "Transfert Terminé";
?>
