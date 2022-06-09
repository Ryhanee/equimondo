<?php
session_start();
$Dossier = "../../../";
include $Dossier."modules/divers/connexionbdd.php";
include $Dossier."modules/traduction/langCompl_".$_SESSION['infologlang2'].".php";
include $Dossier."modules/traduction/lang_".$_SESSION['infologlang1'].".php";

$reqClie = 'SELECT * FROM panier_association,caissesysteme1,clients WHERE clients_clienum = clienum AND panier_association.caissesysteme1_caissyst1num = caissyst1num AND panier_paninum = "'.$_GET['paninum'].'"';
$reqClieResult = $ConnexionBdd ->query($reqClie) or die ('Erreur SQL !'.$reqClie.'<br />'.mysqli_error());
$reqClieAffich = $reqClieResult->fetch();

$reqPanier = 'SELECT sum(caissyst2prix) FROM panier_association,caissesysteme1,caissesysteme2 WHERE caissesysteme2.caissesysteme1_caissyst1num = caissyst1num AND panier_association.caissesysteme1_caissyst1num = caissyst1num AND panier_paninum = "'.$_GET['paninum'].'"';
$reqPanierResult = $ConnexionBdd ->query($reqPanier) or die ('Erreur SQL !'.$reqPanier.'<br />'.mysqli_error());
$reqPanierAffich = $reqPanierResult->fetch();

$reqPanierAffich[0] = str_replace(".","",$reqPanierAffich[0]);

?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="iso-8859-1">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

  <title>Page de paiement</title>
<style>
input.form-control.mb-3.StripeElement.StripeElement--empty.col-md-6.left {
    margin-right: 11px;
    flex: 0 0 49%;
}
</style>
</head>
<body>
  <div class="container">

    <form action="./charge.php" method="post" id="payment-form">
      <div class="form-row">
      <input type="hidden" name="panier" value="<?php echo $_GET['paninum']; ?>">
      <?php if(empty($reqClieAffich['clienom'])) {echo $_SESSION['STrad851'];} ?>
       <input type="text" name="nom" value="<?php echo $reqClieAffich['clienom']; ?>" class="form-control mb-3 StripeElement StripeElement--empty col-md-6 left" placeholder="<?php echo $TradClieStanNom; ?>">
       <?php if(empty($reqClieAffich['clieprenom'])) {echo $_SESSION['STrad852'];} ?>
       <input type="text" name="prenom" value="<?php echo $reqClieAffich['clieprenom']; ?>" class="form-control mb-3 StripeElement StripeElement--empty col-md-6" placeholder="<?php echo $TradClieStanPrenom; ?>">
       <?php if(empty($reqClieAffich['clieadremail'])) {echo $_SESSION['STrad853'];} ?>
       <input type="email" name="email" value="<?php echo $reqClieAffich['clieadremail']; ?>" class="form-control mb-3 StripeElement StripeElement--empty col-md-6 left" placeholder="<?php echo $TradClieAdresMail; ?>">
	      <input type="hidden" name="prix" value="<?php echo $reqPanierAffich[0]; ?>">
        <div id="card-element" class="form-control">
          <!-- a Stripe Element will be inserted here. -->
        </div>

        <!-- Used to display form errors -->
        <div id="card-errors" role="alert"></div>
      </div>

      <button>Confirmer le paiement</button>
    </form>
  </div>
  <script
          src="https://code.jquery.com/jquery-3.6.0.min.js"
          integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
          crossorigin="anonymous"></script>
  <script src="https://js.stripe.com/v3/"></script>
  <script src="./js/charge.js" ></script>
</body>
</html>
