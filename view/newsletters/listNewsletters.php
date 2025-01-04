<?php
    include VIEW_DIR."template/nav.php";
?>

<h1>Abonnez-vous à notre newsletter</h1>

<form action="index.php?ctrl=newsletters&action=subscribe" method="POST" >
    <label for="email">Email :</label>
    <input type="email" name="email" id="email" required>
    <br>
    <button type="submit" name="submit">S'abonner</button>
</form>