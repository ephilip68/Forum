<?php
    $publications = $result["data"]["publications"];

?>
<?php
include VIEW_DIR."nav.php";;
?>

    <div class="grid">
        <div class="grid-item" id="navMenu">
            <ul class="listNav list-unstyled">
            <?php
                // si l'utilisateur est connecté 
                if(App\Session::getUser()){
                ?>
                    <a href="index.php?ctrl=security&action=profile"><li class="listContent"><i class="fa-solid fa-user"></i><span><?= App\Session::getUser()?></span></li></a>
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
                    <button class="writeSomething" data-toggle="modal" data-target="#modelId"><a href="#"></a>Publier quelque chose !</button>
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
                    <div class="modal fade" id="modelId" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Créer une publication</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form action="index.php?ctrl=publication&action=addPublication" method="post" enctype="multipart/form-data">
                                        <div class="add-dup-parent">
                                            <div class="form-row mt-3 __add-fields">
                                                <input name="content" id="content" value="Publier quelque chose !">
                                                <div class="col-9">
                                                    <div class="card form-image-preview">
                                                        <input type="file" name="photo" class="fileUpload">
                                                        <div class="card-body upload-area upload-file" id="uploadfile">
                                                            <p class="card-text">
                                                            <i class="fa fa-camera fa-lg" aria-hidden="true"></i> <br>
                                                                Drag and Drop ou Télécharger Fichier
                                                            </p>
                                                            <img class="card-img-top" src="">
                                                        </div>
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
                            <p><?=$publication->getContent()?></p>
                            <img src="public/upload/<?=$publication->getPhoto()?>" alt="" srcset="">
                            <p><a href="index.php?ctrl=publication&action=deletePublication&id=<?= $publication->getId() ?>">Supprimer</a></p>
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






  