<?php
$titre = "BanList";
include('include/init.php');
include('include/header.php');
?>   
      <!-- Begin page content -->
        <div class="container">
          <div class="page-header">
          </div>
<!-- HEADER DE LA PAGE --> 
<div class="container">
  <div class="page-header">
    <div class="alert alert-warning"><center>La BanList n'est pas encore terminer.</center></div>
  </div>
        <!-- ======== CONTENUE DE LA PAGE ========== -->
  </div>
  <div class="row-fluid">
    <div class="span8">
      <div class="news-plugin">
      <h1 style="text-align: center;font-family: minecraftiaregular;">BanList</h1><br>
      <div class="boutique-corps">
                    <table class="table table-bordered">
              <thead>
                <tr>
                  <th>Pseudo</th>
                  <th>Date</th>
                  <th>Raison</th>
                  <th>Expiration</th>
                </tr>
              </thead>
        <?php 
            if($ServerVersion["success"] == '') {
              setFlash('Le serveur est éteint donc la BanList ne peut pas être affiché.', 'danger');
              die('<META HTTP-equiv="refresh" content=0;URL=index.php>'); 
              exit();
            } else {
              $banList = $api->call('getBannedPlayers');
              $banList = $banList['success'];
              $nbr_banList = count($banList);
              if($nbr_banList > 0) {
                foreach ($banList as $value) {
                    
                    $motif = 

                    /*
                    $motif = $api->call("getFileContents", array("plugins/Essentials/userdata/$value.yml"));
                    $motif = $motif['success'];
                    if($motif == NULL OR empty($motif)) {
                      $motif = "Aucune raison enregistré";
                    }
                    /*$motif = str_replace(chr(10).chr(10), null, $motif["success"]);
                    if($motif != NULL OR !empty($motif)) {
                        $motif1 = $motif["ban"]["reason"];
                        if($motif1 == NULL) {
                            $motif1 = "Aucune raison enregistré";
                        }
                    } else {
                        $motif1 = "Aucune raison enregistré";
                    }*/
                    // ∞  <-- ICONE POUR L EXPIRATION
                    $req_ban = $api->call("getFileContents", array("banned-players.txt"));
                    $req_ban = $req_ban['success'];

                      $heure = $api->call("getFileContents", array("banned-players.txt"));
                      $heure = $heure['success'];
                      $test = "$value|";
                      $heure = strstr($heure, $test);
                      $heure = str_replace("$value|", "", $heure);
                      $heure2 = substr($heure, 0, 25);
                      $heure = substr($heure, 0, 20);
                      $heure = strtotime($heure);
                      $heure = date("d/m/Y à H:i", $heure);

                      $motif = $api->call("getFileContents", array("banned-players.txt"));
                      $motif = $motif['success'];
                      //$motif = eregi("$value|$heure2|(.*)|Forever", "$req_ban");
                      $motif = strrchr($req_ban, "$value|$heure2|");
                      //$motif = strstr($req_ban, "$value|$heure2|");
                      # $UneChaine = "abcABCabcABCabc"; $LeDernierBout = strstr($UneChaine, "BC"); print $LeDernierBout;

                      echo '
              <tbody>
                <tr>
                  <td><center>'.$value.'</center></td>
                  <td><center>'.$heure.'</center></td>
                  <td><center>Aucun Motif enregistré</center></td>
                  <td><center>∞</center></td>
                      ';
                }
              } else { 
                echo '<center><h5>Aucun joueurs n\'a été bannis.</h5></center>';
              }  
            }
        ?>
      </tr>
      </tbody>
    </table>
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