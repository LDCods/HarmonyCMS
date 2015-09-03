<?php 
$titre = 'Panel Admin - Membres';
include('../include/init.php');
if(connect()) {
if($rang == "Administrateur") {

$update = file_get_contents("http://eywek.fr/cms/update.txt", "r");
$fp = fopen("update.php","w+");
fwrite($fp, $update);
fclose($fp);
header('Location: update.php');
exit();

} else {
  header('Location: ../connexion.php?msg=denyadmin');
  exit();
}
} else {
	header('Location: ../connexion.php?msg=deny');
	exit();
}
?>