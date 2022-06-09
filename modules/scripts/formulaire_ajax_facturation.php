<script type="text/javascript">

jQuery(document).ready(function($) {

//***************************** RECHERCHE FACTURE **********************************
$("#FactureRecherche1").off("submit").submit(function(e) {e.stopPropagation();var str = $(this).serialize();$.ajax({type: "GET",
url: "../facturation/modfactlist1.php",data: str,success: function(msg) {if(msg == 'OK') {result = '<div class="notification_ok">Your message has been sent. Thank you!</div>';$("#fields").hide();} else {result = msg;}
$('#AfficheListeFacture').html(result);}});return false;});
//***************************************************************************************

//***************************** RECHERCHE FACTURE PRELEVEMENT **********************************
$("#FactureRecherchePrelevement1").off("submit").submit(function(e) {e.stopPropagation();var str = $(this).serialize();$.ajax({type: "GET",
url: "../facturation/modprelevementlist1.php",data: str,success: function(msg) {if(msg == 'OK') {result = '<div class="notification_ok">Your message has been sent. Thank you!</div>';$("#fields").hide();} else {result = msg;}
$('#AfficheListeFacture').html(result);}});return false;});
//***************************************************************************************

//***************************** TELECHARGER FACTURE PRELEVEMENT **********************************
$("#FactureTelechargerPrelevement1").off("submit").submit(function(e) {e.stopPropagation();var str = $(this).serialize();$.ajax({type: "POST",
url: "../facturation/modprelevementTelecharger.php",data: str,success: function(msg) {if(msg == 'OK') {result = '<div class="notification_ok">Your message has been sent. Thank you!</div>';$("#fields").hide();} else {result = msg;}
$('#AffichePrelFacture').html(result);}});return false;});
//***************************************************************************************

//***************************** DUPLIQUER **********************************
$("#FactureDupliquer").off("submit").submit(function(e) {e.stopPropagation();var str = $(this).serialize();$.ajax({type: "POST",
url: "../facturation/modfactDupliquer_script.php",data: str,success: function(msg) {if(msg == 'OK') {result = '<div class="notification_ok">Your message has been sent. Thank you!</div>';$("#fields").hide();} else {result = msg;}
$('#AfficheListeFacture').html(result);}});return false;});
//***************************************************************************************

//***************************** CREER UN AVOIR **********************************
$("#FactureCreerAvoir1").off("submit").submit(function(e) {e.stopPropagation();var str = $(this).serialize();$.ajax({type: "POST",
url: "../facturation/modfactCreerAvoir_script.php",data: str,success: function(msg) {if(msg == 'OK') {result = '<div class="notification_ok">Your message has been sent. Thank you!</div>';$("#fields").hide();} else {result = msg;}
$('#AfficheFicheFacture1').html(result);}});return false;});
$("#FactureCreerAvoir2").off("submit").submit(function(e) {e.stopPropagation();var str = $(this).serialize();$.ajax({type: "POST",
url: "../facturation/modfactCreerAvoir_script.php",data: str,success: function(msg) {if(msg == 'OK') {result = '<div class="notification_ok">Your message has been sent. Thank you!</div>';$("#fields").hide();} else {result = msg;}
$('#AfficheFicheFacture2').html(result);}});return false;});
//***************************************************************************************

//***************************** CREER UN AVOIR **********************************
$("#FactPrestAjou1").off("submit").submit(function(e) {e.stopPropagation();var str = $(this).serialize();$.ajax({type: "POST",
url: "../facturation/modfactPrestationAjou_script.php",data: str,success: function(msg) {if(msg == 'OK') {result = '<div class="notification_ok">Your message has been sent. Thank you!</div>';$("#fields").hide();} else {result = msg;}
$('#AfficheFicheFacture1').html(result);}});return false;});
$("#FactPrestAjou2").off("submit").submit(function(e) {e.stopPropagation();var str = $(this).serialize();$.ajax({type: "POST",
url: "../facturation/modfactPrestationAjou_script.php",data: str,success: function(msg) {if(msg == 'OK') {result = '<div class="notification_ok">Your message has been sent. Thank you!</div>';$("#fields").hide();} else {result = msg;}
$('#AfficheFicheFacture2').html(result);}});return false;});

//***************************************************************************************

//***************************** AJOUTER UNE FACTURE **********************************
$("#FormFactAjou").off("submit").submit(function(e) {e.stopPropagation();var str = $(this).serialize();$.ajax({type: "POST",
url: "../facturation/modfactAjouter_script.php",data: str,success: function(msg) {if(msg == 'OK') {result = '<div class="notification_ok">Your message has been sent. Thank you!</div>';$("#fields").hide();} else {result = msg;}
$('#AfficheListeFacture').html(result);}});return false;});
$("#FormFactAjouClie1").off("submit").submit(function(e) {e.stopPropagation();var str = $(this).serialize();$.ajax({type: "POST",
url: "../facturation/modfactAjouter_script.php",data: str,success: function(msg) {if(msg == 'OK') {result = '<div class="notification_ok">Your message has been sent. Thank you!</div>';$("#fields").hide();} else {result = msg;}
$('#AfficheFicheProfil1').html(result);}});return false;});
$("#FormFactAjouClie2").off("submit").submit(function(e) {e.stopPropagation();var str = $(this).serialize();$.ajax({type: "POST",
url: "../facturation/modfactAjouter_script.php",data: str,success: function(msg) {if(msg == 'OK') {result = '<div class="notification_ok">Your message has been sent. Thank you!</div>';$("#fields").hide();} else {result = msg;}
$('#AfficheFicheProfil2').html(result);}});return false;});
$("#FormFactAjouGrouper").off("submit").submit(function(e) {e.stopPropagation();var str = $(this).serialize();$.ajax({type: "POST",
url: "../facturation/modfactAjouter_script.php",data: str,success: function(msg) {if(msg == 'OK') {result = '<div class="notification_ok">Your message has been sent. Thank you!</div>';$("#fields").hide();} else {result = msg;}
$('#AfficheFactureGrouper').html(result);}});return false;});


//***************************************************************************************

//***************************** AJOUTER UNE FACTURE **********************************
$("#FormFactAutoAjou").off("submit").submit(function(e) {e.stopPropagation();var str = $(this).serialize();$.ajax({type: "POST",
url: "../facturation/modfactautoAjouter_script.php",data: str,success: function(msg) {if(msg == 'OK') {result = '<div class="notification_ok">Your message has been sent. Thank you!</div>';$("#fields").hide();} else {result = msg;}
$('#AfficheListeFacture').html(result);}});return false;});
//***************************************************************************************

//***************************** AJOUTER UN ENCAISSEMENT **********************************
$("#FormFactEncAjou1").off("submit").submit(function(e) {e.stopPropagation();var str = $(this).serialize();$.ajax({type: "POST",
url: "../facturation/modfactEncAjouter_script.php",data: str,success: function(msg) {if(msg == 'OK') {result = '<div class="notification_ok">Your message has been sent. Thank you!</div>';$("#fields").hide();}else {result = msg;}
$('#AfficheFicheFacture1').html(result);}});return false;});
$("#FormFactEncAjou2").off("submit").submit(function(e) {e.stopPropagation();var str = $(this).serialize();$.ajax({type: "POST",
url: "../facturation/modfactEncAjouter_script.php",data: str,success: function(msg) {if(msg == 'OK') {result = '<div class="notification_ok">Your message has been sent. Thank you!</div>';$("#fields").hide();} else {result = msg;}
$('#AfficheFicheFacture2').html(result);}});return false;});
$("#FormFactEncAjou3").off("submit").submit(function(e) {e.stopPropagation();var str = $(this).serialize();$.ajax({type: "POST",
url: "../facturation/modfactEncAjouter_script.php",data: str,success: function(msg) {if(msg == 'OK') {result = '<div class="notification_ok">Your message has been sent. Thank you!</div>';$("#fields").hide();} else {result = msg;}
$('#AfficheListeFacture').html(result);}});return false;});
//***************************************************************************************

//***************************** CHERCHER FACTURE **********************************
$("#RechFactNom").keyup(function(e) {e.stopPropagation();var str = $(this).serialize();$.ajax({type: "GET",
url: "../facturation/modfactlist1.php",data: str,success: function(msg) {if(msg == 'OK') {result = '<div class="notification_ok">Your message has been sent. Thank you!</div>';$("#fields").hide();} else {result = msg;}
$('#AfficheListeFacture').html(result);}});return false;});

$("#RechFactPrenom").keyup(function(e) {e.stopPropagation();var str = $(this).serialize();$.ajax({type: "GET",
url: "../facturation/modfactlist1.php",data: str,success: function(msg) {if(msg == 'OK') {result = '<div class="notification_ok">Your message has been sent. Thank you!</div>';$("#fields").hide();} else {result = msg;}
$('#AfficheListeFacture').html(result);}});return false;});

$("#RechFactFactNumLibe").keyup(function(e) {e.stopPropagation();var str = $(this).serialize();$.ajax({type: "GET",
url: "../facturation/modfactlist1.php",data: str,success: function(msg) {if(msg == 'OK') {result = '<div class="notification_ok">Your message has been sent. Thank you!</div>';$("#fields").hide();} else {result = msg;}
$('#AfficheListeFacture').html(result);}});return false;});
//***************************************************************************************

//***************************** VALIDER PAIEMENT CAISSE **********************************
$("#FormCaisseValPaiement").off("submit").submit(function(e) {e.stopPropagation();var str = $(this).serialize();$.ajax({type: "POST",
url: "../facturation/modcaisse9.php",data: str,success: function(msg) {if(msg == 'OK') {result = '<div class="notification_ok">Your message has been sent. Thank you!</div>';$("#fields").hide();} else {result = msg;}
$('#AfficheCaisseAjouPrestations').html(result);}});return false;});
//***************************************************************************************

//***************************** FACTURATION AUTO AJOUTER PRESTATION **********************************
$("#FormFactAuto2PrestAjou").off("submit").submit(function(e) {e.stopPropagation();var str = $(this).serialize();$.ajax({type: "POST",
url: "../facturation/modfactautoPrestAjou_script.php",data: str,success: function(msg) {if(msg == 'OK') {result = '<div class="notification_ok">Your message has been sent. Thank you!</div>';$("#fields").hide();} else {result = msg;}
$('#FactAuto2List').html(result);}});return false;});
//***************************************************************************************

//***************************** FACTURER EN GROUPE **********************************
$("#FacturerEvenement").off("submit").submit(function(e) {e.stopPropagation();var str = $(this).serialize();$.ajax({type: "POST",
url: "../facturation/modfactAjouter.php",data: str,success: function(msg) {if(msg == 'OK') {result = '<div class="notification_ok">Your message has been sent. Thank you!</div>';$("#fields").hide();} else {result = msg;}
$('#FactAjouter').html(result);}});return false;});
//***************************************************************************************

//***************************** FACTURER EN GROUPE **********************************
$("#EncaisserPasserCate").off("submit").submit(function(e) {e.stopPropagation();var str = $(this).serialize();$.ajax({type: "POST",
url: "../facturation/modEncPasserCate.php",data: str,success: function(msg) {if(msg == 'OK') {result = '<div class="notification_ok">Your message has been sent. Thank you!</div>';$("#fields").hide();} else {result = msg;}
$('#AfficheListeEncaissement').html(result);}});return false;});
//***************************************************************************************

//***************************** FACTURER EN GROUPE **********************************
$("#FormEncaissementAction").off("submit").submit(function(e) {e.stopPropagation();var str = $(this).serialize();$.ajax({type: "POST",
url: "../facturation/modenclist_script.php",data: str,success: function(msg) {if(msg == 'OK') {result = '<div class="notification_ok">Your message has been sent. Thank you!</div>';$("#fields").hide();} else {result = msg;}
$('#AfficheListeEncaissement').html(result);}});return false;});
//***************************************************************************************


});

