<?php
session_start();
$ConnexionBdd = new PDO('mysql:host=localhost;dbname=equimondo', 'root', '');

//************************** RESOLUTION ECRAN **************************************
if(!empty($_GET['AuthWidthLargeur'])) {$_SESSION['ResolutionConnexion1'] = $_GET['AuthWidthLargeur'];}
if(!empty($_GET['AuthHeightHauteur'])) {$_SESSION['ResolutionConnexion2'] = $_GET['AuthHeightHauteur'];}

if(!empty($_GET['lang']))
  {
    $_SESSION['infologlang1'] = $_GET['lang'];
    echo '<SCRIPT LANGUAGE = "javascript"> window.location.replace("'.$_GET['URL_REDIRIGE'].'") </SCRIPT>';
    exit;
  }

function ResolutionEcran()
  {
    $largeur = '<script type="text/javascript">document.write(""+screen.width+"");</script>';
    $hauteur = '<script type="text/javascript">document.write(""+screen.height+"");</script>';

    //if(empty($_SESSION['ResolutionConnexion1'])) {$_SESSION['ResolutionConnexion1'] = $largeur;}
    //if(empty($_SESSION['ResolutionConnexion2'])) {$_SESSION['ResolutionConnexion2'] = $hauteur;}

    return null;
  }
//*******************************************************************************************

// HEURE ACTUELLE
if($_SESSION['infologlang2'] == "nc")
	{
		$_SESSION['HeureActuelle1'] = date('Y-m-d', mktime(date('H') + 11,date('i'),date('s'),date('m'),date('d'),date('Y')));
		$_SESSION['HeureActuelle2'] = date('Y-m-d H:i:s', mktime(date('H') + 9,date('i'),date('s'),date('m'),date('d'),date('Y')));
	}
else if($_SESSION['infologlang2'] == "ca")
	{
		$_SESSION['HeureActuelle1'] = date('Y-m-d', mktime(date('H') - 6,date('i'),date('s'),date('m'),date('d'),date('Y')));
		$_SESSION['HeureActuelle2'] = date('Y-m-d H:i:s', mktime(date('H') - 6,date('i'),date('s'),date('m'),date('d'),date('Y')));
	}
else
	{
		$_SESSION['HeureActuelle1'] = date('Y-m-d');
		$_SESSION['HeureActuelle2'] = date('Y-m-d H:i:s');
	}

if(!empty($_COOKIE["equimondo3"])) {$_SESSION['hebeappnum']=$_COOKIE["equimondo3"];}

