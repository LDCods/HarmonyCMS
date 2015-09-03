<?php
$titre = "Inscription";
include('include/init.php');
include('include/jso.php');
include('include/JSONAPI.php');
include('include/variables.php');

$passwordverif = $_POST['password'];
$passwordverif=preg_replace('/\s/', '', $passwordverif);
if($_POST) {
	
	/* SI IL EST PREMIUM SEULEMENT SI COCHER */
	if($onlyPremium == "true") {
	$valid_pseudo = file_get_contents('http://minecraft.net/haspaid.jsp?user='.$_POST['pseudo'].'', "r");
	}	

	/* SI IL EST CONNECTER SEULEMENT SI COCHER */
	if($isConnected == "true") {
	$EgetPseudoInfoServeur = $api->call('getPlayer', array(''.$_POST['pseudo'].''));
    $EgetPseudoInfoServeur = $EgetPseudoInfoServeur['success'];
    $EisOnlineTest = $EgetPseudoInfoServeur['ip'];
    if($EisOnlineTest != "offline") { 
        $EisOnline = "true";
    } else { 
        $EisOnline = "false"; 
    }
	}

    if($EisOnline == "true" OR $isConnected == "false") {
	if($valid_pseudo == "true" OR $onlyPremium == "false") {
	/* INSCRIPTION EN ELLE MEME */
	if($_POST['pseudo']!=NULL && $_POST['password']!=NULL && $_POST['email']!=NULL && $_POST['captcha']) {
		if($_POST['password'] == $_POST['password2']) {
			if(strlen($passwordverif)>4) {
				$code = strtoupper($_POST['captcha']);
				if(md5($code) == $_SESSION['captcha']) {
				$req_selectPseudo = $connexion->prepare('SELECT * FROM membres WHERE pseudo=:pseudo');
				$req_selectPseudo->execute(array(
					'pseudo' => $_POST['pseudo']
				));
				$selectPseudo = $req_selectPseudo->rowCount();
				
				$req_selectEmail = $connexion->prepare('SELECT * FROM membres WHERE email=:email');
				$req_selectEmail->execute(array(
					'email' => $_POST['email']
				));
				$selectEmail = $req_selectEmail->rowCount();
			
				if($selectEmail == "0" && $selectPseudo == "0") {
					$pseudo = htmlentities($_POST['pseudo'], ENT_QUOTES);
					$password = sha1($_POST['password']);
					$email = htmlentities($_POST['email']);
					$session = md5(rand());
					$pseudo=preg_replace('/\s/', '', $pseudo);
					$password=preg_replace('/\s/', '', $password);
					if(filter_var($email, FILTER_VALIDATE_EMAIL)) {
						$addMembre = $connexion->prepare('INSERT INTO membres SET pseudo=:pseudo, passe=:passe, email=:email, session=:session');
						$addMembre->execute(array(
								'pseudo' => $pseudo,
								'passe' => $password,
								'email' => $email,
								'session' => $session
						));
						setFlash('Votre compte a bien été créé vous pouvez désormais vous connectez', 'success');
						die('<META HTTP-equiv="refresh" content=0;URL=connexion.php>');						
					} else {
						$erreur = 'Veuillez renseignez une adresse mail valide !';
					}
				} else {
					$erreur = 'Ce pseudo ou cette adresse mail sont déjà utilisés';
				}
			} else { $erreur = 'Le code anti-robot entré n\'est pas valide'; }
			} else {
				$erreur = 'Veuillez avoir un mot de passe de plus de 5 caratères !';
			}
		} else {
			$erreur = 'Veuillez renseignez des mots de passe identiques !';
		}
	} else {
		$erreur = 'Veuillez remplir tous les champs !';
	} 
} else {
	$erreur = 'Veuillez avoir un compte minecraft premium pour vous inscrire !';
}
} else {
	$erreur = 'Veuillez être connecter sur le serveur pour vous inscrire !';
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
      <h1 style="text-align: center;font-family: minecraftiaregular;">Inscription</h1><br><br>
      <div class="boutique-corps">

<?php
if(!empty($erreur)) {
	echo '<div class="alert alert-error"><strong>Erreur:</strong> '.$erreur.'</div>';
}
?>
    <form method="post" class="form-horizontal">
    <div class="control-group">
    <label class="control-label" for="inputEmail">Nom d'utilisateur (pseudo en jeu)</label>
    <div class="controls">
    <input type="text" style="height: 30px;" name="pseudo" placeholder="Pseudo" value="<?php echo $_POST['pseudo']; ?>" required>
    </div>
    </div>
    <div class="control-group">
    <label class="control-label" for="inputPassword">Mot de passe</label>
    <div class="controls">
    <input type="password" style="height: 30px;" name="password" placeholder="Mot de passe" value="<?php echo $_POST['password']; ?>" required>
    </div>
    </div>
    <div class="control-group">
    <label class="control-label" for="inputPassword">Confirmation</label>
    <div class="controls">
    <input type="password" name="password2" style="height: 30px;" placeholder="Confirmation du mot de passe" value="<?php echo $_POST['password2']; ?>" required>
    </div>
    </div>
    <div class="control-group">
    <label class="control-label" for="inputEmail">Email</label>
    <div class="controls">
    <input type="text" name="email" style="height: 30px;" placeholder="Email" value="<?php echo $_POST['email']; ?>" required>
    </div>
    </div>
    <div class="control-group">
    <div class="controls">
    <img src="captcha.php" alt="Captcha" id="captcha">
    <img src="images/reloadc.png" alt="Recharger l'image" title="Recharger l'image" style="cursor:pointer;position:relative;top:-7px;" onclick="document.images.captcha.src='captcha.php?id='+Math.round(Math.random(0)*1000)" /><br><br>
    <input type="text" style="height: 30px;" name="captcha" placeholder="Recopiez le code ci-dessus" required><br>
	</div>
	</div>
    <div class="control-group">
    <div class="controls">
    <button type="submit" class="btn btn-success">S'inscrire</button>
    </div>
    </div>
    </form>
    </div>
<div id="push"></div>
</div>
    </div>
<?php include('include/menudroite.php'); ?>
    </div>
</div>
<div id="push"></div>
</div>
</div>
</div>
</div>
<?php 
include('include/footer.php'); ?>