<?php
//******************************* AFFICHER UN CLIENT *************************
function ClieLect($num,$ConnexionBdd)
	{
		$req = 'SELECT * FROM clients WHERE clienum="'.$num.'"';
		$reqResult = $ConnexionBdd ->query($req) or die ('Erreur SQL !'.$req.'<br />'.mysqli_error());
		$reqAffich = $reqResult->fetch();

		if($_SESSION['infologlang2'] == "es") {$Lecture.=$reqAffich['clieprenom']." ".$reqAffich['clienom'];}
		else {$Lecture.=$reqAffich['clienom']." ".$reqAffich['clieprenom'];}

		return $Lecture;
	}

//******************************* AFFICHER UN CLIENT *************************
function DocLect($num,$ConnexionBdd)
{
	$req = 'SELECT * FROM document WHERE docunum="'.$num.'"';
	$reqResult = $ConnexionBdd ->query($req) or die ('Erreur SQL !'.$req.'<br />'.mysqli_error());
	$reqAffich = $reqResult->fetch();


	if($_SESSION['infologlang2'] == "es") {$Lecture=$reqAffich['docutitre'];}
	else {$Lecture=$reqAffich['docutitre'];}


	return $Lecture;
}
//****************************************************************************************

//******************************* AFFICHER UN CHEVAL *************************
function ChevLect($num,$ConnexionBdd)
	{
		$req = 'SELECT * FROM chevaux WHERE chevnum="'.$num.'"';
		$reqResult = $ConnexionBdd ->query($req) or die ('Erreur SQL !'.$req.'<br />'.mysqli_error());
		$reqAffich = $reqResult->fetch();

		$Lecture=$reqAffich['chevnom'];

		return $Lecture;
	}
//****************************************************************************************

//******************************* AFFICHER UN AUTHENTIFICATION *************************
function AuthLect($num,$ConnexionBdd)
	{
		$req = 'SELECT * FROM authentification WHERE authnum="'.$num.'"';
		$reqResult = $ConnexionBdd ->query($req) or die ('Erreur SQL !'.$req.'<br />'.mysqli_error());
		$reqAffich = $reqResult->fetch();
		if(!empty($reqAffich['clients_clienum'])) {$Lecture = ClieLect($reqAffich['clients_clienum'],$ConnexionBdd);}
		if(!empty($reqAffich['utilisateurs_utilnum'])) {$Lecture = UtilLect($reqAffich['utilisateurs_utilnum'],$ConnexionBdd);}

		return $Lecture;
	}
//****************************************************************************************

//******************************* AFFICHER UN GROUPE *************************
function GroupeLect($num,$ConnexionBdd)
	{
		$req = 'SELECT * FROM groupe WHERE groupnum="'.$num.'"';
		$reqResult = $ConnexionBdd ->query($req) or die ('Erreur SQL !'.$req.'<br />'.mysqli_error());
		$reqAffich = $reqResult->fetch();
		if(!empty($reqAffich['groupnum'])) {$Lecture = $reqAffich['groupnom'];}

		return $Lecture;
	}
//****************************************************************************************

//******************************* CONFIGURATION NIVEAU ************************
function NiveauSelect($num,$ConnexionBdd)
	{
		$Lecture.="<option value='NULL'>- ".$_SESSION['STrad122']." -</option>";

		$req = 'SELECT * FROM calendrier_niveau_configuration WHERE AA_equimondo_hebeappnum = "'.$_SESSION['hebeappnum'].'" ORDER BY caleniveconflibe ASC';
		$reqResult = $ConnexionBdd ->query($req) or die ('Erreur SQL !'.$req.'<br />'.mysqli_error());
		while($reqAffich = $reqResult->fetch())
			{
				$Lecture.="<option value='".$reqAffich['caleniveconflibe']."'>".$reqAffich['caleniveconflibe']."</option>";
			}

		return $Lecture;
	}
//*******************************************************************

//******************************* CONFIGURATION PAYS*************************
function PaysSelect($num,$ConnexionBdd)
	{
		$Lecture.="<option value=''>- Pays -</option>";
		$req = 'SELECT * FROM confpays ORDER BY confpayslibe ASC';
		$reqResult = $ConnexionBdd ->query($req) or die ('Erreur SQL !'.$req.'<br />'.mysqli_error());
		while($reqAffich = $reqResult->fetch())
			{
				$Lecture.="<option value='".$reqAffich['confpayslibe']."'>".$reqAffich['confpayslibe']."</option>";
			}

		return $Lecture;
	}
function PaysLect($num,$ConnexionBdd)
	{
		$req = 'SELECT * FROM confpays WHERE confpaysnum="'.$num.'"';
		$reqResult = $ConnexionBdd ->query($req) or die ('Erreur SQL !'.$req.'<br />'.mysqli_error());
		$reqAffich = $reqResult->fetch();
		$Lecture = $reqAffich['confpayslibe'];

		return $Lecture;
	}
//****************************************************************************************

//************************** AFFICHER MODE DE PAIEMENT ********************************************
function ModePaieLect($num,$ConnexionBdd)
	{
		$req = 'SELECT modepaienum,modepaielibe FROM mode_paie WHERE modepaienum = "'.$num.'"';
		$reqResult = $ConnexionBdd ->query($req) or die ('Erreur SQL !'.$req.'<br />'.mysqli_error());
		$reqAffich = $reqResult->fetch();
		$Lecture.=$reqAffich[1];

		return $Lecture;
	}
//****************************************************************************************

//******************************* AFFICHER UNE PRESTATION *************************
function TypePrestationLect($num,$ConnexionBdd)
	{
		$req = 'SELECT * FROM typeprestation WHERE typeprestnum="'.$num.'"';
		$reqResult = $ConnexionBdd ->query($req) or die ('Erreur SQL !'.$req.'<br />'.mysqli_error());
		$reqAffich = $reqResult->fetch();

		$Lecture.=$reqAffich['typeprestlibe'];

		return $Lecture;
	}
//****************************************************************************************

//******************************* CATEGORIE CALENDRIER *************************
function CaleCateLect($num,$ConnexionBdd)
	{
		$req = 'SELECT * FROM calendrier_categorie WHERE calecatenum="'.$num.'"';
		$reqResult = $ConnexionBdd ->query($req) or die ('Erreur SQL !'.$req.'<br />'.mysqli_error());
		$reqAffich = $reqResult->fetch();

		$Lecture=$reqAffich['calecatelibe'];

		return $Lecture;
	}
//****************************************************************************************

//******************************************* FONCTION SELECT CAVALIER *******************************************
function ClieSelect($Dossier,$ConnexionBdd,$clienum,$faminum,$factnum,$AfficheNull,$AjouterClientPassage,$calenum,$chevnum,$AfficherAjouCava,$ResponsableLegal,$calecopier,$SelectMontoir)
	{
		if($ResponsableLegal == 2 AND !empty($faminum))
			{
				$reqClie = 'SELECT * FROM clients WHERE familleclients_famiclienum = "'.$faminum.'"';
				$reqClieResult = $ConnexionBdd ->query($reqClie) or die ('Erreur SQL !'.$reqClie.'<br />'.mysqli_error());
				while($reqClieAffich = $reqClieResult->fetch())
					{
						if($reqClieAffich['cliestatus'] == 2 OR $reqClieAffich['cliestatus'] == 3) {$Selected = "selected";$SelectedOne = 2;} else {$Selected = "";}
						$Lecture.="<option value='".$reqClieAffich['clienum']."'";if(!empty($Selected)) {$Lecture.=" ".$Selected;} $Lecture.=">".ClieLect($reqClieAffich['clienum'],$ConnexionBdd)."</option>";
					}
			}

		if(!empty($chevnum) AND !empty($calenum))
			{
				$reqCale = 'SELECT clients_clienum,clienom,clieprenom FROM calendrier_participants,clients WHERE clients_clienum = clienum AND calendrier_calenum = "'.$calenum.'" AND chevaux_chevnum = "'.$chevnum.'"';
				$reqCaleResult = $ConnexionBdd ->query($reqCale) or die ('Erreur SQL !'.$reqCale.'<br />'.mysqli_error());
				$reqCaleAffich = $reqCaleResult->fetch();
				if(!empty($reqCaleAffich[0])) {$Lecture.="<option value='".$reqCaleAffich[0]."'>".ClieLect($reqCaleAffich[0],$ConnexionBdd)."</option>";}
			}

		if($AfficheNull == 2) {$ClieNumNull = "NULL";} else {$ClieNumNull = "";}
		if($AfficherAjouCava == 2) {$LibeOption = $_SESSION['STrad281'];}
		else if(!empty($calenum) AND !empty($reqCaleAffich[0])) {$LibeOption = $_SESSION['STrad192']." ".$reqCaleAffich[2];}
		else {$LibeOption = $_SESSION['STrad114'];}
		$Lecture.="<option value='".$ClieNumNull;if(!empty($calenum)) {$Lecture.="|".$calenum."|".$chevnum;} $Lecture.="'>- ".$LibeOption." -</option>";

		if($AjouterClientPassage == 2)
			{
				$Lecture.="<option value='AjouCliePassage'>- ".$_SESSION['STrad179']." -</option>";
			}

		$req = 'SELECT * FROM clients';
		if(!empty($calenum) AND $calecopier != 2) {$req.= ',calendrier_participants';}
		$req.= ' WHERE clients.AA_equimondo_hebeappnum = "'.$_SESSION['hebeappnum'].'"';
		if(!empty($calenum) AND $calecopier != 2){$req.= ' AND clients_clienum = clienum AND calendrier_calenum = "'.$calenum.'"';}
		$req.=	' GROUP BY clienum';
		$req.= ' ORDER BY clienom ';
		if($_SESSION['infologlang2'] == "es") {$req.='DESC';}
		else {$req.='ASC';}
		$reqResult = $ConnexionBdd ->query($req) or die ('Erreur SQL !'.$req.'<br />'.mysqli_error());
		while($reqAffich = $reqResult->fetch())
			{
				if(!empty($calenum) AND !empty($chevnum) AND $Exec == 2)
					{
						$VerifDispo = VerifDispo($chevnum,$_SESSION['DateMontoir'],$_SESSION['DateMontoir'],$reqAffich['clienum'],null,$Dossier,$reqAffich['clieniveau'],$ConnexionBdd);
						if($VerifDispo[0] == 2) {$Exec = 2;}
						else {$Exec = 1;}
					}
				else {$Exec = 2;}

				if(!empty($calenum) AND empty($reqAffich['chevaux_chevnum']) AND $AfficheNull == 2) {$Exec = 2;}
				else if(!empty($calenum) AND !empty($reqAffich['chevaux_chevnum']) AND $AfficheNull == 2) {$Exec = 1;}

				if($Exec == 2)
					{
						$reqClie = 'SELECT cliesupp FROM clients WHERE clienum = "'.$reqAffich['clienum'].'"';
						$reqClieResult = $ConnexionBdd ->query($reqClie) or die ('Erreur SQL !'.$reqClie.'<br />'.mysqli_error());
						$reqClieAffich = $reqClieResult->fetch();
						if(empty($clienum) AND $reqClieAffich['cliesupp'] == 1) {$Exec = 2;}
						else if(empty($clienum) AND $reqClieAffich['cliesupp'] != 1) {$Exec = 1;}
						else if(!empty($clienum) AND $reqAffich['clienum'] == $clienum) {$Exec = 2;}
						else if(!empty($clienum) AND $reqClieAffich['cliesupp'] == 1) {$Exec = 2;}
						else {$Exec = 1;}
					}

				if($Exec == 2)
					{
						if(!empty($calenum) AND $calecopier == 2)
							{
								$reqCale = 'SELECT count(calepartnum) FROM calendrier_participants WHERE calendrier_calenum = "'.$calenum.'" AND clients_clienum = "'.$reqAffich['clienum'].'"';
								$reqCaleResult = $ConnexionBdd ->query($reqCale) or die ('Erreur SQL !'.$reqCale.'<br />'.mysqli_error());
								$reqCaleAffich = $reqCaleResult->fetch();
								if($reqCaleAffich[0] >= 1) {$Selected = "selected";} else {$Selected = "";}
							}
						else if($clienum == $reqAffich[0] AND $SelectedOne != 2) {$Selected = "selected";} else {$Selected = "";}

						$reqAffich['clienom'] = EnleverAccent1($reqAffich['clienom']);
						$reqAffich['clieprenom'] = EnleverAccent1($reqAffich['clieprenom']);

					 	$Libe = EnleverAccent1(ClieLect($reqAffich['clienum'],$ConnexionBdd));

						$Lecture.="<option value='";if($SelectMontoir != 2) {$Lecture.=$reqAffich[0];} if(!empty($factnum)) {$Lecture.="|".$factnum;} if(!empty($reqAffich['calepartnum'])) {$Lecture.="|".$reqAffich['calepartnum']."|".$chevnum;} $Lecture.="'";if(!empty($Selected)) {$Lecture.=" selected";} $Lecture.=">".$Libe."</option>";
					}
			}

		return $Lecture;
	}
//******************************************************echo $reqPart."<br>";**********************************

