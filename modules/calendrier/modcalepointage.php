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
include $Dossier."modules/function/allfunction_clients.php";
include $Dossier."modules/function/allfunction_calendrier.php";
$_SESSION['NumExecPrest'] = 0;

echo "<section style='padding:20px;'>";

if(!empty($_GET['date'])) {echo "<form id='FormCalePointage1' action=''>";}
else
  {
    echo "<form id='FormCalePointage' action=''>";
  }
echo "<input type='hidden' name='calemethodvalid' value='".$calemethodvalide."'>";
echo "<input type='hidden' name='indice' value=".$_GET['indice'].">";
echo "<input type='hidden' name='date' value=".$_GET['date'].">";

$req = 'SELECT calenum,caledate1,caleheure1,caletext1,utilisateurs_utilnum,caletext9,caletext6,calecatetype FROM calendrier,calendrier_categorie WHERE calendrier_categorie_calecatenum = calecatenum AND (calecatetype = "1" OR calecatetype = "2") '.$Condition.' AND calendrier.AA_equimondo_hebeappnum = "'.$_SESSION['hebeappnum'].'"';
if(!empty($_GET['utilnum'])) {$req.=' AND calendrier.utilisateurs_utilnum = "'.$_GET['utilnum'].'"';}
if(!empty($_GET['calenum'])) {$req.=' AND calenum = "'.$_GET['calenum'].'"';}
$req.=' ORDER BY caledate1 ASC';
$reqResult = $ConnexionBdd ->query($req) or die ('Erreur SQL !'.$req.'<br />'.mysqli_error());
while($reqAffich = $reqResult->fetch())
  {
    $dateCale = formatheure1($reqAffich[1]);
    $dateCale = $dateCale[3]."-".$dateCale[4]."-".$dateCale[5];

    $RDVCOLOR = RdvColor($reqAffich['calenum'],$ConnexionBdd);
    echo "<div class='top-label custom-control-container'><div class='form-check form-switch'><input type='checkbox' name='calenum[]' value='".$reqAffich['calenum']."' class='form-check-input' id='customSwitchTopLabel' checked/><label class='form-check-label' for='customSwitchTopLabel'>".RdvLibelle($reqAffich['calenum'],$ConnexionBdd)." - ".UtilLect($reqAffich['utilisateurs_utilnum'],$ConnexionBdd)."</label><a href='".$Dossier."modules/calendrier/modcalefichcomplet.php?calenum=".$reqAffich['calenum']."' style='float:right;' class='form-check-label AfficheCaleFichComplet'>".$NTrad322."</a></div><span>".FormatDateTimeMySql($reqAffich[1])."</span></div>";

    echo "<div style='height:10;clear:both;display:block;width:100%;'></div>";
    echo "<div class='top-label custom-control-container' background-color:".$RDVCOLOR.";>";

    // VERIF S'IL Y A DES CAVALIERS
    $reqVerif1 = 'SELECT count(calepartnum) FROM calendrier_participants WHERE calendrier_calenum = "'.$reqAffich[0].'"';
    $reqVerif1Result = $ConnexionBdd ->query($reqVerif1) or die ('Erreur SQL !'.$reqVerif1.'<br />'.mysqli_error());
    $reqVerif1Affich = $reqVerif1Result->fetch();
    if($reqVerif1Affich[0] == 0) {echo "<div style='clear:both;display:block;width:100%;'>".$Trad691."</div>";}
    else
      {
        echo "<table class='table'>";
        $req1 = 'SELECT calepartnum,clienum,clienom,clieprenom,caleparttext2,calepartnbdebit FROM calendrier_participants,clients WHERE clients_clienum = clienum AND calendrier_calenum = "'.$reqAffich[0].'"';
        $req1Result = $ConnexionBdd ->query($req1) or die ('Erreur SQL !'.$req1.'<br />'.mysqli_error());
        while($req1Affich = $req1Result->fetch())
          {
            echo "<tr>";
            echo "<td>".$req1Affich[2]." ".$req1Affich[3]."</td>";
            echo "<td><select name='calepartstatus[]' class='form-control' onchange='CaleSelectStatus(this.value)'>".ReprisePresenceSelect($req1Affich['caleparttext2'],$req1Affich['calepartnum'])."</select></td>";
            $Forf = CalePointageReprise($req1Affich[1],$reqAffich[5],$reqAffich[1],$req1Affich[0],$ConnexionBdd);
            echo "<td><select name='calepartforf[]' class='form-control' required>".$Forf."</select></td>";
            $_SESSION['NumExecPrest'] = $_SESSION['NumExecPrest'] + 1;
            echo "<td><select name='calepartnbdebit' class='form-control' onchange='CalePartNbDebitSelect".$_SESSION['NumExecPrest']."(this.value)'>".DureeRepriseDebit($req1Affich['calepartnbdebit'],$req1Affich['calepartnum'])."</select></td>";
            echo "</tr>";
          }
        echo "</table>";
      }
    echo "</div>";
    echo "<div style='height:15px;clear:both;display:block;'></div>";
  }

echo "<button type='submit' class='btn btn-primary'>".$Trad716."</button>";
echo "</form>";

echo "</section>";
?>
