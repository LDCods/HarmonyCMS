<?php 
$titre = 'Panel Admin - Membres';
include('../include/init.php');
if(connect()) {
if($rang == "Administrateur") {
include('header.php');
?>
<div class="container">
          <div class="page-header">
<?php
if(!empty($_GET['delete'])) {
  if($_GET['delete']=="no") {
    echo '<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">&times;</button><strong>Erreur:</strong> Vous ne pouvez pas supprimer votre compte !</div>';
  }
  if($_GET['delete']=="ok") {
    echo '<div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert">&times;</button><strong>Succès:</strong> Le membre a été supprimer avec succès !</div>';
  }
}
if(!empty($_GET['update'])) {
  if($_GET['update']=="ok") {
    echo '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button><strong>Succès:</strong> Le membre a été modifier avec succès !</div>';
  }
}
?>
</div></div>
<!-- ====== CONTENUE DE LA PAGE ======= --> 
<div class="row-fluid">
      <div class="news-plugin" style="width:100%;">
      <h1 style="text-align: center;">Liste des membres</h1><br>
       <div class="boutique-corps" style="width: auto;margin-left: 20px;margin-right: 20px;">
       <center><h3 style="color: #084D97;text-decoration: underline;">Liste des membres</h3></center>
      
<table class="table table-bordered">
        <tr>
            <td>Pseudo</td>
            <td>Email</td>
            <td>Rang</td>
            <td>Rubis</td>
            <td>Nombre de vote</td>
        </tr>
        <?php
        $sql = $connexion->query("SELECT * FROM membres ORDER BY rang DESC");
        $sql->setFetchMode(PDO::FETCH_OBJ);
        while($req = $sql->fetch()) { ?>
        <tr>
            <td><strong><a style="color: black;" href="profil_membre.php?pseudo=<?php echo $req->pseudo; ?>"><?php echo $req->pseudo; ?></a></strong></td>
            <td><?php echo $req->email; ?></td>
            <td><?php if($req->rang=="1") { echo "Membre"; } elseif($req->rang=="2") { echo "Modérateur"; } else { echo "Administrateur"; } ?></td>
            <td><?php if($req->rubis==null) { echo "0"; } else { echo $req->rubis; } ?></td>
            <td><?php if($req->nbr_vote==null) { echo "0"; } else { echo $req->nbr_vote; } ?></td>
        </tr>
        <?php } ?>
    </table>

       
       </div>
      </div>
    </div></div></div></div>
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