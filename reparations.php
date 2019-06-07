<?php
require('./Classes/fpdf/fpdf.php');
class PDF_MC_Table extends FPDF{
	var $widths;
	var $aligns;

	function SetWidths($w){
	    //Set the array of column widths
	    $this->widths=$w;
	}

	function SetAligns($a){
	    //Set the array of column alignments
	    $this->aligns=$a;
	}

	function Row($fill, $data){
	    //Calculate the height of the row
	    $nb=0;
	    for($i=0;$i<count($data);$i++)
	        $nb=max($nb,$this->NbLines($this->widths[$i],$data[$i]));
	    $h=5*$nb;
	    //Issue a page break first if needed
	    $this->CheckPageBreak($h);
	    //Draw the cells of the row
	    for($i=0;$i<count($data);$i++)
	    {
	        $w=$this->widths[$i];
	        //Save the current position
	        $x=$this->GetX();
	        $y=$this->GetY();
	        //Draw the border
					if($fill == true) {
						$this->Rect($x,$y,$w,$h, 'F');
					}
	        //Print the text
	        $this->MultiCell($w,5,$data[$i],0,'C', $fill);
	        //Put the position to the right of the cell
	        $this->SetXY($x+$w,$y);
	    }
	    //Go to the next line
	    $this->Ln($h);
	}

	function CheckPageBreak($h){
	    //If the height h would cause an overflow, add a new page immediately
	    if($this->GetY()+$h>$this->PageBreakTrigger)
	        $this->AddPage($this->CurOrientation);
	}

	function NbLines($w,$txt){
	    //Computes the number of lines a MultiCell of width w will take
	    $cw=&$this->CurrentFont['cw'];
	    if($w==0)
	        $w=$this->w-$this->rMargin-$this->x;
	    $wmax=($w-2*$this->cMargin)*1000/$this->FontSize;
	    $s=str_replace("\r",'',$txt);
	    $nb=strlen($s);
	    if($nb>0 and $s[$nb-1]=="\n")
	        $nb--;
	    $sep=-1;
	    $i=0;
	    $j=0;
	    $l=0;
	    $nl=1;
	    while($i<$nb)
	    {
	        $c=$s[$i];
	        if($c=="\n")
	        {
	            $i++;
	            $sep=-1;
	            $j=$i;
	            $l=0;
	            $nl++;
	            continue;
	        }
	        if($c==' ')
	            $sep=$i;
	        $l+=$cw[$c];
	        if($l>$wmax)
	        {
	            if($sep==-1)
	            {
	                if($i==$j)
	                    $i++;
	            }
	            else
	                $i=$sep+1;
	            $sep=-1;
	            $j=$i;
	            $l=0;
	            $nl++;
	        }
	        else
	            $i++;
	    }
	    return $nl;
	}
}


//Variables globales
$id_magasin  = NULL;

// Ouvre session
session_start();
// Récupère dans session
if (isset($_SESSION['id_magasin'])) {
	$id_magasin = $_SESSION['id_magasin'];
	$alias_magasin = $_SESSION['alias_magasin'];
	$nom_societe = $_SESSION['nom_societe'];
	$mag_adresse = $_SESSION['adresse_magasin'];
	$mag_adresse = utf8_decode($mag_adresse);
	$mag_adresse = explode("\n", $mag_adresse);
} else {
	header("Location: index.php");
}


$ids_radios = NULL;
if (isset($_POST['list_id_radio'])) {
	$ids_radios = $_POST['list_id_radio'];
}

$code_rep = NULL;
if (isset($_POST['code_rep'])) {
	$code_rep = $_POST['code_rep'];
}

$dates_probleme = NULL;
if (isset($_POST['dates_probleme'])) {
	$dates_probleme = $_POST['dates_probleme'];
}

$problemes = NULL;
if (isset($_POST['problemes'])) {
	$problemes = $_POST['problemes'];
}

$lta = NULL;
if (isset($_POST['lta'])) {
	$lta = $_POST['lta'];
}

