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
include $Dossier."modules/function/allfunction_calendrier.php";

$_SESSION['InputModifcalenum'] = $_GET['calenum'];

$_SESSION['NumExec'] = 0;
$_SESSION['NumExecPrest'] = 0;

$req ='SELECT * FROM calendrier WHERE calenum = "'.$_GET['calenum'].'"';
$reqResult = $ConnexionBdd ->query($req) or die ('Erreur SQL !'.$req.'<br />'.mysqli_error());
$reqAffich = $reqResult->fetch();

$reqCate = 'SELECT * FROM calendrier_categorie WHERE calecatenum = "'.$reqAffich['calendrier_categorie_calecatenum'].'"';
$reqCateResult = $ConnexionBdd ->query($reqCate) or die ('Erreur SQL !'.$reqCate.'<br />'.mysqli_error());
$reqCateAffich = $reqCateResult->fetch();


echo "<a href='".$Dossier."modules/calendrier/modcalefichcomplet.php?calenum=".$_GET['calenum']."' class='AfficheCaleFichComplet btn btn-primary'>".$_SESSION['STrad305']."</a>";

echo "<br>";

// CALENDRIER CATERGORIE
?>
<div class="card mb-5"><div class="card-body">

  <div class="row g-3 mb-3">
    <div class="col-md-6">
      <!-- CATEGORIE -->
    <label for="inputPassword4" class="form-label"><?php echo $TradClieListCate; ?></label>
    <select id="selectBasic" class="form-control" name="calecatenum" onchange='AfficheCaleCateModif(this.value)' required>
      <?php echo CaleCateSelect($reqAffich['calendrier_categorie_calecatenum'],$ConnexionBdd,null); ?>
    </select>
    </div>

    <div class="col-md-6">
      <?php
      // LIBELLE
      if($reqCateAffich['calecatetype'] == 1 OR $reqCateAffich['calecatetype'] == 2)
        {
          ?>
            <label class="form-label"><?php echo $TradChevStan23; ?></label>
            <?php $_SESSION['NumExec'] = $_SESSION['NumExec'] + 1;?>
            <input type="text" class="form-control" id='InputModif<?php echo $_SESSION['NumExec'];?>' name="caletext13" placeholder="" value='<?php echo $reqAffich['caletext13'];?>' required/>
          <?php
        }
        ?>
    </div>
  </div>



  <div class="row g-3 mb-3">
    <div class="col-md-6">
      <!-- MONITEUR -->
      <label for="inputPassword4" class="form-label"><?php echo $TradClieListCate; ?></label>
      <select id="selectBasic" class="form-control" name="utilnum" onchange='AfficheCaleModifUtil(this.value)' required>
        <?php echo UtilSelect($reqAffich['utilisateurs_utilnum'],$ConnexionBdd,1,null,2); ?>
      </select>
    </div>

    <div class="col-md-6">
      <?php
      // HEURE
      if($reqCateAffich['calecatetype'] == 1)
        {
          ?>
          <label class="form-label"><?php echo $Trad955; ?></label>
          <?php
          $caledate1Calc = formatheure1($reqAffich['caledate1']);
          $caledate1Calc = $caledate1Calc[3]."-".$caledate1Calc[4]."-".$caledate1Calc[5];
          ?>
          <input type="date" class="form-control" name="caledate1" value='<?php echo $caledate1Calc;?>' onchange='AfficheCaleModifCaledate1(this.value)' required />

          <?php
        }
        ?>
    </div>
  </div>





<div class="row g-3 mb-3">
  <div class="col-md-6">
    <label for="inputPassword4" class="form-label"><?php echo $TradAjouLeconDureeReprise; ?></label>
    <select id="selectBasic" class="form-control" name="caletext1" onchange='AfficheCaleModifCaletext1(this.value)' required>
      <?php echo DureeReprise($reqAffich['caletext1']); ?>
    </select>
  </div>
  <?php // NOMBRE D HEURE A DEBITER ?>
  <div class="col-md-6">
    <label for="inputPassword4" class="form-label"><?php echo $TradAjouLeconDureeReprise; ?></label>
    <select id="selectBasic" class="form-control" name="caletext9" onchange='AfficheCaleModifCaletext9(this.value)' required>
      <?php echo DureeRepriseDebit($reqAffich['caletext9']); ?>
    </select>
  </div>
</div>



