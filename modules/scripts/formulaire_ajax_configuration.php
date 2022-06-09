<script type="text/javascript">
jQuery(document).ready(function($) {

//***************************** AJOUTER / MODIFIER TYPE PRESTATION CATEGORIE **********************************
$("#FormTypePrestationCatAjou").off("submit").submit(function(e) {e.stopPropagation();var str = $(this).serialize();$.ajax({type: "POST",
url: "../configuration/prestationCat_script.php",data: str,success: function(msg) {if(msg == 'OK') {result = '<div class="notification_ok">Your message has been sent. Thank you!</div>';$("#fields").hide();} else {result = msg;}
$('#AfficheListeTypePrestationCat').html(result);}});return false;});
//***************************************************************************************

//***************************** AJOUTER / MODIFIER PRESTATION **********************************
$("#FormTypePrestationAjou").off("submit").submit(function(e) {e.stopPropagation();var str = $(this).serialize();$.ajax({type: "POST",
url: "../configuration/prestationPrestAjou_script.php",data: str,success: function(msg) {if(msg == 'OK') {result = '<div class="notification_ok">Your message has been sent. Thank you!</div>';$("#fields").hide();} else {result = msg;}
$('#AffichePrestationComplet').html(result);}});return false;});
//***************************************************************************************

//***************************** AJOUTER / MODIFIER PRESTATION **********************************
$("#FormAffichePrestationPrixAjou").off("submit").submit(function(e) {e.stopPropagation();var str = $(this).serialize();$.ajax({type: "POST",
url: "../configuration/prestationPrix.php",data: str,success: function(msg) {if(msg == 'OK') {result = '<div class="notification_ok">Your message has been sent. Thank you!</div>';$("#fields").hide();} else {result = msg;}
$('#AffichePrestationPrix').html(result);}});return false;});
//***************************************************************************************

//***************************** AJOUTER / MODIFIER PRESTATION **********************************
$("#FormVacaScolAjou").off("submit").submit(function(e) {e.stopPropagation();var str = $(this).serialize();$.ajax({type: "POST",
url: "../configuration/vacancescolaire_script.php",data: str,success: function(msg) {if(msg == 'OK') {result = '<div class="notification_ok">Your message has been sent. Thank you!</div>';$("#fields").hide();} else {result = msg;}
$('#AffichePeriodeVacanceScolaire').html(result);}});return false;});
//***************************************************************************************

//***************************** AJOUTER CALENDRIER CATEGORIE TYPEPRESTATION **********************************
$("#FormCaleCateTypePrest").off("submit").submit(function(e) {e.stopPropagation();var str = $(this).serialize();$.ajax({type: "POST",
url: "../configuration/CaleCateTypePrest_script.php",data: str,success: function(msg) {if(msg == 'OK') {result = '<div class="notification_ok">Your message has been sent. Thank you!</div>';$("#fields").hide();} else {result = msg;}
$('#noteAfficheCaleCateTypePrest').html(result);}});return false;});
//***************************************************************************************

//***************************** AJOUTER CALENDRIER CATEGORIE *********************************
$("#FormCaleCate").off("submit").submit(function(e) {e.stopPropagation();var str = $(this).serialize();$.ajax({type: "POST",
url: "../configuration/CaleCate_script.php",data: str,success: function(msg) {if(msg == 'OK') {result = '<div class="notification_ok">Your message has been sent. Thank you!</div>';$("#fields").hide();} else {result = msg;}
$('#noteAfficheCaleCate').html(result);}});return false;});
//***************************************************************************************

//***************************** AJOUTER CALENDRIER NIVEAU *********************************
$("#FormCaleNiveau").off("submit").submit(function(e) {e.stopPropagation();var str = $(this).serialize();$.ajax({type: "POST",
url: "../configuration/CaleNiveau_script.php",data: str,success: function(msg) {if(msg == 'OK') {result = '<div class="notification_ok">Your message has been sent. Thank you!</div>';$("#fields").hide();} else {result = msg;}
$('#noteAfficheCaleNiveau').html(result);}});return false;});
//***************************************************************************************

//***************************** AJOUTER CALENDRIER DISCIPLINE *********************************
$("#FormCaleDiscipline").off("submit").submit(function(e) {e.stopPropagation();var str = $(this).serialize();$.ajax({type: "POST",
url: "../configuration/CaleDiscipline_script.php",data: str,success: function(msg) {if(msg == 'OK') {result = '<div class="notification_ok">Your message has been sent. Thank you!</div>';$("#fields").hide();} else {result = msg;}
$('#noteAfficheCaleDiscipline').html(result);}});return false;});
//***************************************************************************************

});

