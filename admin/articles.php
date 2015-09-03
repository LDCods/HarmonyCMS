<?php 
$titre = 'Panel Admin - Articles';
include('../include/init.php');
if(connect()) {
if($rang == "Administrateur") {
include('header.php');
?>
<!-- ====== CONTENUE DE LA PAGE ======= --> 
<div class="row-fluid">
      <div class="news-plugin" style="width:100%;">
      <h1 style="text-align: center;">Article</h1><br>
       <div class="boutique-corps" style="width: auto;margin-left: 20px;margin-right: 20px;">
       <center><h3 style="color: #084D97;text-decoration: underline;">Ajouter un article</h3></center>


<?php
if (isset($_GET['modifier'])) // Si on demande de modifier une news.
{
    // On protège la variable « modifier_news » pour éviter une faille SQL.
    $_GET['modifier'] = htmlspecialchars($_GET['modifier']);
    // On récupère les informations de la news correspondante.
    $retour = $connexion->query('SELECT * FROM boutique_article WHERE id=\'' . $_GET['modifier'] . '\'');
    $retour->setFetchMode(PDO::FETCH_OBJ);
    $donnees = $retour->fetch();
     
    // On place le titre et le contenu dans des variables simples.
    $nom = stripslashes($donnees->nom);
    $contenu = stripslashes($donnees->description);
    $prix = $donnees->prix;
    $image = $donnees->image;
    $categorie = $donnees->categorie;
    $retourE = $connexion->query('SELECT * FROM boutique_article_commande WHERE id_article=\'' . $_GET['modifier'] . '\'');
    $retourE->setFetchMode(PDO::FETCH_OBJ);
    $donneesE = $retourE->fetch();
    $commande = $donneesE->commande;
    $id_article = $donnees->id; // Cette variable va servir pour se souvenir que c'est une modification.
}
else // C'est qu'on rédige une nouvelle news.
{
    // Les variables $titre et $contenu sont vides, puisque c'est une nouvelle news.
    $nom = '';
    $contenu = '';
    $prix = '';
    $categorie = '';
    $commande = '';
    $image = '';
    $id_article = 0; // La variable vaut 0, donc on se souviendra que ce n'est pas une modification.
}

//-----------------------------------------------------
// Vérification 1 : est-ce qu'on veut poster un article ?
//-----------------------------------------------------
if (isset($_POST['nom']))
{
    $nom = addslashes($_POST['nom']);
    $contenu = $_POST['contenu'];
    $prix = $_POST['prix'];
    $categorie = $_POST['categorie'];
    $id_article = $_POST['id_article'];
    $image = $_POST['image'];

    // On vérifie si c'est une modification de news ou non.
    if($_POST['id_article'] == 0)
    {
        // Ce n'est pas une modification, on crée une nouvelle entrée dans la table.
        $newA = $connexion->query("INSERT INTO boutique_article VALUES('', '" . $nom . "', '" . $contenu . "', '" . $prix . "', '".$image."', '" . $categorie . "')");
        die('<META HTTP-equiv="refresh" content=0;URL=boutique.php?article=ajout>');
    }
    else
    {
        // On protège la variable "id_news" pour éviter une faille SQL.
        $_POST['id_article'] = addslashes($_POST['id_article']);
        // C'est une modification, on met juste à jour le titre et le contenu.
        $ModA = $connexion->query("UPDATE boutique_article SET nom='" . $nom . "', description='" . $contenu . "', prix='" . $prix . "', image='".$image."', categorie='" . $categorie . "' WHERE id='" . $_POST['id_article'] . "'");

        die('<META HTTP-equiv="refresh" content=0;URL=boutique.php?article=modif>');
    }
}
if($_POST) {
if(!empty($_POST['commande'])) {
    $addCommande = $connexion->prepare('INSERT INTO boutique_article_commande SET commande=:commande, id_article=:id_article');
    $addCommande->execute(array(
      'commande' => $_POST['commande'],
      'id_article' => $_GET['modifier']
    ));
}
}

if(!empty($_GET['supprimer'])) {
  $SupprCommande = $connexion->query('DELETE FROM boutique_article_commande WHERE id='.$_GET['supprimer'].'');
}
?>

<form method="post">
<center><p>Nom :<br /> <input type="text" size="30" style="height: 25px;" name="nom" value="<?php echo $nom; ?>" /></p></center>
<center><p>
    Description :<br />
    <textarea name="contenu" cols="50" rows="7">
    <?php echo $contenu; ?>
    </textarea><br />
    <center><p>Prix :<br /> <input type="text" size="30" style="height: 25px;" name="prix" value="<?php echo $prix; ?>" /></p></center>
    <center><p>Lien de l'image :<br /> <input type="text" size="30" style="height: 25px;" name="image" value="<?php echo $image; ?>" /></p></center>
    <center>Categorie: <br>
    <SELECT name="categorie">
    <?php
    $sql = $connexion->query("SELECT * FROM boutique_cat ORDER BY id");
    $sql->setFetchMode(PDO::FETCH_OBJ);
    while($req = $sql->fetch()) { ?>
    <OPTION value="<?php echo $req->nom; ?>" <?php if($categorie == $req->nom){ echo 'selected'; } ?>><?php echo $req->nom; ?></OPTION><?php } ?>
    </SELECT></center>
    <?php 
    if($id_article == 0) {
        echo '<center><p class="muted"><small><em>Une fois que vous avez créer votre article modifier-le pour ajouter une commande.</em></small></p></center>'; 
    } 
    ?>
    <input type="hidden" name="id_article" value="<?php echo $id_article; ?>" />
    <input class="btn btn-success" type="submit" value="Envoyer" />
</p></center>
</form>
<?php if($id_article != 0) { ?>
<hr>
<center><p class="lead">Ajouter une commande</p></center>
<center><form method="post">
<div class="well" style="width: 300px;">
  <p>Commande</p><br><input type="text" size="30" placeholder="Sans slash (/)" style="height: 25px;text-align: center;" name="commande" required>
  <br><small>{PLAYER} = pseudo de l'acheteur</small><br>
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
$sql = $connexion->query("SELECT * FROM boutique_article_commande WHERE id_article='" . $_GET['modifier'] . "'");
$sql->setFetchMode(PDO::FETCH_OBJ);
while($req = $sql->fetch()) { ?>
<tr>
<td><strong>/<?php echo stripslashes($req->commande); ?></strong></td>
<td><a class="btn btn-danger" href="?modifier=<?php echo $_GET['modifier']; ?>&supprimer=<?php echo $req->id; ?>">Supprimer</a></td>
</tr>
<?php
}
?>
</table>
<?php } ?>
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