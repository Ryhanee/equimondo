<?php

// ************************** LISTE DES DOCUMENTS *********************************

function ListeDocuments($ConnexionBdd,$Dossier)
{

    $req1 = 'SELECT docunum, docutitre,docudatecreation FROM document WHERE authentification_authnum='.$_SESSION['authconnauthnum'];
    $req1Result = $ConnexionBdd ->query($req1) or die ('Erreur SQL !'.$req1.'<br />'.mysql_error());
   
   while($reqAffich = $req1Result->fetch())
    {
        $Lien = "<a href='".$Dossier."modules/documents/generatePdf.php?docunum=".$reqAffich['docunum']."' class='AfficheFicheProfil1'>";

        $LibeNom = DocLect($reqAffich['docunum'],$ConnexionBdd);

        // VERSION SMARTPHONE
        $Lecture.="<div class='row'>";
        $Lecture.="<div class='col-auto w-100 sw-md-50'>";
        $Lecture.="<div class='card mb-3'>";
        $Lecture.="<div class='card-body'>";
        $Lecture.="<div class='row g-0 sh-6'>";
        $Lecture.="<div class='col-auto'>";
        $Lecture.=$Lien."<img src='../../img/profile/profile-6.webp' class='card-img rounded-xl sh-6 sw-6' alt='thumb' /></a>";
        $Lecture.="</div>";
        $Lecture.="<div class='col'>";
        $Lecture.="<div class='card-body d-flex flex-row pt-0 pb-0 ps-3 pe-0 h-100 align-items-center justify-content-between'>";
        $Lecture.=$Lien."<div class='d-flex flex-column'>";
        $Lecture.="<div>".$LibeNom."</div>";
       // $Lecture.="<div class='text-small text-muted'>".ClieStatus($reqAffich['cliestatus'])."</div>";
        $Lecture.="</div></a>";
        $Lecture.="<div class='d-flex'>";

       /* $Lecture.=$Lien."<div style='margin-right:10px;'>";
        $Lecture.="<div class='".$ClassAlerte1."' style='padding:2px 5px 2px 5px;border-radius:10px;text-align:center;'>".$RestantDu[4]." ".$_SESSION['STrad27']."</div>";
        $Lecture.="<div style='width:100%;clear:both;display:block;height:5px;'></div>";
        $Lecture.="<div class='".$ClassAlerte2."' style='padding:2px 5px 2px 5px;border-radius:10px;text-align:center;'>".minute_vers_heure($NbHeure[2],null)."</div>";
        $Lecture.="</div></a>";*/

        $Lecture.="<div>";
        $Lecture.="<button class='btn btn-sm btn-icon btn-icon-only btn-outline-primary align-top float-end' type='button' data-bs-toggle='dropdown' aria-expanded='false' aria-haspopup='true'>";
        $Lecture.="<i data-acorn-icon='more-horizontal'></i>";
        $Lecture.="</button>";
        $Lecture.="<div class='dropdown-menu dropdown-menu-sm dropdown-menu-end'>";
        $Lecture.="<a class='dropdown-item AfficheFicheProfil1' href='".$Dossier."modules/documents/modajoutsignature.php?docunum=".$reqAffich['docunum']."' id='mbtn'>Ajouter une signature</a>";
        $Lecture.="<div class='dropdown-divider'></div>";
        $Lecture.="<a class='dropdown-item' href='#'>".$_SESSION['STrad614']."</a>";
        $Lecture.="</div>";
        $Lecture.="</div>";

        $Lecture.="</div>";
        $Lecture.="</div>";
        $Lecture.="</div>";
        $Lecture.="</div>";
        $Lecture.="</div>";
        $Lecture.="</div>";
        $Lecture.="</div>";
        $Lecture.="</div>";
    }

    return array($Lecture);
}
//*************************************************************************************
