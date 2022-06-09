<?php
echo '<SCRIPT LANGUAGE = "javascript"> window.location.replace("#close") </SCRIPT>';
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
include $Dossier."js/divers.php";
echo $_SESSION['MiseEnFormeDivers'];

if(!empty($_POST['calecatelibe']) AND !empty($_POST['calecatetype']))
  {
    $req = 'INSERT INTO calendrier_categorie VALUE(NULL,"'.$_POST['calecatelibe'].'","'.$_SESSION['hebeappnum'].'","'.$_POST['calecatetype'].'")';
		$reqResult = $ConnexionBdd ->query($req) or die ('Erreur SQL !'.$req.'<br />'.mysqli_error());
		$_POST['calecatenum'] = $ConnexionBdd->lastInsertId();
  }

if (!empty($_POST['planlecomodinstalAjou']))
	{
    $instnum = InstallationRequete($Dossier,$ConnexionBdd,$_POST['planlecomodinstalAjou'],null,"ajou");
	}

$calenum = CalendrierAjou($_POST['calenum'],$_POST['calecatetype'],$_POST['caledate1'],$_POST['caledate2'],$_POST['caleheure1'],$_POST['caleheure2'],$_POST['caletext1'],$_POST['caletext2'],$_POST['caletext3'],$_POST['caletext4'],$_POST['caletext5'],$_POST['caletext6'],$_POST['caletext7'],$_POST['caletext8'],$_POST['chevnum'],$_POST['utilnum'],$_POST['repnum'],$_POST['factprestnum'],$_POST['caletext9'],$_POST['caletext10'],$_POST['caletext11'],$_POST['caletext12'],$_POST['caletext13'],$ConnexionBdd,$_POST['caleaction'],$_POST['calecatenum'],$_POST['caletext14'],$_POST['caletext15'],$_POST['caletext16']);

// DISCIPLINE
if ($_POST['calediscconflibe'] == TRUE)
	{
		for ($i=0,$n=count($_POST['calediscconflibe']);$i<$n;$i++)
			{
        if(!empty($_POST['calediscconflibe'][$i]))
          {
            $calediscconfnum = DisciplineRequete($Dossier,$ConnexionBdd,$_POST['calediscconflibe'][$i],"ajou");

            $req = 'INSERT INTO calendrier_discipline VALUE (NULL,"'.$calenum.'","'.$_POST['calediscconflibe'][$i].'")';
            $reqResult = $ConnexionBdd ->query($req) or die ('Erreur SQL !'.$req.'<br />'.mysqli_error());
          }
      }
  }
if ($_POST['calediscconfnum'] == TRUE)
	{
		for ($i=0,$n=count($_POST['calediscconfnum']);$i<$n;$i++)
			{
        if(!empty($_POST['calediscconfnum'][$i]) AND $_POST['calediscconfnum'][$i] != "ajou")
          {
            $req ='SELECT * FROM calendrier_discipline_configuration WHERE calediscconfnum = "'.$_POST['calediscconfnum'][$i].'"';
            $reqResult = $ConnexionBdd ->query($req) or die ('Erreur SQL !'.$req.'<br />'.mysqli_error());
            $reqAffich = $reqResult->fetch();

            $req = 'INSERT INTO calendrier_discipline VALUE (NULL,"'.$calenum.'","'.$reqAffich['calediscconflibe'].'")';
    				$reqResult = $ConnexionBdd ->query($req) or die ('Erreur SQL !'.$req.'<br />'.mysqli_error());
          }
			}
	}

// NIVEAU
if ($_POST['caleniveconflibe'] == TRUE)
	{
		for ($i=0,$n=count($_POST['caleniveconflibe']);$i<$n;$i++)
			{
				if(!empty($_POST['caleniveconflibe'][$i]))
					{
            $calenivecconfnum = NiveauRequete($Dossier,$ConnexionBdd,$_POST['caleniveconflibe'][$i],"ajou");

            $req = 'INSERT INTO calendrier_niveau VALUE (NULL,"'.$_POST['caleniveconflibe'][$i].'","'.$calenum.'")';
    				$reqResult = $ConnexionBdd ->query($req) or die ('Erreur SQL !'.$req.'<br />'.mysqli_error());
          }
			}
	}
