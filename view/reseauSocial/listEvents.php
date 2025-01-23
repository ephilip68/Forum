<?php
    $events = $result["data"]["events"];
    $page = $result["data"]["page"];
    $totalPages = $result["data"]["totalPages"];
    $countParticipants = $result["data"]["countParticipants"];
    
    include VIEW_DIR."template/nav.php";
?>

<div class="container-home" >
    <div class="left-side-content">
        <div class="left-side-event">
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
            <div class="side-wrapper">
                <ul class="listNavEvent list-unstyled">
                    <div class="navEvent">
                        <h2 style="font-weight:700">Evènements</h2>
                        <a href="index.php?ctrl=event&action=index&page=<?= $page - 1; ?>"><li class="listContent"><i class="fa-solid fa-calendar"></i><span>Accueil</span></li></a>
                        <li class="listContent"><i class="fa-solid fa-user"></i><span>Vos évènements</span></li>
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
                    <h3 class="modal-title">Ajouter un Evènement</h3>
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
                                <input id="content" type="number" name="limit" placeholder="nombres de place" required>
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

    <div class="main-container-event">
        <div class="timeline-event">
            <div class="timeline-center-event">
                <div class="pagination">
                    <h3>Liste des évènements à venir</h3>
                </div>
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
                                    <a href="index.php?ctrl=event&action=detailEvents&id=<?= $event->getId() ?>"><p class="eventTitle"><?= ucfirst($event->getTitle()) ?></p></a>
                                    <p class="eventSide"><?= ucfirst($event->getCity()) ?>, <?= ucfirst($event->getCountry()) ?></p>
                                </div>
                                <div class="eventPlace">
                                    <?php foreach($countParticipants as $participant) { ?>
                                        <?php if($participant['id'] == $event->getId()) { ?>
                                            <span class="event-place"><?= $event->getLimit() ?> places | <?= $participant['numberParticipants'] ?> participant<?= $participant['numberParticipants'] > 1 ? "s" : ""  ?></span>
                                            <?php if($participant['limitMax']) { ?> 
                                                <span class="event-limit">Evènement complet</span>
                                            <?php }else{ ?>
                                            <?php } ?>   
                                        <?php } ?>   
                                    <?php } ?>    
                                </div>  
                            </div>
                            <div class="eventButton">
                                <div class="eventBtn">
                                    <a href="index.php?ctrl=event&action=detailEvents&id=<?= $event->getId() ?>"><button class="btnInteresse"><i class="fa-solid fa-plus"></i>Voir plus</button></a>
                                    <button class="btnShareEvent"><i class="fa-solid fa-share"></i></button>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
                <ul class="uk-pagination uk-flex-center" uk-margin>
                    <?php if ($page > 1) { ?>
                        <li><a href="index.php?ctrl=event&action=index&page=<?= $page - 1; ?>"><span uk-pagination-previous></span></a></li>
                    <?php } else { ?>
                        <li class="uk-disabled"><span><span uk-pagination-previous></span></span></li>
                    <?php } ?>

                    <?php for ($pageNumber = 1; $pageNumber <= $totalPages; $pageNumber++) { ?>
                        <li class="<?= ($pageNumber == $page) ? 'uk-active' : ''; ?>">
                            <a href="index.php?ctrl=event&action=index&page=<?= $pageNumber; ?>" <?= ($pageNumber == $page) ? 'aria-current="page"' : ''; ?>><?= $pageNumber ?></a>
                        </li>
                    <?php } ?>

                    <?php if ($page < $totalPages) { ?>
                        <li><a href="index.php?ctrl=event&action=index&page=<?= $page + 1; ?>"><span uk-pagination-next></span></a></li>
                    <?php } else { ?>
                        <li class="uk-disabled"><span><span uk-pagination-next></span></span></li>
                    <?php } ?>
                </ul>
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
                    