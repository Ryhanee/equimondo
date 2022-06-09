<script type="text/javascript">

jQuery(document).ready(function($) {

//***************************** CHERCHER FACTURE **********************************
$("#RechCaleNom").keyup(function(e) {e.stopPropagation();var str = $(this).serialize();$.ajax({type: "GET",
url: "../calendrier/modcalelist1.php",data: str,success: function(msg) {if(msg == 'OK') {result = '<div class="notification_ok">Your message has been sent. Thank you!</div>';$("#fields").hide();} else {result = msg;}
$('#AfficheCalendrier').html(result);}});return false;});
$("#RechCalePrenom").keyup(function(e) {e.stopPropagation();var str = $(this).serialize();$.ajax({type: "GET",
url: "../calendrier/modcalelist1.php",data: str,success: function(msg) {if(msg == 'OK') {result = '<div class="notification_ok">Your message has been sent. Thank you!</div>';$("#fields").hide();} else {result = msg;}
$('#AfficheCalendrier').html(result);}});return false;});
//***************************************************************************

//*************** CALENDRIER AJOUTER ***********************************
$("#FormCaleAjou").off("submit").submit(function(e) {e.stopPropagation();var str = $(this).serialize();$.ajax({type: "POST",
url: "../calendrier/modcaleAjouter_script.php",data: str,success: function(msg) {if(msg == 'OK') {result = '<div class="notification_ok">Your message has been sent. Thank you!</div>';$("#fields").hide();} else {result = msg;}
$('#AfficheCalendrier').html(result);}});return false;});
//***************************************************************************************

//*************** CALENDRIER RECHERCHER ***********************************
$("#CaleRechercher").off("submit").submit(function(e) {e.stopPropagation();var str = $(this).serialize();$.ajax({type: "GET",
url: "../calendrier/modcalelist1.php",data: str,success: function(msg) {if(msg == 'OK') {result = '<div class="notification_ok">Your message has been sent. Thank you!</div>';$("#fields").hide();} else {result = msg;}
$('#AfficheCalendrier').html(result);}});return false;});
//***************************************************************************************

//*************** CALENDRIER CAVALIER AJOUTER ***********************************
$("#FormCaleCavaAjou").off("submit").submit(function(e) {e.stopPropagation();var str = $(this).serialize();$.ajax({type: "POST",
url: "../calendrier/modcalepartajou_script.php",data: str,success: function(msg) {if(msg == 'OK') {result = '<div class="notification_ok">Your message has been sent. Thank you!</div>';$("#fields").hide();} else {result = msg;}
$('#CalePartCava').html(result);}});return false;});
//***************************************************************************************

//*************** MODELE REPRISE AJOUTER ***********************************
$("#FormModeleCavaAjou").off("submit").submit(function(e) {e.stopPropagation();var str = $(this).serialize();$.ajax({type: "POST",
url: "../calendrier/modcaleModeleCavaAjouter_script.php",data: str,success: function(msg) {if(msg == 'OK') {result = '<div class="notification_ok">Your message has been sent. Thank you!</div>';$("#fields").hide();} else {result = msg;}
$('#AfficheModeleClientsAssocie').html(result);}});return false;});
//***************************************************************************************

//*************** MODELE SUPPRIMER CAVALIER ***********************************
$("#FormModeleCavaSupp1").off("submit").submit(function(e) {e.stopPropagation();var str = $(this).serialize();$.ajax({type: "POST",
url: "../calendrier/modcaleModeleFicheComplet1.php",data: str,success: function(msg) {if(msg == 'OK') {result = '<div class="notification_ok">Your message has been sent. Thank you!</div>';$("#fields").hide();} else {result = msg;}
$('#ModeleFicheComplet1').html(result);}});return false;});
$("#FormModeleCavaSupp2").off("submit").submit(function(e) {e.stopPropagation();var str = $(this).serialize();$.ajax({type: "POST",
url: "../calendrier/modcaleModeleFicheComplet2.php",data: str,success: function(msg) {if(msg == 'OK') {result = '<div class="notification_ok">Your message has been sent. Thank you!</div>';$("#fields").hide();} else {result = msg;}
$('#ModeleFicheComplet2').html(result);}});return false;});
//***************************************************************************************

//*************** MODELE SUPPRIMER CAVALIER ***********************************
$("#ModeleCaleAssocie").off("submit").submit(function(e) {e.stopPropagation();var str = $(this).serialize();$.ajax({type: "POST",
url: "../calendrier/modcaleModeleCaleAsso_script.php",data: str,success: function(msg) {if(msg == 'OK') {result = '<div class="notification_ok">Your message has been sent. Thank you!</div>';$("#fields").hide();} else {result = msg;}
$('#AfficheModeleReprisesAssocie').html(result);}});return false;});
//***************************************************************************************

//*************** MODELE REPLIQUER ***********************************
$("#ModeleRepliquer1").off("submit").submit(function(e) {e.stopPropagation();var str = $(this).serialize();$.ajax({type: "POST",
url: "../calendrier/modcaleModeleFicheComplet1.php",data: str,success: function(msg) {if(msg == 'OK') {result = '<div class="notification_ok">Your message has been sent. Thank you!</div>';$("#fields").hide();} else {result = msg;}
$('#ModeleFicheComplet1').html(result);}});return false;});
$("#ModeleRepliquer2").off("submit").submit(function(e) {e.stopPropagation();var str = $(this).serialize();$.ajax({type: "POST",
url: "../calendrier/modcaleModeleFicheComplet2.php",data: str,success: function(msg) {if(msg == 'OK') {result = '<div class="notification_ok">Your message has been sent. Thank you!</div>';$("#fields").hide();} else {result = msg;}
$('#ModeleFicheComplet2').html(result);}});return false;});
//***************************************************************************************

//*************** CALENDRIER POINTAGE ***********************************
$("#FormCalePointage").off("submit").submit(function(e) {e.stopPropagation();var str = $(this).serialize();$.ajax({type: "POST",
url: "../calendrier/modcaledebitevenement_script.php",data: str,success: function(msg) {if(msg == 'OK') {result = '<div class="notification_ok">Your message has been sent. Thank you!</div>';$("#fields").hide();} else {result = msg;}
$('#AfficheCalendrier').html(result);}});return false;});
$("#FormCalePointage1").off("submit").submit(function(e) {e.stopPropagation();var str = $(this).serialize();$.ajax({type: "POST",
url: "../calendrier/modcaledebitevenement_script.php",data: str,success: function(msg) {if(msg == 'OK') {result = '<div class="notification_ok">Your message has been sent. Thank you!</div>';$("#fields").hide();} else {result = msg;}
$('#AfficheFichMontoir').html(result);}});return false;});
//***************************************************************************************

//*************** TYPE PRESTATION ***********************************
$("#FormCaleTypePrestationAjou").off("submit").submit(function(e) {e.stopPropagation();var str = $(this).serialize();$.ajax({type: "POST",
url: "../calendrier/modcaletypeprestationAjou_script.php",data: str,success: function(msg) {if(msg == 'OK') {result = '<div class="notification_ok">Your message has been sent. Thank you!</div>';$("#fields").hide();} else {result = msg;}
$('#AfficheCalendrierTypePrestation').html(result);}});return false;});
//***************************************************************************************

//******************** AJOUTER UN CRENEAU ************************************
$("#FormCaleAjouCreneau").off("submit").submit(function(e) {e.stopPropagation();var str = $(this).serialize();$.ajax({type: "POST",
url: "../calendrier/modcalepartajou_script.php",data: str,success: function(msg) {if(msg == 'OK') {result = '<div class="notification_ok">Your message has been sent. Thank you!</div>';$("#fields").hide();} else {result = msg;}
$('#CalePartCava').html(result);}});return false;});
//*************************************************************

//******************** AJOUTER UN CRENEAU ************************************
$("#FormClieMontoir").off("submit").submit(function(e) {e.stopPropagation();var str = $(this).serialize();$.ajax({type: "POST",
url: "../calendrier/modcaleMontoirCavaAjou_script.php",data: str,success: function(msg) {if(msg == 'OK') {result = '<div class="notification_ok">Your message has been sent. Thank you!</div>';$("#fields").hide();} else {result = msg;}
$('#AfficheFichMontoir').html(result);}});return false;});
//*************************************************************

//******************** NB JOUR MONTOIR ******************************
$("#MontoirNbJour").keyup(function(e) {e.stopPropagation();var str = $(this).serialize();$.ajax({type: "GET",
url: "../calendrier/modcalefichmontoir3.php",data: str,success: function(msg) {if(msg == 'OK') {result = '<div class="notification_ok">Your message has been sent. Thank you!</div>';$("#fields").hide();} else {result = msg;}
$('#AfficheTravailChevauxMontoir').html(result);}});return false;});
//**************************************************************

//*************** CALENDRIER POINTAGE ***********************************
$("#FormModeleRepliquerAjou1").off("submit").submit(function(e) {e.stopPropagation();var str = $(this).serialize();$.ajax({type: "POST",
url: "../calendrier/modcaleModeleFicheComplet1.php",data: str,success: function(msg) {if(msg == 'OK') {result = '<div class="notification_ok">Your message has been sent. Thank you!</div>';$("#fields").hide();} else {result = msg;}
$('#ModeleFicheComplet1').html(result);}});return false;});
$("#FormModeleRepliquerAjou2").off("submit").submit(function(e) {e.stopPropagation();var str = $(this).serialize();$.ajax({type: "POST",
url: "../calendrier/modcaleModeleFicheComplet2.php",data: str,success: function(msg) {if(msg == 'OK') {result = '<div class="notification_ok">Your message has been sent. Thank you!</div>';$("#fields").hide();} else {result = msg;}
$('#ModeleFicheComplet2').html(result);}});return false;});
//***************************************************************************************

//*********************** MODELE AJOUTER DATE D EXCLUSION ********************
$("#FormModeleDateExclusionAjou").off("submit").submit(function(e) {e.stopPropagation();var str = $(this).serialize();$.ajax({type: "POST",
url: "../calendrier/modcaleModeleDateExclusion.php",data: str,success: function(msg) {if(msg == 'OK') {result = '<div class="notification_ok">Your message has been sent. Thank you!</div>';$("#fields").hide();} else {result = msg;}
$('#ModeleDateExclusion').html(result);}});return false;});
//*************************************************************************

//*********************** MODELE AJOUTER DATE D EXCLUSION ********************
$("#FormCaleReservation").off("submit").submit(function(e) {e.stopPropagation();var str = $(this).serialize();$.ajax({type: "POST",
url: "../calendrier/modcalefichcomplet.php",data: str,success: function(msg) {if(msg == 'OK') {result = '<div class="notification_ok">Your message has been sent. Thank you!</div>';$("#fields").hide();} else {result = msg;}
$('#AfficheCaleFichComplet').html(result);}});return false;});
//*************************************************************************

//*********************** REPLIQUER MODELE DE REPRISE ********************
$("#FormCaleModeleRepliquer1").off("submit").submit(function(e) {e.stopPropagation();var str = $(this).serialize();$.ajax({type: "POST",
url: "../calendrier/modmodcalereplication.php",data: str,success: function(msg) {if(msg == 'OK') {result = '<div class="notification_ok">Your message has been sent. Thank you!</div>';$("#fields").hide();} else {result = msg;}
$('#noteCaleModeleRepliquer').html(result);}});return false;});
//*************************************************************************

//*********************** REPLIQUER MODELE DE REPRISE ********************
$("#FormCaleModeleRepliquer2").off("submit").submit(function(e) {e.stopPropagation();var str = $(this).serialize();$.ajax({type: "POST",
url: "../calendrier/modmodcalereplication_script.php",data: str,success: function(msg) {if(msg == 'OK') {result = '<div class="notification_ok">Your message has been sent. Thank you!</div>';$("#fields").hide();} else {result = msg;}
$('#AfficheModele').html(result);}});return false;});
//*************************************************************************

//*********************** REPLIQUER MODELE DE REPRISE ********************
$("#CalejouCavalierDePassage").off("submit").submit(function(e) {e.stopPropagation();var str = $(this).serialize();$.ajax({type: "POST",
url: "../calendrier/modcaleajoucavalierdepassage_script.php",data: str,success: function(msg) {if(msg == 'OK') {result = '<div class="notification_ok">Your message has been sent. Thank you!</div>';$("#fields").hide();} else {result = msg;}
$('#CalePartCava').html(result);}});return false;});
//*************************************************************************

//*********************** REPLIQUER MODELE DE REPRISE ********************
$("#FormCaleConditionAjou").off("submit").submit(function(e) {e.stopPropagation();var str = $(this).serialize();$.ajax({type: "POST",
url: "../calendrier/modcalePrestConditions.php",data: str,success: function(msg) {if(msg == 'OK') {result = '<div class="notification_ok">Your message has been sent. Thank you!</div>';$("#fields").hide();} else {result = msg;}
$('#AfficheCalePrestations').html(result);}});return false;});
//*************************************************************************

//*********************** ACCEPTER UNE RESERVATION EN LIGNE ********************
$("#CaleReservationOk").off("submit").submit(function(e) {e.stopPropagation();var str = $(this).serialize();$.ajax({type: "POST",
url: "../calendrier/modcaleReservationOk_script.php",data: str,success: function(msg) {if(msg == 'OK') {result = '<div class="notification_ok">Your message has been sent. Thank you!</div>';$("#fields").hide();} else {result = msg;}
$('#AfficheCalendrier').html(result);}});return false;});
//*************************************************************************

//*********************** ACCEPTER UNE RESERVATION EN LIGNE ********************
$("#CalePayerCb").off("submit").submit(function(e) {e.stopPropagation();var str = $(this).serialize();$.ajax({type: "POST",
url: "../calendrier/modcalePayerCb_script.php",data: str,success: function(msg) {if(msg == 'OK') {result = '<div class="notification_ok">Your message has been sent. Thank you!</div>';$("#fields").hide();} else {result = msg;}
$('#AfficheCalendrier').html(result);}});return false;});
//*************************************************************************

});


