<script src="../../js/divers.js"></script>

<?php
$Dossier = "../../";
include $Dossier."modules/divers/connexionbdd.php";
include $Dossier."modules/traduction/langCompl_" . $_SESSION['infologlang2'] . ".php";
include $Dossier."modules/traduction/lang_" . $_SESSION['infologlang1'] . ".php";
include $Dossier."modules/function/allfunction.php";
include $Dossier."modules/function/allfunction_clients.php";
include $Dossier."modules/function/allfunction_requete.php";
include $Dossier."modules/function/allfunction_divers.php";
include $Dossier."modules/function/allfunction_configuration.php";


$doc = ajouterSignature($ConnexionBdd,$Dossier,$_GET['docunum']);
echo $doc[0];

?>