//**************************** INFORMATION SESSION CONNEXION *********
function ConnexionInformation($clienum,$utilnum,$ConnexionBdd)
{
	$datedujour = date('Y-m-d');
	if(!empty($utilnum))
	{
		$reqUtil = 'SELECT utilnum,utilnom,utilprenom,utiladresmail,utilautoappli,utiltel1,utiltel2,AA_equimondo_hebeappnum FROM utilisateurs WHERE utilnum="'.$utilnum.'"';
		$reqUtilResult = $ConnexionBdd ->query($reqUtil) or die ('Erreur SQL !'.$reqUtil.'<br />'.mysqli_error());
		$reqUtilAffich = $reqUtilResult->fetch();

		$_SESSION['connauthnum']=$reqUtilAffich[0];
		$_SESSION['connauthnom']=$reqUtilAffich[1];
		$_SESSION['connauthprenom']=$reqUtilAffich[2];
		$_SESSION['connauthadresmail']=$reqUtilAffich[3];
		$_SESSION['connauthtel1']=$reqUtilAffich[5];
		$_SESSION['connauthtel2']=$reqUtilAffich[6];
		$_SESSION['hebeappnum'] = $reqUtilAffich['AA_equimondo_hebeappnum'];

		$reqMaj = 'UPDATE authentification SET authdate="'.$datedujour.'" WHERE utilisateurs_utilnum="'.$utilnum.'"';
		$reqMajResult = $ConnexionBdd ->query($reqMaj) or die ('Erreur SQL !'.$reqMaj.'<br />'.mysqli_error());

		// Ajou de la connexion dans l'historique
	/*	$reqConnHist = 'INSERT INTO connexion_historique VALUE (NULL,"'.$datedujour.'","'.$utilnum.'",NULL,NULL,NULL,NULL)';
		$reqConnHistResult = $ConnexionBdd ->query($reqConnHist) or die ('Erreur SQL !'.$reqConnHist.'<br />'.mysqli_error());
*/
		$_SESSION['connind']="util";
		$_SESSION['modclients'] = 1;
		$_SESSION['modchevaux'] = 1;
		$_SESSION['modstocks'] = 1;
		$_SESSION['modagenda'] = 1;
		$_SESSION['modsoins'] = 1;
		$_SESSION['modfacturation'] = 1;
		$_SESSION['modreprises'] = 1;
		$_SESSION['modstages'] = 1;
		$_SESSION['modconcours'] = 1;
		$_SESSION['modelevage'] = 1;
		$_SESSION['modbilan'] = 1;
		$_SESSION['modstatistiques'] = 1;
		$_SESSION['modconfiguration'] = 1;
		$_SESSION['modboutique'] = 1;

		$reqLevel = 'SELECT proflevelibe FROM utilisateurs_profil, profil, profil_level WHERE profil_level.profil_profnum = profil.profnum AND utilisateurs_profil.profil_profnum = profil.profnum AND utilisateurs_utilnum =  "'.$utilnum.'"';
		$reqLevelResult = $ConnexionBdd ->query($reqLevel) or die ('Erreur SQL !'.$reqLevel.'<br />'.mysqli_error());
		while($reqLevelAffich = $reqLevelResult->fetch())
		{
			$_SESSION['mod'.$reqLevelAffich[0]] = 2;
		}
	}
	if(!empty($clienum))
	{
		$reqClie = 'SELECT clienum,clienom,clieprenom,clieadremail,clieautoappli,familleclients_famiclienum,cliesupp,AA_equimondo_hebeappnum,cliecivilite FROM clients WHERE clienum="'.$clienum.'"';
		$reqClieResult = $ConnexionBdd ->query($reqClie) or die ('Erreur SQL !'.$reqClie.'<br />'.mysqli_error());
		$reqClieAffich = $reqClieResult->fetch();
		$_SESSION['hebeappnum'] = $reqClieAffich['AA_equimondo_hebeappnum'];

		$_SESSION['modclients'] = 2;
		$_SESSION['modchevaux'] = 2;
		$_SESSION['modstocks'] = 2;
		$_SESSION['modagenda'] = 2;
		$_SESSION['modsoins'] = 2;
		$_SESSION['modfacturation'] = 2;
		$_SESSION['modreprises'] = 2;
		$_SESSION['modstages'] = 2;
		$_SESSION['modconcours'] = 2;
		$_SESSION['modelevage'] = 2;
		$_SESSION['modbilan'] = 2;
		$_SESSION['modstatistiques'] = 2;
		$_SESSION['modconfiguration'] = 2;
		$_SESSION['modboutique'] = 2;

		$_SESSION['connauthnum']=$reqClieAffich[0];
		$_SESSION['connauthnom']=$reqClieAffich[1];
		$_SESSION['connauthprenom']=$reqClieAffich[2];
		$_SESSION['connauthadresmail']=$reqClieAffich[3];
		$_SESSION['connauthsupp']=$reqClieAffich['cliesupp'];
		$_SESSION['connauthip']=$_SERVER['REMOTE_ADDR'];
		$_SESSION['connauthcivilite']=$reqClieAffich['cliecivilite'];

		$reqMaj = 'UPDATE authentification SET authdate="'.$datedujour.'" WHERE clients_clienum="'.$clienum.'"';
		$reqMajResult = $ConnexionBdd ->query($reqMaj) or die ('Erreur SQL !'.$reqMaj.'<br />'.mysqli_error());

				// Ajou de la connexion dans l'historique
	/*	$reqConnHist = 'INSERT INTO connexion_historique VALUE (NULL,"'.$datedujour.'",NULL,"'.$clienum.'","2",NULL,NULL)';
		$reqConnHistResult = $ConnexionBdd ->query($reqConnHist) or die ('Erreur SQL !'.$reqConnHist.'<br />'.mysqli_error());
		*/$_SESSION['connind']="clie";

				// Liste les autres membres de la famille
		$reqFami = 'SELECT count(clienum) FROM clients WHERE familleclients_famiclienum="'.$reqClieAffich[5].'" AND cliesupp = "1"';
		$reqFamiResult = $ConnexionBdd ->query($reqFami) or die ('Erreur SQL !'.$reqFami.'<br />'.mysqli_error());
		$reqFamiAffich = $reqFamiResult->fetch();

		$_SESSION['connauthfamicount'] = $reqFamiAffich[0];
		$_SESSION['connauthfaminum'] = $reqClieAffich[5];
		if($reqFamiAffich[0] >= 1)
		{
			$reqFami = 'SELECT clienum,clienom,clieprenom FROM clients WHERE familleclients_famiclienum="'.$reqClieAffich[5].'" ORDER BY clienom ASC';
			$reqFamiResult = $ConnexionBdd ->query($reqFami) or die ('Erreur SQL !'.$reqFami.'<br />'.mysqli_error());
			while($reqFamiAffich = $reqFamiResult->fetch())
			{
				$_SESSION['connauthfami'] = $_SESSION['connauthfami']."<option value='".$reqFamiAffich[0]."'>".$reqFamiAffich[1]." ".$reqFamiAffich[2]."</option>";
			}
		}
	}

		//$req = 'SELECT authnum,AA_equimondo_hebeappnum,authconfigaffichfichmontoir FROM authentification WHERE';
	$req = 'SELECT authnum,AA_equimondo_hebeappnum,authpolitiquedonne FROM authentification WHERE';
	if(!empty($utilnum)) {$req.=' utilisateurs_utilnum = "'.$utilnum.'"';}
	if(!empty($clienum)) {$req.=' clients_clienum = "'.$clienum.'"';}
	$reqResult = $ConnexionBdd ->query($req) or die ('Erreur SQL !'.$req.'<br />'.mysqli_error());
	$reqAffich = $reqResult->fetch();

	if($_SESSION['applivalide'] != 1) {$_SESSION['hebeappnum'] = $reqAffich[1];}
	$_SESSION['authconnauthnum'] = $reqAffich[0];
  $_SESSION['equimondo4'] = $_SESSION['authconnauthnum'];
	$_SESSION['authpolitiquedonne'] = $reqAffich[2];

	$id = $_SESSION['authconnauthnum'];
	$ua = $_SERVER['HTTP_USER_AGENT'];
			if (preg_match('/iphone/i',$ua) || preg_match('/android/i',$ua) || preg_match('/blackberry/i',$ua) || preg_match('/symb/i',$ua) || preg_match('/ipad/i',$ua) || preg_match('/ipod/i',$ua) || preg_match('/phone/i',$ua) )
				{
					$external_id = $id;

					echo '<script> OneSignal.push(function() { OneSignal.setExternalUserId('.$external_id.'); }); </script>';
				}

		//$_SESSION['authconfigaffichfichmontoir'] = $reqAffich['authconfigaffichfichmontoir'];
	$_SESSION['authconfigaffichfichmontoir'] = 1;
	$_SESSION['DemandeConnexion'] = 2;

  return "ok";
}
//*******************************************************************

