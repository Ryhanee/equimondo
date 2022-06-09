<?php
  // DB Params
  define("DB_HOST", "localhost");
  define("DB_USER", "root");
  define("DB_PASS", "");
  define("DB_NAME", "stripe");
// Stripe API configuration
define('STRIPE_API_KEY', 'sk_test_VePHdqKTYQjKNInc7u56JBrQ');
define('STRIPE_PUBLISHABLE_KEY', 'pk_test_oKhSR5nslBRnBZpjO6KuzZeX');

$ConnexionBdd = new PDO('mysql:host=localhost;dbname=stripe', 'root', '');
