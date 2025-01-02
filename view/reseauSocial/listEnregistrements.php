<?php
    $favorites = $result["data"]["favorites"];
    
    include VIEW_DIR."template/nav.php";
?>

<div class="container-home" >
    <div class="left-side-content">
        <div class="left-side-event">
            <div class="side-wrapper">
                <ul class="listNavEvent list-unstyled">
                    <div class="navEvent">
                        <a href="index.php?ctrl=security&action=profile&id=<?=App\Session::getUser()->getId()?>"><li class="listContent"><i><img src="public/upload/<?=App\Session::getUser()->getAvatar()?>" class="status-img-nav"/></i><span><?= ucfirst(App\Session::getUser()->getNickName())?></span></li></a>
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
    <div class="main-container-home">
        <div class="timeline-favorites">
            <div class="favoritesTitle"><h3>Liste des enregistrements</h3></div>
            <?php foreach($favorites as $favoris) { ?>
                <div class="timeline-center-favorites">
                    <div class="favoritesStatus">
                        <div class="favoritesPhoto">
                            <img src="public/upload/<?=$favoris->getPublication()->getPhoto()?> "/>
                        </div>
                        <div class="favoritesList">
                            <div class="favotitesInfo"> 
                                <h4><?=ucfirst($favoris->getPublication()->getContent())?></h4>
                                <div class="favoritesDescriptions">
                                    <img src="public/upload/<?=$favoris->getUser()->getAvatar()?>" class="status-img-nav"/>
                                    <p>Enregistré à partir de la <a href=""><strong>Publication de <?=ucfirst($favoris->getPublication()->getUser()->getNickName())?></strong></a></p>
                                </div>
                            </div>
                            <div class="favoritesButton">
                                <button class="btnSharefavorites"><i class="fa-solid fa-share"></i></button>
                                <button type="button" class="options-btn-favorites"><span uk-icon="icon: more"></span></button>
                            </div>
                            <div class="options-menu-favorites" id="optionsMenu">
                                <div class="arrow"></div>
                                <ul>
                                    <li><a href="index.php?ctrl=publication&action=deleteFavorites&id=<?= $favoris->getPublication()->getId() ?>"><span uk-icon="icon: close"></span>Supprimer cet enregistrement</a></li>
                                    <li><a href="#"><span uk-icon="icon: warning"></span>Signaler cette publication</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</div>


    

<script>
    // Récupérer tous les boutons d'options et les menus associés
    const optionsBtns = document.querySelectorAll('.options-btn-favorites');
    const optionsMenus = document.querySelectorAll('.options-menu-favorites'); 

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