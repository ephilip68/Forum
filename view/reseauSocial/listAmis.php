<?php
    $friends = $result["data"]["friends"];
    
    include VIEW_DIR."template/nav.php";
?>

<div class="container-home" >
    <div class="left-side-content">
        <div class="left-side-event">
            <div class="side-wrapper">
                <ul class="listNavEvent list-unstyled">
                    <div class="navEvent">
                        <h2 style="font-weight:700">Ami(e)s</h2>
                        <li class="listContent"><i class="fa-solid fa-user-group"></i><span>Accueil</span></li>
                        <li class="listContent"><i class="fa-solid fa-user"></i><span>Liste d'ami(e)s</span>
                        <a href="index.php?ctrl=publication&action=listAmis" class="toggle-friends" data="<?= App\Session::getUser()->getId() ?>">
                            <?php if (isset($_GET['id_user']) && $_GET['id_user'] == App\Session::getUser()->getId()) { ?>
                                <i class="fa-solid fa-chevron-up"></i>
                            <?php } else { ?>
                                <i class="fa-solid fa-chevron-down"></i> 
                            <?php } ?>
                        </a>
                        <div class="friends" data="<?= App\Session::getUser()->getId() ?>" style="display: <?= isset($_GET['id_user']) && $_GET['id_user'] == App\Session::getUser()->getId() ? 'block' : 'none' ?>;">
                            <?php foreach($friends as $friend) { ?>
                                <div class="profilFriendsMenu">
                                    <div>
                                        <img src="public/upload/<?=$friend->getAvatar()?>" class="status-img-nav"/>
                                        <a href="index.php?ctrl=publication&action=listProfils&id=<?= $friend->getId() ?>"><?= ucfirst($friend->getNickName()) ?></a>
                                    </div>
                                    <div class="friendsOptions">
                                        <i class="fa-solid fa-ellipsis"></i>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
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
</div>
<script>

document.addEventListener('DOMContentLoaded', function () {
        // Récupérer tous les liens de "toggle-comments"
        var toggleLinks = document.querySelectorAll('.toggle-friends');

        toggleLinks.forEach(function(link) {
            // Ajouter un événement de clic pour chaque lien
            link.addEventListener('click', function(e) {
                e.preventDefault();  // Empêche le comportement par défaut (rechargement de la page)

                var userId = link.getAttribute('data');  // Récupérer l'ID du commentaire
                var friends = document.querySelector('.friends[data= "' + userId + '"]');  // Sélectionner le div des sous-commentaires par ID
                var chevronIcon = link.querySelector('i');  // L'icône du chevron

                // Vérifier si les sous-commentaires sont déjà visibles
                if (friends.style.display === 'none' || friends.style.display === '') {
                    // Afficher les sous-commentaires et changer l'icône du chevron
                    friends.style.display = 'block';
                    chevronIcon.classList.remove('fa-chevron-down');
                    chevronIcon.classList.add('fa-chevron-up');
                    link.innerHTML = '<i class="fa-solid fa-chevron-up"></i>';
                } else {
                    // Masquer les sous-commentaires et changer l'icône du chevron
                    friends.style.display = 'none';
                    chevronIcon.classList.remove('fa-chevron-up');
                    chevronIcon.classList.add('fa-chevron-down');
                    link.innerHTML = '<i class="fa-solid fa-chevron-down"></i>';
                }
            });
        });
    });
</script>