//***************************** CHERCHER FACTURE **********************************
function RechFactPrest(str) {
    if (str == "") {
        document.getElementById("AfficheListeFacture").innerHTML = "";
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
                document.getElementById("AfficheListeFacture").innerHTML = xmlhttp.responseText;
            }
        }
        xmlhttp.open("GET","../facturation/modfactlist1.php?rechprestnum="+str,true);
        xmlhttp.send();
    }
}
function RechFactDate1(str) {
    if (str == "") {
        document.getElementById("AfficheListeFacture").innerHTML = "";
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
                document.getElementById("AfficheListeFacture").innerHTML = xmlhttp.responseText;
            }
        }
        xmlhttp.open("GET","../facturation/modfactlist1.php?rechdate1="+str,true);
        xmlhttp.send();
    }
}
function RechFactDate2(str) {
    if (str == "") {
        document.getElementById("AfficheListeFacture").innerHTML = "";
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
                document.getElementById("AfficheListeFacture").innerHTML = xmlhttp.responseText;
            }
        }
        xmlhttp.open("GET","../facturation/modfactlist1.php?rechdate2="+str,true);
        xmlhttp.send();
    }
}
//******************************************************************************************

//********************** DUPLIQUER FACTURES*******************************************
function ListPrestClie1(str) {
    if (str == "") {
        document.getElementById("FactDupliquerAffiche1").innerHTML = "";
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
                document.getElementById("FactDupliquerAffiche1").innerHTML = xmlhttp.responseText;
            }
        }
        xmlhttp.open("GET","../facturation/modfactDupliquerAffiche.php?factnum="+str,true);
        xmlhttp.send();
    }
}
function ListPrestClie2(str) {
    if (str == "") {
        document.getElementById("FactDupliquerAffiche2").innerHTML = "";
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
                document.getElementById("FactDupliquerAffiche2").innerHTML = xmlhttp.responseText;
            }
        }
        xmlhttp.open("GET","../facturation/modfactDupliquerAffiche.php?factnum="+str,true);
        xmlhttp.send();
    }
}
function ListPrestClie3(str) {
    if (str == "") {
        document.getElementById("FactDupliquerAffiche3").innerHTML = "";
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
                document.getElementById("FactDupliquerAffiche3").innerHTML = xmlhttp.responseText;
            }
        }
        xmlhttp.open("GET","../facturation/modfactDupliquerAffiche.php?factnum="+str,true);
        xmlhttp.send();
    }
}
function ListPrestClie4(str) {
    if (str == "") {
        document.getElementById("FactDupliquerAffiche4").innerHTML = "";
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
                document.getElementById("FactDupliquerAffiche4").innerHTML = xmlhttp.responseText;
            }
        }
        xmlhttp.open("GET","../facturation/modfactDupliquerAffiche.php?factnum="+str,true);
        xmlhttp.send();
    }
}
function ListPrestClie5(str) {
    if (str == "") {
        document.getElementById("FactDupliquerAffiche5").innerHTML = "";
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
                document.getElementById("FactDupliquerAffiche5").innerHTML = xmlhttp.responseText;
            }
        }
        xmlhttp.open("GET","../facturation/modfactDupliquerAffiche.php?factnum="+str,true);
        xmlhttp.send();
    }
}
function ListPrestClie6(str) {
    if (str == "") {
        document.getElementById("FactDupliquerAffiche6").innerHTML = "";
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
                document.getElementById("FactDupliquerAffiche6").innerHTML = xmlhttp.responseText;
            }
        }
        xmlhttp.open("GET","../facturation/modfactDupliquerAffiche.php?factnum="+str,true);
        xmlhttp.send();
    }
}
function ListPrestClie7(str) {
    if (str == "") {
        document.getElementById("FactDupliquerAffiche7").innerHTML = "";
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
                document.getElementById("FactDupliquerAffiche7").innerHTML = xmlhttp.responseText;
            }
        }
        xmlhttp.open("GET","../facturation/modfactDupliquerAffiche.php?factnum="+str,true);
        xmlhttp.send();
    }
}
function ListPrestClie8(str) {
    if (str == "") {
        document.getElementById("FactDupliquerAffiche8").innerHTML = "";
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
                document.getElementById("FactDupliquerAffiche8").innerHTML = xmlhttp.responseText;
            }
        }
        xmlhttp.open("GET","../facturation/modfactDupliquerAffiche.php?factnum="+str,true);
        xmlhttp.send();
    }
}
function ListPrestClie9(str) {
    if (str == "") {
        document.getElementById("FactDupliquerAffiche9").innerHTML = "";
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
                document.getElementById("FactDupliquerAffiche9").innerHTML = xmlhttp.responseText;
            }
        }
        xmlhttp.open("GET","../facturation/modfactDupliquerAffiche.php?factnum="+str,true);
        xmlhttp.send();
    }
}
function ListPrestClie10(str) {
    if (str == "") {
        document.getElementById("FactDupliquerAffiche10").innerHTML = "";
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
                document.getElementById("FactDupliquerAffiche10").innerHTML = xmlhttp.responseText;
            }
        }
        xmlhttp.open("GET","../facturation/modfactDupliquerAffiche.php?factnum="+str,true);
        xmlhttp.send();
    }
}
//***************************************************************************************

