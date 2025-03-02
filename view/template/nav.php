
    <header class="header">
        <div class="headerContent d-flex">
            <div class="logoPage">
                <img src="public/img/logo-erwin.png" alt="" width="150px" heigh="50px">
            </div>
            <div class="center">
                <div class="scroller">
                    <ul class="menu list-unstyled">
                        <a href="index.php?ctrl=publication&action=index"><li class="menuList"><i class="fa-solid fa-house"><span>Accueil</span></i></li></a>
                        <a href="index.php?ctrl=message&action=index"><li class="menuList"><i class="fa-solid fa-message"><span>Messagerie</span></i></li></a>
                        <a href="#"><li class="menuList"><i class="fa-solid fa-bell"><span>Notifications</span></i></li></a>
                        <a href="index.php?ctrl=forum"><li class="menuList"><i class="fa-solid fa-pen-to-square"><span>Communauté</span></i></li></a>
                    </ul>
                </div>
            </div>
            <div class="burgerList">
                <button class="uk-button burger " uk-tooltip="title: Compte; pos: bottom"><span class="bar"></span></button>
            </div>
            <nav class="navbar">
                <ul class="menuBurger list-unstyled">
                    <!-- si l'utilisateur est connecté  -->
                    <?php if(App\Session::getUser()) { ?>
                        <a href="index.php?ctrl=security&action=profile&id=<?=App\Session::getUser()->getId()?>"><i><img src="public/upload/<?=App\Session::getUser()->getAvatar()?>" class="status-img-nav"/></i><?= ucfirst(App\Session::getUser()->getNickName())?></a>
                        <?php if(App\Session::isAdmin()){ ?>
                            <a href="index.php?ctrl=admin&action=users"><i class="fa-solid fa-user"></i>Dashboard</a>
                        <?php } ?>
                        <a href="index.php?ctrl=publication&action=index"><i class="fa-solid fa-house"></i>Accueil</a>
                        <a href="index.php?ctrl=message&action=index"><i class="fa-solid fa-message"></i>Messagerie</a>
                        <a href="#"><i class="fa-solid fa-bell"></i>Notifications</a>
                        <a href="index.php?ctrl=forum"><i class="fa-solid fa-pen-to-square"></i>Communauté</a>
                        <a href="index.php?ctrl=publication&action=listAmis"><i class="fa-solid fa-user-group"></i>Amis</a>
                        <a href="index.php?ctrl=publication&action=getFavoritesPublications"><i class="fa-solid fa-bookmark"></i>Enregistrements</a>
                        <a href="index.php?ctrl=event&action=index"><i class="fa-solid fa-calendar"></i>Evènements</a>
                        <a href="#modal-search" uk-toggle><i class="fa-solid fa-magnifying-glass"></i>Rechercher</a>
                        <a href="index.php?ctrl=newsletter&action=index"><i class="fa-solid fa-envelope"></i>Newsletters</a>
                        <a href="#"><i class="fa-solid fa-gear"></i>Paramètres</a>
                        <!-- si l'utilisateur est connecté  -->
                        <?php if(App\Session::getUser()){ ?>
                            <a href="index.php?ctrl=security&action=logout"><i class="fa-solid fa-arrow-right-from-bracket"></i>Déconnexion</a>
                        <?php }else{ ?>
                            <a href="index.php?ctrl=security&action=login"><i class="fa-solid fa-right-to-bracket"></i>Connexion</a>
                        <?php } ?> 
                        <?php }else{ ?>
                            <li><a href="index.php?ctrl=security&action=login">Connexion</a></li>
                            <li><a href="index.php?ctrl=security&action=register">Inscription</a></li>
                            <!-- <a href="index.php?ctrl=forum&action=index">Liste des catégories</a>
                            <a href="index.php?ctrl=publication&action=index">Liste des publications</a> -->
                    <?php } ?> 
                </ul>
            </nav>
        </div>
    </header>
