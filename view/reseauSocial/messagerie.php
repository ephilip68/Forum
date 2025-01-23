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
                        <a href="index.php?ctrl=security&action=profile&id=<?=App\Session::getUser()->getId()?>"><li class="listContent"><i><img src="public/upload/<?=App\Session::getUser()->getAvatar()?>" class="status-img-nav"/></i><span><?= ucfirst(App\Session::getUser()->getNickName())?></span></li></a>
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
                <figure>
                    <img src="" alt="">
                </figure>
                <div class="profil_informations">
                    <p></p>
                    <p></p>
                </div>
            </div>
            <div class="message_search">
                <form action="index.php?ctrl=message&action=index" method="POST">
                    <input type="text" name="search" placeholder="Rechercher un utilisateur" required>
                    <input type="submit" name="submit" value="Rechercher">
                </form>
                <!-- Affichage des résultats de recherche (si disponibles) -->
                <?php if (!empty($searchResults)) { ?>
                    <h3>Résultats de la recherche :</h3>
                    <ul>
                        <?php foreach ($searchResults as $user) { ?>
                            <li>
                                <?= $user['nickName'] ?> 
                                <a href="index.php?ctrl=message&action=index&id=<?= $user['id_user'] ?>">Envoyer un message</a>
                            </li>
                        <?php } ?>
                    </ul>
                <?php } ?>
            </div>
            <div class="messages">
                 <!-- Affichage de la notification si des messages non lus existent -->
                <?php if ($unreadMessagesCount > 0){ ?>
                    <div class="notification" style="color:black">
                        <p>Vous avez <?= $unreadMessagesCount ?> nouveaux message(s)</p>
                    </div>
                <?php } ?>
                <?php foreach ($conversations as $conversation){ ?>
                    <div>
                        <a href="index.php?ctrl=message&action=index&id=<?= $conversation['id_user'] ?>">
                        <p><?= $conversation['nickName'] ?></p>
                    </div>
                <?php } ?>
            </div>
        </div>
        <div class="message_content2">
            <!-- Affichage des informations du destinataire -->
            <div class="message_contact">
                <?php if (isset($recipient)){ ?>
                    <figure>
                        <!-- Afficher l'avatar du destinataire -->
                        <img src="public/upload/<?= $recipient->getAvatar()?>" class="status-img-nav" alt="<?= $recipient->getNickName() ?>" >
                    </figure>
                    <div class="profil_name">
                        <p><?= $recipient->getNickName() ?></p>
                    </div>
                <?php } ?>
            </div>

            <!-- Affichage des messages de la conversation -->
            <div class="message_discussion">
                <?php if (!empty($messages)){ ?>
                    <?php foreach ($messages as $message){ ?>
                        <div class="messages">
                            <strong>De : <?= $message['nickName'] ?></strong>
                            <p><a href="index.php?ctrl=message&action=index&id=<?= $message['id_message'] ?>"><?= $message['messages'] ?></a></p>
                            <small>Envoyé le : <?= $message['dateMessage'] ?></small>
                        </div>
                    <?php } ?>
                <?php } else { ?>
                    <p>Aucun message à afficher.</p>
                <?php } ?>
            </div>

            <!-- Formulaire d'envoi de message -->
            <div class="send_message">
                <?php if (isset($recipient)){ ?>
                    <form method="post" action="index.php?ctrl=message&action=sendMessage&id=<?= $recipient->getId() ?>">
                        <textarea name="messages" placeholder="Écrire votre message" required></textarea>
                        <input type="submit" name="submit_message" value="Envoyer">
                    </form>
                <?php } ?>
            </div>
        </div>
    </div>
      
 </div>

