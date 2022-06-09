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
include $Dossier."modules/function/allfunction_clients.php";
include $Dossier."modules/function/allfunction_requete.php";
include $Dossier."modules/function/allfunction_calendrier.php";


if($_GET['calecatenum'] == "ajou")
  {
    ?>

    <div class="row g-3">
    <div class="col-md-6">
      <label for="inputEmail4" class="form-label"><?php echo $NTrad93; ?></label>
      <input type="text" class="form-control" name="calecatelibe" placeholder = "<?php echo $NTrad94;?>" required/>
    </div>
    <div class="col-md-6">
      <label for="inputPassword4" class="form-label"><?php echo $NTrad92; ?></label>
      <select id="selectBasic" class="form-control" name="calecatetype" onchange='AfficheCaleType(this.value)' required>
        <?php echo CalendrierCategorieType($num); ?>
      </select>
    </div>
    </div>
    <div id='DivAfficheCaleType'></div>
    <?php
  }
if($_GET['calecatenum'] != "ajou" AND !empty($_GET['calecatenum']))
  {
    $req = 'SELECT * FROM calendrier_categorie WHERE calecatenum = "'.$_GET['calecatenum'].'"';
		$reqResult = $ConnexionBdd ->query($req) or die ('Erreur SQL !'.$req.'<br />'.mysqli_error());
		$reqAffich = $reqResult->fetch();
    $_GET['calecatetype'] = $reqAffich['calecatetype'];
    echo "<input type='hidden' name='calecatetype' value='".$reqAffich['calecatetype']."'>";
  }

echo CalendrierCateType($_GET['calecatetype'],$ConnexionBdd,null,$Dossier);
?>
