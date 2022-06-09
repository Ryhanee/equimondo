<?php

//**************************** CALCUL SOLDE DEBITEUR D'UN CLIENT **************************
function ClieFactCalc($clienum,$Dossier,$ConnexionBdd)
	{
		$MontantTotalTtc = 0;
		$MontantTotalAvoir = 0;
		$MontantTotalEnc = 0;
		$MontantTotalCa = 0;
		$RestantDu = 0;

		/* CALCUL MONTANT TTC FACTURE */
		$req1 = 'SELECT factnum,factnumlibe,factdate FROM factures WHERE clients_clienum = "'.$clienum.'" AND facttype = "4"';
		$req1Result = $ConnexionBdd ->query($req1) or die ('Erreur SQL !'.$req1.'<br />'.mysql_error());
		while($req1Affich = $req1Result->fetch())
			{
				//$SoldeFact = FactCalc($req1Affich[0],$ConnexionBdd);
				$RestantDu = $RestantDu + $SoldeFact[4];
				$MontantTotalTtc = $MontantTotalTtc + $SoldeFact[2];
				if($SoldeFact[4] > 0) {$Resultat1.='<a href="'.$Dossier.'modules/facturation/modfactfichcomplet.php?factnum='.$req1Affich[0].'">'.$_SESSION['STrad35'].' N° '.FactPrefLect($req1Affich[2],$req1Affich[1]).' : '.$SoldeFact[4].' '.$_SESSION['STrad27'].'</a><br>';}
			}

		/* CALCUL MONTANT TTC AVOIR NON ASSOCIER */
		$req2 = 'SELECT sum(factprestprixstatprixttc) FROM factures,factprestation,factprestation_prix WHERE factures_factnum = factnum AND factprestation_factprestnum = factprestnum AND factures.clients_clienum = "'.$clienum.'" AND facttype = "5"';
		$req2Result = $ConnexionBdd ->query($req2) or die ('Erreur SQL !'.$req2.'<br />'.mysql_error());
		$req2Affich = $req2Result->fetch();

		$MontantTotalTtc = $MontantTotalTtc - $req2Affich[0];

		return array ($MontantTotalTtc,$MontantTotalAvoir,$MontantTotalEnc,$MontantTotalCa,$RestantDu,$Resultat1);
	}
//************************************************************************************************************************

//*************************** CALCUL NB HEURE FORFAIT *******************************
function CalcNbHeureForfValide($clienum,$duree,$date,$ConnexionBdd)
	{
		if(empty($date)) {$dateSelect = date('Y-m-d');}
		else {$dateSelect = $date;}

		$Resultat1 = 0;
		$Resultat2.= "<option value=''>-- ".$_SESSION['STrad36']." --</option>";
		$req = 'SELECT cliesoldforfentrnum,cliesoldforfentrnbheure,cliesoldforfentrdate1,cliesoldforfentrdate2,cliesoldforfentrlibe FROM clientssoldeforfentree,clientssoldeforfentree_clients WHERE clientssoldeforfentree_cliesoldforfentrnum = cliesoldforfentrnum AND clients_clienum = "'.$clienum.'" AND cliesoldforfentrdate2 >= "'.$dateSelect.'" ORDER BY cliesoldforfentrdate2 ASC';
		$reqResult = $ConnexionBdd ->query($req) or die ('Erreur SQL !'.$req.'<br />'.mysqli_error());
		while($reqAffich = $reqResult->fetch())
			{
				$req1 = 'SELECT sum(cliesoldforfsortnbheure) FROM clientssoldeforfsortie WHERE clientssoldeforfentree_cliesoldforfentrnum = "'.$reqAffich[0].'"';
				$req1Result = $ConnexionBdd ->query($req1) or die ('Erreur SQL !'.$req1.'<br />'.mysqli_error());
				$req1Affich = $req1Result->fetch();

				$NbHeure = $reqAffich[1]-$req1Affich[0];
				$Resultat1 = $Resultat1 + $NbHeure;

				if($NbHeure > 0 AND $NbHeure >= $duree) {$Resultat2.= '<option value="'.$reqAffich[0].'">'.$reqAffich[4].' : '.minute_vers_heure($NbHeure).' ('.$_SESSION['STrad37'].' '.formatdatemysql($reqAffich['cliesoldforfentrdate2']).')</option>';}
				if($NbHeure > 0 AND $NbHeure >= $duree) {$Resultat3.= $_SESSION['STrad41'].' : <b>'.minute_vers_heure($reqAffich[1]).'</b> <i>, '.$_SESSION['STrad40'].' : <b>'.minute_vers_heure($NbHeure).'</b> ('.$_SESSION['STrad38'].' '.formatdatemysql($reqAffich[2]).' '.$_SESSION['STrad39'].' '.formatdatemysql($reqAffich[3]).')</i><br>';}
			}

		$Resultat2.=$Resultat4;

		// Si le client n'a pas d'heure, vérifier s'il n'en a pas en négatif
		$req1 = 'SELECT sum(cliesoldforfsortnbheure) FROM clientssoldeforfsortie WHERE clientssoldeforfentree_cliesoldforfentrnum IS NULL AND clients_clienum = "'.$clienum.'"';
		$req1Result = $ConnexionBdd ->query($req1) or die ('Erreur SQL !'.$req1.'<br />'.mysqli_error());
		$req1Affich = $req1Result->fetch();
		$Resultat1 = $Resultat1 - $req1Affich[0];

		return array (minute_vers_heure($Resultat1),$Resultat2,$Resultat1,$Resultat3);
	}
//***********************************************************************************

