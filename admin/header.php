<?php
if(!file_exists('../include/installation.txt')) { 
  header('Location: ../install/index.php');
  exit();
}
require_once('../include/JSONAPI.php');
include_once('../include/variables.php'); 

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
    <title><?php echo $nom ?> | <?php echo $titre; ?></title>
    <meta http-equiv="Content-Type" content="text/html;charset=ut8" />
    <meta name="author" content="Eywek ,mineconstructe, Valentin Touffet">
    <link rel="icon" href="images/favicon.gif">
    <link href="../bootstrap/css/bootstrap.css" rel="stylesheet" type="text/css">
    <link href="../bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" type="text/css">
    <!-- CSS -->
    <style type="text/css">

      /* Sticky footer styles
      -------------------------------------------------- */

      html,
      body {
        height: 100%;
        background: url(../images/bg.jpg) repeat scroll 0% 0% transparent;
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
  <style type="text/css">
.nav li a:hover {
color: #555555;
  text-decoration: none;
  background-color: #e5e5e5;
  -webkit-box-shadow: inset 0 3px 8px rgba(0, 0, 0, 0.125);
     -moz-box-shadow: inset 0 3px 8px rgba(0, 0, 0, 0.125);
          box-shadow: inset 0 3px 8px rgba(0, 0, 0, 0.125);
  }
  </style>
<div class="navbar-wrapper">
    <div class="container">
      <div class="navbar">
        <div class="navbar-inner">
          <button class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse" ><i class="collapse-icon icon-align-justify"></i></button>
          <a class="brand" href="admin.php">Panel Admin</a>
          <div class="nav-collapse collapse" style="margin-left:130px;">
            <ul class="nav">
            
              <li><a href="../index.php" >Site</a></li>
              <li <?php if($titre == "Panel Admin") { echo 'class="active"'; } ?>><a href="admin.php">Tableau de bord</a></li>
              <li <?php if($titre == "Panel Admin - Membres") { echo 'class="active"'; } ?>><a href="membres.php" >Membres</a></li>
              <li <?php if($titre == "Panel Admin - News") { echo 'class="active"'; } ?>><a href="news.php" >News</a></li>
              <li <?php if($titre == "Panel Admin - Boutique") { echo 'class="active"'; } ?>><a href="boutique.php" >Boutique</a></li>
              <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" >Autre &raquo;</a>
                <ul class="dropdown-menu">
                  <li><a href="pages.php">Configuration des pages</a></li>
                  <li><a href="config_jso.php">Liaison site-serveur</a></li>
                  <li><a href="reglages.php">Réglages</a></li>
                  <li><a href="slider.php">Slider</a></li>
                  <li><a href="serveur.php">Serveur</a></li>
                  <li><a href="vote.php">Vote</a></li>
                </ul>
              </li>
            <li <?php if($titre == "Panel Admin - Maintenance") { echo 'class="active"'; } ?>><a href="maintenance.php" >Maintenance</a></li>
            </ul>
            <ul class="nav pull-right">  
                  <li><p class="lead" style="font-size: 15px;margin-top: 5px;margin-bottom: -10px;">Connectez en tant que <strong><?php echo $pseudo; ?></strong></p></li>
              </li>
            </ul>
          </div> <!-- nav-collapse -->
        </div> <!-- navbar-inner -->
      </div> <!-- navbar -->
 </div> <!-- container -->
  </div> <!-- navbar-wrapper -->
    <!-- Navbar ================================================== -->
<br><br>
<div class="container">