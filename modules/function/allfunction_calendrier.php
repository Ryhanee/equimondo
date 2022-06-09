<?php
// ************************** MODE DE VUE FICHE MONTOIR ************************
function ModeVueMontoir($num)
	{
		$Lecture.="<option value='1'";if($num == 1) {$Lecture.=" selected";} $Lecture.=">".$_SESSION['STrad180']." 1</option>";
		$Lecture.="<option value='2'";if($num == 2) {$Lecture.=" selected";} $Lecture.=">".$_SESSION['STrad180']." 2</option>";
		$Lecture.="<option value='3'";if($num == 3) {$Lecture.=" selected";} $Lecture.=">".$_SESSION['STrad180']." 3</option>";

		return $Lecture;
	}
//*******************************************************************************************

//******************************************** FICHE MONTOIRE ****************************************************
function FicheMontoir($Dossier,$ConnexionBdd,$Impression,$DateMontoir)
	{
		$_SESSION['NumExec'] = 0;
    if(empty($_SESSION['authconfigaffichfichmontoir'])) {$_SESSION['authconfigaffichfichmontoir'] = 1;}
		if(!empty($Impression)) {$_GET['Impression'] = $Impression;}

		if(!empty($DateMontoir)) {$date=$DateMontoir;}
    else if(!empty($_GET['date'])) {$date=$_GET['date'];}
    else if(!empty($_SESSION['DateMontoir'])) {$date = $_SESSION['DateMontoir'];}
		else {$date=date("Y-m-d");}

    $_SESSION['DateMontoir'] = $date;

		if(empty($_SESSION['authconfigaffichfichmontoir'])) {$_SESSION['authconfigaffichfichmontoir'] = 1;}
		if(!empty($Impression)) {$_GET['Impression'] = $Impression;}
		if(empty($date)) {$date=date("Y-m-d");}

		if(!empty($_GET['authconfigaffichfichmontoir']))
			{
				$req1 = 'UPDATE authentification SET authconfigaffichfichmontoir = "'.$_GET['authconfigaffichfichmontoir'].'" WHERE authnum = "'.$_SESSION['authconnauthnum'].'"';
				$req1Result = $ConnexionBdd ->query($req1) or die ('Erreur SQL !'.$req1.'<br />'.mysqli_error());

				$_SESSION['authconfigaffichfichmontoir'] = $_GET['authconfigaffichfichmontoir'];
			}

		$req1 = 'SELECT count(calenum) FROM calendrier WHERE caleindice = "1" AND caledate1 BETWEEN "'.$date.' 00:00:00" AND "'.$date.' 23:59:59" AND calendrier.AA_equimondo_hebeappnum = "'.$_SESSION['hebeappnum'].'"';
		if(!empty($_SESSION['calecatenum'])) {$req1.=' AND calendrier_categorie_calecatenum = "'.$_SESSION['calecatenum'].'"';}
		$req1Result = $ConnexionBdd ->query($req1) or die ('Erreur SQL !'.$req1.'<br />'.mysqli_error());
		$req1Affich = $req1Result->fetch();

		if(!empty($_SESSION['confenr'])) {$Lecture.="<div class='rub_error1'>".$_SESSION['confenr']."</div>";}

		if($_GET['Impression'] == 2)
			{
				$Lecture.="<div style='width:100%;clear:both;display:block;'>";
				$Lecture.="<img src='https://equimondo.fr/perso_images/".$_SESSION['hebeappnum']."/images/logo.png' class='ImgFactLogo' style='float:left;'>";
			}
		$Lecture.="<center><b<div class='InfoStandard FormInfoStandard1'><img src='".$Dossier."images/informationBlanc.png' class='imgSousMenu1' style='margin-right:10px;'>".CalendrierLect(1)." ".$_SESSION['STrad365']." ".formatdatemysql($date)."</div></center><br>";
		if($_GET['Impression'] == 2)
			{
				$Lecture.="</div>";
			}

		//*********************************** AFFICHER SORTIE PADDOCK *****************************************************
		$reqCaleCount = 'SELECT count(calepartnum) FROM calendrier,calendrier_participants,calendrier_categorie WHERE calendrier_categorie_calecatenum = calecatenum AND calecatetype ="5" AND calendrier_calenum = calenum AND caledate1 BETWEEN "'.$date.' 00:00:00" AND "'.$date.' 23:59:59" AND calendrier.AA_equimondo_hebeappnum = "'.$_SESSION['hebeappnum'].'"';
		$reqCaleCountResult = $ConnexionBdd ->query($reqCaleCount) or die ('Erreur SQL !'.$reqCaleCount.'<br />'.mysqli_error());
		$reqCaleCountAffich = $reqCaleCountResult->fetch();

		if($reqCaleCountAffich[0] >= 1)
			{
				$Lecture.="<div style='width:100%;clear:both;display:block;'>";

				$reqCat = 'SELECT * FROM calendrier_categorie WHERE AA_equimondo_hebeappnum = "'.$_SESSION['hebeappnum'].'" AND calecatetype ="5"';
				$reqCatResult = $ConnexionBdd ->query($reqCat) or die ('Erreur SQL !'.$reqCat.'<br />'.mysqli_error());
				while($reqCatAffich = $reqCatResult->fetch())
					{
						$Lecture.="<div style='float:left;margin-right:10px;'>";
						$Lecture.="<table class='tab_rubrique'>";
						$Lecture.="<tr style='background-color:rgba(0, 144, 255, 1);
						border-style:solid;
						border-width: 1;
						border-color:#09A0F4;
						color:white;
						font-size:34px;padding:10px;'>";
						$Lecture.="<td colspan='3'>".$reqCatAffich['calecatelibe']."</td>";
						$Lecture.="</tr>";
						$reqChev = 'SELECT calendrier_participants.chevaux_chevnum,utilisateurs_utilnum,caletext2,caleparttext2 FROM calendrier,calendrier_participants WHERE calendrier_calenum = calenum AND calendrier_categorie_calecatenum = "'.$reqCatAffich['calecatenum'].'" AND caledate1 BETWEEN "'.$date.' 00:00:00" AND "'.$date.' 23:59:59" AND calendrier.AA_equimondo_hebeappnum = "'.$_SESSION['hebeappnum'].'"';
						$reqChevResult = $ConnexionBdd ->query($reqChev) or die ('Erreur SQL !'.$reqChev.'<br />'.mysqli_error());
						while($reqChevAffich = $reqChevResult->fetch())
							{
								$Lecture.="<tr>";
									$Lecture.="<td>".ChevLect($reqChevAffich[0],$ConnexionBdd)."</td>";
									$Lecture.="<td>".UtilLect($reqChevAffich['utilisateurs_utilnum'],$ConnexionBdd)."</td>";
									$Lecture.="<td>".$reqChevAffich['caleparttext2']."</td>";
								$Lecture.="</tr>";
							}
						$Lecture.="</table>";
						$Lecture.="</div>";
					}
				$Lecture.="</div>";

				$Lecture.="<div style='height:20px;width:100%;clear:both;display:block;'></div>";
			}
		//****************************************************************************************************************

		if($req1Affich[0] == 0) {$Lecture.="<div class='InfoStandard FormInfoStandard1'><center><img src='".$Dossier."images/informationBlanc.png' class='imgSousMenu1' style='margin-right:10px;'>".$_SESSION['STrad741']." ".formatdatemysql($date)."</center></div>";}

		else if($_SESSION['authconfigaffichfichmontoir'] == 3)
			{
				$Lecture.="<table class='tab_rubrique' style='width:100%;'>";
				// AFFICHE LES HEURES DES REPRISES
				$Lecture.="<thead><tr>";
					$Lecture.="<td>".$_SESSION['STrad290']."</td>";
					$Lecture.="<td>".$_SESSION['STrad766']."</td>";
					if($_GET['Impression'] == 2) {$Lecture.="<td>".$_SESSION['STrad767']."</td>";}
					$Lecture.="<td>".$_SESSION['STrad768']."</td>";
					$Lecture.="<td>".$_SESSION['STrad769']."</td>";
				$Lecture.="</tr></thead>";

				$Lecture.="<tbody>";
				/*
				$req1 = 'SELECT DATE_FORMAT(caledate1, "%Hh%i" ) AS heure FROM calendrier,calendrier_categorie';
				if($_SESSION['conflogcaleutilacces'] == 1 AND $_SESSION['modconfiguration'] == 1) {$req1.=',utilisateurs';}
				$req1.=' WHERE calendrier_categorie_calecatenum = calecatenum AND calecatetype = "1" AND caledate1 BETWEEN "'.$date.' 00:00:00" AND "'.$date.' 23:59:59" AND calendrier.AA_equimondo_hebeappnum = "'.$_SESSION['hebeappnum'].'"';
				if($_SESSION['conflogcaleutilacces'] == 1 AND $_SESSION['modconfiguration'] == 1) {$req1.=' AND utilisateurs_utilnum = utilnum AND utilnum = "'.$_SESSION['connauthnum'].'"';}
				$req1.=' GROUP BY heure ORDER BY heure ASC';
				*/
				$req1 = 'SELECT * FROM calendrier,calendrier_categorie';
				if($_SESSION['conflogcaleutilacces'] == 1 AND $_SESSION['modconfiguration'] == 1) {$req1.=',utilisateurs';}
				$req1.=' WHERE calendrier_categorie_calecatenum = calecatenum AND calecatetype = "1" AND caledate1 BETWEEN "'.$date.' 00:00:00" AND "'.$date.' 23:59:59" AND calendrier.AA_equimondo_hebeappnum = "'.$_SESSION['hebeappnum'].'"';
				if($_SESSION['conflogcaleutilacces'] == 1 AND $_SESSION['modconfiguration'] == 1) {$req1.=' AND utilisateurs_utilnum = utilnum AND utilnum = "'.$_SESSION['connauthnum'].'"';}
				if(!empty($_SESSION['calecatenum'])) {$req1.=' AND calendrier_categorie_calecatenum = "'.$_SESSION['calecatenum'].'"';}
				$req1.=' GROUP BY calenum ORDER BY caledate1 ASC';
				$req1Result = $ConnexionBdd ->query($req1) or die ('Erreur SQL !'.$req1.'<br />'.mysqli_error());
				while($req1Affich = $req1Result->fetch())
					{
						$CalcHeure = formatheure1($req1Affich['caledate1']);
						if($_GET['Impression'] != 2) {$Lien = "<a href='".$Dossier."modules/calendrier/modcalefichcomplet.php?calenum=".$req1Affich['calenum']."' class='LoadPage AfficheCaleFichComplet'>";}

						$Lecture.="<tr>";

						// HEURE
						$Lecture.="<td>";
						if(!empty($Lien)) {$Lecture.=$Lien;}
						$Lecture.=$CalcHeure[0].":".$CalcHeure[1]." ".$req1Affich['calecatelibe'];
						if(!empty($Lien)) {$Lecture.="</a>";}
						$Lecture.="</td>";

						// CAVALIERS
						$Lecture.="<td>";
						$req2 = 'SELECT * FROM calendrier_participants,clients WHERE clients_clienum = clienum AND calendrier_calenum = "'.$req1Affich['calenum'].'" ORDER BY clienom ASC';
						$req2Result = $ConnexionBdd ->query($req2) or die ('Erreur SQL !'.$req2.'<br />'.mysqli_error());
						while($req2Affich = $req2Result->fetch())
							{
								$Lecture.="<div style='width:100%;clear:both;display:block;color:white;'>";
								if($_GET['Impression'] != 2) {$Lecture.="<a href='".$Dossier."modules/profil/modprofilfichcomplet1.php?clienum=".$req2Affich['clients_clienum']."&AfficheFenetre=2' class='LoadPage AfficheFicheProfil1'><div style='width:30%;float:left;'>";}
								$Lecture.=ClieLect($req2Affich['clients_clienum'],$ConnexionBdd);
								if($_GET['Impression'] != 2) {$Lecture.="</div></a>";}

								if($_GET['Impression'] != 2)
									{
										$Lecture.="<div style='width:30%;float:left;'>";
										$_SESSION['NumExecPrest'] = $_SESSION['NumExecPrest'] + 1;
										$Lecture.="<select name='chevnum' class='champ_barre' onchange='CalePartChevnumSelect".$_SESSION['NumExecPrest']."(this.value)'>".ChevSelect($Dossier,$ConnexionBdd,$req2Affich['chevaux_chevnum'],$req2Affich['clients_clienum'],2,$req2Affich['calepartnum'])."</select>";
										$Lecture.="<div id='DivCalePartChevnumSelect".$_SESSION['NumExecPrest']."'></div>";
										$Lecture.="</div>";

										// NOMBRE D'HEURE ï¿½ DEBITER
										$Lecture.="<div style='width:30%;float:left;'>";
										$Lecture.="<select name='calepartnbdebit' class='champ_barre' onchange='CalePartNbDebitSelect".$_SESSION['NumExecPrest']."(this.value)'>".DureeRepriseDebit($req2Affich['calepartnbdebit'],$req2Affich['calepartnum'])."</select>";
										$Lecture.="</div>";

										// SUPRIMER CAVALIER VERSION PC
										if($req1Affich['caletext5'] == 1 AND $_GET['Impression'] != 2 AND $_SESSION['ResolutionConnexion1'] >= 800) {$Lecture.="<div style='width:10%;float:left;'><a href='".$Dossier."modules/calendrier/modcaleMontoirpartsupp.php?calepartnum=".$req2Affich['calepartnum']."&date=".$date."' class='LoadPage CaleMontoirCavaSupp' style='float:right;'><img src='".$Dossier."images/supprimer.png' class='ImgSousMenu2'></a></div>";}
									}
								$Lecture.="</div>";
							}
						$Lecture.="</td>";

						// CHEVAUX
						if($_GET['Impression'] == 2)
							{
								$Lecture.="<td>";
								$req2 = 'SELECT * FROM calendrier_participants WHERE calendrier_calenum = "'.$req1Affich['calenum'].'"';
								$req2Result = $ConnexionBdd ->query($req2) or die ('Erreur SQL !'.$req2.'<br />'.mysqli_error());
								while($req2Affich = $req2Result->fetch())
									{
										$Lecture.=ChevLect($req2Affich['chevaux_chevnum'],$ConnexionBdd)."<br>";
									}
								$Lecture.="</td>";
							}

						// SEANCE
						$Lecture.="<td>";
							if(!empty($Lien)) {$Lecture.=$Lien;}
							$Lecture.=RdvLibelle($req1Affich['calenum'],$ConnexionBdd);
							if(!empty($Lien)) {$Lecture.="</a>";}
						$Lecture.="</td>";

						// UTILISATEURS
						$Lecture.="<td>";
							if(!empty($Lien)) {$Lecture.=$Lien;}
							$Lecture.=UtilLect($req1Affich['utilisateurs_utilnum'],$ConnexionBdd);
							if(!empty($Lien)) {$Lecture.="</a>";}
						$Lecture.="</td>";

						$Lecture.="</tr>";
					}
				$Lecture.="</tbody>";

				$Lecture.="</table>";
			}
		else if($_SESSION['authconfigaffichfichmontoir'] == 2)
			{
				$_SESSION['NumExecPrest'] = 0;

				$Lecture.="<table class='tab_rubrique'>";
				// AFFICHE LES HEURES DES REPRISES
				$Lecture.="<thead><tr><td></td>";
				$req1 = 'SELECT DATE_FORMAT(caledate1, "%Hh%i" ) AS heure,count(calenum) FROM calendrier,calendrier_categorie';
				if($_SESSION['conflogcaleutilacces'] == 1 AND $_SESSION['modconfiguration'] == 1) {$req1.=',utilisateurs';}
				$req1.=' WHERE calendrier_categorie_calecatenum = calecatenum AND calecatetype = "1" AND caledate1 BETWEEN "'.$date.' 00:00:00" AND "'.$date.' 23:59:59" AND calendrier.AA_equimondo_hebeappnum = "'.$_SESSION['hebeappnum'].'"';
				if($_SESSION['conflogcaleutilacces'] == 1 AND $_SESSION['modconfiguration'] == 1) {$req1.=' AND utilisateurs_utilnum = utilnum AND utilnum = "'.$_SESSION['connauthnum'].'"';}
				if(!empty($_SESSION['calecatenum'])) {$req1.=' AND calendrier_categorie_calecatenum = "'.$_SESSION['calecatenum'].'"';}
				$req1.=' GROUP BY heure ORDER BY heure ASC';
				$req1Result = $ConnexionBdd ->query($req1) or die ('Erreur SQL !'.$req1.'<br />'.mysqli_error());
				while($req1Affich = $req1Result->fetch())
					{
						$Lecture.="<td colspan='".$req1Affich[1]."'>".$req1Affich[0]."</td>";
					}
				$Lecture.="</tr></thead>";


				// AFFICHE LES MONITEURS
				$Lecture.="<tr><td></td>";
				$req1 = 'SELECT * FROM calendrier,utilisateurs,calendrier_categorie WHERE utilisateurs_utilnum = utilnum AND 	calendrier_categorie_calecatenum = calecatenum';
				if($_SESSION['conflogcaleutilacces'] == 1 AND $_SESSION['modconfiguration'] == 1) {$req1.=' AND utilnum = "'.$_SESSION['connauthnum'].'"';}
				$req1.=' AND 	calecatetype = "1" AND caledate1 BETWEEN "'.$date.' 00:00:00" AND "'.$date.' 23:59:59" AND calendrier.AA_equimondo_hebeappnum = "'.$_SESSION['hebeappnum'].'"';
				if(!empty($_SESSION['calecatenum'])) {$req1.=' AND calendrier_categorie_calecatenum = "'.$_SESSION['calecatenum'].'"';}
				$req1.=' ORDER BY caledate1 ASC';
				$req1Result = $ConnexionBdd ->query($req1) or die ('Erreur SQL !'.$req1.'<br />'.mysqli_error());
				while($req1Affich = $req1Result->fetch())
					{
						$RDVCOLOR = RdvColor($req1Affich['calenum'],$ConnexionBdd);
						$Lecture.="<td style='background-color:".$RDVCOLOR.";'>";
						$Lecture.="<a hre<a href='".$Dossier."modules/calendrier/modcalefichcomplet.php?calenum=".$req1Affich['calenum']."' class='LoadPage AfficheCaleFichComplet' style='color:white;'>".RdvLibelle($req1Affich['calenum'],$ConnexionBdd)."</a>";
						if($_GET['Impression'] != 2)
							{
								$Lecture.="<a href='".$Dossier."modules/calendrier/modcalepointage.php?calenum=".$reqPlanSelectAffich['calenum']."&date=".$date."' class='LoadPage CalePointage1' style='float:right; margin-left:10px;color:white;'><span class='FichMontoireBoutton' style='color:white;'><img src='".$Dossier."images/pointerBlanc.png' class='ImgSousMenu2'>".$_SESSION['STrad354']."</span></a>";
								$Lecture.="<a href='".$Dossier."modules/calendrier/modcaleMontoirCavaAjou.php?calenum=".$reqPlanSelectAffich['calenum']."&date=".$date."' style='float:right;' class='LoadPage AfficheMontoirCava' style='color:white;'><span class='FichMontoireBoutton' style='color:white;'><img src='".$Dossier."images/ajouterBlanc.png' class='ImgSousMenu2'>".$_SESSION['STrad355']."</span></a>";
							}
						$Lecture.="<br><i style='color:white;'>".$req1Affich['utilprenom']."</i></td>";
					}
				$Lecture.="</tr>";

				// AFFICHE LES CHEVAUX
				$req1 = 'SELECT * FROM chevaux WHERE chevsupp = "1" AND chevaux.AA_equimondo_hebeappnum = "'.$_SESSION['hebeappnum'].'" ORDER BY chevnom ASC';
				$req1Result = $ConnexionBdd ->query($req1) or die ('Erreur SQL !'.$req1.'<br />'.mysqli_error());
				while($req1Affich = $req1Result->fetch())
					{
						$VerifDispo = VerifDispo($req1Affich['chevnum'],$date,$date,null,null,$Dossier,null,$ConnexionBdd);

						if($VerifDispo[3] == 2)
							{
								$Lecture.="<tr>";
								$Lecture.="<td class='ChampBarre15_1'>".$req1Affich['chevnom']."</td>";

								$req2 = 'SELECT * FROM calendrier,utilisateurs,calendrier_categorie WHERE utilisateurs_utilnum = utilnum AND 	calendrier_categorie_calecatenum = calecatenum';
								if($_SESSION['conflogcaleutilacces'] == 1 AND $_SESSION['modconfiguration'] == 1) {$req2.=' AND utilnum = "'.$_SESSION['connauthnum'].'"';}
								$req2.=' AND 	calecatetype = "1" AND caledate1 BETWEEN "'.$date.' 00:00:00" AND "'.$date.' 23:59:59" AND calendrier.AA_equimondo_hebeappnum = "'.$_SESSION['hebeappnum'].'" ORDER BY caledate1 ASC';
								$req2Result = $ConnexionBdd ->query($req2) or die ('Erreur SQL !'.$req2.'<br />'.mysqli_error());
								while($req2Affich = $req2Result->fetch())
									{
										$RDVCOLOR = RdvColor($req2Affich['calenum'],$ConnexionBdd);
										$Lecture.="<td class='ChampBarre15_1' style='background-color:".$RDVCOLOR.";'>";
										if($_GET['Impression'] != 2)
											{
												$_SESSION['NumExecPrest'] = $_SESSION['NumExecPrest'] + 1;
												$Lecture.="<select name='clienum' class='champ_barre' onchange='CalePartClienumSelect".$_SESSION['NumExecPrest']."(this.value)'>".ClieSelect($Dossier,$ConnexionBdd,$clienum,$faminum,$factnum,2,$AjouterClientPassage,$req2Affich['calenum'],$req1Affich['chevnum'],$AfficherAjouCava,$ResponsableLegal,null,2)."</select>";
												$Lecture.="<div id='DivCalePartClienumSelect".$_SESSION['NumExecPrest']."'></div>";

											}
										else
											{
												$req3 = 'SELECT clients_clienum FROM calendrier_participants WHERE calendrier_calenum = "'.$req2Affich['calenum'].'" AND chevaux_chevnum = "'.$req1Affich['chevnum'].'"';
												$req3Result = $ConnexionBdd ->query($req3) or die ('Erreur SQL !'.$req3.'<br />'.mysqli_error());
												$req3Affich = $req3Result->fetch();
												$Lecture.=ClieLect($req3Affich[0],$ConnexionBdd);
											}
										$Lecture.="</td>";
									}
								$Lecture.="</tr>";
							}
					}

				$Lecture.="</table>";
			}
		else if($_SESSION['authconfigaffichfichmontoir'] == 1)
			{
				$iCompt1 = 1;

				$Lecture.="<table class='FicheMontoire' style='width:100%;'>";
				// SELECTION DES INFORMATIONS DE LA REPRISE
				$reqPlanSelect = 'SELECT caletext1,caletext2,caletext3,caletext4,caletext6,utilnom,utilprenom,calenum,caletext5,caledate1,caledate2,caleindice FROM calendrier,utilisateurs,calendrier_categorie WHERE utilisateurs_utilnum=utilnum';
				if($_SESSION['conflogcaleutilacces'] == 1 AND $_SESSION['modconfiguration'] == 1) {$reqPlanSelect.=' AND utilnum = "'.$_SESSION['connauthnum'].'"';}
				$reqPlanSelect.=' AND caledate1 BETWEEN "'.$date.' 00:00:00" AND "'.$date.' 23:59:59" AND calendrier.AA_equimondo_hebeappnum = "'.$_SESSION['hebeappnum'].'" AND calendrier_categorie_calecatenum = calecatenum AND calecatetype = "1"';
				if(!empty($_SESSION['calecatenum'])) {$reqPlanSelect.=' AND calendrier_categorie_calecatenum = "'.$_SESSION['calecatenum'].'"';}
				$reqPlanSelect.=' ORDER BY caledate1 ASC';
				$reqPlanSelectResult = $ConnexionBdd ->query($reqPlanSelect) or die ('Erreur SQL !'.$reqPlanSelect.'<br />'.mysqli_error());
				while($reqPlanSelectAffich = $reqPlanSelectResult->fetch())
					{
						$Lecture.="<span id='Calenum".$reqPlanSelectAffich['calenum']."'></span>";
						$RDVCOLOR = RdvColor($reqPlanSelectAffich['calenum'],$ConnexionBdd);
						$heure = formatheure1($reqPlanSelectAffich['caledate1']);

						if($_GET['Impression'] != 2) {$Lecture.="<thead>";}
						$Lecture.="<tr><td style='background-color:".$RDVCOLOR.";color:white;'><b>";
						if($_GET['Impression'] != 2) {$Lecture.="<a href='".$Dossier."modules/calendrier/modcalefichcomplet.php?calenum=".$reqPlanSelectAffich[7]."' class='LoadPage AfficheCaleFichComplet' style='color:white;'>";}
							$Lecture.="<span class='TitreMontoir2' style='color:white;'>".$heure[0].":".$heure[1]." ".RdvLibelle($reqPlanSelectAffich['calenum'],$ConnexionBdd)."<span class='supp400px supp800px'> - ".$reqPlanSelectAffich[6]."</span></span>";
						if($_GET['Impression'] != 2) {$Lecture.="</a>";}
						if($reqPlanSelectAffich['caletext5'] == 2 AND $_GET['Impression'] != 2) {$Lecture.="<a href='".$Dossier."modules/calendrier/modcaledebitevenement_script.php?calenum=".$reqPlanSelectAffich['calenum']."&crediterpointage=2&date=".$date."' class='LoadPage CaleDebit1' style='float:right;'><img src='".$Dossier."images/CreditBlanc.png' class='ImgSousMenu2'>".$_SESSION['STrad389']."</span></a>";}
						if($reqPlanSelectAffich['caletext5'] == 1 AND $_GET['Impression'] != 2)
							{
								$Lecture.="<a href='".$Dossier."modules/calendrier/modcalepointage.php?calenum=".$reqPlanSelectAffich['calenum']."&date=".$date."' class='LoadPage CalePointage1' style='float:right; margin-left:10px;color:white;'><span class='FichMontoireBoutton' style='color:white;'><img src='".$Dossier."images/pointerBlanc.png' class='ImgSousMenu2'>".$_SESSION['STrad354']."</span></a>";
								$Lecture.="<a href='".$Dossier."modules/calendrier/modcaleMontoirCavaAjou.php?calenum=".$reqPlanSelectAffich['calenum']."&date=".$date."' style='float:right;' class='LoadPage AfficheMontoirCava' style='color:white;'><span class='FichMontoireBoutton' style='color:white;'><img src='".$Dossier."images/ajouterBlanc.png' class='ImgSousMenu2'>".$_SESSION['STrad355']."</span></a>";
							}
						$Lecture.="</b></td></tr>";
						if($_GET['Impression'] != 2) {$Lecture.="</thead>";}

						$Lecture.="<tbody><tr><td style='background-color:".$RDVCOLOR.";'>";

						$Lecture.="<table id='TabNo_col'>";
						// LISTE LES CAVALIERS DE LA REPRISE
						$reqPlanLeco = 'SELECT clienum,clienom,clieprenom,clieville,chevnum,chevnom,chevrobe,calendrier_calenum,calepartnum,caleparttext2,calendrier_participants.chevaux_chevnum,calepartnbdebit,calepartannulerraison FROM calendrier_participants left outer join chevaux on calendrier_participants.chevaux_chevnum=chevaux.chevnum left outer join clients on calendrier_participants.clients_clienum=clients.clienum WHERE calendrier_calenum="'.$reqPlanSelectAffich[7].'"';
						$reqPlanLecoResult = $ConnexionBdd ->query($reqPlanLeco) or die ('Erreur SQL !'.$reqPlanLeco.'<br />'.mysqli_error());
						while($reqPlanLecoAffich = $reqPlanLecoResult->fetch())
							{
								//	INFORMATION CLIENT
								$Lecture.="<tr>";
								$Lecture.="<td style='color:white;'>";
									if($_GET['Impression'] != 2) {$Lecture.="<a href='".$Dossier."modules/profil/modprofilfichcomplet1.php?clienum=".$reqPlanLecoAffich['clienum']."&AfficheFenetre=2' class='LoadPage AfficheFicheProfil1' style='color:white;'>";}
										$Lecture.=ClieLect($reqPlanLecoAffich['clienum'],$ConnexionBdd);
									if($_GET['Impression'] != 2) {$Lecture.="</a>";}
									$Lecture.="<span style='margin-right:20px;'></span>";
								$Lecture.="</td>";

								if($_SESSION['conflogvisionheurerestante'] == 2)
									{
										$NbHeure = CalcNbHeureForfValide($reqPlanLecoAffich[0],null,null,$ConnexionBdd);
										if($NbHeure[2] <= 180) {$Alerte = "orange";}
										if($NbHeure[2] < 0) {$Alerte = "red";}
										if($NbHeure[2] > 180) {$Alerte = "";}
										$Lecture.="<td style='background:".$Alerte.";'>";
											if($_GET['Impression'] != 2) {$Lecture.="<a href='".$Dossier."modules/clients/modcliefichcomplet.php?clienum=".$reqPlanLecoAffich[0]."'>";}
												$Lecture.=$NbHeure[0];
											if($_GET['Impression'] != 2) {$Lecture.="</a>";}
											$Lecture.="<span style='margin-right:20px;'></span>";
											// SUPPRIMER CAVALIER VERSION SMARTPONE
											if($reqPlanSelectAffich['caletext5'] == 1 AND $_GET['Impression'] != 2 AND $_SESSION['ResolutionConnexion1'] < 800) {$Lecture.="<td><a href='".$Dossier."modules/calendrier/modcaleMontoirpartsupp.php?calepartnum=".$reqPlanLecoAffich[8]."&date=".$date."' class='LoadPage CaleMontoirCavaSupp' style='float:right;'><img src='".$Dossier."images/supprimerBlanc.png' class='ImgSousMenu2'></a></td>";}

										$Lecture.="</td>";
									}

								if($_SESSION['ResolutionConnexion1'] < 800) {$Lecture.="<tr>";}
								// AJOUTER UN CHEVAL
								$Lecture.="<td>";
								if($_GET['Impression'] != 2)
									{
										$_SESSION['NumExecPrest'] = $_SESSION['NumExecPrest'] + 1;
										$Lecture.="<select name='chevnum' class='champ_barre' onchange='CalePartChevnumSelect".$_SESSION['NumExecPrest']."(this.value)'>".ChevSelect($Dossier,$ConnexionBdd,$reqPlanLecoAffich[10],$reqPlanLecoAffich['clienum'],2,$reqPlanLecoAffich['calepartnum'])."</select>";
										$Lecture.="<div id='DivCalePartChevnumSelect".$_SESSION['NumExecPrest']."'></div>";
									}
								else
									{
										if(empty($reqPlanLecoAffich['chevnum'])) {$Lecture.="<span style='font-style:italic;'>".$_SESSION['STrad353']."</span>";}
										else {$Lecture.=ChevLect($reqPlanLecoAffich['chevnum'],$ConnexionBdd);}
									}
								$Lecture.="<span style='margin-right:20px;'></span>";
								$Lecture.="</td>";

								// ATTRIBUER UN STATUS
								$Lecture.="<td>";
									$_SESSION['NumExecPrest'] = $_SESSION['NumExecPrest'] + 1;
									if($_GET['Impression'] == 2) {if(empty($reqPlanLecoAffich['caleparttext2'])) {$reqPlanLecoAffich['caleparttext2'] = 3;}$Lecture.=ReprisePresenceLect($reqPlanLecoAffich['caleparttext2']);}
									else if($reqPlanSelectAffich['caletext5'] == 1) {$Lecture.="<select name='caleparttext2' class='champ_barre' onchange='CalePartText2Select".$_SESSION['NumExecPrest']."(this.value)'>".ReprisePresenceSelect($reqPlanLecoAffich['caleparttext2'],$reqPlanLecoAffich['calepartnum'])."</select>";}
									else if($reqPlanSelectAffich['caletext5'] == 2) {$Lecture.="<span style='color:white;'>".ReprisePresenceLect($reqPlanLecoAffich['caleparttext2'])."</span>";}
									$Lecture.="<span style='margin-right:20px;'></span>";
								$Lecture.="</td>";
								if($_SESSION['ResolutionConnexion1'] < 800) {$Lecture.="</tr>";}

								// NOMBRE D'HEURE ï¿½ DEBITER
								if($_GET['Impression'] != 2)
									{
										$Lecture.="<td><select name='calepartnbdebit' class='champ_barre' onchange='CalePartNbDebitSelect".$_SESSION['NumExecPrest']."(this.value)'>".DureeRepriseDebit($reqPlanLecoAffich['calepartnbdebit'],$reqPlanLecoAffich['calepartnum'])."</select></td>";
									}
								// SUPPRIMER CAVALIER VERSION PC
								if($reqPlanSelectAffich['caletext5'] == 1 AND $_GET['Impression'] != 2 AND $_SESSION['ResolutionConnexion1'] >= 800) {$Lecture.="<td><a href='".$Dossier."modules/calendrier/modcaleMontoirpartsupp.php?calepartnum=".$reqPlanLecoAffich[8]."&date=".$date."' class='LoadPage CaleMontoirCavaSupp' style='float:right;'><img src='".$Dossier."images/supprimerBlanc.png' class='ImgSousMenu2'></a></td>";}

								$Lecture.="</tr>";

								// AFFICHE RAISON DU REFUS
								if($reqPlanLecoAffich['caleparttext2'] == 7 AND !empty($reqPlanLecoAffich['calepartannulerraison']) AND $_GET['Impression'] != 2)
									{
										$Lecture.="<tr>";
											$Lecture.="<td colspan='3'><div style='float:right;vertical-align:middle;'>".$_SESSION['STrad784']." :</div></td>";
											$Lecture.="<td colspan='3'><div style='vertical-align:middle;font-style:italic;'>".nl2br($reqPlanLecoAffich['calepartannulerraison'])."</div></td>";
										$Lecture.="</tr>";
									}

								$iCompt1 = $iCompt1 + 1;
							}
						$Lecture.="</table>";

						$Lecture.="</td></tr></tbody>";
						$Lecture.="<tr style='height:15px;'></tr>";
					}
				$Lecture.="</table>";
				// *******************************************************************************************
			}

		return $Lecture;
	}
