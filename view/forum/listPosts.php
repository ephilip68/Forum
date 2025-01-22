<?php

$topic = $result["data"]["topic"];
$post = $result["data"]["post"];
$comments = $result["data"]["comments"];
$countLike = $result["data"]["countLike"];
$userLike = $result["data"]["userLike"];
$underComments = $result["data"]["underComments"];
$countComments = $result["data"]["countComments"];

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
                            
                                <p><?= $post->getText() ?></p>
                            
                        </div>
                        <div class="cardReaction">
                            <div class="cardReactionLike">
                                <?php if (!$userLike){ ?>
                                    <form action="index.php?ctrl=forum&action=likePost&id=<?= $post->getId() ?>" method="POST">
                                        <button class="tooltip" type="submit" name="submit"><?= $countLike ?><i class="fa-solid fa-heart"></i></button>
                                    </form>
                                <?php }else{ ?>
                                    
                                <?php } ?>
                            </div>
                            <div class="cardReactionShare">
                                <a class="tooltip" href=""><i class="fa-solid fa-up-right-from-square "></i></a>
                            </div>
                            <div class="cardReactionShare">
                                <a class="tooltip" href=""><i class="fa-regular fa-bookmark"></i></a>
                            </div>
                            <div class="cardReactionReply">
                                <a href="#modal-answer-post-<?= $post->getId()?>" uk-toggle>
                                    <i class="fa-solid fa-reply"></i>
                                    <span>Répondre</span>
                                </a>
                            </div> 
                            <!-- Modal -->
                            <div id="modal-answer-post-<?= $post->getId()?>" class="under" uk-modal>
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
                                            <form action="index.php?ctrl=post&action=addCommentPost&id=<?= $post->getId() ?>" method="POST">
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
                                <span class="cardInfoResult"><?= $countLike ?></span>
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
            <div class="message_container" > 
                <?php if(!empty($comments)){ ?>
                    <?php foreach($comments as $comment){ ?>
                        <div class="messageAnswer">
                            <div class="messageProfil">
                                <img src="public/upload/<?= $comment['avatar'] ?>" alt="photo de profil" class="status-img-nav" >
                                <div class="messageProfilInfo">
                                    <span ><a class="album-title-comment" href="index.php?ctrl=security&action=profile&id=<?= $comment['user_id'] ?>"><?= ucfirst($comment['nickName']) ?></a></span>
                                    <span class="album-comment-date"><?= $comment['commentDate'] ?></span>
                                </div>
                            </div>
                            <div class="messageText">
                                <p><?= ucfirst($comment['text']) ?></p>
                            </div>
                            <div class="messageReaction">
                                <div class="answer">
                                <?php foreach ($countComments as $count){
                                    if ($comment['id_comment'] == $count['id']){ ?>
                                        <span><?= $count['count'] ?></span>
                                        <span>Réponse<?= $count['count'] > 1 ? "s" : "" ?></span>
                                    <?php } ?> 
                                <?php } ?> 
                                    <a href="index.php?ctrl=post&action=listPostsByTopic&id=<?= $topic->getId() ?>&comment_id=<?= $comment['id_comment'] ?>" class="toggle-comments" data="<?= $comment['id_comment'] ?>">
                                        <!-- Vérifie si le commentaire est sélectionné pour afficher ou masquer les sous-commentaires -->
                                        <?php if (isset($_GET['comment_id']) && $_GET['comment_id'] == $comment['id_comment']) { ?>
                                            <i class="fa-solid fa-chevron-up"></i>
                                        <?php } else { ?>
                                            <i class="fa-solid fa-chevron-down"></i> 
                                        <?php } ?>   
                                    </a>
                                </div>
                                <div class="reaction">
                                    <div class="cardReactionLike">
                                        <span>2</span>
                                        <i class="fa-regular fa-heart"></i>
                                    </div>
                                    <div class="cardReactionShare">
                                        <i class="fa-solid fa-up-right-from-square"></i>
                                    </div>
                                    <div class="cardReactionShare">
                                        <a href="index.php?ctrl=publication&action=addFavorites&id="><i class="fa-regular fa-bookmark"></i></a>
                                    </div>
                                    <div class="cardReactionReply">
                                    
                                    <button uk-toggle="target: #modal-under-comment-<?= $comment['id_comment'] ?>" type="button"><a href="index.php?ctrl=post&action=addUnderComment&id=<?= $comment['id_comment'] ?>"><span>Répondre</span></a></button>
                                    </div>   
                                </div>
                            </div>

                            <div class="underpost-comments" data="<?= $comment['id_comment'] ?>" style="display: <?= isset($_GET['comment_id']) && $_GET['comment_id'] == $comment['id_comment'] ? 'block' : 'none' ?>;">
                                <?php foreach($underComments as $underComment){ ?>
                                    <?php if ($underComment['comment_id'] == $comment['id_comment']){ ?>
                                        <div class="messageAnswerComment">
                                            <div class="messageProfilComment">
                                                <img src="public/upload/<?= $underComment['avatar'] ?>" alt="photo de profil" class="status-img-nav" >
                                                <div class="messageProfilInfo">
                                                    <span ><a class="album-title-comment" href="index.php?ctrl=security&action=profile&id=<?= $UnderComment['user_id'] ?>"><?= ucfirst($underComment['nickName']) ?></a></span>
                                                    <p><?= ucfirst($underComment['text']) ?></p>
                                                    <div class="messageProfilDate">
                                                        <span class="album-ucomment-date"><?= $underComment['commentDate'] ?></span>
                                                    </div>
                                                </div>  
                                            </div>  
                                        </div>
                                    <?php } ?>
                                <?php } ?>
                            </div>
                        
                            <!-- Modal -->
                            <div id="modal-under-comment-<?= $comment['id_comment'] ?>" class="under" uk-modal>
                                <div class="uk-modal-dialog uk-modal-body modal-post">
                                    <div class="modal-content">
                                        <a class="btn-close uk-modal-close close-post"><i class="fa-solid fa-up-right-and-down-left-from-center"></i></a>
                                        <div class="modal-reply">
                                            <div class="modalReplyTitle">
                                                <i class="fa-solid fa-reply"></i>
                                                <h3 class="modalTitle"><?= ucfirst($comment['text'])?></h3>
                                            </div>
                                        </div>
                                        <div class="modal-body">
                                            <form action="index.php?ctrl=post&action=addUnderComment&id=<?= $comment['id_comment'] ?>" method="POST">
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
                    <?php } ?>
                <?php }else{ ?>
                <?php } ?>
            </div>
            
        </div>
    </div>
