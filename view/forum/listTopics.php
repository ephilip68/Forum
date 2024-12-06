<?php

    $category = $result["data"]['category']; 
    $topics = $result["data"]['topics']; 
    
  
?>

<h1>Liste des topics</h1>

<?php
foreach($topics as $topic){?>

    <p><a href="index.php?ctrl=forum&action=listPostsByTopic&id=<?= $topic->getId() ?>"><?php echo $topic->getTitle()?></a> par <?= $topic->getUser()->getNickName() ?></p>

<?php } ?>

<h1>AJOUTER SUJET</h1>

<div class="form">
    <form action="index.php?ctrl=forum&action=addTopicToCategory&id=<?= $category->getId()?>" method="post">
        <div>
            <label for="">Titre</label>
            <input name="title" type="text">

          
            <label for="">Premier Message</label>
            <textarea name="text" id="text" cols="30" rows="10"></textarea>
     
            <!-- <label for="">Nouveau Sujet</label>
            <textarea name="text" id="message" cols="30" rows="10"></textarea> -->
        </div>

        <input type="submit" name="submit" value="Ajouter">
    </form>
</div>