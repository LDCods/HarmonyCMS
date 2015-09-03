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

<?php
if (isset($_GET['modifier'])) // Si on demande de modifier une slider.
{
    // On protège la variable « modifier_slider » pour éviter une faille SQL.
    $_GET['modifier'] = htmlspecialchars($_GET['modifier']);
    // On récupère les informations de la slider correspondante.
    $retour = $connexion->query('SELECT * FROM slider WHERE id=\'' . $_GET['modifier'] . '\'');
    $retour->setFetchMode(PDO::FETCH_OBJ);
    $donnees = $retour->fetch();
     
    // On place le titre et le contenu dans des variables simples.
    $titre = stripslashes($donnees->titre);
    $contenu = stripslashes($donnees->contenu);
    $image = stripcslashes($donnees->image);
    $id_slider = $donnees->id; // Cette variable va servir pour se souvenir que c'est une modification.
}
else // C'est qu'on rédige une nouvelle slider.
{
    // Les variables $titre et $contenu sont vides, puisque c'est une nouvelle slider.
    $image = '';
    $titre = '';
    $contenu = '';
    $id_slider = 0; // La variable vaut 0, donc on se souviendra que ce n'est pas une modification.
}
?>

<form action="slider.php" method="post">
<center><p>Titre :<br /> <input type="text" size="30" style="height: 30px;" name="titre" placeholder="Le titre de l'image." value="<?php echo $titre; ?>" /></p></center>
<center><p>Lien de l'image: <br><input type="text" size="30" style="height: 30px;" placeholder="Obligatoire" value="<?php echo $image; ?>" name="image"/></p></center>
<center><p>
    Contenu :<br />
    <textarea name="contenu" cols="50" rows="7">
    <?php echo $contenu; ?>
    </textarea><br />
     
    <input type="hidden" name="id_slider" value="<?php echo $id_slider; ?>" />
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