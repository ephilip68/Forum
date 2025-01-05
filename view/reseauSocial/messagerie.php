<?php
    $messages = $result["data"]["messages"];
    // $friends = $result["data"]["friends"];
    // $users = $result["data"]["users"];
    include VIEW_DIR."template/nav.php";
?>

<div class="container-home" >
    <div class="left-side-content">
        <div class="left-side-event">
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
                        <form action="index.php?ctrl=message&action=searchUsers" method="GET">
                            <i class="fa-solid fa-magnifying-glass"></i>
                            <input class="input4" type="text" name="search" placeholder="cherche un ami">
                            <button type="submit">Rechercher</button>
                        </form>
                        
                    </div>
                    <div class="message"></div>
                </div>
                <div class="message_content2">
                    <div class="message_contact">
                        <figure>
                            <img src="" alt="">
                        </figure>
                        <div class="profil_name">
                            <p></p>
                        </div>
                    </div>
                    <div class="message_discussion">
                    <?php foreach ($messages as $message){ ?>
                            <div class="message">
                                <strong>De : <?php $message->getUser_id() ?></strong>
                                <p><a href="index.php?action=viewMessage&id=<?= $message->getId() ?>"><?= $message->getMessage() ?></a></p>
                                <small>Envoyé le : <?php $message->getdateMessage() ?></small>
                            </div>
                        <?php } ?>   
      
                <img src="" alt="" srcset="">
                <a href="index.php?ctrl=security&action=profile&id="></a>   
    
                    </div>
                    <div class="send_message">
                    <form action="index.php?ctrl=message&action=sendMessage" method="post">

                        <input type="text" id="user" name="user_id_1" required><br>

                        <label for="message">Message:</label>
                        <textarea name="message" id="message" rows="4" required></textarea>

                        <input type="hidden" name="user_id" value="1"> <!-- L'ID de l'utilisateur connecté -->
                        <button type="submit" name="submit">Envoyer</button>
                    </form>
                    </div>
                </div>
            </div>
        </div>
    </div>   
 </div>





















<!-- <h2>Boîte de réception</h2>
<?php foreach ($messages as $message): ?>
    <div class="message">
        <strong>De : <?php echo htmlspecialchars($message['sender_name']); ?></strong>
        <p><?php echo nl2br(htmlspecialchars($message['message'])); ?></p>
        <small>Envoyé le : <?php echo $message['sent_at']; ?></small>
    </div>
<?php endforeach; ?>


<form action="index.php?ctrl=message&action=sendMessage" method="post">
    <label for="receiver_id">Destinataire:</label>
    <input type="text" name="receiver_id" id="receiver_id" required>

    <label for="message">Message:</label>
    <textarea name="message" id="message" rows="4" required></textarea>

    <button type="submit" name="submit">Envoyer</button>
</form> -->