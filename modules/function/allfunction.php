<?php
//**************************** COMPTEUR *********************************
function Compteur($size,$tva,$num)
	{
		if($tva == 2) {$Lecture.="<option value=''>- ".$_SESSION['STrad217']." -</option>";$ii = 1;}
		else {$ii = 0;}

		for($i=$ii;$i<$size;$i++)
			{
				$Lecture.="<option value='".$i."'";if($num == $i) {$Lecture.=" selected";} $Lecture.=">".$i."</option>";
			}
		return $Lecture;
	}
//*******************************************************************

//**************************** FORMAT DATE *********************************
function DateJJ($num)
	{
		$Lecture.="<option value=''>".$_SESSION['STrad645']."</option>";
		for ($i = 1 ; $i <= 31 ; $i++)
			{
				$Lecture.="<option value='".$i."'";if($num == $i) {$Lecture.=" selected";} $Lecture.=">".$i."</option>";
			}
		return $Lecture;
	}
function DateMM($num)
	{
		$Lecture.="<option value=''>".$_SESSION['STrad646']."</option>";
		for ($i = 1 ; $i <= 12 ; $i++)
			{
				$Lecture.="<option value='".$i."'";if($num == $i) {$Lecture.=" selected";} $Lecture.=">".TradMoisNum($i)."</option>";
			}
		return $Lecture;
	}
function DateAA($num)
	{
		$Lecture.="<option value=''>".$_SESSION['STrad16']."</option>";

		for ($i = date('Y'); $i >= 1910; $i--)
			{
				$Lecture.="<option value='".$i."'";if($num == $i) {$Lecture.=" selected";} $Lecture.=">".$i."</option>";
			}
		return $Lecture;
	}

function formatdatemysql($date)
	{
		if($date == "0000-00-00") {$date="";}
		$datecomplet=strtolower($date);
		$dateaaaa=substr("$datecomplet", 0, 4);
		$datemm=substr("$datecomplet", 5, 2);
		$datejj=substr("$datecomplet", 8, 2);

		$datemm = TradMoisNum($datemm);

		if($_SESSION['infologlang1'] != "es")
			{
				$date=$datejj."  ".$datemm."  ".$dateaaaa;
			}
		else if($_SESSION['infologlang1'] == "es")
			{
				$date=$datejj." de ".$datemm." de ".$dateaaaa;
			}

		return $date;
	}

function formatdatemysqlexport1($date)
	{
		if($date == "0000-00-00")
			{
				return "000000";
			}
	if(!empty($date))
		{
			$datecomplet=strtolower($date);
			$dateaaaa=substr("$datecomplet", 0, 4);
			$datemm=substr("$datecomplet", 5, 2);
			$datejj=substr("$datecomplet", 8, 2);
			$datereturn=$datejj.$datemm.$dateaaaa;
			return $datereturn;
		}
	}
function formatdatemysqlexport2($date)
	{
		if($date == "0000-00-00")
			{
				return "000000";
			}
	if(!empty($date))
		{
			$datecomplet=strtolower($date);
			$dateaaaa=substr("$datecomplet", 0, 4);
			$datemm=substr("$datecomplet", 5, 2);
			$datejj=substr("$datecomplet", 8, 2);
			$datereturn=$datejj."/".$datemm."/".$dateaaaa;
			return $datereturn;
		}
	}

function formatheure1($heure)
	{
			$num=strtolower($heure);
			$num1=substr("$heure", 11, 2);
			$num2=substr("$heure", 14, 2);
			$num3=substr("$heure", 17, 2);
			$num4=substr("$heure", 0, 4);
			$num5=substr("$heure", 5, 2);
			$num6=substr("$heure", 8, 2);
			return array($num1,$num2,$num3,$num4,$num5,$num6);
	}
function formatdatemysqlselect($date)
	{
		$datecomplet=strtolower($date);
		$dateaaaa=substr("$datecomplet", 0, 4);
		$datemm=substr("$datecomplet", 5, 2);
		$datejj=substr("$datecomplet", 8, 2);
		return array( $datejj, $datemm, $dateaaaa );
	}
function debutsem1($year,$month,$day) {
 $num_day      = date('w', mktime(0,0,0,$month,$day,$year));
 $premier_jour = mktime(0,0,0, $month,$day-(!$num_day?7:$num_day)+1,$year);
 $datedeb      = date('d', $premier_jour);
 $datedeb1      = date('Y-m-d', $premier_jour);
    return array($datedeb,$premier_jour,$datedeb1);
}

function formatdatemysql1($date)
	{
		if($date == '0000-00-00')
			{
				return '';
			}

		if(!empty($date))
			{
				$datecomplet=strtolower($date);
				$dateaaaa=substr("$datecomplet", 0, 4);
				$datemm=substr("$datecomplet", 5, 2);
				$datejj=substr("$datecomplet", 8, 2);

				$Jour = date("w",mktime(0,0,0,$datemm,$datejj,$dateaaaa));

				$date = AfficheJours($Jour)." ".$datejj."/".$datemm;
			}
		return $date;
	}

