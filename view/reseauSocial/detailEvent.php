<?php
    
    $event = $result["data"]["event"];
    $limit = $result["data"]["limit"];
    $nombreParticipants = $result["data"]["nombreParticipants"];
    $limitMax = $result["data"]["limitMax"];
    $isParticipant = $result["data"]["isParticipant"];
    $isFollowing = $result["data"]["isFollowing"];

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
                        <a href="index.php?ctrl=event&action=index"><li class="listContent"><i class="fa-solid fa-calendar"></i><span>Accueil</span></li></a>
                        <a href="#modal-detail" uk-toggle class="newEvent"><i class="fa-solid fa-plus"></i>Créer un évnement</a>
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
    <div id="modal-detail" uk-modal>
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
    <div class="main-profil">
        <div class="main-container-detail">
            <div class="profileEvent">
                <img src="public/upload/<?= $event->getPhoto() ?>" alt="" class="profile-event-cover">
            </div>
            <div class="detailButton">
                <div class="detailBtn">
                    <!-- Vérifie si l'utilisateur connecté est le créateur de l'événement -->
                    <?php if(App\Session::getUser() == $event->getUser()){ ?>
                        <!-- Si l'utilisateur est le créateur de l'événement, il n'y a pas de bouton, donc aucune action n'est faite ici -->
                    <?php }elseif($isParticipant) { ?>
                        <!-- Si l'utilisateur est déjà inscrit à l'événement, afficher un bouton pour annuler sa participation -->
                        <a class="participant-btn" href="index.php?ctrl=event&action=deleteParticipant&id=<?= $event->getId() ?>">
                            <!-- Icône pour signifier que l'utilisateur participe déjà à l'événement -->
                            <i class="fa-solid fa-circle-check"></i>Je participe
                        </a>
                    <?php } else { ?>
                        <!-- Si l'utilisateur n'est pas encore inscrit, afficher un bouton pour s'inscrire à l'événement -->
                        <a class="participant-btn2" href="index.php?ctrl=event&action=addParticipant&id=<?= $event->getId() ?>">
                            <!-- Icône pour signifier que l'utilisateur peut s'inscrire à l'événement -->
                            <i class="fa-regular fa-circle-check"></i>Je participe
                        </a>
                    <?php } ?>
                <!-- Intégration d'un widget de partage social -->
                <div class="sharethis-inline-share-buttons"></div>
            </div>
            <div class="timeline-detail">
                <div class="timeline-left-detail">
                    <div class="detail-box">
                        <h3>Détails</h3>
                        <div class="detail-title">
                            <span class="detail-time"><?= $event->getFormattedDate() ?> à <?= $event->getEventHours() ?></span>
                            <p><?= ucfirst($event->getTitle()) ?></p>
                            <span><?= ucfirst($event->getCity()) ?>, <?= ucfirst($event->getCountry()) ?></span>
                        </div>
                        <div class="info-detail">
                            <div class="info-content">
                                <p><i class="fa-solid fa-user-group"></i><?= $nombreParticipants ?> personnes participent</p>
                                <p><i class="fa-solid fa-user"></i>Evènement crée par <a href="index.php?ctrl=security&action=profile&id=<?= $event->getUser()->getId() ?>"><?= ucfirst($event->getUser()->getNickName()) ?></a></p>
                                <p><?= $event->getText() ?></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="timeline-right-detail">
                    <div class="detail-box-right">
                        <h3>Organisateur</h3>
                        <div class="detail-box-img">
                            <div class="detail-img">
                                <img src="public/upload/<?=$event->getUser()->getAvatar()?>" />
                                <a href="index.php?ctrl=security&action=profile&id=<?= $event->getUser()->getId() ?>"><?= ucfirst($event->getUser()->getNickName()) ?></a>
                            </div>
                            <div class="info-button">
                                <div class="info-btn">
                                    <?php if(App\Session::getUser()->getId() == $event->getUser()->getId()){ ?>
                                        <a class="profile-menu-btn" href="#modal-edit" uk-toggle>Modifier l'évènement</a>
                                    <?php }elseif($isFollowing) { ?>
                                        <a href="index.php?ctrl=follow&action=addFollow&id=<?= $event->getUser()->getId() ?>"><i class="fa-solid fa-plus"></i>Suivre</a>
                                    <?php }else{ ?>
                                        <a href="index.php?ctrl=follow&action=deleteFollow&id=<?= $event->getUser()->getId() ?>">Suivi(e)</a>
                                    <?php } ?>  
                                </div>
                            </div>
                        </div>
                    </div>  
                </div>
            </div>
        </div>
    </div>
</div>