<?php
$Dossier = "../../";
include $Dossier."header.php";

if(empty($_SESSION['FactProduitsDate1'])) {$_SESSION['FactProduitsDate1'] = date('Y-m-01', mktime(0,0,0,date('m') - 2,date('d'),date('Y')));}
if(empty($_SESSION['FactProduitsDate2'])) {$_SESSION['FactProduitsDate2'] = date('Y-m-d', mktime(0,0,0,date('m') + 1,date('d'),date('Y')));}

echo "<main>";
echo "<div class='container'>";
echo "<div class='row'>";
echo "<div class='col'>";

if($_GET['Impression'] != 2)
  {
    echo "<div class='row'>";

    // RECHERCHE DEBUT
    echo "<div class='col-sm-12 col-md-5 col-lg-3 col-xxl-2 mb-1'>";
    echo "<label class='form-label'>".$Trad693."</label>";
    echo "<div class='d-inline-block float-md-start me-1 mb-1 search-input-container w-100 shadow bg-foreground'>";
    echo "<input type='date' class='form-control datatable-search' placeholder='Date 1' name='FactProduitsDate1' value='".$_SESSION['FactProduitsDate1']."' onchange='FactProduitsDate1(this.value)' />";
    echo "<span class='search-magnifier-icon'>";
    echo "<i data-acorn-icon='search'></i>";
    echo "<span class='search-delete-icon d-none'>";
    echo "<i data-acorn-icon='close'></i>";
    echo "</span>";
    echo "</div>";

    // RECEHRCHE FIN
    echo "</div>";
    echo "<div class='col-sm-12 col-md-5 col-lg-3 col-xxl-2 mb-1'>";
    echo "<label class='form-label'>".$Trad694."</label>";
    echo "<div class='d-inline-block float-md-start me-1 mb-1 search-input-container w-100 shadow bg-foreground'>";
    echo "<input type='date' class='form-control datatable-search' placeholder='Date 2' name='FactProduitsDate2' value='".$_SESSION['FactProduitsDate2']."' onchange='FactProduitsDate2(this.value)' />";
    echo "<span class='search-magnifier-icon'>";
    echo "<i data-acorn-icon='search'></i>";
    echo "</span>";
    echo "<span class='search-delete-icon d-none'>";
    echo "<i data-acorn-icon='close'></i>";
    echo "</span>";
    echo "</div>";
    echo "</div>";

    // IMPRIMER
    echo "<div class='col-sm-12 col-md-5 col-lg-3 col-xxl-2 mb-1 btn btn-icon btn-icon-only btn-foreground-alternate shadow datatable-print'><a href=\"Imprimer\"target=\"popup\" onclick=\"window.open('".$Dossier."modules/facturation/modproduitsconstates.php?Impression=2','popup','width=1024px,height=550px,left=100px,top=100px,scrollbars=1');return(false)\"><i data-acorn-icon='print' title='Print' data-acorn-size='30'></i> ".$TradDivButt10."</a></div>";

    echo "</div>";
  }
else
  {
    echo "<a href='javascript:window.print()' class='no_print'><i data-acorn-icon='print' title='Print' data-acorn-size='30'></i>".$TradDivButt10."</a><br>";
  }

echo "<div id='AfficheProduitsConstates'>";
echo AfficheProduitsConstates($Dossier,$ConnexionBdd,$_SESSION['FactProduitsDate1'],$_SESSION['FactProduitsDate2']);
echo "</div>";

echo "</div>";
echo "</div>";
echo "</div>";
echo "</main>";

include $Dossier."footer.php";
?>
