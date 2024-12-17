<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="<?= $meta_description ?>">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <script src="https://cdn.tiny.cloud/1/zg3mwraazn1b2ezih16je1tc6z7gwp5yd4pod06ae5uai8pa/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
        <link rel="stylesheet" href="style.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" integrity="sha256-h20CPZ0QyXlBuAw7A+KluUYx/3pK+c7lYEpqLTlxjYQ=" crossorigin="anonymous" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/uikit@3.21.13/dist/css/uikit.min.css" />
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="<?= PUBLIC_DIR ?>/css/style.css">
        <script src="public/js/script.js"></script>
        <title>SportLink</title>
    </head>
    <header class="header">
        <div class="headerContent d-flex">
            <div class="logo">
                <img src="public/img/logo-erwin.png" alt="" width="150px" heigh="50px">
            </div>
            <div class="center">
                <div class="scroller">
                    <ul class="menu list-unstyled">
                        <a href="index.php?ctrl=home&action=home"><li class="menuList"><i class="fa-solid fa-house"></i>Accueil</li></a>
                        <a href="#"><li class="menuList"><i class="fa-solid fa-message"></i>Messagerie</li></a>
                        <a href="#"><li class="menuList"><i class="fa-solid fa-bell"></i>Notifications</li></a>
                        <a href="index.php?ctrl=forum"><li class="menuList"><i class="fa-solid fa-pen-to-square"></i>Communauté</li></a>
                    </ul>
                </div>
            </div>
            <div class="burgerList">
                <button class="burger"><span class="bar"></span></button>
            </div>
            <nav class="navbar">
                <ul class="menuBurger list-unstyled">
                    <?php
                        // si l'utilisateur est connecté 
                        if(App\Session::getUser()){
                            ?>
                            <li><a href="index.php?ctrl=security&action=profile"><span class="fas fa-user"></span>&nbsp;<?= App\Session::getUser()?></a></li>
                            <li><a href="#">Paramètres</a></li>
                            <li><a href="index.php?ctrl=security&action=logout">Déconnexion</a></li>
                            <?php
                        }
                        else{
                            ?>
                            <li><a href="index.php?ctrl=security&action=login">Connexion</a></li>
                            <li><a href="index.php?ctrl=security&action=register">Inscription</a></li>
                            <!-- <a href="index.php?ctrl=forum&action=index">Liste des catégories</a>
                            <a href="index.php?ctrl=publication&action=index">Liste des publications</a> -->
                        <?php
                        }
                    ?> 
                </ul>
            </nav>
        </div>
    </header>
    <body>
        <div id="wrapper"> 
            <div id="mainpage">
                <!-- c'est ici que les messages (erreur ou succès) s'affichent-->
                <h3 class="message" style="color: red"><?= App\Session::getFlash("error") ?></h3>
                <h3 class="message" style="color: green"><?= App\Session::getFlash("success") ?></h3>
                <header>
                    
                    <nav>
                        <div id="">
                            <a href="/">Accueil</a>
                            <?php
                            // if(App\Session::isAdmin()){
                                ?>
                                <a href="index.php?ctrl=home&action=users">Voir la liste des gens</a>
                            <?php 
                        // } 
                        ?>
                        </div>
                        <div id="nav-right">
                        
                        </div>
                    </nav>
                </header>
                
                <main id="forum">
                    <?= $page ?>
                </main>
            </div>
            <!-- <footer>
                <p>&copy; <?= date_create("now")->format("Y") ?> - <a href="#">Règlement du forum</a> - <a href="#">Mentions légales</a></p>
            </footer> -->
        </div>
        <script
            src="https://code.jquery.com/jquery-3.4.1.min.js"
            integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
            crossorigin="anonymous">
        </script>
        <script>
            $(document).ready(function(){
                $(".message").each(function(){
                    if($(this).text().length > 0){
                        $(this).slideDown(500, function(){
                            $(this).delay(3000).slideUp(500)
                        })
                    }
                })
                $(".delete-btn").on("click", function(){
                    return confirm("Etes-vous sûr de vouloir supprimer?")
                })
                tinymce.init({
                    selector: '.post',
                    menubar: false,
                    plugins: [
                        'advlist autolink lists link image charmap print preview anchor',
                        'searchreplace visualblocks code fullscreen',
                        'insertdatetime media table paste code help wordcount'
                    ],
                    toolbar: 'undo redo | formatselect | ' +
                    'bold italic backcolor | alignleft aligncenter ' +
                    'alignright alignjustify | bullist numlist outdent indent | ' +
                    'removeformat | help',
                    content_css: '//www.tiny.cloud/css/codepen.min.css'
                });
            })
        </script>
        <script src="https://cdn.jsdelivr.net/npm/uikit@3.21.13/dist/js/uikit.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/uikit@3.21.13/dist/js/uikit-icons.min.js"></script>
        <script src="<?= PUBLIC_DIR ?>/js/script.js"></script>
    </body>
</html>