function formatheure($heure)
	{
		$num=strtolower($heure);
		$num1=substr("$heure", 0, 2);
		$num2=substr("$heure", 3, 2);
		$num3=substr("$heure", 6, 2);
		return array($num1,$num2,$num3);
	}

function formatdatemysqlexport($date)
	{
		if($date == "0000-00-00")
			{
				return "000000";
			}
		if(!empty($date))
			{
				$datecomplet=strtolower($date);
				$dateaaaa=substr("$datecomplet", 2, 2);
				$datemm=substr("$datecomplet", 5, 2);
				$datejj=substr("$datecomplet", 8, 2);
				$datereturn=$datejj.$datemm.$dateaaaa;
				return $datereturn;
			}
	}
//*************************************************************************************************

//************************** QUESTION OUI NON **********************
function AffichQuestOuiNonSelect($question)
	{
		$Lecture.="<option value=''>- ".$_SESSION['STrad349']." -</option>";
		$Lecture.="<option value='1'";if($question == 1) {$Lecture.=" selected";} $Lecture.=">".$_SESSION['STrad34']."</option>";
		$Lecture.="<option value='2'";if($question == 2) {$Lecture.=" selected";} $Lecture.=">".$_SESSION['STrad33']."</option>";

		return $Lecture;
	}
function AffichQuestOuiNonLect($question)
	{
		if($question == 1)
		{return $_SESSION['STrad34'];};
		if($question == 2)
		{return $_SESSION['STrad33'];};
	}
//********************************************************************

//***************************************** CALCUL DUREE CALENDRIER **************************************************
function CalcDureeCalendrier($date1,$date2)
	{
		$dateDeb = new DateTime($date1);

		$heure2 = formatheure1($date2);
		$TrancheHoraire = date("Y-m-d H:i:s", mktime($heure2[0],$heure2[1],$heure2[2] + 1,$heure2[4],$heure2[5],$heure2[3]));

		$dateFin = new DateTime($TrancheHoraire);

		$Resultat = ($dateFin ->format('U') - $dateDeb ->format('U')) / 3600;
		if($Resultat >= 15) {$Resultat = 15;}

		if($Resultat > 0 AND $Resultat <= 1.1) {$Resultat = $Resultat;}
		else if($Resultat > 1.1 AND $Resultat <= 2.1) {$Resultat = $Resultat + 0.1;}
		else if($Resultat > 2.1 AND $Resultat <= 3.1) {$Resultat = $Resultat + 0.3;}
		else if($Resultat > 3.1 AND $Resultat <= 4.1) {$Resultat = $Resultat + 0.5;}
		else if($Resultat > 4.1 AND $Resultat <= 5.1) {$Resultat = $Resultat + 0.7;}
		else if($Resultat > 5.1 AND $Resultat <= 6.1) {$Resultat = $Resultat + 0.9;}
		else if($Resultat > 6.1 AND $Resultat <= 7.1) {$Resultat = $Resultat + 1.1;}
		else if($Resultat > 7.1 AND $Resultat <= 8.1) {$Resultat = $Resultat + 1.3;}
		else if($Resultat > 8.1 AND $Resultat <= 9.1) {$Resultat = $Resultat + 1.5;}
		else if($Resultat > 9.1 AND $Resultat <= 10.1) {$Resultat = $Resultat + 1.7;}
		else if($Resultat > 10.1 AND $Resultat <= 11.1) {$Resultat = $Resultat + 1.9;}
		else if($Resultat > 11.1 AND $Resultat <= 12.1) {$Resultat = $Resultat + 2.1;}
		else if($Resultat > 12.1 AND $Resultat <= 13.1) {$Resultat = $Resultat + 2.3;}

		return $Resultat;
	}
//**************************************************************************************************************************

//*********************** CALCUL LE NOMBRE DE SEMAINE ****************************
function CalcNbSem($date1,$date2)
	{
		$dureeSejour = (strtotime($date2." 23:59:59") - strtotime($date1." 00:00:00"));

		$NbSem = $dureeSejour/86400;
		$NbSem = $NbSem/7;
		$NbSem = round($NbSem,"0");
		$NbSem = $NbSem;

	//$NbSem = number_format($dureeSejour/86400 ,0);
		return $NbSem;
		exit;
	}
//*******************************************************************************************

//******************************* CLIENTS CIVITE ************************************
function ClieSexeLect($sexe)
	{
		if($sexe == 1){return $_SESSION['STrad54'];}
		else if($sexe == 2){return $_SESSION['STrad55'];}
		else if($sexe == 4){return $_SESSION['STrad56'];}
		else if($sexe == 3){return "";}
		else if($sexe == 5){return "";}
		else if($sexe == 6){return $_SESSION['STrad58'];}
		else if($sexe == 7){return $_SESSION['STrad57'];}
		else if($sexe == 8){return $_SESSION['STrad59'];}
		else {return $sexe;}
	}
