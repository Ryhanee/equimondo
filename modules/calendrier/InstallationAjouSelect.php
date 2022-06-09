<?php
$Dossier = "../../";
session_start();
include $Dossier."modules/divers/connexionbdd.php";
include $Dossier."modules/traduction/langCompl_".$_SESSION['infologlang2'].".php";
include $Dossier."modules/traduction/lang_".$_SESSION['infologlang1'].".php";

if($_GET['q'] == "ajou")
  {
    ?>
    <input type="text" class="form-control" name="planlecomodinstalAjou" placeholder='<?php echo $NTrad101; ?>' required/>

    <?php
  }
?>
