<?php

  
?>

<h1>AJOUTER SUJET</h1>

<div class="form">
    <form action="index.php?ctrl=forum&action=addTopic" method="post">
        <div>
            <label for="">Titre</label>
            <input name="title" type="text">
            <label for="">Nouveau Sujet</label>
            <textarea name="text" id="message" cols="30" rows="10"></textarea>
        </div>

        <input type="submit" name="submit" value="Ajouter">
    </form>
</div>