<?php
$titre = "Mot de passe oublié";
include('include/init.php');
// ---------------------------------------------------------------------
//	Générer un mot de passe aléatoire
// ---------------------------------------------------------------------
function genererMDP ($longueur = 8){
	// initialiser la variable $mdp
	$mdp = '';

	// Définir tout les caractères possibles dans le mot de passe, 
	// Il est possible de rajouter des voyelles ou bien des caractères spéciaux
	$possible = "2346789bcdfghjkmnpqrtvwxyzBCDFGHJKLMNPQRTVWXYZ";

	// obtenir le nombre de caractères dans la chaîne précédente
	// cette valeur sera utilisé plus tard
	$longueurMax = strlen($possible);

	if ($longueur > $longueurMax) {
		$longueur = $longueurMax;
	}

	// initialiser le compteur
	$i = 0;

	// ajouter un caractère aléatoire à $mdp jusqu'à ce que $longueur soit atteint
	while ($i < '8') {
		// prendre un caractère aléatoire
		$caractere = substr($possible, mt_rand(0, $longueurMax-1), 1);

		// vérifier si le caractère est déjà utilisé dans $mdp
		if (!strstr($mdp, $caractere)) {
			// Si non, ajouter le caractère à $mdp et augmenter le compteur
			$mdp .= $caractere;
			$i++;
		}
	}

	// retourner le résultat final
	return $mdp;
}
if($_POST) { 
	$req_Email = $connexion->query('SELECT * FROM membres WHERE email=\'' . $_POST['email'] . '\'');
    $valid_email = $req_Email->rowCount();
    if($valid_email != '0') {
    	$newpassword = genererMDP($longueur = 8);
    	$newpasswordE = sha1($newpassword);
    	$update_password = $connexion->query("UPDATE membres SET passe='" . $newpasswordE . "' WHERE email='" . $_POST['email'] . "'");
    	$req_selectLost = $connexion->prepare('SELECT * FROM membres WHERE email=:email');
    	$req_selectLost->execute(array(
    		'email' => $_POST['email']
    	));
    	$selectLost = $req_selectLost->fetch();
        $pseudoLost = $selectLost['pseudo'];
		
		$to = $_POST['email'];
		$subject = 'Mot de passe oublié | '.$nom.'';
		$message = 'Bonjour,

Comme vous l\'avez demandé votre mot de passe sur le site '.$nom.' a été rénitialisé et remplacer par le mot de passe ci-dessous
Nouveau mot de passe: '.$newpassword.' (Il est conseiller de le changer pour mieux le mémoriser)

Récapitulatif de vos informations :
Pseudo: '.$pseudoLost.'
Mot de passe: '.$newpassword.'

Cordialement, l\'équipe du site '.$nom.'.
Ce mail est un mail automatique veuillez ne pas répondre a l\'email.';
		$headers = 'From: '.$nom.' <noreply@eywek.fr>' . "\r\n" .
     	'Reply-To: noreply@eywek.fr' . "\r\n" .
     	'X-Mailer: PHP/' . phpversion();
		
		if(mail($to, $subject, $message, $headers)) {
		setFlash('Un email avec un nouveau mot de passe a été envoyé !', 'danger');
    	header('Location: connexion.php?msg=lost:ok');
    	exit();
    	} else {
    		setFlash('L\'email n\'a pas été envoyé veuillez réessayez', 'danger');
    		header('Location: connexion.php?msg=emaillost:false');
    		exit();
    	}
    	
   	} else {
   		setFlash('Veuillez renseignez un email correct !', 'danger');
   		header('Location: connexion.php?msg=lost:false');
    	exit();
   	}
}


?>