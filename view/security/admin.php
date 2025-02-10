<?php
    
    $users = $result["data"]["users"];
   
    include VIEW_DIR."template/nav.php";

    
?>

<div>
    <table class='uk-table uk-table-hover' id='recap'>
        <thead id='category'>
            <tr id=title-category>
                <th id='title-user'>UTILISATEUR</th>
                <th id='title-reply'>Date d'inscription</th>
                <th id='title-view'>Status</th>
                <th id='title-view'>Rôle</th>
                <th id='title-view'>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php if(empty($users)){ ?> 
                <p>Aucun utilisateur trouvé.</p>
            <?php }else{ ?>    
                <?php foreach($users as $user){ ?>
                    <tr id='product-hover'>
                        <td><a href="index.php?ctrl=security&action=profile&id=<?= $user->getId() ?>"><img src="public/upload/<?= $user->getAvatar() ?>" class="status-img-nav"/><p><?= ucfirst($user->getNickName())?></p></a></td>
                        <td class="user-topic"><p><?= $user->getFormattedDateInscription() ?></p></td>
                        <td class="info-topic"><p><?= ucfirst($user->getIsBanned()) ?></p></td>
                        <td class="info-topic"><p><?= $user->getRole() ?></p></td>
                        <td class="info-topic">
                            <a href="#modal-role-<?= $user->getId() ?>" uk-toggle>Modifier Rôle</a>
                            <!-- modal -->
                            <div id="modal-role-<?= $user->getId() ?>" uk-modal>
                                <div class="uk-modal-dialog uk-modal-body">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h3 class="modal-title">Changer Rôle</h3>
                                            <hr>
                                            <a class="btn-close uk-modal-close close-close" ><i class="fa-solid fa-xmark"></i></a>
                                        </div>
                                        <div class="modal-body">
                                        <form action="index.php?ctrl=admin&action=changeRole" method="POST">
                                                <input type="hidden" name="id" value="<?= $user->getId() ?>" />
                                                
                                                <select name="role" id="role" required>
                                                    <option value="ROLE_USER" <?= ($user->getRole() == 'ROLE_USER') ? 'selected' : '' ?>>Utilisateur</option>
                                                    <option value="ROLE_ADMIN" <?= ($user->getRole() == 'ROLE_ADMIN') ? 'selected' : '' ?>>Administrateur</option>
                                                    <option value="SUPER_ADMIN" <?= ($user->getRole() == 'SUPER_ADMIN') ? 'selected' : '' ?>>Super Administrateur</option>
                                                </select>
                                                
                                                <button type="submit">Modifier</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php if ($user->getIsBanned() == 'actif'){ ?>
                                <!-- Si l'utilisateur n'est pas banni (isBanned est 'actif'), afficher un lien pour le bannir -->
                                <a href="index.php?ctrl=admin&action=banUser&id=<?= $user->getId() ?>">Bannir</a>
                            <?php } else { ?>
                                <!-- Si l'utilisateur est déjà banni (isBanned est différent de 'actif'), afficher un lien pour le débannir -->
                                <a href="index.php?ctrl=admin&action=unBanUser&id=<?= $user->getId() ?>">Débannir</a>
                            <?php } ?>
                        </td>
                    </tr>  
                <?php } ?>
            <?php } ?>
        </tbody>
    </table>
</div>