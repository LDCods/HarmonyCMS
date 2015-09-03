<?php
$titre = "Crediter son compte - Etape 2";
include('include/init.php'); 
if(connect()) {
include('include/header.php'); 
?>
<!-- ======= HEADER DE LA PAGE ======== -->
<div class="container">
	 <div class="page-header">
<!-- ======== CONTENUE DE LA PAGE ========== -->	 	
</div>
  <div class="row-fluid">
    <div class="span8">
      <div class="news-plugin">
      <h1 style="text-align: center;font-family: minecraftiaregular;">Crediter son compte <br> Etape 2</h1><br><br>
<div class="boutique-corps">
	<h3>Payez votre offre:</h3><br>
<?php
if(!empty($_GET['offre'])) {
  if($_GET['offre']=="starpass") { ?>
  <h4>1 Code = <?php echo $nbr_rubis_code ?> rubis</h4><br>
          <div id="starpass_<?php echo $idd; ?>"></div>
          <script type="text/javascript" src="http://script.starpass.fr/script.php?idd=<?php echo $idd; ?>&amp;verif_en_php=1&amp;datas="></script>
          <noscript>Veuillez activer le Javascript de votre navigateur s'il vous pla&icirc;t.<br />
            <a href="http://www.starpass.fr/">Micro Paiement StarPass</a>
          </noscript>
  <?php
  }
} else {
  setFlash('Veuillez choisir une offre pour accèdez a cette page', 'danger');
  echo '<meta http-equiv="refresh" content="0; URL=crediter.php">';
}
?>
    </div>
    </div>
    </div>
<?php include('include/menudroite.php'); ?>
<div id="push"></div>
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