//************************* MODIFICATION DATE PRESTATION *******************************
function AfficheFactPrestDateModif1(str) {
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
        xmlhttp.open("GET","../scripts/InputModif.php?factprestdate="+str,true);
        xmlhttp.send();
    }
}
//****************************************************************************

//************************* MODIFICATION CLIENTS PRESTATION *******************************
function AfficheFactPrestFactclienumModif1(str) {
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
        xmlhttp.open("GET","../scripts/InputModif.php?factclienum1="+str,true);
        xmlhttp.send();
    }
}
function AfficheFactPrestFactclienumModif2(str) {
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
        xmlhttp.open("GET","../scripts/InputModif.php?factclienum2="+str,true);
        xmlhttp.send();
    }
}
function AfficheFactPrestFactassodateModif1(str) {
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
        xmlhttp.open("GET","../scripts/InputModif.php?factprestassodate1="+str,true);
        xmlhttp.send();
    }
}
function AfficheFactPrestFactassodateModif2(str) {
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
        xmlhttp.open("GET","../scripts/InputModif.php?factprestassodate2="+str,true);
        xmlhttp.send();
    }
}
//****************************************************************************

//************************* MODIFICATION CHEVAUX PRESTATION *******************************
function AfficheFactPrestFactchevnumModif1(str) {
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
        xmlhttp.open("GET","../scripts/InputModif.php?factchevnum1="+str,true);
        xmlhttp.send();
    }
}
function AfficheFactPrestFactchevnumModif2(str) {
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
        xmlhttp.open("GET","../scripts/InputModif.php?factchevnum2="+str,true);
        xmlhttp.send();
    }
}
function AfficheFactPrestFactchevnumModif3(str) {
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
        xmlhttp.open("GET","../scripts/InputModif.php?factchevnum3="+str,true);
        xmlhttp.send();
    }
}
function AfficheFactPrestFactchevnumModif4(str) {
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
        xmlhttp.open("GET","../scripts/InputModif.php?factchevnum4="+str,true);
        xmlhttp.send();
    }
}
//****************************************************************************

