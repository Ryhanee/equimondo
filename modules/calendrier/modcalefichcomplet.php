<script src="../../js/divers.js"></script>
<?php
$Dossier = "../../";
session_start();
include $Dossier."modules/divers/connexionbdd.php";
include $Dossier."modules/traduction/langCompl_".$_SESSION['infologlang2'].".php";
include $Dossier."modules/traduction/lang_".$_SESSION['infologlang1'].".php";
include $Dossier."modules/function/allfunction.php";
include $Dossier."modules/function/allfunction_clients.php";
include $Dossier."modules/function/allfunction_requete.php";
include $Dossier."modules/function/allfunction_divers.php";
include $Dossier."modules/function/allfunction_configuration.php";
include $Dossier."modules/function/allfunction_facturation.php";
include $Dossier."modules/function/allfunction_calendrier.php";
include $Dossier."modules/function/allfunction_chevaux.php";
include $Dossier."modules/scripts/formulaire_ajax_chevaux.php";
include $Dossier."modules/scripts/formulaire_ajax_clients.php";
include $Dossier."modules/scripts/formulaire_ajax_facturation.php";
include $Dossier."modules/scripts/formulaire_ajax_calendrier.php";
include $Dossier."modules/scripts/formulaire_ajax_configuration.php";
include $Dossier."modules/scripts/formulaire_ajax_profil.php";

$_SESSION['InputModifcalenum'] = $_GET['calenum'];

$_SESSION['NumExec'] = 0;
$_SESSION['NumExecPrest'] = 0;

if(!empty($_GET['clienum'])) {echo "<a href='".$Dossier."modules/profil/modprofilfichcomplet1.php?clienum=".$_GET['clienum']."' class='AfficheFicheProfil1 btn btn-primary'>".$_SESSION['STrad839']."</a>";}

if(!empty($_GET['calenum']))
  {
    echo CalendrierFicheComplet($Dossier,$ConnexionBdd,$_GET['calenum']);
  }

?>
