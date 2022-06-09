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

if($_GET['crediterpointage'] == 2 AND !empty($_GET['calenum']))
  {
    // VERIF SI LA REPRISE EST BIEN INDIQUÉ DANS CLIENTSSOLDEFORF
		$req = 'SELECT calepartnum,caletext1,caledate1,clients_clienum,caleparttext2,calepartnbdebit FROM calendrier_participants,calendrier WHERE calendrier_calenum = calenum AND calendrier_calenum = "'.$_GET['calenum'].'"';
		$reqResult = $ConnexionBdd ->query($req) or die ('Erreur SQL !'.$req.'<br />'.mysqli_error());
		while($reqAffich = $reqResult->fetch())
			{
				$req1 = 'DELETE FROM clientssoldeforfsortie WHERE calendrier_participants_calepartnum = "'.$reqAffich[0].'"';
				$req1Result = $ConnexionBdd ->query($req1) or die ('Erreur SQL !'.$req1.'<br />'.mysqli_error());
			}

		$req = 'UPDATE calendrier SET caletext5 = "1" WHERE calenum = "'.$_GET['calenum'].'"';
		$reqResult = $ConnexionBdd ->query($req) or die ('Erreur SQL !'.$req.'<br />'.mysqli_error());
  }
else
  {
    if ($_POST['calenum'] == TRUE)
    	{
    		for ($i=0,$n=count($_POST['calenum']);$i<$n;$i++)
    			{
    				if(!empty($_POST['calenum'][$i]))
    					{
    						$req1 = 'UPDATE calendrier SET caletext5 = "3" WHERE calenum = "'.$_POST['calenum'][$i].'" AND caletext5 = "1"';
    						$req1Result = $ConnexionBdd ->query($req1) or die ('Erreur SQL !'.$req1.'<br />'.mysqli_error());
    					}
    			}
    	}

    if ($_POST['calepartforf'] == TRUE)
    	{
    		for ($i=0,$n=count($_POST['calepartforf']);$i<$n;$i++)
    			{
    				if(!empty($_POST['calepartforf'][$i]))
    					{
    						$calepartnum = stristr($_POST['calepartforf'][$i], '|');
    						$calepartnum = strstr($_POST['calepartforf'][$i],'|');
    						$forfnum=str_replace($calepartnum, "", $_POST['calepartforf'][$i]);
    						$calepartnum=str_replace("|", "", $calepartnum);

    						$req1 = 'SELECT caledate1,clienum,caletext1,caletext5,caletext9,calenum,caleparttext2,calepartnbdebit FROM calendrier,calendrier_participants,clients WHERE clients_clienum=clienum AND calendrier_calenum = calenum AND calepartnum = "'.$calepartnum.'"';
                $req1Result = $ConnexionBdd ->query($req1) or die ('Erreur SQL !'.$req1.'<br />'.mysqli_error());
    						$req1Affich = $req1Result->fetch();
    						if($req1Affich['caletext5'] == 3)
    							{
    								if(empty($req1Affich['caleparttext2']))
    									{
    										$req1Affich['caleparttext2'] = 3;
    										$req2 = 'UPDATE calendrier_participants SET caleparttext2 = "'.$req1Affich['caleparttext2'].'" WHERE calepartnum = "'.$calepartnum.'"';
    										$req2Result = $ConnexionBdd ->query($req2) or die ('Erreur SQL !'.$req2.'<br />'.mysqli_error());
    									}
    								if($req1Affich['caleparttext2'] == 3 OR $req1Affich['caleparttext2'] == 2)
    									{
    										if($calepartforf[$i] != "NULL") {$EntrSold = $forfnum;}
    										else if($calepartforf[$i] == "NULL") {$EntrSold = "NULL";}

    										if($EntrSold != "NULL")
    											{
    												$reqForf = 'SELECT * FROM clientssoldeforfentree WHERE cliesoldforfentrnum = "'.$EntrSold.'"';
    												$reqForfResult = $ConnexionBdd ->query($reqForf) or die ('Erreur SQL !'.$reqForf.'<br />'.mysqli_error());
    												$reqForfAffich = $reqForfResult->fetch();
    											}
    										$req2 = 'INSERT INTO clientssoldeforfsortie VALUE (NULL,"'.$req1Affich[0].'","'.$req1Affich['calepartnbdebit'].'","'.$req1Affich[1].'","'.$calepartnum.'",'.$EntrSold.',"'.$_SESSION['hebeappnum'].'","'.$reqForfAffich['cliesoldforfentrmontant'].'")';
                        $req2Result = $ConnexionBdd ->query($req2) or die ('Erreur SQL !'.$req2.'<br />'.mysqli_error());
    									}

    								$calenum1 = $req1Affich['calenum'];
    							}
    					}
    			}
    	}

    if ($_POST['calenum'] == TRUE)
    	{
    		for ($i=0,$n=count($_POST['calenum']);$i<$n;$i++)
    			{
    				if(!empty($_POST['calenum'][$i]))
    					{
    						$req1 = 'UPDATE calendrier SET caletext5 = "2" WHERE calenum = "'.$_POST['calenum'][$i].'"';
    						$req1Result = $ConnexionBdd ->query($req1) or die ('Erreur SQL !'.$req1.'<br />'.mysqli_error());
    					}
    			}
    	}
  }

if(!empty($_GET['calenum'])) {$calenum = $_GET['calenum'];}
if ($_POST['calenum'] == TRUE)
  {
    for ($i=0,$n=count($_POST['calenum']);$i<$n;$i++)
      {
        if(!empty($_POST['calenum'][$i]))
          {
            $calenum = $_POST['calenum'][$i];
          }
      }
  }

if(!empty($_POST['date']) OR !empty($_GET['date']))
  {
    if(!empty($_POST['date'])) {$date = $_POST['date'];}
    else if(!empty($_GET['date'])) {$date = $_GET['date'];}

    echo FicheMontoir($Dossier,$ConnexionBdd,null,$date);
  }
else
  {
    echo CalendrierFicheComplet($Dossier,$ConnexionBdd,$calenum);
  }
?>
