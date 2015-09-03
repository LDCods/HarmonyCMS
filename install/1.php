<?php 
include('../include/bdd.php');
include('../include/init.php');
if(isset($etape_1)) {
$req_selectEtape = $connexion->query('SELECT * FROM installation');
$selectEtape = $req_selectEtape->fetch();
$etape = $selectEtape['etape_actuelle'];
if($etape != '1') {
if($etape != '') {
if(!empty($etape)) {
  header("Location: $etape.php");
  exit();
}
}
}
}

if($_POST) {
  if(!empty($_POST['host']) AND !empty($_POST['bdd']) AND !empty($_POST['user']) AND !empty($_POST['password'])) {
    try {
      $dbh = new PDO('mysql:host='.$_POST['host'].';dbname='.$_POST['bdd'].';charset=utf8', $_POST['user'], $_POST['password']) or die("test");
      $data = '<?php $host = "'.$_POST['host'].'"; $user = "'.$_POST['user'].'"; $password = "'.$_POST['password'].'"; $db = "'.$_POST['bdd'].'"; $etape_1 = "ok"?>';
      $fp = fopen("../include/bdd.php","w+");
      fwrite($fp, $data);
      fclose($fp);

      $connexion_bdd = "true";
      $success = "Les informations on bien été enregistrées. Vous pouvais désormais continuer l'installation.";
      include('sql.php');
      $etape_actuelle = '2';
      $addEtape = $dbh->prepare("INSERT INTO installation SET etape_actuelle=:etape_actuelle");
      $addEtape->execute(array(
                'etape_actuelle' => $etape_actuelle
      ));
    } catch (Exception $erreur) {
      $erreur = "Impossible de se connecter à la base de donnée.";
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
        <center><h2 class="form-signin-heading">Etape 1 - Connexion à la base de données</h2></center>
      <center>
        <p class="lead">Pour installez votre CMS il vous faut impérativement une base de données. Veuillez remplir les champs ci-dessous pour que votre CMS fonctionne.</p>
        <div class="well">
          <?php if(!empty($erreur)) { ?>
          <div class="alert alert-error"><?php echo $erreur; ?></div>
          <?php } ?>
          <?php if(!empty($success)) {
          echo('<div class="alert alert-success'); echo $success; echo('</div>');
          } ?>
          <form class="form-horizontal">
            <div class="control-group">
            <label class="control-label" for="inputHost">Serveur de la base de données</label>
            <div class="controls">
            <input type="text" name="host" placeholder="Exemple: sql.exemple.fr" value="<?php if(!empty($_POST['host'])) { echo $_POST['host']; } ?>" required>
            </div>
            </div>
            <div class="control-group">
            <label class="control-label" for="inputBDD">Nom de la base de données</label>
            <div class="controls">
            <input type="text" name="bdd" placeholder="Exemple: 25857_sql" value="<?php if(!empty($_POST['bdd'])) { echo $_POST['bdd']; } ?>" required>
            </div>
            </div>
            <div class="control-group">
            <label class="control-label" for="inputUser">Utilisateur</label>
            <div class="controls">
            <input type="text" name="user" placeholder="Exemple: Eywek" value="<?php if(!empty($_POST['user'])) { echo $_POST['user']; } ?>" required>
            </div>
            </div>
            <div class="control-group">
            <label class="control-label" for="inputPassword">Mot de passe</label>
            <div class="controls">
            <input type="password" name="password" placeholder="Mot de passe de votre BDD" value="<?php if(!empty($_POST['password'])) { echo $_POST['password']; } ?>" required>
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
        <?php if($connexion_bdd == "true") { ?>
        <a href="2.php" class="btn btn-medium btn-success">Continuer</a>
        <?php } else { ?>
        <button class="btn btn-medium btn-success disabled">Continuer</button>
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
