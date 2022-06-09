<?php
$Dossier = "../../";
session_start();
include $Dossier."modules/divers/connexionbdd.php";
include $Dossier."modules/function/allfunction.php";
include $Dossier."modules/function/allfunction_facturation.php";
include $Dossier."modules/function/allfunction_configuration.php";
include $Dossier."modules/function/allfunction_requete.php";
echo "test : ".$_POST['caletext13']."<br>";
if(!empty($_POST['caissyst2libe'])) {$Exec=2;$Resultat = SecureInput($_POST['caissyst2libe']);$KeyNum = $_SESSION['InputModifcaissyst2num'];$occurenceKey = "caissyst2num";  $Occurence = "caissyst2libe";$Table = "caissesysteme2";}
if(!empty($_POST['caissyst2prix'])) {$Exec=2;$Resultat = $_POST['caissyst2prix'];$KeyNum = $_SESSION['InputModifcaissyst2num'];$occurenceKey = "caissyst2num"; $Occurence = "caissyst2prix";$Table = "caissesysteme2";}
if(!empty($_POST['factprestlibe'])){$Exec=2;$Resultat = SecureInput($_POST['factprestlibe']);$KeyNum = $_SESSION['InputModiffactprestnum'];$occurenceKey = "factprestnum"; $Occurence = "factprestlibe";$Table = "factprestation";}
if(!empty($_GET['factprestdate'])){$Exec=2;$Resultat = $_GET['factprestdate'];$KeyNum = $_SESSION['InputModiffactprestnum'];$occurenceKey = "factprestnum"; $Occurence = "factprestdate";$Table = "factprestation";}
if(!empty($_POST['factprestprix']) OR !empty($_POST['factprestqte']) OR isset($_POST['factremise']))
  {
    $req = 'SELECT typeprestation_typeprestnum,facttype,factprestrempourc,factprestqte,factures.AA_equimondo_hebeappnum FROM factures,factprestation WHERE factures_factnum = factnum AND factprestnum = "'.$_SESSION['InputModiffactprestnum'].'"';
    $reqResult = $ConnexionBdd ->query($req) or die ('Erreur SQL !'.$req.'<br />'.mysqli_error());
		$reqAffich = $reqResult->fetch();

    $factprestprix = $_SESSION['InputModiffactprestprix'];

    if(!empty($_POST['factprestqte']))
      {
        $factprestqte = $_POST['factprestqte'];
        $factprestprixInit = $factprestprix - $_SESSION['InputModiffactremise'];
      }
    else {$factprestqte = $reqAffich['factprestqte'];}

    if(!empty($_POST['factprestprix']))
      {
        $_POST['factprestprix'] = str_replace (",",".",$_POST['factprestprix']);
        $factprestprix = $_POST['factprestprix'];
        $_SESSION['InputModiffactprestprix'] = $factprestprix;
        $factprestprixInit = ($factprestprix * $factprestqte) - $_SESSION['InputModiffactremise'];
      }

    if(isset($_POST['factremise']))
      {
        $_SESSION['InputModiffactremise'] = $_POST['factremise'];
        $factprestremmontant = $_POST['factremise'];
        $CalcRemise = $_POST['factremise'] / $factprestqte;
        $factprestprixInit = $factprestprix - $CalcRemise;
        $factprestprix = $factprestprixInit;
      }
    else {$factprestremmontant = $reqAffich['factprestremmontant'];}

    if(!empty($factprestremmontant))
      {
        $factprestremmontant2 = $factprestprix * $factprestqte;
        $factprestremmontant1 = $factprestremmontant2 - $factprestprixInit;
        $factprestrempourc1=$factprestremmontant * 100;
        $factprestrempourc = $factprestrempourc1 / $factprestprix;
      }
		else {$factprestrempourc = 0;$factprestremmontant=0;$factprestremmontant1=0;}

    if(isset($_POST['factremise']))
      {
        $req1 = 'UPDATE factprestation SET factprestrempourc="'.$factprestrempourc.'",factprestremmontant="'.$factprestremmontant.'" WHERE factprestnum = "'.$_SESSION['InputModiffactprestnum'].'"';
        $req1Result = $ConnexionBdd ->query($req1) or die ('Erreur SQL !'.$req1.'<br />'.mysqli_error());
      }
    if(!empty($_POST['factprestqte']))
      {
        $req1 = 'UPDATE factprestation SET factprestqte = "'.$factprestqte.'" WHERE factprestnum = "'.$_SESSION['InputModiffactprestnum'].'"';
        $req1Result = $ConnexionBdd ->query($req1) or die ('Erreur SQL !'.$req1.'<br />'.mysqli_error());
      }

    // INFO PRIX
    $reqInfoFactPrix = 'SELECT * FROM factprestation_prix WHERE factprestation_factprestnum = "'.$_SESSION['InputModiffactprestnum'].'"';
    $reqInfoFactPrixResult = $ConnexionBdd ->query($reqInfoFactPrix) or die ('Erreur SQL !'.$reqInfoFactPrix.'<br />'.mysqli_error());
    $reqInfoFactPrixAffich = $reqInfoFactPrixResult->fetch();

    $req1 = 'DELETE FROM factprestation_prix WHERE factprestation_factprestnum = "'.$_SESSION['InputModiffactprestnum'].'"';
    $req1Result = $ConnexionBdd ->query($req1) or die ('Erreur SQL !'.$req1.'<br />'.mysqli_error());

    if($_SESSION['infologlang2'] == "ca")
			{
        $factprestprixInit = $factprestprix;

        $req2 = 'SELECT typeprestprixtaxe1,typeprestprixtaxe2,typeprestprixnum FROM typeprestation_prix WHERE typeprestprixsupp= "1" AND typeprestprixnum = "'.$reqInfoFactPrixAffich['typeprestation_prix_typeprestprixnum'].'"';
        $req2Result = $ConnexionBdd ->query($req2) or die ('Erreur SQL !'.$req2.'<br />'.mysqli_error());
				$req2Affich = $req2Result->fetch();

        $reqConfEntr = 'SELECT * FROM confentr WHERE AA_equimondo_hebeappnum = "'.$reqAffich[4].'"';
        $reqConfEntrResult = $ConnexionBdd ->query($reqConfEntr) or die ('Erreur SQL !'.$reqConfEntr.'<br />'.mysqli_error());
				$reqConfEntrAffich = $reqConfEntrResult->fetch();

				$prestprixttcCalc = $factprestprix;
				if($req2Affich['typeprestprixtaxe1'] == 2) {$MontantTPS = $prestprixttcCalc * $reqConfEntrAffich['confentrtaxe1'];}
				if($req2Affich['typeprestprixtaxe2'] == 2) {$MontantTVQ = $prestprixttcCalc * $reqConfEntrAffich['confentrtaxe2'];}
				$MontantTTC = $prestprixttcCalc + $MontantTPS + $MontantTVQ;

			 	$MontantTPS = round($MontantTPS,"2");
			 	$MontantTVQ = round($MontantTVQ,"2");
			 	$MontantTTC = round($MontantTTC,"2");

				$req3 = 'INSERT INTO factprestation_prix VALUE (NULL,"'.$factprestprix.'","'.$_SESSION['confentrtaxe1'].'","'.$_SESSION['InputModiffactprestnum'].'","'.$MontantTPS.'","'.$MontantTTC.'","'.$req2Affich['typeprestprixnum'].'","'.$factprestprixInit.'","'.$factprestprix.'","'.$MontantTPS.'","'.$MontantTTC.'","'.$_SESSION['hebeappnum'].'","'.$_SESSION['confentrtaxe2'].'","'.$MontantTVQ.'")';
        $req3Result = $ConnexionBdd ->query($req3) or die ('Erreur SQL !'.$req3.'<br />'.mysqli_error());
      }
    else
      {
        // ENREGISTREMENT DES PRIX
    		$req1 = 'SELECT typeprestprixnum,typeprestprixprix,typeprestprixtva,typeprestprixlibe FROM typeprestation_prix WHERE typeprestprixsupp = "1" AND typeprestation_typeprestnum = "'.$reqAffich['typeprestation_typeprestnum'].'"';
        $req1Result = $ConnexionBdd ->query($req1) or die ('Erreur SQL !'.$req1.'<br />'.mysqli_error());
    		while($req1Affich = $req1Result->fetch())
    			{
            $Pourc = CalcPourcPrest($req1Affich[0],$ConnexionBdd);

    				$PrixTtcCalc1 = $factprestprixInit * $Pourc;
    				$PrixTtcCalc = $PrixTtcCalc1 * $factprestqte;

    				$IndTva = $req1Affich[2] + 1;
    				// Calcul du HT avant remise
    				$PrixHt = $PrixTtcCalc / $IndTva;

    				// Calcul de la TVA
    				$MontantTva = $PrixHt * $req1Affich[2];

    				$StatHt = $PrixHt;
    				$StatTva = $StatHt * $req1Affich[2];
    				$StatTtc = $StatHt + $StatTva;

    				$req3 = 'INSERT INTO factprestation_prix VALUE (NULL,"'.$PrixHt.'","'.$req1Affich[2].'","'.$_SESSION['InputModiffactprestnum'].'","'.$MontantTva.'","'.$PrixTtcCalc.'","'.$req1Affich[0].'","'.$PrixTtcCalc1.'","'.$StatHt.'","'.$StatTva.'","'.$StatTtc.'","'.$_SESSION['hebeappnum'].'",NULL,NULL)';
            $req3Result = $ConnexionBdd ->query($req3) or die ('Erreur SQL !'.$req3.'<br />'.mysqli_error());
    			}
      }

    $Exec = 1;
  }
