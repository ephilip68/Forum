<?php
    
    $users = $result["data"]["users"];
    $page = $result["data"]["page"];
    $totalPages = $result["data"]["totalPages"];
   
    include VIEW_DIR."template/nav.php";

    
?>

<div class="container-home" >
    <div class="left-side-content">
        <div class="left-side-event">
            <div class="alert">
                <!-- c'est ici que les messages (erreur ou succès) s'affichent-->
                <?php 
                    $successMessage = App\Session::getFlash("success");
                    $errorMessage = App\Session::getFlash("error");
                    if($successMessage) { ?>
                    <div class="uk-alert-primary message" uk-alert>
                        <a href class="uk-alert-close" uk-close></a>
                        <p><?= $successMessage ?></p>
                    </div>
                <?php }elseif($errorMessage){ ?>
                    <div class="uk-alert-danger message" uk-alert>
                        <a href class="uk-alert-close" uk-close></a>
                        <p><?= $errorMessage ?></p>
                    </div>
                <?php }else{ ?>
                <?php } ?>
            </div>
            <div class="side-wrapper">
                <ul class="listNavEvent list-unstyled">
                    <div class="navEvent">
                        <h2 style="font-weight:700">Dashboard</h2>
                        <a href="#"><li class="listContent"><i class="fa-solid fa-calendar"></i><span>Accueil</span></li></a>
                    </div>
                    <div class="footerHome">
                        <a class="" href="#">A Propos</a> - 
                        <a class="" href="#">Règlement du forum</a> -  
                        <a class="" href="#">Mentions légales</a>  
                        -<small>&copy; <?= date_create("now")->format("Y") ?></small>
                    </div>
                </ul>   
            </div>
        </div>
    </div>
    <div class="main-container-event">
        <div class="timeline-event">
            <div class="timeline-center-event">
                <div class="pagination">
                    <h3>Liste des utilisateurs</h3>
                </div>
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
                                    <td class="user-topic"><a href="index.php?ctrl=security&action=profile&id=<?= $user->getId() ?>"><img src="public/upload/<?= $user->getAvatar() ?>" class="status-img-nav"/><p><?= ucfirst($user->getNickName())?></p></a></td>
                                    <td class="info-topic"><p><?= $user->getFormattedDateInscription() ?></p></td>
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
                <ul class="uk-pagination uk-flex-center" uk-margin>
                    <?php if ($page > 1) { ?>
                        <li><a href="index.php?ctrl=admin&action=users&page=<?= $page - 1; ?>"><span uk-pagination-previous></span></a></li>
                    <?php } else { ?>
                        <li class="uk-disabled"><span><span uk-pagination-previous></span></span></li>
                    <?php } ?>

                    <?php for ($pageNumber = 1; $pageNumber <= $totalPages; $pageNumber++) { ?>
                        <li class="<?= ($pageNumber == $page) ? 'uk-active' : ''; ?>">
                            <a href="index.php?ctrl=admin&action=users&page=<?= $pageNumber; ?>" <?= ($pageNumber == $page) ? 'aria-current="page"' : ''; ?>><?= $pageNumber ?></a>
                        </li>
                    <?php } ?>

                    <?php if ($page < $totalPages) { ?>
                        <li><a href="index.php?ctrl=admin&action=users&page=<?= $page + 1; ?>"><span uk-pagination-next></span></a></li>
                    <?php } else { ?>
                        <li class="uk-disabled"><span><span uk-pagination-next></span></span></li>
                    <?php } ?>
                </ul>
            </div>
        </div>
    </div>            
</div>