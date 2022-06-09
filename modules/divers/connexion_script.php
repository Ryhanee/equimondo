<?php
$sitesource = $_POST['sitesource'];

$Dossier = "../../";
session_start();
include $Dossier."modules/divers/connexionbdd.php";
include $Dossier."modules/traduction/langCompl_".$_SESSION['infologlang2'].".php";
include $Dossier."modules/traduction/lang_".$_SESSION['infologlang1'].".php";
include $Dossier."modules/function/allfunction.php";

if(!empty($_POST['souvenir'])) {$souvenir=htmlspecialchars($_POST['souvenir']);}
if(!empty($_GET['souvenir'])) {$souvenir=htmlspecialchars($_GET['souvenir']);}
if(!empty($_POST['login'])) {$login=htmlspecialchars($_POST['login']);}
if(!empty($_GET['login'])) {$login=htmlspecialchars($_GET['login']);}
if(!empty($_POST['mdp'])) {$mdp=htmlspecialchars($_POST['mdp']);$mdpcrypt=MD5($mdp);}
if(!empty($_GET['mdp'])) {$mdp = htmlspecialchars($_GET['mdp']);$mdpcrypt=MD5($mdp);}
$inscription = htmlspecialchars($_POST['inscription']);
$television = htmlspecialchars($_POST['television']);
$calenum = htmlspecialchars($_POST['calenum']);

//**************************** VERIFICATION AUTENTIFICATION *********************************
$datedujour = date("Y-m-d H:i:s");

// Verif que le login et le mot de passe correspondent bien
$reqVerif = 'SELECT count(authnum) FROM authentification WHERE authlogin="'.$login.'" AND authmdp="'.$mdpcrypt.'"';
$reqVerifResult = $ConnexionBdd ->query($reqVerif) or die ('Erreur SQL !'.$reqVerif.'<br />'.mysqli_error());
$reqVerifAffich = $reqVerifResult->fetch();

if($reqVerifAffich[0] == 0)
	{
		echo "<div class='alert alert-danger' role='alert'>".$Trad1034."</div>";
		exit;
	}
else if($reqVerifAffich[0] == 1)
	{
		$req = 'SELECT authnum,authdate,authdate,utilisateurs_utilnum,clients_clienum,AA_equimondo_hebeappnum FROM authentification WHERE authlogin="'.$login.'" AND authmdp="'.$mdpcrypt.'"';
		$reqResult = $ConnexionBdd ->query($req) or die ('Erreur SQL !'.$req.'<br />'.mysqli_error());
		$reqAffich = $reqResult->fetch();
		$_SESSION['hebeappnum'] = $reqAffich['AA_equimondo_hebeappnum'];

		if(!empty($reqAffich[3]))
			{
				$reqUtil = 'SELECT utilnum,utilnom,utilprenom,utiladresmail,utilautoappli,utiltel1,utiltel2 FROM utilisateurs WHERE utilnum="'.$reqAffich[3].'"';
				$reqUtilResult = $ConnexionBdd ->query($reqUtil) or die ('Erreur SQL !'.$reqUtil.'<br />'.mysql_error());
				$reqUtilAffich = $reqUtilResult->fetch();

				if($reqUtilAffich[4] == 2)
					{
						$ok = ConnexionInformation(null,$reqUtilAffich[0],$ConnexionBdd);
						$AutoAppli = 2;
					}
				else
					{
						$AutoAppli = 1;
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
						$AutoAppli = 2;
						$ok = ConnexionInformation($reqClieAffich[0],null,$ConnexionBdd);
					}
				else
					{
						$AutoAppli = 1;
					}
			}

		if(!empty($MessageErreur))
			{
				echo "<div class='alert alert-danger' role='alert'>".$MessageErreur."</div>";
			}
		else if($souvenir == "on")
			{
				$_SESSION['equimondo1'] = $login;
				$_SESSION['equimondo2'] = $mdpcrypt;

				echo "<script language=\"JavaScript\">document.location=\"enrCookie_script.php?AuthWidthLargeur=\"+screen.width+\"&AuthHeightHauteur=\"+screen.height;</script>";
				exit;
			}
		else
			{
				echo "<script language=\"JavaScript\">document.location=\"index.php?AuthWidthLargeur=\"+screen.width+\"&AuthHeightHauteur=\"+screen.height;</script>";
				exit;
			}
	}

?>
