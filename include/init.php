<?php
$date = date('d/m/Y');
$heure = date('H');
$minute = date('i');

session_start();
header("Content-Type: text/html; charset=utf-8");

function connect() {
    if(empty($_SESSION['session'])) {
        return false;
    } else {
        return true;
    }
}


function flash(){
    if(isset($_SESSION['Flash'])){
        $message = $_SESSION['Flash'];
        $type = $_SESSION['Flash_Type'];
        echo "<div class='alert alert-$type'><button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>$message</div>";
        unset($_SESSION['Flash_Type']);
        unset($_SESSION['Flash']);
    }
}

function setFlash($message, $type = 'success') {
    $_SESSION['Flash'] = $message;
    $_SESSION['Flash_Type'] = $type;
}

include('include/include.php');

if(isset($etape_1)) {
if($etape_1 == "ok") {
?>
<?php
try
{
    $connexion = new PDO('mysql:host='.$host.';dbname='.$db.'', ''.$user.'', ''.$password.'');
    if(!empty($_SESSION['session'])) {
    	$req_selectMembre = $connexion->prepare('SELECT * FROM membres WHERE session=:session');
    	$req_selectMembre->execute(array(
    		'session' => $_SESSION['session']
    	));
    	$selectMembre = $req_selectMembre->fetch();

        $pseudo = $selectMembre['pseudo'];
	    $email = $selectMembre['email'];
	    $rangnumero = $selectMembre['rang'];
        $rubis = $selectMembre['rubis'];
        $nombre_vote = $selectMembre['nbr_vote'];
        $heurevote = $selectMembre['heurevote'];
        if($nombre_vote == null) {
            $nombre_vote = 0;
        }
        if($rubis == null) {
            $rubis = 0;
        }
    } else {
    	return true;
    }

}
catch (Exception $e)
{
        echo('Erreur : ' . $e->getMessage());
}

    $req_nbrMembre = $connexion->query('SELECT * FROM membres');
    $nbrMembre = $req_nbrMembre->rowCount();

    $req_nbrNews = $connexion->query('SELECT * FROM news');
    $nbrNews = $req_nbrNews->rowCount();

    $req_nbrArticles = $connexion->query('SELECT * FROM boutique_article');
    $nbrArticles = $req_nbrArticles->rowCount();

    $req_nbrCat = $connexion->query('SELECT * FROM boutique_article');
    $nbrCat = $req_nbrCat->rowCount();


if ($rangnumero == "1") {
    $rang = "Membre";
}
if ($rangnumero == "2") {
    $rang = "Modérateur";
}
if ($rangnumero == "3") {
    $rang = "Administrateur";
}

}
}
?>