//******************************* FONCTION SELECT CHEVAUX *******************************
function ChevSelect($Dossier,$ConnexionBdd,$chevnum,$clienum,$ChevNumNull,$calepartnum,$calenum)
	{
		if($ChevNumNull == 2) {$ChevNumNull = "NULL";} else {$ChevNumNull = "";}
		$Lecture.="<option value='".$ChevNumNull."'>- ".$_SESSION['STrad115']." -</option>";

		if(!empty($calepartnum))
			{
				$reqCale = 'SELECT * FROM calendrier,calendrier_participants WHERE calendrier_calenum = calenum AND calepartnum = "'.$calepartnum.'"';
				$reqCaleResult = $ConnexionBdd ->query($reqCale) or die ('Erreur SQL !'.$reqCale.'<br />'.mysqli_error());
				$reqCaleAffich = $reqCaleResult->fetch();
				$caledate = formatheure1($reqCaleAffich['caledate1']);
				$caledate = $caledate[3]."-".$caledate[4]."-".$caledate[5];
			}
		//*********** AFFICHER LES CHEVAUX EN PROPRIETE D UN CLIENT *******************
		if(!empty($clienum))
			{
				$req1 = 'SELECT count(chevnum) FROM chevaux,avoir WHERE clients_clienum = "'.$clienum.'" AND chevaux_chevnum = chevnum AND chevsupp = "1" AND chevaux.AA_equimondo_hebeappnum = "'.$_SESSION['hebeappnum'].'"';
				$req1Result = $ConnexionBdd ->query($req1) or die ('Erreur SQL !'.$req1.'<br />'.mysqli_error());
				$req1Affich = $req1Result->fetch();
				if($req1Affich[0] >= 1)
					{
						$Lecture.="<option value=''>- ".$_SESSION['STrad333']." -</option>";
						$req = 'SELECT chevnum,chevnom,chevrobe,chevcomm FROM chevaux,avoir WHERE clients_clienum = "'.$clienum.'" AND chevaux_chevnum = chevnum AND chevsupp = "1" AND chevaux.AA_equimondo_hebeappnum = "'.$_SESSION['hebeappnum'].'" ORDER BY chevnom ASC';
						$reqResult = $ConnexionBdd ->query($req) or die ('Erreur SQL !'.$req.'<br />'.mysqli_error());
						while($reqAffich = $reqResult->fetch())
							{
								if($chevnum == $reqAffich[0]) {$Selected =" selected";$SelectedProprio = 2;}
								else {$Selected = "";}

								$Lecture.="<option value='".$reqAffich[0];if(!empty($calepartnum)) {$Lecture.="|".$calepartnum;} $Lecture.="'";if(!empty($Selected)) {$Lecture.=" ".$Selected;} $Lecture.=">".$reqAffich[1]."</option>";
							}
						$Lecture.="<option value='NULL'>-------------------------------</option>";
					}
			}
		//*******************************************************************

		$req = 'SELECT chevnum,chevnom,chevrobe,chevcomm FROM chevaux WHERE chevsupp = "1" AND AA_equimondo_hebeappnum = "'.$_SESSION['hebeappnum'].'" ORDER BY chevnom ASC';
		$reqResult = $ConnexionBdd ->query($req) or die ('Erreur SQL !'.$req.'<br />'.mysqli_error());
		while($reqAffich = $reqResult->fetch())
			{
				if($chevnum == $reqAffich[0]) {$Selected =" selected";}
				else {$Selected = "";}
				if(!empty($clienum))
					{
						$req1 = 'SELECT count(avoirnum) FROM avoir WHERE clients_clienum = "'.$clienum.'" AND chevaux_chevnum ="'.$reqAffich['chevnum'].'"';
						$req1Result = $ConnexionBdd ->query($req1) or die ('Erreur SQL !'.$req1.'<br />'.mysqli_error());
						$req1Affich = $req1Result->fetch();
						if($req1Affich[0] >= 1) {$Exec = 1;}
						else $Exec = 2;
					}
				else {$Exec = 2;}

				if(!empty($calepartnum))
					{
						$VerifDispo = VerifDispo($reqAffich['chevnum'],$caledate,$caledate,$chevnum,null,$Dossier,null,$ConnexionBdd);
						if($VerifDispo[0] == 1) {$Exec = 1;}
					}

				if(!empty($Selected)) {$Exec = 2;}

				if($Exec == 2)
					{
						if(!empty($calenum))
							{
								$reqCale = 'SELECT count(calepartnum) FROM calendrier_participants WHERE calendrier_calenum = "'.$calenum.'" AND chevaux_chevnum ="'.$reqAffich['chevnum'].'"';
								$reqCaleResult = $ConnexionBdd ->query($reqCale) or die ('Erreur SQL !'.$reqCale.'<br />'.mysqli_error());
								$reqCaleAffich = $reqCaleResult->fetch();
								if($reqCaleAffich[0] >= 1) {$Selected =" selected";} else {$Selected ="";}
							}

						$Lecture.="<option value='".$reqAffich[0];if(!empty($calepartnum)) {$Lecture.="|".$calepartnum;} $Lecture.="'";if(!empty($Selected)) {$Lecture.=" ".$Selected;} $Lecture.=">".$reqAffich[1]."</option>";
					}
			}

		return $Lecture;
	}
//****************************************************************************************

//******************************************* FONCTION SELECT GROUPE *******************************************
function GroupSelect($Dossier,$ConnexionBdd,$groupnum,$groupind)
	{
		$Lecture.="<option value = ''>- ".$_SESSION['STrad711']." -</option>";

		$req = 'SELECT * FROM groupe WHERE AA_equimondo_hebeappnum = "'.$_SESSION['hebeappnum'].'"';
		if(!empty($groupind)) {$req.=' AND groupind = "'.$groupind.'"';}
		$req.=' ORDER BY groupnom ASC';
		$reqResult = $ConnexionBdd ->query($req) or die ('Erreur SQL !'.$req.'<br />'.mysqli_error());
		while($reqAffich = $reqResult->fetch())
			{
				$req1 = 'SELECT count(groupassonum) FROM groupe_association WHERE groupe_groupnum = "'.$reqAffich['groupnum'].'"';
				$req1Result = $ConnexionBdd ->query($req1) or die ('Erreur SQL !'.$req1.'<br />'.mysqli_error());
				$req1Affich = $req1Result->fetch();
				$Lecture.="<option value='".$reqAffich['groupnum']."'";if($groupnum == $reqAffich['groupnum']) {$Lecture.=" selected";} $Lecture.=">".$reqAffich['groupnom']." (".$req1Affich[0].")</option>";
			}

		return $Lecture;
	}
//****************************************************************************************

//******************************** AJOUTER UNE FACTURE ********************************
function FactAjou($factdate,$factcom,$clienum,$facttype,$ConnexionBdd,$factcondition,$factnumlibe)
	{
		// CALCUL LE DERNIER NUMÉRO DE FACTURE
		if($facttype == 8) {$FactNumDern = SecureInput($factnumlibe);}
		else {$FactNumDern=CalcDernNumFact($facttype,$ConnexionBdd);}
		$Lien = GenererLien($ConnexionBdd);

		if(!empty($factcondition)) {$factcondition = $factcondition;} else {$factcondition = $_SESSION['conflogcondfact'];}
		$factcondition = str_replace('"', '\"', $factcondition);
		$factcom = str_replace('"', '\"', $factcom);

		$req = 'INSERT INTO factures VALUE (NULL,"'.$factdate.'","'.$FactNumDern.'","'.$factcom.'","'.$clienum.'","'.$facttype.'","1","1","0","0","'.$factcondition.'","'.$Lien.'","1","'.$_SESSION['hebeappnum'].'")';
		$reqResult = $ConnexionBdd ->query($req) or die ('Erreur SQL !'.$req.'<br />'.mysqli_error());
		$factnum = $ConnexionBdd->lastInsertId();

		if($facttype == 4 OR $facttype == 5)
			{
				$req2 = 'INSERT INTO livredecompte VALUE (NULL,"'.$factdate.'","'.$factnum.'",NULL,'.$_SESSION['hebeappnum'].','.$clienum.')';
    		$req2Result = $ConnexionBdd ->query($req2) or die ('Erreur SQL !'.$req2.'<br />'.mysqli_error());
			}

		return $factnum;
	}
//*******************************************************************************************

