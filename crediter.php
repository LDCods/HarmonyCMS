<?php
$titre = "Crediter son compte - Etape 1";
include('include/init.php'); 
if(connect()) {
  if(!empty($_GET)) {
  if(!empty($_GET['paypal']) AND $_GET['paypal'] == "ok") {
    if(file_exists('paypal_log.txt')) {
      unlink('paypal_log.txt');
      setFlash('Le paiement c\'est bien effectué. '.$ajout_rubis_paypal.' rubis ont bien été ajouté a votre compte !', 'success');
      header('Location: crediter.php');
      exit();
    } else {
    header('Location: crediter.php');
    exit();
  }
  }
}
include('include/header.php');
?>
<!-- HEADER DE LA PAGE -->
<div class="container">
	 <div class="page-header">
<!-- ======= ALERTE ========= -->
<?php
flash();
?>
<!-- HEADER DE LA PAGE --> 
<div class="container">
  <div class="page-header">
<!-- ============= CONTENUE DE LA PAGE ========== -->
  </div>
  <div class="row-fluid">
    <div class="span8">
      <div class="news-plugin">
      <h1 style="text-align: center;font-family: minecraftiaregular;">Crediter son compte <br> Etape 1</h1><br>
<div class="boutique-corps">
	<h3>Choississez votre mode de paiement:</h3><br><br>
<?php 
if(isset($_GET['code']) AND $_GET['code']=="faux") { 
  echo '<div class="alert alert-error">Votre code est erron&eacute ! Veuillez r&eacute-essayer.</div><br><br>'; 
} 
?>
<center><div class="well" style="max-width: 400px; margin: 0 auto 10px;"><center>Payer via StarPass · 1 code vous ajoute <?php echo $nbr_rubis_code ?> rubis</center><a href="crediter_object.php?offre=starpass" class="btn btn-large btn-block btn-primary">StarPass</a></div><br></center>
<?php if(isset($paypal_info) AND $paypal_info == "true") { ?>
<center><div class="well" style="max-width: 400px; margin: 0 auto 10px;"><center>Payer via Paypal · <?php echo $prix_rubis_paypal; ?>€ vous ajoute <?php echo $ajout_rubis_paypal ?> rubis</center>
<?php
/* Les variables suivantes doivent être personnalisées selon vos besoins */
  $email_paypal = $mail_paypal;/*email associé au compte paypal du vendeur*/
  $item_prix = $prix_rubis_paypal;    /*prix du produit*/
  $item_nom = $ajout_rubis_paypal.' rubis sur le site  '.$nom; /*Nom du produit*/
  $url_retour = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']."?paypal=ok";/*page de remerciement à créer*/
  $url_cancel = $url; /* page d'annulation d'achat SI RETOUR */
  $url_confirmation = $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
  $url_confirmation = substr($url_confirmation, 0, -12);
  $url_confirmation = 'http://'.$url_confirmation.'verif_paypal.php';/*page de confirmation d'achat*/
/* fin déclaration des variables */
  $reqID = $connexion->prepare('SELECT id FROM membres WHERE session=:session');
  $reqID->execute(array(
    'session' => $_SESSION['session']
  ));
  $reqID = $reqID->fetch();

  echo '
  <form action="https://www.paypal.com/cgi-bin/webscr" method="post">
  <input type="hidden" name="cmd" value="_xclick"/>
  <input type="hidden" name="business" value="'.$email_paypal.'"/>
  <input type="hidden" name="item_name" value="'.$item_nom.'"/>
  <input type="hidden" name="amount" value="'.$item_prix.'"/>
  <input type="hidden" name="currency_code" value="EUR"/>
  <input type="hidden" name="no_note" value="1"/>
  <input name="no-shipping" type="hidden" value="1">
  <input name="tax" type="hidden" value="0.00">
  <input name="bn" type="hidden" value="PP-BuyNowBF">
  <input type="hidden" name="lc" value="FR"/>
  <input type="hidden" name="notify_url" value="'.$url_confirmation.'"/>
  <input type="hidden" name="cancel_return" value="'.$url_cancel.'">
  <input type="hidden" name="return" value="'.$url_retour.'">
  <input type="hidden" name="custom" value="user_id='.$reqID['id'].'">
  <button name="submit" type="submit" class="btn btn-large btn-block btn-primary" alt="PayPal - la solution de paiement en ligne la plus simple et la plus sécurisée !">PayPal</button></div><br></center>
  </form> ';
} ?>
    </div>
  </div>
    </div>
<?php include('include/menudroite.php'); ?>
<div id="push"></div>
</div>
</div>
</div>
</div>
</div>
<?php 
include('include/footer.php');
} else {
    setFlash('Veuillez vous connectez pour avoir accès a la page demandée !', 'danger');
    header('Location: connexion.php');
} ?>