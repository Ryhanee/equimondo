<?php
$Dossier = "../../";
session_start();
include $Dossier."modules/divers/connexionbdd.php";
include $Dossier."modules/traduction/langCompl_".$_SESSION['infologlang2'].".php";
include $Dossier."modules/traduction/lang_".$_SESSION['infologlang1'].".php";
include $Dossier."modules/function/allfunction_calendrier.php";
include $Dossier."modules/function/allfunction_requete.php";

if(!empty($_GET['typeprestnum']))
  {
    $req1 = 'SELECT sum(typeprestprixprix) FROM typeprestation_prix WHERE typeprestation_typeprestnum = "'.$_GET['typeprestnum'].'" AND typeprestprixsupp = "1"';
		$req1Result = $ConnexionBdd ->query($req1) or die ('Erreur SQL !'.$req1.'<br />'.mysqli_error());
		$req1Affich = $req1Result->fetch();

    echo "<div class='row g-3'><div class='col-md-6'>";
        echo "<input type='hidden' name='typeprestnum[]' value='".$_GET['typeprestnum']."'>";
        echo "<label for='inputPassword4' class='form-label'>".$_SESSION['STrad826']." :</label>";
        echo "<input id='selectBasic' class='form-control is-valid' name='typeprestprix[]' value='".$req1Affich[0]."' required>";
        echo "</div>";

        echo "<div class='col-md-6'>";
        echo "<label for='inputPassword4' class='form-label'>".$_SESSION['STrad827']." :</label>";
        echo "<select id='selectBasic' class='form-control is-valid' name='calecondind[]'>".ConditionsReservationEnLigneSelect(null)."</select>";
    echo "</div></div>";
  }

echo "<label for='inputPassword4' class='form-label'>".$_SESSION['STrad815']."</label>";
$_SESSION['NumExecTypePrest'] = $_SESSION['NumExecTypePrest'] + 1;
echo "<select id='selectBasic' class='form-control' name='typeprestation' onchange='AfficheTypePrestationReservation".$_SESSION['NumExecTypePrest']."(this.value)'>";
echo TypePrestSelect(null,null,$ConnexionBdd,null,$AfficheNull,null);
echo "</select>";

echo "<div id='DivAfficheTypePrestationReservation".$_SESSION['NumExecTypePrest']."'></div>";

?>
