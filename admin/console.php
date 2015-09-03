<div class="boutique-corps" style="background-color: black;max-width: 1050;height: 500px;overflow: auto;">
<link href="../../bootstrap/css/bootstrap.css" rel="stylesheet" type="text/css">
<link href="../../bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" type="text/css">
<?php
include_once('../include/jso.php');
include_once('../include/JSONAPI.php');
include_once('../include/variables.php');
        // LA CONSOLE
 
 
function translateMCColors($text) { // chaque code couleur de la console est remplacé par la bonne couleur en html
    $dictionary = array(
        '[30;22m' => '</span><span style="color: #000000;">', // §0 - Black
        '[34;22m' => '</span><span style="color: #0000AA;">', // §1 - Dark_Blue
        '[32;22m' => '</span><span style="color: #00AA00;">', // §2 - Dark_Green
        '[36;22m' => '</span><span style="color: #00AAAA;">', // §3 - Dark_Aqua
        '[31;22m' => '</span><span style="color: #AA0000;">', // §4 - Dark_Red
        '[35;22m' => '</span><span style="color: #AA00AA;">', // §5 - Purple
        '[33;22m' => '</span><span style="color: #FFAA00;">', // §6 - Gold
        '[37;22m' => '</span><span style="color: #AAAAAA;">', // §7 - Gray
        '[30;1m' => '</span><span style="color: #555555;">', // §8 - Dakr_Gray
        '[34;1m' => '</span><span style="color: #5555FF;">', // §9 - Blue
        '[32;1m' => '</span><span style="color: #55FF55;">', // §a - Green
        '[36;1m' => '</span><span style="color: #55FFFF;">', // §b - Aqua
        '[31;1m' => '</span><span style="color: #FF5555;">', // §c - Red
        '[35;1m' => '</span><span style="color: #FF55FF;">', // §d - Light_Purple
        '[33;1m' => '</span><span style="color: #FFFF55;">', // §e - Yellow
        '[37;1m' => '</span><span style="color: #FFFFFF;">', // §f - White
       
        '[0;30;22m' => '</span><span style="color: #000000;">', // §0 - Black
        '[0;34;22m' => '</span><span style="color: #0000AA;">', // §1 - Dark_Blue
        '[0;32;22m' => '</span><span style="color: #00AA00;">', // §2 - Dark_Green
        '[0;36;22m' => '</span><span style="color: #00AAAA;">', // §3 - Dark_Aqua
        '[0;31;22m' => '</span><span style="color: #AA0000;">', // §4 - Dark_Red
        '[0;35;22m' => '</span><span style="color: #AA00AA;">', // §5 - Purple
        '[0;33;22m' => '</span><span style="color: #FFAA00;">', // §6 - Gold
        '[0;37;22m' => '</span><span style="color: #AAAAAA;">', // §7 - Gray
        '[0;30;1m' => '</span><span style="color: #555555;">', // §8 - Dakr_Gray
        '[0;34;1m' => '</span><span style="color: #5555FF;">', // §9 - Blue
        '[0;32;1m' => '</span><span style="color: #55FF55;">', // §a - Green
        '[0;36;1m' => '</span><span style="color: #55FFFF;">', // §b - Aqua
        '[0;31;1m' => '</span><span style="color: #FF5555;">', // §c - Red
        '[0;35;1m' => '</span><span style="color: #FF55FF;">', // §d - Light_Purple
        '[0;33;1m' => '</span><span style="color: #FFFF55;">', // §e - Yellow
        '[0;37;1m' => '</span><span style="color: #FFFFFF;">', // §f - White
       
        '[5m' => '', // Obfuscated
        '[21m' => '<b>', // Bold
        '[9m' => '<s>', // Strikethrough
        '[4m' => '<u>', // Underline
        '[3m' => '<i>', // Italic
       
        '[0;39m' => '</b></s></u></i></span>', // Reset
        '[0m' => '</b></s></u></i></span>', // Reset
        '[m' => '</b></s></u></i></span>', // End
    );
 
    $text = str_replace(array_keys($dictionary), $dictionary, $text);
   
    return '<span style="color: #BDBDBD;">'.$text;
}
 
 
 
 
$msg = 130; // nombre de message de la console
$console = $api->call("getLatestConsoleLogsWithLimit", array(''.$msg.''));
   
$console = $console["success"];
 
$console = array_reverse($console); // on inverse
 
$date = date("Y-m-d"); // on récupère la date du jour
 
foreach ($console as $value) {
 
$console = $value["line"]; // on récupère le message de la console
 
$console = str_replace($date, '', $console); // dans chaque ligne de la console, il nous donne la date. On la remplace alors par '', en gros on la supprime.
 
$msg_prefix = array("[INFO]", "[WARNING]", "[SEVERE]"); // on remplace [INFO], [Warning] ...
$color_prefix = array('<span style="color: #2E64FE;">[INFO]</span>', '<span style="color: #FF8000;">[WARNING]</span>', '<span style="color: #FF0040;">[SEVERE]</span>'); // par les meme message mais en couleur
$console = str_replace($msg_prefix, $color_prefix, $console);
 
if($doublon == $console) // voir apres
{}
else
{
echo '<div>';
echo translateMCColors($console); // on affiche le message de la console avec la fonction "translateMCCOlors" pour la couleur
echo '<br/></div>';
}
 
$doublon = $console; // on dit que $doublon = $console, ainsi, au prochain foreach si le message est le même que le précedent on l'affiche pas, pour ne pas avoir 2x le meme message :)
 
} // fin du foreach 
?>
</div>
<META HTTP-equiv="refresh" content=10;>