//***************************** CHERCHER FACTURE **********************************
function RechCaleDate(str) {
    if (str == "") {
        document.getElementById("AfficheCalendrier").innerHTML = "";
        return;
    } else {
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                document.getElementById("AfficheCalendrier").innerHTML = xmlhttp.responseText;
            }
        }
        xmlhttp.open("GET","../calendrier/modcalelist1.php?rechcaledate="+str,true);
        xmlhttp.send();
    }
}
//******************************************************************************************

//********************** MODIFICATION DATE MONTOIR *******************************************
function ModifDateMontoir(str) {
    if (str == "") {
        document.getElementById("AfficheFichMontoir").innerHTML = "";
        return;
    } else {
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                document.getElementById("AfficheFichMontoir").innerHTML = xmlhttp.responseText;
            }
        }
        xmlhttp.open("GET","../calendrier/modcalefichmontoir1.php?date="+str,true);
        xmlhttp.send();
    }
}
//**********************************************************************************************

//********************** MODE VUE MONTOIR *******************************************
function MontoirModeVue(str) {
    if (str == "") {
        document.getElementById("AfficheFichMontoir").innerHTML = "";
        return;
    } else {
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                document.getElementById("AfficheFichMontoir").innerHTML = xmlhttp.responseText;
            }
        }
        xmlhttp.open("GET","../calendrier/modcalefichmontoir1.php?modevue="+str,true);
        xmlhttp.send();
    }
}
//**********************************************************************************************