//********************************** AJOUTER UNE PRESTATION ******************************
function FactAjouPrest($factnum,$typeprestnum,$prestprixttc,$factqte,$factclienum,$factprestnbheure,$factprestperiode1,$factprestperiode2,$ConnexionBdd,$factprestlibe,$factchevnum,$factavoirprestnum,$factremise,$factremiseind,$factclienum1,$factprestdate,$cliesoldforfsortnum,$calepartnum,$facttypetransfere,$factchevnum1,$factchevnum2,$factchevnum3,$FactDupliquer,$calepartnum1)
	{
		$reqFact = 'SELECT * FROM factures WHERE factnum = "'.$factnum.'"';
		$reqFactResult = $ConnexionBdd ->query($reqFact) or die ('Erreur SQL !'.$reqFact.'<br />'.mysqli_error());
		$reqFactAffich = $reqFactResult->fetch();

		if(!empty($facttypetransfere)) {$facttype = $facttypetransfere;}
		else {$facttype = $reqFactAffich['facttype'];}
		if(empty($factprestdate)) {$factprestdate = $reqFactAffich['factdate'];}
		$factprestdate1 = formatdatemysqlselect($factprestdate);
		if(empty($factclienum)) {$factclienum = $reqFactAffich['clients_clienum'];}

		// SELECTIONNE LES INFOS DE LA PRESTATION
		$req = 'SELECT typeprestnum,typeprestcat,typeprestlibe,typeprestdesc,typeprestnbheurejour,typeprestvalidite,typeprestvaldate1,typeprestvaldate2,typepresthoraire1,typepresthoraire2,typepresthoraire3,typepresthoraire4,typeprestsupp,typeprestnumcompte FROM typeprestation WHERE typeprestnum = "'.$typeprestnum.'"';
		$reqResult = $ConnexionBdd ->query($req) or die ('Erreur SQL !'.$req.'<br />'.mysqli_error());
		$reqAffich = $reqResult->fetch();
		$typeprestcat = $reqAffich[1];
		if(empty($factprestlibe)) {$factprestlibe = $reqAffich['typeprestlibe'];}

		$prestprixttcCalcRem = $prestprixttc;
		$factprestrempourc = $factremise;

		if(!empty($factprestrempourc) AND $factremiseind == "%") {$factprestremmontant1 = $prestprixttcCalcRem * $factprestrempourc / 100;$factprestremmontant = $factprestremmontant1 * $factqte;$factprestremmontant = round($factprestremmontant,"2");$factprestrempourc = $factprestrempourc / 100;}
		else if(!empty($factprestrempourc) AND ($factremiseind =="e" OR $factremiseind =="EUR" OR $factremiseind =="$")) {$factprestremmontant1=$factprestrempourc / $factqte;$factprestremmontant=$factprestrempourc;$factprestrempourc=$factprestrempourc * 100 / $prestprixttcCalcRem;}
		else {$factprestrempourc = 0;$factprestremmontant=0;$factprestremmontant1=0;}

		$prestprixttcCalc = $prestprixttc - $factprestremmontant1;

		$Libe = $factprestlibe;
		$Libe = str_replace('"',"'",$Libe);
		$Libe = str_replace("\n","<br>",$Libe);
		$Libe = str_replace("\r","",$Libe);

		$req1 = 'INSERT INTO factprestation VALUE (NULL,"'.$factnum.'","'.$factprestdate.'","'.$Libe.'","0","'.$facttype.'","0","0","0","'.$factprestremmontant.'","'.$factprestrempourc.'","'.$typeprestnum.'","'.$factqte.'",NULL,"1",NULL,"'.$_SESSION['hebeappnum'].'")';
		$req1Result = $ConnexionBdd ->query($req1) or die ('Erreur SQL !'.$req1.'<br />'.mysqli_error());
		$factprestnum = $ConnexionBdd->lastInsertId();

		// ON RETIRE LES STOCKS DE LA BOUTIQUE
		if($facttype == 6)
			{
				$reqBout1 = 'SELECT typeprestboutnum,typeprestboutrestant FROM typeprestation_boutique WHERE typeprestation_typeprestnum = "'.$typeprestnum.'" AND typeprestboutrestant > "0" ORDER BY typeprestboutdate ASC LIMIT 0,1';
				$reqBout1Result = $ConnexionBdd ->query($reqBout1) or die ('Erreur SQL !'.$reqBout1.'<br />'.mysqli_error());
				$reqBout1Affich = $reqBout1Result->fetch();

				$Restant = $reqBout1Affich[1] - $factqte;

				$reqBout1 = 'UPDATE typeprestation_boutique SET typeprestboutrestant = "'.$Restant.'" WHERE typeprestboutnum = "'.$reqBout1Affich[0].'"';
				$reqBout1Result = $ConnexionBdd ->query($reqBout1) or die ('Erreur SQL !'.$reqBout1.'<br />'.mysqli_error());
			}

		if($_SESSION['infologlang2'] == "ca")
			{
				$req1 = 'SELECT factprestprixnum,factprestprixstatprixttc,factprestprixtva,factprestlibe,typeprestation_prix_typeprestprixnum FROM factprestation_prix,factprestation WHERE factprestation_factprestnum = factprestnum AND factprestation_factprestnum = "'.$factavoirprestnum.'"';
				$req1Result = $ConnexionBdd ->query($req1) or die ('Erreur SQL !'.$req1.'<br />'.mysqli_error());
				$req1Affich = $req1Result->fetch();

				$req2 = 'SELECT typeprestprixtaxe1,typeprestprixtaxe2,typeprestprixnum FROM typeprestation_prix WHERE typeprestprixsupp= "1" AND typeprestation_typeprestnum = "'.$typeprestnum.'"';
				$req2Result = $ConnexionBdd ->query($req2) or die ('Erreur SQL !'.$req2.'<br />'.mysqli_error());
				$req2Affich = $req2Result->fetch();

				$prestprixttcCalc = $prestprixttcCalc * $factqte;

				if($req2Affich['typeprestprixtaxe1'] == 2) {$MontantTPS = $prestprixttcCalc * $_SESSION['confentrtaxe1'];}
				if($req2Affich['typeprestprixtaxe2'] == 2) {$MontantTVQ = $prestprixttcCalc * $_SESSION['confentrtaxe2'];}
				$MontantTTC = $prestprixttcCalc + $MontantTPS + $MontantTVQ;

			 	$MontantTPS = round($MontantTPS,"2");
			 	$MontantTVQ = round($MontantTVQ,"2");
			 	$MontantTTC = round($MontantTTC,"2");

				$req3 = 'INSERT INTO factprestation_prix VALUE (NULL,"'.$prestprixttcCalc.'","'.$_SESSION['confentrtaxe1'].'","'.$factprestnum.'","'.$MontantTPS.'","'.$prestprixttcCalc.'","'.$req2Affich['typeprestprixnum'].'","'.$prestprixttc.'","'.$prestprixttcCalc.'","'.$MontantTPS.'","'.$MontantTTC.'","'.$_SESSION['hebeappnum'].'","'.$_SESSION['confentrtaxe2'].'","'.$MontantTVQ.'")';
				$req3Result = $ConnexionBdd ->query($req3) or die ('Erreur SQL !'.$req3.'<br />'.mysqli_error());
			}
		else
			{
				// ENREGISTREMENT DES PRIX
				if(($facttype == 5 AND !empty($factavoirprestnum)) OR $FactDupliquer == 2)
					{
						$req1 = 'SELECT factprestprixnum,factprestprixstatprixttc,factprestprixtva,factprestlibe,typeprestation_prix_typeprestprixnum FROM factprestation_prix,factprestation WHERE factprestation_factprestnum = factprestnum AND factprestation_factprestnum = "'.$factavoirprestnum.'"';
						$req1Result = $ConnexionBdd ->query($req1) or die ('Erreur SQL !'.$req1.'<br />'.mysqli_error());
						while($req1Affich = $req1Result->fetch())
							{
								$Pourc = CalcPourcPrestFact($req1Affich[0],$ConnexionBdd);

								$PrixTtcCalc = $prestprixttcCalc * $Pourc;
								$IndTva = $req1Affich[2] + 1;
								// Calcul du HT avant remise
								$PrixHt = $PrixTtcCalc / $IndTva;

								// Calcul de la TVA
								$MontantTva = $PrixHt * $req1Affich[2];

								$StatHt = $PrixHt;
								$StatTva = $StatHt * $req1Affich[2];
								$StatTtc = $StatHt + $StatTva;

								$req3 = 'INSERT INTO factprestation_prix VALUE (NULL,"'.$PrixHt.'","'.$req1Affich[2].'","'.$factprestnum.'","'.$MontantTva.'","'.$PrixTtcCalc.'","'.$req1Affich[4].'","'.$prestprixttc.'","'.$StatHt.'","'.$StatTva.'","'.$StatTtc.'","'.$_SESSION['hebeappnum'].'",NULL,NULL)';
								$req3Result = $ConnexionBdd ->query($req3) or die ('Erreur SQL !'.$req3.'<br />'.mysqli_error());
							}
					}
				else
					{
						$req1 = 'SELECT typeprestprixnum,typeprestprixprix,typeprestprixtva,typeprestprixlibe FROM typeprestation_prix WHERE typeprestprixsupp = "1" AND typeprestation_typeprestnum = "'.$typeprestnum.'"';
						$req1Result = $ConnexionBdd ->query($req1) or die ('Erreur SQL !'.$req1.'<br />'.mysqli_error());
						while($req1Affich = $req1Result->fetch())
							{
								$Pourc = CalcPourcPrest($req1Affich[0],$ConnexionBdd);
								$PrixTtcCalc1 = $prestprixttcCalc * $Pourc;

								$PrixTtcCalc = $PrixTtcCalc1 * $factqte;

								$IndTva = $req1Affich[2] + 1;
								// Calcul du HT avant remise
								$PrixHt = $PrixTtcCalc / $IndTva;

								// Calcul de la TVA
								$MontantTva = $PrixHt * $req1Affich[2];

								$StatHt = $PrixHt;
								$StatTva = $StatHt * $req1Affich[2];
								$StatTtc = $StatHt + $StatTva;

								$req3 = 'INSERT INTO factprestation_prix VALUE (NULL,"'.$PrixHt.'","'.$req1Affich[2].'","'.$factprestnum.'","'.$MontantTva.'","'.$PrixTtcCalc.'","'.$req1Affich[0].'","'.$PrixTtcCalc1.'","'.$StatHt.'","'.$StatTva.'","'.$StatTtc.'","'.$_SESSION['hebeappnum'].'",NULL,NULL)';
								$req3Result = $ConnexionBdd ->query($req3) or die ('Erreur SQL !'.$req3.'<br />'.mysqli_error());
							}
					}
			}
		$TotalTTCPrest = CalcPrest($factprestnum,$ConnexionBdd);
		$MontantTotalSoldeAEncaisser = $TotalTTCPrest[1];

		// VERIF S'IL Y A DES ENCAISSEMENTS QUI NE SONT PAS FINIS DE SOLDER DANS CETTE FACTURE
		$req = 'SELECT factprestnum FROM factprestation WHERE factures_factnum = "'.$factnum.'"';
		$reqResult = $ConnexionBdd ->query($req) or die ('Erreur SQL !'.$req.'<br />'.mysqli_error());
		while($reqAffich = $reqResult->fetch())
			{
				$reqPrest.=' OR factprestation_factprestnum = '.$reqAffich[0];
			}

		$reqPrest=substr($reqPrest, 4, 20125698755455566566556);

		if(!empty($reqPrest))
			{
				$req = 'SELECT factencnum,factencmontantverser FROM factencaisser,factures_factencaisser WHERE factencaisser_factencnum = factencnum AND ('.$reqPrest.') GROUP BY factencnum';
				$reqResult = $ConnexionBdd ->query($req) or die ('Erreur SQL !'.$req.'<br />'.mysqli_error());
				while($reqAffich = $reqResult->fetch())
					{
						$RestantDuEnc = EncaissementSolder($reqAffich[0],$ConnexionBdd);

						if($RestantDuEnc[0] > 0 AND $MontantTotalSoldeAEncaisser > 0)
							{
								if($MontantTotalSoldeAEncaisser >= $RestantDuEnc[0]) {$MontantSoldeAEncaisser = $RestantDuEnc[0];}
								else {$MontantSoldeAEncaisser = $MontantTotalSoldeAEncaisser;}

								$req1 = 'INSERT INTO factures_factencaisser VALUE (NULL,"'.$factprestnum.'","'.$reqAffich[0].'")';
								$req1Result = $ConnexionBdd ->query($req1) or die ('Erreur SQL !'.$req1.'<br />'.mysqli_error());
								$encnum = $ConnexionBdd->lastInsertId();

								// CALCUL DE LA PROPORTION DE LA PRESTATION
								$req2 = 'SELECT factprestprixnum,factprestprixtva FROM factprestation_prix WHERE factprestation_factprestnum = "'.$factprestnum.'"';
								$req2Result = $ConnexionBdd ->query($req2) or die ('Erreur SQL !'.$req2.'<br />'.mysqli_error());
								while($req2Affich = $req2Result->fetch())
									{
										$MontantPourc = CalcPourcPrix($req2Affich[0],$ConnexionBdd);
										$Montant = $MontantSoldeAEncaisser * $MontantPourc;
										$req3 = 'INSERT INTO factures_factencaisser_stat VALUE (NULL,"'.$Montant.'","'.$req2Affich[1].'","'.$encnum.'")';
										$req3Result = $ConnexionBdd ->query($req3) or die ('Erreur SQL !'.$req3.'<br />'.mysqli_error());
									}

								$MontantTotalSoldeAEncaisser = $MontantTotalSoldeAEncaisser - $MontantSoldeAEncaisser;
							}
					}
			}

		// ------------------------------------------------------------------------------------------------------------
		if($factprestnbheure == "NULL") {$factprestnbheure = "";}
		// AJOU S'IL Y A DES HEURES
		if($factprestnbheure > 0)
			{
				$Periode1=$factprestperiode1;
				$Periode2=$factprestperiode2;

				$factprestnbheure = $factprestnbheure * $factqte;
			}

		if($factprestnbheure > 0 AND $facttype == 4)
			{
				$NbHeureTotalACrediter = $factprestnbheure * 60;
				$MontantNbHeure = $TotalTTCPrest[3] / $NbHeureTotalACrediter;
				// AJOUTE L'ENTRÉE
				$reqSold1 = 'INSERT INTO clientssoldeforfentree VALUE (NULL,"'.$Periode1.'","'.$Periode2.'","'.$NbHeureTotalACrediter.'","'.$Libe.'","'.$factprestnum.'","'.$_SESSION['hebeappnum'].'","'.$MontantNbHeure.'")';
				$reqSold1Result = $ConnexionBdd ->query($reqSold1) or die ('Erreur SQL !'.$reqSold1.'<br />'.mysqli_error());
				$soldforfnum = $ConnexionBdd->lastInsertId();

				//DATE D EXCLUSION
				$reqDate1 = 'SELECT typeprestdatenum,typeprestdatedate1,typeprestdatedate2 FROM typeprestation_dateexclu WHERE typeprestation_typeprestnum = "'.$typeprestnum.'"';
				$reqDate1Result = $ConnexionBdd ->query($reqDate1) or die ('Erreur SQL !'.$reqDate1.'<br />'.mysqli_error());
				while($reqDate1Affich = $reqDate1Result->fetch())
					{
						$reqDate2 = 'INSERT INTO clientssoldeforfentree_date VALUE (NULL,"'.$reqDate1Affich[1].'","'.$reqDate1Affich[2].'","'.$soldforfnum.'")';
						$reqDate2Result = $ConnexionBdd ->query($reqDate2) or die ('Erreur SQL !'.$reqDate2.'<br />'.mysqli_error());
					}

				$req2 = 'INSERT INTO clientssoldeforfentree_clients VALUE (NULL,"'.$soldforfnum.'","'.$factclienum.'")';
				$req2Result = $ConnexionBdd ->query($req2) or die ('Erreur SQL !'.$req2.'<br />'.mysqli_error());

				if(!empty($factclienum1))
					{
						$req2 = 'INSERT INTO clientssoldeforfentree_clients VALUE (NULL,"'.$soldforfnum.'","'.$factclienum1.'")';
						$req2Result = $ConnexionBdd ->query($req2) or die ('Erreur SQL !'.$req2.'<br />'.mysqli_error());
					}

				// ASSOCIE LES HEURES SORTIES � L ENTRE
				if ($cliesoldforfsortnum == TRUE)
					{
						for ($i=0,$n=count($cliesoldforfsortnum);$i<$n;$i++)
							{
								if(!empty($cliesoldforfsortnum[$i]))
									{
										$reqSold2 = 'UPDATE clientssoldeforfsortie SET clientssoldeforfentree_cliesoldforfentrnum = "'.$soldforfnum.'" WHERE cliesoldforfsortnum = "'.$cliesoldforfsortnum[$i].'"';
										$reqSold2Result = $ConnexionBdd ->query($reqSold2) or die ('Erreur SQL !'.$reqSold2.'<br />'.mysqli_error());
									}
							}
					}
				else
					{
						$NbHeureForfait = $NbHeureTotalACrediter;
						$reqSort = 'SELECT * FROM clientssoldeforfsortie WHERE clients_clienum = "'.$factclienum.'" AND clientssoldeforfentree_cliesoldforfentrnum IS NULL ORDER BY cliesoldforfsortdate ASC';
						$reqSortResult = $ConnexionBdd ->query($reqSort) or die ('Erreur SQL !'.$reqSort.'<br />'.mysqli_error());
						while($reqSortAffich = $reqSortResult->fetch())
							{
								if($NbHeureForfait >= $reqSortAffich['cliesoldforfsortnbheure']) {$PeriodeOK = 2;}
								else {break;}

								$CalcSort = formatheure1($reqSortAffich['cliesoldforfsortdate']);
								$TestDateSort = $CalcSort[3].$CalcSort[4].$CalcSort[5];
								if($TestDateSort >= $TestPeriode1 AND $TestDateSort <= $TestPeriode2) {$PeriodeOK = 2;} else {$PeriodeOK = 1;}

								if($PeriodeOK == 2)
									{
										$reqSold2 = 'UPDATE clientssoldeforfsortie SET clientssoldeforfentree_cliesoldforfentrnum = "'.$soldforfnum.'" WHERE cliesoldforfsortnum = "'.$reqSortAffich['cliesoldforfsortnum'].'"';
										$reqSold2Result = $ConnexionBdd ->query($reqSold2) or die ('Erreur SQL !'.$reqSold2.'<br />'.mysqli_error());
									}
								$NbHeureForfait = $NbHeureForfait - $reqSortAffich['cliesoldforfsortnbheure'];
							}
					}

				if(!empty($calepartnum))
					{
						if(empty($factclienum)) {$factclienum = "NULL";}
						$req1 = 'INSERT INTO factprestation_association VALUE(NULL,'.$factclienum.',NULL,"'.$factprestnum.'","'.$calepartnum.'",NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL)';
						$req1Result = $ConnexionBdd ->query($req1) or die ('Erreur SQL !'.$req1.'<br />'.mysqli_error());
					}
				if(!empty($calepartnum1))
					{
						if(empty($factclienum1)) {$factclienum1 = "NULL";}
						$req1 = 'INSERT INTO factprestation_association VALUE(NULL,'.$factclienum1.',NULL,"'.$factprestnum.'","'.$calepartnum1.'",NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL)';
						$req1Result = $ConnexionBdd ->query($req1) or die ('Erreur SQL !'.$req1.'<br />'.mysqli_error());
					}
			}
		else
			{
				// ASSOCIE CLIENT A LA PRESTATION
				if(!empty($factclienum) OR !empty($factchevnum) OR !empty($calepartnum))
					{
						if(empty($factchevnum)) {$factchevnum="NULL";}
						if(empty($factchevnum1)) {$factchevnum1="NULL";}
						if(empty($factchevnum2)) {$factchevnum2="NULL";}
						if(empty($factchevnum3)) {$factchevnum3="NULL";}
						if(empty($factclienum)) {$factclienum="NULL";}
						if(empty($factclienum1)) {$factclienum1="NULL";}
						if(empty($calepartnum)) {$calepartnum="NULL";}

						$req1 = 'INSERT INTO factprestation_association VALUE(NULL,'.$factclienum.','.$factchevnum.',"'.$factprestnum.'",'.$calepartnum.',NULL,NULL,'.$factclienum1.',"'.$factprestnbheure.'"';
						if(!empty($Periode1)) {$req1.= ',"'.$Periode1.'"';}
						else {$req1.= ',NULL';}
						if(!empty($Periode2)) {$req1.= ',"'.$Periode2.'"';}
						else {$req1.= ',NULL';}
						$req1.=','.$factchevnum1.','.$factchevnum2.','.$factchevnum3;
						$req1.= ')';
						$req1Result = $ConnexionBdd ->query($req1) or die ('Erreur SQL !'.$req1.'<br />'.mysqli_error());

						if($typeprestcat == 7 AND $facttype == 4)
							{
								$req1='SELECT conflogcliecotisation FROM conflogiciel WHERE AA_equimondo_hebeappnum = "'.$_SESSION['hebeappnum'].'"';
								$req1Result = $ConnexionBdd ->query($req1) or die ('Erreur SQL !'.$req1.'<br />'.mysqli_error());
								$req1Affich = $req1Result->fetch();
								if($req1Affich[0] == 1)
									{
										$datefin = date("Y")."-12-31";
									}
								else
									{
										$datefin = date("Y-m-d",mktime(0, 0, 0, $factprestdate1[1], $factprestdate1[0], $factprestdate1[2] + 1));
									}
								$req1 = 'UPDATE clients SET cliedatecotisation = "'.$datefin.'" WHERE clienum = "'.$factclienum.'"';
								$req1Result = $ConnexionBdd ->query($req1) or die ('Erreur SQL !'.$req1.'<br />'.mysqli_error());
							}
						if($typeprestcat == 8 AND $facttype == 4)
							{
								if($factprestdate1[1] >= 9 AND $factprestdate1[1] <= 12) {$anne = $factprestdate1[2] + 1;} else {$anne = $factprestdate1[2];}
								$req1 = 'UPDATE clients SET cliedatevallic = "'.$anne.date('-12-31').'" WHERE clienum = "'.$factclienum.'"';
								$req1Result = $ConnexionBdd ->query($req1) or die ('Erreur SQL !'.$req1.'<br />'.mysqli_error());
							}
					}
			}

		return $factprestnum;
	}
//*******************************************************************************************

//******************************* MODE DE PAIEMENT ************************
function ModePaieSelect($num,$ConnexionBdd,$AfficheNull,$factnum,$clienum)
	{
		$Lecture = "<option value='";if($AfficheNull == 2) {$Lecture.="NULL";} $Lecture.="'>-- ".$_SESSION['STrad93']." --</option>";
		$req2 = 'SELECT modepaienum,modepaielibe FROM mode_paie WHERE modepaiesupp = "1" AND AA_equimondo_hebeappnum = "'.$_SESSION['hebeappnum'].'" ORDER BY modepaielibe ASC';
		$req2Result = $ConnexionBdd ->query($req2) or die ('Erreur SQL !'.$req2.'<br />'.mysqli_error());
		while($req2Affich = $req2Result->fetch())
			{
				$Lecture.='<option value="'.$req2Affich[0];if(!empty($factnum)) {$Lecture.="|".$factnum;} if(!empty($clienum)) {$Lecture.="|clie".$clienum;} $Lecture.='"';if($num == $req2Affich[0]) {$Lecture.=' selected';} $Lecture.='>'.$req2Affich[1].'</option>';
			}

		return $Lecture;
	}
//****************************************************************************