function ClieSexeSelect($num)
	{
		$Lecture.="<option value=''>-- ".$_SESSION['STrad62']." --</option>";
		$Lecture.="<option value='1'";if($num == 1) {$Lecture.=" selected";} $Lecture.=">".$_SESSION['STrad54']."</option>";
		$Lecture.="<option value='2'";if($num == 2) {$Lecture.=" selected";} $Lecture.=">".$_SESSION['STrad55']."</option>";
		$Lecture.="<option value='4'";if($num == 4) {$Lecture.=" selected";} $Lecture.=">".$_SESSION['STrad56']."</option>";
		$Lecture.="<option value='3'";if($num == 3) {$Lecture.=" selected";} $Lecture.=">".$_SESSION['STrad60']."</option>";
		$Lecture.="<option value='5'";if($num == 5) {$Lecture.=" selected";} $Lecture.=">".$_SESSION['STrad61']."</option>";
		$Lecture.="<option value='6'";if($num == 6) {$Lecture.=" selected";} $Lecture.=">".$_SESSION['STrad58']."</option>";
		$Lecture.="<option value='7'";if($num == 7) {$Lecture.=" selected";} $Lecture.=">".$_SESSION['STrad57']."</option>";
		$Lecture.="<option value='8'";if($num == 8) {$Lecture.=" selected";} $Lecture.=">".$_SESSION['STrad59']."</option>";

		return $Lecture;
	}
//**********************************************************************************************

//*************************** CARACTERE SPECIAUX ******************************
function CaracSpeciaux($carac)
	{
		$carac = str_replace ( "'" , " " , $carac);
		$carac = str_replace('"', '\"', $carac);

		return $carac;
	}
//*******************************************************************************************

//***************************** SECURISE LES FORMULAIRES ************************************
function SecureInput($mot)
	{
		$mot = iconv( 'UTF-8', 'ISO-8859-1//TRANSLIT', $mot);
		return $mot;
	}
/*******************************************************************************************/

/******************* GENERE UN MOT DE PASSE ****************************/
function Genere_Password($size)
	{
		// Initialisation des caract√®res utilisables
		$characters = array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9);
		for($i=0;$i<$size;$i++)
			{
				$password .= ($i%2) ? strtoupper($characters[array_rand($characters)]) : $characters[array_rand($characters)];
			}
		return $password;
	}
/*******************************************************************************************/

/************************** REMPLACER ACCENT ***************************/
function EnleverAccent($mot)
	{
		$mot = str_replace("‚", "&acirc;", $mot);
		$mot = str_replace("‡", "&agrave;", $mot);
		$mot = str_replace("¿", "&agrave;", $mot);
		$mot = str_replace("È", "&eacute;", $mot);
		$mot = str_replace("…", "&eacute;", $mot);
		$mot = str_replace("Í", "&ecirc;", $mot);
		$mot = str_replace("Ë", "&egrave;", $mot);
		$mot = str_replace("»", "&egrave;", $mot);
		$mot = str_replace("Î", "&euml;", $mot);
		$mot = str_replace("Ó", "&icirc;", $mot);
		$mot = str_replace("Ô", "&iuml;", $mot);
		$mot = str_replace("Ù", "&ocirc;", $mot);
		$mot = str_replace("ú", "&oelig;", $mot);
		$mot = str_replace("˚", "&ucirc;", $mot);
		$mot = str_replace("˘", "&ugrave;", $mot);
		$mot = str_replace("¸", "&uuml;", $mot);
		$mot = str_replace("Á", "&ccedil;", $mot);
		$mot = str_replace("ﬂ", "&szlig;", $mot);
		$mot = str_replace("¯", "&oslash;", $mot);
		$mot = str_replace("–", "&ETH;", $mot);
		$mot = str_replace("ÿ", "&Oslash;", $mot);
		$mot = str_replace("ﬁ", "&THORN;", $mot);
		$mot = str_replace("˛", "&thorn;", $mot);
		$mot = str_replace("≈", "&Aring;", $mot);
		$mot = str_replace("'", "\'", $mot);
		$mot = str_replace("Ò", "n", $mot);
		$mot = str_replace("Û", "o", $mot);
		$mot = str_replace("”", "O", $mot);
		$mot = str_replace("Õ", "I", $mot);
		$mot = str_replace("·", "a", $mot);

		return $mot;
	}