//************************ DECOMPTE HEURE REPRISE ************************
function AfficheNbHeureDecompte(str) {
    if (str == "") {
        document.getElementById("DivAfficheNbHeureDecompte").innerHTML = "";
        return;
    } else {
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                document.getElementById("DivAfficheNbHeureDecompte").innerHTML = xmlhttp.responseText;
            }
        }
        xmlhttp.open("GET","../calendrier/AfficheNbHeureDecompte.php?caletext9="+str,true);
        xmlhttp.send();
    }
}
//************************************************

//************************ CALENDRIER CATEGORIE ************************
function AfficheCaleCate(str) {
    if (str == "") {
        document.getElementById("DivAfficheCaleCate").innerHTML = "";
        return;
    } else {
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                document.getElementById("DivAfficheCaleCate").innerHTML = xmlhttp.responseText;
            }
        }
        xmlhttp.open("GET","../calendrier/AfficheCaleCate.php?calecatenum="+str,true);
        xmlhttp.send();
    }
}
//************************************************

//************************ CALENDRIER CATEGORIE ************************
function AfficheModeleCaleCate(str) {
    if (str == "") {
        document.getElementById("DivAfficheCaleCate").innerHTML = "";
        return;
    } else {
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                document.getElementById("DivAfficheCaleCate").innerHTML = xmlhttp.responseText;
            }
        }
        xmlhttp.open("GET","../calendrier/AfficheModeleCaleCate.php?calecatenum="+str,true);
        xmlhttp.send();
    }
}
//************************************************

