<?php
$Dossier = "../../";

session_start();
include $Dossier."modules/divers/connexionbdd.php";
$titre=$_POST['titre'];
$description=$_POST['description'];
$sign = $_POST['signature'];


  
if(!empty($_SESSION['hebeappnum'])) {$Hebeappnum = $_SESSION['hebeappnum'];}
else {$Hebeappnum = "NULL";}



        $req = 'INSERT INTO document (`docutitre`, `docudescription`, `docudatecreation`, `authentification_authnum`, `AA_equimondo_hebeappnum`) VALUES ("'.$titre.'","'.$description.'","'.date("Y-m-d H:i:s").'","'.$_SESSION['authconnauthnum'].'","'.$Hebeappnum.'")';
        $reqResult = $ConnexionBdd ->query($req) or die ('Erreur SQL !'.$req.'<br />'.mysqli_error());

        $id = $ConnexionBdd->lastInsertId();
        
//header('Location: '.$_POST['return_url']);
        if($sign !== "") {
              $upload_dir = 'perso_image';
              @chmod($upload_dir, 0777);
              $img = $_POST['signature'];
                $img = str_replace('data:image/png;base64,', '', $img);
                $img = str_replace(' ', '+', $img);
                $data = base64_decode($img);
                $file = $upload_dir . "/" . $_SESSION['authconnauthnum']. "_" . $id . ".png";
                $success = file_put_contents($file, $data);
                $signe = 1;
        }else {
                $file ="";
                $signe =0;
        }
echo $success;



$clt = 'SELECT `clients_clienum` FROM authentification WHERE authnum ='.$_SESSION['authconnauthnum'];
$cltreq = $ConnexionBdd ->query($clt) or die ('Erreur SQL !'.$clt.'<br />'.mysqli_error());
$cleint =$cltreq->fetch();

print_r($cleint[1]);

/*
$chev = 'SELECT chevaux_chevnum FROM avoir where clients_clienum ='.$cleint['clients_clienum'];
$reqResultChev = $ConnexionBdd ->query($chev) or die ('Erreur SQL !'.$chev.'<br />'.mysqli_error());
$cheval = $reqResultChev->fetch();
print_r($cheval['chevaux_chevnum']);
*/
$req = 'INSERT INTO document_signature (`signature`, `docnum`, `clienum`) VALUES ("'.$file.'","'.$id.'","'.$cleint['clients_clienum'].'")';
$reqResult = $ConnexionBdd ->query($req) or die ('Erreur SQL !'.$req.'<br />'.mysqli_error());

?>
