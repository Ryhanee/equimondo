<script type="text/javascript">

    jQuery(document).ready(function ($) {

//***************************** AJOUTER UN CLIENT **********************************
        $("#FormClieAjou").off("submit").submit(function (e) {
            e.stopPropagation();
            var str = $(this).serialize();
            $.ajax({
                type: "POST",
                url: "../clients/modclieAjou_script.php", data: str, success: function (msg) {
                    if (msg == 'OK') {
                        result = '<div class="notification_ok">Your message has been sent. Thank you!</div>';
                        $("#fields").hide();
                    } else {
                        result = msg;
                    }
                    $('#AfficheFicheProfil2').html(result);
                }
            });
            return false;
        });
//***************************************************************************************

//***************************** RETIRER DES HEURE FORFAIT **********************************
        $("#FormForfRetirerHeure").off("submit").submit(function (e) {
            e.stopPropagation();
            var str = $(this).serialize();
            $.ajax({
                type: "POST",
                url: "../clients/ForfaitRetirerHeure_script.php", data: str, success: function (msg) {
                    if (msg == 'OK') {
                        result = '<div class="notification_ok">Your message has been sent. Thank you!</div>';
                        $("#fields").hide();
                    } else {
                        result = msg;
                    }
                    $('#AfficheFicheCompletForfait').html(result);
                }
            });
            return false;
        });
//***************************************************************************************

//***************************** RETIRER DES HEURE FORFAIT **********************************
        $("#FormForfAjouHeure").off("submit").submit(function (e) {
            e.stopPropagation();
            var str = $(this).serialize();
            $.ajax({
                type: "POST",
                url: "../clients/modForfClieHeureAjou_script.php", data: str, success: function (msg) {
                    if (msg == 'OK') {
                        result = '<div class="notification_ok">Your message has been sent. Thank you!</div>';
                        $("#fields").hide();
                    } else {
                        result = msg;
                    }
                    $('#AfficheForfClie').html(result);
                }
            });
            return false;
        });
//***************************************************************************************

//***************************** AJOUTER MEMBRE DE LA MEME FAMILLE **********************************
        $("#FormMembreFamilleAjou1").off("submit").submit(function (e) {
            e.stopPropagation();
            var str = $(this).serialize();
            $.ajax({
                type: "POST",
                url: "../clients/modMembreFamilleAjou1_script.php", data: str, success: function (msg) {
                    if (msg == 'OK') {
                        result = '<div class="notification_ok">Your message has been sent. Thank you!</div>';
                        $("#fields").hide();
                    } else {
                        result = msg;
                    }
                    $('#AfficheMembreFamille').html(result);
                }
            });
            return false;
        });
        $("#FormMembreFamilleAjou2").off("submit").submit(function (e) {
            e.stopPropagation();
            var str = $(this).serialize();
            $.ajax({
                type: "POST",
                url: "../clients/modMembreFamilleAjou2_script.php", data: str, success: function (msg) {
                    if (msg == 'OK') {
                        result = '<div class="notification_ok">Your message has been sent. Thank you!</div>';
                        $("#fields").hide();
                    } else {
                        result = msg;
                    }
                    $('#AfficheMembreFamille').html(result);
                }
            });
            return false;
        });
//***************************************************************************************

$("#ForfaitCarteAssociation").off("submit").submit(function (e) {
    e.stopPropagation();
    var str = $(this).serialize();
    $.ajax({
        type: "POST",
        url: "../clients/modforfaitcarteassociation_script.php", data: str, success: function (msg) {
            if (msg == 'OK') {
                result = '<div class="notification_ok">Your message has been sent. Thank you!</div>';
                $("#fields").hide();
            } else {
                result = msg;
            }
            $('#AfficheForfList').html(result);
        }
    });
    return false;
});

//*********************** RECHERCHE PAR CLIENT NOM *****************************
var timeoutNom;

$("#RechClieNom").off('keyup').keyup(function (e) {
    e.stopPropagation();
    var str = $(this).serialize();

    if (timeoutNom) {
        clearTimeout(timeoutNom);
    }

    timeoutNom = setTimeout(function () {
        $.ajax({
            type: "GET",
            url: "../clients/modclielist1.php",
            data: str,
            success: function (msg) {
                $('#AfficheListeClient').html(msg);
            }
        });
    }, 500);

    return false;
});
//***************************************************************************************
//*********************** RECHERCHE PAR CLIENT PRENOM *****************************
var timeoutPrenom;

$("#RechCliePrenom").off('keyup').keyup(function (e) {
    e.stopPropagation();
    var str = $(this).serialize();

    if (timeoutPrenom) {
        clearTimeout(timeoutPrenom);
    }

    timeoutPrenom = setTimeout(function () {
        $.ajax({
            type: "GET",
            url: "../clients/modclielist1.php",
            data: str,
            success: function (msg) {
                $('#AfficheListeClient').html(msg);
            }
        });
    }, 500);

    return false;
});
//***************************************************************************************

    });

