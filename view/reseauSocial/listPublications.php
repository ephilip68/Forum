<?php
    $publications = $result["data"]["publications"];
?>

<h1>Liste des publications</h1>

<?php
    foreach($publications as $publication){ 
        ?>
            <p><?=$publication->getContent()?></p>
            <p><a href="index.php?ctrl=publication&action=deletePublication&id=<?= $publication->getId() ?>">Supprimer</a></p>
            
<?php } ?>

<div class="form">
    <form action="index.php?ctrl=publication&action=addPublication" method="post">
        <input  name="content" type="text" value="Publier quelque chose !">
        <input type="submit" name="submit" value="Ajouter">
    </form>
</div>






  