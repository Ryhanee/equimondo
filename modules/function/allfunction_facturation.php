<?php
//******************************** CALCUL HT, TVA, TTC, ETC ... D'UNE FACTURE ****************************
function FactCalc($factnum,$ConnexionBdd)
	{
		$InfoBulle.= '<table style="font-size:24px;width:100%;">';
		$req = 'SELECT factprestation_prix.factprestprixstatprixht,factprestqte,factprestlibe,sum(factprestation_prix.factprestprixstatprixttc) FROM factprestation,factprestation_prix WHERE factprestation_factprestnum = factprestnum AND factures_factnum = "'.$factnum.'" GROUP BY factprestnum';
		$reqResult = $ConnexionBdd ->query($req) or die ('Erreur SQL !'.$req.'<br />'.mysqli_error());
		while($reqAffich = $reqResult->fetch())
			{
				$InfoBulle.= "<tr><td style='width:70%;'>".$reqAffich[2]."</td><td style='width:30%;'><b>".$reqAffich[3]." ".$_SESSION['STrad27']."</b></td></tr>";
				$InfoBulleMontantTtc = $InfoBulleMontantTtc + $reqAffich[3];
			}
		$InfoBulle.="<tr><td colspan='2'><hr></td></tr>";
		$InfoBulle.= "<tr><td style='vertical-align:middle;'><b style='float:right;font-weight:bolder;'>".$_SESSION['STrad42']." = </b></td><td style='vertical-align:middle;'><b style='font-weight:bolder;'>".$InfoBulleMontantTtc." ".$_SESSION['STrad27']."</b></td></tr>";
		$InfoBulle.= "</table>";

		$req = 'SELECT sum(factprestprixstatprixht) FROM factprestation,factprestation_prix WHERE factprestation_factprestnum = factprestnum AND factures_factnum = "'.$factnum.'"';
		$reqResult = $ConnexionBdd ->query($req) or die ('Erreur SQL !'.$req.'<br />'.mysqli_error());
		$reqAffich = $reqResult->fetch();
		$TotalMontantHt = round($reqAffich[0],"2");

		// Affiche les escomptes
		$reqEsc = 'SELECT facttauxescompte,facttype FROM factures WHERE factnum = "'.$factnum.'"';
		$reqEscResult = $ConnexionBdd ->query($reqEsc) or die ('Erreur SQL !'.$reqEsc.'<br />'.mysqli_error());
		$reqEscAffich = $reqEscResult->fetch();
		if($reqEscAffich[0] > 0)
			{
				$TotalMontantEsc = $TotalMontantHt * $reqEscAffich[0];
				$TotalMontantEsc = round($TotalMontantEsc,"2");
				$TauxEsc = $reqEscAffich[0] * 100;
				$TotalMontant = $TotalMontantHt - $TotalMontantEsc;
			}
		else
			{
				$TotalMontantEsc = round(0,"2");
				$TotalMontant = $TotalMontantHt;
			}

		// Affiche les taux de TVA
		$reqTvaSelect = 'SELECT sum(factprestprixstatprixtva) FROM factprestation,factprestation_prix WHERE factprestation_factprestnum = factprestnum AND factures_factnum = "'.$factnum.'"';
		$reqTvaSelectResult = $ConnexionBdd ->query($reqTvaSelect) or die ('Erreur SQL !'.$reqTvaSelect.'<br />'.mysqli_error());
		$reqTvaSelectAffich = $reqTvaSelectResult->fetch();
		$MontantTotalTva = round($reqTvaSelectAffich[0],"2");
		if($_SESSION['infologlang2'] == "ca")
			{
				$reqTvaSelect = 'SELECT sum(factprestprixstatprixtva1) FROM factprestation,factprestation_prix WHERE factprestation_factprestnum = factprestnum AND factures_factnum = "'.$factnum.'"';
				$reqTvaSelectResult = $ConnexionBdd ->query($reqTvaSelect) or die ('Erreur SQL !'.$reqTvaSelect.'<br />'.mysqli_error());
				$reqTvaSelectAffich = $reqTvaSelectResult->fetch();
				$MontantTotalTva = $MontantTotalTva + $reqTvaSelectAffich[0];
				$MontantTotalTva = round($MontantTotalTva,"2");
			}

		// Affiche total TTC
		$TotalMontant = $TotalMontant + $MontantTotalTva;

		// CALCUL ENCAISSEMENT
		$req = 'SELECT factprestnum FROM factprestation WHERE factures_factnum = "'.$factnum.'"';
		$reqResult = $ConnexionBdd ->query($req) or die ('Erreur SQL !'.$req.'<br />'.mysqli_error());
		while($reqAffich = $reqResult->fetch())
			{
				$InfoFactPrest = CalcPrest($reqAffich[0],$ConnexionBdd);
				$TotalEncaissement = $TotalEncaissement + $InfoFactPrest[0];
			}

		$TotalMontant = round($TotalMontant,"2");
		$TotalEncaissement = round($TotalEncaissement,"2");
		$TotalMontantRestant = $TotalMontant - $TotalEncaissement;

		// Calcul les avoirs
		$NumAvoir = VerifAvoir($factnum,$ConnexionBdd);

		// S'il y avait une diffï¿½rence depuis la mise ï¿½ jour de septembre 2014
		$reqDiff = 'SELECT factdiffmontant FROM factures_difference WHERE factures_factnum = "'.$factnum.'"';
		$reqDiffResult = $ConnexionBdd ->query($reqDiff) or die ('Erreur SQL !'.$reqDiff.'<br />'.mysqli_error());
		$reqDiffAffich = $reqDiffResult->fetch();

		if($reqDiffAffich[0] > 0) {$TotalMontantRestant = $TotalMontantRestant - $reqDiffAffich[0];$TotalEncaissement = $TotalEncaissement + $reqDiffAffich[0];}
		if($reqDiffAffich[0] < 0) {$TotalMontantRestant = $TotalMontantRestant - $reqDiffAffich[0];$TotalEncaissement = $TotalEncaissement - $reqDiffAffich[0];}

		$TotalMontantRestant = $TotalMontantRestant - $NumAvoir;
		$TotalMontantRestant = round($TotalMontantRestant,"2");

		// INFOBULLE POUR L ENVOI DE LA FACTURE PAR MAIL
		$EnvoiMail = 0;
		$req = 'SELECT * FROM envoi_mail,envoi_mail_participants WHERE envmail_envmailnum = envmailnum AND factures_factnum = "'.$factnum.'"';
		$reqResult = $ConnexionBdd ->query($req) or die ('Erreur SQL !'.$req.'<br />'.mysqli_error());
		while($reqAffich = $reqResult->fetch())
			{
				$EnvoiMail = $EnvoiMail + 1;
				$InfoBulleMail.=FormatDateTimeMySql($reqAffich['envmaildatetime'])."<br>";
			}
		if($EnvoiMail >= 1) {$InfoBulleMail=$_SESSION['STrad43']." : <br>".$InfoBulleMail;}
		else {$InfoBulleMail = $_SESSION['STrad44'];}

		$InfoBulle = str_replace("'"," ",$InfoBulle);
		$InfoBulle = str_replace('"'," ",$InfoBulle);
		$InfoBulle= str_replace('<br />', ' ', nl2br($InfoBulle));
		$InfoBulle= str_replace('<br/>', ' ', nl2br($InfoBulle));
		$InfoBulle= str_replace('&quot;', ' ', $InfoBulle);


		// Montant HT, Montant TVA, Montant TTC, Acompte(s) encaissement(s)
		return array ($TotalMontantHt,$MontantTotalTva,$TotalMontant,$TotalEncaissement,$TotalMontantRestant,$NumAvoir,$TotalMontantEsc,$InfoBulle,$InfoBulleMail);
	}
//************************************************************************************************************************

//********************* CALCUL LE RESTANT DU D UNE PRESTATION *********************************
function CalcPrest($factprestnum,$ConnexionBdd)
	{
		$reqCountEnc = 'SELECT SUM(factencassostatmontant) FROM factures_factencaisser,factures_factencaisser_stat,factencaisser WHERE factencaisser_factencnum = factencnum AND factures_factencaisser_factencassonum = factencassonum AND factprestation_factprestnum = "'.$factprestnum.'"';
		$reqCountEncResult = $ConnexionBdd ->query($reqCountEnc) or die ('Erreur SQL !'.$reqCountEnc.'<br />'.mysql_error());
		$reqCountEncAffich = $reqCountEncResult->fetch();

		$reqFactPrest = 'SELECT SUM(factprestprixstatprixht),SUM(factprestprixstatprixtva),SUM(factprestprixstatprixtva1) FROM factprestation_prix WHERE factprestation_factprestnum = "'.$factprestnum.'"';
		$reqFactPrestResult = $ConnexionBdd ->query($reqFactPrest) or die ('Erreur SQL !'.$reqFactPrest.'<br />'.mysql_error());
		$reqFactPrestAffich = $reqFactPrestResult->fetch();
		$TotalTtc = $reqFactPrestAffich[0] + $reqFactPrestAffich[1] + $reqFactPrestAffich[2];

		$RestantDu = $TotalTtc - $reqCountEncAffich[0];
		$RestantDu = round($RestantDu,"2");

		return array($reqCountEncAffich[0],$reqFactPrestAffich[0],$RestantDu,$TotalTtc,$reqFactPrestAffich[1]);
	}
//****************************************************************************************************

//****************************** VERIF S'IL Y A UN AVOIR ******************************************
function VerifAvoir($factnum,$ConnexionBdd)
	{
		if(!empty($factnum))
		{
		$MontantAvoir = 0;

		$reqCountNb = 'SELECT count(factassonum) FROM factures_association WHERE factures_factnum1 = "'.$factnum.'" OR factures_factnum2 = "'.$factnum.'"';
		$reqCountNbResult = $ConnexionBdd ->query($reqCountNb) or die ('Erreur SQL !'.$reqCountNb.'<br />'.mysql_error());
		$reqCountNbAffich = $reqCountNbResult->fetch();

			// S'il y en a
			if($reqCountNbAffich[0] >= 1)
				{
					$reqNb = 'SELECT factures_factnum2,facttype,factdate,factnumlibe,factnum FROM factures_association,factures WHERE factures_association.factures_factnum2=factures.factnum AND factures_factnum1 = "'.$factnum.'" AND facttype = "5"';
					$reqNbResult = $ConnexionBdd ->query($reqNb) or die ('Erreur SQL !'.$reqNb.'<br />'.mysql_error());
					while($reqNbAffich = $reqNbResult->fetch())
						{
							$Total1 = 0;
							$TotalRembourssement = 0;
							$req1 = 'SELECT sum(factprestprixstatprixttc) FROM factures,factprestation,factprestation_prix WHERE factures_factnum = factnum AND factprestation_factprestnum = factprestnum AND factures.factnum = "'.$reqNbAffich[0].'"';
							$req1Result = $ConnexionBdd ->query($req1) or die ('Erreur SQL !'.$req1.'<br />'.mysql_error());
							$req1Affich = $req1Result->fetch();

							$MontantAvoir = $MontantAvoir + $req1Affich[0];

							$reqNb1 = 'SELECT factures_factnum1,facttype,factdate,factnumlibe,factnum FROM factures_association,factures WHERE factures_association.factures_factnum1=factures.factnum AND factures_factnum2 = "'.$reqNbAffich[0].'" AND facttype = "4" AND factnum != "'.$factnum.'"';
							$reqNb1Result = $ConnexionBdd ->query($reqNb1) or die ('Erreur SQL !'.$reqNb1.'<br />'.mysql_error());
							while($reqNb1Affich = $reqNb1Result->fetch())
								{

									$req1 = 'SELECT sum(factprestprixstatprixttc) FROM factures,factprestation,factprestation_prix WHERE factures_factnum = factnum AND factprestation_factprestnum = factprestnum AND factures.factnum = "'.$reqNb1Affich[0].'"';
									$req1Result = $ConnexionBdd ->query($req1) or die ('Erreur SQL !'.$req1.'<br />'.mysql_error());
									$req1Affich = $req1Result->fetch();
									$Total1 = $Total1 + $req1Affich[0];

									// CALCUL ENCAISSEMENT
									$req = 'SELECT factprestnum FROM factprestation WHERE factures_factnum = "'.$reqNb1Affich[0].'"';
									$reqResult = $ConnexionBdd ->query($req) or die ('Erreur SQL !'.$req.'<br />'.mysqli_error());
									while($reqAffich = $reqResult->fetch())
										{
											$InfoFactPrest = CalcPrest($reqAffich[0],$ConnexionBdd);
											$Total1 = $Total1 - $InfoFactPrest[0];
										}

									// S'il y avait une diffï¿½rence depuis la mise ï¿½ jour de septembre 2014
									$reqDiff = 'SELECT factdiffmontant FROM factures_difference WHERE factures_factnum = "'.$reqNb1Affich[0].'"';
									$reqDiffResult = $ConnexionBdd ->query($reqDiff) or die ('Erreur SQL !'.$reqDiff.'<br />'.mysqli_error());
									$reqDiffAffich = $reqDiffResult->fetch();
									$Total1 = $Total1 - $reqDiffAffich[0];
								}
							$MontantAvoir = $MontantAvoir - $Total1;

							// CALCUL REMBOURSSEMENT
							$req = 'SELECT factprestnum FROM factprestation WHERE factures_factnum = "'.$reqNbAffich[0].'"';
							$reqResult = $ConnexionBdd ->query($req) or die ('Erreur SQL !'.$req.'<br />'.mysqli_error());
							while($reqAffich = $reqResult->fetch())
								{
									$InfoFactPrest = CalcPrest($reqAffich[0],$ConnexionBdd);
									$TotalRembourssement = $TotalRembourssement + $InfoFactPrest[0];
								}
							$MontantAvoir = $MontantAvoir + $TotalRembourssement;
						}

				}

		return $MontantAvoir;
		}
	}
//****************************************************************************************************

//***************************** PREFIXE NUMERO FACTURE ****************************************
function FactPrefLect($date,$num,$version,$conflogfactprefixe)
	{
		if(empty($_SESSION['conflogfactprefixe'])) {$_SESSION['conflogfactprefixe'] = $conflogfactprefixe;}

		if($_SESSION['conflogfactprefixe'] == 1) {$anne=substr("$date", 0, 4);$num = $anne.$num;}
		else if($_SESSION['conflogfactprefixe'] == 2) {$anne=substr("$date", 0, 4);$mois=substr("$date", 5, 2);$num = $anne.$mois.$num;}

		if($version == 2)
			{
				$num = substr('0000000'.$num,-6);
			}
		if($version == 6) {$num = substr('0000000'.$num,-10);}

		return $num;
	}
//*******************************************************************************************

//****************************** INDICE MODULE FACTURATION ******************************
function FactIndLect($indice,$prefixe)
	{
		if($indice == 1) {if($prefixe == 1) {$Lecture.=$_SESSION['STrad49']." ";} $Lecture.=$_SESSION['STrad50'];return $Lecture;}
		if($indice == 2) {if($prefixe == 1) {$Lecture.=$_SESSION['STrad49']." ";} $Lecture.=$_SESSION['STrad51'];return $Lecture;}
		if($indice == 4) {if($prefixe == 1) {$Lecture.=$_SESSION['STrad48']." ";} $Lecture.=$_SESSION['STrad47'];return $Lecture;}
		if($indice == 5) {if($prefixe == 1) {$Lecture.=$_SESSION['STrad49']." ";} $Lecture.=$_SESSION['STrad52'];return $Lecture;}
		if($indice == 7) {if($prefixe == 1) {$Lecture.=$_SESSION['STrad49']." ";} $Lecture.=$_SESSION['STrad53'];return $Lecture;}
		if($indice == 8) {if($prefixe == 1) {$Lecture.=$_SESSION['STrad49']." ";} $Lecture.=$_SESSION['STrad259'];return $Lecture;}
	}
//************************************************************************************

//****************************** INDICE MODULE FACTURATION ******************************
function FactCalcClie($Dossier,$ConnexionBdd,$clienum,$date1,$date2)
	{
		// FACTURES SOLDE
		$req1 = 'SELECT * FROM factures WHERE clients_clienum = "'.$clienum.'" AND facttype ="4"';
		if(!empty($date1) AND !empty($date2)) {$req1.= ' AND factdate BETWEEN "'.$date1.'" AND "'.$date2.'"';}
		$req1Result = $ConnexionBdd ->query($req1) or die ('Erreur SQL !'.$req1.'<br />'.mysqli_error());
		while($req1Affich = $req1Result->fetch())
			{
				$FactCalc = FactCalc($req1Affich['factnum'],$ConnexionBdd);
				$MontantTtc = $MontantTtc + $FactCalc[2];
				$MontantHt = $MontantHt + $FactCalc[0];
			}

		// AVOIRS
		$req1 = 'SELECT * FROM factures WHERE clients_clienum = "'.$clienum.'" AND facttype ="5"';
if(!empty($date1) AND !empty($date2)) {$req1.= ' AND factdate BETWEEN "'.$date1.'" AND "'.$date2.'"';}
		$req1Result = $ConnexionBdd ->query($req1) or die ('Erreur SQL !'.$req1.'<br />'.mysqli_error());
		while($req1Affich = $req1Result->fetch())
			{
				$FactCalc = FactCalc($req1Affich['factnum'],$ConnexionBdd);
				$MontantTtcAvoir = $MontantTtcAvoir + $FactCalc[2];
				$MontantHtAvoir = $MontantHtAvoir + $FactCalc[0];
			}

		// TOTAL
		$MontantTtc = $MontantTtc - $MontantTtcAvoir;
		$MontantHt = $MontantHt - $MontantHtAvoir;

		// NB HEURE
		$req1 = 'SELECT sum(cliesoldforfsortnbheure),sum(cliesoldforfsortmontant) FROM clientssoldeforfsortie WHERE clients_clienum = "'.$clienum.'"';
		if(!empty($date1) AND !empty($date2)) {$req1.=' AND cliesoldforfsortdate BETWEEN "'.$date1.'" AND "'.$date2.'"';}
		$req1Result = $ConnexionBdd ->query($req1) or die ('Erreur SQL !'.$req1.'<br />'.mysqli_error());
		$req1Affich = $req1Result->fetch();
		$NbHeure = $req1Affich[0];
		$MontantNbHeure = $req1Affich[1];

		return array ($MontantHt,$MontantTtc,$NbHeure,$MontantNbHeure);
	}
//************************************************************************************

//************************************* LSITE DES FACTURES **************************************
function FactListFich($Dossier,$ConnexionBdd,$facttype,$clienum,$AfficheDroite,$AffichePrelevement)
	{
		if(!empty($facttype)) {$facttype = $facttype;}
		else if(!empty($_GET['facttype'])) {$facttype = $_GET['facttype'];}
		else if(!empty($_SESSION['facttype'])) {$facttype = $_SESSION['facttype'];}

		$_SESSION['facttype'] = $facttype;

		if(empty($_GET['DebutListe'])) {$DebutListe = 0;}
		else {$DebutListe = $_GET['DebutListe'];}

		$LectureClient.="<table class='tab_rubrique' style='width:100%;'>";
		$LectureClient.="<thead>";
			$LectureClient.="<tr>";
				if(empty($clienum)) {$LectureClient.='<td><input onclick="CocheTout(this, \'factnum[]\');" type="checkbox" style="margin-left:15px;"></td>';}
				$LectureClient.="<td>".$_SESSION['STrad334']."</td>";
				$LectureClient.="<td>".$_SESSION['STrad88']."</td>";
				$LectureClient.="<td class='supp400px'>".$_SESSION['STrad92']."</td>";
				$LectureClient.="<td class='supp400px'>".$_SESSION['STrad91']."</td>";
				$LectureClient.="<td class='supp400px'>".$_SESSION['STrad335']."</td>";
				$LectureClient.="<td class='supp400px'>".$_SESSION['STrad311']."</td>";
				$LectureClient.="<td>".$_SESSION['STrad2']."</td>";
			$LectureClient.="</tr>";
		$LectureClient.="</thead>";

		$Lecture.="<table style='width:100%;'>";
		$req= 'SELECT * FROM factures,clients';
		if(!empty($_GET['rechprestnum'])) {$req.=',factprestation';}
		$req.=' WHERE factsupp = "1" AND factures.clients_clienum = clienum AND factures.AA_equimondo_hebeappnum = "'.$_SESSION['hebeappnum'].'"';
		if(!empty($clienum))
			{
				$reqClie = 'SELECT familleclients_famiclienum FROM clients WHERE clienum = "'.$clienum.'"';
				$reqClieResult = $ConnexionBdd ->query($reqClie) or die ('Erreur SQL !'.$reqClie.'<br />'.mysqli_error());
				$reqClieAffich = $reqClieResult->fetch();
				if(!empty($reqClieAffich[0]))
					{
						$req.=' AND familleclients_famiclienum = "'.$reqClieAffich[0].'"';
					}
				else if(!empty($clienum)) {$req.=' AND clients_clienum = "'.$clienum.'"';}
				$req.=' AND facttype != "5"';
			}
		else {$req.=' AND facttype = "'.$facttype.'"';}
		if(!empty($_GET['rechfactclienom'])) {$req.=' AND clienom LIKE "'.$_GET['rechfactclienom'].'%"';}
		if(!empty($_GET['rechfactprenom'])) {$req.=' AND clieprenom LIKE "'.$_GET['rechfactclieprenom'].'%"';}
		if(!empty($_GET['rechprestnum'])) {$req.=' AND factures_factnum = factnum';}
		if(!empty($_GET['rechprestnum'])) {$req.=' AND typeprestation_typeprestnum = "'.$_GET['rechprestnum'].'"';}
		if(!empty($_GET['rechfactnumlibe'])) {$req.=FactPrefLectSql($_GET['rechfactnumlibe']);}
		if(!empty($_GET['rechfactdate1']) AND !empty($_GET['rechfactdate2'])) {$req.=' AND factdate BETWEEN "'.$_GET['rechfactdate1'].'" AND "'.$_GET['rechfactdate2'].'"';}
		$req.=' GROUP BY factnum';
		$req.=' ORDER BY factnum DESC';
		if(empty($clienum) AND $_GET['factrechind'] != 2) {$req.=' LIMIT '.$DebutListe.',25';}
		$reqResult = $ConnexionBdd ->query($req) or die ('Erreur SQL !'.$req.'<br />'.mysqli_error());
		while($reqAffich = $reqResult->fetch())
			{
				$InfoFact = FactCalc($reqAffich['factnum'],$ConnexionBdd);

				if($_GET['factnonpaye'] == 2 AND $facttype == 4 AND $InfoFact[4] == 0) {$AutoAffi = 1;}
				else {$AutoAffi = 2;}
				if($facttype != 4) {$AfficheColor = "text-align:center;padding:5px;color:black;border-color:color:rgba(255, 66, 0, 0);border-style: solid;border-width:0px;-webkit-border-radius: 20px;-moz-border-radius:20px;border-radius: 20px;-webkit-appearance: none;";}
				else if($InfoFact[4] != 0)
					{
						$AfficheColor = "text-align:center;padding:5px;color:rgba(255, 66, 0, 1);background-color:color:rgba(255, 66, 0, 0.5);border-color:color:rgba(255, 66, 0, 1);border-style: solid;border-width:1px;-webkit-border-radius: 20px;-moz-border-radius:20px;border-radius: 20px;-webkit-appearance: none;";
						$LibeStatus = $_SESSION['STrad118'];
					}
				else
					{
						$AfficheColor = "text-align:center;padding:5px;color:rgba(72, 255, 0, 1);background-color:color:rgba(72, 255, 0, 0.5);border-color:color:rgba(72, 255, 0, 1);border-style: solid;border-width:1px;-webkit-border-radius: 20px;-moz-border-radius:20px;border-radius: 20px;-webkit-appearance: none;";
						$LibeStatus = $_SESSION['STrad117'];
					}

				if($facttype == 4)
					{
						if($InfoFact[4] == 0) {$Montant1 = $_SESSION['STrad117'];}
						else {$Montant1 = number_format($InfoFact[4], 2, '.', '')." ".$_SESSION['STrad27'];}
						$Montant2 = number_format($InfoFact[2], 2, '.', '')." ".$_SESSION['STrad27'];
					}
				else {$Montant1 = number_format($InfoFact[2], 2, '.', '')." ".$_SESSION['STrad27'];$Montant2="";}

				if(($_SESSION['ResolutionConnexion1'] < 800 OR !empty($clienum) AND $AfficheDroite!= 2) OR $AffichePrelevement == 2)
					{
						$Lien = "<a href='".$Dossier."modules/facturation/modfactfichcomplet1.php?factnum=".$reqAffich['factnum']."' class='LoadPage AfficheFicheFacture1'>";
					}
				else
					{
						$Lien = "<a href='".$Dossier."modules/facturation/modfactfichcomplet2.php?factnum=".$reqAffich['factnum']."' class='LoadPage AfficheFicheFacture2'>";
						$InfoBulle = '<span onmouseover=\'afficher_bulle("<em><div class=infobulle2>'.$InfoFact[7].'</div></em>", "white", event);\' onmouseout="masquer_bulle();" class="infobulle1">';
						$InfoBullePaie = '<span onmouseover=\'afficher_bulle("<em><div class=infobulle2>'.$_SESSION['STrad107'].'</div></em>", "white", event);\' onmouseout="masquer_bulle();" class="infobulle1">';
					}

				if($AutoAffi == 2)
					{
						$Lecture.="<tr>";
							$Lecture.="<td style='width:10%;float:left;'>";
							$Lecture.="<input type='checkbox' name='factnum[]' value='".$reqAffich['factnum']."'>";
							$Lecture.="<div style='background:#FFD95C;width:40%;margin-left:15%;height:42px;'></div>";
			        $Lecture.="<div style='background:#FFCCF9;width:40%;margin-left:15%;height:42px;'></div>";
			        $Lecture.="<div style='background:#99D8F4;width:40%;margin-left:15%;height:42px;'></div>";
							$Lecture.="</td>";
							$Lecture.="<td style='width:90%;float:left;'>".$InfoBulle.$Lien;

							$Lecture.="<section style='width:100%;clear:both;dislay:block;margin-bottom:15px;";
							if($_SESSION['ResolutionConnexion1'] <= 800) {$Lecture.="margin-top:-15px;";} else {$Lecture.="margin-top:-50px;";}
							$Lecture.="'>";
							$Lecture.="<section style='width:49%;margin-right:1%;float:left;'>";
								$Lecture.="<div style='margin-bottom:15px;'>".$reqAffich['clienom']." ".$reqAffich['clieprenom']."</div>";
								if($facttype == 8) {$Lecture.="<div>".$reqAffich['factnumlibe']."</div>";}
								else if($facttype != 7) {$Lecture.="<div>".FactIndLect($reqAffich['facttype'],null)." N° ".FactPrefLect($reqAffich[1],$reqAffich[2])."</div>";}
							$Lecture.="</section>";

							$Lecture.="<section style='width:39%;float:left;margin-left:1%;'>";
								$Lecture.="<div style='text-align:center;margin-bottom:15px;'>".formatdatemysql($reqAffich['factdate'])."</div>";
								$Lecture.="<div style='".$AfficheColor."'>".$Montant1."</div>";
								if(!empty($Montant2)) {$Lecture.="<div style='width:100%;font-size:22px;'>".$_SESSION['STrad335']." : ".$Montant2."</div>";}
							$Lecture.="</section>";
							$Lecture.="</section>";

							$LectureClient.="<tr>";
								if(empty($clienum)) {$LectureClient.="<td><input type='checkbox' name='factnum[]' value='".$reqAffich['factnum']."'></td>";}
								$LectureClient.="<td>".$InfoBulle.$Lien.FactIndLect($reqAffich['facttype'])."<a></span></td>";
								$LectureClient.="<td>".$InfoBulle.$Lien.formatdatemysql($reqAffich['factdate'])."<a></span></td>";
								$LectureClient.="<td class='supp400px'>".$InfoBulle.$Lien.FactPrefLect($reqAffich[1],$reqAffich[2])."<a></span></td>";
								$LectureClient.="<td class='supp400px'>".$InfoBulle.$Lien.$reqAffich['clienom']." ".$reqAffich['clieprenom']."<a></span></td>";
								$InfoFact[2] = number_format($InfoFact[2], 2, '.', '');
								$LectureClient.="<td class='supp400px'>".$InfoBulle.$Lien.$InfoFact[2]." ".$_SESSION['STrad27']."<a></span></td>";
								$InfoFact[3] = number_format($InfoFact[3], 2, '.', '');
								$LectureClient.="<td class='supp400px'>".$InfoBulle.$Lien.$InfoFact[3]." ".$_SESSION['STrad27']."<a></span></td>";
								$InfoFact[4] = number_format($InfoFact[4], 2, '.', '');
								$LectureClient.="<td>".$InfoBulle.$Lien.$InfoFact[4]." ".$_SESSION['STrad27']."<a></span></td>";
							$LectureClient.="</tr>";

							if($facttype == 4)
								{
									$reqVerif1 = 'SELECT count(factencnum) FROM factencaisser,factures_factencaisser,factprestation WHERE factencaisser_factencnum = factencnum AND factprestation_factprestnum = factprestnum AND factenctype = "1" AND factprestation.factures_factnum = "'.$reqAffich['factnum'].'"';
									$reqVerif1Result = $ConnexionBdd ->query($reqVerif1) or die ('Erreur SQL !'.$reqVerif1.'<br />'.mysqli_error());
									$reqVerif1Affich = $reqVerif1Result->fetch();
									if($reqVerif1Affich[0] >= 1)
										{
											$LibeModePaie = "";
											$reqEnc = 'SELECT mode_paie_modepaienum FROM factencaisser,factures_factencaisser,factprestation WHERE factencaisser_factencnum = factencnum AND factprestation_factprestnum = factprestnum AND factenctype = "1" AND factprestation.factures_factnum = "'.$reqAffich['factnum'].'" GROUP BY mode_paie_modepaienum';
											$reqEncResult = $ConnexionBdd ->query($reqEnc) or die ('Erreur SQL !'.$reqEnc.'<br />'.mysqli_error());
											while($reqEncAffich = $reqEncResult->fetch()) {$LibeModePaie.=", ".ModePaieLect($reqEncAffich[0],$ConnexionBdd);}

											$LibeModePaie = substr($LibeModePaie, 1, 9999);
											$Lecture.="<section style='width:100%;clear:both;dislay:block;'>";
											$Lecture.="<div style='font-style:italic;'>".$_SESSION['STrad258']." : ".$LibeModePaie."</div>";
											$Lecture.="</section>";
										}
									else if($reqVerif1Affich[0] == 0)
										{
											$Lecture.="<section style='width:100%;clear:both;dislay:block;'>";
											$Lecture.="<div style='font-style:italic;color:red;'>".$_SESSION['STrad422']."</div>";
											$Lecture.="</section>";
										}
								}

							if($facttype == 4 AND $_SESSION['connind'] == "util")
								{
									$Lecture.="<section style='width:100%;clear:both;dislay:block;'>";
									$Lecture.=$InfoBullePaie."<a href='".$Dossier."modules/facturation/modfactEncAjouter.php?factnum=".$reqAffich['factnum']."' class='LoadPage FactEncAjouter buttonLittle3' style='float:right;margin-right:5px;'><img src='".$Dossier."images/facturationBlanc.png' class='ImgSousMenu2'>".$_SESSION['STrad107']."</a></span>";
									$Lecture.="</section>";
								}
							$Lecture.="</td>";
						$Lecture.="</tr>";
						if($facttype != 4) {$Lecture.="<tr><td colspan='2' style='height:10px;width:100%;'></td></tr>";}
					}
			}

		$_SESSION['AfficheFactListMultiple'] = $_SESSION['AfficheFactListMultiple'] + 1;
		$DebutListe = $DebutListe + 25;
		$VariableLien = "DebutListe=".$DebutListe."&facttype=".$facttype."&clienom=".$_GET['rechfactclienom']."&clieprenom=".$_GET['rechfactclieprenom']."&factnonpaye=".$_GET['factnonpaye']."&clienum=".$clienum."&rechfactdate1=".$_GET['rechfactdate1']."&rechfactdate2=".$_GET['rechfactdate2']."&rechfactnumlibe=".$_GET['rechfactnumlibe'];

		$_SESSION['rechfactclienom'] = $_GET['rechfactclienom'];
		$_SESSION['rechfactclieprenom'] = $_GET['rechfactclieprenom'];
		$_SESSION['rechfactnumlibe'] = $_GET['rechfactnumlibe'];
		$_SESSION['rechfactdate1'] = $_GET['rechfactdate1'];
		$_SESSION['rechfactdate2'] = $_GET['rechfactdate2'];

		if(empty($clienum))
			{
				$Lecture.="<tr style='height:15px;'></tr>";
				$Lecture.="<tr><td colspan='2'><div id='AfficheFactListMultiple".$_SESSION['AfficheFactListMultiple']."' style='margin-bottom:30px;'>";
				$Lecture.="<center><a href='".$Dossier."modules/facturation/modfactlist1.php?".$VariableLien."' class='LoadPage AfficheFactListMultiple".$_SESSION['AfficheFactListMultiple']." button'><img src='".$Dossier."images/ListerBas.png' class='ImgSousMenu2'>".$_SESSION['STrad162']." ".FactIndLect($facttype,null)."</a></center>";
				$Lecture.="</div></td></tr>";
			}
		$Lecture.="</table>";
		$LectureClient.="</table>";

		return array($Lecture,$Export,$LectureClient);
	}
