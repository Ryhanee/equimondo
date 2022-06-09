<?php
//********************** CAISSE CONFIGURATION LISTER PRESTATION********************************
function CaisseConfListePrestations($Dossier,$Connexionbdd,$num)
  {
    $Lecture.="<option value='1'";if($num == 1) {$Lecture.=" selected";} $Lecture.=">".$_SESSION['STrad203']."</option>";
    $Lecture.="<option value='2'";if($num == 2) {$Lecture.=" selected";} $Lecture.=">".$_SESSION['STrad204']."</option>";
    $Lecture.="<option value='3'";if($num == 3) {$Lecture.=" selected";} $Lecture.=">".$_SESSION['STrad205']."</option>";
    $Lecture.="<option value='4'";if($num == 4) {$Lecture.=" selected";} $Lecture.=">".$_SESSION['STrad206']."</option>";
    $Lecture.="<option value='5'";if($num == 5) {$Lecture.=" selected";} $Lecture.=">".$_SESSION['STrad207']."</option>";
    $Lecture.="<option value='6'";if($num == 6) {$Lecture.=" selected";} $Lecture.=">".$_SESSION['STrad208']."</option>";

    return $Lecture;
  }
//****************************************************************************************

//******************** AFFICHE LES TAUX DE TVA DANS UN  TABLEAU **********************
function AffichTauxTva($tauxtva)
	{
		if(!empty($tauxtva))
      {
        $tauxtva = $tauxtva * 100;
        $tauxtva = number_format($tauxtva, 2, '.', '');
        $tauxtva = $tauxtva." %";
      }

    return $tauxtva;
	}

function AffichTauxTvaSelect($num)
	{
    if($_SESSION['infologlang2'] == "fr")
      {
        $Lecture.="<option value='0'";if($num == "0") {$Lecture.=" selected";}$Lecture.=">0 %</option>";
        $Lecture.="<option value='0.021'";if($num == "0.021") {$Lecture.=" selected";}$Lecture.=">2,10 %</option>";
        $Lecture.="<option value='0.055'";if($num == "0.055") {$Lecture.=" selected";}$Lecture.=">5,50 %</option>";
        $Lecture.="<option value='0.085'";if($num == "0.085") {$Lecture.=" selected";}$Lecture.=">8,50 %</option>";
        $Lecture.="<option value='0.1'";if($num == "0.1") {$Lecture.=" selected";}$Lecture.=">10 %</option>";
        $Lecture.="<option value='0.2'";if($num == "0.2") {$Lecture.=" selected";}$Lecture.=">20 %</option>";
      }
    if($_SESSION['infologlang2'] == "es")
      {
        $Lecture.="<option value='0'";if($num == "0") {$Lecture.=" selected";}$Lecture.=">0 %</option>";
        $Lecture.="<option value='0.04'";if($num == "0.04") {$Lecture.=" selected";}$Lecture.=">4 %</option>";
        $Lecture.="<option value='0.1'";if($num == "0.1") {$Lecture.=" selected";}$Lecture.=">10 %</option>";
        $Lecture.="<option value='0.21'";if($num == "0.21") {$Lecture.=" selected";}$Lecture.=">21 %</option>";
      }
    if($_SESSION['infologlang2'] == "nl")
      {
        $Lecture.="<option value='0'";if($num == "0") {$Lecture.=" selected";}$Lecture.=">0 %</option>";
        $Lecture.="<option value='0.09'";if($num == "0.09") {$Lecture.=" selected";}$Lecture.=">9 %</option>";
        $Lecture.="<option value='0.21'";if($num == "0.21") {$Lecture.=" selected";}$Lecture.=">21 %</option>";
      }
    if($_SESSION['infologlang2'] == "ch")
      {
        $Lecture.="<option value='0'";if($num == "0") {$Lecture.=" selected";}$Lecture.=">0 %</option>";
        $Lecture.="<option value='0.025'";if($num == "0.025") {$Lecture.=" selected";}$Lecture.=">2.5 %</option>";
        $Lecture.="<option value='0.077'";if($num == "0.077") {$Lecture.=" selected";}$Lecture.=">7.7 %</option>";
      }

		return $Lecture;
	}
//*************************************************************************

//******************** PRESTATION *******************************
function AfficheListePrestations($Dossier,$ConnexionBdd,$num)
  {
    $Lecture.="<div style='width:100%;'>";
    $Lecture.="<div class='InfoStandard FormInfoStandard1'><img src='".$Dossier."images/informationBlanc.png' class='imgSousMenu1' style='margin-right:10px;'>".$_SESSION['STrad216']."</div>";
    $Lecture.="<div style='width:90%;display:block;clear:both;height:10px;'></div>";

    if($_SESSION['ResolutionConnexion1'] > 800)
      {
        $Lecture.="<a href='".$Dossier."modules/configuration/prestationsAjou.php' class='LoadPage AffichePrestationAjou button buttonLittle2'><img src='".$Dossier."images/ajouterBlanc.png' class='ImgSousMenu2'>".$_SESSION['STrad157']."</a>";
      }
    $Lecture.="<div style='width:90%;display:block;clear:both;height:10px;'></div>";

    $req1 = 'SELECT * FROM typeprestation WHERE typeprestsupp = "1" AND AA_equimondo_hebeappnum = "'.$_SESSION['hebeappnum'].'"';
    if(!empty($num)) {$req1.=' AND typeprestation_categorie_typeprestcatnum='.$num;}
    $req1.= ' ORDER BY typeprestlibe ASC';
    $req1Result = $ConnexionBdd ->query($req1) or die ('Erreur SQL !'.$req1.'<br />'.mysqli_error());
    while($req1Affich = $req1Result->fetch())
      {
        if($_SESSION['ResolutionConnexion1'] < 800)
          {
            $Lien1 = "<a href='".$Dossier."modules/configuration/prestationsFicheComplet.php?typeprestnum=".$req1Affich['typeprestnum']."&AfficheSmartphone=2' class='LoadPage AffichePrestationFicheComplet1'>";
          }
        else
          {
            $Lien1 = "<a href='".$Dossier."modules/configuration/prestationsFicheComplet.php?typeprestnum=".$req1Affich['typeprestnum']."' class='LoadPage AffichePrestationFicheComplet'>";
          }
        $Lien2 = "</a>";

        $req2 = 'SELECT sum(typeprestprixprix) FROM typeprestation_prix WHERE typeprestation_typeprestnum = "'.$req1Affich['typeprestnum'].'" AND typeprestprixsupp = "1"';
        $req2Result = $ConnexionBdd ->query($req2) or die ('Erreur SQL !'.$req2.'<br />'.mysqli_error());
        $req2Affich = $req2Result->fetch();
        $Lecture.=$Lien1."<div style='width:96%;display:block;clear:both;'>";
          $Lecture.=$Lien1."<div style='width:78%;float:left;margin-right:2%;'>".$req1Affich['typeprestlibe']."</div>".$Lien2;
          $Lecture.=$Lien1."<div style='width:18%;float:left;margin-left:2%;white-space:nowrap'>".$req2Affich[0]." ".$_SESSION['STrad27']."</div>".$Lien2;
        $Lecture.="</div>".$Lien2;

        $Lecture.="<div style='width:96%;display:block;clear:both;'>";
          $Lecture.="<div style='height:5px;'></div>";
          $Lecture.="<hr style='width:70%;'>";
          $Lecture.="<div style='height:5px;'></div>";
        $Lecture.="</div>";
      }

    $Lecture.="</div>";
    return $Lecture;
  }
