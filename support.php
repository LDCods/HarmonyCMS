<?php
$titre = "Support";
include('include/init.php');
if($_POST) {
	if(!empty($_POST['titre']) AND !empty($_POST['contenu'])) {
		if(connect()) {
			$titre = addslashes($_POST['titre']);
			$contenu = addslashes($_POST['contenu']);
			$add_ticket = $connexion->prepare("INSERT INTO support VALUES('', '" . $titre . "', '" . $contenu . "', '" . $pseudo . "', '1')");
			$add_ticket->execute();
			header('Location: support.php');
			exit();
		}
	}
	if(!empty($_POST['id_resolu'])) {
		$update_resolu = $connexion->prepare('UPDATE support SET etat=:etat WHERE id=:id');
		$update_resolu->execute(array(
			'etat' => '2',
			'id' => $_POST['id_resolu']
		));
	}
	if(!empty($_POST['id_supprimer'])) {
		$delete_ticket = $connexion->query('DELETE FROM support WHERE id='.$_POST['id_supprimer'].'');
    $delete_reponse = $connexion->query('DELETE FROM reponse_support WHERE id_ticket='.$_POST['id_supprimer'].'');
		header('Location: support.php');
		exit();
	}
  if(!empty($_POST['reponse'])) {
    $Envoi_reponse = addslashes($_POST['reponse']);
    $add_reponse = $connexion->prepare("INSERT INTO reponse_support VALUES('', '" . $_GET['id'] . "', '" . $Envoi_reponse . "', '" . $pseudo . "')");
    $add_reponse->execute();
  }
  if(!empty($_POST['id_supprimer_reponse'])) {
    $delete_reponse = $connexion->query('DELETE FROM reponse_support WHERE id='.$_POST['id_supprimer_reponse'].'');
  }
}
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
      <h1 style="text-align: center;font-family: minecraftiaregular;">Support</h1><br>
      <?php if(empty($_GET['id']) AND empty($_GET['ajouter']) AND connect()) { ?>
      <center><a href="?ajouter=new" class="btn btn-success">Ajouter un ticket</a></center>
      <?php } ?>
