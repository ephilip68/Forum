<?php
// session_start();

// var_dump($_SESSION);
?>

<div id="container">

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
</div>
