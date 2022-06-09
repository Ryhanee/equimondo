<?php
//************************ ENVOYER UN EMAIL ****************************************
use Dompdf\Dompdf;

function EnvoiMail($Dossier, $ConnexionBdd, $factnum, $calenum)
{
    echo "<div style='height:10px;'></div>";
    if(!empty($factnum))
    {
        $req = 'SELECT * FROM factures,clients WHERE clients_clienum = clienum AND factnum = "'.$factnum.'"';
        $reqResult = $ConnexionBdd ->query($req) or die ('Erreur SQL !'.$req.'<br />'.mysqli_error());
        $reqAffich = $reqResult->fetch();
        $Email1 = $reqAffich['clieadremail'];
        $objet = FactIndLect($reqAffich['facttype'],null)." ".$_SESSION['STrad111']." ".formatdatemysql($reqAffich['factdate']);
    }

    if(!empty($_GET['calenum']))
    {
        echo "<a href='".$Dossier."modules/calendrier/modcalefichcomplet.php?calenum=".$_GET['calenum']."' class='AfficheCaleFichComplet btn btn-primary'>".$_SESSION['STrad305']."</a>";
        echo "<div style='height:15px;'></div>";
    }

    $Lecture.="<form method='POST' action='".$Dossier."modules/divers/EnvoyerUnMail.php' autocomplete='off'  enctype='multipart/form-data'>";
    if(!empty($factnum))
    {
        $Lecture.="<input type='hidden' name='factnum' value='".$factnum."'>";
    }
    if(!empty($calenum))
    {
        $Lecture.="<input type='hidden' name='calenum' value='".$calenum."'>";
    }

    if(!empty($calenum))
    {
        $req = 'SELECT * FROM calendrier,calendrier_categorie WHERE calendrier_categorie_calecatenum = calecatenum AND calenum = "'.$calenum.'"';
        $reqResult = $ConnexionBdd ->query($req) or die ('Erreur SQL !'.$req.'<br />'.mysqli_error());
        $reqAffich = $reqResult->fetch();

        $objet = $reqAffich['calecatelibe']." ".FormatDateTimeMySql($reqAffich['caledate1']);

        $req = 'SELECT * FROM calendrier_participants,clients WHERE clients_clienum=clienum AND calendrier_calenum = "'.$calenum.'"';
        $reqResult = $ConnexionBdd ->query($req) or die ('Erreur SQL !'.$req.'<br />'.mysqli_error());
        while($reqAffich = $reqResult->fetch())
        {
            ?>
            <div class="row g-3 mb-3">
                <div class="col-md-6">
                    <label class="form-label"><?php echo ClieLect($reqAffich['clients_clienum'],$ConnexionBdd); ?></label>
                    <input type="email" class="form-control" name="email[]" value='<?php echo $reqAffich['clieadremail']; ?>' placeholder='<?php echo $_SESSION['STrad809']; ?>'/>
                </div>
            </div>
            <?php
        }
    }

    $Lecture.="<div class='mb-3'>
			  <label class='form-label'>".$_SESSION['STrad108']."</label>
			  <input type='email' class='form-control' name='email[]' placeholder=''/>
			</div>

			<div class='mb-3'>
			  <label class='form-label'>".$_SESSION['STrad109']."</label>
			  <input type='text' class='form-control' name='objet'";if(!empty($objet)) {$Lecture.=" value='".$objet."'";} $Lecture.=" placeholder='' required/>
			</div>

			<div class='mb-3'>
			<input type='file' name='piecejointe[]' multiple><br>
			<input type='file' name='piecejointe[]' multiple><br>
			<input type='file' name='piecejointe[]' multiple><br>
			<input type='file' name='piecejointe[]' multiple>
			</div>

			<div class='row g-3'>
			  <div class='col-12'>
			    <div class='mb-3 top-label'>
			      <textarea class='form-control' rows='3' name='message' placeholder='".$_SESSION['STrad152']."'></textarea>
			      <span>".$Trad525."</span>
			    </div>
			  </div>
			</div>

			<button type='submit' class='btn btn-primary'>".$_SESSION['STrad110']."</button>
			";
    $Lecture.="<form>";

    return $Lecture;
}
//**************************************************************************************************

//********************************************************************************************
function RedigerCorpMail($Dossier,$ConnexionBdd,$factnum)
{
    $message.= $_SESSION['conflogmail1']."<br>";
    if(!empty($factnum))
    {
        $req = 'SELECT * FROM factures,clients WHERE clients_clienum = clienum AND factnum = "'.$factnum.'"';
        $reqResult = $ConnexionBdd ->query($req) or die ('Erreur SQL !'.$req.'<br />'.mysqli_error());
        $reqAffich = $reqResult->fetch();
        $clienum = $reqAffich['clients_clienum'];
        $adresmail = $reqAffich['clieadremail'];
        $nom = $reqAffich['clienom']." ".$reqAffich['clieprenom'];

        $objet = FactIndLect($reqAffich['facttype'],null)." ".$_SESSION['STrad111']." ".formatdatemysql($reqAffich['factdate']);
        $message.= '<br>'.$_SESSION['STrad795'].'<br/><a href="http://equimondo.app/modules/facturation/modfactImpression.php?factlien='.$reqAffich['factlien'].'&Impression=2">'.FactIndLect($reqAffich['facttype']).' '.formatdatemysql($reqAffich['factdate']).' N '.FactPrefLect($reqAffich['factdate'],$reqAffich['factnumlibe'],null).'</a><br/>';
    }
    $message.= "<br>".$_SESSION['conflogmail2'];

    if(!empty($factnum))
    {
        $reqEnvMail = 'INSERT INTO envoi_mail VALUE (NULL,"'.$_SESSION['HeureActuelle2'].'","'.$objet.'","'.CaracSpeciaux($message).'","'.$_SESSION['hebeappnum'].'")';
        $reqEnvMailResult = $ConnexionBdd ->query($reqEnvMail) or die ('Erreur SQL !'.$reqEnvMail.'<br />'.mysqli_error());
        $envmailnum = $ConnexionBdd->lastInsertId();
    }

    if(!empty($clienum) OR !empty($factnum))
    {
        if(empty($clienum)) {$clienum = "NULL";}
        if(empty($factnum)) {$factnum = "NULL";}

        $req2 = 'INSERT INTO envoi_mail_participants VALUE (NULL,"'.$envmailnum.'","'.$clienum.'",'.$factnum.')';
        $req2Result = $ConnexionBdd ->query($req2) or die ('Erreur SQL !'.$req2.'<br />'.mysqli_error());
    }

    return array($message,$factnum,$clienum,$objet,$adresmail,$nom,$envmailnum);
}
//**************************************************************************************************