<?php if(empty($_GET['id']) AND empty($_GET['ajouter'])) { ?> 
<?php 
$Support = $connexion->query("SELECT * FROM support");
$Support = $Support->rowCount();
if($Support > '0') { 
?> 
      <div class="boutique-corps" style="padding: 0;width: 695px;">
      	<table class="table table-bordered" style="margin: 0 0 0 0;">
        <tr>
            <td>Titre</td>
            <td>Auteur</td>
            <td>Etat</td>
        </tr>
<?php
$sql = $connexion->query("SELECT * FROM support ORDER BY id DESC");
$sql->setFetchMode(PDO::FETCH_OBJ);
while($req = $sql->fetch()) { ?>
<tr>
<td><strong><a style="color: black;" href="?id=<?php echo $req->id; ?>"><?php echo stripslashes($req->titre); ?></a></strong></td>
<td><?php echo $req->auteur; ?></td>
<td><?php if($req->etat == "1") { echo '<center><img src="images/cross.png"></img></center>'; } else { echo '<center><img src="images/true.png"></img></center>'; } ?></td>
</tr>
<?php
} // Fin de la boucle qui liste les news.
?>
</table>
    </div>

<?php // SI AUCUN TICKET
} else { ?>
<div class="boutique-corps">
	<center><h4 class="lead">Aucun ticket n'a été posté sur le site.</h4></center>
</div>
<?php } // FIN SI AUCUN TICKET ?>
<?php // SI ON REGARDE UN TICKET
 } elseif(!empty($_GET['id'])) { ?>
<?php
$req_support = $connexion->query('SELECT * FROM support WHERE id=\'' . $_GET['id'] . '\'');
$req_support->setFetchMode(PDO::FETCH_OBJ);
$req_support = $req_support->fetch();
?>
	<div class="thumbnail" style="background-color: white;width: 735px;margin: 10px;min-height: 75px;">
        <div class="caption">
      <div style="float: left;">
        <h4><?php if($req_support->etat == "2")  { echo '<span style="color:green;font-weight:bold;">[RESOLU]</span> '; } ?><?php echo stripslashes($req_support->titre); ?></h4>
        <p><?php echo stripslashes($req_support->contenu); ?></p>
      </div>
      <div>
        <?php if($req_support->auteur == $pseudo OR $rang == "Administrateur" OR $rang == "Modérateur") { ?>
        <?php if($req_support->etat == "1") { ?>
        <form method="POST">
          <button type="submit" class="btn btn-link muted" style="float: right;color: gray;">Mettre en résolu</button><br>
           <input type="hidden" name="id_resolu" value="<?php echo $req_support->id; ?>" />
        </form>
          <?php } ?>
          <form method="POST">
          <button type="submit" class="btn btn-link muted" style="float: right;color: gray;">Supprimer</button><br>
           <input type="hidden" name="id_supprimer" value="<?php echo $req_support->id; ?>" />
        </form>
          <?php } ?>
        <small class="text-right"><p>Posté par : <strong><a href="joueurs.php?pseudo=<?php echo $req_support->auteur; ?>" style="color: black;"><?php echo $req_support->auteur; ?></a></strong></p></small>
      </div>
        </div>
        </div>
        
        <?php 
        $reponse_Support = $connexion->query('SELECT * FROM reponse_support WHERE id_ticket='.$_GET['id'].'');
    		$reponse_Support = $reponse_Support->rowCount();
    		  if($reponse_Support > '0') { 
            $Rep_Support = $connexion->query('SELECT * FROM reponse_support WHERE id_ticket='.$_GET['id'].'');
            $Rep_Support->setFetchMode(PDO::FETCH_OBJ);
        ?>
		<hr>
        <center><h4 class="lead" style="margin: 10px;">Réponse</h4></center>
		<?php while($req = $Rep_Support->fetch()) { ?>
        <div class="thumbnail" style="background-color: white;width: 700px;margin: 10px;">
        <div class="caption">
      <div style="float: left;">
        <p><?php echo stripslashes($req->reponse); ?></p>
      </div>
      <div>
        <?php if($req->auteur == $pseudo OR $rang == "Administrateur" OR $rang == "Modérateur") { ?>
        <form method="POST">
          <button type="submit" class="btn btn-link muted" style="float: right;color: gray;">Supprimer</button><br>
          <input type="hidden" name="id_supprimer_reponse" value="<?php echo $req->id; ?>" />
        </form>
          <?php } ?>
        <small class="text-right"><p>Posté par : <strong><a href="joueurs.php?pseudo=<?php echo $req->auteur; ?>" style="color: black;"><?php echo $req->auteur; ?></a></strong></p></small>
      </div>
        </div>
        </div>
        <?php } ?>
        <?php } ?>

        <?php if(connect() AND $rang == "Administrateur" OR $rang == "Modérateur") { ?>
        <hr>
        <center><h4 class="lead" style="margin: 10px;">Répondre</h4></center>
        <center><form class="form-signin" method="post" style="width: auto;">
      <center>
          <form class="form-horizontal">
            <div class="control-group">
            <div class="controls">
            <textarea type="text" name="reponse" style="width:600px;height:150px;" placeholder="Réponse au problème" value="<?php echo $_POST['reponse']; ?>" required></textarea>
            </div>
            </div>
            <div class="control-group">
            <div class="controls">
            <button type="submit" class="btn btn-success">Envoyer</button><br><br>
            </div>
        </div>
          </form>   
      <center>
      </form></center>
      <hr>
        <?php } ?>
        <br><center><a href="support.php" class="btn">Revenir sur le support</a></center><br>
<?php } // FIN SI ON REGARDE UN TICKET
// SI ON AJOUTE UN TICKET
elseif(!empty($_GET['ajouter']) AND connect()) { ?>
<div class="boutique-corps">
<center><form class="form-signin" method="post" style="width: auto;">
      <center>
        <div class="well">
          <form class="form-horizontal">
            <div class="control-group">
            <label class="control-label">Titre de votre ticket</label>
            <div class="controls">
            <input type="text" name="titre" placeholder="Titre du ticket" value="<?php echo $_POST['titre']; ?>" required>
            </div>
            </div>
            <div class="control-group">
            <label class="control-label">Contenu de votre ticket</label>
            <div class="controls">
            <textarea type="text" name="contenu" style="width:600px;height:150px;" placeholder="Expliquez votre problème" value="<?php echo $_POST['contenu']; ?>" required></textarea>
            </div>
            </div>
            <div class="control-group">
            <div class="controls">
            <button type="submit" class="btn btn-success">Enregistrer</button><br><br>
            <a href="support.php" class="btn">Revenir sur le support</a>
            </div>
            </div>
          </form>
        
      <center>
      </form></center>
</div>
</div>
<?php // FI SI ON AJOUTE UN TICKET
} else { die('<META HTTP-equiv="refresh" content=0;URL=index.php>'); } ?>
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
include('include/footer.php'); ?>
