<?php
$titre = "Modifier son profil";
include('include/init.php');
if(connect()) { 
$passwordverif = $_POST['mdp1'];
$passwordverif=preg_replace('/\s/', '', $passwordverif);
	if($_POST) {
		if(!empty($_POST['mdp1'])) {
			if($_POST['mdp1'] == $_POST['mdp2']) {
				if(strlen($passwordverif)>4) {
					$mdp = sha1($_POST['mdp1']);	
					$mdp=preg_replace('/\s/', '', $mdp);
					$updateMembre = $connexion->prepare('UPDATE membres SET passe=:passe WHERE pseudo=:pseudo');
					$updateMembre ->execute(array(
						'passe' => $mdp,
						'pseudo' => $pseudo,
					));
				} else {
					$erreur = "Veuillez avoir un mot de passe de plus de 5 caratères !";
				}
			} else {
				$erreur = "Veuillez renseignez des mots de passe identiques !";
			}
			$success = "1";
		}
		$email = htmlspecialchars($_POST['email'], ENT_QUOTES);
		if(!empty($_POST['email'])) {
			if(filter_var($email, FILTER_VALIDATE_EMAIL)) {	
				$updateMembre = $connexion->prepare('UPDATE membres SET email=:email WHERE pseudo=:pseudo');
				$updateMembre ->execute(array(
					'email' => htmlentities($_POST['email'], ENT_QUOTES),
					'pseudo' => $pseudo,
				));
			} else {
				$erreur = "Veuillez renseignez une adresse mail valide !";
			}
			$success = "1";
		}	
	}
	
include('include/header.php'); 
?>
<!-- HEADER DE LA PAGE --> 
<div class="container">
  <div class="page-header">
           <!-- =========== ALERTE ========= -->
<?php
if(!empty($erreur)) {
	echo '<div class="alert alert-error"><strong>Erreur:</strong> '.$erreur.'</div><br><br>';
}
if(!empty($success)) {
	echo '<div class="alert alert-success"><strong>Succès:</strong> Votre compte a bien été modifié. <a class="btn btn-success pull-right" style="margin-top: -5px;" href="profil.php">Retournez sur votre profil</a></div><br><br>';
}
?>
<!-- ======== CONTENUE DE LA PAGE ========== -->
  </div>
  <div class="row-fluid">
    <div class="span8">
      <div class="news-plugin">
      <h1 style="text-align: center;font-family: minecraftiaregular;">Profil</h1><br>
      <div class="boutique-corps" style="height: 500px;">
      	<h3 style="color: #175084;float: right;margin-right: 80px;">Modifier vos informations :</h3>
    <img style="float:left" src="http://www.craftmycms.fr/ressources/skin3d.php?a=0&w=0&wt=0&abg=0&abd=0&ajg=0&ajd=0&ratio=15&format=png&displayHairs=true&headOnly=false&login=<?php echo $pseudo; ?>"><br><br>
    <br><br><br>
    <form method="post" class="form-horizontal pull-right" style="height: 200px;width: 370px;margin-right: 39px;">
    
    <div class="control-group">
    <label class="control-label" for="inputMDP1">Mot de passe&nbsp;&nbsp;&nbsp;&nbsp;</label>
    <div class="controls">
    <input type="password" name="mdp1" placeholder="Mot de passe">
    </div>
    </div>
    
    <div class="control-group">
    <label class="control-label" for="inputMDP2">Confirmation</label>
    <div class="controls">
    <input type="password" name="mdp2" placeholder="Confirmation du mot de passe">
    </div>
    </div>
    
    <div class="control-group">
    <label class="control-label" for="inputEMAIL">Email</label>
    <div class="controls">
    <input type="text" name="email" placeholder="Email">
    </div>
    </div>
    
    <div class="control-group">
    <div class="controls">
    <button type="submit" class="btn btn-success">Modifier les informations</button>
    </div>
    </div>
    
    </form>
    </div>
    </div>
</div>
<?php include('include/menudroite.php'); ?>
<div id="push"></div>
</div>
</div>
</div>
</div>
<?php 
include('include/footer.php');
} else {
	setFlash('Veuillez vous connectez pour avoir accès a la page demandée !', 'danger');
	header('Location: connexion.php'); 
} ?>