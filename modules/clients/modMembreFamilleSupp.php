<script src="../../js/divers.js"></script>
<?php
session_start();
$Dossier = "../../";
include $Dossier."modules/divers/connexionbdd.php";
include $Dossier."modules/traduction/langCompl_".$_SESSION['infologlang2'].".php";
include $Dossier."modules/traduction/lang_".$_SESSION['infologlang1'].".php";
include $Dossier."modules/function/allfunction.php";
include $Dossier."modules/function/allfunction_facturation.php";
include $Dossier."modules/function/allfunction_clients.php";
include $Dossier."modules/function/allfunction_divers.php";
include $Dossier."modules/function/allfunction_requete.php";
include $Dossier."modules/scripts/formulaire_ajax_profil.php";
include $Dossier."modules/scripts/formulaire_ajax_facturation.php";
include $Dossier."modules/scripts/formulaire_ajax_clients.php";

echo "<div class='alert alert-primary' role='alert'>".$NTrad251."</div>";
echo "<a href='".$Dossier."modules/clients/modMembreFamilleSupp_script.php?clienum=".$_GET['clienum']."&clienumsupp=".$_GET['clienumsupp']."' class='MembreFamilleSupp2'><button class='btn btn-icon btn-icon-end btn-primary' type='submit'>
  <span>".$TradDivOui."</span>
  <i data-acorn-icon='chevron-right'></i>
</button></a>";
echo "<a href='".$Dossier."modules/clients/modMembreFamilleSupp_script.php?clienum=".$_GET['clienum']."&NoAction=2' class='MembreFamilleSupp2' style='margin-left:10px;'><button class='btn btn-icon btn-icon-end btn-primary' type='submit'>
  <span>".$TradDivNon."</span>
  <i data-acorn-icon='chevron-right'></i>
</button></a>";
?>