function EnleverAccent1($mot)
	{
		$mot = str_replace("‚", "a", $mot);
		$mot = str_replace("‡", "a", $mot);
		$mot = str_replace("¿", "a", $mot);
		$mot = str_replace("È", "e", $mot);
		$mot = str_replace("…", "e", $mot);
		$mot = str_replace("Í", "e", $mot);
		$mot = str_replace("Ë", "e", $mot);
		$mot = str_replace("»", "e", $mot);
		$mot = str_replace("Î", "e", $mot);
		$mot = str_replace("Ó", "i", $mot);
		$mot = str_replace("Ô", "i", $mot);
		$mot = str_replace("Ù", "o", $mot);
		$mot = str_replace("ú", "u", $mot);
		$mot = str_replace("˚", "u", $mot);
		$mot = str_replace("˘", "u", $mot);
		$mot = str_replace("¸", "u", $mot);
		$mot = str_replace("Á", "c", $mot);
		$mot = str_replace("ﬂ", "b", $mot);
		$mot = str_replace("¯", "o", $mot);
		$mot = str_replace("–", "o", $mot);
		$mot = str_replace("ÿ", "o", $mot);
		$mot = str_replace("≈", "a", $mot);
		$mot = str_replace("·", "a", $mot);
		$mot = str_replace("È", "e", $mot);
		$mot = str_replace("Ì", "i", $mot);
		$mot = str_replace("Û", "o", $mot);
		$mot = str_replace("˙", "u", $mot);
		$mot = str_replace("¡", "A", $mot);
		$mot = str_replace("…", "E", $mot);
		$mot = str_replace("Õ", "I", $mot);
		$mot = str_replace("”", "O", $mot);
		$mot = str_replace("⁄", "U", $mot);
		$mot = str_replace("·", "a", $mot);
		$mot = str_replace("È", "e", $mot);
		$mot = str_replace("Ì", "i", $mot);
		$mot = str_replace("Û", "o", $mot);
		$mot = str_replace("˙", "u", $mot);
		$mot = str_replace("Ò", "n", $mot);
		$mot = str_replace("¡", "A", $mot);
		$mot = str_replace("…", "E", $mot);
		$mot = str_replace("Õ", "I", $mot);
		$mot = str_replace("”", "O", $mot);
		$mot = str_replace("⁄", "U", $mot);
		$mot = str_replace("—", "N", $mot);

		return $mot;
	}
//*******************************************************************************************

//************************** FORMAT DATE MOIS **********************************
function TradMoisNum($mois)
	{
		if($mois == 1){return $_SESSION['STrad4'];}
		else if($mois == 2){return $_SESSION['STrad5'];}
		else if($mois == 3){return $_SESSION['STrad6'];}
		else if($mois == 4){return $_SESSION['STrad7'];}
		else if($mois == 5){return $_SESSION['STrad8'];}
		else if($mois == 6){return $_SESSION['STrad9'];}
		else if($mois == 7){return $_SESSION['STrad10'];}
		else if($mois == 8){return $_SESSION['STrad11'];}
		else if($mois == 9){return $_SESSION['STrad12'];}
		else if($mois == 10){return $_SESSION['STrad13'];}
		else if($mois == 11){return $_SESSION['STrad14'];}
		else if($mois == 12){return $_SESSION['STrad15'];}
	}
function TradMoisNumSAccent($mois)
	{
		if($mois == 1){return $_SESSION['STrad4'];}
		else if($mois == 2){return $_SESSION['STrad5'];}
		else if($mois == 3){return $_SESSION['STrad6'];}
		else if($mois == 4){return $_SESSION['STrad7'];}
		else if($mois == 5){return $_SESSION['STrad8'];}
		else if($mois == 6){return $_SESSION['STrad9'];}
		else if($mois == 7){return $_SESSION['STrad10'];}
		else if($mois == 8){return $_SESSION['STrad11'];}
		else if($mois == 9){return $_SESSION['STrad12'];}
		else if($mois == 10){return $_SESSION['STrad13'];}
		else if($mois == 11){return $_SESSION['STrad14'];}
		else if($mois == 12){return $_SESSION['STrad15'];}
	}
