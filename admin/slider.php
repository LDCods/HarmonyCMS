<?php 
$titre = 'Panel Admin - Slider';
include('../include/init.php');
if(connect()) {
if($rang == "Administrateur") {
include('header.php');
?>
<!-- ====== CONTENUE DE LA PAGE ======= --> 
<div class="row-fluid">
      <div class="news-plugin" style="width:100%;">
      <h1 style="text-align: center;">Slider</h1><br>
       <div class="boutique-corps" style="width: auto;margin-left: 20px;margin-right: 20px;">
       <center><h3 style="color: #084D97;text-decoration: underline;">Modifier le slider</h3></center><br>
       <center><a class="btn btn-success" href="modif_slider.php">Ajouter un slider</a></center><br>

<?php
//-----------------------------------------------------
// Vérification 1 : est-ce qu'on veut poster une slider ?
//-----------------------------------------------------
if (isset($_POST['titre']) AND isset($_POST['contenu']) AND isset($_POST['image']))
{
    $titre = addslashes($_POST['titre']);
    $contenu = addslashes($_POST['contenu']);
    $image = $_POST['image'];
    // On vérifie si c'est une modification de slider ou non.
    if ($_POST['id_slider'] == 0)
    {
        // Ce n'est pas une modification, on crée une nouvelle entrée dans la table.
        $PI = $connexion->query("INSERT INTO slider VALUES('', '" . $image . "', '" . $titre . "', '" . $contenu . "')");
    }
    else
    {
        // C'est une modification, on met juste à jour le titre et le contenu.
        $ER = $connexion->query("UPDATE slider SET titre='" . $titre . "', contenu='" . $contenu . "', image='" . $image . "' WHERE id='" . $_POST['id_slider'] . "'");
    }
}
  
//--------------------------------------------------------
// Vérification 2 : est-ce qu'on veut supprimer une slider ?
//--------------------------------------------------------
if (isset($_GET['supprimer'])) // Si l'on demande de supprimer une slider.
{
    // Alors on supprime la slider correspondante.
    // On protège la variable « id_slider » pour éviter une faille SQL.
    $_GET['supprimer'] = addslashes($_GET['supprimer']);
    $PD = $connexion->query('DELETE FROM slider WHERE id=\'' . $_GET['supprimer'] . '\'');
}
?>
<table class="table table-bordered">
        <tr>
            <td>Titre</td>
            <td>Contenu</td>
            <td>Image</td>
            <td>Action</td>
        </tr>
<?php
$sql = $connexion->query("SELECT * FROM slider ORDER BY id DESC");
$sql->setFetchMode(PDO::FETCH_OBJ);
while($req = $sql->fetch()) { ?>
<tr>
<td><?php echo $req->titre; ?></td>
<td><?php echo $req->contenu; ?></td>
<td><img src="<?php echo $req->image; ?>" class="img-rounded" style="width: 100px;"></img></td>
<td><center><a class="btn btn-info" href="modif_slider.php?modifier=<?php echo $req->id; ?>">Modifier</a>&nbsp;<a class="btn btn-danger" href="?supprimer=<?php echo $req->id; ?>">Supprimer</a></center></td>
</tr>
<?php
} // Fin de la boucle qui liste les slider.
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