//*****************************************************************************************************************************

//****************** INDICATEUR CALENDRIER ************************
function CalendrierLect($ind,$prefixe)
	{
		if($ind == 1){if($prefixe == 2) {$Lecture.=$_SESSION['STrad182']." ";} $Lecture.= $_SESSION['STrad184'];}
		else if($ind == 2){if($prefixe == 2) {$Lecture.=$_SESSION['STrad183']." ";}$Lecture.= $_SESSION['STrad185'];}
		else if($ind == 3){if($prefixe == 2) {$Lecture.=$_SESSION['STrad183']." ";}$Lecture.= $_SESSION['STrad186'];}
		else if($ind == 4){if($prefixe == 2) {$Lecture.=$_SESSION['STrad183']." ";}$Lecture.= $_SESSION['STrad187'];}
		else if($ind == 5){if($prefixe == 2) {$Lecture.=$_SESSION['STrad182']." ";}$Lecture.= $_SESSION['STrad188'];}
		else if($ind == 6){$Lecture.= $_SESSION['STrad189'];}
		else if($ind == 11){if($prefixe == 2) {$Lecture.=$_SESSION['STrad183']." ";}$Lecture.= $_SESSION['STrad190'];}
		else if($ind == 14){if($prefixe == 2) {$Lecture.=$_SESSION['STrad182']." ";}$Lecture.= $_SESSION['STrad191'];}

		return $Lecture;
	}
//***********************************************************************************/

//***************************************** COULEUR POUR LE RENDEZ VOUS ***********************************************
function RdvColor($calenum,$ConnexionBdd,$utilnum)
	{
		if(!empty($calenum))
			{
				$reqUtil = 'SELECT utilcolor,caleindice,caletext3 FROM calendrier left outer join utilisateurs on utilisateurs_utilnum = utilnum WHERE calenum = "'.$calenum.'"';
				$reqUtilResult = $ConnexionBdd ->query($reqUtil) or die ('Erreur SQL !'.$reqUtil.'<br />'.mysqli_error());
				$reqUtilAffich = $reqUtilResult->fetch();
				if(!empty($reqUtilAffich[0])) {$RDVCOLOR = $reqUtilAffich[0];} else {$RDVCOLOR = "#2080e1";}
				if($reqUtilAffich['caleindice'] == 4 AND $reqUtilAffich['caletext3'] == 2) {$RDVCOLOR = "red";} else if($reqUtilAffich['caleindice'] == 4) {$RDVCOLOR = "#2080e1";}
			}
		else if(!empty($utilnum))
			{
				$reqUtil = 'SELECT utilcolor FROM utilisateurs WHERE utilnum = "'.$utilnum.'"';
				$reqUtilResult = $ConnexionBdd ->query($reqUtil) or die ('Erreur SQL !'.$reqUtil.'<br />'.mysqli_error());
				$reqUtilAffich = $reqUtilResult->fetch();
				$RDVCOLOR = $reqUtilAffich['utilcolor'];
			}
		return $RDVCOLOR;
	}
//*****************************************************************************************************************************


//******************* VERIF SI CHEVAL DE DISPO **********************************
function VerifDispo($chevnum,$date1,$date2,$clienum,$utilnum,$Dossier,$niveau,$ConnexionBdd)
	{
		$Dispo = 2;
		$IndispoSante = 2;

		// VERIF SI PAS DEJA PRIS DANS UNE INDISPONIBILITE
		$req1 = 'SELECT count(disponum),disporaison FROM disponibilite';
		$req1.=' WHERE ((dispodate1 <= "'.$date1.'" AND dispodate2 >= "'.$date2.'") OR dispodate1 BETWEEN "'.$date1.'" AND "'.$date2.'" OR dispodate2 BETWEEN "'.$date1.'" AND "'.$date2.'")';
		if(!empty($chevnum)) {$req1.=' AND chevaux_chevnum = "'.$chevnum.'"';}
		if(!empty($clienum)) {$req1.=' AND clients_clienum = "'.$clienum.'"';}
		if(!empty($utilnum)) {$req1.=' AND utilisateurs_utilnum = "'.$utilnum.'"';}
		$req1Result = $ConnexionBdd ->query($req1) or die ('Erreur SQL !'.$req1.'<br />'.mysqli_error());
		$req1Affich = $req1Result->fetch();
		if($req1Affich[0] >= 1) {$IndispoSante = 1;$Raison.=$_SESSION['STrad691']." : <b>".$req1Affich[1]."</b><br>";$Dispo = 1;$RaisonCourt = $req1Affich[1];}

		// VERIF QUE LE CHEVAL N'A PAS ATTEINT SON NOMBRE D'HEURE LIMITE
		if(!empty($chevnum))
		{
		$req1 = 'SELECT chevnom,chevnbheure,chevnbheureperiode FROM chevaux WHERE chevnum = "'.$chevnum.'"';
		$req1Result = $ConnexionBdd ->query($req1) or die ('Erreur SQL !'.$req1.'<br />'.mysqli_error());
		$req1Affich = $req1Result->fetch();
		if(!empty($req1Affich[1]) AND !empty($req1Affich[2]))
			{
				$nbHeureMaxi = $req1Affich[1] * 60;
				// PAR JOUR
				if($req1Affich[2] == 6)
					{
						$date2Modif = formatheure1($date2);
						$jour1Select = debutsem1($date2Modif[3],$date2Modif[4],$date2Modif[5]);
						$jour1 = $date2Modif[3]."-".$date2Modif[4]."-".$date2Modif[5].' 00:00:00';
						$jour2 = $date2Modif[3]."-".$date2Modif[4]."-".$date2Modif[5].' 23:59:59';
					}

				// PAR SEMAINE
				if($req1Affich[2] == 5)
					{
						$date2Modif = formatheure1($date2);
						$jour1Select = debutsem1($date2Modif[3],$date2Modif[4],$date2Modif[5]);
						$jour1 = $jour1Select[2].' 00:00:00';
						$jour2Select = formatdatemysqlselect($jour1Select[2]);
						$jour2 = date("Y-m-d 23:59:59",mktime(0,0,0, $jour2Select[1],$jour2Select[0] + 6, $jour2Select[2]));
					}
				// PAR MOIS
				if($req1Affich[2] == 1)
					{
						$date2Modif = formatheure1($date2);
						$jour1 = date("Y-m-01 00:00:00",mktime(0,0,0, $date2Modif[4],$date2Modif[5], $date2Modif[3]));
						$jour2 = date("Y-m-31 23:59:59",mktime(0,0,0, $date2Modif[4],$date2Modif[5], $date2Modif[3]));
					}
				// PAR TRIMESTRE
				if($req1Affich[2] == 2)
					{
						$date2Modif = formatheure1($date2);
						$jour1 = date("Y-m-d 00:00:00",mktime(0,0,0, $date2Modif[4] - 4,$date2Modif[5], $date2Modif[3]));
						$jour2 = $date2.' 23:59:59';
					}
				// PAR SEMESTRE
				if($req1Affich[2] == 3)
					{
						$date2Modif = formatheure1($date2);
						$jour1 = date("Y-m-d 00:00:00",mktime(0,0,0, $date2Modif[4] - 6,$date2Modif[5], $date2Modif[3]));
						$jour2 = $date2.' 23:59:59';
					}
				// PAR AN
				if($req1Affich[2] == 4)
					{
						$date2Modif = formatheure1($date2);
						$jour1 = date("Y-m-d 00:00:00",mktime(0,0,0, $date2Modif[4],$date2Modif[5], $date2Modif[3] - 1));
						$jour2 = $date2.' 23:59:59';
					}
				$req2 = 'SELECT sum(caletext1) FROM calendrier,calendrier_participants,calendrier_categorie WHERE calendrier_calenum = calenum AND calendrier_categorie_calecatenum = calecatenum AND calecatetype ="1" AND calendrier_participants.chevaux_chevnum = "'.$chevnum.'" AND caledate1 BETWEEN "'.$jour1.'" AND "'.$jour2.'"';
				$req2Result = $ConnexionBdd ->query($req2) or die ('Erreur SQL !'.$req2.'<br />'.mysqli_error());
				$req2Affich = $req2Result->fetch();
				if($req2Affich[0] >= $nbHeureMaxi) {$Raison.=$req1Affich[0]." ".$_SESSION['STrad689'];$Dispo = 1;$RaisonCourt = $_SESSION['STrad690'];}
			}

		// VERIF SI PAS DEJA PRIS DANS UN RENDEZ VOUS
		//$req1 = 'SELECT count(calepartnum),calenum,caleindice,caledate1 FROM calendrier,calendrier_participants WHERE calendrier_calenum = calenum AND ((caledate1 <= "'.$date1.'" AND caledate2 >= "'.$date2.'") OR caledate1 BETWEEN "'.$date1.'" AND "'.$date2.'" OR caledate2 BETWEEN "'.$date1.'" AND "'.$date2.'") AND calendrier_participants.chevaux_chevnum = "'.$chevnum.'"';
		$req1 = 'SELECT count(calepartnum),calenum,caleindice,caledate1 FROM calendrier,calendrier_participants,calendrier_categorie WHERE calendrier_calenum = calenum AND calendrier_categorie_calecatenum = calecatenum AND calecatetype ="1"';
		$req1.= ' AND ((caledate1 <= "$date1" AND caledate2 >= "$date2") OR caledate1 BETWEEN "'.$date1.'" AND "'.$date2.'" OR caledate2 BETWEEN "'.$date1.'" AND "'.$date2.'")';
		$req1.= ' AND calendrier_participants.chevaux_chevnum = "'.$chevnum.'"';

		$req1Result = $ConnexionBdd ->query($req1) or die ('Erreur SQL !'.$req1.'<br />'.mysqli_error());
		$req1Affich = $req1Result->fetch();
		$CalcDate1=formatheure1($date1);
		if($req1Affich[0] >= 1) {$Raison.=ChevLect($chevnum,$ConnexionBdd)." ".$_SESSION['STrad687']." <a href='".$Dossier."modules/calendrier/modcalefichcomplet.php?calenum=".$req1Affich[1]."' class='LoadPage AfficheCaleFichComplet'>".CalendrierLect($req1Affich[2],2)." ".FormatDateTimeMySql($req1Affich['caledate1'])."</a><br>";$Dispo = 1;$RaisonCourt = $_SESSION['STrad688'];}

		// VERIF NIVEAU DU CAVALIER ET CHEVAL
		if(!empty($niveau))
			{
				$req2 = 'SELECT chevniveau'.$niveau.',chevnom FROM chevaux WHERE chevnum = "'.$chevnum.'"';
				$req2Result = $ConnexionBdd ->query($req2) or die ('Erreur SQL !'.$req2.'<br />'.mysqli_error());
				$req2Affich = $req2Result->fetch();

				if($req2Affich[0] != 2) {$Raison.=$_SESSION['STrad685'];$Dispo = 1;$RaisonCourt = $_SESSION['STrad686'];}
			}
		}

		return array ($Dispo,$Raison,$RaisonCourt,$IndispoSante);
	}
//***********************************************************************************

//***************************************** LIBELLE POUR LE RENDEZ VOUS ***********************************************
function RdvLibelle($calenum,$ConnexionBdd)
	{
		$req2 = 'SELECT caletext6,caletext3,caletext4,caletext13,caleindice,caletext1,calendrier_categorie_calecatenum FROM calendrier WHERE calenum = "'.$calenum.'"';
		$req2Result = $ConnexionBdd ->query($req2) or die ('Erreur SQL !'.$req2.'<br />'.mysqli_error());
		$req2Affich = $req2Result->fetch();

		$reqCate = 'SELECT * FROM calendrier_categorie WHERE calecatenum = "'.$req2Affich['calendrier_categorie_calecatenum'].'"';
		$reqCateResult = $ConnexionBdd ->query($reqCate) or die ('Erreur SQL !'.$reqCate.'<br />'.mysqli_error());
		$reqCateAffich = $reqCateResult->fetch();

		if($reqCateAffich['calecatetype'] == 1)
			{
				$req1 = 'SELECT planlecomodlibe FROM planning_modele_calendrier,planning_lecon_modele,calendrier WHERE calendrier_calenum = calenum AND planning_lecon_modele_planlecomodnum = planlecomodnum AND calendrier_calenum = "'.$calenum.'"';
				$req1Result = $ConnexionBdd ->query($req1) or die ('Erreur SQL !'.$req1.'<br />'.mysqli_error());
				$req1Affich = $req1Result->fetch();

				if(!empty($req2Affich['caletext13'])) {$Lecture.=$req2Affich['caletext13'];}
				else if(!empty($req1Affich[0])) {$Lecture.=$req1Affich[0];}
				else {$Lecture.=$reqCateAffich['calecatelibe'];}
			}
		else if(($reqCateAffich['calecatetype'] == 2 OR $reqCateAffich['calecatetype'] == 3) AND !empty($req2Affich['caletext13']))
			{
				$Lecture.=$req2Affich['caletext13'];
			}
		else if($reqCateAffich['calecatetype'] == 4)
			{
				$Lecture.=$reqCateAffich['calecatelibe'];

				$req1 = 'SELECT count(calepartnum) FROM calendrier_participants WHERE calendrier_calenum = "'.$calenum.'"';
				$req1Result = $ConnexionBdd ->query($req1) or die ('Erreur SQL !'.$req1.'<br />'.mysqli_error());
				$req1Affich = $req1Result->fetch();
				if($req1Affich[0] == 1) {$Lecture.=" <i>(".$req1Affich[0]." ".$_SESSION['STrad683'].")</i>";}
				if($req1Affich[0] >= 2) {$Lecture.=" <i>(".$req1Affich[0]." ".$_SESSION['STrad684'].")</i>";}
			}
		else if($reqCateAffich['calecatetype'] == 5)
			{
				$Lecture.=$reqCateAffich['calecatelibe'];

				$req1 = 'SELECT count(calepartnum) FROM calendrier_participants WHERE calendrier_calenum = "'.$calenum.'"';
				$req1Result = $ConnexionBdd ->query($req1) or die ('Erreur SQL !'.$req1.'<br />'.mysqli_error());
				$req1Affich = $req1Result->fetch();
				if($req1Affich[0] == 1) {$Lecture.=" <i>(".$req1Affich[0]." ".$_SESSION['STrad683'].")</i>";}
				if($req1Affich[0] >= 2) {$Lecture.=" <i>(".$req1Affich[0]." ".$_SESSION['STrad684'].")</i>";}
			}
		else if(!empty($req2Affich['caletext13']))
			{
				$Lecture.=$req2Affich['caletext13'];
			}
		else
			{
				$Lecture.=$reqCateAffich['calecatelibe'];
			}

		//$Resolution = ResolutionEcran();
		//if($Resolution[0] <= "800") {$Lecture.="-".$Resolution[0];}

		//if($Resolution[0] < 800) {$LectureConf = substr($Lecture, 0, 10);}
		//else {$LectureConf = $Lecture;}

		return $Lecture;
	}
//*****************************************************************************************************************************


//***************** PRï¿½SENCE POUR LES CAVALIERS D'UNE REPRISE ******************
function ReprisePresenceSelect($ind,$calepartnum)
	{
		$Lecture="<option value='3";if(!empty($calepartnum)) {$Lecture.="|".$calepartnum;} $Lecture.="'";if($ind == 3) {$Lecture.=" selected";} $Lecture.=">".$_SESSION['STrad677']."</option>";
		$Lecture.="<option value='1";if(!empty($calepartnum)) {$Lecture.="|".$calepartnum;} $Lecture.="'"; if($ind == 1) {$Lecture.=" selected";} $Lecture.=">".$_SESSION['STrad678']."</option>";
		$Lecture.="<option value='2";if(!empty($calepartnum)) {$Lecture.="|".$calepartnum;} $Lecture.="'"; if($ind == 2) {$Lecture.=" selected";} $Lecture.=">".$_SESSION['STrad679']."</option>";
		$Lecture.="<option value='4";if(!empty($calepartnum)) {$Lecture.="|".$calepartnum;} $Lecture.="'"; if($ind == 4) {$Lecture.=" selected";} $Lecture.=">".$_SESSION['STrad680']."</option>";
		$Lecture.="<option value='5";if(!empty($calepartnum)) {$Lecture.="|".$calepartnum;} $Lecture.="'"; if($ind == 5) {$Lecture.=" selected";} $Lecture.=">".$_SESSION['STrad681']."</option>";
		$Lecture.="<option value='6";if(!empty($calepartnum)) {$Lecture.="|".$calepartnum;} $Lecture.="'"; if($ind == 6) {$Lecture.=" selected";} $Lecture.=">".$_SESSION['STrad682']."</option>";
		$Lecture.="<option value='7";if(!empty($calepartnum)) {$Lecture.="|".$calepartnum;} $Lecture.="'"; if($ind == 7) {$Lecture.=" selected";} $Lecture.=">".$_SESSION['STrad783']."</option>";

		return $Lecture;
	}
function ReprisePresenceLect($ind,$alerte)
	{
		if($ind == 1) {if($alerte == 2) {$Lecture.="<b style=color:red;>";} $Lecture.=$_SESSION['STrad678'];if($alerte == 2) {$Lecture.="</b>";}}
		if($ind == 2) {if($alerte == 2) {$Lecture.="<b style=color:red;>";} $Lecture.=$_SESSION['STrad679'];if($alerte == 2) {$Lecture.="</b>";}}
		if($ind == 3) {if($alerte == 2) {$Lecture.="<b style=color:green;>";}$Lecture.=$_SESSION['STrad677'];if($alerte == 2) {$Lecture.="</b>";}}
		if($ind == 4) {if($alerte == 2) {$Lecture.="<b style=color:red;>";}$Lecture.=$_SESSION['STrad680'];if($alerte == 2) {$Lecture.="</b>";}}
		if($ind == 5) {if($alerte == 2) {$Lecture.="<b style=color:red;>";}$Lecture.=$_SESSION['STrad681'];if($alerte == 2) {$Lecture.="</b>";}}
		if($ind == 6) {if($alerte == 2) {$Lecture.="<b style=color:red;>";}$Lecture.=$_SESSION['STrad682'];if($alerte == 2) {$Lecture.="</b>";}}
		if($ind == 7) {if($alerte == 2) {$Lecture.="<b style=color:red;>";}$Lecture.=$_SESSION['STrad783'];if($alerte == 2) {$Lecture.="</b>";}}

		return $Lecture;
	}
