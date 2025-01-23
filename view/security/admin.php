<?php
    
    $users = $result["data"]["users"];
   
    include VIEW_DIR."template/nav.php";

    
?>

<div>
    <?php foreach($users as $user) { ?>

        <p><?= $user->getNickName()?></p>

    <?php } ?>

</div>