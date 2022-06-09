<?php
$Dossier = "../../";
session_start();
include $Dossier."modules/divers/connexionbdd.php";
include $Dossier."modules/traduction/langCompl_".$_SESSION['infologlang2'].".php";
include $Dossier."modules/traduction/lang_".$_SESSION['infologlang1'].".php";
include $Dossier."modules/function/allfunction.php";
include $Dossier."modules/scripts/formulaire_ajax_boucle.php";
include $Dossier."modules/scripts/formulaire_ajax_calendrier.php";
include $Dossier."modules/function/allfunction_requete.php";
include $Dossier."modules/function/allfunction_clients.php";
include $Dossier."modules/function/allfunction_calendrier.php";

$calepartnum = stristr($_GET['caleparttext2'], '|');
$calepartnum = strstr($_GET['caleparttext2'],'|');
$caleparttext2=str_replace($calepartnum, "", $_GET['caleparttext2']);
$calepartnum=str_replace("|", "", $calepartnum);

$reqPart = 'UPDATE calendrier_participants SET caleparttext2 = "'.$caleparttext2.'" WHERE calepartnum = "'.$calepartnum.'"';
$reqPartResult = $ConnexionBdd ->query($reqPart) or die ('Erreur SQL !'.$reqPart.'<br />'.mysqli_error());

$reqPart = 'SELECT * FROM calendrier_participants WHERE calepartnum = "'.$calepartnum.'"';
$reqPartResult = $ConnexionBdd ->query($reqPart) or die ('Erreur SQL !'.$reqPart.'<br />'.mysqli_error());
$reqPartAffich = $reqPartResult->fetch();
if($reqPartAffich['caleparttext2'] == 1 OR $reqPartAffich['caleparttext2'] == 2)
  {
    $reqPart = 'UPDATE calendrier_participants SET chevaux_chevnum = NULL WHERE calepartnum = "'.$calepartnum.'"';
    $reqPartResult = $ConnexionBdd ->query($reqPart) or die ('Erreur SQL !'.$reqPart.'<br />'.mysqli_error());
  }

?>
<script src="<?php echo $Dossier; ?>js/divers.js"></script>