//*************************************************************************

//******************** PRESTATION CATEGORIE *******************************
function AfficheListePrestationsCategorie($Dossier,$ConnexionBdd,$typeprestcatnum,$AutoAjou)
  {
    $Lecture1.="<div style='width:100%;'>";
    $Lecture1.="<div class='InfoStandard FormInfoStandard1'><img src='".$Dossier."images/informationBlanc.png' class='imgSousMenu1' style='margin-right:10px;'>".$_SESSION['STrad215']."</div>";
    $Lecture1.="<div style='width:90%;display:block;clear:both;height:10px;'></div>";

    // AJOUTER UNE CATEGORIE DE PRESTATION
    if($_SESSION['ResolutionConnexion1'] > 800)
      {
        $Lecture1.="<a href='".$Dossier."modules/configuration/prestationsCatAjou.php' class='LoadPage AffichePrestationCatAjou button buttonLittle2'><img src='".$Dossier."images/ajouterBlanc.png' class='ImgSousMenu2'>".$_SESSION['STrad214']."</a>";
      }

    $Lecture1.="<div style='width:90%;display:block;clear:both;height:10px;'></div>";

    $Lecture2.="<option value=''>- ".$_SESSION['STrad234']." -</option>";
    if($AutoAjou != 1) {$Lecture2.="<option value='ajou'>- ".$_SESSION['STrad214']." -</option>";}

    $req1 = 'SELECT * FROM typeprestation_categorie WHERE typeprestcatsupp = "1" AND AA_equimondo_hebeappnum = "'.$_SESSION['hebeappnum'].'" ORDER BY typeprestcatlibe ASC';
    $req1Result = $ConnexionBdd ->query($req1) or die ('Erreur SQL !'.$req1.'<br />'.mysqli_error());
    while($req1Affich = $req1Result->fetch())
      {
        $Lecture1.="<ul>";
          $Lecture1.="<li style='margin-left:40px;margin-top:5px;margin-bottom:5px;'>";
          $Lecture1.="<a href='".$Dossier."modules/configuration/prestation_script.php?typeprestcatnum=".$req1Affich['typeprestcatnum']."' class='LoadPage AfficheTypePrestationCatNum LienHref'> ".$req1Affich['typeprestcatlibe']."</a>";
          $Lecture1.="<a href='".$Dossier."modules/configuration/prestationsCatAjou.php?typeprestcatnum=".$req1Affich['typeprestcatnum']."' class='LoadPage AffichePrestationCatAjou'><img src='".$Dossier."images/modifier.png' class='ImgSousMenu2' style='margin-left:10px;'></a>";
          $Lecture1.="<a href='".$Dossier."modules/configuration/prestationCat_script.php?typeprestcatnum=".$req1Affich['typeprestcatnum']."&typeprestcatsupp=2' class='LoadPage AfficheListeTypePrestationCat'><img src='".$Dossier."images/supprimer.png' class='ImgSousMenu2' style='margin-left:10px;'></a>";
          $Lecture1.="</li>";
        $Lecture1.="</ul>";

        $Lecture2.="<option value='".$req1Affich['typeprestcatnum']."'";if($req1Affich['typeprestcatnum'] == $typeprestcatnum) {$Lecture2.=" selected";} $Lecture2.=">".$req1Affich['typeprestcatlibe']."</option>";
      }

    $Lecture1.="</div>";
    return array ($Lecture1,$Lecture2);
  }
//*************************************************************************

//*********************** AFFICHE LES TYPES DE PRESTATION ******************************
function AfficheTypePrestation($num,$action)
  {
    $Lecture.="<option value=''>- ".$_SESSION['STrad224']." -</option>";

    $Lecture.="<option value='1";if($action == "modif") {$Lecture.="|modif";} $Lecture.="'";if($num == 1) {$Lecture.=" selected";} $Lecture.=">".$_SESSION['STrad45']."</option>";
    $Lecture.="<option value='2";if($action == "modif") {$Lecture.="|modif";} $Lecture.="'";if($num == 2) {$Lecture.=" selected";} $Lecture.=">".$_SESSION['STrad219']."</option>";
    $Lecture.="<option value='3";if($action == "modif") {$Lecture.="|modif";} $Lecture.="'";if($num == 3) {$Lecture.=" selected";} $Lecture.=">".$_SESSION['STrad185']."</option>";
    $Lecture.="<option value='5";if($action == "modif") {$Lecture.="|modif";} $Lecture.="'";if($num == 5) {$Lecture.=" selected";} $Lecture.=">".$_SESSION['STrad220']."</option>";
    $Lecture.="<option value='6";if($action == "modif") {$Lecture.="|modif";} $Lecture.="'";if($num == 6) {$Lecture.=" selected";} $Lecture.=">".$_SESSION['STrad221']."</option>";
    $Lecture.="<option value='7";if($action == "modif") {$Lecture.="|modif";} $Lecture.="'";if($num == 7) {$Lecture.=" selected";} $Lecture.=">".$_SESSION['STrad222']."</option>";
    $Lecture.="<option value='8";if($action == "modif") {$Lecture.="|modif";} $Lecture.="'";if($num == 8) {$Lecture.=" selected";} $Lecture.=">".$_SESSION['STrad223']."</option>";
    $Lecture.="<option value='9";if($action == "modif") {$Lecture.="|modif";} $Lecture.="'";if($num == 9) {$Lecture.=" selected";} $Lecture.=">".$_SESSION['STrad347']."</option>";

    return $Lecture;
  }
