<?php
//Variables globales
$id_magasin  = NULL;

$first_config = NULL;
if (isset($_GET['first_config'])) {
	$first_config = $_GET['first_config'];
}

// Ouvre session
session_start();
// Récupère dans session
if (isset($_SESSION['id_magasin'])) {
	$id_magasin = $_SESSION['id_magasin'];
	$alias_magasin = $_SESSION['alias_magasin'];
} else {
	if($first_config == NULL){
		header("Location: index.php");
	}
}

$action = NULL;
if (isset($_POST['action'])) {
	$action = $_POST['action'];
}
if (isset($_GET['action'])) {
	$action = $_GET['action'];
}

// Paramètres de connexion
include_once("dbConfig.php");

// Ouverture connexion
$mysqli = new mysqli(DB_HOST, DB_LOGIN, DB_PWD, DB_NAME); mysqli_set_charset($mysqli, "utf8");


if($action == "add_fournisseur"){
	add_fournisseur();
} else if($action == "sup_avant_date"){
	sup_avant_date();
} else if($action == "mod_mag_base"){
	mod_mag_base();
} else if($action == "add_rep"){
	add_rep();
} else if($action == "def_annees_purge"){
	def_annees_purge();
} else if($action == "add_user"){
	add_user();
} else if($action == "del_user" || $action == "del_rep"){
	del_user();
} else if($action == "add_radio"){
	add_radio();
} else if($action == "del_radio"){
	del_radio();
} else if($action == "add_mag"){
	add_mag();
} else if($action == "del_mag"){
	del_mag();
} else if($action == "add_plage_radio"){
	add_plage_radio();
} else if($action == "mod_user" || $action == "mod_radio"){
	modifications();
} else if($action == "mod_user_base"){
	mod_user_base();
} else if($action == "mod_radio_base"){
	mod_radio_base();
} else if($action == "sup_panne_avant_date"){
	sup_panne_avant_date();
}


function mod_mag_base(){
	global $mysqli;


	$adresse_mag = NULL;
	if (isset($_POST['adresse_mag'])) {
		$adresse_mag = $_POST['adresse_mag'];
		$adresse_mag = strtoupper($adresse_mag);
	}

	$id_mag = NULL;
	if (isset($_POST['id_mag'])) {
		$id_mag = $_POST['id_mag'];
	}

	if($id_mag == NULL){
		header("Location: liste_mag.php?message=error");
	} else{
		$query_update = "UPDATE `magasins` SET `adresse` = '$adresse_mag' WHERE `id_magasin` = '$id_mag';";
		$result = $mysqli->query($query_update);
		if($result){
			header("Location: liste_mag.php?message=success");
		} else{
			header("Location: liste_mag.php?message=error");
		}
	}
}

function format_date($date){
	$date = explode('/',$date);
	$date = array_reverse($date);
	$date = implode('-',$date);
	return "$date";
}

function add_fournisseur(){
	global $id_magasin, $mysqli;

	$societe_fournisseur = NULL;
	if (isset($_POST['societe_fournisseur'])) {
		$societe_fournisseur = $_POST['societe_fournisseur'];
		$societe_fournisseur = strtoupper($societe_fournisseur);
	}
	$nom = NULL;
	if (isset($_POST['nom'])) {
		$nom = $_POST['nom'];
		$nom = strtoupper($nom);
	}
	$prenom = NULL;
	if (isset($_POST['prenom'])) {
		$prenom = $_POST['prenom'];
	}


	if($societe_fournisseur == NULL){
		header("Location: admin.php?message=add_ko");
	} else {
		if($nom == NULL){
			$nom = $societe_fournisseur;
		}

		$query_verify_exist = "SELECT * FROM `utilisateurs` WHERE `nom` = '$nom' AND `prenom` = '$prenom' AND `fonction` =  'FOURNISSEUR' AND `id_magasin` = '$id_magasin';";
		$result_verify = $mysqli->query($query_verify_exist);
		if($result_verify){
			$nb_results = $result_verify->num_rows;
			$result_verify->close();
		} else {
			$nb_results = 0;
		}

		if($nb_results == 0){
			$query_insert_user = "INSERT INTO `utilisateurs` (`id`, `nom`, `prenom`, `fonction`, `secteur`, `id_magasin`, `non_rendu`)
			VALUES (NULL, '$nom', '$prenom', 'FOURNISSEUR', '$societe_fournisseur', '$id_magasin', '0');";
			$result = $mysqli->query($query_insert_user);
		} else{
			header("Location: admin.php?message=add_fournisseur_ko");
		}



		if($result){
			header("Location: admin.php?message=add_fournisseur_ok");
		}

	}
}