// VERIF SI YA UNE ASSOCIATION DANS LA FACTURATION POUR UNE PRESTATION
if(!empty($_GET['factclienum1']) OR !empty($_GET['factclienum2']) OR !empty($_GET['factchevnum1']) OR !empty($_GET['factchevnum2']) OR !empty($_GET['factchevnum3']) OR !empty($_GET['factchevnum4']))
  {
    $reqVerif1 = 'SELECT count(factprestassonum) FROM factprestation_association WHERE factprestation_factprestnum = "'.$_SESSION['InputModiffactprestnum'].'"';
    $reqVerif1Result = $ConnexionBdd ->query($reqVerif1) or die ('Erreur SQL !'.$reqVerif1.'<br />'.mysqli_error());
		$reqVerif1Affich = $reqVerif1Result->fetch();
    if($reqVerif1Affich[0] == 0)
      {
        $req = 'INSERT INTO factprestation_association VALUE (NULL,NULL,NULL,"'.$_SESSION['InputModiffactprestnum'].'",NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL)';
        $reqResult = $ConnexionBdd ->query($req) or die ('Erreur SQL !'.$req.'<br />'.mysqli_error());
      }
    $Exec = 1;
  }
if(!empty($_GET['factclienum1'])){$Exec=2;$Resultat = $_GET['factclienum1'];$KeyNum = $_SESSION['InputModiffactprestnum'];$occurenceKey = "factprestation_factprestnum"; $Occurence = "clients_clienum";$Table = "factprestation_association";}
if(!empty($_GET['factclienum2'])){$Exec=2;$Resultat = $_GET['factclienum2'];$KeyNum = $_SESSION['InputModiffactprestnum'];$occurenceKey = "factprestation_factprestnum"; $Occurence = "clients_clienum1";$Table = "factprestation_association";}
if(!empty($_GET['factchevnum1'])){$Exec=2;$Resultat = $_GET['factchevnum1'];$KeyNum = $_SESSION['InputModiffactprestnum'];$occurenceKey = "factprestation_factprestnum"; $Occurence = "chevaux_chevnum";$Table = "factprestation_association";}
if(!empty($_GET['factchevnum2'])){$Exec=2;$Resultat = $_GET['factchevnum2'];$KeyNum = $_SESSION['InputModiffactprestnum'];$occurenceKey = "factprestation_factprestnum"; $Occurence = "chevaux_chevnum1";$Table = "factprestation_association";}
if(!empty($_GET['factchevnum3'])){$Exec=2;$Resultat = $_GET['factchevnum3'];$KeyNum = $_SESSION['InputModiffactprestnum'];$occurenceKey = "factprestation_factprestnum"; $Occurence = "chevaux_chevnum2";$Table = "factprestation_association";}
if(!empty($_GET['factchevnum4'])){$Exec=2;$Resultat = $_GET['factchevnum4'];$KeyNum = $_SESSION['InputModiffactprestnum'];$occurenceKey = "factprestation_factprestnum"; $Occurence = "chevaux_chevnum3";$Table = "factprestation_association";}
if(!empty($_POST['cliesoldforfentrnbheure'])){$Exec=2;$Resultat = $_POST['cliesoldforfentrnbheure'] * 60;$KeyNum = $_SESSION['InputModiffactprestnum'];$occurenceKey = "factprestation_factprestnum"; $Occurence = "factprestassonbheure";$Table = "factprestation_association";}
if(!empty($_GET['factprestassodate1'])){$Exec=2;$Resultat = $_GET['factprestassodate1'];$KeyNum = $_SESSION['InputModiffactprestnum'];$occurenceKey = "factprestation_factprestnum"; $Occurence = "factprestassodate1";$Table = "factprestation_association";}
if(!empty($_GET['factprestassodate2'])){$Exec=2;$Resultat = $_GET['factprestassodate2'];$KeyNum = $_SESSION['InputModiffactprestnum'];$occurenceKey = "factprestation_factprestnum"; $Occurence = "factprestassodate2";$Table = "factprestation_association";}
if(isset($_POST['confentrnom'])){$Exec=2;$Resultat = SecureInput($_POST['confentrnom']);$KeyNum = $_SESSION['hebeappnum'];$occurenceKey = "AA_equimondo_hebeappnum"; $Occurence = "confentrnom";$Table = "confentr";}
if(isset($_GET['confentrdatecrea'])){$Exec=2;$Resultat = $_GET['confentrdatecrea'];$KeyNum = $_SESSION['hebeappnum'];$occurenceKey = "AA_equimondo_hebeappnum"; $Occurence = "confentrdatecrea";$Table = "confentr";}
if(isset($_POST['confentrnomdirec'])){$Exec=2;$Resultat = SecureInput($_POST['confentrnomdirec']);$KeyNum = $_SESSION['hebeappnum'];$occurenceKey = "AA_equimondo_hebeappnum"; $Occurence = "confentrnomdirec";$Table = "confentr";}
if(isset($_POST['confentrprendirec'])){$Exec=2;$Resultat = SecureInput($_POST['confentrprendirec']);$KeyNum = $_SESSION['hebeappnum'];$occurenceKey = "AA_equimondo_hebeappnum"; $Occurence = "confentrprendirec";$Table = "confentr";}
if(isset($_POST['confentradres'])){$Exec=2;$Resultat = SecureInput($_POST['confentradres']);$KeyNum = $_SESSION['hebeappnum'];$occurenceKey = "AA_equimondo_hebeappnum"; $Occurence = "confentradres";$Table = "confentr";}
if(isset($_POST['confentrcp'])){$Exec=2;$Resultat = SecureInput($_POST['confentrcp']);$KeyNum = $_SESSION['hebeappnum'];$occurenceKey = "AA_equimondo_hebeappnum"; $Occurence = "confentrcp";$Table = "confentr";}
if(isset($_POST['confentrville'])){$Exec=2;$Resultat = SecureInput($_POST['confentrville']);$KeyNum = $_SESSION['hebeappnum'];$occurenceKey = "AA_equimondo_hebeappnum"; $Occurence = "confentrville";$Table = "confentr";}
if(isset($_POST['confentrtel'])){$Exec=2;$Resultat = $_POST['confentrtel'];$KeyNum = $_SESSION['hebeappnum'];$occurenceKey = "AA_equimondo_hebeappnum"; $Occurence = "confentrtel";$Table = "confentr";}
if(isset($_POST['confentrfax'])){$Exec=2;$Resultat = $_POST['confentrfax'];$KeyNum = $_SESSION['hebeappnum'];$occurenceKey = "AA_equimondo_hebeappnum"; $Occurence = "confentrfax";$Table = "confentr";}
if(isset($_POST['confentradresmail'])){$Exec=2;$Resultat = $_POST['confentradresmail'];$KeyNum = $_SESSION['hebeappnum'];$occurenceKey = "AA_equimondo_hebeappnum"; $Occurence = "confentradresmail";$Table = "confentr";}
if(isset($_POST['confentrurl'])){$Exec=2;$Resultat = $_POST['confentrurl'];$KeyNum = $_SESSION['hebeappnum'];$occurenceKey = "AA_equimondo_hebeappnum"; $Occurence = "confentrurl";$Table = "confentr";}
if(isset($_POST['confentrsiret'])){$Exec=2;$Resultat = $_POST['confentrsiret'];$KeyNum = $_SESSION['hebeappnum'];$occurenceKey = "AA_equimondo_hebeappnum"; $Occurence = "confentrsiret";$Table = "confentr";}
if(isset($_POST['confentrcodeape'])){$Exec=2;$Resultat = $_POST['confentrcodeape'];$KeyNum = $_SESSION['hebeappnum'];$occurenceKey = "AA_equimondo_hebeappnum"; $Occurence = "confentrcodeape";$Table = "confentr";}
if(isset($_POST['confentrintratva'])){$Exec=2;$Resultat = $_POST['confentrintratva'];$KeyNum = $_SESSION['hebeappnum'];$occurenceKey = "AA_equimondo_hebeappnum"; $Occurence = "confentrintratva";$Table = "confentr";}
if(isset($_POST['confentrdomiciliation'])){$Exec=2;$Resultat = SecureInput($_POST['confentrdomiciliation']);$KeyNum = $_SESSION['hebeappnum'];$occurenceKey = "AA_equimondo_hebeappnum"; $Occurence = "confentrdomiciliation";$Table = "confentr";}
if(isset($_POST['confentrbic'])){$Exec=2;$Resultat = $_POST['confentrbic'];$KeyNum = $_SESSION['hebeappnum'];$occurenceKey = "AA_equimondo_hebeappnum"; $Occurence = "confentrbic";$Table = "confentr";}
if(isset($_POST['confentriban1'])){$Exec=2;$Resultat = $_POST['confentriban1'];$KeyNum = $_SESSION['hebeappnum'];$occurenceKey = "AA_equimondo_hebeappnum"; $Occurence = "confentriban1";$Table = "confentr";}
if(isset($_POST['confentrdenosocial'])){$Exec=2;$Resultat = SecureInput($_POST['confentrdenosocial']);$KeyNum = $_SESSION['hebeappnum'];$occurenceKey = "AA_equimondo_hebeappnum"; $Occurence = "confentrdenosocial";$Table = "confentr";}
if(isset($_POST['confentrcapital'])){$Exec=2;$Resultat = SecureInput($_POST['confentrcapital']);$KeyNum = $_SESSION['hebeappnum'];$occurenceKey = "AA_equimondo_hebeappnum"; $Occurence = "confentrcapital";$Table = "confentr";}
if(isset($_POST['confentrsiren'])){$Exec=2;$Resultat = SecureInput($_POST['confentrsiren']);$KeyNum = $_SESSION['hebeappnum'];$occurenceKey = "AA_equimondo_hebeappnum"; $Occurence = "confentrsiren";$Table = "confentr";}
if(isset($_POST['confentrrcs'])){$Exec=2;$Resultat = SecureInput($_POST['confentrrcs']);$KeyNum = $_SESSION['hebeappnum'];$occurenceKey = "AA_equimondo_hebeappnum"; $Occurence = "confentrrcs";$Table = "confentr";}
if(isset($_POST['confentrvillegreffe'])){$Exec=2;$Resultat = SecureInput($_POST['confentrvillegreffe']);$KeyNum = $_SESSION['hebeappnum'];$occurenceKey = "AA_equimondo_hebeappnum"; $Occurence = "confentrvillegreffe";$Table = "confentr";}
if(isset($_POST['confentrtaxe1'])){$_POST['confentrtaxe1'] = str_replace(",",".",$_POST['confentrtaxe1']);$_POST['confentrtaxe1'] = $_POST['confentrtaxe1'] / 100;$Exec=2;$Resultat = SecureInput($_POST['confentrtaxe1']);$KeyNum = $_SESSION['hebeappnum'];$occurenceKey = "AA_equimondo_hebeappnum"; $Occurence = "confentrtaxe1";$Table = "confentr";}
if(isset($_POST['confentrtaxe2'])){$_POST['confentrtaxe2'] = str_replace(",",".",$_POST['confentrtaxe2']);$_POST['confentrtaxe2'] = $_POST['confentrtaxe2'] / 100;$Exec=2;$Resultat = SecureInput($_POST['confentrtaxe2']);$KeyNum = $_SESSION['hebeappnum'];$occurenceKey = "AA_equimondo_hebeappnum"; $Occurence = "confentrtaxe2";$Table = "confentr";}
if(isset($_POST['factcondition'])){$Exec=2;$Resultat = SecureInput($_POST['factcondition']);$KeyNum = $_SESSION['InputModiffactnum'];$occurenceKey = "factnum"; $Occurence = "factcondition";$Table = "factures";}
if(isset($_POST['conflograppelfact'])){$Exec=2;$Resultat = SecureInput($_POST['conflograppelfact']);$KeyNum = $_SESSION['hebeappnum'];$occurenceKey = "AA_equimondo_hebeappnum"; $Occurence = "conflograppelfact";$Table = "conflogiciel";}
if(isset($_GET['conflogdateexercice1'])){$Exec=2;$Resultat = SecureInput($_GET['conflogdateexercice1']);$KeyNum = $_SESSION['hebeappnum'];$occurenceKey = "AA_equimondo_hebeappnum"; $Occurence = "conflogdateexercice1";$Table = "conflogiciel";}
if(isset($_GET['conflogdateexercice2'])){$Exec=2;$Resultat = SecureInput($_GET['conflogdateexercice2']);$KeyNum = $_SESSION['hebeappnum'];$occurenceKey = "AA_equimondo_hebeappnum"; $Occurence = "conflogdateexercice2";$Table = "conflogiciel";}
if(isset($_GET['conflogfactprefixe'])){$Exec=2;$Resultat = SecureInput($_GET['conflogfactprefixe']);$KeyNum = $_SESSION['hebeappnum'];$occurenceKey = "AA_equimondo_hebeappnum"; $Occurence = "conflogfactprefixe";$Table = "conflogiciel";}
if(isset($_POST['conflogsoldcaisse'])){$Exec=2;$Resultat = SecureInput($_POST['conflogsoldcaisse']);$KeyNum = $_SESSION['hebeappnum'];$occurenceKey = "AA_equimondo_hebeappnum"; $Occurence = "conflogsoldcaisse";$Table = "conflogiciel";}
if(isset($_POST['conflogcondfact'])){$Exec=2;$Resultat = SecureInput($_POST['conflogcondfact']);$KeyNum = $_SESSION['hebeappnum'];$occurenceKey = "AA_equimondo_hebeappnum"; $Occurence = "conflogcondfact";$Table = "conflogiciel";}
if(isset($_GET['conflogdatedevis'])){$Exec=2;$Resultat = SecureInput($_GET['conflogdatedevis']);$KeyNum = $_SESSION['hebeappnum'];$occurenceKey = "AA_equimondo_hebeappnum"; $Occurence = "conflogdatedevis";$Table = "conflogiciel";}
if(isset($_GET['conflogpassagenbfacture'])){$Exec=2;$Resultat = SecureInput($_GET['conflogpassagenbfacture']);$KeyNum = $_SESSION['hebeappnum'];$occurenceKey = "AA_equimondo_hebeappnum"; $Occurence = "conflogpassagenbfacture";$Table = "conflogiciel";}
if(isset($_GET['conflogpassagefactparchevaux'])){$Exec=2;$Resultat = SecureInput($_GET['conflogpassagefactparchevaux']);$KeyNum = $_SESSION['hebeappnum'];$occurenceKey = "AA_equimondo_hebeappnum"; $Occurence = "conflogpassagefactparchevaux";$Table = "conflogiciel";}
if(isset($_POST['conflogmessfactnonpayer'])){$Exec=2;$Resultat = SecureInput($_POST['conflogmessfactnonpayer']);$KeyNum = $_SESSION['hebeappnum'];$occurenceKey = "AA_equimondo_hebeappnum"; $Occurence = "conflogmessfactnonpayer";$Table = "conflogiciel";}
if(isset($_POST['conflogmessagefactauto'])){$Exec=2;$Resultat = SecureInput($_POST['conflogmessagefactauto']);$KeyNum = $_SESSION['hebeappnum'];$occurenceKey = "AA_equimondo_hebeappnum"; $Occurence = "conflogmessagefactauto";$Table = "conflogiciel";}
if(isset($_GET['conflogcliecotisation'])){$Exec=2;$Resultat = SecureInput($_GET['conflogcliecotisation']);$KeyNum = $_SESSION['hebeappnum'];$occurenceKey = "AA_equimondo_hebeappnum"; $Occurence = "conflogcliecotisation";$Table = "conflogiciel";}
if(isset($_GET['caisseclients1'])) {$Exec=2;$Resultat = $_GET['caisseclients1'];$KeyNum = $_SESSION['InputModifcaissyst2num'];$occurenceKey = "caissyst2num";$Occurence = "clients_clienum1";$Table = "caissesysteme2";}
if(isset($_GET['caisseclients2'])) {$Exec=2;$Resultat = $_GET['caisseclients2'];$KeyNum = $_SESSION['InputModifcaissyst2num'];$occurenceKey = "caissyst2num";$Occurence = "clients_clienum2";$Table = "caissesysteme2";}
if(isset($_GET['conflogcaisseafficheprestations'])){$Exec=2;$Resultat = SecureInput($_GET['conflogcaisseafficheprestations']);$KeyNum = $_SESSION['hebeappnum'];$occurenceKey = "AA_equimondo_hebeappnum"; $Occurence = "conflogcaisseafficheprestations";$Table = "conflogiciel";}
if(isset($_GET['conflogreservation'])){$Exec=2;$Resultat = SecureInput($_GET['conflogreservation']);$KeyNum = $_SESSION['hebeappnum'];$occurenceKey = "AA_equimondo_hebeappnum"; $Occurence = "conflogreservation";$Table = "conflogiciel";}
if(isset($_GET['conflogicielaccesniveau'])){$Exec=2;$Resultat = SecureInput($_GET['conflogicielaccesniveau']);$KeyNum = $_SESSION['hebeappnum'];$occurenceKey = "AA_equimondo_hebeappnum"; $Occurence = "conflogicielaccesniveau";$Table = "conflogiciel";}
if(isset($_GET['conflogvisionheurerestante'])){$Exec=2;$Resultat = SecureInput($_GET['conflogvisionheurerestante']);$KeyNum = $_SESSION['hebeappnum'];$occurenceKey = "AA_equimondo_hebeappnum"; $Occurence = "conflogvisionheurerestante";$Table = "conflogiciel";}
if(isset($_GET['conflogcaleutilacces'])){$Exec=2;$Resultat = SecureInput($_GET['conflogcaleutilacces']);$KeyNum = $_SESSION['hebeappnum'];$occurenceKey = "AA_equimondo_hebeappnum"; $Occurence = "conflogcaleutilacces";$Table = "conflogiciel";}
if(isset($_GET['conflognumerotationcompteclie'])){$Exec=2;$Resultat = SecureInput($_GET['conflognumerotationcompteclie']);$KeyNum = $_SESSION['hebeappnum'];$occurenceKey = "AA_equimondo_hebeappnum"; $Occurence = "conflognumerotationcompteclie";$Table = "conflogiciel";}
if(isset($_POST['typeprestlibe'])) {$Exec=2;$Resultat = SecureInput($_POST['typeprestlibe']);$KeyNum = $_SESSION['InputModiftypeprestnum'];$occurenceKey = "typeprestnum"; $Occurence = "typeprestlibe";$Table = "typeprestation";}
if(isset($_POST['typeprestdesc'])) {$Exec=2;$Resultat = SecureInput($_POST['typeprestdesc']);$KeyNum = $_SESSION['InputModiftypeprestnum'];$occurenceKey = "typeprestnum"; $Occurence = "typeprestdesc";$Table = "typeprestation";}
if(isset($_GET['typeprestation_categorie_typeprestcatnum'])) {$Exec=2;$Resultat = SecureInput($_GET['typeprestation_categorie_typeprestcatnum']);$KeyNum = $_SESSION['InputModiftypeprestnum'];$occurenceKey = "typeprestnum"; $Occurence = "typeprestation_categorie_typeprestcatnum";$Table = "typeprestation";}
if(isset($_POST['typeprestprixprix'])) {$Exec=2;$Resultat = SecureInput($_POST['typeprestprixprix']);$KeyNum = $_SESSION['InputModiftypeprestprixnum'];$occurenceKey = "typeprestprixnum"; $Occurence = "typeprestprixprix";$Table = "typeprestation_prix";}
if(isset($_POST['typeprestprixlibe'])) {$Exec=2;$Resultat = SecureInput($_POST['typeprestprixlibe']);$KeyNum = $_SESSION['InputModiftypeprestprixnum'];$occurenceKey = "typeprestprixnum"; $Occurence = "typeprestprixlibe";$Table = "typeprestation_prix";}
if(isset($_POST['typeprestprixnumcompte'])) {$Exec=2;$Resultat = SecureInput($_POST['typeprestprixnumcompte']);$KeyNum = $_SESSION['InputModiftypeprestprixnum'];$occurenceKey = "typeprestprixnum"; $Occurence = "typeprestprixnumcompte";$Table = "typeprestation_prix";}
if(isset($_GET['typeprestprixtva'])) {$Exec=2;$Resultat = SecureInput($_GET['typeprestprixtva']);$KeyNum = $_SESSION['InputModiftypeprestprixnum'];$occurenceKey = "typeprestprixnum"; $Occurence = "typeprestprixtva";$Table = "typeprestation_prix";}
if(isset($_GET['typeprestprixtaxe1'])) {$Exec=2;$Resultat = SecureInput($_GET['typeprestprixtaxe1']);$KeyNum = $_SESSION['InputModiftypeprestprixnum'];$occurenceKey = "typeprestprixnum"; $Occurence = "typeprestprixtaxe1";$Table = "typeprestation_prix";}
if(isset($_GET['typeprestprixtaxe2'])) {$Exec=2;$Resultat = SecureInput($_GET['typeprestprixtaxe2']);$KeyNum = $_SESSION['InputModiftypeprestprixnum'];$occurenceKey = "typeprestprixnum"; $Occurence = "typeprestprixtaxe2";$Table = "typeprestation_prix";}
if(isset($_POST['typeprestnbheurejour'])) {$Exec=2;$Resultat = SecureInput($_POST['typeprestnbheurejour']);$Resultat = $Resultat * 60;$KeyNum = $_SESSION['InputModiftypeprestnum'];$occurenceKey = "typeprestnum"; $Occurence = "typeprestnbheurejour";$Table = "typeprestation";}
if(isset($_GET['typeprestvalidite'])) {$Exec=2;$Resultat = SecureInput($_GET['typeprestvalidite']);$KeyNum = $_SESSION['InputModiftypeprestnum'];$occurenceKey = "typeprestnum"; $Occurence = "typeprestvalidite";$Table = "typeprestation";}
if(isset($_GET['typeprestvaldate1'])) {$Exec=2;$Resultat = SecureInput($_GET['typeprestvaldate1']);$KeyNum = $_SESSION['InputModiftypeprestnum'];$occurenceKey = "typeprestnum"; $Occurence = "typeprestvaldate1";$Table = "typeprestation";}
if(isset($_GET['typeprestvaldate2'])) {$Exec=2;$Resultat = SecureInput($_GET['typeprestvaldate2']);$KeyNum = $_SESSION['InputModiftypeprestnum'];$occurenceKey = "typeprestnum"; $Occurence = "typeprestvaldate2";$Table = "typeprestation";}
if(isset($_POST['typeprestcatlibe'])) {$Exec=2;$Resultat = SecureInput($_POST['typeprestcatlibe']);$KeyNum = $_SESSION['InputModiftypeprestcatnum'];$occurenceKey = "typeprestcatnum"; $Occurence = "typeprestcatlibe";$Table = "typeprestation_categorie";}
if(isset($_GET['calecatenum'])) {$Exec=2;$Resultat = SecureInput($_GET['calecatenum']);$KeyNum = $_SESSION['InputModifcalenum'];$occurenceKey = "calenum"; $Occurence = "calendrier_categorie_calecatenum";$Table = "calendrier";}
if(isset($_GET['caleutilnum'])) {$Exec=2;$Resultat = SecureInput($_GET['caleutilnum']);$KeyNum = $_SESSION['InputModifcalenum'];$occurenceKey = "calenum"; $Occurence = "utilisateurs_utilnum";$Table = "calendrier";}
if(isset($_POST['caletext13'])) {$Exec=2;$Resultat = SecureInput($_POST['caletext13']);$KeyNum = $_SESSION['InputModifcalenum'];$occurenceKey = "calenum"; $Occurence = "caletext13";$Table = "calendrier";}
if(isset($_GET['caletext14'])) {$Exec=2;$Resultat = SecureInput($_GET['caletext14']);$KeyNum = $_SESSION['InputModifcalenum'];$occurenceKey = "calenum"; $Occurence = "caletext14";$Table = "calendrier";}
if(isset($_GET['caletext15'])) {$Exec=2;$Resultat = SecureInput($_GET['caletext15']);$KeyNum = $_SESSION['InputModifcalenum'];$occurenceKey = "calenum"; $Occurence = "caletext15";$Table = "calendrier";}
if(isset($_POST['caletext16'])) {$Exec=2;$Resultat = SecureInput($_POST['caletext16']);$KeyNum = $_SESSION['InputModifcalenum'];$occurenceKey = "calenum"; $Occurence = "caletext16";$Table = "calendrier";}
if(isset($_GET['caletext7'])) {$Exec=2;$Resultat = SecureInput($_GET['caletext7']);$KeyNum = $_SESSION['InputModifcalenum'];$occurenceKey = "calenum"; $Occurence = "caletext7";$Table = "calendrier";}
if(isset($_GET['caletext8'])) {$Exec=2;$Resultat = $_GET['caletext8'];$KeyNum = $_SESSION['InputModifcalenum'];$occurenceKey = "calenum"; $Occurence = "caletext8";$Table = "calendrier";}
if(isset($_POST['caletext2'])) {$Exec=2;$Resultat = SecureInput($_POST['caletext2']);$KeyNum = $_SESSION['InputModifcalenum'];$occurenceKey = "calenum"; $Occurence = "caletext2";$Table = "calendrier";}
if(isset($_GET['caletext1'])) {$Exec=2;$Resultat = SecureInput($_GET['caletext1']);$KeyNum = $_SESSION['InputModifcalenum'];$occurenceKey = "calenum"; $Occurence = "caletext1";$Table = "calendrier";}
if(isset($_GET['caletext9'])) {$Exec=2;$Resultat = SecureInput($_GET['caletext9']);$KeyNum = $_SESSION['InputModifcalenum'];$occurenceKey = "calenum"; $Occurence = "caletext9";$Table = "calendrier";}
if(isset($_GET['caledate1']))
  {
    $Exec=2;$Resultat = SecureInput($_GET['caledate1']);
    $KeyNum = $_SESSION['InputModifcalenum'];
    $req1 = 'SELECT * FROM calendrier WHERE calenum = "'.$KeyNum.'"';
    $req1Result = $ConnexionBdd ->query($req1) or die ('Erreur SQL !'.$req1.'<br />'.mysqli_error());
    $req1Affich = $req1Result->fetch();
    $DateCalc = formatheure1($req1Affich['caledate1']);
    $Resultat = $Resultat." ".$DateCalc[0].":".$DateCalc[1].":".$DateCalc[2];
    $occurenceKey = "calenum";
    $Occurence = "caledate1";
    $Table = "calendrier";
  }