//*************************************************************************

//*************************** NOMBRE D'HEURE DE VALIDIE ********************************
function AfficheTypePrestHeureValidite($num,$action)
	{
    $Lecture.="<option value=''>- ".$_SESSION['STrad759']." -</option>";
    $Lecture.="<option value='ajou'>- ".$_SESSION['STrad758']." -</option>";
    $Lecture.="<option value='forfait1";if($action == "modif") {$Lecture.="|modif";} $Lecture.="'";if($num == "forfait1") {$Lecture.=" selected";}$Lecture.=">".$_SESSION['STrad227']."</option>";
    $Lecture.="<option value='forfait2";if($action == "modif") {$Lecture.="|modif";} $Lecture.="'";if($num == "forfait2") {$Lecture.=" selected";}$Lecture.=">".$_SESSION['STrad228']."</option>";
    $Lecture.="<option value='forfait3";if($action == "modif") {$Lecture.="|modif";} $Lecture.="'";if($num == "forfait3") {$Lecture.=" selected";}$Lecture.=">".$_SESSION['STrad229']."</option>";
    $Lecture.="<option value='forfait4";if($action == "modif") {$Lecture.="|modif";} $Lecture.="'";if($num == "forfait4") {$Lecture.=" selected";}$Lecture.=">".$_SESSION['STrad230']."</option>";

		return $Lecture;
	}
//*****************************************************************************************************************************

//**************** NOMBRE DE MOIS CALCULER EN JOUR *******************
function AffichNbMoisCalcJourSelect($num)
	{
		$Lecture.="<option value=''>- ".$_SESSION['STrad231']." -</option>";
		$Lecture.="<option value='30'";if($num == 30) {$Lecture.=" selected";}$Lecture.=">1 ".$_SESSION['STrad232']."</option>";
		$Lecture.="<option value='61'";if($num == 61) {$Lecture.=" selected";}$Lecture.=">2 ".$_SESSION['STrad232']."</option>";
		$Lecture.="<option value='91'";if($num == 91) {$Lecture.=" selected";}$Lecture.=">3 ".$_SESSION['STrad232']."</option>";
    $Lecture.="<option value='98'";if($num == 98) {$Lecture.=" selected";}$Lecture.=">14 ".$_SESSION['STrad233']."</option>";
    $Lecture.="<option value='122'";if($num == 122) {$Lecture.=" selected";}$Lecture.=">4 ".$_SESSION['STrad232']."</option>";
		$Lecture.="<option value='152'";if($num == 152) {$Lecture.=" selected";}$Lecture.=">5 ".$_SESSION['STrad232']."</option>";
		$Lecture.="<option value='183'";if($num == 183) {$Lecture.=" selected";}$Lecture.=">6 ".$_SESSION['STrad232']."</option>";
		$Lecture.="<option value='213'";if($num == 213) {$Lecture.=" selected";}$Lecture.=">7 ".$_SESSION['STrad232']."</option>";
		$Lecture.="<option value='244'";if($num == 244) {$Lecture.=" selected";}$Lecture.=">8 ".$_SESSION['STrad232']."</option>";
		$Lecture.="<option value='274'";if($num == 274) {$Lecture.=" selected";}$Lecture.=">9 ".$_SESSION['STrad232']."</option>";
		$Lecture.="<option value='305'";if($num == 305) {$Lecture.=" selected";}$Lecture.=">10 ".$_SESSION['STrad232']."</option>";
		$Lecture.="<option value='335'";if($num == 335) {$Lecture.=" selected";}$Lecture.=">11 ".$_SESSION['STrad232']."</option>";
		$Lecture.="<option value='366'";if($num == 366) {$Lecture.=" selected";}$Lecture.=">12 ".$_SESSION['STrad232']."</option>";

		return $Lecture;
	}
//*************************************************************************