// ************************** LISTE DES CLIENTS *********************************
function ListeClient($ConnexionBdd,$Dossier)
	{
		if(empty($_GET['cliesupp'])) {$_GET['cliesupp'] = 1;}
		if(empty($_GET['DernAffiche'])) {$_GET['DernAffiche'] = 0;}

		if(isset($_GET['clienom'])) {$_SESSION['RechClieNom'] = $_GET['clienom'];}
		if(isset($_GET['clieprenom'])) {$_SESSION['RechCliePrenom'] = $_GET['clieprenom'];}

		$reqCond.=' FROM clients';
		if(!empty($_GET['groupnum'])) {$reqCond.=',clientsgroupe';}
		$reqCond.=' WHERE AA_equimondo_hebeappnum = "'.$_SESSION['hebeappnum'].'"';
		if(!empty($_GET['cliesupp']) AND ($_GET['cliesupp'] == 1 OR $_GET['cliesupp'] == 2)) {$reqCond.=' AND cliesupp = "'.$_GET['cliesupp'].'"';}
		else if(!empty($_GET['cliesupp']) AND $_GET['cliesupp'] == "all") {$reqCond.=' AND (cliesupp = "1" OR cliesupp = "2")';}
		if(!empty($_GET['clienum'])) {$reqCond.=' AND clienum = "'.$_GET['clienum'].'"';}
		if(!empty($_SESSION['RechClieNom'])) {$reqCond.=' AND clienom LIKE "'.$_SESSION['RechClieNom'].'%"';}
		if(!empty($_SESSION['RechCliePrenom'])) {$reqCond.=' AND clieprenom LIKE "'.$_SESSION['RechCliePrenom'].'%"';}
		if(!empty($_GET['cliecp'])) {$reqCond.=' AND cliecp LIKE "'.$_GET['cliecp'].'%"';}
		if(!empty($_GET['clieville'])) {$reqCond.=' AND clieville LIKE "%'.$_GET['clieville'].'%"';}
		if(!empty($_GET['cliestatus'])) {$reqCond.=' AND cliestatus = "'.$_GET['cliestatus'].'"';}
		if(!empty($_GET['groupnum'])) {$reqCond.=' AND clients_clienum = clienum AND groupe_groupnum = "'.$_GET['groupnum'].'"';}

		$req='SELECT * ';
		$req.=$reqCond;
		if($_SESSION['infologlang2'] == "es") {$req.= ' ORDER BY clieprenom ASC';}
		else {$req.= ' ORDER BY clienom ASC';}
		if($_GET['rechok'] != 2) {$req.=' LIMIT '.$_GET['DernAffiche'].',25';}
		$reqResult = $ConnexionBdd ->query($req) or die ('Erreur SQL !'.$req.'<br />'.mysqli_error());
		while($reqAffich = $reqResult->fetch())
			{
				// TOTAL FACTURE NON PAYE
				$RestantDu = ClieFactCalc($reqAffich['clienum'],$Dossier,$ConnexionBdd);
				if($RestantDu[4] > 0) {$ClassAlerte1 = 'bg-danger';}
				else {$ClassAlerte1 = 'bg-success';}
				if($_SESSION['equimondoinfologversionnum'] == 1)
					{
						// SOLDE FORFAITAIRE
						$NbHeure = CalcNbHeureForfValide($reqAffich['clienum'],NULL,NULL,$ConnexionBdd);
						if($NbHeure[2] >= 0 AND $NbHeure[2] <= 180) {$ClassAlerte2 = 'bg-warning';}
						else if($NbHeure[2] < 0) {$ClassAlerte2 = 'bg-danger';}
						else {$ClassAlerte2 = 'bg-success';}
					}

				//if($_SESSION['ResolutionConnexion1'] <= 800) {$Lien = "<a href='".$Dossier."modules/profil/modprofilfichcomplet1.php?clienum=".$reqAffich['clienum']."' class='LoadPage AfficheFicheProfil1'>";}
				//else {$Lien = "<a href='".$Dossier."modules/profil/modprofilfichcomplet2.php?clienum=".$reqAffich['clienum']."' class='LoadPage AfficheFicheProfil2'>";}

				$Lien = "<a href='".$Dossier."modules/profil/modprofilfichcomplet1.php?clienum=".$reqAffich['clienum']."' class='AfficheFicheProfil1'>";

				$LibeNom = ClieLect($reqAffich['clienum'],$ConnexionBdd);

				// VERSION SMARTPHONE
				$Lecture.="<div class='row'>";
				$Lecture.="<div class='col-auto w-100 sw-md-50'>";
				$Lecture.="<div class='card mb-3'>";
				$Lecture.="<div class='card-body'>";
				$Lecture.="<div class='row g-0 sh-6'>";
					$Lecture.="<div class='col-auto'>";
					$Lecture.=$Lien."<img src='../../img/profile/profile-6.webp' class='card-img rounded-xl sh-6 sw-6' alt='thumb' /></a>";
					$Lecture.="</div>";
				$Lecture.="<div class='col'>";
				$Lecture.="<div class='card-body d-flex flex-row pt-0 pb-0 ps-3 pe-0 h-100 align-items-center justify-content-between'>";
					$Lecture.=$Lien."<div class='d-flex flex-column'>";
					$Lecture.="<div>".$LibeNom."</div>";
					$Lecture.="<div class='text-small text-muted'>".ClieStatus($reqAffich['cliestatus'])."</div>";
					$Lecture.="</div></a>";
				$Lecture.="<div class='d-flex'>";

				$Lecture.=$Lien."<div style='margin-right:10px;'>";
					$Lecture.="<div class='".$ClassAlerte1."' style='padding:2px 5px 2px 5px;border-radius:10px;text-align:center;'>".$RestantDu[4]." ".$_SESSION['STrad27']."</div>";
					$Lecture.="<div style='width:100%;clear:both;display:block;height:5px;'></div>";
					$Lecture.="<div class='".$ClassAlerte2."' style='padding:2px 5px 2px 5px;border-radius:10px;text-align:center;'>".minute_vers_heure($NbHeure[2],null)."</div>";
				$Lecture.="</div></a>";

				$Lecture.="<div>";
					$Lecture.="<button class='btn btn-sm btn-icon btn-icon-only btn-outline-primary align-top float-end' type='button' data-bs-toggle='dropdown' aria-expanded='false' aria-haspopup='true'>";
					$Lecture.="<i data-acorn-icon='more-horizontal'></i>";
					$Lecture.="</button>";
					$Lecture.="<div class='dropdown-menu dropdown-menu-sm dropdown-menu-end'>";
					$Lecture.="<a class='dropdown-item ProfilIdentifiants1' href='".$Dossier."modules/profil/modIdentifiants_script.php?clienum=".$reqAffich['clienum']."'>".$_SESSION['STrad400']."</a>";
					$Lecture.="<div class='dropdown-divider'></div>";
					$Lecture.="<a class='dropdown-item' href='#'>".$_SESSION['STrad614']."</a>";
				$Lecture.="</div>";
				$Lecture.="</div>";

				$Lecture.="</div>";
				$Lecture.="</div>";
				$Lecture.="</div>";
				$Lecture.="</div>";
				$Lecture.="</div>";
				$Lecture.="</div>";
				$Lecture.="</div>";
				$Lecture.="</div>";
			}

		return array($Lecture,$Variable1);
	}
//*************************************************************************************

//***************************** NIVEAU CAVALIER *************************************
function ClieNiveau($niveau,$calepartnum)
	{
		$Lecture="<option value = ''>-- Niveau --</option>";
		$Lecture.="<option value='12'";if(!empty($calepartnum)) {$Lecture.="&".$calepartnum;} $Lecture.="'";if($niveau == 12) {$Lecture.=" selected";} $Lecture.=">Initiation</option>";
		$Lecture.="<option value='11'";if(!empty($calepartnum)) {$Lecture.="&".$calepartnum;} $Lecture.="'";if($niveau == 11) {$Lecture.=" selected";} $Lecture.=">Débutant</option>";
		$Lecture.="<option value='1'";if(!empty($calepartnum)) {$Lecture.="&".$calepartnum;} $Lecture.="'";if($niveau == 1) {$Lecture.=" selected";} $Lecture.=">Galop 1</option>";
		$Lecture.="<option value='2'";if(!empty($calepartnum)) {$Lecture.="&".$calepartnum;} $Lecture.="'";if($niveau == 2) {$Lecture.=" selected";} $Lecture.=">Galop 2</option>";
		$Lecture.="<option value='3'";if(!empty($calepartnum)) {$Lecture.="&".$calepartnum;} $Lecture.="'";if($niveau == 3) {$Lecture.=" selected";} $Lecture.=">Galop 3</option>";
		$Lecture.="<option value='4'";if(!empty($calepartnum)) {$Lecture.="&".$calepartnum;} $Lecture.="'";if($niveau == 4) {$Lecture.=" selected";} $Lecture.=">Galop 4</option>";
		$Lecture.="<option value='5'";if(!empty($calepartnum)) {$Lecture.="&".$calepartnum;} $Lecture.="'";if($niveau == 5) {$Lecture.=" selected";} $Lecture.=">Galop 5</option>";
		$Lecture.="<option value='6'";if(!empty($calepartnum)) {$Lecture.="&".$calepartnum;} $Lecture.="'";if($niveau == 6) {$Lecture.=" selected";} $Lecture.=">Galop 6</option>";
		$Lecture.="<option value='7'";if(!empty($calepartnum)) {$Lecture.="&".$calepartnum;} $Lecture.="'";if($niveau == 7) {$Lecture.=" selected";} $Lecture.=">Galop 7</option>";
		$Lecture.="<option value='8'";if(!empty($calepartnum)) {$Lecture.="&".$calepartnum;} $Lecture.="'";if($niveau == 8) {$Lecture.=" selected";} $Lecture.=">Galop 8</option>";
		$Lecture.="<option value='9'";if(!empty($calepartnum)) {$Lecture.="&".$calepartnum;} $Lecture.="'";if($niveau == 9) {$Lecture.=" selected";} $Lecture.=">Galop 9</option>";
		$Lecture.="<option value='10'";if(!empty($calepartnum)) {$Lecture.="&".$calepartnum;} $Lecture.="'";if($niveau == 10) {$Lecture.=" selected";} $Lecture.=">BPJEPS</option>";

		return $Lecture;
	}