//******************************* AJOU PRESTATIONS CAISSE ************************
function CaissePrestationsAjou($Dossier,$ConnexionBdd,$typeprestnum,$indice,$prix,$clienum1,$clienum2,$paninum)
	{
		if($_SESSION['connind'] == "util") {$connauthnum = $_SESSION['connauthnum'];}
		if($_SESSION['connind'] == "clie") {$connauthnum = "NULL";}

		$reqVerif1 = 'SELECT count(caissyst1num),caissyst1num FROM caissesysteme1 WHERE utilisateurs_utilnum = "'.$_SESSION['connauthnum'].'"';
		if(!empty($indice)) {$reqVerif1.=' AND caissyst1indice = "'.$indice.'"';}
		$reqVerif1Result = $ConnexionBdd ->query($reqVerif1) or die ('Erreur SQL !'.$reqVerif1.'<br />'.mysqli_error());
		$reqVerif1Affich = $reqVerif1Result->fetch();
		if($reqVerif1Affich[0] == 0)
			{
				$req2 = 'INSERT INTO caissesysteme1 VALUE (NULL,"'.date('Y-m-d').'",'.$connauthnum.',"'.$clienum1.'","'.$_SESSION['hebeappnum'].'",NULL,"'.$indice.'")';
				$req2Result = $ConnexionBdd ->query($req2) or die ('Erreur SQL !'.$req2.'<br />'.mysqli_error());
				$caissyst1num = $ConnexionBdd->lastInsertId();
			}
		else {$caissyst1num = $reqVerif1Affich[1];}

		// SI C'EST UN PANIER ON L'ASSOCIE
		if(!empty($paninum))
			{
				$req2 = 'INSERT INTO panier_association VALUE (NULL,"'.$paninum.'","'.$caissyst1num.'")';
				$req2Result = $ConnexionBdd ->query($req2) or die ('Erreur SQL !'.$req2.'<br />'.mysqli_error());
			}

		if(!empty($prix))
			{
				$req1 = 'SELECT sum(typeprestprixprix),typeprestlibe,typeprestcat FROM typeprestation_prix,typeprestation WHERE typeprestation_typeprestnum = typeprestnum AND typeprestation_typeprestnum = "'.$typeprestnum.'" AND typeprestprixsupp = "1"';
				$req1Result = $ConnexionBdd ->query($req1) or die ('Erreur SQL !'.$req1.'<br />'.mysqli_error());
				$req1Affich = $req1Result->fetch();
				$Libe = $req1Affich['typeprestlibe'];
			}
		else if(empty($prix))
			{
				$req1 = 'SELECT sum(typeprestprixprix),typeprestlibe,typeprestcat FROM typeprestation_prix,typeprestation WHERE typeprestation_typeprestnum = typeprestnum AND typeprestation_typeprestnum = "'.$typeprestnum.'" AND typeprestprixsupp = "1"';
				$req1Result = $ConnexionBdd ->query($req1) or die ('Erreur SQL !'.$req1.'<br />'.mysqli_error());
				$req1Affich = $req1Result->fetch();
				$prix = $req1Affich[0];
				$Libe = $req1Affich['typeprestlibe'];
			}

		$req2 = 'INSERT INTO caissesysteme2 VALUE (NULL,"'.$caissyst1num.'","'.$typeprestnum.'","'.$prix.'","'.$clienum1.'","'.$clienum2.'","'.$Libe.'","'.date('Y-m-d H:i:s').'")';
		$req2Result = $ConnexionBdd ->query($req2) or die ('Erreur SQL !'.$req2.'<br />'.mysqli_error());

		return $Lecture;
	}
//****************************************************************************

//********************* CREATION D'UN PANIER ***************************************
function CreationPanier($Dossier,$ConnexionBdd)
	{
		$req1 = 'INSERT INTO panier VALUE (NULL,"'.$_SESSION['hebeappnum'].'")';
		$req1Result = $ConnexionBdd ->query($req1) or die ('Erreur SQL !'.$req1.'<br />'.mysqli_error());
		$paninum = $ConnexionBdd->lastInsertId();

		return $paninum;
	}
//****************************************************************************

//******************************* SUPP PRESTATIONS CAISSE ************************
function CaissePrestationsSupp($Dossier,$ConnexionBdd,$caissyst2num)
	{
		$req1 = 'DELETE FROM caissesysteme2 WHERE caissyst2num = "'.$caissyst2num.'"';
		$req1Result = $ConnexionBdd ->query($req1) or die ('Erreur SQL !'.$req1.'<br />'.mysqli_error());

		return $Lecture;
	}
//****************************************************************************

//******************************* AFFICHER UN UTILISATEUR *************************
function UtilLect($num,$ConnexionBdd)
	{
		$req = 'SELECT * FROM utilisateurs WHERE utilnum="'.$num.'"';
		$reqResult = $ConnexionBdd ->query($req) or die ('Erreur SQL !'.$req.'<br />'.mysqli_error());
		$reqAffich = $reqResult->fetch();

		$Lecture.=$reqAffich['utilnom']." ".$reqAffich['utilprenom'];

		return $Lecture;
	}
//*****************************************************************************

//*************************** AFFICHER CATEGORIE DEPENSE ********************
function DepensesCatLect($num,$ConnexionBdd)
	{
		$req = 'SELECT depecatnum,depecatlibe FROM depenses_categorie WHERE depecatnum = "'.$num.'"';
		$reqResult = $ConnexionBdd ->query($req) or die ('Erreur SQL !'.$req.'<br />'.mysqli_error());
		$reqAffich = $reqResult->fetch();
		$Lecture.=$reqAffich[1];

		return $Lecture;
	}
//************************************************************************

//*********************** AJOUTER UN MODELE ************************
function ModeleRepriseAjou($Dossier,$ConnexionBdd,$planlecomodlibe,$planlecomodjour,$planlecomodheure,$planlecomodduree,$planlecomoddesc,$planlecomodniveau1,$planlecomodniveau2,$planlecomodcategorie,$utilnum,$planlecomodnbmaxpers,$planlecomodinstal,$planlecomodrepliquer,$planlecomoddureeabebiter,$planlecomodhorsperiode,$calecatenum,$calediscconflibe)
	{
		$planlecomodlibe = SecureInput($planlecomodlibe);
		$planlecomodcategorie = SecureInput($planlecomodcategorie);
		$planlecomodinstal = SecureInput($planlecomodinstal);
		$calediscconflibe = SecureInput($calediscconflibe);

		if ($_POST['calediscconflibe'] == TRUE)
			{
				for ($i=0,$n=count($_POST['calediscconflibe']);$i<$n;$i++)
					{
		        if(!empty($_POST['calediscconflibe'][$i]))
		          {
		            $calediscconfnum = DisciplineRequete($Dossier,$ConnexionBdd,$_POST['calediscconflibe'][$i],"ajou");
								$planlecomodcategorie = $_POST['calediscconflibe'][$i];
		          }
					}
			}

		if(!empty($planlecomodcategorie))
			{
				$reqDisc = 'SELECT * FROM calendrier_discipline_configuration WHERE calediscconfnum = "'.$planlecomodcategorie.'"';
				$reqDiscResult = $ConnexionBdd ->query($reqDisc) or die ('Erreur SQL !'.$reqDisc.'<br />'.mysqli_error());
				$reqDiscAffich = $reqDiscResult->fetch();
				$planlecomodcategorie = $reqDiscAffich['calediscconflibe'];
			}

		$req1 = 'INSERT INTO planning_lecon_modele VALUE (NULL,"'.$planlecomodlibe.'","'.$planlecomodjour.'","'.$planlecomodheure.'","'.$planlecomodduree.'","'.$planlecomoddesc.'","'.$planlecomodniveau1.'","'.$planlecomodniveau2.'","'.$planlecomodcategorie.'","'.$utilnum.'","'.$planlecomodnbmaxpers.'","'.$planlecomodinstal.'","'.$_SESSION['hebeappnum'].'","'.$planlecomodrepliquer.'","'.$planlecomoddureeabebiter.'","'.$planlecomodhorsperiode.'","'.$calecatenum.'","1")';
		$req1Result = $ConnexionBdd ->query($req1) or die ('Erreur SQL !'.$req1.'<br />'.mysqli_error());
		$planlecomodnum = $ConnexionBdd->lastInsertId();

		return $planlecomodnum;
	}
//*****************************************************

//********************* ENREGISTRER UN ENCAISSEMENT ****************
function FactEncAjou($factencmontantverser,$factencdate,$modepaienum,$factencreference,$factenccommentaire,$factencnombanque,$factencnomemetteur,$factencindice,$factencexport,$ConnexionBdd,$factprestnum,$factnum,$factencnum,$factenctype)
	{
		if(!empty($factnum))
			{
				$reqInfo = 'SELECT * FROM factures WHERE factnum = "'.$factnum.'"';
				$reqInfoResult = $ConnexionBdd ->query($reqInfo) or die ('Erreur SQL !'.$reqInfo.'<br />'.mysqli_error());
				$reqInfoAffich = $reqInfoResult->fetch();
			}

		if($reqInfoAffich['facttype'] != 5 AND $factenctype == 1 AND empty($factencnum))
			{
				$CalcNumEnc = CalcDernNumFact(6,$ConnexionBdd);
				$factencclecrypt = $CalcNumEnc."-".date('Y-m-d H:i:s');
				$factencclecrypt = hash('sha256',$factencclecrypt);
			}
		if($reqInfoAffich['facttype'] == 5) {$factencmontantverser = $factencmontantverser * -1;}

		// ENCAISSEMENT
		if(empty($factencnum))
			{
				// ,"'.$_SESSION['connauthnum'].'","'.$_SERVER['REMOTE_ADDR'].'"
				$req = 'INSERT INTO factencaisser VALUE (NULL,"'.$factencmontantverser.'","'.$factencdate.'",NULL,"'.$modepaienum.'","'.$factencreference.'","'.$factenccommentaire.'",NULL,"'.$factencnombanque.'","'.$factencnomemetteur.'","'.$factencindice.'","'.$factencexport.'","'.$_SESSION['hebeappnum'].'","'.date('Y-m-d H:i:s').'","'.$CalcNumEnc.'","'.$factencclecrypt.'","'.$_SESSION['connauthnum'].'","'.$_SERVER['REMOTE_ADDR'].'","'.$factenctype.'")';
				$reqResult = $ConnexionBdd ->query($req) or die ('Erreur SQL !'.$req.'<br />'.mysqli_error());
				$factencnum1 = $ConnexionBdd->lastInsertId();
			}
		if($reqInfoAffich['facttype'] != 5 AND $factenctype == 1 AND empty($factencnum))
			{
				if($factencmontantverser < 0) {$logaction="Annulation_encaissement";}
				else {$logaction="Enregistrement_encaissement";}

				$req = 'INSERT INTO log VALUE (NULL,"'.$_SESSION['connauthnum'].'","'.date('Y-m-d H:i:s').'","'.$_SERVER['REMOTE_ADDR'].'","'.$logaction.'",NULL,NULL,"'.$_SESSION['hebeappnum'].'","'.$factencnum1.'",NULL)';
				$reqResult = $ConnexionBdd ->query($req) or die ('Erreur SQL !'.$req.'<br />'.mysqli_error());
			}
		if($factencmontantverser < 0 OR ($reqInfoAffich['facttype'] == 5 AND $factencmontantverser > 0)) {$caisentrsort = 2;}
		else {$caisentrsort = 1;}

		if($reqInfoAffich['facttype'] == 5) {$factencmontantverser = $factencmontantverser * -1;}

		// CAISSE
		if(empty($factencnum) AND $factenctype == 1)
			{
				$req = 'INSERT INTO caisse VALUE (NULL,"'.$factencdate.'",NULL,"'.$caisentrsort.'","'.$factencmontantverser.'",NULL,"'.$modepaienum.'",NULL,NULL,"'.$factencnum1.'",NULL,NULL,"'.$_SESSION['hebeappnum'].'",NULL)';
				$reqResult = $ConnexionBdd ->query($req) or die ('Erreur SQL !'.$req.'<br />'.mysqli_error());
			}

		// MONTANT RESTANT A SOLDER
		$MontantRestantASolder = $factencmontantverser;
		// AJOUT DES MONTANTS D ENCAISSEMENT
		if ($factprestnum == TRUE)
			{
				for ($i=0,$n=count($factprestnum);$i<$n;$i++)
					{
						if(!empty($factprestnum[$i]))
							{
								// S'IL N'Y A PLUS DE MONTANT A SOLDER
								if($MontantRestantASolder > 0)
									{
										$InfoFactPrest = CalcPrest($factprestnum[$i],$ConnexionBdd);

										if($MontantRestantASolder >= $InfoFactPrest[2]) {$MontantASolder = $InfoFactPrest[2];}
										else {$MontantASolder = $MontantRestantASolder;}

										if(!empty($factencnum)) {$factencnum1 = $factencnum;}
										$FactEncMontant = FactEncAJouMontant ($factencnum1,$factprestnum[$i],$ConnexionBdd,$MontantASolder);

										// CALCUL DU MONTANT RESTANT � SOLDER
										$MontantRestantASolder = $MontantRestantASolder - $MontantASolder;
									}
							}
					}
			}
		else if(!empty($factnum))
			{
				// AJOUT DES MONTANTS D ENCAISSEMENT
				$req1 = 'SELECT factprestnum FROM factprestation WHERE factures_factnum = "'.$factnum.'"';
				$req1Result = $ConnexionBdd ->query($req1) or die ('Erreur SQL !'.$req1.'<br />'.mysqli_error());
				while($req1Affich = $req1Result->fetch())
					{
						// S'IL N'Y A PLUS DE MONTANT A SOLDER
						if($MontantRestantASolder > 0)
							{
								$InfoFactPrest = CalcPrest($req1Affich[0],$ConnexionBdd);

								if($MontantRestantASolder >= $InfoFactPrest[2]) {$MontantASolder = $InfoFactPrest[2];}
								else {$MontantASolder = $MontantRestantASolder;}

								$FactEncMontant = FactEncAJouMontant ($factencnum1,$req1Affich[0],$ConnexionBdd,$MontantASolder);
								// CALCUL DU MONTANT RESTANT A SOLDER
								$MontantRestantASolder = $MontantRestantASolder - $MontantASolder;
							}
					}
			}

		if(!empty($factencnum1) AND $logaction != "Annulation_encaissement" AND $factenctype == 1)
			{
				$req1 = 'SELECT factures.clients_clienum FROM factures_factencaisser,factprestation,factures WHERE factures_factnum = factnum AND factprestation_factprestnum = factprestnum AND factencaisser_factencnum = "'.$factencnum1.'"';
				$req1Result = $ConnexionBdd ->query($req1) or die ('Erreur SQL !'.$req1.'<br />'.mysqli_error());
				$req1Affich = $req1Result->fetch();
				if(!empty($req1Affich[0])) {$clienum = $req1Affich[0];}
				else {$clienum = $reqInfoAffich['factures.clients_clienum'];}

				$req2 = 'INSERT INTO livredecompte VALUE (NULL,"'.$factencdate.'",NULL,"'.$factencnum1.'",'.$_SESSION['hebeappnum'].','.$clienum.')';
				$req2Result = $ConnexionBdd ->query($req2) or die ('Erreur SQL !'.$req2.'<br />'.mysqli_error());
			}

		return $factencnum1;
	}
function FactEncAJouMontant ($factencnum,$factprestnum,$ConnexionBdd,$MontantASolder,$encnum)
	{
		$reqInfo = 'SELECT facttype FROM factures,factprestation WHERE factures_factnum = factnum AND factprestnum = "'.$factprestnum.'"';
		$reqInfoResult = $ConnexionBdd ->query($reqInfo) or die ('Erreur SQL !'.$reqInfo.'<br />'.mysqli_error());
		$reqInfoAffich = $reqInfoResult->fetch();

		$reqEnc = 'SELECT * FROM factencaisser WHERE factencnum = "'.$factencnum.'"';
		$reqEncResult = $ConnexionBdd ->query($reqEnc) or die ('Erreur SQL !'.$reqEnc.'<br />'.mysqli_error());
		$reqEncAffich = $reqEncResult->fetch();

		if(empty($encnum))
			{
				$req = 'INSERT INTO factures_factencaisser VALUE (NULL,"'.$factprestnum.'","'.$factencnum.'")';
				$reqResult = $ConnexionBdd ->query($req) or die ('Erreur SQL !'.$req.'<br />'.mysqli_error());
				$encnum = $ConnexionBdd->lastInsertId();
			}

		if($reqEncAffich['factenctype'] == 1)
			{
				// CALCUL DE LA PROPORTION DE LA PRESTATION
				$req = 'SELECT factprestprixnum,factprestprixtva,factprestprixtva1,factprestprixstatprixtva1,factprestprixtvamontant FROM factprestation_prix WHERE factprestation_factprestnum = "'.$factprestnum.'"';
				$reqResult = $ConnexionBdd ->query($req) or die ('Erreur SQL !'.$req.'<br />'.mysqli_error());
				while($reqAffich = $reqResult->fetch())
					{
						if($_SESSION['infologlang2'] == "ca")
							{
								$Montant = $MontantASolder / 2;

								$req2 = 'INSERT INTO factures_factencaisser_stat VALUE (NULL,"'.$Montant.'","'.$reqAffich['factprestprixtva'].'","'.$encnum.'")';
								$req2Result = $ConnexionBdd ->query($req2) or die ('Erreur SQL !'.$req2.'<br />'.mysqli_error());

								$req2 = 'INSERT INTO factures_factencaisser_stat VALUE (NULL,"'.$Montant.'","'.$reqAffich['factprestprixtva1'].'","'.$encnum.'")';
								$req2Result = $ConnexionBdd ->query($req2) or die ('Erreur SQL !'.$req2.'<br />'.mysqli_error());
							}
						else
							{
								$MontantPourc = CalcPourcPrix($reqAffich[0],$ConnexionBdd);
								$Montant = $MontantASolder * $MontantPourc;
								if($reqInfoAffich['facttype'] == 5) {$Montant = $Montant * -1;}
								$req2 = 'INSERT INTO factures_factencaisser_stat VALUE (NULL,"'.$Montant.'","'.$reqAffich[1].'","'.$encnum.'")';
								$req2Result = $ConnexionBdd ->query($req2) or die ('Erreur SQL !'.$req2.'<br />'.mysqli_error());
							}
					}
			}
	}
