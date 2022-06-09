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
include $Dossier."js/divers.php";
echo $_SESSION['MiseEnFormeDivers'];

echo "<form id='CalejouCavalierDePassage'>";
  echo "<input type='hidden' name='calenum' value='".$_GET['calenum']."'>";
  echo "<div style='height:10px;'></div>";
  echo "<div class='InfoStandard FormInfoStandard1'>".$NTrad153." :</div>";
  echo "<input type='text' name='clienom' class='champ_barre' style='width:49%;' placeholder='".$TradClieStanNom."' required>";
  echo "<input type='text' name='clieprenom' class='champ_barre' style='width:49%;' placeholder='".$TradClieStanPrenom."'>";
  echo "<input type='text' name='clienumtel' class='champ_barre' style='width:49%;' placeholder='".$TradClieStanTel."'>";
  echo "<input type='text' name='clieadremail' class='champ_barre' style='width:49%;' placeholder='".$TradClieStanAdresMail."'>";
  echo "<div style='height:10px;'></div>";
  echo "<div class='InfoStandard FormInfoStandard1'>".$Trad166." :</div>";
  echo "<input type='text' name='clienom1' class='champ_barre' style='width:49%;' placeholder='".$TradClieStanNom."'>";
  echo "<input type='text' name='clieprenom1' class='champ_barre' style='width:49%;' placeholder='".$TradClieStanPrenom."'>";
  echo "<input type='text' name='clienumtel1' class='champ_barre' style='width:49%;' placeholder='".$TradClieStanTel."'>";
  echo "<input type='text' name='clieadremail1' class='champ_barre' style='width:49%;' placeholder='".$TradClieStanAdresMail."'>";

  echo "<button class='button'><img src='".$Dossier."images/validerBlanc.png' class='ImgSousMenu2'>".$TradDivButtAjou."</button>";
echo "</form>";


?>