//****************** MODIFICATION DATE CONFIGURATION ENTREPRISE **************************
function AfficheConfEntrDateCrea1(str) {
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
        xmlhttp.open("GET","../scripts/InputModif.php?confentrdatecrea="+str,true);
        xmlhttp.send();
    }
}
//****************************************************************************

//****************** MODIFICATION DATE CONFIGURATION LOGICIEL **************************
function ModifDateExer1(str) {
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
        xmlhttp.open("GET","../scripts/InputModif.php?conflogdateexercice1="+str,true);
        xmlhttp.send();
    }
}
function ModifDateExer2(str) {
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
        xmlhttp.open("GET","../scripts/InputModif.php?conflogdateexercice2="+str,true);
        xmlhttp.send();
    }
}

function conflogfactprefixe(str) {
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
        xmlhttp.open("GET","../scripts/InputModif.php?conflogfactprefixe="+str,true);
        xmlhttp.send();
    }
}
function conflogcliecotisation(str) {
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
        xmlhttp.open("GET","../scripts/InputModif.php?conflogcliecotisation="+str,true);
        xmlhttp.send();
    }
}
function conflogcaisseafficheprestations(str) {
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
        xmlhttp.open("GET","../scripts/InputModif.php?conflogcaisseafficheprestations="+str,true);
        xmlhttp.send();
    }
}
//****************************************************************************

//************************ AJOUTER UNE LIBELLÉ CATEGORIE PRESTATION *****************************
function CategoriePrestationAjou(str) {
    if (str == "") {
        document.getElementById("noteCategoriePrestationAjou").innerHTML = "";
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
                document.getElementById("noteCategoriePrestationAjou").innerHTML = xmlhttp.responseText;
            }
        }
        xmlhttp.open("GET","../configuration/CategoriePrestationAjou.php?q="+str,true);
        xmlhttp.send();
    }
}
//****************************************************************************

//*********************** AFFICHE TAUX DE TVA *********************************
function AfficheNbTauxTva(str) {
    if (str == "") {
        document.getElementById("noteAfficheNbTva").innerHTML = "";
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
                document.getElementById("noteAfficheNbTva").innerHTML = xmlhttp.responseText;
            }
        }
        xmlhttp.open("GET","../configuration/AfficheNbTauxTva.php?q="+str,true);
        xmlhttp.send();
    }
}
function AfficheNbTauxTvaAjou(str) {
    if (str == "") {
        document.getElementById("noteAfficheNbTvaAjou").innerHTML = "";
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
                document.getElementById("noteAfficheNbTvaAjou").innerHTML = xmlhttp.responseText;
            }
        }
        xmlhttp.open("GET","../configuration/AfficheNbTauxTva.php?q="+str,true);
        xmlhttp.send();
    }
}
//*****************************************************

//*********************** AFFICHE TYPE DE PRESTATION *********************************
function AfficheTypePrestation(str) {
    if (str == "") {
        document.getElementById("noteAfficheTypePrestation").innerHTML = "";
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
                document.getElementById("noteAfficheTypePrestation").innerHTML = xmlhttp.responseText;
            }
        }
        xmlhttp.open("GET","../configuration/AfficheTypePrestation.php?q="+str,true);
        xmlhttp.send();
    }
}
function AfficheTypePrestationModif(str) {
    if (str == "") {
        document.getElementById("noteAfficheTypePrestationModif").innerHTML = "";
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
                document.getElementById("noteAfficheTypePrestationModif").innerHTML = xmlhttp.responseText;
            }
        }
        xmlhttp.open("GET","../configuration/AfficheTypePrestation.php?q="+str,true);
        xmlhttp.send();
    }
}
//*****************************************************************

//*********************** AFFICHE TYPE DE PRESTATION *********************************
function AfficheTypePrestHeureValidite(str) {
    if (str == "") {
        document.getElementById("noteAfficheTypePrestHeureValidite").innerHTML = "";
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
                document.getElementById("noteAfficheTypePrestHeureValidite").innerHTML = xmlhttp.responseText;
            }
        }
        xmlhttp.open("GET","../configuration/AfficheTypePrestHeureValidite.php?q="+str,true);
        xmlhttp.send();
    }
}
function AfficheTypePrestHeureValiditeModif(str) {
    if (str == "") {
        document.getElementById("noteAfficheTypePrestHeureValiditeModif").innerHTML = "";
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
                document.getElementById("noteAfficheTypePrestHeureValiditeModif").innerHTML = xmlhttp.responseText;
            }
        }
        xmlhttp.open("GET","../configuration/AfficheTypePrestHeureValidite.php?q="+str,true);
        xmlhttp.send();
    }
}
//*****************************************************************