//********************** PROFIL FICHE COMPLET **********************************
function ProfilFichComplet($ConnexionBdd,$Dossier,$clienum)
{
    if(empty($_SESSION['hebeappnum']))
    {
        exit;
    }

    if($_SESSION['connind'] == 'clie')
    {
        $AccesRefuser = 2;
        $reqVerif1 = 'SELECT familleclients_famiclienum FROM clients WHERE clienum="'.$_SESSION['connauthnum'].'"';
        $reqVerif1Result = $ConnexionBdd ->query($reqVerif1) or die ('Erreur SQL !'.$reqVerif1.'<br />'.mysqli_error());
        $reqVerif1Affich = $reqVerif1Result->fetch();

        $req = 'SELECT clienum FROM clients WHERE familleclients_famiclienum = "'.$reqVerif1Affich[0].'"';
        $reqResult = $ConnexionBdd ->query($req) or die ('Erreur SQL !'.$req.'<br />'.mysqli_error());
        while($reqAffich = $reqResult->fetch())
        {
            if($clienum == $reqAffich[0]) {$AccesRefuser = 1;}
        }
        if($AccesRefuser == 2)
        {
            echo '<SCRIPT LANGUAGE = "javascript"> window.location.replace("#AccesRefuser") </SCRIPT>';
            exit;
        }
    }
    else if($_SESSION['modclients'] == 1 AND $_SESSION['connind'] == 'util')
    {
        echo '<SCRIPT LANGUAGE = "javascript"> window.location.replace("#AccesRefuser") </SCRIPT>';
        exit;
    }
    if($_SESSION['connind'] == 'util')
    {
        $req = 'SELECT AA_equimondo_hebeappnum FROM clients WHERE clienum = "'.$clienum.'"';
        $reqResult = $ConnexionBdd ->query($req) or die ('Erreur SQL !'.$req.'<br />'.mysqli_error());
        $reqAffich = $reqResult->fetch();

        if($reqAffich[0] != $_SESSION['hebeappnum'] AND !empty($clienum)) {echo '<br><br><center style="font-size:40px;color:red;">Acc�s refus�</center>';exit;}
    }


    // INFOS CLIENTS
    if(!empty($_GET['clienum']))
    {
        $req = 'SELECT * FROM clients WHERE clienum="'.$_GET['clienum'].'"';
        $reqResult = $ConnexionBdd ->query($req) or die ('Erreur SQL !'.$req.'<br />'.mysqli_error());
        $reqAffich = $reqResult->fetch();

        $NomEtablissement = $reqAffich['clienometablissement'];
        $faminum = $reqAffich['familleclients_famiclienum'];
        $Civilite = $reqAffich['cliecivilite'];
        $Prenom = $reqAffich['clieprenom'];
        $Nom = $reqAffich['clienom'];
        $Adresse = $reqAffich['clieadre'];
        $Cp = $reqAffich['cliecp'];
        $Ville = $reqAffich['clieville'];
        $Pays = $reqAffich['cliepays'];
        $Tel1 = $reqAffich['clienumtel'];
        $Tel2 = $reqAffich['clienumtel1'];
        $AdresseMail = $reqAffich['clieadremail'];
        $NumCompte = $reqAffich['clienumcompte'];
        $DateInsc = formatdatemysql($reqAffich['cliedateinscription']);
        $NumCarteIdendite = $reqAffich['clienumcarteidentite'];
        $Iban = $reqAffich['clieiban'];
        $Bic = $reqAffich['cliebic'];

        $Status = ClieStatus($reqAffich['cliestatus']);
        $DateNaiss = formatdatemysql($reqAffich['cliedatenaiss']);
        $DateCotisation = formatdatemysql($reqAffich['cliedatecotisation']);
        $Niveau = $reqAffich['clieniveau'];
        $LicNum = $reqAffich['clienumlic'];
        $LicDateVal = formatdatemysql($reqAffich['cliedatevallic']);
        $Commentaire = $reqAffich['cliecommentaire'];

        // TOTAL FACTURE NON PAYE
        $RestantDu = ClieFactCalc($reqAffich['clienum'],$Dossier,$ConnexionBdd);
        if($RestantDu[4] > 0) {$Color1 = 'AlerteRedColor';}
        else {$Color1 = '';}
        if($_SESSION['equimondoinfologversionnum'] == 1)
        {
            // SOLDE FORFAITAIRE
            $NbHeure = CalcNbHeureForfValide($reqAffich['clienum'],NULL,NULL,$ConnexionBdd);
            if($NbHeure[2] >= 0 AND $NbHeure[2] <= 180) {$Color2 = 'border-color:orange;color:orange;';}
            else if($NbHeure[2] < 0) {$Color2 = 'border-color:red;color:red;';}
            else {$Color2 = 'border-color:green;color:green;';}
        }
        $Color2.="border-style:solid;border-width: 1px ;border-radius:20px;padding:5px 70px 5px 70px;font-size:35px;";
    }

    $FileName = "http://equimondo.fr/perso_images/clients/".$clienum.".png";

    if(!file_exists($FileName))
    {
        $FileName = $Dossier."img/profile/profile-2.webp";
    }


    $Lecture.="<div class='card h-100-card'>";
    $Lecture.="<div class='card-body mb-n2 border-last-none h-100'>";
    $Lecture.="<div class='container'>";
    $Lecture.="<div class='page-title-container'>";
    $Lecture.="<div class='row'>";
    $Lecture.="<div class='col-12 col-md-7'>";
    $Lecture.="<h1 class='mb-0 pb-0 display-4' id='title'>".$Nom." ".$Prenom."</h1>";
    $Lecture.="</div>";
    $Lecture.="<div class='col-12 col-md-5 d-flex align-items-start justify-content-end'>";
    $Lecture.="<button type='button' class='btn btn-outline-primary btn-icon btn-icon-start w-100 w-md-auto'>";
    $Lecture.="<i data-acorn-icon='edit-square'></i>";
    $Lecture.="<span>".$_SESSION['STrad304']."</span>";
    $Lecture.="</button>";
    $Lecture.="</div>";
    $Lecture.="</div>";
    $Lecture.="</div>";

    $Lecture.="<div class='row'>";
    $Lecture.="<div class='col-12 col-xl-4 col-xxl-3'>";
    $Lecture.="<h2 class='small-title'>".$_SESSION['STrad803']."</h2>";
    $Lecture.="<div class='card mb-5'>";
    $Lecture.="<div class='card-body'>";
    $Lecture.="<div class='d-flex align-items-center flex-column mb-4'>";
    $Lecture.="<div class='d-flex align-items-center flex-column'>";
    $Lecture.="<div class='sw-13 position-relative mb-3'>";
    $Lecture.="<img src='".$FileName."' class='img-fluid rounded-xl' alt='thumb' />";
    $Lecture.="</div>";

    if(!empty($NomEtablissement))
    {
        $Lecture.="<div class='h5 mb-0'>".$NomEtablissement."</div>";
    }
    $Lecture.="<div class='h5 mb-0'>".$Nom." ".$Prenom."</div>";
    $Lecture.="<div class='text-muted'>".$Status."</div>";
    $Lecture.="<div class='text-muted'>".ClieCiviliteLect($Civilite)."</div>";
    $Lecture.="<div class='text-muted'>";
    $Lecture.="<i data-acorn-icon='pin' class='me-1'></i>";
    if(!empty($Adresse))
    {
        $Lecture.="<span class='align-middle'>".$Adresse."</span><br>";
    }
    if(!empty($Cp) OR !empty($Ville))
    {
        $Lecture.="<span class='align-middle'>".$Cp." ".$Ville."</span><br>";
    }
    if(!empty($Pays))
    {
        $Lecture.="<span class='align-middle'>".$Pays."</span><br>";
    }

    $Lecture.="</div>";
    $Lecture.="</div>";
    $Lecture.="</div>";


    $Lecture.="<div class='nav flex-column' role='tablist'>";

    $Lecture.="<a class='nav-link px-0 border-bottom border-separator-light' data-bs-toggle='tab' href='#permissionsTab' role='tab'>";
    $Lecture.="<i data-acorn-icon='lock-off' class='me-2' data-acorn-size='17'></i>";
    $Lecture.="<span class='align-middle'>".$_SESSION['STrad835']."</span>";
    $Lecture.="</a>";

    $Lecture.="<a class='nav-link px-0 border-bottom border-separator-light' data-bs-toggle='tab' href='#friendsTab' role='tab'>";
    $Lecture.="<i data-acorn-icon='heart' class='me-2' data-acorn-size='17'></i>";
    $Lecture.="<span class='align-middle'>".$_SESSION['STrad804']."</span>";
    $Lecture.="</a>";

    $Lecture.="<a class='nav-link px-0 border-bottom border-separator-light' data-bs-toggle='tab' href='#Evenments' role='tab'>";
    $Lecture.="<i data-acorn-icon='heart' class='me-2' data-acorn-size='17'></i>";
    $Lecture.="<span class='align-middle'>".$_SESSION['STrad837']."</span>";
    $Lecture.="</a>";

    $Lecture.="</div>";
    $Lecture.="</div>";
    $Lecture.="</div>";
    $Lecture.="</div>";

    // PARIE SUR LA DROITE
    $Lecture.="<div class='col-12 col-xl-8 col-xxl-9 mb-5 tab-content'>";

    // AFFICHER FORFAITS CARTES
    $Lecture.="<div class='tab-pane fade' id='permissionsTab' role='tabpanel'>";
    $Lecture.="<h2 class='small-title'>".$_SESSION['STrad835']."</h2>";
    $Lecture.=ListeForfaitsClients($Dossier,$ConnexionBdd,$_GET['clienum']);
    $Lecture.="</div>";

    // MEMBRE DE LA MEME FAMILLE
    $Lecture.="<div class='tab-pane fade' id='friendsTab' role='tabpanel'>";
    $Lecture.="<h2 class='small-title'>".$_SESSION['STrad804']."</h2>";
    $Lecture.="<div id='AfficheMembreFamille'>";
    $Lecture.=MembreFamille($Dossier,$ConnexionBdd,$_GET['clienum']);
    $Lecture.="</div>";
    $Lecture.="</div>";

    // EVENENTS INSCRITS
    $Lecture.="<div class='tab-pane fade' id='Evenments' role='tabpanel'>";
    $Lecture.="<h2 class='small-title'>".$_SESSION['STrad837']."</h2>";
    $Lecture.=CalendrierClientsListe($Dossier,$ConnexionBdd,$_GET['clienum']);
    $Lecture.="</div>";

    // FIN DE PARTIE SUR LA DROITE
    $Lecture.="</div>";
    $Lecture.="</div>";

    // SOUS MENU
    $Lecture.="<section style='position:fixed;bottom:45%;right:0px;'>";
    $Lecture.="<button type='button' class='btn btn-primary dropdown-toggle mb-1' data-bs-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>".$_SESSION['STrad149']."</button>";
    $Lecture.="<div class='dropdown-menu'>";
    if($_SESSION['connind'] == "util")
    {
        // SUPPRIMER
        $Lecture.="<a href='".$Dossier."modules/calendrier/modcaleAjouter.php?calenum=".$reqAffich['calenum']."' class='CaleAjouter dropdown-item'>".$_SESSION['STrad772']."</a>";

        $Lecture.="<div class='dropdown-divider'></div>";
    }

    if($_SESSION['ResolutionConnexion1'] > 800)
    {
        // IMPRIMER
        $Lecture.="<a href=\"Imprimer\"target=\"popup\" onclick=\"window.open('".$Dossier."modules/calendrier/modcaleImpression.php?calenum=".$calenum."&Impression=2','popup','width=1024px,height=550px,left=100px,top=100px,scrollbars=1');return(false)\" class='dropdown-item'>".$_SESSION['STrad105']."</a>";
    }
    else {$Lecture.="<div class='dropdown-divider'></div>";}

    $Lecture.="</section>";

    return array($Lecture,$donne1);
}
//*************************************************************************************

//************************************ TAILLE D'UNE IMAGE DE PROFIL *****************
function TailleImgProfil($image)
{
    $taille = getimagesize($image);
    $largeur = $taille[0];
    $hauteur = $taille[1];

    if($largeur > $hauteur) {return $valeur = 'width:200px;';exit;}
    if($largeur <= $hauteur) {return $valeur = 'height:150px;';exit;}
}
//*******************************************************************************

//******************* AFFICHE GROUPE *****************************************
function AfficheGroupe($Dossier,$ConnexionBdd,$clienum,$chevnum,$groupind)
{
    $Lecture.="<hr class='HrListe1'>";
    $Lecture.="<div class='InfoStandard FormInfoStandard1'><img src='".$Dossier."images/informationBlanc.png' class='imgSousMenu1' style='margin-right:10px;'>".$_SESSION['STrad742']."</div>";

    $req1 = 'SELECT count(groupassonum) FROM groupe_association,groupe WHERE groupe_groupnum = groupnum';
    if(!empty($clienum)) {$req1.=' AND clients_clienum = "'.$clienum.'"';}
    if(!empty($chevnum)) {$req1.=' AND chevaux_chevnum = "'.$chevnum.'"';}
    $req1Result = $ConnexionBdd ->query($req1) or die ('Erreur SQL !'.$req1.'<br />'.mysqli_error());
    $req1Affich = $req1Result->fetch();
    if($req1Affich[0] == 0)
    {
        $Lecture.=$_SESSION['STrad721']."<br><br>";
    }
    else if($req1Affich[0] >= 1)
    {
        $Lecture.="<table class='tab_rubrique' style='width:100%;'>";
        $Lecture.="<thead><tr>";
        $Lecture.="<td>".$_SESSION['STrad720']."</td>";
        if($_SESSION['connind'] == 'util') {$Lecture.="<td></td>";}
        $Lecture.="</tr></thead>";
        $Lecture.="<tbody>";

        $req3 = 'SELECT * FROM groupe_association,groupe WHERE groupe_groupnum = groupnum';
        if(!empty($clienum)) {$req3.=' AND clients_clienum = "'.$clienum.'"';}
        if(!empty($chevnum)) {$req3.=' AND chevaux_chevnum = "'.$chevnum.'"';}
        $req3.=' GROUP BY groupnum ORDER BY groupnom ASC';
        $req3Result = $ConnexionBdd ->query($req3) or die ('Erreur SQL !'.$req3.'<br />'.mysqli_error());
        while($req3Affich = $req3Result->fetch())
        {
            $Lecture.="<tr>";
            $Lecture.="<td><a href='".$Dossier."modules/divers/modgroupefichcomplet1.php?groupnum=".$req3Affich['groupnum']."' class='LoadPage AfficheFicheGroupe1'>".$req3Affich['groupnom']."</a></td>";
            if($_SESSION['connind'] == 'util') {$Lecture.="<td><a href='".$Dossier."modules/divers/modgroupeassosupp.php?groupassonum=".$req3Affich['groupassonum']."&clienum=".$clienum."&groupind=".$groupind."' class='LoadPage GroupeSupp3'><img src='".$Dossier."images/supprimer.png' class='ImgSousMenu2'></a></td>";}
            $Lecture.="</tr>";
        }
        $Lecture.="</tbody>";
        $Lecture.="</table>";
    }

    if($_SESSION['connind'] == 'util')
    {
        $Lecture.="<br><a href='".$Dossier."modules/divers/modGroupAjouAffiche.php?clienum=".$clienum."' class='LoadPage GroupAjouAffiche'><div class='LienDefilement1'>".$_SESSION['STrad722']."<img src='".$Dossier."images/FlecheBasBlanc.png' class='ImgSousMenu2' style='float:right;'></div></a>";
        $Lecture.="<div id='GroupAjouAffiche'></div>";
    }

    return $Lecture;
}
//****************************************************************************************

