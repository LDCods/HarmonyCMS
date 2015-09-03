<?php
$titre = "Accueil";
include('include/init.php');
include('include/header.php');
?>   
      <!-- Begin page content -->
        <div class="container">
          <div class="page-header">
           <!-- =========== ALERTE ========= -->
           <?php flash(); ?>
          </div>
          <!-- ===========SLIDER =========== -->
          <style type="text/css">
/* ============ CUSTOMIZE SLIDER ========= */
    /* Carousel base class */

    .carousel .container {
      position: relative;
      z-index: 9;
    height:335px;
    width:975px;
    }

    .carousel-control {
      height: 80px;
      margin-top: 0;
      font-size: 120px;
      text-shadow: 0 1px 1px rgba(0,0,0,.4);
      background-color: transparent;
      border: 0;
      z-index: 10;
    }

    .carousel .item {
    /*background: url(images/slider/background.png);*/
    width: 975; 
    height: 335;
    }
    .carousel img {
      position: absolute;
    top: -3px;
    left: 94px;
    z-index:99;
    }

     .carousel-caption {
      padding: 10px 20px;
      margin-top: 200px;
    }
    .carousel-caption h1,
    .carousel-caption .lead {
      margin: 0;
      line-height: 1.25;
      color: #fff;
      text-shadow: 0 1px 1px rgba(0,0,0,.4);
    }
    .carousel-caption .btn {
      margin-top: 10px;
    }
          </style>
<!-- HEADER DE LA PAGE --> 
<?php 
// SLIDER REQUETE
$sql = $connexion->query('SELECT * FROM slider ORDER BY id');
$sql->setFetchMode(PDO::FETCH_OBJ);
?>
<div class="container">
  <div class="page-header">
  </div>
  <div class="span12" style="margin-top: -50px;">
    <div id="myCarousel" class="carousel slide">
      <div class="carousel-inner pull-left" style="margin-left: -60px;margin-bottom: 20px;">
      <?php $numero = 0; while($req = $sql->fetch()) { $numero++; ?>
        
        <div class="item <?php if($numero == 1) { echo 'active'; } ?>">
          <img src="<?php echo $req->image; ?>" style="z-index:1;-webkit-box-shadow: 2px 3px 9px rgba(25,52,65,.79); -moz-box-shadow: 2px 3px 9px rgba(25,52,65,.79); box-shadow: 2px 3px 9px rgba(25,52,65,.79); width: 980px; height: 340px;" alt="" class="img-rounded"> 
          <div class="container">
             <?php if(isset($req->titre) AND !empty($req->titre) AND isset($req->contenu) AND !empty($req->contenu)) { ?> 
              <div class="carousel-caption">
                <h4 style="font-family: minecraftiaregular;"><?php echo $req->titre; ?></h4>
                <p style="font-family: minecraftiaregular;"><?php echo $req->contenu; ?></p>
              </div>
            <?php } ?>
          </div>
        </div>
      
<?php } ?>
        
        
      </div>
      <a class="left carousel-control pull-left" href="#myCarousel" data-slide="prev" style="top: 150px;margin-left: -30px;">&lsaquo;</a>
      <a class="right carousel-control pull-right" href="#myCarousel" data-slide="next" style="top: 150px;margin-right: 95px;">&rsaquo;</a>
    </div>
           </div>
        <!-- ======== CONTENUE DE LA PAGE ========== -->
  </div>
  <div class="row-fluid">
    <div class="span8">
      <div class="news-plugin" style="width: 750px;">
      <h1 style="text-align: center;font-family: minecraftiaregular;">News</h1><br>

      <?php // LIENS PAGE
        $req_nbrNews2 = $connexion->query('SELECT * FROM news');
        $nbrNews2 = $req_nbrNews2->rowCount();
        $NewsParPage = 3;
        $TotalNews = $nbrNews2;
        $nombreDePages  = ceil($TotalNews / $NewsParPage);
        if (isset($_GET['page']))
        {
          $page = $_GET['page']; // On récupère le numéro de la page indiqué dans l'adresse (livreor.php?page=4)
        }
        else // La variable n'existe pas, c'est la première fois qu'on charge la page
        {
          $page = 1; // On se met sur la page 1 (par défaut)
        }
      ?>
      <?php // AFFICHER NEWS 
        $premiereNews_Afficher = ($page - 1) * $NewsParPage;
        $sql = $connexion->query('SELECT * FROM news ORDER BY id DESC LIMIT ' . $premiereNews_Afficher . ', ' . $NewsParPage . '');
        $sql->setFetchMode(PDO::FETCH_OBJ);
        while($req = $sql->fetch()) { 
        // NBR DE COMMENTAIRES
        $sql3 = $connexion->query('SELECT * FROM comment WHERE news=\'' . $req->id . '\'');
        $nbr_comment = $sql3->rowCount();
      ?>
      <?php 
      if($nbrNews2 < 1) {
        echo 'Aucune news n\'a été postée';
      }
      ?>
                <div class="thumbnail" style="width: 720px;background-color: white;auto;margin: 10px;">

                  <div class="caption">
                    <?php if($req->image == NULL) { } else { ?>
                  <img src="<?php echo $req->image; ?>" class="img-rounded" style="width: 170px;float: left;margin-right: 5px;margin-top:18px;" alt="">
                  <?php } ?>
                    <h3><?php echo stripslashes($req->titre); ?></h3>
                    <p><?php echo stripslashes($req->description); ?></p>
                    <p><a href="comment.php?news=<?php echo $req->id; ?>" class="btn btn-info pull-left"><?php echo $nbr_comment; ?> commentaire<?php if($nbr_comment > 1) { echo 's'; } ?></a></p>
                    <p><a href="news.php?id=<?php echo $req->id; ?>" class="btn btn-success pull-right">Lire la suite &raquo;</a></p><br><br>
                  </div>
                </div>
      <?php
} // Fin de la boucle qui liste les news.
?>
</div>
<?php

echo '<center><div class="btn-toolbar" style="margin-top: 15px;">
        <div class="btn-group">';
        for ($i = 1 ; $i <= $nombreDePages ; $i++) {
            echo '<a class="btn ';
            if($page == $i) { echo 'active'; }
            echo '" href="?page=' . $i . '">' . $i . '</a> ';
        }
        echo '</div></div></center>';
?>

          
    </div>
<?php include('include/menudroite.php'); ?>
</div>
</div>
</div>
</div>
</div>
</div>

<?php 
include('include/footer.php'); 
?>