//*********************** MODIFICATION CATEGORIE TYPE PRESTATION *********************************
function FormModifTypePrestationCat(str) {
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
        xmlhttp.open("GET","../scripts/InputModif.php?typeprestation_categorie_typeprestcatnum="+str,true);
        xmlhttp.send();
    }
}
function FormModifTypePrestationCat1(str) {
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
        xmlhttp.open("GET","../scripts/InputModif.php?calecatetype="+str,true);
        xmlhttp.send();
    }
}
//*****************************************************************

//*********************** MODIFICATION TAUX TVA PRESTATION PRIX *********************************
function FormModifPrestationTva(str) {
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
        xmlhttp.open("GET","../scripts/InputModif.php?typeprestprixtva="+str,true);
        xmlhttp.send();
    }
}
//*****************************************************************

//*********************** MODIFICATION TYPE PRESTATION VALIDITE, DATE 2, DATE 2 *********************************
function FormTypePrestationValiditeModif(str) {
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
        xmlhttp.open("GET","../scripts/InputModif.php?typeprestvalidite="+str,true);
        xmlhttp.send();
    }
}
function FormTypePrestationValDate1Modif(str) {
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
        xmlhttp.open("GET","../scripts/InputModif.php?typeprestvaldate1="+str,true);
        xmlhttp.send();
    }
}
function FormTypePrestationValDate2Modif(str) {
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
        xmlhttp.open("GET","../scripts/InputModif.php?typeprestvaldate2="+str,true);
        xmlhttp.send();
    }
}
//*****************************************************************

//*************** PASSAGE DATE DEVIS ************************
function conflogdatedevis(str) {
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
        xmlhttp.open("GET","../scripts/InputModif.php?conflogdatedevis="+str,true);
        xmlhttp.send();
    }
}
//*****************************************************************

//*************** GENERE NB FACTURE ************************
function conflogpassagenbfacture(str) {
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
        xmlhttp.open("GET","../scripts/InputModif.php?conflogpassagenbfacture="+str,true);
        xmlhttp.send();
    }
}
//*****************************************************************

//*************** FACT AUTO PAR CLIENT OU PAR CHEVAL ************************
function conflogpassagefactparchevaux(str) {
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
        xmlhttp.open("GET","../scripts/InputModif.php?conflogpassagefactparchevaux="+str,true);
        xmlhttp.send();
    }
}
//*****************************************************************

//********************** AFFICHAGE CONFIGURATION RESERVATION **************************
function ConfSelectPartagePlanning(str) {
    if (str == "") {
        document.getElementById("DivConfSelectPartagePlanning").innerHTML = "";
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
                document.getElementById("DivConfSelectPartagePlanning").innerHTML = xmlhttp.responseText;
            }
        }
        xmlhttp.open("GET","../configuration/ConfSelectPartagePlanning.php?q="+str,true);
        xmlhttp.send();
    }
}
//*****************************************************************

//*************** AUTORISATION ACCES CLIENT EXTERIEUR ************************
function ConfSelectPartagePlanningAccesClientExt(str) {
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
        xmlhttp.open("GET","../scripts/InputModif.php?conflogreservation="+str,true);
        xmlhttp.send();
    }
}
//*****************************************************************

//*************** MODIFICATION TAXE FEDERAL ET PROVINCIALE ************************
function TypePrestationTaxe1(str) {
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
        xmlhttp.open("GET","../scripts/InputModif.php?typeprestprixtaxe1="+str,true);
        xmlhttp.send();
    }
}
function TypePrestationTaxe2(str) {
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
        xmlhttp.open("GET","../scripts/InputModif.php?typeprestprixtaxe2="+str,true);
        xmlhttp.send();
    }
}
//*****************************************************************

//*****************************************************************
function ConfLogicielAccesNiveau(str) {
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
        xmlhttp.open("GET","../scripts/InputModif.php?conflogicielaccesniveau="+str,true);
        xmlhttp.send();
    }
}
//*****************************************************************

//*****************************************************************
function ConfLogicielVisionNbHeureRestant(str) {
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
        xmlhttp.open("GET","../scripts/InputModif.php?conflogvisionheurerestante="+str,true);
        xmlhttp.send();
    }
}
//*****************************************************************

//*****************************************************************
function ConfLogicielCaleUtilAcces(str) {
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
        xmlhttp.open("GET","../scripts/InputModif.php?conflogcaleutilacces="+str,true);
        xmlhttp.send();
    }
}
//*****************************************************************

//*****************************************************************
function conflognumerotationcompteclie(str) {
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
        xmlhttp.open("GET","../scripts/InputModif.php?conflognumerotationcompteclie="+str,true);
        xmlhttp.send();
    }
}
//*****************************************************************

</script>