//****************************************************************************************************

//******************************* REQUETE POUR LES PREFIXE FACTURE ***********************************
function FactPrefLectSql($factnumlibe)
	{
		if($_SESSION['conflogfactprefixe'] == 1) {$anne=substr("$factnumlibe", 0, 4);$num=substr("$factnumlibe", 4, 4);$requete=' AND YEAR(factdate) = "'.$anne.'" AND factnumlibe = "'.$num.'"';return $requete;}
		else if($_SESSION['conflogfactprefixe'] == 2) {$anne=substr("$factnumlibe", 0, 4);$mois=substr("$factnumlibe", 4, 2);$num=substr("$factnumlibe", 6, 4);$requete=' AND YEAR(factdate) = "'.$anne.'" AND MONTH(factdate) = "'.$mois.'" AND factnumlibe = "'.$num.'"';return $requete;}
		else {$requete=' AND factnumlibe = "'.$factnumlibe.'"';return $requete;}
	}
//*******************************************************************************************************


//***************************** EN TETE FACTURE*********************************
function FactureFicheComplet($factnum,$Dossier,$ConnexionBdd)
	{
		$Lecture.="<div style='height:10px;' class='supp400px supp800px'></div>";
		// REQUETE INFO DE LA FACTURE
		$req = 'SELECT factnum,factdate,factnumlibe,clients_clienum,facttype,factcloture,factexport,clienom,clieprenom,cliecivilite,clieadre,cliecp,clieville,clienumcompte,factures.AA_equimondo_hebeappnum,factcom,factcondition,clienometablissement,cliesiret,clietvaintra,clienumcarteidentite FROM factures,clients WHERE clients_clienum=clienum AND factnum = "'.$factnum.'"';
		$reqResult = $ConnexionBdd ->query($req) or die ('Erreur SQL !'.$req.'<br />'.mysqli_error());
		$reqAffich = $reqResult->fetch();

		$reqConf = 'SELECT * FROM conflogiciel WHERE AA_equimondo_hebeappnum = "'.$reqAffich['AA_equimondo_hebeappnum'].'"';
		$reqConfResult = $ConnexionBdd ->query($reqConf) or die ('Erreur SQL !'.$reqConf.'<br />'.mysqli_error());
		$reqConfAffich = $reqConfResult->fetch();

		$conflogfactprefixe = $reqConfAffich['conflogfactprefixe'];

		$reqInfo = 'SELECT * FROM infologiciel WHERE AA_equimondo_hebeappnum = "'.$reqAffich['AA_equimondo_hebeappnum'].'"';
		$reqInfoResult = $ConnexionBdd ->query($reqInfo) or die ('Erreur SQL !'.$reqInfo.'<br />'.mysqli_error());
		$reqInfoAffich = $reqInfoResult->fetch();

		if(($reqAffich['facttype'] == 4 OR $reqAffich['facttype'] == 5) OR $_SESSION['connind'] == 'clie') {$FactAutoModif = 1;}
		else {$FactAutoModif = 2;}
		if($_GET['Impression'] == 2) {$FactAutoModif = 1;}
		if($_SESSION['infologlang2'] == "ca" AND $_SESSION['connind'] == "util") {$FactAutoModif = 2;}
		if($_SESSION['infologlang2'] == "ca" AND $_SESSION['connind'] == "clie") {$FactAutoModif = 1;}

		if($_GET['Impression'] != 2)
			{
				$Lecture.=SousMenuFacturationFichComplet($Dossier,$ConnexionBdd,$factnum);
				if($_SESSION['ResolutionConnexion1'] <= 800 AND !empty($_GET['clienum']))
					{
						$Lecture.="<a href='#FenAfficheFicheProfil1' class='ButtonBasAll supp1300px supp1024px'><img src='".$Dossier."images/closeBlanc.png' class='ImgSousMenu2'></a>";
					}
				if($_SESSION['ResolutionConnexion1'] <= 800 AND empty($_GET['clienum']))
					{
						$Lecture.="<a href='#close' class='ButtonBasAll supp1300px supp1024px'><img src='".$Dossier."images/closeBlanc.png' class='ImgSousMenu2'></a>";
					}
				if($_SESSION['ResolutionConnexion1'] > 800)
					{
						$Lecture.="<a href='#close' class='ButtonBasAll supp1300px supp1024px'><img src='".$Dossier."images/closeBlanc.png' class='ImgSousMenu2'></a>";
					}
			}

		// COMMENTAIRE FACTURES
		if($_GET['Impression'] != 2 AND $_SESSION['connind'] == "util")
			{
				$Lecture.="<div style='height:30px;' class='supp400px supp800px'></div>";
				$Lecture.="<div id='AfficheCommentairesGenerals' class='AfficheCommentaires'>";
				$Lecture.="<a href='".$Dossier."modules/divers/AfficheCommentaireGeneral.php?factnum=".$factnum."' class='LoadPage CommGeneAffiche'><div class='LienDefilement1'>".$_SESSION['STrad209']."<img src='".$Dossier."images/FlecheBasBlanc.png' class='ImgSousMenu2' style='float:right;'></div></a>";
				$Lecture.="</div>";
			}

$reqConfEntr='SELECT * FROM confentr WHERE AA_equimondo_hebeappnum = "'.$reqAffich['AA_equimondo_hebeappnum'].'"';
$reqConfEntrResult = $ConnexionBdd ->query($reqConfEntr) or die ('Erreur SQL !'.$reqConfEntr.'<br />'.mysqli_error());
$reqConfEntrAffich = $reqConfEntrResult->fetch();

// CALCUL DES MONTANTS DE LA FACTURE
$InfoCalcFact = FactCalc($factnum,$ConnexionBdd);

$Lecture.="<section class='FactureBloc' id='AfficheFacture'>";

if($reqConfAffich['conflogfacturemodele'] == 1)
	{
		//******************************* PARTIE GAUCHE ************************************
		$Lecture.="<section id='PartieGauche'>";

		if(!empty($reqConfEntrAffich['confentrdenosocial'])) {$Lecture.=$reqConfEntrAffich['confentrdenosocial']." ";}
		$Lecture.=$reqConfEntrAffich['confentrnom'];if($_SESSION['connind'] == 'util' AND $FactAutoModif == 2) {$Lecture.=" <a href='".$Dossier."modules/configuration/Afficheconfentr1.php?factnum=".$factnum."' class='no_print LoadPage Afficheconfentr1'><img src='".$Dossier."images/modifier.png'></a>";} $Lecture.="<br>";
		$Lecture.=$reqConfEntrAffich['confentradres']."<br>";
		$Lecture.=$reqConfEntrAffich['confentrcp']." ".$reqConfEntrAffich['confentrville']."<br>";
		$Lecture.=$reqConfEntrAffich['confentrtel']."<br>";
		if(!empty($reqConfEntrAffich['confentradresmail'])) {$Lecture.="Mail : ".$reqConfEntrAffich['confentradresmail']."<br>";}
		if(!empty($reqConfEntrAffich['confentrfax'])) {$Lecture.=$reqConfEntrAffich['confentrfax']."<br>";}
		if(!empty($reqConfEntrAffich['confentrsiret'])) {$Lecture.=$_SESSION['STrad332']." : ".$reqConfEntrAffich['confentrsiret']."<br>";}
		if(!empty($reqConfEntrAffich['confentrsiren'])) {$Lecture.=$_SESSION['STrad747']." : ".$reqConfEntrAffich['confentrsiren']."<br>";}

		if($_SESSION['infologlang1'] == "fr")
			{
				if(!empty($reqConfEntrAffich['confentrcodeape'])) {$Lecture.="Code APE : ".$reqConfEntrAffich['confentrcodeape']."<br>";}
				if(!empty($reqConfEntrAffich['confentrintratva'])) {$Lecture.="Num. Intra. TVA : ".$reqConfEntrAffich['confentrintratva']."<br>";}
				if(!empty($reqConfEntrAffich['confentrcapital'])) {$Lecture.="Capital sociale : ".$reqConfEntrAffich['confentrcapital']."<br>";}
				if(!empty($reqConfEntrAffich['confentrrcs'])) {$Lecture.="Mention RCS : ".$reqConfEntrAffich['confentrrcs']."<br>";}
				if(!empty($reqConfEntrAffich['confentrvillegreffe'])) {$Lecture.="Ville greffe : ".$reqConfEntrAffich['confentrvillegreffe']."<br>";}
			}
		$Lecture.="</section>";
		//************************************************************************************

		//************************ PARTIE DE DROITE *********************************
		$Lecture.="<section id='PartieDroite'>";

		if (!file_exists("https://equimondo.fr/perso_images/".$reqAffich['AA_equimondo_hebeappnum']."/images/logo.png"))
			{
				$Lecture.="<img src='https://equimondo.fr/perso_images/".$reqAffich['AA_equimondo_hebeappnum']."/images/logo.png' class='ImgFactLogo'><br><br>";
			}
		else
			{
				$Lecture.="<img src='".$Dossier."/images/logo_equimondo.png' class='ImgFactLogo'><br><br>";
			}

		// COORDONNE CLIENT
		$Lecture.="<b>";
		if($_GET['Impression'] != 2) {$Lecture.="<a href='".$Dossier."modules/profil/modprofilfichcomplet1.php?clienum=".$reqAffich['clients_clienum']."' class='LoadPage AfficheFicheProfil1'>";}
			if(!empty($reqAffich['clienometablissement'])) {$Lecture.=$reqAffich['clienometablissement']."<br>";}
			if($reqInfoAffich['infologlang2'] != "es") {$Lecture.=ClieSexeLect($reqAffich['cliecivilite']);}
			if($reqInfoAffich['infologlang1'] == "es") {$Lecture.=" ".$reqAffich[8]." ".$reqAffich[7];}
			else {$Lecture.=" ".$reqAffich[7]." ".$reqAffich[8];}
		if($_GET['Impression'] != 2) {$Lecture.="</a>";}
		if($FactAutoModif == 2) {$Lecture.='<a href="'.$Dossier.'modules/facturation/modfactModifClie.php?factnum='.$factnum.'" class="LoadPage FactClieModif"><span onmouseover=\'afficher_bulle("<em><div class=infobulle2>'.$_SESSION['STrad63'].'</div></em>", "white", event);\' onmouseout="masquer_bulle();" class="infobulle1"><img src="'.$Dossier.'images/modifier.png"></span></a>';}
		$Lecture.="<br>".$reqAffich[10]."<br>";
		$Lecture.=$reqAffich[11]." ".$reqAffich[12]."</b><br>";

		if(!empty($reqAffich['cliesiret'])) {$Lecture.=$_SESSION['STrad725']." : ".$reqAffich['cliesiret']."<br>";}
		if(!empty($reqAffich['clietvaintra'])) {$Lecture.=$_SESSION['STrad726'] ." : ".$reqAffich['clietvaintra']."<br>";}

		if($_GET['Rappel'] == 2) {$Lecture.="<div style='font-size:26px;color:red;margin-top:15px;'>RAPPEL</div>";}
		$Lecture.="</section>";
		//************************************************************************************
		$Lecture.="</section>";

		$Lecture.="<section style='clear:both;display:block;height:40px;'></section>";

		$Lecture.="<section class='FactureBloc'>";
		//******************************* NUMERO FACTURE ************************************
		$Lecture.="<section id='PartieGauche'>";

		if($reqAffich['facttype'] == 8) {$Lecture.=$reqAffich['factnumlibe']."<br>";}
		else if($reqAffich['facttype'] != 7) {$Lecture.=$_SESSION['STrad196']." ".FactIndLect($reqAffich[4])." :  ".FactPrefLect($reqAffich[1],$reqAffich[2],null,$conflogfactprefixe)."<br>";}
		$Lecture.=$_SESSION['STrad326']." : ".$reqAffich['clienumcompte'];

		if($reqInfoAffich['infologlang1'] == "es") {$Lecture.="<br>".$_SESSION['STrad446']." : ".$reqAffich['clienumcarteidentite'];}

		$Lecture.="</section>";
		//************************************************************************************

		//******************************* LIEU ET DATE ************************************
		$Lecture.="<section id='PartieDroite'>";
		if($reqInfoAffich['infologlang1'] != "es")
			{
				$Lecture.=$_SESSION['STrad17']." ".$reqConfEntrAffich['confentrville']."<br>";
				$Lecture.=$_SESSION['STrad18']." ".formatdatemysql($reqAffich[1]);
			}
		else if($reqInfoAffich['infologlang1'] == "es")
			{
				$Lecture.=$reqConfEntrAffich['confentrville'].", ".formatdatemysql($reqAffich[1]);
			}
		if($FactAutoModif == 2) {$Lecture.='<a href="'.$Dossier.'modules/facturation/modfactModifDate.php?factnum='.$factnum.'" class="LoadPage FactDateModif"><span onmouseover=\'afficher_bulle("<em><div class=infobulle2>'.$_SESSION['STrad158'].'</div></em>", "white", event);\' onmouseout="masquer_bulle();" class="infobulle1"><img src="'.$Dossier.'images/modifier.png"></span></a>';}

		$Lecture.="</section>";
		//************************************************************************************
		$Lecture.="</section>";

		$Lecture.="<section style='clear:both;display:block;height:40px;'></section>";

		// AFFICHE PRESTATIONS
		$Lecture.="<div id='AfficheFactPrestations'>";
		$Lecture.=AfficheFactPrestations($Dossier,$ConnexionBdd,$factnum);
		$Lecture.="</div>";

		// MONTANT HT
		$TotalMontantHt = $InfoCalcFact[0];

		// AFFICHE LES MONTANTS HT, TTC, TVA ETC ....
		$Lecture.="<div style='height:20px;'></div>";
		$Lecture.="<table class='tab_rubrique AfficheTotaux1'>";
			// AFFICHE MONTANT HT
			$TotalMontantHt = number_format($TotalMontantHt, 2, '.', '');
			$Lecture.="<tr><td class='ChampBarreMiddle'><span style='float:right;'><b>".$_SESSION['STrad70']."</b></span></td><td><b>".$TotalMontantHt." ".$_SESSION['STrad27']."</b></td></tr>";

			// AFFICHE LES ESCOMPTES
			$reqEsc = 'SELECT facttauxescompte,facttype FROM factures WHERE factnum = "'.$factnum.'"';
			$reqEscResult = $ConnexionBdd ->query($reqEsc) or die ('Erreur SQL !'.$reqEsc.'<br />'.mysqli_error());
			$reqEscAffich = $reqEscResult->fetch();
			if($reqEscAffich[0] > 0)
				{
					$TotalMontantEsc = $TotalMontantHt * $reqEscAffich[0];
					$TotalMontantEsc = round($TotalMontantEsc,"2");
					$TauxEsc = $reqEscAffich[0] * 100;
					$TotalMontant = $TotalMontantHt - $TotalMontantEsc;
					$Lecture.="<tr><td class='ChampBarreMiddle'><span style='float:right;'>".$_SESSION['STrad71']."</span></td><td>".$InfoCalcFact[6]." ".$_SESSION['STrad27']." <i>(".$TauxEsc." %)</i></td></tr>";
					$Lecture.="<tr><td class='ChampBarreMiddle'><span style='float:right;'><b>".$_SESSION['STrad72']."</b></span></td><td><b>".$TotalMontant." ".$_SESSION['STrad27']."</b></td></tr>";
				}
			else
				{
					$TotalMontant = $TotalMontantHt;
				}

			// AFFICHE LES TAUX DE TVA
			$reqTvaSelect = 'SELECT sum(factprestprixstatprixtva),factprestprixtva FROM factprestation_prix,factprestation WHERE factprestation_factprestnum = factprestnum AND factures_factnum = "'.$factnum.'" GROUP BY factprestprixtva HAVING factprestprixtva != "0" ORDER BY factprestprixtva ASC';
			$reqTvaSelectResult = $ConnexionBdd ->query($reqTvaSelect) or die ('Erreur SQL !'.$reqTvaSelect.'<br />'.mysqli_error());
			while($reqTvaSelectAffich = $reqTvaSelectResult->fetch())
				{
					$AffichTva = $reqTvaSelectAffich[1] * 100;
					$reqTvaSelectAffich[0] = number_format($reqTvaSelectAffich[0], 2, '.', '');
					$Lecture.="<tr><td class='ChampBarreMiddle'><span style='float:right;'>".$_SESSION['STrad73']." ".$AffichTva." %</span></td><td>".$reqTvaSelectAffich[0]." ".$_SESSION['STrad27']."</td></tr>";
				}
			$LibeTotalTva = $_SESSION['STrad74'];

			if($_SESSION['infologlang2'] == "ca")
				{
					$reqTvaSelect = 'SELECT sum(factprestprixstatprixtva1),factprestprixtva1 FROM factprestation_prix,factprestation WHERE factprestation_factprestnum = factprestnum AND factures_factnum = "'.$factnum.'" GROUP BY factprestprixtva1 HAVING factprestprixtva1 != "0" ORDER BY factprestprixtva1 ASC';
					$reqTvaSelectResult = $ConnexionBdd ->query($reqTvaSelect) or die ('Erreur SQL !'.$reqTvaSelect.'<br />'.mysqli_error());
					while($reqTvaSelectAffich = $reqTvaSelectResult->fetch())
						{
							$AffichTva = $reqTvaSelectAffich[1] * 100;
							$reqTvaSelectAffich[0] = number_format($reqTvaSelectAffich[0], 2, '.', '');
							$Lecture.="<tr><td class='ChampBarreMiddle'><span style='float:right;'>".$_SESSION['STrad73']." ".$AffichTva." %</span></td><td>".$reqTvaSelectAffich[0]." ".$_SESSION['STrad27']."</td></tr>";
						}
					$LibeTotalTva = $_SESSION['STrad260'];
				}

			$InfoCalcFact[1] = number_format($InfoCalcFact[1], 2, '.', '');
			$Lecture.="<tr><td class='ChampBarreMiddle'><span style='float:right;'><b>".$LibeTotalTva."</b></span></td><td><b>".$InfoCalcFact[1]." ".$_SESSION['STrad27']."</b></td></tr>";

			// AFFICHE TOTAL TTC
			$InfoCalcFact[2] = number_format($InfoCalcFact[2], 2, '.', '');
			$Lecture.="<tr><td class='ChampBarreMiddle'><span style='float:right;'><b>".$_SESSION['STrad75']."</b></span></td><td><b>".$InfoCalcFact[2]." ".$_SESSION['STrad27']."</b></td></tr>";

			// AFFICHE TOTAL ENCAISSEMENT
			$InfoCalcFact[3] = number_format($InfoCalcFact[3], 2, '.', '');
			if($InfoCalcFact[3] != 0 AND $reqAffich['facttype'] == 4) {$Lecture.="<tr><td class='ChampBarreMiddle'><span style='float:right;'>".$_SESSION['STrad76']."</span></td><td><b>- ".$InfoCalcFact[3]." ".$_SESSION['STrad27']."</b></td></tr>";}

			// AFFICHE TOTAL REMBOURSSEMENT
			if($InfoCalcFact[3] != 0 AND $reqAffich['facttype'] == 5) {$Lecture.="<tr><td class='ChampBarreMiddle'><span style='float:right;'>".$_SESSION['STrad77']."</span></td><td><b>".$InfoCalcFact[3]." ".$_SESSION['STrad27']."</b></td></tr>";}

			// AFFICHE TOTAL AVOIR
			$InfoCalcFact[5] = number_format($InfoCalcFact[5], 2, '.', '');
			if($InfoCalcFact[5] != 0) {$Lecture.="<tr><td class='ChampBarreMiddle'><span style='float:right;'>".$_SESSION['STrad78']."</span></td><td><b>- ".$InfoCalcFact[5]." ".$_SESSION['STrad27']."</b></td></tr>";}

			// AFFICHER SOLDE A PAYER
			$InfoCalcFact[4] = number_format($InfoCalcFact[4], 2, '.', '');
			if($InfoCalcFact[4] != 0  AND $reqAffich['facttype'] == 4){$Lecture.="<tr><td class='ChampBarreMiddle'><b style='color:red;float:right;'>".$_SESSION['STrad79']."</b></td><td><b style='color:red;'>".$InfoCalcFact[4]." ".$_SESSION['STrad27']."</b></td></tr>";}

			// FACTURE ACQUITTEE
			if($InfoCalcFact[4] == 0 AND ($reqAffich['facttype'] == 4 OR $reqAffich['facttype'] == 6)) {$Lecture.="<tr><td colspan='2' class='ChampBarreMiddle'><center class='rub_error2'>".$_SESSION['STrad80']."</center></tr></td>";}
		$Lecture.="</table>";

		$Lecture.="<div>";
		// INFORMATION BANCAIRE
		if(!empty($reqConfEntrAffich['confentrdomiciliation']) OR !empty($reqConfEntrAffich['confentrbic']) OR !empty($reqConfEntrAffich['confentriban1']))
			{
				$Lecture.="<div class='FactAfficheCondition1'>";
				$Lecture.="<u>".$_SESSION['STrad81']."</u> :";if($FactAutoModif == 2){$Lecture.=" <a href='".$Dossier."modules/configuration/Afficheconfentr2.php?factnum=".$factnum."' class='no_print LoadPage Afficheconfentr2'><img src ='".$Dossier."images/modifier.png'></a>";} $Lecture.="<br>";
				// DOMICILIATION
				if(!empty($reqConfEntrAffich['confentrdomiciliation'])) {$Lecture.=$_SESSION['STrad82']." : ".$reqConfEntrAffich['confentrdomiciliation']."<br>";}
				// BIC
				if(!empty($reqConfEntrAffich['confentrbic'])) {$Lecture.=$_SESSION['STrad83']." : ".$reqConfEntrAffich['confentrbic']."<br>";}
				// IBAN
				if(!empty($reqConfEntrAffich['confentriban1'])) {$Lecture.=$_SESSION['STrad84']." : ".$reqConfEntrAffich['confentriban1']."<br>";}
				$Lecture.="</div><br>";
			}

		// CONDITION FACTURE
		$Lecture.="<div class='FactAfficheCondition1'><i><u>".$_SESSION['STrad85']."</u> :</i>";if($FactAutoModif == 2){$Lecture.=" <a href='".$Dossier."modules/facturation/AfficheFactConditionModif.php?factnum=".$factnum."' class='no_print LoadPage FactConditionModif'><img src ='".$Dossier."images/modifier.png'></a>";} $Lecture.="<br>".nl2br($reqAffich['factcondition'])."</div>";
		// COMMENTAIRE
		if(!empty($reqAffich['factcom'])) {$Lecture.="<br><div><i><u>".$_SESSION['STrad86']."</u> :</i>";if($FactAutoModif == 2){$Lecture.="<a href='".$Dossier."modules/facturation/AfficheFactConditionModif.php?factnum=".$factnum."' class='no_print LoadPage FactConditionModif'><img src ='".$Dossier."images/modifier.png'></a>";}$Lecture.="<br>".nl2br($reqAffich['factcom'])."</div>";}

		$Lecture.="</div>";

		$Lecture.="<section style='clear:both;display:block;height:40px;'></section>";
		}
else if($reqConfAffich['conflogfacturemodele'] == 2)
		{
			$Lecture.="<section style='clear:both;display:block;'>";
			$Lecture.="<section id='PartieDroite' style='float:right;width:40%;'>";
			if($reqAffich['facttype'] == 8) {$Lecture.=$reqAffich['factnumlibe']."<br>";}
			else if($reqAffich['facttype'] != 7) {$Lecture.=$_SESSION['STrad196']." ".FactIndLect($reqAffich[4])." :  ".FactPrefLect($reqAffich[1],$reqAffich[2],null,$conflogfactprefixe)."<br>";}
			$Lecture.=$_SESSION['STrad17']." ".$reqConfEntrAffich['confentrville'].'<br>';
			$Lecture.=$_SESSION['STrad424']." ".formatdatemysql($reqAffich[1]);
			if($FactAutoModif == 2) {$Lecture.='<a href="'.$Dossier.'modules/facturation/modfactModifDate.php?factnum='.$factnum.'" class="LoadPage FactDateModif"><span onmouseover=\'afficher_bulle("<em><div class=infobulle2>'.$_SESSION['STrad158'].'</div></em>", "white", event);\' onmouseout="masquer_bulle();" class="infobulle1"><img src="'.$Dossier.'images/modifier.png"></span></a>';}

			$Lecture.="<div style='height:60px;'></div>";

			if($_GET['Impression'] != 2) {$Lecture.="<a href='".$Dossier."modules/profil/modprofilfichcomplet1.php?clienum=".$reqAffich['clients_clienum']."' class='LoadPage AfficheFicheProfil1'>";}
				if($reqInfoAffich['infologlang2'] != "es") {$Lecture.=ClieSexeLect($reqAffich['cliecivilite']);}
				$Lecture.=" ".$reqAffich[7]." ".$reqAffich[8];
			if($_GET['Impression'] != 2) {$Lecture.="</a>";}
			if($FactAutoModif == 2) {$Lecture.='<a href="'.$Dossier.'modules/facturation/modfactModifClie.php?factnum='.$factnum.'" class="LoadPage FactClieModif"><span onmouseover=\'afficher_bulle("<em><div class=infobulle2>'.$_SESSION['STrad63'].'</div></em>", "white", event);\' onmouseout="masquer_bulle();" class="infobulle1"><img src="'.$Dossier.'images/modifier.png"></span></a>';}
			$Lecture.="<br>".$reqAffich[10]."<br>";
			$Lecture.=$reqAffich[11]." ".$reqAffich[12]."</b>";
			$Lecture.="</section>";
			$Lecture.="<section id='PartieGauche' style='float:left;width:40%;'>";
			if (!file_exists("https://equimondo.fr/perso_images/".$reqAffich['AA_equimondo_hebeappnum']."/images/logo.png"))
				{
					$Lecture.="<img src='https://equimondo.fr/perso_images/".$reqAffich['AA_equimondo_hebeappnum']."/images/logo.png' class='ImgFactLogo'><br><br>";
				}
			else
				{
					$Lecture.="<img src='".$Dossier."/images/logo_equimondo.png' class='ImgFactLogo'><br><br>";
				}
			$Lecture.="</section>";
			$Lecture.="</section>";

			$Lecture.="<table class='tab_rubrique FactAffichePrestation' style='width:100%;'>";
				$Lecture.="<thead><tr>";
				$Lecture.="<td>".$_SESSION['STrad65']."</td>";
				$Lecture.="<td class='supp400px'>".$_SESSION['STrad66']."</td>";
				$Lecture.="<td class='supp400px'>".$_SESSION['STrad67']."</td>";
				$Lecture.="<td class='supp400px'>".$_SESSION['STrad68']."</td>";
				if($reqInfoAffich['infologlang2'] == "ca") {$Lecture.="<td class='supp400px'>".$_SESSION['STrad260']."</td>";}
				else {$Lecture.="<td class='supp400px'>".$_SESSION['STrad249']."</td>";}
				$Lecture.="<td>".$_SESSION['STrad69']."</td>";
				// SUPPRIMER
				if($FactAutoModif == 2) {$Lecture.="<td class='no_print'></td>";}
				$Lecture.="</tr></thead>";
				$Lecture.="<tbody>";

			// LISTE PRESTATION DE LA FACTURE
			$reqPrest = 'SELECT factprestnum,factures_factnum,factprestdate,factprestlibe,factprestrempourc,typeprestation_typeprestnum,factprestqte,clients_clienum,factprestavoir,SUM(factprestation_prix.factprestprixht),SUM(factprestprixstatprixttc),factprestremmontant FROM factprestation,factprestation_prix WHERE factprestation_factprestnum = factprestnum AND factures_factnum = "'.$factnum.'" GROUP BY factprestnum';
			$reqPrestResult = $ConnexionBdd ->query($reqPrest) or die ('Erreur SQL !'.$reqPrest.'<br />'.mysqli_error());
			while($reqPrestAffich = $reqPrestResult->fetch())
				{
					if($FactAutoModif == 2)
						{
							$Liens1 = "<a href='".$Dossier."modules/facturation/modFactPrestModif.php?factprestnum=".$reqPrestAffich[0]."' class='LoadPage FactPrestModif'>";
							$Liens2 = "</a>";
						}

					$i = 0;
					$reqVerif1 = 'SELECT count(factprestprixnum) FROM factprestation_prix left outer join typeprestation_prix on typeprestation_prix_typeprestprixnum = typeprestprixnum WHERE factprestation_factprestnum = "'.$reqPrestAffich[0].'"';
					$reqVerif1Result = $ConnexionBdd ->query($reqVerif1) or die ('Erreur SQL !'.$reqVerif1.'<br />'.mysqli_error());
					$reqVerif1Affich = $reqVerif1Result->fetch();
					$NbPrest = $reqVerif1Affich[0];

					$reqPrix = 'SELECT * FROM factprestation_prix left outer join typeprestation_prix on typeprestation_prix_typeprestprixnum = typeprestprixnum WHERE factprestation_factprestnum = "'.$reqPrestAffich[0].'"';
					$reqPrixResult = $ConnexionBdd ->query($reqPrix) or die ('Erreur SQL !'.$reqPrix.'<br />'.mysqli_error());
					while($reqPrixAffich = $reqPrixResult->fetch())
						{
							$i = $i +1;

							$Lecture.="<tr>";
							$Libe = "";
							if($reqPrestAffich['factprestdate'] != "0000-00-00" AND !empty($reqPrestAffich['factprestdate'])) {$Libe.= formatdatemysql($reqPrestAffich['factprestdate'])."<br>";}

							$Libe.= nl2br($reqPrestAffich['factprestlibe']);

							// SELECTIONNE LES CLIENTS ET CHEVAUX ASSOCIï¿½S
							$reqVerif1 = 'SELECT factprestassonum,clients_clienum,chevaux_chevnum,clients_clienum1,chevaux_chevnum1,chevaux_chevnum2,chevaux_chevnum3 FROM factprestation_association WHERE factprestation_factprestnum = "'.$reqPrestAffich[0].'"';
							$reqVerif1Result = $ConnexionBdd ->query($reqVerif1) or die ('Erreur SQL !'.$reqVerif1.'<br />'.mysqli_error());
							while($reqVerif1Affich = $reqVerif1Result->fetch())
								{
									if(!empty($reqVerif1Affich[1]))
										{
											$reqLibe = 'SELECT clienom,clieprenom FROM clients WHERE clienum = "'.$reqVerif1Affich[1].'"';
											$reqLibeResult = $ConnexionBdd ->query($reqLibe) or die ('Erreur SQL !'.$reqLibe.'<br />'.mysqli_error());
											$reqLibeAffich = $reqLibeResult->fetch();
											$Libe.= "<br>".$reqLibeAffich[0].' '.$reqLibeAffich[1];
										}
									if(!empty($reqVerif1Affich[3]))
										{
											$reqLibe = 'SELECT clienom,clieprenom FROM clients WHERE clienum = "'.$reqVerif1Affich[3].'"';
											$reqLibeResult = $ConnexionBdd ->query($reqLibe) or die ('Erreur SQL !'.$reqLibe.'<br />'.mysqli_error());
											$reqLibeAffich = $reqLibeResult->fetch();
											$Libe.= "<br>".$reqLibeAffich[0].' '.$reqLibeAffich[1];
										}
									if(!empty($reqVerif1Affich['chevaux_chevnum'])) {$Libe.= "<br>".ChevLect($reqVerif1Affich['chevaux_chevnum'],$ConnexionBdd);}
									if(!empty($reqVerif1Affich['chevaux_chevnum1'])) {$Libe.= "<br>".ChevLect($reqVerif1Affich['chevaux_chevnum1'],$ConnexionBdd);}
									if(!empty($reqVerif1Affich['chevaux_chevnum2'])) {$Libe.= "<br>".ChevLect($reqVerif1Affich['chevaux_chevnum2'],$ConnexionBdd);}
									if(!empty($reqVerif1Affich['chevaux_chevnum3'])) {$Libe.= "<br>".ChevLect($reqVerif1Affich['chevaux_chevnum3'],$ConnexionBdd);}
								}
							// SELECTIONNE UN CLIENT QUI A DES ENTRï¿½ES
							$reqVerif1 = 'SELECT clienum,clienom,clieprenom FROM clientssoldeforfentree,clientssoldeforfentree_clients,clients WHERE clients_clienum = clienum AND clientssoldeforfentree_cliesoldforfentrnum = cliesoldforfentrnum AND factprestation_factprestnum = "'.$reqPrestAffich[0].'"';
							$reqVerif1Result = $ConnexionBdd ->query($reqVerif1) or die ('Erreur SQL !'.$reqVerif1.'<br />'.mysqli_error());
							while($reqVerif1Affich = $reqVerif1Result->fetch())
								{
									$Libe.="<br><b>(".$reqVerif1Affich[1]." ".$reqVerif1Affich[2].")</b>";

								}

							if($i == 1)
								{
									$Lecture.="<td rowspan='".$NbPrest."' style='white-space:normal;'>".$Liens1.$Libe.$Liens2."</td>";
									$Lecture.="<td rowspan='".$NbPrest."' class='supp400px'>".$Liens1.$reqPrestAffich['factprestqte'].$Liens2."</td>";
								}
							// PRIX UNITAIRE
							if(empty($reqPrixAffich['factprestqte'])) {$reqPrixAffich['factprestqte'] = 1;}
							$PuHT = $reqPrixAffich['factprestprixstatprixht'] / $reqPrestAffich['factprestqte'];
							$PuHT = number_format($PuHT, 2, '.', '');
							$Lecture.="<td class='supp400px'>".$Liens1."<div style='white-space:nowrap;'>";$Lecture.="<b>".$PuHT." ".$_SESSION['STrad27']."</b>";if(!empty($reqPrixAffich['typeprestprixlibe'])) {$Lecture.=" <i>(".$reqPrixAffich['typeprestprixlibe'].")</i> : ";}$Lecture.="</div>".$Liens2."</td>";

							// TOTAL HT
							$reqPrixAffich['factprestprixstatprixht'] = number_format($reqPrixAffich['factprestprixstatprixht'], 2, '.', '');
							$Lecture.="<td class='supp400px'>".$Liens1."<div style='white-space:nowrap;'>".$reqPrixAffich['factprestprixstatprixht']." ".$_SESSION['STrad27']."</div>".$Liens2."</td>";

							// TOTAL TVA
							if($_SESSION['infologlang2'] == "ca")
								{
									$reqPrixAffich['factprestprixtva'] = 	$reqPrixAffich['factprestprixstatprixtva'] + $reqPrixAffich['factprestprixstatprixtva1'];
									$IndTva = $_SESSION['STrad27'];
								}
							else
								{
									$reqPrixAffich['factprestprixtva'] = $reqPrixAffich['factprestprixtva'] * 100;
									$IndTva = "%";
								}
							$reqPrixAffich['factprestprixtva'] = number_format($reqPrixAffich['factprestprixtva'], 2, '.', '');
							$Lecture.="<td class='supp400px'>".$Liens1;
							$Lecture.="<div style='white-space:nowrap;'>".$reqPrixAffich['factprestprixtva']." ".$IndTva."</div>";
							$Lecture.=$Liens2."</td>";


							// PRIX TTC
							$reqPrixAffich['factprestprixstatprixttc'] = number_format($reqPrixAffich['factprestprixstatprixttc'], 2, '.', '');
							$Lecture.="<td>".$Liens1;
							$Lecture.="<div style='white-space:nowrap;'>".$reqPrixAffich['factprestprixstatprixttc']." ".$_SESSION['STrad27']."</div>";


							if(!empty($reqPrestAffich['factprestremmontant'])) {$Lecture.="<i style='font-size:10px;'>Dont remise accordï¿½e : ".$reqPrestAffich['factprestremmontant']." ".$_SESSION['STrad27']."</i>";}
							else if(!empty($reqPrestAffich['factprestrempourc'])) {$reqPrestAffich['factprestrempourc']=$reqPrestAffich['factprestrempourc']*100;$Lecture.="<i style='font-size:10px;'>Dont remise accordï¿½e : ".$reqPrestAffich['factprestrempourc']." %</i>";}

							$Lecture.=$Liens2."</td>";

							if($i == 1)
								{
									if($FactAutoModif == 2) {$Lecture.="<td rowspan='".$NbPrest."'><a href='".$Dossier."modules/facturation/modfactfichcompletsuppprest_script.php?factnum=".$factnum."&factprestnum=".$reqPrestAffich[0]."'><img src='".$Dossier."images/supprimer.png' class='ImgSousMenu2'></a></td>";}
								}

							$Lecture.="</tr>";
						}
				}

			// AJOUTER UNE PRESTATION
			if($FactAutoModif == 2)
				{
					$Lecture.="<tr><td colspan='6'><div style='height:15px;'></div><a href='modfactPrestationsAjou.php?factnum=".$factnum."' class='button LoadPage FactPrestAjou'>".$_SESSION['STrad157']."</a><div style='height:15px;'></div></td></tr>";
				}

			$Lecture.="</tbody>";
			$Lecture.="</table>";
			$Lecture.="</section>";

			$Lecture.="<div style='height:40px;clear:both;display:block;'></div>";

			// FACTURE ACQUITTEE
			if($InfoCalcFact[4] == 0 AND ($reqAffich['facttype'] == 4 OR $reqAffich['facttype'] == 6)) {$Lecture.="<center style='color:red;font-size:20px;'>".$_SESSION['STrad80']."</center>";}

			$Lecture.="<div style='height:40px;clear:both;display:block;'></div>";

			if($InfoCalcFact[4] == 0 AND ($reqAffich['facttype'] == 4 OR $reqAffich['facttype'] == 6)) {$AlerteNonPaye = "";} else {$AlerteNonPaye="color:red;";}

			$Lecture.="<section style='clear:both;display:block;'>";
			$Lecture.="<table class='tab_rubrique' style='width:100%;'>";
			$Lecture.="<thead>";
				$Lecture.="<tr>";
					$Lecture.="<td>".$_SESSION['STrad425']."</td>";
					$reqPrix = 'SELECT factprestprixtva FROM factprestation_prix,factprestation WHERE factures_factnum = "'.$factnum.'" AND factprestation_factprestnum = factprestnum ORDER BY factprestprixstatprixtva ASC';
					$reqPrixResult = $ConnexionBdd ->query($reqPrix) or die ('Erreur SQL !'.$reqPrix.'<br />'.mysqli_error());
					while($reqPrixAffich = $reqPrixResult->fetch())
						{
							$Taux = $reqPrixAffich[0] * 100;
							$Lecture.="<td>".$_SESSION['STrad199']." <i>(".$Taux." %)</i></td>";
						}
					$Lecture.="<td>".$_SESSION['STrad69']."</td>";
					$reqPrix = 'SELECT sum(factprestprixstatprixttc) FROM factprestation_prix,factprestation WHERE factures_factnum = "'.$factnum.'" AND factprestation_factprestnum = factprestnum ';
					$reqPrixResult = $ConnexionBdd ->query($reqPrix) or die ('Erreur SQL !'.$reqPrix.'<br />'.mysqli_error());
					$reqPrixAffich = $reqPrixResult->fetch();
					$reqPrixAffich[0] = number_format($reqPrixAffich[0], 2, '.', '');
					$Lecture.="<td style='".$AlerteNonPaye."'>".$reqPrixAffich[0]." ".$_SESSION['STrad27']."</td>";
				$Lecture.="</tr>";
			$Lecture.="</thead>";

			// BASE HT
			$Lecture.="<tr>";
			$Lecture.="<td>".$_SESSION['STrad427']." : </td>";

			$reqPrix = 'SELECT factprestprixtva FROM factprestation_prix,factprestation WHERE factures_factnum = "'.$factnum.'" AND factprestation_factprestnum = factprestnum ORDER BY factprestprixtva ASC';
			$reqPrixResult = $ConnexionBdd ->query($reqPrix) or die ('Erreur SQL !'.$reqPrix.'<br />'.mysqli_error());
			while($reqPrixAffich = $reqPrixResult->fetch())
				{
					$reqPrix1 = 'SELECT sum(factprestprixstatprixht) FROM factprestation_prix,factprestation WHERE factures_factnum = "'.$factnum.'" AND factprestation_factprestnum = factprestnum AND factprestprixtva LIKE "%'.$reqPrixAffich[0].'%"';
					$reqPrix1Result = $ConnexionBdd ->query($reqPrix1) or die ('Erreur SQL !'.$reqPrix1.'<br />'.mysqli_error());
					$reqPrix1Affich = $reqPrix1Result->fetch();
					$reqPrix1Affich[0] = number_format($reqPrix1Affich[0], 2, '.', '');
					$Lecture.="<td>".$reqPrix1Affich[0]." ".$_SESSION['STrad27']."</td>";
				}

			$Lecture.="<td>".$_SESSION['STrad68']."</td>";
			$reqPrix1 = 'SELECT sum(factprestprixstatprixht) FROM factprestation_prix,factprestation WHERE factures_factnum = "'.$factnum.'" AND factprestation_factprestnum = factprestnum';
			$reqPrix1Result = $ConnexionBdd ->query($reqPrix1) or die ('Erreur SQL !'.$reqPrix1.'<br />'.mysqli_error());
			$reqPrix1Affich = $reqPrix1Result->fetch();
			$reqPrix1Affich[0] = number_format($reqPrix1Affich[0], 2, '.', '');
			$Lecture.="<td style='".$AlerteNonPaye."'>".$reqPrix1Affich[0]." ".$_SESSION['STrad27']."</td>";
			$Lecture.="</tr>";

			// MONTANT TVA
			$Lecture.="<tr>";
			$Lecture.="<td>".$_SESSION['STrad428']." : </td>";
			$reqPrix = 'SELECT factprestprixtva FROM factprestation_prix,factprestation WHERE factures_factnum = "'.$factnum.'" AND factprestation_factprestnum = factprestnum ORDER BY factprestprixtva ASC';
			$reqPrixResult = $ConnexionBdd ->query($reqPrix) or die ('Erreur SQL !'.$reqPrix.'<br />'.mysqli_error());
			while($reqPrixAffich = $reqPrixResult->fetch())
				{
					$reqPrix1 = 'SELECT sum(factprestprixstatprixtva) FROM factprestation_prix,factprestation WHERE factures_factnum = "'.$factnum.'" AND factprestation_factprestnum = factprestnum AND factprestprixtva LIKE "%'.$reqPrixAffich[0].'%"';
					$reqPrix1Result = $ConnexionBdd ->query($reqPrix1) or die ('Erreur SQL !'.$reqPrix1.'<br />'.mysqli_error());
					$reqPrix1Affich = $reqPrix1Result->fetch();
					$reqPrix1Affich[0] = number_format($reqPrix1Affich[0], 2, '.', '');
					$Lecture.="<td>".$reqPrix1Affich[0]." ".$_SESSION['STrad27']."</td>";
				}

			$Lecture.="<td>".$_SESSION['STrad429']."</td>";
			$reqPrix = 'SELECT sum(factprestprixstatprixtva) FROM factprestation_prix,factprestation WHERE factures_factnum = "'.$factnum.'" AND factprestation_factprestnum = factprestnum';
			$reqPrixResult = $ConnexionBdd ->query($reqPrix) or die ('Erreur SQL !'.$reqPrix.'<br />'.mysqli_error());
			$reqPrixAffich = $reqPrixResult->fetch();
			$reqPrixAffich[0] = number_format($reqPrixAffich[0], 2, '.', '');
			$Lecture.="<td style='".$AlerteNonPaye."'>".$reqPrixAffich[0]." ".$_SESSION['STrad27']."</td>";
			$Lecture.="</tr>";

			$Lecture.="</table>";
			$Lecture.="</section>";

			$Lecture.="<section style='clear:both;display:block;width:100%;bottom:0px;position:fixed;'>";
			$Lecture.="<hr>";
			$Lecture.="<center>";
				$reqConfEntr='SELECT * FROM confentr WHERE AA_equimondo_hebeappnum = "'.$reqAffich[14].'"';
				$reqConfEntrResult = $ConnexionBdd ->query($reqConfEntr) or die ('Erreur SQL !'.$reqConfEntr.'<br />'.mysqli_error());
				$reqConfEntrAffich = $reqConfEntrResult->fetch();

				if(!empty($reqConfEntrAffich['confentrdenosocial'])) {$Lecture.=$reqConfEntrAffich['confentrdenosocial']." ";}
				$Lecture.=$reqConfEntrAffich['confentrnom']."<br>";if($_SESSION['connind'] == 'util' AND $FactAutoModif == 2) {$Lecture.=" <a href='".$Dossier."modules/configuration/Afficheconfentr1.php?factnum=".$factnum."' class='no_print LoadPage Afficheconfentr1'><img src='".$Dossier."images/modifier.png'></a>";}
				$Lecture.=$reqConfEntrAffich['confentradres']." - ";
				$Lecture.=$reqConfEntrAffich['confentrcp']." ".$reqConfEntrAffich['confentrville']."<br>";
				$Lecture.=$_SESSION['STrad430']." ".$reqConfEntrAffich['confentrtel']."<br>";
				if(!empty($reqConfEntrAffich['confentradresmail'])) {$Lecture.="Mail : ".$reqConfEntrAffich['confentradresmail']." - ";}
				if(!empty($reqConfEntrAffich['confentrfax'])) {$Lecture.=$reqConfEntrAffich['confentrfax']."<br>";}
				if(!empty($reqConfEntrAffich['confentrsiret'])) {$Lecture.=$_SESSION['STrad332']." : ".$reqConfEntrAffich['confentrsiret']."<br>";}

				if($_SESSION['infologlang1'] == "fr")
					{
						if(!empty($reqConfEntrAffich['confentrsiren'])) {$Lecture.="Siren : ".$reqConfEntrAffich['confentrsiren']." - ";}
						if(!empty($reqConfEntrAffich['confentrcodeape'])) {$Lecture.="Code APE : ".$reqConfEntrAffich['confentrcodeape']."<br>";}
						if(!empty($reqConfEntrAffich['confentrintratva'])) {$Lecture.="Num. Intra. TVA : ".$reqConfEntrAffich['confentrintratva']." - ";}
						if(!empty($reqConfEntrAffich['confentrcapital'])) {$Lecture.="Capital sociale : ".$reqConfEntrAffich['confentrcapital']."<br>";}
						if(!empty($reqConfEntrAffich['confentrrcs'])) {$Lecture.="Mention RCS : ".$reqConfEntrAffich['confentrrcs']." - ";}
						if(!empty($reqConfEntrAffich['confentrvillegreffe'])) {$Lecture.="Ville greffe : ".$reqConfEntrAffich['confentrvillegreffe']."<br>";}
					}
				$Lecture.="</center>";
			$Lecture.="</section>";
		}

		$Lecture.="</section>";

		$Lecture.="<div style='height:80px;clear:both;display:block;'></div>";

		$Lecture.="<section style='clear:both;display:block;'>";
			$Lecture.=FactEnc($ConnexionBdd,$Dossier,$factnum);
		$Lecture.="</section>";

		return $Lecture;
	}
