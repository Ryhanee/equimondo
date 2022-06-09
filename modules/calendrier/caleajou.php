<?php
$Dossier = "../../";
include $Dossier."header.php";
include $Dossier."modules/divers/MenuThemes.php";
$_SESSION['NumExecPrest'] = 1;
$_SESSION['NumExecTypePrest'] = 1;
?>

<!-- ********** CSS INDEX ********** -->
<link rel="stylesheet" href="<?php echo $Dossier; ?>css/vendor/select2.min.css" />
<link rel="stylesheet" href="<?php echo $Dossier; ?>css/vendor/select2-bootstrap4.min.css" />
<link rel="stylesheet" href="<?php echo $Dossier; ?>css/vendor/bootstrap-datepicker3.standalone.min.css" />
<link rel="stylesheet" href="<?php echo $Dossier; ?>css/vendor/tagify.css" />
<!-- ********************** -->

<div id="root">
<main><div class="container"><div class="row"><div class="col">

<section class="scroll-section" id="formRow">

  <div id='AfficheCalendrier'>
  <?php
  if(!empty($_GET['calenum']))
    {
      echo CalendrierFicheComplet($Dossier,$ConnexionBdd,$_GET['calenum']);
    }
  else
    {
  ?>
  <form id='FormCaleAjou' class="row g-3" action=''>
  <input type='hidden' name='caleaction' value='ajou'>
  <div class="card mb-5"><div class="card-body">
      <label for="inputPassword4" class="form-label"><?php echo $NTrad39; ?></label>
      <select id="selectBasic" class="form-control" name="calecatenum" onchange='AfficheCaleCate(this.value)' required>
        <?php echo CaleCateSelect($reqCaleAffich['calendrier_categorie_calecatenum'],$ConnexionBdd,"ajou"); ?>
      </select>
  </div></div>

  <div id='DivAfficheCaleCate'></div>

  <div class="card mb-5"><div class="card-body">
    <div class="mb-3">
      <label class="form-label"><?php echo $Trad525; ?></label>
      <textarea placeholder="" name="caletext2" class="form-control" rows="3"></textarea>
    </div>
  </div></div>

    <button type="submit" class="btn btn-primary"><?php echo $TradDivButtAjou;?></button>
  </form>
  <?php
    }
  ?>
  </div>

</section>
</div></div></div></main>
</div>

<?php
include $Dossier."footer.php";
?>
