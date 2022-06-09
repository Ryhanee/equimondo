<?php
$Dossier = "./";
include $Dossier."header.php";
include $Dossier."modules/divers/MenuThemes.php";

echo "<div id='root'><main><div class='container'><div class='row'><div class='col'><div class='row'>";

echo "<div class='AfficheListe'>";

echo "<div class='col-xl-6 mb-5' style='width:100%;'>";
echo "<section class='scroll-section' id='users'>";
echo "<h2 class='small-title'>".$NTrad255."</h2>";
echo "<div class='card'>";

// RECHERCHE NOM
echo "<div class='col-12 col-sm mb-1 mb-sm-0'>";
echo "<div class='search-input-container rounded-md border border-separator mb-2' style='width:50%;float:left;'>";
echo "<input class='form-control search' type='text' autocomplete='off' name='clienom' id='RechClieNom' placeholder='".$TradClieStanNom."' />";
echo "<span class='search-magnifier-icon'>";
echo "<i data-acorn-icon='search'></i>";
echo "</span>";
echo "</div>";

// RECHERCHE PRENOM
echo "<div class='search-input-container rounded-md border border-separator mb-2' style='width:50%;float:left;'>";
echo "<input class='form-control search' type='text' autocomplete='off' name='clieprenom' id='RechCliePrenom' placeholder='".$TradClieStanPrenom."' />";
echo "<span class='search-magnifier-icon'>";
echo "<i data-acorn-icon='search'></i>";
echo "</span>";
echo "</div>";
echo "</div>";

// AFFICHE IDENTIFIANTS
echo "<div id='ProfilIdentifiants1'></div>";

// LISTER CLIENTS
echo "<div id='AfficheListeClient'>";
$listeDocs = ListeDocuments($ConnexionBdd, $Dossier);
echo $listeDocs[0];
echo "</div>";
echo "</div>";
echo "</section>";
echo "</div>";
echo "</div>";

// AFFICHE COMPLET
echo "<div class='AfficheFicheComplet'>";
echo "<div class='col-xl-6 mb-5' style='width:100%;'>";
echo "<section class='scroll-section' id='userButtons'>";
echo "<h2 class='small-title'></h2>";
echo "<div id='AfficheFicheProfil1'></div>";
echo "</section>";
echo "</div>";
echo "</div>";

echo "</div></div></div></div></main></div>";

include $Dossier."footer.php";
?>
