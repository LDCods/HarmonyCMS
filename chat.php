<?php
$titre = "Chat en ligne";
include_once('include/init.php');
include_once('include/header.php');
if($_POST) {
  if($_POST['message'] != NULL) {
  $message = htmlentities($_POST['message'], ENT_QUOTES);
  $EnvoieCommande = $api->call("broadcastWithName", array(''.$message.'', ''.$pseudo.''));
  }
}
?>   
      <!-- Begin page content -->
        <div class="container">
          <div class="page-header">
          </div>
<!-- HEADER DE LA PAGE --> 
<div class="container">
  <div class="page-header">
  </div>
        <!-- ======== CONTENUE DE LA PAGE ========== -->
  </div>
  <div class="row-fluid">
    <div class="span8">
      <div class="news-plugin">
      <h1 style="text-align: center;font-family: minecraftiaregular;">Chat</h1><br>
      <div class="boutique-corps">

        	<?php 
            if($ServerVersion["success"] == '') {
              setFlash('Le serveur est éteint donc le chat en ligne ne peut pas être affiché.', 'danger');
              die('<META HTTP-equiv="refresh" content=0;URL=index.php>'); 
            } else { ?>
<?php //include('chat_frame.php'); ?>
<iframe src="chat_frame.php" scrolling=no width=636 style="height: 500px;border-radius: 4px;border: 5px solid #D8D8D8;"> <p>Votre navigateur ne supporte pas l'élément iframe</p></iframe>
<?php
} 

if(!empty($erreur)) {
  echo $erreur;
} 
?>

<?php if(connect()) { ?>
<br><div class="well" style="width: 600px;height: 30px;"><div class="input-append"><form method="POST">
    <input class="span2" name="message" type="text" style="width: 445px;" placeholder="Entrez votre message ici">
    <button class="btn" name="BtnEnvoie" type="submit">Envoyez le message</button>
    </form></div></div>
<?php } ?>
	    </div>
    </div>
    </div>
<?php include('include/menudroite.php'); ?>
</div>
</div>
</div>
<?php 
include('include/footer.php'); 
?>