function add_rep(){
	global $id_magasin, $mysqli;

	$nom_rep = NULL;
	if (isset($_POST['nom_rep'])) {
		$nom_rep = $_POST['nom_rep'];
		$nom_rep = strtoupper($nom_rep);
	}
	$mail_rep = NULL;
	if (isset($_POST['mail_rep'])) {
		$mail_rep = $_POST['mail_rep'];
	}
	$adresse_rep = NULL;
	if (isset($_POST['adresse_rep'])) {
		$adresse_rep = $_POST['adresse_rep'];
		$adresse_rep = strtoupper($adresse_rep);
	}


	if($nom_rep == NULL){
		header("Location: admin.php?message=add_ko");
	} else {

		$query_verify_exist = "SELECT * FROM `utilisateurs` WHERE `nom` = '$nom_rep' AND `fonction` =  'REPARATEUR' AND `secteur` = '$nom_rep' AND`id_magasin` = '$id_magasin';";
		$result_verify = $mysqli->query($query_verify_exist);
		if($result_verify){
			$nb_results = $result_verify->num_rows;
			$result_verify->close();
		} else {
			$nb_results = 0;
		}

		if($nb_results == 0){
			$query_insert_user = "INSERT INTO `utilisateurs` (`id`, `nom`, `fonction`, `secteur`, `email`, `adresse`, `id_magasin`, `non_rendu`)
			VALUES (NULL, '$nom_rep', 'REPARATEUR', '$nom_rep', '$mail_rep', '$adresse_rep','$id_magasin', '0');";
			$result = $mysqli->query($query_insert_user);
		} else{
			header("Location: admin.php?message=add_rep_ko");
		}



		if($result){
			header("Location: admin.php?message=add_rep_ok");
		}

	}
}

function sup_avant_date(){
	global $id_magasin, $mysqli, $first_config;
	$sup_avant_date = NULL;

	if (isset($_GET['nb_annees'])) {
		$nb_annees = $_GET['nb_annees'];
		$sup_avant_date = date('d/m/Y', strtotime('-' . $nb_annees . ' year'));
		$sup_avant_date = format_date($sup_avant_date);
	} else{
		if (isset($_POST['sup_avant_date'])) {
			$sup_avant_date = $_POST['sup_avant_date'];
			$sup_avant_date = format_date($sup_avant_date);
		}
	}


	if($sup_avant_date == NULL){
		if($first_config == NULL){
			header("Location: admin.php?message=del_ko");
		} else{
			header("Location: index.php");
		}
	} else {
		$query_sup_avant_date = "DELETE FROM `prets` WHERE `id_magasin`='$id_magasin' AND `date_pret` <= '$sup_avant_date 23:59:59';";
		$result = $mysqli->query($query_sup_avant_date);

		$nbLignes = $mysqli->affected_rows;


		if($result && $nbLignes != 0){
			if($first_config == NULL){
				header("Location: admin.php?message=sup_avant_date_ok&result=$nbLignes");
			} else{
				header("Location: index.php");
			}
		} else{
			if($first_config == NULL){
				header("Location: admin.php?message=pas_pret");
			} else{
				header("Location: index.php");
			}
		}

	}
}

function def_annees_purge(){
	global $id_magasin, $mysqli;

	if (isset($_POST['nb_annees'])) {
		$nb_annees = $_POST['nb_annees'];
	}

	if($nb_annees == "") $nb_annees = "NULL";

	$_SESSION['nb_annees_purge'] = $nb_annees;

	$query_set_nb_purge = "UPDATE `parametres` SET `nombre_annees_purge` = '$nb_annees' WHERE `id_magasin` = '$id_magasin';";
	$result = $mysqli->query($query_set_nb_purge);


	if($result){
		header("Location: admin.php?message=set_purge_ok");
	} else{
		header("Location: admin.php");
	}

}

