



<div>Modification</div>

    <form action= "index.php?ctrl=security&action=updateProfile"  method="post">
        <?php
            if (isset($nickName)){
        ?>
        <div><?= getUser()-> getNickName() ?></div>
            <?php
                }
            ?>
        <input type="text" placeholder="Pseudo" name="nickName" value="" required>
        <?php
        if (isset($email)){
        ?>
        <div><?= getUser()-> getEmail() ?></div>
        <?php
            }
        ?>
            <input type="email" placeholder="Email" name="email" value="" required>
            <?php
            if (isset($pass1)){
        ?>
            <div><?= $password ?></div>
        <?php
            }
        ?>
        <input type="password" placeholder="password" name="pass1" value="" required>

        <?php
            if (isset($pass2)){
        ?>
            <div><?= $password ?></div>
        <?php
            }
        ?>
        <input type="password" placeholder="password" name="pass2" value="" required>

        <button type="submit" name="modification">Modifier</button>
    </form>