//************************************************************************************

function AfficheFactPrestations($Dossier,$ConnexionBdd,$factnum)
	{
		// REQUETE INFO DE LA FACTURE
		$req = 'SELECT factnum,factdate,factnumlibe,clients_clienum,facttype,factcloture,factexport,clienom,clieprenom,cliecivilite,clieadre,cliecp,clieville,clienumcompte,factures.AA_equimondo_hebeappnum,factcom,factcondition FROM factures,clients WHERE clients_clienum=clienum AND factnum = "'.$factnum.'"';
		$reqResult = $ConnexionBdd ->query($req) or die ('Erreur SQL !'.$req.'<br />'.mysqli_error());
		$reqAffich = $reqResult->fetch();

		$reqConf = 'SELECT * FROM conflogiciel WHERE AA_equimondo_hebeappnum = "'.$reqAffich['AA_equimondo_hebeappnum'].'"';
		$reqConfResult = $ConnexionBdd ->query($reqConf) or die ('Erreur SQL !'.$reqConf.'<br />'.mysqli_error());
		$reqConfAffich = $reqConfResult->fetch();

		$reqInfo = 'SELECT * FROM infologiciel WHERE AA_equimondo_hebeappnum = "'.$reqAffich['AA_equimondo_hebeappnum'].'"';
		$reqInfoResult = $ConnexionBdd ->query($reqInfo) or die ('Erreur SQL !'.$reqInfo.'<br />'.mysqli_error());
		$reqInfoAffich = $reqInfoResult->fetch();

		if(($reqAffich['facttype'] == 4 OR $reqAffich['facttype'] == 5) OR $_SESSION['connind'] == 'clie') {$FactAutoModif = 1;}
		else {$FactAutoModif = 2;}
		if($_GET['Impression'] == 2) {$FactAutoModif = 1;}
		if($_SESSION['infologlang2'] == "ca" AND $_SESSION['connind'] == "util") {$FactAutoModif = 2;}
		if($_SESSION['infologlang2'] == "ca" AND $_SESSION['connind'] == "clie") {$FactAutoModif = 1;}

		$Lecture.="<table class='tab_rubrique FactAffichePrestation' style='width:100%;'>";
			$Lecture.="<thead style='font-size:28px;'><tr>";
			$Lecture.="<td>".$_SESSION['STrad65']."</td>";
			$Lecture.="<td class='supp400px'>".$_SESSION['STrad66']."</td>";
			$Lecture.="<td class='supp400px'>".$_SESSION['STrad67']."</td>";
			$Lecture.="<td class='supp400px'>".$_SESSION['STrad68']."</td>";

			if($reqInfoAffich['infologlang2'] == "ca") {$Lecture.="<td class='supp400px'>".$_SESSION['STrad260']."</td>";}
			else {$Lecture.="<td class='supp400px'>".$_SESSION['STrad249']."</td>";}
			$Lecture.="<td>".$_SESSION['STrad69']."</td>";
			// SUPPRIMER
			if($FactAutoModif == 2) {$Lecture.="<td class='no_print'></td>";}
			$Lecture.="</tr></thead>";
			$Lecture.="<tbody style='font-size:28px;'>";

		// LISTE PRESTATION DE LA FACTURE
		$reqPrest = 'SELECT factprestnum,factures_factnum,factprestdate,factprestlibe,factprestrempourc,typeprestation_typeprestnum,factprestqte,clients_clienum,factprestavoir,SUM(factprestation_prix.factprestprixht),SUM(factprestprixstatprixttc),factprestremmontant FROM factprestation,factprestation_prix WHERE factprestation_factprestnum = factprestnum AND factures_factnum = "'.$factnum.'" GROUP BY factprestnum';
		$reqPrestResult = $ConnexionBdd ->query($reqPrest) or die ('Erreur SQL !'.$reqPrest.'<br />'.mysqli_error());
		while($reqPrestAffich = $reqPrestResult->fetch())
			{
				if($FactAutoModif == 2)
					{
						$Liens1 = "<a href='".$Dossier."modules/facturation/modFactPrestModif.php?factprestnum=".$reqPrestAffich[0]."' class='LoadPage FactPrestModif'>";
						$Liens2 = "</a>";
					}

				$i = 0;
				$reqVerif1 = 'SELECT count(factprestprixnum) FROM factprestation_prix left outer join typeprestation_prix on typeprestation_prix_typeprestprixnum = typeprestprixnum WHERE factprestation_factprestnum = "'.$reqPrestAffich[0].'"';
				$reqVerif1Result = $ConnexionBdd ->query($reqVerif1) or die ('Erreur SQL !'.$reqVerif1.'<br />'.mysqli_error());
				$reqVerif1Affich = $reqVerif1Result->fetch();
				$NbPrest = $reqVerif1Affich[0];

				$reqPrix = 'SELECT * FROM factprestation_prix left outer join typeprestation_prix on typeprestation_prix_typeprestprixnum = typeprestprixnum WHERE factprestation_factprestnum = "'.$reqPrestAffich[0].'"';
				$reqPrixResult = $ConnexionBdd ->query($reqPrix) or die ('Erreur SQL !'.$reqPrix.'<br />'.mysqli_error());
				while($reqPrixAffich = $reqPrixResult->fetch())
					{
						$i = $i +1;

						$Lecture.="<tr>";
						$Libe = "";
						if($reqPrestAffich['factprestdate'] != "0000-00-00" AND !empty($reqPrestAffich['factprestdate'])) {$Libe.= formatdatemysql($reqPrestAffich['factprestdate'])."<br>";}

						$Libe.= nl2br($reqPrestAffich['factprestlibe']);

						// SELECTIONNE LES CLIENTS ET CHEVAUX ASSOCIES
						$reqVerif1 = 'SELECT factprestassonum,clients_clienum,chevaux_chevnum,clients_clienum1,chevaux_chevnum1,chevaux_chevnum2,chevaux_chevnum3 FROM factprestation_association WHERE factprestation_factprestnum = "'.$reqPrestAffich[0].'"';
						$reqVerif1Result = $ConnexionBdd ->query($reqVerif1) or die ('Erreur SQL !'.$reqVerif1.'<br />'.mysqli_error());
						while($reqVerif1Affich = $reqVerif1Result->fetch())
							{
								if(!empty($reqVerif1Affich[1]))
									{
										$reqLibe = 'SELECT clienom,clieprenom FROM clients WHERE clienum = "'.$reqVerif1Affich[1].'"';
										$reqLibeResult = $ConnexionBdd ->query($reqLibe) or die ('Erreur SQL !'.$reqLibe.'<br />'.mysqli_error());
										$reqLibeAffich = $reqLibeResult->fetch();
										$Libe.= "<br>".$reqLibeAffich[0].' '.$reqLibeAffich[1];
									}
								if(!empty($reqVerif1Affich[3]))
									{
										$reqLibe = 'SELECT clienom,clieprenom FROM clients WHERE clienum = "'.$reqVerif1Affich[3].'"';
										$reqLibeResult = $ConnexionBdd ->query($reqLibe) or die ('Erreur SQL !'.$reqLibe.'<br />'.mysqli_error());
										$reqLibeAffich = $reqLibeResult->fetch();
										$Libe.= "<br>".$reqLibeAffich[0].' '.$reqLibeAffich[1];
									}
								if(!empty($reqVerif1Affich['chevaux_chevnum'])) {$Libe.= "<br>".ChevLect($reqVerif1Affich['chevaux_chevnum'],$ConnexionBdd);}
								if(!empty($reqVerif1Affich['chevaux_chevnum1'])) {$Libe.= "<br>".ChevLect($reqVerif1Affich['chevaux_chevnum1'],$ConnexionBdd);}
								if(!empty($reqVerif1Affich['chevaux_chevnum2'])) {$Libe.= "<br>".ChevLect($reqVerif1Affich['chevaux_chevnum2'],$ConnexionBdd);}
								if(!empty($reqVerif1Affich['chevaux_chevnum3'])) {$Libe.= "<br>".ChevLect($reqVerif1Affich['chevaux_chevnum3'],$ConnexionBdd);}
							}
						// SELECTIONNE UN CLIENT QUI A DES ENTRES
						$reqVerif1 = 'SELECT clienum,clienom,clieprenom FROM clientssoldeforfentree,clientssoldeforfentree_clients,clients WHERE clients_clienum = clienum AND clientssoldeforfentree_cliesoldforfentrnum = cliesoldforfentrnum AND factprestation_factprestnum = "'.$reqPrestAffich[0].'"';
						$reqVerif1Result = $ConnexionBdd ->query($reqVerif1) or die ('Erreur SQL !'.$reqVerif1.'<br />'.mysqli_error());
						while($reqVerif1Affich = $reqVerif1Result->fetch())
							{
								$Libe.="<br><b>(".$reqVerif1Affich[1]." ".$reqVerif1Affich[2].")</b>";

							}

						if($i == 1)
							{
								$Lecture.="<td rowspan='".$NbPrest."' style='white-space:normal;'>".$Liens1.$Libe.$Liens2."</td>";
								$Lecture.="<td rowspan='".$NbPrest."' class='supp400px' style='text-align:center;'>".$Liens1.$reqPrestAffich['factprestqte'].$Liens2."</td>";
							}
						// PRIX UNITAIRE
						if(empty($reqPrixAffich['factprestqte'])) {$reqPrixAffich['factprestqte'] = 1;}
						$PuHT = $reqPrixAffich['factprestprixstatprixht'] / $reqPrestAffich['factprestqte'];
						$PuHT = number_format($PuHT, 2, '.', '');
						$Lecture.="<td class='supp400px'>".$Liens1."<div style='white-space:nowrap;float:right;'>";$Lecture.="<b>".$PuHT." ".$_SESSION['STrad27']."</b>";if(!empty($reqPrixAffich['typeprestprixlibe'])) {$Lecture.=" <i>(".$reqPrixAffich['typeprestprixlibe'].")</i> : ";}$Lecture.="</div>".$Liens2."</td>";

						// TOTAL HT
						$reqPrixAffich['factprestprixstatprixht'] = number_format($reqPrixAffich['factprestprixstatprixht'], 2, '.', '');
						$Lecture.="<td class='supp400px'>".$Liens1."<div style='white-space:nowrap;float:right;'>".$reqPrixAffich['factprestprixstatprixht']." ".$_SESSION['STrad27']."</div>".$Liens2."</td>";

						// TOTAL TVA
						if($_SESSION['infologlang2'] == "ca")
							{
								$reqPrixAffich['factprestprixtva'] = 	$reqPrixAffich['factprestprixstatprixtva'] + $reqPrixAffich['factprestprixstatprixtva1'];
								$IndTva = $_SESSION['STrad27'];
							}
						else
							{
								$reqPrixAffich['factprestprixtva'] = $reqPrixAffich['factprestprixtva'] * 100;
								$IndTva = "%";
							}
						$reqPrixAffich['factprestprixtva'] = number_format($reqPrixAffich['factprestprixtva'], 2, '.', '');
						$Lecture.="<td class='supp400px'>".$Liens1;
						$Lecture.="<div style='white-space:nowrap;text-align:center;'>".$reqPrixAffich['factprestprixtva']." ".$IndTva."</div>";
						$Lecture.=$Liens2."</td>";


						// PRIX TTC
						$reqPrixAffich['factprestprixstatprixttc'] = number_format($reqPrixAffich['factprestprixstatprixttc'], 2, '.', '');
						$Lecture.="<td>".$Liens1;
						$Lecture.="<div style='white-space:nowrap;'>".$reqPrixAffich['factprestprixstatprixttc']." ".$_SESSION['STrad27']."</div>";


						if(!empty($reqPrestAffich['factprestremmontant'])) {$Lecture.="<i style='font-size:10px;'>".$_SESSION['STrad750']." : ".$reqPrestAffich['factprestremmontant']." ".$_SESSION['STrad27']."</i>";}
						else if(!empty($reqPrestAffich['factprestrempourc'])) {$reqPrestAffich['factprestrempourc']=$reqPrestAffich['factprestrempourc']*100;$Lecture.="<i style='font-size:10px;'>".$_SESSION['STrad750']." : ".$reqPrestAffich['factprestrempourc']." %</i>";}

						$Lecture.=$Liens2."</td>";

						if($i == 1)
							{
								if($FactAutoModif == 2) {$Lecture.="<td rowspan='".$NbPrest."'><a href='".$Dossier."modules/facturation/modfactPrestSupp.php?factnum=".$factnum."&factprestnum=".$reqPrestAffich[0]."' class='LoadPage FactPrestSupp'><img src='".$Dossier."images/supprimer.png' class='ImgSousMenu2'></a></td>";}
							}

						$Lecture.="</tr>";
					}
			}

		// AJOUTER UNE PRESTATION
		if($FactAutoModif == 2)
			{
				$Lecture.="<tr><td colspan='7'><div style='height:15px;'></div><a href='".$Dossier."modules/facturation/modfactPrestationsAjou.php?factnum=".$factnum."' class='button LoadPage FactPrestAjou' style='color:white;'><img src='".$Dossier."images/ajouterBlanc.png' class='ImgSousMenu2'>".$_SESSION['STrad157']."</a><div style='height:15px;'></div></td></tr>";
			}

		$Lecture.="</tbody>";
		$Lecture.="</table>";

		return $Lecture;
	}

