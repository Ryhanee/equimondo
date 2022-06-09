<?php
$Dossier = "../../";
include $Dossier."modules/divers/connexionbdd.php";
// echo $_POST['clienum'];


    // Fetch state name base on country id
    $req = "SELECT avoir.chevaux_chevnum, avoir.clients_clienum , chevaux.chevnum , chevaux.chevnom FROM 
    avoir LEFT OUTER JOIN chevaux ON avoir.chevaux_chevnum = chevaux.chevnum WHERE avoir.clients_clienum =".$_POST['clienum'];
    $reqResultSign = $ConnexionBdd->query($req) or die ('Erreur SQL !' . $req . '<br />' . mysqli_error());
//    $reqAffichSign = $reqResultSign->fetch();
//    print_r($reqAffichSign);
    while ( $row = $reqResultSign->fetch()) {
            echo '<option value="'.$row['chevnum'].'">'.$row['chevnom'].'</option>';
    }




?>
