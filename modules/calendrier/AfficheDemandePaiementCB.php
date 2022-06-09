<?php
$Dossier = "../../";
session_start();
include $Dossier."modules/divers/connexionbdd.php";
include $Dossier."modules/traduction/langCompl_".$_SESSION['infologlang2'].".php";
include $Dossier."modules/traduction/lang_".$_SESSION['infologlang1'].".php";
?>
<div class="form-check form-switch">
<input type="checkbox" class="form-check-input" value="2" id="customSwitchTopLabel" onchange='AffichePourcPaiementCB(this.value)' />
<label class="form-check-label" name="Acompte" for="customSwitchTopLabel"><?php echo $_SESSION['STrad809']; ?></label>
</div>
<div id='noteAffichePourcPaiementCB'></div>
