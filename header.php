<?php

session_start();
include $Dossier . "modules/divers/connexionbdd.php";

//if(empty($_SESSION['infologlang1'])) {$_SESSION['infologlang1'] = "fr";}
//if(empty($_SESSION['infologlang2'])) {$_SESSION['infologlang2'] = "fr";}



$_SESSION['URL_ACTUELLE2'] = substr($_SERVER['REQUEST_URI'], 0, 99);

include $Dossier . "modules/function/allfunction.php";
include $Dossier . "modules/function/allfunction_documents.php";
include $Dossier . "modules/function/allfunction_clients.php";
include $Dossier . "modules/function/allfunction_requete.php";
include $Dossier . "modules/function/allfunction_divers.php";
include $Dossier . "modules/function/allfunction_configuration.php";
include $Dossier . "modules/divers/informations.php";
include $Dossier . "modules/traduction/langCompl_" . $_SESSION['infologlang2'] . ".php";
include $Dossier . "modules/traduction/lang_" . $_SESSION['infologlang1'] . ".php";

if (!empty($_SESSION['authconnauthnum']))
  {
    include $Dossier . "modules/function/allfunction_facturation.php";
    include $Dossier . "modules/function/allfunction_calendrier.php";
    include $Dossier . "modules/function/allfunction_chevaux.php";
    include $Dossier . "modules/function/allfunction_gestion_equimondo.php";
  }

if (!empty($_GET['AuthWidthLargeur']))
  {
    $_SESSION['ResolutionConnexion1'] = $_GET['AuthWidthLargeur'];
  }
if (!empty($_GET['AuthHeightHauteur']))
  {
    $_SESSION['ResolutionConnexion2'] = $_GET['AuthHeightHauteur'];
  }