<div class="row g-3 mb-3">
  <div class="col-md-6">
    <label for="inputPassword4" class="form-label"><?php echo $_SESSION['STrad122']; ?></label>
    <select id="select2Multiple" class="form-control" name="calenivenum[]" onchange='NiveauCaleFichAjouSelect(this.value)' multiple>
      <?php echo CalendrierNiveau($num,$ConnexionBdd,"ajou",$_GET['calenum']); ?>
    </select>
    <div id='DivAfficheNiveau'></div>
  </div>
  <div class="col-md-6">
    <label for="inputPassword4" class="form-label"><?php echo $_SESSION['STrad293']; ?></label>
    <select id="selectBasic" class="form-control" name="calediscconfnum[]" onchange='DisciplineCaleFichAjouSelect(this.value)' multiple required>
      <?php echo CaleDiscSelect(null,$ConnexionBdd,null,$_GET['calenum']); ?>
    </select>
    <div id='DivDisciplineAjouSelect'></div>
  </div>
</div>


</div></div>
<div class="card mb-5"><div class="card-body">


<div class="row g-3">
  <div class="col-md-6">
    <label for="inputPassword4" class="form-label"><?php echo $_SESSION['STrad294']; ?></label>
    <select class="form-control" name="caletext7" onchange='AfficheCaleModifCaletext7(this.value)' required>
      <?php echo NbMaxPersonne($reqAffich['caletext7']);?>
    </select>
  </div>
  <div class="col-md-6">
    <label for="inputPassword4" class="form-label"><?php echo $_SESSION['STrad295']; ?></label>
    <select id="selectBasic" class="form-control" name="caletext8" onchange='InstallationAjouSelectModif(this.value)'>
      <?php echo InstSelect($reqAffich['caletext8'],$ConnexionBdd,null); ?>
    </select>
    <div id='DivInstallationAjouSelect'></div>
  </div>
</div>



<div class="row g-3">
    <div class="col-md-6">
        <label class="form-check-label" name="caletext14" for="customSwitchTopLabel"><?php echo $_SESSION['STrad806']; ?> :</label>
        <select id="selectBasic" class="form-control" name="caletext14" onchange='Caletext14(this.value)'>
          <?php echo AffichQuestOuiNonSelect($reqAffich['caletext14']); ?>
        </select>
        <label class="form-check-label" name="caletext15" for="customSwitchTopLabel"><?php echo $_SESSION['STrad807']; ?> :</label>
        <select id="selectBasic" class="form-control" name="caletext15" onchange='Caletext15(this.value)'>
          <?php echo AffichQuestOuiNonSelect($reqAffich['caletext15']); ?>
        </select>
    </div>

    <div class="col-md-6">
      <label class="form-label"><?php echo $_SESSION['STrad810']; ?> ?</label>
      <?php $_SESSION['NumExec'] = $_SESSION['NumExec'] + 1; ?>
      <input type="tel" class="form-control" name="caletext16" id='InputModif<?php echo $_SESSION['NumExec'];?>' value="<?php echo $reqAffich['caletext16']; ?>" />
    </div>

</div>


</div></div>
<?php


if($reqCateAffich['calecatetype'] == 5)
  {
    $_SESSION['NumExec'] = $_SESSION['NumExec'] + 1;
    $caledate1Calc = formatheure1($reqAffich['caledate1']);
    $caledate1Calc = $caledate1Calc[0].":".$caledate1Calc[1];
    echo "<tr><td><input type='time' name='caleheure1' id='InputModif".$_SESSION['NumExec']."' class='champ_barre ChampBarre50_1' placeholder='".$Trad1131."' value='".$caledate1Calc."'>";
    $_SESSION['NumExec'] = $_SESSION['NumExec'] + 1;
    echo "<input type='time' name='caleheure2' id='InputModif".$_SESSION['NumExec']."' class='champ_barre ChampBarre50_1' placeholder='".$_SESSION['STrad785']."' value='".$caledate2Calc."'></td></tr>";
  }

// COMMENTAIRE
$_SESSION['NumExec'] = $_SESSION['NumExec'] + 1;
?>
<div class="row g-3">
  <div class="col-12">
    <div class="mb-3 top-label">
      <textarea class="form-control" rows="3" name='caletext2' id='InputModif<?php echo $_SESSION['NumExec']; ?>'><?php echo nl2br($reqAffich['caletext2']); ?></textarea>
      <span><?php echo $Trad525; ?></span>
    </div>
  </div>
</div>
