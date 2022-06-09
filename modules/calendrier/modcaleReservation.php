<?php
$Dossier = "../../";
session_start();
include $Dossier."modules/divers/connexionbdd.php";
include $Dossier."modules/traduction/langCompl_".$_SESSION['infologlang2'].".php";
include $Dossier."modules/traduction/lang_".$_SESSION['infologlang1'].".php";
include $Dossier."modules/function/allfunction.php";
include $Dossier."modules/scripts/formulaire_ajax_boucle.php";
include $Dossier."modules/scripts/formulaire_ajax_calendrier.php";
include $Dossier."modules/function/allfunction_clients.php";
include $Dossier."modules/function/allfunction_requete.php";
include $Dossier."modules/function/allfunction_calendrier.php";

$reqCale = 'SELECT *FROM calendrier WHERE calenum = "'.$_GET['calenum'].'"';
$reqCaleResult = $ConnexionBdd ->query($reqCale) or die ('Erreur SQL !'.$reqCale.'<br />'.mysqli_error());
$reqCaleAffich = $reqCaleResult->fetch();

echo "<div style='height:20px;width:100%;clear:both;display:block;'></div>";

if(!empty($_SESSION['authconnauthnum']))
  {
    echo "<div class='card mb-5'><div class='card-body'>";

    echo "<form id='CaleReservationOk' action=''>";
    echo "<input type='hidden' name='calenum' value='".$_GET['calenum']."'>";

    // VERIF SI IL Y A PLUSIEURS MEMBRE DE LA MEME FAMILLE
    $req1 = 'SELECT familleclients_famiclienum FROM clients WHERE clienum = "'.$_SESSION['connauthnum'].'"';
    $req1Result = $ConnexionBdd ->query($req1) or die ('Erreur SQL !'.$req1.'<br />'.mysqli_error());
		$req1Affich = $req1Result->fetch();

    $req2 = 'SELECT count(clienum) FROM clients WHERE familleclients_famiclienum = "'.$req1Affich['familleclients_famiclienum'].'"';
    $req2Result = $ConnexionBdd ->query($req2) or die ('Erreur SQL !'.$req2.'<br />'.mysqli_error());
		$req2Affich = $req2Result->fetch();

    // SI IL A UNE FAMILLE
    if($req2Affich[0] >= 2)
      {
        echo $TradErrPlanAjouCaval3." :<br><br>";
        $req2 = 'SELECT * FROM clients WHERE familleclients_famiclienum = "'.$req1Affich['familleclients_famiclienum'].'"';
        $req2Result = $ConnexionBdd ->query($req2) or die ('Erreur SQL !'.$req2.'<br />'.mysqli_error());
    		while($req2Affich = $req2Result->fetch())
          {
            // SELECT LA PRESTATION
            if(!empty($reqCaleAffich['caletext16']) OR $reqCaleAffich['caletext14'] == 2)
              {
                $calecondnum = CalendrierConditionsResultat($Dossier,$ConnexionBdd,$_GET['calenum'],$req2Affich['clienum']);
              }
            if(!empty($calecondnum))
              {
                $req3 = 'SELECT * FROM calendrier_conditions WHERE calecondnum = "'.$calecondnum.'"';
                $req3Result = $ConnexionBdd ->query($req3) or die ('Erreur SQL !'.$req3.'<br />'.mysqli_error());
            		$req3Affich = $req3Result->fetch();
                $LibePrest = "(".TypePrestationLect($req3Affich['typeprestation_typeprestnum'],$ConnexionBdd)." ".number_format($req3Affich['calecondprix'], 2, '.', '')." ".$_SESSION['STrad27'].")";
              }
            else {$LibePrest = "";}

            if(empty($calecondnum)) {$calecondnum = "NULL";}

            echo "<input type='checkbox' class='form-check-input' name='clienum[]' value='".$req2Affich['clienum']."' id='customSwitchTopLabel' /> ";
            echo "<label class='form-check-label' for='customSwitchTopLabel'> ".$req2Affich['clienom']." ".$req2Affich['clieprenom']." ".$LibePrest."</label><br>";
            echo "<input type='hidden' name='calecondnum[]' value='".$calecondnum."'>";
          }
      }

    // SI IL N A PAS DE FAMILLE
    if($req2Affich[0] == 1 OR empty($req1Affich['familleclients_famiclienum']))
      {
        // SELECT LA PRESTATION
        if(!empty($reqCaleAffich['caletext16']) OR $reqCaleAffich['caletext14'] == 2)
          {
            $calecondnum = CalendrierConditionsResultat($Dossier,$ConnexionBdd,$_GET['calenum'],$_SESSION['connauthnum']);
          }
        if(!empty($calecondnum))
          {
            $req3 = 'SELECT * FROM calendrier_conditions WHERE calecondnum = "'.$calecondnum.'"';
            $req3Result = $ConnexionBdd ->query($req3) or die ('Erreur SQL !'.$req3.'<br />'.mysqli_error());
            $req3Affich = $req3Result->fetch();
            $LibePrest = "(".TypePrestationLect($req3Affich['typeprestation_typeprestnum'],$ConnexionBdd)." ".number_format($req3Affich['calecondprix'], 2, '.', '')." ".$_SESSION['STrad27'].")";
          }
        else {$LibePrest = "";}

        if(empty($calecondnum)) {$calecondnum = "NULL";}

        echo "<input type='hidden' name='clienum[]' value='".$_SESSION['connauthnum']."'>";
        echo "<input type='hidden' name='calecondnum[]' value='".$calecondnum."'>";
      }

    echo "<div style='height:20px;width:100%;clear:both;display:block;'></div>";
    echo "<button type='submit' class='btn btn-primary'>".$Trad451."</button>";

    echo "</form>";

    echo "</div></div>";
  }

echo "<div style='height:20px;width:100%;clear:both;display:block;'></div>";
?>
<script src="<?php echo $Dossier; ?>js/divers.js"></script>
