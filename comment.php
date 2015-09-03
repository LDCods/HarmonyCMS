<?php
$titre = "Commentaires";
include('include/init.php');
include('include/header.php');
if($_POST) {
if (isset($_POST['titre']))
{
    $titre = htmlentities($_POST['titre'], ENT_QUOTES);
    $contenu = htmlentities($_POST['contenu'], ENT_QUOTES);
    $titre = addslashes($titre);
    $contenu = addslashes($contenu);
    $addComment = $connexion->prepare('INSERT INTO comment SET titre=:titre, contenu=:contenu, auteur=:auteur, timestamp=:timestamp, news=:news');
    $addComment->execute(array(
                'titre' => $titre,
                'contenu' => $contenu,
                'auteur' => $pseudo,
                'timestamp' => time(),
                'news' => $_GET['news']
    ));
    die('<META HTTP-equiv="refresh" content=0;URL=comment.php?news='.$_GET['news'].'>');
}
if(isset($_POST['id'])) {
  $deleteComment = $connexion->query('DELETE FROM comment WHERE id=\'' . $_POST['id'] . '\'');
}
}

$sql3 = $connexion->query('SELECT * FROM comment WHERE news=\'' . $_GET['news'] . '\'');
$nbr_comment = $sql3->rowCount();
?>   
      <!-- Begin page content -->
        <div class="container">
          <div class="page-header">
          </div>
<!-- HEADER DE LA PAGE --> 
<div class="container">
  <div class="page-header">
  </div>
        <!-- ======== CONTENUE DE LA PAGE ========== -->
  </div>
  <div class="row-fluid">
    <div class="span8">
      <div class="news-plugin" style="width: 760px;">
      <h1 style="text-align: center;font-family: minecraftiaregular;">Commentaire<?php if($nbr_comment > 1) { echo 's'; } ?></h1><br>
      <?php if(connect()) { ?>
      <center><a class="btn btn-success" href="#addcomment">Ajouter un commentaire </a></center>
      <?php } ?>
      <?php
      $req_comment1 = $connexion->query('SELECT * FROM comment WHERE news=\'' . $_GET['news'] . '\'');
      $nbr_11comment = $req_comment1->rowCount();
      if($nbr_11comment < 1) {
      echo '<br><center><p class="lead">Aucun commentaire n\'a été posté</p></center>'; 
      }
      ?>
        <?php if(!empty($_GET['news'])) { ?>
        <?php 
        $sql = $connexion->query('SELECT * FROM comment WHERE news=\'' . $_GET['news'] . '\' ORDER BY id DESC');
        $sql->setFetchMode(PDO::FETCH_OBJ);
        while($req = $sql->fetch()) { 
        ?>
        <div class="thumbnail" style="background-color: white;width: 700px;margin: 10px;">
        <div class="caption">
      <div style="float: left;">
        <h4><?php echo stripslashes($req->titre); ?></h4>
        <p><?php echo stripslashes($req->contenu); ?></p>
      </div>
      <div>
        <?php if($req->auteur == $pseudo OR $rang == "Administrateur" OR $rang == "Modérateur") { ?>
        <form method="POST">
          <button type="submit" class="btn btn-link muted" style="float: right;color: gray;">Supprimer</button><br>
          <input type="hidden" name="id" value="<?php echo $req->id; ?>" />
        </form>
          <?php } ?>
        <small class="text-right"><p>Posté par : <strong><a href="joueurs.php?pseudo=<?php echo $req->auteur; ?>" style="color: black;"><?php echo $req->auteur; ?></a></strong></p></small>
        <small class="text-right"><p>Le : <strong><?php echo date('d/m/Y', $req->timestamp); ?></strong></p></small>
      </div>
        </div>
        </div>
        <?php } ?>
        <?php } else { die('<META HTTP-equiv="refresh" content=0;URL=index.php>'); exit(); } ?>
      <?php if(connect()) { ?>
      <hr>
      <div id="addcomment">
        <br>
        <center><h4 class="lead" style="margin: 10px;">Ajouter un commentaire :</h4></center>
        <div style="float: left;">
        <br><img src="https://minotar.net/helm/<?php echo $pseudo; ?>/70" style="margin-left: 10px;" class="img-rounded"></img><br><span class="lead" style="font-size: 15px;">&nbsp;<?php echo $pseudo; ?></span>
        </div>
      <form method="post">
        <input type="text" size="30" style="height: 30px;float:right;margin: 10px;width: 570px;" name="titre" placeholder="Titre du commentaire"><br>
        <textarea name="contenu" style="margin: 10px;width: 570px;height: 100px;float:right;" placeholder="Commentaire"></textarea><br>
        <button class="btn btn-success" style="margin: 10px;" type="submit">Envoyer</button>
      </form>
      </div>
      <?php } ?>
    </div>
  </div>
<?php include('include/menudroite.php'); ?>
</div>
</div>
</div>
<?php 
include('include/footer.php'); 
?>