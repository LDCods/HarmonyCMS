<?php
$titre = "Maintenance";
include('include/init.php');
?>  
<?php 
if(!file_exists('include/installation.txt')) { 
  header('Location: install/index.php');
  exit();
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
<!-- Le styles -->
    <link href="../assets/css/bootstrap.css" rel="stylesheet">
    <style type="text/css">
      body {
        padding-top: 40px;
        padding-bottom: 40px;
        background-color: #f5f5f5;
      }

      .form-signin {
        max-width: 700px;
        padding: 19px 29px 29px;
        margin: 0 auto 20px;
        background-color: #fff;
        border: 1px solid #e5e5e5;
        -webkit-border-radius: 5px;
           -moz-border-radius: 5px;
                border-radius: 5px;
        -webkit-box-shadow: 0 1px 2px rgba(0,0,0,.05);
           -moz-box-shadow: 0 1px 2px rgba(0,0,0,.05);
                box-shadow: 0 1px 2px rgba(0,0,0,.05);
      }
      .form-signin .form-signin-heading,
      .form-signin .checkbox {
        margin-bottom: 10px;
      }
      .form-signin input[type="text"],
      .form-signin input[type="password"] {
        font-size: 16px;
        height: auto;
        margin-bottom: 15px;
        padding: 7px 9px;
      }

    </style>
    <div id="wrap">
    <div class="container">

      <div class="form-signin">
        <center><h1 class="form-signin-heading">Maintenance</h2></center>
        <center><p class="lead"><?php echo $motif; ?></p></center>
      </div>

    </div> <!-- /container -->
    </div>
<?php include('include/footer.php'); ?>