//***************************************************************************************

//************************ TRAVAIL DU NOMBRE D'HEURE DES CHEVAUX ***********************************
function AfficheNbHeureChevaux($Dossier,$ConnexionBdd,$date,$nbjouravant)
	{
		if(empty($date)) {$date = date('Y-m-d');}
		if(!isset($nbjouravant)) {$nbjouravant = 7;}

		$Calcdate = formatheure1($date." 00:00:00");

		$dateCalc = date("Y-m-d",mktime(0,0,0,$Calcdate[4] ,$Calcdate[5] - $nbjouravant,$Calcdate[3]));;

		$Lecture.="<table class='tab_rubrique' style='width:100%;'>";
		$req1 = 'SELECT chevnum,chevnom,SUM(caletext1) AS TOTAL FROM chevaux,calendrier,calendrier_participants,calendrier_categorie WHERE calendrier_categorie_calecatenum = calecatenum AND calendrier_participants.chevaux_chevnum = chevnum AND calendrier_calenum = calenum AND chevsupp = "1" AND calecatetype = "1" AND chevaux.AA_equimondo_hebeappnum = "'.$_SESSION['hebeappnum'].'" AND caledate1 BETWEEN "'.$dateCalc.' 00:00:00" AND "'.$date.' 23:59:59" GROUP BY chevnum ORDER BY TOTAL DESC';
		$req1Result = $ConnexionBdd ->query($req1) or die ('Erreur SQL !'.$req1.'<br />'.mysqli_error());
		while($req1Affich = $req1Result->fetch())
			{
				$Lecture.="<tr>";
					$Lecture.="<td>".$req1Affich['chevnom']."</td>";
					$Lecture.="<td>".minute_vers_heure($req1Affich[2],2)."</td>";
				$Lecture.="</tr>";
			}

		$Lecture.="</table>";

		return $Lecture;
	}
//***************************************************************************************

//***************************** AFFICHE CALENDRIER ******************************
function Calendrier($Dossier,$ConnexionBdd,$caledate1,$modaffiche,$calecatenum,$clienum,$PartageCalendrier)
	{
		if(!empty($_SESSION['CaleMois'])) {$mois = $_SESSION['CaleMois'];} else {$mois = date('m');}
		if(!empty($_SESSION['CaleAnne'])) {$anne = $_SESSION['CaleAnne'];} else {$anne = date('Y');}
		if(!empty($_SESSION['CaleJour'])) {$jour = $_SESSION['CaleJour'];} else {$jour = date('d');}

		if(empty($modaffiche)) {$modaffiche = 2;}

		if($_SESSION['ResolutionConnexion1'] <= 800 AND $PartageCalendrier != 2) {$modaffiche = 4;}

		if(!empty($calecatenum)) {$_SESSION['calecatenum'] = $calecatenum;} else {$calecatenum = "";}

		// RECHERCHER UTILISATEURS
		if(!empty($_GET['utilnum'])) {$utilnum = $_GET['utilnum'];}

		// DISCIPLINES
		if ($_GET['disciplines'] == TRUE)
			{
				for ($i=0,$n=count($_GET['disciplines']);$i<$n;$i++)
					{
						if(!empty($_GET['disciplines'][$i]))
							{
								$disciplines.=' OR calediscilibe = "'.$_GET['disciplines'][$i].'"';
							}
					}

				$disciplines = substr($disciplines, 4, 1000);
				$Rechdisciplines = 2;
			}

		//******************************* REQUETE SQL ***********************************
		$req1 = 'SELECT * FROM calendrier';
		$req2 = 'SELECT count(calenum) FROM calendrier';
		// RECHERCHE PAR CLIENTS
		if(!empty($rechnom) OR !empty($rechprenom)) {$reqInit.=',calendrier_participants,clients';}
		// RECHERCHE PAR CHEVAL
		if(!empty($rechchevnom) OR !empty($chevnum) AND empty($caleind) AND $_SESSION['connind'] == 'clie') {$reqInit.=',chevaux,calendrier_participants';}
		if(!empty($rechchevnom) OR !empty($chevnum) AND $_SESSION['connind'] == 'util') {$reqInit.=',chevaux,calendrier_participants';}
		//if(empty($rechchevnom) AND empty($chevnum)) {$reqInit.=",calendrier_participants";}
		// RECHERCHE PAR UTILISATEURS
		if(!empty($rechutilnum)) {$reqInit.=',utilisateurs';}
		// CONNEXION CLIENTS
		if($_SESSION['connind'] == 'clie' AND ($caleind == 4 OR $caleind == 14)) {$reqInit.=',calendrier_participants,avoir,chevaux';}
		// RECHERCHE PAR DISCIPLINE
		if($Rechdisciplines == 2) {$reqInit.=',calendrier_discipline';}
		if(!empty($clienum)) {$reqInit.=",calendrier_categorie,calendrier_participants";}
		if($_SESSION['connind'] == 'clie' AND ($caleind == 4 OR $caleind == 14)) {$reqInit.=' WHERE calendrier_calenum = calenum AND calendrier_participants.chevaux_chevnum = chevnum AND avoir.chevaux_chevnum = chevnum AND avoir.clients_clienum = "'.$_SESSION['connauthnum'].'"';}
		else {$reqInit.=' WHERE calendrier.AA_equimondo_hebeappnum = "'.$_SESSION['hebeappnum'].'"';}
		if(!empty($calecatenum)) {$reqInit.=' AND calendrier_categorie_calecatenum = "'.$calecatenum.'"';}
		// RECHERCHE PAR CHEVAL
		if(!empty($rechchevnom) OR !empty($chevnum)) {$reqInit.=' AND calendrier_calenum = calenum AND calendrier_participants.chevaux_chevnum = chevnum';}
		if(!empty($rechchevnom)) {$reqInit.=' AND chevnom LIKE "%'.$rechchevnom.'%"';}
		if(!empty($chevnum)) {$reqInit.=' AND chevnum = "'.$chevnum.'"';}
		// RECHERCHE PAR CLIENTS
		if(!empty($rechnom) OR !empty($rechprenom)) {$reqInit.=' AND calendrier_calenum = calenum AND calendrier_participants.clients_clienum = clienum';}
		if(!empty($rechnom)) {$reqInit.=' AND clienom LIKE "%'.$rechnom.'%"';}
		if(!empty($rechprenom)) {$reqInit.=' AND clieprenom LIKE "%'.$rechprenom.'%"';}
		// RECHERCHE PAR UTILISATEURS
		if($_SESSION['conflogcaleutilacces'] == 1 AND $_SESSION['modconfiguration'] == 1) {$rechutilnum = $_SESSION['connauthnum'];}
		if(!empty($utilnum) OR ($_SESSION['conflogcaleutilacces'] == 1 AND $_SESSION['modconfiguration'] == 1)) {$reqInit.=' AND utilisateurs_utilnum = "'.$utilnum.'"';}
		// RECHERCHE PAR DISCIPLINE
		if($Rechdisciplines == 2) {$reqInit.=' AND calendrier_discipline.calendrier_calenum = calenum AND ('.$disciplines.')';}
		// RECHERCHE PAR INSTALLATION
		if(!empty($_GET['caletext8']) AND $caleind == 1) {$reqInit.=' AND caletext8 = "'.$_GET['caletext8'].'"';}
		// RECHERCHE PAR REPRISE POINTER NON POINTER
		if(!empty($_GET['rechpointe']) AND empty($_GET['rechnonpointe'])) {$reqInit.=' AND caletext5 = "'.$_GET['rechpointe'].'"';}
		else if(empty($_GET['rechpointe']) AND !empty($_GET['rechnonpointe'])) {$reqInit.=' AND caletext5 = "'.$_GET['rechnonpointe'].'"';}
		if($caleind == 4 AND !empty($caledate1) AND !empty($caledate2)) {$reqInit.=' AND caledate1 >= "'.$caledate1.' 00:00:00" AND caledate2 <= "'.$caledate2.' 23:59:59"';}
		if($caleind == 4 AND !empty($rechchevnom)) {$reqInit.=' AND chevnom LIKE "%'.$rechchevnom.'%"';}
		if(!empty($clienum)) {$reqInit.=' AND calendrier_categorie_calecatenum = calecatenum AND calendrier_calenum = calenum AND calendrier_participants.clients_clienum = "'.$clienum.'"';}
		$reqFin=" GROUP BY calenum";
		if($modaffiche == 3) {$reqFin.=" ORDER BY caledate1 DESC";}
		else {$reqFin.=" ORDER BY caledate1 ASC";}
		if(empty($caledate1) AND empty($caledate2)) {$reqFin.=" LIMIT 0,200";}

		//********************* AFFICHE A LA SEMAINE ***********
		if($modaffiche == 1)
			{
				$Lecture.="<table class='table table-bordered'>";
				$Lecture.="<thead><tr style='height:40px;'>";
				$Lecture.="<th style='min-width:3%;max-width:3%;' scope='col'></th>";

				$jour1 = debutsem1($anne,$mois,$jour);
				$DateDebutSem = formatdatemysqlselect($jour1[2]);

				for ($i = 1 ; $i <= 7 ; $i++)
					{
						$Lecture.="<th scope='row'><a href='?".$Variable1.$Variable2."&modaffiche=3&caledate1=".$anne."-".$mois."-".$jour."'>".JourList($i).". ".$DateDebutSem[0]."/".$DateDebutSem[1]."</a></th>";
						$jourMenu = date("d", mktime(0,0,0,$DateDebutSem[1],$DateDebutSem[0] + 1,$DateDebutSem[2]));
						$jour1 = date("Y-m-d", mktime(0,0,0,$DateDebutSem[1],$DateDebutSem[0] + 1,$DateDebutSem[2]));
						$DateDebutSem = formatdatemysqlselect($jour1);
					}
				$Lecture.="</tr></thead>";

				$Lecture.="<tbody>";

				for ($i = 7 ; $i <= 21 ; $i++)
					{
						$Lecture.="<tr style='height:40px;'>";
						$Lecture.="<th scope='row'><center>".$i.":00</center></th>";
						for ($ii = 1 ; $ii <= 7 ; $ii++)
							{
								$Lecture.="<td>";

								if($ii == 1)
									{
										$jour1 = debutsem1($anne,$mois,$jour);
										$DateEnCour = $jour1[2];
									}

								$TranchHoraire = date("H:i:s", mktime($i,'00' + 59,'59'));

								// CALCUL LE NOMBRE DE RENDEZ VOUS
								$NbCale = 0;
								$reqCount = $req1.$reqInit.$reqCalc;
								$reqCount.=' AND caledate1 BETWEEN "'.$DateEnCour.' '.$i.':00:00" AND "'.$DateEnCour.' '.$TranchHoraire.'"';
								$reqCount.=$reqFin;
								$reqCountResult = $ConnexionBdd ->query($reqCount) or die ('Erreur SQL !'.$reqCount.'<br />'.mysqli_error());
								while($reqCountAffich = $reqCountResult->fetch())
									{
										$Largeur = 12.5 / $NbCale;
										$heure1 = formatheure1($reqCountAffich['caledate1']);
										$heure1 = $heure1[0].$heure1[1].$heure1[2];
										$heure2 = formatheure1($reqCountAffich['caledate2']);
										$heure2 = $heure2[0].$heure2[1].$heure2[2];
										$TranchHoraireCalc = str_replace(":","",$TranchHoraire);

										$NbCaleCount = $NbCaleCount + 1;
										$Minute = formatheure1($reqCountAffich[2]);
										if($Minute[1] >= 30 AND $Minute[1] <= 59) {$Hauteur = 18;}
										else {$Hauteur = 0;}
										$CalcDure = CalcDureeCalendrier($reqCountAffich['caledate1'],$reqCountAffich['caledate2']);
										$Duree = $CalcDure * 33;
										if($reqCountAffich[1] == 2) {$Duree = 4 * 33;}

										$RDVCOLOR = RdvColor($reqCountAffich['calenum'],$ConnexionBdd);

										$Lecture.='<div id="RDV" style="background-color:'.$RDVCOLOR.';height:'.$Duree.'px;width:94%;color:white;';
										$Lecture.='margin-left:'.$LargeurAffich.'%;margin-top:'.$Hauteur.'px;border-radius:5px;padding:5px;">';
										$Lecture.="<a href='".$Dossier."modules/calendrier/modcalefichcomplet.php?calenum=".$reqCountAffich['calenum']."' class='AfficheCaleFichComplet'>".$Minute[0].":".$Minute[1]." ".RdvLibelle($reqCountAffich['calenum'],$ConnexionBdd)."</a><br>";
										$Lecture.="</div>";
										$Lecture.="<div style='height:5px;'></div>";

										$NbCale = $NbCale + 1;
									}

								$Largeur = 12.5 / $NbCale;

								//if($_SESSION['connind'] == 'util') {$Lecture.='<a href="?'.$Variable2.'&caledateAjou='.$CalcJour1.' '.$i.':00:00#CaleAjou" class="RDVLien">';}
								$Lecture.='<div class="RDVLienAjou">';
								//$Lecture.=$NbCale;
								$Lecture.='</div>';
								if($_SESSION['connind'] == 'util') {$Lecture.='</a>';}
									$DateEnCour = formatdatemysqlselect($DateEnCour);
									$DateEnCour = date("Y-m-d", mktime(0,0,0,$DateEnCour[1],$DateEnCour[0] + 1,$DateEnCour[2]));
								$Lecture.="</td>";
							}
						$Lecture.="</tr>";
					}
				$Lecture.="</tbody>";

				$Lecture.="</table>";
			}
		//************************ FIN AFFICHE A LA SEMAINE *********************

		//********************* AFFICHE AU MOIS ***********
		if($modaffiche == 2)
			{
				if(empty($magik1)){$magik1=$mois;}
				if(empty($magik2)){$magik2=$anne;}

				$magik3=date("w", mktime(0,0,0,$magik1,1,$magik2));

				$magik4=date("t", mktime(0,0,0,$magik1,1,$magik2));

				$magik6=date("d");

				if ($magik3==0) {$magik3=7;}

				$Lecture.="<table class='table table-bordered' style='width:100%;'>";
				$Lecture.="<thead><tr><td colspan='7'><center>".TradMoisNum($mois)." ".$anne."</center></td></tr></thead>";
				$Lecture.="<thead><tr>";
				for ($i = 1 ; $i <= 7 ; $i++)
					{
						$Lecture.="<th scope='row' style='width:14%;'>".JourList($i).".</th>";
					}
				$Lecture.="</tr></thead>";
				$Lecture.="</table>";

				$Lecture.="<table class='table table-bordered' style='width:100%;'>";
				$i=1;while ($i<$magik3) { $Lecture.="<th scope='col' style='width:14%;white-space:normal;'>&nbsp;</th>";$i++;}

				$i=1;while ($i<=$magik4){
				$magik5=($i+$magik3-1)%7;
				$Lecture.="<td style='width:14%;white-space:normal;'>";
				$date1 = $magik2."-".$magik1."-".$i;

				$CalcDate = formatdatemysqlselect($date1);
				$Lecture.="<a href='?modaffiche=3&mois=".$CalcDate[1]."&anne=".$CalcDate[2]."&jour=".$CalcDate[0].$Variable2."' class='TitreJour'>".$i."</a><br>";

				$req = $req1.$reqInit.$reqCalc;
				$req.=' AND caledate1 BETWEEN "'.$date1.' 00:00:00" AND "'.$date1.' 23:59:59"';
				$req.=$reqFin;
				$reqResult = $ConnexionBdd ->query($req) or die ('Erreur SQL !'.$req.'<br />'.mysqli_error());
				while($reqAffich = $reqResult->fetch())
					{
						$Date = formatheure1($reqAffich['caledate1']);

						$RDVCOLOR = RdvColor($reqAffich['calenum'],$ConnexionBdd);

						$InfoBulleCale = str_replace("'"," ",$InfoBulleCale);
						$InfoBulle = '<span onmouseover=\'afficher_bulle("<em><div class=infobulle2>'.$InfoBulleCale.'</div></em>", "white", event);\' onmouseout="masquer_bulle();" class="infobulle1">';

						$Lecture.=$InfoBulle;
						//$Lecture.="<button type='button' class='btn btn-outline-secondary mb-1' data-bs-toggle='modal' data-bs-target='#overlayScrollShort'>";
						$Lecture.="<div style = 'background-color:".$RDVCOLOR.";border-radius:10px;padding:5px;'>";
						$Lecture.="<a href='".$Dossier."modules/calendrier/modcalefichcomplet.php?calenum=".$reqAffich['calenum']."' class='AfficheCaleFichComplet' style='color:white;'>";
						$Lecture.=$Date[0].":".$Date[1]." ".RdvLibelle($reqAffich['calenum'],$ConnexionBdd);
						$Lecture.="</a>";
						$Lecture.="</div>";
						$Lecture.="</span><br>";
					}

				$Lecture.="</td>";
				if ($magik5==0) { $Lecture.="</tr><tr>"; }
				$i++;}

				$Lecture.="</tr></tbody></table><br>";
			}
		//*********************************************

		//*************** AFFICHE LISTE **************
		if($modaffiche == 3)
			{
				$Lecture.="<table class='tab_rubrique' style='width:100%;'>";
					$Lecture.="<thead><tr>";
						$Lecture.="<td>".$_SESSION['STrad396']."</td>";
						$Lecture.="<td>".$_SESSION['STrad88']."</td>";
						$Lecture.="<td>".$_SESSION['STrad397']."</td>";
					$Lecture.="<tr></thead>";
					$Lecture.="<tbody>";
					$req = $req1.$reqInit.$reqCalc;
					$req.=$reqFin;
					$reqResult = $ConnexionBdd ->query($req) or die ('Erreur SQL !'.$req.'<br />'.mysqli_error());
					while($reqAffich = $reqResult->fetch())
						{
							$Lien = "<a href='".$Dossier."modules/calendrier/modcalefichcomplet.php?calenum=".$reqAffich['calenum']."' class='LoadPage AfficheCaleFichComplet'>";
							$Lecture.="<tr>";
								$Lecture.="<td>".$Lien.$reqAffich['calecatelibe']."</a></td>";
								$Lecture.="<td>".$Lien.FormatDateTimeMySql($reqAffich['caledate1'])."</a></td>";

								// INFO CHEVAL
								if($reqAffich['calecatetype'] == 1)
									{
										$req1 = 'SELECT * FROM calendrier_participants WHERE calepartnum = "'.$reqAffich['calepartnum'].'"';
										$req1Result = $ConnexionBdd ->query($req1) or die ('Erreur SQL !'.$req1.'<br />'.mysqli_error());
										$req1Affich = $req1Result->fetch();
									}
								$Lecture.="<td>".$Lien.ChevLect($req1Affich['chevaux_chevnum'],$ConnexionBdd)."</a></td>";

							$Lecture.="</tr>";
						}
					$Lecture.="</tbody>";
				$Lecture.="</table>";
			}
		//*********************************************

		//*************** AFFICHE LISTE SMARTPHONE **************
		if($modaffiche == 4)
			{
				if(empty($_GET['caledate1'])) {$caledate1 = date('Y-m-d');} else {$caledate1 = $_GET['caledate1'];}
				if(empty($_GET['caledate2'])) {$DatePlus7=date("Y-m-d", mktime(0,0,0,date('m'),date('d') + 7,date('Y')));$caledate2 = $DatePlus7;} else {$caledate2 = $_GET['caledate2'];}

				$req = $req1.$reqInit.$reqCalc;
				$req.=' AND caledate1 BETWEEN "'.$caledate1.' 00:00:00" AND "'.$caledate2.' 23:59:59"';
				$req.=$reqFin;
				$reqResult = $ConnexionBdd ->query($req) or die ('Erreur SQL !'.$req.'<br />'.mysqli_error());
				while($reqAffich = $reqResult->fetch())
					{
						$reqCaleCate = 'SELECT * FROM calendrier_categorie WHERE calecatenum = "'.$reqAffich['calendrier_categorie_calecatenum'].'"';
						$reqCaleCateResult = $ConnexionBdd ->query($reqCaleCate) or die ('Erreur SQL !'.$reqCaleCate.'<br />'.mysqli_error());
						$reqCaleCateAffich = $reqCaleCateResult->fetch();

						$Lien = "<a href='".$Dossier."modules/calendrier/modcalefichcomplet.php?calenum=".$reqAffich['calenum']."' class='LoadPage AfficheCaleFichComplet'>";

						$RDVCOLOR = RdvColor($reqAffich['calenum'],$ConnexionBdd);

						$date = formatheure1($reqAffich['caledate1']);

						$Lecture.="<section style='background-color:".$RDVCOLOR.";margin-bottom:10px;width:98%;height:110px;clear:both;display:block;color:white;padding:3px;border-radius:5px;'>".$Lien;
							$Lecture.="<div style='float:left;width:48%;margin-left:1%;margin-right:1%;color:white;'>";
								// AFFICHE LA DATE et L'HEURE
								$Lecture.=$date[5]." ".TradMoisNum($date[4])." ".$date[3]."<br>".$date[0].":".$date[1]."<br>";
								// AFFICHE LA DUREE
								if($reqCaleCateAffich['calecatetype'] == 1 OR $reqCaleCateAffich['calecatetype'] == 2) {$Lecture.=minute_vers_heure($reqAffich['caletext1'],2);}
							$Lecture.="</div>";
							$Lecture.="<div style='float:left;width:48%;margin-left:1%;margin-right:1%;color:white;'><span style='float:right;'>";
								// AFFICHER LE LIBELLE
								$Lecture.=RdvLibelle($reqAffich['calenum'],$ConnexionBdd)."<br>";
								// AFFICHER LE MONITEUR
								if(!empty($reqAffich['utilisateurs_utilnum'])) {$Lecture.=UtilLect($reqAffich['utilisateurs_utilnum'],$ConnexionBdd);}
							$Lecture.="</span></div>";

							// NOMBRE DE CAVALIER
							if($reqCaleCateAffich['calecatetype'] == 1 OR $reqCaleCateAffich['calecatetype'] == 2)
								{
									$Lecture.="<section style='float:left;width:97%;color:white;'>";
									$NbPart = 0;
									$req2 = 'SELECT DISTINCT clients_clienum FROM calendrier_participants WHERE calendrier_calenum = "'.$reqAffich['calenum'].'" AND caleparttext2 = "3"';
									$req2Result = $ConnexionBdd ->query($req2) or die ('Erreur SQL !'.$req2.'<br />'.mysqli_error());
									while($req2Affich = $req2Result->fetch()) {$NbPart = $NbPart + 1;}

									$Lecture.="<span style='float:right;'>".$_SESSION['STrad707']." ".$NbPart." ".$_SESSION['STrad708']."</span>";
									$Lecture.="</section>";
								}

						$Lecture.="</a></section>";
					}
			}

		$_SESSION['modaffiche'] = $modaffiche;
		$_SESSION['CaleJour'] = $jour;
		$_SESSION['CaleMois'] = $mois;
		$_SESSION['CaleAnne'] = $anne;

		return $Lecture;
	}
//******************************************************************

