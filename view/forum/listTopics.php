<?php

    $category = $result["data"]['category']; 
    $topics = $result["data"]['topics']; 
  
?>

<h1>Liste des topics</h1>

<?php
foreach($topics as $topic){?>

    <p><a href="index.php?ctrl=forum&action=listPostsByTopic&id=<?= $topic->getId() ?>"><?php echo $topic->getTitle()?></a> par <?= $topic->getUser()->getNickName() ?></p>
<?php } ?>

<a href="index.php?ctrl=forum&action=addTopicForm">Ajouter Sujet</a>
 