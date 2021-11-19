<?php
$DATABASE_HOST = 'localhost';
$DATABASE_USER = 'root';
$DATABASE_PASS = '';
$DATABASE_NAME = 'phplogin';

$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
if (!isset($_POST["token"]) || !isset($_SESSION["token"]) || !isset($_SESSION["token-expire"])) {
    exit("Le jeton n'est pas défini!");
  }
   
 
  if ($_SESSION["token"]==$_POST["token"]) {
    
    if (time() >= $_SESSION["token-expire"]) {
      exit("Le jeton est expiré. vueillez relancer votre formulaire.");
    }
    
    else {
      unset($_SESSION["token"]);
      unset($_SESSION["token-expiré"]);
      echo "OK";
    }
  }
  
  
  else {  
if (mysqli_connect_errno()) {
	exit('Connexion a MySQL echouée:  ' . mysqli_connect_error());
}


// vérifier la saisie de données.
if (!isset($_POST['username'], $_POST['password'], $_POST['email'])) {
	exit('Vueillez saisir tous les champs!');
}
// vérifier si les champs ne sont pas vides.
if (empty($_POST['username']) || empty($_POST['password']) || empty($_POST['email'])) {
	exit('Vueillez completer la saisie des champs!');
}


// Vérification de l'existence d'un compte pour un identifiant.
if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
	exit('Adresse mail non valide!');
}
if (preg_match('/^[a-zA-Z0-9]+$/', $_POST['username']) == 0) {
    exit('Identifiant non valide!');
}

if (strlen($_POST['password']) > 18 || strlen($_POST['password']) < 8) {
	exit('Le mot de passe doit avoir entre 8 et 18 caracteres!');
}
if ($stmt = $con->prepare('SELECT id, password FROM accounts WHERE username = ?')) {
	$stmt->bind_param('s', $_POST['username']);
	$stmt->execute();
	$stmt->store_result();
	if ($stmt->num_rows > 0) {
		echo 'Identifiant existant, vueillez saisir un autre!';
	} else {
if ($stmt = $con->prepare('INSERT INTO accounts (username, password, email) VALUES (?, ?, ?)')) {
	//Pour ne pas exposer le mot de passe dans la bdd, on applique le hashage We do not want to expose passwords in our database, et utiliser password_verify quand un utilisateur s'identifie.
	$password = password_hash($_POST['password'], PASSWORD_DEFAULT);
	$stmt->bind_param('sss', $_POST['username'], $password, $_POST['email']);
	$stmt->execute();
	echo 'Inscription avec succés, vous pouvez vous connecter!';
    // Requete SQL ne peut etre executée.
} else {
	echo 'Erreur!';
}
	}
	$stmt->close();
} else {
	// Requete SQL ne peut etre executée.
	echo 'Erreur!';
}
$con->close();
  }
?>
