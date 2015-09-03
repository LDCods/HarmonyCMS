<?php
include('../include/bdd.php');
include('../include/init.php');
if($etape_1 == "ok") {
$req_selectEtape = $connexion->query('SELECT * FROM installation');
$selectEtape = $req_selectEtape->fetch();
$etape = $selectEtape['etape_actuelle'];
if($etape != 'final') {
if(!empty($etape)) {
  header("Location: $etape.php");
  exit();
} 
}
}
// DROP INSTALLATION
$connexion->exec("DROP TABLE installation");
$fp = fopen("../include/installation.txt","w+");
fclose($fp)
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>LapisCraft | Installation</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Valentin TOUFFET, Eywek, mineconstructe">

    <!-- Le styles -->
    <link href="../bootstrap/css/bootstrap.css" rel="stylesheet">
    <style type="text/css">
      body {
        padding-top: 40px;
        padding-bottom: 40px;
        background-color: #f5f5f5;
      }

      .form-signin {
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
    <link href="../bootstrap/css/bootstrap-responsive.css" rel="stylesheet">

    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="../assets/js/html5shiv.js"></script>
    <![endif]-->
  </head>

  <body>

    <div class="container">

      <form class="form-signin" style="width: 900px;">
        <center><h2 class="form-signin-heading">Fin de l'installation</h2></center>
       <center><p class="lead">Bravo ! L'installation c'est déroulé normalement vous pouvez désormais vous connecter.</p><center>
        <a href="../connexion.php" class="btn btn-block btn-success">Continuer</a>
      </form>

    </div> <!-- /container -->

  </body>
</html>