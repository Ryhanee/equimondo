<?php
$Dossier = "../../";
include $Dossier."modules/divers/connexionbdd.php";
    


// echo $_GET['q'];
if(!isset($_GET['q'])){ 
    $sql = "SELECT clienum, clienom FROM clients LIMIT 10"; 
$result = $ConnexionBdd->query($sql) or die ('Erreur SQL !' . $sql . '<br />' . mysqli_error());
}else{
    $search = $_GET['q'];
    $sql = "SELECT clienum, clienom FROM clients WHERE clienom LIKE '%".$search."%'
    LIMIT 10"; 
   // SELECT clienum, clienom FROM clients WHERE clienom LIKE '%test';

            $result = $ConnexionBdd->query($sql) or die ('Erreur SQL !' . $sql . '<br />' . mysqli_error());
           // $reqAffichSign = $reqResultSign->fetch();
}
$json = [];
    while($row = $result->fetch()){ 
             $json[] = ['id'=>$row['clienum'], 'text'=>$row['clienom']];
                //  $data.= '<option value="'.$row['clienum'].'">'.$row['clienom'].'</option>';
            }
            echo json_encode($json);


?>
