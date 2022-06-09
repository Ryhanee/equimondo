<?php
$Dossier = "../../";
session_start();
include $Dossier."modules/divers/connexionbdd.php";
include $Dossier."modules/traduction/langCompl_".$_SESSION['infologlang2'].".php";
include $Dossier."modules/traduction/lang_".$_SESSION['infologlang1'].".php";
?>
<div class="form-check form-switch">
  <input type="checkbox" class="form-check-input" name="caletext15" onchange='AffichePaiementCB(this.value)' value="2" id="customSwitchTopLabel" />
  <label class="form-check-label" for="customSwitchTopLabel"><?php echo $_SESSION['STrad807']; ?></label>
</div>
