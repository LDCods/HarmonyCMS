<?php 
$titre = 'Panel Admin - Règlages';
include('../include/init.php');
if(connect()) {
if($rang == "Administrateur") {
  if($_POST) {
    if(!empty($_POST['titre']) AND !empty($_POST['contenu'])) {
    $data = '<?php
$titre = '.$_POST['titre'].';
include(\'include/init.php\');
include(\'include/header.php\');
?>
    <!-- HEADER DE LA PAGE --> 
    <div class="container">
      <div class="page-header">
    <!-- ======== CONTENUE DE LA PAGE ========== -->
      </div>
      <div class="row-fluid">
        <div class="span8">
          <div class="news-plugin">
          <h1 style="text-align: center;font-family: minecraftiaregular;">'.$_POST['titre'].'</h1><br>
          <div class="boutique-corps" style="height:500px;">
            '.$_POST['contenu'].'
        </div>
    </div>
        </div>
    <?php include(\'include/menudroite.php\'); ?>
    </div>
    <div id="push"></div>
    </div>
    </div>
    </div>
    </div>
    <?php include(\'include/footer.php\'); ?>';
    $url_pageC = "../".$_POST['titre'].".php";
    $url_pageC = preg_replace('/\s/', '_', $url_pageC); 
    $url_page = $url."/".$_POST['titre'].".php";
    $url_page = preg_replace('/\s/', '_', $url_page); 
    $fp = fopen($url_pageC,"w+");
    fwrite($fp, $data);
    fclose($fp);
    $add_page = $connexion->prepare("INSERT INTO pages VALUES('', '" . $_POST['titre'] . "', '" . $url_page . "', '" . $url_pageC . "')");
    $add_page->execute();
    $success = "La page a été sauvegarger avec succès elle est accessible depuis cette URL: <a href=\"".$url_pageC."\">".$url_page."</a>";
  }

  if(!empty($_POST['titre_widget']) AND !empty($_POST['contenu_widget'])) {
    $add_widget = $connexion->prepare("INSERT INTO widgets VALUES('', '" . $_POST['titre_widget'] . "', '" . $_POST['contenu_widget'] . "')");
    $add_widget->execute();
    $success_widget = "Le widget a été sauvegarger avec succès";
  }

  if(!empty($_POST['nom_onglet']) AND !empty($_POST['url_onglet'])) {
    /*$onglet = '<li <?php if($monUrl == \''.$_POST['url_onglet'].'\') { echo \'class="active"\'; } ?>><a style="font-family: minecraftiaregular;" href="'.$_POST['url_onglet'].'">'.$_POST['nom_onglet'].'</a></li>';
    */$ordre = $connexion->query("SELECT * FROM navbar");
    $ordre = $ordre->rowCount();
    $ordre = $ordre+'1';
    $add_onglet = $connexion->prepare("INSERT INTO navbar VALUES('', '" . $ordre . "', '" . $_POST['nom_onglet'] . "', '" . $_POST['url_onglet'] . "')");
    $add_onglet->execute();
    $success_onglet = "L'onglet a été ajouté avec succès";
  }
}
if(!empty($_GET['supprimer'])) {
  $req_modif = $connexion->query("SELECT * FROM pages WHERE id=".$_GET['supprimer']."");
  $req_modif->setFetchMode(PDO::FETCH_OBJ);
  $req_modif = $req_modif->fetch();
  $url_modif = $req_modif->url_unlink;
  unlink(''.$url_modif.'');
  $supprimer_page = $connexion->query('DELETE FROM pages WHERE id='.$_GET['supprimer'].'');
}
if(!empty($_GET['supprimer_widget'])) {
  $supprimer_widget = $connexion->query('DELETE FROM widgets WHERE id='.$_GET['supprimer_widget'].'');
}
if(!empty($_GET['supprimer_onglet'])) {
  $supprimer_onglet = $connexion->query('DELETE FROM navbar WHERE id='.$_GET['supprimer_onglet'].'');
}
include('../include/infos.php');
include('header.php');
?>
<!-- ====== CONTENUE DE LA PAGE ======= --> 
<div class="row-fluid">
      <div class="news-plugin" style="width:100%;">
      <h1 style="text-align: center;">Configuration des pages</h1><br>
       <div class="boutique-corps" style="width: auto;margin-left: 20px;margin-right: 20px;">
        <center><h4 class="lead" style="margin: 10px;">Ajout de page</h4></center>
        <center><form class="form-signin" method="post" style="width: 900px;">
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
            <label class="control-label">Titre de la page</label>
            <div class="controls">
            <input type="text" name="titre" placeholder="Exemple: Recrutement" value="<?php echo $titre_modif; ?>" required>
            </div>
            </div>
            <div class="control-group">
            <label class="control-label">Contenu de la page</label>
            <div class="controls">
            <textarea type="text" name="contenu" style="width:600px;height:150px;" placeholder="Exemple: Pour vous faire recruter ..." required></textarea>
            <br><small><strong style="font-weight: italic;color:grey;">Le Code HTML est accepter</strong></small>
            </div>
            </div>
            <div class="control-group">
            <div class="controls">
            <button type="submit" class="btn btn-success">Enregistrer</button>
            </div>
            </div>
          </form>
      <center>
      </form></center>
      </div>
      <hr>
      <?php 
      $pages = $connexion->query("SELECT * FROM pages");
      $pages = $pages->rowCount();
      if($pages > '0') { ?>
      <center><h4 class="lead" style="margin: 10px;">Gérer les pages</h4></center>
      <table class="table table-bordered" style="margin: 0 0 0 0;">
        <tr>
            <td>Titre</td>
            <td>URL</td>
            <td><center>Action</center></td>
        </tr>
<?php 
$sql = $connexion->query("SELECT * FROM pages ORDER BY id DESC");
$sql->setFetchMode(PDO::FETCH_OBJ);
while($req = $sql->fetch()) { ?>
<tr>
<td><strong><a style="color: black;" href="?id=<?php echo $req->id; ?>"><?php echo stripslashes($req->titre); ?></a></strong></td>
<td><?php echo $req->url; ?></td>
<td><center><a class="btn btn-info" href="<?php echo $req->url; ?>" target="_blank">Voir</a>&nbsp;<a class="btn btn-danger" href="?supprimer=<?php echo $req->id; ?>">Supprimer</a></center></td>
<?php } ?>
</tr>
</table>
<?php } else { echo '<center><h4 class="lead">Aucune page n\'a été créé sur le site.</h4></center>'; } ?>
<hr>
<center><h4 class="lead" style="margin: 10px;">Ajouter un widget</h4></center>
<center><form class="form-signin" method="post" style="width: 900px;">
      <center>
        <div class="well">
          <?php if(!empty($erreur_widget)) { ?>
          <div class="alert alert-error"><?php echo $erreur_widget; ?></div>
          <?php } ?>
          <?php if(!empty($success_widget)) { ?>
          <div class="alert alert-success"><?php echo $success_widget; ?></div>
          <?php } ?>
          <form class="form-horizontal">
            <div class="control-group">
            <label class="control-label">Titre du widget</label>
            <div class="controls">
            <input type="text" name="titre_widget" placeholder="Exemple: Recrutement" value="<?php echo $titre_modif; ?>" required>
            </div>
            </div>
            <div class="control-group">
            <label class="control-label">Contenu du widget</label>
            <div class="controls">
            <textarea type="text" name="contenu_widget" style="width:600px;height:150px;" placeholder="Exemple: Pour vous faire recruter ..." required></textarea>
            <br><small><strong style="font-weight: italic;color:grey;">Le Code HTML est accepter</strong></small>
            </div>
            </div>
            <div class="control-group">
            <div class="controls">
            <button type="submit" class="btn btn-success">Enregistrer</button>
            </div>
            </div>
          </form>
          </div>
      <center>
      </form></center>
      <?php 
      $widgets = $connexion->query("SELECT * FROM widgets");
      $widgets = $widgets->rowCount();
      if($widgets > '0') { ?>
       <center><h4 class="lead" style="margin: 10px;">Gérer les widgets</h4></center>
      <table class="table table-bordered" style="margin: 0 0 0 0;">
        <tr>
            <td>Titre</td>
            <td><center>Action</center></td>
        </tr>
<?php 
$sql_widget = $connexion->query("SELECT * FROM widgets ORDER BY id DESC");
$sql_widget->setFetchMode(PDO::FETCH_OBJ);
while($req_widget = $sql_widget->fetch()) { ?>
<tr>
<td><strong><a style="color: black;" href="?id_widget=<?php echo $req->id; ?>"><?php echo stripslashes($req_widget->nom); ?></a></strong></td>
<td><center><a class="btn btn-danger" href="?supprimer_widget=<?php echo $req_widget->id; ?>">Supprimer</a></center></td>
<?php } ?>
</tr>
</table>
<?php } else { echo '<center><h4 class="lead">Aucun widget n\'a été créé sur le site.</h4></center>'; } ?>
<hr>
<center><h4 class="lead" style="margin: 10px;">Ajouter un onglet</h4></center>
<center><form class="form-signin" method="post" style="width: 900px;">
      <center>
        <div class="well">
          <?php if(!empty($erreur_onglet)) { ?>
          <div class="alert alert-error"><?php echo $erreur_onglet; ?></div>
          <?php } ?>
          <?php if(!empty($success_onglet)) { ?>
          <div class="alert alert-success"><?php echo $success_onglet; ?></div>
          <?php } ?>
          <form class="form-horizontal">
            <div class="control-group">
            <label class="control-label">Titre de l'onget</label>
            <div class="controls">
            <input type="text" name="nom_onglet" placeholder="Exemple: Pages" required>
            </div>
            </div>
            <div class="control-group">
            <label class="control-label">URL de l'onget</label>
            <div class="controls">
            <input type="text" name="url_onglet" placeholder="Exemple: pages.php" required>
            </div>
            </div>
            <div class="control-group">
            <div class="controls">
            <button type="submit" class="btn btn-success">Enregistrer</button>
            </div>
            </div>
          </form>
          </div>
      <center>
      </form></center>
      <?php 
      $navbar = $connexion->query("SELECT * FROM navbar");
      $navbar = $navbar->rowCount();
      if($navbar > '0') { ?>
       <center><h4 class="lead" style="margin: 10px;">Gérer les onglets</h4></center>
      <table class="table table-bordered" style="margin: 0 0 0 0;">
        <tr>
            <!-- <td>Ordre</td> -->
            <td>Nom</td>
            <td>URL</td>
            <td><center>Action</center></td>
        </tr>
<?php 
$sql_onglet = $connexion->query("SELECT * FROM navbar ORDER BY ordre");
$sql_onglet->setFetchMode(PDO::FETCH_OBJ);
while($req_onglets = $sql_onglet->fetch()) { ?>
<tr>
<!-- <td><?php // echo stripslashes($req_onglets->ordre); ?></a></strong></td> -->
<td><?php echo stripslashes($req_onglets->nom); ?></td>
<td><?php echo stripslashes($req_onglets->url); ?></td>
<td><center><a class="btn btn-danger" href="?supprimer_onglet=<?php echo $req_onglets->id; ?>">Supprimer</a></center></td>
<?php } ?>
</tr>
</table>
<?php } else { echo '<center><h4 class="lead">Aucun onglet n\'a été créé sur le site.</h4></center>'; } ?>
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