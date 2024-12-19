
    <header class="header">
        <div class="headerContent d-flex">
            <div class="logo">
                <img src="public/img/logo-erwin.png" alt="" width="150px" heigh="50px">
            </div>
            <div class="center">
                <div class="scroller">
                    <ul class="menu list-unstyled">
                        <a href="index.php?ctrl=publication&action=index"><li class="menuList"><i class="fa-solid fa-house"></i>Accueil</li></a>
                        <a href="#"><li class="menuList"><i class="fa-solid fa-message"></i>Messagerie</li></a>
                        <a href="#"><li class="menuList"><i class="fa-solid fa-bell"></i>Notifications</li></a>
                        <a href="index.php?ctrl=forum"><li class="menuList"><i class="fa-solid fa-pen-to-square"></i>Communauté</li></a>
                    </ul>
                </div>
            </div>
            <div class="burgerList">
                <button class="burger"><span class="bar"></span></button>
            </div>
            <nav class="navbar">
                <ul class="menuBurger list-unstyled">
                    <?php
                        // si l'utilisateur est connecté 
                        if(App\Session::getUser()){
                            ?>
                            <li><a href="index.php?ctrl=security&action=profile"><span class="fas fa-user"></span>&nbsp;<?= App\Session::getUser()?></a></li>
                            <li><a href="#">Paramètres</a></li>
                            <li><a href="index.php?ctrl=security&action=logout">Déconnexion</a></li>
                            <?php
                        }
                        else{
                            ?>
                            <li><a href="index.php?ctrl=security&action=login">Connexion</a></li>
                            <li><a href="index.php?ctrl=security&action=register">Inscription</a></li>
                            <!-- <a href="index.php?ctrl=forum&action=index">Liste des catégories</a>
                            <a href="index.php?ctrl=publication&action=index">Liste des publications</a> -->
                        <?php
                        }
                    ?> 
                </ul>
            </nav>
        </div>
    </header>
