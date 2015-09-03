<?php
include('include/init.php');

/* Script de récupération et de vérification des données IPN de Paypal
        Disponible sur https://cms.paypal.com/cms_content/US/en_US/files/developer/IPN_PHP_41.txt */
 
// Ajout du paramètre "cmd" à l'URL
$req = 'cmd=_notify-validate';
 
foreach ($_POST as $cle => $valeur)
{
    $valeur = urlencode(stripslashes($valeur));
    $req .= "&$cle=$valeur";
}
 
// On renvoie les informations IPN à Paypal pour valider la transaction
$header .= "POST /cgi-bin/webscr HTTP/1.0\r\n";
$header .= "Content-Type: application/x-www-form-urlencoded\r\n";
$header .= "Content-Length: " . strlen($req) . "\r\n\r\n";
$fp = fsockopen ('ssl://www.paypal.com', 443, $errno, $errstr, 30);// Mode de connexion par SSL.
 
// On récupère les données POST dans des variables
$item_name = $_POST['item_name'];
$item_number = $_POST['item_number'];
$payment_status = $_POST['payment_status'];
$payment_amount = $_POST['mc_gross'];
$payment_currency = $_POST['mc_currency'];
$txn_id = $_POST['txn_id'];
$receiver_email = $_POST['receiver_email'];
$payer_email = $_POST['payer_email'];
parse_str($_POST['custom'], $custom);
$id = $custom['user_id'];
 
if (!$fp) // Si la connexion avec Paypal n'a pas pu être initialisée, on affiche une erreur
{
    setFlash('Problème de connexion avec Paypal, les données IPN n\'ont pas pu être repostées', 'error');
    header('Location: crediter.php');
    exit();
}
else
{
    fputs ($fp, $header . $req);// fputs=fwrite | On envoie la variable $req à Paypal via le connexion initialisée précédemment (nommée $fp)
    while (!feof($fp))// Tant qu'on n'arrive pas à la fin de $fp
    {
        $res = fgets ($fp, 1024);
        if (strcmp ($res, "VERIFIED") == 0)// Si on trouve le mot VERIFIED (donc si les données reçues correspondent aux données de la transaction)
        {
            if ($payment_status=="Completed" AND $receiver_email==$mail_paypal AND $payment_amount==$prix_rubis_paypal AND $payment_currency=="EUR")// Si tous les paramètres sont bons, on peut procéder au traitement de la commande
            {
                $newsolde = $rubis+$ajout_rubis_paypal;
                $updateSolde = $connexion->prepare('UPDATE membres SET rubis=:rubis WHERE id=:id');
                $updateSolde ->execute(array(
                  'rubis' => $newsolde, 
                  'id' => $id,
                ));
                $data = 'Ok';
                $fp = fopen("paypal_log.txt","w+");
                fwrite($fp, $data);
                fclose($fp);
                header('Location: crediter.php?paypal=ok');
                exit();
            }
        }
        else if (strcmp ($res, "INVALID") == 0) // Si on trouve le mot INVALID (données reçues != données de la transaction)
        {
            setFlash('Un problème est survenue durant le paiement, veuillez ré-essayer.', 'error');
            header('Location: crediter.php?erreur');
            exit();
        }
    }
fclose ($fp);
}
?>