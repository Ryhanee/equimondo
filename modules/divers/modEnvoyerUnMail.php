<script type="text/javascript" src="../../js/divers.js"></script>
<?php
$Dossier = "../../";
include $Dossier."modules/divers/connexionbdd.php";
include $Dossier."modules/traduction/langCompl_".$_SESSION['infologlang2'].".php";
include $Dossier."modules/traduction/lang_".$_SESSION['infologlang1'].".php";
include $Dossier."modules/function/allfunction_divers.php";
include $Dossier."modules/function/allfunction_requete.php";
include $Dossier."modules/function/allfunction.php";
include $Dossier."modules/function/allfunction_facturation.php";
include $Dossier."modules/scripts/formulaire_ajax_divers.php";
include $Dossier."modules/scripts/formulaire_ajax_boucle.php";
include $Dossier."modules/scripts/formulaire_ajax_calendrier.php";
include $Dossier."modules/function/allfunction_calendrier.php";

echo EnvoiMail($Dossier,$ConnexionBdd,$_GET['factnum'],$_GET['calenum']);
?>
