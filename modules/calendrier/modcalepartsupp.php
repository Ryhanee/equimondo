<script src="../../js/divers.js"></script>
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

$_SESSION['NumExecCreneau'] = 1;

$req = 'DELETE FROM factprestation_association WHERE calendrier_participants_calepartnum = "'.$_GET['calepartnum'].'" OR calendrier_participants_calepartnum1 = "'.$_GET['calepartnum'].'"';
$reqResult = $ConnexionBdd ->query($req) or die ('Erreur SQL !'.$req.'<br />'.mysqli_error());

$req = 'DELETE FROM calendrier_participants WHERE calepartnum = "'.$_GET['calepartnum'].'"';
$reqResult = $ConnexionBdd ->query($req) or die ('Erreur SQL !'.$req.'<br />'.mysqli_error());

echo CalendrierParticipants($Dossier,$ConnexionBdd,$_GET['calenum']);

include $Dossier."footer.php";
?>
<script src="<?php echo $Dossier; ?>icon/acorn-icons.js"></script>
<script src="<?php echo $Dossier; ?>icon/acorn-icons-interface.js"></script>
