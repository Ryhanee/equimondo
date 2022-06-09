<script src="../../js/divers.js"></script>
<?php
echo '<SCRIPT LANGUAGE = "javascript"> window.location.replace("#close") </SCRIPT>';
$Dossier = "../../";
session_start();
include $Dossier."modules/divers/connexionbdd.php";
include $Dossier."modules/traduction/langCompl_".$_SESSION['infologlang2'].".php";
include $Dossier."modules/traduction/lang_".$_SESSION['infologlang1'].".php";
include $Dossier."modules/function/allfunction.php";
include $Dossier."modules/scripts/formulaire_ajax_boucle.php";
include $Dossier."modules/scripts/formulaire_ajax_calendrier.php";
include $Dossier."modules/function/allfunction_requete.php";
include $Dossier."modules/function/allfunction_calendrier.php";

$reqCate = 'SELECT calendrier_categorie_calecatenum FROM calendrier WHERE calenum = "'.$_GET['calenum'].'"';
$reqCateResult = $ConnexionBdd ->query($reqCate) or die ('Erreur SQL !'.$reqCate.'<br />'.mysqli_error());
$reqCateAffich = $reqCateResult->fetch();

$ok = CalendrierSupp($_GET['calenum'],$ConnexionBdd);

///echo Calendrier($Dossier,$ConnexionBdd,$caledate1,$modaffiche);

echo '<SCRIPT LANGUAGE = "javascript"> window.location.replace("'.$Dossier.'modules/calendrier/modcalelist.php?calecatenum='.$reqCateAffich['calendrier_categorie_calecatenum'].'") </SCRIPT>';
exit;
?>