//******************* AFFICHE CHEVAUX EN PROPRIETE *****************************************
function AfficheProprietaireChevaux($Dossier,$ConnexionBdd,$clienum)
{
    $Lecture.="<div style='height:30px;'></div>";
    $Lecture.="<hr class='HrListe1'>";
    $Lecture.="<div class='InfoStandard FormInfoStandard1'><img src='".$Dossier."images/informationBlanc.png' class='imgSousMenu1' style='margin-right:10px;'>".$_SESSION['STrad723']."</div>";

    $req1 = 'SELECT count(clients_clienum) FROM avoir WHERE clients_clienum="'.$clienum.'"';
    $req1Result = $ConnexionBdd ->query($req1) or die ('Erreur SQL !'.$req1.'<br />'.mysqli_error());
    $req1Affich = $req1Result->fetch();
    if($req1Affich[0] >= 1)
    {
        $Lecture.="<table class='tab_rubrique' style='width:100%;'>";
        $Lecture.="<thead><tr>";
        $Lecture.="<td>".$_SESSION['STrad126']."</td>";
        $Lecture.="<td>".$_SESSION['STrad127']."</td>";
        if($_SESSION['connind'] == 'util') {$Lecture.="<td></td>";}
        $Lecture.="</tr></thead>";
        $Lecture.="<tbody>";

        $req3 = 'SELECT avoirnum,chevnom,chevsexe,chevrobe,chevtail,chevnum,avoipart FROM avoir, chevaux  WHERE clients_clienum = "'.$clienum.'" AND chevnum = chevaux_chevnum AND chevsupp="1" ORDER BY chevnom ASC';
        $req3Result = $ConnexionBdd ->query($req3) or die ('Erreur SQL !'.$req3.'<br />'.mysqli_error());
        while($req3Affich = $req3Result->fetch())
        {
            $avoipart = $req3Affich['avoipart'] * 100;
            $Lecture.="<tr>";
            $Lecture.="<td><a href='".$Dossier."modules/chevaux/modchevfichcomplet.php?id=".$req3Affich['chevnum']."'>".$req3Affich['chevnom']."</a></td>";
            $Lecture.="<td><a href='".$Dossier."modules/chevaux/modchevfichcomplet.php?id=".$req3Affich['chevnum']."'>".$avoipart." %</a></td>";
            if($_SESSION['connind'] == 'util') {$Lecture.="<td><a href='".$Dossier."modules/profil/modprofilSuppChev.php?avoinum=".$req3Affich['avoirnum']."&clienum=".$clienum."' class='LoadPage AfficheProfilAvoirSupp'><img src='".$Dossier."images/supprimer.png' class='ImgSousMenu2'></a></td>";}
            $Lecture.="</tr>";
        }
        $Lecture.="</tbody>";
        $Lecture.="</table>";
    }
    else
    {
        $req1 = 'SELECT clieprenom FROM clients WHERE clienum="'.$clienum.'"';
        $req1Result = $ConnexionBdd ->query($req1) or die ('Erreur SQL !'.$req1.'<br />'.mysqli_error());
        $req1Affich = $req1Result->fetch();

        $Lecture.="<i><div class='InfoStandard'>".$req1Affich['clieprenom']." ".$_SESSION['STrad128']."</div></i>";
    }

    if($_SESSION['connind'] == 'util')
    {
        $Lecture.="<br><a href='".$Dossier."modules/profil/modprofilAjouChevAvoir.php?clienum=".$clienum."' class='LoadPage profilAjouChevAvoir'><div class='LienDefilement1'>".$_SESSION['STrad130']."<img src='".$Dossier."images/FlecheBasBlanc.png' class='ImgSousMenu2' style='float:right;'></div></a>";
        $Lecture.="<div id='profilAjouChevAvoir'></div>";
    }

    return $Lecture;
}
//*************************************************************************************

//************************** SOUS MENU PROFIL **********************************
function SousMenuProfilFichComplet($Dossier,$ConnexionBdd,$clienum)
{
    $req1 = 'SELECT * FROM clients WHERE clienum="'.$clienum.'"';
    $req1Result = $ConnexionBdd ->query($req1) or die ('Erreur SQL !'.$req1.'<br />'.mysqli_error());
    $req1Affich = $req1Result->fetch();

    if($_SESSION['ResolutionConnexion1'] <= 800) {$Ancre = "FenAfficheFicheFacture1";}
    else {$Ancre = "";}

    if($_SESSION['connind'] == "util")
    {
        $ResultatTailleWidth = "23";
    }

    if($_SESSION['connind'] == "util")
    {

        // SUPPRIMER
        if($req1Affich['cliesupp'] == 1)
        {
            $Libe = "";
            if($_SESSION['ResolutionConnexion1'] <= 800) {$Libe = $_SESSION['STrad316'];	}
            else  {$Libe = $_SESSION['STrad155'];}
            $SousMenuCorp.="<div class='buttonBasMenuFixedRub'";if($_SESSION['ResolutionConnexion1'] <= 800) {$SousMenuCorp.=" style='width:".$ResultatTailleWidth."%;'";}
            $SousMenuCorp.=">";
            if($_SESSION['ResolutionConnexion1'] <= 800) {$SousMenuCorp.="<a href='".$Dossier."modules/clients/modclieSupp.php?clienum=".$clienum."' class='LoadPage ClieSupp ImgSousMenu2'>";}
            if($_SESSION['ResolutionConnexion1'] > 800) {$SousMenuCorp.="<a href='".$Dossier."modules/clients/modclieSupp.php?clienum=".$clienum."' class='LoadPage ClieSupp button ImgSousMenu2 buttonMargRight'>";}
            $SousMenuCorp.="<img src='".$Dossier."images/supprimerBlanc.png' class='ImgSousMenu2'>";
            $SousMenuCorp.=$Libe."</a></div>";
        }

        if($req1Affich['cliesupp'] == 2 OR $req1Affich['cliesupp'] == 5)
        {
            if($_SESSION['ResolutionConnexion1'] <= 800) {$Indicateur = 1;}
            else {$Indicateur = 2;}
            // REVENU
            $Libe = "";
            if($_SESSION['ResolutionConnexion1'] <= 800) {$Libe = $_SESSION['STrad453'];	}
            else  {$Libe = $_SESSION['STrad453'];}
            $SousMenuCorp.="<div class='buttonBasMenuFixedRub'";if($_SESSION['ResolutionConnexion1'] <= 800) {$SousMenuCorp.=" style='width:".$ResultatTailleWidth."%;'";}
            $SousMenuCorp.=">";
            if($_SESSION['ResolutionConnexion1'] <= 800) {$SousMenuCorp.="<a href='".$Dossier."modules/profil/modprofilfichcomplet".$Indicateur.".php?clienum=".$clienum."&cliesupp=1' class='LoadPage AfficheFicheProfil".$Indicateur." ImgSousMenu2'>";}
            if($_SESSION['ResolutionConnexion1'] > 800) {$SousMenuCorp.="<a href='".$Dossier."modules/profil/modprofilfichcomplet".$Indicateur.".php?clienum=".$clienum."&cliesupp=1' class='LoadPage AfficheFicheProfil".$Indicateur."";}
            $SousMenuCorp.="<img src='".$Dossier."images/supprimerBlanc.png' class='ImgSousMenu2'>";
            $SousMenuCorp.=$Libe."</a></div>";
        }

        // AJOUTER FACTURE
        $Libe = "";
        if($_SESSION['ResolutionConnexion1'] <= 800) {$Libe = $_SESSION['STrad398'];}
        else {$Libe = $_SESSION['STrad399'];}
        $SousMenuCorp.="<div class='buttonBasMenuFixedRub'";if($_SESSION['ResolutionConnexion1'] <= 800) {$SousMenuCorp.=" style='width:".$ResultatTailleWidth."%;'";}
        $SousMenuCorp.="><a href='".$Dossier."modules/facturation/modfactAjouter.php?facttype=4&clienum=".$clienum."' class='LoadPage FactAjouter";
        if($_SESSION['ResolutionConnexion1'] > 800) {$SousMenuCorp.=" button ImgSousMenu2 buttonMargRight";} else {$SousMenuCorp.=" ImgSousMenu2";	}
        $SousMenuCorp.="'><img src='".$Dossier."images/ajouterBlanc.png' class='ImgSousMenu2''>";
        $SousMenuCorp.=$Libe."</a></div>";

        // ENVOYER IDENTIFIANTS
        $Libe = "";
        if($_SESSION['ResolutionConnexion1'] <= 800) {$Libe = $_SESSION['STrad401'];}
        else {$Libe = $_SESSION['STrad400'];}
        $SousMenuCorp.="<div class='buttonBasMenuFixedRub'";if($_SESSION['ResolutionConnexion1'] <= 800) {$SousMenuCorp.=" style='width:".$ResultatTailleWidth."%;'";}
        $SousMenuCorp.=">";
        if($_SESSION['ResolutionConnexion1'] <= 800) {$SousMenuCorp.="<a href='".$Dossier."modules/profil/modIdentifiants_script.php?clienum=".$clienum."' class='LoadPage ProfilIdentifiants1 ImgSousMenu2'>";}
        if($_SESSION['ResolutionConnexion1'] > 800) {$SousMenuCorp.="<a href='".$Dossier."modules/profil/modIdentifiants_script.php?clienum=".$clienum."' class='LoadPage ProfilIdentifiants2 button ImgSousMenu2 buttonMargRight'>";}
        $SousMenuCorp.="<img src='".$Dossier."images/envoyerBlanc.png' class='ImgSousMenu2'>";
        $SousMenuCorp.=$Libe."</a></div>";
    }

    // FERMER
    if($_SESSION['ResolutionConnexion1'] <= 800)
    {
        $Libe = $_SESSION['STrad705'];
        $SousMenuCorp.="<div class='buttonBasMenuFixedRub'";if($_SESSION['ResolutionConnexion1'] <= 800) {$SousMenuCorp.=" style='width:".$ResultatTailleWidth."%;'";}
        $SousMenuCorp.="><a href='#close' class='";
        if($_SESSION['ResolutionConnexion1'] > 800) {$SousMenuCorp.=" button buttonLittle buttonMargRight";} else {$SousMenuCorp.="ImgSousMenu2";}
        $SousMenuCorp.="'><img src='".$Dossier."images/closeBlanc.png' class='ImgSousMenu2'>";
        $SousMenuCorp.=$Libe."</a></div>";
    }

    $Lecture.="<div class='buttonBasMenuFixed1'>";
    $Lecture.=$SousMenuCorp;
    $Lecture.="</div>";

    return $Lecture;
}
//************************************************************************************

