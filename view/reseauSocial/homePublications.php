<?php
    $publications = $result["data"]["publications"];
    
    include VIEW_DIR."template/nav.php";
?>

    <div class="grid">
        <div class="grid-item" id="navMenu">
            <ul class="listNav list-unstyled">
            <?php
                // si l'utilisateur est connecté 
                if(App\Session::getUser()){
                ?>
                    <a href="index.php?ctrl=security&action=profile&id=<?=App\Session::getUser()->getId()?>"><li class="listContent"><i class="fa-solid fa-user"></i><span><?= App\Session::getUser()?></span></li></a>
                <?php
                }else{
                ?>
                    <a href="#"><li class="listContent"><i class="fa-solid fa-user"></i><span>User</span></li></a>
                <?php
                }
                ?> 
                    <a href="#"><li class="listContent"><i class="fa-solid fa-user-group"></i><span>Amis</span></li></a>
                    <a href="#"><li class="listContent"><i class="fa-solid fa-bookmark"></i><span>Enregistrements</span></li></a>
                    <a href="#"><li class="listContent"><i class="fa-solid fa-calendar"></i><span>Evènements</span></li></a>
                    <a href="#"><li class="listContent"><i class="fa-solid fa-magnifying-glass"></i><span>Rechercher</span></li></a>
                    <a href="#"><li class="listContent"><i class="fa-solid fa-envelope"></i><span>Newsletters</span></li></a>
                    <li class="divider"></li>
                    <a href="#"><li class="listContent"><i class="fa-solid fa-gear"></i><span>Paramètres</span></li></a>
                <?php
                // si l'utilisateur est connecté 
                if(App\Session::getUser()){
                ?>
                    <a href="index.php?ctrl=security&action=logout"><li class="listContent"><i class="fa-solid fa-arrow-right-from-bracket"></i><span>Déconnexion</span></li></a>
                <?php
                }else{
                ?>
                    <a href="index.php?ctrl=security&action=login"><li class="listContent"><i class="fa-solid fa-right-to-bracket"></i><span>Connexion</span></li></a>
                <?php
                }
                ?> 
            </ul>
        </div>
        <div class="grid-item" id="publication">
            <div class="publicationContent">
                <div class="publicationList">
                    <figure>
                        <img src="public/img/R.jpg" alt="image utilisateur">
                    </figure>
                    <button class="writeSomething" type="button" uk-toggle="target: #modal-example3"><a href="#"></a>Publier quelque chose !</button>
                </div>
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
                <div class="containerPublication">
                    <!-- Modal -->
                    <div id="modal-example3" uk-modal>
                        <div class="uk-modal-dialog uk-modal-body">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h3 class="modal-title">Créer une publication</h3>
                                    <hr>
                                    <a class="btn-close uk-modal-close" ><i class="fa-solid fa-xmark"></i></a>
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
                                        <input type="submit" name="submit" value="Publier">
                                        <p><strong>Note:</strong> Seuls les formats .jpg, .jpeg, .jpeg, .gif, .png, .webp sont autorisés jusqu'à une taille maximale de 5 Mo.</p>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <br><br>
                <div class="publicationUser">
                <?php
                    foreach($publications as $publication){ 
                        ?>
                            <p><?=$publication->getPublicationDate()?></p>
                            <p><?=$publication->getContent()?></p>
                            <img src="public/upload/<?=$publication->getPhoto()?>" alt="" srcset="">
                            <p><a href="index.php?ctrl=publication&action=deletePublication&id=<?= $publication->getId() ?> ">Supprimer</a></p>
                <?php } ?>
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

   

    <!-- default template for cloning -->



<!-- <div class="form">
    <form action="index.php?ctrl=publication&action=addPublication" method="post">
        <input  name="content" type="text" value="Publier quelque chose !">
        <input type="submit" name="submit" value="Publier">
    </form>
</div> -->






  