//***************** INFORMATION DE L'ENTREPRISE *****************
function LectureInformationsConfentr($Dossier,$ConnexionBdd)
  {
  	$reqConfEntr='SELECT * FROM confentr WHERE AA_equimondo_hebeappnum = "'.$_SESSION['hebeappnum'].'"';
  	$reqConfEntrResult = $ConnexionBdd ->query($reqConfEntr) or die ('Erreur SQL !'.$reqConfEntr.'<br />'.mysqli_error());
  	$reqConfEntrAffich = $reqConfEntrResult->fetch();

  	$_SESSION['confentradresmail']=$reqConfEntrAffich['confentradresmail'];
  	$_SESSION['confentrnom']=$reqConfEntrAffich['confentrnom'];
  	$_SESSION['confentradres']=$reqConfEntrAffich['confentradres'];
  	$_SESSION['confentrcp']=$reqConfEntrAffich['confentrcp'];
  	$_SESSION['confentrville']=$reqConfEntrAffich['confentrville'];
  	$_SESSION['confentrtel']=$reqConfEntrAffich['confentrtel'];
  	$_SESSION['confentradresmail']=$reqConfEntrAffich['confentradresmail'];
  	$_SESSION['confentrurl']=$reqConfEntrAffich['confentrurl'];
  	$_SESSION['confentrsiret']=$reqConfEntrAffich['confentrsiret'];
  	$_SESSION['confentrcodeape']=$reqConfEntrAffich['confentrcodeape'];
  	$_SESSION['confentrintratva']=$reqConfEntrAffich['confentrintratva'];
  	$_SESSION['confentrdomiciliation']=$reqConfEntrAffich['confentrdomiciliation'];
  	$_SESSION['confentrbic']=$reqConfEntrAffich['confentrbic'];
  	$_SESSION['confentriban1']=$reqConfEntrAffich['confentriban1'];
  	// $_SESSION['confentriban2']=$reqConfEntrAffich['confentriban2'];
  	// $_SESSION['confentriban3']=$reqConfEntrAffich['confentriban3'];
  	// $_SESSION['confentriban4']=$reqConfEntrAffich['confentriban4'];
  	// $_SESSION['confentriban5']=$reqConfEntrAffich['confentriban5'];
  	$_SESSION['confentrdenosocial']=$reqConfEntrAffich['confentrdenosocial'];
  	$_SESSION['confentrcapital']=$reqConfEntrAffich['confentrcapital'];
  	$_SESSION['confentrsiren']=$reqConfEntrAffich['confentrsiren'];
  	$_SESSION['confentrrcs']=$reqConfEntrAffich['confentrrcs'];
  	$_SESSION['confentrvillegreffe']=$reqConfEntrAffich['confentrvillegreffe'];
  	$_SESSION['confentrtaxe1']=$reqConfEntrAffich['confentrtaxe1'];
  	$_SESSION['confentrtaxe2']=$reqConfEntrAffich['confentrtaxe2'];
  }