function ClieNiveauLect($clieniveau)
	{
		if(empty($clieniveau))
		{return "Pas d'examen";}
		else if($clieniveau == 1)
		{return "Galop 1";}
		else if($clieniveau == 2)
		{return "Galop 2";}
		else if($clieniveau == 3)
		{return "Galop 3";}
		else if($clieniveau == 4)
		{return "Galop 4";}
		else if($clieniveau == 5)
		{return "Galop 5";}
		else if($clieniveau == 6)
		{return "Galop 6";}
		else if($clieniveau == 7)
		{return "Galop 7";}
		else if($clieniveau == 8)
		{return "Galop 8";}
		else if($clieniveau == 9)
		{return "Galop 9";}
		else if($clieniveau == 10)
		{return "BPJEPS";}
		else if($clieniveau == 11)
		{return "Débutant";}
		else if($clieniveau == 12)
		{return "Initiation";}
		else {return $clieniveau;}
	}
//****************************************************************************************

//************************* COTISATION ************************
function ConfLogCotisationSelect($num)
	{
		$Lecture.="<option value=''>-- Sélectionner --</option>";
		$Lecture.="<option value='1'";if($num == 1) {$Lecture.=" selected";} $Lecture.=">Année civile</option>";
		$Lecture.="<option value='3'";if($num == 3) {$Lecture.=" selected";} $Lecture.=">Année scolaire</option>";
		$Lecture.="<option value='2'";if($num == 2) {$Lecture.=" selected";} $Lecture.=">Date à date</option>";

		return $Lecture;
	}
//*******************************************************************************************

//************************ LISTE FORFAITS / CARTES **********************************
function AfficheForfaitCarte($ConnexionBdd,$Dossier,$clienum)
	{
		$Lecture.="<div style='height:20px;'></div>";
		if(!empty($clienum))
			{

				if($_SESSION['connind'] == 'util')
					{
						$Lecture.="<section id='ForfClieHeureAjou'>";
							$Lecture.="<a href='".$Dossier."modules/clients/modForfClieHeureAjou.php?clienum=".$clienum."' class='LoadPage ForfClieHeureAjou'><div class='LienDefilement1'>".$_SESSION['STrad390']."<img src='".$Dossier."images/FlecheBasBlanc.png' class='ImgSousMenu2' style='float:right;'></div></a>";
						$Lecture.="</section>";

						$req1 = 'SELECT cliesoldforfsortdate FROM clientssoldeforfsortie WHERE clientssoldeforfentree_cliesoldforfentrnum IS NULL AND clients_clienum = "'.$clienum.'" ORDER BY cliesoldforfsortdate ASC LIMIT 0,1';
						$req1Result = $ConnexionBdd ->query($req1) or die ('Erreur SQL !'.$req1.'<br />'.mysqli_error());
						$req1Affich = $req1Result->fetch();
						$CalcDate = formatheure1($req1Affich[0]);
						$req1Affich[0] = $CalcDate[3]."-".$CalcDate[4]."-".$CalcDate[5];

						$NbHeure = CalcNbHeureForfValide($clienum,NULL,$req1Affich[0],$ConnexionBdd);
					}

			// AFFICHE LES ENTRES SANS LES SORTIES
			$req1 = 'SELECT count(cliesoldforfsortnum) FROM clientssoldeforfsortie left outer join calendrier_participants on calendrier_participants_calepartnum = calepartnum left outer join calendrier on calendrier_calenum = calenum WHERE clientssoldeforfsortie.clientssoldeforfentree_cliesoldforfentrnum IS NULL AND clientssoldeforfsortie.clients_clienum = "'.$clienum.'" ORDER BY cliesoldforfsortdate DESC';
			$req1Result = $ConnexionBdd ->query($req1) or die ('Erreur SQL !'.$req1.'<br />'.mysqli_error());
			$req1Affich = $req1Result->fetch();
			if($req1Affich[0] >= 1)
				{
					$Lecture.="<i>".$_SESSION['STrad774']."</i>";
					$Lecture.="<form id='ForfaitCarteAssociation' action=''>";
					$Lecture.="<input type='hidden' name='clienum' value='".$clienum."'>";
					$Lecture.="<table style='width:100%;'>";
					$req1 = 'SELECT cliesoldforfsortnum,cliesoldforfsortdate,cliesoldforfsortnbheure,calendrier_participants_calepartnum,calenum,caledate1 FROM clientssoldeforfsortie left outer join calendrier_participants on calendrier_participants_calepartnum = calepartnum left outer join calendrier on calendrier_calenum = calenum WHERE clientssoldeforfsortie.clientssoldeforfentree_cliesoldforfentrnum IS NULL AND clientssoldeforfsortie.clients_clienum = "'.$clienum.'" ORDER BY cliesoldforfsortdate ASC';
					$req1Result = $ConnexionBdd ->query($req1) or die ('Erreur SQL !'.$req1.'<br />'.mysqli_error());
					while($req1Affich = $req1Result->fetch())
						{
							$Lecture.="<tr><td style='margin-left:40px;'>";
							if($_SESSION['connind'] == 'util') {$Lecture.="<input type='checkbox' name='cliesoldforfsortnum[]' value='".$req1Affich['cliesoldforfsortnum']."'>";}
							$Lecture.=" <b>- ".minute_vers_heure($req1Affich[2])."</b></td>";
							if(!empty($req1Affich[4])) {$Lecture.="<td><a href='".$Dossier."modules/calendrier/modcalefichcomplet.php?calenum=".$req1Affich['calenum']."' class='LoadPage AfficheCaleFichComplet'><i>(".$_SESSION['STrad775']." ".formatdatemysql($req1Affich[5]).")</i></a></td>";}
							if(empty($req1Affich[4]) AND $_SESSION['connind'] == 'util') {$Lecture.="<td><a href='".$Dossier."modules/clients/modforfaitcarteassociation_script.php?cliesoldforfsortnum=".$req1Affich[0]."&clienum=".$clienum."&suppforfaitsortie=2' class='LoadPage ForfSortNumSupp'><img src='".$Dossier."images/supprimer.png' class='ImgSousMenu2'></a>";}
							//if($_SESSION['connind'] == 'util') {$Lecture.=" <a href='?clienum=".$clienum."&cliesoldforfsortnum=".$req1Affich[0]."#ForfSort'><img src='".$Dossier."images/supprimer.png' class='ImgSousMenu2'></a></td>";}
							$Lecture.="</tr>";
						}
					if($_SESSION['connind'] == 'util')
						{
							$Lecture.="<tr><td colspan='3'><select name='cliesoldforfentrnum' class='champ_barre' required>".$NbHeure[1]."</select></td></tr>";
							$Lecture.="<tr><td colspan='3'><button class='button'><img src='".$Dossier."images/ajouterBlanc.png' class='ImgSousMenu2'>".$_SESSION['STrad394']."</button></td></tr>";
						}
					$Lecture.="</table>";
					$Lecture.="</form>";
				}
			}
		$Lecture.="<div style='height:10px;'></div>";

		// LISTE FORFAIT / CARTE
		$Lecture.="<table class='tab_rubrique' style='width:100%;'>";
			$Lecture.="<thead><tr>";
				if(empty($clienum)) {$Lecture.="<td>".$_SESSION['STrad360']."</td>";}
				$Lecture.="<td>".$_SESSION['STrad237']."</td>";
				$Lecture.="<td>".$_SESSION['STrad361']."</td>";
				if(empty($clienum)) {$Lecture.="<td>".$_SESSION['STrad362']."</td>";}
				$Lecture.="<td>".$_SESSION['STrad363']."</td>";
			$Lecture.="</thead></tr>";
			$Lecture.="<tbody>";
			$req1='SELECT * FROM clientssoldeforfentree';
			if(!empty($_SESSION['rechforfaitclienom']) OR !empty($_SESSION['rechforfaitclieprenom']) OR !empty($clienum)) {$req1.=',clientssoldeforfentree_clients,clients';}
			$req1.=' WHERE clientssoldeforfentree.AA_equimondo_hebeappnum = "'.$_SESSION['hebeappnum'].'"';
			if(!empty($_SESSION['rechforfaitdate1']) AND !empty($_SESSION['rechforfaitdate2'])) {$req1.=" AND cliesoldforfentrdate1 >= '".$_SESSION['rechforfaitdate1']."' AND cliesoldforfentrdate2 <= '".$_SESSION['rechforfaitdate2']."'";}
			if(!empty($_SESSION['rechforfaitclienom']) OR !empty($_SESSION['rechforfaitclieprenom']) OR !empty($clienum))
				{
					$req1.=' AND clientssoldeforfentree_cliesoldforfentrnum = cliesoldforfentrnum AND clients_clienum=clienum';
					if(!empty($_SESSION['rechforfaitclienom'])) {$req1.=' AND clienom LIKE "'.$_SESSION['rechforfaitclienom'].'%"';}
					if(!empty($_SESSION['rechforfaitclieprenom'])) {$req1.=' AND clieprenom LIKE "'.$_SESSION['rechforfaitclieprenom'].'%"';}
					if(!empty($clienum)) {$req1.=' AND clienum = "'.$clienum.'"';}
				}
			$req1.=' GROUP BY cliesoldforfentrnum ORDER BY cliesoldforfentrdate1 DESC';
			$req1Result = $ConnexionBdd ->query($req1) or die ('Erreur SQL !'.$req1.'<br />'.mysqli_error());
			while($req1Affich = $req1Result->fetch())
				{
					$ClieLibe="";
					$req2='SELECT clienum,clienom,clieprenom FROM clientssoldeforfentree_clients,clients WHERE clients_clienum = clienum AND clientssoldeforfentree_cliesoldforfentrnum = "'.$req1Affich['cliesoldforfentrnum'].'"';
					$req2Result = $ConnexionBdd ->query($req2) or die ('Erreur SQL !'.$req2.'<br />'.mysqli_error());
					while($req2Affich = $req2Result->fetch()) {$ClieLibe.=$req2Affich['clienom']." ".$req2Affich['clieprenom']."<br>";}

					$req3='SELECT sum(cliesoldforfsortnbheure) FROM clientssoldeforfsortie WHERE clientssoldeforfentree_cliesoldforfentrnum = "'.$req1Affich['cliesoldforfentrnum'].'"';
					$req3Result = $ConnexionBdd ->query($req3) or die ('Erreur SQL !'.$req3.'<br />'.mysqli_error());
					$req3Affich = $req3Result->fetch();

					$TotalHeure = $req1Affich['cliesoldforfentrnbheure'] - $req3Affich[0];
					$CalcPourc = $TotalHeure * 100 / $req1Affich['cliesoldforfentrnbheure'];

					$CalcDate1 = formatheure1($req1Affich['cliesoldforfentrdate2']);
					$CalcDate = $CalcDate1[3].$CalcDate1[4].$CalcDate1[5];
					if($CalcDate < date('Ymd')) {$Alerte = "red";}
					else {$Alerte = "";}

					if($CalcPourc > 0 AND $CalcPourc <= 15) {$AlerteAffiche = "AlerteOrange";}
					else if ($CalcPourc >= 16 AND $CalcPourc <= 100) {$AlerteAffiche = "AlerteGreen";}
					else {$AlerteAffiche = "AlerteRed";}
					if($Alerte == "red") {$AlerteAffiche = "AlerteRed";}

					$Exec = 1;
					if(!empty($_GET['rechforfaitind']) AND !empty($_GET['rechforfaitnbheure']))
						{
							$Calcnbheure = $_GET['rechforfaitnbheure'] * 60;

							if($TotalHeure <= $Calcnbheure AND $_GET['rechforfaitind'] == 1) {$Exec = 2;}
							else if($TotalHeure >= $Calcnbheure AND $_GET['rechforfaitind'] == 2) {$Exec = 2;}
							else {$Exec = 1;}
						}
					else {$Exec = 2;}

					if($Exec == 2)
						{
							$Lien = "<a href='".$Dossier."modules/clients/AfficheFicheCompletForfait.php?cliesoldforfentrnum=".$req1Affich['cliesoldforfentrnum']."&clienum=".$clienum."' class='LoadPage AfficheFicheCompletForfait'>";

							$Lecture.="<tr class='".$AlerteAffiche."'>";
								if(empty($clienum)) {$Lecture.="<td>".$Lien.$ClieLibe."</a></td>";}
								$Lecture.="<td>".$Lien.$req1Affich['cliesoldforfentrlibe']."</a></td>";
								$Lecture.="<td>".$Lien.$_SESSION['STrad365']." ".formatdatemysql($req1Affich['cliesoldforfentrdate1'])." ".$_SESSION['STrad366']." ".formatdatemysql($req1Affich['cliesoldforfentrdate2'])."</a></td>";
								if(empty($clienum)) {$Lecture.="<td>".$Lien.minute_vers_heure($req1Affich['cliesoldforfentrnbheure'])."</a></td>";}
								$Lecture.="<td>".$Lien.minute_vers_heure($TotalHeure)."</a></td>";
								$Lecture.="</tr>";
						}
				}
			$Lecture.="</tbody>";
		$Lecture.="</table>";

		return $Lecture;
	}