//****************** INFO BULLE CALENDRIER ************************
function CalendrierInfoBulle($calenum,$Dossier,$ConnexionBdd,$date)
	{
		// INFO RDV
		$req1 = 'SELECT calendrier_categorie_calecatenum,caletext6,utilisateurs_utilnum,chevaux_chevnum,chevaux_chevnum,caledate1,caletext3,caletext4,calejour1,calejour2,calejour3,calejour4,calejour5,calejour6,calejour7,caletext1 FROM calendrier WHERE calenum = "'.$calenum.'"';
		$req1Result = $ConnexionBdd ->query($req1) or die ('Erreur SQL !'.$req1.'<br />'.mysqli_error());
		$req1Affich = $req1Result->fetch();

		$reqCate = 'SELECT * FROM calendrier_categorie WHERE calecatenum = "'.$req1Affich['calendrier_categorie_calecatenum'].'"';
		$reqCateResult = $ConnexionBdd ->query($reqCate) or die ('Erreur SQL !'.$reqCate.'<br />'.mysqli_error());
		$reqCateAffich = $reqCateResult->fetch();

		$Lecture.=RdvLibelle($calenum,$ConnexionBdd)."<br>";

		// AFFICHER L HEURE
		if($reqCateAffich['calecatetype'] == 1) {$heure1 = formatheure1($req1Affich[5]);$Lecture.="Heure : <b>".$heure1[0].":".$heure1[1]."</b><br>";}

		if($reqCateAffich['calecatetype'] == 1 AND !empty($req1Affich[1])) {$Lecture.=$req1Affich[1]."<br>";}
		// NIVEAU
		if($reqCateAffich['calecatetype'] == 1)
			{
				$reqNive = 'SELECT count(calenivenum) FROM calendrier_niveau WHERE calendrier_calenum = "'.$calenum.'"';
				$reqNiveResult = $ConnexionBdd ->query($reqNive) or die ('Erreur SQL !'.$reqNive.'<br />'.mysqli_error());
				$reqNiveAffich = $reqNiveResult->fetch();
				if($reqNiveAffich[0] >= 1)
					{
						$Lecture.=$_SESSION['STrad122']." : <br>";
						$reqNive = 'SELECT * FROM calendrier_niveau WHERE calendrier_calenum = "'.$calenum.'"';
						$reqNiveResult = $ConnexionBdd ->query($reqNive) or die ('Erreur SQL !'.$reqNive.'<br />'.mysqli_error());
						while($reqNiveAffich = $reqNiveResult->fetch())
							{
								$Lecture.=$reqNiveAffich['calenivelibe']."<br>";
							}
					}
			}

		// AFFICHE LA DUREE
		if($reqCateAffich['calecatetype'] == 1) {$Lecture.= $_SESSION['STrad291']." : ".minute_vers_heure($req1Affich['caletext1'],2)."<br>";}

		// INFO SOINS
		if($reqCateAffich['calecatetype'] == 4 OR $reqCateAffich['calecatetype'] == 5)
			{
				$reqChev = 'SELECT chevnum,chevnom FROM chevaux,calendrier_participants WHERE chevaux_chevnum = chevnum AND calendrier_calenum = "'.$calenum.'"';
				$reqChevResult = $ConnexionBdd ->query($reqChev) or die ('Erreur SQL !'.$reqChev.'<br />'.mysqli_error());
				while($reqChevAffich = $reqChevResult->fetch()) {$Lecture.=$reqChevAffich[1]."<br>";}
			}

		// INFO UTILISATEUR
		if($reqCateAffich['calecatetype'] == 2)
			{
				$reqDisci = 'SELECT calediscilibe FROM calendrier_discipline WHERE calendrier_calenum = "'.$calenum.'"';
				$reqDisciResult = $ConnexionBdd ->query($reqDisci) or die ('Erreur SQL !'.$reqDisci.'<br />'.mysqli_error());
				while($reqDisciAffich = $reqDisciResult->fetch()) {$Lecture.=$reqDisciAffich[0].', ';}

				$Lecture.="<br>";

				if($req1Affich['calejour1'] == 2) {$ListeJour.=$_SESSION['STrad19'].", ";}
				if($req1Affich['calejour2'] == 2) {$ListeJour.=$_SESSION['STrad19'].", ";}
				if($req1Affich['calejour3'] == 2) {$ListeJour.=$_SESSION['STrad19'].", ";}
				if($req1Affich['calejour4'] == 2) {$ListeJour.=$_SESSION['STrad19'].", ";}
				if($req1Affich['calejour5'] == 2) {$ListeJour.=$_SESSION['STrad19'].", ";}
				if($req1Affich['calejour6'] == 2) {$ListeJour.=$_SESSION['STrad19'].", ";}
				if($req1Affich['calejour7'] == 2) {$ListeJour.=$_SESSION['STrad19'].", ";}

				$Lecture.=$ListeJour."<br>";
			}

		// INFO UTILISATEUR
		if(!empty($req1Affich[2]))
			{
				$Lecture.="<b>".UtilLect($req1Affich[2],$ConnexionBdd)."</b><br>";
			}

		if($reqCateAffich['calecatetype'] == 1 OR $reqCateAffich['calecatetype'] == 2 OR $reqCateAffich['calecatetype'] == 3 OR $reqCateAffich['calecatetype'] == 6)
			{
				$NbPart = 0;
				if($reqCateAffich['calecatetype'] == 2 AND $_SESSION['connind'] == 'util')
					{
						// INFO PARTICIPANTS
						$req2 = 'SELECT DISTINCT clients_clienum FROM calendrier_participants';
						if(!empty($date)) {$req2.=',calendrier';}
						$req2.=' WHERE calendrier_calenum = "'.$calenum.'"';
						if(!empty($date)) {$req2.=' AND calendrier_calenum = calenum AND caledate1 BETWEEN "'.$date.' 00:00:00" AND "'.$date.' 23:59:59"';}
						$req2Result = $ConnexionBdd ->query($req2) or die ('Erreur SQL !'.$req2.'<br />'.mysqli_error());
						while($req2Affich = $req2Result->fetch()) {$NbPart = $NbPart + 1;}

						$Lecture.="<i>".$_SESSION['STrad707']." ".$NbPart." ".$_SESSION['STrad706']." ".formatdatemysql($date)."</i><br>";
					}
				$Lecture.="<hr>";
				// INFO PARTICIPANTS
				$req2 = 'SELECT DISTINCT clients_clienum FROM calendrier_participants WHERE calendrier_calenum = "'.$calenum.'"';
				$req2Result = $ConnexionBdd ->query($req2) or die ('Erreur SQL !'.$req2.'<br />'.mysqli_error());
				while($req2Affich = $req2Result->fetch()) {$NbPart = $NbPart + 1;}

				$Lecture.="<i>".$_SESSION['STrad707']." <b style='color:green;'>".$NbPart." ".$_SESSION['STrad708']."</b> ".$reqCateAffich['calecatelibe']."</i><br>";

				if($NbPart >= 1 AND $_SESSION['connind'] == 'util')
					{
						$req2 = 'SELECT clients_clienum,chevaux_chevnum,caleparttext1,caleparttext2 FROM calendrier_participants';
						if($_SESSION['connind'] == 'clie') {$req2.=',clients';}
						$req2.=' WHERE calendrier_calenum = "'.$calenum.'"';
						if($_SESSION['connind'] == 'clie') {$req2.=' AND clients_clienum = clienum AND familleclients_famiclienum = "'.$_SESSION['connauthfaminum'].'"';}
						if($req1Affich[0] == 2) {$req2.=' GROUP BY clients_clienum';}
						$req2Result = $ConnexionBdd ->query($req2) or die ('Erreur SQL !'.$req2.'<br />'.mysqli_error());
						while($req2Affich = $req2Result->fetch())
							{
								// INFO CLIENT
								if(!empty($req2Affich[0]))
									{
										$Lecture.=ClieLect($req2Affich[0],$ConnexionBdd);
									}
								// INFO CHEVAUX
								if(!empty($req2Affich[1]))
									{
										$Lecture.=" <i> - ".ChevLect($req2Affich[1],$ConnexionBdd)."</i>";
									}
								// STATUS RESERVER
								$Lecture.=" - ".CalendrierStatusReservation($req2Affich[2],$req2Affich[3]);

								// STATUS PRESENT, ABSENT, ETC ....
								if(!empty($req2Affich['caleparttext2']) AND $reqCateAffich['calecatetype'] != 3) {$Lecture.=" - ".ReprisePresenceLect($req2Affich['caleparttext2'],2);}

								$Lecture.='<br>';
							}
					}
			}

		return $Lecture;
	}
//***************************************************************************

//***************************** INFO BULLE CALENDRIER ******************************
function CalendrierStatusReservation($status,$caleparttext2)
	{
		if($status == 1 OR $status == 3 AND $caleparttext2 != 3) {return "<i style='color:red;'>".$_SESSION['STrad709']."</i";}
		if($status == 2 OR $status == 4 AND $caleparttext2 == 3) {return "<i style='color:green;'>".$_SESSION['STrad710']."</i>";}
	}
//***************************************************************************************

//******************** FONCTION JOUR POUR CALENDRIER *****************
function JourList($jour)
	{
		if($jour == 7 OR $jour == 0) {return $_SESSION['STrad261'];}
		if($jour == 1) {return $_SESSION['STrad262'];}
		if($jour == 2) {return $_SESSION['STrad263'];}
		if($jour == 3) {return $_SESSION['STrad264'];}
		if($jour == 4) {return $_SESSION['STrad265'];}
		if($jour == 5) {return $_SESSION['STrad266'];}
		if($jour == 6) {return $_SESSION['STrad267'];}
	}
//***********************************************************

//******************** DUREE REPRISE *******************
function DureeReprise($dure)
	{
		$Lecture.="<option value=''";if(empty($dure)) {$Lecture.=" selected";} $Lecture.=">-- ".$_SESSION['STrad268']." --</option>";
		$Lecture.="<option value='15'";if($dure == 15) {$Lecture.=" selected";} $Lecture.=">15 ".$_SESSION['STrad46']."</option>";
		$Lecture.="<option value='30'";if($dure == 30) {$Lecture.=" selected";} $Lecture.=">30 ".$_SESSION['STrad46']."</option>";
		$Lecture.="<option value='45'";if($dure == 45) {$Lecture.=" selected";} $Lecture.=">45 ".$_SESSION['STrad46']."</option>";
		$Lecture.="<option value='50'";if($dure == 50) {$Lecture.=" selected";} $Lecture.=">50 ".$_SESSION['STrad46']." </option>";
		$Lecture.="<option value='60'";if($dure == 60) {$Lecture.=" selected";} $Lecture.=">1 ".$_SESSION['STrad28']." </option>";
		$Lecture.="<option value='75'";if($dure == 75) {$Lecture.=" selected";} $Lecture.=">1 ".$_SESSION['STrad28']." 15</option>";
		$Lecture.="<option value='90'";if($dure == 90) {$Lecture.=" selected";} $Lecture.=">1 ".$_SESSION['STrad28']." 30</option>";
		$Lecture.="<option value='105'";if($dure == 105) {$Lecture.=" selected";} $Lecture.=">1 ".$_SESSION['STrad28']." 45</option>";
		$Lecture.="<option value='120'";if($dure == 120) {$Lecture.=" selected";} $Lecture.=">2 ".$_SESSION['STrad29']."</option>";
		$Lecture.="<option value='135'";if($dure == 135) {$Lecture.=" selected";} $Lecture.=">2 ".$_SESSION['STrad29']." 15</option>";
		$Lecture.="<option value='150'";if($dure == 150) {$Lecture.=" selected";} $Lecture.=">2 ".$_SESSION['STrad29']." 30</option>";
		$Lecture.="<option value='165'";if($dure == 165) {$Lecture.=" selected";} $Lecture.=">2 ".$_SESSION['STrad29']." 45</option>";
		$Lecture.="<option value='180'";if($dure == 180) {$Lecture.=" selected";} $Lecture.=">3 ".$_SESSION['STrad29']."</option>";
		$Lecture.="<option value='195'";if($dure == 195) {$Lecture.=" selected";} $Lecture.=">3 ".$_SESSION['STrad29']." 15</option>";
		$Lecture.="<option value='210'";if($dure == 210) {$Lecture.=" selected";} $Lecture.=">3 ".$_SESSION['STrad29']." 30</option>";
		$Lecture.="<option value='225'";if($dure == 225) {$Lecture.=" selected";} $Lecture.=">3 ".$_SESSION['STrad29']." 45</option>";
		$Lecture.="<option value='240'";if($dure == 240) {$Lecture.=" selected";} $Lecture.=">4 ".$_SESSION['STrad29']."</option>";
		$Lecture.="<option value='255'";if($dure == 255) {$Lecture.=" selected";} $Lecture.=">4 ".$_SESSION['STrad29']." 15</option>";
		$Lecture.="<option value='270'";if($dure == 270) {$Lecture.=" selected";} $Lecture.=">4 ".$_SESSION['STrad29']." 30</option>";
		$Lecture.="<option value='285'";if($dure == 285) {$Lecture.=" selected";} $Lecture.=">4 ".$_SESSION['STrad29']." 45</option>";
	$Lecture.="<option value='300'";if($dure == 300) {$Lecture.=" selected";} $Lecture.=">5 ".$_SESSION['STrad29']."</option>";

		return $Lecture;
	}
//***************************************************************

//******************** DUREE REPRISE *******************
function DureeRepriseDebit($dure,$calepartnum)
	{
		if($_SESSION['infologlang1'] == "ch")
			{
				$Lecture.="<option value='30";if(!empty($calepartnum)) {$Lecture.="|".$calepartnum;} $Lecture.="'";if($dure == 30) {$Lecture.=" selected";} $Lecture.=">0.5 ".$_SESSION['STrad753']." </option>";
				$Lecture.="<option value='60";if(!empty($calepartnum)) {$Lecture.="|".$calepartnum;} $Lecture.="'";if($dure == 60) {$Lecture.=" selected";} $Lecture.=">1 ".$_SESSION['STrad753']." </option>";
				$Lecture.="<option value='90";if(!empty($calepartnum)) {$Lecture.="|".$calepartnum;} $Lecture.="'";if($dure == 90) {$Lecture.=" selected";} $Lecture.=">1.5 ".$_SESSION['STrad753']." </option>";
				$Lecture.="<option value='120";if(!empty($calepartnum)) {$Lecture.="|".$calepartnum;} $Lecture.="'";if($dure == 120) {$Lecture.=" selected";} $Lecture.=">2 ".$_SESSION['STrad753']." </option>";
				$Lecture.="<option value='180";if(!empty($calepartnum)) {$Lecture.="|".$calepartnum;} $Lecture.="'";if($dure == 180) {$Lecture.=" selected";} $Lecture.=">3 ".$_SESSION['STrad753']." </option>";
				$Lecture.="<option value='240";if(!empty($calepartnum)) {$Lecture.="|".$calepartnum;} $Lecture.="'";if($dure == 240) {$Lecture.=" selected";} $Lecture.=">4 ".$_SESSION['STrad753']." </option>";
			}
		else
			{
				$Lecture.="<option value=''";if(empty($dure)) {$Lecture.=" selected";} $Lecture.=">-- ".$_SESSION['STrad268']." --</option>";
				$Lecture.="<option value='15";if(!empty($calepartnum)) {$Lecture.="|".$calepartnum;} $Lecture.="'";if($dure == 15) {$Lecture.=" selected";} $Lecture.=">15 ".$_SESSION['STrad46']."</option>";
				$Lecture.="<option value='30";if(!empty($calepartnum)) {$Lecture.="|".$calepartnum;} $Lecture.="'";if($dure == 30) {$Lecture.=" selected";} $Lecture.=">30 ".$_SESSION['STrad46']."</option>";
				$Lecture.="<option value='45";if(!empty($calepartnum)) {$Lecture.="|".$calepartnum;} $Lecture.="'";if($dure == 45) {$Lecture.=" selected";} $Lecture.=">45 ".$_SESSION['STrad46']."</option>";
				$Lecture.="<option value='60";if(!empty($calepartnum)) {$Lecture.="|".$calepartnum;} $Lecture.="'";if($dure == 60) {$Lecture.=" selected";} $Lecture.=">1 ".$_SESSION['STrad28']." </option>";
				$Lecture.="<option value='75";if(!empty($calepartnum)) {$Lecture.="|".$calepartnum;} $Lecture.="'";if($dure == 75) {$Lecture.=" selected";} $Lecture.=">1 ".$_SESSION['STrad28']." 15</option>";
				$Lecture.="<option value='90";if(!empty($calepartnum)) {$Lecture.="|".$calepartnum;} $Lecture.="'";if($dure == 90) {$Lecture.=" selected";} $Lecture.=">1 ".$_SESSION['STrad28']." 30</option>";
				$Lecture.="<option value='105";if(!empty($calepartnum)) {$Lecture.="|".$calepartnum;} $Lecture.="'";if($dure == 105) {$Lecture.=" selected";} $Lecture.=">1 ".$_SESSION['STrad28']." 45</option>";
				$Lecture.="<option value='120";if(!empty($calepartnum)) {$Lecture.="|".$calepartnum;} $Lecture.="'";if($dure == 120) {$Lecture.=" selected";} $Lecture.=">2 ".$_SESSION['STrad29']."</option>";
				$Lecture.="<option value='135";if(!empty($calepartnum)) {$Lecture.="|".$calepartnum;} $Lecture.="'";if($dure == 135) {$Lecture.=" selected";} $Lecture.=">2 ".$_SESSION['STrad29']." 15</option>";
				$Lecture.="<option value='150";if(!empty($calepartnum)) {$Lecture.="|".$calepartnum;} $Lecture.="'";if($dure == 150) {$Lecture.=" selected";} $Lecture.=">2 ".$_SESSION['STrad29']." 30</option>";
				$Lecture.="<option value='165";if(!empty($calepartnum)) {$Lecture.="|".$calepartnum;} $Lecture.="'";if($dure == 165) {$Lecture.=" selected";} $Lecture.=">2 ".$_SESSION['STrad29']." 45</option>";
				$Lecture.="<option value='180";if(!empty($calepartnum)) {$Lecture.="|".$calepartnum;} $Lecture.="'";if($dure == 180) {$Lecture.=" selected";} $Lecture.=">3 ".$_SESSION['STrad29']."</option>";
				$Lecture.="<option value='195";if(!empty($calepartnum)) {$Lecture.="|".$calepartnum;} $Lecture.="'";if($dure == 195) {$Lecture.=" selected";} $Lecture.=">3 ".$_SESSION['STrad29']." 15</option>";
				$Lecture.="<option value='210";if(!empty($calepartnum)) {$Lecture.="|".$calepartnum;} $Lecture.="'";if($dure == 210) {$Lecture.=" selected";} $Lecture.=">3 ".$_SESSION['STrad29']." 30</option>";
				$Lecture.="<option value='225";if(!empty($calepartnum)) {$Lecture.="|".$calepartnum;} $Lecture.="'";if($dure == 225) {$Lecture.=" selected";} $Lecture.=">3 ".$_SESSION['STrad29']." 45</option>";
				$Lecture.="<option value='240";if(!empty($calepartnum)) {$Lecture.="|".$calepartnum;} $Lecture.="'";if($dure == 240) {$Lecture.=" selected";} $Lecture.=">4 ".$_SESSION['STrad29']."</option>";
				$Lecture.="<option value='255";if(!empty($calepartnum)) {$Lecture.="|".$calepartnum;} $Lecture.="'";if($dure == 255) {$Lecture.=" selected";} $Lecture.=">4 ".$_SESSION['STrad29']." 15</option>";
				$Lecture.="<option value='270";if(!empty($calepartnum)) {$Lecture.="|".$calepartnum;} $Lecture.="'";if($dure == 270) {$Lecture.=" selected";} $Lecture.=">4 ".$_SESSION['STrad29']." 30</option>";
				$Lecture.="<option value='285";if(!empty($calepartnum)) {$Lecture.="|".$calepartnum;} $Lecture.="'";if($dure == 285) {$Lecture.=" selected";} $Lecture.=">4 ".$_SESSION['STrad29']." 45</option>";
				$Lecture.="<option value='300";if(!empty($calepartnum)) {$Lecture.="|".$calepartnum;} $Lecture.="'";if($dure == 300) {$Lecture.=" selected";} $Lecture.=">5 ".$_SESSION['STrad29']."</option>";
			}

		return $Lecture;
	}
//***************************************************************

//******************* CATEGORIE CALENDRIER ***************************
function CalendrierCategorieTypeLect($num)
	{
		if($num == 1) {$Lecture.=$_SESSION['STrad184'];}
		else if($num == 2) {$Lecture.=$_SESSION['STrad185'];}
		else if($num == 3) {$Lecture.=$_SESSION['STrad186'];}
		else if($num == 4) {$Lecture.=$_SESSION['STrad221'];}
		else if($num == 5) {$Lecture.=$_SESSION['STrad220'];}
		else if($num == 15) {$Lecture.=$_SESSION['STrad276'];}

		return $Lecture;
	}
function CalendrierCategorieType($num)
	{
		$Lecture.="<option value=''>-- ".$_SESSION['STrad275']." --</option>";
		$Lecture.="<option value='1'";if($num == 1) {$Lecture.=" selected";} $Lecture.=">".$_SESSION['STrad184']."</option>";
		$Lecture.="<option value='2'";if($num == 2) {$Lecture.=" selected";} $Lecture.=">".$_SESSION['STrad185']."</option>";
		$LectureCalendrierCateType.="<option value='3'";if($num == 3) {$Lecture.=" selected";} $Lecture.=">".$_SESSION['STrad186']."</option>";
		$Lecture.="<option value='4'";if($num == 4) {$Lecture.=" selected";} $Lecture.=">".$_SESSION['STrad221']."</option>";
		$Lecture.="<option value='5'";if($num == 5) {$Lecture.=" selected";} $Lecture.=">".$_SESSION['STrad220']."</option>";
		$Lecture.="<option value='15'";if($num == 15) {$Lecture.=" selected";} $Lecture.=">".$_SESSION['STrad276']."</option>";

		return $Lecture;
	}
//***************************************************************

//*********************** CALENDRIER CATEGORIE TYPE ***********************
function CalendrierCateType($num,$ConnexionBdd,$calenum,$Dossier)
	{
		if(!empty($calenum))
			{
				$reqCale = 'SELECT * FROM calendrier,calendrier_categorie WHERE calendrier_categorie_calecatenum = calecatenum AND calenum = "'.$calenum.'"';
		    $reqCaleResult = $ConnexionBdd ->query($reqCale) or die ('Erreur SQL !'.$reqCale.'<br />'.mysqli_error());
		    $reqCaleAffich = $reqCaleResult->fetch();
				$num = $reqCaleAffich['calecatetype'];
				$caletext1 = $reqCaleAffich['caletext1'];
				$caletext2 = $reqCaleAffich['caletext2'];
				$caletext3 = $reqCaleAffich['caletext3'];
				$caletext4 = $reqCaleAffich['caletext4'];
				$caletext5 = $reqCaleAffich['caletext5'];
				$caletext6 = $reqCaleAffich['caletext6'];
				$caletext7 = $reqCaleAffich['caletext7'];
				$caletext8 = $reqCaleAffich['caletext8'];
				$caletext13 = $reqCaleAffich['caletext13'];
				$utilnum = $reqCaleAffich['utilisateurs_utilnum'];

				$dateCalc1 = formatheure1($reqCaleAffich['caledate1']);
				$dateCalc2 = formatheure1($reqCaleAffich['caledate2']);
				$date1 = $dateCalc1[3]."-".$dateCalc1[4]."-".$dateCalc1[5];
				$date2 = $dateCalc2[3]."-".$dateCalc2[4]."-".$dateCalc2[5];

				$heure1 = $dateCalc1[0].":".$dateCalc1[1];
				$heure2 = $dateCalc2[0].":".$dateCalc2[1];
			}
		else
			{
				$date1 = date('Y-m-d');
				$date2 = date('Y-m-d');

				$heure1 = date('H').":00";
				$heure2 = date('H').":00";

				$caletext1 = "";
				$caletext2 = "";
				$caletext3 = "";
				$caletext4 = "";
				$caletext5 = "";
				$caletext6 = "";
				$caletext7 = "";
				$caletext8 = "";
				$utilnum = "";
			}

		if($num == 2)
			{
				$Lecture.="<input type='date' class='champ_barre ChampBarre50_1' name='caledate1' value='".$date1."' required>";
				$Lecture.="<input type='date' class='champ_barre ChampBarre50_1' name='caledate2' value='".$date2."' required>";

				$Lecture.="<input type='time' class='champ_barre ChampBarre50_1' name='caleheure1' value='".$heure1."' required>";
				$Lecture.="<input type='time' class='champ_barre ChampBarre50_1' name='caleheure2' value='".$heure2."' required>";

				// RESTUARATION SUR PLACE
				$Lecture.="<select name='caletext6' class='champ_barre' required>".RestaurationSelect($caletext6)."</select>";

				$Lecture.="<textarea name='caletext7' class='champ_barre' value='".$caletext7."' placeholder='".$_SESSION['STrad287']."'></textarea>";
				$Lecture.="<textarea name='caletext9' class='champ_barre' value='".$caletext9."' placeholder='".$_SESSION['STrad288']."'></textarea>";
				$Lecture.="<textarea name='caletext13' class='champ_barre' value='".$caletext13."' placeholder='".$_SESSION['STrad289']."'></textarea>";
			}

		if($num == 1)
			{
				?>

				<div class="card mb-5"><div class="card-body">

				<div class="row g-3 mb-3">
			    <div class="col-md-6">
						<label class="form-label"><?php echo $_SESSION['STrad170']; ?></label>
						<input type="date" class="form-control" name="caledate1" required />
					</div>
			    <div class="col-md-6">
						<label class="form-label"><?php echo $_SESSION['STrad290']; ?></label>
						<input type="time" class="form-control" name="caleheure1" required />
			    </div>
		    </div>


				<div class="row g-3 mb-3">
			    <div class="col-md-6">
						<label for="inputPassword4" class="form-label"><?php echo $_SESSION['STrad291']; ?></label>
	          <select id="selectBasic" class="form-control" name="caletext1" onchange='AfficheNbHeureDecompte(this.value)' required>
	            <?php echo DureeReprise($caletext1); ?>
	          </select>
					</div>
			    <div class="col-md-6" id='DivAfficheNbHeureDecompte'></div>
		    </div>

			</div></div>

<?php

			}
		if($num == 1 OR $num == 2)
			{
				?>
				<div class="card mb-5"><div class="card-body">

				<div class="row g-3 mb-3">
			    <div class="col-md-6">
						<label class="form-label"><?php echo $_SESSION['STrad598']; ?></label>
	          <input type="text" class="form-control" name="caletext13" placeholder="" required/>

					</div>

					<div class="col-md-6">
						<label for="inputPassword4" class="form-label"><?php echo $_SESSION['STrad269']; ?></label>
						<select id="selectBasic" class="form-control" name="utilnum" required>
							<?php echo UtilSelect($utilnum,$ConnexionBdd,1,null,2); ?>
						</select>
					</div>
				</div>

				<div class="row g-3 mb-3">
			    <div class="col-md-6">
						<label for="inputPassword4" class="form-label"><?php echo $_SESSION['STrad122']; ?></label>
						<select id="select2Multiple" class="form-control" name="calenivenum[]" onchange='AfficheNiveau(this.value)' multiple>
							<?php echo CalendrierNiveau($num,$ConnexionBdd,"ajou",$calenum); ?>
	          </select>
						<div id='DivAfficheNiveau'></div>
					</div>
			    <div class="col-md-6">
						<label for="inputPassword4" class="form-label"><?php echo $_SESSION['STrad293']; ?></label>
	          <select id="selectBasic" class="form-control" name="calediscconfnum[]" onchange='DisciplineAjouSelect(this.value)' required>
	            <?php echo CaleDiscSelect(null,$ConnexionBdd,"ajou",$calenum); ?>
	          </select>
						<div id='DivDisciplineAjouSelect'></div>
			    </div>
		    </div>

				<div class="row g-3">
			    <div class="col-md-6">
						<label for="inputPassword4" class="form-label"><?php echo $_SESSION['STrad294']; ?></label>
						<select class="form-control" name="caletext7" required>
	            <?php echo NbMaxPersonne($caletext7);?>
	          </select>
					</div>
			    <div class="col-md-6">
						<label for="inputPassword4" class="form-label"><?php echo $_SESSION['STrad295']; ?></label>
	          <select id="selectBasic" class="form-control" name="caletext8" onchange='InstallationAjouSelect(this.value)'>
	            <?php echo InstSelect($caletext8,$ConnexionBdd,"ajou"); ?>
	          </select>
						<div id='DivInstallationAjouSelect'></div>
			    </div>
		    </div>

			</div></div>

			<div class="card mb-5"><div class="card-body">
				<div class="row g-3">
						<div class="col-md-6">
						<label for="inputPassword4" class="form-label"><?php echo $_SESSION['STrad805']; ?></label>
							<div class="form-check form-switch">
								<input type="checkbox" class="form-check-input" name="caletext14" onchange='AfficheCreerEncaissement(this.value)' value="2" id="customSwitchTopLabel" />
								<label class="form-check-label" for="customSwitchTopLabel"><?php echo $_SESSION['STrad806']; ?></label>
							</div>
							<div id='noteAfficheCreerEncaissement'></div>

						</div>

						<div class="col-md-6">
							<div id='noteAffichePaiementCB'></div>
						</div>
				</div>

				<div class="row g-3">
						<label for="inputPassword4" class="form-label"><?php echo $_SESSION['STrad815']; ?></label>
						<?php $_SESSION['NumExecTypePrest'] = $_SESSION['NumExecTypePrest'] + 1;?>
	          <select id="selectBasic" class="form-control" name="typeprestation" onchange='AfficheTypePrestationReservation<?php echo $_SESSION['NumExecTypePrest']; ?>(this.value)'>
	            <?php echo TypePrestSelect(null,null,$ConnexionBdd,null,$AfficheNull,null); ?>
	          </select>

						<div id='DivAfficheTypePrestationReservation<?php echo $_SESSION['NumExecTypePrest']; ?>'></div>
				</div>

			</div></div>

				<?php

			}
		if($num == 4)
			{
				$Lecture.="<input type='radio' name='caletext3' value='1'> ".$_SESSION['STrad717']." ";
				$Lecture.="<input type='radio' name='caletext3' value='2'> ".$_SESSION['STrad716']." ";

				$Lecture.="<tr><td><input type='date' class='champ_barre' name='caledate1' value='".$date1."' required></td></tr>";

				// CHEVAUX
				$Lecture.="<tr><td><select name='chevnum[]' class='champ_barre' id='select3' multiple>".ChevSelect($Dossier,$ConnexionBdd,null,null,null,null,$calenum)."</select></td></tr>";

				// FOURNISSEUR
				$Lecture.="<tr><td><select name='utilnum' class='champ_barre'>".UtilSelect($utilnum,$ConnexionBdd,2,"ajou")."</select></td></tr>";

				// PRESTATION
				$Lecture.="<tr><td><select name='typeprestnum[]' class='champ_barre'>".PrestationsSelect($Dossier,$ConnexionBdd,null,6)."</select></td></tr>";
			}
		if($num == 5)
			{
				// DATE
				$Lecture.="<tr><td><input type='date' class='champ_barre' name='caledate1' value='".$date1."' required></td></tr>";
				// HEURE
				$Lecture.="<input type='time' class='champ_barre' name='caleheure1' value='".$heure1."' required>";

				// FOURNISSEUR
				$Lecture.="<tr><td><select name='utilnum' class='champ_barre'>".UtilSelect($utilnum,$ConnexionBdd,1,"ajou")."</select></td></tr>";

				// CHEVAUX
				$Lecture.="<tr><td><select name='chevnum[]' class='champ_barre' id='select_' multiple>".ChevSelect($Dossier,$ConnexionBdd,null,null,null,null,$calenum)."</select></td></tr>";

			}

		return $Lecture;
	}
