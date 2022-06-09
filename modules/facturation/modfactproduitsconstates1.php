<script src="../../js/divers.js"></script>
<?php
$Dossier = "../../";
session_start();
include $Dossier."modules/divers/connexionbdd.php";
include $Dossier."modules/traduction/langCompl_".$_SESSION['infologlang2'].".php";
include $Dossier."modules/traduction/lang_".$_SESSION['infologlang1'].".php";
include $Dossier."modules/function/allfunction.php";
include $Dossier."modules/scripts/formulaire_ajax_boucle.php";
include $Dossier."modules/scripts/formulaire_ajax_facturation.php";
include $Dossier."modules/function/allfunction_clients.php";
include $Dossier."modules/function/allfunction_requete.php";
include $Dossier."modules/function/allfunction_facturation.php";


if(!empty($_GET['FactProduitsDate1'])) {$_SESSION['FactProduitsDate1'] = $_GET['FactProduitsDate1'];}
if(!empty($_GET['FactProduitsDate2'])) {$_SESSION['FactProduitsDate2'] = $_GET['FactProduitsDate2'];}

echo AfficheProduitsConstates($Dossier,$ConnexionBdd,$_SESSION['FactProduitsDate1'],$_SESSION['FactProduitsDate2']);
?>