if(isset($_POST['caleheure1']))
  {
    $Exec=2;$Resultat = SecureInput($_POST['caleheure1']);
    $KeyNum = $_SESSION['InputModifcalenum'];
    $req1 = 'SELECT * FROM calendrier WHERE calenum = "'.$KeyNum.'"';
    $req1Result = $ConnexionBdd ->query($req1) or die ('Erreur SQL !'.$req1.'<br />'.mysqli_error());
    $req1Affich = $req1Result->fetch();
    $DateCalc = formatheure1($req1Affich['caledate1']);
    $Resultat = $DateCalc[3]."-".$DateCalc[4]."-".$DateCalc[5]." ".$Resultat.":00";
    $occurenceKey = "calenum";
    $Occurence = "caledate1";
    $Table = "calendrier";
  }
if(isset($_POST['caleheure2']))
  {
    $Exec=2;$Resultat = SecureInput($_POST['caleheure2']);
    $KeyNum = $_SESSION['InputModifcalenum'];
    $req1 = 'SELECT * FROM calendrier WHERE calenum = "'.$KeyNum.'"';
    $req1Result = $ConnexionBdd ->query($req1) or die ('Erreur SQL !'.$req1.'<br />'.mysqli_error());
    $req1Affich = $req1Result->fetch();
    $DateCalc = formatheure1($req1Affich['caledate2']);
    $Resultat = $DateCalc[3]."-".$DateCalc[4]."-".$DateCalc[5]." ".$Resultat.":00";
    $occurenceKey = "calenum";
    $Occurence = "caledate2";
    $Table = "calendrier";

    echo "tesrt : ".$_POST['caleheure2']."<br>";
  }