//**********************************************

//*********************** CONDITION DE RESERVATION CALENDRIER ******************
function ConditionsReservationEnLigneSelect($num)
	{
		$Lecture.="<option value=''>- Selectionner une condition -</option>";
		$Lecture.="<option value='1'";if($num == 1) {$Lecture.=" selected";} $Lecture.=">".$_SESSION['STrad811']."</option>";
		$Lecture.="<option value='2'";if($num == 2) {$Lecture.=" selected";} $Lecture.=">".$_SESSION['STrad812']."</option>";
		$Lecture.="<option value='3'";if($num == 3) {$Lecture.=" selected";} $Lecture.=">".$_SESSION['STrad813']."</option>";
		$Lecture.="<option value='4'";if($num == 4) {$Lecture.=" selected";} $Lecture.=">".$_SESSION['STrad814']."</option>";
		$Lecture.="<option value='5'";if($num == 5) {$Lecture.=" selected";} $Lecture.=">".$_SESSION['STrad817']."</option>";
		$Lecture.="<option value='6'";if($num == 6) {$Lecture.=" selected";} $Lecture.=">".$_SESSION['STrad816']."</option>";

		return $Lecture;
	}
function ConditionsReservationEnLigneLect($num)
	{
		if($num == 1) {$Lecture=$_SESSION['STrad811'];}
		if($num == 2) {$Lecture=$_SESSION['STrad812'];}
		if($num == 3) {$Lecture=$_SESSION['STrad813'];}
		if($num == 4) {$Lecture=$_SESSION['STrad814'];}
		if($num == 5) {$Lecture=$_SESSION['STrad817'];}
		if($num == 6) {$Lecture=$_SESSION['STrad816'];}

		return $Lecture;
	}
//******************************************************

//*********************** NOMBRE DE PERSONNE MAXIMUM ******************
function NbMaxPersonne($num)
	{
		$Lecture.="<option value = ''>-- ".$_SESSION['STrad740']." --</option>";
			for ($i = 1 ; $i <= 50 ; $i++)
				{
					$Lecture.="<option value='".$i."'";if($i == $num) {$Lecture.=" selected";} $Lecture.=">".$i."</option>";
				}
		return $Lecture;
	}
//******************************************************

//********************** RESTAURATION *************************
function RestaurationSelect($num)
	{
		$Lecture.="<option value=''>-- ".$_SESSION['STrad284']." --</option>";
		$Lecture.="<option value='1'";if($num == 1) {$Lecture.=" selected";} $Lecture.=">".$_SESSION['STrad285']."</option>";
		$Lecture.="<option value='2'";if($num == 2) {$Lecture.=" selected";} $Lecture.=">".$_SESSION['STrad286']."</option>";

		return $Lecture;
	}
function Restauration($num)
	{
		if($num == 1) {return $_SESSION['STrad285'];}
		if($num == 2) {return $_SESSION['STrad286'];}

		return $Lecture;
	}
//**************************************************************

//**************** FICHE COMPLET CALENDRIER *******************
function CalendrierFicheComplet($Dossier,$ConnexionBdd,$calenum)
	{
		$req = 'SELECT * FROM calendrier WHERE calenum = "'.$calenum.'"';
		$reqResult = $ConnexionBdd ->query($req) or die ('Erreur SQL !'.$req.'<br />'.mysqli_error());
		$reqAffich = $reqResult->fetch();
		$date1 = formatheure1($reqAffich['caledate1']);
		$date2 = formatheure1($reqAffich['caledate2']);

		$reqCate = 'SELECT * FROM calendrier_categorie WHERE calecatenum = "'.$reqAffich['calendrier_categorie_calecatenum'].'"';
		$reqCateResult = $ConnexionBdd ->query($reqCate) or die ('Erreur SQL !'.$reqCate.'<br />'.mysqli_error());
		$reqCateAffich = $reqCateResult->fetch();

		// CALCUL NOMBRE DE CAVALIER
		$reqCava = 'SELECT distinct(clients_clienum) FROM calendrier_participants WHERE calendrier_calenum = "'.$calenum.'"';
		$reqCavaResult = $ConnexionBdd ->query($reqCava) or die ('Erreur SQL !'.$reqCava.'<br />'.mysqli_error());
		while($reqCavaAffich = $reqCavaResult->fetch()) {$NbCava = $NbCava + 1;}

		// RESERVATION / ANNULATION POUR UN CAVALIER QUI EST LOGGER
		if($_SESSION['connind'] == "clie" OR empty($_SESSION['authconnauthnum']))
			{
				// SI L UTILSIATEUR N'EST PAS LOGGE
				if(empty($_SESSION['authconnauthnum']))
					{

					}
				// SI UTILISATEUR EST LOGGE
				else if(!empty($_SESSION['authconnauthnum']))
					{
						$Commande = CommanderEnLigne($calenum,$_SESSION['connauthnum'],$ConnexionBdd);

						if($Commande[0] == 2) {$Lecture.="<a href='".$Dossier."modules/calendrier/modcaleReservation.php?calenum=".$calenum."' class='AfficheCaleReservation btn btn-primary'><i data-acorn-icon='cursor-default'></i> ".$_SESSION['STrad654']."</a>";}
					}

				$Lecture.="<div id='AfficheCaleReservation'></div>";

				if(!empty($Commande[2]))
					{
						$Lecture.="<div class='alert alert-danger' role='alert'>".$_SESSION['STrad666']."<br>".$Commande[2]."</div>";
					}
			}

	$Lecture.="<div style='height:20px;width:100%;clear:both;display:block;'></div>";

	$Lecture.="<div class='row'>";
	$Lecture.="<div class='col-12 col-xxl-6 mb-5 h-100-card'><div class='card h-100'><div class='card-body row g-0'><div class='col-12'>";
	$Lecture.="<div class='mb-3 cta-3 text-primary'>".RdvLibelle($reqAffich['calenum'],$ConnexionBdd)." - ".$NbCava." ".$_SESSION['STrad297']."</div>";
	$Lecture.="<div class='row gx-2'><div class='col'><div class='text-muted mb-3 mb-sm-0 pe-3'>";
	$Lecture.="<table>";

	if($reqCateAffich['calecatetype'] == 5)
		{
			// CATEGORIE
			$Lecture.="<tr><td>".$_SESSION['STrad273']." :</td><td style='font-size:18px;'>".$reqCateAffich['calecatelibe']."</td></tr>";
		}
	if($reqCateAffich['calecatetype'] == 1 OR $reqCateAffich['calecatetype'] == 2 OR $reqCateAffich['calecatetype'] == 5)
		{
			// DATE
			$Lecture.="<tr><td>".$_SESSION['STrad88']." :</td><td style='font-size:18px;'>".$date1[5]." ".TradMoisNum($date1[4])." ".$date1[3]."</td></tr>";
		}
	if($reqCateAffich['calecatetype'] == 2)
		{
			// DATE FIN
			if($reqCateAffich['calecatetype'] == 2) {$Lecture.="<tr><td style='font-size:18px;'>".$_SESSION['STrad296']." :</td><td>".$date2[5]." ".TradMoisNum($date2[4])." ".$date2[3]."</td></tr>";}
		}
	if($reqCateAffich['calecatetype'] == 1 OR $reqCateAffich['calecatetype'] == 2 OR $reqCateAffich['calecatetype'] == 5)
		{
			// HEURE
			$Lecture.="<tr><td>".$_SESSION['STrad290']." :</td><td style='font-size:18px;'>".$date1[0].":".$date1[1];if($reqCateAffich['calecatetype'] == 2 OR $reqCateAffich['calecatetype'] == 5) {$Lecture.=" / ".$date2[0].":".$date2[1];} $Lecture.="</td></tr>";
		}
	if($reqCateAffich['calecatetype'] == 1 OR $reqCateAffich['calecatetype'] == 2)
		{
			// LIBELLE
			$Lecture.="<tr><td>".$_SESSION['STrad237']." :</td><td style='font-size:18px;'>".RdvLibelle($reqAffich['calenum'],$ConnexionBdd)."</td></tr>";
		}
	if($reqCateAffich['calecatetype'] == 1)
		{
			// DUREE
			$Lecture.="<tr><td>".$_SESSION['STrad291']." :</td><td style='font-size:18px;'>".minute_vers_heure($reqAffich['caletext1'],2)."</td></tr>";
			// NB HEURE DEBITER
			$Lecture.="<tr><td>".$_SESSION['STrad292']." :</td><td style='font-size:18px;'>".minute_vers_heure($reqAffich['caletext9'])."</td></tr>";
		}

	$Lecture.="</table>";

	$Lecture.="</div></div>";

	$Lecture.="<div class='col-12 col-sm-auto d-flex align-items-center position-relative'>";
		// MODIFIER
		if((($reqCateAffich['calecatetype'] == 1 AND $reqAffich['caletext5'] == 1) OR $reqCateAffich['calecatetype'] != 1) AND $_SESSION['connind'] == "util")
			{
				$Lecture.="<a href='".$Dossier."modules/calendrier/modcalemodif.php?calenum=".$reqAffich['calenum']."' class='CaleModif btn btn-icon btn-icon-start btn-white'><i data-acorn-icon='pen'></i> ";
				$Lecture.="<span>".$_SESSION['STrad304']."</span></a>";
			}
	$Lecture.="</div>";

	$Lecture.="</div></div></div></div></div>";
	$Lecture.="<div class='col-12 col-xxl-6 mb-5 h-100-card'><div class='card h-100 bg-gradient-light'><div class='card-body row g-0'><div class='col-12'><div class='row gx-2'><div class='col'><div class='text-muted mb-3 mb-sm-0 pe-3 text-white'>";

		$Lecture.="<table>";

		if($reqCateAffich['calecatetype'] == 1 OR $reqCateAffich['calecatetype'] == 2 OR $reqCateAffich['calecatetype'] == 4)
			{
				// MONITEUR
				$Lecture.="<tr><td>".$_SESSION['STrad269']." :</td><td style='font-size:18px;'>".UtilLect($reqAffich['utilisateurs_utilnum'],$ConnexionBdd)."</td></tr>";
			}
		// DISCIPLINE
		if($reqCateAffich['calecatetype'] == 1 OR $reqCateAffich['calecatetype'] == 2)
			{
				$Lecture.="<tr><td>".$_SESSION['STrad293']." :</td><td style='font-size:18px;'>";

				$Lecture.="<ul>";
					$req1 = 'SELECT * FROM calendrier_discipline WHERE calendrier_calenum = "'.$calenum.'"';
					$req1Result = $ConnexionBdd ->query($req1) or die ('Erreur SQL !'.$req1.'<br />'.mysqli_error());
					while($req1Affich = $req1Result->fetch())
						{
							$Lecture.="<li>".$req1Affich['calediscilibe']."</li>";
						}
					$Lecture.="</ul>";
				$Lecture.="</td></tr>";
			}

		// NIVEAU
		if($reqCateAffich['calecatetype'] == 1 OR $reqCateAffich['calecatetype'] == 2)
			{
				$Lecture.="<tr><td>".$_SESSION['STrad122']." :</td><td style='font-size:18px;'>";
				$Lecture.="<ul>";
					$req1 = 'SELECT * FROM calendrier_niveau WHERE calendrier_calenum = "'.$calenum.'"';
					$req1Result = $ConnexionBdd ->query($req1) or die ('Erreur SQL !'.$req1.'<br />'.mysqli_error());
					while($req1Affich = $req1Result->fetch())
						{
							$Lecture.="<li>".$req1Affich['calenivelibe']."</li>";
						}
					$Lecture.="</ul>";

				$Lecture.="</td></tr>";
			}

		if($reqCateAffich['calecatetype'] == 2)
			{
				// RESTAURATION
				$Lecture.="<tr><td>".$_SESSION['STrad284']." :</td><td style='font-size:18px;'>".Restauration($reqAffich['caletext6'])."</td></tr>";
				$Lecture.="<tr><td>".$_SESSION['STrad287']." :</td><td style='font-size:18px;'>".nl2br($reqAffich['caletext7'])."</td></tr>";
				$Lecture.="<tr><td>".$_SESSION['STrad288']." :</td><td style='font-size:18px;'>".nl2br($reqAffich['caletext9'])."</td></tr>";
				$Lecture.="<tr><td>".$_SESSION['STrad289']." :</td><td style='font-size:18px;'>".nl2br($reqAffich['caletext13'])."</td></tr>";
			}

		if($reqCateAffich['calecatetype'] == 1 OR $reqCateAffich['calecatetype'] == 2)
			{
				// NB PERSONNE MAX
				$Lecture.="<tr><td>".$_SESSION['STrad294']." :</td><td style='font-size:18px;'>".$reqAffich['caletext7']."</td></tr>";
				// LIEU
				$Lecture.="<tr><td>".$_SESSION['STrad295']." :</td><td style='font-size:18px;'>".$reqAffich['caletext8']."</td></tr>";
			}

		// COMMENTAIRE
		$Lecture.="<tr><td>".$_SESSION['STrad86']." :</td><td style='font-size:18px;'>".nl2br($reqAffich['caletext2'])."</td></tr>";

		$Lecture.="</table>";

		$Lecture.="</div></div>";
		$Lecture.="<div class='col-12 col-sm-auto d-flex align-items-center position-relative'>";
		// MODIFIER
		if((($reqCateAffich['calecatetype'] == 1 AND $reqAffich['caletext5'] == 1) OR $reqCateAffich['calecatetype'] != 1) AND $_SESSION['connind'] == "util")
			{
				$Lecture.="<a href='".$Dossier."modules/calendrier/modcalemodif.php?calenum=".$reqAffich['calenum']."' class='CaleModif btn btn-icon btn-icon-start btn-white'><i data-acorn-icon='pen'></i> ";
				$Lecture.="<span>".$_SESSION['STrad304']."</span></a>";
			}
		$Lecture.="</div>";

		$Lecture.="</div></div></div></div></div></div>";



		$Lecture.="<div class='row'>";

		$Lecture.="<div class='col-12 col-xxl-6 mb-5 h-100-card'><div class='card h-100 bg-gradient-light'><div class='card-body row g-0'><div class='col-12'><div class='row gx-2'><div class='col'><div class='text-muted mb-3 mb-sm-0 pe-3 text-white'>";


			// RESERVATION EN LIGNE
			if($reqCateAffich['calecatetype'] == 1)
				{
					$Lecture.="<table>";
					$Lecture.="<tr><td colspan='2'>".$_SESSION['STrad805']."</td></tr>";
					$Lecture.="<tr><td>".$_SESSION['STrad806']." :</td><td style='font-size:18px;'>".AffichQuestOuiNonLect($reqAffich['caletext14'])."</td></tr>";
					$Lecture.="<tr><td>".$_SESSION['STrad807']." :</td><td style='font-size:18px;'>".AffichQuestOuiNonLect($reqAffich['caletext15'])."</td></tr>";
					$Lecture.="<tr><td>".$_SESSION['STrad810']." :</td><td style='font-size:18px;'>";if(!empty($reqAffich['caletext16'])) {$Lecture.=$reqAffich['caletext16']." %";} $Lecture.="</td></tr>";
					$Lecture.="</table>";
					$Lecture.="<div style='height:40px;width:100%;clear:both;display:block;'></div>";
					$Lecture.="<div id='AfficheCalePrestations'>";
					$Lecture.=CalendrierConditions($Dossier,$ConnexionBdd,$calenum);
					$Lecture.="</div>";
				}

			$Lecture.="</div></div>";
			$Lecture.="<div class='col-12 col-sm-auto d-flex align-items-center position-relative'>";
			// MODIFIER
			if((($reqCateAffich['calecatetype'] == 1 AND $reqAffich['caletext5'] == 1) OR $reqCateAffich['calecatetype'] != 1) AND $_SESSION['connind'] == "util")
				{
					$Lecture.="<a href='".$Dossier."modules/calendrier/modcalemodif.php?calenum=".$reqAffich['calenum']."' class='CaleModif btn btn-icon btn-icon-start btn-white'><i data-acorn-icon='pen'></i> ";
					$Lecture.="<span>".$_SESSION['STrad304']."</span></a>";
				}
			$Lecture.="</div>";

			$Lecture.="</div></div></div></div></div>";

		$Lecture.="<div class='col-12 col-xxl-6 mb-5 h-100-card'><div class='card h-100'><div class='card-body row g-0'><div class='col-12'>";
		$Lecture.="<div class='row gx-2'><div class='col'><div class='text-muted mb-3 mb-sm-0 pe-3'>";

		// COMMENTAIRES
		if($_GET['Impression'] != 2 AND !empty($_SESSION['authconnauthnum']))
			{
				$Lecture.="<div id='AfficheCommentairesGenerals' class='AfficheCommentaires mb-3 cta-3 text-primary'";if(!empty($calenum)) {$Lecture.=" style='width:100%;'";} $Lecture.=">";
				$Lecture.="<a href='".$Dossier."modules/divers/AfficheCommentaireGeneral.php?calenum=".$calenum."' class='LoadPage CommGeneAffiche'><div class='LienDefilement1'><i data-acorn-icon='notebook-1'></i> ".$_SESSION['STrad209']."</div></a>";
				$Lecture.="</div>";
			}

		$Lecture.="</div></div>";
		$Lecture.="</div></div></div></div></div>";

		$Lecture.="</div>";

		//*************************** CAVALIERS ***************************
		$Lecture.="<div class='card mb-5'><div class='card-body'>";
		$Lecture.="<div id='CalePartCava'>";
		$Lecture.= CalendrierParticipants($Dossier,$ConnexionBdd,$calenum);
		$Lecture.="</div>";
		$Lecture.="</div></div>";
		//******************************************************

		$Lecture.="<section style='position:fixed;bottom:45%;right:0px;'>";
			// MENU
			$Lecture.="<button type='button' class='btn btn-primary dropdown-toggle mb-1' data-bs-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>".$_SESSION['STrad149']."</button>";
			$Lecture.="<div class='dropdown-menu'>";
			if($_SESSION['connind'] == "util")
				{
					// SUPPRIMER
				  if((($reqCateAffich['calecatetype'] == 1 AND $reqAffich['caletext5'] == 1) OR $reqCateAffich['calecatetype'] != 1)) {$Lecture.="<a class='dropdown-item CaleSupp' data-bs-dismiss='modal' href='".$Dossier."modules/calendrier/modcaleSupp.php?calenum=".$calenum."'>".$_SESSION['STrad155']."</a>";}
					// RECREDITER REPRISE
					if($reqCateAffich['calecatetype'] == 1 AND $reqAffich['caletext5'] == 2) {$Lecture.="<a href='".$Dossier."modules/calendrier/modcaledebitevenement_script.php?calenum=".$reqAffich['calenum']."&crediterpointage=2' class='CaleDebit dropdown-item'>".$_SESSION['STrad301']."</a>";}
					// POINTAGE REPRISE
					if($reqCateAffich['calecatetype'] == 1 AND $reqAffich['caletext5'] == 1) {$Lecture.="<a href='".$Dossier."modules/calendrier/modcalepointage.php?calenum=".$reqAffich['calenum']."' class='CalePointage dropdown-item'>".$_SESSION['STrad302']."</a>";}
					// MODIFIER
					if((($reqCateAffich['calecatetype'] == 1 AND $reqAffich['caletext5'] == 1) OR $reqCateAffich['calecatetype'] != 1)) {$Lecture.="<a href='".$Dossier."modules/calendrier/modcalemodif.php?calenum=".$reqAffich['calenum']."' class='CaleModif dropdown-item'>".$_SESSION['STrad304']."</a>";}
					// ENVOYER UN EMAIL
					if(($reqCateAffich['calecatetype'] == 1 OR $reqCateAffich['calecatetype'] == 2)) {$Lecture.="<a href='".$Dossier."modules/divers/modEnvoyerUnMail.php?calenum=".$reqAffich['calenum']."' class='AfficheCaleEnvoiMail dropdown-item'>".$_SESSION['STrad102']."</a>";}
					// COPIER
					$Lecture.="<a href='".$Dossier."modules/calendrier/modcaleAjouter.php?calenum=".$reqAffich['calenum']."' class='CaleAjouter dropdown-item'>".$_SESSION['STrad772']."</a>";

					$Lecture.="<div class='dropdown-divider'></div>";
				}

			if($_SESSION['ResolutionConnexion1'] > 800)
				{

					$Lecture.="<a href=\"Imprimer\"target=\"popup\" onclick=\"window.open('".$Dossier."modules/calendrier/modcaleImpression.php?calenum=".$calenum."&Impression=2','popup','width=1024px,height=550px,left=100px,top=100px,scrollbars=1');return(false)\" class='dropdown-item'>".$_SESSION['STrad105']."</a>";
				}
			else {$Lecture.="<div class='dropdown-divider'></div>";}

			// RETOUR PLANNING
			$Lecture.="<a href='".$Dossier."modules/calendrier/modcalelist.php?calenum=".$reqAffich['calendrier_categorie_calecatenum']."' class='AfficheCaleFichComplet dropdown-item'>".$_SESSION['STrad802']."</a>";

		$Lecture.="</section>";

		return $Lecture;
	}
//**************************************************************

