<?php

//************************* AFFICHER MODE DE PAIEMENT *************************
$iTour = 1;
while($iTour <= 20)
{
?>
<script type="text/javascript">
<?php $VariableSelect = "AfficheModePaie".$iTour; ?>
function <?php echo $VariableSelect; ?>(str) {
    if (str == "") {
        document.getElementById("Div<?php echo $VariableSelect; ?>").innerHTML = "";
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
                document.getElementById("Div<?php echo $VariableSelect; ?>").innerHTML = xmlhttp.responseText;
            }
        }
        xmlhttp.open("GET","../facturation/modAfficheModePaie.php?q="+str,true);
        xmlhttp.send();
    }
}
</script>
<?php
$iTour = $iTour + 1;
}
$iTour = 1;
while($iTour <= 20)
{
?>
<script type="text/javascript">
<?php $VariableSelect = "AfficheModePaieAll".$iTour; ?>
function <?php echo $VariableSelect; ?>(str) {
    if (str == "") {
        document.getElementById("Div<?php echo $VariableSelect; ?>").innerHTML = "";
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
                document.getElementById("Div<?php echo $VariableSelect; ?>").innerHTML = xmlhttp.responseText;
            }
        }
        xmlhttp.open("GET","../facturation/modAfficheModePaieAll.php?q="+str,true);
        xmlhttp.send();
    }
}
</script>
<?php
$iTour = $iTour + 1;
}
//***********************************************************

//************************* AFFICHER SELECT PRESTATION POUR UNE FACTURE *************************
$iTour = 1;
while($iTour <= 20)
{
?>
<script type="text/javascript">
<?php $VariableSelect = "AfficheFactAjouterPrestationsClie".$iTour; ?>
function <?php echo $VariableSelect; ?>(str) {
    if (str == "") {
        document.getElementById("Div<?php echo $VariableSelect; ?>").innerHTML = "";
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
                document.getElementById("Div<?php echo $VariableSelect; ?>").innerHTML = xmlhttp.responseText;
            }
        }
        xmlhttp.open("GET","../facturation/modAfficheFactAjouterPrestationsClie.php?clienum="+str,true);
        xmlhttp.send();
    }
}
</script>
<?php
$iTour = $iTour + 1;
}

$iTour = 1;
while($iTour <= 20)
{
?>
<script type="text/javascript">
<?php $VariableSelect = "AfficheFactAjouterPrestationsGroup".$iTour; ?>
function <?php echo $VariableSelect; ?>(str) {
    if (str == "") {
        document.getElementById("Div<?php echo $VariableSelect; ?>").innerHTML = "";
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
                document.getElementById("Div<?php echo $VariableSelect; ?>").innerHTML = xmlhttp.responseText;
            }
        }
        xmlhttp.open("GET","../facturation/modAfficheFactAjouterPrestationsGroup.php?groupnum="+str,true);
        xmlhttp.send();
    }
}
</script>
<?php
$iTour = $iTour + 1;
}
//***********************************************************

//************************* AFFICHER PRESTATION POUR UNE FACTURE *************************
$iTour = 1;
while($iTour <= 45)
{
?>
<script type="text/javascript">
<?php $VariableSelect = "AfficheFactAjouterPrestations".$iTour; ?>
function <?php echo $VariableSelect; ?>(str) {
    if (str == "") {
        document.getElementById("Div<?php echo $VariableSelect; ?>").innerHTML = "";
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
                document.getElementById("Div<?php echo $VariableSelect; ?>").innerHTML = xmlhttp.responseText;
            }
        }
        xmlhttp.open("GET","../facturation/modAfficheFactAjouterPrestations.php?typeprestnum="+str,true);
        xmlhttp.send();
    }
}
</script>
<?php
$iTour = $iTour + 1;
}
//***********************************************************

//************************* MONTOIR ATTRIBUTION CAVALIER *************************
$iTour = 1;
while($iTour <= 45)
{
?>
<script type="text/javascript">
<?php $VariableSelect = "MontoirAttributionCavalier".$iTour; ?>
function <?php echo $VariableSelect; ?>(str) {
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
        xmlhttp.open("GET","../calendrier/modcalefichmontoir1.php?clienum="+str,true);
        xmlhttp.send();
    }
}
</script>
<?php
$iTour = $iTour + 1;
}
//***********************************************************