if(isset($_POST['clienometablissement'])) {$Exec=2;$Resultat = SecureInput($_POST['clienometablissement']);$KeyNum = $_SESSION['InputModifclienum'];$occurenceKey = "clienum"; $Occurence = "clienometablissement";$Table = "clients";}
if(isset($_POST['cliesiret'])) {$Exec=2;$Resultat = SecureInput($_POST['cliesiret']);$KeyNum = $_SESSION['InputModifclienum'];$occurenceKey = "clienum"; $Occurence = "cliesiret";$Table = "clients";}
if(isset($_POST['clietvaintra'])) {$Exec=2;$Resultat = SecureInput($_POST['clietvaintra']);$KeyNum = $_SESSION['InputModifclienum'];$occurenceKey = "clienum"; $Occurence = "clietvaintra";$Table = "clients";}
if(isset($_POST['clienom'])) {$Exec=2;$Resultat = SecureInput($_POST['clienom']);$KeyNum = $_SESSION['InputModifclienum'];$occurenceKey = "clienum"; $Occurence = "clienom";$Table = "clients";}
if(isset($_POST['clieprenom'])) {$Exec=2;$Resultat = SecureInput($_POST['clieprenom']);$KeyNum = $_SESSION['InputModifclienum'];$occurenceKey = "clienum"; $Occurence = "clieprenom";$Table = "clients";}
if(isset($_POST['clieadre'])) {$Exec=2;$Resultat = SecureInput($_POST['clieadre']);$KeyNum = $_SESSION['InputModifclienum'];$occurenceKey = "clienum"; $Occurence = "clieadre";$Table = "clients";}
if(isset($_POST['cliecp'])) {$Exec=2;$Resultat = SecureInput($_POST['cliecp']);$KeyNum = $_SESSION['InputModifclienum'];$occurenceKey = "clienum"; $Occurence = "cliecp";$Table = "clients";}
if(isset($_POST['clieville'])) {$Exec=2;$Resultat = SecureInput($_POST['clieville']);$KeyNum = $_SESSION['InputModifclienum'];$occurenceKey = "clienum"; $Occurence = "clieville";$Table = "clients";}
if(isset($_GET['cliepays'])) {$Exec=2;$Resultat = SecureInput($_GET['cliepays']);$KeyNum = $_SESSION['InputModifclienum'];$occurenceKey = "clienum"; $Occurence = "cliepays";$Table = "clients";}
if(isset($_GET['cliedatenaiss'])) {$Exec=2;$Resultat = SecureInput($_GET['cliedatenaiss']);$KeyNum = $_SESSION['InputModifclienum'];$occurenceKey = "clienum"; $Occurence = "cliedatenaiss";$Table = "clients";}
if(isset($_POST['clieadremail'])) {$Exec=2;$Resultat = SecureInput($_POST['clieadremail']);$KeyNum = $_SESSION['InputModifclienum'];$occurenceKey = "clienum"; $Occurence = "clieadremail";$Table = "clients";}
if(isset($_POST['clienumtel'])) {$Exec=2;$Resultat = SecureInput($_POST['clienumtel']);$KeyNum = $_SESSION['InputModifclienum'];$occurenceKey = "clienum"; $Occurence = "clienumtel";$Table = "clients";}
if(isset($_POST['clienumtel1'])) {$Exec=2;$Resultat = SecureInput($_POST['clienumtel1']);$KeyNum = $_SESSION['InputModifclienum'];$occurenceKey = "clienum"; $Occurence = "clienumtel1";$Table = "clients";}
if(isset($_POST['clienumlic'])) {$Exec=2;$Resultat = SecureInput($_POST['clienumlic']);$KeyNum = $_SESSION['InputModifclienum'];$occurenceKey = "clienum"; $Occurence = "clienumlic";$Table = "clients";}
if(isset($_GET['cliedatevallic'])) {$Exec=2;$Resultat = SecureInput($_GET['cliedatevallic']);$KeyNum = $_SESSION['InputModifclienum'];$occurenceKey = "clienum"; $Occurence = "cliedatevallic";$Table = "clients";}
if(isset($_GET['cliedateinscription'])) {$Exec=2;$Resultat = SecureInput($_GET['cliedateinscription']);$KeyNum = $_SESSION['InputModifclienum'];$occurenceKey = "clienum"; $Occurence = "cliedateinscription";$Table = "clients";}
if(isset($_GET['cliedatecotisation'])) {$Exec=2;$Resultat = SecureInput($_GET['cliedatecotisation']);$KeyNum = $_SESSION['InputModifclienum'];$occurenceKey = "clienum"; $Occurence = "cliedatecotisation";$Table = "clients";}
if(isset($_GET['clieniveau'])) {$Exec=2;$Resultat = SecureInput($_GET['clieniveau']);$KeyNum = $_SESSION['InputModifclienum'];$occurenceKey = "clienum"; $Occurence = "clieniveau";$Table = "clients";}
if(isset($_POST['clienumcompte'])) {$Exec=2;$Resultat = SecureInput($_POST['clienumcompte']);$KeyNum = $_SESSION['InputModifclienum'];$occurenceKey = "clienum"; $Occurence = "clienumcompte";$Table = "clients";}
if(isset($_GET['cliecivilite'])) {$Exec=2;$Resultat = SecureInput($_GET['cliecivilite']);$KeyNum = $_SESSION['InputModifclienum'];$occurenceKey = "clienum"; $Occurence = "cliecivilite";$Table = "clients";}
if(isset($_GET['cliestatus'])) {$Exec=2;$Resultat = SecureInput($_GET['cliestatus']);$KeyNum = $_SESSION['InputModifclienum'];$occurenceKey = "clienum"; $Occurence = "cliestatus";$Table = "clients";}
if(isset($_POST['cliecommentaire'])) {$Exec=2;$Resultat = SecureInput($_POST['cliecommentaire']);$KeyNum = $_SESSION['InputModifclienum'];$occurenceKey = "clienum"; $Occurence = "cliecommentaire";$Table = "clients";}
if(isset($_POST['cliesoldforfentrlibe'])) {$Exec=2;$Resultat = SecureInput($_POST['cliesoldforfentrlibe']);$KeyNum = $_SESSION['InputModifForfnum'];$occurenceKey = "cliesoldforfentrnum"; $Occurence = "cliesoldforfentrlibe";$Table = "clientssoldeforfentree";}
if(isset($_POST['cliesoldforfentrnbheure'])) {$Exec=2;$_POST['cliesoldforfentrnbheure'] = $_POST['cliesoldforfentrnbheure'] * 60;$Resultat = SecureInput($_POST['cliesoldforfentrnbheure']);$KeyNum = $_SESSION['InputModifForfnum'];$occurenceKey = "cliesoldforfentrnum"; $Occurence = "cliesoldforfentrnbheure";$Table = "clientssoldeforfentree";}
if(isset($_POST['cliesoldforfentrmontant'])) {$Exec=2;$_POST['cliesoldforfentrmontant'] = str_replace(",",".",$_POST['cliesoldforfentrmontant']);$Resultat = SecureInput($_POST['cliesoldforfentrmontant']);$KeyNum = $_SESSION['InputModifForfnum'];$occurenceKey = "cliesoldforfentrnum"; $Occurence = "cliesoldforfentrmontant";$Table = "clientssoldeforfentree";}
if(isset($_GET['cliesoldforfentrdate1'])) {$Exec=2;$Resultat = SecureInput($_GET['cliesoldforfentrdate1']);$KeyNum = $_SESSION['InputModifForfnum'];$occurenceKey = "cliesoldforfentrnum"; $Occurence = "cliesoldforfentrdate1";$Table = "clientssoldeforfentree";}
if(isset($_GET['cliesoldforfentrdate2'])) {$Exec=2;$Resultat = SecureInput($_GET['cliesoldforfentrdate2']);$KeyNum = $_SESSION['InputModifForfnum'];$occurenceKey = "cliesoldforfentrnum"; $Occurence = "cliesoldforfentrdate2";$Table = "clientssoldeforfentree";}
if(isset($_POST['clienumcarteidentite'])) {$Exec=2;$Resultat = SecureInput($_POST['clienumcarteidentite']);$KeyNum = $_SESSION['InputModifclienum'];$occurenceKey = "clienum"; $Occurence = "clienumcarteidentite";$Table = "clients";}
if(isset($_POST['clieiban'])) {$Exec=2;$Resultat = SecureInput($_POST['clieiban']);$KeyNum = $_SESSION['InputModifclienum'];$occurenceKey = "clienum"; $Occurence = "clieiban";$Table = "clients";}
if(isset($_POST['cliebic'])) {$Exec=2;$Resultat = SecureInput($_POST['cliebic']);$KeyNum = $_SESSION['InputModifclienum'];$occurenceKey = "clienum"; $Occurence = "cliebic";$Table = "clients";}
if(isset($_POST['clieprovince'])) {$Exec=2;$Resultat = SecureInput($_POST['clieprovince']);$KeyNum = $_SESSION['InputModifclienum'];$occurenceKey = "clienum"; $Occurence = "clieprovince";$Table = "clients";}
if(isset($_POST['groupnom'])) {$Exec=2;$Resultat = SecureInput($_POST['groupnom']);$KeyNum = $_SESSION['InputModifGroupnum'];$occurenceKey = "groupnum"; $Occurence = "groupnom";$Table = "groupe";}
if(isset($_POST['groupdesc'])) {$Exec=2;$Resultat = SecureInput($_POST['groupdesc']);$KeyNum = $_SESSION['InputModifGroupnum'];$occurenceKey = "groupnum"; $Occurence = "groupdesc";$Table = "groupe";}
if(isset($_POST['planlecomodlibe'])) {$Exec=2;$Resultat = SecureInput($_POST['planlecomodlibe']);$KeyNum = $_SESSION['InputModifModelenum'];$occurenceKey = "planlecomodnum"; $Occurence = "planlecomodlibe";$Table = "planning_lecon_modele";}
if(isset($_GET['planlecomodjour'])) {$Exec=2;$Resultat = SecureInput($_GET['planlecomodjour']);$KeyNum = $_SESSION['InputModifModelenum'];$occurenceKey = "planlecomodnum"; $Occurence = "planlecomodjour";$Table = "planning_lecon_modele";}
if(isset($_GET['planlecomodrepliquer'])) {$Exec=2;$Resultat = SecureInput($_GET['planlecomodrepliquer']);$KeyNum = $_SESSION['InputModifModelenum'];$occurenceKey = "planlecomodnum"; $Occurence = "planlecomodrepliquer";$Table = "planning_lecon_modele";}
if(isset($_POST['planlecomodheure'])) {$Exec=2;$Resultat = SecureInput($_POST['planlecomodheure']);$KeyNum = $_SESSION['InputModifModelenum'];$occurenceKey = "planlecomodnum"; $Occurence = "planlecomodheure";$Table = "planning_lecon_modele";}
if(isset($_GET['planlecomodduree'])) {$Exec=2;$Resultat = SecureInput($_GET['planlecomodduree']);$KeyNum = $_SESSION['InputModifModelenum'];$occurenceKey = "planlecomodnum"; $Occurence = "planlecomodduree";$Table = "planning_lecon_modele";}
if(isset($_GET['planlecomoddureeabebiter'])) {$Exec=2;$Resultat = SecureInput($_GET['planlecomoddureeabebiter']);$KeyNum = $_SESSION['InputModifModelenum'];$occurenceKey = "planlecomodnum"; $Occurence = "planlecomoddureeabebiter";$Table = "planning_lecon_modele";}
if(isset($_GET['modelecalecatenum'])) {$Exec=2;$Resultat = SecureInput($_GET['modelecalecatenum']);$KeyNum = $_SESSION['InputModifModelenum'];$occurenceKey = "planlecomodnum"; $Occurence = "calendrier_categorie_calecatenum";$Table = "planning_lecon_modele";}
if(isset($_GET['planlecomodcategorie']))
  {
    $Exec=2;$Resultat = SecureInput($_GET['planlecomodcategorie']);
    $req1 = 'SELECT * FROM calendrier_discipline_configuration WHERE calediscconfnum = "'.$Resultat.'"';
    $req1Result = $ConnexionBdd ->query($req1) or die ('Erreur SQL !'.$req1.'<br />'.mysqli_error());
    $req1Affich = $req1Result->fetch();
    $Resultat = $req1Affich['calediscconflibe'];
    $KeyNum = $_SESSION['InputModifModelenum'];$occurenceKey = "planlecomodnum";
    $Occurence = "planlecomodcategorie";$Table = "planning_lecon_modele";
  }
