<?php
$nom_societe = NULL;
$departement = NULL;
$id_magasin = NULL;

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
	header("Location: admin.php");
}


if($nom_societe == NULL || $departement == NULL || $id_magasin == NULL){
	header("Location: index.php");
} else {
	$chemin_actuel = str_replace('\\', '/', __DIR__);

	$modele = NULL;
	if (isset($_POST['modele'])) {
		$modele = $_POST['modele'];
	}

	if($modele != NULL){
		copier_ressources($chemin_actuel, "./installation/ressources/$modele/", "./installation/temp/$modele/");
		configure($chemin_actuel, $modele);
		download($chemin_actuel, $modele);

	} else {
		header("Location: installation.php");
	}
}

function copier_ressources($chemin_actuel, $dir_source, $dir_dest){
	//Lance scripts pour supprimer puis créer le dossier temp (en gros ça permet de vider le dossier temp)
	shell_exec("$chemin_actuel/installation/delete_temp.bat");
	shell_exec("$chemin_actuel/installation/create_temp.bat");

	mkdir($dir_dest, 0755);

	$dir_iterator = new RecursiveDirectoryIterator($dir_source, RecursiveDirectoryIterator::SKIP_DOTS);

	$iterator = new RecursiveIteratorIterator($dir_iterator, RecursiveIteratorIterator::SELF_FIRST);

	foreach($iterator as $element){

	   if($element->isDir()){
	      mkdir($dir_dest . DIRECTORY_SEPARATOR . $iterator->getSubPathName());
	   } else{
	      copy($element, $dir_dest . DIRECTORY_SEPARATOR . $iterator->getSubPathName());
	   }
	}

	copy("$chemin_actuel/installation/README.txt", "$chemin_actuel/installation/temp/README.txt");
}

function download($chemin_actuel, $modele){
	$file = "$chemin_actuel/installation/temp/ressource.zip";
	$size = filesize($file);
	$type = filetype($file);
	$nomfichier = "Ressources_$modele.zip";

  	// désactive le temps max d'exécution
	set_time_limit(0);

	// désactivation compression GZip
	if (ini_get("zlib.output_compression")) {
	    ini_set("zlib.output_compression", "Off");
	}

	// désactive la mise en cache
	header("Cache-Control: no-cache, must-revalidate");
	header("Cache-Control: post-check=0,pre-check=0");
	header("Cache-Control: max-age=0");
	header("Pragma: no-cache");
	header("Expires: 0");

	// force le téléchargement du fichier avec un beau nom
	header("Content-Type: application/force-download");
	header('Content-Disposition: attachment; filename="'.$nomfichier.'"');

	// indique la taille du fichier à télécharger
	header("Content-Length: ".$size);

	// envoi le contenu du fichier
	readfile($file);
}