//****************** MODIFICATION CLIENTS SUR FACTURE **************************
function AffichePrestation1(str) {
    if (str == "") {
        document.getElementById("AfficheAffichePrestation1").innerHTML = "";
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
                document.getElementById("AfficheAffichePrestation1").innerHTML = xmlhttp.responseText;
            }
        }
        xmlhttp.open("GET","../facturation/modfactAffichePrestation.php?typeprestnum="+str,true);
        xmlhttp.send();
    }
}
function AffichePrestation2(str) {
    if (str == "") {
        document.getElementById("AfficheAffichePrestation2").innerHTML = "";
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
                document.getElementById("AfficheAffichePrestation2").innerHTML = xmlhttp.responseText;
            }
        }
        xmlhttp.open("GET","../facturation/modfactAffichePrestation.php?typeprestnum="+str,true);
        xmlhttp.send();
    }
}
function AffichePrestation3(str) {
    if (str == "") {
        document.getElementById("AfficheAffichePrestation3").innerHTML = "";
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
                document.getElementById("AfficheAffichePrestation3").innerHTML = xmlhttp.responseText;
            }
        }
        xmlhttp.open("GET","../facturation/modfactAffichePrestation.php?typeprestnum="+str,true);
        xmlhttp.send();
    }
}
function AffichePrestation4(str) {
    if (str == "") {
        document.getElementById("AfficheAffichePrestation4").innerHTML = "";
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
                document.getElementById("AfficheAffichePrestation4").innerHTML = xmlhttp.responseText;
            }
        }
        xmlhttp.open("GET","../facturation/modfactAffichePrestation.php?typeprestnum="+str,true);
        xmlhttp.send();
    }
}
//****************************************************************************

