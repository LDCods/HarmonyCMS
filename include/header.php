<?php 
if(!file_exists('include/installation.txt')) { 
  header('Location: install/index.php');
  exit();
}
$URLMaint = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
if(isset($maintenance)) {
if($maintenance == "true" AND $URLMaint != $url.'/connexion.php' AND $URLMaint != $url.'/maintenance.php') {
    if($rang != "Administrateur") {
        header('Location: '.$url.'/maintenance.php');
        exit();
    }
}
}
require_once('include/JSONAPI.php');
include_once('include/variables.php');

$req_nbVisite = $connexion->prepare('SELECT * FROM visites WHERE date=:date AND ip=:ip');
$req_nbVisite->execute(array(
  'date' => $date,
  'ip' => $_SERVER['REMOTE_ADDR']
));
$nbVisite = $req_nbVisite->rowCount();
if($nbVisite == "0") {
  $addVisite = $connexion->prepare("INSERT INTO visites SET date=:date, ip=:ip");
  $addVisite->execute(array(
    'date' => $date,
    'ip' => $_SERVER['REMOTE_ADDR']
  ));
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <title><?php echo $nom; ?> | <?php echo $titre; ?></title>
    <meta http-equiv="Content-Type" content="text/html;charset=ut8" />
    <meta re="stylesheet" href="style.css" media="screen">
    <link rel="stylesheet" media="screen" href="style.css">
    <meta name="keywords" content="CMS, minecraft, LapisCraft, <?php echo $keywords; ?>">
    <meta name="author" content="Eywek, mineconstructe, Valentin Touffet">
    <link rel="icon" href="images/favicon.gif">
    <link href="bootstrap/css/bootstrap.css" rel="stylesheet" type="text/css">
    <link href="bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" type="text/css">
    <!-- CSS -->
    <style type="text/css">

      /* Sticky footer styles
      -------------------------------------------------- */

      html,
      body {
        height: 100%;
        background: url(<?php echo $background; ?>) no-repeat fixed;
        background-size: 100% 100%;
        /* The html and body elements cannot have any padding or margin. */
      }
      /* Wrapper for page content to push down footer */
      #wrap {
        min-height: 100%;
        height: auto !important;
        height: 100%;
        /* Negative indent footer by it's height */
        margin: 0 auto -60px;
      }

      /* Set the fixed height of the footer here */
      #push,
      #footer {
        height: 60px;
      }
      #footer {
        background-color: #E6E6E6;      }
      /* Lastly, apply responsive CSS fixes as necessary */
      @media (max-width: 767px) {
        #footer {
          margin-left: -20px;
          margin-right: -20px;
          padding-left: 20px;
          padding-right: 20px;
        }
      }



      /* Custom page CSS
      -------------------------------------------------- */
      /* Not required for template or sticky footer method. */

      #wrap > .container {
        padding-top: 60px;
      }
      .container .credit {
        margin: 20px 0;
      }

      code {
        font-size: 80%;
      }

    </style>
    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="../assets/js/html5shiv.js"></script>
    <![endif]-->
  </head>

  <body>


    <!-- Part 1: Wrap all page content here -->
    <div id="wrap">

      <!-- Fixed navbar -->
      <div class="navbar navbar-fixed-top">
        <div class="navbar-inner">
          <div class="container">
            <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
            <!--<a class="brand" href="index.php">LapisCraft</a>-->
            <div class="nav-collapse collapse">
              <ul class="nav">
                
                <!-- NAVBAR PERSONNALISE -->
                <li <?php if($monUrl == ''.$url.'/' OR $monUrl == ''.$url.'/index.php') { echo 'class="active"'; } ?>><a style="font-family: minecraftiaregular;" href="index.php">Accueil</a></li>
                <li <?php if($monUrl == ''.$url.'/boutique.php') { echo 'class="active"'; } ?>><a style="font-family: minecraftiaregular;" href="boutique.php">Boutique</a></li>
                <li class="dropdown">
                  <a style="font-family: minecraftiaregular;" href="#" class="dropdown-toggle" data-toggle="dropdown">Serveur <b class="caret"></b></a>
                  <ul class="dropdown-menu">
                    <li><a style="font-family: minecraftiaregular;" href="banlist.php">BanList</a></li>
                    <li><a href="chat.php" style="font-family: minecraftiaregular;">Chat</a></li>
                    <li><a href="players.php" style="font-family: minecraftiaregular;">Joueurs en ligne</a></li>
                  </ul>
                <li <?php if($monUrl == ''.$url.'/support.php') { echo 'class="active"'; } ?>><a style="font-family: minecraftiaregular;" href="support.php">Support</a></li>
                <li <?php if($monUrl == ''.$url.'/voter.php') { echo 'class="active"'; } ?>><a style="font-family: minecraftiaregular;" href="voter.php">Vote</a></li>

                <?php 
                $req_onglet = $connexion->query("SELECT * FROM navbar ORDER BY ordre");
                $req_onglet->setFetchMode(PDO::FETCH_OBJ);
                while($onglets = $req_onglet->fetch()) { ?>
                <li <?php if($monUrl == $url.'/'.$onglets->url) { echo 'class="active"'; } ?> ><a style="font-family: minecraftiaregular;" href="<?php echo $onglets->url ?>"><?php echo $onglets->nom ?></a></li>
                <?php } ?>
                <!-- ### -->  
                
                <!-- RESTE TOUJOURS LA | A NE PAS SUPPRIMER | NON MODIFIABLE -->
                  <?php if(!connect()) { ?>
                  <form method="post" style="margin-left: 10px; margin-bottom: 0px; margin-top: 3px;" class="form-inline pull-right" action="connexion.php">
                  <input type="text" class="input-medium" style="width: 120px;" name="pseudo" placeholder="Pseudo">
                  <input type="password" class="input-small" style="width: 60px;" name="password" placeholder="Mot de Passe">
                  <button type="submit" style="margin-top: 1px;font-family: minecraftiaregular;" class="btn btn-primary">Connexion</button>
                  <a class="btn btn-small" aria-hidden="true" type="text" href="#inscription" role="button" data-toggle="modal" style="font-family: minecraftiaregular;">Inscription</a>
                  </form>
                  <?php } else { ?>
                      &nbsp;&nbsp;
                      <div class="btn-group">
                        <a style="font-family: minecraftiaregular;" class="btn btn-info dropdown-toggle" data-toggle="dropdown" href="#">
                        <img src="https://minotar.net/helm/<?php echo $pseudo; ?>/20">&nbsp;Mon Profil <span class="caret"></span></a>
                        </a>
                        <ul class="dropdown-menu">
                        <li><a style="font-family: minecraftiaregular;" href="profil.php">Profil</a><li>
                        <li><a style="font-family: minecraftiaregular;" href="mprofil.php">Modifier ses infos</a><li>
                        <?php if($rang == "Administrateur") { ?>
                        <li class="divider"></li>
                        <li><a style="font-family: minecraftiaregular;" href="admin/admin.php">Pannel d'admin</a></li>
                        <?php } ?>
                        </ul>
                        </div>
                  <a style="font-family: minecraftiaregular;" class="btn btn-small" aria-hidden="true" type="text" href="logout.php">Déconnexion</a>
                  <?php } ?>
                  <!-- #### -->
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
<!-- ============= Inscription =========== -->
<div id="inscription" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="inscriptionLabel" aria-hidden="true">
    <div class="modal-header">
      <button class="close" data-dismiss="modal" aria-hidden="true">×</button>
      <h3 style="font-family: minecraftiaregular;">Inscription</h3> 
    </div>
    <div class="modal-body">
    <div id="message_Inscription"></div>
      <form class="form-horizontal" method="post" action="inscription.php">
        <div class="control-group">
          <label class="control-label" for="usernameregister" style="font-family: minecraftiaregular;">Nom d'utilisateur <br> (pseudo en jeu)</label>
          <div class="controls">
            <input type="text" name="pseudo" value="">
          </div>
        </div>
        <div class="control-group">
          <label class="control-label" for="passwordregister" style="font-family: minecraftiaregular;">Mot de passe</label>
          <div class="controls">
            <input type="password" name="password" value=""/>
          </div>
        </div>
        <div class="control-group">
          <label class="control-label" for="passwordregister2" style="font-family: minecraftiaregular;">Confirmation</label>
          <div class="controls">
            <input type="password"  name="password2" value="" placeholder="Entrez le même mot de passe" />
          </div>
        </div>
        <div class="control-group">
          <label class="control-label" for="emailregister" style="font-family: minecraftiaregular;">Adresse email</label>
          <div class="controls">
            <input type="text"  name="email" value="">
          </div>
        </div> 
        <div class="control-group">
    <div class="controls">
    <img src="captcha.php" alt="Captcha" id="captcha">
    <img src="images/reloadc.png" alt="Recharger l'image" title="Recharger l'image" style="cursor:pointer;position:relative;top:-7px;" onclick="document.images.captcha.src='captcha.php?id='+Math.round(Math.random(0)*1000)" /><br><br>
    <input type="text" style="height: 30px;" name="captcha" placeholder="Recopiez le code ci-dessus" required><br>
  </div>
  </div>       
    </div>
    <div class="modal-footer">
      <button class="btn" data-dismiss="modal" aria-hidden="true" style="font-family: minecraftiaregular;">Annuler</button>
      <button type="submit" class="btn btn-success" style="font-family: minecraftiaregular;">S'inscrire</button>
    </form>
    </div>
  </div>