//*************************************************

//***************** CONFIGURATION DU LOGICIEL *****************
function LectureInformationsConflogiciel($Dossier,$ConnexionBdd)
  {
      //configuration du logiciel
  	$reqConfLog = 'SELECT * FROM conflogiciel WHERE AA_equimondo_hebeappnum = "'.$_SESSION['hebeappnum'].'"';
  	$reqConfLogResult = $ConnexionBdd ->query($reqConfLog) or die ('Erreur SQL !'.$reqConfLog.'<br />'.mysqli_error());
  	$reqConfLogAffich = $reqConfLogResult->fetch();

  	$_SESSION['conflogcondfact']=$reqConfLogAffich['conflogcondfact'];
  	$_SESSION['conflogboutique']=$reqConfLogAffich['conflogboutique'];
  	$_SESSION['conflogdateexercice1']=$reqConfLogAffich['conflogdateexercice1'];
  	$_SESSION['conflogdateexercice2']=$reqConfLogAffich['conflogdateexercice2'];
  	$_SESSION['conflognbjourreservleco']=$reqConfLogAffich['conflognbjourreservleco'];
  	$_SESSION['conflogmessfactnonpayer']=$reqConfLogAffich['conflogmessfactnonpayer'];
  	$_SESSION['conflognumcompte1']=$reqConfLogAffich['conflognumcompte1'];
  	// $_SESSION['conflognbcaractnumcompte']=$reqConfLogAffich['conflognbcaractnumcompte'];
  	$_SESSION['conflognumcompte3']=$reqConfLogAffich['conflognumcompte3'];
  	$_SESSION['conflognumcompte4']=$reqConfLogAffich['conflognumcompte4'];
  	$_SESSION['conflognumcompte5']=$reqConfLogAffich['conflognumcompte5'];
  	$_SESSION['conflognumcompte6']=$reqConfLogAffich['conflognumcompte6'];
  	$_SESSION['conflognumcompte7']=$reqConfLogAffich['conflognumcompte7'];
  	$_SESSION['conflognumcompte8']=$reqConfLogAffich['conflognumcompte8'];
  	$_SESSION['conflogplanlecoautofact']=$reqConfLogAffich['conflogplanlecoautofact'];
  	$_SESSION['conflogfactprefixe']=$reqConfLogAffich['conflogfactprefixe'];
  	$_SESSION['conflogactualite']=$reqConfLogAffich['conflogactualite'];
  	$_SESSION['conflognbheurereserver']=$reqConfLogAffich['conflognbheurereserver'];
  	$_SESSION['conflogcodebarre']=$reqConfLogAffich['conflogcodebarre'];
  	$_SESSION['conflogcliecotisation']=$reqConfLogAffich['conflogcliecotisation'];
  	$_SESSION['conflogprefixeclient']=$reqConfLogAffich['conflognumcompte9'];
  	$_SESSION['conflogreservheure']=$reqConfLogAffich['conflogreservheure'];
  	$_SESSION['conflogreservnbjour']=$reqConfLogAffich['conflogreservnbjour'];
  	$_SESSION['conflogmail1']=$reqConfLogAffich['conflogmail1'];
  	$_SESSION['conflogmail2']=$reqConfLogAffich['conflogmail2'];
  	$_SESSION['conflogsoldcaisse']=$reqConfLogAffich['conflogsoldcaisse'];
  	$_SESSION['conflogpartagerplanning']=$reqConfLogAffich['conflogpartagerplanning'];
  	$_SESSION['conflogreservation']=$reqConfLogAffich['conflogreservation'];
  	$_SESSION['conflogmodelefacture']=$reqConfLogAffich['conflogmodelefacture'];
  	$_SESSION['conflogcaisseafficheprestations']=$reqConfLogAffich['conflogcaisseafficheprestations'];
  	$_SESSION['conflogaccesficheperso']=$reqConfLogAffich['conflogaccesficheperso'];
  	$_SESSION['conflogacceschevaux']=$reqConfLogAffich['conflogacceschevaux'];
  	$_SESSION['conflogaccessoins']=$reqConfLogAffich['conflogaccessoins'];
  	$_SESSION['conflogaccesreprises']=$reqConfLogAffich['conflogaccesreprises'];
  	$_SESSION['conflogaccesstages']=$reqConfLogAffich['conflogaccesstages'];
  	$_SESSION['conflogaccesconcours']=$reqConfLogAffich['conflogaccesconcours'];
  	$_SESSION['conflogaccesfacturation']=$reqConfLogAffich['conflogaccesfacturation'];
  	$_SESSION['conflogcaleutilacces']=$reqConfLogAffich['conflogcaleutilacces'];
  	$_SESSION['conflogpassagefactparchevaux']=$reqConfLogAffich['conflogpassagefactparchevaux'];
  	$_SESSION['conflognumerotationcompteclie']=$reqConfLogAffich['conflognumerotationcompteclie'];
  	$_SESSION['conflogvisionheurerestante']=$reqConfLogAffich['conflogvisionheurerestante'];
  }