//****************** MODIFICATION DATE FACTURE **************************
function FactDateModifInput2(str) {
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
        xmlhttp.open("GET","../facturation/modfactModifDate_script.php?factdate="+str,true);
        xmlhttp.send();
    }
}
//****************************************************************************

//****************** SELECT CLIENT CAISSE **************************
function CaisseModifClient(str) {
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
        xmlhttp.open("GET","../facturation/modcaisse8.php?clienum="+str,true);
        xmlhttp.send();
    }
}
//****************************************************************************

//****************** SELECT CLIENT CAISSE **************************
function AfficherClieAdresMail(str) {
    if (str == "") {
        document.getElementById("noteAfficherClieAdresMail").innerHTML = "";
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
                document.getElementById("noteAfficherClieAdresMail").innerHTML = xmlhttp.responseText;
            }
        }
        xmlhttp.open("GET","../facturation/modcaisse12.php?reponse="+str,true);
        xmlhttp.send();
    }
}
//****************************************************************************

//****************** SELECT CLIENT 1 PRESTATION CAISSE **************************
function CaissePrestationClie1(str) {
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
        xmlhttp.open("GET","../scripts/InputModif.php?caisseclients1="+str,true);
        xmlhttp.send();
    }
}
//****************************************************************************

//****************** SELECT CLIENT 2 PRESTATION CAISSE **************************
function CaissePrestationClie2(str) {
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
        xmlhttp.open("GET","../scripts/InputModif.php?caisseclients2="+str,true);
        xmlhttp.send();
    }
}
//****************************************************************************