//**************** PRESTATION FICHE COMPLET ********************************
function PrestationFicheComplet($Dossier,$ConnexionBdd,$typeprestnum)
  {
    $_SESSION['InputModiftypeprestnum'] = $typeprestnum;
    $req1 = 'SELECT * FROM typeprestation WHERE typeprestnum = "'.$typeprestnum.'"';
    $req1Result = $ConnexionBdd ->query($req1) or die ('Erreur SQL !'.$req1.'<br />'.mysqli_error());
    $req1Affich = $req1Result->fetch();

    if($_SESSION['ResolutionConnexion1'] <= 800) {$LibeButt = $_SESSION['STrad316'];}
    else {$LibeButt = $_SESSION['STrad155'];}
    $SousMenuCorp.="<div class='buttonBasMenuFixedRub'><a href='".$Dossier."modules/configuration/prestationPrestAjou_script.php?typeprestnum=".$typeprestnum."&typeprestsupp=2' class='LoadPage AffichePrestationComplet button buttonLittle'><img src='".$Dossier."images/supprimerBlanc.png' class='ImgSousMenu2'>".$LibeButt."</a></div>";
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



    $Lecture.="<section style='width:97%;display:block;clear:both;'>";
    $Lecture.="<div class='Partie50Gauche'>";
      $PrestCat = AfficheListePrestationsCategorie($Dossier,$ConnexionBdd,$req1Affich['typeprestation_categorie_typeprestcatnum'],1);
      $Lecture.="<select name='typeprestcatnum' class='champ_barre' onchange='FormModifTypePrestationCat(this.value)' required>".$PrestCat[1]."</select>";
      $req1Affich['typeprestlibe'] = str_replace("'"," ",$req1Affich['typeprestlibe']);
      $Lecture.="<input type='text' name='typeprestlibe' class='champ_barre' id='InputModif1' placeholder='".$_SESSION['STrad239']."' value='".$req1Affich['typeprestlibe']."' required>";
      $Lecture.="<textarea name='typeprestdesc' class='champ_barre' id='InputModif2' placeholder='".$_SESSION['STrad240']."'>".$req1Affich['typeprestdesc']."</textarea>";

      $Lecture.="<div style='width:100%;height:25px;'></div>";

      $Lecture.="<div class='InfoStandard FormInfoStandard1'><img src='".$Dossier."images/informationBlanc.png' class='imgSousMenu1' style='margin-right:10px;'>".$_SESSION['STrad235']."</div>";
      $Lecture.="<div id='AffichePrestationPrix'>";
      $Lecture.=AfficheTypePrestationPrix($Dossier,$ConnexionBdd,$typeprestnum);
      $Lecture.="</div>";
    $Lecture.="</div>";

    $Lecture.="<div class='Partie50Droite'>";
      $Lecture.="<table>";
      $Lecture.="<tr><td><div class='InfoStandard FormInfoStandard1'><img src='".$Dossier."images/informationBlanc.png' class='imgSousMenu1' style='margin-right:10px;'>".$_SESSION['STrad218']."</div></td></tr>";
      $Lecture.="<tr><td><select name='typeprestcat' class='champ_barre' onchange='AfficheTypePrestationModif(this.value)'>".AfficheTypePrestation($req1Affich['typeprestcat'],"modif")."</select></td></tr>";
      $Lecture.="<tr><td><div id='noteAfficheTypePrestationModif'>";
      if($req1Affich['typeprestcat'] == 1 OR $req1Affich['typeprestcat'] == 2)
        {
          $Lecture.="<select name='typeprestnbheurejour' class='champ_barre' onchange='AfficheTypePrestHeureValiditeModif(this.value)' required>".AfficheTypePrestHeureValidite($req1Affich['typeprestnbheurejour'],"modif")."</select>";
          $Lecture.="<div id='noteAfficheTypePrestHeureValiditeModif'>";
          if(!empty($req1Affich['typeprestnbheurejour']) AND $req1Affich['typeprestnbheurejour'] != "forfait1" AND $req1Affich['typeprestnbheurejour'] != "forfait2" AND $req1Affich['typeprestnbheurejour'] != "forfait3" AND $req1Affich['typeprestnbheurejour'] != "forfait4")
            {
              $req1Affich['typeprestnbheurejour'] = $req1Affich['typeprestnbheurejour'] / 60;
              $Lecture.="<input type='tel' class='champ_barre' name='typeprestnbheurejour' id='InputModif3' placeholder='".$_SESSION['STrad242']."' value='".$req1Affich['typeprestnbheurejour']."' required>";
              $Lecture.="<div class='InfoStandard FormInfoStandard1'>".$_SESSION['STrad243']."</div>";
              $Lecture.="<select name='typeprestvalidite' class='champ_barre' onchange='FormTypePrestationValiditeModif(this.value)' required>".AffichNbMoisCalcJourSelect($req1Affich['typeprestvalidite'])."</select>";
            }
          if($req1Affich['typeprestnbheurejour'] == "forfait1" OR $req1Affich['typeprestnbheurejour'] == "forfait2" OR $req1Affich['typeprestnbheurejour'] == "forfait3" OR $req1Affich['typeprestnbheurejour'] == "forfait4")
            {
              $Lecture.="<div class='InfoStandard FormInfoStandard1'>".$_SESSION['STrad244']."</div>";
              $Lecture.="<input type='date' name='typeprestvaldate1' class='champ_barre' style='width:50%;float:left;' onchange='FormTypePrestationValDate1Modif(this.value)' placeholder='".$_SESSION['STrad245']."' value='".$req1Affich['typeprestvaldate1']."' required>";
              $Lecture.="<input type='date' name='typeprestvaldate2' class='champ_barre' style='width:50%;float:left;' onchange='FormTypePrestationValDate2Modif(this.value)' placeholder='".$_SESSION['STrad246']."' value='".$req1Affich['typeprestvaldate2']."' required>";
            }
          $Lecture.="</div>";
        }

      $Lecture.="</div></td></tr>";
      $Lecture.="</table>";
    $Lecture.="</div>";
    $Lecture.="</section>";

    $Lecture.="<div style='height:100px;clear:both;display:block;width:100%;'></div>";

    return $Lecture;
  }
//*************************************************************************