//*************************************************

//***************** INFORMATION DU LOGICIEL *****************
function LectureInformationsInfologiciel($Dossier,$ConnexionBdd)
{
    // INFORMATION DU LOGICIEL
	$reqLog = 'SELECT * FROM infologiciel WHERE AA_equimondo_hebeappnum = "'.$_SESSION['hebeappnum'].'"';
	$reqLogResult = $ConnexionBdd ->query($reqLog) or die ('Erreur SQL !'.$reqLog.'<br />'.mysqli_error());
	$reqLogAffich = $reqLogResult->fetch();

	$_SESSION['equimondoinfolognum']=$reqLogAffich[0];
	$_SESSION['infologversionlogiciel']=$reqLogAffich[1];
	$_SESSION['equimondoinfologurl']=$reqLogAffich[2];
	$_SESSION['equimondoinfologdatemiseenprod']=$reqLogAffich[3];
	$_SESSION['equimondoinfolognomcom']=$reqLogAffich[4];
	$_SESSION['equimondoinfologversionnum']=$reqLogAffich[6];
	$_SESSION['equimondoinfologlang']=$reqLogAffich[7];
	$_SESSION['infologbluepaidonoff']=$reqLogAffich[8];
	$_SESSION['infologbluepaididboutique']=$reqLogAffich[9];
	$_SESSION['infologbluepaiddevise']=$reqLogAffich[10];
	$_SESSION['infologidmodepaiecb']=$reqLogAffich[11];
	$_SESSION['infologmodepaiementcb']=$reqLogAffich['infologmodepaiementcb'];
	$_SESSION['infologtypeprestnumpaiementcb']=$reqLogAffich['infologtypeprestnumpaiementcb'];
	if(empty($_SESSION['infologlang1'])) {$_SESSION['infologlang1']=$reqLogAffich['infologlang1'];}
	if(empty($_SESSION['infologlang2'])) {$_SESSION['infologlang2']=$reqLogAffich['infologlang2'];}

	// INFORMATION AA_EQUIMONDO_CLIENTS ET AA_EQUIMONDO_APPLICATION
	$reqClieHebe = 'SELECT * FROM AA_equimondo_clients,AA_equimondo_hebergement_application WHERE AA_equimondo_clients_clienum = AA_equimondo_clienum AND AA_equimondo_hebeappnum = "'.$_SESSION['hebeappnum'].'"';
	$reqClieHebeResult = $ConnexionBdd ->query($reqClieHebe) or die ('Erreur SQL !'.$reqClieHebe.'<br />'.mysqli_error());
	$reqClieHebeAffich = $reqClieHebeResult->fetch();
	$_SESSION['equimondoinfolognumclieequimondo'] = $reqClieHebeAffich['AA_equimondo_clienum'];
}
//*************************************************


