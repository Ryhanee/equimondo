<?php
$Dossier = "../../";
session_start();
include $Dossier."modules/divers/connexionbdd.php";
include $Dossier."modules/traduction/langCompl_".$_SESSION['infologlang2'].".php";
include $Dossier."modules/traduction/lang_".$_SESSION['infologlang1'].".php";
include $Dossier."modules/function/allfunction_calendrier.php";

?>
  <label for="inputPassword4" class="form-label"><?php echo $Trad1035; ?></label>
  <select id="selectBasic" class="form-control is-valid" name="caletext9" required>
    <?php echo DureeRepriseDebit($_GET['caletext9']); ?>
  </select>
  <div class="valid-feedback">Bien pris en compte</div>
