<?php 
$titre = 'Panel Admin - Règlages';
include('../include/init.php');
if(connect()) {
if($rang == "Administrateur") {
  if($_POST) {
  if(!empty($_POST['nom']) AND !empty($_POST['description']) AND !empty($_POST['keywords']) AND !empty($_POST['background']) AND !empty($_POST['ip_afficher']) AND !empty($_POST['url']) AND !empty($_POST['nbr_rubis_code']) AND !empty($_POST['idd']) AND !empty($_POST['idp']) AND !empty($_POST['nom_serveur'])) {
    if($_POST['onlyPremium'] != 'true') {
      $EonlyPremium = 'false'; 
    } else { 
      $EonlyPremium = 'true';
    }
    if($_POST['isConnected'] != 'true') {
      $EisConnected = 'false'; 
    } else { 
      $EisConnected = 'true';
    }
    if($_POST['paypal_info'] != 'true') {
      $paypal_info = 'false'; 
    } else { 
      $paypal_info = 'true';
    }
    $data = '<?php
    $nom = "'.$_POST['nom'].'";
    $description = "'.$_POST['description'].'";
    $keywords = "'.$_POST['keywords'].'";
    $background = "'.$_POST['background'].'";
    $ip_afficher = "'.$_POST['ip_afficher'].'";
    $nom_serveur = "'.$_POST['nom_serveur'].'";
    $url = "'.$_POST['url'].'";
    $url_verif = substr($url, -1, 1);
    if ($url_verif == "/") {
      $url = substr($url,0,-1);
    }
    $lien_youtube = "'.$_POST['youtube'].'";
    $lien_facebook = "'.$_POST['facebook'].'";
    $lien_twitter = "'.$_POST['twitter'].'";
    $onlyPremium = "'.$EonlyPremium.'";
    $isConnected = "'.$EisConnected.'";

    /* STARPASS */ 
    $nbr_rubis_code = "'.$_POST['nbr_rubis_code'].'";
    $idd = "'.$_POST['idd'].'";
    $idp = "'.$_POST['idp'].'";

    /* PAYPAL */
    $paypal_info = "'.$_POST['paypal_info'].'";
    $mail_paypal = "'.$_POST['mail_paypal'].'";
    $ajout_rubis_paypal = "'.$_POST['ajout_rubis_paypal'].'";
    $prix_rubis_paypal = "'.$_POST['prix_rubis_paypal'].'";
    ?>';
    $fp = fopen("../include/infos.php","w+");
    fwrite($fp, $data);
    fclose($fp);
    $success = "Les règlages ont bien été enregistrer";
  } else {
    $erreur = "Veuillez remplir tout les champs !";
  }
}
include('../include/infos.php');
include('header.php');
?>
<!-- ====== CONTENUE DE LA PAGE ======= --> 
<div class="row-fluid">
      <div class="news-plugin" style="width:100%;">
      <h1 style="text-align: center;">Réglages</h1><br>
       <div class="boutique-corps" style="width: auto;margin-left: 20px;margin-right: 20px;">
       <center><h3 style="color: #084D97;text-decoration: underline;">Infos sur le site</h3></center><br>
<center><form class="form-signin" method="post" style="width: 900px;">
      <center>
        <div class="well">
          <?php if(!empty($erreur)) { ?>
          <div class="alert alert-error"><?php echo $erreur; ?></div>
          <?php } ?>
          <?php if(!empty($success)) { ?>
          <div class="alert alert-success"><?php echo $success; ?></div>
          <?php } ?>
          <form class="form-horizontal">
            <div class="control-group">
            <label class="control-label">Nom du site</label>
            <div class="controls">
            <input type="text" name="nom" placeholder="Exemple: LapisCraft" value="<?php echo $nom; ?>" required>
            </div>
            </div>
            <div class="control-group">
            <label class="control-label">Description du site</label>
            <div class="controls">
            <input type="text" name="description" placeholder="Exemple: Serveur PvP" value="<?php echo $description; ?>" required>
            </div>
            </div>
            <div class="control-group">
            <label class="control-label">Mot clés</label>
            <div class="controls">
            <input type="text" name="keywords" placeholder="Separer-les par des virgules" value="<?php echo $keywords; ?>" required>
            </div>
            </div>
            <div class="control-group">
            <label class="control-label">Image de fond</label>
            <div class="controls">
            <input type="text" name="background" placeholder="L'image de fond du site" value="<?php echo $background; ?>" required>
            </div>
            </div>
            <div class="control-group">
            <label class="control-label">IP du serveur a afficher</label>
            <div class="controls">
            <input type="text" name="ip_afficher" placeholder="Exemple: play.serveur.fr" value="<?php echo $ip_afficher; ?>" required>
            </div>
            </div>
            <div class="control-group">
            <label class="control-label">Nom du serveur a afficher</label>
            <div class="controls">
            <input type="text" name="nom_serveur" placeholder="Exemple: BattleFight" value="<?php echo $nom_serveur; ?>" required>
            </div>
            </div>
            <div class="control-group">
            <label class="control-label">URL d'accès au site</label>
            <div class="controls">
            <input type="text" name="url" placeholder="Exemple: http://eywek.fr" value="<?php echo $url; ?>" required>
            </div>
            </div>
            <div class="control-group">
            <label class="control-label">Lien de la chaine YouTube</label>
            <div class="controls">
            <input type="text" name="youtube" placeholder="Facultatif" value="<?php echo $lien_youtube; ?>">
            </div>
            </div>
            <div class="control-group">
            <label class="control-label">Lien de la page Facebook</label>
            <div class="controls">
            <input type="text" name="facebook" placeholder="Facultatif" value="<?php echo $lien_facebook; ?>">
            </div>
            </div>
            <div class="control-group">
            <label class="control-label">Lien du Twitter</label>
            <div class="controls">
            <input type="text" name="twitter" placeholder="Facultatif" value="<?php echo $lien_twitter; ?>">
            </div>
            </div>
            <div class="control-group">
            <label class="control-label">Options</label>
            <div class="controls">
            <label class="checkbox inline">
            <input type="checkbox" name="onlyPremium" value="true" <?php if($onlyPremium == "true") { echo 'checked'; } ?>> Obliger un membre a avoir minecraft premium pour s'inscrire
            </label><br>
            <label class="checkbox inline">
            <input type="checkbox" name="isConnected" value="true" <?php if($isConnected == "true") { echo 'checked'; } ?>> Obliger un membre a être connecter sur le serveur pour s'inscrire
            </label>
            </div>
            </div><br>
            <hr>
          <center><h4>StarPass</h4></center>
            <div class="control-group">
            <label class="control-label">Valeur d'un code acheté</label>
            <div class="controls">
            <input type="text" name="nbr_rubis_code" placeholder="Nombre de rubis" value="<?php echo $nbr_rubis_code; ?>" required>
            </div>
            </div>
            <div class="control-group">
            <label class="control-label">IDD <a aria-hidden="true" type="text" href="#aide" role="button" data-toggle="modal">Aide <i class="icon-question-sign" title="Comment avoir l'IDD ?"></i></a></label>
            <div class="controls">
            <input type="text" name="idd" placeholder="Suivre le tuto" value="<?php echo $idd; ?>" required>
            </div>
            </div>
            <div class="control-group">
            <label class="control-label">IDP <a aria-hidden="true" type="text" href="#aide" role="button" data-toggle="modal">Aide <i class="icon-question-sign" title="Comment avoir l'IDD ?"></i></a></label>
            <div class="controls">
            <input type="text" name="idp" placeholder="Suivre le tuto" value="<?php echo $idp; ?>" required>
            </div>
            </div>
            <hr>
            <center><h4>PayPal</h4></center>
            <div class="controls">
            <label class="checkbox inline">
            <input type="checkbox" name="paypal_info" value="true" <?php if($paypal_info == "true") { echo 'checked'; } ?>> Activer le paiement par PayPal
            </div><br>
            <div class="control-group">
            <label class="control-label">Mail PayPal (La votre)</label>
            <div class="controls">
            <input type="text" name="mail_paypal" placeholder="Mail du vendeur" value="<?php echo $mail_paypal; ?>">
            </div>
            </div>
            <div class="control-group">
            <label class="control-label">Valeur d'un paiement</label>
            <div class="controls">
            <div class="input-append">
            <input class="span2" type="text" style="width:192px;" name="prix_rubis_paypal" placeholder="En euros" value="<?php echo $prix_rubis_paypal; ?>">
            <span class="add-on">€</span>
            </div>
            </div>
            </div>
            <div class="control-group">
            <label class="control-label">Nombre de rubis par paiement</label>
            <div class="controls">
            <div class="input-append">
            <input class="span2" type="text" style="width:192px;" name="ajout_rubis_paypal" placeholder="Exemple : 1 rubis" value="<?php echo $ajout_rubis_paypal; ?>">
            <span class="add-on"><img src="../images/rubis.png"></span>
            </div>
            </div>
            </div>
            <hr>
            <div class="control-group">
            <div class="controls">
            <a aria-hidden="true" type="text" href="#aide" role="button" data-toggle="modal"><small>Aide</small></a><br><br>
            <button type="submit" class="btn btn-success">Enregistrer</button>
            </div>
            </div>
          </form>
        
      <center>
      </form></center>
      </div>
    <!-- MODAL AIDE -->
    <!-- ============= IDD =========== -->
<div id="aide" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="aideLabel" aria-hidden="true">
    <div class="modal-header">
      <button class="close" data-dismiss="modal" aria-hidden="true">×</button>
      <h3 class="lead">Comment mettre en place StarPass ?</h3> 
    </div>
    <div class="modal-body">
      <h3>Configuration Starpass</h3> 
    <p>Afin de reçevoir les revenus grâce aux achats de crédits pour la boutique automatique, vous devez configurer votre document starpass.</p>
    <ul>
      <li>Rendez vous sur le site de <a href="http://www.starpass.fr/">Starpass</a> et connectez-vous.</li>
      <li>Allez dans <a href="http://membres.starpass.fr/document_creer.php">Créer un document</a>, puis choisissez <a href="?http://membres.starpass.fr/document_paiement.php?iPaymentType=0">StarPass CLASSIC</a>.</li>
      <li>
        Insérer ceci dans les champs correspondant:<br>
        <b>URL de la page d'accès</b> : <?php echo "http://votresite.com/crediter_object.php?offre=starpass"; ?><br>
        <b>URL du document</b> : <?php echo "http://votresite.com/addcredit.php"; ?><br>
        <b>URL d'erreur</b> : <?php echo "http://votresite.com/crediter.php?code=faux"; ?><br><br>
        <img src="../images/starpass.png" alt="starpass">
      </li>
      <li>Remplissez les autres champs comme vous le désirez et cliquez sur <i>Enregistrer</i>.</li>
      <li>
        Vous allez être rédigez sur une page qui contiendra deux scripts.<br>
        Allez en bas de la page, et cliquez sur <strong>Installation Script PHP</strong><br>
        <img src="../images/installationphp.png">         
      </li>
      <li>
        Et maintenant vous pouvez récupérer les <strong>IDD</strong> et <strong>IDP</strong> comme sur l'image<br>
        <center><img src="../images/idpidd.png"></center><br>
      </li>
    </ul>

    </div>
    <div class="modal-footer">
      <button class="btn" data-dismiss="modal" aria-hidden="true">Annuler</button>
      <button type="submit" class="btn btn-success">Ok</button>
    </div>
  </div>
    <!-- +++++=======++++++ -->
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