//************************* ATTRIBUTION CHEVAUX DANS REPRISE *************************
$iTour = 1;
while($iTour <= 200)
{
?>
<script type="text/javascript">
<?php $VariableSelect = "CalePartChevnumSelect".$iTour; ?>
function <?php echo $VariableSelect; ?>(str) {
    if (str == "") {
        document.getElementById("Div<?php echo $VariableSelect; ?>").innerHTML = "";
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
                document.getElementById("Div<?php echo $VariableSelect; ?>").innerHTML = xmlhttp.responseText;
            }
        }
        xmlhttp.open("GET","../calendrier/modcalePartChev.php?chevnum="+str,true);
        xmlhttp.send();
    }
}
</script>
<?php
$iTour = $iTour + 1;
}
//***********************************************************

//************************* ATTRIBUTION CLIENT DANS MONTOIR *************************
$iTour = 1;
while($iTour <= 200)
{
?>
<script type="text/javascript">
<?php $VariableSelect = "CalePartClienumSelect".$iTour; ?>
function <?php echo $VariableSelect; ?>(str) {
    if (str == "") {
        document.getElementById("Div<?php echo $VariableSelect; ?>").innerHTML = "";
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
                document.getElementById("Div<?php echo $VariableSelect; ?>").innerHTML = xmlhttp.responseText;
            }
        }
        xmlhttp.open("GET","../calendrier/modcalePartClie.php?chevnum="+str,true);
        xmlhttp.send();
    }
}
</script>
<?php
$iTour = $iTour + 1;
}
//***********************************************************


//************************* ATTRIBUTION STATUS DANS REPRISE *************************
$iTour = 1;
while($iTour <= 45)
{
?>
<script type="text/javascript">
<?php $VariableSelect = "CalePartText2Select".$iTour; ?>
function <?php echo $VariableSelect; ?>(str) {
    if (str == "") {
        document.getElementById("Div<?php echo $VariableSelect; ?>").innerHTML = "";
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
                document.getElementById("Div<?php echo $VariableSelect; ?>").innerHTML = xmlhttp.responseText;
            }
        }
        xmlhttp.open("GET","../calendrier/modcalePartText2.php?caleparttext2="+str,true);
        xmlhttp.send();
    }
}
</script>
<?php
$iTour = $iTour + 1;
}
//***********************************************************

//************************* ATTRIBUTION STATUS DANS REPRISE *************************
$iTour = 1;
while($iTour <= 45)
{
?>
<script type="text/javascript">
<?php $VariableSelect = "CalePartNbDebitSelect".$iTour; ?>
function <?php echo $VariableSelect; ?>(str) {
    if (str == "") {
        document.getElementById("Div<?php echo $VariableSelect; ?>").innerHTML = "";
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
                document.getElementById("Div<?php echo $VariableSelect; ?>").innerHTML = xmlhttp.responseText;
            }
        }
        xmlhttp.open("GET","../calendrier/modcalePartNbDebit.php?calepartnbdebit="+str,true);
        xmlhttp.send();
    }
}
</script>
<?php
$iTour = $iTour + 1;
}
//***********************************************************

//************************* AFFICHE PRESTATIONS *************************
$iTour = 1;
while($iTour <= 45)
{
?>
<script type="text/javascript">
<?php $VariableSelect = "AfficheCalePrestation".$iTour; ?>
function <?php echo $VariableSelect; ?>(str) {
    if (str == "") {
        document.getElementById("Div<?php echo $VariableSelect; ?>").innerHTML = "";
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
                document.getElementById("Div<?php echo $VariableSelect; ?>").innerHTML = xmlhttp.responseText;
            }
        }
        xmlhttp.open("GET","../calendrier/modcalePrestation.php?typeprestnum="+str,true);
        xmlhttp.send();
    }
}
</script>
<?php
$iTour = $iTour + 1;
}
//***********************************************************

