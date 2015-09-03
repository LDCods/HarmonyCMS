<?php
include('include/init.php');
include('include/jso.php');
include('include/JSONAPI.php');
include('include/variables.php'); 
// ========== SI CONNECTEZ SUR LE SITE ===========
if(connect()) { 
  // ========== SI LE SERVEUR N EST PAS ETEINT ============
  if($ServerVersion["success"] == '') {
    setFlash('Le serveur est éteint donc la BanList ne peut pas être affiché.', 'danger');
    die('<META HTTP-equiv="refresh" content=0;URL=index.php>'); 
    exit();
  } else {
    // ========== SI CONNECTEZ SUR LE SERVEUR ===========
    if($isOnline == "true") {    

      $req_Achat_Info2 = $connexion->query('SELECT * FROM boutique_article WHERE id=\'' . $_GET['article'] . '\'');
      $Achat_Info2 = $req_Achat_Info2->fetch();

      if(!empty($_GET['article'])) {
          if($rubis >= $Achat_Info2['prix']) {
            $newsolde = $rubis-$Achat_Info2['prix'];
            $updateSolde = $connexion->prepare('UPDATE membres SET rubis=:rubis WHERE pseudo=:pseudo');
            $updateSolde ->execute(array(
              'rubis' => $newsolde, 
              'pseudo' => $pseudo,
            ));
            // COMMANDE JSONAPI
            // POUR PLUSIEURS COMMANDES UN FOREACH ICI *
            $sql = $connexion->query('SELECT * FROM boutique_article_commande WHERE id_article=\'' . $_GET['article'] . '\'');
            $sql->setFetchMode(PDO::FETCH_OBJ);
            while($req = $sql->fetch()) {
            $commande = str_replace('{PLAYER}', $pseudo, $req->commande);
            $Commande = $api->call("runConsoleCommand", array("".$commande.""));
            }
            setFlash('Vous avez acheté l\'article "'.$Achat_Info2['nom'].'" !', 'success');
            die('<META HTTP-equiv="refresh" content=0;URL=boutique.php>');
            exit();
          } else {
            setFlash('Votre solde est insuffisant pour procédé a cet achat !', 'danger');
            die('<META HTTP-equiv="refresh" content=0;URL=boutique.php>');
            exit();
          }
        } 
  } else {
      setFlash('Vous devez être connecté sur le serveur pour procédé a un achat !', 'danger');
      die('<META HTTP-equiv="refresh" content=0;URL=boutique.php>');
      exit();
  } 
}
} else {
  setFlash('Veuillez vous connectez pour avoir accès a la page demandée !', 'danger');
  die('<META HTTP-equiv="refresh" content=0;URL=connexion.php>');
  exit();
} 
?>