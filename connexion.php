<?php
$titre = "Connexion";
include('include/init.php');


if($_POST) {
		$password = sha1($_POST['password']);
		$pseudo = htmlentities($_POST['pseudo'], ENT_QUOTES);
		$pseudo=preg_replace('/\s/', '', $pseudo);

		$req_nbrMembre = $connexion->prepare('SELECT * FROM membres WHERE pseudo=:pseudo AND passe=:password');
		$req_nbrMembre->execute(array(
			'pseudo' => $pseudo,
			'password' => $password
		));
		$nbrMembre = $req_nbrMembre->rowCount();
		if($nbrMembre>0) {
			$session = md5(rand());

			$updateMembre = $connexion->prepare('UPDATE membres SET session=:session WHERE pseudo=:pseudo AND passe=:passe');
			$updateMembre->execute(array(
				'pseudo' => $pseudo,
				'passe' => $password,
				'session' => $session
			));
			$_SESSION['session'] = $session;
			//$ref = $_SERVER["HTTP_REFERER"];
			$ref = "index.php";
			header('Location: '.$ref.'');
			exit();
	} else { 
		$erreur = 'Vous avez entrez des mauvais identifiants veuillez réessayez';
	}
}

include('include/header.php');
?>
<!-- HEADER DE LA PAGE --> 
<div class="container">
  <div class="page-header">
<!-- ======== CONTENUE DE LA PAGE ========== -->
  </div>
  <div class="row-fluid">
    <div class="span8">
      <div class="news-plugin">
      <h1 style="text-align: center;font-family: minecraftiaregular;">Connexion</h1><br><br>
      <div class="boutique-corps">
<?php
flash();
if(!empty($erreur)) {
	echo '<div class="alert alert-error"><strong>Erreur:</strong> '.$erreur.'</div>';
}
?>
<form method="post">
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Pseudo: <input type="text" name="pseudo" required><br>
	Mot de Passe: <input type="password" name="password" required><br><br>
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<input style="padding:8" class="btn btn-primary btn-medium" type="submit" value="Connexion">&nbsp;&nbsp;<a href="#lostpassword" role="button" data-toggle="modal">Mot de passe oublié</a>
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
<!-- ============= LOST PASSWORD =========== -->
<div id="lostpassword" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="lostpasswordLabel" aria-hidden="true">
    <div class="modal-header">
      <button class="close" data-dismiss="modal" aria-hidden="true">×</button>
      <h3 class="lead">Mot de passe oublié</h3> 
    </div>
    <div class="modal-body">
    	<p class="lead">Veuillez rentrer l'adresse email avec laquelle vous vous êtes inscrit</p>
    <div id="message_Inscription"></div>
      <form class="form-horizontal" method="post" action="lostpassword.php">
        <div class="control-group">
          <label class="control-label" for="emailregister">Email</label>
          <div class="controls">
            <input type="text"  name="email" style="height: 30px;">
          </div>
        </div>        
    </div>
    <div class="modal-footer">
      <button class="btn lead" data-dismiss="modal"  aria-hidden="true">Annuler</button>
      <button type="submit" class="btn btn-success lead">Valider</button>
    </form>
    </div>
  </div>
<?php 
include('include/footer.php'); ?>