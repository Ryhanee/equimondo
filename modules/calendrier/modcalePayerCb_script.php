<?php
$Dossier = "../../";
session_start();
include $Dossier."modules/divers/connexionbdd.php";
include $Dossier."modules/traduction/langCompl_".$_SESSION['infologlang2'].".php";
include $Dossier."modules/traduction/lang_".$_SESSION['infologlang1'].".php";
include $Dossier."modules/function/allfunction.php";
include $Dossier."modules/scripts/formulaire_ajax_boucle.php";
include $Dossier."modules/scripts/formulaire_ajax_calendrier.php";
include $Dossier."modules/function/allfunction_clients.php";
include $Dossier."modules/function/allfunction_requete.php";
include $Dossier."modules/function/allfunction_calendrier.php";

if(!empty($_GET['calenum'])) {$calenum = $_GET['calenum'];}
if(!empty($_POST['calenum'])) {$calenum = $_POST['calenum'];}

if($_POST['conditions'] != 2)
  {
    echo "<div class='alert alert-danger' role='alert'>".$_SESSION['STrad832']."</div>";
    exit;
  }
else
  {
    $reqPanier = 'SELECT sum(caissyst2prix) FROM panier_association,caissesysteme1,caissesysteme2 WHERE caissesysteme2.caissesysteme1_caissyst1num = caissyst1num AND panier_association.caissesysteme1_caissyst1num = caissyst1num AND panier_paninum = "'.$_POST['paninum'].'"';
    $reqPanierResult = $ConnexionBdd ->query($reqPanier) or die ('Erreur SQL !'.$reqPanier.'<br />'.mysqli_error());
    $reqPanierAffich = $reqPanierResult->fetch();
    echo "<div class='card mb-5'><div class='card-body'>";

    echo "<div class='cta-3'>".$_SESSION['STrad833']."</div>";

    echo "<div class='alert alert-success' role='alert'>".$_SESSION['STrad834']." ".number_format($reqPanierAffich[0], 2, '.', '')." ".$_SESSION['STrad27']."<br>";
    echo "</div></div>";
  }

?>
<script src="<?php echo $Dossier; ?>js/divers.js"></script>
