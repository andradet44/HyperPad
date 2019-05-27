<?php
$user_code = NULL;
$radio_code = NULL;

//Données client
if (isset($_POST['user_code'])) {
  $user_code = $_POST['user_code'];
}
//On récupère que les chiffres parmis la chaine de caractères : "108 - Prenom NOM" -> "108"
$user_code = preg_replace('~\D~', '', $user_code);
if (isset($_POST['radio_code'])) {
  $radio_code = $_POST['radio_code'];
}
if (isset($_POST['page'])) {
  $page = $_POST['page'];
}

//Variables globales
$id_magasin  = NULL;

// Ouvre session
session_start();
// Récupère dans session
if (isset($_SESSION['id_magasin'])) {
	$id_magasin = $_SESSION['id_magasin'];
} else {
	header("Location: index.php?message=vide");
}


// Paramètres de connexion
include_once("dbConfig.php");

// Ouverture connexion
$mysqli = new mysqli(DB_HOST, DB_LOGIN, DB_PWD, DB_NAME);

//On vérifie que l'utilisateur et le code radiopad sont bien présents en base de données
$query_verifier_code = "SELECT * FROM `radiopads` WHERE `id_radio` = '$radio_code' AND `id_magasin` = '$id_magasin'";
$result_verifier_code = $mysqli->query($query_verifier_code);
if($result_verifier_code){
  $nbLignes = $result_verifier_code->num_rows;
  $result_verifier_code->close();
} else{
  $nbLignes = 0;
}

echo $query_verifier_code;
$query_verifier_code = "SELECT * FROM `utilisateurs` WHERE `id` = '$user_code' AND `id_magasin` = '$id_magasin'";
$result_verifier_code = $mysqli->query($query_verifier_code);
if($result_verifier_code){
  $nbLignes += $result_verifier_code->num_rows;
  $result_verifier_code->close();
}

if($nbLignes != 2){
   header("Location: $page?message=vide");
} else{



  //On teste si les champs on bien été remplis
  if($user_code == NULL || $radio_code == NULL || $user_code == "" || $radio_code == ""){
    header("Location: $page?message=vide");
  } else{

    //On vérifie s'il s'agit d'un prêt ou d'un retour
    //Requete sql
    $query_verifier_pret = "SELECT * FROM `prets` WHERE `id_radiopad` = '$radio_code' AND `date_retour` =  '0000-00-00 00:00:00' AND `id_magasin` = '$id_magasin';";
    //On lance la requete en base de données
    $result_verifier_pret = $mysqli->query($query_verifier_pret);
    //Nombre de lignes retournées par la requete
    $nbLignes = $result_verifier_pret->num_rows;

    //On récupère la date de retour afin de faire des vérifications7
    $user_code_base = "";
    if($result_verifier_pret){
      while ($pret = $result_verifier_pret->fetch_assoc()) {
        $user_code_base = $pret['id_utilisateur'];
        $date_retour = $pret['date_retour'];
      }
    }


    // Destruction résultat
    $result_verifier_pret->close();

    if($nbLignes==0){
      //Requete sql permetant d'insérer les données
      $query_pret = "INSERT INTO `prets` (`id`, `id_utilisateur`, `id_radiopad`, `date_pret`, `date_retour`, `id_magasin`) VALUES (NULL, '$user_code', '$radio_code', CURRENT_TIMESTAMP, 0, '$id_magasin');";
      //On lance la requete en base de données
      $mysqli->query($query_pret);

      header("Location: $page?message=pret");
    } else {
        if($user_code != $user_code_base){


          //On vérifie si les données fournies par le client sont des données comptenues en base de données
          //Vérification pour le code utilisateur
          $query_verifier_valeur = "SELECT * FROM `radiopads` WHERE `id_radio` = '$radio_code' AND `id_magasin` = '$id_magasin';";
          //On lance la requete en base de données
          $result_verifier_valeur = $mysqli->query($query_verifier_valeur);
          //Nombre de lignes retournées par la requete
          if($result_verifier_valeur){
            $nbLignes = $result_verifier_valeur->num_rows;
            $result_verifier_valeur->close();
          } else{
            $nbLignes = 0;
          }


          if($nbLignes == 0){
            $radio_code = NULL;
          }

          //Vérification pour le code radiopad
          $query_verifier_valeur = "SELECT * FROM `utilisateurs` WHERE `id_utilisateur` = '$user_code' AND `id_magasin` = '$id_magasin';";
          //On lance la requete en base de données
          $result_verifier_valeur = $mysqli->query($query_verifier_valeur);
          //Nombre de lignes retournées par la requete
          if($result_verifier_valeur){
            $nbLignes = $result_verifier_valeur->num_rows;
            $result_verifier_valeur->close();
          } else{
            $nbLignes = 0;
          }

          if($nbLignes == 0){
            $user_code = NULL;
          }

          header("Location: $page?message=pas_rendu");

        } else {
          //Requete sql permetant d'insérer les données
          $query_modif_pret = "UPDATE `prets` SET `date_retour` = CURRENT_TIMESTAMP WHERE `id_radiopad` = '$radio_code' AND `id_utilisateur` =  '$user_code' AND `date_retour` =  '0000-00-00 00:00:00';";
          //On lance la requete en base de données
          $mysqli->query($query_modif_pret);

          if($page != "index.php"){
            header("Location: $page?message=retour");
          } else{
            header("Location: $page");
          }

        }

    }

  }
}

// Fermeture connection
$mysqli->close();
?>