//****************************** CONNEXION AUTOMATIQUE ***********************
if(empty($_SESSION['connauthnum']) AND !empty($_COOKIE["equimondo1"]) AND !empty($_COOKIE["equimondo2"]))
{
	$login = $_COOKIE["equimondo1"];
	$mdpcrypt = $_COOKIE["equimondo2"];

	$reqVerif = 'SELECT count(authnum) FROM authentification WHERE authlogin="'.$login.'" AND authmdp="'.$mdpcrypt.'"';
	$reqVerifResult = $ConnexionBdd ->query($reqVerif) or die ('Erreur SQL !'.$reqVerif.'<br />'.mysql_error());
	$reqVerifAffich = $reqVerifResult->fetch();

	if($reqVerifAffich[0] == 1)
	{
		$req = 'SELECT authnum,authdate,authdate,utilisateurs_utilnum,clients_clienum,AA_equimondo_hebeappnum,authpolitiquedonne FROM authentification WHERE authlogin="'.$login.'" AND authmdp="'.$mdpcrypt.'"';
		$reqResult = $ConnexionBdd ->query($req) or die ('Erreur SQL !'.$req.'<br />'.mysql_error());
		$reqAffich = $reqResult->fetch();
		$_SESSION['authpolitiquedonne'] = $reqAffich['authpolitiquedonne'];

		echo ResolutionEcran();

		if(!empty($reqAffich[3]))
		{
			$reqUtil = 'SELECT utilnum,utilnom,utilprenom,utiladresmail,utilautoappli,utiltel1,utiltel2 FROM utilisateurs WHERE utilnum="'.$reqAffich[3].'"';
			$reqUtilResult = $ConnexionBdd ->query($reqUtil) or die ('Erreur SQL !'.$reqUtil.'<br />'.mysql_error());
			$reqUtilAffich = $reqUtilResult->fetch();

			if($reqUtilAffich[4] == 2)
			{
				$ok = ConnexionInformation(null,$reqUtilAffich[0],$ConnexionBdd);

        echo "<script language=\"JavaScript\">document.location=\"http://".$_SERVER['SERVER_NAME']."/enrCookie_script.php?AuthWidthLargeur=\"+screen.width+\"&AuthHeightHauteur=\"+screen.height;</script>";
				exit;
			}
			else
			{
				echo '<SCRIPT LANGUAGE = "javascript"> window.location.replace("'.$Dossier.'deconnexion.php") </SCRIPT>';
				exit;
			}
		}
				//*****************************************************************

				//****************** CONNEXION CLIENT *********************
		if(!empty($reqAffich[4]))
		{
			$reqClie = 'SELECT clienum,clienom,clieprenom,clieadremail,clieautoappli,familleclients_famiclienum FROM clients WHERE clienum="'.$reqAffich[4].'"';
			$reqClieResult = $ConnexionBdd ->query($reqClie) or die ('Erreur SQL !'.$reqClie.'<br />'.mysql_error());
			$reqClieAffich = $reqClieResult->fetch();

			if($reqClieAffich[4] == 2)
			{
				$ok = ConnexionInformation($reqClieAffich[0],null,$ConnexionBdd);
        echo "<script language=\"JavaScript\">document.location=\"http://".$_SERVER['SERVER_NAME']."/enrCookie_script.php?AuthWidthLargeur=\"+screen.width+\"&AuthHeightHauteur=\"+screen.height;</script>";
				exit;
			}
			else
			{
				echo '<SCRIPT LANGUAGE = "javascript"> window.location.replace("'.$Dossier.'deconnexion.php") </SCRIPT>';
				exit;
			}
		}
	}
}
//*******************************************************************************************************/

