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
include $Dossier."modules/function/allfunction_configuration.php";

$calepartnum = stristr($_GET['chevnum'], '|');
$calepartnum = strstr($_GET['chevnum'],'|');
$chevnumnum=str_replace($calepartnum, "", $_GET['chevnum']);
$calepartnum=str_replace("|", "", $calepartnum);

$reqPart = 'UPDATE calendrier_participants SET chevaux_chevnum = "'.$chevnumnum.'" WHERE calepartnum = "'.$calepartnum.'"';
$reqPartResult = $ConnexionBdd ->query($reqPart) or die ('Erreur SQL !'.$reqPart.'<br />'.mysqli_error());

$reqPart = 'SELECT * FROM calendrier_participants,clients,chevaux,calendrier WHERE calendrier_calenum = calenum AND calendrier_participants.chevaux_chevnum = chevnum AND calepartnum = "'.$calepartnum.'" AND clients_clienum = clienum';
$reqPartResult = $ConnexionBdd ->query($reqPart) or die ('Erreur SQL !'.$reqPart.'<br />'.mysqli_error());
$reqPartAffich = $reqPartResult->fetch();

$date1 = formatheure1($reqPartAffich['caledate1']);
$date1 = $date1[3]."-".$date1[4]."-".$date1[5];
$date2 = $date1;

if($reqPartAffich['clieniveau'] == "NULL") {$reqPartAffich['clieniveau']="";}

$Dispo = VerifDispo($reqPartAffich['chevnum'],$date1,$date2,$reqPartAffich['clienum'],null,$Dossier,$reqPartAffich['clieniveau'],$ConnexionBdd);

if(!empty($Dispo[2]))
  {
    echo $reqPartAffich['chevnom']." ".$NTrad291." ".$Dispo[2];
  }

?>
<script src="<?php echo $Dossier; ?>js/divers.js"></script>
