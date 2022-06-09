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

if(!empty($_POST['calenum'])) {$calenum = $_POST['calenum'];}
if(!empty($_GET['calenum'])) {$calenum = $_GET['calenum'];}

// SUPPRIMER UNE CONDITION
if($_GET['calecondsupp'] == 2 AND !empty($_GET['calecondnum']))
  {
    $reqCond = 'DELETE FROM calendrier_conditions WHERE calecondnum = "'.$_GET['calecondnum'].'"';
		$reqCondResult = $ConnexionBdd ->query($reqCond) or die ('Erreur SQL !'.$reqCond.'<br />'.mysqli_error());
	}

// AJOUTER UNE CONDITION
if ($_POST['typeprestnum'] == TRUE)
	{
    for ($i=0,$n=count($_POST['typeprestnum']);$i<$n;$i++)
      {
        if(!empty($_POST['typeprestnum'][$i]))
          {
            $calecondnumOk = CaleConditions($Dossier,$ConnexionBdd,$_POST['calenum'],$_POST['typeprestnum'][$i],$_POST['typeprestprix'][$i],$_POST['calecondind'][$i]);
          }
      }
  }

echo CalendrierConditions($Dossier,$ConnexionBdd,$calenum);

?>