function add_user(){
	global $action, $id_magasin, $mysqli;

	$user_code = NULL;
	if (isset($_POST['user_code'])) {
		$user_code = $_POST['user_code'];
	}
	$nom = NULL;
	if (isset($_POST['nom'])) {
		$nom = $_POST['nom'];
		$nom = strtoupper($nom);
	}
	$prenom = NULL;
	if (isset($_POST['prenom'])) {
		$prenom = $_POST['prenom'];
	}
	$fonction = NULL;
	if (isset($_POST['fonction'])) {
		$fonction = $_POST['fonction'];
	}
	$secteur = NULL;
	if (isset($_POST['secteur'])) {
		$secteur = $_POST['secteur'];
	}
	$non_rendu = 0;
	if (isset($_POST['non_rendu'])) {
		$non_rendu = $_POST['non_rendu'];
	}
	$mail_user = 0;
	if (isset($_POST['mail_user'])) {
		$mail_user = $_POST['mail_user'];
	}

	if(($user_code == NULL || $nom == NULL || $prenom == NULL || $id_magasin == NULL || $fonction == NULL) && $action != 'mod_user_base'){
		header("Location: admin.php?message=add_ko&user_code=$user_code&nom=$nom&prenom=$prenom&fonction=$fonction&secteur=$secteur&id_magasin=$id_magasin&mail_user=$mail_user");
	} else{
		$query_insert_user = "INSERT INTO `utilisateurs` (`id`, `nom`, `prenom`, `fonction`, `secteur`, `email`, `id_magasin`, `non_rendu`)
		VALUES ('$user_code', '$nom', '$prenom', '$fonction', '$secteur', '$mail_user', '$id_magasin', '$non_rendu');";
		$result = $mysqli->query($query_insert_user);


		if($result){
			if($action == "mod_user_base"){
				//Quand il s'agit d'une modifications de données pour un utilisateur
				header("Location: liste_users.php?message=success");
			} else {
				//Quand il s'agit d'une insertion de données pour un utilisateur
				header("Location: admin.php?message=add_user_ok");
			}
		} else{
			header("Location: admin.php?message=add_ko&user_code=$user_code&nom=$nom&prenom=$prenom&fonction=$fonction&secteur=$secteur&id_magasin=$id_magasin&mail_user=$mail_user");
		}
	}
}

function del_user(){
	global $id_magasin, $mysqli, $action;

	$user_code = NULL;
	$user_code2 = NULL;
	if($action == 'del_rep'){
		if (isset($_POST['id_rep'])) {
			$user_code = $_POST['id_rep'];
			//Récupération des nombres dans la chaine de charactères
			$user_code2 = preg_replace('~\D~', '', $user_code);
		}
	} else{
		if (isset($_POST['user_code'])) {
			$user_code = $_POST['user_code'];
			//Récupération des nombres dans la chaine de charactères
			$user_code2 = preg_replace('~\D~', '', $user_code);
		}
	}

	if($user_code == NULL || $id_magasin == NULL){
		header("Location: admin.php?message=del_ko&user_code_del=$user_code&magasin=$id_magasin");
	} else{
		$query_del_user = "DELETE FROM `utilisateurs` WHERE `utilisateurs`.`id` = '$user_code2' AND `id_magasin`='$id_magasin';";
		$result = $mysqli->query($query_del_user);
		$nbLignes = $mysqli->affected_rows;

		if($action == 'mod_user_base'){
			header("Location: liste_users.php");
		}

		if($result && $nbLignes != 0){
			if($action == "del_rep"){
				header("Location: admin.php?message=del_rep_ok");
			} else {
				header("Location: admin.php?message=del_user_ok");
			}
		} else{
			header("Location: admin.php?message=del_ko&user_code_del=$user_code&magasin=$id_magasin");
		}
	}
}

