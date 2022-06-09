<?php
session_start();
$ConnexionBdd = new PDO('mysql:host=localhost;dbname=test_equimondo', 'root', '');

$req1 = 'SELECT * FROM clientssoldeforfsortie WHERE clients_clienum != "14959"';
$req1Result = $ConnexionBdd ->query($req1) or die ('Erreur SQL !'.$req1.'<br />'.mysqli_error());
while($req1Affich = $req1Result->fetch())
  {
    $req3 = 'SELECT count(clienum) FROM clients WHERE clienum = "'.$req1Affich['clients_clienum'].'"';
    $req3Result = $ConnexionBdd ->query($req3) or die ('Erreur SQL !'.$req3.'<br />'.mysqli_error());
    $req3Affich = $req3Result->fetch();
    if($req3Affich[0] >= 1)
      {
        $req2 = 'INSERT INTO clientssoldeforf VALUE (NULL,NULL,"'.$req1Affich['cliesoldforfsortnum'].'","'.$req1Affich['cliesoldforfsortdate'].'","'.$req1Affich['cliesoldforfsortdate'].'","'.$req1Affich['clients_clienum'].'")';
        $req2Result = $ConnexionBdd ->query($req2) or die ('Erreur SQL !'.$req2.'<br />'.mysqli_error());
      }
  }

$req1 = 'SELECT * FROM clientssoldeforfentree,clientssoldeforfentree_clients WHERE clientssoldeforfentree_cliesoldforfentrnum = cliesoldforfentrnum AND clients_clienum != "14959"';
$req1Result = $ConnexionBdd ->query($req1) or die ('Erreur SQL !'.$req1.'<br />'.mysqli_error());
while($req1Affich = $req1Result->fetch())
  {
    $req3 = 'SELECT count(clienum) FROM clients WHERE clienum = "'.$req1Affich['clients_clienum'].'"';
    $req3Result = $ConnexionBdd ->query($req3) or die ('Erreur SQL !'.$req3.'<br />'.mysqli_error());
    $req3Affich = $req3Result->fetch();
    if($req3Affich[0] >= 1)
      {
        $req2 = 'INSERT INTO clientssoldeforf VALUE (NULL,"'.$req1Affich['cliesoldforfentrnum'].'",NULL,"'.$req1Affich['cliesoldforfentrdate1'].'","'.$req1Affich['cliesoldforfentrdate2'].'","'.$req1Affich['clients_clienum'].'")';
        $req2Result = $ConnexionBdd ->query($req2) or die ('Erreur SQL !'.$req2.'<br />'.mysqli_error());
      }
  }

echo "fait ! ";
?>
