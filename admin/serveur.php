<?php
$titre = 'Panel Admin - Serveur';
include('../include/init.php');
if(connect()) {
if($rang == "Administrateur") {
include('header.php');

if($_GET['activer']) {
  $activer = $api->call("enablePlugin", array("".$_GET['activer'].""));
  die('<META HTTP-equiv="refresh" content=0;URL=serveur.php>');
}
if($_GET['desactiver']) {
  $desactiver = $api->call("disablePlugin", array("".$_GET['desactiver'].""));
  die('<META HTTP-equiv="refresh" content=0;URL=serveur.php>');
}

?> 
<!-- HEADER DE LA PAGE --> 
<div class="container">
  <div class="page-header">
<!-- ======== CONTENUE DE LA PAGE ========== -->
  </div>
  <div class="row-fluid">
      <div class="news-plugin" style="width:100%;">
      <h1 style="text-align: center;font-family: minecraftiaregular;">Serveur</h1><br>
    <div class="boutique-corps" style="width: auto;margin-left: 20px;margin-right: 20px;">
      <?php if($ServerVersion["success"] == '') {
              echo '<center><h5 style="color: red;font-family: minecraftiaregular;">Serveur éteint.</h5></center>';
            } else { ?>
      <div style="width: 600px;float: left;">
      <h4 style="color: #084D97;font-family: minecraftiaregular;">Plugins :</h4><br>
    <table class="table table-bordered">
              <thead>
                <tr>
                  <th>Nom</th>
                  <th>Version</th>
                  <th>Etat</th>
                  <th>Action</th>
                </tr>
              </thead>
        <?php 
                foreach ($Plugins["success"] as $value) { ?>
              <tbody>
                <tr>
                  <td><?php echo $value['name']; ?></td>
                  <td><?php echo $value['version'] ?></td>
                  <td><?php if($value['enabled']== "true") { echo '<center><img src="../images/true.png"></img></center>'; } else { echo '<center><img src="../images/cross.png"></img></center>'; } ?></td>
                  <td><?php if($value['enabled']!= "true") { ?>
                    <a class="btn btn-success" href="?activer=<?php echo $value['name']; ?>">Activer</a>
                    <?php } else { ?>
                    <a class="btn btn-danger" href="?desactiver=<?php echo $value['name']; ?>">Désactiver</a><?php } ?></td>
<?php
                } 
        ?>
      </tr>
      </tbody>
      </table>
    </div>
      <div style="float: right;">
      <center><h4 style="color: #084D97;font-family: minecraftiaregular;">Récente connexion(s) :</h4></center><br>
        <table class="table table-bordered" style="width: 400px;">
              <thead>
                <tr>
                  <th>Pseudo</th>
                  <th>Etat</th>
                </tr>
              </thead>
        <?php 
                foreach ($Recente_connexion["success"] as $value) { ?>
              <tbody>
                <tr>
                  <td><?php echo $value['player']; ?></td>
                  <td><?php if($value['action']== "connected") { echo '<center><img src="../images/true.png"></img></center>'; } else { echo '<center><img src="../images/cross.png"></img></center>'; } ?></td>
<?php
                }
        }
        ?>
      </tr>
      </tbody>
    </table>
  </div>
<?php /* ?>
 <div style="width: 100px;float: left;margin-left: 20px;">
      <h4 style="color: #084D97;font-family: minecraftiaregular;">Infos :</h4><br>
    <table class="table table-bordered">
              <thead>
                <tr>
                  <th>IP</th>
                  <th>Port</th>
                  <th>Etat</th>
                  <th>Joueurs</th>
                  <th>Mondes</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td><?php echo $ip; ?></td>
                  <td><?php echo $ServerPort['success']; ?></td>
                  <td><?php if($ServerVersion["success"] == '') { echo '<center><img src="../images/cross.png"></img></center>'; } else { echo '<center><img src="../images/true.png"></img></center>'; } ?></td>
                  <td><?php echo $PlayerCount['success']; ?>/<?php echo $PlayerLimit['success']; ?></td>
                  <td>
                  <?php foreach($Mondes['success'] as $value) {  ?>
                  <?php echo $value; ?><br>
                  <?php } ?></td>
      </tr>
      </tbody>
      </table>
    </div>
<?php */ ?>
    </div>
    </div>
</div>
</div>
</div>
</div>
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
} 
?>