//******************************** LISTE TOUS LES PAYS **************************
function ListePays($num,$ConnexionBdd)
{
    $Lecture.="<option value=''>-- Pays --</option>";
    $req = 'SELECT confpayslibe FROM confpays ORDER BY confpayslibe ASC';
    $reqResult = $ConnexionBdd ->query($req) or die ('Erreur SQL !'.$req.'<br />'.mysqli_error());
    while($reqAffich = $reqResult->fetch())
    {
        $Lecture.="<option value='".$reqAffich[0]."'";if($num == $reqAffich[0]) {$Lecture.=" selected";} $Lecture.=">".$reqAffich[0]."</option>";
    }
    return $Lecture;
}
//****************************************************************************************

//****************** COMMENTAIRES FACTURES, CLIENTS, CHEVAUX, CALENDRIER *************************
function CommentairesGenerals($Dossier,$ConnexionBdd,$factnum,$clienum,$chevnum,$calenum,$NoAffiche)
{
    if($NoAffiche == 2) {$Lecture.="<a href='".$Dossier."modules/divers/AfficheCommentaireGeneral.php?factnum=".$factnum."&calenum=".$calenum."' class='LoadPage CommGeneAffiche'";if(!empty($calenum)) {$Lecture.=" style='width:100%;'";} $Lecture.="><div class='LienDefilement1'>".$_SESSION['STrad209']."</div></a>";}
    if($NoAffiche != 2)
    {
        $Lecture.="<a href='".$Dossier."modules/divers/AfficheCommentaireGeneral.php?factnum=".$factnum."&calenum=".$calenum."&NoAffiche=2' class='LoadPage CommGeneAffiche'><div class='LienDefilement1'";if(!empty($calenum)) {$Lecture.=" style='width:100%;'";} $Lecture.=">".$_SESSION['STrad210']."</div></a>";

        $Lecture.="<table class='table'>";
        $req1 = 'SELECT * FROM commentairesgenerals WHERE AA_equimondo_hebeappnum = "'.$_SESSION['hebeappnum'].'"';
        if(!empty($factnum)) {$req1.= ' AND factures_factnum = "'.$factnum.'"';}
        if(!empty($calenum)) {$req1.= ' AND calendrier_calenum = "'.$calenum.'"';}
        if(!empty($clienum)) {$req1.= ' AND clients_clienum = "'.$clienum.'"';}
        if(!empty($chevnum)) {$req1.= ' AND chevaux_chevnum = "'.$chevnum.'"';}
        $req1.=' ORDER BY commgenedate DESC';
        $req1Result = $ConnexionBdd ->query($req1) or die ('Erreur SQL !'.$req1.'<br />'.mysqli_error());
        while($req1Affich = $req1Result->fetch())
        {
            $Lecture.="<tr>";
            $Lecture.="<td style='width:70%;'>".AuthLect($req1Affich['authentification_authnum'],$ConnexionBdd)."</td>";
            $Lecture.="<td style='width:30%;'><div style='float:right;'>".FormatDateTimeMySql($req1Affich['commgenedate'])."</div></td>";

            $Lecture.="<td style='width:90%;'>".nl2br($req1Affich['commgenelibe'])."</td>";
            $Lecture.="<td style='width:10%;'><div style='float:right;'>";
            if($_SESSION['connind'] == "util" OR ($_SESSION['connind'] == "clie" AND $_SESSION['authconnauthnum'] == $req1Affich['authentification_authnum'])) {$Lecture.="<a href='".$Dossier."modules/divers/commentairegeneral_script.php?commgenenum=".$req1Affich['commgenenum']."&commgenesupp=2&factnum=".$clienum."&calenum=".$calenum."&factnum=".$factnum."&chevnum=".$chevnum."' class='CommGeneSupp'>Supp</a>";}
            $Lecture.="</div></td>";
            $Lecture.="</tr>";
        }
        $Lecture.="<table>";

        $Lecture.="<div style='height:15px;clear:both;display:block;'></div>";
        $Lecture.="<form id='FormMessageGeneral' action=''>";
        $Lecture.="<input type='hidden' name='authnum' value='".$_SESSION['authconnauthnum']."'>";
        if(!empty($calenum)) {$Lecture.="<input type='hidden' name='calenum' value='".$calenum."'>";}
        if(!empty($factnum)) {$Lecture.="<input type='hidden' name='factnum' value='".$factnum."'>";}
        if(!empty($chevnum)) {$Lecture.="<input type='hidden' name='chevnum' value='".$chevnum."'>";}
        if(!empty($clienum)) {$Lecture.="<input type='hidden' name='clienum' value='".$clienum."'>";}

        $Lecture.="<div class='mb-3 top-label'>";
        $Lecture.="<textarea class='form-control' name='commgenelibe' rows='2'></textarea>";
        $Lecture.="<span>".$_SESSION['STrad801']."</span>";
        $Lecture.="</div>";
        $Lecture.="<button class='btn btn-primary' type='submit'>".$_SESSION['STrad110']."</button>";
        $Lecture.="</form>";

        $Lecture.="</div>";
    }
    return $Lecture;
}
//***********************************************************

//******************************* CLIENTS CIVITE ************************************
function ClieCiviliteLect($num)
{
    if($num == 1){return $_SESSION['STrad336'];}
    else if($num == 2){return $_SESSION['STrad337'];}
    else if($num == 3){return $_SESSION['STrad338'];}
    else if($num == 5){return $_SESSION['STrad339'];}
    else if($num == 6){return $_SESSION['STrad340'];}
    else if($num == 7){return $_SESSION['STrad341'];}
    else if($num == 8){return $_SESSION['STrad342'];}
    else {return $num;}
}

function ClieCiviliteSelect($num)
{
    $Lecture.="<option value=''>-- ".$_SESSION['STrad62']." --</option>";
    $Lecture.="<option value='1'";if($num == 1) {$Lecture.=" selected";} $Lecture.=">".$_SESSION['STrad336']."</option>";
    $Lecture.="<option value='2'";if($num == 2) {$Lecture.=" selected";} $Lecture.=">".$_SESSION['STrad337']."</option>";
    $Lecture.="<option value='3'";if($num == 3) {$Lecture.=" selected";} $Lecture.=">".$_SESSION['STrad338']."</option>";
    $Lecture.="<option value='5'";if($num == 5) {$Lecture.=" selected";} $Lecture.=">".$_SESSION['STrad339']."</option>";
    $Lecture.="<option value='6'";if($num == 6) {$Lecture.=" selected";} $Lecture.=">".$_SESSION['STrad340']."</option>";
    $Lecture.="<option value='7'";if($num == 7) {$Lecture.=" selected";} $Lecture.=">".$_SESSION['STrad341']."</option>";
    $Lecture.="<option value='8'";if($num == 8) {$Lecture.=" selected";} $Lecture.=">".$_SESSION['STrad342']."</option>";

    return $Lecture;
}
//**********************************************************************************************

//**************************** FONCTION STATUS CAVALIER ***************************************
function ClieStatusSelect($status)
{
    $Lecture.="<option value=''>-- ".$_SESSION['STrad299']." --</option>";
    $Lecture.="<option value='1'"; if($status == 1) {$Lecture.=" selected";} $Lecture.=">".$_SESSION['STrad343']."</option>";
    $Lecture.="<option value='2'"; if($status == 2) {$Lecture.=" selected";} $Lecture.=">".$_SESSION['STrad344']."</option>";
    $Lecture.="<option value='3'"; if($status == 3) {$Lecture.=" selected";} $Lecture.=">".$_SESSION['STrad345']."</option>";
    $Lecture.="<option value='4'"; if($status == 4) {$Lecture.=" selected";} $Lecture.=">".$_SESSION['STrad346']."</option>";
    $Lecture.="<option value='6'"; if($status == 6) {$Lecture.=" selected";} $Lecture.=">".$_SESSION['STrad347']."</option>";
    $Lecture.="<option value='5'"; if($status == 5) {$Lecture.=" selected";} $Lecture.=">".$_SESSION['STrad348']."</option>";

    return $Lecture;
}
function ClieStatus($status)
{
    if($status == 1) {return $_SESSION['STrad343'];}
    if($status == 2) {return $_SESSION['STrad344'];}
    if($status == 3) {return $_SESSION['STrad345'];}
    if($status == 4) {return $_SESSION['STrad346'];}
    if($status == 5) {return $_SESSION['STrad348'];}
    if($status == 6) {return $_SESSION['STrad347'];}
}
//****************************************************************************************