//********************************************************************************************

//******************* VERIF SI FORFAIT VALIDE *********************
function ForfaitVerifValide($Dossier,$ConnexionBdd,$cliesoldforfentrnum,$date)
	{
		// INFORMATION FORFAIT
		$req1='SELECT * FROM clientssoldeforfentree WHERE cliesoldforfentrnum = "'.$cliesoldforfentrnum.'"';
		if(!empty($date)) {$req1.=' AND cliesoldforfentrdate1 <= "'.$date.'" AND cliesoldforfentrdate2 >= "'.$date.'"';}
		$req1Result = $ConnexionBdd ->query($req1) or die ('Erreur SQL !'.$req1.'<br />'.mysqli_error());
		$req1Affich = $req1Result->fetch();

		// NOMBRE D'HEURE SORTANT
		$req3='SELECT sum(cliesoldforfsortnbheure) FROM clientssoldeforfsortie WHERE clientssoldeforfentree_cliesoldforfentrnum = "'.$req1Affich['cliesoldforfentrnum'].'"';
		$req3Result = $ConnexionBdd ->query($req3) or die ('Erreur SQL !'.$req3.'<br />'.mysqli_error());
		$req3Affich = $req3Result->fetch();

		$TotalHeure = $req1Affich['cliesoldforfentrnbheure'] - $req3Affich[0];

		if($TotalHeure > 0) {$Valide = 2;}
		else if($TotalHeure <= 0) {$Valide = 1;}

		return array($Valide);
	}
//************************************************************************

