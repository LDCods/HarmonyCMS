<?php 
$titre = 'Panel Admin - Categorie';
include('../include/init.php');
if(connect()) {
if($rang == "Administrateur") {
include('header.php');
?>
<!-- ====== CONTENUE DE LA PAGE ======= --> 
<div class="row-fluid">
      <div class="news-plugin" style="width:100%;">
      <h1 style="text-align: center;">Boutique</h1><br>
       <div class="boutique-corps" style="width: auto;margin-left: 20px;margin-right: 20px;">
       <center><h3 style="color: #084D97;text-decoration: underline;">Ajouter une Catégorie</h3></center>


<?php
//-----------------------------------------------------
// Vérification 1 : est-ce qu'on veut poster une categorie ?
//-----------------------------------------------------
if (isset($_POST['nom']))
{
    $nom = addslashes($_POST['nom']);
    // On vérifie si c'est une modification de news ou non.
        // Ce n'est pas une modification, on crée une nouvelle entrée dans la table.
        $PO = $connexion->query("INSERT INTO boutique_cat VALUES('', '" . $nom . "')");
        die('<META HTTP-equiv="refresh" content=0;URL=boutique.php?cat=ajout>');
}
?>

<form method="post">
<center><p>Nom :<br /> <input type="text" style="height: 30px;" size="30" name="nom"/></p></center>
<center><p>
<br />
     
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