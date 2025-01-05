<?php

$topic = $result["data"]["topic"];
$posts = $result["data"]["posts"];
$comments = $result["data"]["comments"];
$countLike = $result["data"]["countLike"];
$userLike = $result["data"]["userLike"];

include VIEW_DIR."template/nav.php";

?>

<section class="pageCategorie">
    <div class="post_container">
        <div class="post_content">
            <div class="post_description">
                <div class="post_category">
                    <i class="fa-solid fa-group-arrows-rotate"></i>
                    <p><?php echo ucfirst($topic->getCategory()->getName())?></p>
                </div>
                <div class="cardContent">
                    <div class="card_post">
                        <div class="cardTitle">
                            <p><?php echo ucfirst($topic->getTitle())?></p>
                        </div>
                        <div class="cardProfil">
                        
                        
                            <?php if (!empty($topic->getUser()->getAvatar())){ ?>

                                <img src="public/upload/<?= $topic->getUser()->getAvatar() ?>" alt="photo de profil" class="status-img">     
    
                            <?php }else{ ?>
    
                                <img src="public/img/default-avatar.webp" alt="photo de profil par défaut" class="img_profil">
    
                            <?php } ?>      
                            
                            <p><?= ucfirst($topic->getUser()->getNickName()) ?></p>
                        </div>
                        <div class="cardText">
                            <?php foreach($posts as $post){ ?>
                                <p><?= ucfirst($post->getText()) ?></p>
                            
                        </div>
                        <div class="cardReaction">
                            <div class="cardReactionLike">
                                
                                    <span><?= $countLike[$post->getId()] ?></span>


                                <?php if (!$userLike){ ?>
                                    <form action="index.php?ctrl=forum&action=likePost&id=<?= $post->getId() ?>" method="POST">
                                        <button type="submit" name="submit"><i class="fa-solid fa-heart"></i></button>
                                    </form>
                                <?php }else{ ?>
                                    <p>Vous avez déjà aimé ce topic.</p>
                                <?php } ?>
                            </div>
                            <div class="cardReactionShare">
                                <a href=""><i class="fa-solid fa-up-right-from-square"></i></a>
                            </div>
                            <div class="cardReactionBookmark">
                                <a href="" ><i class="fa-regular fa-bookmark"></i></a>
                            </div>
                            <div class="cardReactionReply">
                                <a href="#modal-example8" uk-toggle>
                                    <i class="fa-solid fa-reply"></i>
                                    <span>Répondre</span>
                                </a>
                            </div> 
                            <!-- Modal -->
                            <div id="modal-example8" uk-modal>
                                <div class="uk-modal-dialog uk-modal-body modal-post">
                                    <div class="modal-content">
                                        <a class="btn-close uk-modal-close close-post"><i class="fa-solid fa-up-right-and-down-left-from-center"></i></a>
                                        <div class="modal-reply">
                                            <div class="modalReplyTitle">
                                                <i class="fa-solid fa-reply"></i>
                                                <h3 class="modalTitle"><?php echo ucfirst($topic->getTitle())?></h3>
                                            </div>
                                        </div>
                                        <div class="modal-body">
                                            <form action="index.php?ctrl=post&action=addCommentPost&id=<?= $post->getId() ?>" method="post">
                                                <div class="modal-comment">
                                                    <textarea class="editor" name="text" cols="30" rows="10" placeholder="Vous en pensez-quoi?"></textarea>
                                                </div>
                                                <div class="modal-submit">
                                                    <div class="modal-button">
                                                        <button class="uk-modal-close btn-cancel">Annuler</button>
                                                        <button class="btn-submit" type="submit" name="submit">Envoyer</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="cardInfo">
                            <div class="cardInfoContent">
                                <span class="cardInfoTitle">REPUBLICATIONS</span>
                                <span class="cardInfoResult"></span>
                            </div>
                            <div class="cardInfoContent">
                                <span class="cardInfoTitle">VUES</span>
                                <span class="cardInfoResult"></span>
                            </div>
                            <div class="cardInfoContent">
                                <span class="cardInfoTitle">LIKES</span>
                                <span class="cardInfoResult"></span>
                            </div>
                            <div class="cardInfoContent">
                                <span class="cardInfoTitle">DERNIER COMMENTAIRE</span>
                                <span class="cardInfoResult"><?= $post->getCreationDate() ?></span>
                            </div>
                        </div>
                        <div class="cardAvatar">
                            <p>1</p>
                        </div>
                        
                    </div>
                </div>
            </div>
            <div class="message_container">
                <?php foreach($comments[$post->getId()] as $comment){ ?>
                    
                <div class="messageAnswer">
                    <div class="messageProfil">
                        <img src="" alt="photo de profil" class="img_profil" alt="">
                        <div class="messageProfilInfo">
                            <span></span>
                            <span></span>
                        </div>
                    </div>
                    <div class="messageText">
                    
                        <p><?= $comment->getText()?></p>
                        
                    </div>
                    <div class="messageReaction">
                        <div class="answer">
                            <span></span>
                            <span>Réponse</span>
                        </div>
                        <div class="reaction">
                            <div class="cardReactionLike">
                                <span></span>
                                <i class="fa-regular fa-heart"></i>
                            </div>
                            <div class="cardReactionShare">
                                <i class="fa-solid fa-up-right-from-square"></i>
                            </div>
                            <div class="cardReactionBookmark">
                                <i class="fa-regular fa-bookmark"></i>
                            </div>
                            <div class="cardReactionReply">
                                <span>Répondre</span>
                            </div>   
                        </div>
                    </div>
                </div>
            </div>
            <?php } ?>
        </div><?php } ?>
    </div>
</section>

<!-- <h1>Liste des Posts</h1> -->





<!-- <h1>Message</h1>

<div class="form">
    <form action="index.php?ctrl=forum&action=addPostToTopic&id=<?= $topic->getId()?>" method="post">
        <div>
            <label for="">Nouveau Message</label>
            <textarea name="text" id="text" cols="30" rows="10"></textarea>
        </div>

        <input type="submit" name="submit" value="Ajouter">
    </form>
</div> -->