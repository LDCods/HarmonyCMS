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
       <center><h3 style="color: #084D97;text-decoration: underline;">Rediger une News</h3></center>


<?php
if (isset($_GET['modifier_news'])) // Si on demande de modifier une news.
{
    // On protège la variable « modifier_news » pour éviter une faille SQL.
    $_GET['modifier_news'] = htmlspecialchars($_GET['modifier_news']);
    // On récupère les informations de la news correspondante.
    $retour = $connexion->query('SELECT * FROM news WHERE id=\'' . $_GET['modifier_news'] . '\'');
    $retour->setFetchMode(PDO::FETCH_OBJ);
    $donnees = $retour->fetch();
     
    // On place le titre et le contenu dans des variables simples.
    $titre = stripslashes($donnees->titre);
    $contenu = stripslashes($donnees->contenu);
    $description = stripcslashes($donnees->description);
    $id_news = $donnees->id; // Cette variable va servir pour se souvenir que c'est une modification.
}
else // C'est qu'on rédige une nouvelle news.
{
    // Les variables $titre et $contenu sont vides, puisque c'est une nouvelle news.
    $titre = '';
    $contenu = '';
    $description = '';
    $id_news = 0; // La variable vaut 0, donc on se souviendra que ce n'est pas une modification.
}
?>

<form action="news.php" method="post">
<center><p>Titre :<br /> <input type="text" size="30" style="height: 30px;" name="titre" value="<?php echo $titre; ?>" /></p></center>
<center><p>Lien de l'image: <br><input type="text" size="30" style="height: 30px;" placeholder="Facultatif" name="image"/></p></center>
<center><p>
    Courte description :<br />
    <textarea name="description" maxlength="130" cols="50" rows="7">
    <?php echo $description; ?>
    </textarea><br />
    Contenu :<br />
    <textarea name="contenu" cols="50" rows="7">
    <?php echo $contenu; ?>
    </textarea><br />
     
    <input type="hidden" name="id_news" value="<?php echo $id_news; ?>" />
    <input class="btn btn-success" type="submit" value="Envoyer" />
</p></center>
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