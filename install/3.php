<?php 
include('../include/bdd.php');
include('../include/init.php');
if($etape_1 == "ok") {
$req_selectEtape = $connexion->query('SELECT * FROM installation');
$selectEtape = $req_selectEtape->fetch();
$etape = $selectEtape['etape_actuelle'];
if($etape != "3") {
  if($etape >= "1") {
    header("Location: $etape.php");
    exit();
  } else {
    header('Location: ../install');
    exit();
  }
}
}

if($_POST) {
  if(!empty($_POST['pseudo']) AND !empty($_POST['mdp']) AND !empty($_POST['mdp2']) AND !empty($_POST['email'])) {
    if($_POST['mdp'] == $_POST['mdp2']) {
          $pseudo = htmlspecialchars($_POST['pseudo'], ENT_QUOTES);
          $password = sha1($_POST['mdp']);
          $email = htmlspecialchars($_POST['email'], ENT_QUOTES);
          $session = md5(rand());
          $pseudo=preg_replace('/\s/', '', $pseudo);
          $password=preg_replace('/\s/', '', $password);
          $rang = '3';
          if(filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $addMembre = $connexion->prepare('INSERT INTO membres SET pseudo=:pseudo, passe=:passe, email=:email, rang=:rang, session=:session');
            $addMembre->execute(array(
                'pseudo' => $pseudo,
                'passe' => $password,
                'email' => $email,
                'rang' => $rang,
                'session' => $session
            ));
            $etape_actuelle = '4';
            $addEtape = $connexion->prepare("UPDATE installation SET etape_actuelle=:etape_actuelle");
            $addEtape->execute(array(
                'etape_actuelle' => $etape_actuelle
            ));
            header('location: 4.php');
            exit();
          } else {
            $erreur = "Veuillez rentrer un email valide !";
          }
    } else {
      $erreur = "Veuillez renseignez des mot de passe valides !";
    }
  } else {
    $erreur = "Veuillez remplir tout les champs !";
  }
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>LapisCraft | Installation</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Valentin TOUFFET, Eywek, mineconstructe">

    <!-- Le styles -->
    <link href="../bootstrap/css/bootstrap.css" rel="stylesheet">
    <style type="text/css">
      body {
        padding-top: 40px;
        padding-bottom: 40px;
        background-color: #f5f5f5;
      }

      .form-signin {
        padding: 19px 29px 29px;
        margin: 0 auto 20px;
        background-color: #fff;
        border: 1px solid #e5e5e5;
        -webkit-border-radius: 5px;
           -moz-border-radius: 5px;
                border-radius: 5px;
        -webkit-box-shadow: 0 1px 2px rgba(0,0,0,.05);
           -moz-box-shadow: 0 1px 2px rgba(0,0,0,.05);
                box-shadow: 0 1px 2px rgba(0,0,0,.05);
      }
      .form-signin .form-signin-heading,
      .form-signin .checkbox {
        margin-bottom: 10px;
      }
      .form-signin input[type="text"],
      .form-signin input[type="password"] {
        font-size: 16px;
        height: auto;
        margin-bottom: 15px;
        padding: 7px 9px;
      }

    </style>
    <link href="../bootstrap/css/bootstrap-responsive.css" rel="stylesheet">

    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="../assets/js/html5shiv.js"></script>
    <![endif]-->
  </head>

  <body>

    <div class="container">

      <form class="form-signin" method="post" style="width: 900px;">
        <center><h2 class="form-signin-heading">Etape 3 - Compte Administrateur</h2></center>
      <center>
        <p class="lead">Ce compte sera automatiquement Administrateur.</p>
        <div class="well">
          <?php if(!empty($erreur)) { ?>
          <div class="alert alert-error"><?php echo $erreur; ?></div>
          <?php } ?>
          <?php if(!empty($success)) { ?>
          <div class="alert alert-success"><?php echo $success; ?></div>
          <?php } ?>
          <form class="form-horizontal" method="post">
            <div class="control-group">
            <label class="control-label">Nom d'utilisateur</label>
            <div class="controls">
            <input type="text" name="pseudo" placeholder="Votre pseudo en jeu" value="<?php if(!empty($_POST['pseudo'])) { echo $_POST['pseudo']; } ?>" required>
            </div>
            </div>
            <div class="control-group">
            <label class="control-label">Mot de Passe</label>
            <div class="controls">
            <input type="password" name="mdp" placeholder="Mot de passe" value="<?php if(!empty($_POST['mdp'])) { echo $_POST['mdp']; } ?>" required>
            </div>
            </div>
            <div class="control-group">
            <label class="control-label">Confirmation</label>
            <div class="controls">
            <input type="password" name="mdp2" placeholder="Mot de passe" value="<?php if(!empty($_POST['mdp2'])) { echo $_POST['mdp2']; } ?>" required>
            </div>
            </div>
            <div class="control-group">
            <label class="control-label">Email</label>
            <div class="controls">
            <input type="text" name="email" placeholder="Votre email" value="<?php if(!empty($_POST['email'])) { echo $_POST['email']; } ?>" required>
            </div>
            </div>
            <div class="control-group">
              <button type="submit" class="btn btn-medium btn-success">Continuer</button>
            <div class="controls">
            </div>
            </div>
          </form>
        </div>
      <center>
        
      </form>

    </div> <!-- /container -->

    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="../bootstrap/js/jquery.js"></script>
    <script src="../bootstrap/js/bootstrap.min.js"></script>
  </body>
</html>