if(isset($_GET['modeleutilnum'])) {$Exec=2;$Resultat = SecureInput($_GET['modeleutilnum']);$KeyNum = $_SESSION['InputModifModelenum'];$occurenceKey = "planlecomodnum"; $Occurence = "utilisateurs_utilnum";$Table = "planning_lecon_modele";}
if(isset($_GET['planlecomodniveau1'])) {$Exec=2;$Resultat = SecureInput($_GET['planlecomodniveau1']);$KeyNum = $_SESSION['InputModifModelenum'];$occurenceKey = "planlecomodnum"; $Occurence = "planlecomodniveau1";$Table = "planning_lecon_modele";}
if(isset($_GET['planlecomodniveau2'])) {$Exec=2;$Resultat = SecureInput($_GET['planlecomodniveau2']);$KeyNum = $_SESSION['InputModifModelenum'];$occurenceKey = "planlecomodnum"; $Occurence = "planlecomodniveau2";$Table = "planning_lecon_modele";}
if(isset($_GET['planlecomodnbmaxpers'])) {$Exec=2;$Resultat = SecureInput($_GET['planlecomodnbmaxpers']);$KeyNum = $_SESSION['InputModifModelenum'];$occurenceKey = "planlecomodnum"; $Occurence = "planlecomodnbmaxpers";$Table = "planning_lecon_modele";}
if(isset($_GET['planlecomodinstal'])) {$Exec=2;$Resultat = SecureInput($_GET['planlecomodinstal']);$KeyNum = $_SESSION['InputModifModelenum'];$occurenceKey = "planlecomodnum"; $Occurence = "planlecomodinstal";$Table = "planning_lecon_modele";}
if(isset($_POST['planlecomoddesc'])) {$Exec=2;$Resultat = SecureInput($_POST['planlecomoddesc']);$KeyNum = $_SESSION['InputModifModelenum'];$occurenceKey = "planlecomodnum"; $Occurence = "planlecomoddesc";$Table = "planning_lecon_modele";}
if(isset($_GET['planlecomodhorsperiode'])) {$Exec=2;$Resultat = SecureInput($_GET['planlecomodhorsperiode']);$KeyNum = $_SESSION['InputModifModelenum'];$occurenceKey = "planlecomodnum"; $Occurence = "planlecomodhorsperiode";$Table = "planning_lecon_modele";}
if(isset($_POST['calecatelibe'])) {$Exec=2;$Resultat = SecureInput($_POST['calecatelibe']);$KeyNum = $_SESSION['InputModifcalecatenum'];$occurenceKey = "calecatenum"; $Occurence = "calecatelibe";$Table = "calendrier_categorie";}
if(isset($_GET['calecatetype'])) {$Exec=2;$Resultat = SecureInput($_GET['calecatetype']);$KeyNum = $_SESSION['InputModifcalecatenum'];$occurenceKey = "calecatenum"; $Occurence = "calecatetype";$Table = "calendrier_categorie";}

if($Exec == 2)
  {
    if($Resultat == "NULL") {$req = 'UPDATE '.$Table.' SET '.$Occurence.' = '.$Resultat.' WHERE '.$occurenceKey.' = "'.$KeyNum.'"';}
    else {$req = 'UPDATE '.$Table.' SET '.$Occurence.' = "'.$Resultat.'" WHERE '.$occurenceKey.' = "'.$KeyNum.'"';}
    $reqResult = $ConnexionBdd ->query($req) or die ('Erreur SQL !'.$req.'<br />'.mysqli_error());

    if($Table == "confentr")
      {
        echo LectureInformationsConfentr($Dossier,$ConnexionBdd);
      }
    if($Table == "conflogiciel")
      {
        echo LectureInformationsConflogiciel($Dossier,$ConnexionBdd);
      }
  }
echo $req;
?>
