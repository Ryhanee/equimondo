<script type="text/javascript">
jQuery(document).ready(function($) {

//************************* AJOUTER UN CHEVAL EN PROPRIETE *********************************
$("#AfficheProfilAvoirAjou").off("submit").submit(function(e) {e.stopPropagation();var str = $(this).serialize();$.ajax({type: "POST",
url: "../profil/modprofilAjouChev.php",data: str,success: function(msg) {if(msg == 'OK') {result = '<div class="notification_ok">Your message has been sent. Thank you!</div>';$("#fields").hide();} else {result = msg;}
$('#AfficheProprietaire').html(result);}});return false;});
//***************************************************************************************

//********************* AJOUTER PHOTO PROFIL **************************************
$( '#FormImportPhotoProfil' ).submit( function( e ) {$.ajax( {
url: '../profil/modImportFichier.php',type: 'POST',data: new FormData( this ),processData: false,contentType: false,success: function(msg) {if(msg == 'OK') {result = '<div class="notification_ok">Your message has been sent. Thank you!</div>';$("#fields").hide();}else {result = msg;}
$('#ProfilPhoto').html(result);}});e.preventDefault();});
//***************************************************************************************

//********************* AJOUTER GROUPE **************************************
$( '#AfficheProfilAjouGroupeForm' ).submit( function( e ) {$.ajax( {
url: '../divers/modgroupProfilAjou_script.php',type: 'POST',data: new FormData( this ),processData: false,contentType: false,success: function(msg) {if(msg == 'OK') {result = '<div class="notification_ok">Your message has been sent. Thank you!</div>';$("#fields").hide();}else {result = msg;}
$('#AfficheGroupe').html(result);}});e.preventDefault();});
//***************************************************************************************

});
</script>