//**********************************************************************

//***************** PASSAGE ENCAISSEMENT NORMAL A EN ATTENTE ****************************
function FactEncPassage($Dossier,$ConnexionBdd,$factencnum)
	{
		$reqEnc = 'SELECT * FROM factencaisser WHERE factencnum = "'.$factencnum.'"';
		$reqEncResult = $ConnexionBdd ->query($reqEnc) or die ('Erreur SQL !'.$reqEnc.'<br />'.mysqli_error());
		$reqEncAffich = $reqEncResult->fetch();
		if($reqEncAffich['factenctype'] == 2)
			{
				$MontantRestantASolder = $reqEncAffich['factencmontantverser'];
				$factencdateenr = date('Y-m-d H:i:s');

				$CalcNumEnc = CalcDernNumFact(6,$ConnexionBdd);
				$factencclecrypt = $CalcNumEnc."-".date('Y-m-d H:i:s');
				$factencclecrypt = hash('sha256',$factencclecrypt);

				$req1 = 'UPDATE factencaisser SET factencdateenr = "'.$factencdateenr.'",factencnumchainage = "'.$CalcNumEnc.'",factencclecrypt="'.$factencclecrypt.'",utilisateurs_utilnum="'.$_SESSION['connauthnum'].'",factencip="'.$_SERVER['REMOTE_ADDR'].'",factenctype="1" WHERE factencnum = "'.$factencnum.'"';
				$req1Result = $ConnexionBdd ->query($req1) or die ('Erreur SQL !'.$req1.'<br />'.mysqli_error());

				$logaction="Enregistrement_encaissement";

				$req = 'INSERT INTO log VALUE (NULL,"'.$_SESSION['connauthnum'].'","'.factencdateenr.'","'.$_SERVER['REMOTE_ADDR'].'","'.$logaction.'",NULL,NULL,"'.$_SESSION['hebeappnum'].'","'.$factencnum.'",NULL)';
				$reqResult = $ConnexionBdd ->query($req) or die ('Erreur SQL !'.$req.'<br />'.mysqli_error());

				$req = 'INSERT INTO caisse VALUE (NULL,"'.$reqEncAffich['factencdate'].'",NULL,"1","'.$reqEncAffich['factencmontantverser'].'",NULL,"'.$reqEncAffich['mode_paie_modepaienum'].'",NULL,NULL,"'.$factencnum.'",NULL,NULL,"'.$_SESSION['hebeappnum'].'",NULL)';
				$reqResult = $ConnexionBdd ->query($req) or die ('Erreur SQL !'.$req.'<br />'.mysqli_error());

				$req1 = 'SELECT factprestation_factprestnum FROM factures_factencaisser WHERE factencaisser_factencnum = "'.$factencnum.'"';
				$req1Result = $ConnexionBdd ->query($req1) or die ('Erreur SQL !'.$req1.'<br />'.mysqli_error());
				while($req1Affich = $req1Result->fetch())
					{
						// S'IL N'Y A PLUS DE MONTANT A SOLDER
						if($MontantRestantASolder > 0)
							{
								$InfoFactPrest = CalcPrest($req1Affich[0],$ConnexionBdd);

								if($MontantRestantASolder >= $InfoFactPrest[2]) {$MontantASolder = $InfoFactPrest[2];}
								else {$MontantASolder = $MontantRestantASolder;}

								$FactEncMontant = FactEncAJouMontant ($factencnum,$req1Affich[0],$ConnexionBdd,$MontantASolder,$req1Affich['factencassonum']);
								// CALCUL DU MONTANT RESTANT A SOLDER
								$MontantRestantASolder = $MontantRestantASolder - $MontantASolder;
							}
					}
			}
		return $factencnum;
	}
//**********************************************************************

//******************************* TYPE PRESTATION *************************
function TypePrestSelect($num,$cat,$ConnexionBdd,$factclienum,$AfficheNull,$AfficheAjouNbHeure)
	{
		$Lecture.= "<option value='";if($AfficheNull == 2) {$Lecture.="NULL";} $Lecture.="'>- ".$_SESSION['STrad303']." -</option>";
		if($AfficheAjouNbHeure == 2)
			{
				$Lecture.="<option value='ajou'>- ".$_SESSION['STrad751']." -</option>";
			}
		$req2 = 'SELECT typeprestnum,typeprestlibe';
		$req2.=' FROM typeprestation';
		$req2.= ' WHERE typeprestsupp = "1" AND AA_equimondo_hebeappnum = "'.$_SESSION['hebeappnum'].'"';
		if(!empty($cat)) {$req2.=' AND typeprestcat = "'.$cat.'"';}
		$req2.=' ORDER BY typeprestlibe ASC';
		$req2Result = $ConnexionBdd ->query($req2) or die ('Erreur SQL !'.$req2.'<br />'.mysqli_error());
		while($req2Affich = $req2Result->fetch())
			{
				$reqPrestPrix = 'SELECT sum(typeprestprixprix) FROM typeprestation_prix WHERE typeprestation_typeprestnum = "'.$req2Affich[0].'" AND typeprestprixsupp = "1"';
				$reqPrestPrixResult = $ConnexionBdd ->query($reqPrestPrix) or die ('Erreur SQL !'.$reqPrestPrix.'<br />'.mysqli_error());
				$reqPrestPrixAffich = $reqPrestPrixResult->fetch();
				$Lecture.="<option value='".$req2Affich[0];if(!empty($factclienum)) {$Lecture.="|".$factclienum;} $Lecture.="'";if($num == $req2Affich[0]) {$Lecture.=" selected";} $Lecture.=">".$req2Affich[1]." (".$reqPrestPrixAffich[0]." ".$_SESSION['STrad27'].")";$Lecture.="</option>";
			}

		return $Lecture;
	}
//****************************************************************************

//******************************* CALENDRIER CONDITION *************************
function CaleConditions($Dossier,$ConnexionBdd,$calenum,$typeprestnum,$typeprestprix,$calecondind)
	{
		$req = 'INSERT INTO calendrier_conditions VALUE(NULL,"'.$calenum.'","'.$typeprestnum.'","'.$typeprestprix.'","'.$calecondind.'")';
		$reqResult = $ConnexionBdd ->query($req) or die ('Erreur SQL !'.$req.'<br />'.mysqli_error());
		$calecondnum = $ConnexionBdd->lastInsertId();

		return $calecondnum;
	}
//******************************************************************

//*************************** GENERER UN NUMERO DE COMPTE CLIENT ***************************************
function CompteClieAjou($ConnexionBdd)
	{
		while($ok != 2)
			{
				$Nb = strlen($_SESSION['conflogprefixeclient']);
				$NbCalc1 = $Nb - $_SESSION['conflognbcaractnumcompte'];
				$NbCalc = $NbCalc1;

				if($_SESSION['conflognumerotationcompteclie'] == 1)
					{
						$num = Genere_Password(8);
						$clienumcompte = substr('0000000'.$num,$NbCalc);
						$clienumcompte = $_SESSION['conflogprefixeclient'].$clienumcompte;
					}
				if($_SESSION['conflognumerotationcompteclie'] == 2)
 					{
 						$reqClie = 'SELECT clienumcompte FROM clients WHERE AA_equimondo_hebeappnum = "'.$_SESSSION['hebeappnum'].'" ORDER BY clienumcompte DESC';
 						$reqClieResult = $ConnexionBdd ->query($reqClie) or die ('Erreur SQL !'.$reqClie.'<br />'.mysqli_error());
 						$reqClieAffich = $reqClieResult->fetch();

						$reqClieAffich['clienumcompte'] = preg_replace('/[^0-9]/', '', $reqClieAffich['clienumcompte']);

 						$nbCaract = strlen($_SESSION['conflogprefixeclient']);
 						$NbCaractTotal = $_SESSION['conflognbcaractnumcompte'];
 						$NbCaractRestant = $NbCaractTotal - $nbCaract;
 						$NbCaractRestantMoins = $NbCaractRestant * -1;

 						$reqClieAffich['clienumcompte'] = $reqClieAffich['clienumcompte'] + 1;
 						$numcompte =  "0000000".$reqClieAffich['clienumcompte'];
 						$clienumcompte = substr($numcompte, $NbCaractRestantMoins,$NbCaractRestant);
 						$clienumcompte = $_SESSION['conflogprefixeclient'].$clienumcompte;
 					}

				return $clienumcompte;
			}
	}
//****************************************************************************************

//******************************* AJOUTER UN CLIENT *************************
function ClieAjou($clienum,$clienom,$clieprenom,$cliedatenaiss,$clieadre,$cliecp,$clieville,$clienumtel,$clienumlic,$cliecommentaire,$clieadremail,$clieniveau,$cliecivilite,$cliepays,$cliesupp,$clieautoappli,$clienumtel1,$cliedatevallic,$cliedateinscription,$cliedatecotisation,$famiclienum,$clieresplegal,$clienumcompte,$cliestatus,$ConnexionBdd,$action,$clienbheurerestant,$clieprovince,$groupnum,$chevnum,$avoipart)
	{
		if(!empty($_SESSION['hebeappnum'])) {$Hebeappnum = $_SESSION['hebeappnum'];}
		else {$Hebeappnum = "NULL";}

		if(empty($cliedatenaiss)) {$cliedatenaiss = "0000-00-00";}
		if(empty($cliedatevallic)) {$cliedatevallic = "0000-00-00";}
		if(empty($cliedateinscription)) {$cliedateinscription = "0000-00-00";}
		if(empty($cliedatecotisation)) {$cliedatecotisation = "0000-00-00";}
		if(empty($clieniveau)) {$clieniveau = 0;}

		$clieadre = str_replace('"','\"',$clieadre);

		$clienom = SecureInput($clienom);
		$clieprenom = SecureInput($clieprenom);

		if($action == "ajou")
			{
				if(empty($cliesupp)) {$cliesupp = 1;}
				if(empty($clieautoappli)) {$clieautoappli = 2;}

				if(empty($famiclienum))
					{
						$req = 'INSERT INTO familleclients VALUE (NULL,'.$Hebeappnum.')';
						$reqResult = $ConnexionBdd ->query($req) or die ('Erreur SQL !'.$req.'<br />'.mysqli_error());
						$famiclienum = $ConnexionBdd->lastInsertId();
					}

				// GENERATION DU COMPTE CLIENT POUR LE COMPTABLE
				if(empty($clienumcompte))
					{
						$clienumcompte = CompteClieAjou($ConnexionBdd);
					}


				$req = 'INSERT INTO clients VALUE (NULL,"'.$clienom.'","'.$clieprenom.'","'.$cliedatenaiss.'","'.$clieadre.'","'.$cliecp.'","'.$clieville.'","'.$clienumtel.'","'.$clienumlic.'","'.$cliecommentaire.'","'.$clieadremail.'","'.$clieniveau.'","'.$cliecivilite.'","'.$cliepays.'","'.$cliesupp.'","'.$clieautoappli.'","'.$clienumtel1.'","'.$cliedatevallic.'","'.$cliedateinscription.'","'.$cliedatecotisation.'","'.$famiclienum.'","'.$clieresplegal.'","'.$clienumcompte.'","'.$cliestatus.'",'.$Hebeappnum.',"'.$cliecodebarre.'",NULL,NULL,NULL,NULL,"'.$clieprovince.'",NULL,NULL,NULL)';
				$reqResult = $ConnexionBdd ->query($req) or die ('Erreur SQL !'.$req.'<br />'.mysqli_error());
				$clienum = $ConnexionBdd->lastInsertId();

				// ASSOCIER GROUPE
				if(!empty($groupnum))
					{
						if ($_POST['groupnum'] == TRUE)
							{
								for ($i=0,$n=count($_POST['groupnum']);$i<$n;$i++)
									{
										if(!empty($_POST['groupnum'][$i]))
											{
												$req1 = 'INSERT INTO groupe_association VALUE (NULL,"'.$_POST['groupnum'][$i].'","'.$clienum.'",NULL)';
												$req1Result = $ConnexionBdd ->query($req1) or die ('Erreur SQL !'.$req1.'<br />'.mysqli_error());
											}
									}
							}
					}

				// ASSOCIER CHEVAL
				if(!empty($chevnum))
					{
						if(empty($avoipart)) {$avoipart = 1;}
						$req1 = 'INSERT INTO avoir VALUE (NULL,"'.$chevnum.'","'.$clienum.'","'.$avoipart.'")';
						$req1Result = $ConnexionBdd ->query($req1) or die ('Erreur SQL !'.$req1.'<br />'.mysqli_error());
					}
			}

		return array($clienum,$famiclienum);
	}
//****************************************************************************************

//*******************************************************************
function TypePrestationCatAjouModif($Dossier,$ConnexionBdd,$action,$typeprestcatnum,$typeprestcatlibe,$typeprestcatsupp)
	{
		if(empty($typeprestcatsupp)) {$typeprestcatsupp = 1;}
		$typeprestcatlibe = SecureInput($typeprestcatlibe);

		if($action == "ajou")
			{
				$req = 'INSERT INTO typeprestation_categorie VALUE (NULL,"'.$typeprestcatlibe.'","'.$typeprestcatsupp.'","'.$_SESSION['hebeappnum'].'")';
				$reqResult = $ConnexionBdd ->query($req) or die ('Erreur SQL !'.$req.'<br />'.mysqli_error());
				$typeprestcatnum = $ConnexionBdd->lastInsertId();
			}
		if($action == "modif")
			{
				$req = 'UPDATE typeprestation_categorie SET typeprestcatlibe="'.$typeprestcatlibe.'" WHERE typeprestcatnum = "'.$typeprestcatnum.'"';
				$reqResult = $ConnexionBdd ->query($req) or die ('Erreur SQL !'.$req.'<br />'.mysqli_error());
			}
		return $typeprestcatnum;
	}
//*******************************************************************