function add_radio(){
	global $alias_magasin, $id_magasin, $mysqli;

	$code_radio = NULL;
	if (isset($_POST['code_radio'])) {
		$code_radio = $_POST['code_radio'];
	}

	$radiopad = "$alias_magasin"."$code_radio";

	$sn = NULL;
	if (isset($_POST['sn'])) {
		$sn = $_POST['sn'];
	}
	$mac = NULL;
	if (isset($_POST['mac'])) {
		$mac = $_POST['mac'];
	}

	$etat = NULL;
	if (isset($_POST['etat'])) {
		$etat = $_POST['etat'];
	}
	$modele = NULL;
	if (isset($_POST['modele'])) {
		$modele = $_POST['modele'];
		$modele = strtoupper($modele);
	}
	$date_achat = NULL;
	if (isset($_POST['date_achat'])) {
		$date_achat = $_POST['date_achat'];
		$date_achat = format_date($date_achat);
	}

	if($code_radio == NULL || $sn == NULL || $id_magasin == NULL){
		header("Location: admin.php?message=add_ko&code_radio=$code_radio&sn=$sn&etat=$etat&mac=$mac&modele=$modele&date_achat=$date_achat&magasin=$id_magasin");
	} else{
		$query_insert_radio = "INSERT INTO `radiopads` (`id_radio`, `sn`, `radiopad`,
			`mac`, `etat`, `modele`, `date_achat`, `id_magasin`)
			VALUES ('$code_radio', '$sn', '$radiopad', '$mac', '$etat', '$modele',
				'$date_achat', '$id_magasin');";
		$result = $mysqli->query($query_insert_radio);


		if($result){
				header("Location: admin.php?message=add_radio_ok");
		} else{
			header("Location: admin.php?message=add_ko&code_radio=$code_radio&sn=$sn&pn=$pn&etat=$etat&mac=$mac&modele=$modele&date_achat=$date_achat&magasin=$id_magasin");
		}
	}

}

function add_plage_radio(){
	global $id_magasin, $mysqli;

	$code_radio1 = NULL;
	if (isset($_POST['code_radio1'])) {
		$code_radio1 = $_POST['code_radio1'];
	}
	$code_radio2 = NULL;
	if (isset($_POST['code_radio2'])) {
		$code_radio2 = $_POST['code_radio2'];
	}


	if($code_radio1 == NULL || $code_radio2 == NULL ){
		header("Location: admin.php?message=add_ko&code_radio1=$code_radio1&code_radio2=$code_radio2");
	} else{
		$n = 0;
		for ($i=$code_radio1; $i <= $code_radio2; $i++) {
			//On vérifie si le radiopad existe déjà
			$query_verify_exist = "SELECT * FROM `radiopads` WHERE `id_radio` = '$i' AND `id_magasin` = '$id_magasin';";
			$result_verify = $mysqli->query($query_verify_exist);
			if($result_verify){
				$nb_results = $result_verify->num_rows;
				$result_verify->close();
			} else {
				$nb_results = 0;
			}

			if($nb_results == 0){
				$query_insert_user = "INSERT INTO `radiopads` (`id_radio`, `etat`, `date_achat`, `id_magasin`) VALUES ('$i', 'PROD',  '0', '$id_magasin');";
				$result = $mysqli->query($query_insert_user);
			}

			if($result) $n +=1;
		}

		header("Location: admin.php?message=add_radio_plage_ok&nb_radio=$n");
	}

}

function del_radio(){
	global $id_magasin, $mysqli;

	$code_radio = NULL;
	if (isset($_POST['code_radio'])) {
		$code_radio = $_POST['code_radio'];
	}

	if($code_radio == NULL || $id_magasin == NULL){
		header("Location: admin.php?message=del_ko&code_radio_del=$code_radio&magasin=$id_magasin");
	} else{
		$query_del_radio = "DELETE FROM `radiopads` WHERE `id_radio` = '$code_radio' AND `id_magasin`='$id_magasin';";
		$result = $mysqli->query($query_del_radio);

		$query_del_radio_pannes = "DELETE FROM `pannes_radiopads` WHERE `id_radiopad` = '$code_radio' AND `id_magasin`='$id_magasin';";
		$mysqli->query($query_del_radio_pannes);

		if($result){
			header("Location: admin.php?message=del_radio_ok");
		} else{
			header("Location: admin.php?message=del_ko&code_radio_del=$code_radio&magasin=$id_magasin");
		}
	}

}