function SelectTradMoisNum($mois)
	{
		$Lecture.="<option value=''>- Mois -</option>";
		$Lecture.="<option value='1'";if($mois == 1) {$Lecture.=" selected";} $Lecture.=">".$_SESSION['STrad4']."</option>";
		$Lecture.="<option value='2'";if($mois == 2) {$Lecture.=" selected";} $Lecture.=">".$_SESSION['STrad5']."</option>";
		$Lecture.="<option value='3'";if($mois == 3) {$Lecture.=" selected";} $Lecture.=">".$_SESSION['STrad6']."</option>";
		$Lecture.="<option value='4'";if($mois == 4) {$Lecture.=" selected";} $Lecture.=">".$_SESSION['STrad7']."</option>";
		$Lecture.="<option value='5'";if($mois == 5) {$Lecture.=" selected";} $Lecture.=">".$_SESSION['STrad8']."</option>";
		$Lecture.="<option value='6'";if($mois == 6) {$Lecture.=" selected";} $Lecture.=">".$_SESSION['STrad9']."</option>";
		$Lecture.="<option value='7'";if($mois == 7) {$Lecture.=" selected";} $Lecture.=">".$_SESSION['STrad10']."</option>";
		$Lecture.="<option value='8'";if($mois == 8) {$Lecture.=" selected";} $Lecture.=">".$_SESSION['STrad11']."</option>";
		$Lecture.="<option value='9'";if($mois == 9) {$Lecture.=" selected";} $Lecture.=">".$_SESSION['STrad12']."</option>";
		$Lecture.="<option value='10'";if($mois == 10) {$Lecture.=" selected";} $Lecture.=">".$_SESSION['STrad13']."</option>";
		$Lecture.="<option value='11'";if($mois == 11) {$Lecture.=" selected";} $Lecture.=">".$_SESSION['STrad14']."</option>";
		$Lecture.="<option value='12'";if($mois == 12) {$Lecture.=" selected";} $Lecture.=">".$_SESSION['STrad15']."</option>";

		return $Lecture;
	}

function SelectAfficheAnnee($anneSelect)
	{
		$Lecture.="<option value=''>- ".$_SESSION['STrad16']." -</option>";
		for ($anne = 2012 ; $anne <= date('Y') ; $anne++)
			{
				$Lecture.="<option value='".$anne."'";if($anne == $anneSelect) {$Lecture.=" selected";} $Lecture.=">".$anne."</option>";
			}
		return $Lecture;
	}

function FormatDateTimeMySql($date)
	{
		$date1 = formatdatemysql($date);

		$datecomplet=strtolower($date);
		$heure=substr("$datecomplet", 11, 8);

		return $_SESSION['STrad18']." ".$date1." ".$_SESSION['STrad17']." ".$heure;
	}
function AfficheJours($jour)
	{
		if($jour == 1) {return $_SESSION['STrad19'];}
		else if($jour == 2) {return $_SESSION['STrad20'];}
		else if($jour == 3) {return $_SESSION['STrad21'];}
		else if($jour == 4) {return $_SESSION['STrad22'];}
		else if($jour == 5) {return $_SESSION['STrad23'];}
		else if($jour == 6) {return $_SESSION['STrad24'];}
		else if($jour == 0) {return $_SESSION['STrad25'];}
	}
function JourSemaineSelect($jour)
	{
		$lecture.='<option value=""';if(empty($jour) AND $jour != 0) {$lecture.=' selected';} $lecture.='></option>';
		$lecture.='<option value="1"';if($jour == 1) {$lecture.=' selected';} $lecture.='>'.$_SESSION['STrad19'].'</option>';
		$lecture.='<option value="2"';if($jour == 2) {$lecture.=' selected';} $lecture.='>'.$_SESSION['STrad20'].'</option>';
		$lecture.='<option value="3"';if($jour == 3) {$lecture.=' selected';} $lecture.='>'.$_SESSION['STrad21'].'</option>';
		$lecture.='<option value="4"';if($jour == 4) {$lecture.=' selected';} $lecture.='>'.$_SESSION['STrad22'].'</option>';
		$lecture.='<option value="5"';if($jour == 5) {$lecture.=' selected';} $lecture.='>'.$_SESSION['STrad23'].'</option>';
		$lecture.='<option value="6"';if($jour == 6) {$lecture.=' selected';} $lecture.='>'.$_SESSION['STrad24'].'</option>';
		$lecture.='<option value="0"';if($jour == 0) {$lecture.=' selected';} $lecture.='>'.$_SESSION['STrad25'].'</option>';

		return $lecture;
	}
//*******************************************************************************************


