<?php
$Dossier = "../../";
session_start();
include $Dossier."modules/divers/connexionbdd.php";
include $Dossier."modules/traduction/langCompl_".$_SESSION['infologlang2'].".php";
include $Dossier."modules/traduction/lang_".$_SESSION['infologlang1'].".php";

if($_GET['q'] == "ajou")
  {
    ?>

    <input type="text" class="form-control" name="caleniveconflibe[]" placeholder='<?php echo $NTrad105; ?> 1' />
    <input type="text" class="form-control" name="caleniveconflibe[]" placeholder='<?php echo $NTrad105; ?> 2' />
    <input type="text" class="form-control" name="caleniveconflibe[]" placeholder='<?php echo $NTrad105; ?> 3' />
    <input type="text" class="form-control" name="caleniveconflibe[]" placeholder='<?php echo $NTrad105; ?> 4' />


    <?php
}
?>
