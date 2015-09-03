<?php
$titre = "Boutique";
include('include/init.php');
if(connect()) {
include('include/header.php');
?>  
<!-- HEADER DE LA PAGE --> 
<div class="container">
  <div class="page-header">
<!-- =========== ALERTE ========= -->
<?php flash(); ?>
<!-- ======== CONTENUE DE LA PAGE ========== -->
  </div>
  <div class="row-fluid">
    <div class="span8">
      <div class="news-plugin">
      <h1 style="text-align: center;font-family: minecraftiaregular;">Boutique</h1><br>
<?php
if(!empty($_GET['article'])) {
$req_Article_Info = $connexion->query('SELECT * FROM boutique_article WHERE id=\'' . $_GET['article'] . '\'');
$Article_Info = $req_Article_Info->fetch(); ?>
<div class="boutique-corps">
<div class="modal-body">
        <center><h5 style="font-weight: bold;">Vous êtes sur le point d'acheter l'article "<?php echo $Article_Info['nom']; ?>". Voulez-vous vraiment l'achetez ?</h5></center>
      </div>
      <div class="modal-footer">
          <center><a class="btn btn-success" href="achat.php?article=<?php echo $Article_Info['id']; ?>">Acheter</a>
          <a href="boutique.php" class="btn" aria-hidden="true" type="text">Annuler</a></center>
      </div>
    </div>
<?php } else { ?>

<!-- ======= CONTENUE DE LA BOUTIQUE ========= -->
<!-- ========== BOUTIQUE EN ELLE MEME ======= -->
           <?php if($rubis == NULL) { ?>
           <center><a class="btn btn-warning" href="crediter.php">Créditer son compte</a></center>
           <?php } else { ?>
           <center><a class="btn btn-info" href="crediter.php">Créditer son compte</a></center>
           <?php } ?>
           <div class="boutique-corps">
            <ul id="myTab" class="nav nav-tabs">

              <?php
              $sql = $connexion->query("SELECT * FROM boutique_cat ORDER BY id");

              $sql->setFetchMode(PDO::FETCH_OBJ);
              while($req = $sql->fetch()) { 
              ?>
              <li<?php if($_GET['categorie']== ''.$req->nom.'') { echo ' class="active"'; } ?>><a href="?categorie=<?php echo $req->nom; ?>"><?php echo $req->nom; ?></a></li>
<?php } ?>

            </ul>
            <div id="myTabContent" class="tab-content">
              <div class="tab-pane fade in active">
              <?php 
              if(isset($_GET['categorie'])) {
              $sql = $connexion->query('SELECT * FROM boutique_article WHERE categorie=\'' . $_GET['categorie'] . '\'');
              $sql->setFetchMode(PDO::FETCH_OBJ);
              while($req = $sql->fetch()) { 
              ?>

                <a href="?article=<?php echo $req->id; ?>"><div class="shop-item" style="height:auto;">
                  <strong><?php echo $req->nom; ?></strong>
                  <br><img src="<?php echo $req->image; ?>" width="130"><br><small><?php echo $req->description; ?></small><br><div class="text-align: center;"><?php echo $req->prix; ?> <img src="images/rubis.png"></div>
                </div></a>
              <?php } } ?>
              </div>
            </div>
            </div>
            <?php } ?>
    </div>
    </div>
<?php include('include/menudroite.php'); ?>
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