<?php
include('../include/bdd.php');
include('../include/init.php');
if($etape_1 == "ok") {
$req_selectEtape = $connexion->query('SELECT * FROM installation');
$selectEtape = $req_selectEtape->fetch();
$etape = $selectEtape['etape_actuelle'];
if($etape != "2") {
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
  if(!empty($_POST['ip']) AND !empty($_POST['utilisateur']) AND !empty($_POST['motdepasse']) AND !empty($_POST['port'])) {
    require('../include/JSONAPI.php');
    $req_test_jsonapi = new JSONAPI($_POST['ip'], $_POST['port'], $_POST['utilisateur'], $_POST['motdepasse']);
    $test_jsonapi = $req_test_jsonapi->call("getServerVersion");
    if($test_jsonapi["success"] != '') {
      $data = '<?php $ip = "'.$_POST['ip'].'"; $port = "'.$_POST['port'].'"; $utilisateur = "'.$_POST['utilisateur'].'"; $motdepasse = "'.$_POST['motdepasse'].'"; $jso_napi = "ok"; ?>';
      $fp = fopen("../include/jso.php","w+");
      fwrite($fp, $data);
      fclose($fp);

      $connexion_jsonapi = "true";
      $success = "La connexion au serveur a bien été effectuer. Vous pouvais désormais continuer l'installation.";
      $etape_actuelle = '3';
      $addEtape = $connexion->prepare("UPDATE installation SET etape_actuelle=:etape_actuelle");
      $addEtape->execute(array(
                'etape_actuelle' => $etape_actuelle
      ));
    } else {
      $erreur = "Impossible de se connecter au serveur. Vérifier que les ports sont ouverts.";
    }
  } else {
    $erreur = "Veuillez remplir tout les champs !";
  }
 if(!empty($_POST['ignorer'])) {
  $etape_actuelle = '3';
      $addEtape = $connexion->prepare("UPDATE installation SET etape_actuelle=:etape_actuelle");
      $addEtape->execute(array(
                'etape_actuelle' => $etape_actuelle
      ));
  header('Location: 3.php');
  exit();
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

      <form class="form-signin" method="post" action="2.php" style="width: 900px;">
        <center><h2 class="form-signin-heading">Etape 2 - Liaison site-serveur</h2></center>
      <center>
        <p class="lead">Pour que le CMS soit relié au serveur il faut que vous ayez au préalable <a href="http://dev.bukkit.org/bukkit-plugins/jsonapi/files/">JSONAPI</a> et <a href="http://dev.bukkit.org/bukkit-plugins/vault/files/">VAULT</a> sur votre serveur. Veuillez vous assurez que les ports sont ouverts pour le bon fonctionnement de la liaision.</p>
        <div class="well">
          <?php if(!empty($erreur)) { ?>
          <div class="alert alert-error"><?php echo $erreur; ?></div>
          <?php } ?>
          <?php if(!empty($success)) { ?>
          <div class="alert alert-success"><?php echo $success; ?></div>
          <?php } ?>
          <form class="form-horizontal">
            <div class="control-group">
            <label class="control-label">IP du serveur</label>
            <div class="controls">
            <input type="text" name="ip" placeholder="Veuillez mettre l'ip en chiffre" value="<?php if(!empty($_POST['ip'])) { echo $_POST['ip']; } ?>" required>
            </div>
            </div>
            <div class="control-group">
            <label class="control-label">Nom d'utilisateur JSONAPI</label>
            <div class="controls">
            <input type="text" name="utilisateur" placeholder="Nom d'utilisateur mit dans le fichier config.yml" value="<?php if(!empty($_POST['utilisateur'])) { echo $_POST['utilisateur']; } ?>" required>
            </div>
            </div>
            <div class="control-group">
            <label class="control-label">Mot de Passe JSONAPI</label>
            <div class="controls">
            <input type="password" name="motdepasse" placeholder="Mot de passe mit dans le fichier config.yml" value="<?php if(!empty($_POST['motdepasse'])) { echo $_POST['motdepasse']; } ?>" required>
            </div>
            </div>
            <div class="control-group">
            <label class="control-label">Port JSONAPI</label>
            <div class="controls">
            <input type="text" name="port" placeholder="Exemple: 20059" value="<?php if(!empty($_POST['port'])) { echo $_POST['port']; } ?>" required>
            </div>
            </div>
            <div class="control-group">
            <div class="controls">
            <button type="submit" class="btn btn-primary">Tester la connexion</button>
            </div>
            </div>
          </form>
        </div>
      <center>
        <?php if($connexion_jsonapi == "true") { ?>
        <a href="3.php" class="btn btn-medium btn-success">Continuer</a><br><form method="POST"><input name="ignorer" type="hidden" value="ignorer"><button type="submit">Ignorer cette étape</button></form>
        <?php } else { ?>
        <button class="btn btn-medium btn-success disabled">Continuer</button><br><br><form method="POST"><input name="ignorer" type="hidden" value="ignorer"><center><button class="btn btn-link" type="submit">Ignorer cette étape</button></center></form>
        <?php } ?>
      </form>

    </div> <!-- /container -->

    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="../bootstrap/js/jquery.js"></script>
    <script src="../bootstrap/js/bootstrap.min.js"></script>
  </body>
</html>