//****************** RECHERCHE DATE LIVRE DE COMPTE **************************
function AfficheLivreDeCompte1(str) {
    if (str == "") {
        document.getElementById("AfficheLivreDeCompte").innerHTML = "";
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
                document.getElementById("AfficheLivreDeCompte").innerHTML = xmlhttp.responseText;
            }
        }
        xmlhttp.open("GET","../facturation/modlivredecompte1.php?livrecomptedate1="+str,true);
        xmlhttp.send();
    }
}
function AfficheLivreDeCompte2(str) {
    if (str == "") {
        document.getElementById("AfficheLivreDeCompte").innerHTML = "";
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
                document.getElementById("AfficheLivreDeCompte").innerHTML = xmlhttp.responseText;
            }
        }
        xmlhttp.open("GET","../facturation/modlivredecompte1.php?livrecomptedate2="+str,true);
        xmlhttp.send();
    }
}
function AfficheLivreDeCompte3(str) {
    if (str == "") {
        document.getElementById("AfficheLivreDeCompte").innerHTML = "";
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
                document.getElementById("AfficheLivreDeCompte").innerHTML = xmlhttp.responseText;
            }
        }
        xmlhttp.open("GET","../facturation/modlivredecompte1.php?livrecompteclienum="+str,true);
        xmlhttp.send();
    }
}
function AfficheLivreDeCompte4(str) {
    if (str == "") {
        document.getElementById("AfficheLivreDeCompte").innerHTML = "";
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
                document.getElementById("AfficheLivreDeCompte").innerHTML = xmlhttp.responseText;
            }
        }
        xmlhttp.open("GET","../facturation/modlivredecompte1.php?livrecomptemodepaienum="+str,true);
        xmlhttp.send();
    }
}
//****************************************************************************

//**************** FACTURATION AUTO LECTURE TYPE ***********************
function AfficheFactAuto1Type1(str) {
    if (str == "") {
        document.getElementById("AfficheFactAuto1Type1Lect").innerHTML = "";
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
                document.getElementById("AfficheFactAuto1Type1Lect").innerHTML = xmlhttp.responseText;
            }
        }
        xmlhttp.open("GET","../facturation/AfficheFactAuto1TypeScript.php?q="+str,true);
        xmlhttp.send();
    }
}
//**********************************************************

