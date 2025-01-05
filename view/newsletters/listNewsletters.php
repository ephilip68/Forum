<?php
    include VIEW_DIR."template/nav.php";
?>

<h1>Abonnez-vous à notre newsletter</h1>

<form action="index.php?ctrl=newsletter&action=subscribe" method="POST" >
    <label for="email">Email :</label>
    <input type="email" name="email" id="email" required>
    <br>
    <button type="submit" name="submit">S'abonner</button>
</form>

<h1>Envoyer la newsletter à tous les abonnés</h1>

<!-- Formulaire d'envoi de la newsletter -->
<form action="index.php?ctrl=newsletter&action=sendNewsletter" method="POST">
    <button type="submit">Envoyer</button>
</form>