//************************ FICHE COMPLET FORFAITS / CARTES **********************************
function FicheCompletForfaitCarte($ConnexionBdd,$Dossier,$cliesoldforfentrnum,$clienum)
	{
		/*
		if($_SESSION['connind'] == 'util') {$Lecture.="<a href='".$Dossier."modules/clients/ForfaitModif.php?cliesoldforfentrnum=".$cliesoldforfentrnum."&clienum=".$clienum."' class='button LoadPage ForfModif'><img src='".$Dossier."images/modifierBlanc.png' class='ImgSousMenu2'>".$_SESSION['STrad304']."</a><span style='margin-left:10px;'></span>";}
		if($_SESSION['connind'] == 'util') {$Lecture.="<a href='".$Dossier."modules/clients/ForfaitSuppConf.php?cliesoldforfentrnum=".$cliesoldforfentrnum."&clienum=".$clienum."' class='button LoadPage ForfSuppConf'><img src='".$Dossier."images/supprimerBlanc.png' class='ImgSousMenu2'>".$_SESSION['STrad155']."</a><span style='margin-left:10px;'></span>";}
		if($_SESSION['connind'] == 'util') {$Lecture.="<a href='".$Dossier."modules/clients/ForfaitRetirerHeure.php?cliesoldforfentrnum=".$cliesoldforfentrnum."&clienum=".$clienum."' class='button LoadPage ForfRetirerHeure'><img src='".$Dossier."images/FlecheBas.png' class='ImgSousMenu2'>".$_SESSION['STrad371']."</a>";}
*/
		if($_SESSION['connind'] == "util")
			{
				$ResultatTailleWidth = "23";

				// MODIFIER
				if($_SESSION['ResolutionConnexion1'] <= 800) {$Libe = $_SESSION['STrad704'];}
				else  {$Libe = $_SESSION['STrad304'];}
				$SousMenuCorp.="<div class='buttonBasMenuFixedRub'";if($_SESSION['ResolutionConnexion1'] <= 800) {$SousMenuCorp.=" style='width:".$ResultatTailleWidth."%;'";}
				$SousMenuCorp.=">";
				if($_SESSION['ResolutionConnexion1'] > 800) {$SousMenuCorp.="<a href='".$Dossier."modules/clients/ForfaitModif.php?cliesoldforfentrnum=".$cliesoldforfentrnum."&clienum=".$clienum."' class='button LoadPage ForfModif button ImgSousMenu2 buttonMargRight'>";}
				if($_SESSION['ResolutionConnexion1'] <= 800) {$SousMenuCorp.="<a href='".$Dossier."modules/clients/ForfaitModif.php?cliesoldforfentrnum=".$cliesoldforfentrnum."&clienum=".$clienum."' class='button LoadPage ForfModif ImgSousMenu2'>";}
				$SousMenuCorp.="<img src='".$Dossier."images/modifierBlanc.png' class='ImgSousMenu2 supp400px supp800px'>";
				$SousMenuCorp.=$Libe."</a></div>";

				// SUPPRIMER
				if($_SESSION['ResolutionConnexion1'] <= 800) {$Libe = $_SESSION['STrad316'];}
				else  {$Libe = $_SESSION['STrad614'];}
				$SousMenuCorp.="<div class='buttonBasMenuFixedRub'";if($_SESSION['ResolutionConnexion1'] <= 800) {$SousMenuCorp.=" style='width:".$ResultatTailleWidth."%;'";}
				$SousMenuCorp.=">";
				if($_SESSION['ResolutionConnexion1'] > 800) {$SousMenuCorp.="<a href='".$Dossier."modules/clients/ForfaitSuppConf.php?cliesoldforfentrnum=".$cliesoldforfentrnum."&clienum=".$clienum."' class='button LoadPage ForfSuppConf button ImgSousMenu2 buttonMargRight'>";}
				if($_SESSION['ResolutionConnexion1'] <= 800) {$SousMenuCorp.="<a href='".$Dossier."modules/clients/ForfaitSuppConf.php?cliesoldforfentrnum=".$cliesoldforfentrnum."&clienum=".$clienum."' class='button LoadPage ForfSuppConf ImgSousMenu2'>";}
				$SousMenuCorp.="<img src='".$Dossier."images/supprimerBlanc.png' class='ImgSousMenu2 supp400px supp800px'>";
				$SousMenuCorp.=$Libe."</a></div>";

				// RETIRER DES HEURES
				if($_SESSION['ResolutionConnexion1'] <= 800) {$Libe = $_SESSION['STrad752'];}
				else  {$Libe = $_SESSION['STrad371'];}
				$SousMenuCorp.="<div class='buttonBasMenuFixedRub'";if($_SESSION['ResolutionConnexion1'] <= 800) {$SousMenuCorp.=" style='width:".$ResultatTailleWidth."%;'";}
				$SousMenuCorp.=">";
				if($_SESSION['ResolutionConnexion1'] > 800) {$SousMenuCorp.="<a href='".$Dossier."modules/clients/ForfaitRetirerHeure.php?cliesoldforfentrnum=".$cliesoldforfentrnum."&clienum=".$clienum."' class='button LoadPage ForfRetirerHeure button ImgSousMenu2 buttonMargRight'>";}
				if($_SESSION['ResolutionConnexion1'] <= 800) {$SousMenuCorp.="<a href='".$Dossier."modules/clients/ForfaitRetirerHeure.php?cliesoldforfentrnum=".$cliesoldforfentrnum."&clienum=".$clienum."' class='button LoadPage ForfRetirerHeure ImgSousMenu2'>";}
				$SousMenuCorp.="<img src='".$Dossier."images/retirerBlanc.png' class='ImgSousMenu2 supp400px supp800px'>";
				$SousMenuCorp.=$Libe."</a></div>";

				// FERMER
				if($_SESSION['ResolutionConnexion1'] <= 800)
					{
						$Libe = $_SESSION['STrad705'];
						$SousMenuCorp.="<div class='buttonBasMenuFixedRub'";if($_SESSION['ResolutionConnexion1'] <= 800) {$SousMenuCorp.=" style='width:".$ResultatTailleWidth."%;'";}
						$SousMenuCorp.="><a href='#FenAfficheFicheProfil1'>";
						$SousMenuCorp.="<img src='".$Dossier."images/closeBlanc.png' class='ImgSousMenu2'>";
						$SousMenuCorp.=$Libe."</a></div>";
					}

				$Lecture.="<div class='buttonBasMenuFixed1'>";
				$Lecture.=$SousMenuCorp;
				$Lecture.="</div>";
			}

		$Lecture.="<div style='height:40px;width:100%;display:block;clear:both;'></div>";

		$req1='SELECT * FROM clientssoldeforfentree WHERE cliesoldforfentrnum = "'.$cliesoldforfentrnum.'"';
		$req1Result = $ConnexionBdd ->query($req1) or die ('Erreur SQL !'.$req1.'<br />'.mysqli_error());
		$req1Affich = $req1Result->fetch();

		$req2='SELECT clienum,clienom,clieprenom FROM clientssoldeforfentree_clients,clients WHERE clients_clienum = clienum AND clientssoldeforfentree_cliesoldforfentrnum = "'.$req1Affich['cliesoldforfentrnum'].'"';
		$req2Result = $ConnexionBdd ->query($req2) or die ('Erreur SQL !'.$req2.'<br />'.mysqli_error());
		while($req2Affich = $req2Result->fetch()) {$ClieLibe.="<a href='".$Dossier."modules/clients/modcliefichcomplet.php?clienum=".$req2Affich['clienum']."'>".$req2Affich['clienom']." ".$req2Affich['clieprenom']."</a><br>";}

		$req3='SELECT sum(cliesoldforfsortnbheure) FROM clientssoldeforfsortie WHERE clientssoldeforfentree_cliesoldforfentrnum = "'.$req1Affich['cliesoldforfentrnum'].'"';
		$req3Result = $ConnexionBdd ->query($req3) or die ('Erreur SQL !'.$req3.'<br />'.mysqli_error());
		$req3Affich = $req3Result->fetch();

		$TotalHeure = $req1Affich['cliesoldforfentrnbheure'] - $req3Affich[0];
		$CalcPourc = $TotalHeure * 100 / $req1Affich['cliesoldforfentrnbheure'];
		if($CalcPourc > 0 AND $CalcPourc <= 15) {$AlerteAffiche = "AlerteOrange";}
		else if ($CalcPourc >= 16 AND $CalcPourc <= 100) {$AlerteAffiche = "AlerteGreen";}
		else {$AlerteAffiche = "AlerteRed";}

		$Lecture.="<table>";
			$Lecture.="<tr class='".$AlerteAffiche."'>";
				$Lecture.="<td>".$_SESSION['STrad364']." :</td>";
				$Lecture.="<td>".minute_vers_heure($TotalHeure)."</td>";
			$Lecture.="</tr>";
			$Lecture.="<tr>";
				$Lecture.="<td>".$_SESSION['STrad237']." :</td>";
				$Lecture.="<td>".$req1Affich['cliesoldforfentrlibe']."</td>";
			$Lecture.="</tr>";
			$Lecture.="<tr>";
				$Lecture.="<td>".$_SESSION['STrad360']." :</td>";
				$Lecture.="<td>".$ClieLibe."</td>";
			$Lecture.="</tr>";
			$Lecture.="<tr>";
				$Lecture.="<td>".$_SESSION['STrad231']." :</td>";
				$Lecture.="<td>".$_SESSION['STrad365']." ".formatdatemysql($req1Affich['cliesoldforfentrdate1'])." ".$_SESSION['STrad366']." ".formatdatemysql($req1Affich['cliesoldforfentrdate2'])."</td>";
			$Lecture.="</tr>";
			$Lecture.="<tr>";
				$Lecture.="<td>".$_SESSION['STrad367']." :</td>";
				$Lecture.="<td>".minute_vers_heure($req1Affich['cliesoldforfentrnbheure'])."</td>";
			$Lecture.="</tr>";
			$Lecture.="<tr>";
				$Lecture.="<td>".$_SESSION['STrad368']." :</td>";
				$Lecture.="<td>".$req1Affich['cliesoldforfentrmontant']."</td>";
			$Lecture.="</tr>";
		$Lecture.="</table>";

		if(!empty($req1Affich['factprestation_factprestnum']))
			{
				$req4='SELECT factnum,factdate,factnumlibe,facttype FROM factures,factprestation WHERE factures_factnum = factnum AND factprestnum = "'.$req1Affich['factprestation_factprestnum'].'" LIMIT 0,1';
				$req4Result = $ConnexionBdd ->query($req4) or die ('Erreur SQL !'.$req4.'<br />'.mysqli_error());
				$req4Affich = $req4Result->fetch();
				$Lecture.="<hr class='Rubrique_hr1'>".$_SESSION['STrad369']." : <a href='".$Dossier."modules/facturation/modfactfichcomplet1.php?factnum=".$req4Affich[0]."' class='LoadPage AfficheFicheFacture1'>".FactIndLect($req4Affich[3])." ".FactPrefLect($req4Affich[1],$req4Affich[2],null)."</a>";
			}

		// AFFICHE LES HEURES DE SORTIES
		if($req3Affich[0] > 0)
			{
				$Lecture.="<div style='height:20px;'></div>";
				$Lecture.="<hr class='Rubrique_hr1'>".$_SESSION['STrad370']." :<hr class='Rubrique_hr1'>";
				$Lecture.="<table class='tab_rubrique'>";
				$req3='SELECT * FROM clientssoldeforfsortie WHERE clientssoldeforfentree_cliesoldforfentrnum = "'.$cliesoldforfentrnum.'"';
				$req3Result = $ConnexionBdd ->query($req3) or die ('Erreur SQL !'.$req3.'<br />'.mysqli_error());
				while($req3Affich = $req3Result->fetch())
					{
						if(!empty($req3Affich['calendrier_participants_calepartnum']))
							{
								$req4='SELECT caledate1,caleindice,calenum,calendrier_participants.chevaux_chevnum FROM calendrier,calendrier_participants WHERE calendrier_calenum = calenum AND calepartnum = "'.$req3Affich['calendrier_participants_calepartnum'].'"';
								$req4Result = $ConnexionBdd ->query($req4) or die ('Erreur SQL !'.$req4.'<br />'.mysqli_error());
								$req4Affich = $req4Result->fetch();
								$req4Affich['caledate1'] = "<a href='?calenum=".$req4Affich['calenum']."&cliesoldforfentrnum=".$cliesoldforfentrnum."&clienum=".$clienum."#CaleFichComplet'>".RdvLibelle($req4Affich['calenum'],$ConnexionBdd)." <br>".FormatDateTimeMySql($req4Affich['caledate1'])."</a>";
							}
						else {$req4Affich['caledate1'] = formatdatemysql($req3Affich['cliesoldforfsortdate']);$req4Affich[3] = "";}

						$Lecture.="<tr>";
							$Lecture.="<td>".minute_vers_heure($req3Affich['cliesoldforfsortnbheure'])." </td>";
							$Lecture.="<td>".$req4Affich['caledate1']."</td>";
							$Lecture.="<td><a href='".$Dossier."modules/clients/modcliefichcomplet.php?clienum=".$req3Affich['clients_clienum']."'>".ClieLect($req3Affich['clients_clienum'],$ConnexionBdd)."</a></td>";
							$Lecture.="<td><a href='".$Dossier."modules/chevaux/modchevfichcomplet.php?chevnum=".$req4Affich[3]."'>".ChevLect($req4Affich[3],$ConnexionBdd)."</a></td>";
							if($_SESSION['connind'] == 'util') {$Lecture.="<td><a href='".$Dossier."modules/clients/modcliefichcomplet_script.php?cliesoldforfentrnum=".$cliesoldforfentrnum."&clienum=".$clienum."&cliesoldforfsortnum=".$req3Affich['cliesoldforfsortnum']."&suppcliesoldforfsortnum=2'></a></td>";}
						$Lecture.="</tr>";
					}
				$Lecture.="</table>";
			}

		return $Lecture;
	}
