<?php
session_start();

if(!empty($_SESSION['equimondo1'])) {setcookie('equimondo1',$_SESSION['equimondo1'],time()+3600*24*31*360, null, null, false, true);}
if(!empty($_SESSION['equimondo2'])) {setcookie('equimondo2',$_SESSION['equimondo2'],time()+3600*24*31*360, null, null, false, true);}
if(!empty($_SESSION['equimondo3'])) {setcookie('equimondo3',$_SESSION['equimondo3'],time()+3600*24*31*360, null, null, false, true);}
if(!empty($_SESSION['equimondo4'])) {setcookie('equimondo4',$_SESSION['equimondo4'],time()+3600*24*31*360, null, null, false, true);}

//************************** RESOLUTION ECRAN **************************************
if(!empty($_GET['AuthWidthLargeur'])) {$_SESSION['ResolutionConnexion1'] = $_GET['AuthWidthLargeur'];}
if(!empty($_GET['AuthHeightHauteur'])) {$_SESSION['ResolutionConnexion2'] = $_GET['AuthHeightHauteur'];}

if(!empty($_SESSION['inscription'])) {echo '<SCRIPT LANGUAGE = "javascript"> window.location.replace("inscription.php") </SCRIPT>';}
else if(!empty($_SESSION['television'])) {echo '<SCRIPT LANGUAGE = "javascript"> window.location.replace("television.php") </SCRIPT>';}
else {echo '<SCRIPT LANGUAGE = "javascript"> window.location.replace("index.php") </SCRIPT>';}
?>