function add_mag(){
	global $mysqli;

	$departement_add = NULL;
	if (isset($_POST['departement'])) {
		$departement_add = $_POST['departement'];
		$departement_add = strtoupper($departement_add);
	}
	$nom_mag = NULL;
	if (isset($_POST['nom_mag'])) {
		$nom_mag = $_POST['nom_mag'];
		$nom_mag = strtoupper($nom_mag);
	}
	$alias = NULL;
	if (isset($_POST['alias'])) {
		$alias = $_POST['alias'];
		$alias = strtoupper($alias);
	}
	$adresse = NULL;
	if (isset($_POST['adresse'])) {
		$adresse = $_POST['adresse'];
	}
	$enseigne = NULL;
	if (isset($_POST['enseigne'])) {
		$enseigne = $_POST['enseigne'];
	}

	if($departement_add == NULL || $nom_mag == NULL || $alias == NULL || $enseigne == NULL){
		header("Location: admin.php?message=add_ko&&departement_add=$departement_add&nom_mag=$nom_mag&alias=$alias&enseigne=$enseigne&adresse=$adresse");
	} else {

		$query_verify_exist = "SELECT * FROM `magasins` WHERE `departement` = '$departement_add' AND `nom` = '$nom_mag';";
		$result_verify_exist = $mysqli->query($query_verify_exist);

		if($result_verify_exist){
			$nb_results = $result_verify_exist->num_rows;
		} else{
			$nb_results = 0;
		}
		if($nb_results >= 1){
			header("Location: admin.php?message=mag_exist");
		} else{
			//On ajoute un symbole qui permettra de gerer les sauts de lignes quand on Récupère dans la base de données
			// echo $adresse; exit;

			$query_insert_mag = "INSERT INTO `magasins` (`id_magasin`, `departement`, `adresse`, `alias`, `nom`, `enseigne`)
			VALUES (NULL, '$departement_add', '$adresse', '$alias', '$nom_mag', '$enseigne');";
			$result = $mysqli->query($query_insert_mag);

			if($result){
				$query_mag = "SELECT * FROM `magasins` WHERE `departement` = '$departement_add' AND `nom` = '$nom_mag';";
				$result_mag = $mysqli->query($query_mag);

				if($result_mag){
					while ($mag = $result_mag->fetch_assoc()) {
						$id_mag = $mag['id_magasin'];
						$alias_mag = $mag['alias'];
						$alias_mag = strtolower($alias_mag);

						//Création du compte admin
						$query_insert_admin = "INSERT INTO `admins` (`id`, `username`, `password`, `id_magasin`)
						VALUES ('$id_mag', 'admin$alias_mag', '8eded9ebe2cb7b95a17ddf4ef619d4671794f4ab8b03b2009ef0b43db9f3ea11', '$id_mag');";
						$mysqli->query($query_insert_admin);
					}
				}

				header("Location: admin.php?message=add_mag_ok");
			} else{
						header("Location: admin.php?message=add_ko&&departement_add=$departement_add&nom_mag=$nom_mag&alias=$alias&enseigne=$enseigne&adresse=$adresse");
			}
		}

	}

}

