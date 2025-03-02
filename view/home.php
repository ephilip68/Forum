<body class="connexion">
    <div class="alert">
        <!-- c'est ici que les messages (erreur ou succès) s'affichent-->
        <?php 
            $successMessage = App\Session::getFlash("success");
            $errorMessage = App\Session::getFlash("error");
            if($successMessage) { ?>
            <div class="uk-alert-primary message" uk-alert>
                <a href class="uk-alert-close" uk-close></a>
                <p><?= $successMessage ?></p>
            </div>
        <?php }elseif($errorMessage){ ?>
            <div class="uk-alert-danger message" uk-alert>
                <a href class="uk-alert-close" uk-close></a>
                <p><?= $errorMessage ?></p>
            </div>
        <?php }else{ ?>
        <?php } ?>
    </div> 
    <div class="grid2">
        <div class="left">
            <figure class="left-logo">
                <img src="public\img\logo (2).png" alt="Logo SportLink">
            </figure>
        </div>
        <div class="right">
            <div class="welcomeTitle">
                <h1>Bienvenue sur SportLink !</h1>
                <p>Le réseau social des sportifs</p>
            </div>

            <div class="titleInscription">
                <h3>Inscrivez-vous.</h3>
            </div>

            <button class="btnInscription">
                <a class="googleConnect" href="google-oauth.php">
                    <img src="public/img/google.png" alt="logo google">
                    S'inscrire avec Google  
                </a>
            </button>

            <div class="separation2">
                <div class="divider5"></div>
                <span>OU</span>
                <div class="divider6"></div>
            </div>

            <form action="" class="formInscription">
                
                <a href="#modal-example" uk-toggle><button class="submit2" type="button" >Créer un compte</button></a>

                <div class="titleInscription">
                    <h4>Vous avez déja un compte?</h4>
                </div>

                <a href="#modal-example2" uk-toggle><button class="submit3" type="button" >Se connecter</button></a>
                
            </form> 
            
            <div id="modal-example" uk-modal>
                <div class="uk-modal-dialog uk-modal-body">
                    <a class="btn-close uk-modal-close close-close" ><i class="fa-solid fa-xmark"></i></a>
                    <div class="modalContent">
                        <div class="formBox">
                            <div class="title">
                                <div id="content"><h1>Créer votre compte</h1></div>
                            </div>
                            <form class="formulaire" action="index.php?ctrl=security&action=register" method="POST">

                                <label for="pseudo"></label>
                                <i class="fa-solid fa-user user"> </i>
                                <input class="input" type="text" name="nickName" id="pseudo" placeholder="Pseudo" required>

                                <label for="email"></label>
                                <i class="fa-solid fa-envelope envelope"></i>
                                <input class="input" type="email" name="email" id="email" placeholder="Email" required>

                                <label for="pass1"></label>
                                <i class="fa-solid fa-unlock"></i>
                                <input class="input" type="password" name="pass1" id="pass1" placeholder="Mot de passe" required>

                                <label for="pass2"></label>
                                <i class="fa-solid fa-lock"></i>
                                <input class="input" type="password" name="pass2" id="pass2" placeholder="Confirmer mot de passe" required>

                                <label class="checkbox">
                                    <input type="checkbox" name="accept_cgu" required> J'accepte les <a href="view/security/cgu.php" target="_blank"><strong>Conditions Générales d'Utilisation</strong></a>.
                                </label>

                                
                               <input class="submit" type="submit" name="submit" value="Créer votre compte">

                            </form>
                            <div class="connecter">
                                <p>Vous avez déja un compte ?</p>
                                <a href="#modal-example2" uk-toggle>Se connecter</a>
                            </div>
                        </div>
                    </div>  
                </div>
            </div>
            
            <div id="modal-example2" uk-modal>
                <div class="uk-modal-dialog uk-modal-body">
                    <a class="btn-close uk-modal-close close-close" ><i class="fa-solid fa-xmark"></i></a>
                    <div class="modalContent">
                        <div class="formBox2">
                            <div class="title">
                                <div id="content">
                                    <h1>Connectez-vous</h1>
                                </div>
                                <button class="forget">
                                    <a class="googleConnect" href="google-oauth.php">
                                        <img src="public/img/google.png" alt="logo google">
                                        Se connecter avec Google  
                                    </a>
                                </button>
                            </div>
                            <div class="separation">
                                <div class="divider3"></div>
                                <span>OU</span>
                                <div class="divider4"></div>
                            </div>

                            <form class="formulaire2" action="index.php?ctrl=security&action=login" method="POST">

                                <label for="email"></label>
                                <input class="input2" type="email" name="email" id="email" placeholder="Adresse email" required>

                                <label for="pass1"></label>
                                <input class="input2" type="password" name="password" id="pass1" placeholder="Mot de passe" required>
                                
                                <input class="submit" type="submit" name="submit" value="Se connecter">
                                
                                <div class="forget2">
                                    <a href="#">Mot de passe oublié ?</a>
                                </div>

                            </form>
                        
                            <div class="connecter">
                                <p>Vous n'avez pas de compte ?</p>
                                <a href="#modal-example" uk-toggle>Inscrivez-vous</a>
                            </div>
                        </div>
                    </div>  
                </div>
            </div>
        </div>
    </div>
    <footer>
        <div class="footer">
            <a class="reglement" href="#">Règlement du forum</a> 
            <a class="mention" href="#">Mentions légales</a>
            <small>&copy; <?= date_create("now")->format("Y") ?></small>
        </div>
    </footer> 
</body>


