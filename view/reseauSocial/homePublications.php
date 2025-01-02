<?php
    $publications = $result["data"]["publications"];
    
    include VIEW_DIR."template/nav.php";
?>

<div class="container-home" >
    <div class="left-side-home">
        <div class="side-wrapper-home">
            <ul class="listNav list-unstyled">
                <!-- si l'utilisateur est connecté  -->
                <?php if(App\Session::getUser()){ ?>
                    <a href="index.php?ctrl=security&action=profile&id=<?=App\Session::getUser()->getId()?>"><li class="listContent"><i><img src="public/upload/<?=App\Session::getUser()->getAvatar()?>" class="status-img-nav"/></i><span><?= ucfirst(App\Session::getUser()->getNickName())?></span></li></a>
                <?php }else{ ?>
                    <a href="#"><li class="listContent"><i class="fa-solid fa-user"></i><span>User</span></li></a>
                <?php } ?> 
                <a href="index.php?ctrl=publication&action=listAmis"><li class="listContent"><i class="fa-solid fa-user-group"></i><span>Amis</span></li></a>
                <a href="index.php?ctrl=publication&action=getFavoritesPublications"><li class="listContent"><i class="fa-solid fa-bookmark"></i><span>Enregistrements</span></li></a>
                <a href="#"><li class="listContent"><i class="fa-solid fa-calendar"></i><span>Evènements</span></li></a>
                <a href="#"><li class="listContent"><i class="fa-solid fa-magnifying-glass"></i><span>Rechercher</span></li></a>
                <a href="#"><li class="listContent"><i class="fa-solid fa-envelope"></i><span>Newsletters</span></li></a>
                <li class="divider"></li>
                <a href="#"><li class="listContent"><i class="fa-solid fa-gear"></i><span>Paramètres</span></li></a>
                <!-- si l'utilisateur est connecté  -->
                <?php if(App\Session::getUser()){ ?>
                    <a href="index.php?ctrl=security&action=logout"><li class="listContent"><i class="fa-solid fa-arrow-right-from-bracket"></i><span>Déconnexion</span></li></a>
                <?php }else{ ?>
                    <a href="index.php?ctrl=security&action=login"><li class="listContent"><i class="fa-solid fa-right-to-bracket"></i><span>Connexion</span></li></a>
                <?php } ?> 
                <div class="footerHome">
                    <a class="" href="#">A Propos</a> - 
                    <a class="" href="#">Règlement du forum</a> -  
                    <a class="" href="#">Mentions légales</a>  
                    -<small>&copy; <?= date_create("now")->format("Y") ?></small>
                </div>
            </ul>   
        </div>
    </div>

    <div class="main">
        <div class="main-container-home">
            <div class="timeline-home">
                <div class="timeline-center">
                    <div class="status box-box">
                        <!-- <div class="status-main"> -->
                            <div class="publicationList">
                                <img src="public/upload/<?=App\Session::getUser()->getAvatar()?>" class="status-img"/>
                                <button class="writeSomething" type="button" uk-toggle="target: #modal-example3"><a href="#"></a>Publier quelque chose !</button>
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
                    

                    <!-- Modal -->
                    <div id="modal-example3" uk-modal>
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
                                                    <input type="file" name="photo" id="fileUpload" onchange="previewPicture(this)">
                                                    <div class="js-upload uk-placeholder uk-text-center">
                                                        <span uk-icon="icon: cloud-upload"></span>
                                                        <span class="uk-text-middle">Ajouter des photos/vidéos</span>
                                                        <span class="link">ou faites glisser-déposer</span>
                                                        <img src="#" alt="" id="image" style="margin-top: 20px;">
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

                    <?php foreach($publications as $publication){ ?>
                        <div class="album-home box-box">
                            <div class="status-main-content">
                                <div class="status-main-home">
                                    <img src="public/upload/<?=$publication->getUser()->getAvatar()?>" class="status-img"/>
                                    <div class="album-detail-home">
                                        <div class="album-title-home"><a href="index.php?ctrl=security&action=profile&id=<?=$publication->getUser()->getId()?>"><?=ucfirst($publication->getUser()->getNickName())?></a></div>
                                        <div class="album-date-home"><?=$publication->getPublicationDate()?></div>
                                    </div>
                                    <div class="home-option">
                                        <button type="button" class="options-btn"><i class="fa-solid fa-ellipsis"></i></button>
                                        <a href="index.php?ctrl=publication&action=deletePublication&id=<?= $publication->getId() ?> "><i class="fa-solid fa-xmark home-close"></i></a>
                                    </div>
                                    <div class="options-menu" id="optionsMenu">
                                        <div class="arrow"></div>
                                        <ul>
                                            <li><a href="#">Signaler la publication</a></li>
                                            <li><a href="index.php?ctrl=publication&action=addFavorites&id=<?= $publication->getId() ?>"><i class="fa-solid fa-bookmark"></i>Enregistrer la publication</a></li>
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
<script>
    // Récupérer tous les boutons d'options et les menus associés
    const optionsBtns = document.querySelectorAll('.options-btn');
    const optionsMenus = document.querySelectorAll('.options-menu'); 

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
</script>







  