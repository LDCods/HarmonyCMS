<?php 
//require_once('include/JSONAPI.php');
$monUrl = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
$salt = "";
$api = new JSONAPI($ip, $port, $utilisateur, $motdepasse, $salt);
$ServerVersion = $api->call("getServerVersion");
if($ServerVersion["success"] != '') {
$PlayerCount = $api->call("getPlayerCount");
$PlayerLimit = $api->call("getPlayerLimit");
$PlayerNames = $api->call("getPlayerNames");
$ServerPort = $api->call("getServerPort");
$PlayersBan = $api->call("getBannedPlayers");
$Plugins = $api->call("getPlugins");
$Recente_connexion = $api->call("getLatestConnectionsWithLimit", array('10'));
$Argent_IG = $api->call("econ.getBalance", array(''.$pseudo.''));
$Mondes = $api->call("getWorldNames");
$getPseudoInfoServeur = $api->call('getPlayer', array($pseudo));
$getPseudoInfoServeur = $getPseudoInfoServeur['success'];
$isOnlineTest = $getPseudoInfoServeur['ip'];
if($isOnlineTest != "offline") { 
     $isOnline = "true";
} else { 
     $isOnline = "false"; 
}
}
?>