//******************************* AJOUTER UNE PRESTATION *************************
function TypePrestationAjou($Dossier,$ConnexionBdd,$action,$typeprestnum,$typeprestcat,$typeprestlibe,$typeprestdesc,$typeprestnbheurejour,$typeprestvalidite,$typeprestvaldate1,$typeprestvaldate2,$typepresthoraire1,$typepresthoraire2,$typepresthoraire3,$typepresthoraire4,$typeprestsupp,$typeprestnumcompte,$typeprestdate1,$typeprestdate2,$typeprestcatnum)
	{
		$typeprestlibe = SecureInput($typeprestlibe);
		$typeprestdesc = SecureInput($typeprestdesc);

		if($typeprestvalidite == "ajou") {$typeprestvalidite="";}
		if($typeprestnbheurejour == "ajou") {$typeprestnbheurejour = $typeprestnbheurejourAjou;}
		if($typeprestnbheurejour != "forfait1" AND $typeprestnbheurejour != "forfait2" AND $typeprestnbheurejour != "forfait3" AND $typeprestnbheurejour != "forfait4" AND $typeprestcat != 3 AND $typeprestcat != 6) {$typeprestnbheurejour = $typeprestnbheurejour * 60;}

		if(empty($typeprestsupp)) {$typeprestsupp=1;}

		if(empty($typepresthoraire1)) {$typepresthoraire1 = '00:00:00';}
		if(empty($typepresthoraire2)) {$typepresthoraire2 = '00:00:00';}
		if(empty($typepresthoraire3)) {$typepresthoraire3 = '00:00:00';}
		if(empty($typepresthoraire4)) {$typepresthoraire4 = '00:00:00';}

		if(empty($typeprestvaldate1)) {$typeprestvaldate1 = "0000-00-00";}
		if(empty($typeprestvaldate2)) {$typeprestvaldate2 = "0000-00-00";}

		if($action == "ajou")
			{
				$req = 'INSERT INTO typeprestation VALUES (NULL,"'.$typeprestcat.'","'.$typeprestlibe.'","'.$typeprestdesc.'","'.$typeprestnbheurejour.'","'.$typeprestvalidite.'","'.$typeprestvaldate1.'","'.$typeprestvaldate2.'","'.$typepresthoraire1.'","'.$typepresthoraire2.'","'.$typepresthoraire3.'","'.$typepresthoraire4.'","'.$typeprestsupp.'","'.$typeprestnumcompte.'","'.$_SESSION['hebeappnum'].'","'.$typeprestcatnum.'")';
				$reqResult = $ConnexionBdd ->query($req) or die ('Erreur SQL !'.$req.'<br />'.mysqli_error());
				$typeprestnum = $ConnexionBdd->lastInsertId();
			}
		//********************** MODIFIER UNE PRESTATION ************************
		if($action == "modif")
			{
				$req = 'UPDATE typeprestation SET typeprestcat = "'.$typeprestcat.'", typeprestlibe = "'.$typeprestlibe.'", typeprestdesc = "'.$typeprestdesc.'", typeprestnbheurejour = "'.$typeprestnbheurejour.'", typeprestvalidite = "'.$typeprestvalidite.'", typeprestvaldate1 = "'.$typeprestvaldate1.'", typeprestvaldate2 = "'.$typeprestvaldate2.'",typepresthoraire1 = "'.$typepresthoraire1.'", typepresthoraire2 = "'.$typepresthoraire2.'", typepresthoraire3 = "'.$typepresthoraire3.'", typepresthoraire4 = "'.$typepresthoraire4.'" WHERE typeprestnum = "'.$typeprestnum.'"';
				$reqResult = $ConnexionBdd ->query($req) or die ('Erreur SQL !'.$req.'<br />'.mysqli_error());
			}
		//*************************************************************************

		$req = 'DELETE FROM typeprestation_dateexclu WHERE typeprestation_typeprestnum = "'.$typeprestnum.'"';
		$reqResult = $ConnexionBdd ->query($req) or die ('Erreur SQL !'.$req.'<br />'.mysqli_error());

		//************************* DATE D EXCLUSION ****************************
		if ($typeprestdate1 == TRUE)
			{
				for ($i=0,$n=count($typeprestdate1);$i<$n;$i++)
					{
						if(!empty($typeprestdate1[$i]))
							{
								$req = 'INSERT INTO typeprestation_dateexclu VALUE (NULL,"'.$typeprestdate1[$i].'","'.$typeprestdate2[$i].'","'.$typeprestnum.'")';
								$reqResult = $ConnexionBdd ->query($req) or die ('Erreur SQL !'.$req.'<br />'.mysqli_error());
							}
					}
			}
		//********************************************************************

		return $typeprestnum;
	}
//****************************************************************************************

//******************************* AJOUTER UNE PRESTATION *************************
function TypePrestationPrixAjou($Dossier,$ConnexionBdd,$action,$typeprestprixnum,$typeprestnum,$nbtaux,$prixttc,$tauxtva1,$numcompte1,$repartition1,$libelle1,$tauxtva2,$numcompte2,$repartition2,$libelle2,$nbtaux1,$prixttc1,$tauxtva3,$numcompte3,$repartition3,$libelle3,$tauxtva4,$numcompte4,$repartition4,$libelle4,$typeprestprixtaxe1,$typeprestprixtaxe2)
	{
		$libelle1 = SecureInput($libelle1);
		$libelle2 = SecureInput($libelle2);
		$libelle3 = SecureInput($libelle3);
		$libelle4 = SecureInput($libelle4);

		if(empty($typeprestprixsupp)) {$typeprestprixsupp = 1;}
		$prixttc = str_replace (",",".",$prixttc);

		if($action == "ajou")
			{
				if($nbtaux == 1)
					{
						if(empty($tauxtva1)){$tauxtva1=0;}
						$req = 'INSERT INTO typeprestation_prix VALUE (NULL,"'.$prixttc.'","'.$tauxtva1.'","'.$typeprestnum.'","'.$typeprestprixsupp.'","'.$numcompte1.'","'.$libelle1.'","'.$_SESSION['hebeappnum'].'","'.$typeprestprixtaxe1.'","'.$typeprestprixtaxe2.'")';
						$reqResult = $ConnexionBdd ->query($req) or die ('Erreur SQL !'.$req.'<br />'.mysqli_error());
					}
				else if($nbtaux == 2)
					{
						$repartition1 = str_replace (" ","",$repartition1);$repartition1 = str_replace ("%","",$repartition1);$repartition1 = $repartition1 / 100;
						$repartition2 = str_replace (" ","",$repartition2);$repartition2 = str_replace ("%","",$repartition2);$repartition2 = $repartition2 / 100;
						if(empty($tauxtva1)) {$tauxtva1=0;}
						if(empty($tauxtva2)) {$tauxtva2=0;}

						$CalcCoef = ($repartition1 * $tauxtva1) + ($repartition2 * $tauxtva2) + 1;
						$PrixHtGlobal = $prixttc / $CalcCoef;
						$prixHt1 = $PrixHtGlobal * $repartition1;$MontantTva1 = $prixHt1 * $tauxtva1;$prixttc1 = $prixHt1 + $MontantTva1;
						$prixHt2 = $PrixHtGlobal * $repartition2;$MontantTva2 = $prixHt2 * $tauxtva2;$prixttc2 = $prixHt2 + $MontantTva2;

						$req = 'INSERT INTO typeprestation_prix VALUE (NULL,"'.$prixttc1.'","'.$tauxtva1.'","'.$typeprestnum.'","'.$typeprestprixsupp.'","'.$numcompte1.'","'.$libelle1.'","'.$_SESSION['hebeappnum'].'","'.$typeprestprixtaxe1.'","'.$typeprestprixtaxe2.'")';
						$reqResult = $ConnexionBdd ->query($req) or die ('Erreur SQL !'.$req.'<br />'.mysqli_error());

						$req = 'INSERT INTO typeprestation_prix VALUE (NULL,"'.$prixttc2.'","'.$tauxtva2.'","'.$typeprestnum.'","1","'.$numcompte2.'","'.$libelle2.'","'.$_SESSION['hebeappnum'].'","'.$typeprestprixtaxe1.'","'.$typeprestprixtaxe2.'")';
						$reqResult = $ConnexionBdd ->query($req) or die ('Erreur SQL !'.$req.'<br />'.mysqli_error());
					}
				if($nbtaux1 == 1)
					{
						if(empty($tauxtva1)){$tauxtva1=0;}
						$req = 'INSERT INTO typeprestation_prix VALUE (NULL,"'.$prixttc1.'","'.$tauxtva3.'","'.$typeprestnum.'","'.$typeprestprixsupp.'","'.$numcompte3.'","'.$libelle3.'","'.$_SESSION['hebeappnum'].'","'.$typeprestprixtaxe1.'","'.$typeprestprixtaxe2.'")';
						$reqResult = $ConnexionBdd ->query($req) or die ('Erreur SQL !'.$req.'<br />'.mysqli_error());
					}
				else if($nbtaux1 == 2)
					{
						$repartition3 = str_replace (" ","",$repartition3);$repartition3 = str_replace ("%","",$repartition3);$repartition3 = $repartition3 / 100;
						$repartition4 = str_replace (" ","",$repartition4);$repartition4 = str_replace ("%","",$repartition4);$repartition4 = $repartition4 / 100;
						if(empty($tauxtva3)) {$tauxtva3=0;}
						if(empty($tauxtva4)) {$tauxtva4=0;}

						$CalcCoef = ($repartition3 * $tauxtva3) + ($repartition4 * $tauxtva4) + 1;
						$PrixHtGlobal = $prixttc1 / $CalcCoef;
						$prixHt3 = $PrixHtGlobal * $repartition3;$MontantTva3 = $prixHt3 * $tauxtva3;$prixttc3 = $prixHt3 + $MontantTva3;
						$prixHt4 = $PrixHtGlobal * $repartition4;$MontantTva4 = $prixHt4 * $tauxtva4;$prixttc4 = $prixHt4 + $MontantTva4;

						$req = 'INSERT INTO typeprestation_prix VALUE (NULL,"'.$prixttc3.'","'.$tauxtva3.'","'.$typeprestnum.'","'.$typeprestprixsupp.'","'.$numcompte3.'","'.$libelle3.'","'.$_SESSION['hebeappnum'].'","'.$typeprestprixtaxe1.'","'.$typeprestprixtaxe2.'")';
						$reqResult = $ConnexionBdd ->query($req) or die ('Erreur SQL !'.$req.'<br />'.mysqli_error());

						$req = 'INSERT INTO typeprestation_prix VALUE (NULL,"'.$prixttc4.'","'.$tauxtva4.'","'.$typeprestnum.'","1","'.$numcompte4.'","'.$libelle4.'","'.$_SESSION['hebeappnum'].'","'.$typeprestprixtaxe1.'","'.$typeprestprixtaxe2.'")';
						$reqResult = $ConnexionBdd ->query($req) or die ('Erreur SQL !'.$req.'<br />'.mysqli_error());
					}
			}

		return $typeprestnum;
	}
//****************************************************************************************

//********************** AJOUTER / MODIFIER UN MODELE DE REPRISE *************
function ModeleReprise($modnum,$planlecomodlibe,$planlecomodjour,$planlecomodheure,$planlecomodduree,$planlecomoddesc,$planlecomodniveau1,$planlecomodniveau2,$planlecomodcat,$utilnum,$planlecomodnbmaxpers,$planlecomodinstal,$ConnexionBdd,$action,$planlecomodrepliquer,$planlecomoddureeabebiter)
	{
		if($action == "ajou")
			{
				$req = 'INSERT INTO planning_lecon_modele VALUE (NULL,"'.$planlecomodlibe.'","'.$planlecomodjour.'","'.$planlecomodheure.'","'.$planlecomodduree.'","'.$planlecomoddesc.'","'.$planlecomodniveau1.'","'.$planlecomodniveau2.'","'.$planlecomodcat.'","'.$utilnum.'","'.$planlecomodnbmaxpers.'","'.$planlecomodinstal.'","'.$_SESSION['hebeappnum'].'","'.$planlecomodrepliquer.'","'.$planlecomoddureeabebiter.'")';
				$reqResult = $ConnexionBdd ->query($req) or die ('Erreur SQL !'.$req.'<br />'.mysqli_error());
				$modnum = $ConnexionBdd->lastInsertId();
			}
		else if($action == "modif")
			{
				$req = 'UPDATE planning_lecon_modele SET planlecomodlibe = "'.$planlecomodlibe.'", planlecomodjour = "'.$planlecomodjour.'", planlecomodheure = "'.$planlecomodheure.'", planlecomodduree = "'.$planlecomodduree.'", planlecomoddesc = "'.$planlecomoddesc.'", planlecomodniveau1 = "'.$planlecomodniveau1.'", planlecomodniveau2 = "'.$planlecomodniveau2.'", planlecomodcategorie = "'.$planlecomodcat.'", utilisateurs_utilnum = "'.$utilnum.'",planlecomodnbmaxpers = "'.$planlecomodnbmaxpers.'", planlecomodinstal = "'.$planlecomodinstal.'",planlecomodrepliquer= "'.$planlecomodrepliquer.'",planlecomoddureeabebiter="'.$planlecomoddureeabebiter.'" WHERE planlecomodnum = "'.$modnum.'"';
				$reqResult = $ConnexionBdd ->query($req) or die ('Erreur SQL !'.$req.'<br />'.mysqli_error());
			}

		return $modnum;
	}
//*************************************************************************

//********************** AJOUTER UN CAVALIER UN MODELE DE REPRISE ***********
function ModeleRepriseCava($modnum,$clienum,$ConnexionBdd)
	{
		$req = 'INSERT INTO planning_clients_chevaux_modele VALUE (NULL,"'.$modnum.'","'.$clienum.'")';
		$reqResult = $ConnexionBdd ->query($req) or die ('Erreur SQL !'.$req.'<br />'.mysqli_error());
		$modclienum = $ConnexionBdd->lastInsertId();

		return $modclienum;
	}
//******************************************************************

//********** AJOUTER / MODIFIER DES DATES D'EXCLUS UN MODELE DE REPRISE ******
function ModeleRepriseDateExclu($planmoddateexclunum,$modnum,$date1,$date2,$ConnexionBdd,$action)
	{
		if($action == "ajou")
			{
				$req = 'INSERT INTO planning_modele_date_exclu VALUE (NULL,"'.$modnum.'","'.$date1.'","'.$date2.'")';
				$reqResult = $ConnexionBdd ->query($req) or die ('Erreur SQL !'.$req.'<br />'.mysqli_error());
				$planmoddateexclunum = $ConnexionBdd->lastInsertId();
			}
		if($action == "modif")
			{
				$req = 'UPDATE planning_modele_date_exclu SET planning_lecon_modele_planlecomodnum = "'.$modnum.'",  	planmoddateexcludate1="'.$date1.'", 	planmoddateexcludate2="'.$date2.'" WHERE planmoddateexclunum = "'.$planmoddateexclunum.'"';
				$reqResult = $ConnexionBdd ->query($req) or die ('Erreur SQL !'.$req.'<br />'.mysqli_error());
			}

		return $planmoddateexclunum;
	}
//**************************************************************

