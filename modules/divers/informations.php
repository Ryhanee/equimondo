<?php
if(!empty($_SESSION['authconnauthnum']))
	{
		$reqMaj = 'UPDATE authentification SET authdate="'.date("Y-m-d H:i:s").'" WHERE authnum="'.$_SESSION['authconnauthnum'].'"';
		$reqMajResult = $ConnexionBdd ->query($reqMaj) or die ('Erreur SQL !'.$reqMaj.'<br />'.mysqli_error());

		if($_SESSION['authpolitiquedonne'] == 1 AND $_SERVER['PHP_SELF'] != "/modules/divers/modsignaturepolitiquedonne.php")
			{
				echo '<SCRIPT LANGUAGE = "javascript"> window.location.replace("'.$Dossier.'modules/divers/modsignaturepolitiquedonne.php?calenum='.$_GET['calenum'].'") </SCRIPT>';
				exit;
			}
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

if(empty($_SESSION['infologlang1'])) {$_SESSION['infologlang1'] = "fr";}
if(empty($_SESSION['infologlang2'])) {$_SESSION['infologlang2'] = "fr";}
?>
