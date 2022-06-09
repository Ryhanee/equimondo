<script src="../../js/divers.js"></script>
<?php
$Dossier = "../../";
session_start();
include $Dossier."modules/divers/connexionbdd.php";
include $Dossier."modules/traduction/langCompl_".$_SESSION['infologlang2'].".php";
include $Dossier."modules/traduction/lang_".$_SESSION['infologlang1'].".php";
include $Dossier."modules/scripts/formulaire_ajax_boucle.php";
include $Dossier."modules/scripts/formulaire_ajax_calendrier.php";
include $Dossier."modules/function/allfunction_requete.php";
include $Dossier."modules/function/allfunction.php";
include $Dossier."modules/function/allfunction_calendrier.php";
include $Dossier."modules/function/allfunction_clients.php";
include $Dossier."modules/function/allfunction_divers.php";
include $Dossier."modules/function/allfunction_configuration.php";

include $Dossier."js/divers.php";
echo $_SESSION['MiseEnFormeDivers'];

$cliesupp = 1;
$clieautoappli = 2;
$action = "ajou";
$cliecivilite = 1;


// AJOUTER UN CLIENT DE PASSAGE
if(!empty($_POST['clienom']))
  {
    $cliestatus = 1;
    $clienum = ClieAjou(null,$_POST['clienom'],$_POST['clieprenom'],$cliedatenaiss,$clieadre,$cliecp,$clieville,$_POST['clienumtel'],$clienumlic,$cliecommentaire,$_POST['clieadremail'],$clieniveau,$cliecivilite,$cliepays,$cliesupp,$clieautoappli,$clienumtel1,$cliedatevallic,$cliedateinscription,$cliedatecotisation,$famiclienum,$clieresplegal,$clienumcompte,$cliestatus,$ConnexionBdd,$action,$clienbheurerestant,$clieprovince,$groupnum,$chevnum,$avoipart);

    // ENVOI IDENTIFIANTS PAR MAIL
    if(!empty($_POST['clieadremail']) )
      {
        $identifiants = VerifLogin($clienum[0],null,$ConnexionBdd,$Dossier);
        echo "<div style='display:none;'>";
        $adresmail = $identifiants[1];
        $message = $identifiants[2];
        $objet = $identifiants[3];
        $nom = $identifiants[4];
        include $Dossier."modules/envoimail2.php";
        echo "</div>";
      }

    $ok = CalendrierPartAjou(null,$_POST['calenum'],$clienum[0],$chevnum,2,3,$caleparttext3,$caleparttext4,$caleparttext5,$caleparttext6,$caleparttext7,$equinum,$cliesoldentrnum,$calepartdate1,$calepartdate2,$ConnexionBdd,"ajou",$depecat,$depemontantttc,$caledate1,$depetauxtva,$calepartnumasso);
  }

// AJOUTER UN CLIENT DE PASSAGE
if(!empty($_POST['clienom']))
  {
    $cliestatus = 1;
    $clienum1 = ClieAjou(null,$_POST['clienom1'],$_POST['clieprenom1'],$cliedatenaiss,$clieadre,$cliecp,$clieville,$_POST['clienumtel1'],$clienumlic,$cliecommentaire,$_POST['clieadremail1'],$clieniveau,$cliecivilite,$cliepays,$cliesupp,$clieautoappli,$clienumtel1,$cliedatevallic,$cliedateinscription,$cliedatecotisation,$clienum[1],$clieresplegal,$clienumcompte,$cliestatus,$ConnexionBdd,$action,$clienbheurerestant,$clieprovince,$groupnum,$chevnum,$avoipart);

    // ENVOI IDENTIFIANTS PAR MAIL
    if(!empty($_POST['clieadremail1']) )
      {
        $identifiants = VerifLogin($clienum1[0],null,$ConnexionBdd,$Dossier);
        echo "<div style='display:none;'>";
        $adresmail = $identifiants[1];
        $message = $identifiants[2];
        $objet = $identifiants[3];
        $nom = $identifiants[4];
        include $Dossier."modules/envoimail2.php";
        echo "</div>";
      }
  }

echo "<div class='InfoStandard FormInfoStandard1'>".$_SESSION['STrad786']."</div>";

echo CalendrierParticipants($Dossier,$ConnexionBdd,$_POST['calenum']);

?>
