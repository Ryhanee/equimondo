<?php
session_start();
$Dossier = "../../";
include $Dossier."modules/divers/connexionbdd.php";
include $Dossier."modules/traduction/langCompl_".$_SESSION['infologlang2'].".php";
include $Dossier."modules/traduction/lang_".$_SESSION['infologlang1'].".php";
include $Dossier."modules/function/allfunction.php";
include $Dossier."modules/function/allfunction_divers.php";
include $Dossier."modules/envoimail1.php";

$clienum = $_GET['clienum'];

$identifiants = VerifLogin($_GET['clienum'],$_GET['utilnum'],$ConnexionBdd,$Dossier);

echo $NTrad223." :<br>";
echo $NTrad209." : <b style='font-weight:bolder;'>".$identifiants[0]."</b><br>";
echo $Trad253." : <b style='font-weight:bolder;'>".$identifiants[5]."</b><br>";

echo $_SESSION['STrad420'];
echo "<br>";

echo "<div style='display:none;'>";
$adresmail = $identifiants[1];
$message = $identifiants[2];
$objet = $identifiants[3];
$nom = $identifiants[4];
include $Dossier."modules/envoimail2.php";
echo "</div>";

?>
