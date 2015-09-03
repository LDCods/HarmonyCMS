<?php
include('include/init.php');
require_once('include/JSONAPI.php');
include_once('include/variables.php');
if($ServerVersion['success'] == '') {
  setFlash('Le serveur est éteint donc les joueurs en ligne ne peuvent pas être affichés.', 'danger');
  die('<META HTTP-equiv="refresh" content=0;URL=index.php>');
}
if($PlayerCount['success'] == '0' OR empty($PlayerCount['success'])) {
  $erreur = '<center><h4 class="lead">Aucun joueurs n\'est connecté sur le serveur.</h4<center>';
}
$titre = "Joueurs en ligne";
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
      <h1 style="text-align: center;font-family: minecraftiaregular;">Joueurs en ligne</h1><br>
      <div class="boutique-corps">
      <?php 
        if(!empty($erreur)) {
          echo $erreur;
        }
        foreach($PlayerNames['success'] as $joueurs_liste) { ?>
          <a href="joueurs.php?pseudo=<?php echo $joueurs_liste; ?>" class="btn btn-small"><img src="https://minotar.net/helm/<?php echo $joueurs_liste; ?>/30"><br><?php echo $joueurs_liste; ?></a>
      <?php
        } 
      ?>
      </div>
    </div>
    </div>
<?php include('include/menudroite.php'); ?>
</div>
</div>
</div>
<?php 
include('include/footer.php'); 
?>