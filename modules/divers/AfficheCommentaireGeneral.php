<script src="../../js/divers.js"></script>
<?php
$Dossier = "../../";
session_start();
include $Dossier."modules/divers/connexionbdd.php";
include $Dossier."modules/traduction/langCompl_".$_SESSION['infologlang2'].".php";
include $Dossier."modules/traduction/lang_".$_SESSION['infologlang1'].".php";
include $Dossier."modules/function/allfunction.php";
include $Dossier."modules/function/allfunction_clients.php";
include $Dossier."modules/function/allfunction_facturation.php";
include $Dossier."modules/function/allfunction_requete.php";
include $Dossier."modules/function/allfunction_divers.php";
include $Dossier."modules/scripts/formulaire_ajax_divers.php";

echo CommentairesGenerals($Dossier,$ConnexionBdd,$_GET['factnum'],$_GET['clienum'],$_GET['chevnum'],$_GET['calenum'],$_GET['NoAffiche']);
?>