//************************ MODIFICATION CALENDRIER CATEGORIE ************************
function AfficheCaleCateModif(str) {
    if (str == "") {
        document.getElementById("noteInputModif").innerHTML = "";
        return;
    } else {
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                document.getElementById("noteInputModif").innerHTML = xmlhttp.responseText;
            }
        }
        xmlhttp.open("GET","../scripts/InputModif.php?calecatenum="+str,true);
        xmlhttp.send();
    }
}
//************************************************


//************************ DECOMPTE HEURE REPRISE ************************
function AfficheCaleType(str) {
    if (str == "") {
        document.getElementById("DivAfficheCaleType").innerHTML = "";
        return;
    } else {
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                document.getElementById("DivAfficheCaleType").innerHTML = xmlhttp.responseText;
            }
        }
        xmlhttp.open("GET","../calendrier/AfficheCaleType.php?calecatetype="+str,true);
        xmlhttp.send();
    }
}
//************************************************

//************** SELECTIONNER INSTALLATION **************
function InstallationAjouSelect(str) {
    if (str == "") {
        document.getElementById("DivInstallationAjouSelect").innerHTML = "";
        return;
    } else {
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                document.getElementById("DivInstallationAjouSelect").innerHTML = xmlhttp.responseText;
            }
        }
        xmlhttp.open("GET","../calendrier/InstallationAjouSelect.php?q="+str,true);
        xmlhttp.send();
    }
}
//************************************************

