<?php
    
    $event = $result["data"]["event"];
    $limit = $result["data"]["limit"];
    $nombreParticipants = $result["data"]["nombreParticipants"];
    $limitMax = $result["data"]["limitMax"];
    $isParticipant = $result["data"]["isParticipant"];

    include VIEW_DIR."template/nav.php";

?>

<div class="container-home" >
    <div class="left-side-content">
        <div class="left-side-event">
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
        <div class="main-container">
            <div class="profileEvent">
                <img src="public/upload/<?= $event->getPhoto() ?>" alt="" class="profile-event-cover">
            </div>
            <div class="detailButton">
                <div class="detailBtn">
                    <?php if($isParticipant) { ?>
                        <a href="index.php?ctrl=event&action=deleteParticipant&id=<?= $event->getId() ?>"><i class="fa-solid fa-circle-check"></i>Je participe</a>
                    <?php } else { ?>
                        <a href="index.php?ctrl=event&action=addParticipant&id=<?= $event->getId() ?>"><i class="fa-regular fa-circle-check"></i>Je participe</a>
                    <?php } ?>
                    <a href=""><i class="fa-solid fa-share"></i></a><div class="sharethis-inline-share-buttons"></div>
                </div>
            </div>
            <div class="timeline">
                <div>

                </div>
                <div class="timeline-left">
                    <div class="intro box">
                        <div class="intro-title">
                            
                        </div>
                        <div class="info">
                            <div class="info-item">
                                
                                
                                
                            </div>
                            <div class="info-item">
                                
                                
                                 
                            </div>
                        </div>
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