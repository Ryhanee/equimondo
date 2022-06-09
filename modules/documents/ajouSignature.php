<?php
$Dossier = "../../";

session_start();
include $Dossier."modules/divers/connexionbdd.php";


$cheval=$_POST['cheval'];
$doc=$_POST['doc'];
$sign = $_POST['signature'];
$client = $_POST['client'];
$token = $_POST['token'];


  
if(!empty($_SESSION['hebeappnum'])) {$Hebeappnum = $_SESSION['hebeappnum'];}
else {$Hebeappnum = "NULL";}

//header('Location: '.$_POST['return_url']);
if($sign !== "") {
    $upload_dir = 'perso_image';
    @chmod($upload_dir, 0777);
    $img = $_POST['signature'];
      $img = str_replace('data:image/png;base64,', '', $img);
      $img = str_replace(' ', '+', $img);
      $data = base64_decode($img);
      $file = $upload_dir . "/" . $_SESSION['authconnauthnum']. "_" . $doc . ".png";
      $success = file_put_contents($file, $data);
      $signe = 1;
}else {
      $file ="";
      $signe =0;
}
echo $success;
$reqToken = 'SELECT token from document_association where token='.$token;
$resToken = $ConnexionBdd ->query($reqToken) or die ('Erreur SQL !'.$reqToken.'<br />'.mysqli_error());
$reqAfTok = $resToken=>fetch()

if($token == $reqAfTok['token']){
$req = 'INSERT INTO document_signature (`signature`, `docnum`, `clienum`,`chevnum`) VALUES ("'.$file.'","'.$doc.'","'.$client.'","'.$cheval.'")';
$reqResult = $ConnexionBdd ->query($req) or die ('Erreur SQL !'.$req.'<br />'.mysqli_error());

       // $id = $ConnexionBdd->lastInsertId();
$req2='SELECT clieadremail FROM CLIENTS WHERE clienum ='.$client ;
$res2 = $ConnexionBdd ->query($req2) or die ('Erreur SQL !'.$req2.'<br />'.mysqli_error());
$resAf = $res2=>fetch();

}



/*
http://localhost/alpha.equimondo.app/modules/documents/creationSignature.php?doc=54&cheval=16964&client=294
*/


?>
