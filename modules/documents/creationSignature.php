<?php
$Dossier = "../../";
include $Dossier."header.php";
include $Dossier."modules/divers/MenuThemes.php";
$doc =  $_GET['doc']; 
$client =   $_GET['client']; 
 $cheval =  $_GET['cheval']; 
// $token =  $_GET['token']; 

echo $client;

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

    jQuery(document).ready(function ($) {
        $('#ajoutDoc').on('click', function() {
            $("#ajoutDoc").attr("disabled", "disabled");
            var canvas=document.getElementById("dd_canvas");
           var doc = $('#doc').html();
           var chev = $('#cheval').html();
           var cli = $('#client').html();
           console.log(doc)
            var dataUrl=canvas.toDataURL();
          
            if(dataUrl !=""){
                $.ajax({
                    url: "ajouSignature.php",
                    type: "POST",
                    data: {
                        
                        signature:dataUrl,
                       client:cli,
                       cheval: chev,
                       doc: doc,
                    },
                    cache: false,
                    success: function(dataResult){
                        var dataResult = JSON.parse(dataResult);
                        if(dataResult.statusCode==200){
                            $("#ajoutDoc").removeAttr("disabled");
                            alert('success');
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
    });

</script>

<div id="root">
    <main><div class="container"><div class="row"><div class="col">

                    <section class="scroll-section" id="address">
                        <h2 class="small-title">Créer un document</h2>
                        <form class="tooltip-end-top" id="docForm">
                            <div class="card mb-5">
                                <div class="card-body">
                                    <div style="visibility:hidden">
                                    <span id="client"><?php echo $client; ?></span>
                                    <span id="cheval"><?php echo $cheval; ?></span>
                                    <span id="doc"><?php echo $doc; ?></span>

</div>
                                        <div class="col-md-12">
                                            <section class="scroll-section" >
                                                <div class="col-md-12">
                                                    <label class="mb-3 top-label">
                                                                <div class="signature" id="singleSignature">
                                                                    <div id="signatureSet">
                                                                        <div id="dd_signaturePadWrapper"></div>
                                                                    </div>
                                                                    
                                                                </div>

                                                        <span>Signer le document</span>
                                                    </label>
                                                </div>
                                            </section>
                                        </div>
                                    </div>

                            
                                </div>




                                <div class="card-footer border-0 pt-0 d-flex justify-content-end align-items-center">


                                    <br>
                                    <div class="card-footer border-0 pt-0 d-flex justify-content-end align-items-center">
                                        <div>
                                            <button class="btn btn-icon btn-icon-end btn-primary" type="submit" id="ajoutDoc">
                                                <span>Je signe</span>
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