//**************************** AFFICHAGE NOMBRFE D'HEURE *****************************
function minute_vers_heure($minute,$AfficheHeure)
	{
		if($_SESSION['infologlang1'] == "ch")
			{
				if($AfficheHeure == 2)
					{
						$minute = sprintf('%02d H %02d', floor($minute/60), $minute%60);
						return $minute;
					}
				else
					{
						$minute = $minute / 60;
						$minute = number_format($minute, 2, '.', '');
						return $minute." ".$_SESSION['STrad753'];
					}
			}
		else
			{
				if ($minute == 'forfait1' AND !is_numeric($minute))
				{return '1 H / '.$_SESSION['STrad26'];}
				else if ($minute == 'forfait2' AND !is_numeric($minute))
				{return '2 H / '.$_SESSION['STrad26'];}
				else if ($minute == 'forfait3' AND !is_numeric($minute))
				{return '3 H / '.$_SESSION['STrad26'];}
				else if ($minute == 'forfait4' AND !is_numeric($minute))
				{return '4 H / '.$_SESSION['STrad26'];}
				else if($minute < -360)
				{return sprintf('%02d H %02d', floor($minute/60), $minute%60);}
				else if($minute == -15)
				{return "- 15 ".$_SESSION['STrad46'];}
				else if($minute == -30)
				{return "- 30 ".$_SESSION['STrad46'];}
				else if($minute == -45)
				{return "- 45 ".$_SESSION['STrad46'];}
				else if($minute == -60)
				{return "- 1 ".$_SESSION['STrad28'];}
				else if($minute == -75)
				{return "- 1 ".$_SESSION['STrad28']." et 15 ".$_SESSION['STrad46'];}
				else if($minute == -90)
				{return "- 1 ".$_SESSION['STrad28']." et 30 ".$_SESSION['STrad46'];}
				else if($minute == -105)
				{return "- 1 ".$_SESSION['STrad28']." et 45 ".$_SESSION['STrad46'];}
				else if($minute == -120)
				{return "- 2 ".$_SESSION['STrad29'];}
				else if($minute == -135)
				{return "- 2 H 15";}
				else if($minute == -150)
				{return "- 2 H 30";}
				else if($minute == -165)
				{return "- 2 H 45";}
				else if($minute == -180)
				{return "- 3 H";}
				else if($minute == -195)
				{return "- 3 H 15";}
				else if($minute == -210)
				{return "- 3 H 30";}
				else if($minute == -225)
				{return "- 3 H 45";}
				else if($minute == -240)
				{return "- 4 H";}
				else if($minute == -255)
				{return "- 4 H 15";}
				else if($minute == -270)
				{return "- 4 H 30";}
				else if($minute == -285)
				{return "- 4 H 45";}
				else if($minute == -300)
				{return "- 5 H";}
				else if($minute == -315)
				{return "- 5 H 15";}
				else if($minute == -330)
				{return "- 5 H 30";}
				else if($minute == -345)
				{return "- 5 H 45";}
				else if($minute == -360)
				{return "- 6 H";}
				else if($minute == 0)
				{return "0 ".$_SESSION['STrad46'];}
				else if($minute == 15)
				{return "15 ".$_SESSION['STrad46'];}
				else if($minute == 30)
				{return "30 ".$_SESSION['STrad46'];}
				else if($minute == 45)
				{return "45 ".$_SESSION['STrad46'];}
				else if($minute == 60)
				{return "1 ".$_SESSION['STrad28'];}
				else if($minute == 75)
				{return "1 ".$_SESSION['STrad28']." et 15 ".$_SESSION['STrad46'];}
				else if($minute == 90)
				{return "1 ".$_SESSION['STrad28']." et 30 ".$_SESSION['STrad46'];}
				else if($minute == 105)
				{return "1 ".$_SESSION['STrad28']." et 45 ".$_SESSION['STrad46'];}
				else if($minute == 120)
				{return "2 ".$_SESSION['STrad29'];}
				else if($minute == 135)
				{return "2 H 15";}
				else if($minute == 150)
				{return "2 H 30";}
				else if($minute == 165)
				{return "2 H 45";}
				else if($minute == 180)
				{return "3 H";}
				else if($minute == 195)
				{return "3 H 15";}
				else if($minute == 210)
				{return "3 H 30";}
				else if($minute == 225)
				{return "3 H 45";}
				else if($minute == 240)
				{return "4 H";}
				else if($minute == 255)
				{return "4 H 15";}
				else if($minute == 270)
				{return "4 H 30";}
				else if($minute == 285)
				{return "4 H 45";}
				else if($minute == 300)
				{return "5 H";}
				else if($minute == 315)
				{return "5 H 15";}
				else if($minute == 330)
				{return "5 H 30";}
				else if($minute == 345)
				{return "5 H 45";}
				else if($minute == 360)
				{return "6 H";}
				else if($minute > 360)
				{return sprintf('%02d H %02d', floor($minute/60), $minute%60);}
			}
	}
//**********************************************************************************************

//**************************** FONCTION LISTE CLIENT *****************************
function ListeClientsSelect($num)
	{
		$Lecture.="<option value='1'";if($num == 1) {$Lecture.=" selected";} $Lecture.=">-- ".$_SESSION['STrad30']." --</option>";
		$Lecture.="<option value='2'";if($num == 2) {$Lecture.=" selected";} $Lecture.=">-- ".$_SESSION['STrad31']." --</option>";
		$Lecture.="<option value='all'";if($num == "all") {$Lecture.=" selected";} $Lecture.=">-- ".$_SESSION['STrad32']." --</option>";

		return $Lecture;
	}
//********************************************************************************

//*************************** GESTION OUI / NON ***********************************
function AffichQuestSelect($lect)
	{
		$Lecture="<option value='1'";if($lect == 1) {$Lecture.=" selected";} $Lecture.=">".$_SESSION['STrad34']."</option>";
		$Lecture.="<option value='2'";if($lect == 2) {$Lecture.=" selected";} $Lecture.=">".$_SESSION['STrad33']."</option>";

		return $Lecture;
	}
