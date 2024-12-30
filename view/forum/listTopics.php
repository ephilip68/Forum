<?php

    $category = $result["data"]['category']; 
    $topics = $result["data"]['topics']; 
    include VIEW_DIR."template/nav.php";
  
?>

<section class="pageCategorie">
    <div class="categoryContent">
        <div class="categoryTitle">
            <div class="underTitle">
                <span class="categories">CATEGORIES</span>
                <span class="categories">/<?php echo strtoupper($category->getName())?></span>
            </div>
        </div>
        <div class="cardTopicContent">
            <div class="cardTopic">
                <div class="cardTopicTitle">
                    <figure>
                        <p><a href="index.php?ctrl=forum&action=listTopicsByCategory&id=<?= $category->getId() ?>"><?= ucfirst($category->getName()) ?></a></p>
                        <img class="imgCategory" src="public/upload/<?= $category->getPhoto() ?>" alt="" srcset="">
                    </figure>
                </div>
            </div>
        </div>
        <div class="addTopic2">
            <div class="underTitle">
                <span class="categories">RECENT</span>
            </div>
            <button class="btnCategorie" type="button" uk-toggle="target: #modal-example7">
                <a href="#"></a>
                <i class="fa-solid fa-plus"></i>
                NEW TOPIC
            </button>
        </div>
        <!-- Modal -->
        <div id="modal-example7" uk-modal>
            <div class="uk-modal-dialog uk-modal-body">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title">Nouveau Sujet</h3>
                        <hr>
                        <a class="btn-close uk-modal-close close-close" ><i class="fa-solid fa-xmark"></i></a>
                    </div>
                    <div class="modal-body">
                        <form action="index.php?ctrl=forum&action=addTopicToCategory&id=<?= $category->getId()?>" method="post">
                            <div class="modal-comment">
                                <div class="modal-Form">
                                    <input id="content" type="text" name="title" placeholder="Titre du sujet">
                                    <input id="content" type="text" name="text" placeholder="Ecrivez votre message...">
                                </div>
                            </div>
                            <br/>
                            <input type="submit" name="submit" value="Ajouter">
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class='cantainer-topic'>
            <table class='uk-table uk-table-hover' id='recap'>
                <thead id='category'>
                    <tr id=title>
                        <th class='category-title'>TOPIC</th>
                        <th class='category-title'>UTILISATEURS</th>
                        <th class='category-title'>REPUBLICATIONS</th>
                        <th class='category-title'>VUES</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(empty($topics)){ ?> 
                        <p>Cette catégorie n'a pas de sujet pour le moment.</p>
                    <?php }else{ ?>    
                    <?php foreach($topics as $topic){ ?>

                        <tr id='product-hover'>

                            <td><a href="index.php?ctrl=forum&action=listPostsByTopic&id=<?= $topic->getId() ?>"><?php echo ucfirst($topic->getTitle())?></a></td>
                            <td><?php echo ucfirst($topic->getUser()->getNickName()) ?></td>
                            <td></td>
                            <td></td>
                        </tr>  
                    <?php } ?>
                <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</section>