?>
<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
    <title>Connexion Equimondo</title>
    <meta name="description" content="Connexion Equimondo"/>
    <meta charset='iso-8859-1'>
    <!-- Favicon Tags Start -->
    <link rel="apple-touch-icon-precomposed" sizes="57x57"
          href="<?php echo $Dossier; ?>img/favicon/apple-touch-icon-57x57.png"/>
    <link rel="apple-touch-icon-precomposed" sizes="114x114"
          href="<?php echo $Dossier; ?>img/favicon/apple-touch-icon-114x114.png"/>
    <link rel="apple-touch-icon-precomposed" sizes="72x72"
          href="<?php echo $Dossier; ?>img/favicon/apple-touch-icon-72x72.png"/>
    <link rel="apple-touch-icon-precomposed" sizes="144x144"
          href="<?php echo $Dossier; ?>img/favicon/apple-touch-icon-144x144.png"/>
    <link rel="apple-touch-icon-precomposed" sizes="60x60"
          href="<?php echo $Dossier; ?>img/favicon/apple-touch-icon-60x60.png"/>
    <link rel="apple-touch-icon-precomposed" sizes="120x120"
          href="<?php echo $Dossier; ?>img/favicon/apple-touch-icon-120x120.png"/>
    <link rel="apple-touch-icon-precomposed" sizes="76x76"
          href="<?php echo $Dossier; ?>img/favicon/apple-touch-icon-76x76.png"/>
    <link rel="apple-touch-icon-precomposed" sizes="152x152"
          href="<?php echo $Dossier; ?>img/favicon/apple-touch-icon-152x152.png"/>
    <link rel="icon" type="image/png" href="<?php echo $Dossier; ?>img/favicon/favicon-196x196.png" sizes="196x196"/>
    <link rel="icon" type="image/png" href="<?php echo $Dossier; ?>img/favicon/favicon-96x96.png" sizes="96x96"/>
    <link rel="icon" type="image/png" href="<?php echo $Dossier; ?>img/favicon/favicon-32x32.png" sizes="32x32"/>
    <link rel="icon" type="image/png" href="<?php echo $Dossier; ?>img/favicon/favicon-16x16.png" sizes="16x16"/>
    <link rel="icon" type="image/png" href="<?php echo $Dossier; ?>img/favicon/favicon-128.png" sizes="128x128"/>
    <meta name="application-name" content="&nbsp;"/>
    <meta name="msapplication-TileColor" content="#FFFFFF"/>
    <meta name="msapplication-TileImage" content="<?php echo $Dossier; ?>img/favicon/mstile-144x144.png"/>
    <meta name="msapplication-square70x70logo" content="<?php echo $Dossier; ?>img/favicon/mstile-70x70.png"/>
    <meta name="msapplication-square150x150logo" content="<?php echo $Dossier; ?>img/favicon/mstile-150x150.png"/>
    <meta name="msapplication-wide310x150logo" content="<?php echo $Dossier; ?>img/favicon/mstile-310x150.png"/>
    <meta name="msapplication-square310x310logo" content="<?php echo $Dossier; ?>img/favicon/mstile-310x310.png"/>

    <!-- ********** FICHIER CSS *********** -->
    <link rel="preconnect" href="https://fonts.gstatic.com"/>
    <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@300;400;700&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;700&display=swap" rel="stylesheet"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.0/font/bootstrap-icons.css"/>
    <link rel="stylesheet" href="<?php echo $Dossier; ?>font/CS-Interface/style.css"/>
    <link rel="stylesheet" href="<?php echo $Dossier; ?>css/vendor/bootstrap.min.css"/>
    <link rel="stylesheet" href="<?php echo $Dossier; ?>css/vendor/OverlayScrollbars.min.css"/>
    <link rel="stylesheet" href="<?php echo $Dossier; ?>css/vendor/fullcalendar.min.css"/>
    <link rel="stylesheet" href="<?php echo $Dossier; ?>css/vendor/bootstrap-datepicker3.standalone.min.css"/>
    <link rel="stylesheet" href="<?php echo $Dossier; ?>css/vendor/tagify.css"/>
    <link rel="stylesheet" href="<?php echo $Dossier; ?>css/vendor/quill.bubble.css"/>
    <link rel="stylesheet" href="<?php echo $Dossier; ?>css/vendor/baguetteBox.min.css"/>
    <link rel="stylesheet" href="<?php echo $Dossier; ?>css/vendor/select2-bootstrap4.min.css" />
    <link rel="stylesheet" href="<?php echo $Dossier; ?>css/vendor/select2.min.css" />
    <link rel="stylesheet" href="<?php echo $Dossier; ?>css/styles.css"/>
    <link rel="stylesheet" href="<?php echo $Dossier; ?>css/main.css"/>
    <link rel="stylesheet" href="<?php echo $Dossier; ?>css/vendor/datatables.min.css" />
    <link rel="stylesheet" href="<?php echo $Dossier; ?>css/vendor/quill.bubble.css" />
    <link rel="stylesheet" href="<?php echo $Dossier; ?>css/vendor/quill.snow.css" />
    <link rel="stylesheet" href="css/vendor/select2.min.css" />

    <link rel="stylesheet" href="css/vendor/select2-bootstrap4.min.css" />

    <link rel="stylesheet" href="css/vendor/bootstrap-datepicker3.standalone.min.css" />
    <meta name="description" content="A modern rich text editor built for compatibility and extensibility." />

    <meta name="application-name" content="&nbsp;" />

    <!-- Favicon Tags End -->
    <!-- Font Tags Start -->
    <link rel="preconnect" href="https://fonts.gstatic.com" />
    <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@300;400;700&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="font/CS-Interface/style.css" />
    <?php
    echo '<style>
    @import url("'.$Dossier.'css/style_400px.css") screen and (min-device-width: 0px) and (max-width: 400px);
    @import url("'.$Dossier.'css/style_800px.css") screen and (min-device-width: 401px) and (max-width: 800px);
    @import url("'.$Dossier.'css/style_1024px.css") screen and (min-device-width: 801px) and (max-width: 1024px);
    @import url("'.$Dossier.'css/style_1300px.css") screen and (min-device-width: 1025px);
    </style>';
    ?>
    <!-- ************************************ -->

    <!-- ********** FICHIER JS *********** -->
    <script src="<?php echo $Dossier; ?>js/base/loader.js"></script>
    <script src="<?php echo $Dossier; ?>js/vendor/jquery-3.5.1.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="<?php echo $Dossier; ?>js/divers.js"></script>
    <?php
    include $Dossier."modules/scripts/formulaire_ajax_divers.php";
    include $Dossier."modules/scripts/formulaire_ajax_clients.php";
    include $Dossier."modules/scripts/formulaire_ajax_boucle.php";
    if(!empty($_SESSION['authconnauthnum']))
      {
        include $Dossier."modules/scripts/formulaire_ajax_chevaux.php";
        include $Dossier."modules/scripts/formulaire_ajax_facturation.php";
        include $Dossier."modules/scripts/formulaire_ajax_calendrier.php";
        include $Dossier."modules/scripts/formulaire_ajax_configuration.php";
        include $Dossier."modules/scripts/formulaire_ajax_profil.php";
      }
    ?>
    <!-- ************************************ -->

</head>

<body>

<?php
if($_GET['Impression'] != 2)
  {
    include $Dossier . "modules/divers/menu.php";
  }
  ini_set('display_errors',0);
  error_reporting(E_ALL ^ E_NOTICE);  

?>