//********************** AFFICHE PRIX DANS UNE PRESTATION ************************
function AfficheTypePrestationPrix($Dossier,$ConnexionBdd,$typeprestnum)
  {
    $Lecture.="<table class='tab_rubrique'>";
    $Lecture.="<thead><tr>";
      $Lecture.="<td>".$_SESSION['STrad236']."</td>";
      if($_SESSION['infologlang2'] != "ca")
        {
          $Lecture.="<td>".$_SESSION['STrad199']."</td>";
        }
      if($_SESSION['infologlang2'] == "fr") {$Lecture.="<td>".$_SESSION['STrad237']."</td>";}
      else if($_SESSION['infologlang2'] == "ca") {$Lecture.="<td>".$_SESSION['STrad329']."</td>";}
      $Lecture.="<td>".$_SESSION['STrad238']."</td>";
      $Lecture.="<td></td>";
    $Lecture.="<tr></thead>";
    $Lecture.="<tbody>";
    $req2 = 'SELECT * FROM typeprestation_prix WHERE typeprestation_typeprestnum = "'.$typeprestnum.'" AND typeprestprixsupp = "1"';
    $req2Result = $ConnexionBdd ->query($req2) or die ('Erreur SQL !'.$req2.'<br />'.mysqli_error());
    while($req2Affich = $req2Result->fetch())
      {
        $Lien = "<a href='".$Dossier."modules/configuration/prestationPrixModif.php?typeprestprixnum=".$req2Affich['typeprestprixnum']."' class='LoadPage AffichePrestationPrixModif'>";
        $Lecture.="<tr>";
          $Lecture.="<td>".$Lien.$req2Affich['typeprestprixprix']." ".$_SESSION['STrad27']."</a></td>";
          if($_SESSION['infologlang2'] != "ca")
            {
              $Lecture.="<td>".$Lien.AffichTauxTva($req2Affich['typeprestprixtva'])."</td>";
              // CALC PRIX TTC
              $PrixTtc = $PrixTtc + $req2Affich['typeprestprixprix'];
              // CALC PRIX HT
              $TvaCalc = $req2Affich['typeprestprixtva'] + 1;
              $PrixHtCalc = $req2Affich['typeprestprixprix'] / $TvaCalc;
              $PrixHt = $PrixHt + $PrixHtCalc;
            }
          if($_SESSION['infologlang2'] == "fr") {$Lecture.="<td>".$Lien.$req2Affich['typeprestprixlibe']."</td>";}
          if($_SESSION['infologlang2'] == "ca")
            {
              $Lecture.="<td>".$Lien;
                if($req2Affich['typeprestprixtaxe1'] == 2) {$Lecture.=$_SESSION['STrad330']."<br>";}
                if($req2Affich['typeprestprixtaxe2'] == 2) {$Lecture.=$_SESSION['STrad331']."<br>";}
              $Lecture.="</a></td>";
              // CALC PRIX HT
              $PrixHt = $req2Affich['typeprestprixprix'];
              // CALC PRIX TTC
              if($req2Affich['typeprestprixtaxe1'] == 2) {$MontantTPS = $req2Affich['typeprestprixprix'] * $_SESSION['confentrtaxe1'];}
      				if($req2Affich['typeprestprixtaxe2'] == 2) {$MontantTVQ = $req2Affich['typeprestprixprix'] * $_SESSION['confentrtaxe2'];}
      				$PrixTtc = $req2Affich['typeprestprixprix'] + $MontantTPS + $MontantTVQ;
            }
          $Lecture.="<td>".$Lien.$req2Affich['typeprestprixnumcompte']."</td>";
          $Lecture.="<td><a href='".$Dossier."modules/configuration/prestationPrix.php?typeprestnum=".$typeprestnum."&typeprestprixnum=".$req2Affich['typeprestprixnum']."&typeprestprixsupp=2' class='LoadPage AffichePrestationPrixSupp'><img src='".$Dossier."images/supprimer.png' class='ImgSousMenu2'></a></td>";
        $Lecture.="</tr>";
      }
    $Lecture.="<tr>";
      $PrixHt = number_format($PrixHt, 2, '.', '');
      $Lecture.="<td colspan='3'>".$_SESSION['STrad135']." : <b style='font-weight:bolder;'>".$PrixHt." ".$_SESSION['STrad27']."</b></td>";
      $PrixTtc = number_format($PrixTtc, 2, '.', '');
      $Lecture.="<td colspan='2'>".$_SESSION['STrad134']." : <b style='font-weight:bolder;'>".$PrixTtc." ".$_SESSION['STrad27']."</b></td>";
    $Lecture.="</tr>";
    $Lecture.="</tbody>";
    $Lecture.="<tr style='height:15px;'></tr>";
    $Lecture.="</table>";

    $Lecture.="<div style='height:10px;'></div>";
    $Lecture.="<a href='".$Dossier."modules/configuration/prestationAjouPrix.php?typeprestnum=".$typeprestnum."' class='LoadPage PrestationAjouPrix button buttonLittle2'><img src='".$Dossier."images/FlecheBasBlanc.png' class='ImgSousMenu2'>".$_SESSION['STrad247']."</a>";
    $Lecture.="<div class='FormInfoStandard' id='PrestationAjouPrix'>";
    $Lecture.="</div>";
    $Lecture.="<div style='height:15px;'></div>";

    return $Lecture;
  }
//*********************************************************************

//****************** AJOUTE RUN PRIX ********************************
function PrestationAjouPrix($Dossier,$ConnexionBdd,$typeprestnum)
  {
    $Lecture.="<div style='height:15px;'></div>";
    $Lecture.="<form id='FormAffichePrestationPrixAjou' action='' class='tab_rubrique'>";
    $Lecture.="<input type='hidden' name='action' value='ajou'>";
    $Lecture.="<input type='hidden' name='typeprestnum' value='".$typeprestnum."'>";
    if($_SESSION['infologlang2'] == "ca")
      {
        $Lecture.="<input type='tel' name='prixttc' placeholder='".$_SESSION['STrad134']."' class='champ_barre' style='width:50%;float:left;' required><input type='tel' name='numcompte1' class='champ_barre' style='width:50%;float:left;' placeholder='".$_SESSION['STrad238']."'>";
        $Lecture.="<input type='hidden' name='tauxtva1' value='0'>";
        $Lecture.="<input type='hidden' name='nbtaux' value='1'>";
        $Lecture.="<input name='typeprestprixtaxe1' type='checkbox' value='2' checked>".$_SESSION['STrad327']."";
        $Lecture.="<input name='typeprestprixtaxe2' type='checkbox' value='2' checked>".$_SESSION['STrad328']."";
      }
    else if($_SESSION['infologlang2'] == "fr")
      {
        $Lecture.="<div style='font-style:italic;'>".$_SESSION['STrad248']."</div>";
        $Lecture.="<div style='height:10px;'></div>";
        $Lecture.="<select name='nbtaux' class='champ_barre' onchange='AfficheNbTauxTvaAjou(this.value)'>".Compteur(3,2)."</select>";
        $Lecture.="<div id='noteAfficheNbTvaAjou'></div>";
      }
    else
      {
        $Lecture.="<input type='hidden' name='nbtaux' value='1'>";
        $Lecture.="<input type='tel' name='prixttc' placeholder='".$_SESSION['STrad134']."' class='champ_barre' style='width:33%;float:left;' required><select name='tauxtva1' class='champ_barre' style='width:32%;float:left;'>".AffichTauxTvaSelect()."</select> <input type='tel' name='numcompte1' class='champ_barre' style='width:33%;float:left;' placeholder='".$_SESSION['STrad238']."'>";
    	}
      $Lecture.="<div style='height:15px;'></div>";
      $Lecture.="<button class='button'><img src='".$Dossier."images/ajouterBlanc.png' class='ImgSousMenu2'>".$_SESSION['STrad160']."</button>";
    $Lecture.="</form>";

    return $Lecture;
  }
