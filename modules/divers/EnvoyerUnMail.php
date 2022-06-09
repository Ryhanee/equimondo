<?php
$Dossier = "../../";
include $Dossier."modules/divers/connexionbdd.php";
include $Dossier."modules/traduction/langCompl_".$_SESSION['infologlang2'].".php";
include $Dossier."modules/traduction/lang_".$_SESSION['infologlang1'].".php";
include $Dossier."modules/function/allfunction.php";
include $Dossier."modules/function/allfunction_facturation.php";
include $Dossier."modules/envoimail1.php";

$_POST['message'] = str_replace("<p>","",$_POST['message']);
$_POST['message'] = str_replace("</p>","<br>",$_POST['message']);
$_POST['message'] = nl2br($_POST['message']);
if(!empty($_SESSION['hebeappnum'])) {$Hebeappnum = $_SESSION['hebeappnum'];}

//******************** PARAMETRE INFORMATION EXPEDITEUR ****************************
$req1 = 'SELECT confentrnom,confentradresmail FROM confentr WHERE AA_equimondo_hebeappnum = "'.$Hebeappnum.'"';
$req1Result = $ConnexionBdd ->query($req1) or die ('Erreur SQL !'.$req1.'<br />'.mysqli_error());
$req1Affich = $req1Result->fetch();
$Entr = $req1Affich[0];
$MailEntr = $req1Affich[1];
if(empty($MailEntr))
  {
    $Entr='Equimondo';
    $MailEntr = 'contact@equimondo.fr';
  }
//****************************************************************************

//************************** ENREGISTREMENT DU MAIL ENVOYE ***************************
$req3 = 'INSERT INTO envoi_mail VALUE (NULL,"'.date("Y-m-d H:i:s").'","'.$_POST['objet'].'","'.$_POST['message'].'","'.$_SESSION['hebeappnum'].'")';
$req3Result = $ConnexionBdd ->query($req3) or die ('Erreur SQL !'.$req3.'<br />'.mysqli_error());
$envmailnum = $ConnexionBdd->lastInsertId();

if(!empty($_POST['factnum']))
  {
    $req2 = 'SELECT * FROM factures,clients WHERE clients_clienum = clienum AND factnum = "'.$_POST['factnum'].'"';
    $req2Result = $ConnexionBdd ->query($req2) or die ('Erreur SQL !'.$req2.'<br />'.mysqli_error());
    $req2Affich = $req2Result->fetch();
    $nom = $req2Affich['clienom']." ".$req2Affich['clieprenom'];
    $facttype = $req2Affich['facttype'];
    $factlien = $req2Affich['factlien'];

    $req4 = 'INSERT INTO envoi_mail_participants VALUE (NULL,"'.$envmailnum.'","'.$req2Affich['clienum'].'",'.$_POST['factnum'].')';
    $req4Result = $ConnexionBdd ->query($req4) or die ('Erreur SQL !'.$req4.'<br />'.mysqli_error());
  }
//****************************************************************************

//***************** PIECE JOINTE **********************************
if ($_FILES['piecejointe'] == TRUE)
  {
    for ($i=0,$n=count($_FILES['piecejointe']);$i<$n;$i++)
      {
  	     $fichier1 = basename($_FILES['piecejointe']['name'][$i]);
  	     $extension1 = strrchr($_FILES['piecejointe']['name'][$i], '.');

  		   $taille_maxi = 3000000;
  		   $taille = filesize($_FILES['piecejointe']['tmp_name'][$i]);
  		   $extensions = array('.png', '.gif', '.jpg', '.jpeg', '.docx', '.doc', '.xlsx', '.xls', '.pdf', '.PDF');
  		   $extension1 = strrchr($_FILES['piecejointe']['name'][$i], '.');

  		   $fichier1 = AttribueNomFichier($extension1,$ConnexionBdd);

         $dossier = "/var/www/equimondo.fr/perso_images/mails/";
         $url = "https://equimondo.fr/perso_images/mails/";

  		   if(move_uploaded_file($_FILES['piecejointe']['tmp_name'][$i], $dossier.$fichier1))
  			   {
  				   $ConfMailFichierOK.= '<b><a href="'.$url.$fichier1.'">'.$Trad572.'</a></b><br>';

             $req = 'INSERT INTO envoi_mail_fichier VALUE (NULL,"'.$fichier1.'","'.$envmailnum.'")';
  				   $reqResult = $ConnexionBdd ->query($req) or die ('Erreur SQL !'.$req.'<br />'.mysqli_error());
  			   }
  		   else
  			   {
  				  $ConfMailFichier = $Trad573;
  			   }
  	  }
  }