//************************** SOUS MENU FACTURATION **********************************
function SousMenuFacturation($Dossier,$ConnexionBdd)
	{
		$Lecture.="<ul class='menuBas1'>";
		  $Lecture.="<li><a href='#'><img src='".$Dossier."images/menu.png' class='ImgSousMenu1'></a>";
		    $Lecture.="<ul class='quatreliens'>";
		        $Lecture.="<li><a href='#FenAfficheFactRecherche'><img src='".$Dossier."images/rechercher.png' class='ImgSousMenu2'>".$_SESSION['STrad64']."</a></li>";
		        $Lecture.="<li><a href='".$Dossier."modules/facturation/modfactAjouter.php?facttype=".$_GET['facttype']."' class='LoadPage FactAjouter'><img src='".$Dossier."images/ajouter.png' class='ImgSousMenu2'>".$_SESSION['STrad160']."</a></li>";
		        $Lecture.="<li><a href='#'><img src='".$Dossier."images/configuration.png' class='ImgSousMenu2'>".$_SESSION['STrad161']."</a></li>";
		        if(!empty($factnum)) {$Lecture.="<li><a href='#'>Lien sous menu 3</a></li>";}
		    $Lecture.="</ul>";
		  $Lecture.="</li>";
		$Lecture.="</ul>";

		return $Lecture;
	}
//************************************************************************************

//************************** SOUS MENU FACTURATION **********************************
function SousMenuFacturationFichComplet($Dossier,$ConnexionBdd,$factnum)
	{
		$req='SELECT * FROM factures WHERE factnum = "'.$factnum.'"';
		$reqResult = $ConnexionBdd ->query($req) or die ('Erreur SQL !'.$req.'<br />'.mysqli_error());
		$reqAffich = $reqResult->fetch();

		if($_SESSION['ResolutionConnexion1'] <= 800) {$Ancre = "FenAfficheFicheFacture1";}
		else {$Ancre = "";}

		if($reqAffich['facttype'] == 4 AND $_SESSION['connind'] == "clie") {$ResultatTailleWidth = "49.5";}
		else if($reqAffich['facttype'] == 4 AND $_SESSION['connind'] == "util") {$ResultatTailleWidth = "19.5";}
		else if($reqAffich['facttype'] == 8) {$ResultatTailleWidth = "33";}
		else if($reqAffich['facttype'] == 7) {$ResultatTailleWidth = "24.5";}

		// SUPPRIMER
		if($reqAffich['facttype'] != 4 AND $reqAffich['facttype'] != 5 AND $_SESSION['connind'] == "util")
			{
				$Libe = "";
				if($_SESSION['ResolutionConnexion1'] <= 800) {$Libe = $_SESSION['STrad316'];}
				else {$Libe = $_SESSION['STrad155'];}

				$SousMenuCorp.="<div class='buttonBasMenuFixedRub'";if($_SESSION['ResolutionConnexion1'] <= 800){$SousMenuCorp.=" style='width:".$ResultatTailleWidth."%;'";}
				$SousMenuCorp.="><a href='".$Dossier."modules/facturation/modfactsupprimer.php?factnum=".$factnum."' class='LoadPage SupprimerFacture";
				if($_SESSION['ResolutionConnexion1'] > 800) {$SousMenuCorp.=" button ImgSousMenu2 buttonMargRight";} else {$SousMenuCorp.=" ImgSousMenu2";}
				$SousMenuCorp.="'><img src='".$Dossier."images/supprimerBlanc.png' class='";if($_SESSION['ResolutionConnexion1'] > 800) {$SousMenuCorp.="ImgSousMenu2";} else {$SousMenuCorp.="ImgSousMenu2";}
				$SousMenuCorp.="'>".$Libe."</a></div>";
			}

		// AJOUTER
		if($_SESSION['connind'] == "util")
			{
				$Libe = "";
				if($_SESSION['ResolutionConnexion1'] <= 800) {$Libe = $_SESSION['STrad317'];}
				else {$Libe = $_SESSION['STrad160'];}
				$SousMenuCorp.="<div class='buttonBasMenuFixedRub'";if($_SESSION['ResolutionConnexion1'] <= 800) {$SousMenuCorp.=" style='width:".$ResultatTailleWidth."%;'";}
				$SousMenuCorp.="><a href='".$Dossier."modules/facturation/modfactAjouter.php?facttype=".$reqAffich['facttype']."' class='LoadPage FactAjouter";
				if($_SESSION['ResolutionConnexion1'] > 800) {$SousMenuCorp.=" button ImgSousMenu2 buttonMargRight";} else {$SousMenuCorp.=" ImgSousMenu2";	}
				$SousMenuCorp.="'><img src='".$Dossier."images/ajouterBlanc.png' class='";if($_SESSION['ResolutionConnexion1'] > 800) {$SousMenuCorp.="ImgSousMenu2";} else {$SousMenuCorp.="ImgSousMenu2";}
				$SousMenuCorp.="'>".$Libe."</a></div>";
			}

		// DUPLIQUER
		if($_SESSION['connind'] == "util")
			{
				$Libe = "";
				if($_SESSION['ResolutionConnexion1'] <= 800) {$Libe = $_SESSION['STrad318'];	}
				else {if($reqAffich['facttype'] == 8) {$Libe = $_SESSION['STrad154'];}else {$Libe = $_SESSION['STrad103'];}}
				$SousMenuCorp.="<div class='buttonBasMenuFixedRub'";if($_SESSION['ResolutionConnexion1'] <= 800) {$SousMenuCorp.=" style='width:".$ResultatTailleWidth."%;'";}
				$SousMenuCorp.="><a href='".$Dossier."modules/facturation/modfactDupliquer.php?factnum=".$factnum."' class='LoadPage AfficheFactDupliquer";
				if($_SESSION['ResolutionConnexion1'] > 800) {$SousMenuCorp.=" button ImgSousMenu2 buttonMargRight";} else {$SousMenuCorp.=" ImgSousMenu2";	}
				$SousMenuCorp.="'><img src='".$Dossier."images/copierBlanc.png' class='";if($_SESSION['ResolutionConnexion1'] > 800) {$SousMenuCorp.="ImgSousMenu2";} else {$SousMenuCorp.="ImgSousMenu2";}
				$SousMenuCorp.="'>".$Libe."</a></div>";
			}

		// PASSER EN FACTURE
		if(($reqAffich['facttype'] == 7 OR $reqAffich['facttype'] == 1) AND $_SESSION['connind'] == "util")
			{
				$Libe = "";
				$Libe = $_SESSION['STrad319'];
				$SousMenuCorp.="<div class='buttonBasMenuFixedRub'";if($_SESSION['ResolutionConnexion1'] <= 800) {$SousMenuCorp.=" style='width:".$ResultatTailleWidth."%;'";}
				$SousMenuCorp.="><a href='".$Dossier."modules/facturation/modfactpasserenfacture.php?factnum=".$factnum."' class='LoadPage PasserEnFacture2";
				if($_SESSION['ResolutionConnexion1'] > 800) {$SousMenuCorp.=" button ImgSousMenu2 buttonMargRight";} else {$SousMenuCorp.=" ImgSousMenu2";	}
				$SousMenuCorp.="'><img src='".$Dossier."images/ajouterBlanc.png' class='";if($_SESSION['ResolutionConnexion1'] > 800) {$SousMenuCorp.="ImgSousMenu2";} else {$SousMenuCorp.="ImgSousMenu2";}
				$SousMenuCorp.="'>".$Libe."</a></div>";
			}

		// IMPRIMER
		if($reqAffich['facttype'] != 7 AND $reqAffich['facttype'] != 8 AND $_SESSION['ResolutionConnexion1'] > 800)
			{
				$Libe = "";
				$SousMenuCorp.="<div class='buttonBasMenuFixedRub'><a href=\"Imprimer\"target=\"popup\" onclick=\"window.open('".$Dossier."modules/facturation/modfactImpression.php?factnum=".$factnum."&Impression=2','popup','width=1024px,height=550px,left=100px,top=100px,scrollbars=1');return(false)\" class='button ImgSousMenu2 buttonMargRight'><img src='".$Dossier."images/imprimerBlanc.png' class='ImgSousMenu2'>".$_SESSION['STrad105']."</a></div>";
			}

		// ENVOYER PAR MAIL
		if($reqAffich['facttype'] != 7 AND $reqAffich['facttype'] != 8)
			{
				$Libe = "";
				if($_SESSION['ResolutionConnexion1'] <= 800) {$Libe = $_SESSION['STrad322'];}
				else {$Libe = $_SESSION['STrad102'];}
				$SousMenuCorp.="<div class='buttonBasMenuFixedRub'";if($_SESSION['ResolutionConnexion1'] <= 800) {$SousMenuCorp.=" style='width:".$ResultatTailleWidth."%;'";}
				$SousMenuCorp.="><a href='".$Dossier."modules/divers/modEnvoyerUnMail.php?factnum=".$factnum."' class='LoadPage AfficheEnvoiMail";
				if($_SESSION['ResolutionConnexion1'] > 800) {$SousMenuCorp.=" button ImgSousMenu2 buttonMargRight";} else {$SousMenuCorp.=" ImgSousMenu2";	}
				$SousMenuCorp.="'><img src='".$Dossier."images/mailBlanc.png' class='";if($_SESSION['ResolutionConnexion1'] > 800) {$SousMenuCorp.="ImgSousMenu2";} else {$SousMenuCorp.="ImgSousMenu2";}
				$SousMenuCorp.="'>".$Libe."</a></div>";
			}


		// CREER UN AVOIR
		if($reqAffich['facttype'] == 4 AND $_SESSION['connind'] == "util")
			{
				$Libe = "";
				if($_SESSION['ResolutionConnexion1'] <= 800) {$Libe = $_SESSION['STrad325'];}
				else {$Libe = $_SESSION['STrad104'];}
				$SousMenuCorp.="<div class='buttonBasMenuFixedRub'";if($_SESSION['ResolutionConnexion1'] <= 800) {$SousMenuCorp.=" style='width:".$ResultatTailleWidth."%;'";}
				$SousMenuCorp.="><a href='".$Dossier."modules/facturation/modfactCreerAvoir.php?factnum=".$factnum."' class='LoadPage AfficheFactCreeAvoir";
				if($_SESSION['ResolutionConnexion1'] > 800) {$SousMenuCorp.=" button ImgSousMenu2 buttonMargRight";} else {$SousMenuCorp.=" ImgSousMenu2";	}
				$SousMenuCorp.="'><img src='".$Dossier."images/ajouterBlanc.png' class='";if($_SESSION['ResolutionConnexion1'] > 800) {$SousMenuCorp.="ImgSousMenu2";} else {$SousMenuCorp.="ImgSousMenu2";}
				$SousMenuCorp.="'>".$Libe."</a></div>";
			}

		// AJOUTER UN ENCAISSEMENT
		if($reqAffich['facttype'] == 4 AND $_SESSION['connind'] == "util")
			{
				$Libe = "";
				if($_SESSION['ResolutionConnexion1'] <= 800) {$Libe = $_SESSION['STrad323'];}
				else {$Libe = $_SESSION['STrad107'];}
				$SousMenuCorp.="<div class='buttonBasMenuFixedRub'";if($_SESSION['ResolutionConnexion1'] <= 800) {$SousMenuCorp.=" style='width:".$ResultatTailleWidth."%;'";}
				$SousMenuCorp.="><a href='".$Dossier."modules/facturation/modfactEncAjouter.php?factnum=".$factnum."&AfficheFacture=2' class='LoadPage FactEncAjouter";
				if($_SESSION['ResolutionConnexion1'] > 800) {$SousMenuCorp.=" button ImgSousMenu2 buttonMargRight";} else {$SousMenuCorp.=" ImgSousMenu2";	}
				$SousMenuCorp.="'><img src='".$Dossier."images/ajouterBlanc.png' class='";if($_SESSION['ResolutionConnexion1'] > 800) {$SousMenuCorp.="ImgSousMenu2";} else {$SousMenuCorp.="ImgSousMenu2";}
				$SousMenuCorp.="'>".$Libe."</a></div>";
			}

		// AJOUTER UN REMBOURSEMENT
		if($reqAffich['facttype'] == 5 AND $_SESSION['connind'] == "util")
			{
				$Libe = "";
				if($_SESSION['ResolutionConnexion1'] <= 800) {$Libe = $_SESSION['STrad324'];}
				else {$Libe = $_SESSION['STrad153'];}
				$SousMenuCorp.="<div class='buttonBasMenuFixedRub'";if($_SESSION['ResolutionConnexion1'] <= 800) {$SousMenuCorp.=" style='width:".$ResultatTailleWidth."%;'";}
				$SousMenuCorp.="><a href='#' class='LoadPage FactEncAjouter";
				if($_SESSION['ResolutionConnexion1'] > 800) {$SousMenuCorp.=" button ImgSousMenu2 buttonMargRight";} else {$SousMenuCorp.="ImgSousMenu2";	}
				$SousMenuCorp.="'><img src='".$Dossier."images/ajouterBlanc.png' class='";if($_SESSION['ResolutionConnexion1'] > 800) {$SousMenuCorp.="ImgSousMenu2";} else {$SousMenuCorp.="ImgSousMenu2";}
				$SousMenuCorp.="'>".$Libe."</a></div>";
			}

		$Lecture.="<div class='buttonBasMenuFixed1'>";
		$Lecture.=$SousMenuCorp;
		$Lecture.="</div>";

		return $Lecture;
	}
//************************************************************************************

//******************* TYPE D'ACTION POUR L'ENCAISSEMENT *************************************
function EncaissementsAction($action,$factenctype)
	{
		$Lecture.="<option value=''>- ".$_SESSION['STrad800']." -</option>";
		$Lecture.="<option value='1'";if($action == 1) {$Lecture.=" selected";} $Lecture.=">".$_SESSION['STrad763']."</option>";
		$Lecture.="<option value='2'";if($action == 2) {$Lecture.=" selected";} $Lecture.=">".$_SESSION['STrad155']."</option>";

		return $Lecture;
	}
//************************************************************************************

//*********************** AFFICHE ENCAISSEMENT FACTURE *******************
function EncaissementsListe($ConnexionBdd,$Dossier,$factenctype,$EncAction)
	{
		if(!empty($_GET['factenctype'])) {$factenctype = $_GET['factenctype'];}

		if(!empty($_SESSION['factencdate1']) AND empty($_SESSION['factencdate2'])) {$_SESSION['factencdate2'] = date('Y-m-31');}
		if(!empty($_POST['rechencclienum'])) {$_SESSION['rechencclienum'] = $_POST['rechencclienum'];}

		// RECHERCHE PAR PERIODE
		$Lecture.="<input type='date' name='factencdate1' class='champ_barre' style='width:50%;float:left;' value='".$_SESSION['factencdate1']."'>";
		$Lecture.="<input type='date' name='factencdate2' class='champ_barre' style='width:50%;float:left;' value='".$_SESSION['factencdate2']."'>";
		// RECHERCHER PAR CLIENT
		$Lecture.="<select class='champ_barre' name='rechencclienum'>".ClieSelect($Dossier,$ConnexionBdd,$_SESSION['rechencclienum'],$faminum,$factnum,$AfficheNull,$AjouterClientPassage,$calenum,$chevnum,$AfficherAjouCava,$ResponsableLegal,$calecopier,$SelectMontoir)."</select>";

		if(empty($factenctype) OR $factenctype == 2)
		  {
		    $Lecture.="<select name='EncAction' class='champ_barre'>".EncaissementsAction(null)."</select>";
		    $Lecture.="<button class='button'><img src='".$Dossier."images/validerBlanc.png' class='ImgSousMenu2'>".$_SESSION['STrad307']."</button>";
		    $Lecture.="<br><br>";
		  }

		$Lecture.='<div style="width:100%;clear:both;display:block;margin-botom:25px;"><input onclick="CocheTout(this, \'factencnum[]\');" type="checkbox">'.$_SESSION['STrad799'].'</div>';

		$reqEnc = 'SELECT * FROM factencaisser';
		if(!empty($_SESSION['rechencclienum'])) {$reqEnc.=',factures_factencaisser,factprestation,factures';}
		$reqEnc.=' WHERE factencaisser.AA_equimondo_hebeappnum = "'.$_SESSION['hebeappnum'].'"';
		if(!empty($_SESSION['rechencclienum'])) {$reqEnc.=' AND factures_factencaisser.factencaisser_factencnum = factencnum AND factures_factencaisser.factprestation_factprestnum = factprestnum AND factprestation.factures_factnum = factnum AND factures.clients_clienum = "'.$_SESSION['rechencclienum'].'"';}
		if(!empty($factenctype)) {$reqEnc.=' AND factenctype = "'.$factenctype.'"';}
		if(!empty($_SESSION['factencdate1']) AND !empty($_SESSION['factencdate2'])) {$reqEnc.=' AND factencdate BETWEEN "'.$_SESSION['factencdate1'].'" AND "'.$_SESSION['factencdate2'].'"';}
		$reqEnc.=' ORDER BY factencdateenr DESC';
		$reqEncResult = $ConnexionBdd ->query($reqEnc) or die ('Erreur SQL !'.$reqEnc.'<br />'.mysqli_error());
		while($reqEncAffich = $reqEncResult->fetch())
			{
				// VERIF SI YA PAS UNE ANNULATION
				$reqVerif1 = 'SELECT count(factencassonum),factencassodate FROM factencaisser_association WHERE factencaisser_factencnumorigine = "'.$reqEncAffich['factencnum'].'"';
				$reqVerif1Result = $ConnexionBdd ->query($reqVerif1) or die ('Erreur SQL !'.$reqVerif1.'<br />'.mysqli_error());
				$reqVerif1Affich = $reqVerif1Result->fetch();
				if($reqVerif1Affich[0] == 1) {$AlerteEnc = "AlerteRed";$EncAnnule = 2;}
				else {$AlerteEnc = "";$EncAnnule = 1;}

				$reqVerif1 = 'SELECT facttype,factures.clients_clienum FROM factures,factprestation,factures_factencaisser WHERE factures_factnum=factnum AND factprestation_factprestnum = factprestnum AND factencaisser_factencnum = "'.$reqEncAffich['factencnum'].'" LIMIT 0,1';
				$reqVerif1Result = $ConnexionBdd ->query($reqVerif1) or die ('Erreur SQL !'.$reqVerif1.'<br />'.mysqli_error());
				$reqVerif1Affich = $reqVerif1Result->fetch();
				if($reqVerif1Affich['facttype'] == 4) {$Exec = 2;}
				else {$Exec = 1;}

				if($_SESSION['ResolutionConnexion1'] <= 800) {$Lien = "<a href='".$Dossier."modules/facturation/modEncaissementFiche1.php?factencnum=".$reqEncAffich['factencnum']."' class='AfficheFicheEncaissement1'>";}
				else {$Lien = "<a href='".$Dossier."modules/facturation/modEncaissementFiche2.php?factencnum=".$reqEncAffich['factencnum']."' class='AfficheFicheEncaissement2'>";}

				if($Exec == 2)
					{
						$Lecture.="<tr class='".$AlerteEnc."'>";
						$Lecture.="<td><section style='width:9%;float:left;'>";
							$Lecture.="<input type='checkbox' name='factencnum[]' value='".$reqEncAffich['factencnum']."'>";
						$Lecture.="</section>".$Lien;
							$Lecture.="<section style='width:60%;float:left;'>";
								$Lecture.="<span class='Liste1Titre'>".ClieLect($reqVerif1Affich[1],$ConnexionBdd)."</span><br>";
								$Export.=ClieLect($reqVerif1Affich[1],$ConnexionBdd).";";
								$Lecture.="<span class='Liste1SousTitre1'>".formatdatemysql($reqEncAffich['factencdate'])."</span><br>";
								$Export.=formatdatemysql($reqEncAffich['factencdate']).";";
								$Lecture.="<span class='Liste1SousTitre1'>".ModePaieLect($reqEncAffich['mode_paie_modepaienum'],$ConnexionBdd)."</span><br>";
								$Export.=ModePaieLect($reqEncAffich['mode_paie_modepaienum'],$ConnexionBdd).";";
							$Lecture.="</section>";
							$Lecture.="<section style='width:29%;float:left;'>";
								$Lecture.="<div class='Liste1Titre'>".$reqEncAffich['factencmontantverser']." ".$_SESSION['STrad27']."</div>";
								if($reqEncAffich['factenctype'] == 1) {$Lecture.="<div style='font-style:italic;color:green;'>".CategorieEncaissement($ConnexionBdd,$Dossier,$reqEncAffich['factenctype'])."</div>";}
								if($reqEncAffich['factenctype'] == 2) {$Lecture.="<div style='font-style:italic;color:red;'>".CategorieEncaissement($ConnexionBdd,$Dossier,$reqEncAffich['factenctype'])."</div>";}
								$Export.=$reqEncAffich['factencmontantverser'].";";
								if($EncAnnule == 2) {$Lecture.="<div class='FactListStatus' style='background-color:red;'>".$_SESSION['STrad151']."</div>";}
							$Lecture.="</section>";

							// LISTE DES FACTURES ASSOCIES
							$FactAsso = "";
							$req1='SELECT factnum,factnumlibe,factdate,facttype FROM factprestation,factures_factencaisser,factures WHERE factures_factnum = factnum AND factures_factencaisser.factprestation_factprestnum = factprestnum AND factures_factencaisser.factencaisser_factencnum = "'.$reqEncAffich['factencnum'].'"';
							$req1Result = $ConnexionBdd ->query($req1) or die ('Erreur SQL !'.$req1.'<br />'.mysqli_error());
							while($req1Affich = $req1Result->fetch())
								{
									$FactAsso.=", ".FactIndLect($req1Affich['facttype']).' N° '.FactPrefLect($req1Affich['factdate'],$req1Affich['factnumlibe'],null,null);
								}
							$FactAsso = substr($FactAsso, 2,9999);

							$Lecture.="<div style='width:100%;clear:both;display:block;'>".$FactAsso."</div>";

						$Lecture.="</a></td>";
						$Lecture.="</tr>";

						// EXPORT NUMERO DE FACTURE
						$reqVerif1 = 'SELECT DISTINCT factnumlibe FROM factures,factprestation,factures_factencaisser WHERE factures_factnum=factnum AND factprestation_factprestnum = factprestnum AND factencaisser_factencnum = "'.$reqEncAffich['factencnum'].'"';
						$reqVerif1Result = $ConnexionBdd ->query($reqVerif1) or die ('Erreur SQL !'.$reqVerif1.'<br />'.mysqli_error());
						while($reqVerif1Affich = $reqVerif1Result->fetch())
						{$Export.=$reqVerif1Affich[0].", ";}
						$Export.=";";
						// lES PRESTATIONS ASSOCIÉS
						$reqVerif1 = 'SELECT typeprestation_typeprestnum FROM factprestation,factures_factencaisser WHERE factprestation_factprestnum = factprestnum AND factencaisser_factencnum = "'.$reqEncAffich['factencnum'].'"';
						$reqVerif1Result = $ConnexionBdd ->query($reqVerif1) or die ('Erreur SQL !'.$reqVerif1.'<br />'.mysqli_error());
						while($reqVerif1Affich = $reqVerif1Result->fetch())
						{$Export.=TypePrestationLect($reqVerif1Affich[0],$ConnexionBdd).", ";}

						$Export.="\n";
						$Lecture.="<tr><td><hr class='HrListe1' style='clear:both;display:block;'></td></tr>";
					}
			}

		return array($Lecture,$Export);
	}
//************************************************************************************

//*************************** FICHE COMPLET REMISE EN BANQUE ********************************************
function EncaissementFichComplet($Dossier,$ConnexionBdd,$factencnum,$AfficheBouttonImprimer)
	{
		$req1 = 'SELECT * FROM factencaisser WHERE factencnum="'.$factencnum.'"';
		$req1Result = $ConnexionBdd ->query($req1) or die ('Erreur SQL !'.$req1.'<br />'.mysqli_error());
		$req1Affich = $req1Result->fetch();

		$Lecture.="<div style='height:10px;'></div>";
		if($_GET['Impression'] != 2 AND $_SESSION['ResolutionConnexion1'] > 800 AND $AfficheBouttonImprimer == 2) {$Lecture.="<a href=\"Imprimer\"target=\"popup\" onclick=\"window.open('".$Dossier."modules/facturation/modEncaissementFiche2.php?factencnum=".$factencnum."&Impression=2','popup','width=1024px,height=550px,left=100px,top=100px,scrollbars=1');return(false)\" class='button'><img src='".$Dossier."images/imprimerBlanc.png' class='ImgSousMenu2 '> ".$_SESSION['STrad105']."</a>";}

		// SUPPRIMER UN ENCAISSEMENT EN ATTENTE
		if($_SESSION['connind'] == "util" AND $req1Affich['factenctype'] == 2)
			{
				$Lecture.="<a href='".$Dossier."modules/facturation/modenclist2.php?factenctype=2&factencsupp=2&factencnum=".$factencnum."' class='button AfficheEncaissementSupp'><img src='".$Dossier."images/supprimerBlanc.png' class='ImgSousMenu2'>".$_SESSION['STrad762']."</a>";
				$Lecture.="<a href='".$Dossier."modules/facturation/modenclist2.php?factencpasser=2&factencnum=".$factencnum."' class='button AfficheEncaissementSupp' style='margin-left:10px;'><img src='".$Dossier."images/validerBlanc.png' class='ImgSousMenu2'>".$_SESSION['STrad763']."</a>";
			}

		//******************** BOUTTON FERMER **************************
		if($_SESSION['ResolutionConnexion1'] <= 800) {$LibeButt = $_SESSION['STrad705'];}
		else {$LibeButt = $_SESSION['STrad746'];}
		if($_SESSION['ResolutionConnexion1'] <= 800) {$SousMenuCorp.="<div class='buttonBasMenuFixedRub'><a href='#close' class='button buttonLittle'><img src='".$Dossier."images/closeBlanc.png' class='ImgSousMenu2'>".$LibeButt."</a></div>";}

		if($_SESSION['ResolutionConnexion1'] <= 800)
		  {
		    $ResultatTailleWidth = "98";
		    $SousMenuCorp = str_replace("<div class='buttonBasMenuFixedRub'>","<div class='buttonBasMenuFixedRub' style='width:".$ResultatTailleWidth."%;'>",$SousMenuCorp);
		    $Lecture.="<div class='buttonBasMenuFixed'>";
		    $Lecture.=$SousMenuCorp;
		    $Lecture.="</div>";
		  }
		//****************************************************************

		$Lecture.="<div style='height:40px;'></div>";

		// VERIF S IL N Y A PAS UNE ANNULATION
		$reqVerif1 = 'SELECT * FROM factencaisser,factencaisser_association WHERE factencaisser_factencnumancien = factencnum AND factencaisser_factencnumorigine ="'.$factencnum.'"';
		$reqVerif1Result = $ConnexionBdd ->query($reqVerif1) or die ('Erreur SQL !'.$reqVerif1.'<br />'.mysqli_error());
		$reqVerif1Affich = $reqVerif1Result->fetch();
		if(!empty($reqVerif1Affich['factencnum']))
			{
				$Lecture.="<div class='InfoPetit1'>".$_SESSION['STrad167']." <b>".FormatDateTimeMySql($reqVerif1Affich['factencdateenr'])."</b><br>Raison : <b>".$reqVerif1Affich['factenccommentaire']."</b><br>Numï¿½ro de chainage : <b>".$reqVerif1Affich['factencnumchainage']."</b></div>";
			}

		if(empty($reqVerif1Affich['factencnum']) AND $req1Affich['factenccloture'] == 1 AND $_SESSION['connind'] == 'util')
			{
				$Lecture.="<a href='?factnum=".$_GET['factnum']."&factencnum=".$factencnum."#FactEncAnnule' class='button'>".$_SESSION['STrad168']."</a>";
			}

		$Lecture.="<table>";
		$Lecture.="<tr>";
			$Lecture.="<td></td>";
			$Lecture.="<td>".CategorieEncaissement($ConnexionBdd,$Dossier,$req1Affich['factenctype'])."</td>";
		$Lecture.="</tr>";
		$Lecture.="<tr>";
			$Lecture.="<td>".$_SESSION['STrad170']." :</td>";
			$Lecture.="<td>".formatdatemysql($req1Affich['factencdate'])."<br><i style='font-style:italic;'>".$_SESSION['STrad169']." ".FormatDateTimeMySql($req1Affich['factencdateenr'])."</i></td>";
		$Lecture.="</tr>";
		$Lecture.="<tr>";
			$Lecture.="<td>".$_SESSION['STrad171']." :</td>";
			$Lecture.="<td>".$req1Affich['factencmontantverser']." ".$_SESSION['STrad27']."</td>";
		$Lecture.="</tr>";
		$Lecture.="<tr>";
			$Lecture.="<td>".$_SESSION['STrad172']." :</td>";
			$Lecture.="<td>".ModePaieLect($req1Affich['mode_paie_modepaienum'],$ConnexionBdd)."</td>";
		$Lecture.="</tr>";
		$Lecture.="<tr>";
			$Lecture.="<td>".$_SESSION['STrad94']." :</td>";
			$Lecture.="<td>".$req1Affich['factencreference']."</td>";
		$Lecture.="</tr>";
		$Lecture.="<tr>";
			$Lecture.="<td>".$_SESSION['STrad173']." :</td>";
			$Lecture.="<td>".$req1Affich['factencnomemetteur']."</td>";
		$Lecture.="</tr>";
		$Lecture.="<tr>";
			$Lecture.="<td>".$_SESSION['STrad174']." :</td>";
			$Lecture.="<td>".$req1Affich['factencnombanque']."</td>";
		$Lecture.="</tr>";
		$Lecture.="</table>";

		$Lecture.="<div style='height:30px;'></div>";

		$Lecture.="<table>";
		$Lecture.="<tr>";
			$Lecture.="<td>".$_SESSION['STrad175']." :</td>";
			$Lecture.="<td>".AffichQuestOuiNonLect($req1Affich['factenccloture'])."</td>";
		$Lecture.="</tr>";
		$Lecture.="<tr>";
			$Lecture.="<td>".$_SESSION['STrad176']." :</td>";
			$Lecture.="<td>".AffichQuestOuiNonLect($req1Affich['factencexport'])."</td>";
		$Lecture.="</tr>";
		$Lecture.="<tr>";
			$Lecture.="<td>".$_SESSION['STrad177']." :</td>";
			$Lecture.="<td>".$req1Affich['factencnumchainage']."</td>";
		$Lecture.="</tr>";
		$Lecture.="</table>";

		$Lecture.="<div style='height:30px;'></div>";

		$Lecture.="<table>";
		$Lecture.="<tr>";
			$Lecture.="<td>".$_SESSION['STrad178']." :</td>";
		$Lecture.="</tr>";
		$req2 = 'SELECT * FROM factures,clients,factprestation,factures_factencaisser WHERE factencaisser_factencnum = "'.$factencnum.'" AND factures_factnum = factnum AND factprestation_factprestnum = factprestnum AND factures.clients_clienum = clienum GROUP BY factprestnum';
		$req2Result = $ConnexionBdd ->query($req2) or die ('Erreur SQL !'.$req2.'<br />'.mysqli_error());
		while($req2Affich = $req2Result->fetch())
			{
				$req2Affich['factnumlibe'] = FactPrefLect($req2Affich['factdate'],$req2Affich['factnumlibe'],null);
				$Lecture.="<tr><td>".$req2Affich['factprestlibe']." ";
				if($_GET['Impression'] != 2) {$Lecture.="<a href='".$Dossier."modules/facturation/modfactfichcomplet1.php?factnum=".$req2Affich['factnum']."' class='LoadPage AfficheFicheFacture1'>";} $Lecture.="<i>(".FactIndLect($req2Affich['facttype'])." N° ".$req2Affich['factnumlibe'].")</i>";
				$Lecture.="</td></tr>";
			}
		$Lecture.="</table>";

		return $Lecture;
	}
