<div id="menudroite">
      <div class="news-plugin pull-right" style="width: 300px;margin-right: 70px;displays: inline-block;">
      <h3 style="text-align: center;color: #175084;font-family: minecraftiaregular;">Etat du serveur</h3>
      <center><h4 style="color:grey;"><?php echo $nom_serveur ?></h4></center>
      <pre class="text-warning" style="width: 270px;margin: 5px;"><center><?php echo $ip_afficher; ?></center></pre>

      <?php if ($ServerVersion["success"] == '') { ?>
      <button class="btn btn-danger btn-large btn-block" style="margin: 5px; width: 290px;"><center>Hors Ligne</center></button>
	  <?php } else { ?> 
      <button class="btn btn-success btn-large btn-block" style="margin: 5px; width: 290px;"><center>En Ligne</center><center><?php  print  ($PlayerCount['success']); ?>/<?php  print  ($PlayerLimit['success']);?></center></button>
      <?php } ?>
      </div>


      <div class="news-plugin pull-right" style="width: 300px; margin-left: 20px; margin-right: 70px;margin-top: 20px;displays: inline-block;">
           <h3 style="text-align: center;color: #175084;font-family: minecraftiaregular;">Vote et gagne</h3>
            <center><h5 style="margin: 5px;"><?php echo $des_vote; ?></h5></center><br>
               <form action="voter.php" method="post">
            <center><button class="btn btn-success" type="submit" style="margin-top: 5px;"/>Voter</button></center>
            </form>
            </div>
      <?php if(!empty($lien_youtube) OR !empty($lien_facebook) OR !empty($lien_twitter)) { ?>
      <div class="news-plugin" style="width: 300px;margin-right: 70px;displays: inline-block;margin-top: 25px;float: right;clear: both;">
      <h3 style="text-align: center;color: #175084;font-family: minecraftiaregular;">Social</h3><br>
      <center>
            <?php if(!empty($lien_youtube)) { ?>
            <a href="<?php echo $lien_youtube; ?>"><img src="images/youtube.png"></a>
            <?php } if(!empty($lien_facebook)) { ?>
            <a href="<?php echo $lien_facebook; ?>"><img src="images/facebook.png"></a>
            <?php } if(!empty($lien_twitter)) { ?>
            <a href="<?php echo $lien_twitter; ?>"><img src="images/twitter.png"></a>
            <?php } ?>
      </center><br><br>
      </div>
      <?php } ?>
      
      <?php 
      $req_widget = $connexion->query("SELECT * FROM widgets ORDER BY id DESC");
      $req_widget->setFetchMode(PDO::FETCH_OBJ);
      while($widget = $req_widget->fetch()) { ?>
      <div class="news-plugin" style="width: 300px;margin-right: 70px;displays: inline-block;margin-top: 25px;float: right;clear: both;">
      <h3 style="text-align: center;color: #175084;font-family: minecraftiaregular;"><?php echo $widget->nom; ?></h3><br>
            <?php echo $widget->contenu; ?>
      </div>
      <?php } ?>
</div>