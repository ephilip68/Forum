<?php
    $friends = $result["data"]["friends"];
    
    include VIEW_DIR."template/nav.php";
?>


<h3>Liste d'Amis</h3>
    <?php
        foreach($friends as $friend){ 
            ?>
                <img src="<?=$friend->getAvatar()?>" alt="" srcset="">
                <a href="index.php?ctrl=security&action=profile&id=<?=$friend->getId()?>"><?=$friend->getNickName()?></a>   
    <?php } ?>