//****************** AFFICHE TOUS LES PARTICIPANTS D UN EVENEMENT **********************
function CalendrierParticipants($Dossier,$ConnexionBdd,$calenum)
	{
		$req = 'SELECT * FROM calendrier WHERE calenum = "'.$calenum.'"';
		$reqResult = $ConnexionBdd ->query($req) or die ('Erreur SQL !'.$req.'<br />'.mysqli_error());
		$reqAffich = $reqResult->fetch();

		$reqCate = 'SELECT * FROM calendrier_categorie WHERE calecatenum = "'.$reqAffich['calendrier_categorie_calecatenum'].'"';
		$reqCateResult = $ConnexionBdd ->query($reqCate) or die ('Erreur SQL !'.$reqCate.'<br />'.mysqli_error());
		$reqCateAffich = $reqCateResult->fetch();

		if($reqAffich['caletext5'] == 1 AND $reqCateAffich['calecatetype'] == 1 AND $_SESSION['connind'] == "util") {$AutoSupp = 2;}
		else if($reqAffich['caletext5'] == 2 AND $reqCateAffich['calecatetype'] == 1 AND $_SESSION['connind'] == "util") {$AutoSupp = 1;}
		else if(($reqCateAffich['calecatetype'] == 4 OR $reqCateAffich['calecatetype'] == 5) AND $_SESSION['connind'] == "util") {$AutoSupp = 2;}
		else if($reqCateAffich['calecatetype'] == 1 AND $_SESSION['connind'] == "util") {$AutoSupp = 1;}
		else {$AutoSupp = 2;}

		$Lecture.="<div style='height:20px;clear:both;display:block;' class='supp400px supp800px'></div>";

		if(empty($_SESSION['authconnauthnum']))
			{
				$req1 = 'SELECT * FROM calendrier_participants WHERE calendrier_calenum = "'.$calenum.'"';
				$NbPersonne = 0;
				if($reqCateAffich['calecatetype'] == 2) {$req1.=' GROUP BY clients_clienum';}
				$req1.=' ORDER BY calepartnum ASC';
				$req1Result = $ConnexionBdd ->query($req1) or die ('Erreur SQL !'.$req1.'<br />'.mysqli_error());
				while($req1Affich = $req1Result->fetch()) {$NbPersonne = $NbPersonne + 1;}
				if($NbPersonne >= 1)
					{
						$Lecture.="<div class='FormInfoStandard6'>".$_SESSION['STrad667']." ".$NbPersonne." ".$_SESSION['STrad668']."</div>";
					}
			}
		else if(!empty($_SESSION['authconnauthnum']))
			{
				$Lecture.='<table class="table table-bordered">';
				$Lecture.="<thead><tr>";
					if($reqCateAffich['calecatetype'] == 1 OR $reqCateAffich['calecatetype'] == 2)
						{
							$Lecture.="<th scope='col'>".$_SESSION['STrad297']."</th>";
						}
					if($reqCateAffich['calecatetype'] == 4 OR $reqCateAffich['calecatetype'] == 5)
						{
							$Lecture.="<th scope='col'>".$_SESSION['STrad181']."</th>";
							$Lecture.="<th scope='col'>".$_SESSION['STrad86']."</th>";
						}
					if($reqCateAffich['calecatetype'] == 1)
						{
							// NOMBRE D HEURE
							if($_SESSION['conflogvisionheurerestante'] == 2 AND $_SESSION['ResolutionConnexion1'] > 800) {$Lecture.="<th scope='col'>".$_SESSION['STrad298']."</th>";}
							if($_SESSION['ResolutionConnexion1'] > 800)
								{
									$Lecture.="<th scope='col'>".$_SESSION['STrad126']."</th>";
									$Lecture.="<th scope='col'>".$_SESSION['STrad299']."</th>";
									$Lecture.="<th scope='col'>".$_SESSION['STrad782']."</th>";
								}
						}
					if($reqCateAffich['calecatetype'] == 2) {$Lecture.="<th scope='col'></th>";}
				if($AutoSupp == 2 AND $_SESSION['connind'] == "util") {$Lecture.="<th scope='col'></th>";}
				$Lecture.="<tr></thead>";
				$Lecture.="<tbody>";
				$req1 = 'SELECT * FROM calendrier_participants WHERE calendrier_calenum = "'.$calenum.'"';
				if($reqCateAffich['calecatetype'] == 2) {$req1.=' GROUP BY clients_clienum';}
				$req1.=' ORDER BY calepartnum ASC';
				$req1Result = $ConnexionBdd ->query($req1) or die ('Erreur SQL !'.$req1.'<br />'.mysqli_error());
				while($req1Affich = $req1Result->fetch())
					{
						$LienSupp = "<td><a href='".$Dossier."modules/calendrier/modcalepartsupp.php?calenum=".$calenum."&calepartnum=".$req1Affich['calepartnum']."' class='CalePartCava'><i data-acorn-icon='error-circle' data-acorn-size='35'></i>SUPP</a></td>";

						$Lecture.="<tr>";
						// CLIENTS
						if($reqCateAffich['calecatetype'] == 1 OR $reqCateAffich['calecatetype'] == 2)
							{
								$Lecture.="<td><a href='".$Dossier."modules/profil/modprofilfichcomplet1.php?clienum=".$req1Affich['clients_clienum']."' class='LoadPage AfficheFicheProfil1'>".CLieLect($req1Affich['clients_clienum'],$ConnexionBdd)."</a></td>";
							}
						// CHEVAUX
						if($reqCateAffich['calecatetype'] == 4 OR $reqCateAffich['calecatetype'] == 5)
							{
								$Lecture.="<td>".ChevLect($req1Affich['chevaux_chevnum'],$ConnexionBdd)."</td>";
								$Lecture.="<td>".$req1Affich['caleparttext2']."</td>";
							}
						if($reqCateAffich['calecatetype'] == 1)
							{
								// NOMBRE D HEURE
								if($_SESSION['conflogvisionheurerestante'] == 2)
									{
										$SoldForf = CalcNbHeureForfValide($req1Affich['clients_clienum'],null,null,$ConnexionBdd);
										$Lecture.="<td>".$SoldForf[0]."</td>";
									}
								if($_SESSION['connind'] == "clie")
									{
										$Lecture.="<td>".ChevLect($req1Affich['chevaux_chevnum'],$ConnexionBdd)."</td>";
										$Lecture.="<td>";
										if($req1Affich['caleparttext1'] == 1 OR $req1Affich['caleparttext1'] == 3) {$Lecture.=$_SESSION['STrad695'];}
										else {$Lecture.=ReprisePresenceLect($req1Affich['caleparttext2']);}
										$Lecture.="</td>";
										$Lecture.="<td>".minute_vers_heure($req1Affich['calepartnbdebit'])."</td>";
									}
								else if($_SESSION['connind'] == "util")
									{
										if($_SESSION['ResolutionConnexion1'] <= 800)
											{
												$Lecture.="</tr><tr>";
											}

										$_SESSION['NumExecPrest'] = $_SESSION['NumExecPrest'] + 1;
										// CHEVAUX
										$Lecture.="<td>";
											if($reqAffich['caletext5'] == 1 AND $reqCateAffich['calecatetype'] == 1) {$Lecture.="<select name='chevnum' class='form-control' onchange='CalePartChevnumSelect".$_SESSION['NumExecPrest']."(this.value)'>".ChevSelect($Dossier,$ConnexionBdd,$req1Affich['chevaux_chevnum'],$req1Affich['clients_clienum'],null,$req1Affich['calepartnum'])."</select><div id='DivCalePartChevnumSelect".$_SESSION['NumExecPrest']."'></div>";}
											if($reqAffich['caletext5'] == 2 AND $reqCateAffich['calecatetype'] == 1) {$Lecture.=ChevLect($req1Affich['chevaux_chevnum'],$ConnexionBdd);}
										$Lecture.="</td>";

										// STATUS CAVALIER
										$Lecture.="<td>";
											if($reqAffich['caletext5'] == 1 AND $reqCateAffich['calecatetype'] == 1) {$Lecture.="<select name='caleparttext2' class='form-control' onchange='CalePartText2Select".$_SESSION['NumExecPrest']."(this.value)'>".ReprisePresenceSelect($req1Affich['caleparttext2'],$req1Affich['calepartnum'])."</select><div id='DivCalePartText2Select".$_SESSION['NumExecPrest']."'></div>";}
											if($reqAffich['caletext5'] == 2 AND $reqCateAffich['calecatetype'] == 1) {$Lecture.=ReprisePresenceLect($req1Affich['caleparttext2']);}
										$Lecture.="</td>";

										if($_SESSION['ResolutionConnexion1'] <= 800)
											{
												$Lecture.="</tr><tr>";
											}

										// NOMBRE D'HEURE À DEBITER
										$Lecture.="<td>";
											if($reqAffich['caletext5'] == 1 AND $reqCateAffich['calecatetype'] == 1) {$Lecture.="<select name='calepartnbdebit' class='form-control' onchange='CalePartNbDebitSelect".$_SESSION['NumExecPrest']."(this.value)'>".DureeRepriseDebit($req1Affich['calepartnbdebit'],$req1Affich['calepartnum'])."</select>";}
											if($reqAffich['caletext5'] == 2 AND $reqCateAffich['calecatetype'] == 1) {$Lecture.=minute_vers_heure($req1Affich['calepartnbdebit']);}
										$Lecture.="</td>";
									}
								if($AutoSupp == 2 AND $_SESSION['connind'] == "util") {$Lecture.=$LienSupp;}
							}

							if($reqCateAffich['calecatetype'] == 4 OR $reqCateAffich['calecatetype'] == 5)
								{
									if($AutoSupp == 2) {$Lecture.="<td><a href='".$Dossier."modules/calendrier/modcalepartsupp.php?calenum=".$calenum."&calepartnum=".$req1Affich['calepartnum']."' class='LoadPage CalePartCava'>supp</a></td>";}
									$Lecture.="</tr>";
								}

							if($reqCateAffich['calecatetype'] == 2)
								{
									$Lecture.="<td>";
										$req2 = 'SELECT * FROM calendrier_participants WHERE calendrier_calenum = "'.$calenum.'" AND clients_clienum = "'.$req1Affich['clients_clienum'].'" AND calepartdate1 != "0000-00-00 00:00:00"';
										$req2Result = $ConnexionBdd ->query($req2) or die ('Erreur SQL !'.$req2.'<br />'.mysqli_error());
										while($req2Affich = $req2Result->fetch())
											{
												$dateCalc = formatheure1($req2Affich['calepartdate1']);
												$heure = $dateCalc[0].":".$dateCalc[1];
												$Lecture.="<div style='width:20%;float:left;'>".$heure."</div>";
												$Lecture.="<select name='chevnum' class='champ_barre' style='width:70%;float:left;' onchange='CalePartChevnumSelect".$_SESSION['NumExecPrest']."(this.value)'>".ChevSelect($Dossier,$ConnexionBdd,$req2Affich['chevaux_chevnum'],$req2Affich['clients_clienum'],2,$req2Affich['calepartnum'])."</select>";
												$Lecture.="<div style='width:10%;float:left;'><center><a href='".$Dossier."modules/calendrier/modcalepartsupp.php?calenum=".$calenum."&calepartnum=".$req2Affich['calepartnum']."' class='LoadPage CalePartCava'><img src='".$Dossier."images/supprimer.png' class='ImgSousMenu2'></a></center></div>";
												$Lecture.="<br>";
											}
										$Lecture.="<div style='width:100%;clear:both;display:block;'><a href='".$Dossier."modules/calendrier/modcaleajoucreneau.php?calenum=".$calenum."&clienum=".$req1Affich['clients_clienum']."' class='LoadPage CaleAjouCreneau".$_SESSION['NumExecCreneau']."'><img src='".$Dossier."images/ajouter.png' class='ImgSousMenu2'>".$_SESSION['STrad314']."</a></div>";
										$Lecture.="<div id='CaleAjouCreneau".$_SESSION['NumExecCreneau']."'></div>";
									$Lecture.="</td>";
									$_SESSION['NumExecCreneau'] = $_SESSION['NumExecCreneau'] + 1;
								}

						$Lecture.="</tr>";

						// MOTIF DU REFUS DE RESERVATION
						if($_SESSION['connind'] == "clie") {$VerifFamiOK = VerifClienumOK($Dossier,$ConnexionBdd,$req1Affich['clients_clienum']);}

						if($req1Affich['caleparttext2'] == 7 AND !empty($req1Affich['calepartannulerraison']) AND ($_SESSION['connind'] == "util" OR ($_SESSION['connind'] == "clie" AND $VerifFamiOK == 2)))
							{
								$Lecture.="<tr>";
									$Lecture.="<td colspan='3'><span style='float:right;vertical-align:middle;'>".$_SESSION['STrad784']." : </span></td>";
									$Lecture.="<td colspan='3'><i style='font-style:italic;vertical-align:middle;'>".nl2br($req1Affich['calepartannulerraison'])."</i></td>";
								$Lecture.="</tr>";
							}
					}
				$Lecture.="</tbody>";
				$Lecture.="</table>";
			}

		$Lecture.="<div style='height:20px;clear:both;display:block;'></div>";

		if($_SESSION['connind'] == "util" AND $_GET['Impression'] != 2)
			{
				/*
				if($reqCateAffich['calecatetype'] == 1 OR $reqCateAffich['calecatetype'] == 2)
					{
						$Lecture.="<a href='".$Dossier."modules/calendrier/modcaleajoucavalierdepassage.php?calenum=".$calenum."' class='CaleAjouCavalierDePassage1 LienDefilement1'><i data-acorn-icon='plus' class='text-primary me-1' data-acorn-size='15'></i>".$_SESSION['STrad785']."</a>";
						$Lecture.="<div id='CaleAjouCavalierDePassage1'></div>";
						$Lecture.="<div style='height:20px;'></div>";
					}
				*/

				if($reqCateAffich['calecatetype'] == 1 OR $reqCateAffich['calecatetype'] == 2)
					{
						$Lecture.="<div class='InfoStandard FormInfoStandard1'><i data-acorn-icon='plus' class='text-primary me-1' data-acorn-size='15'></i>".$_SESSION['STrad313']." :</div><br>";
					}
				if($reqCateAffich['calecatetype'] == 4 OR $reqCateAffich['calecatetype'] == 5)
					{
						$Lecture.="<div class='InfoStandard FormInfoStandard1'><i data-acorn-icon='plus' class='text-primary me-1' data-acorn-size='15'></i>".$_SESSION['STrad718']." :</div><br>";
					}
				//$Lecture.="<select name='clienum' class='champ_barre' id='select2'>".ClieSelect($Dossier,$ConnexionBdd,null,null,null,null,null,null,null,null)."</select>";

				$Lecture.="<form id='FormCaleCavaAjou' action=''>";
				$Lecture.="<input type='hidden' name='calenum' value='".$calenum."'>";
				if($reqCateAffich['calecatetype'] == 4 OR $reqCateAffich['calecatetype'] == 5)
					{
						$Lecture.='<select multiple="multiple" id="select2Multiple" name="chevnum[]">';
						$Lecture.=ChevSelect($Dossier,$ConnexionBdd,null,null,null,null);
						$Lecture.="<input type='text' name='caleparttext2' class='champ_barre' placeholder = '".$_SESSION['STrad86']."'>";
						$Lecture.="</select>";
					}
				if($reqCateAffich['calecatetype'] == 1 OR $reqCateAffich['calecatetype'] == 2)
					{
						$Lecture.='<select class="selectBasic" name="clienum[]" style="width:100%;" multiple>';
						$Lecture.=ClieSelect($Dossier,$ConnexionBdd,null,null,null,null,null,null,null,null);
						$Lecture.="</select>";
					}
				$Lecture.="<button type='submit' class='btn btn-primary'>".$_SESSION['STrad307']."</button>";
				$Lecture.="</form>";
			}
		return $Lecture;
	}
//****************************************************

//****************** CALENDRIER CONDITIONS **************************
function CalendrierConditions($Dossier,$ConnexionBdd,$calenum)
	{
		$Lecture.="<div class='cta-3 text-white'>".$_SESSION['STrad825']."</div>";
		$Lecture.="<div style='height:20px;width:100%;clear:both;display:block;'></div>";
		$Lecture.="<table class='table table-bordered' style='color:white;'><tbody>";
		// CONDITION DE RESERVATIONAVEC PRIX
		$reqCond = 'SELECT * FROM calendrier_conditions WHERE calendrier_calenum = "'.$calenum.'"';
		$reqCondResult = $ConnexionBdd ->query($reqCond) or die ('Erreur SQL !'.$reqCond.'<br />'.mysqli_error());
		while($reqCondAffich = $reqCondResult->fetch())
			{
				$Lecture.="<tr>";
				$Lecture.="<td style='color:white;'>".TypePrestationLect($reqCondAffich['typeprestation_typeprestnum'],$ConnexionBdd)."</td>";
				$Lecture.="<td style='color:white;'>".number_format($reqCondAffich['calecondprix'], 2, '.', '')." ".$_SESSION['STrad27']."</td>";
				$Lecture.="<td style='color:white;'>".ConditionsReservationEnLigneLect($reqCondAffich['calecondind'])."</td>";
				if($_SESSION['connind'] == "util") {$Lecture.="<td><a href='".$Dossier."modules/calendrier/modcalePrestConditions.php?calenum=".$calenum."&calecondnum=".$reqCondAffich['calecondnum']."&calecondsupp=2' class='CaleCondSupp' style='color:white;'><i data-acorn-icon='error-circle' data-acorn-size='35'></i>SUPP</a></td>";}
				$Lecture.="</tr>";
			}
		$Lecture.="</tbody></table>";

		if($_SESSION['connind'] == "util")
			{
				$Lecture.="<div class='card mb-5'><div class='card-body'>";
				$Lecture.="<form id='FormCaleConditionAjou' action=''>";
				$Lecture.="<input type='hidden' name='calenum' value='".$calenum."'>";
				$Lecture.="<input type='hidden' name='action' value='ajou'>";
				$_SESSION['NumExecTypePrest'] = $_SESSION['NumExecTypePrest'] + 1;
				$Lecture.="<select id='selectBasic' class='form-control' name='typeprestation' onchange='AfficheTypePrestationReservation".$_SESSION['NumExecTypePrest']."(this.value)'>";
				$Lecture.=TypePrestSelect(null,null,$ConnexionBdd,null,$AfficheNull,null);
				$Lecture.="</select>";

				$Lecture.="<div id='DivAfficheTypePrestationReservation".$_SESSION['NumExecTypePrest']."'></div>";

				$Lecture.="<button type='submit' class='btn btn-primary'>".$_SESSION['STrad160']."</button>";
				$Lecture.="</form>";
				$Lecture.="</div></div>";
			}

		return $Lecture;
	}
//**********************************************************************

//****************** SELECTION DE LA PRESTATION SELON LA CONDITION DU CAVALIER *********************************
function CalendrierConditionsResultatIndice($Dossier,$ConnexionBdd,$Indice,$clienum)
	{
		// LICENCIE
		if($Indice == 1 OR $Indice == 2)
			{
				$Licence = ClientsLicenceValide($Dossier,$Connexion,$clienum);
				if($Indice == 1 AND $Licence = 2) {$Resultat = 2;} else {$Resultat = 1;}
				if($Indice == 2 AND $Licence = 1) {$Resultat = 2;} else {$Resultat = 1;}
			}
		// COTISATION
		if($Indice == 3 OR $Indice == 4)
			{
				$Cotisation = ClientsCotisationValide($Dossier,$Connexion,$clienum);
				if($Indice == 3 AND $Cotisation = 2) {$Resultat = 2;} else {$Resultat = 1;}
				if($Indice == 4 AND $Cotisation = 1) {$Resultat = 2;} else {$Resultat = 1;}
			}

		// + DE 14 ANS OU - DE 14 ANS
		if($Indice == 5 OR $Indice == 6)
			{
				$reqClie = 'SELECT * FROM clients WHERE clienum = "'.$clienum.'"';
				$reqClieResult = $ConnexionBdd ->query($reqClie) or die ('Erreur SQL !'.$reqClie.'<br />'.mysqli_error());
				$reqClieAffich = $reqClieResult->fetch();

				if(!empty($reqClieAffich['cliedatenaiss']) OR $reqClieAffich['cliedatenaiss'] != "0000-00-00")
					{
						$Age = CalcAge($reqClieAffich['cliedatenaiss']);

						if($Indice == 5 AND $Age <= 14) {$Resultat = 2;}
						if($Indice == 5 AND $Age > 14) {$Resultat = 2;}
					}
				else {$Resultat = 1;}
			}

		return $Resultat;
	}
function CalendrierConditionsResultat($Dossier,$ConnexionBdd,$calenum,$clienum)
	{
		$reqCond = 'SELECT count(calecondnum),calecondnum FROM calendrier_conditions WHERE calendrier_calenum = "'.$calenum.'" ORDER BY calecondprix ASC';
		$reqCondResult = $ConnexionBdd ->query($reqCond) or die ('Erreur SQL !'.$reqCond.'<br />'.mysqli_error());
		$reqCondAffich = $reqCondResult->fetch();

		if($reqCondAffich[0] == 1)
			{
				$calecondnum = $reqCondAffich[1];
			}

		if($reqCondAffich[0] >= 2)
			{
				$reqCond = 'SELECT * FROM calendrier_conditions WHERE calendrier_calenum = "'.$calenum.'" ORDER BY calecondprix ASC';
				$reqCondResult = $ConnexionBdd ->query($reqCond) or die ('Erreur SQL !'.$reqCond.'<br />'.mysqli_error());
				while($reqCondAffich = $reqCondResult->fetch())
					{
						$Resultat = CalendrierConditionsResultatIndice($Dossier,$ConnexionBdd,$reqCondAffich['calecondind'],$clienum);

						if($Resultat == 2)
							{
								$calecondnum = $reqCondAffich['calecondnum'];
								break;
							}
					}
			}

		if(empty($calecondnum))
			{
				$reqCond = 'SELECT * FROM calendrier_conditions WHERE calendrier_calenum = "'.$calenum.'" ORDER BY calecondprix ASC';
				$reqCondResult = $ConnexionBdd ->query($reqCond) or die ('Erreur SQL !'.$reqCond.'<br />'.mysqli_error());
				while($reqCondAffich = $reqCondResult->fetch())
					{
						if(empty($reqCondAffich['calecondind ']))
							{
								$calecondnum = $reqCondAffich['calecondnum'];
							}
					}
			}

		return $calecondnum;
	}
//**********************************************************************

//****************** POINTAGE CARTE FORFAIT *************************
function CalePointageReprise($clienum,$duree,$date,$calepartnum,$ConnexionBdd)
	{
		if(empty($date)) {$dateSelect = date('Y-m-d');}
		else {$dateSelect = formatheure1($date);$dateSelect = $dateSelect[3]."-".$dateSelect[4]."-".$dateSelect[5];}

		$req = 'SELECT cliesoldforfentrnum,cliesoldforfentrnbheure,cliesoldforfentrdate1,cliesoldforfentrdate2,cliesoldforfentrlibe FROM clientssoldeforfentree,clientssoldeforfentree_clients WHERE clientssoldeforfentree_cliesoldforfentrnum = cliesoldforfentrnum AND clients_clienum = "'.$clienum.'" AND cliesoldforfentrdate2 >= "'.$dateSelect.'" AND cliesoldforfentrdate1 <= "'.$dateSelect.'" ORDER BY cliesoldforfentrdate1 ASC';
		$reqResult = $ConnexionBdd ->query($req) or die ('Erreur SQL !'.$req.'<br />'.mysqli_error());
		while($reqAffich = $reqResult->fetch())
			{
				$req1 = 'SELECT sum(cliesoldforfsortnbheure) FROM clientssoldeforfsortie WHERE clientssoldeforfentree_cliesoldforfentrnum = "'.$reqAffich[0].'"';
				$req1Result = $ConnexionBdd ->query($req1) or die ('Erreur SQL !'.$req1.'<br />'.mysqli_error());
				$req1Affich = $req1Result->fetch();

				$NbHeure = $reqAffich[1]-$req1Affich[0];

				/************ LISTE LES DATES D EXCLUSION *************/
				$req2 = 'SELECT count(cliesoldforfcliedatenum) FROM clientssoldeforfentree_date WHERE cliesoldforfcliedatedate1 <= "'.$date.'" AND cliesoldforfcliedatedate2 >= "'.$date.'" AND clientssoldeforfentree_cliesoldforfentrnum = "'.$reqAffich[0].'"';
				$req2Result = $ConnexionBdd ->query($req2) or die ('Erreur SQL !'.$req2.'<br />'.mysqli_error());
				$req2Affich = $req2Result->fetch();
				if($req2Affich[0] == 0) {$DateOk = 2;}
				else {$DateOk = 1;}
				/******************************************************/

				if($NbHeure > 0 AND $NbHeure >= $duree AND $DateOk == 2)
					{
						$Lecture.= "<option value='".$reqAffich[0];if(!empty($calepartnum)) {$Lecture.="|".$calepartnum;} $Lecture.="'>".$reqAffich[4]." : <b>".minute_vers_heure($NbHeure)."</b></option>";
					}
			}

		$Lecture.= "<option value='NULL";
		if(!empty($calepartnum)) {$Lecture.="|".$calepartnum;}

		$Lecture.="' style='background-color:red;'>".$_SESSION['STrad781']."</option>";

		return $Lecture;
	}
//****************************************************************

//***************** LISTER MODELE DE REPRISE ********************
function ModeleReprises($Dossier,$ConnexionBdd)
	{
		if(empty($_GET['planlecomodsupp'])) {$_GET['planlecomodsupp'] = 1;}
		$req1 = 'SELECT * FROM planning_lecon_modele WHERE AA_equimondo_hebeappnum = "'.$_SESSION['hebeappnum'].'" AND planlecomodsupp = "'.$_GET['planlecomodsupp'].'" ORDER BY planlecomodjour ASC';
		$req1Result = $ConnexionBdd ->query($req1) or die ('Erreur SQL !'.$req1.'<br />'.mysqli_error());
		while($req1Affich = $req1Result->fetch())
			{
				$HeureCalc = formatheure1("0000-00-00 ".$req1Affich['planlecomodheure']);
				$Color = RdvColor(null,$ConnexionBdd,$req1Affich['utilisateurs_utilnum']);

				if($_SESSION['ResolutionConnexion1'] < 800)
					{
						$Lien = "<a href='".$Dossier."modules/calendrier/modcaleModeleFicheComplet1.php?planlecomodnum=".$req1Affich['planlecomodnum']."' class='LoadPage ModeleFicheComplet1'>";
					}
				else
					{
						$Lien = "<a href='".$Dossier."modules/calendrier/modcaleModeleFicheComplet2.php?planlecomodnum=".$req1Affich['planlecomodnum']."' class='LoadPage ModeleFicheComplet2'>";
					}

				$Lecture.="<input type='checkbox' name='planlecomodnum[]' value='".$req1Affich['planlecomodnum']."'>".$Lien."<section style='width:100%;clear:both;display:block;background-color:".$Color.";pading:5px;height:120px;border-style:solid;border-width:0 0 1 0;border-color:white'>";
				$Lecture.="<div style='height:10px;'></div>";

				$Lecture.=$_SESSION['STrad377']." ".AfficheJours($req1Affich['planlecomodjour'])."<br>";
				$Lecture.="<section style='width:100%;clear:both;display:block;'>";
					$Lecture.="<div style='float:left;width:48%;margin-left:1%;margin-right:1%;'>".$req1Affich['planlecomodlibe']."</div>";
					$Lecture.="<div style='float:left;width:48%;margin-left:1%;margin-right:1%;'>".$HeureCalc[0].":".$HeureCalc[1]."</div>";
				$Lecture.="</section>";
				$Lecture.="<div style='height:10px;'></div>";
				$Lecture.="<section style='width:100%;clear:both;display:block;'>";
					$Lecture.="<div style='float:left;width:48%;margin-left:1%;margin-right:1%;'>".UtilLect($req1Affich['utilisateurs_utilnum'],$ConnexionBdd)."</div>";
					$Lecture.="<div style='float:left;width:48%;margin-left:1%;margin-right:1%;'>".minute_vers_heure($req1Affich['planlecomodduree'],2)."</div>";
				$Lecture.="</section>";

				$Lecture.="<div style='height:10px;'></div>";
				$Lecture.="</section></a>";
			}

		return $Lecture;
	}
