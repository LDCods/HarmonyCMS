<?php
$titre = 'Panel Admin - JSONAPI';
include('../include/init.php');
if(connect()) {
if($rang == "Administrateur") {
if($_POST) {
  if(!empty($_POST['ip']) AND !empty($_POST['utilisateur']) AND !empty($_POST['motdepasse']) AND !empty($_POST['port'])) {
    require_once('../include/JSONAPI.php');
    $salt = "";
    $req_test_jsonapi = new JSONAPI($_POST['ip'], $_POST['port'], $_POST['utilisateur'], $_POST['motdepasse'], $salt);
    $test_jsonapi = $req_test_jsonapi->call("getServerVersion");
    if($test_jsonapi["success"] != '') {
      $data = '<?php $ip = "'.$_POST['ip'].'"; $port = "'.$_POST['port'].'"; $utilisateur = "'.$_POST['utilisateur'].'"; $motdepasse = "'.$_POST['motdepasse'].'"; $jso_napi = "ok"; ?>';
      $fp = fopen("../include/jso.php","w+");
      fwrite($fp, $data);
      fclose($fp);
      $success = "La configuration a bien été enregistrer et la liaison a réussie.";
    } else {
      $erreur = "Impossible de se connecter au serveur. Vérifier que les ports sont ouverts et que le serveur est ouvert.";
    }
  } else {
    $erreur = "Veuillez remplir tout les champs !";
  }
}
include('header.php');
?>
<!-- ====== CONTENUE DE LA PAGE ======= --> 
<div class="row-fluid">
      <div class="news-plugin" style="width:100%;">
      <h1 style="text-align: center;">Configurer la liaison site-serveur</h1><br>
       <div class="boutique-corps" style="width: auto;margin-left: 20px;margin-right: 20px;">
       <center><h3 style="color: #084D97;text-decoration: underline;">Informations sur JSONAPI</h3></center><br>
      <center>
      <form class="form-signin" method="post" style="width: 900px;">
      <center>
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
            <input type="text" name="ip" placeholder="Veuillez mettre l'ip en chiffre" value="<?php if(!empty($_POST['ip'])) { echo $_POST['ip']; } else { echo $ip; } ?>" required>
            </div>
            </div>
            <div class="control-group">
            <label class="control-label">Nom d'utilisateur JSONAPI</label>
            <div class="controls">
            <input type="text" name="utilisateur" placeholder="Nom d'utilisateur mit dans le fichier config.yml" value="<?php if(!empty($_POST['utilisateur'])) { echo $_POST['utilisateur']; } else { echo $utilisateur; } ?>" required>
            </div>
            </div>
            <div class="control-group">
            <label class="control-label">Mot de Passe JSONAPI</label>
            <div class="controls">
            <input type="password" name="motdepasse" placeholder="Mot de passe mit dans le fichier config.yml" value="<?php if(!empty($_POST['motdepasse'])) { echo $_POST['motdepasse']; } else { echo $motdepasse; } ?>" required>
            </div>
            </div>
            <div class="control-group">
            <label class="control-label">Port JSONAPI</label>
            <div class="controls">
            <input type="text" name="port" placeholder="Exemple: 20059" value="<?php if(!empty($_POST['port'])) { echo $_POST['port']; } else { echo $port; } ?>" required>
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
        <?php if($ServerVersion["success"] != '') { ?>
        <button class="btn btn-medium btn-success disabled">Liaison effectué</button>
        <?php } else { ?>
        <button class="btn btn-medium btn-danger disabled">Liaison inexistante</button>
        <?php } ?>
      </form></center>
        <div class="span9">
          </div></div></div></div></div>
<?php
include('include/footer.php');
} else {
  setFlash('Veuillez être administrateur pour avoir accès a la page demandée !', 'danger');
  header('Location: ../connexion.php');
  exit();
}
} else {
  setFlash('Veuillez vous connectez pour avoir accès a la page demandée !', 'danger');
  header('Location: ../connexion.php');
  exit();
}
?>