//************************** GEN�RE DES NOUVEAUX IDENTIFIANTS **************************
function VerifLogin($clienum,$utilnum,$ConnexionBdd,$Dossier)
{
    $mdpGen = Genere_Password(6);
    $mdp = MD5($mdpGen);

    /*Pour un client*/
    if(!empty($clienum))
    {
        $req2 = 'UPDATE clients SET clieautoappli ="2" WHERE clienum = "'.$clienum.'"';
        $req2Result = $ConnexionBdd ->query($req2) or die ('Erreur SQL !'.$req2.'<br />'.mysqli_error());

        $req1 = 'SELECT count(authnum),authlogin FROM authentification WHERE clients_clienum = "'.$clienum.'"';
        $req1Result = $ConnexionBdd ->query($req1) or die ('Erreur SQL !'.$req1.'<br />'.mysqli_error());
        $req1Affich = $req1Result->fetch();

        $req2 = 'SELECT clieadremail,AA_equimondo_hebeappnum,clieautoappli,clienom,clieprenom FROM clients WHERE clienum = "'.$clienum.'"';
        $req2Result = $ConnexionBdd ->query($req2) or die ('Erreur SQL !'.$req2.'<br />'.mysqli_error());
        $req2Affich = $req2Result->fetch();
        $nom = $req2Affich[3].' '.$req2Affich[4];

        $adresmail = $req2Affich[0];
        $AA_equimondo_hebeappnum = $req2Affich[1];
    }
    /*Pour un utilisateur*/
    if(!empty($utilnum))
    {
        $req2 = 'UPDATE utilisateurs SET utilautoappli ="2" WHERE utilnum = "'.$utilnum.'"';
        $req2Result = $ConnexionBdd ->query($req2) or die ('Erreur SQL !'.$req2.'<br />'.mysqli_error());

        $req1 = 'SELECT count(authnum),authlogin FROM authentification WHERE utilisateurs_utilnum = "'.$utilnum.'"';
        $req1Result = $ConnexionBdd ->query($req1) or die ('Erreur SQL !'.$req1.'<br />'.mysqli_error());
        $req1Affich = $req1Result->fetch();

        $req2 = 'SELECT utiladresmail,AA_equimondo_hebeappnum,utilautoappli,utilnom,utilprenom FROM utilisateurs WHERE utilnum = "'.$utilnum.'"';
        $req2Result = $ConnexionBdd ->query($req2) or die ('Erreur SQL !'.$req2.'<br />'.mysqli_error());
        $req2Affich = $req2Result->fetch();
        $AA_equimondo_hebeappnum = $req2Affich[1];
        $nom = $req2Affich[3].' '.$req2Affich[4];

        $adresmail = $req2Affich[0];
    }

    // GENERE UN NOUVEAU LOGIN
    $reqVerif1 = 'SELECT count(authnum) FROM authentification where authlogin = "'.$adresmail.'"';
    $reqVerif1Result = $ConnexionBdd ->query($reqVerif1) or die ('Erreur SQL !'.$reqVerif1.'<br />'.mysqli_error());
    $reqVerif1Affich = $reqVerif1Result->fetch();
    if($reqVerif1Affich[0] == 0)
    {
        $NewLogin = $adresmail;
    }
    else
    {
        $NewLogin = Genere_Password(6);
    }

    /* GENERER UN LOGIN */
    if($req1Affich[0] == 1)
    {
        if(empty($req1Affich[1])) {$login = $NewLogin;}
        else {$login = $req1Affich[1];}
        $req2 = 'UPDATE authentification SET authlogin = "'.$login.'", authmdp = "'.$mdp.'" WHERE';if(!empty($clienum)) {$req2.=' clients_clienum = "'.$clienum.'"';}if(!empty($utilnum)) {$req2.=' utilisateurs_utilnum = "'.$utilnum.'"';}
        $req2Result = $ConnexionBdd ->query($req2) or die ('Erreur SQL !'.$req2.'<br />'.mysqli_error());
    }
    else if($req1Affich[0] == 0)
    {
        if(!empty($utilnum)) {$num = $utilnum;}
        if(!empty($clienum)) {$num = $clienum;}

        $login = $NewLogin;

        if(!empty($utilnum))
        {
            $req2 = 'INSERT INTO authentification VALUE (NULL,"'.$login.'","'.$mdp.'","0000-00-00 00:00:00","'.$utilnum.'",NULL,"'.$AA_equimondo_hebeappnum.'","1","1",null,null,null)';
            $req2Result = $ConnexionBdd ->query($req2) or die ('Erreur SQL !'.$req2.'<br />'.mysqli_error());
        }
        if(!empty($clienum))
        {
            $req2 = 'INSERT INTO authentification VALUE (NULL,"'.$login.'","'.$mdp.'","0000-00-00 00:00:00",NULL,"'.$clienum.'","'.$AA_equimondo_hebeappnum.'","1","1",null,null,null)';
            $req2Result = $ConnexionBdd ->query($req2) or die ('Erreur SQL !'.$req2.'<br />'.mysqli_error());
        }
    }

    $objet = $_SESSION['STrad402'];
    $messagemail.=$_SESSION['STrad405'];
    $messagemail.=$_SESSION['STrad421'].' : <b><a href="http://equimondo.app/">http://equimondo.app/</a></b><br>';
    $messagemail.=$_SESSION['STrad404']." : <b>".$login."</b><br>";
    $messagemail.=$_SESSION['STrad403']." : <b>".$mdpGen."</b><br><br>";

    if(!empty($clienum))
    {
        $messagemail.=$_SESSION['confentrnom']." ".$_SESSION['STrad406']." :<br>";
        $messagemail.="<ul>";
        $messagemail.="<li>".$_SESSION['STrad407']." :</li><br>";
        $messagemail.="<i>".$_SESSION['STrad408']."</i><br>";
        $messagemail.="<li>".$_SESSION['STrad409']." :</li><br>";
        $messagemail.="<i>".$_SESSION['STrad410']."</i><br>";
        $messagemail.="<li>".$_SESSION['STrad411']." :</li><br>";
        $messagemail.="<i>".$_SESSION['STrad412']."</i><br>";
        $messagemail.="<li>".$_SESSION['STrad413']." :</li><br>";
        $messagemail.="<i>".$_SESSION['STrad414']."</i><br>";
        $messagemail.="<li>".$_SESSION['STrad415']." :</li><br>";
        $messagemail.="<i>".$_SESSION['STrad416']."</i><br>";
    }

    $messagemail.=$_SESSION['STrad417']." <a href='http://".$_SERVER['SERVER_NAME']."'>http://".$_SERVER['SERVER_NAME']."</a><br><br>";
    $messagemail.=$_SESSION['STrad418']." !";

    $adresmail = $adresmail;
    $message = EnleverAccent($messagemail);

    return array($login,$adresmail,$message,$objet,$nom,$mdpGen);
}
//**************************************************************************************************

//**************************** GROUPE ***************************************
function GroupeList($Dossier,$ConnexionBdd,$groupind)
{
    if(!empty($_GET['groupind'])) {$groupind = $_GET['groupind'];}

    $Lecture.="<div style='height:20px;'></div>";

    $Lecture.="<table style='width:100%;'>";
    $req1 = 'SELECT * FROM groupe WHERE AA_equimondo_hebeappnum = "'.$_SESSION['hebeappnum'].'" AND groupind = "'.$groupind.'" ORDER BY groupnom ASC';
    $req1Result = $ConnexionBdd ->query($req1) or die ('Erreur SQL !'.$req1.'<br />'.mysqli_error());
    while($req1Affich = $req1Result->fetch())
    {
        $NbPart = 0;
        $req2 = 'SELECT * FROM groupe_association';
        if($req1Affich['groupind'] == 1) {$req2.=',clients';}
        if($req1Affich['groupind'] == 2) {$req2.=',chevaux';}
        $req2.=' WHERE groupe_groupnum = "'.$req1Affich['groupnum'].'"';
        if($req1Affich['groupind'] == 1) {$req2.=' AND clients_clienum = clienum AND cliesupp = "1"';}
        if($req1Affich['groupind'] == 2) {$req2.=' AND chevaux_chevnum = chevnum';}
        if($req1Affich['groupind'] == 1 AND $_SESSION['infologlang1'] == "es") {$req2.=' ORDER BY clieprenom ASC';}
        else if($req1Affich['groupind'] == 1 AND $_SESSION['infologlang1'] != "es") {$req2.=' ORDER BY clienom ASC';}
        if($req1Affich['groupind'] == 2) {$req2.=' ORDER BY chevnom ASC';}
        $req2Result = $ConnexionBdd ->query($req2) or die ('Erreur SQL !'.$req2.'<br />'.mysqli_error());
        while($req2Affich = $req2Result->fetch())
        {
            $NbPart = $NbPart + 1;
        }

        if($_SESSION['ResolutionConnexion1'] <= 800) {$Lien = "<a href='".$Dossier."modules/divers/modgroupefichcomplet1.php?groupnum=".$req1Affich['groupnum']."' class='LoadPage AfficheFicheGroupe1'>";}
        else {$Lien = "<a href='".$Dossier."modules/divers/modgroupefichcomplet2.php?groupnum=".$req1Affich['groupnum']."' class='LoadPage AfficheFicheGroupe2'>";}

        $Lecture.="<tr>";
        $Lecture.="<td><input type='checkbox' name='groupnum[]' value='".$req1Affich['groupnum']."'>".$Lien."<b style='font-weight:bolder;'>".$req1Affich['groupnom']." (".$NbPart.")</b></a></td>";
        $Lecture.="</tr>";
        $Lecture.="<tr>";
        $Lecture.="<td>".$Lien."<b style='font-style:italic;'>".$req1Affich['groupdesc']."</b></a></td>";
        $Lecture.="</tr>";
        $Lecture.="<tr>";
        $Lecture.="<td><hr class='HrListe1'></td>";
        $Lecture.="</tr>";
    }

    $Lecture.="</table>";

    return $Lecture;
}
//**************************************************************************************************

//************************ GROUPE FICHE COMPLET ******************************************
function GroupeFicheComplet($Dossier,$ConnexionBdd,$groupnum)
{
    $req1 = 'SELECT * FROM groupe WHERE groupnum = "'.$groupnum.'"';
    $req1Result = $ConnexionBdd ->query($req1) or die ('Erreur SQL !'.$req1.'<br />'.mysqli_error());
    $req1Affich = $req1Result->fetch();

    $Lecture.="<div style='height:15px;'></div>";
    $Lecture.="<a href='".$Dossier."modules/divers/modgroupesupp.php?groupnum=".$groupnum."&groupind=".$req1Affich['groupind']."' class='button buttonLittle LoadPage GroupeSupp1' style='margin-right:5px;'><img src='".$Dossier."images/supprimerBlanc.png' class='ImgSousMenu2'>".$_SESSION['STrad155']."</a>";
    if($_SESSION['ResolutionConnexion1'] > 800) {$Lecture.="<a href='".$Dossier."modules/divers/modgroupetelecharger_script.php?groupnum[]=".$groupnum."' class='button buttonLittle LoadPage GroupeTelecharger2'><img src='".$Dossier."images/telechargerBlanc.png' class='ImgSousMenu2'>".$_SESSION['STrad669']."</a>";}

    $Lecture.="<div style='height:15px;'></div>";
    $Lecture.="<div id='GroupeTelecharger2'></div>";

    $req1Affich['groupnom'] = str_replace("'"," ",$req1Affich['groupnom']);

    $Lecture.="<table>";
    $Lecture.="<tr>";
    $Lecture.="<td><input type='text' name='groupnom' id='InputModif1' class='champ_barre' placeholder='".$_SESSION['STrad423']."' value='".$req1Affich['groupnom']."'></td>";
    $Lecture.="</tr>";
    $Lecture.="<tr>";
    $Lecture.="<td><textarea id='InputModif2' name='groupdesc' class='champ_barre' placeholder='".$_SESSION['STrad240']."'>".$req1Affich['groupdesc']."</textarea></td>";
    $Lecture.="</tr>";
    $Lecture.="</table>";

    $Lecture.="<div style='height:30px;'></div>";

    $Lecture.="<div id='AfficheGroupeAssociation'>";
    $Lecture.=GroupeAssociation($Dossier,$ConnexionBdd,$groupnum);
    $Lecture.="</div>";

    return $Lecture;
}

