<?php
session_start();
@$password= md5(htmlentities($_POST['password']));
@$username=htmlentities($_POST['username']);
@$email=htmlentities($_POST['email']);
@$passwordrepaet=md5(htmlentities($_POST['passwordrepaet']));
$verifier_mot_passe=true;//pour verifier si tous les condition sont satisfaites
$verifier_email=true;
$verifier_username=true;

?>


<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
        <div class="inner" style=" height: 500px">
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
                                    <h3>Créez votre compte !</h3>
                                </div>
                <form action="" method="post" autocomplete="off">
                    
                    <i class="fas fa-user icon"></i> 
                    <input type="text" name="username" placeholder="Votre Nom" required>
                    <i class="fas fa-envelope icon"></i>
                    
                    <?php 
                    if (isset($_POST['submit'])) {
                       
                        if (preg_match('/^[a-zA-Z0-9]+$/', $_POST['username']) == 0) {
                            echo'Identifiant non valide!';
                            $verifier_username=false;
                        }
                    }
                    
                    
	                ?>
                    <input type="email" name="email" placeholder="Votre e-mail" required>
                    <i class="fas fa-lock icon"></i> 
                    <?php 
                    if (isset($_POST['submit'])) {
                       
                        if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
                            echo"Adresse mail non valide!";
                            $verifier_email=false;
                        }
                    }
                    
                    
	                ?>
                  
                
                    <input type="password" name="password" placeholder="Creez un mot de passe" required>
                    <?php 
                    if (isset($_POST['submit'])) {
                       
                        if (strlen($_POST['password']) > 18 || strlen($_POST['password']) < 8) {
                            echo'Le mot de passe doit avoir entre 8 et 18 caracteres!';
                            $verifier_mot_passe=false;
                        }
                    }
                    
                    
	                ?>
                  
                    
                   
                    <div class="action-btn">
                       
                        <button type="submit" name="submit" value="inscription" class="btn">Inscription</button>
                        <?php
                        
                        
                        if (isset($_POST['submit'])) {
                            //on ajoute un client a la base de donnees si seulement tout les champs sont valides 

                            if ($verifier_username==true && $verifier_mot_passe==true) {
                            $bdd=new PDO('mysql:host=localhost;dbname=form;charset=utf8','root','',array(PDO:: ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
                            $req=$bdd->prepare('INSERT INTO accounts(username,email,password) VALUES (?,?,?)');
                            $req->execute(array(@$username,@$email,@$password));
                            echo '<div class="alert alert-success">
                        <strong>Félicitations!</strong> Votre compte a été crée. 
                        </div>';
                                }
                            }
                        ?>
                    </div>
                </form>
            </div>
        </div>
</body>
</html>