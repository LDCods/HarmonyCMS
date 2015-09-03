<?php 
$titre = 'Panel Admin - Profils';
include('../include/init.php');
if(connect()) {
if($rang == "Administrateur") {

$PseudoM = $_GET['pseudo'];
$req_selectMembreA = $connexion->prepare('SELECT * FROM membres WHERE pseudo=:pseudo');
      $req_selectMembreA->execute(array(
        'pseudo' => $PseudoM
      ));
      $selectMembreA = $req_selectMembreA->fetch();

      $email_M = $selectMembreA['email'];
      $rangnumero_M = $selectMembreA['rang'];
      $rubis_M = $selectMembreA['rubis'];
      $nombre_voteM = $selectMembreA['nbr_vote'];
      $id_M = $selectMembreA['id'];

if($nombre_voteM == null) {
  $nombre_voteM = 0;
}
if($rubis_M == null) {
  $rubis_M = 0;
}


if ($rangnumero_M == "1") {
    $rang_M = Membre;
}
if ($rangnumero_M == "2") {
    $rang_M = Modérateur;
}
if ($rangnumero_M == "3") {
    $rang_M = Administrateur;
}

if ($email_M == null) {
  $email_M = 'Non renseigner';
}

     
        if($_POST) {
          if (!empty($_POST['email'])) {
                if(!empty($_POST['password'])) {
                $mdp = sha1($_POST['password']); 
                $mdp=preg_replace('/\s/', '', $mdp);
                $updateMembre_Admin = $connexion->prepare('UPDATE membres SET passe=:passe WHERE pseudo=:pseudo');
                $updateMembre_Admin ->execute(array(
                  'passe' => $mdp,
                  'pseudo' => $PseudoM,
                ));
              }

          if(filter_var($email, FILTER_VALIDATE_EMAIL)) { 
            $updateMembre_Admin = $connexion->prepare('UPDATE membres SET email=:email, rubis=:rubis, nbr_vote=:nbr_vote, rang=:rang WHERE pseudo=:pseudo');
            $updateMembre_Admin ->execute(array(
              'email' => htmlspecialchars($_POST['email'], ENT_QUOTES),
              'rubis' => $_POST['Rubis'],
              'nbr_vote' => $_POST['NbrVote'],
              'rang' => $_POST['rang'],
              'pseudo' => $PseudoM
            ));
          } else {
            header('location: membres.php?update=email:false');
            exit();
          }
          header('Location: membres.php?update=ok');
          exit();
          }
      

          if(!empty($_POST['delete'])) {
          if($PseudoM != $pseudo) {
  
            $id_delete = $id_M; //Mes l'id d'une ligne dans ta basse de donnée
            $Delete_Membre = $connexion->prepare('DELETE FROM membres WHERE id = :id');
            $Delete_Membre->bindValue(':id', $id_delete, PDO::PARAM_INT);
            $Delete_Membre->execute();
            $Delete_Membre->closeCursor();

            header('Location: membres.php?delete=ok');
            exit();
          } else {
            header('Location: membres.php?delete=no');
            exit();
          }
        }
        }




include('header.php');
?>
<!-- ====== CONTENUE DE LA PAGE ======= --> 
<div class="row-fluid">
      <div class="news-plugin" style="width:100%;">
      <h1 style="text-align: center;">Profils des membres</h1><br>
       <div class="boutique-corps" style="width: auto;margin-left: 20px;margin-right: 20px;">
       <center><h3 style="color: #084D97;text-decoration: underline;">Profil de <?php echo $PseudoM; ?></h3></center>

    <form class="form-horizontal" method="post">
    <div class="control-group">
    <label class="control-label">Pseudo</label>
    <span class="input-large uneditable-input" style="margin-left: 20px;"><?php echo $PseudoM; ?></span>
    </div>
    <div class="control-group">
    <label class="control-label" for="inputEmail">Email</label>
    <div class="controls">
    <input class="input-large" type="text" name="email" value="<?php echo $email_M; ?>">
    </div>
    </div>
    <div class="control-group">
    <label class="control-label" for="inputPassword">Mot de Passe</label>
    <div class="controls">
    <input type="password" name="password">
    </div>
    </div>
    <div class="control-group">
    <label class="control-label" for="inputRang">Rang</label>
    <div class="controls">
    <!--<span class="input-large uneditable-input"><?php // echo $rang_M; ?></span>-->
    <SELECT name="rang">
    <OPTION value="3" <?php if($rang_M == "Administrateur") { echo "selected"; } ?>>Administrateur</OPTION>
    <OPTION value="2" <?php if($rang_M == "Modérateur") { echo "selected"; } ?>>Modérateur</OPTION>
    <OPTION value="1" <?php if($rang_M == "Membre") { echo "selected"; } ?>>Membre</OPTION>
    </SELECT>
    </div>
    </div>
    <div class="control-group">
    <label class="control-label" for="inputRubis">Rubis</label>
    <div class="controls">
    <input type="text" name="Rubis" value="<?php echo $rubis_M; ?>">
    </div>
    </div>
    <div class="control-group">
    <label class="control-label" for="inputNbrVote">Nombre de vote</label>
    <div class="controls">
    <input type="text" name="NbrVote" value="<?php echo $nombre_voteM; ?>">
    </div>
    </div>
    <div class="control-group">
    <div class="controls">
    <button type="submit" class="btn btn-success">Modifier les informations</button><br>
    </div>
    </div>
    </form>
    <a class="btn btn-danger" href="#delete" role="button" data-toggle="modal" style="margin-left: 185px;">Supprimer ce membre</a>
       
       </div>
      </div>
    </div></div></div></div>

<!-- ============= DELETE =========== -->
<div id="delete" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="deleteLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel">Supprimer un membre</h3>
  </div>
  <div class="modal-body">
    <p>Voulez-vous vraiment supprimer le membre <strong><?php echo $PseudoM; ?></strong> ?</p>
  </div>
  <div class="modal-footer">
      <button class="btn" data-dismiss="modal" aria-hidden="true" type="text">Annuler</button>
      <form method="post">
      <input name="delete" type="hidden" value="delete">
      <button name="delete" type="submit" class="btn btn-danger" value="delete" href="">Supprimer</button>
      </form>
  </div>
</div>
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