//************************ MODIF CLIENTS PAYS ******************************
function ClieModifPays(str) {
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
        xmlhttp.onreadystatechange = function () {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                document.getElementById("noteInputModif").innerHTML = xmlhttp.responseText;
            }
        }
        xmlhttp.open("GET", "../scripts/InputModif.php?cliepays=" + str, true);
        xmlhttp.send();
    }
}

//****************************************************************************

    //************************ MODIF CLIENTS DATE NAISSANCE ******************************
    function ClieModifDateNaiss(str) {
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
            xmlhttp.onreadystatechange = function () {
                if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                    document.getElementById("noteInputModif").innerHTML = xmlhttp.responseText;
                }
            }
            xmlhttp.open("GET", "../scripts/InputModif.php?cliedatenaiss=" + str, true);
            xmlhttp.send();
        }
    }

    //****************************************************************************

    //************************ MODIF CLIENTS DATE VALIDATION LICENCE ******************************
    function ClieModifDateValLic(str) {
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
            xmlhttp.onreadystatechange = function () {
                if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                    document.getElementById("noteInputModif").innerHTML = xmlhttp.responseText;
                }
            }
            xmlhttp.open("GET", "../scripts/InputModif.php?cliedatevallic=" + str, true);
            xmlhttp.send();
        }
    }

    //****************************************************************************

    //************************ MODIF CLIENTS DATE INSCRIPTION ******************************
    function ClieModifDateInscription(str) {
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
            xmlhttp.onreadystatechange = function () {
                if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                    document.getElementById("noteInputModif").innerHTML = xmlhttp.responseText;
                }
            }
            xmlhttp.open("GET", "../scripts/InputModif.php?cliedateinscription=" + str, true);
            xmlhttp.send();
        }
    }

    //****************************************************************************

    //************************ MODIF CLIENTS DATE COTISATION ******************************
    function ClieModifDateCotisation(str) {
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
            xmlhttp.onreadystatechange = function () {
                if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                    document.getElementById("noteInputModif").innerHTML = xmlhttp.responseText;
                }
            }
            xmlhttp.open("GET", "../scripts/InputModif.php?cliedatecotisation=" + str, true);
            xmlhttp.send();
        }
    }

    //****************************************************************************

    //************************ MODIF CLIENTS NIVEAU ******************************
    function ClieModifNiveau(str) {
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
            xmlhttp.onreadystatechange = function () {
                if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                    document.getElementById("noteInputModif").innerHTML = xmlhttp.responseText;
                }
            }
            xmlhttp.open("GET", "../scripts/InputModif.php?clieniveau=" + str, true);
            xmlhttp.send();
        }
    }

    //****************************************************************************

    //************************ MODIF CLIENTS CIVILITE ******************************
    function ClieModifCivilite(str) {
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
            xmlhttp.onreadystatechange = function () {
                if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                    document.getElementById("noteInputModif").innerHTML = xmlhttp.responseText;
                }
            }
            xmlhttp.open("GET", "../scripts/InputModif.php?cliecivilite=" + str, true);
            xmlhttp.send();
        }
    }

    function ClieModifCivilite1(str) {
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
            xmlhttp.onreadystatechange = function () {
                if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                    document.getElementById("noteInputModif").innerHTML = xmlhttp.responseText;
                }
            }
            xmlhttp.open("GET", "../scripts/InputModif.php?cliecivilite=" + str, true);
            xmlhttp.send();
        }
    }

    //****************************************************************************

    //************************ MODIF CLIENTS STATUS ******************************
    function ClieModifStatus(str) {
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
            xmlhttp.onreadystatechange = function () {
                if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                    document.getElementById("noteInputModif").innerHTML = xmlhttp.responseText;
                }
            }
            xmlhttp.open("GET", "../scripts/InputModif.php?cliestatus=" + str, true);
            xmlhttp.send();
        }
    }

    //****************************************************************************

    //************************ MODIF CLIENTS STATUS ******************************
    function AfficheClieCivilite(str) {
        if (str == "") {
            document.getElementById("noteAfficheClieCivilite").innerHTML = "";
            return;
        } else {
            if (window.XMLHttpRequest) {
                // code for IE7+, Firefox, Chrome, Opera, Safari
                xmlhttp = new XMLHttpRequest();
            } else {
                // code for IE6, IE5
                xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
            }
            xmlhttp.onreadystatechange = function () {
                if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                    document.getElementById("noteAfficheClieCivilite").innerHTML = xmlhttp.responseText;
                }
            }
            xmlhttp.open("GET", "../clients/AfficheClieCivilite.php?cliecivilite=" + str, true);
            xmlhttp.send();
        }
    }

    function AfficheClieCivilite1(str) {
        if (str == "") {
            document.getElementById("noteAfficheClieCivilite1").innerHTML = "";
            return;
        } else {
            if (window.XMLHttpRequest) {
                // code for IE7+, Firefox, Chrome, Opera, Safari
                xmlhttp = new XMLHttpRequest();
            } else {
                // code for IE6, IE5
                xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
            }
            xmlhttp.onreadystatechange = function () {
                if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                    document.getElementById("noteAfficheClieCivilite1").innerHTML = xmlhttp.responseText;
                }
            }
            xmlhttp.open("GET", "../clients/AfficheClieCivilite.php?cliecivilite=" + str, true);
            xmlhttp.send();
        }
    }

    //****************************************************************************

    //************************ CLIENTS CIVILITE ******************************
    function ClieModifStatus(str) {
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
            xmlhttp.onreadystatechange = function () {
                if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                    document.getElementById("noteInputModif").innerHTML = xmlhttp.responseText;
                }
            }
            xmlhttp.open("GET", "../scripts/InputModif.php?cliestatus=" + str, true);
            xmlhttp.send();
        }
    }

    //****************************************************************************

    //************************ CLIENTS STATUS ******************************
    function AfficheClieStatus(str) {
        if (str == "") {
            document.getElementById("noteAfficheClieStatus").innerHTML = "";
            return;
        } else {
            if (window.XMLHttpRequest) {
                // code for IE7+, Firefox, Chrome, Opera, Safari
                xmlhttp = new XMLHttpRequest();
            } else {
                // code for IE6, IE5
                xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
            }
            xmlhttp.onreadystatechange = function () {
                if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                    document.getElementById("noteAfficheClieStatus").innerHTML = xmlhttp.responseText;
                }
            }
            xmlhttp.open("GET", "../clients/AfficheClieStatus.php?cliestatus=" + str, true);
            xmlhttp.send();
        }
    }

    //****************************************************************************

    //************************ MODIF DATE FORFAIT VALIDITE ******************************
    function ClieForfModifDate1(str) {
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
            xmlhttp.onreadystatechange = function () {
                if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                    document.getElementById("noteInputModif").innerHTML = xmlhttp.responseText;
                }
            }
            xmlhttp.open("GET", "../scripts/InputModif.php?cliesoldforfentrdate1=" + str, true);
            xmlhttp.send();
        }
    }

    function ClieForfModifDate2(str) {
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
            xmlhttp.onreadystatechange = function () {
                if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                    document.getElementById("noteInputModif").innerHTML = xmlhttp.responseText;
                }
            }
            xmlhttp.open("GET", "../scripts/InputModif.php?cliesoldforfentrdate2=" + str, true);
            xmlhttp.send();
        }
    }

    function ClieForfModifAjouClie(str) {
        if (str == "") {
            document.getElementById("AfficheForfClientsAssocies").innerHTML = "";
            return;
        } else {
            if (window.XMLHttpRequest) {
                // code for IE7+, Firefox, Chrome, Opera, Safari
                xmlhttp = new XMLHttpRequest();
            } else {
                // code for IE6, IE5
                xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
            }
            xmlhttp.onreadystatechange = function () {
                if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                    document.getElementById("AfficheForfClientsAssocies").innerHTML = xmlhttp.responseText;
                }
            }
            xmlhttp.open("GET", "../clients/modforfcliesupp.php?clienum=" + str, true);
            xmlhttp.send();
        }
    }

    //****************************************************************************

    //******************** AFFICHE NOMBRE D'HEURE CLIENT ****************************
    function ClieForfAjouHeureManuel(str) {
        if (str == "") {
            document.getElementById("noteClieForfAjouHeureManuel").innerHTML = "";
            return;
        } else {
            if (window.XMLHttpRequest) {
                // code for IE7+, Firefox, Chrome, Opera, Safari
                xmlhttp = new XMLHttpRequest();
            } else {
                // code for IE6, IE5
                xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
            }
            xmlhttp.onreadystatechange = function () {
                if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                    document.getElementById("noteClieForfAjouHeureManuel").innerHTML = xmlhttp.responseText;
                }
            }
            xmlhttp.open("GET", "../clients/ClieForfAjouHeureManuel.php?typeprestnum=" + str, true);
            xmlhttp.send();
        }
    }

    //****************************************************************************

    //******************* AFFICHE CLIENUM ****************************
    function RechercheClieNum1(str) {
        if (str == "") {
            document.getElementById("AfficheFicheProfil1").innerHTML = "";
            return;
        } else {
            if (window.XMLHttpRequest) {
                // code for IE7+, Firefox, Chrome, Opera, Safari
                xmlhttp = new XMLHttpRequest();
            } else {
                // code for IE6, IE5
                xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
            }
            xmlhttp.onreadystatechange = function () {
                if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                    document.getElementById("AfficheFicheProfil1").innerHTML = xmlhttp.responseText;
                }
            }
            xmlhttp.open("GET", "../profil/modprofilfichcomplet1.php?clienum=" + str, true);
            xmlhttp.send();
        }
    }

    function RechercheClieNum2(str) {
        if (str == "") {
            document.getElementById("AfficheFicheProfil2").innerHTML = "";
            return;
        } else {
            if (window.XMLHttpRequest) {
                // code for IE7+, Firefox, Chrome, Opera, Safari
                xmlhttp = new XMLHttpRequest();
            } else {
                // code for IE6, IE5
                xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
            }
            xmlhttp.onreadystatechange = function () {
                if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                    document.getElementById("AfficheFicheProfil2").innerHTML = xmlhttp.responseText;
                }
            }
            xmlhttp.open("GET", "../profil/modprofilfichcomplet2.php?clienum=" + str, true);
            xmlhttp.send();
        }
    }

    //****************************************************************************
    console.log(   
    jQuery('#clients').select2({
    ajax: {
      url: 'modlistclients.php',
      delay: 250,
      data: function (params) {
        return {
          q: params.term, // search term
          page: params.page
        };
      },
      processResults : function (data) {
        return {
            results : data
        }
        
      },
      cache: true
    },
    placeholder: 'Search for a repository',
   
  })
);
$('#clients').select2({
        ajax: {
          url: 'modlistclients.php',
          delay: 250,
          data: function (params) {
            return {
              q: params.term, // search term
              page: params.page
            };
          },
          processResults: function (data, params) {
            // parse the results into the format expected by Select2
            // since we are using custom formatting functions we do not need to
            // alter the remote JSON data, except to indicate that infinite
            // scrolling can be used
            params.page = params.page || 1;
      
            return {
              results: data.items,
              pagination: {
                more: (params.page * 30) < data.total_count
              }
            };
          },
          cache: true
        },
        placeholder: 'Search for a repository',
        minimumInputLength: 1,
       
      });
      
</script>
