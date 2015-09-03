<?php 
$titre = 'Panel Admin - News';
include('../include/init.php');
if(connect()) {
if($rang == "Administrateur") {
include('header.php');
?>
<!-- ====== CONTENUE DE LA PAGE ======= --> 
<div class="row-fluid">
      <div class="news-plugin" style="width:100%;">
      <h1 style="text-align: center;">News</h1><br>
       <div class="boutique-corps" style="width: auto;margin-left: 20px;margin-right: 20px;">
       <center><h3 style="color: #084D97;text-decoration: underline;">Modification des News</h3></center><br>
       <center><a class="btn btn-success" href="rediger_news.php">Ajouter une News</a></center><br>

<?php
//-----------------------------------------------------
// Vérification 1 : est-ce qu'on veut poster une news ?
//-----------------------------------------------------
if (isset($_POST['titre']) AND isset($_POST['contenu']) AND isset($_POST['description']))
{
    $titre = addslashes($_POST['titre']);
    $contenu = addslashes($_POST['contenu']);
    $description = addslashes($_POST['description']);
    $image = $_POST['image'];
    // On vérifie si c'est une modification de news ou non.
    if ($_POST['id_news'] == 0)
    {
        // Ce n'est pas une modification, on crée une nouvelle entrée dans la table.
       $GH = $connexion->query("INSERT INTO news VALUES('', '" . $titre . "', '" . $description . "', '" . $contenu . "', '" . time() . "', '" . $pseudo . "', '" . $image . "')");
    }
    else
    {
        // On protège la variable "id_news" pour éviter une faille SQL.
        $_POST['id_news'] = addslashes($_POST['id_news']);
        // C'est une modification, on met juste à jour le titre et le contenu.
        $JK = $connexion->query("UPDATE news SET titre='" . $titre . "', description='" . $description . "', contenu='" . $contenu . "', image='" . $image . "' WHERE id='" . $_POST['id_news'] . "'");
    }
}
  
//--------------------------------------------------------
// Vérification 2 : est-ce qu'on veut supprimer une news ?
//--------------------------------------------------------
if (isset($_GET['supprimer_news'])) // Si l'on demande de supprimer une news.
{
    // Alors on supprime la news correspondante.
    // On protège la variable « id_news » pour éviter une faille SQL.
    $supprimer_news = addslashes($_GET['supprimer_news']);
    $UY = $connexion->query('DELETE FROM news WHERE id=\'' . $supprimer_news . '\'');
    $AP = $connexion->query('DELETE FROM comment WHERE news=\'' . $_GET['supprimer_news'] . '\'');
}
?>
<table class="table table-bordered">
        <tr>
            <td>Titre</td>
            <td>Date</td>
            <td>Action</td>
        </tr>
<?php
$sql = $connexion->query("SELECT * FROM news ORDER BY id DESC");
$sql->setFetchMode(PDO::FETCH_OBJ);
while($req = $sql->fetch()) { ?>
<tr>
<td><?php echo stripslashes($req->titre); ?></td>
<td><?php echo date('d/m/Y', $req->timestamp); ?></td>
<td><a class="btn btn-info" href="rediger_news.php?modifier_news=<?php echo $req->id; ?>">Modifier</a>&nbsp;<a class="btn btn-danger" href="?supprimer_news=<?php echo $req->id; ?>">Supprimer</a></td>
</tr>
<?php
} // Fin de la boucle qui liste les news.
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