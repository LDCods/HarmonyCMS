<?php
$titre = "Voter";
include('include/init.php'); 
include('include/header.php');
if($ServerVersion["success"] == '') {
  setFlash('Le serveur est éteint donc vous ne pouvez pas voter.', 'danger');
  die('<META HTTP-equiv="refresh" content=0;URL=index.php>'); 
  exit();
} else {
if(connect()) {
if($isOnline == "true") {
$datevote = time();
$ecartminute = ($datevote - $heurevote)/60;
$restant = round($temps_vote_ - $ecartminute, 0);
$Trestant = $restant*60;
$Trestant = date('H:i', $Trestant)
?>
<!-- HEADER DE LA PAGE --> 
<div class="container">
  <div class="page-header">
<?php
if(!empty($_GET['vote'])) {
  if($_GET['vote']=="ok") {
    echo '<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button><strong>Succès:</strong> Vous avez reçu votre récompense !</div>';
  }
}
?>
<!-- ======== CONTENUE DE LA PAGE ========== -->
  </div>
  <div class="row-fluid">
    <div class="span8">
      <div class="news-plugin">
      <h1 style="text-align: center;font-family: minecraftiaregular;">Voter pour nous !</h1><br><br>
      <div class="boutique-corps">
<?php 
//$tempsrevoter = ''.$tempsvoteheure.''+'03';
if($ecartminute >= 120) { ?>

<a name="Vote" href="<?Php echo $url_vote; ?>" target="_blank" onClick="start();" class="btn btn-success btn-large btn-block"><h3>Vote et gagne !</h3><br><br>Une fois que vous avez voter revenez sur cette page et attendez que votre vote soit comptabilisé sans actualiser la page pour récuperer ta récompense</a>

<div id="bip" class="display"></div>

<script>
var counter = 20;
var intervalId = null;
function action()
{
  // clearInterval(intervalId);
  document.getElementById("bip").innerHTML = '<br><form method="post"><input type="hidden" name="recompense" value="recompense"><button class="btn btn-info btn-large btn-block" name="Recompense" type="submit" href="voter.php?vote=ok" id="chrono"><h3>Récompense</h3><br>Clique ici pour récuperer ta récompense</button></form>';  
}
// function bip()
// {
//   document.getElementById("bip").innerHTML = "";
//   counter--;
// }
function start()
{
  // intervalId = setInterval(bip, 1000);
  setTimeout(action, 30000);
} 
</script>
<?php } else { ?>
<button class="btn btn-danger btn-large btn-block" href=""><h3>Tu ne peux voter que toutes les <?php $Etemps_vote_ = $temps_vote_*60; $Etemps_vote_ = date('H:m', $Etemps_vote_); $Etemps_vote_ = strtr($Etemps_vote_, ":", "Heure"); echo $Etemps_vote_; ?></h3><br> Vous avez déjà voté, veuillez attendre le temps imparti<br>Vous pourrez re-votez dans <?php $Trestant = strtr($Trestant, ":", "Heure"); echo $Trestant; ?> !</button>
<?php } ?>
 
<script language="javascript">
    function startChrono(i){
        i = (!i ? 0 : i)+1; //On augmente le compteur de 1
        var button = document.getElementById('chrono');
        if(i==10){
            //Si le compteur est à 15, on rend le bouton actif (utilisable)
            button.disabled = false;
        }
        else{
            //Si le compteur n'est pas à 15, on rappelle la fonction pour faire tourner le compteur
            setTimeout('startChrono('+i+')', 1000);
        }
    }
</script>
    </div>
    </div>
    </div>
<?php include('include/menudroite.php'); ?>
</div>
<div id="push"></div>
</div>
</div>
</div>
<?php 
include('include/footer.php');

if($_POST) {
 
if(!empty($_POST['recompense'])) {
  if($ecartminute >= $temps_vote_)  {
  $nbr_vote = $nombre_vote+1;
  $updateHeureVote = $connexion->prepare('UPDATE membres SET heurevote=:heurevote, nbr_vote=:nbr_vote WHERE pseudo=:pseudo');
  $updateHeureVote ->execute(array(
    'heurevote' => $datevote,
    'nbr_vote' => $nbr_vote,
    'pseudo' => $pseudo
  ));
  // RUBIS
  if(isset($nbr_rubis_vote)) {
  $newsolde = $rubis+$nbr_rubis_vote;
  $updateSolde = $connexion->prepare('UPDATE membres SET rubis=:rubis WHERE pseudo=:pseudo');
  $updateSolde ->execute(array(
      'rubis' => $newsolde, 
      'pseudo' => $pseudo,
  ));
  }
  // FIN 
  $sql = $connexion->query("SELECT * FROM vote ORDER BY id DESC");
  $sql->setFetchMode(PDO::FETCH_OBJ);
  while($req = $sql->fetch()) {
  $commande = str_replace('{PLAYER}', $pseudo, $req->commande);
  $Vote = $api->call("runConsoleCommand", array("".$commande.""));
  }
  die('<META HTTP-equiv="refresh" content=0;URL=voter.php>');
  }
}
}

} else {
  setFlash('Vous devez être connecté sur le serveur pour pouvoir voter !', 'danger');
  die('<META HTTP-equiv="refresh" content=0;URL=index.php>');
  exit();
}
} else {
  setFlash('Veuillez vous connectez pour avoir accès a la page demandée !', 'danger');
  die('<META HTTP-equiv="refresh" content=0;URL=connexion.php>');
  exit();
}
}
?>