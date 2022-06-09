<script src="../../js/divers.js"></script>
<?php

echo '<SCRIPT LANGUAGE = "javascript"> window.location.replace("#close") </SCRIPT>';
session_start();
$Dossier = "../../";
include $Dossier."modules/divers/connexionbdd.php";
include $Dossier."modules/traduction/langCompl_".$_SESSION['infologlang2'].".php";
include $Dossier."modules/traduction/lang_".$_SESSION['infologlang1'].".php";
include $Dossier."modules/function/allfunction.php";
include $Dossier."modules/function/allfunction_facturation.php";
include $Dossier."modules/function/allfunction_clients.php";
include $Dossier."modules/function/allfunction_calendrier.php";
include $Dossier."modules/function/allfunction_requete.php";
include $Dossier."modules/function/allfunction_divers.php";
include $Dossier."modules/scripts/formulaire_ajax_clients.php";
include $Dossier."modules/scripts/formulaire_ajax_boucle.php";

$_SESSION['AfficheClieListMultiple'] = $_SESSION['AfficheClieListMultiple'] + 1;

$listeDocs = ListeDocuments($ConnexionBdd, $Dossier);
echo "<table>";
echo $listeDocs[0];
echo "</table>";

?>