//***************************************************************************************************

//***************************** TYPE DE CATEGORIE ENCAISSEMENT***************************************
function CategorieEncaissement($ConnexionBdd,$Dossier,$categorie)
	{
		if($categorie == 1) {$resultat = $_SESSION['STrad756'];}
		else if($categorie == 2) {$resultat = $_SESSION['STrad757'];}

		return $resultat;
	}
//***************************************************************************************************

//*********************** AFFICHE ENCAISSEMENT FACTURE *******************
function FactEnc($ConnexionBdd,$Dossier,$factnum)
	{
		$req = 'SELECT facttype,factures.AA_equimondo_hebeappnum FROM factures,clients WHERE clients_clienum=clienum AND factnum = "'.$factnum.'"';
		$reqResult = $ConnexionBdd ->query($req) or die ('Erreur SQL !'.$req.'<br />'.mysqli_error());
		$reqAffich = $reqResult->fetch();
		$Hebeappnum = $reqAffich[1];

		// SELECTIONNE LES ENCAISSEMENTS
		$reqEnc1 = 'SELECT count(factencnum)';
		$reqEnc2 = 'SELECT *';
		$reqEnc.=' FROM factencaisser';
		$reqEnc.=',factures,factprestation,clients,factures_factencaisser';
		$reqEnc.=' WHERE factencaisser.AA_equimondo_hebeappnum = "'.$Hebeappnum.'"';
		$reqEnc.=' AND factprestation.factures_factnum = factnum AND factures.clients_clienum = clienum AND factprestation_factprestnum = factprestnum AND factencaisser_factencnum = factencnum AND factprestation.factures_factnum = "'.$factnum.'"';
		$reqEnc.=' GROUP BY factencnum';
		$reqEnc.=' ORDER BY factencnum DESC';

		$reqEncCount = $reqEnc1.$reqEnc;
		$reqEncCountResult = $ConnexionBdd ->query($reqEncCount) or die ('Erreur SQL !'.$reqEncCount.'<br />'.mysqli_error());
		$reqEncCountAffich = $reqEncCountResult->fetch();
		// S'IL Y A DES ENCAISSEMENTS
		if($reqEncCountAffich[0] >= 1)
			{
				$Lecture.="<table class='tab_rubrique'>";
					$Lecture.="<thead><tr>";
					$Lecture.="<td>".$_SESSION['STrad273']."</td>";
					$Lecture.="<td>".$_SESSION['STrad88']."</td>";
					$Lecture.="<td class='supp400px supp800px'>".$_SESSION['STrad89']."</td>";
					$Lecture.="<td>".$_SESSION['STrad90']."</td>";
					$Lecture.="<td>".$_SESSION['STrad93']."</td>";
					$Lecture.="<td class='supp400px supp800px'>".$_SESSION['STrad94']."</td>";
					$Lecture.="<td class='supp400px supp800px'>".$_SESSION['STrad95']."</td>";
					$Lecture.="<td class='supp400px supp800px'>".$_SESSION['STrad96']."</td>";
					$Lecture.="<td class='supp400px supp800px'>".$_SESSION['STrad86']."</td>";
					if($_GET['Impression'] != 2) {$Lecture.="<td></td>";}
					$Lecture.="</tr></thead>";
					$Lecture.="<tbody>";

				$reqEnc = $reqEnc2.$reqEnc;
				$reqEncResult = $ConnexionBdd ->query($reqEnc) or die ('Erreur SQL !'.$reqEnc.'<br />'.mysqli_error());
				while($reqEncAffich = $reqEncResult->fetch())
					{
						// VERIF SI YA PAS UNE ANNULATION
						$reqVerif1 = 'SELECT count(factencassonum),factencassodate FROM factencaisser_association WHERE factencaisser_factencnumorigine = "'.$reqEncAffich['factencnum'].'"';
						$reqVerif1Result = $ConnexionBdd ->query($reqVerif1) or die ('Erreur SQL !'.$reqVerif1.'<br />'.mysqli_error());
						$reqVerif1Affich = $reqVerif1Result->fetch();
						if($reqVerif1Affich[0] == 1) {$AlerteEnc = "AlerteRed";$EncAnnule = 2;}
						else {$AlerteEnc = "";$EncAnnule = 1;}

						$Lien = "<span onmouseover='afficher_bulle(\"<em><div class=InfoBulle2>".CaracSpeciaux($_SESSION['STrad101'])."</div></em>\", \"white\", event);' onmouseout=\"masquer_bulle();\" class='InfoBulle1'><a href='".$Dossier."modules/facturation/modEncaissementFiche1.php?factencnum=".$reqEncAffich['factencnum']."' class='LoadPage AfficheFicheEncaissement1'>";

						// VERIF SI C'EST UN REMBOURSEMENT
						$reqVerif2 = 'SELECT factnum,facttype FROM factures,factprestation,factures_factencaisser WHERE factures_factnum=factnum AND factprestation_factprestnum = factprestnum AND factencaisser_factencnum = "'.$reqEncAffich['factencnum'].'" LIMIT 0,1';
						$reqVerif2Result = $ConnexionBdd ->query($reqVerif2) or die ('Erreur SQL !'.$reqVerif2.'<br />'.mysqli_error());
						$reqVerif2Affich = $reqVerif2Result->fetch();
						if($reqVerif2Affich['facttype'] == 5 AND $factnum == "listall") {$Exec = 1;}
						else {$Exec = 2;}

						if($Exec == 2)
							{
								$Lecture.="<tr class='".$AlerteEnc."'>";
								$Lecture.="<td>".$Lien.CategorieEncaissement($ConnexionBdd,$Dossier,$reqEncAffich['factenctype'])."</a></span></td>";
								$Lecture.="<td>".$Lien.formatdatemysql($reqEncAffich['factencdate'])."</a></span></td>";
								$Lecture.="<td class='supp400px supp800px'>".$Lien.FormatDateTimeMySql($reqEncAffich['factencdateenr'])."</a></span></td>";
								$Lecture.="<td>".$Lien.$reqEncAffich['factencmontantverser']." ".$_SESSION['STrad27']."</a></span></td>";
								$Lecture.="<td>".$Lien.ModePaieLect($reqEncAffich['mode_paie_modepaienum'],$ConnexionBdd)."</a></span></td>";
								$Lecture.="<td class='supp400px supp800px'>".$Lien.$reqEncAffich['factencreference']."</a></span></td>";
								$Lecture.="<td class='supp400px supp800px'>".$Lien.$reqEncAffich['factencnombanque']."</a></span></td>";
								$Lecture.="<td class='supp400px supp800px'>".$Lien.$reqEncAffich['factencnomemetteur']."</a></span></td>";
								$Lecture.="<td class='supp400px supp800px'>".$Lien.nl2br($reqEncAffich['factenccommentaire'])."</a></span></td>";

								if($_GET['Impression'] != 2)
									{
										$Lecture.="<td>";
											if($reqEncAffich['factenccloture'] == 1) {$Lecture.="<a href='#' class=''><img src='".$Dossier."images/annuler.png' class='ImgSousMenu1'></a>";}
										$Lecture.="</td>";
									}
								$Lecture.="</tr>";
								// SI ANNULER AFFICHE LE MOTIF
								if($reqVerif1Affich[0] == 1)
									{
										$reqEncAsso = 'SELECT * FROM factencaisser,factencaisser_association WHERE factencaisser_factencnumancien = factencnum AND factencaisser_factencnumorigine = "'.$reqEncAffich['factencnum'].'"';
										$reqEncAssoResult = $ConnexionBdd ->query($reqEncAsso) or die ('Erreur SQL !'.$reqEncAsso.'<br />'.mysqli_error());
										$reqEncAssoAffich = $reqEncAssoResult->fetch();
										$facture.="<tr class='AlerteRed'><td colspan='9'>";
											$Lecture.=$_SESSION['STrad97']." <b>".FormatDateTimeMySql($reqVerif1Affich['factencassodate'])."</b> ".$_SESSION['STrad98']." : <b>".nl2br($reqEncAssoAffich['factenccommentaire'])."</b>";
										$Lecture.="</td></tr>";
									}
						}
					}

				$Lecture.="</tbody></table>";
			}
		// S'IL N"Y A PAS D ENCAISSEMENT NI D ACOMPTE
		if($reqEncCountAffich[0] == 0 AND $_GET['Impression'] != 2 AND $reqAffich['facttype'] == 4) {$Lecture.="<div class='InfoStandard FormInfoStandard1'><img src='".$Dossier."images/informationBlanc.png' class='imgSousMenu1' style='margin-right:10px;'>".$_SESSION['STrad99']."</div>";}
		// S'IL N'Y A PAS DE REMBOURSSEMENT
		if($reqEncCountAffich[0] == 0 AND $_GET['Impression'] != 2 AND $reqAffich['facttype'] == 5) {$Lecture.="<div class='InfoStandard FormInfoStandard1'><img src='".$Dossier."images/informationBlanc.png' class='imgSousMenu1' style='margin-right:10px;'>".$_SESSION['STrad100']."</div>";}

		$Lecture.="<div style='height:50px;'></div>";

		return $Lecture;
	}
//**************************************************************************************************

//*********************** DUPLIQUER *******************
function FactDupliquer($ConnexionBdd,$Dossier,$factnum)
	{
		$req = 'SELECT * FROM factures,clients WHERE clients_clienum=clienum AND factnum = "'.$factnum.'"';
		$reqResult = $ConnexionBdd ->query($req) or die ('Erreur SQL !'.$req.'<br />'.mysqli_error());
		$reqAffich = $reqResult->fetch();
		$Hebeappnum = $reqAffich[1];

		$Lecture.="<form id='FactureDupliquer' action=''>";
		$Lecture.="<input type='hidden' name='factnum' value='".$factnum."'>";
		$Lecture.="<table class='table_champ_barre'>";
		$Lecture.="<tr><td><span class='TitreLightbox'>".$_SESSION['STrad103']." ".FactIndLect($reqAffich['facttype']).' N° '.FactPrefLect($reqAffich['factdate'],$reqAffich['factnumlibe'],null,null)."</span></td></tr>";
		$Lecture.="<tr style='height:20px;'></tr>";

		$Lecture.="<tr><td><input type='radio' name='facttype' value='1'> ".FactIndLect(1)."</td></tr>";
		$Lecture.="<tr><td><input type='radio' name='facttype' value='7'> ".FactIndLect(7)."</td></tr>";
		$Lecture.="<tr><td><input type='radio' name='facttype' value='4' checked> ".FactIndLect(4)."</td></tr>";

		$Lecture.="<tr><td><input type='date' name='factdate' class='champ_barre WidthPopup' placeholder = '".$_SESSION['STrad88']."' value='".date('Y-m-d')."' required></td></tr>";

		$Lecture.="<tr style='height:30px;'></tr>";
		$Lecture.="<tr><td><div class='InfoStandard FormInfoStandard3 WidthPopup'>".$_SESSION['STrad113']." :</div></td></tr>";

		$Lecture.="<tr><td><select name='Selectclienum[]' class='champ_barre SelectFormInfoStandard2 WidthPopup' onchange='ListPrestClie1(this.value)'>".ClieSelect($Dossier,$ConnexionBdd,$clienum,$faminum,$factnum,$AfficheNull,$AjouterClientPassage,$calenum,$chevnum,$AfficherAjouCava)."</select><div id='FactDupliquerAffiche1'></div></td></tr>";

		$Lecture.="<tr style='height:30px;'></tr>";
		$Lecture.="<tr><td><select name='Selectclienum[]' class='champ_barre SelectFormInfoStandard2 WidthPopup' onchange='ListPrestClie2(this.value)'>".ClieSelect($Dossier,$ConnexionBdd,null,null,$factnum,null)."</select><div id='FactDupliquerAffiche2'></div></td></tr>";

		$Lecture.="<tr style='height:30px;'></tr>";
		$Lecture.="<tr><td><select name='Selectclienum[]' class='champ_barre SelectFormInfoStandard2 WidthPopup' onchange='ListPrestClie3(this.value)'>".ClieSelect($Dossier,$ConnexionBdd,null,null,$factnum,null)."</select><div id='FactDupliquerAffiche3'></div></td></tr>";

		$Lecture.="<tr style='height:30px;'></tr>";
		$Lecture.="<tr><td><select name='Selectclienum[]' class='champ_barre SelectFormInfoStandard2 WidthPopup' onchange='ListPrestClie4(this.value)'>".ClieSelect($Dossier,$ConnexionBdd,null,null,$factnum,null)."</select><div id='FactDupliquerAffiche4'></div></td></tr>";

		$Lecture.="<tr style='height:30px;'></tr>";
		$Lecture.="<tr><td><select name='Selectclienum[]' class='champ_barre SelectFormInfoStandard2 WidthPopup' onchange='ListPrestClie5(this.value)'>".ClieSelect($Dossier,$ConnexionBdd,null,null,$factnum,null)."</select><div id='FactDupliquerAffiche5'></div></td></tr>";

		$Lecture.="<tr style='height:30px;'></tr>";
		$Lecture.="<tr><td><select name='Selectclienum[]' class='champ_barre SelectFormInfoStandard2 WidthPopup' onchange='ListPrestClie6(this.value)'>".ClieSelect($Dossier,$ConnexionBdd,null,null,$factnum,null)."</select><div id='FactDupliquerAffiche6'></div></td></tr>";

		$Lecture.="<tr style='height:30px;'></tr>";
		$Lecture.="<tr><td><select name='Selectclienum[]' class='champ_barre SelectFormInfoStandard2 WidthPopup' onchange='ListPrestClie7(this.value)'>".ClieSelect($Dossier,$ConnexionBdd,null,null,$factnum,null)."</select><div id='FactDupliquerAffiche7'></div></td></tr>";

		$Lecture.="<tr style='height:30px;'></tr>";
		$Lecture.="<tr><td><select name='Selectclienum[]' class='champ_barre SelectFormInfoStandard2 WidthPopup' onchange='ListPrestClie8(this.value)'>".ClieSelect($Dossier,$ConnexionBdd,null,null,$factnum,null)."</select><div id='FactDupliquerAffiche8'></div></td></tr>";

		$Lecture.="<tr style='height:30px;'></tr>";
		$Lecture.="<tr><td><select name='Selectclienum[]' class='champ_barre SelectFormInfoStandard2 WidthPopup' onchange='ListPrestClie9(this.value)'>".ClieSelect($Dossier,$ConnexionBdd,null,null,$factnum,null)."</select><div id='FactDupliquerAffiche9'></div></td></tr>";

		$Lecture.="<tr style='height:30px;'></tr>";
		$Lecture.="<tr><td><select name='Selectclienum[]' class='champ_barre SelectFormInfoStandard2 WidthPopup' onchange='ListPrestClie10(this.value)'>".ClieSelect($Dossier,$ConnexionBdd,null,null,$factnum,null)."</select><div id='FactDupliquerAffiche10'></div></td></tr>";

		$Lecture.="<tr style='height:20px;'></tr>";
		$Lecture.="<tr><td><textarea name='factcom' class='champ_barre WidthPopup' placeholder='".$_SESSION['STrad86']."'></textarea></td></tr>";
		$Lecture.="<tr><td><button class='button WidthPopup'><img src='".$Dossier."images/copier.png'  class='ImgSousMenu2'>".$_SESSION['STrad103']."</button></td></tr>";
		$Lecture.="</table>";
		$Lecture.="</form>";

		if($_SESSION['ResolutionConnexion1'] < 800) {$Lecture.="<a href='#FenAfficheFicheFacture1' class='ButtonBasAll supp1300px supp1024px'><img src='".$Dossier."images/closeBlanc.png' class='ImgSousMenu2'></a>";}
		$Lecture.=$_SESSION['MiseEnFormeDivers'];
		return $Lecture;
	}
//**************************************************************************************************

//************************************ CALCUL DERNIER NUMï¿½RO DE FACTURE *****************************
function CalcDernNumFact($factind,$ConnexionBdd)
	{
		if($factind == 5) {$factind = 4;}
		$CalcNumDern = 'SELECT factconflibenum FROM factures_configuration WHERE factconftype="'.$factind.'" AND AA_equimondo_hebeappnum = "'.$_SESSION['hebeappnum'].'"';
		$CalcNumDernResult = $ConnexionBdd ->query($CalcNumDern) or die ('Erreur SQL !'.$CalcNumDern.'<br />'.mysqli_error());
		$CalcNumDernAffich = $CalcNumDernResult->fetch();
		$FactNumDern= $CalcNumDernAffich[0]+1;
		if($factind == 6) {$FactNumDern=substr('00000000000000'.$FactNumDern,-10);}
		else if($_SESSION['hebeappnum'] == 573 OR $_SESSION['hebeappnum'] == 287) {$FactNumDern=substr('00000'.$FactNumDern,-5);}
		else {$FactNumDern=substr('00000'.$FactNumDern,-4);}

		// ENREGISTRE LE DERNIER NUMï¿½RO UTILISï¿½
		$req = 'UPDATE factures_configuration SET factconflibenum = "'.$FactNumDern.'" WHERE factconftype="'.$factind.'" AND AA_equimondo_hebeappnum = "'.$_SESSION['hebeappnum'].'"';
		$reqResult = $ConnexionBdd ->query($req) or die ('Erreur SQL !'.$req.'<br />'.mysqli_error());
		return $FactNumDern;
	}
//****************************************************************************************************

//**************************** GENERER UN LIEN POUR FACTURE **************************************
function GenererLien($ConnexionBdd)
	{
		$Lien = Genere_Password(20);
		$Lien = SHA1($Lien);

		$LienOK = 1;
		$i = 0;

		while($LienOK != 2)
			{
				$req1 = 'SELECT count(factlien) FROM factures WHERE factlien = "'.$Lien.'"';
				$req1Result = $ConnexionBdd ->query($req1) or die ('Erreur SQL !'.$req1.'<br />'.mysqli_error());
				$req1Affich = $req1Result->fetch();
				if($req1Affich[0] == 0)
					{
						$LienOK = 2;
						$LienCorrect = $Lien;
					}
				else
					{
						$i = $i + 1;
						$Lien = Genere_Password(20).$i;
						$Lien = SHA1($Lien);
					}
			}

		return $LienCorrect;
	}
//*******************************************************************************************

//************************** INFORMATION D'UNE PRESTATION ***********************************
function FactPrestInfos($Dossier,$ConnexionBdd,$factprestnum,$facttype,$clienum)
	{
		$req1 = 'SELECT * FROM factprestation,factures WHERE factures_factnum = factnum AND factprestnum = "'.$factprestnum.'"';
		$req1Result = $ConnexionBdd ->query($req1) or die ('Erreur SQL !'.$req1.'<br />'.mysqli_error());
		$req1Affich = $req1Result->fetch();

		$Lecture.="<input type='hidden' name='typeprestnum[]' value='".$req1Affich['typeprestation_typeprestnum']."'>";
		if(!empty($factprestnum))
			{
				$Lecture.="<input type='hidden' name='factprestnum[]' value='".$factprestnum."|".$clienum."'>";
				$Lecture.="<input type='hidden' name='factprestlibe[]' value='".$req1Affich['factprestlibe']."'>";
				$Lecture.="<input type='hidden' name='factprestqte[]' value='".$req1Affich['factprestqte']."'>";
				$Lecture.="<input type='hidden' name='factremise[]' value='".$req1Affich['factprestremmontant']."'>";
				$Lecture.="<input type='hidden' name='factremiseind[]' value='e'>";

				$Lecture.="<b>".$req1Affich['factprestlibe']."</b> :<br>";
				$Lecture.="<select name='factclienum[]' class='champ_barre ChampBarre50' required>".ClieSelect($Dossier,$ConnexionBdd,$clienum,$reqClieAffich[0],null,2)."</select>";
				$Lecture.="<select class='champ_barre ChampBarre50' name='factchevnum[]'>".ChevSelect($Dossier,$ConnexionBdd,null,$clienum,2)."</select>";
				$Lecture.="<br>";

				if($req1Affich['facttype'] == 4)
					{
						$req2 = 'SELECT * FROM clientssoldeforfentree WHERE factprestation_factprestnum = "'.$factprestnum.'"';
						$req2Result = $ConnexionBdd ->query($req2) or die ('Erreur SQL !'.$req2.'<br />'.mysqli_error());
						$req2Affich = $req2Result->fetch();
						$factprestnbheure = $req2Affich['cliesoldforfentrnbheure'];
						$factprestperiode1 = $req2Affich['cliesoldforfentrdate1'];
						$factprestperiode2 = $req2Affich['cliesoldforfentrdate2'];
					}
				else
					{
						$req2 = 'SELECT * FROM factprestation_association WHERE factprestation_factprestnum = "'.$factprestnum.'"';
						$req2Result = $ConnexionBdd ->query($req2) or die ('Erreur SQL !'.$req2.'<br />'.mysqli_error());
						$req2Affich = $req2Result->fetch();
						$factprestnbheure = $req2Affich['factprestassonbheure'];
						$factprestperiode1 = $req2Affich['factprestassodate1'];
						$factprestperiode2 = $req2Affich['factprestassodate2'];
					}

				$Lecture.="<input type='hidden' name='factprestnbheure[]' value='".$factprestnbheure."'>";
				$Lecture.="<input type='hidden' name='factprestdate1[]' value='".$factprestperiode1."'>";
				$Lecture.="<input type='hidden' name='factprestdate2[]' value='".$factprestperiode2."'>";

				// INFO PRIX
				if($_SESSION['infologlang2'] != "ca")
					{
						$reqPrix = 'SELECT sum(factprestprixstatprixttc) FROM factprestation_prix WHERE factprestation_factprestnum = "'.$factprestnum.'"';
					}
				else
					{
						$reqPrix = 'SELECT sum(factprestprixstatprixht) FROM factprestation_prix WHERE factprestation_factprestnum = "'.$factprestnum.'"';
					}

				$reqPrixResult = $ConnexionBdd ->query($reqPrix) or die ('Erreur SQL !'.$reqPrix.'<br />'.mysqli_error());
				$reqPrixAffich = $reqPrixResult->fetch();
				if(empty($reqPrixAffich[0])) {$reqPrixAffich[0] = "0.00";}
				$reqPrixAffich[0] = $reqPrixAffich[0] + $req1Affich['factprestremmontant'];
				$Lecture.="<input type='hidden' name='prixttc[]' value='".$reqPrixAffich[0]."'>";
			}

		return $Lecture;
	}
//*******************************************************************************************

//***************************** CALCUL POURCENTAGE  FACTURATION PRESTATION *************************
function CalcPourcPrestFact($factprestprixnum,$ConnexionBdd)
	{
		$req1 = 'SELECT factprestation_factprestnum,factprestprixstatprixttc FROM factprestation_prix WHERE factprestprixnum = "'.$factprestprixnum.'"';
		$req1Result = $ConnexionBdd ->query($req1) or die ('Erreur SQL !'.$req1.'<br />'.mysql_error());
		$req1Affich = $req1Result->fetch();

		$req2 = 'SELECT sum(factprestprixstatprixttc),count(factprestprixnum) FROM factprestation_prix WHERE factprestation_factprestnum = "'.$req1Affich[0].'"';
		$req2Result = $ConnexionBdd ->query($req2) or die ('Erreur SQL !'.$req2.'<br />'.mysql_error());
		$req2Affich = $req2Result->fetch();

		if($req2Affich[1] == 0)
			{
				$CalcPourc = 0;
			}
		else if($req2Affich[1] == 1)
			{
				$CalcPourc = 1;
			}
		else
			{
				$CalcPourc = $req1Affich[1] * 100 / $req2Affich[0];
				$CalcPourc = $CalcPourc / 100;
				//$CalcPourc = round($CalcPourc,"2");
			}

		return $CalcPourc;
	}
//****************************************************************************************************

//****************************** CALCUL POURCENTAGE PRESTATION *************************************
function CalcPourcPrest($typeprestprixnum,$ConnexionBdd)
	{
		$req1 = 'SELECT typeprestation_typeprestnum,typeprestprixprix FROM typeprestation_prix WHERE typeprestprixnum = "'.$typeprestprixnum.'"';
		$req1Result = $ConnexionBdd ->query($req1) or die ('Erreur SQL !'.$req1.'<br />'.mysql_error());
		$req1Affich = $req1Result->fetch();

		$req2 = 'SELECT sum(typeprestprixprix),count(typeprestprixnum) FROM typeprestation_prix WHERE typeprestation_typeprestnum = "'.$req1Affich[0].'" AND typeprestprixsupp = "1"';
		$req2Result = $ConnexionBdd ->query($req2) or die ('Erreur SQL !'.$req2.'<br />'.mysql_error());
		$req2Affich = $req2Result->fetch();

		if($req2Affich[1] == 0)
			{
				$CalcPourc = 0;
			}
		else if($req2Affich[1] == 1)
			{
				$CalcPourc = 1;
			}
		else
			{
				$CalcPourc = $req1Affich[1] * 100 / $req2Affich[0];
				$CalcPourc = $CalcPourc / 100;
				//$CalcPourc = round($CalcPourc,"2");
			}

		return $CalcPourc;
	}
//****************************************************************************************************

//******************** VERIF SI TOUS LES ENCAISSEMENTS SONT BIENS SOLDï¿½S SUR UNE FACTURE **********************
function EncaissementSolder($factencnum,$ConnexionBdd)
	{
		$req1 = 'SELECT factencnum,factencmontantverser FROM factencaisser WHERE factencnum = "'.$factencnum.'"';
		$req1Result = $ConnexionBdd ->query($req1) or die ('Erreur SQL !'.$req1.'<br />'.mysql_error());
		$req1Affich = $req1Result->fetch();

		$reqCountEnc = 'SELECT SUM(factencassostatmontant) FROM factures_factencaisser,factures_factencaisser_stat WHERE factures_factencaisser_factencassonum = factencassonum AND factencaisser_factencnum = "'.$factencnum.'"';
		$reqCountEncResult = $ConnexionBdd ->query($reqCountEnc) or die ('Erreur SQL !'.$reqCountEnc.'<br />'.mysql_error());
		$reqCountEncAffich = $reqCountEncResult->fetch();

		$RestantDu = $req1Affich[1] - $reqCountEncAffich[0];

		return array($RestantDu);
	}
//*******************************************************************************************************************************

//************************* CALCUL POURCENTAGE PRESTATION_PRIX *********************************
function CalcPourcPrix($factprestprixnum,$ConnexionBdd)
	{
		$req1 = 'SELECT factprestation_factprestnum,factprestprixstatprixttc FROM factprestation_prix WHERE factprestprixnum = "'.$factprestprixnum.'"';
		$req1Result = $ConnexionBdd ->query($req1) or die ('Erreur SQL !'.$req1.'<br />'.mysql_error());
		$req1Affich = $req1Result->fetch();

		$req2 = 'SELECT sum(factprestprixstatprixttc),count(factprestprixnum) FROM factprestation,factprestation_prix WHERE factprestation_factprestnum = factprestnum AND factprestnum = "'.$req1Affich[0].'"';
		$req2Result = $ConnexionBdd ->query($req2) or die ('Erreur SQL !'.$req2.'<br />'.mysql_error());
		$req2Affich = $req2Result->fetch();

		if($req2Affich[1] == 0)
			{
				$CalcPourc = 0;
			}
		else if($req2Affich[1] == 1)
			{
				$CalcPourc = 1;
			}
		else
			{
				$CalcPourc = $req1Affich[1] * 100 / $req2Affich[0];
				$CalcPourc = $CalcPourc / 100;
				//$CalcPourc = round($CalcPourc,"2");
			}

		return $CalcPourc;
	}
//****************************************************************************************************

//************* FORMULAIRE AJOU ENCAISSEMENT ***********************************
function EncAjouter($Dossier,$ConnexionBdd,$factnum,$factencnum,$facttype)
	{
		$TestAjouEnc = VerifCloture($Dossier,$ConnexionBdd,$factnum);

		if($facttype == 5) {$TestAjouEnc[0] = 2;}

		if($TestAjouEnc[0] == 2)
			{
				$Lecture.=EncAjouter1($Dossier,$ConnexionBdd,null);
			}
		else if($TestAjouEnc[0] == 1)
			{
				$Lecture.="<div class='rub_error'>".$TestAjouEnc[1]."</div>";
			}

		return $Lecture;
	}
//******************************************************************************

//***********************************************************************
function EncAjouter1($Dossier,$ConnexionBdd,$Required)
	{
		$Lecture.="<table>";
		$Lecture.="<tr><td><input type='date' name='factencdate' class='champ_barre ChampBarre50' placeholder='".$_SESSION['STrad88']."' value='".date('Y-m-d')."'";if($Required == 2){$Lecture.=" required";} $Lecture.="></td><td><input type='tel' name='factencmontantverser' class='champ_barre ChampBarre50' placeholder='".$_SESSION['STrad90']."' ";if($Required == 2){$Lecture.=" required";}$Lecture.="></td></tr>";
		$Lecture.="<tr><td><select name='modepaienum' class='champ_barre ChampBarre50'";if($Required == 2){$Lecture.=" required";}$Lecture.=">".ModePaieSelect(null,$ConnexionBdd)."</select></td><td><input type='text' name='factencreference' class='champ_barre ChampBarre50' placeholder='".$_SESSION['STrad147']."'></td></tr>";
		$Lecture.="<tr><td><input type='text' name='factencnombanque' class='champ_barre ChampBarre50' placeholder='".$_SESSION['STrad95']."'></td><td><input type='text' name='factencnomemetteur' class='champ_barre ChampBarre50' placeholder='".$_SESSION['STrad148']."'></td></tr>";
		$Lecture.="<tr><td colspan='2'><textarea name='factenccommentaire' class='champ_barre' placeholder='".$_SESSION['STrad86']."'></textarea></td></tr>";
		$Lecture.="</table>";

		return $Lecture;
	}
//***********************************************************************