if ($_POST['calenivenum'] == TRUE)
	{
		for ($i=0,$n=count($_POST['calenivenum']);$i<$n;$i++)
			{
				if(!empty($_POST['calenivenum'][$i]) AND $_POST['calenivenum'][$i] != "ajou")
					{
            $req = 'INSERT INTO calendrier_niveau VALUE (NULL,"'.$_POST['calenivenum'][$i].'","'.$calenum.'")';
    				$reqResult = $ConnexionBdd ->query($req) or die ('Erreur SQL !'.$req.'<br />'.mysqli_error());
          }
			}
	}

// AJOUT DES CAVALIER
if ($_POST['clienum'] == TRUE)
	{
		for ($i=0,$n=count($_POST['clienum']);$i<$n;$i++)
			{
				if(!empty($_POST['clienum'][$i]))
					{
            $calepartnum = CalendrierPartAjou($_POST['calepartnum'],$calenum,$_POST['clienum'][$i],null,$_POST['caleparttext1'],$_POST['caleparttext2'],$_POST['caleparttext3'],$_POST['caleparttext4'],$_POST['caleparttext5'],$_POST['caleparttext6'],$_POST['caleparttext7'],null,$_POST['cliesoldentrnum'],$_POST['calepartdate1'],$_POST['calepartdate2'],$ConnexionBdd,$_POST['caleaction'],$_POST['depecat'],$_POST['depemontantttc'],$_POST['caledate1'],$_POST['depetauxtva'],$_POST['calepartnumasso']);
          }
			}
	}

// AJOUT DES PRESTATIONS
if ($_POST['typeprestnum'] == TRUE)
	{
		for ($i=0,$n=count($_POST['typeprestnum']);$i<$n;$i++)
			{
				if(!empty($_POST['typeprestnum'][$i]))
					{
            $req = 'INSERT INTO calendrier_typeprestation VALUE (NULL,"'.$calenum.'","'.$_POST['typeprestnum'][$i].'","'.$_POST['prestprixttc'][$i].'")';
            $reqResult = $ConnexionBdd ->query($req) or die ('Erreur SQL !'.$req.'<br />'.mysqli_error());
          }
			}
	}

// AJOUT DES CHEVAUX
if ($_POST['chevnum'] == TRUE)
	{
		for ($i=0,$n=count($_POST['chevnum']);$i<$n;$i++)
			{
				if(!empty($_POST['chevnum'][$i]))
					{
            $calepartnum = CalendrierPartAjou($_POST['calepartnum'],$calenum,$_POST['clienum'][$i],$_POST['chevnum'][$i],$_POST['caleparttext1'],$_POST['caleparttext2'],$_POST['caleparttext3'],$_POST['caleparttext4'],$_POST['caleparttext5'],$_POST['caleparttext6'],$_POST['caleparttext7'],null,$_POST['cliesoldentrnum'],$_POST['calepartdate1'],$_POST['calepartdate2'],$ConnexionBdd,$_POST['caleaction'],$_POST['depecat'],$_POST['depemontantttc'],$_POST['caledate1'],$_POST['depetauxtva'],$_POST['calepartnumasso']);
          }
			}
	}

// CONDIITON CALENDRIER
if ($_POST['typeprestnum'] == TRUE)
	{
    for ($i=0,$n=count($_POST['typeprestnum']);$i<$n;$i++)
      {
        if(!empty($_POST['typeprestnum'][$i]))
          {
            $calecondnumOk = CaleConditions($Dossier,$ConnexionBdd,$calenum,$_POST['typeprestnum'][$i],$_POST['typeprestprix'][$i],$_POST['calecondind'][$i]);
          }
      }
  }

echo "<div class='alert alert-success' role='alert'>".$NTrad321."</div>";
$_SESSION['InputModifcalenum'] = $calenum;
echo CalendrierFicheComplet($Dossier,$ConnexionBdd,$calenum);

?>
<script src="<?php echo $Dossier; ?>js/divers.js"></script>
