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

$calepartnum = stristr($_GET['calepartnbdebit'], '|');
$calepartnum = strstr($_GET['calepartnbdebit'],'|');
$calepartnbdebit=str_replace($calepartnum, "", $_GET['calepartnbdebit']);
$calepartnum=str_replace("|", "", $calepartnum);

$reqPart = 'UPDATE calendrier_participants SET calepartnbdebit = "'.$calepartnbdebit.'" WHERE calepartnum = "'.$calepartnum.'"';
$reqPartResult = $ConnexionBdd ->query($reqPart) or die ('Erreur SQL !'.$reqPart.'<br />'.mysqli_error());

?>
<script src="<?php echo $Dossier; ?>js/divers.js"></script>
