<?php 
include('../include/init.php');
if(connect()) {
if($rang == "Administrateur") {

$req_VisitesToday = $connexion->prepare('SELECT * FROM visites WHERE date=:date');
$req_VisitesToday->execute(array(
  'date' => $date 
));
$nbrVisitesToday = $req_VisitesToday->rowCount();

$req_VisitesTotal = $connexion->query('SELECT * FROM visites');
$nbrVisitesTotal = $req_VisitesTotal->rowCount();

$req_support = $connexion->query('SELECT * FROM support');
$nbr_support = $req_support->rowCount();

$titre = 'Panel Admin';
include('header.php');

if($_POST) {
  if($_POST['commande'] != NULL) {
  $commande = $_POST['commande'];
  $EnvoieCommande = $api->call("runConsoleCommand", array(''.$commande.''));
  }
}
if(!empty($_GET['action'])) {
  if($_GET['action'] == 'reload') {
    $Reload1 = $api->call("runConsoleCommand", array('save-all'));
    $Reload2 = $api->call("runConsoleCommand", array('say Rechargement des données du serveur'));
    $Reload3 = $api->call("runConsoleCommand", array('reload'));
    die('<META HTTP-equiv="refresh" content=0;URL=admin.php>');
  }
  if($_GET['action'] == 'stop') {
    $Arret1 = $api->call("runConsoleCommand", array('save-all'));
    $Arret2 = $api->call("runConsoleCommand", array('say Arrêt du serveur'));
    $Arret3 = $api->call("runConsoleCommand", array('stop'));
    die('<META HTTP-equiv="refresh" content=0;URL=admin.php>');
  }
}

?>
<!-- ====== CONTENUE DE LA PAGE =======--> 
<div class="row-fluid">
      <div class="news-plugin" style="width:100%;">
      <h1 style="text-align: center;">Tableau de bord</h1><br>
       <div class="boutique-corps" style="width: auto;margin-left: 20px;margin-right: 20px;">
<?php
        /* LE CMS EST IL A JOUR ? */
$last_version = file_get_contents("http://eywek.fr/cms/last_version.txt", "r");
include("../include/version.php");
if($version != $last_version) {
    echo '<div class="alert alert-warning"><center>Votre CMS n\'est pas à jour ! La dernière version sortie est la '.$last_version.'  <a class="btn btn-warning" href="miseajour.php">Mettre a jour</a></center></div>';
}
?>
<?php flash(); $alertPerso = file_get_contents("http://eywek.fr/cms/alert.txt", "r"); if(!empty($alertPerso)) { ?>
<div class="alert alert-warning"><center><?php echo $alertPerso ?></center></div>
<?php } ?>
       <center><h3 style="color: #084D97;text-decoration: underline;">Informations sur le serveur</h3></center>
       <?php if($ServerVersion["success"] == '') { echo '<center><h5 style="color: red;font-family: minecraftiaregular;">Serveur éteint.</h5></center>'; } else { ?>
      <center><h4 style="color: #084D97;font-family: minecraftiaregular;">Action :</h4></center>
      <center><div class="well" style="width: 70px;"><a href="#commande" title="Commande rapide" role="button" data-toggle="modal"><i class="icon-circle-arrow-right"></i></a>&nbsp;&nbsp;<a href="?action=reload" title="Rechargez votre serveur"><i class="icon-repeat"></i></a>&nbsp;&nbsp;<a href="?action=stop" title="Arrêter votre serveur"><i class="icon-off"></i></a></div></center>
       <center><h4 style="color: #084D97;font-family: minecraftiaregular;">Console :</h4></center>
<center><iframe src="console.php" scrolling=no style="width:100%;background-color: black;height: 510px;border-radius: 4px;border: 5px solid #D8D8D8;"> <p>Votre navigateur ne supporte pas l'élément iframe</p></iframe></center>
       <center><h4 style="color: #084D97;font-family: minecraftiaregular;">Envoyez une commande :</h4></center>
    <center><div class="input-append">
    <form method="POST">
    <input class="span2" name="commande" type="text" style="width:330px;" placeholder="Entrez votre commande ici sans slash (/)">
    <button class="btn" name="BtnEnvoie" type="submit">Envoyez la commande</button>
    </form>
    </div></center>
    <?php } ?>
       <center><h3 style="color: #084D97;text-decoration: underline;">Informations sur le site</h3></center>
 <style type="text/css">
 .droite {
  float: right;
  width: 200px;
 }
 .gauche {
  float: left;
  width: 200px;
 }
 </style>
    <div class="droite">
      <img class="pull-right" src="../images/GUI/user.png">
        <p>
          <blockquote class="pull-right">
          <p><?php echo $nbrMembre; ?> membre(s) se sont inscris sur le site.</p>
          </blockquote>
        </p>
        <img class="pull-right" src="../images/GUI/shopping-backet.png">
        <p>
          <blockquote class="pull-right">
          <p><?php echo $nbrArticles; ?> article(s) sont disponible sur la boutique.</p>
          </blockquote>
        </p>
        <img class="pull-right" src="../images/GUI/screwdriver.png">
        <p>
          <blockquote class="pull-right">
            <p>Il y a <?php echo $nbr_support ?> ticket(s) sur le support.</p>
          </blockquote>
        </p>
    </div>
    
    <div class="gauche">
        <img src="../images/GUI/bars-chart.png">
        <p>
          <blockquote>
          <p>Le site a été visité <strong><?php echo $nbrVisitesToday; ?></strong> fois aujourd'hui.</p>
          </blockquote>
        </p>
        <img src="../images/GUI/pie-chart.png">
        <p>
          <blockquote>
          <p>Le site a été visité <strong><?php echo $nbrVisitesTotal; ?></strong> fois au total.</p>
          </blockquote>
        </p>
        <img src="../images/GUI/notes.png">
        <p>
          <blockquote>
          <p><?php echo $nbrNews; ?> news on été publiée(s).</p>
          </blockquote>
        </p>
    </div><br> <br> <br> <br> <br> <br> <br> <br> <br> <br> <br> <br> <br> <br> <br> <br> <br> <br> <br> <br> <br> 
       </div>
      </div>
        <div class="span9">
          </div></div></div></div>
<!-- ============= COMMANDE RAPIDE =========== -->
    <div id="commande" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="commandeLabel" aria-hidden="true">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3>Commande rapide</h3>
      </div>
      <div class="modal-body"><br>
        <center><div class="input-append">
    <form method="POST">
    <input class="span2" name="commande" type="text" style="width:330px;" placeholder="Entrez votre commande ici sans slash (/)">
    <button class="btn btn-success" name="BtnEnvoie" type="submit">Envoyez la commande</button>
    </form>
    </div></center>
      </div>
      <div class="modal-footer">
          <button class="btn btn-danger" data-dismiss="modal" aria-hidden="true" type="text">Annuler</button>
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
	exit();
}
?>