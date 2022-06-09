<?php
$Dossier = "../../";
include $Dossier."header.php";
include $Dossier."modules/divers/MenuThemes.php";
?>

    <link rel="stylesheet" href="../../css/vendor/select2.min.css" />

    <link rel="stylesheet" href="../../css/vendor/select2-bootstrap4.min.css" />

    <link rel="stylesheet" href="../../css/vendor/bootstrap-datepicker3.standalone.min.css" />

<div id="root">
<main><div class="container"><div class="row"><div class="col">




<section class="scroll-section" id="address">
  <h2 class="small-title">Inscription en ligne</h2>
  <form class="tooltip-end-top" id="addressForm">
    <div class="card mb-5">
      <div class="card-body">
        <p class="text-alternate mb-4">
          Veuillez indiquer vos informations
        </p>
        <div class="row g-3">
          <div class="col-md-6">
            <label class="mb-3 top-label">
              <input class="form-control" name="addressFirstName" />
              <span>NOM</span>
            </label>
          </div>
          <div class="col-md-6">
            <label class="mb-3 top-label">
              <input class="form-control" name="addressLastName" />
              <span>PRENOM</span>
            </label>
          </div>
        </div>
        <div class="row g-3">
          <div class="col-md-6">
            <label class="mb-3 top-label">
              <input class="form-control" name="addressPhone" />
              <span>TELEPHONE</span>
            </label>
          </div>
          <div class="col-md-6">
            <label class="mb-3 top-label">
              <input class="form-control" name="addressCompany" />
              <span>ADRESSE MAIL</span>
            </label>
          </div>
        </div>
        <div class="row g-3">
          <div class="col-md-4">
            <label for="inputPassword4" class="form-label">PAYS</label>
            <select id="selectBasic" class="form-control" name="calecatenum" required>
              <?php echo CaleCateSelect($reqCaleAffich['calendrier_categorie_calecatenum'],$ConnexionBdd,"ajou"); ?>
            </select>
          </div>
          <div class="col-md-4">
            <label class="mb-3 top-label">
              <input class="form-control" name="addressPhone" />
              <span>VILLE</span>
            </label>
          </div>
          <div class="col-md-4">
            <label class="mb-3 top-label">
              <input class="form-control" name="addressZipCode" />
              <span>CODE POSTAL</span>
            </label>
          </div>
        </div>
        <div class="row g-3">
          <div class="col-12">
            <div class="mb-3 top-label">
              <textarea class="form-control" rows="2" name="addressDetail"></textarea>
              <span>ADRESSE POSTAL</span>
            </div>
          </div>
        </div>
      </div>


      <section class="scroll-section" id="singleImageUpload">
        <div class="card-footer border-0 pt-0 d-flex justify-content-end align-items-center">
        <h2 class="small-title">Télécharger votre photo de profil</h2>
        <div class="card">
          <div class="card-body">
            <form>
              <div class="position-relative d-inline-block" id="singleImageUploadExample">
                <img src="../../img/profile/profile-11.webp" alt="alternate text" class="rounded-xl border border-separator-light border-4 sw-11 sh-11" />
                <button class="btn btn-sm btn-icon btn-icon-only btn-separator-light rounded-xl position-absolute e-0 b-0" type="button">
                  <i data-acorn-icon="upload"></i>
                </button>
                <input class="file-upload d-none" type="file" accept="image/*" />
              </div>
            </form>
          </div>
        </div>
      </div>
    </section>

      <div class="card-footer border-0 pt-0 d-flex justify-content-end align-items-center">
        <div>
          <div class='form-check form-switch'><input type='checkbox' name='calenum[]' value='".$reqAffich['calenum']."' class='form-check-input' id='customSwitchTopLabel' required/> Veuillez accepter les conditions générals de vente
        </div>
      </div>

      <br>
      <div class="card-footer border-0 pt-0 d-flex justify-content-end align-items-center">
        <div>
          <button class="btn btn-icon btn-icon-end btn-primary" type="submit">
            <span>Je m'inscris</span>
            <i data-acorn-icon="chevron-right"></i>
          </button>
        </div>
      </div>

    </div>





  </form>
</section>


</div></div></div></main>
</div>


<?php
include $Dossier."footer.php";
?>