function AffichQuest($question)
	{
		if($question == 1)
		{return $_SESSION['STrad34'];};
		if($question == 2)
		{return $_SESSION['STrad33'];};
	}
//****************************************************************************************

//***************************** ATTRIBUE UN NOM DE FICHIER ************
function AttribueNomFichier($ext,$ConnexionBdd)
	{
		while($i != 2)
			{
				$nom = Genere_Password(30);
				$nom = md5($nom);
				$req1 = 'SELECT count(envmailfichnum) FROM envoi_mail_fichier WHERE envmailfichnom = "'.$nom.$ext.'"';
				$req1Result = $ConnexionBdd ->query($req1) or die ('Erreur SQL !'.$req1.'<br />'.mysqli_error());
				$req1Affich = $req1Result->fetch();
				if($req1Affich[0] == 0) {return $nom.$ext;break;}
			}
	}
//*****************************************************************

//******************************* INDICATEUR REMISE ***********************
function RemiseIndicateur($ind)
	{
		$Lecture.="<option value='%'";if($ind == "%") {$Lecture.=" selected";} $Lecture.=">%</option>";
		$Lecture.="<option value='".$_SESSION['STrad27']."'";if($ind == $_SESSION['STrad27']) {$Lecture.=" selected";} $Lecture.=">".$_SESSION['STrad27']."</option>";

		return $Lecture;
	}
//*************************************************************************

//******************* JOUR FACTURATION AUTO ********************
function FactAutoPeriode($num)
	{
		$Lecture.="'<option value = ''>- ".$_SESSION['STrad382']." -</option>";
		for ($i = 01 ; $i <= 28 ; $i++)
			{
				$Lecture.="<option value='".$i."'";if($i == $num) {$Lecture.=" selected";} $Lecture.=">" .$i. "</option>";
			}
		return $Lecture;
	}
//*******************************************************************

//***************** SEMAINE PAIR OU IMPAIR **************************
function SemainePairImpair($date)
	{
		$date=explode('-',$date);
		$nb = date('W',mktime(0,0,0,$date[1],$date[2],$date[0]));

		if ($nb % 2 == 1)
			{
			   return 1;
			}
		elseif ($nb % 2 == 0)
			{
			   return 2;
			}
	}
//**********************************************************************

//******************************** RESERVATION EN LIGNE **************************
function ReservationNbJourAvant($num)
	{
		$Lecture.="<option value=''";if(empty($num)) {$Lecture.=" selected";} $Lecture.=">-- ".$_SESSION['STrad647']." --</option>";
		$Lecture.="<option value='1'";if($num == 1) {$Lecture.=" selected";} $Lecture.=">".$_SESSION['STrad648']."</option>";
		$Lecture.="<option value='2'";if($num == 2) {$Lecture.=" selected";} $Lecture.=">".$_SESSION['STrad649']."</option>";
		$Lecture.="<option value='3'";if($num == 3) {$Lecture.=" selected";} $Lecture.=">".$_SESSION['STrad650']."</option>";
		$Lecture.="<option value='4'";if($num == 4) {$Lecture.=" selected";} $Lecture.=">".$_SESSION['STrad651']."</option>";
		$Lecture.="<option value='5'";if($num == 5) {$Lecture.=" selected";} $Lecture.=">".$_SESSION['STrad652']."</option>";
		$Lecture.="<option value='6'";if($num == 6) {$Lecture.=" selected";} $Lecture.=">".$_SESSION['STrad653']."</option>";

		return $Lecture;
	}

function ReservationNbJourAvantLect($num)
	{
		if($num == 1) {return $_SESSION['STrad648'];}
		if($num == 2) {return $_SESSION['STrad649'];}
		if($num == 3) {return $_SESSION['STrad650'];}
		if($num == 4) {return $_SESSION['STrad651'];}
		if($num == 5) {return $_SESSION['STrad652'];}
		if($num == 6) {return $_SESSION['STrad653'];}

		return $Lecture;
	}
//***********************************************************************************

//********************** CRERR DES ZIP *************************************
class zipfile
{
    /**
     * Array to store compressed data
     *
     * @var  array    $datasec
     */
    var $datasec      = array();

    /**
     * Central directory
     *
     * @var  array    $ctrl_dir
     */
    var $ctrl_dir     = array();

    /**
     * End of central directory record
     *
     * @var  string   $eof_ctrl_dir
     */
    var $eof_ctrl_dir = "\x50\x4b\x05\x06\x00\x00\x00\x00";

    /**
     * Last offset position
     *
     * @var  integer  $old_offset
     */
    var $old_offset   = 0;


