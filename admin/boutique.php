<?php 
$titre = 'Panel Admin - Boutique';
include('../include/init.php');
if(connect()) {
if($rang == "Administrateur") {
include('header.php');
?>
<?php
//--------------------------------------------------------
// Vérification 1 : est-ce qu'on veut supprimer une catégorie ?
//--------------------------------------------------------
if (isset($_GET['supprimer_cat'])) // Si l'on demande de supprimer une news.
{
    // Alors on supprime la news correspondante.
    // On protège la variable « id_news » pour éviter une faille SQL.
    $_GET['supprimer_cat'] = addslashes($_GET['supprimer_cat']);
    $sql3 = $connexion->query('SELECT * FROM boutique_cat WHERE id=\'' . $_GET['supprimer_cat'] . '\'');
    $sql3->setFetchMode(PDO::FETCH_OBJ);
    $req3 = $sql3->fetch();
    $nomcat = $req3->nom;
    $DeleteCat = $connexion->query('DELETE FROM boutique_cat WHERE id=\'' . $_GET['supprimer_cat'] . '\'');
    $DeleteArt = $connexion->query('DELETE FROM boutique_article WHERE categorie=\'' . $nomcat . '\'');
}
if (isset($_GET['supprimer_articles'])) // Si l'on demande de supprimer une news.
{
    // Alors on supprime la news correspondante.
    // On protège la variable « id_news » pour éviter une faille SQL.
    $_GET['supprimer_articles'] = addslashes($_GET['supprimer_articles']);
    $DeleteCat = $connexion->query('DELETE FROM boutique_article WHERE id=\'' . $_GET['supprimer_articles'] . '\'');
}
?>
<!-- ====== CONTENUE DE LA PAGE ======= --> 
<div class="row-fluid">
      <div class="news-plugin" style="width:100%;">
      <h1 style="text-align: center;">Boutique</h1><br>
       <div class="boutique-corps" style="width: auto;margin-left: 20px;margin-right: 20px;">
       <center><h3 style="color: #084D97;text-decoration: underline;">Catégorie</h3><a class="btn btn-success" href="categorie.php">Ajouter une Catégorie</a></center><br>
       <table class="table table-striped">
              <thead>
                <tr>
                  <th>Nom</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $sql = $connexion->query("SELECT * FROM boutique_cat ORDER BY id");
                $sql->setFetchMode(PDO::FETCH_OBJ);
                while($req = $sql->fetch()) { 
              ?>
                <tr>
                  <td><?php echo $req->nom; ?></td>
                  <td><a class="btn btn-danger" href="?supprimer_cat=<?php echo $req->id; ?>">Supprimer</a></td>
                </tr>
              <?php } ?>
              </tbody>
            </table>
       <center><h3 style="color: #084D97;text-decoration: underline;">Article</h3><a class="btn btn-success" href="articles.php">Ajouter un Article</a></center><br>
       <table class="table table-striped">
              <thead>
                <tr>
                  <th>Nom</th>
                  <th>Prix</th>
                  <th>Catégorie</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
              <?php
                $sql = $connexion->query("SELECT * FROM boutique_article ORDER BY id");
                $sql->setFetchMode(PDO::FETCH_OBJ);
                while($req = $sql->fetch()) { 
              ?>
                <tr>
                  <td><?php echo $req->nom; ?></td>
                  <td><?php echo $req->prix; ?> Rubis</td>
                  <td><?php echo $req->categorie; ?></td>
                  <td><a class="btn btn-info" href="articles.php?modifier=<?php echo $req->id; ?>">Modifier</a>&nbsp;<a class="btn btn-danger" href="?supprimer_articles=<?php echo $req->id; ?>">Supprimer</a></td>
                </tr>
              <?php } ?>
              </tbody>
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