//****************************************************************

//***************** FICHE COMPLET MODELE DE REPRISE ***********************
function ModeleFicheComplet($Dossier,$ConnexionBdd,$planlecomodnum)
	{
		$Lecture.="<div style='height:15px;clear:both;display:block;'></div>";

		$req1 = 'SELECT * FROM planning_lecon_modele WHERE planlecomodnum = "'.$planlecomodnum.'"';
		$req1Result = $ConnexionBdd ->query($req1) or die ('Erreur SQL !'.$req1.'<br />'.mysqli_error());
		$req1Affich = $req1Result->fetch();

		// REPLIQUER LE MODELE
		if($_SESSION['ResolutionConnexion1'] <= 800) {$LibeButt = $_SESSION['STrad789'];} else {$LibeButt = $_SESSION['STrad445'];}
		$SousMenuCorp.="<div class='buttonBasMenuFixedRub'><a href='".$Dossier."modules/calendrier/modcaleModeleRepliquer.php?planlecomodnum=".$planlecomodnum."' class='button LoadPage ModeleRepliquer'><img src='".$Dossier."images/copierBlanc.png' class='ImgSousMenu2 supp400px supp800px'>".$LibeButt."</a></div>";

		// MODIFIER LE MODELE
		if($_SESSION['ResolutionConnexion1'] <= 800) {$LibeButt = $_SESSION['STrad704'];} else {$LibeButt = $_SESSION['STrad304'];}
		$SousMenuCorp.="<div class='buttonBasMenuFixedRub'><a href='".$Dossier."modules/calendrier/modcaleModeleRepliquerAjou.php?planlecomodnum=".$planlecomodnum."' class='button LoadPage ModeleRepliquerAjou'><img src='".$Dossier."images/modifierBlanc.png' class='ImgSousMenu2 supp400px supp800px'>".$LibeButt."</a></div>";

		if($req1Affich['planlecomodsupp'] == 1)
			{
				// ARCHIVER LE MODELE
				if($_SESSION['ResolutionConnexion1'] <= 800) {$LibeButt = $_SESSION['STrad790'];} else {$LibeButt = $_SESSION['STrad760'];}
				$SousMenuCorp.="<div class='buttonBasMenuFixedRub'><a href='".$Dossier."modules/calendrier/modcaleModeleSupp.php?planlecomodnum=".$planlecomodnum."&planlecomodsupp=2' class='button LoadPage ModeleSupp1'><img src='".$Dossier."images/supprimerBlanc.png' class='ImgSousMenu2 supp400px supp800px'>".$LibeButt."</a></div>";
			}
		if($req1Affich['planlecomodsupp'] == 2)
			{
				// RE ACTIVER CE MODELE
				if($_SESSION['ResolutionConnexion1'] <= 800) {$LibeButt = $_SESSION['STrad791'];} else {$LibeButt = $_SESSION['STrad761'];}
				$SousMenuCorp.="<div class='buttonBasMenuFixedRub'><a href='".$Dossier."modules/calendrier/modcaleModeleSupp.php?planlecomodnum=".$planlecomodnum."&planlecomodsupp=1' class='button LoadPage ModeleSupp1'><img src='".$Dossier."images/supprimerBlanc.png' class='ImgSousMenu2 supp400px supp800px'>".$LibeButt."</a></div>";
			}

		$Lecture.="<div class='supp400px supp800px'>";
		$Lecture.=$SousMenuCorp;
		$Lecture.="</div>";

		$ResultatTailleWidth = "24";
		$SousMenuCorp = str_replace("<div class='buttonBasMenuFixedRub'>","<div class='buttonBasMenuFixedRub' style='width:".$ResultatTailleWidth."%;'>",$SousMenuCorp);
		$Lecture.="<div class='buttonBasMenuFixed'>";
		$Lecture.=$SousMenuCorp;
		$Lecture.="</div>";

		$Lecture.="<div style='height:25px;clear:both;display:block;'></div>";

		$HeureCalc = formatheure1("0000-00-00 ".$req1Affich['planlecomodheure']);

		$Lecture.="<section style='width:100%;clear:both;display:block;'>";
			$Lecture.="<section class='PartieGauche'>";
			$Lecture.="<table>";
				// CATEGORIE
				$Lecture.="<tr>";
					$Lecture.="<td>".$_SESSION['STrad273']." :</td>";
					$Lecture.="<td>".CaleCateLect($req1Affich['calendrier_categorie_calecatenum'],$ConnexionBdd)."</td>";
				$Lecture.="</tr>";
				// LIBELEE
				$Lecture.="<tr>";
					$Lecture.="<td>".$_SESSION['STrad237']." :</td>";
					$Lecture.="<td>".$req1Affich['planlecomodlibe']."</td>";
				$Lecture.="</tr>";
				// TOUS LES DIMANCHE
				$Lecture.="<tr>";
					$Lecture.="<td>".$_SESSION['STrad377']." :</td>";
					$Lecture.="<td>".AfficheJours($req1Affich['planlecomodjour'])."</td>";
				$Lecture.="</tr>";
				// SEMAINE PAIR, IMPAIR, TOUS LES SEMAINES
				$Lecture.="<tr>";
					$Lecture.="<td>".$_SESSION['STrad431']." :</td>";
					$Lecture.="<td>".SemainePairImpairLect($req1Affich['planlecomodrepliquer'])."</td>";
				$Lecture.="</tr>";
				// HEURE
				$Lecture.="<tr>";
					$Lecture.="<td>".$_SESSION['STrad290']." :</td>";
					$Lecture.="<td>".$HeureCalc[0].":".$HeureCalc[1]."</td>";
				$Lecture.="</tr>";
				// DUREE
				$Lecture.="<tr>";
					$Lecture.="<td>".$_SESSION['STrad291']." :</td>";
					$Lecture.="<td>".minute_vers_heure($req1Affich['planlecomodduree'],2)."</td>";
				$Lecture.="</tr>";
				// DUREE A DEBITER
				$Lecture.="<tr>";
					$Lecture.="<td>".$_SESSION['STrad292']." :</td>";
					$Lecture.="<td>".minute_vers_heure($req1Affich['planlecomoddureeabebiter'])."</td>";
				$Lecture.="</tr>";
			$Lecture.="</table>";
			$Lecture.="</section>";

			$Lecture.="<section class='PartieDroite'>";
			$Lecture.="<table>";
				// DISCIPLINE
				$Lecture.="<tr>";
					$Lecture.="<td>".$_SESSION['STrad293']." :</td>";
					$Lecture.="<td>".$req1Affich['planlecomodcategorie']."</td>";
				$Lecture.="</tr>";
				// MONITEURS
				$Lecture.="<tr>";
					$Lecture.="<td>".$_SESSION['STrad435']." :</td>";
					$Lecture.="<td>".UtilLect($req1Affich['utilisateurs_utilnum'],$ConnexionBdd)."</td>";
				$Lecture.="</tr>";
				// NIVEAU
				$Lecture.="<tr>";
					$Lecture.="<td>".$_SESSION['STrad122']." :</td>";
					$Lecture.="<td>".$req1Affich['planlecomodniveau1']." ".$req1Affich['planlecomodniveau2']."</td>";
				$Lecture.="</tr>";
				// NOMBRE DE PERSONNE AUTORISE
				$Lecture.="<tr>";
					$Lecture.="<td>".$_SESSION['STrad294']." :</td>";
					$Lecture.="<td>".$req1Affich['planlecomodnbmaxpers']."</td>";
				$Lecture.="</tr>";
				// LIEU
				$Lecture.="<tr>";
					$Lecture.="<td>".$_SESSION['STrad295']." :</td>";
					$Lecture.="<td>".$req1Affich['planlecomodinstal']."</td>";
				$Lecture.="</tr>";
				// COMMENTAIRE
				$Lecture.="<tr>";
					$Lecture.="<td>".$_SESSION['STrad86']." :</td>";
					$Lecture.="<td>".nl2br($req1Affich['planlecomoddesc'])."</td>";
				$Lecture.="</tr>";
			$Lecture.="</table>";
			$Lecture.="</section>";
		$Lecture.="</section>";

		$Lecture.="<section style='width:100%;clear:both;display:block;'>";
		$Lecture.="<div style='height:20px;'></div>";

		// CAVALIERS ASSOCIES AU MODELE
			$Lecture.="<section id='AfficheModeleClientsAssocie' class='PartieGauche'>";
				$Lecture.=AfficheModeleClientsAssocie($Dossier,$ConnexionBdd,$planlecomodnum);
			$Lecture.="</section>";
		// REPRISES ASSOCIER
			$Lecture.="<section id='AfficheModeleReprisesAssocie' class='PartieGauche'>";
				$Lecture.="<div id='ModeleDateExclusion'>";
					$Lecture.=ModeleDateExclu($Dossier,$ConnexionBdd,$planlecomodnum);
				$Lecture.="</div>";
				$Lecture.="<div style='height:20px;'></div>";
					$Lecture.=AfficheModeleReprisesAssociees($Dossier,$ConnexionBdd,$planlecomodnum);
			$Lecture.="</section>";

		$Lecture.="</section>";

		$Lecture.="<div style='height:100px;width:97%;clear:both;display:block;'></div>";

		return $Lecture;
	}
//****************************************************************

//********************** MODELE CAVALIERS ASSOCIER ************************
function AfficheModeleClientsAssocie($Dossier,$ConnexionBdd,$planlecomodnum)
	{
		$Lecture.="<div class='InfoStandard FormInfoStandard1'><img src='".$Dossier."images/informationBlanc.png' class='imgSousMenu1' style='margin-right:10px;'>".$_SESSION['STrad739']." :</div>";

		$req2 = 'SELECT count(plancliechevmodnum) FROM planning_clients_chevaux_modele WHERE planning_lecon_modele_planlecomodnum = "'.$planlecomodnum.'"';
		$req2Result = $ConnexionBdd ->query($req2) or die ('Erreur SQL !'.$req2.'<br />'.mysqli_error());
		$req2Affich = $req2Result->fetch();
		if($req2Affich[0] == 0)
			{
				$Lecture.="<div class='InfoStandard FormInfoStandard1'><img src='".$Dossier."images/informationBlanc.png' class='imgSousMenu1' style='margin-right:10px;'>".$_SESSION['STrad436']."</div>";
			}
		else if($req2Affich[0] >= 1)
			{
				$Lecture.="<table>";
				$req2 = 'SELECT * FROM planning_clients_chevaux_modele WHERE planning_lecon_modele_planlecomodnum = "'.$planlecomodnum.'"';
				$req2Result = $ConnexionBdd ->query($req2) or die ('Erreur SQL !'.$req2.'<br />'.mysqli_error());
				while($req2Affich = $req2Result->fetch())
					{
						$Lecture.="<tr>";
						$Lecture.="<td>".ClieLect($req2Affich['clients_clienum'],$ConnexionBdd)."</td>";
						$Lecture.="<td><a href='".$Dossier."modules/calendrier/modcaleModeleClientsSupp.php?planlecomodnum=".$planlecomodnum."&plancliechevmodnum=".$req2Affich['plancliechevmodnum']."' class='LoadPage ModeleClientsSupp'><img src='".$Dossier."images/supprimer.png' class='ImgSousMenu2'></a></td>";
						$Lecture.="</tr>";
					}
				$Lecture.="</table>";
			}

		$Lecture.="<div style='height:15px;'></div>";
		$Lecture.="<div class='InfoStandard FormInfoStandard1'><img src='".$Dossier."images/informationBlanc.png' class='imgSousMenu1' style='margin-right:10px;'>".$_SESSION['STrad437']." :</div><br>";
		$Lecture.="<form id='FormModeleCavaAjou' action=''>";
		$Lecture.="<input type='hidden' name='planlecomodnum' value='".$planlecomodnum."'>";
		$Lecture.="<td><select id='select4' name='clienum[]' multiple>";
		$Lecture.=ClieSelect($Dossier,$ConnexionBdd,$clienum,$faminum,$factnum,$AfficheNull,$AjouterClientPassage,$calenum,$chevnum,$AfficherAjouCava);
		$Lecture.="</select>";
		$Lecture.="<input type='checkbox' name='synchroniser' value='2' checked> ".$_SESSION['STrad444'];
		$Lecture.="<div style='height:15px;'></div>";
		$Lecture.="<button class='button'><img src='".$Dossier."images/ajouterBlanc.png' class='ImgSousMenu2'>".$_SESSION['STrad160']."</button>";
		$Lecture.="</form>";

		return $Lecture;
	}
//****************************************************************

//********************* REPRISES ASSOCIES **************************
function AfficheModeleReprisesAssociees($Dossier,$ConnexionBdd,$planlecomodnum)
	{
		$Lecture.="<div class='InfoStandard FormInfoStandard1'><img src='".$Dossier."images/informationBlanc.png' class='imgSousMenu1' style='margin-right:10px;'>".$_SESSION['STrad438']." :</div>";

		$req2 = 'SELECT count(calenum) FROM planning_modele_calendrier,calendrier WHERE planning_lecon_modele_planlecomodnum= "'.$planlecomodnum.'" AND calendrier_calenum = calenum';
		$req2Result = $ConnexionBdd ->query($req2) or die ('Erreur SQL !'.$req2.'<br />'.mysqli_error());
		$req2Affich = $req2Result->fetch();
		if($req2Affich[0] >= 1)
			{
				$Lecture.="<form id='ModeleCaleAssocie' action=''>";
				$Lecture.="<input type='hidden' name='planlecomodnum' value='".$planlecomodnum."'>";
				$Lecture.="<table class='tab_rubrique'>";
				$Lecture.="<thead><tr>";
					$Lecture.="<td>".$_SESSION['STrad441']."</td>";
					$Lecture.="<td>".$_SESSION['STrad442']."</td>";
					$Lecture.='<td><input onclick="CocheTout(this, \'calenum[]\');" type="checkbox"></td>';
				$Lecture.="</tr></thead>";
				$Lecture.="<tbody>";
				$req2 = 'SELECT * FROM planning_modele_calendrier,calendrier WHERE planning_lecon_modele_planlecomodnum= "'.$planlecomodnum.'" AND calendrier_calenum = calenum ORDER BY caledate1 DESC';
				$req2Result = $ConnexionBdd ->query($req2) or die ('Erreur SQL !'.$req2.'<br />'.mysqli_error());
				while($req2Affich = $req2Result->fetch())
					{
						$status = AfficheCaleStatus($Dossier,$ConnexionBdd,$req2Affich['calenum']);
						$Lecture.="<tr>";
							$Lecture.="<td><a href='".$Dossier."modules/calendrier/modcalefichcomplet.php?calenum=".$req2Affich['calenum']."' class='LoadPage AfficheCaleFichComplet'>".formatdatemysql($req2Affich['caledate1'])."</a></td>";
							$Lecture.="<td><a href='".$Dossier."modules/calendrier/modcalefichcomplet.php?calenum=".$req2Affich['calenum']."' class='LoadPage AfficheCaleFichComplet'>".$status[2]."</a></td>";
							$Lecture.="<td><input type='checkbox' name='calenum[]' value='".$req2Affich['calenum']."'></td>";
						$Lecture.="</tr>";
					}
				$Lecture.="<tr><td colspan='3'><button class='button' style='float:right;'><img src='".$Dossier."images/supprimerBlanc.png' class='ImgSousMenu2'></button></td></tr>";
				$Lecture.="</tbody>";
				$Lecture.="</table>";
				$Lecture.="</form>";
			}
		else
			{
				$Lecture.="<div class='InfoStandard'>".$_SESSION['STrad443']."</div>";
			}

		return $Lecture;
	}
//****************************************************************

// ************************** STATUS REPRISES ************************
function AfficheCaleStatus($Dossier,$ConnexionBdd,$calenum)
	{
		$req1 = 'SELECT * FROM calendrier WHERE calenum = "'.$calenum.'"';
		$req1Result = $ConnexionBdd ->query($req1) or die ('Erreur SQL !'.$req1.'<br />'.mysqli_error());
		$req1Affich = $req1Result->fetch();

		if($req1Affich['caletext5'] == 1)
			{
				$status = $req1Affich['caletext5'];
				$color = "green";
				$AfficheResultat = "<span style='color:green'>".$_SESSION['STrad439']."</span>";
			}
		else if($req1Affich['caletext5'] == 2)
			{
				$status = $req1Affich['caletext5'];
				$color = "red";
				$AfficheResultat = "<span style='color:red'>".$_SESSION['STrad440']."</span>";
			}

		return array($status,$color,$AfficheResultat);
	}
//****************************************************************

// ************************** REPLICATION MODE DE REPRISE ************************
function SemainePairImpairLect($num)
	{
		if($num == 1) {$Lecture.=$_SESSION['STrad432'];}
		if($num == 2) {$Lecture.=$_SESSION['STrad433'];}
		if($num == 3) {$Lecture.=$_SESSION['STrad434'];}

		return $Lecture;
	}
function SemainePairImpairSelect($num)
	{
		$Lecture.="<option value='1'";if($num == 1) {$Lecture.=" selected";} $Lecture.=">".$_SESSION['STrad432']."</option>";
		$Lecture.="<option value='2'";if($num == 2) {$Lecture.=" selected";} $Lecture.=">".$_SESSION['STrad433']."</option>";
		$Lecture.="<option value='3'";if($num == 3) {$Lecture.=" selected";} $Lecture.=">".$_SESSION['STrad434']."</option>";

		return $Lecture;
	}
//*******************************************************************************************

//*************************** REPLIQUER UN MODELE DE REPRISE *******************************
function ModeleRepriseReplication($planlecomodnum,$date1,$date2,$ConnexionBdd)
	{
		$i = 0;
		// SELECTION INFO MODELE REPRISE
		$reqModRep = 'SELECT planlecomodjour,planlecomodheure,planlecomodduree,planlecomoddesc,planlecomodniveau1,planlecomodniveau2,planlecomodcategorie,utilisateurs_utilnum,planlecomodnbmaxpers,planlecomodnbmaxpers,planlecomodinstal,planlecomodrepliquer,planlecomoddureeabebiter,calendrier_categorie_calecatenum FROM planning_lecon_modele WHERE planlecomodnum="'.$planlecomodnum.'"';
		$reqModRepResult = $ConnexionBdd ->query($reqModRep) or die ('Erreur SQL !'.$reqModRep.'<br />'.mysqli_error());
		$reqModRepAffich = $reqModRepResult->fetch();

		$moddateLect1 = formatdatemysqlselect($date1);
		$moddateLect2 = formatdatemysqlselect($date2);

		$moddatejj1=$moddateLect1[0];
		$moddatemm1=$moddateLect1[1];
		$moddateaaaa1=$moddateLect1[2];
		$moddatejj2=$moddateLect2[0];
		$moddatemm2=$moddateLect2[1];
		$moddateaaaa2=$moddateLect2[2];

		$Heure1 = $reqModRepAffich[1];
		$CalcHeure1 = formatheure1($date1." ".$reqModRepAffich[1]);
		$Heure2 = date('H:i:s', mktime($CalcHeure1[0],$CalcHeure1[1] + $reqModRepAffich[2],$CalcHeure1[2] - 1,0,0,0));

		/*********************** SELECTIONNE LE BON JOUR ***********************/
		$jourtest = date('w', mktime(0,0,0,$moddatemm1,$moddatejj1,$moddateaaaa1));
		$jourgood=$reqModRepAffich[0];
		$calcjourok=1;
		$datereprise = $moddateaaaa1.'-'.$moddatemm1.'-'.$moddatejj1;
		while($calcjourok == 1)
			{
				if ($jourgood == $jourtest)
					{
						break;
					}
				else
					{
						$date=formatdatemysqlselect($datereprise);
						$datereprise=date("Y-m-d",mktime(0, 0, 0, $date[1], $date[0] + 1, $date[2]));
						$jourtest = date('w', mktime(0,0,0,$date[1], $date[0] + 1, $date[2]));
					}
			}
		/****************************************************************/

		/*********************** REPLICATION REPRISE ***********************/
		$repliqueok = 1;
		while($repliqueok == 1)
			{
				$datereprisetest=str_replace("-", "", $datereprise);
				$moddate1test=str_replace("-", "", $date1);
				$moddate2test=str_replace("-", "", $date2);
				if($datereprisetest > $moddate2test) {break;}

				if($reqModRepAffich['planlecomodrepliquer'] == 2 OR $reqModRepAffich['planlecomodrepliquer'] == 3)
					{
						$ResultatSem = SemainePairImpair($datereprise);
						if($reqModRepAffich['planlecomodrepliquer'] == 2 AND $ResultatSem == 1) {$Exec = 2;} else if($reqModRepAffich['planlecomodrepliquer'] == 2 AND $ResultatSem != 1) {$Exec = 1;}
						if($reqModRepAffich['planlecomodrepliquer'] == 3 AND $ResultatSem == 2) {$Exec = 2;} else if($reqModRepAffich['planlecomodrepliquer'] == 3 AND $ResultatSem != 2) {$Exec = 1;}
					}
				else {$Exec = 2;}

				if($Exec == 2)
					{
						// RECHERCHE SI DEJA REPLIQUER
						$DejaRepli = ChercheRepliMod($datereprise,$planlecomodnum,$ConnexionBdd);
						if($DejaRepli == 2) {$MessageErreur.=$Trad706.' <b>'.formatdatemysql($datereprise).'</b><br>';}
						// CHERCHE SI Y'A UNE DATE D'EXCLUSION
						$DateExclu = ChercheRepliModExclu($datereprise,$planlecomodnum,$ConnexionBdd);

						/*
						$VerifUtil = VerifDispoUtil($reqModRepAffich[7],$datereprise,$reqModRepAffich[1],$reqModRepAffich[2],$ConnexionBdd);
						if($VerifUtil == 2) {$utilnum = $reqModRepAffich[7];}
						if($VerifUtil == 1) {$utilnum = "NULL";$MessageErreur.= $Trad705.' <b>'.formatdatemysql($datereprise).'</b> '.$TradDivPeriodeA.' <b>'.$reqModRepAffich[1].'</b><br>';}
						*/
						$VerifUtil = 2;
						if($DejaRepli == 1 AND $DateExclu == 1 AND $VerifUtil == 2) {$Exec = 2;}
						else {$Exec = 1;}
					}

				if($Exec == 2)
					{
						$i = $i + 1;
						$caledate1 = $datereprise;
						$caleheure1 = $Heure1;
						$caledate2 = $datereprise;
						$caleheure2 = $Heure2;

						$calenum = CalendrierAjou(null,1,$caledate1,$caledate2,$caleheure1,$caleheure2,$reqModRepAffich['planlecomodduree'],null,$reqModRepAffich['planlecomodniveau1'],$reqModRepAffich['planlecomodniveau2'],1,null,$reqModRepAffich['planlecomodnbmaxpers'],$reqModRepAffich['planlecomodinstal'],null,$reqModRepAffich['utilisateurs_utilnum'],null,null,$reqModRepAffich['planlecomoddureeabebiter'],null,null,null,null,$ConnexionBdd,"ajou",$reqModRepAffich['calendrier_categorie_calecatenum']);

						if(!empty($reqModRepAffich['planlecomodcategorie']))
							{
								$req1 = 'INSERT INTO calendrier_discipline VALUE(NULL,"'.$calenum.'","'.$reqModRepAffich['planlecomodcategorie'].'")';
								$req1Result = $ConnexionBdd ->query($req1) or die ('Erreur SQL !'.$req1.'<br />'.mysqli_error());
							}

						// ASSOCIER LA REPRISE ET LE MODï¿½LE
						$req1 = 'INSERT INTO planning_modele_calendrier VALUE(NULL,"'.$planlecomodnum.'","'.$calenum.'")';
						$req1Result = $ConnexionBdd ->query($req1) or die ('Erreur SQL !'.$req1.'<br />'.mysqli_error());
						// ENREGISTREMENT DES CAVALIERS DE LA REPRISE
						$req2 = 'SELECT clients_clienum FROM planning_clients_chevaux_modele WHERE planning_lecon_modele_planlecomodnum="'.$planlecomodnum.'"';
						$req2Result = $ConnexionBdd ->query($req2) or die ('Erreur SQL !'.$req2.'<br />'.mysqli_error());
						while($req2Affich = $req2Result->fetch())
							{
								$reqCale = 'SELECT caledate1 FROM calendrier WHERE calenum = "'.$calenum.'"';
								$reqCaleResult = $ConnexionBdd ->query($reqCale) or die ('Erreur SQL !'.$reqCale.'<br />'.mysqli_error());
								$reqCaleAffich = $reqCaleResult->fetch();
								$caledateCut = formatheure1($reqCaleAffich['caledate1']);
								$caledate = $caledateCut[3]."-".$caledateCut[4]."-".$caledateCut[5];
								$VerifDispo = VerifDispo(null,$caledate,$caledate,$req2Affich[0],null,$Dossier,null,$ConnexionBdd);
								if($VerifDispo[0] == 2) {$caleparttext2 = 3;}
								else {$caleparttext2 = 6;}

								$calepartnum = CalendrierPartAjou(null,$calenum,$req2Affich[0],null,2,$caleparttext2,null,null,null,null,null,null,null,null,null,$ConnexionBdd,"ajou",null,null,null,null,null);
							}
					}
				$datereprise=formatdatemysqlselect($datereprise);
				$datereprise=date("Y-m-d",mktime(0, 0, 0, $datereprise[1], $datereprise[0] + 7, $datereprise[2]));
			}
			/****************************************************************/

			$MessageErreur.=$Trad698.' <b>'.AfficheJours($reqModRepAffich[0]).'</b> '.$TradDivPeriodeA.' <b>'.$reqModRepAffich[1].'</b> '.$Trad697.' <b>('.formatdatemysql($moddate1).' / '.formatdatemysql($moddate2).')</b><br>';
			if($i >= 1) {$MessageConf=$_SESSION['STrad455']."".formatdatemysql($date1)." ".$_SESSION['STrad39']." ".formatdatemysql($date2).".";}

		return array($calenum,$MessageErreur,$MessageConf);
	}