    /**
     * Converts an Unix timestamp to a four byte DOS date and time format (date
     * in high two bytes, time in low two bytes allowing magnitude comparison).
     *
     * @param  integer  the current Unix timestamp
     *
     * @return integer  the current date in a four byte DOS format
     *
     * @access private
     */
    function unix2DosTime($unixtime = 0) {
        $timearray = ($unixtime == 0) ? getdate() : getdate($unixtime);

        if ($timearray['year'] < 1980) {
            $timearray['year']    = 1980;
            $timearray['mon']     = 1;
            $timearray['mday']    = 1;
            $timearray['hours']   = 0;
            $timearray['minutes'] = 0;
            $timearray['seconds'] = 0;
        } // end if

        return (($timearray['year'] - 1980) << 25) | ($timearray['mon'] << 21) | ($timearray['mday'] << 16) |
                ($timearray['hours'] << 11) | ($timearray['minutes'] << 5) | ($timearray['seconds'] >> 1);
    } // end of the 'unix2DosTime()' method


    /**
     * Adds "file" to archive
     *
     * @param  string   file contents
     * @param  string   name of the file in the archive (may contains the path)
     * @param  integer  the current timestamp
     *
     * @access public
     */
    function addFile($data, $name, $time = 0)
    {
        $name     = str_replace('\\', '/', $name);

        $dtime    = dechex($this->unix2DosTime($time));
        $hexdtime = '\x' . $dtime[6] . $dtime[7]
                  . '\x' . $dtime[4] . $dtime[5]
                  . '\x' . $dtime[2] . $dtime[3]
                  . '\x' . $dtime[0] . $dtime[1];
        eval('$hexdtime = "' . $hexdtime . '";');

        $fr   = "\x50\x4b\x03\x04";
        $fr   .= "\x14\x00";            // ver needed to extract
        $fr   .= "\x00\x00";            // gen purpose bit flag
        $fr   .= "\x08\x00";            // compression method
        $fr   .= $hexdtime;             // last mod time and date

        // "local file header" segment
        $unc_len = strlen($data);
        $crc     = crc32($data);
        $zdata   = gzcompress($data);
        $zdata   = substr(substr($zdata, 0, strlen($zdata) - 4), 2); // fix crc bug
        $c_len   = strlen($zdata);
        $fr      .= pack('V', $crc);             // crc32
        $fr      .= pack('V', $c_len);           // compressed filesize
        $fr      .= pack('V', $unc_len);         // uncompressed filesize
        $fr      .= pack('v', strlen($name));    // length of filename
        $fr      .= pack('v', 0);                // extra field length
        $fr      .= $name;

        // "file data" segment
        $fr .= $zdata;

        // "data descriptor" segment (optional but necessary if archive is not
        // served as file)
        // nijel(2004-10-19): this seems not to be needed at all and causes
        // problems in some cases (bug #1037737)
        //$fr .= pack('V', $crc);                 // crc32
        //$fr .= pack('V', $c_len);               // compressed filesize
        //$fr .= pack('V', $unc_len);             // uncompressed filesize

        // add this entry to array
        $this -> datasec[] = $fr;

        // now add to central directory record
        $cdrec = "\x50\x4b\x01\x02";
        $cdrec .= "\x00\x00";                // version made by
        $cdrec .= "\x14\x00";                // version needed to extract
        $cdrec .= "\x00\x00";                // gen purpose bit flag
        $cdrec .= "\x08\x00";                // compression method
        $cdrec .= $hexdtime;                 // last mod time & date
        $cdrec .= pack('V', $crc);           // crc32
        $cdrec .= pack('V', $c_len);         // compressed filesize
        $cdrec .= pack('V', $unc_len);       // uncompressed filesize
        $cdrec .= pack('v', strlen($name) ); // length of filename
        $cdrec .= pack('v', 0 );             // extra field length
        $cdrec .= pack('v', 0 );             // file comment length
        $cdrec .= pack('v', 0 );             // disk number start
        $cdrec .= pack('v', 0 );             // internal file attributes
        $cdrec .= pack('V', 32 );            // external file attributes - 'archive' bit set

        $cdrec .= pack('V', $this -> old_offset ); // relative offset of local header
        $this -> old_offset += strlen($fr);

        $cdrec .= $name;

        // optional extra field, file comment goes here
        // save to central directory
        $this -> ctrl_dir[] = $cdrec;
    } // end of the 'addFile()' method


    /**
     * Dumps out file
     *
     * @return  string  the zipped file
     *
     * @access public
     */
    function file()
    {
        $data    = implode('', $this -> datasec);
        $ctrldir = implode('', $this -> ctrl_dir);

        return
            $data .
            $ctrldir .
            $this -> eof_ctrl_dir .
            pack('v', sizeof($this -> ctrl_dir)) .  // total # of entries "on this disk"
            pack('v', sizeof($this -> ctrl_dir)) .  // total # of entries overall
            pack('V', strlen($ctrldir)) .           // size of central dir
            pack('V', strlen($data)) .              // offset to start of central dir
            "\x00\x00";                             // .zip file comment length
    } // end of the 'file()' method

}
//*******************************************************************************************

?>