//******************* AJOUTER UN CALENDRIER *******************
function CalendrierAjou($calenum,$calecatetype,$caledate1,$caledate2,$caleheure1,$caleheure2,$caletext1,$caletext2,$caletext3,$caletext4,$caletext5,$caletext6,$caletext7,$caletext8,$chevnum,$utilnum,$repnum,$factprestnum,$caletext9,$caletext10,$caletext11,$caletext12,$caletext13,$ConnexionBdd,$caleaction,$calecatenum,$caletext14,$caletext15,$caletext16)
	{
		$caletext13 = SecureInput($caletext13);

		if(empty($caledate2)) {$caledate2 = $caledate1;}

		if(empty($caleheure1)) {$caleheure1 = "00:00:00";}
		if(empty($caleheure2)) {$caleheure2 = "00:00:00";}

		$caledate1 = $caledate1." ".$caleheure1;
		$caledate2 = $caledate2." ".$caleheure2;

		if($calecatetype == 1) {$date1Calc = formatheure1($caledate1);$caledate2=date("Y-m-d H:i:s",mktime($date1Calc[0], $date1Calc[1] + $caletext1, $date1Calc[2] - 1, $date1Calc[4] , $date1Calc[5], $date1Calc[3]));}

		if(empty($calecatenum)) {$calecatenum = "NULL";}

		if(empty($chevnum)) {$chevnum = "NULL";}
		if(empty($utilnum)) {$utilnum = "NULL";}
		if(empty($typeprestnum)) {$typeprestnum = "NULL";}
		if(empty($repnum)) {$repnum = "NULL";}
		if(empty($factprestnum)) {$factprestnum = "NULL";}
		if(empty($caletext11)) {$caletext11 = "NULL";}

		if($_SESSION['connind'] == 'util' OR !empty($_SESSION['hebeappnum'])) {$Hebeappnum = $_SESSION['hebeappnum'];}
		else if($_SESSION['connind'] == 'clie') {$Hebeappnum = "NULL";}

/*
		if($calecatetype == 4 AND $caleaction == "ajou")
			{
				$req = 'SELECT calenum FROM calendrier';
				if($_SESSION['connind'] == 'clie') {$req.=',calendrier_participants';}
				$req.=' WHERE caleindice = "4" AND caledate1 = "'.$caledate1.'" AND caletext3 = "'.$caletext3.'" AND caletext1 = "'.$caletext1.'" AND typeprestation_typeprestnum = "'.$typeprestnum.'" AND utilisateurs_utilnum1 = "'.$repnum.'"';
				if($_SESSION['connind'] == 'util') {$req.=' AND AA_equimondo_hebeappnum = "'.$_SESSION['hebeappnum'].'"';}
				else if($_SESSION['connind'] == 'clie') {$req.=' AND calendrier_calenum = calenum AND clients_clienum = "'.$_SESSION['connauthnum'].'"';}
				$reqResult = $ConnexionBdd ->query($req) or die ('Erreur SQL !'.$req.'<br />'.mysqli_error());
				$reqAffich = $reqResult->fetch();
				if(!empty($reqAffich['calenum'])) {return $reqAffich['calenum'];exit;}
			}
*/

		if($caleaction == "ajou")
			{
				$reqCat = 'SELECT * FROM calendrier_categorie WHERE calecatenum = "'.$calecatenum.'"';
				$reqCatResult = $ConnexionBdd ->query($reqCat) or die ('Erreur SQL !'.$reqCat.'<br />'.mysqli_error());
				$reqCatAffich = $reqCatResult->fetch();

				if($reqCatAffich['calecatetype'] == 1) {$caletext5 = 1;}
				$req = 'INSERT INTO calendrier VALUE (NULL,"'.$reqCatAffich['calecatetype'].'","'.$caledate1.'","'.$caledate2.'",NULL,NULL,"'.SecureInput($caletext1).'","'.SecureInput($caletext2).'","'.SecureInput($caletext3).'","'.SecureInput($caletext4).'","'.SecureInput($caletext5).'","'.SecureInput($caletext6).'","'.SecureInput($caletext7).'","'.SecureInput($caletext8).'",NULL,'.$utilnum.','.$repnum.','.$factprestnum.',"'.SecureInput($caletext9).'","'.SecureInput($caletext10).'",'.SecureInput($caletext11).',"'.SecureInput($caletext12).'",'.$Hebeappnum.',"'.$calejour1.'","'.$calejour2.'","'.$calejour3.'","'.$calejour4.'","'.$calejour5.'","'.$calejour6.'","'.$calejour7.'","'.$caledemijournee.'","'.$caleprix1jour.'","'.$caleprix2jour.'","'.$caleprix3jour.'","'.$caleprix4jour.'","'.$caleprix5jour.'","'.SecureInput($caletext13).'",'.$calecatenum.',"'.$caletext14.'","'.$caletext15.'","'.$caletext16.'")';
				$reqResult = $ConnexionBdd ->query($req) or die ('Erreur SQL !'.$req.'<br />'.mysqli_error());
				$calenum = $ConnexionBdd->lastInsertId();
			}
		else if($caleaction == "modif")
			{
				$req = 'UPDATE calendrier SET caledate1 = "'.$caledate1.'", caledate2 = "'.$caledate2.'",caletext1 = "'.$caletext1.'", caletext2 = "'.$caletext2.'", caletext3 = "'.$caletext3.'",caletext4 = "'.$caletext4.'", caletext5="'.$caletext5.'",caletext6="'.$caletext6.'",caletext7="'.$caletext7.'",caletext8="'.$caletext8.'",utilisateurs_utilnum='.$utilnum.',typeprestation_typeprestnum='.$typeprestnum.',utilisateurs_utilnum1='.$repnum.',factprestation_factprestnum='.$factprestnum.',caletext9="'.$caletext9.'",caletext10="'.$caletext10.'",caletext11='.$caletext11.',caletext12="'.$caletext12.'",AA_equimondo_hebeappnum = '.$Hebeappnum.',caletext13="'.$caletext13.'", calendrier_categorie_calecatenum ="'.$calecatenum.'" WHERE calenum = "'.$calenum.'"';
				$reqResult = $ConnexionBdd ->query($req) or die ('Erreur SQL !'.$req.'<br />'.mysqli_error());
			}

		return $calenum;
	}
//******************************************************************

//*********************** AJOUTER UN CALENDRIER PARTICIPANTS ******************
function CalendrierPartAjou($calepartnum,$calenum,$clienum,$chevnum,$caleparttext1,$caleparttext2,$caleparttext3,$caleparttext4,$caleparttext5,$caleparttext6,$caleparttext7,$equinum,$cliesoldentrnum,$calepartdate1,$calepartdate2,$ConnexionBdd,$caleaction,$depecat,$depemontantttc,$caledate1,$depetauxtva,$calepartnumasso,$factprestnum)
	{
		$Exec = 2;

		if($caleparttext1 == 2 AND ($caleparttext2 == 3 OR $caleparttext2 == 6) AND !empty($clienum))
			{
				$reqCale = 'SELECT * FROM calendrier,calendrier_categorie WHERE calendrier_categorie_calecatenum = calecatenum AND calenum = "'.$calenum.'"';
				$reqCaleResult = $ConnexionBdd ->query($reqCale) or die ('Erreur SQL !'.$reqCale.'<br />'.mysqli_error());
				$reqCaleAffich = $reqCaleResult->fetch();

				$reqCalePart = 'SELECT count(calepartnum) FROM calendrier_participants WHERE calendrier_calenum = "'.$calenum.'" AND clients_clienum = "'.$clienum.'"';
				$reqCalePartResult = $ConnexionBdd ->query($reqCalePart) or die ('Erreur SQL !'.$reqCalePart.'<br />'.mysqli_error());
				$reqCalePartAffich = $reqCalePartResult->fetch();
			}
		if($reqCaleAffich['calecatetype'] == 1 AND $reqCalePartAffich[0] >= 1)
			{
				$Exec = 1;
				$req = 'UPDATE calendrier_participants SET caleparttext1 = "2",caleparttext2 = "'.$caleparttext2.'" WHERE calendrier_calenum = '.$calenum.' AND clients_clienum='.$clienum.'';
				$reqResult = $ConnexionBdd ->query($req) or die ('Erreur SQL !'.$req.'<br />'.mysqli_error());
			}

		if($caleparttext2 == 6 AND !empty($clienum) AND !empty($calenum))
			{
				$reqCale = 'SELECT * FROM calendrier_participants WHERE calendrier_calenum = "'.$calenum.'" AND clients_clienum = "'.$clienum.'"';
				$reqCaleResult = $ConnexionBdd ->query($reqCale) or die ('Erreur SQL !'.$reqCale.'<br />'.mysqli_error());
				$reqCaleAffich = $reqCaleResult->fetch();
				if($reqCaleAffich[0] >= 1)
					{
						$Exec = 1;
						$req = 'UPDATE calendrier_participants SET caleparttext1 = "'.$caleparttext1.'",caleparttext2 = "'.$caleparttext2.'",chevaux_chevnum = NULL WHERE calendrier_calenum = '.$calenum.' AND clients_clienum='.$clienum.'';
						$reqResult = $ConnexionBdd ->query($req) or die ('Erreur SQL !'.$req.'<br />'.mysqli_error());
					}
			}

		$reqCat = 'SELECT * FROM calendrier,calendrier_categorie WHERE calendrier_categorie_calecatenum = calecatenum AND calenum = "'.$calenum.'"';
		$reqCatResult = $ConnexionBdd ->query($reqCat) or die ('Erreur SQL !'.$reqCat.'<br />'.mysqli_error());
		$reqCatAffich = $reqCatResult->fetch();

		// AJOUTE L'HEURE DE LA RERPISES A DEBITER
		if($reqCatAffich['calecatetype'] == 1)
			{
				$reqCale1 = 'SELECT * FROM calendrier WHERE calenum = "'.$calenum.'"';
				$reqCale1Result = $ConnexionBdd ->query($reqCale1) or die ('Erreur SQL !'.$reqCale1.'<br />'.mysqli_error());
				$reqCale1Affich = $reqCale1Result->fetch();

				$calepartnbdebit = $reqCale1Affich['caletext9'];
			}
		else {$calepartnbdebit = "";}

		if(empty($chevnum)) {$chevnum = "NULL";}
		if(empty($clienum)) {$clienum = "NULL";}
		if(empty($calenum)) {$calenum = "NULL";}
		if(empty($equinum)) {$equinum = "NULL";}
		if(empty($cliesoldentrnum)) {$cliesoldentrnum = "NULL";}
		if(empty($calepartdate1)) {$calepartdate1 = "0000-00-00 00:00:00";}
		if(empty($calepartdate2)) {$calepartdate2 = "0000-00-00 00:00:00";}
		if(empty($depecat)) {$depecat = "NULL";}
		if(empty($repnum)) {$repnum = "NULL";}

		if($_SESSION['connind'] == 'util' OR !empty($_SESSION['hebeappnum'])) {$Hebeappnum = $_SESSION['hebeappnum'];}
		else if($_SESSION['connind'] == 'clie') {$Hebeappnum = "NULL";}

		if($reqCaleAffich['calecatetype'] == 4) {$Exec = 2;}

		if($caleaction == "ajou" AND $Exec == 2)
			{
				$req = 'INSERT INTO calendrier_participants VALUE (NULL,'.$calenum.','.$clienum.','.$chevnum.',"'.$caleparttext1.'","'.$caleparttext2.'","'.$caleparttext3.'","'.$caleparttext4.'","'.$caleparttext5.'","'.$caleparttext6.'","'.$caleparttext7.'",NULL,'.$equinum.','.$cliesoldentrnum.','.$Hebeappnum.',"'.$calepartdate1.'","'.$calepartdate2.'",'.$depecat.',"'.$calepartnbdebit.'",NULL)';
				$reqResult = $ConnexionBdd ->query($req) or die ('Erreur SQL !'.$req.'<br />'.mysqli_error());
				$calepartnum = $ConnexionBdd->lastInsertId();

				// S IL Y A UNE DEPENSES
				if(!empty($depemontantttc))
					{
						$depedateCalc = formatheure1($caledate1);
						$depedate = $depedateCalc[3]."-".$depedateCalc[4]."-".$depedateCalc[5];

						//$depenum = DepensesAjou($depedate,$depetauxtva,$depemontantttc,$depecommentaire,$modepaienum,$deperef,$Hebeappnum,$chevnum,$clienum,$repnum,$depecat,$ConnexionBdd,"ajou",null);
					}

				if(!empty($calepartnumasso) OR !empty($depenum) OR !empty($factprestnum))
					{
						if(empty($calepartnumasso)) {$calepartnumasso = "NULL";}
						if(empty($calepartnum)) {$calepartnum = "NULL";}
						if(empty($depenum)) {$depenum = "NULL";}

						$req1 = 'INSERT INTO factprestation_association VALUE(NULL,NULL,NULL,'.$factprestnum.','.$calepartnumasso.','.$calepartnum.','.$depenum.',NULL,NULL,NULL,NULL,NULL,NULL,NULL)';
						$req1Result = $ConnexionBdd ->query($req1) or die ('Erreur SQL !'.$req1.'<br />'.mysqli_error());
					}
			}
		if($caleaction == "modif")
			{
				$req = 'UPDATE calendrier_participants SET calendrier_calenum = '.$calenum.',clients_clienum='.$clienum.',chevaux_chevnum='.$chevnum.',caleparttext1="'.$caleparttext1.'",caleparttext2="'.$caleparttext2.'",caleparttext3="'.$caleparttext3.'",caleparttext4="'.$caleparttext4.'",caleparttext5="'.$caleparttext5.'",caleparttext6="'.$caleparttext6.'",caleparttext7="'.$caleparttext7.'",equipement_equipenum='.$equinum.',clientssoldeforfentree_cliesoldforfentrnum='.$cliesoldentrnum.',AA_equimondo_hebeappnum='.$Hebeappnum.',calepartdate1='.$calepartdate1.',calepartdate2='.$calepartdate2.',depenses_categorie_depecatnum = '.$depecat.' WHERE calepartnum = "'.$calepartnum.'"';
				$reqResult = $ConnexionBdd ->query($req) or die ('Erreur SQL !'.$req.'<br />'.mysqli_error());
			}

		return $calepartnum;
	}
//*************************************************************************

//******************* LISTER UTILISATEURS **************
function UtilSelect($num,$ConnexionBdd,$utiltype,$action,$AfficheMoniteur)
	{
		if($AfficheMoniteur == 2)  {$Lecture = "<option value=''>-- ".$_SESSION['STrad269']." --</option>";}
		else if($utiltype == 1) {$Lecture = "<option value=''>-- ".$_SESSION['STrad270']." --</option>";}
		else if($utiltype == 2) {$Lecture = "<option value=''>-- ".$_SESSION['STrad271']." --</option>";}
		if($action == "ajou" AND $utiltype == 2) {$Lecture.="<option value='ajou'>-- ".$_SESSION['STrad272']." --</option>";}
		$req = 'SELECT utilnum,utilnom,utilprenom,utilville FROM utilisateurs';
		if($utiltype == 2) {$req.= ',utilisateurs_hebeappnum';}
		$req.=' WHERE ';
		if($utiltype == 1) {$req.= ' utiltype = "'.$utiltype.'" AND AA_equimondo_hebeappnum = "'.$_SESSION['hebeappnum'].'" AND utilsupp = "1"';}
		if($utiltype == 2 AND $_SESSION['connind'] == 'util') {$req.= ' utilisateurs_utilnum = utilnum AND utilisateurs_hebeappnum.AA_equimondo_hebeappnum = "'.$_SESSION['hebeappnum'].'" AND utilhebeappsupp = "1"';}
		if($utiltype == 2 AND $_SESSION['connind'] == 'clie') {$req.= ' utilisateurs_utilnum = utilnum AND utilisateurs_hebeappnum.clients_clienum = "'.$_SESSION['connauthnum'].'" AND utilhebeappsupp = "1"';}
		$req.=' ORDER BY utilnom ASC';
		$reqResult = $ConnexionBdd ->query($req) or die ('Erreur SQL !'.$req.'<br />'.mysqli_error());
		while($reqAffich = $reqResult->fetch())
			{
				$Lecture.="<option value='".$reqAffich[0]."'";if($num == $reqAffich[0]) {$Lecture.=" selected";} $Lecture.=">".$reqAffich[1]." ".$reqAffich[2];if(!empty($reqAffich[3])) {$Lecture.=" (".$reqAffich[3].")";} $Lecture.="</option>";
			}

		return $Lecture;
	}
//******************************************************************