//************** SELECTIONNER INSTALLATION **************
function DisciplineAjouSelect(str) {
    if (str == "") {
        document.getElementById("DivDisciplineAjouSelect").innerHTML = "";
        return;
    } else {
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                document.getElementById("DivDisciplineAjouSelect").innerHTML = xmlhttp.responseText;
            }
        }
        xmlhttp.open("GET","../calendrier/DisciplineAjouSelect.php?q="+str,true);
        xmlhttp.send();
    }
}
//************************************************

//************** SELECTIONNER DISCIPLINE **************
function DisciplineCaleFichAjouSelect(str) {
    if (str == "") {
        document.getElementById("AfficheCalendrierDiscipline").innerHTML = "";
        return;
    } else {
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                document.getElementById("AfficheCalendrierDiscipline").innerHTML = xmlhttp.responseText;
            }
        }
        xmlhttp.open("GET","../calendrier/DisciplineCaleAjou.php?calediscconfnum="+str,true);
        xmlhttp.send();
    }
}
//************************************************

//************** SELECTIONNER INSTALLATION **************
function AfficheNiveau(str) {
    if (str == "") {
        document.getElementById("DivAfficheNiveau").innerHTML = "";
        return;
    } else {
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                document.getElementById("DivAfficheNiveau").innerHTML = xmlhttp.responseText;
            }
        }
        xmlhttp.open("GET","../calendrier/AfficheNiveau.php?q="+str,true);
        xmlhttp.send();
    }
}
//************************************************

//************** SELECTIONNER INSTALLATION **************
function NiveauCaleFichAjouSelect(str) {
    if (str == "") {
        document.getElementById("AfficheCalendrierNiveau").innerHTML = "";
        return;
    } else {
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                document.getElementById("AfficheCalendrierNiveau").innerHTML = xmlhttp.responseText;
            }
        }
        xmlhttp.open("GET","../calendrier/AfficheNiveauAjou.php?caleniveconfnum="+str,true);
        xmlhttp.send();
    }
}
//************************************************