//*********************************************************************

//********************** DATE PASSAGE DEVIS ********************************
function conflogdatedevisSelect($Dossier,$Connexionbdd,$num)
  {
    $Lecture.="<option value='1'";if($num == 1) {$Lecture.=" selected";} $Lecture.=">".$_SESSION['STrad254']."</option>";
    $Lecture.="<option value='2'";if($num == 2) {$Lecture.=" selected";} $Lecture.=">".$_SESSION['STrad255']."</option>";

    return $Lecture;
  }
//****************************************************************************************

//********************** GENERE NB BROUILLON DE FACTURE ********************************
function conflogpassagenbfactureSelect($Dossier,$Connexionbdd,$num)
  {
    $Lecture.="<option value='1'";if($num == 1) {$Lecture.=" selected";} $Lecture.=">".$_SESSION['STrad256']."</option>";
    $Lecture.="<option value='2'";if($num == 2) {$Lecture.=" selected";} $Lecture.=">".$_SESSION['STrad257']."</option>";

    return $Lecture;
  }
//****************************************************************************************

//*************** LANGUE ***************************
function LangueVersion($version)
  {
    $Lecture.="<option value='fr'";if($version == "fr") {$Lecture.=" selected";} $Lecture.=">".$_SESSION['STrad350']."</option>";
    $Lecture.="<option value='ca'";if($version == "ca") {$Lecture.=" selected";} $Lecture.=">".$_SESSION['STrad351']."</option>";
    $Lecture.="<option value='es'";if($version == "es") {$Lecture.=" selected";} $Lecture.=">".$_SESSION['STrad352']."</option>";

    return $Lecture;
  }
//***************************************************

//*********** PÉRIODE DE VACANCE SCOLAIRE ***********************
function PeriodeVacanceScolaire($Dossier,$ConnexionBdd)
  {
    $Lecture.="<div class='InfoStandard FormInfoStandard1'><img src='".$Dossier."images/informationBlanc.png' class='imgSousMenu1' style='margin-right:10px;'>".$_SESSION['STrad458']."</div>";
    $Lecture.=$_SESSION['STrad460']."<br><br>";
    $Lecture.="<table>";
    $req1 = 'SELECT * FROM vacancesscolaires WHERE AA_equimondo_hebeappnum = "'.$_SESSION['hebeappnum'].'" ORDER BY vacascoldate1 ASC';
    $req1Result = $ConnexionBdd ->query($req1) or die ('Erreur SQL !'.$req1.'<br />'.mysqli_error());
    while($req1Affich = $req1Result->fetch())
      {
        $Lecture.="<tr>";
          $Lecture.="<td>".formatdatemysql($req1Affich['vacascoldate1'])."</td>";
          $Lecture.="<td><span style='margin-left:10px;'>".formatdatemysql($req1Affich['vacascoldate2'])."</span></td>";
          $Lecture.="<td><a href='".$Dossier."modules/configuration/vacancescolaire_script.php?vacascolnum=".$req1Affich['vacascolnum']."' class='LoadPage VacanceScolaire'><img src='".$Dossier."images/supprimer.png' class='ImgSousMenu2'></a></td>";
        $Lecture.="</tr>";
      }
    $Lecture.="</table>";

    $Lecture.="<div style='height:20px;width:100%;clear:both;display:block;'></div>";
    $Lecture.="<section style='width:100%;clear:both;display:block;'>";
    $Lecture.=$_SESSION['STrad461'];
    $Lecture.="<div style='height:20px;width:100%;clear:both;display:block;'></div>";
    $Lecture.="<a href='".$Dossier."modules/configuration/vacancescolaire_script.php?Associer=2' class='button buttonLittle LoadPage VacanceScolaire'><img src='".$Dossier."images/validerBlanc.png' class='ImgSousMenu2'>".$_SESSION['STrad462']."</a>";
    $Lecture.="</section>";
    $Lecture.="<div style='height:20px;'></div>";

    $Lecture.=$_SESSION['STrad459']." :<br>";
    $Lecture.="<form id='FormVacaScolAjou' action=''>";
    $Lecture.="<input type='date' name='date1' class='champ_barre' placeholder='".$Trad693."' style='float:left;width:50%;'>";
    $Lecture.="<input type='date' name='date2' class='champ_barre' placeholder='".$Trad694."' style='float:left;width:50%;'>";
    $Lecture.="<button class='button'><img src='".$Dossier."images/ajouterBlanc.png' class='ImgSousMenu2'>".$_SESSION['STrad160']."</button>";
    $Lecture.="</form>";

    return $Lecture;
  }
//***************************************************

//*************** CALENDRIER CATEGORIE *********************
function AfficheCaleCate($Dossier,$ConnexionBdd)
  {
    $Lecture.="<div class='InfoStandard FormInfoStandard1'><img src='".$Dossier."images/informationBlanc.png' class='imgSousMenu1' style='margin-right:10px;'>".$_SESSION['STrad730']."</div>";

    $Lecture.="<div style='height:20px;'></div>";
    $Lecture.="<table class='tab_rubrique'>";
    $req1 = 'SELECT * FROM calendrier_categorie WHERE AA_equimondo_hebeappnum = "'.$_SESSION['hebeappnum'].'" ORDER BY calecatelibe';
    $req1Result = $ConnexionBdd ->query($req1) or die ('Erreur SQL !'.$req1.'<br />'.mysqli_error());
    while($req1Affich = $req1Result->fetch())
      {
        $Lecture.="<tr>";
          $Lecture.="<td>".$req1Affich['calecatelibe']."</td>";
          $Lecture.="<td>".CalendrierCategorieTypeLect($req1Affich['calecatetype'])."</td>";
          $Lecture.="<td><a href='".$Dossier."modules/configuration/confmodifiercategorie.php?calecatenum=".$req1Affich['calecatenum']."' class='LoadPage CateCaleNumModif'><img src='".$Dossier."images/modifier.png' class='ImgSousMenu2'></a></td>";
        $Lecture.="</tr>";
      }
    $Lecture.="</table>";

    $Lecture.="<div style='height:20px;'></div>";
    $Lecture.="<form id='FormCaleCate' action=''>";
    $Lecture.="<input type='text' name='calecatlibe' class='champ_barre' placeholder = '".$_SESSION['STrad237']."' required>";
    $Lecture.="<select name='calecatetype' id='select3' required>".CalendrierCategorieType($num)."</select>";
    $Lecture.="<div style='height:10px;'></div>";
    $Lecture.="<button class='button'><img src='".$Dossier."images/ajouterBlanc.png' class='ImgSousMenu2'>".$_SESSION['STrad160']."</button>";
    $Lecture.="</form>";

    return $Lecture;
  }
