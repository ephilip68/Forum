<?php
    $user = $result["data"]["user"];
    $friends = $result["data"]["friends"];
    $friendByusers = $result["data"]["friendByusers"];
    $publications = $result["data"]["publications"];
    $isFollowing = $result["data"]["isFollowing"];
    $following = $result["data"]["following"];
    $followers = $result["data"]["followers"];
    $events = $result["data"]["events"];

    include VIEW_DIR."template/nav.php";
?>

<div class="container-home" >
    <div class="left-side-content">
        <div class="left-side-event">
            <div class="side-wrapper">
                <ul class="listNavEvent list-unstyled">
                    <div class="navEvent">
                        <h2 style="font-weight:700">Ami(e)s</h2>
                        <a href="index.php?ctrl=publication&action=listAmis"><li class="listContent"><i class="fa-solid fa-user-group"></i><span>Accueil</span></li></a>
                        <li class="listContent"><i class="fa-solid fa-user"></i></i><span>Liste d'ami(e)s</span>
                        <a href="index.php?ctrl=publication&action=listAmis" class="toggle-friends" data="<?= App\Session::getUser()->getId() ?>">
                            <?php if (isset($_GET['id_user']) && $_GET['id_user'] == App\Session::getUser()->getId()) { ?>
                                <i class="fa-solid fa-chevron-up"></i>
                            <?php } else { ?>
                                <i class="fa-solid fa-chevron-down"></i> 
                            <?php } ?>
                        </a>
                        <div class="friends" data="<?= App\Session::getUser()->getId() ?>" style="display: <?= isset($_GET['id_user']) && $_GET['id_user'] == App\Session::getUser()->getId() ? 'block' : 'none' ?>;">
                            <?php foreach($friends as $friend) { ?>
                                <div class="profilFriends">
                                    <img src="public/upload/<?=$friend->getAvatar()?>" class="status-img-nav"/>
                                    <a href="index.php?ctrl=publication&action=listProfils&id=<?= $friend->getId() ?>"><?= ucfirst($friend->getNickName()) ?></a>
                                    <i class="fa-solid fa-ellipsis"></i>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="footerHome">
                        <a class="" href="#">A Propos</a> - 
                        <a class="" href="#">Règlement du forum</a> -  
                        <a class="" href="#">Mentions légales</a>  
                        -<small>&copy; <?= date_create("now")->format("Y") ?></small>
                    </div>
                </ul>   
            </div>
        </div>
    </div>
    <div class="main-profil">
        <div class="main-container">
            <div class="profile">
                <div class="profile-avatar">
                    <?php if (!empty($user->getAvatar())){ ?>
                        <img src="public/upload/<?=$user->getAvatar()?>" alt="photo de profil" class="profile-img">
                    <?php }else{ ?>
                        <img src="public/upload/default-avatar.webp" alt="photo de profil par défaut" class="profile-img">
                    <?php } ?>      
                    <a href="#modal-avatar" uk-toggle ><i class="fa-solid fa-camera"></i></a>
                    <div class="profile-name"><?=ucfirst($user->getNickName())?></div>
                    <div class="containerPublication"> 
                
                        <!-- Modal -->
                        <div id="modal-avatar" uk-modal>
                            <div class="uk-modal-dialog uk-modal-body">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h3 class="modal-title">Ajouter une photo de profil</h3>
                                        <hr>
                                        <a class="btn-close uk-modal-close close-close" ><i class="fa-solid fa-xmark"></i></a>
                                    </div>
                                    <div class="modal-body">
                                        <form action="index.php?ctrl=security&action=addPhoto" method="post" enctype="multipart/form-data">
                                            <div class="modal-comment">
                                                <div class="modal-Form">
                                                    <div uk-form-custom >
                                                        <input type="file" name="photo" id="fileUpload" data-target="image-2">
                                                        <div class="js-upload uk-placeholder uk-text-center">
                                                            <span uk-icon="icon: cloud-upload"></span>
                                                            <span class="uk-text-middle">Ajouter votre photo</span>
                                                            <span class="link">ou faites glisser-déposer</span>
                                                            <img src="#" alt="" class="image-2" style="margin-top: 20px;">
                                                        </div>
                                                    </div> 
                                                </div>
                                            </div>
                                            <br/>
                                            <input type="submit" name="submit" value="Publier">
                                            <p><strong>Note:</strong> Seuls les formats .jpg, .jpeg, .jpeg, .gif, .png, .webp sont autorisés jusqu'à une taille maximale de 5 Mo.</p>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <img src="public/img/37236783-ai-generato-beautuful-sportivo-sfondo-con-copia-spazio-gratuito-foto.jpg" alt="" class="profile-cover">
                
                <div class="profile-menu">
                    <div class="followers">
                        <?php if ($_GET['id']){ ?>

                            <a><?= $following. " ". "Abonnement"?><?= $following > 1 ? "s" : "" ?></a>
                            <a><?= $followers. " ". "Abonné"?><?= $followers > 1 ? "s" : "" ?></a>

                        <?php } ?>
                    </div>
                    <div class="profile-menu-content">

                        <?php if($isFollowing) { ?>

                            <a class="profile-menu-suivi" href="index.php?ctrl=follow&action=deleteFollowing&id=<?=$friend->getId()?>">Suivi(e)</a>

                        <?php }else{ ?>

                            <a class="profile-menu-suivre" href="index.php?ctrl=follow&action=addFollow&id=<?=$friend->getId()?>">Suivre</a>

                        <?php } ?>
                    </div> 
                </div>
            </div>
            <div class="timeline">
                <div class="timeline-left">
                    <div class="intro box">
                        <div class="intro-title">
                            Informations
                        </div>
                        <div class="info">
                            <div class="info-item">
                                <span uk-icon="icon: social"></span>
                                Inscrit le 
                                <a href="#"><?=$user->getFormattedDateInscription()?></a>
                            </div>
                            <div class="info-item">
                                <span uk-icon="icon: mail"></span>
                                Email 
                                <a href="#"><?=ucfirst($user->getEmail())?></a> 
                            </div>
                        </div>
                    </div>
                    <?php if(!empty($events)) { ?>
                        <?php foreach($events as $event) { ?>
                            <div class="event box mySlides">
                                <div class="eventPhoto ">
                                    <img src="public/upload/<?=$event->getPhoto()?>"/>
                                    <button type="button" class="options-btn-event"><span uk-icon="icon: more"></span></button>
                                    <div class="options-menu-profil" id="optionsMenu">
                                        <ul>
                                            <?php if(App\Session::getUser()->getId() == $event->getUser()->getId()) { ?>
                                                <li><a href="index.php?ctrl=publication&action=addFavorites&id=<?= $event->getId() ?>"><span uk-icon="icon: bookmark"></span>Enregistrer cet évènement</a></li>
                                                <li><a href="index.php?ctrl=event&action=deleteEvent&id=<?= $event->getId() ?>"><span uk-icon="icon: close"></span>Supprimer cet évènement</a></li>
                                                <li><a href="#"><span uk-icon="icon: warning"></span>Signaler cet évènement</a></li>
                                            <?php }else{ ?>
                                                    <li><a href="index.php?ctrl=publication&action=addFavorites&id=<?= $event->getId() ?>"><span uk-icon="icon: bookmark"></span>Enregistrer cet évènement</a></li>
                                                    <li><a href="#"><span uk-icon="icon: warning"></span>Signaler cet évènement</a></li>
                                            <?php } ?>
                                        </ul>
                                    </div>
                                    <div class="eventList">
                                        <div class="eventInfo">
                                            <p class="eventDate"><?= $event->getFormattedDate() ?> à <?= $event->getEventHours() ?></p>
                                            <p class="eventTitle"><?= ucfirst($event->getTitle()) ?> | <?= ucfirst($event->getText()) ?></p>
                                            <p class="eventSide"><?= ucfirst($event->getCity()) ?>, <?= ucfirst($event->getCountry()) ?></p>
                                        </div>  
                                    </div>
                                    <div class="eventButton">
                                        <div class="eventBtn">
                                        
                                            <button class="btnInteresse"><i class="fa-regular fa-star"></i>Ça m'intéresse</button>
                                            <button class="btnShareEvent"><i class="fa-solid fa-share"></i></button>
                                        </div>
                                    </div>
                                </div>
                                    <button class="w3-button w3-display-left w3-black " id="left-arrow" onclick="plusDivs(-1)">&#10094;</button>
                                    <button class="w3-button w3-display-right w3-black" id="right-arrow" onclick="plusDivs(1)">&#10095;</button>
                                </div>
                        <?php } ?>
                    <?php }else{ ?>
                        <div class="event box mySlides">
                            <p class="noEvent">Pas d'évènement disponible</p>
                        </div>
                    <?php } ?>
                    <div class="pages box">
                        <div class="intro-title">
                            Amis
                        </div>
                        <?php if(!empty($friendByusers)) {?>
                            <?php foreach($friendByusers as $friendByuser) { ?>                          
                                <div class="profilFriends">
                                    <?php if($friendByuser->getId() == App\Session::getUser()->getId()) { ?> 

                                    <?php }else{ ?>
                                        <img src="public/upload/<?= $friendByuser->getAvatar() ?>" class="status-img"/>                                    
                                        <a href="index.php?ctrl=security&action=profile&id=<?= $friendByuser->getId() ?>"><?= ucfirst($friendByuser->getNickName()) ?></a> 
                                    <?php } ?>
                                </div> 
                            <?php } ?>
                        <?php }else{ ?>
                            <div class="intro-title-friend">
                                Aucun Amis !
                            </div>
                        <?php } ?>
                    </div>
                </div>
                <div class="timeline-right">
                    <?php if(App\Session::getUser()->getId() == $_GET['id']) { ?>
                        <div class="status box-publication">
                            <!-- <div class="status-main"> -->
                                <div class="publicationList">
                                    <img src="public/upload/<?=App\Session::getUser()->getAvatar()?>" class="status-img"/>
                                    <button class="writeSomething" type="button" uk-toggle="target: #modal-publication-profil"><a href="#"></a>Publier quelque chose !</button>
                                </div>
                            <!-- </div> -->
                            <div class="divider2"></div>
                            <div class="publicationIcone">
                                <div class="icone">
                                    <i class="fa-regular fa-image"></i>
                                    <a href="#">Image</a> 
                                </div>
                                <div class="icone">
                                    <i class="fa-solid fa-video"></i>
                                    <a href="#">Vidéo</a> 
                                </div>
                                <div class="icone">
                                    <i class="fa-regular fa-face-smile-beam"></i>
                                    <a href="#">Humeur</a> 
                                </div>
                            </div>
                        </div>
                    <?php }else{ ?>

                    <?php } ?>
                
                    <!-- Modal -->
                    <div id="modal-publication-profil" uk-modal>
                        <div class="uk-modal-dialog uk-modal-body">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h3 class="modal-title">Créer une publication</h3>
                                    <hr>
                                    <a class="btn-close uk-modal-close close-close" ><i class="fa-solid fa-xmark"></i></a>
                                </div>
                                <div class="modal-body">
                                    <form action="index.php?ctrl=publication&action=addPublication" method="post" enctype="multipart/form-data">
                                        <div class="modal-comment">
                                            <div class="modal-Form">
                                                <input id="content" name="content" placeholder="Publier quelque chose !">
                                                <div uk-form-custom >
                                                    <input type="file" name="photo" id="fileUpload" data-target="image-3">
                                                    <div class="js-upload uk-placeholder uk-text-center">
                                                        <span uk-icon="icon: cloud-upload"></span>
                                                        <span class="uk-text-middle">Ajouter des photos/vidéos</span>
                                                        <span class="link">ou faites glisser-déposer</span>
                                                        <img src="#" alt="" class="image-3" style="margin-top: 20px;">
                                                    </div>
                                                </div> 
                                            </div>
                                        </div>
                                        <br/>
                                        <input class="status-share" type="submit" name="submit" value="Publier">
                                        <p><strong>Note:</strong> Seuls les formats .jpg, .jpeg, .jpeg, .gif, .png, .webp sont autorisés jusqu'à une taille maximale de 5 Mo.</p>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <?php if(!empty($publications)){ ?>
                    <?php foreach($publications as $publication){ ?>
                        <div class="album-home box-publication">
                            <div class="status-main-content">
                                <div class="status-main-home">
                                    <img src="public/upload/<?=$publication->getUser()->getAvatar()?>" class="status-img"/>
                                    <div class="album-details">
                                        <div class="album-titles"><a href="index.php?ctrl=security&action=profile&id=<?=$publication->getUser()->getId()?>"><?=ucfirst($publication->getUser()->getNickName())?></a></div>
                                        <div class="album-dates"><?=$publication->getFormattedPublicationDate()?></div>
                                    </div>
                                    <div class="home-option">
                                        <?php if(App\Session::getUser()->getId() == $publication->getUser()->getId()) { ?>
                                            <button type="button" class="options-btn"><span uk-icon="icon: more"></span></button>
                                            <a href="index.php?ctrl=publication&action=deletePublication&id=<?= $publication->getId() ?> "><i class="fa-solid fa-xmark home-close"></i></a>
                                        <?php }else{ ?>
                                            <button type="button" class="options-btn"><span uk-icon="icon: more"></span></button>
                                        <?php } ?>
                                    </div>
                                    <div class="options-menu" id="optionsMenu">
                                        <div class="arrow"></div>
                                        <ul>
                                            <li><a href="index.php?ctrl=publication&action=addFavorites&id=<?= $publication->getId() ?>"><span uk-icon="icon: bookmark"></span>Enregistrer la publication</a></li>
                                            <li><a href="#"><span uk-icon="icon: warning"></span>Signaler la publication</a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="album-content-home">
                                    <p><?=ucfirst($publication->getContent())?></p>
                                </div>
                                <div class="album-photos-home">
                                    <img src="public/upload/<?=$publication->getPhoto()?>" alt="" class="album-photo-home"/>
                                </div>
                                <div class="album-actions-home">
                                    <div class="action-reaction">
                                        <a href=""><i class="fa-solid fa-heart" style="color:red"></i></a>
                                        <div class="action-number">
                                            <span>Commentaire</span>
                                            <span>Partage</span>
                                        </div>
                                    </div>
                                    <div class="divider-home"></div>
                                    <div class="action-reactions">
                                        <a href="#"><i class="fa-regular fa-heart"></i>J'aime</a>
                                        <a href="#"><i class="fa-regular fa-comment"></i>Commenter</a>
                                        <a href="#"><i class="fa-solid fa-share"></i>Republier</a>
                                    </div>    
                                </div>    
                            </div>
                        </div>
                    <?php } ?>
                    <?php }elseif(App\Session::getUser()->getId() == $_GET['id']){ ?>
                        <p class="intro-title">Vous n'avez aucune publication pour le moment !</p>
                        <?php }else{ ?>

                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    var slideIndex = 1;
    showDivs(slideIndex);

    function plusDivs(n) {
        showDivs(slideIndex += n);
    }

    function showDivs(n) {
        var i;
        var x = document.getElementsByClassName("mySlides");
        if (n > x.length) {slideIndex = 1}
        if (n < 1) {slideIndex = x.length}
        for (i = 0; i < x.length; i++) {
            x[i].style.display = "none";  
        }
        x[slideIndex-1].style.display = "block";  
    }

    // Récupérer tous les boutons d'options et les menus associés
    const optionsBtns = document.querySelectorAll('.options-btn-event');
    const optionsMenus = document.querySelectorAll('.options-menu-profil'); 

    // Ajouter un événement à chaque bouton
    optionsBtns.forEach((btn, index) => {
        const menu = optionsMenus[index]; 
        
        // Ajouter l'événement au clic sur le bouton
        btn.addEventListener('click', function(event) {
            // Empêcher la propagation du clic pour éviter de fermer le menu immédiatement
            event.stopPropagation();
            
            // Alterner la visibilité du menu
            menu.style.display = menu.style.display === 'block' ? 'none' : 'block';
        });
    });

    // Fermer le menu si on clique ailleurs sur la page
    document.addEventListener('click', function(event) {
        optionsMenus.forEach(menu => {
            if (!menu.contains(event.target) && !optionsBtns.some(btn => btn.contains(event.target))) {
                menu.style.display = 'none';
            }
        });
    });

    // Récupérer tous les boutons d'options et les menus associés
    const optionsButtons = document.querySelectorAll('.options-btn');
    const optionsShows = document.querySelectorAll('.options-menu'); 

    // Ajouter un événement à chaque bouton
    optionsButtons.forEach((btn, index) => {
        const menu = optionsShows[index]; 
        
        // Ajouter l'événement au clic sur le bouton
        btn.addEventListener('click', function(event) {
            // Empêcher la propagation du clic pour éviter de fermer le menu immédiatement
            event.stopPropagation();
            
            // Alterner la visibilité du menu
            menu.style.display = menu.style.display === 'block' ? 'none' : 'block';
        });
    });

    // Fermer le menu si on clique ailleurs sur la page
    document.addEventListener('click', function(event) {
        optionsShows.forEach(menu => {
            if (!menu.contains(event.target) && !optionsButtons.some(btn => btn.contains(event.target))) {
                menu.style.display = 'none';
            }
        });
    });

    document.addEventListener('DOMContentLoaded', function () {
    // Récupére tous les liens de "toggle-friends" pour la gestion des amis
    var toggleFriendsLinks = document.querySelectorAll('.toggle-friends');

    toggleFriendsLinks.forEach(function(link) {
        // Ajout d'un événement de clic pour chaque lien d'affichage des amis
        link.addEventListener('click', function(e) {
            e.preventDefault();  // Empêche le comportement par défaut (rechargement de la page)

            var userId = link.getAttribute('data');  // Récupére l'ID de l'utilisateur
            var friendsList = document.querySelector('.friends[data="' + userId + '"]');  // Sélectionne la liste des amis par ID
            var chevronIcon = link.querySelector('i');  // L'icône du chevron

            // Vérifie si la liste des amis est déjà visible
            if (friendsList.style.display === 'none' || friendsList.style.display === '') {
                // Affiche la liste des amis et change l'icône du chevron
                friendsList.style.display = 'block';
                chevronIcon.classList.remove('fa-chevron-down');
                chevronIcon.classList.add('fa-chevron-up');
                // Sauvegarde l'état ouvert dans localStorage
                localStorage.setItem('friendsVisible_' + userId, 'true');
            } else {
                // Masque la liste des amis et changer l'icône du chevron
                friendsList.style.display = 'none';
                chevronIcon.classList.remove('fa-chevron-up');
                chevronIcon.classList.add('fa-chevron-down');
                // Sauvegarde l'état fermé dans localStorage
                localStorage.setItem('friendsVisible_' + userId, 'false');
            }
        });

        // Vérifie l'état de chaque liste d'amis au chargement de la page
        var userId = link.getAttribute('data');
        var friendsList = document.querySelector('.friends[data="' + userId + '"]');
        var chevronIcon = link.querySelector('i');

        // Récupére l'état sauvegardé de la liste des amis pour cet utilisateur
        var isVisible = localStorage.getItem('friendsVisible_' + userId);

        if (isVisible === 'true') {
            // Afficher la liste des amis et mettre l'icône en haut
            friendsList.style.display = 'block';
            chevronIcon.classList.remove('fa-chevron-down');
            chevronIcon.classList.add('fa-chevron-up');
        } else {
            // Masquer la liste des amis et mettre l'icône en bas
            friendsList.style.display = 'none';
            chevronIcon.classList.remove('fa-chevron-up');
            chevronIcon.classList.add('fa-chevron-down');
        }
    });
});
</script>  