//****************************************************************************

//********************** CONFIGUE MAIL ***************************
$message.= $_SESSION['conflogmail1']."<br>".$_POST['message'];
// S IL Y A UNE FACTURE
if(!empty($_POST['factnum'])) {
	$message.= '<br>'.$NTrad4.'<br/><a href="http://equimondo.app/modules/facturation/modfactImpression.php?factlien='.$req2Affich['factlien'].'&Impression=2">'.FactIndLect($req2Affich['facttype']).' '.formatdatemysql($req2Affich['factdate']).' N '.FactPrefLect($req2Affich['factdate'],$req2Affich['factnumlibe'],null).'</a><br/>';

}
if(!empty($ConfMailFichierOK)) {
	$message.="<br>".$ConfMailFichierOK;
}

$message.= "<br>".$_SESSION['conflogmail2'];
//****************************************************************************

//********************** ENVOI AUX EMAILS *******************************
if ($_POST['email'] == TRUE)
  {
    for ($i=0,$n=count($_POST['email']);$i<$n;$i++)
      {
        if(!empty($_POST['email'][$i]))
          {
            $reqInfo = 'SELECT factdate,factlien,clieadremail,clienom,clieprenom,clienum,facttype,factnumlibe,clienum,factnum FROM factures,clients WHERE factnum = "'.$_POST['factnum'].'" AND clients_clienum = clienum';
        		$reqInfoResult = $ConnexionBdd ->query($reqInfo) or die ('Erreur SQL !'.$reqInfo.'<br />'.mysqli_error());
        		$reqInfoAffich = $reqInfoResult->fetch();

        		$nom = $reqInfoAffich[3]." ".$reqInfoAffich[4];

        		//$message = $entete.$message.$Trad893.' :<br>';

        		$adresmail = $_POST['email'][$i];
        		$objet = $_POST['objet'];
        		$clienum = $reqInfoAffich[5];
        		$envmailnum = $envmailnum;
        		$factnumnum = $_POST['factnum'];

        		// Enregistrement dans la table des envois de mail
        		$reqEnvMail = 'INSERT INTO envoi_mail VALUE (NULL,"'.$_SESSION['HeureActuelle2'].'","'.$objet.'","'.CaracSpeciaux($message).'","'.$_SESSION['hebeappnum'].'")';
        		$reqEnvMailResult = $ConnexionBdd ->query($reqEnvMail) or die ('Erreur SQL !'.$reqEnvMail.'<br />'.mysqli_error());
        		$envmailnum = $ConnexionBdd->lastInsertId();

        		include $Dossier.'modules/envoimail2.php';
          }
      }
  }
//****************************************************************************

if(!empty($_POST['factnum']))
  {
    $_SESSION['confenr'] = $TradClieEnvoiMAil1;

    echo '<SCRIPT LANGUAGE = "javascript"> window.location.replace("'.$Dossier.'modules/facturation/modfactlist.php?facttype='.$facttype.'&factnum='.$_POST['factnum'].'") </SCRIPT>';
    exit;
  }
if(!empty($_POST['calenum']))
  {
    $_SESSION['confenr'] = $TradClieEnvoiMAil1;

    echo '<SCRIPT LANGUAGE = "javascript"> window.location.replace("'.$Dossier.'modules/calendrier/caleajou.php?calenum='.$_POST['calenum'].'") </SCRIPT>';
    exit;
  }

?>