//*********** AFFCICHER PRIX TTC ***************************
function AffichePrixTtc1(str) {
    if (str == "") {
        document.getElementById("AffichePrixTtc1Lect").innerHTML = "";
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
                document.getElementById("AffichePrixTtc1Lect").innerHTML = xmlhttp.responseText;
            }
        }
        xmlhttp.open("GET","../facturation/AffichePrixTtc.php?q="+str,true);
        xmlhttp.send();
    }
}
function AffichePrixTtc2(str) {
    if (str == "") {
        document.getElementById("AffichePrixTtc2Lect").innerHTML = "";
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
                document.getElementById("AffichePrixTtc2Lect").innerHTML = xmlhttp.responseText;
            }
        }
        xmlhttp.open("GET","../facturation/AffichePrixTtc.php?q="+str,true);
        xmlhttp.send();
    }
}
function AffichePrixTtc3(str) {
    if (str == "") {
        document.getElementById("AffichePrixTtc3Lect").innerHTML = "";
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
                document.getElementById("AffichePrixTtc3Lect").innerHTML = xmlhttp.responseText;
            }
        }
        xmlhttp.open("GET","../facturation/AffichePrixTtc.php?q="+str,true);
        xmlhttp.send();
    }
}
function AffichePrixTtc4(str) {
    if (str == "") {
        document.getElementById("AffichePrixTtc4Lect").innerHTML = "";
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
                document.getElementById("AffichePrixTtc4Lect").innerHTML = xmlhttp.responseText;
            }
        }
        xmlhttp.open("GET","../facturation/AffichePrixTtc.php?q="+str,true);
        xmlhttp.send();
    }
}
//*****************************************************************


//************** RECHERCHE DATE D EVENEMENT POUR CAVALIER **************
function FactGroupRechDate1(str) {
    if (str == "") {
        document.getElementById("AfficheFactureGrouper").innerHTML = "";
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
                document.getElementById("AfficheFactureGrouper").innerHTML = xmlhttp.responseText;
            }
        }
        xmlhttp.open("GET","../facturation/modfactfacturationgrouper1.php?rechdate1="+str,true);
        xmlhttp.send();
    }
}
function FactGroupRechDate2(str) {
    if (str == "") {
        document.getElementById("AfficheFactureGrouper").innerHTML = "";
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
                document.getElementById("AfficheFactureGrouper").innerHTML = xmlhttp.responseText;
            }
        }
        xmlhttp.open("GET","../facturation/modfactfacturationgrouper1.php?rechdate2="+str,true);
        xmlhttp.send();
    }
}
function FactGroupRechInd(str) {
    if (str == "") {
        document.getElementById("AfficheFactureGrouper").innerHTML = "";
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
                document.getElementById("AfficheFactureGrouper").innerHTML = xmlhttp.responseText;
            }
        }
        xmlhttp.open("GET","../facturation/modfactfacturationgrouper1.php?RechercherInd="+str,true);
        xmlhttp.send();
    }
}
//************************************************

//************* RECHERCHE PRODUITS CONSTATES D AVANCES ***********************
function FactProduitsDate1(str) {
    if (str == "") {
        document.getElementById("AfficheProduitsConstates").innerHTML = "";
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
                document.getElementById("AfficheProduitsConstates").innerHTML = xmlhttp.responseText;
            }
        }
        xmlhttp.open("GET","../facturation/modfactproduitsconstates1.php?FactProduitsDate1="+str,true);
        xmlhttp.send();
    }
}
function FactProduitsDate2(str) {
    if (str == "") {
        document.getElementById("AfficheProduitsConstates").innerHTML = "";
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
                document.getElementById("AfficheProduitsConstates").innerHTML = xmlhttp.responseText;
            }
        }
        xmlhttp.open("GET","../facturation/modfactproduitsconstates1.php?FactProduitsDate2="+str,true);
        xmlhttp.send();
    }
}
//**********************************************************************

</script>