$dimensions = NULL;
if (isset($_POST['dimensions'])) {
	$dimensions = $_POST['dimensions'];
}

$chronoposte = NULL;
if (isset($_POST['chronoposte'])) {
	$chronoposte = $_POST['chronoposte'];
}


if($ids_radios == NULL || $code_rep == NULL){
	header("Location: envoyer_reparation.php?message=vide&ids_radios=$ids_radios&code_rep=$code_rep&dates_probleme=$dates_probleme&problemes=$problemes");
} else {
	// Paramètres de connexion
	include_once("dbConfig.php");
	//Script d'envoi de mail
	include_once("send_mail.php");

	// Ouverture connexion
	$mysqli = new mysqli(DB_HOST, DB_LOGIN, DB_PWD, DB_NAME); mysqli_set_charset($mysqli, "utf8");

	$ids_radios = explode(',', $ids_radios);
	$dates_probleme = explode(',', $dates_probleme);
	$problemes = explode(',', $problemes);

	$message = "
	Bonjour,
	<br><br>
	Veuillez trouver ci-dessous la liste des Radiopads envoyé pour Réparation.
	Merci de confirmer bonne réception.

	<!DOCTYPE html>
	<html>
	<head>
		<title> HyperPad </title>
		<style media='screen'>
		table{
			display: block;
			width: 98%;
			margin: auto;
			margin-top: 60px;
			text-align: center;
		}


		td, th{
			width: 14vw;
			padding: 8px;
			background-color: #f2f2f2;
			border-radius: 5px;
		}

		th{
			cursor: pointer;
		}

		tr:hover > .color{
			background-color: #2098D1;
			color: white;
		}

		.entete{
			background-color: #4CAF50;
			border-style: solid;
			border-width: 0px 0px 2px 0px;
			font-weight: bold;
			font-size: 20px;
			color: white;
			cursor: pointer;
		}
	</style>
	</head>
	<body>
	<table class='tab_search avectri'>
	<thead>
		<tr class='th'>
			<th class='entete'> Matériel </th>
			<th class='entete'> Modèle </th>
			<th class='entete'> Magasin </th>
			<th class='entete'> Code </th>
			<th class='entete'> Numéro de série </th>
			<th class='entete'> Problème rencontré </th>
			<th class='entete'> Date du problème </th>
		</tr>
	</thead>
	<tbody>
	";
	$taille = sizeof($ids_radios);
	$i = 0;
	$nb_colis = 1;

	$data = [];
	$data_mat = [];
	$data_modele = [];
	$data_mag = [];
	$data_code = [];
	$data_sn = [];
	$data_pb = [];
	$data_date_pb = [];



	foreach ($ids_radios as $key => $id_radio) {
		change_status($id_radio);
		$radio_info = get_info($id_radio);
		$modele = $radio_info['modele'];
		$code = $radio_info['radiopad'];
		$sn = $radio_info['sn'];
		$probleme = $problemes[$key];
		$probleme = str_replace("MATERIEL : ", "", $probleme);
		$probleme = str_replace("LOGICIEL : ", "", $probleme);
		$date_probleme = $dates_probleme[$key];
		$date_probleme = substr($date_probleme, 0, 11);


		$message .= "<td class='color'> Radiopad </td>";
		$message .="<td class='color'> $modele </td>";
		$message .= "<td class='color'> $nom_societe </td>";
		$message .= "<td class='color'> $code </td>";
		$message .= "<td class='color'> $sn </td>";
		$message .= "<td class='color'> $probleme </td>";
		$message .= "<td class='color'> $date_probleme </td>";
		$message .= "</tr>";

		$data_mat[$i] = "Radiopad";
		$data_modele[$i] = $modele;
		$data_mag[$i] = $nom_societe;
		$data_code[$i] = $code;
		$data_sn[$i] = $sn;
		$data_pb[$i] = $probleme;
		$data_date_pb[$i] = $date_probleme;

		if($i == $taille - 2) break;

		$i++;
	}

	$data[0] = array('Matériel', 'Modèle', 'Magasin', 'Code', 'Numéro de série', 'Problème rencontré', 'Date du problème');
	$data[1] = $data_mat;
	$data[2] = $data_modele;
	$data[3] = $data_mag;
	$data[4] = $data_code;
	$data[5] = $data_sn;
	$data[6] = $data_pb;
	$data[7] = $data_date_pb;


	$message .= "</tbody>";
	$message .= "</table></body></html>
	<br><br>
	$nom_societe
	";

	$query_get_info = "SELECT * FROM `utilisateurs` WHERE `id` = '$code_rep' AND `fonction` = 'REPARATEUR' AND `id_magasin` = '$id_magasin';";
	$result = $mysqli->query($query_get_info);

	$mail_reparateur = NULL;
	$adresse_rep = NULL;

	if($result){
		while ($user = $result->fetch_assoc()) {
			$mail_reparateur = $user['email'];
			$adresse_rep = $user['adresse'];
			$reparateur = $user['nom'];
			$adresse_rep = explode("\n", $adresse_rep);
		}
	}


	// Fermeture connection
	$mysqli->close();

	if($chronoposte != NULL){
		generer_pdf();
	}

	if($mail_reparateur != NULL){
		//Envoi du mail
		$subject = "Matériel envoyé pour réparation";
		$mag = "HyperPad.".$nom_societe;

		// send_mail($mail_reparateur, utf8_decode($message), utf8_decode($subject), $mag);
	}

}