//*********************** SELECTIONNE LE TROP PERCU *************************
function TropPercuSelect($faminum,$ConnexionBdd,$Dossier)
	{
		$NbEnc = 0;
		$Lecture = "<option value=''>-- ".$_SESSION['STrad146']." --</option>";

		$req1 = 'SELECT * FROM factencaisser,factures_factencaisser,factprestation,factures,clients WHERE factprestation.factures_factnum = factnum AND factures.clients_clienum = clienum AND factprestation_factprestnum = factprestnum AND factencaisser_factencnum = factencnum AND familleclients_famiclienum = "'.$faminum.'" GROUP BY factencnum ORDER BY factdate DESC';
		$req1Result = $ConnexionBdd ->query($req1) or die ('Erreur SQL !'.$req1.'<br />'.mysqli_error());
		while($req1Affich = $req1Result->fetch())
			{
				// VERIF SI C EST UN ENCAISSEMENT ANNULE
				$reqVerif = 'SELECT count(factencassonum) FROM factencaisser_association WHERE factencaisser_factencnumorigine = "'.$req1Affich[0].'" OR factencaisser_factencnumancien = "'.$req1Affich[0].'"';
				$reqVerifResult = $ConnexionBdd ->query($reqVerif) or die ('Erreur SQL !'.$reqVerif.'<br />'.mysqli_error());
				$reqVerifAffich = $reqVerifResult->fetch();

				if($reqVerifAffich[0] == 0 AND $req1Affich['factencmontantverser'] > 0)
					{
						$req2 = 'SELECT sum(factencassostatmontant) FROM factures_factencaisser,factures_factencaisser_stat WHERE factures_factencaisser_factencassonum = factencassonum AND factencaisser_factencnum = "'.$req1Affich['factencnum'].'"';
						$req2Result = $ConnexionBdd ->query($req2) or die ('Erreur SQL !'.$req2.'<br />'.mysqli_error());
						$req2Affich = $req2Result->fetch();
						$MontantAsso = $req2Affich[0];

						$req2 = 'SELECT sum(factencdiffmontant) FROM factencaisser_difference WHERE factencaisser_factencnum = "'.$req1Affich['factencnum'].'"';
						$req2Result = $ConnexionBdd ->query($req2) or die ('Erreur SQL !'.$req2.'<br />'.mysqli_error());
						$req2Affich = $req2Result->fetch();
						$MontantDiff = $req2Affich[0];

						$MontantNegatif = $MontantAsso+$MontantDiff;

						$Montant = $req1Affich['factencmontantverser']-$MontantNegatif;
						$Montant = round($Montant,"2");

						if($Montant != 0 AND $req1Affich['factencmontantverser'] > 0) {$NbEnc = $NbEnc + 1;$Lecture.="<option value='".$req1Affich['factencnum']."'>".$Montant." ".$_SESSION['STrad27']." ".$req1Affich['clienom']." ".$req1Affich['clieprenom']." (".formatdatemysql($req1Affich['factencdate']).")</option>";}
					}
			}
		$Lecture.= "<option value='ajou'>-- ".$_SESSION['STrad150']." --</option>";

		return array($Lecture,$NbEnc);
	}
//**************************************************************************

//********************* VERIF SI LA CLOTURE A ETE FAIT ***********************
function VerifCloture($Dossier,$ConnexionBdd,$factnum)
	{
		$Auto = 2;

		// AFFICHE LA DERNIERE DATE D ENCAISSEMENT ENREGISTRE
		$reqVerif1 = 'SELECT factencdateenr FROM factencaisser WHERE AA_equimondo_hebeappnum = "'.$_SESSION['hebeappnum'].'" ORDER BY factencdateenr DESC LIMIT 0,1';
		$reqVerif1Result = $ConnexionBdd ->query($reqVerif1) or die ('Erreur SQL !'.$reqVerif1.'<br />'.mysqli_error());
		$reqVerif1Affich = $reqVerif1Result->fetch();

		$CalcDernDateEncEnr = formatheure1($reqVerif1Affich[0]);
		$DernDateEncEnr = $CalcDernDateEncEnr[3]."-".$CalcDernDateEncEnr[4]."-".$CalcDernDateEncEnr[5];
		$DernDateEncEnrModif = $CalcDernDateEncEnr[3].$CalcDernDateEncEnr[4].$CalcDernDateEncEnr[5];

		// VERIF SI LA CLOTURE DU DERNIER ENCAISSEMENT A ETE FAITE
		$reqVerif2 = 'SELECT count(factencclotnum) FROM factencaisser_cloture WHERE factencclotindice = "1" AND AA_equimondo_hebeappnum = "'.$_SESSION['hebeappnum'].'" AND factencclotdate1 = "'.$DernDateEncEnr.'"';
		$reqVerif2Result = $ConnexionBdd ->query($reqVerif2) or die ('Erreur SQL !'.$reqVerif2.'<br />'.mysqli_error());
		$reqVerif2Affich = $reqVerif2Result->fetch();

		// SI LA CLOTURE DU DERNIER ENCAISSEMENT N A PAS ETE FAITE
		if($reqVerif2Affich[0] == 0 AND $DernDateEncEnrModif != date('Ymd'))
			{
				$Auto = 1;
				$Raison.= $_SESSION['STrad139']." ".formatdatemysql($DernDateEncEnr)." ".$_SESSION['STrad140'].". <a href='".$Dossier."modules/facturation/modenclist.php?indice=1&factencdateenr1=".$DernDateEncEnr."&factnum=".$factnum."#EncClotureEdit'>".$_SESSION['STrad141']." ".formatdatemysql($DernDateEncEnr)."</a> ".$_SESSION['STrad142'].". ";
			}

		// VERIF SI LA CLOTURE DU DERNIER ENCAISSEMENT A ETE FAITE
		$reqVerif2 = 'SELECT count(factencclotnum) FROM factencaisser_cloture WHERE factencclotindice = "1" AND AA_equimondo_hebeappnum = "'.$_SESSION['hebeappnum'].'" AND factencclotdate1 = "'.date('Y-m-d').'"';
		$reqVerif2Result = $ConnexionBdd ->query($reqVerif2) or die ('Erreur SQL !'.$reqVerif2.'<br />'.mysqli_error());
		$reqVerif2Affich = $reqVerif2Result->fetch();

		// SI UNE CLOTURE DE LA DATE DU JOUR N A PAS ETE FAITE
		if($reqVerif2Affich[0] == 1)
			{
				$Auto = 1;
				$Raison.= $_SESSION['STrad143']." ";
			}

		// VERIF SI LA CLOTURE DU DERNIER ENCAISSEMENT A ETE FAITE
		$Date1MoisDernEnc = date("Y-m-d 00:00:00",mktime(0,0,0,date('m') - 1,date('d')  ,date('Y')));
		$CalcDate1MoisDernEnc = formatheure1($Date1MoisDernEnc);
		$Date2MoisDernEnc = date("01",mktime(0,0,0,date('m') + 1,date('d')  ,date('Y')));

		//$Date2MoisDernEnc = date("t",mktime(0,0,0,$CalcDate1MoisDernEnc[4],$CalcDate1MoisDernEnc[5] + 1,$CalcDate1MoisDernEnc[3]));

		$Date3 = $CalcDate1MoisDernEnc[3]."-".$CalcDate1MoisDernEnc[4]."-".$Date2MoisDernEnc." 23:59:59";
		$reqVerif1 = 'SELECT factencdateenr FROM factencaisser WHERE factencdateenr <= "'.$Date3.'" AND AA_equimondo_hebeappnum = "'.$_SESSION['hebeappnum'].'" ORDER BY factencdateenr DESC';
		$reqVerif1Result = $ConnexionBdd ->query($reqVerif1) or die ('Erreur SQL !'.$reqVerif1.'<br />'.mysqli_error());
		$reqVerif1Affich = $reqVerif1Result->fetch();

		if(!empty($reqVerif1Affich[0]))
			{
				$CalcDate1 = formatheure1($reqVerif1Affich[0]);
				$PremJour = $CalcDate1[3]."-".$CalcDate1[4]."-01";

				$reqVerif2 = 'SELECT count(factencclotnum) FROM factencaisser_cloture WHERE factencclotindice = "2" AND AA_equimondo_hebeappnum = "'.$_SESSION['hebeappnum'].'" AND factencclotdate1 = "'.$PremJour.'"';
				$reqVerif2Result = $ConnexionBdd ->query($reqVerif2) or die ('Erreur SQL !'.$reqVerif2.'<br />'.mysqli_error());
				$reqVerif2Affich = $reqVerif2Result->fetch();
				if($reqVerif2Affich[0] == 0 AND date('m') != $CalcDate1[4])
					{
						$Auto = 1;
						$Raison.= $_SESSION['STrad144']." ".TradMoisNum($CalcDate1[4])." ".$CalcDate1[3]." ".$_SESSION['STrad140'].". <a href='".$Dossier."modules/facturation/modenclist.php?indice=2&mois=".$CalcDate1[4]."&anne=".$CalcDate1[3]."&factnum=".$factnum."#EncClotureEdit'>".$_SESSION['STrad145']." ".TradMoisNum($CalcDate1[4])." ".$CalcDate1[3]."</a> ".$_SESSION['STrad142'].". ";
					}
			}

		// VERIF SI YA DEJA EU DES ENCAISSEMENTS
		$reqVerif1 = 'SELECT count(factencnum) FROM factencaisser WHERE AA_equimondo_hebeappnum = "'.$_SESSION['hebeappnum'].'"';
		$reqVerif1Result = $ConnexionBdd ->query($reqVerif1) or die ('Erreur SQL !'.$reqVerif1.'<br />'.mysqli_error());
		$reqVerif1Affich = $reqVerif1Result->fetch();
		if($reqVerif1Affich[0] == 0) {$Auto = 2;$Raison.= "";}

		return array($Auto,$Raison);
	}
//*****************************************************************************

//********************* LISTE TYPE DE PRESTATION ****************************
function ListeTypePrestation($Dossier,$ConnexionBdd)
	{
		$Lecture.="<a href='modcaisse2.php?typeprestcatnum=' class='CaisseBoutton LoadPage AfficheCaissePrestations'>".$_SESSION['STrad320']."</a>";

		$req1 = 'SELECT * FROM typeprestation_categorie WHERE AA_equimondo_hebeappnum = "'.$_SESSION['hebeappnum'].'" AND typeprestcatsupp = "1" ORDER BY typeprestcatlibe ASC';
		$req1Result = $ConnexionBdd ->query($req1) or die ('Erreur SQL !'.$req1.'<br />'.mysqli_error());
		while($req1Affich = $req1Result->fetch())
			{
				$Lecture.="<a href='modcaisse2.php?typeprestcatnum=".$req1Affich['typeprestcatnum']."' class='CaisseBoutton LoadPage AfficheCaissePrestations'>".$req1Affich['typeprestcatlibe']."</a>";
			}

		return $Lecture;
	}
//********************************************************************

//********************* LISTE TYPE DE PRESTATION ****************************
function ListePrestations($Dossier,$ConnexionBdd,$typeprestcatnum)
	{
		$req1 = 'SELECT typeprestnum,typeprestlibe';
		if($_SESSION['conflogcaisseafficheprestations'] != 5) {$req1.= ',count(factprestnum) AS TOTAL1';} else {$req1.=',typeprestlibe';}
		$req1.= ',sum(typeprestprixprix) AS TOTAL2 FROM typeprestation';

		if($_SESSION['conflogcaisseafficheprestations'] != 5) {$req1.= ' left outer join factprestation on factprestation.typeprestation_typeprestnum = typeprestnum';}
		$req1.= ' left outer join typeprestation_prix on typeprestation_prix.typeprestation_typeprestnum = typeprestnum';
		if(!empty($typeprestcatnum)) {$req1.=' left outer join typeprestation_categorie on typeprestation_categorie_typeprestcatnum = typeprestcatnum';}
		$req1.= ' WHERE typeprestsupp = "1" AND typeprestation.AA_equimondo_hebeappnum = "'.$_SESSION['hebeappnum'].'"';
		if(!empty($typeprestcatnum)) {$req1.=' AND typeprestcatnum = "'.$typeprestcatnum.'"';}
		$req1.= ' GROUP BY typeprestnum';
		if($_SESSION['conflogcaisseafficheprestations'] == 1) {$req1.= ' ORDER BY typeprestlibe DESC';}
		if($_SESSION['conflogcaisseafficheprestations'] == 2) {$req1.= ' ORDER BY typeprestlibe ASC';}
		if($_SESSION['conflogcaisseafficheprestations'] == 3) {$req1.= ' ORDER BY TOTAL1 DESC';}
		if($_SESSION['conflogcaisseafficheprestations'] == 4) {$req1.= ' ORDER BY TOTAL1 ASC';}
		if($_SESSION['conflogcaisseafficheprestations'] == 5) {$req1.= ' ORDER BY TOTAL2 DESC';}
		if($_SESSION['conflogcaisseafficheprestations'] == 6) {$req1.= ' ORDER BY TOTAL2 ASC';}
		$req1Result = $ConnexionBdd ->query($req1) or die ('Erreur SQL !'.$req1.'<br />'.mysqli_error());
		while($req1Affich = $req1Result->fetch())
			{
				$req2 = 'SELECT SUM(typeprestprixprix) FROM typeprestation_prix WHERE typeprestation_typeprestnum = "'.$req1Affich['typeprestnum'].'" AND typeprestprixsupp = "1"';
				$req2Result = $ConnexionBdd ->query($req2) or die ('Erreur SQL !'.$req2.'<br />'.mysqli_error());
				$req2Affich = $req2Result->fetch();
				$Lecture.="<a href='modcaisse3.php?typeprestnum=".$req1Affich['typeprestnum']."' class='CaisseBoutton1 LoadPage AfficheCaisseAjouPrestations'>".$req1Affich['typeprestlibe']." <i>(".$req2Affich[0]." ".$_SESSION['STrad27'].")</i></a>";
			}

		return $Lecture;
	}
//********************************************************************

//********************* AFFICHE TOUTES PRESTATIONS CAISSE ****************************
function ListeCaisseTotal($Dossier,$ConnexionBdd)
	{
		$req2= 'SELECT * FROM caissesysteme1 WHERE utilisateurs_utilnum = "'.$_SESSION['connauthnum'].'"';
		$req2Result = $ConnexionBdd ->query($req2) or die ('Erreur SQL !'.$req2.'<br />'.mysqli_error());
		$req2Affich = $req2Result->fetch();

		$reqFami= 'SELECT familleclients_famiclienum FROM clients WHERE clienum = "'.$req2Affich['clients_clienum'].'"';
		$reqFamiResult = $ConnexionBdd ->query($reqFami) or die ('Erreur SQL !'.$reqFami.'<br />'.mysqli_error());
		$reqFamiAffich = $reqFamiResult->fetch();

		$Lecture.="<div class='supp400px supp800px'>";
		$Lecture.="<table style='width:100%;font-family:Chivo;'>";
		$req1= 'SELECT * FROM caissesysteme2 WHERE caissesysteme1_caissyst1num = "'.$req2Affich['caissyst1num'].'"';
		$req1Result = $ConnexionBdd ->query($req1) or die ('Erreur SQL !'.$req1.'<br />'.mysqli_error());
		while($req1Affich = $req1Result->fetch())
			{
				$Lecture.="<tr>";
					$Lecture.="<td><a href='modcaisse5.php?caissyst2num=".$req1Affich['caissyst2num']."' class='LoadPage1 AffichePrestModif'>".nl2br($req1Affich['caissyst2libe'])."</a></td>";
					$Lecture.="<td><a href='modcaisse5.php?caissyst2num=".$req1Affich['caissyst2num']."' class='LoadPage1 AffichePrestModif'>".$req1Affich['caissyst2prix']." ".$_SESSION['STrad27']."</a></td>";
					$Lecture.="<td><a href='modcaisse4.php?caissyst2num=".$req1Affich['caissyst2num']."' class='LoadPage1 CaissePrestationSupp'><img src='".$Dossier."images/supprimer.png' class='ImgSousMenu2'></a></td>";
				$Lecture.="</tr>";
			}
		$Lecture.="<tr style='height:30px;'></tr>";
		$Lecture.="</table>";

		$Lecture.="<section style='height:1px;width:100%;background-color:#039BE5;margin:0;padding:0;'></section>";
		$Lecture.="<section style='height:20px;clear:both;display:block;width:100%;'><section>";
		$Lecture.="</div>";

		$Lecture.="<section style='width:100%;clear:both;display:block;' class='CaisseAfficheClieMail'>";

		// SELECTIONNER UN CLIENT
		$Lecture.="<section class='CaisseAfficheGaucheSPart1'>";
		$Lecture.="<select name='clienum' class='champ_barre' id='select4' onchange='CaisseModifClient(this.value)'>".ClieSelect($Dossier,$ConnexionBdd,$req2Affich['clients_clienum'],$reqFamiAffich[0],null,null)."</select>";
		$Lecture.="<div style='height:10px'></div>";
		$Lecture.="</section>";

		// ENVOI PAR MAIL
		$Lecture.="<section class='CaisseAfficheDroiteSPart1'>";
		$Lecture.="<input type='checkbox'  value='2' onchange='AfficherClieAdresMail(this.value)' style='vertical-align:middle;'>".$_SESSION['STrad102']."<br>";
		$Lecture.="<div id='noteAfficherClieAdresMail'></div>";
		$Lecture.="</section>";

		$Lecture.="</section>";

		// AFFICHE PRIX TOTAL
		$req1= 'SELECT SUM(caissyst2prix),count(caissyst2num) FROM caissesysteme2 WHERE caissesysteme1_caissyst1num = "'.$req2Affich['caissyst1num'].'"';
		$req1Result = $ConnexionBdd ->query($req1) or die ('Erreur SQL !'.$req1.'<br />'.mysqli_error());
		$req1Affich = $req1Result->fetch();
		if($req1Affich[1] >= 1)
			{
				$Lecture.="<table style='width:100%;' class='supp400px supp800px'>";
					$Lecture.="<tr style='height:15px;'></tr>";
					$Lecture.="<tr>";
					$Lecture.="<td style='wdth:100%;'><div style='padding:10px;width:96%;font-size:30px;font-family:Chivo;border-style:solid;border-width: 1px ;border-color:#039BE5;background-color:#039BE5;color:white;text-align:center;'>".$req1Affich[0]." ".$_SESSION['STrad27']."</div></td>";
					$Lecture.="</tr>";
					if($req1Affich[1] >= 1)
						{
							$Lecture.="<tr style='height:15px;'></tr>";
							$Lecture.="<tr><td colspan='2'><a href='#FenCaissePayerTotalQuestion'><div class='button' style='width:94%;height:50px;text-align:center;'><span style='font-size:40px;vertical-align:middle;'><img src='".$Dossier."images/facturationBlanc.png' class='ImgSousMenu1'><span style='margin-left:20px;'></span>".$_SESSION['STrad163']."</span></div></a></td></tr>";
						}
				$Lecture.="</table>";

				$Lecture.="<section class='BlocStandard supp1024px supp1300px CaisseAffichePrix1'>";
					$Lecture.="<span style='float:left;width:40%;font-size:50px;vetical-align:middle;'>".$req1Affich[0]." ".$_SESSION['STrad27']."</span>";
					$Lecture.="<span style='float:left;width:60%;font-size:25px;'>";
						$Lecture.="<div style='height:10px;'></div>";
						$Lecture.="<div class='buttonBasMenuFixedRub' style='width:32%;'><a href='".$Dossier."modules/facturation/modcaisse10.php' class='LoadPage CaisseListePrestations buttonLittle'>PREST</a></div>";
						$Lecture.="<div class='buttonBasMenuFixedRub' style='width:32%;'><a href='#FenCaissePayerTotalQuestion' class='buttonLittle'>PAYER</a></div>";
						$Lecture.="<div class='buttonBasMenuFixedRub' style='width:32%;'><a href='".$Dossier."modules/configuration/conffacturationcaisse.php' class='LoadPage Afficheconfcaisse buttonLittle'>CONF</a></div>";
					$Lecture.="</span>";
				$Lecture.="</section>";
			}

		return $Lecture;
	}
//*********************************************************************

//********************* AFFICHE TOUTES PRESTATIONS CAISSE SMARTPHONE ****************************
function ListeCaisseListeTotal($Dossier,$ConnexionBdd)
	{
		$req2= 'SELECT * FROM caissesysteme1 WHERE utilisateurs_utilnum = "'.$_SESSION['connauthnum'].'"';
		$req2Result = $ConnexionBdd ->query($req2) or die ('Erreur SQL !'.$req2.'<br />'.mysqli_error());
		$req2Affich = $req2Result->fetch();

		$reqFami= 'SELECT familleclients_famiclienum FROM clients WHERE clienum = "'.$req2Affich['clients_clienum'].'"';
		$reqFamiResult = $ConnexionBdd ->query($reqFami) or die ('Erreur SQL !'.$reqFami.'<br />'.mysqli_error());
		$reqFamiAffich = $reqFamiResult->fetch();

		$Lecture.="<table style='width:100%;font-family:Chivo;'>";
		$req1= 'SELECT * FROM caissesysteme2 WHERE caissesysteme1_caissyst1num = "'.$req2Affich['caissyst1num'].'"';
		$req1Result = $ConnexionBdd ->query($req1) or die ('Erreur SQL !'.$req1.'<br />'.mysqli_error());
		while($req1Affich = $req1Result->fetch())
			{
				$Lecture.="<tr>";
					$Lecture.="<td><a href='modcaisse5.php?caissyst2num=".$req1Affich['caissyst2num']."' class='LoadPage1 AffichePrestModif'>".nl2br($req1Affich['caissyst2libe'])."</a></td>";
					$Lecture.="<td><a href='modcaisse5.php?caissyst2num=".$req1Affich['caissyst2num']."' class='LoadPage1 AffichePrestModif'>".$req1Affich['caissyst2prix']." ".$_SESSION['STrad27']."</a></td>";
					$Lecture.="<td><a href='modcaisse11.php?caissyst2num=".$req1Affich['caissyst2num']."' class='LoadPage1 CaissePrestationSupp'><img src='".$Dossier."images/supprimer.png' class='ImgSousMenu2'></a></td>";
				$Lecture.="</tr>";
			}
		$Lecture.="<tr style='height:30px;'></tr>";
		$Lecture.="</table>";

		// AFFICHE PRIX TOTAL
		$req1= 'SELECT SUM(caissyst2prix),count(caissyst2num) FROM caissesysteme2 WHERE caissesysteme1_caissyst1num = "'.$req2Affich['caissyst1num'].'"';
		$req1Result = $ConnexionBdd ->query($req1) or die ('Erreur SQL !'.$req1.'<br />'.mysqli_error());
		$req1Affich = $req1Result->fetch();
		if($req1Affich[1] >= 1)
			{
				$Lecture.="<section class='BlocStandard supp1024px supp1300px button' style='margin-top:10px;width:90%;text-align:center;font-size:40px;'>";
					$Lecture.=$req1Affich[0]." ".$_SESSION['STrad27'];
				$Lecture.="</section>";
			}

		return $Lecture;
	}
//*********************************************************************

//***************************** DEPENSES LISTER ***************************************
function DepensesList($Dossier,$ConnexionBdd)
	{
		$Lecture.="<table>";
		$Export.="Date;";
		$Export.="Montant TTC;";
		if(empty($chevnum)) {;$Export.="Cheval;";}
		$Export.="Fournisseur;";
		$Export.="Catï¿½gorie;";
		$Export.="Rï¿½fï¿½rence de paiement;\n\r";
		$req = 'SELECT * FROM depenses,depenses_categorie WHERE depenses_categorie_depecatnum = depecatnum AND';
		if($_SESSION['connind'] == 'util') {$req.=' depenses.AA_equimondo_hebeappnum = "'.$_SESSION['hebeappnum'].'"';}
		if($_SESSION['connind'] == 'clie') {$req.=' depenses.clients_clienum = "'.$_SESSION['connauthnum'].'"';}
		if(!empty($chevnum)) {$req.=' AND chevaux_chevnum = "'.$chevnum.'"';}
		if(!empty($depecat)) {$req.=' AND depecatnum = "'.$depecat.'"';}
		if(!empty($utilnum)) {$req.=' AND utilisateurs_utilnum = "'.$utilnum.'"';}
		if(!empty($date1) AND !empty($date2)) {$req.=' AND depedate BETWEEN  "'.$date1.'" AND "'.$date2.'"';}
		$req.='	ORDER BY depedate DESC';
		$reqResult = $ConnexionBdd ->query($req) or die ('Erreur SQL !'.$req.'<br />'.mysqli_error());
		while($reqAffich = $reqResult->fetch())
			{
				if(!empty($reqAffich['utilisateurs_utilnum']))
					{
						$LibeRep = UtilLect($reqAffich['utilisateurs_utilnum'],$ConnexionBdd);
					}
				else {$LibeRep = "";}
				if(!empty($reqAffich['chevaux_chevnum']))
					{
						$reqRep = 'SELECT chevnom FROM chevaux WHERE chevnum = "'.$reqAffich['chevaux_chevnum'].'"';
						$reqRepResult = $ConnexionBdd ->query($reqRep) or die ('Erreur SQL !'.$reqRep.'<br />'.mysqli_error());
						$reqRepAffich = $reqRepResult->fetch();
						$LibeChev = $reqRepAffich[0];
					}
				else {$LibeChev = "";}

				if($_SESSION['ResolutionConnexion1'] <= 800) {$Lien = "<a href='modDepenseFiche1.php?depenum=".$reqAffich['depenum']."' class='LoadPage AfficheFicheDepense1'>";}
				else {$Lien = "<a href='modDepenseFiche2.php?depenum=".$reqAffich['depenum']."' class='LoadPage AfficheFicheDepense2'>";}

				$Lecture.="<tr><td>";

				$Export.=$LibeRep.";".formatdatemysql($reqAffich['depedate']).";".$reqAffich['depemontantttc']."\n\r";
				$Lecture.="<tr class='".$AlerteEnc."'>";
				$Lecture.="<td>".$Lien;
					$Lecture.="<section style='width:69%;float:left;'>";
						$Lecture.="<span class='Liste1Titre'>".$LibeRep."</span><br>";
						$Lecture.="<span class='Liste1SousTitre1'>".formatdatemysql($reqAffich['depedate'])."</span><br>";
						$Lecture.="<span class='Liste1SousTitre1'>".$reqAffich['depecatlibe']."</span><br>";
					$Lecture.="</section>";
					$Lecture.="<section style='width:29%;float:left;'>";
						$Lecture.="<div class='Liste1Titre'>".$reqAffich['depemontantttc']." ".$_SESSION['STrad27']."</div>";
					$Lecture.="</section>";
				$Lecture.="</a></td>";
				$Lecture.="</tr>";
				$Lecture.="<tr><td><hr class='HrListe1' style='clear:both;display:block;'></td></tr>";
			}
		$Lecture.="</table>";

		return array($Lecture,$Export);
	}
//***************************************************************************************************

//***************************** DEPENSES FICHE COMPLET *************************************
function DepeFichComplet($depenum,$ConnexionBdd,$Dossier)
	{
		$req = 'SELECT * FROM depenses WHERE depenum = "'.$depenum.'"';
		$reqResult = $ConnexionBdd ->query($req) or die ('Erreur SQL !'.$req.'<br />'.mysqli_error());
		$reqAffich = $reqResult->fetch();

		$Lecture.="<table class='table_champ_barre'>";
		$Lecture.="<tr><td class='supp400px'>Date :</td><td>".formatdatemysql($reqAffich['depedate'])."</td></tr>";
		if(!empty($reqAffich['chevaux_chevnum'])) {$Lecture.="<tr><td class='supp400px'>Cheval :</td><td>".ChevLect($reqAffich['chevaux_chevnum'],$ConnexionBdd)."</td></tr>";}
		$Lecture.="<tr><td class='supp400px'>Fournisseur :</td><td>".UtilLect($reqAffich['utilisateurs_utilnum'],$ConnexionBdd)."</td></tr>";
		$Lecture.="<tr><td class='supp400px'>Catï¿½gorie :</td><td>".DepensesCatLect($reqAffich['depenses_categorie_depecatnum'],$ConnexionBdd)."</td></tr>";
		$Lecture.="<tr><td class='supp400px'>Montant TTC :</td><td>".$reqAffich['depemontantttc']." ".$_SESSION['STrad27']."</td></tr>";
		if($_SESSION['connind'] == 'util')
			{
				$Lecture.="<tr><td class='supp400px'></td><td><i style='font-size:10px;'>Dont TVA : </i></td></tr>";
				$req1 = 'SELECT * FROM depenses_tva WHERE depenses_depenum = "'.$_GET['depenum'].'"';
				$req1Result = $ConnexionBdd ->query($req1) or die ('Erreur SQL !'.$req1.'<br />'.mysqli_error());
				while($req1Affich = $req1Result->fetch())
					{
						$Taux = $req1Affich['depetvataux'] * 100;
						$Lecture.="<tr><td class='supp400px'></td><td><i style='font-size:10px;'>".$req1Affich['depetvamontant']." ".$_SESSION['STrad27']."  (TVA de ".$Taux." %)</i></td></tr>";
						$TotalHT = $TotalHT + $req1Affich['depetvamontant'];
					}
				$TotalHT = $reqAffich['depemontantttc'] - $TotalHT;
				$Lecture.="<tr><td class='supp400px'>Total HT :</td><td>".$TotalHT." ".$Trad27."</td></tr>";
			}
		$Lecture.="<tr><td class='supp400px'>Mode de paiement :</td><td>".ModePaieLect($reqAffich['mode_paie_modepaienum'],$ConnexionBdd)."</td></tr>";
		if($_SESSION['connind'] == 'util') {$Lecture.="<tr><td class='supp400px'>Rï¿½fï¿½rence de paiement :</td><td>".$reqAffich['deperef']."</td></tr>";}
		$Lecture.="<tr><td class='supp400px'>Commentaire :</td><td>".$reqAffich['depecommentaire']."</td></tr>";
		$Lecture.="</table>";

		echo "<a href='".$Dossier."modules/facturation/moddepenses_script.php?depenum=".$depenum."&depesupp=2'><i class='icofont icofont-ui-delete TitreIcone ButtonSmartphone ButtonSmartphone1'></i></a>";
		echo "<a href='?depenum=".$depenum."#DepeAjou'><i class='icofont icofont-social-livejournal TitreIcone ButtonSmartphone'></i></a>";

		return $Lecture;
	}
//***************************************************************************************************


//********************************* SUPPRIMER UN BROUILLON DE FACTURE *********************************
function BrouillonFactSupp($factnum,$ConnexionBdd,$Dossier)
	{
		$reqPrest = 'SELECT factprestnum FROM factprestation WHERE factures_factnum = "'.$factnum.'"';
		$reqPrestResult = $ConnexionBdd ->query($reqPrest) or die ('Erreur SQL !'.$reqPrest.'<br />'.mysqli_error());
		while($reqPrestAffich = $reqPrestResult->fetch())
			{
				$req = 'DELETE FROM factprestation_association WHERE factprestation_factprestnum = "'.$reqPrestAffich[0].'"';
				$reqResult = $ConnexionBdd ->query($req) or die ('Erreur SQL !'.$req.'<br />'.mysqli_error());
				$req = 'DELETE FROM factprestation_prix WHERE factprestation_factprestnum = "'.$reqPrestAffich[0].'"';
				$reqResult = $ConnexionBdd ->query($req) or die ('Erreur SQL !'.$req.'<br />'.mysqli_error());

				$ok = BrouillonFactPrestSupp($reqPrestAffich[0],$ConnexionBdd,$Dossier);
			}
		$req = 'DELETE FROM factprestation WHERE factures_factnum = "'.$factnum.'"';
		$reqResult = $ConnexionBdd ->query($req) or die ('Erreur SQL !'.$req.'<br />'.mysqli_error());

		$req = 'DELETE FROM livredecompte WHERE factures_factnum = "'.$factnum.'"';
		$reqResult = $ConnexionBdd ->query($req) or die ('Erreur SQL !'.$req.'<br />'.mysqli_error());

		$req = 'DELETE FROM envoi_mail_participants WHERE factures_factnum = "'.$factnum.'"';
		$reqResult = $ConnexionBdd ->query($req) or die ('Erreur SQL !'.$req.'<br />'.mysqli_error());

		$req = 'DELETE FROM commentairesgenerals WHERE factures_factnum = "'.$factnum.'"';
		$reqResult = $ConnexionBdd ->query($req) or die ('Erreur SQL !'.$req.'<br />'.mysqli_error());

		$req = 'DELETE FROM factures WHERE factnum = "'.$factnum.'"';
		$reqResult = $ConnexionBdd ->query($req) or die ('Erreur SQL !'.$req.'<br />'.mysqli_error());
	}
