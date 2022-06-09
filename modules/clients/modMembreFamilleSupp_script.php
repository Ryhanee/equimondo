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
include $Dossier."modules/function/allfunction_divers.php";
include $Dossier."modules/function/allfunction_requete.php";
include $Dossier."modules/scripts/formulaire_ajax_profil.php";
include $Dossier."modules/scripts/formulaire_ajax_facturation.php";
include $Dossier."modules/scripts/formulaire_ajax_clients.php";

if($_GET['NoAction'] != 2)
  {
    if(!empty($_GET['clienumsupp']))
      {
        $req2 = 'UPDATE clients SET familleclients_famiclienum=NULL WHERE clienum="'.$_GET['clienumsupp'].'"';
        $req2Result = $ConnexionBdd ->query($req2) or die ('Erreur SQL !'.$req2.'<br />'.mysqli_error());
      }
    else
      {
        $req2 = 'UPDATE clients SET familleclients_famiclienum=NULL WHERE clienum="'.$_GET['clienum'].'"';
        $req2Result = $ConnexionBdd ->query($req2) or die ('Erreur SQL !'.$req2.'<br />'.mysqli_error());
      }
  }

echo MembreFamille($Dossier,$ConnexionBdd,$_GET['clienum']);
?>
