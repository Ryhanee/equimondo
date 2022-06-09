<?php
  require_once('config/db.php');
  require_once('lib/pdo_db.php');
  require_once('models/Client.php');

  // Instantiate Client
  $client = new Client();

  // Get Client
  $clients = $client->getClients();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  <title>View Customers</title>
</head>
<body>
  <div class="container mt-4">
    <div class="btn-group" role="group">
      <a href="clients.php" class="btn btn-primary">Customers</a>
      <a href="transactions.php" class="btn btn-secondary">Transactions</a>
    </div>
    <hr>
    <h2>Customers</h2>
    <table class="table table-striped">
      <thead>
        <tr>
          <th>Customer ID</th>
          <th>Name</th>
          <th>Email</th>
          <th>Date</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach($clients as $c): ?>
          <tr>
            <td><?php echo $c->id; ?></td>
            <td><?php echo $c->nom; ?> <?php echo $c->prenom; ?></td>
            <td><?php echo $c->email; ?></td>
            <td><?php echo $c->date; ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
    <br>
    <p><a href="index.php">Page de paiement</a></p>
  </div>
</body>
</html>