//***************************************************

//*************** CALENDRIER CATEGORIE TYPEPRESTATION *********************
function AfficheCaleCateTypePrest($Dossier,$ConnexionBdd)
  {
    $Lecture.="<div class='InfoStandard FormInfoStandard1'><img src='".$Dossier."images/informationBlanc.png' class='imgSousMenu1' style='margin-right:10px;'>".$_SESSION['STrad727']."</div>";

    $Lecture.="<div style='height:20px;'></div>";
    $Lecture.="<table class='tab_rubrique'>";
    $req1 = 'SELECT * FROM calendrier_categorie_typeprestation WHERE AA_equimondo_hebeappnum = "'.$_SESSION['hebeappnum'].'"';
    $req1Result = $ConnexionBdd ->query($req1) or die ('Erreur SQL !'.$req1.'<br />'.mysqli_error());
    while($req1Affich = $req1Result->fetch())
      {
        $Lecture.="<tr>";
          $Lecture.="<td>".$_SESSION['STrad728']." <b>".TypePrestationLect($req1Affich['typeprestation_typeprestnum'],$ConnexionBdd)."</b> ".$_SESSION['STrad729']." <b>".CaleCateLect($req1Affich['calendrier_categorie_calecatenum'],$ConnexionBdd)."</b></td>";
          $Lecture.="<td><a href='".$Dossier."modules/configuration/CaleCateTypePrest_script.php?catecaletypeprestnum=".$req1Affich['catecaletypeprestnum']."' class='LoadPage CateCaleTypePrestNumSupp'><img src='".$Dossier."images/supprimer.png' class='ImgSousMenu2'></a></td>";
        $Lecture.="</tr>";
      }
    $Lecture.="</table>";

    $Lecture.="<div style='height:20px;'></div>";
    $Lecture.="<form id='FormCaleCateTypePrest' action=''>";
    $Lecture.="<select name='calecatenum' id='select8' required>".CaleCateSelect($Dossier,$ConnexionBdd,null)."</select>";
    $Lecture.="<select name='typeprestnum[]' id='select4' multiple required>".TypePrestSelect(null,null,$ConnexionBdd,null,null)."</select>";
    $Lecture.="<div style='height:10px;'></div>";
    $Lecture.="<button class='button'><img src='".$Dossier."images/ajouterBlanc.png' class='ImgSousMenu2'>".$_SESSION['STrad160']."</button>";
    $Lecture.="</form>";

    return $Lecture;
  }
//***************************************************

//*************** CALENDRIER CATEGORIE TYPEPRESTATION *********************
function AfficheCaleNiveau($Dossier,$ConnexionBdd)
  {
    $Lecture.="<div class='InfoStandard FormInfoStandard1'><img src='".$Dossier."images/informationBlanc.png' class='imgSousMenu1' style='margin-right:10px;'>".$_SESSION['STrad736']."</div>";

    $Lecture.="<div style='height:20px;'></div>";
    $Lecture.="<table class='tab_rubrique'>";
    $req1 = 'SELECT * FROM calendrier_niveau_configuration WHERE AA_equimondo_hebeappnum = "'.$_SESSION['hebeappnum'].'" ORDER BY caleniveconflibe ASC';
    $req1Result = $ConnexionBdd ->query($req1) or die ('Erreur SQL !'.$req1.'<br />'.mysqli_error());
    while($req1Affich = $req1Result->fetch())
      {
        $Lecture.="<tr>";
          $Lecture.="<td>".$req1Affich['caleniveconflibe']."</td>";
          $Lecture.="<td><a href='".$Dossier."modules/configuration/CaleNiveau_script.php?caleniveconfnum=".$req1Affich['caleniveconfnum']."' class='LoadPage CateNiveauNumSupp'><img src='".$Dossier."images/supprimer.png' class='ImgSousMenu2'></a></td>";
        $Lecture.="</tr>";
      }
    $Lecture.="</table>";

    $Lecture.="<div style='height:20px;'></div>";
    $Lecture.="<form id='FormCaleNiveau' action=''>";
    $Lecture.="<input type='text' name='caleniveconflibe[]' class='champ_barre' placeholder='".$_SESSION['STrad731']."' required>";
    $Lecture.="<input type='text' name='caleniveconflibe[]' class='champ_barre' placeholder='".$_SESSION['STrad731']."'>";
    $Lecture.="<input type='text' name='caleniveconflibe[]' class='champ_barre' placeholder='".$_SESSION['STrad731']."'>";
    $Lecture.="<div style='height:10px;'></div>";
    $Lecture.="<button class='button'><img src='".$Dossier."images/ajouterBlanc.png' class='ImgSousMenu2'>".$_SESSION['STrad160']."</button>";
    $Lecture.="</form>";

    return $Lecture;
  }
//***************************************************