//************************* AFFICHE PRESTATIONS RESERVATION  *************************
$iTour = 1;
while($iTour <= 45)
{
?>
<script type="text/javascript">
<?php $VariableSelect = "AfficheTypePrestationReservation".$iTour; ?>
function <?php echo $VariableSelect; ?>(str) {
    if (str == "") {
        document.getElementById("Div<?php echo $VariableSelect; ?>").innerHTML = "";
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
                document.getElementById("Div<?php echo $VariableSelect; ?>").innerHTML = xmlhttp.responseText;
            }
        }
        xmlhttp.open("GET","../calendrier/AfficheTypePrestationReservation.php?typeprestnum="+str,true);
        xmlhttp.send();
    }
}
</script>
<?php
$iTour = $iTour + 1;
}
//***********************************************************

//********************** BOUCLE POUR LES INPUTS *****************************
?>
<script type="text/javascript">
$(document).ready(function(){
<?php
$iTour = 1;
while($iTour <= 80)
  {
    $VariableInput = "InputModif".$iTour;
    ?>
    $('#<?php echo $VariableInput; ?>').keyup(function(){
      var str = $(this).serialize();
      $.ajax({
        type: "POST",
        url: "../scripts/InputModif.php",
        data: str,
        success: function(msg) {
            // Message Sent? Show the 'Thank You' message and hide the form
            if(msg == 'OK') {
              result = '<div class="notification_ok">Your message has been sent. Thank you!</div>';
              $("#fields").hide();
            } else {
              result = msg;
            }
            $('#noteInputModif').html(result);
        }
      });
      return false;
    })
<?php
    $iTour = $iTour + 1;
  }
//**************************************************************************

//********************** ENREGISTRER RAISON CAVALIERS *****************************
$iTour = 1;
while($iTour <= 50)
  {
    $VariableInput = "AfficheAnnulationCavalier".$iTour;
    ?>
    $("#<?php echo $VariableInput; ?>").off("submit").submit(function(e) {e.stopPropagation();var str = $(this).serialize();$.ajax({type: "POST",
    url: "../calendrier/modcalereservation_script.php",data: str,success: function(msg) {if(msg == 'OK') {result = '<div class="notification_ok">Your message has been sent. Thank you!</div>';$("#fields").hide();} else {result = msg;}
    $('#AfficheReservationCavalier<?php echo $iTour; ?>').html(result);}});return false;});
<?php
    $iTour = $iTour + 1;
  }
//**************************************************************************

?>
});
</script>
<?php
//**************************************************************************

//********************** BOUCLE POUR LES INPUTS *****************************
?>
<script type="text/javascript">
$(document).ready(function(){
<?php
//********************* FACT MENU LIST ********************************
$iTour = 1;
while($iTour <= 20)
  {
    $VariableInput = "AfficheFactListMultiple".$iTour;
    ?>
    $("a.<?php echo $VariableInput; ?>")
    .click(function() {
    $("#<?php echo $VariableInput; ?>").load(this.href);
    	return false;
    });
    <?php
    $iTour = $iTour + 1;
  }
//*************************************************************************

//********************* FACT MENU LIST ********************************
$iTour = 1;
while($iTour <= 20)
  {
    $VariableInput = "AfficheClieListMultiple".$iTour;
    ?>
    $("a.<?php echo $VariableInput; ?>")
    .click(function() {
    $("#<?php echo $VariableInput; ?>").load(this.href);
    	return false;
    });
    <?php
    $iTour = $iTour + 1;
  }
//*************************************************************************

//********************* SAISIR ANNULATION REPRISE ********************************
$iTour = 1;
while($iTour <= 50)
  {
    $VariableInput = "SaisirAnnulationReservationCavalier".$iTour;
    ?>
    $("a.<?php echo $VariableInput; ?>")
    .click(function() {
    $("#<?php echo $VariableInput; ?>").load(this.href);
    	return false;
    });
    <?php
    $iTour = $iTour + 1;
  }
//*************************************************************************

//********************* ACCEPTER RESERVATION EN LIGNE CAVALIERS ********************************
$iTour = 1;
while($iTour <= 50)
  {
    $VariableInput = "AfficheReservationCavalier".$iTour;
    ?>
    $("a.<?php echo $VariableInput; ?>")
    .click(function() {
    $("#<?php echo $VariableInput; ?>").load(this.href);
    	return false;
    });
    <?php
    $iTour = $iTour + 1;
  }
//*************************************************************************


?>
});


</script>
<?php
//**************************************************************************



?>
