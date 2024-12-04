<?php

$topic = $result["data"]["topic"];
$posts = $result["data"]["posts"];

?>

<h1>Liste des Postes</h1>

<?php
    foreach($posts as $post){ ?>
        <p><a href="#><?= $post->getId() ?>"><?php echo $topic->getTitle()?></a> par <?= $post->getUser()->getNickName() ?></p>
        <p><?= $post->getCreationDate() ?></p>
        <p><?= $post->getText() ?></p>
 
<?php }