function GroupeAssociation($Dossier,$ConnexionBdd,$groupnum)
{
    $Lecture.="<div class='InfoStandard FormInfoStandard1'><img src='".$Dossier."images/informationBlanc.png' class='imgSousMenu1' style='margin-right:10px;'>".$_SESSION['STrad745']."</div>";

    $req1 = 'SELECT * FROM groupe WHERE groupnum = "'.$groupnum.'"';
    $req1Result = $ConnexionBdd ->query($req1) or die ('Erreur SQL !'.$req1.'<br />'.mysqli_error());
    $req1Affich = $req1Result->fetch();

    $Lecture.="<table>";
    $req2 = 'SELECT * FROM groupe_association';
    if($req1Affich['groupind'] == 1) {$req2.=',clients';}
    if($req1Affich['groupind'] == 2) {$req2.=',chevaux';}
    $req2.=' WHERE groupe_groupnum = "'.$req1Affich['groupnum'].'"';
    if($req1Affich['groupind'] == 1) {$req2.=' AND clients_clienum = clienum AND cliesupp = "1"';}
    if($req1Affich['groupind'] == 2) {$req2.=' AND chevaux_chevnum = chevnum';}
    if($req1Affich['groupind'] == 1 AND $_SESSION['infologlang1'] == "es") {$req2.=' ORDER BY clieprenom ASC';}
    else if($req1Affich['groupind'] == 1 AND $_SESSION['infologlang1'] != "es") {$req2.=' ORDER BY clienom ASC';}
    if($req1Affich['groupind'] == 2) {$req2.=' ORDER BY chevnom ASC';}
    $req2Result = $ConnexionBdd ->query($req2) or die ('Erreur SQL !'.$req2.'<br />'.mysqli_error());
    while($req2Affich = $req2Result->fetch())
    {
        $Lecture.="<tr>";
        if(!empty($req2Affich['clients_clienum']))
        {
            $Lecture.="<td><a href='".$Dossier."modules/profil/modprofilfichcomplet1.php?clienum=".$req2Affich['clients_clienum']."' class='LoadPage AfficheFicheProfil1'>".ClieLect($req2Affich['clients_clienum'],$ConnexionBdd)."</a></td>";
        }
        if(!empty($req2Affich['chevaux_chevnum']))
        {
            $Lecture.="<td><a href='".$Dossier."modules/chevaux/modchevfichcomplet.php?chevnum=".$req2Affich['chevaux_chevnum']."'>".ChevLect($req2Affich['chevaux_chevnum'],$ConnexionBdd)."</a></td>";
        }
        $Lecture.="<td><a href='".$Dossier."modules/divers/modgroupassosupp_script.php?groupassonum=".$req2Affich['groupassonum']."&groupnum=".$req1Affich['groupnum']."' class='LoadPage GroupeAssociationSupp'><img src='".$Dossier."images/supprimer.png' class='ImgSousMenu2'></a></td>";
        $Lecture.="</tr>";
    }
    $Lecture.="</table>";

    $Lecture.="<div style='height:15px;'></div>";

    $Lecture.="<form id='FormGroupAssoAjou' action=''>";
    $Lecture.="<input type='hidden' name='groupnum' value='".$groupnum."'>";
    if($req1Affich['groupind'] == 1)
    {
        $Lecture.="<select name='clienum[]' class='champ_barre' id='select3' multiple>".ClieSelect($Dossier,$ConnexionBdd,$clienum,$faminum,$factnum,$AfficheNull,$AjouterClientPassage,$calenum,$chevnum,$AfficherAjouCava)."</select>";
    }
    if($req1Affich['groupind'] == 2)
    {
        $Lecture.="<select name='chevnum[]' class='champ_barre' id='select3' multiple>".ChevSelect($Dossier,$ConnexionBdd,null,null,null,null)."</select>";
    }
    $Lecture.="<div style='height:10px;'></div>";
    $Lecture.="<button class='button'><img src='".$Dossier."images/ajouterBlanc.png' class='ImgSousMenu2'>".$_SESSION['STrad160']."</button>";
    $Lecture.="</form>";

    return $Lecture;
}
//**************************************************************************************************


//****************** AFFICHER LES NOTIFICATIONS ****************************
function DiversNotification($Dossier,$ConnexionBdd)
{
    $Lecture.="<div id='noteNotifications'>";
    //*********************** RESERVATION EN LIGNE SUR LE CALENDRIER ***********************
    $reqReseCount = 'SELECT count(calepartnum) FROM calendrier,calendrier_participants,clients WHERE calendrier_calenum=calenum AND clients_clienum=clienum AND caleparttext1="1" AND calendrier.AA_equimondo_hebeappnum = "'.$_SESSION['hebeappnum'].'"';
    if(!empty($_GET['utilnum'])) {$reqReseCount.=' AND calendrier.utilisateurs_utilnum = "'.$_GET['utilnum'].'"';}
    $reqReseCountResult = $ConnexionBdd ->query($reqReseCount) or die ('Erreur SQL !'.$reqReseCount.'<br />'.mysqli_error());
    $reqReseCountAffich = $reqReseCountResult->fetch();
    if($reqReseCountAffich[0] == 0)
    {
        $Lecture.="<div class='InfoStandard FormInfoStandard6'><img src='".$Dossier."images/informationBlanc.png' class='imgSousMenu1' style='margin-right:10px;'>".$_SESSION['STrad671']."</div><br>";
    }
    if($reqReseCountAffich[0] >= 1)
    {
        $Lecture.="<div class='InfoStandard FormInfoStandard6'><img src='".$Dossier."images/informationBlanc.png' class='imgSousMenu1' style='margin-right:10px;'>".$_SESSION['STrad672']."</div>";
        /*
            echo "<form method='GET' action='' class='table_champ_barre'>";
              echo "<select name='utilnum' class='champ_barre' onchange='submit()'>".UtilSelect($_GET['utilnum'],$ConnexionBdd,1)."</select>";
            echo "</form>";
        */
        $Lecture.="<table class='tab_rubrique' style='width:100%;'>";
        $Lecture.="<thead>";
        $Lecture.="<tr>";
        $Lecture.="<td>".$_SESSION['STrad673']."</td>";
        $Lecture.="<td>".$_SESSION['STrad674']."</td>";
        $Lecture.="<td>".$_SESSION['STrad675']."</td>";
        //echo "<td>".$TradPlanLecoFichCompletSousTitre2."</td>";
        //echo '<td>'.$TradPlanValStag4.'<center><input onclick="CocheTout(this, \'calereserve1[]\');" type="checkbox"></center></td>';
        //echo '<td>'.$TradPlanValStag5.'<center><input onclick="CocheTout(this, \'calereserve2[]\');" type="checkbox"></center></td>';
        $Lecture.="</tr>";
        $Lecture.="</thead>";

        $Lecture.="<tbody>";
        $reqCale = 'SELECT calenum,caleindice,caledate1,caledate2,caletext3,caletext4,calendrier.utilisateurs_utilnum,clients_clienum,calepartnum,caletext7 FROM calendrier,calendrier_participants,calendrier_categorie WHERE calendrier_calenum = calenum AND caleparttext1="1" AND calendrier_categorie_calecatenum = calecatenum AND calendrier.AA_equimondo_hebeappnum = "'.$_SESSION['hebeappnum'].'"';
        if(!empty($_GET['utilnum'])) {$reqCale.=' AND calendrier.utilisateurs_utilnum = "'.$_GET['utilnum'].'"';}
        $reqCale.='GROUP BY calenum ORDER BY caledate1 ASC';
        $reqCaleResult = $ConnexionBdd ->query($reqCale) or die ('Erreur SQL !'.$reqCale.'<br />'.mysqli_error());
        while($reqCaleAffich = $reqCaleResult->fetch())
        {
            $reqCaleCount = 'SELECT count(calepartnum) FROM calendrier_participants WHERE calendrier_calenum = "'.$reqCaleAffich['calenum'].'" AND caleparttext2 = "3"';
            $reqCaleCountResult = $ConnexionBdd ->query($reqCaleCount) or die ('Erreur SQL !'.$reqCaleCount.'<br />'.mysqli_error());
            $reqCaleCountAffich = $reqCaleCountResult->fetch();

            $Lien = "<a href='".$Dossier."modules/calendrier/modcalefichcomplet.php?calenum=".$reqCaleAffich['calenum']."' class='LoadPage AfficheCaleFichComplet'>";

            $Color = RdvColor($reqCaleAffich['calenum'],$ConnexionBdd,$reqCaleAffich['utilisateurs_utilnum']);

            $Lecture.="<tr style='blackground-color:".$Color.";'>";
            $Lecture.="<td>".$Lien.CalendrierLect($reqCaleAffich[1])."</a></td>";
            $Lecture.="<td>".$Lien.FormatDateTimeMySql($reqCaleAffich[2]); if($reqCaleAffich[1] == 2) { echo "<br>".$TradDivPeriodeAu." ".FormatDateTimeMySql($reqCaleAffich[3]);} echo "</a></td>";
            $Lecture.="<td>".$Lien;

            // AFFICHE LE MONITEUR
            if(!empty($reqCaleAffich[6]))
            {
                $Lecture.=UtilLect($reqCaleAffich[6],$ConnexionBdd)."<br>";
            }

            // AFFICHE LE LIBELLE
            $Lecture.=RdvLibelle($reqCaleAffich[0],$ConnexionBdd)."<br>";

            // NOMBRE DE CAVALIER
            $Lecture.=$_SESSION['STrad676']." : ".$reqCaleCountAffich[0]."/".$reqCaleAffich['caletext7']."<br>";

            $Lecture.="</a></td>";
            $Lecture.="</tr>";


            $req2 = 'SELECT calenum,caleindice,caledate1,caledate2,caletext3,caletext4,calendrier.utilisateurs_utilnum,clients_clienum,calepartnum,caletext7 FROM calendrier,calendrier_participants,calendrier_categorie WHERE calendrier_calenum = calenum AND caleparttext1="1" AND calendrier_categorie_calecatenum = calecatenum AND calendrier.AA_equimondo_hebeappnum = "'.$_SESSION['hebeappnum'].'"';
            $req2.=' AND calenum = "'.$reqCaleAffich['calenum'].'"';
            $req2.=' ORDER BY clients_clienum ASC';
            $req2Result = $ConnexionBdd ->query($req2) or die ('Erreur SQL !'.$req2.'<br />'.mysqli_error());
            while($req2Affich = $req2Result->fetch())
            {
                $Lecture.="<tr>";
                $Lecture.="<td colspan='2'>";
                $Lecture.="<a href='".$Dossier."modules/profil/modprofilfichcomplet1.php?clienum=".$req2Affich['clients_clienum']."' class='LoadPage AfficheFicheProfil1'>".ClieLect($req2Affich['clients_clienum'],$ConnexionBdd)."</a>";
                $Lecture.="</td>";
                $Lecture.="<td>";
                $Lecture.="<div id='AfficheReservationCavalier".$_SESSION['NbExec']."'>";

                $Lecture.="<a href='".$Dossier."modules/calendrier/modcalereservation_script.php?calepartnum=".$req2Affich['calepartnum']."&reserverOK=2' class='AfficheReservationCavalier".$_SESSION['NbExec']."'><img src='".$Dossier."images/valider.png' class='imgSousMenu2'>".$_SESSION['STrad692']."</a><br>";
                $Lecture.="<a href='".$Dossier."modules/calendrier/modcalereservationAnnuler.php?calepartnum=".$req2Affich['calepartnum']."&NbExec=".$_SESSION['NbExec']."' class='SaisirAnnulationReservationCavalier".$_SESSION['NbExec']."'><img src='".$Dossier."images/annuler.png' class='imgSousMenu2'>".$_SESSION['STrad693']."</a>";
                $Lecture.="<div id='SaisirAnnulationReservationCavalier".$_SESSION['NbExec']."'></div>";

                $Lecture.="</div>";
                $Lecture.="</td>";
                $Lecture.="</tr>";
                $_SESSION['NbExec'] = $_SESSION['NbExec'] + 1;
            }
        }

        $Lecture.="</tbody></table>";

        $Lecture.="<div style='height:15px;clear:both;display:block;'></div>";

        //*********************************************************************
    }

    $Lecture.="<div style='height:30px;clear:both;display:block;'></div>";

    // CONFIRMER VUE DECOMMANDE
    //*********************** RESERVATION EN LIGNE SUR LE CALENDRIER ***********************
    $reqReseCount = 'SELECT count(calepartnum) FROM calendrier,calendrier_participants,clients WHERE calendrier_calenum=calenum AND clients_clienum=clienum AND caleparttext1="3" AND calendrier.AA_equimondo_hebeappnum = "'.$_SESSION['hebeappnum'].'"';
    if(!empty($_GET['utilnum'])) {$reqReseCount.=' AND calendrier.utilisateurs_utilnum = "'.$_GET['utilnum'].'"';}
    $reqReseCountResult = $ConnexionBdd ->query($reqReseCount) or die ('Erreur SQL !'.$reqReseCount.'<br />'.mysqli_error());
    $reqReseCountAffich = $reqReseCountResult->fetch();
    if($reqReseCountAffich[0] == 0)
    {
        $Lecture.="<div class='InfoStandard FormInfoStandard6'><img src='".$Dossier."images/informationBlanc.png' class='imgSousMenu1' style='margin-right:10px;'>".$_SESSION['STrad732']."</div><br>";
    }
    if($reqReseCountAffich[0] >= 1)
    {
        $Lecture.="<div class='InfoStandard FormInfoStandard6'><img src='".$Dossier."images/informationBlanc.png' class='imgSousMenu1' style='margin-right:10px;'>".$_SESSION['STrad733']."</div>";

        $Lecture.="<table class='tab_rubrique' style='width:100%;'>";
        $Lecture.="<thead>";
        $Lecture.="<tr>";
        $Lecture.="<td>".$_SESSION['STrad673']."</td>";
        $Lecture.="<td>".$_SESSION['STrad674']."</td>";
        $Lecture.="<td>".$_SESSION['STrad675']."</td>";
        //echo "<td>".$TradPlanLecoFichCompletSousTitre2."</td>";
        //echo '<td>'.$TradPlanValStag4.'<center><input onclick="CocheTout(this, \'calereserve1[]\');" type="checkbox"></center></td>';
        //echo '<td>'.$TradPlanValStag5.'<center><input onclick="CocheTout(this, \'calereserve2[]\');" type="checkbox"></center></td>';
        $Lecture.="</tr>";
        $Lecture.="</thead>";

        $Lecture.="<tbody>";
        $reqCale = 'SELECT calenum,caleindice,caledate1,caledate2,caletext3,caletext4,calendrier.utilisateurs_utilnum,clients_clienum,calepartnum,caletext7 FROM calendrier,calendrier_participants,calendrier_categorie WHERE calendrier_calenum = calenum AND caleparttext1="3" AND calendrier_categorie_calecatenum = calecatenum AND calendrier.AA_equimondo_hebeappnum = "'.$_SESSION['hebeappnum'].'"';
        if(!empty($_GET['utilnum'])) {$reqCale.=' AND calendrier.utilisateurs_utilnum = "'.$_GET['utilnum'].'"';}
        $reqCale.='GROUP BY calenum ORDER BY caledate1 ASC';
        $reqCaleResult = $ConnexionBdd ->query($reqCale) or die ('Erreur SQL !'.$reqCale.'<br />'.mysqli_error());
        while($reqCaleAffich = $reqCaleResult->fetch())
        {
            $reqCaleCount = 'SELECT count(calepartnum) FROM calendrier_participants WHERE calendrier_calenum = "'.$reqCaleAffich['calenum'].'" AND caleparttext2 = "6"';
            $reqCaleCountResult = $ConnexionBdd ->query($reqCaleCount) or die ('Erreur SQL !'.$reqCaleCount.'<br />'.mysqli_error());
            $reqCaleCountAffich = $reqCaleCountResult->fetch();

            $Lien = "<a href='".$Dossier."modules/calendrier/modcalefichcomplet.php?calenum=".$reqCaleAffich['calenum']."' class='LoadPage AfficheCaleFichComplet'>";

            $Lecture.="<tr>";
            $Lecture.="<td>".$Lien.CalendrierLect($reqCaleAffich[1])."</a></td>";
            $Lecture.="<td>".$Lien.FormatDateTimeMySql($reqCaleAffich[2]); if($reqCaleAffich[1] == 2) { echo "<br>".$TradDivPeriodeAu." ".FormatDateTimeMySql($reqCaleAffich[3]);} echo "</a></td>";
            $Lecture.="<td>".$Lien;

            // AFFICHE LE MONITEUR
            if(!empty($reqCaleAffich[6]))
            {
                $Lecture.=UtilLect($reqCaleAffich[6],$ConnexionBdd)."<br>";
            }

            // AFFICHE LE LIBELLE
            $Lecture.=RdvLibelle($reqCaleAffich[0],$ConnexionBdd)."<br>";

            // NOMBRE DE CAVALIER
            $Lecture.=$_SESSION['STrad676']." : ".$reqCaleCountAffich[0]."/".$reqCaleAffich['caletext7']."<br>";

            $Lecture.="</a></td>";
            $Lecture.="</tr>";


            $req2 = 'SELECT calenum,caleindice,caledate1,caledate2,caletext3,caletext4,calendrier.utilisateurs_utilnum,clients_clienum,calepartnum,caletext7 FROM calendrier,calendrier_participants,calendrier_categorie WHERE calendrier_calenum = calenum AND caleparttext1="3" AND calendrier_categorie_calecatenum = calecatenum AND calendrier.AA_equimondo_hebeappnum = "'.$_SESSION['hebeappnum'].'"';
            $req2.=' AND calenum = "'.$reqCaleAffich['calenum'].'"';
            $req2.=' ORDER BY clients_clienum ASC';
            $req2Result = $ConnexionBdd ->query($req2) or die ('Erreur SQL !'.$req2.'<br />'.mysqli_error());
            while($req2Affich = $req2Result->fetch())
            {
                $Lecture.="<tr style='height:35px;'>";
                $Lecture.="<td colspan='2'>";
                $Lecture.="<a href='".$Dossier."modules/profil/modprofilfichcomplet1.php?clienum=".$req2Affich['clients_clienum']."' class='LoadPage AfficheFicheProfil1'>".ClieLect($req2Affich['clients_clienum'],$ConnexionBdd)."</a>";
                $Lecture.="</td>";
                $Lecture.="<td>";
                $Lecture.="<a href='".$Dossier."modules/calendrier/modcalereservation_script.php?confirmedecommande=2&calepartnum=".$req2Affich['calepartnum']."' class='LoadPage CaleConfirmeDecommande button buttonLittle2'><img src='".$Dossier."images/valider.png' class='ImgSousMenu2'>".$_SESSION['STrad692']."</a>";
                $Lecture.="</td>";
                $Lecture.="</tr>";
            }
        }

        $Lecture.="</tbody></table>";

        $Lecture.="<div style='height:15px;clear:both;display:block;'></div>";
        //*********************************************************************
    }

    $Lecture.="</div>";

    return array($Lecture);
}
//**********************************************************************