if(!empty($_SESSION['authconnauthnum']))
{
	$reqMaj = 'UPDATE authentification SET authdate="'.date("Y-m-d H:i:s").'" WHERE authnum="'.$_SESSION['authconnauthnum'].'"';
	$reqMajResult = $ConnexionBdd ->query($reqMaj) or die ('Erreur SQL !'.$reqMaj.'<br />'.mysqli_error());
}

if(!empty($_SESSION['hebeappnum']))
{
	echo LectureInformationsConfentr($Dossier,$ConnexionBdd);

	echo LectureInformationsConflogiciel($Dossier,$ConnexionBdd);

	echo LectureInformationsInfologiciel($Dossier,$ConnexionBdd);

		// Information sur lentreprise Equimondo
	$_SESSION['equimondofactconfentrnom']="Equimondo";
	$_SESSION['equimondofactconfentradres']="1 avenue des essarts";
	$_SESSION['equimondofactconfentrcp']="14470";
	$_SESSION['equimondofactconfentrville']="Courseulles sur mer";
	$_SESSION['equimondofactconfentrtel']="02.61.53.06.15";
	$_SESSION['equimondofactconfentrurl']="http://www.equimondo.fr";
	$_SESSION['equimondofactconfentrsiret']="532 599 834 00019";
}

if($_SESSION['connind'] == "clie" AND $_SESSION['connauthsupp'] == 3)
{
	echo '<SCRIPT LANGUAGE = "javascript"> window.location.replace("'.$Dossier.'index.php#EquimondoConfirmer") </SCRIPT>';
}
?>
