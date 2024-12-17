
<body class="connexion"> 
    <div class="Content">
        <div class="formBox">
            <div class="title">
                <div id="content"><h1>Créer votre compte</h1></div>
            </div>
            <form class="formulaire" action="index.php?ctrl=security&action=register" method="POST">

                <label for="pseudo"></label>
                <i class="fa-solid fa-user user"> </i>
                <input class="input" type="text" name="nickName" id="pseudo" value="Pseudo">

                <label for="email"></label>
                <i class="fa-solid fa-envelope envelope"></i>
                <input class="input" type="email" name="email" id="email" value="Email">

                <label for="pass1"></label>
                <i class="fa-solid fa-unlock"></i>
                <input class="input" type="password" name="pass1" id="pass1" value="Mot de passe" >

                <label for="pass2"></label>
                <i class="fa-solid fa-lock"></i>
                <input class="input" type="password" name="pass2" id="pass2" value="Confirmer mot de passe">
                
                <input class="submit" type="submit" name="submit" value="Créer votre compte">

            </form>
            <div class="connecter">
                <p>Vous avez déja un compte ?</p>
                <a href="index.php?ctrl=security&action=login">Se connecter</a>
            </div>
        </div>
    </div>  
</body>

 


