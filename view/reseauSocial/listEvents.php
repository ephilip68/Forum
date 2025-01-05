<?php
    $events = $result["data"]["events"];
    
    include VIEW_DIR."template/nav.php";
?>

<div class="container-home" >
    <div class="left-side-content">
        <div class="left-side-event">
            <div class="side-wrapper">
                <ul class="listNavEvent list-unstyled">
                    <div class="navEvent">
                        <a href="index.php?ctrl=security&action=profile&id=<?=App\Session::getUser()->getId()?>"><li class="listContent"><i><img src="public/upload/<?=App\Session::getUser()->getAvatar()?>" class="status-img-nav"/></i><span><?= ucfirst(App\Session::getUser()->getNickName())?></span></li></a>
                        <a href="#modal-event" uk-toggle class="newEvent"><i class="fa-solid fa-plus"></i>Créer un évnement</a>
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
    <!-- Modal -->
    <div id="modal-event" uk-modal>
        <div class="uk-modal-dialog uk-modal-body">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">Ajjouter un Evènement</h3>
                    <hr>
                    <a class="btn-close uk-modal-close close-close" ><i class="fa-solid fa-xmark"></i></a>
                </div>
                <div class="modal-body">
                    <form action="index.php?ctrl=event&action=addEvent" method="post" enctype="multipart/form-data">
                        <div uk-form-custom >
                            <input type="file" name="photo" id="fileUpload" data-target="image-5">
                            <div class="js-upload uk-placeholder uk-text-center">
                                <span uk-icon="icon: cloud-upload"></span>
                                <span class="uk-text-middle">Ajouter des photos/vidéos</span>
                                <span class="link">ou faites glisser-déposer</span>
                                <img src="#" alt="" class="image-5" style="margin-top: 20px;">
                            </div>
                        </div> 
                        <div class="modal-comment">
                            <div class="modal-Form">
                                <input id="content" name="title" placeholder="Titre de l'évènement!" required>
                                <input id="content" type="date" name="eventDate" required>
                                <input id="content" type="time" name="eventHours" required>
                                <input id="content" type="text" name="city" placeholder="lieu" required>
                                <input id="content" type="text" name="country" placeholder="Pays" required>
                                <textarea id="content" name="text" placeholder="Détail de lévènemnt"required></textarea>
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

    <div class="main-container-home">
        <div class="timeline-event">
            <div class="timeline-center-event">
                <h3>Liste des évènements à venir</h3>
                <div class="status-event">
                    <?php foreach($events as $event) { ?>
                        <div class="status-content">
                            <div class="eventPhoto">
                                <img src="public/upload/<?=$event->getPhoto()?>"/>
                                <button type="button" class="options-btn-event"><span uk-icon="icon: more"></span></button>
                                <div class="options-menu-event" id="optionsMenu">
                                    <ul>
                                        <?php if(App\Session::getUser()->getId() == $event->getUser()->getId()) { ?>
                                            <li><a href="index.php?ctrl=publication&action=addFavorites&id=<?= $event->getId() ?>"><span uk-icon="icon: bookmark"></span>Enregistrer cet évènement</a></li>
                                            <li><a href="index.php?ctrl=event&action=deleteEvent&id=<?= $event->getId() ?>"><span uk-icon="icon: close"></span>Supprimer cet évènement</a></li>
                                            <li><a href="#"><span uk-icon="icon: warning"></span>Signaler cet évènement</a></li>
                                        <?php }else{ ?>
                                            <li><a href="index.php?ctrl=publication&action=addFavorites&id=<?= $event->getId() ?>"><span uk-icon="icon: bookmark"></span>Enregistrer cet évènement</a></li>
                                            <li><a href="#"><span uk-icon="icon: warning"></span>Signaler cet évènement</a></li>
                                        <?php }?>
                                    </ul>
                                </div>
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
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    // Récupérer tous les boutons d'options et les menus associés
    const optionsBtns = document.querySelectorAll('.options-btn-event');
    const optionsMenus = document.querySelectorAll('.options-menu-event'); 

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
                    