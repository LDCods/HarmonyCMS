<?php
$titre = "Profil";
include('include/init.php');
if(connect()) {
include('include/header.php');
?>
<!-- HEADER DE LA PAGE --> 
<div class="container">
  <div class="page-header">
<!-- ======== CONTENUE DE LA PAGE ========== -->
  </div>
  <div class="row-fluid">
    <div class="span8">
      <div class="news-plugin">
      <h1 style="text-align: center;font-family: minecraftiaregular;">Profil</h1><br>
      <div class="boutique-corps">
    <img style="float:left" src="http://www.craftmycms.fr/ressources/skin3d.php?a=0&w=0&wt=0&abg=0&abd=0&ajg=0&ajd=0&ratio=15&format=png&displayHairs=true&headOnly=false&login=<?php echo $pseudo; ?>"><br><br>
    &nbsp;&nbsp;&nbsp;<span style="color:#045a85; font-size: 30px;">Bienvenue,</span> <span style="color:#045a85; font-weight:bold; font-size: 20"><?php echo $pseudo; ?></span><?php if($ServerVersion["success"] == '') { } else { if($isOnline == "true") { ?><span class="label label-success">En ligne</span><?php } } ?><br><br><br><br>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style="color:#045a85; font-weight:bold;">Votre Pseudo:</span> <span style="color:dark_blue;"><?php echo $pseudo; ?></span><br><br>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style="color:#045a85; font-weight:bold;">Votre Rang:</span> <span style="color:dark_blue;"><?php echo $rang; ?></span><br><br>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style="color:#045a85; font-weight:bold;">Votre Email:</span> <span style="color:dark_blue;"><?php echo $email; ?></span><br><br>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style="color:#045a85; font-weight:bold;">Vos rubis:</span> <abbr title="Les rubis sont la money du site qui vous permettre d'acheter différents grades ou autre sur la boutique."><span style="color:dark_blue;"><?php echo $rubis; ?><img src="images/rubis.png"></span></abbr><br><br>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style="color:#045a85; font-weight:bold;">Vous avez voté: </span><span style="color:dark_blue;"><?php echo $nombre_vote; ?> fois.</span><br><br><br><br><br><br><br><br><br> 
    
    
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a class="btn btn-info" style="text-decoration:none; padding:8" href="mprofil.php">Modifier votre profil</a>
    <br><br><br>
    
    
    </div>
</div>
    </div>
<?php include('include/menudroite.php'); ?>
</div>
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
