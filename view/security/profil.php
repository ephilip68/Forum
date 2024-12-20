<?php
    $user = $result["data"]["user"];
    $friends = $result["data"]["friends"];
    $publications = $result["data"]["publications"];
?>
<?php
include VIEW_DIR."template/nav.php";
?>

<div>

    <img src="public/upload/<?=$user->getAvatar()?>" alt="" srcset="">

    <p><?=$user->getNickName()?></p>
    <p><?=$user->getEmail()?></p>
    <p><?=$user->getDateInscription()?></p>
    <?php 
        if(App\Session::getUser() == $user){
    ?>
    
    <button><a href="#"></a>Modifier profil</button>

    <?php 
    }?>

    <h3>Liste d'Amis</h3>
    <?php
        foreach($friends as $friend){ 
            ?>
                <img src="<?=$friend->getAvatar()?>" alt="" srcset="">
                <a href="index.php?ctrl=security&action=profile&id=<?=$friend->getId()?>"><?=$friend->getNickName()?></a>   
    <?php } ?>

    <h3>Liste des publications</h3>

    <?php
        foreach($publications as $publication){ 
            ?>
                <p><?=$publication->getPublicationDate()?></p>
                <p><?=$publication->getContent()?></p>
                <img src="public/upload/<?=$publication->getPhoto()?>" alt="" srcset="">
                <?php 
                if(App\Session::getUser() == $user){ 
                 ?>
                    <p><a href="index.php?ctrl=publication&action=deletePublication&id=<?= $publication->getId() ?>">Supprimer</a></p>
                 <?php 
                } ?>
    <?php } ?>

</div>