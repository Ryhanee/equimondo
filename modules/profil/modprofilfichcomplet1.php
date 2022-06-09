<script src="../../js/divers.js"></script>
<?php
$Dossier = "../../";
session_start();
include $Dossier."modules/divers/connexionbdd.php";
include $Dossier."modules/traduction/langCompl_" . $_SESSION['infologlang2'] . ".php";
include $Dossier."modules/traduction/lang_" . $_SESSION['infologlang1'] . ".php";
include $Dossier."modules/function/allfunction.php";
include $Dossier."modules/function/allfunction_clients.php";
include $Dossier."modules/function/allfunction_requete.php";
include $Dossier."modules/function/allfunction_divers.php";
include $Dossier."modules/function/allfunction_configuration.php";
include $Dossier."modules/function/allfunction_calendrier.php";
include $Dossier."modules/divers/informations.php";
include $Dossier."modules/scripts/formulaire_ajax_chevaux.php";
include $Dossier."modules/scripts/formulaire_ajax_clients.php";
include $Dossier."modules/scripts/formulaire_ajax_facturation.php";
include $Dossier."modules/scripts/formulaire_ajax_calendrier.php";
include $Dossier."modules/scripts/formulaire_ajax_configuration.php";
include $Dossier."modules/scripts/formulaire_ajax_profil.php";

$Profil = ProfilFichComplet($ConnexionBdd,$Dossier,$_GET['clienum']);
echo $Profil[0];
?>
<script src="../../js/pages/profile.standard.js"></script>