//************** SELECTIONNER MONITEUR **************
function AfficheCaleModifUtil(str) {
    if (str == "") {
        document.getElementById("noteInputModif").innerHTML = "";
        return;
    } else {
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                document.getElementById("noteInputModif").innerHTML = xmlhttp.responseText;
            }
        }
        xmlhttp.open("GET","../scripts/InputModif.php?caleutilnum="+str,true);
        xmlhttp.send();
    }
}
//************************************************

//************** SELECTIONNER NB PERSONNE MAXIMUM **************
function AfficheCaleModifCaletext7(str) {
    if (str == "") {
        document.getElementById("noteInputModif").innerHTML = "";
        return;
    } else {
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                document.getElementById("noteInputModif").innerHTML = xmlhttp.responseText;
            }
        }
        xmlhttp.open("GET","../scripts/InputModif.php?caletext7="+str,true);
        xmlhttp.send();
    }
}
//************************************************

//************** SELECTION MODIF CALENDRIER **************
function InstallationAjouSelectModif(str) {
    if (str == "") {
        document.getElementById("noteInputModif").innerHTML = "";
        return;
    } else {
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                document.getElementById("noteInputModif").innerHTML = xmlhttp.responseText;
            }
        }
        xmlhttp.open("GET","../scripts/InputModif.php?caletext8="+str,true);
        xmlhttp.send();
    }
}
//************************************************

//************** MODELE DE REPRISE MODIF JOUR **************
function ModeleJour(str) {
    if (str == "") {
        document.getElementById("noteInputModif").innerHTML = "";
        return;
    } else {
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                document.getElementById("noteInputModif").innerHTML = xmlhttp.responseText;
            }
        }
        xmlhttp.open("GET","../scripts/InputModif.php?planlecomodjour="+str,true);
        xmlhttp.send();
    }
}
//************************************************

//************** MODELE DE REPRISE MODIF MOD REPLICATION **************
function ModeleModRepliquer(str) {
    if (str == "") {
        document.getElementById("noteInputModif").innerHTML = "";
        return;
    } else {
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                document.getElementById("noteInputModif").innerHTML = xmlhttp.responseText;
            }
        }
        xmlhttp.open("GET","../scripts/InputModif.php?planlecomodrepliquer="+str,true);
        xmlhttp.send();
    }
}
//************************************************

//************** MODELE DE REPRISE MODIF DUREE **************
function ModeleDuree(str) {
    if (str == "") {
        document.getElementById("noteInputModif").innerHTML = "";
        return;
    } else {
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                document.getElementById("noteInputModif").innerHTML = xmlhttp.responseText;
            }
        }
        xmlhttp.open("GET","../scripts/InputModif.php?planlecomodduree="+str,true);
        xmlhttp.send();
    }
}
//************************************************

//************** MODELE DE REPRISE MODIF DUREE A DEBITER **************
function ModeleDureeADebiter(str) {
    if (str == "") {
        document.getElementById("noteInputModif").innerHTML = "";
        return;
    } else {
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                document.getElementById("noteInputModif").innerHTML = xmlhttp.responseText;
            }
        }
        xmlhttp.open("GET","../scripts/InputModif.php?planlecomoddureeabebiter="+str,true);
        xmlhttp.send();
    }
}
//************************************************

//************** MODELE DE REPRISE MODIF DISCIPLINE **************
function ModeleDiscipline(str) {
    if (str == "") {
        document.getElementById("noteInputModif").innerHTML = "";
        return;
    } else {
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                document.getElementById("noteInputModif").innerHTML = xmlhttp.responseText;
            }
        }
        xmlhttp.open("GET","../scripts/InputModif.php?planlecomodcategorie="+str,true);
        xmlhttp.send();
    }
}
//************************************************

