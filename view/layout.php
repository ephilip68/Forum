<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- Description du site pour le SEO -->
        <meta name="description" content="<?= $meta_description ?>">
        <title>SportLink</title><!--Titre de la page affiché dans l'onglet du navigateur -->
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel="stylesheet" href="<?= PUBLIC_DIR ?>/css/style.css">
        <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" integrity="sha256-h20CPZ0QyXlBuAw7A+KluUYx/3pK+c7lYEpqLTlxjYQ=" crossorigin="anonymous" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/uikit@3.21.13/dist/css/uikit.min.css" />
        <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
        <script src="https://cdn.tiny.cloud/1/zg3mwraazn1b2ezih16je1tc6z7gwp5yd4pod06ae5uai8pa/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
        <script type="text/javascript" src="https://platform-api.sharethis.com/js/sharethis.js#property=67924a889b23f5001271592d&product=inline-share-buttons&source=platform" async="async"></script>
    </head>

   
    <body>
        <!-- <div id="wrapper"> 
            <div id="mainpage"> -->

                <!-- <header>
                    
                    <nav>
                        <div id="">
                            <a href="/">Accueil</a> -->
                            <?php // if(App\Session::isAdmin()){ ?>
                                <!-- <a href="index.php?ctrl=home&action=users">Voir la liste des gens</a> -->
                            <?php 
                        // } 
                        ?>
                        <!-- </div>
                        <div id="nav-right">
                        
                        </div>
                    </nav>
                </header> -->
                
                <main id="forum">
                    
                    <?= $page 
                    ?>
                </main>
            <!-- </div> -->
            <!-- <footer>
                <p>&copy; <?= date_create("now")->format("Y") ?> - <a href="#">Règlement du forum</a> - <a href="#">Mentions légales</a></p>
            </footer> -->
        <!-- </div> -->
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

            //================ Prévisualiser une image ================//

            var previewPicture = function (e) {
                const input = e.target;  // L'élément input qui a déclenché l'événement

                // Obtenir la liste des fichiers téléchargés
                const files = input.files;

                // Vérifier s'il y a des fichiers téléchargés
                if (files && files.length > 0) {
                    const picture = files[0];  // Ici, on suppose qu'un seul fichier est téléchargé à la fois.

                    // Créer un objet FileReader pour lire le fichier
                    var reader = new FileReader();

                    // Quand la lecture du fichier est terminée
                    reader.onload = function (event) {
                        // On met à jour l'élément image correspondant
                        // On suppose que l'élément image a la même classe que l'élément input
                        var imgElements = document.querySelectorAll(`img.${input.dataset.target}`);
                        
                        imgElements.forEach(function(imgElement) {
                            imgElement.src = event.target.result; // Mettre à jour le src de chaque image
                        });
                    };

                    // Lire l'image comme une URL de type base64
                    reader.readAsDataURL(picture);
                }
            }

            // Ajouter un écouteur d'événements à chaque champ de fichier
            var fileInputs = document.querySelectorAll('input[type="file"]');
            fileInputs.forEach(function(input) {
                input.addEventListener('change', previewPicture);
            });

            //================ Menu burger ================//

            function menuMobile() {
                const btn = document.querySelector('.burger');
                const header = document.querySelector('.header');
                const links = document.querySelectorAll('.navbar a');

                btn.addEventListener('click', () => {
                    header.classList.toggle('show-nav');
                });

                links.forEach(link => {
                    link.addEventListener('click', () => {
                    header.classList.remove('show-nav');
                    });
                });
            }

            menuMobile();

 
        </script>
        <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v1.9.4/dist/alpine.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/uikit@3.21.13/dist/js/uikit.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/uikit@3.21.13/dist/js/uikit-icons.min.js"></script>
    </body>
</html>