function configure($chemin_actuel, $modele){
	$radio_code = NULL;
	if (isset($_POST['radio_code'])) {
		$radio_code = $_POST['radio_code'];
	}

	$alias_magasin = NULL;
	if (isset($_POST['alias_magasin'])) {
		$alias_magasin = $_POST['alias_magasin'];
	}

	$ip_serveur_meti = NULL;
	if (isset($_POST['ip_serveur_meti'])) {
		$ip_serveur_meti = $_POST['ip_serveur_meti'];
	}

	$ip_serveur_radiopad = NULL;
	if (isset($_POST['ip_serveur_radiopad'])) {
		$ip_serveur_radiopad = $_POST['ip_serveur_radiopad'];
	}

	$fuseau_horaire = NULL;
	if (isset($_POST['fuseau_horaire'])) {
		$fuseau_horaire = $_POST['fuseau_horaire'];
	}

	$ip_serveur_pricer = NULL;
	if (isset($_POST['ip_serveur_pricer'])) {
		$ip_serveur_pricer = $_POST['ip_serveur_pricer'];
	}

	$ip_serveur_ftp = NULL;
	if (isset($_POST['ip_serveur_ftp'])) {
		$ip_serveur_ftp = $_POST['ip_serveur_ftp'];
	}

	$userName = NULL;
	if (isset($_POST['userName'])) {
		$userName = $_POST['userName'];
	}

	$password = NULL;
	if (isset($_POST['password'])) {
		$password = $_POST['password'];
	}

	$dossier = NULL;
	if (isset($_POST['dossier'])) {
		$dossier = $_POST['dossier'];
	}

	$nb_lignes = NULL;
	if (isset($_POST['nb_lignes'])) {
		$nb_lignes = $_POST['nb_lignes'];
	}

	if (isset($_POST['icone_clavier'])) {
		$icone_clavier = "00000001";
	} else{
		$icone_clavier = "00000000";
	}

	if (isset($_POST['icone_heure'])) {
		$icone_heure = "00000001";
	} else{
		$icone_heure = "00000000";
	}

	if (isset($_POST['icone_batterie'])) {
		$icone_batterie = "00000001";
	} else{
		$icone_batterie = "00000000";
	}

	if (isset($_POST['icone_reseau'])) {
		$icone_reseau = "00000001";
	} else{
		$icone_reseau = "00000000";
	}

	$volume = NULL;
	if (isset($_POST['volume'])) {
		$volume = $_POST['volume'];
		if($volume == 0){
			$volume = '0000000000';
		} else if($volume == 1){
			$volume = '0000001111';
		} else if($volume == 2){
			$volume = '0000002111';
		} else if($volume == 3){
			$volume = '4294967295';
		}
	}

	$screen = NULL;
	if (isset($_POST['screen'])) {
		$screen = $_POST['screen'];
		if($screen == 0){
			$screen = '0000000000';
		} else if($screen == 1){
			$screen = '0000001111';
		} else if($screen == 2){
			$screen = '0000002111';
		} else if($screen == 3){
			$screen = '4294967295';
		}
	}

	$key = NULL;
	if (isset($_POST['key'])) {
		$key = $_POST['key'];
		if($key == 0){
			$key = '0000000000';
		} else if($key == 1){
			$key = '0000001111';
		} else if($key == 2){
			$key = '0000002111';
		} else if($key == 3){
			$key = '4294967295';
		}
	}

//Remplacement des clés de configurations du WIFI
if(isset($_FILES['wcs_options'])){
	$dossier = "$chemin_actuel/installation/ressources/$modele/";
	$dossier = str_replace('/', '\\', $dossier);

	$fichier = basename($_FILES['wcs_options']['name']);
	if(move_uploaded_file($_FILES['wcs_options']['tmp_name'], $dossier . $fichier)){
	  echo 'Upload effectué avec succès !';
	} else {
	  echo 'Echec de l\'upload !';
	}
}

if(isset($_FILES['wcs_profiles'])){
	$dossier = "$chemin_actuel/installation/ressources/$modele/";
	$dossier = str_replace('/', '\\', $dossier);

	$fichier = basename($_FILES['wcs_profiles']['name']);
	move_uploaded_file($_FILES['wcs_profiles']['tmp_name'], $dossier . $fichier);
}


	$nom_app = [];
	$description = [];
	$lien = [];

	for ($i=0; $i < $nb_lignes; $i++) {
		if (isset($_POST["nom_app$i"])) {
			$nom_app_i = $_POST["nom_app$i"];
			$nom_app[$i] = $nom_app_i;
		}
		if (isset($_POST["description$i"])) {
			$description_i = $_POST["description$i"];
			$description[$i] = $description_i;
		}
		if (isset($_POST["lien$i"])) {
			$lien_i = $_POST["lien$i"];
			$lien[$i] = $lien_i;
		}
	}

	$parametres = ['"Name"="FIC175"'];
	$valeurs = ['"Name"="' . strtoupper($alias_magasin) . $radio_code . '"'];
	//Modification du fichier Idxx.Reg
	$file_name = "$chemin_actuel/installation/temp/$modele/Idxx.Reg";
	//Code Radiopad avec alias magasin
	read_and_modify($file_name, $parametres, $valeurs);


	$parametres = [
		'"Arguments"="http://10.50.91.93:3333/pda/home"',
		'"Arguments"="\Application\TSE\meti.rdp /v:10.10.10.196"',
		'"ShowKeyStates"=dword:00000000', //Icône ALPHA ou NUMERIQUE
		'"ShowTime"=dword:00000001', //Affiche l'heure
		'"ShowBatteryLevel"=dword:00000001', //Afficher l'icône de la batterie
		'"ShowSignalStrength"=dword:00000001' //Afficher icône signal réseau
	];

	$valeurs = [
		'"Arguments"="http://' . $ip_serveur_pricer . ':3333/pda/home"',
		'"Arguments"="\Application\TSE\meti.rdp /v:' . $ip_serveur_meti . '"',
		'"ShowKeyStates"=dword:' . $icone_clavier,
		'"ShowTime"=dword:' . $icone_heure,
		'"ShowBatteryLevel"=dword:' . $icone_batterie,
		'"ShowSignalStrength"=dword:'. $icone_reseau
	];
	//Modification du fichier AppCenter.reg
	$file_name = "$chemin_actuel/installation/temp/$modele/AppCenter.reg";
	//IP Serveur Pricer et IP serveur METI Radiopad
	read_and_modify($file_name, $parametres, $valeurs);
	//Ajout de liens applicatifs
	if(isset($nom_app[0])){
		read_and_add($file_name, $nom_app, $description, $lien);
	}


	if($modele == 'MC3090'){
		//Modification du fichier Vidage.spt
		$file_name = "$chemin_actuel/installation/temp/$modele/Vidage.spt";
	} else{
		//Modification du fichier Vidage.spt
		$file_name = "$chemin_actuel/installation/temp/$modele/Scripts/Vidage.spt";
	}

	$parametres = [
		'SETVAR string FtpServer = "10.10.10.192"',
		'SETVAR string FtpUserName = "RadiopadRCC"',
		'SETVAR string FtpPassword = "Ficobam"',
		'SETVAR string FileToFtp = "/Vidages_Radiopad/" + LineFile'
	];

	$valeurs = [
		'SETVAR string FtpServer = "' . $ip_serveur_ftp . '"',
		'SETVAR string FtpUserName = "' . $userName . '"',
		'SETVAR string FtpPassword = "' . $password . '"',
		'SETVAR string FileToFtp = "' . $dossier . '" + LineFile'
	];

	//IP serveur FTP, Nom d'utilisateur FTP, Mdp FTP et Dossier de vidage
	read_and_modify($file_name, $parametres, $valeurs);


	if($modele != 'MC3090'){
		$parametres = [
			'"MRU0"="10.10.10.196"',
			'"10.10.10.196"="fic175@gbh"',
			'"Display"="(GMT-03:00) Cayenne, Fortaleza"',
			'"CalibrationData"=""', //Calibrage de l'écran
			'"Volume"=dword:858993459', //Volume entre 0 et 4294967295
			'"Screen"=dword:00000000', //Luminosité de l'écran 0, 1 ou 2
			'"Key"=dword:00000000' //Volume du clavier 0, 1 ou 2
		];

		$valeurs = [
			'"MRU0"="' . $ip_serveur_meti . '"',
			'"' . $ip_serveur_radiopad . '"="' . $alias_magasin . $radio_code . '@gbh"',
			'"Display"="' . $fuseau_horaire . '"',
			'"CalibrationData"="500,514 787,787 219,786 208,247 787,243"',
			'"Volume"=dword:' . $volume ,
			'"Screen"=dword:' . $screen ,
			'"Key"=dword:' . $key
		];
		//Modification du fichier Fusion on.reg
		$file_name = "$chemin_actuel/installation/temp/$modele/fusion on.reg";
		//Ip serveur METI, Ip serveur Radiopad et code Radiopad avec alias magasin et Fuseau Horaire
		read_and_modify($file_name, $parametres, $valeurs);

		$parametres = [
			'ID = 100'
		];

		$valeurs = [
			"ID = $radio_code"
		];
		//Modification du fichier IdentifiantPocket.INI
		$file_name = "$chemin_actuel/installation/temp/$modele/meti_radiopad/IdentifiantPocket.INI";
		//Ip serveur METI, Ip serveur Radiopad et code Radiopad avec alias magasin et Fuseau Horaire
		read_and_modify($file_name, $parametres, $valeurs);
	}

	//Lance script pour ziper dossier de ressources pour le télécharger ensuite
	shell_exec("$chemin_actuel/installation/zip.bat");
}