//************** MODELE DE REPRISE MODIF UTILISATEURS **************
function ModeleUtilisateurs(str) {
    if (str == "") {
        document.getElementById("noteInputModif").innerHTML = "";
        return;
    } else {
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                document.getElementById("noteInputModif").innerHTML = xmlhttp.responseText;
            }
        }
        xmlhttp.open("GET","../scripts/InputModif.php?modeleutilnum="+str,true);
        xmlhttp.send();
    }
}
//************************************************

//************** MODELE DE REPRISE MODIF UTILISATEURS **************
function ModeleNiveau1(str) {
    if (str == "") {
        document.getElementById("noteInputModif").innerHTML = "";
        return;
    } else {
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                document.getElementById("noteInputModif").innerHTML = xmlhttp.responseText;
            }
        }
        xmlhttp.open("GET","../scripts/InputModif.php?planlecomodniveau1="+str,true);
        xmlhttp.send();
    }
}
//************************************************
//************** MODELE DE REPRISE MODIF NIVEAU 1 **************
function ModeleNiveau2(str) {
    if (str == "") {
        document.getElementById("noteInputModif").innerHTML = "";
        return;
    } else {
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                document.getElementById("noteInputModif").innerHTML = xmlhttp.responseText;
            }
        }
        xmlhttp.open("GET","../scripts/InputModif.php?planlecomodniveau2="+str,true);
        xmlhttp.send();
    }
}
//************************************************

//************** MODELE DE REPRISE MODIF NIVEAU 1 **************
function ModeleNiveau12(str) {
    if (str == "") {
        document.getElementById("noteInputModif").innerHTML = "";
        return;
    } else {
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                document.getElementById("noteInputModif").innerHTML = xmlhttp.responseText;
            }
        }
        xmlhttp.open("GET","../scripts/InputModif.php?planlecomodniveau2="+str,true);
        xmlhttp.send();
    }
}
//************************************************

//************** MODELE DE REPRISE MODIF NB MAX PERS **************
function ModeleNbMaxPers(str) {
    if (str == "") {
        document.getElementById("noteInputModif").innerHTML = "";
        return;
    } else {
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                document.getElementById("noteInputModif").innerHTML = xmlhttp.responseText;
            }
        }
        xmlhttp.open("GET","../scripts/InputModif.php?planlecomodnbmaxpers="+str,true);
        xmlhttp.send();
    }
}
//************************************************

//************** MODELE DE REPRISE MODIF NB MAX PERS **************
function ModeleInstal(str) {
    if (str == "") {
        document.getElementById("noteInputModif").innerHTML = "";
        return;
    } else {
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                document.getElementById("noteInputModif").innerHTML = xmlhttp.responseText;
            }
        }
        xmlhttp.open("GET","../scripts/InputModif.php?planlecomodinstal="+str,true);
        xmlhttp.send();
    }
}
//************************************************

//************** MODELE DE REPRISE MODIF HRS PERIODE **************
function ModeleHorsPeriode(str) {
    if (str == "") {
        document.getElementById("noteInputModif").innerHTML = "";
        return;
    } else {
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                document.getElementById("noteInputModif").innerHTML = xmlhttp.responseText;
            }
        }
        xmlhttp.open("GET","../scripts/InputModif.php?planlecomodhorsperiode="+str,true);
        xmlhttp.send();
    }
}
//************************************************

//************** MODELE DE REPRISE MODIF CALETEXT1 **************
function AfficheCaleModifCaletext1(str) {
    if (str == "") {
        document.getElementById("noteInputModif").innerHTML = "";
        return;
    } else {
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                document.getElementById("noteInputModif").innerHTML = xmlhttp.responseText;
            }
        }
        xmlhttp.open("GET","../scripts/InputModif.php?caletext1="+str,true);
        xmlhttp.send();
    }
}
//************************************************

//************** MODELE DE REPRISE MODIF CALETEXT9 **************
function AfficheCaleModifCaletext9(str) {
    if (str == "") {
        document.getElementById("noteInputModif").innerHTML = "";
        return;
    } else {
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                document.getElementById("noteInputModif").innerHTML = xmlhttp.responseText;
            }
        }
        xmlhttp.open("GET","../scripts/InputModif.php?caletext9="+str,true);
        xmlhttp.send();
    }
}
//************************************************