//********************************************************************************************

//******************************** SUPPRESSION FORFAIT / CARTE ***********************************
function SuppForfait($cliesoldforfentrnum,$suppsort,$clienum,$ConnexionBdd)
	{
		if(!empty($cliesoldforfentrnum))
			{
				$req = 'DELETE FROM clientssoldeforfentree_clients WHERE clientssoldeforfentree_cliesoldforfentrnum = "'.$cliesoldforfentrnum.'"';
				$reqResult = $ConnexionBdd ->query($req) or die ('Erreur SQL !'.$req.'<br />'.mysqli_error());

				$req = 'DELETE FROM clientssoldeforfentree_date WHERE clientssoldeforfentree_cliesoldforfentrnum = "'.$cliesoldforfentrnum.'"';
				$reqResult = $ConnexionBdd ->query($req) or die ('Erreur SQL !'.$req.'<br />'.mysqli_error());

				if($suppsort == 2)
					{
						$req = 'UPDATE clientssoldeforfsortie SET clientssoldeforfentree_cliesoldforfentrnum = NULL WHERE clientssoldeforfentree_cliesoldforfentrnum = "'.$cliesoldforfentrnum.'"';
						$reqResult = $ConnexionBdd ->query($req) or die ('Erreur SQL !'.$req.'<br />'.mysqli_error());
					}
				$req = 'DELETE FROM clientssoldeforfentree WHERE cliesoldforfentrnum = "'.$cliesoldforfentrnum.'"';
				$reqResult = $ConnexionBdd ->query($req) or die ('Erreur SQL !'.$req.'<br />'.mysqli_error());
			}

		if(!empty($clienum))
			{
				$req = 'DELETE FROM clientssoldeforfsortie WHERE clients_clienum = "'.$clienum.'"';
				$reqResult = $ConnexionBdd ->query($req) or die ('Erreur SQL !'.$req.'<br />'.mysqli_error());

				$req = 'SELECT * FROM clientssoldeforfentree_clients WHERE clients_clienum = "'.$clienum.'"';
				$reqResult = $ConnexionBdd ->query($req) or die ('Erreur SQL !'.$req.'<br />'.mysqli_error());
				while($reqAffich = $reqResult->fetch())
					{
						$reqVerif1 = 'SELECT count(cliesoldforfentrclienum) FROM clientssoldeforfentree_clients WHERE clientssoldeforfentree_cliesoldforfentrnum = "'.$reqAffich['clientssoldeforfentree_cliesoldforfentrnum'].'" AND clients_clienum != "'.$reqAffich['clients_clienum'].'"';
						$reqVerif1Result = $ConnexionBdd ->query($reqVerif1) or die ('Erreur SQL !'.$reqVerif1.'<br />'.mysqli_error());
						$reqVerif1Affich = $reqVerif1Result->fetch();
						if($reqVerif1Affich[0] == 0)
							{
								$req1 = 'DELETE FROM clientssoldeforfentree_date WHERE clientssoldeforfentree_cliesoldforfentrnum = "'.$reqAffich['clientssoldeforfentree_cliesoldforfentrnum'].'"';
								$req1Result = $ConnexionBdd ->query($req1) or die ('Erreur SQL !'.$req1.'<br />'.mysqli_error());

								$req1 = 'DELETE FROM clientssoldeforfentree_clients WHERE clientssoldeforfentree_cliesoldforfentrnum = "'.$reqAffich['clientssoldeforfentree_cliesoldforfentrnum'].'"';
								$req1Result = $ConnexionBdd ->query($req1) or die ('Erreur SQL !'.$req1.'<br />'.mysqli_error());

								$req1 = 'DELETE FROM clientssoldeforfentree WHERE cliesoldforfentrnum = "'.$reqAffich['clientssoldeforfentree_cliesoldforfentrnum'].'"';
								$req1Result = $ConnexionBdd ->query($req1) or die ('Erreur SQL !'.$req1.'<br />'.mysqli_error());
							}
						else
							{
								$req1 = 'DELETE FROM clientssoldeforfentree_clients WHERE clientssoldeforfentree_cliesoldforfentrnum = "'.$reqAffich['clientssoldeforfentree_cliesoldforfentrnum'].'"';
								$req1Result = $ConnexionBdd ->query($req1) or die ('Erreur SQL !'.$req1.'<br />'.mysqli_error());
							}
					}
			}
		return 2;
	}
