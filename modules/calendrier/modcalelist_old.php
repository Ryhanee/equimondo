<?php
$Dossier = "../../";
include $Dossier.'header.php';

echo "<div style='height:80px;clear:both;display:block;'></div>";

echo "<section style='clear:both;display:block;width:100%;'>";
if(empty($_SESSION['modaffiche'])) {$_SESSION['modaffiche'] = 2;}


if($_SESSION['ResolutionConnexion1'] > 800) {$Dimmension1 = "width:80%;float:left;";$Dimmension2 = "width:20%;float:right;";}
else {$Dimmension1 = "width:100%;";$Dimmension2 = "width:100%;";}

echo "<section style='".$Dimmension2."'>";


if($_SESSION['ResolutionConnexion1'] <= 800)
  {
    if($_SESSION['connind'] == "util") {$ResultatTailleWidth = "49";} else $ResultatTailleWidth = "97";
    echo "<div class='buttonBasMenuFixed'>";
    echo "<div class='buttonBasMenuFixedRub' style='width:".$ResultatTailleWidth."%;'><a href='#FenCaleRechercher' class='button ImgSousMenu2'><img src='".$Dossier."images/rechercherBlanc.png' class='ImgSousMenu2'>".$Trad947."</a></div>";
    if($_SESSION['connind'] == "util") {echo "<div class='buttonBasMenuFixedRub' style='width:".$ResultatTailleWidth."%;'><a href='".$Dossier."modules/calendrier/modcaleAjouter.php?calecatenum=".$_GET['calecatenum']."' class='LoadPage CaleAjouter button ImgSousMenu2'><img src='".$Dossier."images/ajouterBlanc.png' class='ImgSousMenu2'>".$TradDivButtAjou."</a></div>";}
    echo "</div>";
  }
else
  {

    echo "<div style='text-align:center;'>";
      echo "<a href='".$Dossier."modules/calendrier/modcalelist1.php?modprecedent=2&calecatenum=".$_GET['calecatenum']."' class='LoadPage AfficheMode'><img src='".$Dossier."images/flecheGauche.png' class='ImgSousMenu2' style='margin-right:15px;'></a>";
      echo "<a href='".$Dossier."modules/calendrier/modcalelist1.php?modsuivant=2&calecatenum=".$_GET['calecatenum']."' class='LoadPage AfficheMode'><img src='".$Dossier."images/flecheDroite.png' class='ImgSousMenu2' style='margin-left:15px;'></a>";

    echo "</div>";
    echo "<div style='height:20px;'></div>";
    echo "<div style='text-align:center;'>";
    echo "<div style='background-color:white;
    border-style:solid;
    border-width: 1px ;
    border-color:white;
    padding:5px;
    border-radius:15px;
    width:150px;
    '>";

      echo "<a href='".$Dossier."modules/calendrier/modcalelist.php?modaffiche=1' class='LoadPage AfficheMode CalendrierModeVue'>".$TradChevFichCompl111."</a>";
      echo "<a href='".$Dossier."modules/calendrier/modcalelist.php?modaffiche=2' class='LoadPage AfficheMode CalendrierModeVue'>".$TradChevFichCompl2."</a>";
      echo "</div>";
    echo "</div>";

    echo "<div style='height:20px;'></div>";

    echo "<div style='text-align:center;width:100%;'>";
    if($_SESSION['connind'] == "util")
      {
        echo "<a href='#close' class='button ImgSousMenu2'><img src='".$Dossier."images/rechercherBlanc.png' class='ImgSousMenu2'>".$Trad947."</a>";
        echo "</div>";
        echo "<div style='height:20px;'></div>";
        echo "<div style='text-align:center;width:100%;'>";
        echo "<a href='".$Dossier."modules/calendrier/modcaleAjouter.php?calecatenum=".$_GET['calecatenum']."' class='LoadPage CaleAjouter button ImgSousMenu2'><img src='".$Dossier."images/ajouterBlanc.png' class='ImgSousMenu2'>".$TradDivButtAjou."</a>";
        echo "</div>";
        echo "<div style='height:20px;'></div>";
        echo "<div style='text-align:center;width:100%;'>";
        echo "<a href='".$Dossier."modules/configuration/confcalendrier.php' class='LoadPage Afficheconffacturation button ImgSousMenu2'><img src='".$Dossier."images/configurationBlanc.png' class='ImgSousMenu2'>".$Trad217."</a>";
        echo "</div>";
      }
    echo "</div>";

    echo "</section>";
  }

echo "<section style='".$Dimmension1."' id='AfficheCalendrier'>";

echo Calendrier($Dossier,$ConnexionBdd,$caledate1,$modaffiche,$_GET['calecatenum'],null,null);
echo "</section>";

echo "</section>";

echo "</section>";

include $Dossier."footer.php";
?>