//***************** CONNEXION *****************************
function ConnexionEquimondo1($Dossier,$ConnexionBdd,$adresmail,$calenum)
{
    if(!empty($calenum)) {$Form = "ConnexionEquimondoCale";}
    $Lecture.="<form id='".$Form."' action=''>";
    if(!empty($calenum)) {$Lecture.="<input type='hidden' name='calenum' value='".$calenum."'>";}
    $Lecture.="<input type='text' name='login' class='champ_barre' placeholder='".$_SESSION['STrad699']."' required>";
    $Lecture.="<input type='password' name='mdp' class='champ_barre' placeholder='".$_SESSION['STrad700']."' required>";
    $Lecture.="<center><button class='button'><img src='".$Dossier."images/connexionBlanc.png' class='ImgSousMenu2'>".$_SESSION['STrad701']."</button></center>";
    $Lecture.="<div id='noteConnexionEquimondoCale'></div>";
    $Lecture.="</form>";

    return $Lecture;
}
//**********************************************************************

// **************** VERIFIER SI LE CLIENUM FAIT PARTIE DE LA MEME FAMILLE QU'UN AUTRE CLIENUM
function VerifClienumOK($Dossier,$ConnexionBdd,$clienum)
{
    $reqClie = 'SELECT familleclients_famiclienum FROM clients WHERE clienum = "'.$clienum.'"';
    $reqClieResult = $ConnexionBdd ->query($reqClie) or die ('Erreur SQL !'.$reqClie.'<br />'.mysqli_error());
    $reqClieAffich = $reqClieResult->fetch();
    if($_SESSION['connauthfaminum'] == $reqClieAffich['familleclients_famiclienum']) {return 2;}
    else {return 1;}
}
//**********************************************************************


function ListeClients($ConnexionBdd,$Dossier) {
    $reqSign = 'SELECT clienum, clienom FROM clients';
        $req = $ConnexionBdd->query($reqSign) or die ('Erreur SQL !' . $req . '<br />' . mysqli_error());
        $res = $reqResultSign->fetch();
        while($row = $reqResultSign->fetch()){
            $data.= '<option value="'.$row['clienum'].'">'.$row['clienom'].'</option>';
        }
}

function ajouterSignature($ConnexionBdd,$Dossier,$docnum)
{

    // INFOS dosc
    if(!empty($_GET['docunum'])) {

        $reqSign = 'SELECT clienum, clienom FROM clients LIMIT 200 ';
        $reqResultSign = $ConnexionBdd->query($reqSign) or die ('Erreur SQL !' . $req . '<br />' . mysqli_error());
        $reqAffichSign = $reqResultSign->fetch();
        $data.=" <div class='col-12 col-sm-6 col-xl-4'>
        <div class='w-100'>
          <label class='form-label'>Choisissez le cheval</label>";
        $data.="<select id='clients' name='client' class='selectBasicClient'>";
        $data.="<option > Sélectionnez le client </option>";
            // while($row = $reqResultSign->fetch()){
            //     $data.= '<option value="'.$row['clienum'].'">'.$row['clienom'].'</option>';
            // }

            $data.="</select>  </div></div>";
$data.=" <div class='col-12 col-sm-6 col-xl-4'>
<div class='w-100'>
  <label class='form-label'>Choisissez le cheval</label>";
$data.="<select id='cheval' name='cheval' class='form-label'>";
   //$data.=" <option value=''>Select client first</option>";
$data.="</select>  </div>
</div>";

$data.="<button id='ajouSign'>Envoyer</button>";


$data.="<script>
        $(document).ready(function(){
        
        
        $('#ajouSign').on('click', function() {
            $('#ajouSign').attr('disabled', 'disabled');
            var client = $('#clients').val();
            var cheval = $('#cheval').val();
            console.log(cheval);
            var doc = ".$docnum.";
            if((client !='')){
                $.ajax({
                    url: 'ajouSign.php',
                    type: 'POST',
                    data: {
                        clienum: client,
                        chevnum: cheval,
                        docnum: doc
                    },
                    cache: false,
                    success: function(dataResult){
                        var dataResult = JSON.parse(dataResult);
                        if(dataResult.statusCode==200){
                            $('#ajoutSign').removeAttr('disabled');
                            
                            alert('success')
                        }
                        else if(dataResult.statusCode==201){
                            alert('Error occured !');
                        }

                    }
                });
            }
            else{
                alert('Remplir tous les champs !');
            }
        });
    });
    //  jQuery('#clients').select2();
   
    $('#clients').select2({
        ajax: {
          url: 'modlistclients.php',
          delay: 250,
          data: function (params) {
            return {
              q: params.term, // search term
              page: params.page
            };
          },
                processResults: function (data) {
                    // console.log(data);
                  var results = [];
                
                  $.each(JSON.parse(data), function (index, res) {
                      results.push({
                          id: res.id,
                          text: res.text
                      });
                  });
      
                  return {
                      results: results
                  };
          },
          cache: true
        }
       
      });
      $('#clients').on('change', function(){
        var clienum = $(this).val();
        console.log(clienum)
        if(clienum){
            $.ajax({
                type:'POST',
                url:'chevClient.php',
                data:{clienum:clienum},
                    success:function(html){
                        $('#cheval').html(html);
                    }
                });
        }
    });
    $('#cheval').select2();
    

    </script>";
        echo $data ;

    }


}


