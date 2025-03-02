<?php
    $messages = $result["data"]["messages"];
    $recipient = $result["data"]["recipient"];
    $searchResults = $result["data"]["searchResults"];
    $search = $result["data"]["search"];
    $unreadMessagesCount = $result["data"]["unreadMessagesCount"];
    $conversations = $result["data"]["conversations"];
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
                        <a href="index.php?ctrl=security&action=profile&id=<?= App\Session::getUser()->getId()?>"><li class="listContent"><i><img src="public/upload/<?=App\Session::getUser()->getAvatar()?>" class="status-img-nav"/></i><span><?= ucfirst(App\Session::getUser()->getNickName())?></span></li></a>
                        <a href="index.php?ctrl=publication&action=listAmis"><li class="listContent"><i class="fa-solid fa-user-group"></i><span>Amis</span></li></a>
                        <a href="index.php?ctrl=publication&action=getFavoritesPublications"><li class="listContent"><i class="fa-solid fa-bookmark"></i><span>Enregistrements</span></li></a>
                        <a href="index.php?ctrl=event&action=index"><li class="listContent"><i class="fa-solid fa-calendar"></i><span>Evènements</span></li></a>
                        <a href="#"><li class="listContent"><i class="fa-solid fa-magnifying-glass"></i><span>Rechercher</span></li></a>
                        <a href="#"><li class="listContent"><i class="fa-solid fa-envelope"></i><span>Newsletters</span></li></a>
                        <li class="divider"></li>
                        <a href="#"><li class="listContent"><i class="fa-solid fa-gear"></i><span>Paramètres</span></li></a>
                        <a href="index.php?ctrl=security&action=logout"><li class="listContent"><i class="fa-solid fa-arrow-right-from-bracket"></i><span>Déconnexion</span></li></a>  
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
    <div class="messagerie_container">
        <div class="message_content">
            <div class="message_profil">
                    <img src="public/upload/<?= App\Session::getUser()->getAvatar()?>" class="status-img-msg"/>
                <div class="profil_informations">
                    <p><?= ucfirst(App\Session::getUser()->getNickName()) ?></p>
                    <p></p>
                </div>
            </div>
            <div class="message_search">
                <form action="index.php?ctrl=message&action=index" method="POST">
                    <input type="text" name="search" placeholder="Rechercher un utilisateur" required>
                    <button type="submit" name="submit">Rechercher</button>
                </form>
            </div>
            <div class="messages">
                 <!-- Affichage des résultats de recherche (si disponibles) -->
                 <?php if (!empty($searchResults)) { ?>
                    <div class="messages-search">
                        <h3>Résultats de la recherche :</h3>
                        <?php foreach ($searchResults as $user) { ?>
                            <div class="search-result">
                                <img class="status-img-nav" src="public/upload/<?= $user['avatar']?>" alt="photo de <?= ucfirst($user['nickName']) ?>">
                                <p><?= ucfirst($user['nickName']) ?></p> 
                                <a href="index.php?ctrl=message&action=index&id=<?= $user['id_user'] ?>">Envoyer un message</a>
                            </div>
                        <?php } ?>
                    </div>
                <?php } ?>
                <?php if(!empty($conversations)){ ?>
                    <?php foreach ($conversations as $conversation){ ?>
                        <div class="contacts">
                           <a class="contacts-menu" href="index.php?ctrl=message&action=index&id=<?= $conversation['id_user'] ?>">
                                <img src="public/upload/<?= $conversation['avatar']?>" alt="photo de <?= ucfirst($conversation['nickName']) ?>">
                                <p><?= ucfirst($conversation['nickName']) ?></p>
                                 <!-- Affichage de la notification si des messages non lus existent -->
                                <?php if ($conversation['id_user'] == $unreadMessagesCount > 0){ ?>
                                    <p style="color:red"><?= $unreadMessagesCount ?></p> 
                                <?php } ?>
                            </a> 
                        </div>
                    <?php } ?>
                <?php } ?>    
            </div>
        </div>
        <div class="message_content2">
            <!-- Affichage des informations du destinataire -->
            <div class="message_contact">
                <?php if (isset($recipient)){ ?>
                        <!-- Afficher l'avatar du destinataire -->
                        <img src="public/upload/<?= $recipient->getAvatar()?>" alt=" photo de <?= $recipient->getNickName() ?>" >
                    <div class="profil_name">
                        <p><?= ucfirst($recipient->getNickName()) ?></p>
                    </div>
                <?php } ?>
            </div>

            <!-- Affichage des messages de la conversation -->
            <div class="message_discussion">
                <?php if (!empty($messages)){ ?>
                    <?php foreach ($messages as $message){ ?>
                        <?php if (App\Session::getUser()->getId() == $message['user_id']){ ?>
                            <div class="messages-send">
                                <div class="discussion-profil">
                                    <p><?= ucfirst($message['messages']) ?></p>  
                                    <img src="public/upload/<?= App\Session::getUser()->getAvatar()?>" class="status-img-nav"/>
                                </div>
                                <small>le <?= $message['dateMessage'] ?></small>
                            </div>
                        <?php }else{ ?>
                            <div class="messages-users">
                                <div class="discussion-users">
                                    <img src="public/upload/<?= $message['avatar'] ?>" class="status-img-nav"/>
                                    <p><?= ucfirst($message['messages']) ?></p>
                                </div>
                                <small>le <?= $message['dateMessage'] ?></small>
                            </div>
                        <?php } ?>
                    <?php } ?>
                <?php } else { ?>
                <?php } ?>
            </div>

            <!-- Formulaire d'envoi de message -->
            <div class="send_message">
                <?php if (isset($recipient)){ ?>
                    <form method="post" action="index.php?ctrl=message&action=sendMessage&id=<?= $recipient->getId() ?>">
                        <textarea name="messages" placeholder="Écrire votre message" required></textarea>
                        <button type="submit" name="submit_message"><i class="fa-solid fa-paper-plane"></i></button>
                    </form>
                <?php } ?>
            </div>
        </div>
    </div>  
</div>

