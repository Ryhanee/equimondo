<?php
$Dossier = "../../";
session_start();
include $Dossier."modules/divers/connexionbdd.php";
include $Dossier."modules/traduction/langCompl_".$_SESSION['infologlang2'].".php";
include $Dossier."modules/traduction/lang_".$_SESSION['infologlang1'].".php";
?>
<label class="form-label"><?php echo $_SESSION['STrad810']; ?> ?</label>
<input type="text" class="form-control" name="caletext16" placeholder="Ex : 30" required />
