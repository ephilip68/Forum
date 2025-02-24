<?php
    $categories = $result["data"]['categories'];
    $countTopic = $result["data"]['countTopic'];
    
    
?>

<?php
include VIEW_DIR."template/nav.php";
?>

<div class="pageCategorie">
    <div class="categoryContent">
        <div class="categoryTitle">
            <div class="underTitle">
                <span class="populaire">POPULAIRE</span>
                <span class="categories">CATEGORIES</span>
            </div>
            <div class="addTopic">
                <button class="btnCategorie" type="button" uk-toggle="target: #modal-example6">
                    <a href="#"></a>
                    <i class="fa-solid fa-plus"></i>
                    CATEGORIE
                </button>
            </div>
        </div>
        
        <!-- Modal -->
        <div id="modal-example6" uk-modal>
            <div class="uk-modal-dialog uk-modal-body">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title">Ajouter une categorie</h3>
                        <hr>
                        <a class="btn-close uk-modal-close close-close" ><i class="fa-solid fa-xmark"></i></a>
                    </div>
                    <div class="modal-body">
                        <form action="index.php?ctrl=forum&action=addCategory" method="post" enctype="multipart/form-data">
                            <!-- Champ pour le token CSRF -->
                            <input type="hidden" name="csrf_token" value="<?php echo \App\Session::generateCsrfToken(); ?>">
                            <div class="modal-comment">
                                <div class="modal-Form">
                                    <input id="content" type="text" name="title" placeholder="Nom de la catégorie">
                                    <div uk-form-custom >
                                        <input type="file" name="photo" id="fileUpload" data-target="image-4">
                                        <div class="js-upload uk-placeholder uk-text-center">
                                            <span uk-icon="icon: cloud-upload"></span>
                                            <span class="uk-text-middle">Ajouter photo</span>
                                            <span class="link">ou faites glisser-déposer</span>
                                            <img src="#" alt="" class="image-4" style="margin-top: 20px;">
                                        </div>
                                    </div> 
                                </div>
                            </div>
                            <br/>
                            <input type="submit" name="submit" value="Ajouter">
                            <p><strong>Note:</strong> Seuls les formats .jpg, .jpeg, .jpeg, .gif, .png, .webp sont autorisés jusqu'à une taille maximale de 5 Mo.</p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    
        <div class="cardCategoryContent">
            <?php
            foreach($categories as $category){ 
                ?>
            <div class="cardCategory">
                <div class="cardCategoryTitle">
                    <figure>
                        <p><a href="index.php?ctrl=forum&action=listTopicsByCategory&id=<?= $category->getId() ?>"><?= ucfirst($category->getName()) ?></a></p>
                        <img class="imgCategory" src="public/upload/<?= $category->getPhoto() ?>" alt="image catégorie">
                    </figure>
                </div>
                <div class="categoryActivity">
                    <div class="info_category">
                        <span class="title_info">TOPICS</span>
                        <?php foreach ($countTopic as $topic){

                        if ($category->getId() == $topic['id_category']){?>

                        <span class="last_info"><?= $topic['COUNT(*)'] ?></span> 
                    </div>
                    <div class="info_category">
                        <span class="title_info">DERNIERE ACTIVITE</span>
                        <span class="last_info_activity"><?= $topic['last_date'] ?></span>
                    </div>
                </div>
                <div class="categoryTopic">
                    <div class="title_last_topic">
                        <span class="title_info">DERNIER TOPIC</span>
                    </div>
                    <div class="info_last_topic">
                        <?php if ($topic['last_user']){ ?>

                            <img src="public/upload/<?= $topic['last_avatar'] ?>" alt="photo de profil" class="status-img">     
    
                        <?php } ?>
                        <a href="index.php?ctrl=post&action=listPostsByTopic&id=<?= $topic['last_id'] ?>"><span class="last_info"><?= ucfirst($topic['last_title']) ?></span></a>
                        <?php } ?>
                    <?php } ?>
                    </div>
                </div>
                <a href="index.php?ctrl=forum&action=deleteCategory&id=<?= $category->getId() ?>"><i class="fa-solid fa-xmark close"></i></a>
            </div>        
        <?php } ?>
        </div>
    </div>
</div>







  
