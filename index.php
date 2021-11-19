


<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="icon" href="images/png.png" type="image/png">
</head>
<body>
        <div class="inner" style=" height: 450px">
            <div class="photo">
                <img src="images/interface.png">
            </div>
            <div class="user-form">
            <div class="clearfix"></div>
				
                <div class="margin-top-70"></div>
<div class="container">
                    <div class="row">
                        <div class="col-xl-6 offset-xl-3">
                            <div class="login-register-page">
                                <div class="welcome-text">
                                    <h3>Heureux de vous revoir !</h3>
                                    <span>Vous n'avez pas de compte? <a href="register.html" id="registration" style="text-decoration:none; color: #93c751">Inscrivez-vous !</a></span>
                                </div>
                              
                <form action="authenticate.php" method="post">
                
                    <i class="fas fa-user icon"></i> 
                    <input type="text" name="username" placeholder="Identifiant" id="username" required>
                    <i class="fas fa-lock icon"></i> 
                    <input type="password" name="password" placeholder="Mot de passe" id="password" required> 
                    <input type="hidden" name="token" id="token" value="<?php
                    //Le champ caché a pour valeur le jeton csrf
                    echo $token;
                        ?>"/>
                   
                   
                    <div class="action-btn">
                       
                        <input class="btn" type="submit" value="Connexion">
			 <input class="btn" type="reset" value="Annuler">
                    </div>
                  
                </form>
            </div>
        </div>


</body>
</html>
