<body class="connexion"> 
    <div class="grid2">
        <div class="left">
            <figure class="left-logo">
                <img src="public\img\logo erwin.png" alt="Logo SportLink">
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
    
</body>

<?php
include VIEW_DIR."template/footer.php";
?>

<!-- <div id="container">

    <div class="grid">
        <div class="grid-item" id="navMenu">
            <ul class="listNav list-unstyled">
            <?php
                // si l'utilisateur est connecté 
                if(App\Session::getUser()){
                ?>
                    <a href="index.php?ctrl=security&action=profile"><li class="listContent"><i class="fa-solid fa-user"></i><span><?= App\Session::getUser()?></span></li></a>
                <?php
                }else{
                ?>
                    <a href="#"><li class="listContent"><i class="fa-solid fa-user"></i><span>User</span></li></a>
                <?php
                }
                ?> 
                    <a href="#"><li class="listContent"><i class="fa-solid fa-user-group"></i><span>Amis</span></li></a>
                    <a href="#"><li class="listContent"><i class="fa-solid fa-bookmark"></i><span>Enregistrements</span></li></a>
                    <a href="#"><li class="listContent"><i class="fa-solid fa-calendar"></i><span>Evènements</span></li></a>
                    <a href="#"><li class="listContent"><i class="fa-solid fa-magnifying-glass"></i><span>Rechercher</span></li></a>
                    <a href="#"><li class="listContent"><i class="fa-solid fa-envelope"></i><span>Newsletters</span></li></a>
                    <li class="divider"></li>
                    <a href="#"><li class="listContent"><i class="fa-solid fa-gear"></i><span>Paramètres</span></li></a>
                <?php
                // si l'utilisateur est connecté 
                if(App\Session::getUser()){
                ?>
                    <a href="index.php?ctrl=security&action=logout"><li class="listContent"><i class="fa-solid fa-arrow-right-from-bracket"></i><span>Déconnexion</span></li></a>
                <?php
                }else{
                ?>
                    <a href="index.php?ctrl=security&action=login"><li class="listContent"><i class="fa-solid fa-right-to-bracket"></i><span>Connexion</span></li></a>
                <?php
                }
                ?> 
            </ul>
        </div>
        <div class="grid-item" id="publication">
            <div class="publicationContent">
                <div class="publicationList">
                    <figure>
                        <img src="public/img/R.jpg" alt="image utilisateur">
                    </figure>
                    <button class="writeSomething"><a href="#"></a>Publier quelque chose !</button>
                </div>
                <div class="divider2"></div>
                <div class="publicationIcone">
                    <div class="icone">
                        <i class="fa-regular fa-image"></i>
                        <p>Image</p>
                    </div>
                    <div class="icone">
                        <i class="fa-solid fa-video"></i>
                        <p>Vidéo</p>
                    </div>
                    <div class="icone">
                        <i class="fa-regular fa-face-smile-beam"></i>
                        <p>Humeur</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid-item " id="card">
            <div class="card1">
                <h2>Sujets Récent</h2>
            </div>
            <div class="card2">
            <h2>Amis en ligne</h2> 
            </div>
        </div>
    </div>
</div> -->
