<script type="text/javascript">

jQuery(document).ready(function($) {

//************************* CONNEXION EQUIMONDO *********************************
$("#ConnexionEquimondo").off("submit").submit(function(e) {e.stopPropagation();var str = $(this).serialize();$.ajax({type: "POST",
url: "modules/divers/connexion_script.php",data: str,success: function(msg) {if(msg == 'OK') {result = '<div class="notification_ok">Your message has been sent. Thank you!</div>';$("#fields").hide();} else {result = msg;}
$('#noteConnexionEquimondo').html(result);}});return false;});
$("#ConnexionEquimondoCale").off("submit").submit(function(e) {e.stopPropagation();var str = $(this).serialize();$.ajax({type: "POST",
url: "../calendrier/modcalefichcomplet.php",data: str,success: function(msg) {if(msg == 'OK') {result = '<div class="notification_ok">Your message has been sent. Thank you!</div>';$("#fields").hide();} else {result = msg;}
$('#AfficheCaleFichComplet').html(result);}});return false;});
//***************************************************************************************

//***************************** VALIER COMMENTAIRE FACTURES, CLIENTS, CALENDRIER, CHEVAUX **********************************
$("#FormMessageGeneral").off("submit").submit(function(e) {e.stopPropagation();var str = $(this).serialize();$.ajax({type: "POST",
url: "../divers/commentairegeneral_script.php",data: str,success: function(msg) {if(msg == 'OK') {result = '<div class="notification_ok">Your message has been sent. Thank you!</div>';$("#fields").hide();} else {result = msg;}
$('#AfficheCommentairesGenerals').html(result);}});return false;});
//***************************************************************************************

//***************************** VALIER COMMENTAIRE FACTURES, CLIENTS, CALENDRIER, CHEVAUX **********************************
$("#FormGroupAssoAjou").off("submit").submit(function(e) {e.stopPropagation();var str = $(this).serialize();$.ajax({type: "POST",
url: "../divers/modgroupeassoajou_script.php",data: str,success: function(msg) {if(msg == 'OK') {result = '<div class="notification_ok">Your message has been sent. Thank you!</div>';$("#fields").hide();} else {result = msg;}
$('#AfficheGroupeAssociation').html(result);}});return false;});
//***************************************************************************************

//***************************** VALIER COMMENTAIRE FACTURES, CLIENTS, CALENDRIER, CHEVAUX **********************************
$("#FormGroupAjou").off("submit").submit(function(e) {e.stopPropagation();var str = $(this).serialize();$.ajax({type: "POST",
url: "../divers/modgroupajou_script.php",data: str,success: function(msg) {if(msg == 'OK') {result = '<div class="notification_ok">Your message has been sent. Thank you!</div>';$("#fields").hide();} else {result = msg;}
$('#AfficheListe').html(result);}});return false;});
//***************************************************************************************

//***************************** INSCRIPTION RESERVATION EN LIGNE **********************************
$("#FormInscription1").off("submit").submit(function(e) {e.stopPropagation();var str = $(this).serialize();$.ajax({type: "POST",
url: "../divers/modinscription2.php",data: str,success: function(msg) {if(msg == 'OK') {result = '<div class="notification_ok">Your message has been sent. Thank you!</div>';$("#fields").hide();} else {result = msg;}
$('#Inscription2').html(result);}});return false;});

$("#FormInscription2").off("submit").submit(function(e) {e.stopPropagation();var str = $(this).serialize();$.ajax({type: "POST",
url: "../calendrier/modcalefichcomplet.php",data: str,success: function(msg) {if(msg == 'OK') {result = '<div class="notification_ok">Your message has been sent. Thank you!</div>';$("#fields").hide();} else {result = msg;}
$('#AfficheCaleFichComplet').html(result);}});return false;});
//***************************************************************************************

//********************** MOT DE PASSE OUBLIE ******************************
$("#FormMotDePasseOublie").off("submit").submit(function(e) {e.stopPropagation();var str = $(this).serialize();$.ajax({type: "POST",
url: "../divers/motdepasseoublie_script.php",data: str,success: function(msg) {if(msg == 'OK') {result = '<div class="notification_ok">Your message has been sent. Thank you!</div>';$("#fields").hide();} else {result = msg;}
$('#noteMotDePasseOublie').html(result);}});return false;});
//***************************************************************************************

//********************** MOT DE PASSE OUBLIE ******************************
$("#GroupeTelecharger1").off("submit").submit(function(e) {e.stopPropagation();var str = $(this).serialize();$.ajax({type: "GET",
url: "../divers/modgroupetelecharger_script.php",data: str,success: function(msg) {if(msg == 'OK') {result = '<div class="notification_ok">Your message has been sent. Thank you!</div>';$("#fields").hide();} else {result = msg;}
$('#noteGroupeTelecharger1').html(result);}});return false;});
//***************************************************************************************

});

//****************** RECHERCHE CLIENT DEPUIS MENU *************************

//****************************************************************************
</script>
