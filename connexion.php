<?php
$Dossier = "";
include $Dossier."header.php";

if(!empty($_SESSION['authconnauthnum']))
  {
    echo '<SCRIPT LANGUAGE = "javascript"> window.location.replace("'.$Dossier.'index.php") </SCRIPT>';
    exit;
  }
?>
  <body class="h-100">
    <div id="root" class="h-100">
      <!-- Background Start -->
      <div class="fixed-background"></div>
      <!-- Background End -->

      <div class="container-fluid p-0 h-100 position-relative">
        <div class="row g-0 h-100">
          <!-- Left Side Start -->
          <div class="offset-0 col-12 d-none d-lg-flex offset-md-1 col-lg h-lg-100">
            <div class="min-h-100 d-flex align-items-center">
              <div class="w-100 w-lg-75 w-xxl-50">
                <div>
                  <div class="mb-5">
                    <h1 class="display-3 text-white">Avec Equimondo</h1>
                    <!--<h1 class="display-3 text-white">Ready for Your Project</h1>-->
                  </div>
                  <p class="h6 text-white lh-1-5 mb-5">
                    Moins de temps dans vos bureaux, plus de temps pour vos chevaux
                  </p>
                  <div class="mb-5">
                    <a class="btn btn-lg btn-outline-white" href="index.html">En savoir plus</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- Left Side End -->

          <!-- Right Side Start -->
          <div class="col-12 col-lg-auto h-100 pb-4 px-4 pt-0 p-lg-0">
            <div class="sw-lg-70 min-h-100 bg-foreground d-flex justify-content-center align-items-center shadow-deep py-5 full-page-content-right-border">
              <div class="sw-lg-50 px-5">
                <div class="sh-11">
                  <a href="index.html">
                    <div class="logo-default"></div>
                  </a>
                </div>
                <div class="mb-5">
                  <h2 class="cta-1 mb-0 text-primary">Bienvenue</h2>
                  <h2 class="cta-1 text-primary">Dans votre espace</h2>
                </div>
                <div class="mb-5">
                  <p class="h6">Veuillez entrer vos identifiants</p>
                  <p class="h6">
                    Si vous n'avez pas d'identifiants
                    <a href="Pages.Authentication.Register.html">Enregistrez vous ici</a>
                    .
                  </p>
                </div>
                <script>

                </script>
                <div>
                  <!--<form id="loginForm" class="tooltip-end-bottom" novalidate>-->
                    <form id='ConnexionEquimondo' action=''>
                    <div class="mb-3 filled form-group tooltip-end-top">
                      <i data-acorn-icon="email"></i>
                      <input class="form-control" placeholder="Nom d'utilisateur" name="login" required/>
                    </div>
                    <div class="mb-3 filled form-group tooltip-end-top">
                      <i data-acorn-icon="lock-off"></i>
                      <input class="form-control pe-7" name="mdp" type="password" placeholder="Mot de passe" required/>
                      <a class="text-small position-absolute t-3 e-3" href="Pages.Authentication.ForgotPassword.html">Mot de passe oublié ?</a>
                    </div>
                    <div class="mb-3 position-relative form-group">
                      <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="registerCheck" name="souvenir" checked/>
                        <label class="form-check-label" for="registerCheck">
                          Se souvenir de moi
                        </label>
                      </div>
                    </div>
                    <div id="noteConnexionEquimondo"></div>
                    <button type="submit" class="btn btn-lg btn-primary">Connexion</button>
                  </form>
                </div>
              </div>
            </div>
          </div>
          <!-- Right Side End -->
        </div>
      </div>
    </div>

<?php
include $Dossier."footer.php";
?>