function del_mag(){
	global $mysqli;

	$info_magasin = NULL;
	if (isset($_POST['info_magasin'])) {
		$info_magasin = $_POST['info_magasin'];
		$info_magasin = preg_replace('~\D~', '', $info_magasin);
	}

	if($info_magasin == NULL){
		header("Location: admin.php?message=add_ko&info_magasin=$info_magasin");
	} else {
		//Suppression de l'admin lié au magasin
		$query_del_admin = "DELETE FROM `admins` WHERE `id_magasin` = '$info_magasin';";
		$mysqli->query($query_del_admin);

		//Suppression des défaillances liées au magasin
		$query_del_deffaillances = "DELETE FROM `defaillances_radiopads` WHERE `id_magasin` = '$info_magasin';";
		$mysqli->query($query_del_deffaillances);

		//Suppression des pannes liées au magasin
		$query_del_pannes = "DELETE FROM `pannes_radiopads` WHERE `id_magasin` = '$info_magasin';";
		$mysqli->query($query_del_pannes);

		//Suppression des parametres liées au magasin
		$query_del_parametres = "DELETE FROM `parametres` WHERE `id_magasin` = '$info_magasin';";
		$mysqli->query($query_del_parametres);

		//Suppression des prets liées au magasin
		$query_del_prets = "DELETE FROM `prets` WHERE `id_magasin` = '$info_magasin';";
		$mysqli->query($query_del_prets);

		//Suppression des radiopads liées au magasin
		$query_del_radiopads = "DELETE FROM `radiopads` WHERE `id_magasin` = '$info_magasin';";
		$mysqli->query($query_del_radiopads);

		//Suppression des utilisateurs liées au magasin
		$query_del_utilisateurs = "DELETE FROM `utilisateurs` WHERE `id_magasin` = '$info_magasin';";
		$mysqli->query($query_del_utilisateurs);

		$query_del_mag = "DELETE FROM `magasins` WHERE `id_magasin` = '$info_magasin';";
		$result = $mysqli->query($query_del_mag);

		if($result){
			header("Location: admin.php?message=del_mag_ok");
		} else{
			header("Location: admin.php?message=add_ko&info_magasin=$info_magasin");
		}
	}
}

function modifications(){
	global $action, $id_magasin, $mysqli;

	$user_code = NULL;
	if (isset($_POST['user_code'])) {
		$user_code = $_POST['user_code'];
		$user_code = preg_replace('~\D~', '', $user_code);
	}

	$code_radio = NULL;
	if (isset($_POST['code_radio'])) {
		$code_radio = $_POST['code_radio'];
	}

	if($action == "mod_user"){
		header("Location: modifications.php?action=mod_user&user_code=$user_code");
	} else if($action == "mod_radio"){
		header("Location: modifications.php?action=mod_radio&code_radio=$code_radio");
	}

}

function mod_user_base(){
	del_user();
	add_user();
}

function mod_radio_base(){
	global $mysqli;

	$code_radio = NULL;
	if (isset($_POST['code_radio'])) {
		$code_radio = $_POST['code_radio'];
	}
	$etat = NULL;
	if (isset($_POST['etat'])) {
		$etat = $_POST['etat'];
	}
	$affectation = NULL;
	if (isset($_POST['affectation'])) {
		$affectation = $_POST['affectation'];
		$affectation = strtoupper($affectation);
	}
	$nouv_batterie = NULL;
	if (isset($_POST['nouv_batterie'])) {
		$nouv_batterie = $_POST['nouv_batterie'];
	}
	$nouv_batterie = format_date($nouv_batterie);

	if($nouv_batterie == NULL || $nouv_batterie == ""){
		$query_mod = "UPDATE `radiopads` SET `etat`='$etat',
		`affectation`='$affectation' WHERE `id_radio` = '$code_radio';";
	} else {
		$query_mod = "UPDATE `radiopads` SET `etat`='$etat',
		`affectation`='$affectation', `batterie` = '$nouv_batterie'  WHERE `id_radio` = '$code_radio';";
	}


	$result = $mysqli->query($query_mod);

	if($result){
		header("Location: liste_radio.php?message=success");
	} else {
		header("Location: liste_radio.php?message=error");
	}
}

function sup_panne_avant_date(){
	global $id_magasin, $mysqli;

	$sup_panne_avant_date = NULL;
	if (isset($_POST['sup_avant_date'])) {
		$sup_panne_avant_date = $_POST['sup_panne_avant_date'];
		$sup_panne_avant_date = format_date($sup_panne_avant_date);
	}

	if($sup_panne_avant_date == NULL){
		header("Location: admin.php?message=del_ko");
	} else {

		$query_sup_avant_date = "DELETE FROM `pannes_radiopads` WHERE `id_magasin`='$id_magasin' AND `date_panne` < '$sup_panne_avant_date 00:00:00';";
		$result = $mysqli->query($query_sup_avant_date);

		$nbLignes = $mysqli->affected_rows;


		if($result && $nbLignes != 0){
			header("Location: admin.php?message=sup_avant_date_ok&result=$nbLignes");
		} else{
			header("Location: admin.php?message=del_ko");
		}

	}
}

// Fermeture connection
$mysqli->close();
?>
