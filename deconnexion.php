<?php
session_start();

setcookie('equimondo1','',time()+0);
setcookie('equimondo2','',time()+0);
setcookie('equimondo3','',time()+0);

session_destroy();

echo '<SCRIPT LANGUAGE = "javascript"> window.location.replace("connexion.php") </SCRIPT>';
exit;
?>
