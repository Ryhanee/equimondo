<?php

$Dossier = "../../";

session_start();
include $Dossier."modules/divers/connexionbdd.php";
$clienum=$_POST['clienum'];
$cheval=$_POST['chevnum'];
echo $cheval;
$doc = $_POST['docnum'];
$cal = 10;
$token = sha1(mt_rand(1, 90000) . 'SALT');
$docsigne = 1;

if(!empty($cheval)){
    $chev = $cheval;
}else {
    $chev=null;
}

        $req = 'INSERT INTO document_association 
        (`docuassonum`,`docnum`, `clients_clienum`, `chevaux_chevnum`, `calendrier_calenum`, `docuassodate`, `docuassosigne`, `docuassocleurl`) 
        VALUES 
        (NULL,"'.$doc.'","'.$clienum.'","'.$chev.'","'.$cal.'","'.date("Y-m-d H:i:s").'","'.$docsigne.'","'.$token.'")';
        $reqResult = $ConnexionBdd ->query($req) or die ('Erreur SQL !'.$req.'<br />'.mysqli_error());

        // 'INSERT INTO `document_association` (`docuassonum`, `docnum`, `clients_clienum`, `chevaux_chevnum`, `calendrier_calenum`, `docuassodate`, `docuassosigne`, `docuassocleurl`) 
        // VALUES (NULL, '54', '294', '16964', '10', '2022-06-04 01:17:25.000000', '1', '24c24d31ff55ef0e8c7697307dc16c164285d923');
//envoi mail
ini_set();
error_reporting( E_ALL );
$from = "test@gmail.com";
$to = "dalhoumrihane@gmail.com";
$subject = "Signature du document";
$message = "<h2>Bonjour</h2><br><p> Bonjour veuillez signer ce document <br> 
<a href='http://localhost/alpha.equimondo.app/modules/documents/creationSignature.php?doc=".$doc."&cheval=".$cheval."&client=".$client. "token=".$token.">Cliquer ici</a>";
$headers = "From:" . $from;
ini_set();
if(mail($to,$subject,$message, $headers)) {
    echo "The email message was sent.";
} else {
    echo "The email message was not sent.";
}
?>


