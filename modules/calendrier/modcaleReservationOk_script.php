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

$reqCale = 'SELECT * FROM calendrier WHERE calenum = "'.$calenum.'"';
$reqCaleResult = $ConnexionBdd ->query($reqCale) or die ('Erreur SQL !'.$reqCale.'<br />'.mysqli_error());
$reqCaleAffich = $reqCaleResult->fetch();

//echo "<a href='".$Dossier."modules/calendrier/modcalefichcomplet.php?calenum=".$reqCaleAffich['calenum']."' class='AfficheCaleFichComplet btn btn-primary'>".$_SESSION['STrad305']."</a>";

$paninum = CreationPanier($Dossier,$ConnexionBdd);
if($_POST['clienum'] == TRUE)
	{
		for ($i=0,$n=count($_POST['clienum']);$i<$n;$i++)
			{
				if(!empty($_POST['clienum'][$i]))
					{
            $reqCond = 'SELECT * FROM calendrier_conditions WHERE calecondnum = "'.$_POST['calecondnum'][$i].'"';
            $reqCondResult = $ConnexionBdd ->query($reqCond) or die ('Erreur SQL !'.$reqCond.'<br />'.mysqli_error());
        		$reqCondAffich = $reqCondResult->fetch();

            $caissyst1num = CaissePrestationsAjou($Dossier,$ConnexionBdd,$reqCondAffich['typeprestation_typeprestnum'],2,$reqCondAffich['calecondprix'],$_POST['clienum'][$i],null,$paninum);
          }
      }
  }

echo "<div style='height:20px;width:100%;clear:both;display:block;'></div>";

echo "<form id='CalePayerCb' action=''>";
echo "<input type='hidden' name='paninum' value='".$paninum."'>";
echo "<input type='hidden' name='calenum' value='".$calenum."'>";

echo "<div class='row'>";

echo "<div class='col-12 col-xxl-6 mb-5 h-100-card'><div class='card h-100'><div class='card-body row g-0'><div class='col-12'>";
echo "<div class='cta-3'>".RdvLibelle($reqCaleAffich['calenum'],$ConnexionBdd)."</div>";
echo "<div class='row gx-2'><div class='col'>";

echo "<div class='mb-3 cta-3 text-primary'>".$_SESSION['STrad828']."</div>";

if($_POST['clienum'] == TRUE)
	{
		for ($i=0,$n=count($_POST['clienum']);$i<$n;$i++)
			{
				if(!empty($_POST['clienum'][$i]))
					{
            echo "<div class='card mb-5'><div class='card-body'>";
            echo "<table>";
            echo "<tr><td>".$NTrad153." :</td><td>".ClieLect($_POST['clienum'][$i],$ConnexionBdd)."</td></tr>";
            $reqCond = 'SELECT * FROM calendrier_conditions WHERE calecondnum = "'.$_POST['calecondnum'][$i].'"';
            $reqCondResult = $ConnexionBdd ->query($reqCond) or die ('Erreur SQL !'.$reqCond.'<br />'.mysqli_error());
        		$reqCondAffich = $reqCondResult->fetch();

            echo "<tr><td>".$TradFactStan6." :</td><td>".TypePrestationLect($reqCondAffich['typeprestation_typeprestnum'],$ConnexionBdd)." ".number_format($reqCondAffich['calecondprix'], 2, '.', '')." ".$_SESSION['STrad27']." ".ConditionsReservationEnLigneLect($reqCondAffich['calecondind '])."</td></tr>";

            $caissyst1num = CaissePrestationsAjou($Dossier,$ConnexionBdd,$reqCondAffich['typeprestation_typeprestnum'],2,$reqCondAffich['calecondprix'],$_POST['clienum'][$i],null,$paninum);
            echo "</table>";
            echo "</div></div>";
          }
      }
  }

echo "<div class='card mb-5'><div class='card-body'>";
echo "<div class='form-check form-switch'>";
  echo "<input type='checkbox' class='form-check-input' value='2' name='conditions' id='customSwitchTopLabel' required/>";
  echo "<label class='form-check-label' for='customSwitchTopLabel'>".$_SESSION['STrad831']."</label>";
echo "</div>";
echo "<button type='submit' class='btn btn-primary'>".$_SESSION['STrad829']."</button>";
echo "</div></div>";


echo "</div></div></div></div></div></div>";


echo "<div class='col-12 col-xxl-6 mb-5 h-100-card'><div class='card h-100 bg-gradient-light'><div class='card-body row g-0'><div class='col-12'><div class='row gx-2'><div class='col'><div class='text-muted mb-3 mb-sm-0 pe-3 text-white'>";
$reqPanier = 'SELECT sum(caissyst2prix) FROM panier_association,caissesysteme1,caissesysteme2 WHERE caissesysteme2.caissesysteme1_caissyst1num = caissyst1num AND panier_association.caissesysteme1_caissyst1num = caissyst1num AND panier_paninum = "'.$paninum.'"';
$reqPanierResult = $ConnexionBdd ->query($reqPanier) or die ('Erreur SQL !'.$reqPanier.'<br />'.mysqli_error());
$reqPanierAffich = $reqPanierResult->fetch();
echo "<div style='font-size:25px;'>".$_SESSION['STrad830']." : ".number_format($reqPanierAffich[0], 2, '.', '')." ".$_SESSION['STrad27']."</div>";
echo "</div></div></div></div></div></div></div>";


echo "</div>";

echo "</form>";

echo "<div style='height:20px;width:100%;clear:both;display:block;'></div>";
?>
<script src="<?php echo $Dossier; ?>js/divers.js"></script>
