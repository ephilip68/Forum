<?php

$topic = $result["data"]["topic"];
$posts = $result["data"]["posts"];

?>

<h1>Liste des Posts</h1>

<?php
    
    foreach($posts as $post){ ?>
        <p><a href="#><?= $post->getId() ?>"><?php echo $topic->getTitle()?></a> par <?= $post->getUser()->getNickName() ?></p>
        <p><?= $post->getCreationDate() ?></p>
        <p><?= $post->getText() ?></p>
 
<?php } ?>



<h1>Message</h1>

<div class="form">
    <form action="index.php?ctrl=forum&action=addPostToTopic&id=<?= $topic->getId()?>" method="post">
        <div>
            <label for="">Nouveau Message</label>
            <textarea name="text" id="text" cols="30" rows="10"></textarea>
        </div>

        <input type="submit" name="submit" value="Ajouter">
    </form>
</div>