//*******************************************************************************************************

//********************** AFFICHE CAVALIER ASSOCIE FORFAIT / CARTE ************************
function AfficheForfClientsAssocies($Dossier,$ConnexionBdd,$cliesoldforfentrnum)
	{
		$Lecture.="<table style='width:100%;'>";
		$req1 = 'SELECT * FROM clientssoldeforfentree_clients WHERE clientssoldeforfentree_cliesoldforfentrnum="'.$cliesoldforfentrnum.'"';
		$req1Result = $ConnexionBdd ->query($req1) or die ('Erreur SQL !'.$req1.'<br />'.mysqli_error());
		while($req1Affich = $req1Result->fetch())
			{
				$Lecture.="<tr><td>".ClieLect($req1Affich['clients_clienum'],$ConnexionBdd)."</td><td><a href='".$Dossier."modules/clients/modforfcliesupp.php?cliesoldforfentrclienum=".$req1Affich['cliesoldforfentrclienum']."&cliesoldforfentrnum=".$cliesoldforfentrnum."' class='LoadPage ForfClieSupp'><img src='".$Dossier."images/supprimer.png' class='ImgSousMenu2'></a></td></tr>";
			}
    $Lecture.="<tr style='height:15px;'></tr>";
		$Lecture.="<tr><td colspan='2'><select id='select2' name='clienum' class='champ_barre' onchange='ClieForfModifAjouClie(this.value)'>".ClieSelect($Dossier,$ConnexionBdd,$clienum,$faminum,$factnum,$AfficheNull,$AjouterClientPassage,$calenum,$chevnum,$AfficherAjouCava)."</select></td></tr>";
		$Lecture.="</table>";

		return $Lecture;
	}
//******************************************************************

//*******************  MEMBRE DE LA MEME FAMILLE ***************************
function MembreFamille($Dossier,$ConnexionBdd,$clienum)
	{
		$Lecture.="<div class='row row-cols-1 row-cols-md-2 row-cols-xxl-3 g-2 mb-5'>";
		$req1 = 'SELECT familleclients_famiclienum FROM clients WHERE clienum = "'.$clienum.'"';
		$req1Result = $ConnexionBdd ->query($req1) or die ('Erreur SQL !'.$req1.'<br />'.mysqli_error());
		$req1Affich = $req1Result->fetch();
		$faminum = $req1Affich[0];

		$req2Count = 'SELECT count(clienum) FROM clients WHERE familleclients_famiclienum="'.$faminum.'" AND cliesupp = "1" AND clienum != "'.$clienum.'" GROUP BY clienum';
		$req2CountResult = $ConnexionBdd ->query($req2Count) or die ('Erreur SQL !'.$req2Count.'<br />'.mysqli_error());
		$req2CountAffich = $req2CountResult->fetch();
		if($req2CountAffich[0] >= 1)
			{
				$Lecture.="<div style='clear:both;display:block;width:100%;'>";
				$Lecture.="<a href='".$Dossier."modules/clients/modMembreFamilleSupp.php?clienum=".$clienum."' class='MembreFamilleSupp1'><div class='card-footer border-0 pt-0 d-flex justify-content-end align-items-center'>
					<div>
						<button class='btn btn-icon btn-icon-end btn-primary' type='submit'>
							<span>".$_SESSION['STrad392']."</span>
							<i data-acorn-icon='chevron-right'></i>
						</button>
					</div>
				</div></a>";
				$Lecture.="</div>";
				$req2 = 'SELECT * FROM clients WHERE familleclients_famiclienum="'.$faminum.'" AND cliesupp = "1" AND clienum != "'.$_GET['clienum'].'" GROUP BY clienum ORDER BY clienom ASC';
				$req2Result = $ConnexionBdd ->query($req2) or die ('Erreur SQL !'.$req2.'<br />'.mysqli_error());
				while($req2Affich = $req2Result->fetch())
					{
						$FileName = "http://equimondo.fr/perso_images/clients/".$req2Affich['clienum'].".png";

						if(!file_exists($FileName))
							{
								$FileName = $Dossier."img/profile/profile-1.webp";
							}

						$Lecture.="<div class='col'>
							<div class='card'>
								<div class='card-body'>
									<div class='row g-0 sh-6'>
										<div class='col-auto'>
											<img src='".$FileName."' class='card-img rounded-xl sh-6 sw-6' alt='thumb' />
										</div>
										<div class='col'>
											<div class='card-body d-flex flex-row pt-0 pb-0 ps-3 pe-0 h-100 align-items-center justify-content-between'>
												<div class='d-flex flex-column'>
													<div>".$req2Affich['clienom']." ".$req2Affich['clieprenom']."</div>
													<div class='text-small text-muted'>".ClieStatus($req2Affich['cliestatus'])."</div>
												</div>";
												if($_SESSION['connind'] == "util")
													{
														$Lecture.="<div class='d-flex'>
		                          <a href='".$Dossier."modules/clients/modMembreFamilleSupp_script.php?clienum=".$clienum."&clienumsupp=".$req2Affich['clienum']."' class='MembreFamilleClieSupp1'>SUPP</a>
		                        </div>";
													}
												$Lecture.="
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>";
					}

				if($_SESSION['connind'] == "util")
					{
						$Lecture.=$_SESSION['STrad393'];
						$Lecture.="<br><form id='FormMembreFamilleAjou1' action = ''>";
						$Lecture.="<input type='hidden' name='clienum' value='".$clienum."'>";
						$Lecture.="<select name='famiclienum[]' multiple='multiple' id='select2Multiple' class='form-control'>".ClieSelect($Dossier,$ConnexionBdd,null,null,$factnum,$AfficheNull,$AjouterClientPassage,$calenum,$chevnum,$AfficherAjouCava)."</select>";
						$Lecture.="<div class='card-footer border-0 pt-0 d-flex justify-content-end align-items-center'>
						  <div>
						    <button class='btn btn-icon btn-icon-end btn-primary' type='submit'>
						      <span>".$_SESSION['STrad160']."</span>
						      <i data-acorn-icon='chevron-right'></i>
						    </button>
						  </div>
						</div>";

						$Lecture.="</form>";
					}

			}

		if($req2CountAffich[0] == 0 AND $_SESSION['connind'] == "util")
			{
				$Lecture.="<div style='clear:both;display:block;width:100%;'>";
				$Lecture.=$_SESSION['STrad395']." :";
				$Lecture.="<div style='width:100%;clear:both;display:block;margin-top:20px;'><form id='FormMembreFamilleAjou2' action = ''>";
				$Lecture.="<input type='hidden' name='clienum' value='".$clienum."'>";
				$Lecture.="<select id='selectBasic' class='form-control' name='famiclienum'>".ClieSelect($Dossier,$ConnexionBdd,null,null,$factnum,$AfficheNull,$AjouterClientPassage,$calenum,$chevnum,$AfficherAjouCava)."</select>";

				$Lecture.="<div class='card-footer border-0 pt-0 d-flex justify-content-end align-items-center'>
				  <div>
				    <button class='btn btn-icon btn-icon-end btn-primary' type='submit'>
				      <span>".$_SESSION['STrad394']."</span>
				      <i data-acorn-icon='chevron-right'></i>
				    </button>
				  </div>
				</div>";
				$Lecture.="</form></div>";
				$Lecture.="</div>";
			}


			$Lecture.="</div>";

		return $Lecture;
	}
