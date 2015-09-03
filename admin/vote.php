<?php 
$titre = 'Panel Admin - Vote';
include('../include/init.php');
if(connect()) {
if($rang == "Administrateur") {
if($_POST) {
  if(!empty($_POST['description']) AND !empty($_POST['temps']) AND !empty($_POST['url_vote'])) {
    $data = '<?php $des_vote = "'.$_POST['description'].'"; $temps_vote_ = "'.$_POST['temps'].'"; $url_vote = "'.$_POST['url_vote'].'"; $nbr_rubis_vote = "'.$_POST['nbr_rubis_vote'].'" ?>';
    $fp = fopen("../include/config_vote.php","w+");
    fwrite($fp, $data);
    fclose($fp);
    $success = 'Les parametres on été enregistré avec succès !';
  }
  if(!empty($_POST['commande'])) {
    $addCommande = $connexion->prepare('INSERT INTO vote SET commande=:commande');
    $addCommande->execute(array(
      'commande' => $_POST['commande'],
    ));
  }
}
if(!empty($_GET['supprimer'])) {
  $SupprCommande = $connexion->query('DELETE FROM vote WHERE id='.$_GET['supprimer'].'');
}
include('header.php');
?>
<!-- ====== CONTENUE DE LA PAGE ======= --> 
<div class="row-fluid">
      <div class="news-plugin" style="width:100%;">
      <h1 style="text-align: center;">Vote</h1><br>
       <div class="boutique-corps" style="width: auto;margin-left: 20px;margin-right: 20px;">
       <center><h3 style="color: #084D97;text-decoration: underline;">Parametre de vote</h3></center>
<?php if(!empty($success)) { ?>
<div class="alert alert-success"><?php echo $success; ?></div>
<?php } ?>
<center><form method="post">
<center><p>URL de vote :<br /> <input type="text" size="30" style="height: 25px;width: 270px;" name="url_vote" placeholder="URL de redirection" value="<?php if($_POST['url_vote']) { echo $_POST['url_vote']; } else { echo $url_vote; } ?>" required></p></center>
<center><p>Description :<br /> <input type="text" size="30" style="height: 25px;width: 270px;" name="description" placeholder="Description afficher sur la barre a droite" value="<?php if($_POST['temps']) { echo $_POST['description']; } else { echo $des_vote; } ?>" required></p></center>
<center><p>Temps entre chaque vote :<br /> <input type="text" size="30" placeholder="En minutes" style="height: 25px;" name="temps" value="<?php if($_POST['temps']) { echo $_POST['temps']; } else { echo $temps_vote_; } ?>" required></p></center>
<center><p>Gain de rubis par vote :<br /> <input type="text" size="30" placeholder="Facultatif" style="height: 25px;" name="nbr_rubis_vote" value="<?php if($_POST['nbr_rubis_vote']) { echo $_POST['nbr_rubis_vote']; } else { echo $nbr_rubis_vote; } ?>"></p></center>
<center><p>
    <input class="btn btn-success btn-medium" type="submit" value="Enregistrer" />
</p></center>
</form></center>
<hr>
<center><p class="lead">Ajouter une commande (Facultatif)</p></center>
<center><form method="post">
<div class="well" style="width: 300px;">
  <p>Commande</p><br><input type="text" size="30" placeholder="Sans slash (/)" style="height: 25px;text-align: center;" name="commande" required>
  <br><small>Commande qui sera executé quand le joueur va voter.<br>{PLAYER} = pseudo du voteur</small><br>
  <br><button type="submit" class="btn btn-success">Ajouter</button>
</div>
</form></center>
<hr>
<center><p class="lead">Liste des commandes</p></center>
<table class="table table-bordered">
        <tr>
            <td>Commande</td>
            <td>Action</td>
        </tr>
<?php
$sql = $connexion->query("SELECT * FROM vote ORDER BY id DESC");
$sql->setFetchMode(PDO::FETCH_OBJ);
while($req = $sql->fetch()) { ?>
<tr>
<td><strong>/<?php echo stripslashes($req->commande); ?></strong></td>
<td><a class="btn btn-danger" href="?supprimer=<?php echo $req->id; ?>">Supprimer</a></td>
</tr>
<?php
}
?>
</table>
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