//*************** CALENDRIER DISCIPLINE *********************
function AfficheCaleDiscipline($Dossier,$ConnexionBdd)
  {
    $Lecture.="<div class='InfoStandard FormInfoStandard1'><img src='".$Dossier."images/informationBlanc.png' class='imgSousMenu1' style='margin-right:10px;'>".$_SESSION['STrad770']."</div>";

    $Lecture.="<div style='height:20px;'></div>";
    $Lecture.="<table class='tab_rubrique'>";
    $req1 = 'SELECT * FROM calendrier_discipline_configuration WHERE AA_equimondo_hebeappnum = "'.$_SESSION['hebeappnum'].'" ORDER BY calediscconflibe ASC';
    $req1Result = $ConnexionBdd ->query($req1) or die ('Erreur SQL !'.$req1.'<br />'.mysqli_error());
    while($req1Affich = $req1Result->fetch())
      {
        $Lecture.="<tr>";
          $Lecture.="<td>".$req1Affich['calediscconflibe']."</td>";
          $Lecture.="<td><a href='".$Dossier."modules/configuration/CaleDiscipline_script.php?calediscconfnum=".$req1Affich['calediscconfnum']."' class='LoadPage CateDisciplineNumSupp'><img src='".$Dossier."images/supprimer.png' class='ImgSousMenu2'></a></td>";
        $Lecture.="</tr>";
      }
    $Lecture.="</table>";

    $Lecture.="<div style='height:20px;'></div>";
    $Lecture.="<form id='FormCaleDiscipline' action=''>";
    $Lecture.="<input type='text' name='calediscconflibe[]' class='champ_barre' placeholder='".$_SESSION['STrad771']."' required>";
    $Lecture.="<input type='text' name='calediscconflibe[]' class='champ_barre' placeholder='".$_SESSION['STrad771']."'>";
    $Lecture.="<input type='text' name='calediscconflibe[]' class='champ_barre' placeholder='".$_SESSION['STrad771']."'>";
    $Lecture.="<div style='height:10px;'></div>";
    $Lecture.="<button class='button'><img src='".$Dossier."images/ajouterBlanc.png' class='ImgSousMenu2'>".$_SESSION['STrad160']."</button>";
    $Lecture.="</form>";

    return $Lecture;
  }
//***************************************************

//********************** CAISSE CONFIGURATION LISTER PRESTATION********************************
function CalendrierUtilAcces($Dossier,$ConnexionBdd,$num)
  {
    $Lecture.="<option value='1'";if($num == 1) {$Lecture.=" selected";} $Lecture.=">".$_SESSION['STrad754']."</option>";
    $Lecture.="<option value='2'";if($num == 2) {$Lecture.=" selected";} $Lecture.=">".$_SESSION['STrad755']."</option>";

    return $Lecture;
  }
//****************************************************************************************

//********************** CAISSE CONFIGURATION LISTER PRESTATION********************************
function ConfigurationFactAutoGroupeChev($Dossier,$ConnexionBdd,$num)
  {
    $Lecture.="<option value='1'";if($num == 1) {$Lecture.=" selected";} $Lecture.=">".$_SESSION['STrad764']."</option>";
    $Lecture.="<option value='2'";if($num == 2) {$Lecture.=" selected";} $Lecture.=">".$_SESSION['STrad765']."</option>";

    return $Lecture;
  }
//****************************************************************************************

//********************** LISTE TOUS LES ENCAISSEMENTS*******************************
function ConfigurationDocuments($Dossier,$ConnexionBdd,$clienum,$chevnum,$calenum,$utilnum)
  {
    $req1 = 'SELECT * FROM documents_modeles WHERE AA_equimondo_hebeappnum = "'.$_SESSION['hebeappnum'].'" ORDER BY documoddateheure DESC';
    $req1Result = $ConnexionBdd ->query($req1) or die ('Erreur SQL !'.$req1.'<br />'.mysqli_error());
    while($req1Affich = $req1Result->fetch())
      {
        if($_SESSION['ResolutionConnexion1'] <= 800) {$Lien = "<a href='".$Dossier."modules/configuration/documentsFicheComplet1.php?documodnum=".$req1Affich['documodnum']."' class='LoadPage AfficheFicheDocumod1'>";}
				else {$Lien = "<a href='".$Dossier."modules/configuration/documentsFicheComplet2.php?documodnum=".$req1Affich['documodnum']."' class='LoadPage AfficheFicheDocumod2'>";}

        $Lecture.=$Lien;
        $Lecture.="<div style='width:100%;display:block;clear:both;'>";
        $Lecture.=$req1Affich['documodlibe'];

        $Lecture.="<div style='width:100%;display:block;clear:both;height:20px;'></div>";
        $Lecture.="<div style='width:100%;display:block;clear:both;'>";
        $Lecture.="<div style='width:29%;float:left;margin-right:1%;'>";
          $Lecture.=FormatDateTimeMySql($req1Affich['documoddateheure']);
        $Lecture.="</div>";

        $Lecture.="<div style='width:69%;float:left;margin-left:1%;'>";
          $Lecture.=ConfigurationDocumentsType($Dossier,$ConnexionBdd,$req1Affich['documodtype']);
        $Lecture.="</div>";
        $Lecture.="</div>";
        $Lecture.="</a>";
        $Lecture.="<div style='width:100%;display:block;clear:both;height:10px;'></div>";
      }

    return $Lecture;
  }
//****************************************************************************************

//********************** DOCUMENTS TYPE ********************************
function ConfigurationDocumentsType($Dossier,$ConnexionBdd,$num)
  {
    $Lecture.="<option value='1'";if($num == 1) {$Lecture.=" selected";} $Lecture.=">".$_SESSION['STrad776']."</option>";
    $Lecture.="<option value='2'";if($num == 2) {$Lecture.=" selected";} $Lecture.=">".$_SESSION['STrad777']."</option>";
    $Lecture.="<option value='3'";if($num == 3) {$Lecture.=" selected";} $Lecture.=">".$_SESSION['STrad778']."</option>";

    return $Lecture;
  }
function ConfigurationDocumentsTypeLect($Dossier,$ConnexionBdd,$num)
  {
    if($num == 1) {$Lecture.=$_SESSION['STrad776'];}
    if($num == 2) {$Lecture.=$_SESSION['STrad777'];}
    if($num == 3) {$Lecture.=$_SESSION['STrad778'];}

    return $Lecture;
  }
//****************************************************************************************

//****************************************************************************************
function conflognumerotationcompteclie($Dossier,$ConnexionBdd,$num)
  {
    $Lecture.="<option value='1'";if($num == 1) {$Lecture.=" selected";} $Lecture.=">".$_SESSION['STrad780']."</option>";
    $Lecture.="<option value='2'";if($num == 2) {$Lecture.=" selected";} $Lecture.=">".$_SESSION['STrad779']."</option>";

    return $Lecture;
  }
//****************************************************************************************

?>
