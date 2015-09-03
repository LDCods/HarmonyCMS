<div class="boutique-corps" style="font-size: 15px;width: auto;height: 495px;overflow: auto;">
	<link href="../bootstrap/css/bootstrap.css" rel="stylesheet" type="text/css">
    <link href="../bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" type="text/css">
<?php
include_once('include/jso.php');
include_once('include/JSONAPI.php');
include_once('include/variables.php');
// LE CHAT

$msg = 25; // nombre de msg du chat
$chat = $api->call("getLatestChatsWithLimit", array($msg)); // méthode de récupération standard
$chat = $chat["success"];

if(empty($chat)) {
  $erreur = '<center><h4 class="lead">Aucun message n\'a été envoyé sur le serveur.</h4<center><br>';
}
 
$chat = array_reverse($chat); // on inverse l’ordre: les dernier message sont désormais en premier
 
foreach ($chat as $value) { // pour chaque message:
 
$chat = $value["message"]; // on récupère le message
echo '<div>(';  // on affiche "["
echo date('H', $value["time"]); // l'heure du message
echo 'h'; // on affiche "h" après l'heure
echo date('i', $value["time"]); // les minutes du message
echo ') '; // ]
 
// donc, si le message a été envoyé a 15:03, on affiche [15h03] avant le message

echo '<strong>'; // en gras
echo '<img src="https://minotar.net/helm/'.$value["player"].'/20">&nbsp;';
echo $value["player"]; // nom du joueur
echo ':</strong> '; // en normal
echo $chat; // le message
echo '<br/></div>'; // retour a la ligne
} ?>
</div>
<META HTTP-equiv="refresh" content=20;>