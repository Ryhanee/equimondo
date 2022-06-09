<?php
session_start();
  if(!empty($_GET['tid'] && !empty($_GET['produit']))) {
    $GET = filter_var_array($_GET, FILTER_SANITIZE_STRING);

    $tid = $GET['tid'];
    $produit = $GET['produit'];
   $devise = $_GET['devise'];
   //   $prenom = $_SESSION['prenom'];
      $prix = $GET['prix'];
      $status = $GET['status'];
echo $status;
  } else {
    header('Location: index.php');
  }

$Dossier = "../../../../";

// echo '<SCRIPT LANGUAGE = "javascript"> window.location.replace("'.$Dossier.'modules/calendrier/modcaleRetourPaiement.php?paninum='.$produit.'&refpaiement='.$tid.'") </SCRIPT>';
// exit;
?>

<!DOCTYPE html>
<html >
<head>
  <meta charset="iso-8859-1">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  <title>Succés de paiement</title>
</head>
<body>
  <div class="container mt-4">
    <h2>Le paiement est effectué avec succés </h2>
    <hr>
    <p>Référence de facture <?php echo $tid; ?></p>
<p><b>Produit</b> <?php echo $produit; ?></p>
      <p><b>Montant</b> <?php echo $prix.' '.$devise; ?></p>

    <p>Pour plus d'info veuillez consulter votre boite mail</p>
    <p><a href="index.php" class="btn btn-light mt-2">Précédent</a></p>
  </div>
</body>
</html>