function change_status($id_radio){
	global $mysqli, $id_magasin;

	//On met le status du radiopad comme "envoyé en réparation"
	$query_update_status = "UPDATE `radiopads` SET `etat` = 'REPARATION' WHERE `id_radio` = '$id_radio' AND `id_magasin` = '$id_magasin';";
	$mysqli->query($query_update_status);
}

function get_info($id_radio){
	global $mysqli, $id_magasin;

	//On met le status du radiopad comme "envoyé en réparation"
	$query_get_info = "SELECT * FROM `radiopads` WHERE `id_radio` = '$id_radio' AND `id_magasin` = '$id_magasin';";
	$result = $mysqli->query($query_get_info);
	$radio_info = [
		'modele' => '',
		'radiopad' => '',
		'sn' => ''
	];

	if($result){
		while ($radio = $result->fetch_assoc()) {
			$radio_info['modele'] = $radio['modele'];
			$radio_info['radiopad'] = $radio['radiopad'];
			$radio_info['sn'] = $radio['sn'];
		}

		$result->close();
	}

	return $radio_info;
}

function generer_pdf(){
	global $nom_societe, $mag_adresse, $adresse_rep, $reparateur, $nb_colis, $data, $lta, $dimensions;


	$pdf=new PDF_MC_Table();
	//Nouvelle page
	$pdf->AddPage();
	//Change la Police : Courier, U: underline, B: Bold, I: Italic, 11: taille
	$pdf->SetFont('Courier','UB',11);

	////////////////////////Partie expéditeur/////////////////////////
	//écrit un celuler
	$pdf->Cell(40,10,utf8_decode('Expéditeur :'));
	$pdf->SetFont('Courier','B',11);
	//Saut de ligne
	$pdf->Ln(0);
	$mag = strtoupper($nom_societe);
	$pdf->Cell(0,30,"$mag");

	$pdf->Ln(15);
	$pdf->SetFont('Courier','',11);
	//écriture adresse expéditeur avec sauts de lignes
	foreach ($mag_adresse as $key => $adresse) {
		$pdf->Ln(5);
		$pdf->Cell(0,0,"$adresse");
	}

	////////////////////////Partie expéditeur/////////////////////////
	$pdf->Ln(5);
	$pdf->SetFont('Courier','UB',11);
	$pdf->Cell(0,10,utf8_decode('Déstinataire :'), 0, 0, 'R');
	$pdf->SetFont('Courier','B',11);
	$pdf->Ln(15);

	$reparateur = strtoupper($reparateur);
	$pdf->Cell(0,0,"$reparateur", 0, 0, 'R');

	$pdf->SetFont('Courier','',11);

	foreach ($adresse_rep as $key => $adresse) {
		$pdf->Ln(5);

		$y=$pdf->GetY();
		$pdf->SetXY(0,$y);

		$pdf->Cell(0,0,$adresse, 0, 0, 'R');
	}

  $date = date("d-m-Y");

	$pdf->Ln(15);
	$pdf->Cell(0,0,"Le $date", 0, 0, 'R');

	$pdf->SetFont('Courier','U',20);
	$pdf->Ln(15);
	$pdf->Cell(0,0,"ATTESTATION DE VALEUR", 0, 0, 'C');

	$pdf->SetFont('Courier','',15);
	$pdf->Ln(10);
	$pdf->SetFillColor(247, 255, 0);

	$w = $pdf->GetStringWidth("SAV / POUR REPARATION : SANS VALEUR MARCHANDE")+6;
	$pdf->Cell(20);
	$pdf->Cell($w,9,"SAV / POUR REPARATION : SANS VALEUR MARCHANDE", 0, 0, 'C', true);

	$pdf->Ln(10);

	$w = $pdf->GetStringWidth("MATERIELS DEFFECTUEUX")+6;
	$pdf->Cell(60);
	$pdf->Cell($w,9,"MATERIELS DEFFECTUEUX", 0, 0, 'C', true);

	$pdf->SetFont('Courier','',11);
	$pdf->Ln(20);

	$x=$pdf->GetX();

	$w = $pdf->GetStringWidth("Nombre de colis : $nb_colis")+6;
	$pdf->Cell($w,9,"Nombre de colis : $nb_colis", 0, 0, 'L');
	$pdf->Ln(5);

	$y=$pdf->GetY();
	$pdf->SetXY($x,$y);

	$w = $pdf->GetStringWidth("Numéro LTA : $lta")+6;
	$pdf->Cell($w,9,utf8_decode("Numéro LTA : $lta"), 0, 0, 'L');
	$pdf->Ln(5);

	$y=$pdf->GetY();
	$pdf->SetXY($x,$y);

	$w = $pdf->GetStringWidth("Dimensions : $dimensions")+6;
	$pdf->Cell($w,9,"Dimensions : $dimensions", 0, 0, 'L');
	$pdf->Ln(10);


	$pdf->SetFont('Arial','',11);


	$widths_col  = array(
		$pdf->GetStringWidth($data[0][0]) + 2,
		$pdf->GetStringWidth($data[0][1]) + 3,
		$pdf->GetStringWidth($data[0][2]) + 10,
		$pdf->GetStringWidth($data[0][3]) + 7,
		$pdf->GetStringWidth($data[0][4]) - 2,
		$pdf->GetStringWidth($data[0][5]),
		$pdf->GetStringWidth($data[0][6]) + 8
	);

	$pdf->SetWidths($widths_col);


	//Drawing header
	$pdf->SetFillColor(255,0,0);
	$pdf->SetTextColor(255);
	$pdf->SetDrawColor(128,0,0);
	$pdf->SetLineWidth(.3);
	$pdf->SetFont('','B');
	$fill = false;

	foreach ($data[0] as $key => $value) {
		$pdf->Cell($widths_col[$key],5,utf8_decode($data[0][$key]),0,0,'C',true);
	}

	$pdf->Ln();

	$pdf->SetFont('Courier','',10);
	$pdf->SetFillColor(224,235,255);
	$pdf->SetTextColor(0);

	for ($key=0; $key < count($data[1]); $key++) {
		$pdf->Row($fill, array($data[1][$key], $data[2][$key], $data[3][$key], $data[4][$key], $data[5][$key], $data[6][$key], $data[7][$key]));

		$fill = !$fill;
	}

	$pdf->Ln(10);
	$pdf->Cell(0,0,"Responsable informatique", 0, 0, 'R', false);
	$pdf->Ln(5);
	$pdf->Cell(0,0,"(Tampon et signature) :", 0, 0, 'R', false);
	$pdf->Ln(10);


	$pdf->Output();
}
?>
