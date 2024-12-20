<?php
    $categories = $result["data"]['categories']; 
?>

<?php
include VIEW_DIR."template/nav.php";
?>

<h1>Liste des catégories</h1>

<?php
    foreach($categories as $category){ 
        ?>
            <p><a href="index.php?ctrl=forum&action=listTopicsByCategory&id=<?= $category->getId() ?>"><?= $category->getName() ?></a></p>
            <p><a href="index.php?ctrl=forum&action=deleteCategory&id=<?= $category->getId() ?>">Supprimer</a></p>
<?php } ?>

<h1>AJOUTER CATEGORIE</h1>

<div class="form">
    <form action="index.php?ctrl=forum&action=addCategory" method="post">
        <label for="">Nom Catégorie</label>
        <input  name="title" type="text">
        <input type="submit" name="submit" value="Ajouter">
    </form>
</div>


  
