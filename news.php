<?php
$titre = "News";
include('include/init.php');
include('include/header.php');
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
      <div class="news-plugin">
      <h1 style="text-align: center;font-family: minecraftiaregular;">News</h1><br>
       <div class="boutique-corps">
        
        <?php
        $sql3 = $connexion->query('SELECT * FROM comment WHERE news=\'' . $_GET['id'] . '\'');
        $nbr_comment = $sql3->rowCount();
        ?>

        <?php if(!empty($_GET['id'])) { ?>
        <?php 
        $sql = $connexion->query('SELECT * FROM news WHERE id=\'' . $_GET['id'] . '\'');
        $sql->setFetchMode(PDO::FETCH_OBJ);
        $req = $sql->fetch();
        ?>
        <center><?php if($req->image == NULL) { } else { ?>
                  <img src="<?php echo $req->image; ?>" style="width: 600px;" class="img-rounded" alt="">
                  <?php } ?></center>
        <center><h3 style="color: #084D97;text-decoration: underline;"><?php echo $req->titre; ?></h3>
        <h5><?php echo $req->contenu; ?></h5></center><br>
        <?php if(connect()) { ?>
        <a class="btn btn-success" style="float: left;margin-top: 55px;" href="comment.php?news=<?php echo $req->id; ?>#addcomment">Commenter</a>
        <?php } ?>
        <small class="text-right"><p>Posté par : <strong><a href="joueurs.php?pseudo=<?php echo $req->auteur; ?>" style="color: black;"><?php echo $req->auteur; ?></a></strong></p></small>
        <small class="text-right"><p>Le : <strong><?php echo date('d/m/Y', $req->timestamp); ?></strong></p></small>
        <a class="pull-right" href="comment.php?news=<?php echo $req->id; ?>" style="color: black;"><small><?php echo $nbr_comment; ?> commentaire<?php if($nbr_comment > 1) { echo 's'; } ?></small><i class="icon-comment"></i></a><br><br>
        <?php } else { die('<META HTTP-equiv="refresh" content=0;URL=index.php>'); exit(); } ?>
      </div>
      <?php 
        $req_comment = $connexion->query('SELECT * FROM comment WHERE news=\'' . $_GET['id'] . '\'');
        $nbr_1comment = $req_comment->rowCount();
        if($nbr_1comment > 0) { ?>
      <h3 style="text-align: center;color: #175084;font-family: minecraftiaregular;text-decoration: underline;">Commentaire<?php if($nbr_comment > 1) { echo 's'; } ?> :</h3>
      <?php }
        $sqlC = $connexion->query('SELECT * FROM comment WHERE news=\'' . $_GET['id'] . '\' ORDER BY id DESC LIMIT 0, 3');
        $sqlC->setFetchMode(PDO::FETCH_OBJ);
        while($reqC = $sqlC->fetch()) { 
        ?>
        <div class="thumbnail" style="background-color: white;width: 685px;margin: 30px;">
        <div class="caption">
      <div style="float: left;">
        <h4><?php echo stripslashes($reqC->titre); ?></h4>
        <p><?php echo stripslashes($reqC->contenu); ?></p>
      </div>
      <?php if($req->auteur == $pseudo OR $rang == "Administrateur" OR $rang == "Modérateur") { ?>
        <form method="POST" action="comment.php?news=<?php echo $reqC->news ?>">
          <button type="submit" class="btn btn-link muted" style="float: right;color: gray;">Supprimer</button><br>
          <input type="hidden" name="id" value="<?php echo $reqC->id; ?>" />
        </form>
          <?php } ?>
        <small class="text-right"><p>Posté par : <strong><a href="joueurs.php?pseudo=<?php echo $req->auteur; ?>" style="color: black;"><?php echo $reqC->auteur; ?></a></strong></p></small>
        <small class="text-right"><p>Le : <strong><?php echo date('d/m/Y', $reqC->timestamp); ?></strong></p></small>
        </div>
        </div>
        <?php } ?>
        <?php 
        $req_comment = $connexion->query('SELECT * FROM comment WHERE news=\'' . $_GET['id'] . '\'');
        $nbr_1comment = $req_comment->rowCount();
        if($nbr_1comment > 3) { ?>
      <center><a href="comment.php?news=<?php echo $req->id; ?>" style="text-decoration: none;margin-top: 20px;margin-bottom: 10px;width: 600px;" class="btn-more btn btn-info btn-block">Voir plus de commentaires</a></center> 
        <?php } ?>
    </div>
  </div>
<?php include('include/menudroite.php'); ?>
</div>
</div>
</div>
<?php 
include('include/footer.php'); 
?>