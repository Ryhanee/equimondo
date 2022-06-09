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
include $Dossier."modules/scripts/formulaire_ajax_clients.php";
include $Dossier."modules/function/allfunction_requete.php";
include $Dossier."modules/function/allfunction_clients.php";
include $Dossier."modules/function/allfunction_calendrier.php";
?>

<link rel="stylesheet" href="<?php echo $Dossier; ?>css/vendor/select2-bootstrap4.min.css" />
<link rel="stylesheet" href="<?php echo $Dossier; ?>css/vendor/select2.min.css" />
<script src="<?php echo $Dossier; ?>js/vendor/jquery-3.5.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
<script src="<?php echo $Dossier; ?>js/forms/controls.select2.js"></script>

<?php
$_SESSION['NumExecCreneau'] = 1;

if($_POST['calepartheure1'] == TRUE)
	{
		for ($i=0,$n=count($_POST['calepartheure1']);$i<$n;$i++)
			{
				if(!empty($_POST['calepartheure1'][$i]))
					{
						$calepartdate1 = $_POST['calepartdate1'][$i]." ".$_POST['calepartheure1'][$i].":00";
						$ok = CalendrierPartAjou(null,$_POST['calenum'],$_POST['clienum'],$chevnum,2,3,$caleparttext3,$caleparttext4,$caleparttext5,$caleparttext6,$caleparttext7,$equinum,$cliesoldentrnum,$calepartdate1,$calepartdate2,$ConnexionBdd,"ajou",$depecat,$depemontantttc,$caledate1,$depetauxtva,$calepartnumasso);
					}
			}
	}

if($_POST['clienum'] == TRUE)
	{
		for ($i=0,$n=count($_POST['clienum']);$i<$n;$i++)
			{
				if(!empty($_POST['clienum'][$i]))
					{
						$ok = CalendrierPartAjou(null,$_POST['calenum'],$_POST['clienum'][$i],$chevnum,2,3,$caleparttext3,$caleparttext4,$caleparttext5,$caleparttext6,$caleparttext7,$equinum,$cliesoldentrnum,null,$calepartdate2,$ConnexionBdd,"ajou",$depecat,$depemontantttc,$caledate1,$depetauxtva,$calepartnumasso);
					}
			}
	}

if($_POST['chevnum'] == TRUE)
	{
		for ($i=0,$n=count($_POST['chevnum']);$i<$n;$i++)
			{
				if(!empty($_POST['chevnum'][$i]))
					{
						$ok = CalendrierPartAjou(null,$_POST['calenum'],null,$_POST['chevnum'][$i],2,$_POST['caleparttext2'],$caleparttext3,$caleparttext4,$caleparttext5,$caleparttext6,$caleparttext7,$equinum,$cliesoldentrnum,null,$calepartdate2,$ConnexionBdd,"ajou",$depecat,$depemontantttc,$caledate1,$depetauxtva,$calepartnumasso);
					}
			}
	}

echo CalendrierParticipants($Dossier,$ConnexionBdd,$_POST['calenum']);

?>
