<?php
session_start();
$length = 32;
$_SESSION["token"] = substr(base_convert(sha1(uniqid(mt_rand())), 16, 36), 0, $length);
$_SESSION["token-expire"] = time() + 3600; 

$DATABASE_HOST = 'localhost';
$DATABASE_USER = 'root';
$DATABASE_PASS = '';
$DATABASE_NAME = 'form';

if (!isset($_POST["token"]) || !isset($_SESSION["token"]) || !isset($_SESSION["token-expire"])) {
    exit("Le jeton n'est pas défini!");
  }
   
 
  if ($_SESSION["token"]==$_POST["token"]) {
    
    if (time() >= $_SESSION["token-expire"]) {
      exit("Le jeton est expiré. vueillez relancer votre formulaire.");
    }
    
    else {
      unset($_SESSION["token"]);
      unset($_SESSION["token-expire"]);
      echo "OK";
    }
  }
  
  
  else {  

$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
if ( mysqli_connect_errno() ) {

	exit('Failed to connect to MySQL: ' . mysqli_connect_error());
}

if (!isset($_POST['username'], $_POST['password']) ) {
	
	exit('Veuillez saisir tous les champs!');
}

// Preparer la requette SQL pour prevenir les injections SQL.
if ($stmt = $con->prepare('SELECT id, password FROM accounts WHERE username = ?')) {
	$stmt->bind_param('s', $_POST['username']);
	$stmt->execute();
	$stmt->store_result();
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $password);
        $stmt->fetch();
        // Verification du mot de passe
        
        if (password_verify($_POST['password'], $password)) {
            // Verification reussie et l utilisateur est connecte
            // Creation de sessions pour enregistrer les connexions des utilisateurs; ca fonctionne comme les cookies
            $_SESSION['loggedin'] = TRUE;
            $_SESSION['name'] = $_POST['username'];
            $_SESSION['id'] = $id;
            echo 'Bienvenu ' . $_SESSION['name'] . '!';
           
        } else {
            // Incorrect password
            echo '<div class="alert alert-danger">
            <strong>Attention!</strong> Mot de passe incorrect! . 
            </div>';
        }
    } else {
        // Incorrect username
        echo '<div class="alert alert-danger">
                <strong>Attention!</strong> Identifiant  ou mot de passe incorrect! . 
                </div>';
    }


	$stmt->close();
}
}
?>