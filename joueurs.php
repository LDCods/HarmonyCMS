<?php
$titre = "Joueurs";
include('include/init.php');
if(empty($_GET['pseudo'])) {
  header('Location: index.php');
  exit();
}
include('include/header.php');
// GRADE EN JEU
$getGrade = $api->call("permissions.getGroups", array(''.$_GET['pseudo'].''));
$grade = $getGrade['success']['0'];
if(empty($grade)) {
      $grade = "Indéfini";
}
// OP
$getOP = $api->call('getPlayer', array(''.$_GET['pseudo'].''));
$getOP = $getOP['success'];
$OP = $getOP['op'];
// ARGENT IG
$ArgentIG = $api->call("econ.getBalance", array(''.$_GET['pseudo'].''));
// FIRST PLAYED
$getfirstPlayed = $api->call('getPlayer', array(''.$_GET['pseudo'].''));
$getfirstPlayed = $getfirstPlayed['success'];
$firstPlayed = $getfirstPlayed['firstPlayed'];
$firstPlayed = date('d/m/Y à H:i:s', $firstPlayed);
// LAST PLAYED
$getlastPlayed = $api->call('getPlayer', array(''.$_GET['pseudo'].''));
$getlastPlayed = $getlastPlayed['success'];
$lastPlayed = $getlastPlayed['lastPlayed'];
if($lastPlayed == "0") {
      $lastPlayed = $firstPlayed;
} else {
  $lastPlayed = date("d/m/Y à H:i:s", $lastPlayed);
}
// SI IL EST INSCRIT
$req_Inscrit = $connexion->prepare('SELECT * FROM membres WHERE pseudo=:pseudo');
$req_Inscrit->execute(array(
  'pseudo' => $_GET['pseudo']
));
$KnowRang = $req_Inscrit->fetch();
$rubisJ = $KnowRang['rubis'];
if(empty($rubisJ)) {
  $rubisJ = '0';
}
$rangJ = $KnowRang['rang'];
if ($rangJ == "1") {
    $rangJ = Membre;
}
if ($rangJ == "2") {
    $rangJ = Modérateur;
}
if ($rangJ == "3") {
    $rangJ = Administrateur;
}
$inscrit = $req_Inscrit->rowCount();
if($inscrit > '0') {
  $inscrit = 'Oui';
} else {
  $inscrit = 'Non';
}
$getPisOnline = $api->call('getPlayer', array(''.$_GET['pseudo'].''));
$getPisOnline = $getPisOnline['success'];
$PisOnline = $getPisOnline['ip'];
if($PisOnline == "offline") { $PisOnline = 'false'; } else { $PisOnline = 'true'; }
?>
<!-- HEADER DE LA PAGE --> 
<div class="container">
  <div class="page-header">
<!-- ======== CONTENUE DE LA PAGE ========== -->
  </div>
  <div class="row-fluid">
    <div class="span8">
      <div class="news-plugin">
      <h1 style="text-align: center;font-family: minecraftiaregular;">Joueur</h1><br>
      <div class="boutique-corps" style="height:500px;">
<img style="float:left" src="http://www.craftmycms.fr/ressources/skin3d.php?a=0&w=0&wt=0&abg=0&abd=0&ajg=0&ajd=0&ratio=15&format=png&displayHairs=true&headOnly=false&login=<?php echo $_GET['pseudo']; ?>"><br><br>
<span style="color:#045a85; font-size: 30px;">Profil du joueur: </span> <span style="color:#045a85;font-size: 25px;"><strong><?php echo $_GET['pseudo']; ?></strong></span><?php if($ServerVersion["success"] == '') { } else { if($PisOnline == "true") { ?>&nbsp;<span class="label label-success">En ligne</span><?php } else { ?>&nbsp;<span class="label label-important">Hors Ligne</span><?php } } ?><br><br><br><br>
<?php 
if($inscrit == 'Non' AND $ServerVersion["success"] == '') {
  echo '<center><span style="color:#045a85; font-weight:bold;">Aucune Informations a afficher</span></center><br><br>';
}
?>
<?php if($inscrit == 'Oui') { ?>
&nbsp;<span style="color:#045a85; font-weight:bold;">Rang:</span> <span style="color:dark_blue;"><?php echo $rangJ; ?></span><br><br>
<?php } if($ServerVersion["success"] != '') { ?>
&nbsp;<span style="color:#045a85; font-weight:bold;">Grade en Jeu:</span> <span style="color:dark_blue;"><?php echo $grade; if($OP == "true") { echo '&nbsp&nbsp<span style="color:red;font-weight:bold;">[OP]</span>'; } ?></span><br><br>
<?php } if($inscrit == 'Oui') { ?>
&nbsp;<span style="color:#045a85; font-weight:bold;">Rubis:</span> <span style="color:dark_blue;"><?php echo $rubisJ; ?></span><br><br>
<?php } if($ServerVersion["success"] != '') { ?>
&nbsp;<span style="color:#045a85; font-weight:bold;">Argent IG:</span> <span style="color:dark_blue;"><?php echo $ArgentIG['success']; ?></span><br><br><br>
<?php } ?>
<center><div class="well pull-right" style="width: 270px;margin-right: 45px;">
<?php if($ServerVersion["success"] != '') { ?>
<small><p>Première connexion sur le serveur : <strong>Le <?php echo $firstPlayed; ?></strong></p></small>
<small><p>Dernière connexion sur le serveur : <strong>Le <?php echo $lastPlayed; ?></strong></p></small>
<?php } ?>
<small><p>Inscrit sur le site : <strong><?php echo $inscrit; ?></strong></p></small>
</div></center>
  
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
<?php include('include/footer.php'); ?>