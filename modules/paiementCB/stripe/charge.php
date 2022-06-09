<?php

session_start();
 require_once('vendor/autoload.php');

  require_once('models/Client.php');
  require_once('models/Transaction.php');
$ConnexionBdd = new PDO('mysql:host=localhost;dbname=equimondo', 'root', '');

 \Stripe\Stripe::setApiKey('sk_test_51KsXiKLLT9r5SQwZtgREA4bjaL7RWz1HbUvzJNlM1TeXP1o17Lq5obhJVNsTdy2mO7SMyMhV3Kf4AuVaQEIaHodG00jlkEX3FK');
session_start();
// \Stripe\Stripe::setApiKey($_SESSION['infologbluepaididboutique']);



 // Sanitize POST Array
 $POST = filter_var_array($_POST, FILTER_SANITIZE_STRING);

 $nom = $POST['nom'];
 $prenom = $POST['prenom'];
 $email = $POST['email'];
 $token = $POST['stripeToken'];
$prix = 500;
$idPanier = 23;

// echo $token;
// Créer un client dans stripe
$client = \Stripe\Customer::create(array(
  "email" => $email,
  "source" => $token
));

// Charger les données du client
$charge = \Stripe\Charge::create(array(
  "amount" => $prix,
  "currency" => "eur",
  "description" => $idPanier,
  "customer" => $client->id
));

// print_r($charge);

// Données du client
// $clientData = [
//   'id' => $charge->customer,

//   'nom' => $nom,
//   'prenom' => $prenom,
//   'email' => $email
// ];

// ajouter un client a la bd.
//$reqConnHist = 'INSERT INTO clients (id, nom, prenom, email) VALUES ("'.$charge->customer.'", "'.$nom.'", "'.$prenom.'", "'.$email.'")';
//$reqConnHistResult = $ConnexionBdd ->query($reqConnHist) or die ('Erreur SQL !'.$reqConnHist.'<br />'.mysqli_error());
//$client->ajoutClient($clientData, $ConnexionBdd);


// données de transaction
// $transactionData = [
//   'id' => $charge->id,
//   'client_id' => $charge->customer,
//   'produit' => $charge->description,
//   'prix' => $charge->amount,
//   'devise' => $charge->currency,
//   'status' => $charge->status,
// ];


// Add Transaction To DB
// $reqTrans = 'INSERT INTO transactions (id, client_id, produit, prix, devise , status) VALUES ("'.$charge->id.'", "'.$charge->client.'", "'.$charge->description.'", "'.$charge->prix.'", "'.$charge->devise.'", "'.$charge->status.'")';
// $reqConnTransResult = $ConnexionBdd ->query($reqTrans) or die ('Erreur SQL !'.$reqTrans.'<br />'.mysqli_error());
//$transaction->addTransaction($transactionData);

// Redirect to success

header('Location: success.php?tid='.$charge->id.'&produit='.$charge->description.'&prix='.$charge->amount.'&devise='.$charge->currency);