//function hex2dec
//returns an associative array (keys: R,G,B) from
//a hex html code (e.g. #3FE5AA)
function hex2dec($couleur = "#000000"){
    $R = substr($couleur, 1, 2);
    $rouge = hexdec($R);
    $V = substr($couleur, 3, 2);
    $vert = hexdec($V);
    $B = substr($couleur, 5, 2);
    $bleu = hexdec($B);
    $tbl_couleur = array();
    $tbl_couleur['R']=$rouge;
    $tbl_couleur['V']=$vert;
    $tbl_couleur['B']=$bleu;
    return $tbl_couleur;
}

//conversion pixel -> millimeter at 72 dpi
function px2mm($px){
    return $px*25.4/72;
}

function txtentities($html){
    $trans = get_html_translation_table(HTML_ENTITIES);
    $trans = array_flip($trans);
    return strtr($html, $trans);
}

include_once('../../libs/fpdf/fpdf.php');
class PDF extends FPDF
{
    protected $B;
    protected $I;
    protected $U;
    protected $HREF;
    protected $fontList;
    protected $issetfont;
    protected $issetcolor;

    function __construct($orientation='P', $unit='mm', $format='A4')
{
    //Call parent constructor
    parent::__construct($orientation,$unit,$format);
    //Initialization
    $this->B=0;
    $this->I=0;
    $this->U=0;
    $this->HREF='';
    $this->fontlist=array('arial', 'times', 'courier', 'helvetica', 'symbol');
    $this->issetfont=false;
    $this->issetcolor=false;
}

    function WriteHTML($html)
    {
        //HTML parser
        $html=strip_tags($html,"<b><u><i><a><img><p><br><strong><em><font><tr><blockquote>"); //supprime tous les tags sauf ceux reconnus
        $html=str_replace("\n",' ',$html); //remplace retour à la ligne par un espace
        $a=preg_split('/<(.*)>/U',$html,-1,PREG_SPLIT_DELIM_CAPTURE); //éclate la chaîne avec les balises
        foreach($a as $i=>$e)
        {
            if($i%2==0)
            {
                //Text
                if($this->HREF)
                    $this->PutLink($this->HREF,$e);
                else
                    $this->Write(5,stripslashes(txtentities($e)));
            }
            else
            {
                //Tag
                if($e[0]=='/')
                    $this->CloseTag(strtoupper(substr($e,1)));
                else
                {
                    //Extract attributes
                    $a2=explode(' ',$e);
                    $tag=strtoupper(array_shift($a2));
                    $attr=array();
                    foreach($a2 as $v)
                    {
                        if(preg_match('/([^=]*)=["\']?([^"\']*)/',$v,$a3))
                            $attr[strtoupper($a3[1])]=$a3[2];
                    }
                    $this->OpenTag($tag,$attr);
                }
            }
        }
    }
    
    function OpenTag($tag, $attr)
    {
        //Opening tag
        switch($tag){
            case 'STRONG':
                $this->SetStyle('B',true);
                break;
            case 'EM':
                $this->SetStyle('I',true);
                break;
            case 'B':
            case 'I':
            case 'U':
                $this->SetStyle($tag,true);
                break;
            case 'A':
                $this->HREF=$attr['HREF'];
                break;
            case 'IMG':
                if(isset($attr['SRC']) && (isset($attr['WIDTH']) || isset($attr['HEIGHT']))) {
                    if(!isset($attr['WIDTH']))
                        $attr['WIDTH'] = 0;
                    if(!isset($attr['HEIGHT']))
                        $attr['HEIGHT'] = 0;
                    $this->Image($attr['SRC'], $this->GetX(), $this->GetY(), px2mm($attr['WIDTH']), px2mm($attr['HEIGHT']));
                }
                break;
            case 'TR':
            case 'BLOCKQUOTE':
            case 'BR':
                $this->Ln(5);
                break;
            case 'P':
                $this->Ln(10);
                break;
            case 'FONT':
                if (isset($attr['COLOR']) && $attr['COLOR']!='') {
                    $coul=hex2dec($attr['COLOR']);
                    $this->SetTextColor($coul['R'],$coul['V'],$coul['B']);
                    $this->issetcolor=true;
                }
                if (isset($attr['FACE']) && in_array(strtolower($attr['FACE']), $this->fontlist)) {
                    $this->SetFont(strtolower($attr['FACE']));
                    $this->issetfont=true;
                }
                break;
        }
    }
    
    function CloseTag($tag)
    {
        //Closing tag
        if($tag=='STRONG')
            $tag='B';
        if($tag=='EM')
            $tag='I';
        if($tag=='B' || $tag=='I' || $tag=='U')
            $this->SetStyle($tag,false);
        if($tag=='A')
            $this->HREF='';
        if($tag=='FONT'){
            if ($this->issetcolor==true) {
                $this->SetTextColor(0);
            }
            if ($this->issetfont) {
                $this->SetFont('arial');
                $this->issetfont=false;
            }
        }
    }
    
    function SetStyle($tag, $enable)
    {
        //Modify style and select corresponding font
        $this->$tag+=($enable ? 1 : -1);
        $style='';
        foreach(array('B','I','U') as $s)
        {
            if($this->$s>0)
                $style.=$s;
        }
        $this->SetFont('',$style);
    }
    
    function PutLink($URL, $txt)
    {
        //Put a hyperlink
        $this->SetTextColor(0,0,255);
        $this->SetStyle('U',true);
        $this->Write(5,$txt,$URL);
        $this->SetStyle('U',false);
        $this->SetTextColor(0);
    }
    
    function Header()
    {

        $this->Image('../../img/flavicon_equimondo1.png',10,10,30);
        $this->SetFont('Arial','B',13);

        $this->Cell(80);

     //   $this->Cell(80,10,'Member List',1,0,'C');

      //  $this->Ln(20);
    }

    function Footer()
    {

        $this->SetY(-15);

        $this->SetFont('Arial','I',8);

        $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
    }
}

function DocPdfComplet($ConnexionBdd,$Dossier,$docnum)
{

    if(empty($_SESSION['hebeappnum']))
    {
        exit;
    }

    // INFOS dosc
    if(!empty($_GET['docunum'])) {
        $req = 'SELECT * FROM document WHERE docunum=' . $_GET['docunum'];
        $reqResult = $ConnexionBdd->query($req) or die ('Erreur SQL !' . $req . '<br />' . mysqli_error());
        $reqAffich = $reqResult->fetch();
         
        $Titre = $reqAffich['docutitre'];
        $desc = $reqAffich['docudescription'];
        

        $DateInsc = formatdatemysql($reqAffich['docudatecreation']);

    ob_end_clean();
    // Header content type

    $pdf = new PDF('p','mm','a4');
    $pdf->AddPage();
    $pdf->AliasNbPages();
    $pdf->SetAutoPageBreak(false);
    $pdf->SetFont('Arial','B',16);
    $pdf->Cell(50,20,''.$Titre, 1,0, 'C');
    $pdf->SetFont('Arial','',14);
    $pdf->Cell(100,20,''.$DateInsc, 'R');

    $pdf->Ln(40);
    $pdf->SetFont('Arial','',10);
    $pdf->WriteHTML($desc);
    $pdf->Ln(40);
    
    $i = 0;
    $pos=0;
    $j=0;
 
    $qry = 'SELECT document_signature.docnum, document_signature.signature, document_signature.clienum, clients.clienum, clients.clienom
    FROM
    document_signature
    left outer join clients ON document_signature.clienum = clients.clienum WHERE document_signature.docnum = '.$_GET['docunum'];
     $res = $ConnexionBdd->query($qry) or die ('Erreur SQL !' . $qry . '<br />' . mysqli_error());
     $r = $res->fetch();
     $num = $res->rowCount();

    //  $pdf->Cell(0, 20, "Cash Out Report", 1, 1, 'C');
    $width_cell=array(20,50,40,40,40);
$pdf->SetFont('Arial','B',16);

//Background color of header//
$pdf->SetFillColor(193,229,252);
    $i=0;
    $pdf->Cell($width_cell[0],10,'ID',1,0,'C',true);
    //Second header column//
    $pdf->Cell($width_cell[1],10,'NAME',1,0,'C',true);
    $pdf->SetFont('Arial','',14);
//Background color of header//
$pdf->SetFillColor(235,236,236); 
//to give alternate background fill color to rows// 
$fill=false;

  while ($r = $res->fetch())
{   print_r($r);
    $pdf->Ln();
    $pdf->Cell($width_cell[0],10,$r['clienom'],1,0,'C');
// $pdf->Cell($width_cell[1],10,$r['signature'],1,0,'L');
    // $client =$r['clienom'];
    // $sign = $r['signature']; 
    // $pdf->SetX(45);
    // $pdf->Cell(200+$pos,10,''.$client, 0,0, '');
    $pdf->Image($r['signature'],$width_cell[1],10,0);
     
    //100 c'est positionnement de horizentale
    // $pos=$pos+10;
    // $i = $i +1;
    // $fill = !$fill;

}
//   $pdf->AddPage();

// $pdf->Cell(15,8,"S/NO",1);
//     $pdf->Cell(45,8,"First Name",1);
//     $pdf->Cell(40,8,"Last Name",1);

    //writing every row fecthed to the pdf file
    // while ($record = $res->fetch()){
    //     print_r(array($record));
    //     $i=$i+1;
    //     $count +=1;
    //     $pdf->Ln();
    //     $pdf->Cell(15,8,$count,1,0,'C');
    //     $pdf->Cell(45,8,$record['clienom'],1);
    //     $pdf->Cell(40,8,($pdf->Image($r['signature'],10,100+$pos,0)),1);
        
        
    // }





   
    $pdf->Output('test.pdf','F');
    echo "<iframe src='test.pdf' width='800' height='800'></iframe>";
    }
    }
?>

