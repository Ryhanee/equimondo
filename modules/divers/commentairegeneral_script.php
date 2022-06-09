<?php
$Dossier = "../../";
session_start();
include $Dossier."modules/divers/connexionbdd.php";
include $Dossier."modules/traduction/langCompl_".$_SESSION['infologlang2'].".php";
include $Dossier."modules/traduction/lang_".$_SESSION['infologlang1'].".php";
include $Dossier."modules/function/allfunction.php";
include $Dossier."modules/function/allfunction_requete.php";
include $Dossier."modules/function/allfunction_divers.php";
include $Dossier."modules/scripts/formulaire_ajax_divers.php";

if(!empty($_GET['factnum'])) {$_POST['factnum'] = $_GET['factnum'];}
if(!empty($_GET['clienum'])) {$_POST['clienum'] = $_GET['clienum'];}
if(!empty($_GET['calenum'])) {$_POST['calenum'] = $_GET['calenum'];}
if(!empty($_GET['chevnum'])) {$_POST['chevnum'] = $_GET['chevnum'];}

if(!empty($_GET['commgenenum']) AND $_GET['commgenesupp'] == 2)
  {
    $req1 = 'DELETE FROM commentairesgenerals WHERE commgenenum = "'.$_GET['commgenenum'].'"';
    $req1Result = $ConnexionBdd ->query($req1) or die ('Erreur SQL !'.$req1.'<br />'.mysqli_error());
  }

if(!empty($_POST['commgenelibe']))
  {
    if(empty($_POST['factnum'])) {$_POST['factnum'] = "NULL";}
    if(empty($_POST['clienum'])) {$_POST['clienum'] = "NULL";}
    if(empty($_POST['calenum'])) {$_POST['calenum'] = "NULL";}
    if(empty($_POST['chevnum'])) {$_POST['chevnum'] = "NULL";}
    $req1 = 'INSERT INTO commentairesgenerals VALUE (NULL,"'.date('Y-m-d H:i:s').'","'.$_POST['authnum'].'",'.$_POST['factnum'].','.$_POST['calenum'].','.$_POST['clienum'].','.$_POST['chevnum'].','.$_SESSION['hebeappnum'].',"'.SecureInput($_POST['commgenelibe']).'")';
    $req1Result = $ConnexionBdd ->query($req1) or die ('Erreur SQL !'.$req1.'<br />'.mysqli_error());
  }

if($_POST['factnum'] == "NULL") {$_POST['factnum'] = "";}
if($_POST['clienum'] == "NULL") {$_POST['clienum'] = "";}
if($_POST['calenum'] == "NULL") {$_POST['calenum'] = "";}
if($_POST['chevnum'] == "NULL") {$_POST['chevnum'] = "";}

echo CommentairesGenerals($Dossier,$ConnexionBdd,$_POST['factnum'],$_POST['clienum'],$_POST['chevnum'],$_POST['calenum']);
?>
<script src="<?php echo $Dossier; ?>js/divers.js"></script>