//*******************************************************************************************

//********************************* SUPPRIMER PRESTATION *********************************
function BrouillonFactPrestSupp($factprestnum,$ConnexionBdd,$Dossier)
	{
		$reqPrest = 'SELECT factprestnum FROM factprestation WHERE factprestnum = "'.$factprestnum.'"';
		$reqPrestResult = $ConnexionBdd ->query($reqPrest) or die ('Erreur SQL !'.$reqPrest.'<br />'.mysqli_error());
		while($reqPrestAffich = $reqPrestResult->fetch())
			{
				$req = 'DELETE FROM factprestation_association WHERE factprestation_factprestnum = "'.$reqPrestAffich[0].'"';
				$reqResult = $ConnexionBdd ->query($req) or die ('Erreur SQL !'.$req.'<br />'.mysqli_error());
				$req = 'DELETE FROM factprestation_prix WHERE factprestation_factprestnum = "'.$reqPrestAffich[0].'"';
				$reqResult = $ConnexionBdd ->query($req) or die ('Erreur SQL !'.$req.'<br />'.mysqli_error());

				$reqPrest1 = 'SELECT cliesoldforfentrnum FROM clientssoldeforfentree WHERE factprestation_factprestnum = "'.$factprestnum.'"';
				$reqPrest1Result = $ConnexionBdd ->query($reqPrest1) or die ('Erreur SQL !'.$reqPrest1.'<br />'.mysqli_error());
				while($reqPrest1Affich = $reqPrest1Result->fetch())
					{
						$reqPrest2 = 'DELETE FROM clientssoldeforfentree_clients WHERE clientssoldeforfentree_cliesoldforfentrnum = "'.$reqPrest1Affich['cliesoldforfentrnum'].'"';
						$reqPrest2Result = $ConnexionBdd ->query($reqPrest2) or die ('Erreur SQL !'.$reqPrest2.'<br />'.mysqli_error());
					}
				$reqPrest1 = 'DELETE FROM clientssoldeforfentree WHERE factprestation_factprestnum = "'.$factprestnum.'"';
				$reqPrest1Result = $ConnexionBdd ->query($reqPrest1) or die ('Erreur SQL !'.$reqPrest1.'<br />'.mysqli_error());

			}
		$req = 'DELETE FROM factprestation WHERE factprestnum = "'.$factprestnum.'"';
		$reqResult = $ConnexionBdd ->query($req) or die ('Erreur SQL !'.$req.'<br />'.mysqli_error());
	}
//*******************************************************************************************

//************************ CONFIGURATION NUMEROTATION FACTURATION ***************************
function FactPrefSelect($ind)
	{
		$Lecture.='<option value="">-- Choisissez --</option>';
		$Lecture.='<option value="1"';if($ind == 1) {$Lecture.=' selected';}$Lecture.='>Par l\'annï¿½e en cour ('.date('Y').')</option>';
		$Lecture.='<option value="2"';if($ind == 2) {$Lecture.=' selected';}$Lecture.='>Par l\'annï¿½e + mois de facturation (ex : '.date('Ym').')</option>';

		return $Lecture;
	}
//*************************************************************************

//************************ TICKET ENCAISSEMENT ***************************
function TicketEncaissement($Dossier,$ConnexionBdd,$factnum)
	{
		$req= 'SELECT * FROM factures WHERE factnum = "'.$factnum.'"';
		$reqResult = $ConnexionBdd ->query($req) or die ('Erreur SQL !'.$req.'<br />'.mysqli_error());
		$reqAffich = $reqResult->fetch();

		$FactCalc = FactCalc($factnum,$ConnexionBdd);

		$Lecture.="<section style='width:100%;margin:0 auto;'>";
		$Lecture.="<center style='font-size:20px;'>".$_SESSION['confentrnom']."</center>";
		$Lecture.="<center>".$_SESSION['confentradres']."</center>";
		$Lecture.="<center>".$_SESSION['confentrcp']." ".$_SESSION['confentrville']."</center>";
		$Lecture.="<center>".$_SESSION['STrad193']." ".$_SESSION['confentrsiret']."</center>";
		if(!empty($_SESSION['confentrcodeape'])) {$Lecture.="<center>".$_SESSION['STrad194']." ".$_SESSION['confentrcodeape']."</center>";}
		if(!empty($_SESSION['confentrintratva'])) {$Lecture.="<center>".$_SESSION['STrad196']." ".$_SESSION['confentrintratva']."</center>";}

		$Lecture.="<div style='height:20px;'></div>";
		if(empty($_SESSION['conflogfactprefixe']))
			{
				$reqConfLog='SELECT conflogfactprefixe FROM conflogiciel WHERE AA_equimondo_hebeappnum = "'.$_SESSION['hebeappnum'].'"';
				$reqConfLogResult = $ConnexionBdd ->query($reqConfLog) or die ('Erreur SQL !'.$reqConfLog.'<br />'.mysqli_error());
				$reqConfLogAffich = $reqConfLogResult->fetch();
				$conflogfactprefixe = $reqConfLogAffich['conflogfactprefixe'];
			}
		$Lecture.="<div style='clear:both;disply:block;width:100%;'>";
		$Lecture.="<span style='float:left;'>".$_SESSION['STrad196']." ".FactIndLect($reqAffich['facttype'])." :  ".FactPrefLect($reqAffich['factdate'],$reqAffich['factnumlibe'],null,$conflogfactprefixe)."</span>";
		$Lecture.="<span style='float:right;'>".formatdatemysql($reqAffich['factdate'])."</span>";
		$Lecture.="</div>";
		$Lecture.="<hr style='clear:both;disply:block;width:100%;'>";
		$Lecture.="<div style='height:20px;'></div>";

		// LISTE PRODUITS
		$Lecture.="<table style='width:100%;'>";
		$reqPrest = 'SELECT * FROM factprestation WHERE factures_factnum = "'.$factnum.'"';
		$reqPrestResult = $ConnexionBdd ->query($reqPrest) or die ('Erreur SQL !'.$reqPrest.'<br />'.mysqli_error());
		while($reqPrestAffich = $reqPrestResult->fetch())
			{
				$CalcPrest = CalcPrest($reqPrestAffich['factprestnum'],$ConnexionBdd);
				$CalcPrest[3] = number_format($CalcPrest[3], 2, '.', '');

				$Lecture.="<tr>";
					$Lecture.="<td style='width:70%;'>".$reqPrestAffich['factprestlibe']."</td>";
					$Lecture.="<td style='width:30%;'><div style='float:right;'>".$CalcPrest[3]." ".$_SESSION['STrad27']."</div></td>";
				$Lecture.="</tr>";
			}

		$Lecture.="<tr>";
			$Lecture.="<td colspan='2'><hr></td>";
		$Lecture.="</tr>";

		$Lecture.="<tr>";
			$Lecture.="<td style='width:70%;'><div style='float:right;'>".$_SESSION['STrad197']."</div></td>";
			$Lecture.="<td style='width:30%;'><div style='float:right;'>".$FactCalc[2]." ".$_SESSION['STrad27']."</div></td>";
		$Lecture.="</tr>";
		$Lecture.="</table>";

		$Lecture.="<div style='height:20px;'></div>";

		$Lecture.="<table style='width:100%;'>";
		$Lecture.="<tr>";
			$Lecture.="<td>".$_SESSION['STrad201']."</td>";
			$Lecture.="<td>".$_SESSION['STrad198']."</td>";
			$Lecture.="<td>".$_SESSION['STrad199']."</td>";
			$Lecture.="<td>".$_SESSION['STrad200']."</td>";
		$Lecture.="</tr>";

		$reqPrest = 'SELECT factprestprixtva FROM factprestation,factprestation_prix WHERE factprestation_factprestnum = factprestnum AND factures_factnum = "'.$factnum.'" GROUP BY factprestprixtva ORDER BY factprestprixtva ASC';
		$reqPrestResult = $ConnexionBdd ->query($reqPrest) or die ('Erreur SQL !'.$reqPrest.'<br />'.mysqli_error());
		while($reqPrestAffich = $reqPrestResult->fetch())
			{
				$Taux = $reqPrestAffich[0] * 100;
				$reqPrestTotal = 'SELECT sum(factprestprixstatprixht),sum(factprestprixstatprixtva),sum(factprestprixstatprixttc) FROM factprestation,factprestation_prix WHERE factprestation_factprestnum = factprestnum AND factures_factnum = "'.$factnum.'" AND factprestprixtva LIKE "'.$reqPrestAffich['factprestprixtva'].'"';
				$reqPrestTotalResult = $ConnexionBdd ->query($reqPrestTotal) or die ('Erreur SQL !'.$reqPrestTotal.'<br />'.mysqli_error());
				$reqPrestTotalAffich = $reqPrestTotalResult->fetch();
				$reqPrestTotalAffich[0] = number_format($reqPrestTotalAffich[0], 2, '.', '');
				$reqPrestTotalAffich[1] = number_format($reqPrestTotalAffich[1], 2, '.', '');
				$reqPrestTotalAffich[2] = number_format($reqPrestTotalAffich[2], 2, '.', '');
				$Lecture.="<tr>";
					$Lecture.="<td>".$_SESSION['STrad199']." ".$Taux." %</td>";
					$Lecture.="<td>".$reqPrestTotalAffich[0]."</td>";
					$Lecture.="<td>".$reqPrestTotalAffich[1]."</td>";
					$Lecture.="<td>".$reqPrestTotalAffich[2]."</td>";
				$Lecture.="</tr>";
			}
		$Lecture.="</table>";

		$Lecture.="<div style='height:20px;'></div>";

		$Lecture.="<center>";
			$Lecture.=$_SESSION['STrad202'];
		$Lecture.="</center>";

		$Lecture.="</section>";

		return $Lecture;
	}
//*************************************************************************

//********************* SELECTION STAGE, REPRISE, ETC *******************************
function SelectCalendrier($Dossier,$ConnexionBdd,$typeprestcat,$date,$calenum)
	{
		if($typeprestcat == 1) {$caleindice = 1;}
		else if($typeprestcat == 3) {$caleindice = 2;}

		if(empty($date)) {$date = date('Y-m-d');}

		$Lecture.="<option value=''>- ".$_SESSION['STrad251']." -</option>";

		// AFFICHE MODELE REPRISE
		if($typeprestcat == 1 AND empty($calenum))
			{
				$Lecture.="<option value=''>-- ".$_SESSION['STrad253']." --</option>";
				$req1 = 'SELECT * FROM planning_lecon_modele WHERE AA_equimondo_hebeappnum = "'.$_SESSION['hebeappnum'].'" ORDER BY planlecomodjour ASC';
				$req1Result = $ConnexionBdd ->query($req1) or die ('Erreur SQL !'.$req1.'<br />'.mysqli_error());
				while($req1Affich = $req1Result->fetch())
					{
						$Lecture.="<option value='mod".$req1Affich['planlecomodnum']."'>".AfficheJours($req1Affich['planlecomodjour'])." ".$req1Affich['planlecomodheure']." ".UtilLect($req1Affich['utilisateurs_utilnum'],$ConnexionBdd)."</option>";
					}
			}

			if($typeprestcat != 1 OR !empty($calenum))
				{
					$Lecture.="<option value=''>-- ".CalendrierLect($typeprestcat)." --</option>";
					$req1 = 'SELECT * FROM calendrier WHERE AA_equimondo_hebeappnum = "'.$_SESSION['hebeappnum'].'"';
					if(!empty($caleindice)) {$req1.= ' AND caleindice = "'.$caleindice.'"';}
					if(empty($date)) {$req1.= ' AND caledate1 >= "'.$date.' 00:00:00"';}
					//if(!empty($calenum)) {$req1.=' OR calenum = "'.$calenum.'"';}
					$req1.=' ORDER BY caledate1 ASC';
					$req1Result = $ConnexionBdd ->query($req1) or die ('Erreur SQL !'.$req1.'<br />'.mysqli_error());
					while($req1Affich = $req1Result->fetch())
						{
							if($req1Affich['caleindice'] == 1) {$Libe = CalendrierLect($req1Affich['caleindice']);}

							$Date = FormatDateTimeMySql($req1Affich['caledate1']);

							$Lecture.="<option value='cal".$req1Affich['calenum']."'";if($calenum == $req1Affich['calenum']) {$Lecture.=" selected";} $Lecture.=">".$Libe." ".$_SESSION['STrad18']." ".$Date."</option>";
						}
			}

		return $Lecture;
	}
//*************************************************************************

//************* AFFICHER SOLDE FACTENCAISSER ****************
function FactEncaisserTropPercu($Dossier,$ConnexionBdd,$factencnum)
	{
		$req1 = 'SELECT sum(factencassostatmontant) FROM factures_factencaisser,factures_factencaisser_stat WHERE factures_factencaisser_factencassonum = factencassonum AND factencaisser_factencnum = "'.$factencnum.'"';
		$req1Result = $ConnexionBdd ->query($req1) or die ('Erreur SQL !'.$req1.'<br />'.mysqli_error());
		$req1Affich = $req1Result->fetch();

		$req2 = 'SELECT factencmontantverser FROM factencaisser WHERE factencnum = "'.$factencnum.'"';
		$req2Result = $ConnexionBdd ->query($req2) or die ('Erreur SQL !'.$req2.'<br />'.mysqli_error());
		$req2Affich = $req2Result->fetch();

		$RestantDu = $req2Affich[0] - $req1Affich[0];

		return array ($RestantDu);
	}
//**********************************************************

//****************** LIVRE DE COMPTE ***************************
function LivreDeCompte($Dossier,$ConnexionBdd,$clienum)
  {
    if(empty($_SESSION['livrecomptedate1'])) {$_SESSION['livrecomptedate1'] = date('Y-m-01');}
    if(empty($_SESSION['livrecomptedate2'])) {$_SESSION['livrecomptedate2'] = date('Y-m-31');}

		if($_GET['livrecompteclienum'] == "NULL") {$_GET['livrecompteclienum'] = "";$_SESSION['livrecompteclienum'] = "";}
		if($_GET['livrecomptemodepaienum'] == "NULL") {$_GET['livrecomptemodepaienum'] = "";$_SESSION['livrecomptemodepaienum'] = "";}

    if(isset($_GET['livrecomptedate1'])) {$_SESSION['livrecomptedate1'] = $_GET['livrecomptedate1'];}
    if(isset($_GET['livrecomptedate2'])) {$_SESSION['livrecomptedate2'] = $_GET['livrecomptedate2'];}
		if(isset($_GET['livrecompteclienum'])) {$_SESSION['livrecompteclienum'] = $_GET['livrecompteclienum'];}
		if(isset($_GET['livrecomptemodepaienum'])) {$_SESSION['livrecomptemodepaienum'] = $_GET['livrecomptemodepaienum'];}
		if(isset($_GET['livrecomptetypeprestnum'])) {$_SESSION['livrecomptetypeprestnum'] = $_GET['livrecomptetypeprestnum'];}

    $TotalDebit = 0;
    $TotalCredit = 0;

    $Lecture.="<table class='tab_rubrique' style='width:100%;'>";
      $Lecture.="<thead><tr>";
        $Lecture.="<td>".$_SESSION['STrad88']."</td>";
				$Export.=$_SESSION['STrad88'].";";
        $Lecture.="<td class='supp400px'>".$_SESSION['STrad91']."</td>";
				$Export.=$_SESSION['STrad91'].";";
        $Lecture.="<td class='supp400px'>".$_SESSION['STrad237']."</td>";
				$Export.=$_SESSION['STrad237'].";";
        $Lecture.="<td class='supp400px'>".$_SESSION['STrad308']."</td>";
				$Export.=$_SESSION['STrad308'].";";
        $Lecture.="<td>".$_SESSION['STrad309']."</td>";
				$Export.=$_SESSION['STrad309'].";";
        $Lecture.="<td>".$_SESSION['STrad310']."</td>";
				$Export.=$_SESSION['STrad310'].";\n";
      $Lecture.="</tr></thead>";

    $req1 = 'SELECT * FROM livredecompte';
		$req1.=' WHERE livredecompte.AA_equimondo_hebeappnum = "'.$_SESSION['hebeappnum'].'"';
		if(!empty($_SESSION['livrecompteclienum'])) {$req1.=' AND clients_clienum = "'.$_SESSION['livrecompteclienum'].'"';}
		if(!empty($_GET['clienum'])) {$req1.=' AND clients_clienum = "'.$_GET['clienum'].'"';}
		if(!empty($_SESSION['livrecomptedate1']) AND !empty($_SESSION['livrecomptedate2']) AND empty($_GET['clienum'])) {$req1.=' AND livrdecomptdate BETWEEN "'.$_SESSION['livrecomptedate1'].'" AND "'.$_SESSION['livrecomptedate2'].'"';}
		$req1.=' ORDER BY livrdecomptdate DESC';
		$req1Result = $ConnexionBdd ->query($req1) or die ('Erreur SQL !'.$req1.'<br />'.mysqli_error());
		while($req1Affich = $req1Result->fetch())
      {
        if(!empty($req1Affich['factures_factnum']))
          {
						$Lien = "<a href='".$Dossier."modules/facturation/modfactfichcomplet1.php?factnum=".$req1Affich['factures_factnum']."' class='LoadPage AfficheFicheFacture1'>";
					}
        else if(!empty($req1Affich['factencaisser_factencnum']))
          {
						$Lien = "<span onmouseover='afficher_bulle(\"<em><div class=InfoBulle2>".CaracSpeciaux($_SESSION['STrad101'])."</div></em>\", \"white\", event);' onmouseout=\"masquer_bulle();\" class='InfoBulle1'><a href='".$Dossier."modules/facturation/modEncaissementFiche1.php?factencnum=".$req1Affich['factencaisser_factencnum']."' class='LoadPage AfficheFicheEncaissement1'>";
					}
        // FACTURES, AVOIRS
        if(!empty($req1Affich['factures_factnum']))
          {
                $req2 = 'SELECT * FROM factprestation,factures';
								if(!empty($_SESSION['livrecomptemodepaienum'])) {$req2.=',factures_factencaisser,factencaisser';}
								$req2.=' WHERE factprestation.factures_factnum = factnum AND factprestation.factures_factnum = "'.$req1Affich['factures_factnum'].'"';
								if(!empty($_SESSION['livrecomptetypeprestnum'])) {$req2.= ' AND typeprestation_typeprestnum = "'.$_SESSION['livrecomptetypeprestnum'].'"';}
								if(!empty($_SESSION['livrecomptemodepaienum'])) {$req2.=' AND factures_factencaisser.factprestation_factprestnum = factprestnum AND factures_factencaisser.factencaisser_factencnum = factencnum AND mode_paie_modepaienum = "'.$_SESSION['livrecomptemodepaienum'].'"';}
								$req2Result = $ConnexionBdd ->query($req2) or die ('Erreur SQL !'.$req2.'<br />'.mysqli_error());
								while($req2Affich = $req2Result->fetch())
                  {
                    $Lecture.="<tr>";
										// DATE
										$Lecture.="<td>".$Lien.formatdatemysql($req1Affich['livrdecomptdate'])."</a></td>";
										$Export.=formatdatemysql($req1Affich['livrdecomptdate']).";";
										// CLIENTS
										$Lecture.="<td class='supp400px'>".$Lien.ClieLect($req1Affich['clients_clienum'],$ConnexionBdd)."</a></td>";
										$Export.=ClieLect($req1Affich['clients_clienum'],$ConnexionBdd).";";
                    // LIBELLE
										$req2Affich['factprestlibe'] = str_replace('"',"",$req2Affich['factprestlibe']);
										$req2Affich['factprestlibe'] = str_replace('<br>',"",$req2Affich['factprestlibe']);
										$req2Affich['factprestlibe'] = str_replace('<br />',"",$req2Affich['factprestlibe']);
										$req2Affich['factprestlibe'] = str_replace(';',"",$req2Affich['factprestlibe']);

                    $Lecture.="<td class='supp400px'>".$Lien.nl2br($req2Affich['factprestlibe'])."</a></td>";
										$Export.=nl2br($req2Affich['factprestlibe']).";";
										// NUMERO DE PIECE
                  	$Lecture.="<td class='supp400px'>".$Lien.FactPrefLect($req2Affich['factdate'],$req2Affich['factnumlibe'],null,null)."</a></td>";
										$Export.=FactPrefLect($req2Affich['factdate'],$req2Affich['factnumlibe'],null,null).";";
                    // MONTANT DEBIT
                    $TotalPrest = CalcPrest($req2Affich['factprestnum'],$ConnexionBdd);
                    if($req2Affich['facttype'] == 4) {$TotalDebit = $TotalDebit + $TotalPrest[3];}
                    else if($req2Affich['facttype'] == 5) {$TotalCredit = $TotalCredit - $TotalPrest[3];}
                    $TotalPrest[3] = number_format($TotalPrest[3], 2, '.', '');

                    if($req2Affich['facttype'] == 4)
                      {
												if($_SESSION['ResolutionConnexion1'] <= 800)
													{
                        		$Lecture.="<td rowspan='4'>".$Lien.$TotalPrest[3]." ".$_SESSION['STrad27']."</a></td>";
                        		$Lecture.="<td rowspan='4'></td>";
													}
												else
													{
														$Lecture.="<td style='white-space:nowrap;'>".$Lien.$TotalPrest[3]." ".$_SESSION['STrad27']."</a></td>";
                        		$Lecture.="<td style='white-space:nowrap;'></td>";
													}
												$Export.=$TotalPrest[3]." ".$_SESSION['STrad27'].";;";
                      }
                    else if($req2Affich['facttype'] == 5)
                      {
												if($_SESSION['ResolutionConnexion1'] <= 800)
													{
                        		$Lecture.="<td rowspan='4' style='white-space:nowrap;'></td>";
                        		$Lecture.="<td rowspan='4' style='white-space:nowrap;'>".$Lien.$TotalPrest[3]." ".$_SESSION['STrad27']."</a></td>";
													}
												else
													{
														$Lecture.="<td style='white-space:nowrap;'></td>";
		                        $Lecture.="<td style='white-space:nowrap;'>".$Lien.$TotalPrest[3]." ".$_SESSION['STrad27']."</a></td>";
													}
												$Export.=";".$TotalPrest[3]." ".$_SESSION['STrad27'];
											}
                    else
                      {
												if($_SESSION['ResolutionConnexion1'] <= 800)
													{
                        		$Lecture.="<td rowspan='4'></td>";
                        		$Lecture.="<td rowspan='4'></td>";
													}
												else
													{
														$Lecture.="<td></td>";
		                        $Lecture.="<td></td>";
													}
												$Export.=";;";
                      }
										$req3 = 'SELECT * FROM factprestation,factures,clients WHERE factures.clients_clienum = clienum AND factures_factnum = factnum AND factures_factnum = "'.$req1Affich['factures_factnum'].'" AND typeprestation_typeprestnum = "'.$_GET['livrecomptetypeprestnum'].'"';
		                $req3Result = $ConnexionBdd ->query($req3) or die ('Erreur SQL !'.$req3.'<br />'.mysqli_error());
										$req3Affich = $req3Result->fetch();
										$Export.=$req3Affich['clienumcompte'].";";
                    $Lecture.="</tr>";
										$Export.="\n";

										$Lecture.="<tr class='supp1024px supp1300px'>";
											$Lecture.="<td>".$Lien.ClieLect($req1Affich['clients_clienum'],$ConnexionBdd)."</a></td>";
										$Lecture.="</tr>";
										$Lecture.="<tr class='supp1024px supp1300px'>";
											$Lecture.="<td>".$Lien.nl2br($req2Affich['factprestlibe'])."</a></td>";
										$Lecture.="</tr>";
										$Lecture.="<tr class='supp1024px supp1300px'>";
											$Lecture.="<td>".$Lien."N° ".FactPrefLect($req2Affich['factdate'],$req2Affich['factnumlibe'],null,null)."</a></td>";
										$Lecture.="</tr>";
                  }
          }
        // ENCAISSEMENTS
        else if(!empty($req1Affich['factencaisser_factencnum']))
          {
						$reqEncCount = 'SELECT count(factencnum) FROM factencaisser WHERE factencnum = "'.$req1Affich['factencaisser_factencnum'].'"';
						if(!empty($_SESSION['livrecomptemodepaienum'])) {$reqEncCount.=' AND  mode_paie_modepaienum = "'.$_SESSION['livrecomptemodepaienum'].'"';}
						$reqEncCountResult = $ConnexionBdd ->query($reqEncCount) or die ('Erreur SQL !'.$reqEncCount.'<br />'.mysqli_error());
            $reqEncCountAffich = $reqEncCountResult->fetch();

            $req2 = 'SELECT * FROM factencaisser WHERE factencnum = "'.$req1Affich['factencaisser_factencnum'].'"';
            $req2Result = $ConnexionBdd ->query($req2) or die ('Erreur SQL !'.$req2.'<br />'.mysqli_error());
            $req2Affich = $req2Result->fetch();

            // VERIFIE SI L'ENCAISSEMENT EST ANNULE
            $req3 = 'SELECT count(factencassonum) FROM factencaisser_association WHERE factencaisser_factencnumorigine = "'.$req1Affich['factencaisser_factencnum'].'"';
            $req3Result = $ConnexionBdd ->query($req3) or die ('Erreur SQL !'.$req3.'<br />'.mysqli_error());
            $req3Affich = $req3Result->fetch();
            if($req3Affich[0] == 1) {$Barre = 2;} else {$Barre = 1;}

            // VERIF SI C'EST UNE OPERATION QUI S'ANNULE
            $req4 = 'SELECT count(factencassonum) FROM factencaisser_association WHERE factencaisser_factencnumancien = "'.$req1Affich['factencaisser_factencnum'].'"';
            $req4Result = $ConnexionBdd ->query($req4) or die ('Erreur SQL !'.$req4.'<br />'.mysqli_error());

						if(!empty($_SESSION['livrecomptetypeprestnum']))
							{
								$req5 = 'SELECT count(factencassonum) FROM factures_factencaisser,factprestation,factures WHERE factures_factencaisser.factprestation_factprestnum = factprestation.factprestnum AND factprestation.factures_factnum = factnum AND factprestation.typeprestation_typeprestnum = "'.$_SESSION['livrecomptetypeprestnum'].'" AND factdate BETWEEN "'.$_SESSION['livrecomptedate1'].'" AND "'.$_SESSION['livrecomptedate2'].'" AND factures_factencaisser.factencaisser_factencnum = "'.$req1Affich['factencaisser_factencnum'].'"';
								$req5Result = $ConnexionBdd ->query($req5) or die ('Erreur SQL !'.$req5.'<br />'.mysqli_error());
		            $req5Affich = $req5Result->fetch();
								if($req5Affich[0] >= 1) {$Exec = 2;}
								else {$Exec = 1;}
							}
						else {$Exec = 2;}

            if($req4Affich[0] == 0 AND $reqEncCountAffich[0] >= 1 AND $Exec == 2)
              {
                if($Barre == 2) {$BarreLibe1 = "<span style='text-decoration:line-through;'>";$BarreLibe2 = "</span>";}
                else {$BarreLibe1 = "";$BarreLibe2 = "";}

              	$TropPercu = FactEncaisserTropPercu($Dossier,$ConnexionBdd,$req2Affich['factencnum']);

                $Lecture.="<tr>";
                $Lecture.="<td>".$Lien.formatdatemysql($req1Affich['livrdecomptdate'])."</a></td>";
								$Export.=formatdatemysql($req1Affich['livrdecomptdate']).";";
								$Lecture.="<td class='supp400px'>".$Lien.ClieLect($req1Affich['clients_clienum'],$ConnexionBdd)."</a></td>";
								$Export.=ClieLect($req1Affich['clients_clienum'],$ConnexionBdd).";";
                // LIBELLE
                $Lecture.="<td class='supp400px'>".$Lien.$BarreLibe1.$_SESSION['STrad311'];
								$Export.=$_SESSION['STrad311'].";";
                if($TropPercu[0] > 0 AND !empty($BarreLibe1)) {$Lecture.=" <span style='color:green;'>(".$_SESSION['STrad312']." ".$TropPercu[0]." ".$_SESSION['STrad27'].")</span>";$Export.="(".$_SESSION['STrad312']." ".$TropPercu[0]." ".$_SESSION['STrad27'].")";}
                $Lecture.=$BarreLibe2."</a></td>";

                // NUMERO DE PIECE
								$LibeFactEnc = "";
								$req4 = 'SELECT * FROM factures,factprestation,factures_factencaisser WHERE factures_factnum = factnum AND factprestation_factprestnum = factprestnum AND factencaisser_factencnum = "'.$req2Affich['factencnum'].'" GROUP BY factnum';
								$req4Result = $ConnexionBdd ->query($req4) or die ('Erreur SQL !'.$req4.'<br />'.mysqli_error());
								while($req4Affich = $req4Result->fetch()){$LibeFactEnc.=", ".FactPrefLect($req4Affich['factdate'],$req4Affich['factnumlibe'],null,null);}
								$LibeFactEnc = substr($LibeFactEnc, 2, 500);
                $Lecture.="<td class='supp400px'>".$Lien.$BarreLibe1.$req2Affich['factencreference']." ".$LibeFactEnc.$BarreLibe2."</a></td>";
								$Export.=$req2Affich['factencreference']." ".$LibeFactEnc.";";
                // MONTANT DEBIT
                $req2Affich['factencmontantverser'] = number_format($req2Affich['factencmontantverser'], 2, '.', '');

                $TotalCredit = $TotalCredit + $req2Affich['factencmontantverser'];

								if($_SESSION['ResolutionConnexion1'] <= 800)
									{
										$Lecture.="<td rowspan='4' style='white-space:nowrap;'></td>";
		                $Lecture.="<td rowspan='4' style='white-space:nowrap;'>".$Lien.$BarreLibe1.$req2Affich['factencmontantverser']." ".$_SESSION['STrad27'].$BarreLibe2."</a></td>";

									}
								else
									{
										$Lecture.="<td style='white-space:nowrap;'></td>";
		                $Lecture.="<td style='white-space:nowrap;'>".$Lien.$BarreLibe1.$req2Affich['factencmontantverser']." ".$_SESSION['STrad27'].$BarreLibe2."</a></td>";
									}
                $Export.=$req2Affich['factencmontantverser'].";\n";

								$req3 = 'SELECT * FROM clients,factures,factprestation,factures_factencaisser WHERE factures.clients_clienum = clienum AND factures_factnum = factnum AND factprestation_factprestnum = factprestnum AND factencaisser_factencnum = "'.$req2Affich['factencnum'].'" GROUP BY factnum';
								$req3Result = $ConnexionBdd ->query($req3) or die ('Erreur SQL !'.$req3.'<br />'.mysqli_error());
								$req3Affich = $req3Result->fetch();
								$Export.=$req3Affich['clienumcompte'].";";

								$Lecture.="</tr>";

								if($_SESSION['ResolutionConnexion1'] <= 800)
									{
										$Lecture.="<tr>";
											$Lecture.="<td>".$Lien.ClieLect($req1Affich['clients_clienum'],$ConnexionBdd)."</a></td>";
										$Lecture.="</tr>";
										$Lecture.="<tr>";
											$Lecture.="<td>".$Lien.$BarreLibe1.$_SESSION['STrad311'].$BarreLibe2."</a></td>";
										$Lecture.="</tr>";
										$Lecture.="<tr>";
											$Lecture.="<td>".$Lien.$BarreLibe1.$req2Affich['factencreference']." ".$LibeFactEnc.$BarreLibe2."</a></td>";
										$Lecture.="</tr>";
									}
              }
          }
      }

		$TotalDebit = number_format($TotalDebit, 2, '.', '');
		$TotalCredit = number_format($TotalCredit, 2, '.', '');
		$Lecture.="<tr class='supp400px supp800px'><td colspan='4' style='vertical-align:middle;'><span style='float:right;font-weight:bolder;'>".$_SESSION['STrad738']."</span></td><td style='font-weight:bolder;vertical-align:middle;white-space:nowrap;'>".$TotalDebit." ".$_SESSION['STrad27']."</td><td style='font-weight:bolder;vertical-align:middle;white-space:nowrap;'>".$TotalCredit." ".$_SESSION['STrad27']."</td></tr>";
		$Lecture.="<tr class='supp1024px supp1300px'><td style='vertical-align:middle;'><span style='float:right;font-weight:bolder;'>".$_SESSION['STrad738']."</span></td><td style='font-weight:bolder;vertical-align:middle;white-space:nowrap;'>".$TotalDebit." ".$_SESSION['STrad27']."</td><td style='font-weight:bolder;vertical-align:middle;white-space:nowrap;'>".$TotalCredit." ".$_SESSION['STrad27']."</td></tr>";
		$Export.=";;;".$_SESSION['STrad738'].";".$TotalDebit.";".$TotalCredit.";\n";

		$Lecture.="</table>";

		$ouvre=fopen($Dossier."modules/tmp/livredecompte_".$_SESSION['hebeappnum'].".csv","w+");
		fwrite($ouvre,$Export);
		fclose($ouvre);

    return array($Lecture,$Export);
  }