//************** MODELE DE REPRISE MODIF CALEDATE1 **************
function AfficheCaleModifCaledate1(str) {
    if (str == "") {
        document.getElementById("noteInputModif").innerHTML = "";
        return;
    } else {
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                document.getElementById("noteInputModif").innerHTML = xmlhttp.responseText;
            }
        }
        xmlhttp.open("GET","../scripts/InputModif.php?caledate1="+str,true);
        xmlhttp.send();
    }
}
//************************************************


//*************** MODIFICATION MODELE CALENDRIER CATEGORIE ******************
function ModeleModifCateCaleNum(str) {
    if (str == "") {
        document.getElementById("noteInputModif").innerHTML = "";
        return;
    } else {
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                document.getElementById("noteInputModif").innerHTML = xmlhttp.responseText;
            }
        }
        xmlhttp.open("GET","../scripts/InputModif.php?modelecalecatenum="+str,true);
        xmlhttp.send();
    }
}
//************************************************

//*************** AFFICHER % POUR LA RÉSERVATION EN LIGNE ******************
function AffichePourcReservation(str) {
    if (str == "") {
        document.getElementById("noteAffichePourcReservation").innerHTML = "";
        return;
    } else {
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                document.getElementById("noteAffichePourcReservation").innerHTML = xmlhttp.responseText;
            }
        }
        xmlhttp.open("GET","../calendrier/AffichePourcReservation.php?caletext15="+str,true);
        xmlhttp.send();
    }
}
//************************************************


//******************** EST CE QU'ILS VEULENT UN PAIEMENT PAR CB ****************************
function AffichePaiementCB(str) {
    if (str == "") {
        document.getElementById("noteAffichePaiementCB").innerHTML = "";
        return;
    } else {
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                document.getElementById("noteAffichePaiementCB").innerHTML = xmlhttp.responseText;
            }
        }
        xmlhttp.open("GET","../calendrier/AfficheDemandePaiementCB.php?caletext15="+str,true);
        xmlhttp.send();
    }
}
//************************************************

//****************** EST CE QU'ILS VEULENT SOUSCRIRE A STRIPE ******************************
function AffichePourcPaiementCB(str) {
    if (str == "") {
        document.getElementById("noteAffichePourcPaiementCB").innerHTML = "";
        return;
    } else {
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                document.getElementById("noteAffichePourcPaiementCB").innerHTML = xmlhttp.responseText;
            }
        }
        xmlhttp.open("GET","../calendrier/AffichePourcPaiementCB.php?caletext15="+str,true);
        xmlhttp.send();
    }
}
//************************************************

//****************** VEULENT ILS CREER UN ENCAISSEMENT ******************************
function AfficheCreerEncaissement(str) {
    if (str == "") {
        document.getElementById("noteAfficheCreerEncaissement").innerHTML = "";
        return;
    } else {
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                document.getElementById("noteAfficheCreerEncaissement").innerHTML = xmlhttp.responseText;
            }
        }
        xmlhttp.open("GET","../calendrier/AfficheCreerEncaissement.php?caletext15="+str,true);
        xmlhttp.send();
    }
}
//************************************************

//****************** MODIF RESERVATION CREATION FACTURE ******************************
function Caletext14(str) {
    if (str == "") {
        document.getElementById("noteInputModif").innerHTML = "";
        return;
    } else {
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                document.getElementById("noteInputModif").innerHTML = xmlhttp.responseText;
            }
        }
        xmlhttp.open("GET","../scripts/InputModif.php?caletext14="+str,true);
        xmlhttp.send();
    }
}
//************************************************

//****************** MODIF RESERVATION CREATION ENCAISSEMENT ******************************
function Caletext15(str) {
    if (str == "") {
        document.getElementById("noteInputModif").innerHTML = "";
        return;
    } else {
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                document.getElementById("noteInputModif").innerHTML = xmlhttp.responseText;
            }
        }
        xmlhttp.open("GET","../scripts/InputModif.php?caletext15="+str,true);
        xmlhttp.send();
    }
}
//************************************************

</script>
