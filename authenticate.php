<?php
session_start();
//On génére un jeton totalement unique (c'est capital :D)
$token = uniqid(rand(), true);
//Et on le stocke
$_SESSION['token'] = $token;
//On enregistre aussi le timestamp correspondant au moment de la création du token
$_SESSION['token_time'] = time();

$DATABASE_HOST = 'localhost';
$DATABASE_USER = 'root';
$DATABASE_PASS = '';
$DATABASE_NAME = 'phplogin';
// Se connecter a localhost.
$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
if ( mysqli_connect_errno() ) {
	exit('Connexion a MySQL echouée: ' . mysqli_connect_error());
}


// Verification de la disponibilité des données.
if ( !isset($_POST['username'], $_POST['password']) ) {
	
	exit('Veuillez saisir tous les champs!');
}


// Preparer la requette SQL pour prevenir les injections SQL.
if ($stmt = $con->prepare('SELECT id, password FROM accounts WHERE username = ?')) {
	$stmt->bind_param('s', $_POST['username']);
	$stmt->execute();
	// sauvegarde du résulta pour la vérification de  l existence du compte dans la bdd.
	$stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $password);
        $stmt->fetch();
        // Compte existe, donc on verifie le mdp.
        if (password_verify($_POST['password'], $password)) {
            // Verification réussie! l'utilisateur est connecté!
            // Creation de sessions pour enregistrer les connexions des utilisateurs; ca fonctionne comme les cookies
            session_regenerate_id();
            $_SESSION['loggedin'] = TRUE;
            $_SESSION['name'] = $_POST['username'];
            $_SESSION['id'] = $id;
            echo 'Bienvenue ' . $_SESSION['name'] . '!';
        } else {
            // Mot de passe incorrect
            echo 'Mot de passe incorrect!';
        }
    } else {
        // Identifiant incorrect 
        echo 'Identifiant  ou mot de passe incorrect!';
    }


	$stmt->close();
}


//On va vérifier :
//Si le jeton est présent dans la session et dans le formulaire
//if(isset($_SESSION['token']) && isset($_SESSION['token_time']) && isset($_POST['token']))
//{
	//Si le jeton de la session correspond à celui du formulaire
	//if($_SESSION['token'] == $_POST['token'])
	//{
		//On stocke le timestamp qu'il était il y a 15 minutes
		//$timestamp_ancien = time() - (15*60);
		//Si le jeton n'est pas expiré
		//if($_SESSION['token_time'] >= $timestamp_ancien)
		//{
			//Si le referer est bon
			//if($_SERVER['HTTP_REFERER'] == 'http://localhost/phplogin/index.php')
			//{
				//
			//}
		//}
	//}
//}
//
?>
