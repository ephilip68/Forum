<?php
    $favorites = $result["data"]["favorites"];
    
    include VIEW_DIR."template/nav.php";
?>

<h3>Liste d'Enregistrements</h3>


<?php foreach($favorites as $favoris) { ?>

    <div class="album-home box-box">
        <div class="status-main-content">
            <div class="status-main-home">
                <img src="public/upload/<?=$favoris->getPublication()->getUser()->getAvatar()?>" class="status-img"/>
                <div class="album-detail-home">
                    <div class="album-title-home"><a href="index.php?ctrl=security&action=profile&id=<?=$favoris->getPublication()->getUser()->getId()?>"><?=ucfirst($favoris->getPublication()->getUser()->getNickName())?></a></div>
                    <div class="album-date-home"><?=$favoris->getPublication()->getPublicationDate()?></div>
                </div>
                <div class="home-option">
                    <button type="button" class="options-btn"><i class="fa-solid fa-ellipsis"></i></button>
                    <a href="index.php?ctrl=publication&action=deletePublication&id=<?= $favoris->getPublication()->getId() ?> "><i class="fa-solid fa-xmark home-close"></i></a>
                </div>
                <div class="options-menu" id="optionsMenu">
                    <div class="arrow"></div>
                    <ul>
                        <li><a href="#">Signaler la publication</a></li>
                        <li><a href="index.php?ctrl=publication&action=deleteFavorites&id=<?= $favoris->getPublication()->getId() ?>"><i class="fa-solid fa-bookmark"></i>Supprimer des enregistrements</a></li>
                    </ul>
                </div>
            </div>
            <div class="album-content-home">
                <p><?=ucfirst($favoris->getPublication()->getContent())?></p>
            </div>
            <div class="album-photos-home">
                <img src="public/upload/<?=$favoris->getPublication()->getPhoto()?>" alt="" class="album-photo-home"/>
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