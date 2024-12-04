<?php
    $categories = $result["data"]['category']; 
?>

<h1>Liste des catégories</h1>

<?php
    foreach($categories as $category){ 
        ?>
            <p><a href="index.php?ctrl=forum&action=listTopicsByCategory&id=<?= $category->getId() ?>"><?= $category->getName() ?></a></p>
<?php } ?>

<a href="index.php?ctrl=forum&action=addCategoryForm">Ajouter Catégorie</a>
</div>

  