//******************************************************************

//********************* POUVOIR DIRE SI LA LICENCE EST VALIDE OU NON ***********************
function ClientsLicenceValide($Dossier,$Connexion,$clienum)
	{
		$req2 = 'SELECT * FROM clients WHERE clienum="'.$clienum.'"';
		$req2Result = $ConnexionBdd ->query($req2) or die ('Erreur SQL !'.$req2.'<br />'.mysqli_error());
		$req2Affich = $req2Result->fetch();

		if($req2Affich['cliedatevallic'] >= date('Y-m-d') AND !empty($req2Affich['cliedatevallic']) AND $req2Affich['cliedatevallic'] != "0000-00-00") {$Resultat = 2;}
		else {$Resultat = 1;}

		return $Resultat;
	}
//******************************************************************

//********************* POUVOIR DIRE SI LA COTISATION EST VALIDE OU NON ***********************
function ClientsCotisationValide($Dossier,$Connexion,$clienum)
	{
		$req2 = 'SELECT * FROM clients WHERE clienum="'.$clienum.'"';
		$req2Result = $ConnexionBdd ->query($req2) or die ('Erreur SQL !'.$req2.'<br />'.mysqli_error());
		$req2Affich = $req2Result->fetch();

		if($req2Affich['cliedatecotisation'] >= date('Y-m-d') AND !empty($req2Affich['cliedatecotisation']) AND $req2Affich['cliedatecotisation'] != "0000-00-00") {$Resultat = 2;}
		else {$Resultat = 1;}

		return $Resultat;
	}
//******************************************************************

//************************* CALCUL AGE *************************
function CalcAge($date)
  {
    $age = date('Y') - $date;
    if (date('md') < date('md', strtotime($date))) {return $age - 1;}
    return $age;
  }
//******************************************************************

//******************* AFFICHE FORFAITS CARTES CLIENTS ******************************
function ListeForfaitsClients($Dossier,$ConnexionBdd,$clienum)
	{
		$Lecture.="<table class='table table-bordered'><tbody>";
		$req1 = 'SELECT * FROM clientssoldeforf WHERE clients_clienum = "'.$clienum.'" ORDER BY clientssoldeforfdate2 DESC';
		$req1Result = $ConnexionBdd ->query($req1) or die ('Erreur SQL !'.$req1.'<br />'.mysqli_error());
		while($req1Affich = $req1Result->fetch())
		  {
		    // LIBELLE
		    if(!empty($req1Affich['clientssoldeforfentree_cliesoldforfentrnum']))
		      {
						$req2 = 'SELECT * FROM clientssoldeforfentree WHERE cliesoldforfentrnum = "'.$req1Affich['clientssoldeforfentree_cliesoldforfentrnum'].'"';
						$req2Result = $ConnexionBdd ->query($req2) or die ('Erreur SQL !'.$req2.'<br />'.mysqli_error());
						$req2Affich = $req2Result->fetch();

		        if(!empty($req2Affich['cliesoldforfentrlibe'])) {$Libe = $req2Affich['cliesoldforfentrlibe'];}
						else {$Libe = $_SESSION['STrad838'];}
		        $NbHeure = $req2Affich['cliesoldforfentrnbheure'];
		        $MontantHeure = $req2Affich['cliesoldforfentrmontant'];
		        $date1 = $req2Affich['cliesoldforfentrdate1'];
		        $date2 = $req2Affich['cliesoldforfentrdate2'];
		      }
		    else if(!empty($req1Affich['clientssoldeforfsortie_cliesoldforfsortnum']))
		      {
						$req2 = 'SELECT * FROM clientssoldeforfsortie WHERE cliesoldforfsortnum = "'.$req1Affich['clientssoldeforfsortie_cliesoldforfsortnum'].'"';
						$req2Result = $ConnexionBdd ->query($req2) or die ('Erreur SQL !'.$req2.'<br />'.mysqli_error());
						$req2Affich = $req2Result->fetch();

		        if(!empty($req2Affich['calendrier_participants_calepartnum']))
		          {
		            $req3 = 'SELECT calendrier_calenum,chevaux_chevnum FROM calendrier_participants WHERE calepartnum = "'.$req2Affich['calendrier_participants_calepartnum'].'"';
		            $req3Result = $ConnexionBdd ->query($req3) or die ('Erreur SQL !'.$req3.'<br />'.mysqli_error());
		            $req3Affich = $req3Result->fetch();
		            $Libe = RdvLibelle($req3Affich['calendrier_calenum'],$ConnexionBdd);
		            if(!empty($req3Affich['chevaux_chevnum']))
		              {
		                $Libe = $Libe." ".ChevLect($req3Affich['chevaux_chevnum'],$ConnexionBdd);
		              }
		          }
		        else {$Libe = $_SESSION['STrad836'];}

		        $NbHeure = $req2Affich['cliesoldforfsortnbheure'];
		        $MontantHeure = $req2Affich['cliesoldforfsortmontant'];
		        $date1 = $req2Affich['cliesoldforfsortdate1'];
		        $date2 = "";
		      }

				$Lecture.="<tr>";
					$Lecture.="<td>".$Libe."</td>";
					$Lecture.="<td>".minute_vers_heure($NbHeure,null)."</td>";
					$Lecture.="<td>".$MontantHeure." ".$_SESSION['STrad27']." / ".$_SESSION['STrad28']."</td>";
					$Lecture.="<td>".FormatDateTimeMySql($date1);
					if(!empty($date2) AND $date1 != $date2)
					  {
					    $Lecture.=" - ".FormatDateTimeMySql($date2);
					  }
					$Lecture.="</td>";
				$Lecture.="</tr>";
		  }

		$Lecture.="</tbody></table>";

		return $Lecture;
	}
//******************************************************************


?>
