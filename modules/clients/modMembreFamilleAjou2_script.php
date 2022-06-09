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

$req2 = 'SELECT familleclients_famiclienum FROM clients WHERE clienum="'.$_POST['famiclienum'].'"';
$req2Result = $ConnexionBdd ->query($req2) or die ('Erreur SQL !'.$req2.'<br />'.mysqli_error());
$req2Affich = $req2Result->fetch();
$faminum = $req2Affich[0];
if(empty($faminum))
  {
    $req = 'INSERT INTO familleclients VALUE (NULL,'.$_SESSION['hebeappnum'].')';
    $reqResult = $ConnexionBdd ->query($req) or die ('Erreur SQL !'.$req.'<br />'.mysqli_error());
    $faminum = $ConnexionBdd->lastInsertId();
    
    $req2 = 'UPDATE clients SET familleclients_famiclienum = "'.$faminum.'" WHERE clienum="'.$_POST['famiclienum'].'"';
    $req2Result = $ConnexionBdd ->query($req2) or die ('Erreur SQL !'.$req2.'<br />'.mysqli_error());
  }

$req2 = 'UPDATE clients SET familleclients_famiclienum = "'.$faminum .'" WHERE clienum="'.$_POST['clienum'].'"';
$req2Result = $ConnexionBdd ->query($req2) or die ('Erreur SQL !'.$req2.'<br />'.mysqli_error());

echo MembreFamille($Dossier,$ConnexionBdd,$_POST['clienum']);

?>