//******************* CATEGORIE CALENDRIER **************
function CaleCateSelect($num,$ConnexionBdd,$action)
	{
		$Lecture = "<option value=''>-- ".$_SESSION['STrad273']." --</option>";
		if($action == "ajou") {$Lecture.="<option value='ajou'>-- ".$_SESSION['STrad274']." --</option>";}
		$req = 'SELECT * FROM calendrier_categorie WHERE AA_equimondo_hebeappnum = "'.$_SESSION['hebeappnum'].'" ORDER BY calecatelibe ASC';
		$reqResult = $ConnexionBdd ->query($req) or die ('Erreur SQL !'.$req.'<br />'.mysqli_error());
		while($reqAffich = $reqResult->fetch())
			{
				$Lecture.="<option value='".$reqAffich['calecatenum']."'";if($num == $reqAffich['calecatenum']) {$Lecture.=" selected";} $Lecture.=">".$reqAffich['calecatelibe']."</option>";
			}

		return $Lecture;
	}
//******************************************************************

//******************* DISCIPLINE CALENDRIER **************
function CaleDiscSelect($num,$ConnexionBdd,$action,$calenum)
	{
		$Lecture = "<option value=''>-- ".$_SESSION['STrad278']." --</option>";
		if($action == "ajou") {$Lecture.="<option value='ajou'>-- ".$_SESSION['STrad277']." --</option>";}
		$req = 'SELECT * FROM calendrier_discipline_configuration WHERE AA_equimondo_hebeappnum = "'.$_SESSION['hebeappnum'].'" ORDER BY calediscconflibe ASC';
		$reqResult = $ConnexionBdd ->query($req) or die ('Erreur SQL !'.$req.'<br />'.mysqli_error());
		while($reqAffich = $reqResult->fetch())
			{
				if($num == $reqAffich['calediscconflibe']) {$Selected = "Selected";}
				else if(!empty($calenum))
					{
						$reqCale = 'SELECT count(calediscinum) FROM calendrier_discipline WHERE calendrier_calenum	 = "'.$calenum.'" AND calediscilibe = "'.$reqAffich['calediscconflibe'].'"';
						$reqCaleResult = $ConnexionBdd ->query($reqCale) or die ('Erreur SQL !'.$reqCale.'<br />'.mysqli_error());
						$reqCaleAffich = $reqCaleResult->fetch();
						if($reqCaleAffich[0] == 1) {$Selected = "selected";}
						else {$Selected = "";}
					}
				else {$Selected = "";}

				$Lecture.="<option value='".$reqAffich['calediscconfnum']."'";if(!empty($Selected)) {$Lecture.=" ".$Selected;} $Lecture.=">".$reqAffich['calediscconflibe']."</option>";
			}

		return $Lecture;
	}
//******************************************************************


//******************* FONCTION INSTALLATION **********************
function InstSelect($num,$ConnexionBdd,$AfficheAjou)
	{
		$Lecture = "<option value=''>-- ".$_SESSION['STrad279']." --</option>";
		if($AfficheAjou == "ajou") {$Lecture.= "<option value='ajou'>- ".$_SESSION['STrad280']." -</option>";}
		$req = 'SELECT instlibe FROM installations WHERE instsupp="1" AND AA_equimondo_hebeappnum = "'.$_SESSION['hebeappnum'].'" ORDER BY instlibe ASC';
		$reqResult = $ConnexionBdd ->query($req) or die ('Erreur SQL !'.$req.'<br />'.mysqli_error());
		while($reqAffich = $reqResult->fetch())
			{
				$Lecture.="<option value='".$reqAffich[0]."'";if($num == $reqAffich[0]) {$Lecture.=" selected";} $Lecture.=">".$reqAffich[0]."</option>";
			}

		return $Lecture;
	}
//************************************************************

//*********************** CALENDRIER NIVEAU ***********************
function CalendrierNiveau($num,$ConnexionBdd,$Ajou,$calenum)
	{
		$Lecture = "<option value=''>-- ".$_SESSION['STrad282']." --</option>";
		if($Ajou == "ajou") {$Lecture.="<option value='ajou'>- ".$_SESSION['STrad283']." -</option>";}
		$req = 'SELECT caleniveconflibe FROM calendrier_niveau_configuration WHERE AA_equimondo_hebeappnum = "'.$_SESSION['hebeappnum'].'" ORDER BY caleniveconflibe ASC';
		$reqResult = $ConnexionBdd ->query($req) or die ('Erreur SQL !'.$req.'<br />'.mysqli_error());
		while($reqAffich = $reqResult->fetch())
			{
				if($num == $reqAffich[0]) {$Selected = "Selected";}
				else if(!empty($calenum))
					{
						$reqCale = 'SELECT count(calenivenum) FROM calendrier_niveau WHERE calendrier_calenum	 = "'.$calenum.'" AND calenivelibe = "'.$reqAffich['caleniveconflibe'].'"';
						$reqCaleResult = $ConnexionBdd ->query($reqCale) or die ('Erreur SQL !'.$reqCale.'<br />'.mysqli_error());
						$reqCaleAffich = $reqCaleResult->fetch();
						if($reqCaleAffich[0] == 1) {$Selected = "selected";}
						else {$Selected = "";}
					}
				else {$Selected = "";}
				$Lecture.="<option value='".$reqAffich[0]."'";if(!empty($Selected)) {$Lecture.=" ".$Selected;} $Lecture.=">".$reqAffich[0]."</option>";
			}

		return $Lecture;
	}
//**********************************************

//******************** INSTALLATION **************************
function InstallationRequete($Dossier,$ConnexionBdd,$instlibe,$instsupp,$action)
	{
		if(empty($instsupp)) {$instsupp = 1;}

		if($action == "ajou")
			{
				$req = 'INSERT INTO installations VALUE (NULL,"'.$instlibe.'","'.$instsupp.'","'.$_SESSION['hebeappnum'].'")';
				$reqResult = $ConnexionBdd ->query($req) or die ('Erreur SQL !'.$req.'<br />'.mysqli_error());
				$instnum = $ConnexionBdd->lastInsertId();
			}

		return $instnum;
	}
//**********************************************

//******************** DISCIPLINE **************************
function DisciplineRequete($Dossier,$ConnexionBdd,$calediscconflibe,$action)
	{
		if($action == "ajou")
			{
				$req = 'INSERT INTO calendrier_discipline_configuration VALUE (NULL,"'.$calediscconflibe.'","'.$_SESSION['hebeappnum'].'")';
				$reqResult = $ConnexionBdd ->query($req) or die ('Erreur SQL !'.$req.'<br />'.mysqli_error());
				$calediscconfnum = $ConnexionBdd->lastInsertId();
			}

		return $calediscconfnum;
	}
//**********************************************

//******************** NIVEAU **************************
function NiveauRequete($Dossier,$ConnexionBdd,$caleniveconflibe,$action)
	{
		if($action == "ajou")
			{
				$req = 'INSERT INTO calendrier_niveau_configuration VALUE (NULL,"'.$caleniveconflibe.'","'.$_SESSION['hebeappnum'].'")';
				$reqResult = $ConnexionBdd ->query($req) or die ('Erreur SQL !'.$req.'<br />'.mysqli_error());
				$caleniveconfnum = $ConnexionBdd->lastInsertId();
			}

		return $caleniveconfnum;
	}
//**********************************************

//********************** SUPPRESSION CALENDRIER ********************
function CalendrierSupp($calenum,$ConnexionBdd)
	{
		$reqCale = 'SELECT calepartnum FROM calendrier_participants WHERE calendrier_calenum = "'.$calenum.'"';
		$reqCaleResult = $ConnexionBdd ->query($reqCale) or die ('Erreur SQL !'.$reqCale.'<br />'.mysqli_error());
		while($reqCaleAffich = $reqCaleResult->fetch())
			{
				$ok = CalendrierPartSupp($reqCaleAffich[0],$ConnexionBdd);
			}

		$req = 'DELETE FROM commentairesgenerals WHERE calendrier_calenum="'.$calenum.'"';
		$reqResult = $ConnexionBdd ->query($req) or die ('Erreur SQL !'.$req.'<br />'.mysqli_error());

		$req = 'DELETE FROM calendrier_commentaires WHERE calendrier_calenum="'.$calenum.'"';
		$reqResult = $ConnexionBdd ->query($req) or die ('Erreur SQL !'.$req.'<br />'.mysqli_error());
		$req = 'DELETE FROM calendrier_complementaire WHERE calendrier_calenum="'.$calenum.'"';
		$reqResult = $ConnexionBdd ->query($req) or die ('Erreur SQL !'.$req.'<br />'.mysqli_error());
		$req = 'DELETE FROM calendrier_discipline WHERE calendrier_calenum="'.$calenum.'"';
		$reqResult = $ConnexionBdd ->query($req) or die ('Erreur SQL !'.$req.'<br />'.mysqli_error());
		$req = 'DELETE FROM calendrier_niveau WHERE calendrier_calenum="'.$calenum.'"';
		$reqResult = $ConnexionBdd ->query($req) or die ('Erreur SQL !'.$req.'<br />'.mysqli_error());
		$req = 'DELETE FROM calendrier_typeprestation WHERE calendrier_calenum="'.$calenum.'"';
		$reqResult = $ConnexionBdd ->query($req) or die ('Erreur SQL !'.$req.'<br />'.mysqli_error());


		$req = 'DELETE FROM planning_modele_calendrier WHERE calendrier_calenum="'.$calenum.'"';
		$reqResult = $ConnexionBdd ->query($req) or die ('Erreur SQL !'.$req.'<br />'.mysqli_error());

		$reqDoc = 'SELECT * FROM documents WHERE calendrier_calenum = "'.$calenum.'"';
		$reqDocResult = $ConnexionBdd ->query($reqDoc) or die ('Erreur SQL !'.$reqDoc.'<br />'.mysqli_error());
		while($reqDocAffich = $reqDocResult->fetch())
			{
				passthru("rm ".$Dossier."perso_images/documents/".$reqDocAffich['docnom'], $err);
			}

		$req = 'DELETE FROM documents WHERE calendrier_calenum="'.$calenum.'"';
		$reqResult = $ConnexionBdd ->query($req) or die ('Erreur SQL !'.$req.'<br />'.mysqli_error());
		$req = 'DELETE FROM calendrier WHERE calenum="'.$calenum.'"';
		$reqResult = $ConnexionBdd ->query($req) or die ('Erreur SQL !'.$req.'<br />'.mysqli_error());

		return "ok";
	}
//********************************************************************

//*********************** SUPPRESSION CALENDRIER ************************
function CalendrierPartSupp($calepartnum,$ConnexionBdd)
	{
		$req1 = 'SELECT calendrier_participants_calepartnum,calendrier_participants_calepartnum1,depenses_depenum FROM factprestation_association WHERE calendrier_participants_calepartnum = "'.$calepartnum.'" OR calendrier_participants_calepartnum1 = "'.$calepartnum.'"';
		$req1Result = $ConnexionBdd ->query($req1) or die ('Erreur SQL !'.$req1.'<br />'.mysqli_error());
		while($req1Affich = $req1Result->fetch())
			{
				$req = 'DELETE FROM factprestation_association WHERE calendrier_participants_calepartnum = "'.$calepartnum.'" OR calendrier_participants_calepartnum = "'.$calepartnum.'"';
				$reqResult = $ConnexionBdd ->query($req) or die ('Erreur SQL !'.$req.'<br />'.mysqli_error());
				$req = 'DELETE FROM factprestation_association WHERE calendrier_participants_calepartnum1 = "'.$calepartnum.'" OR calendrier_participants_calepartnum1 = "'.$calepartnum.'"';
				$reqResult = $ConnexionBdd ->query($req) or die ('Erreur SQL !'.$req.'<br />'.mysqli_error());

				if(!empty($req1Affich[2]))
					{
						$req = 'DELETE FROM depenses WHERE depenum = "'.$req1Affich[2].'"';
						$reqResult = $ConnexionBdd ->query($req) or die ('Erreur SQL !'.$req.'<br />'.mysqli_error());
					}
			}

		$req = 'DELETE FROM calendrier_participants WHERE calepartnum = "'.$calepartnum.'"';
		$reqResult = $ConnexionBdd ->query($req) or die ('Erreur SQL !'.$req.'<br />'.mysqli_error());

		return "ok";
	}
//**************************************************

//*********************** SELECTIONNE PRESTATIONS ************************
function PrestationsSelect($Dossier,$ConnexionBdd,$typeprestnum,$typeprestcat)
	{
		$Lecture.="<option value=''>-- ".$_SESSION['STrad726']." --</option>";

		$req1 = 'SELECT * FROM typeprestation WHERE AA_equimondo_hebeappnum = "'.$_SESSION['hebeappnum'].'" AND typeprestsupp="1"';
		if(!empty($typeprestcat)) {$req1.=' AND typeprestcat = "'.$typeprestcat.'"';}
		$req1.=' ORDER BY typeprestlibe ASC';
		$req1Result = $ConnexionBdd ->query($req1) or die ('Erreur SQL !'.$req1.'<br />'.mysqli_error());
		while($req1Affich = $req1Result->fetch())
			{
				$req2 = 'SELECT sum(typeprestprixprix) FROM typeprestation_prix WHERE typeprestprixsupp = "1" AND typeprestation_typeprestnum = "'.$req1Affich['typeprestnum'].'"';
				$req2Result = $ConnexionBdd ->query($req2) or die ('Erreur SQL !'.$req2.'<br />'.mysqli_error());
				$req2Affich = $req2Result->fetch();

				$Lecture.="<option value='".$req1Affich['typeprestnum']."'>".$req1Affich['typeprestlibe']." (".$req2Affich[0]." ".$_SESSION['STrad27'].")</option>";
			}
		return $Lecture;
	}
//*****************************************************

//********************* SUPPRESSION ENCAISSERMENT EN ATTENTE ***************************
function EncaissementSupp($Dossier,$ConnexionBdd,$factencnum)
	{
		$req1 ='SELECT * FROM factures_factencaisser WHERE factencaisser_factencnum = "'.$factencnum.'"';
		$req1Result = $ConnexionBdd ->query($req1) or die ('Erreur SQL !'.$req1.'<br />'.mysqli_error());
		while($req1Affich = $req1Result->fetch())
			{
				$req2 = 'DELETE FROM factures_factencaisser_stat WHERE factures_factencaisser_factencassonum = "'.$req1Affich['factencassonum'].'"';
				$req2Result = $ConnexionBdd ->query($req2) or die ('Erreur SQL !'.$req2.'<br />'.mysqli_error());
			}

		$req1 ='DELETE FROM factures_factencaisser WHERE factencaisser_factencnum = "'.$factencnum.'"';
		$req1Result = $ConnexionBdd ->query($req1) or die ('Erreur SQL !'.$req1.'<br />'.mysqli_error());

		$req1 ='DELETE FROM livredecompte WHERE factencaisser_factencnum = "'.$factencnum.'"';
		$req1Result = $ConnexionBdd ->query($req1) or die ('Erreur SQL !'.$req1.'<br />'.mysqli_error());

		$req1 ='DELETE FROM caisse WHERE factencaisser_factencnum = "'.$factencnum.'"';
		$req1Result = $ConnexionBdd ->query($req1) or die ('Erreur SQL !'.$req1.'<br />'.mysqli_error());

		$req1 ='DELETE FROM factencaisser_cloture_association WHERE factencaisser_factencnum = "'.$factencnum.'"';
		$req1Result = $ConnexionBdd ->query($req1) or die ('Erreur SQL !'.$req1.'<br />'.mysqli_error());

		$req1 ='DELETE FROM factencaisser WHERE factencnum = "'.$factencnum.'"';
		$req1Result = $ConnexionBdd ->query($req1) or die ('Erreur SQL !'.$req1.'<br />'.mysqli_error());

		return $factencnum;
	}
//************************************************************************************

?>