//******************************************************************

//********* CHERCHE SI UN MODELE A Dï¿½Jï¿½ ï¿½Tï¿½ Rï¿½PLIQUER ï¿½ UNE DATE PRï¿½CISE ****************
function ChercheRepliMod($date,$planlecomodnum,$ConnexionBdd)
	{
		// Info du modï¿½le
		$req1 = 'SELECT planlecomodheure FROM planning_lecon_modele WHERE planlecomodnum="'.$planlecomodnum.'"';
		$req1Result = $ConnexionBdd ->query($req1) or die ('Erreur SQL !'.$req1.'<br />'.mysqli_error());
		$req1Affich = $req1Result->fetch();

		// Compte si le modï¿½le a dï¿½jï¿½ ï¿½tï¿½ rï¿½pliquer  une date prï¿½cise
		$req2 = 'SELECT count(planmodcalenum) FROM planning_modele_calendrier,calendrier WHERE calendrier_calenum = calenum AND planning_lecon_modele_planlecomodnum="'.$planlecomodnum.'" AND caledate1 = "'.$date.' '.$req1Affich[0].'"';
		$req2Result = $ConnexionBdd ->query($req2) or die ('Erreur SQL !'.$req2.'<br />'.mysqli_error());
		$req2Affich = $req2Result->fetch();
		if($req2Affich[0] >= 1) { return 2;}
		else {return 1;}
	}
//***********************************************************************************


//********* CHERCHE SI ON PEUT REPLIQUER UN MODELE SUIVANT LES DATES D EXCLU *********
function ChercheRepliModExclu($date,$planlecomodnum,$ConnexionBdd)
	{
		$i = 0;
		// Info du modï¿½le
		$req1 = 'SELECT count(planmoddateexcludate1) FROM planning_modele_date_exclu WHERE planning_lecon_modele_planlecomodnum = "'.$planlecomodnum.'" AND planmoddateexcludate1 <= "'.$date.'" AND planmoddateexcludate2 >= "'.$date.'"';
		$req1Result = $ConnexionBdd ->query($req1) or die ('Erreur SQL !'.$req1.'<br />'.mysqli_error());
		$req1Affich = $req1Result->fetch();
		if($req1Affich[0] == 0) {return 1;}
		else {return 2;}
	}
//*******************************************************


//********* VERIF SI L UTILISATEUR EST DISPO A UNE DATE ET HEURE ET DUREE PRECISE **********
function VerifDispoUtil($utilnum,$date,$heure,$duree,$ConnexionBdd)
	{
		$duree1 = formatheure($heure);
		$heurefin = date('H:i:s', mktime($duree1[0], $duree1[1] + $duree, $duree1[2] - 1));
		$heurefin = $date.' '.$heurefin;

		$req1 = 'SELECT count(calenum) FROM calendrier WHERE utilisateurs_utilnum = "'.$utilnum.'" AND caledate1 >= "'.$date.' '.$heure.'" AND caledate2 <= "'.$heurefin.'" AND caleindice = "1"';
		$req1Result = $ConnexionBdd ->query($req1) or die ('Erreur SQL !'.$req1.'<br />'.mysqli_error());
		$req1Affich = $req1Result->fetch();

		if($req1Affich[0] == 0) {return 2;}
		else {return 1;}
	}
//*****************************************************************************

//*********************** SYNCHRONISER MODELE ***********************
function ModeleSynchronisation($Dossier,$ConnexionBdd,$planlecomodnum)
  {
    // SELECTION INFO DU MODï¿½LE DE REPRISE
		$reqModRep = 'SELECT planlecomodjour,planlecomodheure,planlecomodduree,planlecomoddesc,planlecomodniveau1,planlecomodniveau2,planlecomodcategorie,utilisateurs_utilnum,planlecomodnbmaxpers,planlecomodnbmaxpers,planlecomodinstal,planlecomodlibe,planlecomoddureeabebiter,calendrier_categorie_calecatenum FROM planning_lecon_modele WHERE planlecomodnum="'.$planlecomodnum.'"';
		$reqModRepResult = $ConnexionBdd ->query($reqModRep) or die ('Erreur SQL !'.$reqModRep.'<br />'.mysqli_error());
		$reqModRepAffich = $reqModRepResult->fetch();

		// LISTE DES REPRISES ASSOCIES
		$req1 = 'SELECT * FROM planning_modele_calendrier,calendrier WHERE calendrier_calenum = calenum AND planning_lecon_modele_planlecomodnum = "'.$planlecomodnum.'" AND caletext5 = "1"';
		$req1Result = $ConnexionBdd ->query($req1) or die ('Erreur SQL !'.$req1.'<br />'.mysqli_error());
		while($req1Affich = $req1Result->fetch())
			{
				$dateCalc = formatheure1($req1Affich['caledate1']);
				$DateDebSem = debutsem1($dateCalc[3],$dateCalc[4],$dateCalc[5]);
				$dateCalc = formatheure1($DateDebSem[2]." ".$reqModRepAffich[1]);

				for ($i = 1 ; $i <= 7 ; $i++)
					{
						$jourtest = date('w', mktime($dateCalc[0],$dateCalc[1],$dateCalc[2],$dateCalc[4],$dateCalc[5],$dateCalc[3]));
						if($jourtest == $reqModRepAffich['planlecomodjour']) {$caledate1 = $dateCalc[3]."-".$dateCalc[4]."-".$dateCalc[5]." ".$dateCalc[0].":".$dateCalc[1].":".$dateCalc[2];}
						$dateCalc = date('Y-m-d H:i:s', mktime($dateCalc[0],$dateCalc[1],$dateCalc[2],$dateCalc[4],$dateCalc[5] + 1,$dateCalc[3]));
						$dateCalc = formatheure1($dateCalc);
					}

				$dateCalc = formatheure1($caledate1);
				$caledate2 = date('Y-m-d H:i:s', mktime($dateCalc[0],$dateCalc[1] + $reqModRepAffich[2],$dateCalc[2] - 1,$dateCalc[4],$dateCalc[5],$dateCalc[3]));

        $reqCale = 'UPDATE calendrier SET caledate1="'.$caledate1.'",caledate2="'.$caledate2.'",caletext1="'.$reqModRepAffich[2].'",caletext2="'.$reqModRepAffich['planlecomoddesc'].'",caletext7="'.$reqModRepAffich['planlecomodnbmaxpers'].'",caletext8="'.$reqModRepAffich['planlecomodinstal'].'",caletext9="'.$reqModRepAffich['planlecomoddureeabebiter'].'",calendrier_categorie_calecatenum = "'.$reqModRepAffich['calendrier_categorie_calecatenum'].'" WHERE calenum = "'.$req1Affich['calenum'].'"';
				$reqCaleResult = $ConnexionBdd ->query($reqCale) or die ('Erreur SQL !'.$reqCale.'<br />'.mysqli_error());

        // DISCIPLINE
        $reqCale = 'DELETE FROM calendrier_discipline WHERE calendrier_calenum = "'.$req1Affich['calenum'].'"';
        $reqCaleResult = $ConnexionBdd ->query($reqCale) or die ('Erreur SQL !'.$reqCale.'<br />'.mysqli_error());
        $reqCale = 'INSERT INTO calendrier_discipline VALUE (NULL,"'.$req1Affich['calenum'].'","'.$reqModRepAffich['planlecomodcategorie'].'")';
        $reqCaleResult = $ConnexionBdd ->query($reqCale) or die ('Erreur SQL !'.$reqCale.'<br />'.mysqli_error());

        // NIVEAU
        $reqCale = 'DELETE FROM calendrier_niveau WHERE calendrier_calenum = "'.$req1Affich['calenum'].'"';
        $reqCaleResult = $ConnexionBdd ->query($reqCale) or die ('Erreur SQL !'.$reqCale.'<br />'.mysqli_error());
        $reqCale = 'INSERT INTO calendrier_niveau VALUE (NULL,"'.$reqModRepAffich['planlecomodniveau1'].'","'.$req1Affich['calenum'].'")';
        $reqCaleResult = $ConnexionBdd ->query($reqCale) or die ('Erreur SQL !'.$reqCale.'<br />'.mysqli_error());
        $reqCale = 'INSERT INTO calendrier_niveau VALUE (NULL,"'.$reqModRepAffich['planlecomodniveau2'].'","'.$req1Affich['calenum'].'")';
        $reqCaleResult = $ConnexionBdd ->query($reqCale) or die ('Erreur SQL !'.$reqCale.'<br />'.mysqli_error());
			}

		return array ($planlecomodnum,$Trad1102);
  }
// *********************************************************************

//****************** MODELE DATE EXCLUSION ******************
function ModeleDateExclu($Dossier,$ConnexionBdd,$planlecomodnum)
	{
		$Lecture.="<div class='InfoStandard FormInfoStandard1'><img src='".$Dossier."images/informationBlanc.png' class='imgSousMenu1' style='margin-right:10px;'>".$_SESSION['STrad464']." :</div>";

		$Lecture.="<table>";
		$req1 = 'SELECT * FROM planning_modele_date_exclu WHERE planning_lecon_modele_planlecomodnum = "'.$planlecomodnum.'" ORDER BY planmoddateexcludate1 ASC';
		$req1Result = $ConnexionBdd ->query($req1) or die ('Erreur SQL !'.$req1.'<br />'.mysqli_error());
		while($req1Affich = $req1Result->fetch())
			{
				$Lecture.="<tr>";
					$Lecture.="<td>".formatdatemysql($req1Affich['planmoddateexcludate1'])."</td>";
					$Lecture.="<td><span style='margin-left:10px;'>".formatdatemysql($req1Affich['planmoddateexcludate2'])."</span></td>";
					$Lecture.="<td><a href='".$Dossier."modules/calendrier/modcaleModeleDateExclusion.php?planmoddateexclunum=".$req1Affich['planmoddateexclunum']."&planlecomodnum=".$planlecomodnum."' class='LoadPage ModeleDateExclu'><img src='".$Dossier."images/supprimer.png' class='ImgSousMenu2'></a></td>";
				$Lecture.="</tr>";
			}
		$Lecture.="</table>";

		$Lecture.="<div style='height:10px;'></div>";

		$Lecture.="<form id='FormModeleDateExclusionAjou' action=''>";
		$Lecture.="<input type='hidden' name='planlecomodnum' value='".$planlecomodnum."'>";
		$Lecture.="<table style='width:100%;'>";
		$Lecture.="<tr><td>";
		$Lecture.="<input type='date' name='date1' class='champ_barre' placeholder='".$Trad693."' style='float:left;width:50%;'>";
		$Lecture.="<input type='date' name='date2' class='champ_barre' placeholder='".$Trad694."' style='float:left;width:50%;'>";
		$Lecture.="</td></tr>";
		$Lecture.="<tr style='height:10px;'></tr>";
		$Lecture.="<tr><td><button class='button'><img src='".$Dossier."images/ajouterBlanc.png' class='ImgSousMenu2'> ".$_SESSION['STrad160']."</button></td></tr>";
		$Lecture.="</table>";
		$Lecture.="</form>";

		return $Lecture;
	}
//********************************************************************

//************************* COMMANDER / DECOMMANDER EN LIGNE***********************
function CommanderEnLigne($calenum,$clienum,$ConnexionBdd)
	{
		$Commander = 2;
		$Decommander = 2;

		$reqConfLog = 'SELECT * FROM conflogiciel WHERE AA_equimondo_hebeappnum = "'.$_SESSION['hebeappnum'].'"';
		$reqConfLogResult = $ConnexionBdd ->query($reqConfLog) or die ('Erreur SQL !'.$reqConfLog.'<br />'.mysqli_error());
		$reqConfLogAffich = $reqConfLogResult->fetch();

		$reqClieInfo = 'SELECT * FROM clients WHERE clienum = "'.$clienum.'"';
		$reqClieInfoResult = $ConnexionBdd ->query($reqClieInfo) or die ('Erreur SQL !'.$reqClieInfo.'<br />'.mysqli_error());
		$reqClieInfoAffich = $reqClieInfoResult->fetch();

		$heuredecommander=$reqConfLogAffich['conflognbjourreservleco'];
		$conflognbheurereserver=$reqConfLogAffich['conflognbheurereserver'];
		if(!empty($reqConfLogAffich['conflogreservnbjour'])) {$heurecommandeavant = $reqConfLogAffich['conflogreservnbjour'] - 1;} else {$heurecommandeavant = 0;}
		$conflogreservheure = $reqConfLogAffich['conflogreservheure'];

		$req = 'SELECT caledate1,caletext5,caletext7,caleindice,caledate1,caledate2,calendrier_categorie_calecatenum FROM calendrier WHERE calenum = "'.$calenum.'"';
		$reqResult = $ConnexionBdd ->query($req) or die ('Erreur SQL !'.$req.'<br />'.mysqli_error());
		$reqAffich = $reqResult->fetch();

		$reqCate = 'SELECT * FROM calendrier_categorie WHERE calecatenum = "'.$reqAffich['calendrier_categorie_calecatenum'].'"';
		$reqCateResult = $ConnexionBdd ->query($reqCate) or die ('Erreur SQL !'.$reqCate.'<br />'.mysqli_error());
		$reqCateAffich = $reqCateResult->fetch();

		$reqPart = 'SELECT count(calepartnum) FROM calendrier_participants WHERE calendrier_calenum = "'.$calenum.'" AND caleparttext2 = "3"';
		if($reqCateAffich['calecatetype'] == 2) {$reqPart.=' GROUP BY clients_clienum';}
		$reqPartResult = $ConnexionBdd ->query($reqPart) or die ('Erreur SQL !'.$reqPart.'<br />'.mysqli_error());
		$reqPartAffich = $reqPartResult->fetch();

		$Date =formatheure1($reqAffich[0]);

		// VERIF SI LE CAVALIER FAIT DEJA PARTIE DE LA REPRISE
		$reqClie = 'SELECT count(calepartnum) FROM calendrier_participants WHERE calendrier_calenum = "'.$calenum.'" AND clients_clienum = "'.$clienum.'" AND caleparttext2="3"';
		$reqClieResult = $ConnexionBdd ->query($reqClie) or die ('Erreur SQL !'.$reqClie.'<br />'.mysqli_error());
		$reqClieAffich = $reqClieResult->fetch();
		if($reqClieAffich[0] >= 1) {$Commander = 1;}
		if($reqCateAffich['calecatetype'] == 1)
			{
				$reqPartNb = 'SELECT count(calepartnum) FROM calendrier_participants WHERE calendrier_calenum = "'.$calenum.'" AND caleparttext2 = "3"';
				$reqPartNbResult = $ConnexionBdd ->query($reqPartNb) or die ('Erreur SQL !'.$reqPartNb.'<br />'.mysqli_error());
				$reqPartNbAffich = $reqPartNbResult->fetch();
				$NbPersonne = $reqPartNbAffich[0];
			}
		else if($reqCateAffich['calecatetype'] == 2)
			{
				$reqPartNb = 'SELECT count(calepartnum) FROM calendrier_participants WHERE calendrier_calenum = "'.$calenum.'" AND caleparttext2 = "3"';
				$reqPartNb.=' GROUP BY clients_clienum';
				$reqPartNbResult = $ConnexionBdd ->query($reqPartNb) or die ('Erreur SQL !'.$reqPartNb.'<br />'.mysqli_error());
				while ($reqPartNbAffich = $reqPartNbResult->fetch()) {$NbPersonne = $NbPersonne + 1;}
			}

		// VERIF SOLDE DU CLIENT
		if(!empty($clienum) AND $Commander == 2)
			{
				$RestantDu = ClieFactCalc($clienum,$Dossier,$ConnexionBdd);
				$NbHeureRestant = CalcNbHeureForfValide($clienum,null,null,$ConnexionBdd);
				if($RestantDu[4] > 0 AND $_SESSION['conflogplanlecoautofact'] == 2) {$Commander = 1;$Erreur.="<li>".$_SESSION['STrad656']." <b>".$RestantDu[4]." ï¿½</b></li>";}

				// VERIF SI LE SOLDE FORFAITRE NE DEPASSE PAS
				if($NbHeureRestant[2] < $conflognbheurereserver AND !empty($conflognbheurereserver)) {$Commander = 1;$Erreur.="<li>".$_SESSION['STrad657']." ".minute_vers_heure($conflognbheurereserver)." ".$_SESSION['STrad658']." <b>".$NbHeureRestant[0]."</b>.</li>";}
			}

		// VERIF SI REPRISE N'EST PAS DEJA PASSï¿½
		if($datedujour > $CalcDate AND $Commander == 2) {$Commander = 1;$Decommander = 1;$Erreur.="<li>".$_SESSION['STrad659']."</li>";}

		// VERIF SI REPRISE DEJA DEBITER
		if($reqAffich[1] == 2) {$Commander = 1;$Decommander = 1;$Erreur.="<li>".$_SESSION['STrad660']."</li>";}

		// VERIF SI LA REPRISE EST Dï¿½Jï¿½ PLEINE
		$NbPersonneMaxi = $reqAffich['caletext7'];

		if(($reqCateAffich['calecatetype'] == 1 OR $reqCateAffich['calecatetype'] == 2) AND $NbPersonne >= $NbPersonneMaxi AND !empty($NbPersonneMaxi)) {$Commander = 1;$Decommander = 2;$Erreur.="<li>".$_SESSION['STrad661']."</li>";}

		// CALCUL DATE COMMANDER
		$CalcHeureCommander=date("Ymd",mktime($Date[0], $Date[1], $Date[2], $Date[4], $Date[5]-$heurecommandeavant, $Date[3]));
		$CalcDate=date("Ymd",mktime(0, 0, 0, $Date[4], $Date[5], $Date[3]));

		$dateheuredujour = date("Ymd");
		$datedujour = date ("Ymd");

		if($dateheuredujour == $CalcHeureCommander)
			{
				if(!empty($conflogreservheure))
					{
						$heure1 = str_replace(":","",$conflogreservheure);
						$heure2 = date("His");
						if($heure2 > $heure1) {$Exec = 1;} else {$Exec = 2;}
					}
				else {$Exec = 2;}
			}
		else if($CalcHeureCommander < $dateheuredujour) {$Exec = 1;}
		else {$Exec = 2;}
		if($Exec == 1) {$Commander = 1;$Erreur.="<li>".$_SESSION['STrad662']." : ".ReservationNbJourAvantLect($_SESSION['conflogreservnbjour'])." ".$_SESSION['STrad17']." ".$_SESSION['conflogreservheure']."</li>";}

		// CALCUL DATE DECOMMANDER
		$CalcHeureDecommander=date("YmdHis",mktime($Date[0]-$heuredecommander, $Date[1], $Date[2], $Date[4], $Date[5], $Date[3]));
		$CalcDate=date("Ymd",mktime(0, 0, 0, $Date[4], $Date[5], $Date[3]));

		$dateheuredujour = date("YmdHis");
		$datedujour = date ("Ymd");
		if($dateheuredujour > $CalcHeureDecommander) {$Decommander = 1;$Erreur.="<li>".$_SESSION['STrad663']." <b>".$heuredecommander." H</b></li>";}

		// ASSOCIATION FORFAIT / CARTE AVEC CALENDRIER CATEGORIE
		if($Commander == 2)
			{
				$reqCateTypePrest = 'SELECT count(catecaletypeprestnum) FROM calendrier_categorie_typeprestation WHERE calendrier_categorie_calecatenum = "'.$reqAffich['calendrier_categorie_calecatenum'].'"';
				$reqCateTypePrestResult = $ConnexionBdd ->query($reqCateTypePrest) or die ('Erreur SQL !'.$reqCateTypePrest.'<br />'.mysqli_error());
				$reqCateTypePrestAffich = $reqCateTypePrestResult->fetch();
				if($reqCateTypePrestAffich[0] >= 1)
					{
						$Commander = 1;
						$reqCateTypePrest = 'SELECT * FROM calendrier_categorie_typeprestation WHERE calendrier_categorie_calecatenum = "'.$reqAffich['calendrier_categorie_calecatenum'].'"';
						$reqCateTypePrestResult = $ConnexionBdd ->query($reqCateTypePrest) or die ('Erreur SQL !'.$reqCateTypePrest.'<br />'.mysqli_error());
						while($reqCateTypePrestAffich = $reqCateTypePrestResult->fetch())
							{
								$reqFact = 'SELECT * FROM clientssoldeforfentree,clientssoldeforfentree_clients,factprestation WHERE clientssoldeforfentree_cliesoldforfentrnum = cliesoldforfentrnum AND factprestation_factprestnum	= factprestnum AND clientssoldeforfentree_clients.clients_clienum = "'.$clienum.'" AND factprestation.typeprestation_typeprestnum = "'.$reqCateTypePrestAffich['typeprestation_typeprestnum'].'" GROUP BY cliesoldforfentrnum';
								$reqFactResult = $ConnexionBdd ->query($reqFact) or die ('Erreur SQL !'.$reqFact.'<br />'.mysqli_error());
								while($reqFactAffich = $reqFactResult->fetch())
									{
										$Verif = ForfaitVerifValide($Dossier,$ConnexionBdd,$reqFactAffich['cliesoldforfentrnum'],$reqAffich['caledate1']);
										if($Verif[0] == 2) {$Commander = 2;break;}
									}
								$TypePerstationLibe.="<span style='margin-left:10px;'></span>- ".TypePrestationLect($reqCateTypePrestAffich['typeprestation_typeprestnum'],$ConnexionBdd)."<br>";
							}

						if($Commander == 1)
							{
								$Erreur.=$_SESSION['STrad734']."<br>";
								$Erreur.=$TypePerstationLibe."<br>";
							}
					}
			}

		// RESTRICTION PAR NIVEAU
		if($reqConfLogAffich['conflogicielaccesniveau'] == 2)
			{
				$reqNive = 'SELECT count(calenivenum) FROM calendrier_niveau WHERE calenivelibe = "'.$reqClieInfoAffich['clieniveau'].'" AND calendrier_calenum = "'.$calenum.'"';
				$reqNiveResult = $ConnexionBdd ->query($reqNive) or die ('Erreur SQL !'.$reqNive.'<br />'.mysqli_error());
				$reqNiveAffich = $reqNiveResult->fetch();
				if($reqNiveAffich[0] == 0)
					{
						$Commander = 1;
						$Erreur.= $_SESSION['STrad735']."<br>";
					}
			}

		//if($reqAffich['calendrier_categorie_calecatenum'] == "29851") {$Commander = 1;$Decommander = 1;}

		return array($Commander,$Decommander,$Erreur);
	}
//*************************************************************************

//************ AFFICHE TOUS LES EVENEMNTS D'UN CLIENT *************************************
function CalendrierClientsListe($Dossier,$ConnexionBdd,$clienum)
	{
		$Lecture.="<table class='table table-bordered'><tbody>";

		$req1 = 'SELECT calendrier_participants.chevaux_chevnum,calenum,caledate1,caletext1,utilisateurs_utilnum,calecatelibe FROM calendrier,calendrier_participants,calendrier_categorie WHERE calendrier_calenum = calenum AND calendrier_categorie_calecatenum = calecatenum AND calendrier_participants.clients_clienum = "'.$clienum.'" ORDER BY caledate1 DESC';
		$req1Result = $ConnexionBdd ->query($req1) or die ('Erreur SQL !'.$req1.'<br />'.mysqli_error());
		while($req1Affich = $req1Result->fetch())
			{
				$Lien = "<a href='".$Dossier."modules/calendrier/modcalefichcomplet.php?calenum=".$req1Affich['calenum']."&clienum=".$clienum."' class='AfficheCaleClieFichComplet'>";

				$Lecture.="<tr>";
					// CATEGORIE
					$Lecture.="<td>".$Lien.$req1Affich['calecatelibe']."</a></td>";
					// DATE ET HEURE
					$Lecture.="<td>".$Lien.FormatDateTimeMySql($req1Affich['caledate1'])."</a></td>";
					// DUREE
					$Lecture.="<td>".$Lien.minute_vers_heure($req1Affich['caletext1'],null)."</a></td>";
					// CHEVAL
					$Lecture.="<td>".$Lien.ChevLect($req1Affich[0],$ConnexionBdd)."</a></td>";
					// MONITEUR
					$Lecture.="<td>".$Lien.UtilLect($req1Affich['utilisateurs_utilnum'],$ConnexionBdd)."</a></td>";
					/*
					// DISCIPLINE
					$Lecture.="<td>".$Lien;
					$reqDisc = 'SELECT * FROM calendrier_discipline WHERE calendrier_calenum = "'.$req1Affich['calenum'].'"';
					$reqDiscResult = $ConnexionBdd ->query($reqDisc) or die ('Erreur SQL !'.$reqDisc.'<br />'.mysqli_error());
					while($reqDiscAffich = $reqDiscResult->fetch())
						{
							$Lecture.=$reqDiscAffich['calediscilibe ']."<br>";
						}
					$Lecture.="</a></td>";
					*/
				$Lecture.="</tr>";
			}

		$Lecture.="</tbody></table>";

		return $Lecture;
	}
//*************************************************************************

?>
