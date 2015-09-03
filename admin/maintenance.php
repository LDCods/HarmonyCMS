<?php 
$titre = 'Panel Admin - Maintenance';
include('../include/init.php');
if(connect()) {
if($rang == "Administrateur") {
if($_POST) {
  $ancienConfig = file_get_contents('../include/infos.php','r');
  $data = $ancienConfig.'<?php $maintenance = "'.$_POST['action'].'"; $motif = "'.$_POST['motif'].'"; ?>';
  $fp = fopen("../include/infos.php","w+");
  fwrite($fp, $data);
  fclose($fp);
  if($_POST['action'] = "true") {
    $action = "activé";
  } else {
    $action = "désactivé";
  }
  $success = 'La maintenance a été '.$action.' avec succès';
  header('Location: maintenance.php');
}
include('header.php');
?>
<!-- ====== CONTENUE DE LA PAGE ======= --> 
<div class="row-fluid">
      <div class="news-plugin" style="width:100%;">
      <h1 style="text-align: center;">Maintenance</h1><br>
       <div class="boutique-corps" style="width: auto;margin-left: 20px;margin-right: 20px;">
       <center><h3 style="color: #084D97;text-decoration: underline;"><?php if($maintenance == "false" OR !isset($maintenance)) { echo 'Activer'; } else { echo 'Désactiver'; } ?> la maintenance</h3></center>
       <?php if(!empty($success)) { ?>
       <div class="alert alert-success"><strong>Succès :</strong> <?php echo $success; ?></div>
       <?php } ?>
<form method="post">
<center><p>Motif :<br /> <input type="text" style="height: 30px;" size="30" name="motif" placeholder="Sera afficher au joueurs" <?php if(!empty($motif)) { echo 'value="'.$motif.'"'; } ?>/></p></center>
<center><p><small><strong>Pour accèdez au site il faut que vous soyez Administrateur et être connecté au site. <br>Pour vous connectez il vous suffira d'aller sur la <a href="<?php echo $url.'/connexion.php'; ?>">page de connexion</a>.</strong></small></p></center>
<input type="hidden" name="action" value="<?php if($maintenance == "false" OR !isset($maintenance)) { echo 'true'; } else { echo 'false'; } ?>">
<center><p><input class="btn btn-success" type="submit" value="<?php if($maintenance == "false" OR !isset($maintenance)) { echo 'Activer'; } else { echo 'Désactiver'; } ?> la maintenance" /></p></center>
</form>
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