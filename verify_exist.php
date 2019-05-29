<?php
// Ouvre session
session_start();

//Données client
$id_magasin = NULL;
if (isset($_SESSION['id_magasin'])) {
  $id_magasin = $_SESSION['id_magasin'];
}

// AJAX 1
$donneesClient = json_decode($_POST['donneesClient'], true);
$type = $donneesClient['type'];
$code = $donneesClient['code'];
if($type == "user_code"){
  $champ = "id";
  $table = "utilisateurs";
} else if($type == "code_radio"){
  $champ = "id_radio";
  $table = "radiopads";
}

if($id_magasin != NULL){
  // Paramètres de connexion
  include_once("dbConfig.php");

  // Ouverture connexion
  $mysqli = new mysqli(DB_HOST, DB_LOGIN, DB_PWD, DB_NAME); mysqli_set_charset($mysqli, "utf8");

  $query = "SELECT * FROM `$table` WHERE `$champ` = '$code' AND `id_magasin`='$id_magasin';";
  $result = $mysqli->query($query);

  if($result){
    $nb = $result->num_rows;
    $result->close();
  } else {
    $nb = 0;
  }

  if($nb == 0){
    $ok = 0;
  } else{
    $ok = 1;
  }

  if($type == "user_code"){
    // AJAX 1
    $objetJSON = array();
    $objetJSON[] = array("user_code" => $ok);
  } else{
    // AJAX 1
    $objetJSON = array();
    $objetJSON[] = array("code_radio" => $ok);
  }



  // Serialize
  $donneesServeur = json_encode($objetJSON);

  // Serialize et envoie reponse
  echo "$donneesServeur";

  // Fermeture connection
  $mysqli->close();
} else{
  header("Location: index.php?message=invalide");
}




?>