</section>
<script>

document.addEventListener('DOMContentLoaded', function () {
        // Récupérer tous les liens de "toggle-comments"
        var toggleLinks = document.querySelectorAll('.toggle-comments');

        toggleLinks.forEach(function(link) {
            // Ajouter un événement de clic pour chaque lien
            link.addEventListener('click', function(e) {
                e.preventDefault();  // Empêche le comportement par défaut (rechargement de la page)

                var commentId = link.getAttribute('data');  // Récupérer l'ID du commentaire
                var subComments = document.querySelector('.underpost-comments[data= "' + commentId + '"]');  // Sélectionner le div des sous-commentaires par ID
                var chevronIcon = link.querySelector('i');  // L'icône du chevron

                // Vérifier si les sous-commentaires sont déjà visibles
                if (subComments.style.display === 'none' || subComments.style.display === '') {
                    // Afficher les sous-commentaires et changer l'icône du chevron
                    subComments.style.display = 'block';
                    chevronIcon.classList.remove('fa-chevron-down');
                    chevronIcon.classList.add('fa-chevron-up');
                    link.innerHTML = '<i class="fa-solid fa-chevron-up"></i>';
                } else {
                    // Masquer les sous-commentaires et changer l'icône du chevron
                    subComments.style.display = 'none';
                    chevronIcon.classList.remove('fa-chevron-up');
                    chevronIcon.classList.add('fa-chevron-down');
                    link.innerHTML = '<i class="fa-solid fa-chevron-down"></i>';
                }
            });
        });
    });
</script>


