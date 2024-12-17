<?php

// var_dump($_SESSION);
?>
<body class="connexion"> 
    <div class="Content">
        <div class="formBox2">
            <div class="title">
                <div id="content">
                    <h1>Connectez-vous</h1>
                </div>
                <button class="forget">
                    <a class="googleConnect" href="#">
                        <img src="public/img/google.png" alt="logo google">
                        Se connecter avec Google  
                    </a>
                </button>
            </div>
            <div class="separation">
                <div class="divider3"></div>
                <span>OU</span>
                <div class="divider4"></div>
            </div>

            <form class="formulaire2" action="index.php?ctrl=security&action=login" method="POST">

                <label for="email"></label>
                <input class="input2" type="email" name="email" id="email" value="Adresse email">

                <label for="pass1"></label>
                <input class="input2" type="password" name="password" id="pass1" value="Mot de passe" >
                
                <input class="submit" type="submit" name="submit" value="Se connecter"> 
                
                <div class="forget2">
                    <a href="#">Mot de passe oublié ?</a>
                </div>

            </form>
           
            <div class="connecter">
                <p>Vous n'avez pas de compte ?</p>
                <a href="index.php?ctrl=security&action=login">Inscrivez-vous</a>
            </div>
        </div>
    </div>  
</body>