function read_and_modify($file_name, $parametres, $valeurs){
	//Ouverture et lecture du fichier puis fermeture
	$file = fopen("$file_name", 'r+');
	$file_text =  fread($file, filesize("$file_name"));
	fclose($file);
	$i = 0;
	foreach ($parametres as $config) {
		//Modification des paramètres
		$file_text = str_replace($config, $valeurs[$i], $file_text);
		$i++;
	}

	//Ouverture du fichier avec mise à zéro et écriture des nouveaux paramètres
	$file = fopen("$file_name", 'w');
	fwrite($file, $file_text);
	fclose($file);
}

function read_and_add($file_name, $nom_app, $description, $lien){
	$saut = "\r\n";
	$texte_statique = '"IconFile"="\\\windows\\\iesample.exe"' . $saut;
	$texte_statique .= '"Window1"="Accueil - Internet Explorer|iExplore"' . $saut;
	$texte_statique .= '"ReadOnly"=dword:00000000' . $saut;
	$texte_statique .= '"HideFromUser"=dword:00000000' . $saut;
	$texte_statique .= '"HideAllTaskBars"=dword:00000000' . $saut;
	$texte_statique .= '"HideDoneButton"=dword:00000000' . $saut;
	$texte_statique .= '"HideStartMenu"=dword:00000001' . $saut;
	$texte_statique .= '"HideSip"=dword:00000000' . $saut;
	$texte_statique .= '"AutoStart"=dword:00000000' . $saut;
	$texte_statique .= '"StartupDelay"=dword:00000000' . $saut;
	$texte_statique .= '"RelaunchInterval"=dword:00000000' . $saut;
	$texte_statique .= '"AlwaysLaunch"=dword:00000000' . $saut;
	$texte_statique .= '"AddTotoolsMenu"=dword:00000000' . $saut;

	//Ouverture et lecture du fichier puis fermeture
	$file = fopen("$file_name", 'r+');
	$file_text =  fread($file, filesize("$file_name"));
	fclose($file);
	$i = 0;
	foreach ($nom_app as $nom) {
		//Ajout des paramètres
		$file_text .= $saut . "[HKEY_CURRENT_USER\SOFTWARE\Symbol\AppCenter\\$nom]";
		$file_text .= $saut . '"Description"="' . $description[$i] . '"';
		$file_text .= $saut . '"Execute"="\\\windows\\\iesample.exe"';
		$file_text .= $saut . '"Arguments"="http://'. $lien[$i] . '"';
		$file_text .= $saut . $texte_statique;
		$i++;
	}

	//Ouverture du fichier avec mise à zéro et écriture des nouveaux paramètres
	$file = fopen("$file_name", 'w');
	fwrite($file, $file_text);
	fclose($file);
}

?>