//**********************************************************

//*********** LIST FACTURATION AUTOMATIQUE ***************
function FactAutoList($Dossier,$ConnexionBdd)
	{
		$Lecture.="<table style='width:100%;'>";

		$req1 = 'SELECT * FROM facturation_auto1 WHERE AA_equimondo_hebeappnum = "'.$_SESSION['hebeappnum'].'" ORDER BY 	factauto1periode ASC';
		$req1Result = $ConnexionBdd ->query($req1) or die ('Erreur SQL !'.$req1.'<br />'.mysqli_error());
		while($req1Affich = $req1Result->fetch())
			{
				$Lecture.="<tr>";

					if($_SESSION['ResolutionConnexion1'] <= 800) {$Lien = "<a href='".$Dossier."modules/facturation/modfactautofichcomplet1.php?factauto1num=".$req1Affich['factauto1num']."' class='LoadPage AfficheFactAuto1'>";}
					else {$Lien = "<a href='".$Dossier."modules/facturation/modfactautofichcomplet2.php?factauto1num=".$req1Affich['factauto1num']."' class='LoadPage AfficheFactAuto2'>";}

					$Lecture.="<td>";
					$Lecture.="<section style='float:left;width:10%;'>";
						$Lecture.="<div style='background:#FFD95C;width:40%;margin-left:15%;height:30px;'></div>";
						$Lecture.="<div style='background:#FFCCF9;width:40%;margin-left:15%;height:30px;'></div>";
						$Lecture.="<div style='background:#99D8F4;width:40%;margin-left:15%;height:30px;'></div>";
					$Lecture.=$Lien."</section>";

					$Lecture.=$Lien."<section style='float:left;width:85%;'>";
						$Lecture.="<div style='width:100%;margin-bottom:8px;'>";
							$Lecture.="<span style='font-weight:bolder;'>".$_SESSION['STrad377']." ".$req1Affich['factauto1periode']." ".ReplicationPeriodeLect($req1Affich['factauto1replication'])."</span>";
						$Lecture.="</div>";

						$Lecture.="<div style='width:100%;margin-bottom:8px;font-weight:bolder;'>";
							if(!empty($req1Affich['clients_clienum']))
								{
									$Lecture.=ClieLect($req1Affich['clients_clienum'],$ConnexionBdd);
								}
							if(!empty($req1Affich['groupe_groupnum']))
								{
									$Lecture.=GroupeLect($req1Affich['groupe_groupnum'],$ConnexionBdd);
								}
						$Lecture.="</div>";
						$Lecture.="<div style='width:100%;margin-bottom:8px;'>";
							$Lecture.=$_SESSION['STrad378']." : <span style='font-style:italic;'>".formatdatemysql($req1Affich['factauto1datedernexec'])."</span>";
						$Lecture.="</div>";
						$Lecture.="<div style='width:100%;margin-bottom:8px;'>";
							$Lecture.=$_SESSION['STrad379']." : <br>";
							$Lecture.="<span style='font-style:italic;'>";
							if(!empty($req1Affich['factauto1perio1']) AND empty($req1Affich['factauto1perio2']))
								{
									$Lecture.=$TradDivPeriodeDu." ".formatdatemysql($req1Affich['factauto1perio1'])." ".$TradDivPeriodeAu." ".formatdatemysql($req1Affich['factauto1perio2']);
								}
							else {$Lecture.=$_SESSION['STrad380'];}
							$Lecture.="</span>";
						$Lecture.="</div>";

					$Lecture.="</section></a>";
					$Lecture.="</td>";
				$Lecture.="</tr>";
				$Lecture.="<tr><td><hr class='HrListe1'></td></tr>";
			}
		$Lecture.="</table>";

		return array($Lecture);
	}
//**********************************************************

//******************************** REPLICATION FACTURATION AUTO **************************
function ReplicationPeriodeSelect($num)
	{
		$Lecture.="<option value='1'";if($num == 1) {$Lecture.=" selected";} $Lecture.=">".$_SESSION['STrad372']."</option>";
		$Lecture.="<option value='2'";if($num == 2) {$Lecture.=" selected";} $Lecture.=">".$_SESSION['STrad373']."</option>";
		$Lecture.="<option value='3'";if($num == 3) {$Lecture.=" selected";} $Lecture.=">".$_SESSION['STrad374']."</option>";
		$Lecture.="<option value='4'";if($num == 4) {$Lecture.=" selected";} $Lecture.=">".$_SESSION['STrad375']."</option>";
		$Lecture.="<option value='5'";if($num == 5) {$Lecture.=" selected";} $Lecture.=">".$_SESSION['STrad376']."</option>";

		return $Lecture;
	}
function ReplicationPeriodeLect($num)
	{
		if($num == 1) {$Lecture.=$_SESSION['STrad372'];}
		if($num == 2) {$Lecture.=$_SESSION['STrad373'];}
		if($num == 3) {$Lecture.=$_SESSION['STrad374'];}
		if($num == 4) {$Lecture.=$_SESSION['STrad375'];}
		if($num == 5) {$Lecture.=$_SESSION['STrad376'];}

		return $Lecture;
	}
//***********************************************************************************

//******************* AJOUTER UN MOT DE PAIEMENT **********************
function SelectFactAuto1Type($num)
	{
		$Lecture.="<option value=''>".$_SESSION['STrad381']." :</option>";
		$Lecture.="<option value='4'";if($num == 4) {$Lecture.=" selected";} $Lecture.=">".$_SESSION['STrad35']."</option>";
		$Lecture.="<option value='7'";if($num == 7) {$Lecture.=" selected";} $Lecture.=">".$_SESSION['STrad53']."</option>";

		return $Lecture;
	}
//******************************************************

//******************* FICHE COMPLET FACTURATION AUTO **********************
function FacturationAutoFicheComplet($Dossier,$ConnexionBdd,$factauto1num)
	{
		//******************** BOUTTON FERMER **************************
		if($_SESSION['ResolutionConnexion1'] <= 800) {$LibeButt = $_SESSION['STrad316'];}
    else {$LibeButt = $_SESSION['STrad155'];}
    $SousMenuCorp.="<div class='buttonBasMenuFixedRub'><a href='".$Dossier."modules/facturation/modfactautoSupp.php?factauto1num=".$factauto1num."' class='button buttonLittle'><img src='".$Dossier."images/supprimerBlanc.png' class='ImgSousMenu2'>".$LibeButt."</a></div>";
    if($_SESSION['ResolutionConnexion1'] <= 800) {$LibeButt = $_SESSION['STrad705'];}
    else {$LibeButt = $_SESSION['STrad746'];}
    if($_SESSION['ResolutionConnexion1'] <= 800) {$SousMenuCorp.="<div class='buttonBasMenuFixedRub'><a href='#close' class='button buttonLittle'><img src='".$Dossier."images/closeBlanc.png' class='ImgSousMenu2'>".$LibeButt."</a></div>";}

    if($_SESSION['ResolutionConnexion1'] <= 800)
      {
        $ResultatTailleWidth = "49";
        $SousMenuCorp = str_replace("<div class='buttonBasMenuFixedRub'>","<div class='buttonBasMenuFixedRub' style='width:".$ResultatTailleWidth."%;'>",$SousMenuCorp);
        $Lecture.="<div class='buttonBasMenuFixed'>";
        $Lecture.=$SousMenuCorp;
        $Lecture.="</div>";
      }
    else
      {
        $Lecture.="<div class='supp400px supp800px' style='width:100%;display:block;clear:both;'>";
        $Lecture.=$SousMenuCorp;
        $Lecture.="</div>";
        $Lecture.="<div style='height:20px;width:100%;display:block;clear:both;'></div>";
      }
		//****************************************************************

		$req1 = 'SELECT * FROM facturation_auto1 WHERE factauto1num = "'.$factauto1num.'"';
		$req1Result = $ConnexionBdd ->query($req1) or die ('Erreur SQL !'.$req1.'<br />'.mysqli_error());
		$req1Affich = $req1Result->fetch();

		$Lecture.="<table style='width:100%;'>";
			$Lecture.="<tr style='height:20px;'></tr>";
			$Lecture.="<tr>";
			if(!empty($req1Affich['groupe_groupnum'])) {$Lecture.="<td>".$_SESSION['STrad385']." :</td><td>".GroupeLect($req1Affich['groupe_groupnum'],$ConnexionBdd)."</td>";}
			if(!empty($req1Affich['clients_clienum'])) {$Lecture.="<td>".$_SESSION['STrad360']." :</td><td><a href='".$Dossier."modules/profil/modprofilfichcomplet1.php?clienum=".$req1Affich['clients_clienum']."' class='LoadPage AfficheFicheProfil1' style='font-weight:bolder;'>".ClieLect($req1Affich['clients_clienum'],$ConnexionBdd)."</a></td>";}

			$Lecture.="<td><span style='margin-left:20px;'></span>".$_SESSION['STrad377']." <span style='font-weight:bolder;'>".$req1Affich['factauto1periode']." ".ReplicationPeriodeLect($req1Affich['factauto1replication'])."</span></td>";
			$Lecture.="</tr>";

			$Lecture.="<tr>";
				$Lecture.="<td>".$_SESSION['STrad383']." :</td><td><span style='font-weight:bolder;'>".FactIndLect($req1Affich['factauto1type'])."</span></td>";
				$Lecture.="<td><span style='margin-left:20px;'></span>".$_SESSION['STrad378']." :</td><td><span style='font-weight:bolder;'>".formatdatemysql($req1Affich['factauto1datedernexec'])."</span></td>";
			$Lecture.="</tr>";

			$Lecture.="<tr>";
				$Lecture.="<td>".$_SESSION['STrad379']." :</td>";
				$Lecture.="<td><span style='margin-left:20px;'></span><span style='font-weight:bolder;'>";

				if(!empty($req1Affich['factauto1perio1']) AND empty($req1Affich['factauto1perio2']))
					{
						$Lecture.=$TradDivPeriodeDu." ".formatdatemysql($req1Affich['factauto1perio1'])." ".$TradDivPeriodeAu." ".formatdatemysql($req1Affich['factauto1perio2']);
					}
				else {$Lecture.=$_SESSION['STrad380'];}

				$Lecture.="</span></td>";
			$Lecture.="</tr>";

			$Lecture.="<tr>";
				$Lecture.="<td colspan='4'>";
				$Lecture.=$_SESSION['STrad384']." :<span style='font-weight:bolder;'>".AffichQuestOuiNonLect($req1Affich['factauto1mail'])."</span>";
				$Lecture.="</td>";
			$Lecture.="</tr>";

			$Lecture.="<tr style='height:20px;'></tr>";
			$Lecture.="</table>";

			if($_SESSION['ResolutionConnexion1'] < 800) {$Largeur = 100;}
			else {$Largeur = 50;}

			$Lecture.="<section id='FactAuto2List' style='float:left;width:".$Largeur."%;'>";
				$Lecture.=FacturationAutoFicheCompletPrestList($Dossier,$ConnexionBdd,$factauto1num);
			$Lecture.="</section>";

			$Lecture.="<section style='float:left;width:".$Largeur."%;'>";
				$Lecture.="<div class='InfoStandard FormInfoStandard1'><img src='".$Dossier."images/informationBlanc.png' class='imgSousMenu1' style='margin-right:10px;'>".$_SESSION['STrad388']."</div><br>";
				$Lecture.="<table class='tab_rubrique' style='width:100%;'>";
				$req2 = 'SELECT * FROM factures_auto_association,factures WHERE factnum = factures_factnum AND facturation_auto1_factauto1num = "'.$factauto1num.'"';
				$req2Result = $ConnexionBdd ->query($req2) or die ('Erreur SQL !'.$req2.'<br />'.mysqli_error());
				while($req2Affich = $req2Result->fetch())
					{
						$SoldeFact = FactCalc($req2Affich['factures_factnum'],$ConnexionBdd);

						$Lien = "<a href='".$Dossier."modules/facturation/modfactfichcomplet1.php?factnum=".$req2Affich['factnum']."' class='LoadPage AfficheFicheFacture1'>";

						$Lecture.="<tr>";
							$Lecture.="<td>".$Lien.FactIndLect($req2Affich['facttype'])."</a></td>";
							$Lecture.="<td>".$Lien.formatdatemysql($req2Affich['factdate'])."</a></td>";
							$Lecture.="<td>".$Lien.$SoldeFact[2]." ".$_SESSION['STrad27']."</a></td>";
						$Lecture.="</tr>";
					}
				$Lecture.="<table>";
			$Lecture.="</section>";

		return $Lecture;
	}
//******************************************************

//****************** FACTURATION AUTO PRESTATION LIST ***************
function FacturationAutoFicheCompletPrestList($Dossier,$ConnexionBdd,$factauto1num)
	{
		$req1 = 'SELECT * FROM facturation_auto1 WHERE factauto1num = "'.$factauto1num.'"';
		$req1Result = $ConnexionBdd ->query($req1) or die ('Erreur SQL !'.$req1.'<br />'.mysqli_error());
		$req1Affich = $req1Result->fetch();

		$Lecture.="<table style='width:100%;'>";
		$Lecture.="<tr><td colspan='2'><div class='InfoStandard FormInfoStandard1'><img src='".$Dossier."images/informationBlanc.png' class='imgSousMenu1' style='margin-right:10px;'>".$_SESSION['STrad178']."</div></td></tr>";

		$req2 = 'SELECT * FROM facturation_auto2 WHERE facturation_auto1_factauto1num = "'.$factauto1num.'"';
		$req2Result = $ConnexionBdd ->query($req2) or die ('Erreur SQL !'.$req2.'<br />'.mysqli_error());
		while($req2Affich = $req2Result->fetch())
			{
				$req4 = 'SELECT typeprestlibe FROM typeprestation WHERE typeprestnum = "'.$req2Affich['typeprestation_typeprestnum'].'"';
				$req4Result = $ConnexionBdd ->query($req4) or die ('Erreur SQL !'.$req4.'<br />'.mysqli_error());
				$req4Affich = $req4Result->fetch();
				if(empty($reqAffich['factauto2prixttc']))
					{
						$req3 = 'SELECT sum(typeprestprixprix) FROM typeprestation_prix WHERE typeprestprixsupp = "1" AND typeprestation_typeprestnum = "'.$req2Affich['typeprestation_typeprestnum'].'"';
						$req3Result = $ConnexionBdd ->query($req3) or die ('Erreur SQL !'.$req3.'<br />'.mysqli_error());
						$req3Affich = $req3Result->fetch();
					}
				else {$req3Affich[0] = $req2Affich['factauto2prixttc'];}
				$Lecture.="<tr>";
				$Lecture.="<td>".$req4Affich['typeprestlibe']." :</td>";
				$Lecture.="<td>".$req3Affich[0]." ".$_SESSION['STrad27'];
				if(!empty($req2Affich['factauto2tauxremise']))
					{
						$Lecture.=" <span style='font-style:italic;'>(".$_SESSION['STrad386']." : ".$req2Affich['factauto2tauxremise']." %)</span>";
					}
				$Lecture.="</td>";
				$Lecture.="<td rowspan='3'>";
					$Lecture.="<a href='".$Dossier."modules/facturation/modfactautoPrestSupp.php?factauto1num=".$factauto1num."&factauto2num=".$req2Affich['factauto2num']."' class='LoadPage FactAutoPrestSupp'><img src='".$Dossier."images/supprimer.png' class='ImgSousMenu2'></a>";
				$Lecture.="</td>";
				$Lecture.="</tr>";

				$Lecture.="<tr>";
				$Lecture.="<td colspan='3'><a href='".$Dossier."modules/profil/modprofilfichcomplet1.php?clienum=".$req1Affich['clients_clienum']."' class='LoadPage AfficheFicheProfil1' style='font-weight:bolder;'>";
					$Lecture.=ClieLect($req2Affich['clients_clienum'],$ConnexionBdd);
				$Lecture.="</a></td>";
				$Lecture.="</tr>";
				$Lecture.="<tr>";
				$Lecture.="<td colspan='3'>";
					$Lecture.=ChevLect($req2Affich['chevaux_chevnum'],$ConnexionBdd);
				$Lecture.="</td>";
				$Lecture.="</tr>";

			}

		$Lecture.="<tr><td colspan='3'>";
			$Lecture.="<div id='AfficheFactAuto2PrestAjou'>";
			$Lecture.="<a href='".$Dossier."modules/facturation/modfactautoPrestAjou.php?factauto1num=".$factauto1num."' class='LoadPage AfficheFactAuto2PrestAjou'><div class='LienDefilement1'>".$_SESSION['STrad157']."<img src='".$Dossier."images/FlecheBasBlanc.png' class='ImgSousMenu2' style='float:right;'></div></a>";
			$Lecture.="</div>";
		$Lecture.="</td></tr>";
		$Lecture.="</table>";

		return $Lecture;
	}
//******************************************************

//****************** EVENEMENT FACTURER ******************************
function FacturesGroupesRechercher($Dossier,$ConnexionBdd,$RechercherInd)
	{
		$Lecture.="<option value=''>- ".$_SESSION['STrad64']." -</option>";
		if($RechercherInd == 1) {$Selected = "selected";} else {$Selected = "";}
		$Lecture.="<option value='1'";if(!empty($Selected)) {$Lecture.=" ".$Selected;} $Lecture.=">".$_SESSION['STrad714']."</option>";
		if($RechercherInd == 2) {$Selected = "selected";} else {$Selected = "";}
		$Lecture.="<option value='2'";if(!empty($Selected)) {$Lecture.=" ".$Selected;} $Lecture.=">".$_SESSION['STrad724']."</option>";
		if($RechercherInd == 3) {$Selected = "selected";} else {$Selected = "";}
		$Lecture.="<option value='3'";if(!empty($Selected)) {$Lecture.=" ".$Selected;} $Lecture.=">".$_SESSION['STrad117']."</option>";
		if($RechercherInd == 4) {$Selected = "selected";} else {$Selected = "";}
		$Lecture.="<option value='4'";if(!empty($Selected)) {$Lecture.=" ".$Selected;} $Lecture.=">".$_SESSION['STrad118']."</option>";

		return $Lecture;
	}
//*************************************************************************

//****************** EVENEMENT FACTURER ******************************
function FacturesGroupes($Dossier,$ConnexionBdd)
	{
		$Lecture.="<div style='height:20px;'></div>";
		$Lecture.="<table class='tab_rubrique'>";
		  $Lecture.="<thead><tr>";
		    $Lecture.="<td>".$_SESSION['STrad712']."</td>";
		    $Lecture.="<td>".$_SESSION['STrad456']."</td>";
				$Lecture.="<td class='supp400px'>".$_SESSION['STrad397']."</td>";
		    $Lecture.="<td class='supp400px'>".$_SESSION['STrad713']."</td>";
		    $Lecture.="<td class='supp400px'>".$_SESSION['STrad117']." / ".$_SESSION['STrad118']."</td>";
		    $Lecture.='<td><input onclick="CocheTout(this, \'calepartnum[]\');" type="checkbox"></td>';

		  $Lecture.="</tr></thead>";

			if(!empty($_GET['rechdate1'])) {$rechdate1 = $_GET['rechdate1'];} else if(!empty($_SESSION['rechdate1FactGroupe'])) {$rechdate1 = $_SESSION['rechdate1FactGroupe'];} else {$rechdate1 = date('Y-m-d', mktime(0,0,0,date('m') - 2,date('d'),date('Y')));}
			if(!empty($_GET['rechdate2'])) {$rechdate2 = $_GET['rechdate2'];} else if(!empty($_SESSION['rechdate2FactGroupe'])) {$rechdate2 = $_SESSION['rechdate2FactGroupe'];} else {$rechdate2 = date('Y-m-d', mktime(0,0,0,date('m'),date('d'),date('Y')));}
			if(!empty($_GET['RechercherInd'])) {$RechercherInd = $_GET['RechercherInd'];} else if(!empty($_SESSION['RechercherInd'])) {$RechercherInd = $_SESSION['RechercherInd'];} else {$RechercherInd = "";}

		  $req1 = 'SELECT calendrier_participants.chevaux_chevnum,calendrier_participants.clients_clienum,calenum,caledate1,calecatetype,calepartnum FROM calendrier,calendrier_participants,calendrier_categorie WHERE calendrier_categorie_calecatenum = calecatenum AND calendrier_calenum = calenum AND (calecatetype = "1" OR calecatetype = "2") AND calendrier.AA_equimondo_hebeappnum = "'.$_SESSION['hebeappnum'].'"';
			if(!empty($rechdate1) AND !empty($rechdate1)) {$req1.=' AND caledate1 BETWEEN "'.$rechdate1.' 00:00:00" AND "'.$rechdate2.' 23:59:59"';}
			$req1.= ' ORDER BY caledate1 DESC';
			if(empty($_SESSION['rechdate1FactGroupe']) AND empty($_SESSION['rechdate2FactGroupe'])) {$req1.= ' LIMIT 0,50';}
			$req1Result = $ConnexionBdd ->query($req1) or die ('Erreur SQL !'.$req1.'<br />'.mysqli_error());
		  while($req1Affich = $req1Result->fetch())
		    {
					// FACTURER OU NON FACTURER
					$req2 = 'SELECT * FROM factprestation_association WHERE calendrier_participants_calepartnum = "'.$req1Affich['calepartnum'].'"';
					$req2Result = $ConnexionBdd ->query($req2) or die ('Erreur SQL !'.$req2.'<br />'.mysqli_error());
					$req2Affich = $req2Result->fetch();
					if(!empty($req2Affich['factprestassonum'])) {$LibeFact = $_SESSION['STrad714'];$AlerteFact = "AlerteGreen";}
					else {$LibeFact = $_SESSION['STrad715'];$AlerteFact = "AlerteRed";}

					// PAYER OU PAS PAYER
					$Payer = CalcPrest($req2Affich['factprestation_factprestnum'],$ConnexionBdd);

					if($RechercherInd == 1 AND !empty($req2Affich['factprestassonum'])) {$Exec = 2;} else if($RechercherInd == 1 AND empty($req2Affich['factprestassonum'])) {$Exec = 1;}
					if($RechercherInd == 2 AND empty($req2Affich['factprestassonum'])) {$Exec = 2;} else if($RechercherInd == 2 AND !empty($req2Affich['factprestassonum'])) {$Exec = 1;}
					if($RechercherInd == 3 AND $Payer[2] == 0 AND !empty($req2Affich['factprestassonum'])) {$Exec = 2;} else if($RechercherInd == 3) {$Exec = 1;}
					if($RechercherInd == 4 AND ($Payer[2] != 0 OR empty($req2Affich['factprestassonum']))) {$Exec = 2;} else if($RechercherInd == 4) {$Exec = 1;}
					if(empty($RechercherInd)) {$Exec = 2;}

					if($Exec == 2)
						{
				      $Lien1 = "<a href='".$Dossier."modules/calendrier/modcalefichcomplet.php?calenum=".$req1Affich['calenum']."' class='LoadPage AfficheCaleFichComplet'>";

				      $Lecture.="<tr>";
								$Lecture.="<td>".$Lien1.$req1Affich['calecatelibe']." ".FormatDateTimeMySql($req1Affich['caledate1'])."</a></td>";
				        $Lecture.="<td>".$Lien1.ClieLect($req1Affich[1],$ConnexionBdd)."</a></td>";
								$Lecture.="<td class='supp400px'>".$Lien1.ChevLect($req1Affich[0],$ConnexionBdd)."</a></td>";

								// FACTURER OU NON FACTURER
								if(!empty($req2Affich['factprestation_factprestnum']))
									{
										$req3 = 'SELECT * FROM factprestation WHERE factprestnum = "'.$req2Affich['factprestation_factprestnum'].'"';
				        		$req3Result = $ConnexionBdd ->query($req3) or die ('Erreur SQL !'.$req3.'<br />'.mysqli_error());
				        		$req3Affich = $req3Result->fetch();
										$Lien2 = "<a href='".$Dossier."modules/facturation/modfactfichcomplet1.php?factnum=".$req3Affich['factures_factnum']."' class='LoadPage AfficheFicheFacture1'>";
									}
								else {$Lien2 = $Lien1;}

				        $Lecture.="<td class='supp400px ".$AlerteFact."'>".$Lien2.$LibeFact."</a></td>";

				        // PAYER OU PAS PAYER
				        if($Payer[2] != 0 OR empty($req2Affich['factprestassonum'])) {$LibePaye = $_SESSION['STrad118'];$AlerteEnc = "AlerteRed";}
				        else {$LibePaye = $_SESSION['STrad117'];$AlerteEnc = "AlerteGreen";}
				        $Lecture.="<td class='supp400px ".$AlerteEnc."'>".$Lien2.$LibePaye."</a></td>";

				        $Lecture.="<td><input type='checkbox' name='calepartnum[]' value='".$req1Affich['calepartnum']."'></td>";

				      $Lecture.="</tr>";

							$Lecture.="<tr class='supp1024px supp1300px'>";
								$Lecture.="<td class='".$AlerteFact."'>".$Lien2.$LibeFact."</td>";
								$Lecture.="<td class='".$AlerteEnc."'>".$Lien2.$LibePaye."</td>";
							$Lecture.="</tr>";
						}
		    }
		$Lecture.="</table>";

		$_SESSION['rechdate1FactGroupe'] = $rechdate1;
		$_SESSION['rechdate2FactGroupe'] = $rechdate2;
		$_SESSION['RechercherInd'] = $_GET['RechercherInd'];

		return $Lecture;
	}
//***********************************************************************

//********************* PRODUITS CONSTATÉES D'AVANCES *****************************
function FactproduitsConstateDavance($Dossier,$ConnnexionBdd,$date1,$date2)
	{
		$Lecture.="<table>";

		$Lecture.="</table>";

		return $Lecture;
	}
//***********************************************************************

//*************** PRODUITS CONSTATES D AVANCE ******************************
function AfficheProduitsConstates($Dossier,$ConnexionBdd,$date1,$date2)
	{
		$Lecture.="<section class='scroll-section' id='borderedTables'>
		  <h2 class='small-title'>".$_SESSION['STrad823']." ".formatdatemysql($date1)." ".$$_SESSION['STrad824']." ".formatdatemysql($date2)."</h2>
		  <div class='card mb-5'>
		    <div class='card-body'>
		      <table class='table table-bordered'>
		        <thead>
		          <tr>
		            <th scope='col'>".$_SESSION['STrad91']."</th>
		            <th scope='col'>".$_SESSION['STrad326']."</th>
		            <th scope='col'>".$_SESSION['STrad819']."</th>
		            <th scope='col'>".$_SESSION['STrad820']."</th>
								<th scope='col'>".$_SESSION['STrad821']."</th>
								<th scope='col'>".$_SESSION['STrad822']."</th>
		          </tr>
		        </thead>
						<tbody>";

						$req1 = 'SELECT * FROM clients WHERE AA_equimondo_hebeappnum = "'.$_SESSION['hebeappnum'].'" ORDER BY clienom ASC';
						$req1Result = $ConnexionBdd ->query($req1) or die ('Erreur SQL !'.$req1.'<br />'.mysqli_error());
						while($req1Affich = $req1Result->fetch())
							{
								// VERIF SI LA PERSONNE A DES FACTURES
								$req2 = 'SELECT count(factnum) FROM factures WHERE clients_clienum = "'.$req1Affich['clienum'].'"';
								$req2Result = $ConnexionBdd ->query($req2) or die ('Erreur SQL !'.$req2.'<br />'.mysqli_error());
								$req2Affich = $req2Result->fetch();

								// VERIF SI LA PERSONNE A BIEN MONTE
								$req3 = 'SELECT count(cliesoldforfsortnum) FROM clientssoldeforfsortie WHERE clients_clienum = "'.$req1Affich['clienum'].'"';
								$req3Result = $ConnexionBdd ->query($req3) or die ('Erreur SQL !'.$req3.'<br />'.mysqli_error());
								$req3Affich = $req3Result->fetch();

								if($req2Affich[0] >= 1 OR $req3Affich[0] >= 1)
									{
										$CalcClie = FactCalcClie($Dossier,$ConnexionBdd,$req1Affich['clienum'],$date1,$date2);

										$Ht = number_format($CalcClie[0], 2, '.', '');
										$Ttc = number_format($CalcClie[1], 2, '.', '');
										$NbHeure = $CalcClie[2];
										$MontantnbHeure = number_format($CalcClie[3], 2, '.', '');

										if($CalcClie[0] > 0 OR $CalcClie[1] > 0 OR $CalcClie[2] > 0 OR $CalcClie[3] > 0)
											{
												$Lecture.="<tr>";
								        	$Lecture.="<th scope='row'>".$req1Affich['clienom']." ".$req1Affich['clieprenom']."</th>";
								        	$Lecture.="<td>".$req1Affich['clienumcompte']."</td>";
								        	$Lecture.="<td>".$Ttc." ".$_SESSION['STrad27']."</td>";
								        	$Lecture.="<td>".$Ht." ".$_SESSION['STrad27']."</td>";
													$Lecture.="<td>".minute_vers_heure($NbHeure)."</td>";
													$Lecture.="<td>".$MontantnbHeure." ".$_SESSION['STrad27']."</td>";
								        $Lecture.="</tr>";
											}
									}
							}

						$Lecture.="</tbody></table>
		    </div>
		  </div>
		</section>";

		return $Lecture;
	}
//******************************************************************

?>
