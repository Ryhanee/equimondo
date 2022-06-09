<?php
$Dossier = "../../";
include $Dossier."header.php";
include $Dossier."modules/divers/MenuThemes.php";
//
?>

<link rel="stylesheet" href="css/styles.css" />
<!-- Template Base Styles End -->

<link rel="stylesheet" href="css/main.css" />
<link type="text/css" rel="stylesheet" media="screen" href="css/dd_signature_pad.css" />
<script type="text/javascript" src="js/dd_signature_pad.js"></script>
<style type="text/css">
</style>
<script type="text/javascript">
    /**
     * This function is for this demo page only.
     */
    function demo_postSaveAction() {



    }

    jQuery(document).ready(function ($) {
        $('#ajoutDoc').on('click', function() {
            $("#ajoutDoc").attr("disabled", "disabled");
            var canvas=document.getElementById("dd_canvas");
            if(dd_signatureStarted)
            var dataUrl=canvas.toDataURL();
            else
                dataUrl="";
            var titre = $("#titre").val();
            var description = $('.ql-editor p').html();

            if((titre !="") && (description !="")){
                $.ajax({
                    url: "ajouDoc.php",
                    type: "POST",
                    data: {
                        titre: titre,
                        description: description,
                        signature:dataUrl
                    },
                    cache: false,
                    success: function(dataResult){
                        var dataResult = JSON.parse(dataResult);
                        if(dataResult.statusCode==200){
                            $("#ajoutDoc").removeAttr("disabled");
                            $('#docForm').find('input:text').val('');
                            alert('success')
                        }
                        else if(dataResult.statusCode==201){
                            alert("Error occured !");
                        }

                    }
                });
            }
            else{
                alert('Please fill all the field !');
            }
        });
        new Quill('#quillEditor', {
  theme: 'snow'
});
    });

</script>

<div id="root">
    <main><div class="container"><div class="row"><div class="col">

                    <section class="scroll-section" id="address">
                        <h2 class="small-title">Créer un document</h2>
                        <form class="tooltip-end-top" id="docForm">
                            <div class="card mb-5">
                                <div class="card-body">
                                    <p class="text-alternate mb-4">
                                        Veuillez indiquer les informations
                                    </p>
                                    <div class="row g-12">
                                        <div class="col-md-12">
                                            <label class="mb-3 top-label">
                                                <input class="form-control" name="titre" id="titre"/>
                                                <span>Titre</span>
                                            </label>
                                        </div>
                                        <div class="col-md-12">
                                            <section class="scroll-section" id="quillStandart">
                                               <h2 class="small-title">Description</h2>
                                               <div class="card mb-5">
                                                   <div class="card-body editor-container">
                                                       <div class="html-editor sh-19" id="quillEditor"></div>
                                                   </div>
                                                </div> 

                                                <!-- <label class="mb-3 top-label">
                                                    <input class="form-control" name="description" id="description"/>
                                                    <span>Description</span>
                                                </label> -->

                                                <div class="col-md-12">
                                                    <label class="mb-3 top-label">
                                                                <div class="signature" id="singleSignature">
                                                                    <div id="signatureSet">
                                                                        <div id="dd_signaturePadWrapper"></div>
                                                                    </div>
                                                                    <div id="img" style="display:none;">
                                                                        <canvas id='blank' style='display:none;'></canvas>
                                                                    </div>
                                                                </div>

                                                        <span>Signer le document</span>
                                                    </label>
                                                </div>
                                            </section>
                                        </div>
                                    </div>

                                  <!--  <div class="row g-12">
                                        <div class="col-md-12">
                                            <label for="inputPassword4" class="form-label">PAYS</label>
                                            <select id="selectBasic" class="form-control" name="calecatenum" required>
                                                <?php //echo CaleCateSelect($reqCaleAffich['calendrier_categorie_calecatenum'],$ConnexionBdd,"ajou"); ?>
                                            </select>
                                        </div>

                                    </div>-->
                                    <section class="scroll-section" id="signatureDoc">

                                    </section>
                                </div>




                                <div class="card-footer border-0 pt-0 d-flex justify-content-end align-items-center">


                                    <br>
                                    <div class="card-footer border-0 pt-0 d-flex justify-content-end align-items-center">
                                        <div>
                                            <button class="btn btn-icon btn-icon-end btn-primary" type="submit" id="ajoutDoc">
                                                <span>Je m'inscris</span>
                                                <i data-acorn-icon="chevron-right"></i>
                                            </button>
                                        </div>
                                    </div>

                                </div>





                        </form>
                    </section>

<p id="success" style="display: none;">ajouté avec succés</p>
                </div></div></div></main>
</div>



<script>


</script>

<?php
include $Dossier."footer.php";
?>
