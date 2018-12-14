<?php session_start();
var_dump($_SESSION);var_dump($_POST);

$annonce = split("_", $_POST['payer']);
$loginVendeur = $annonce[0];
$titreAnnonce = $annonce[1];

$today = getdate();
$dateToday = $today['year'].'-'.$today['mon'].'-'.$today['mday'].' '.$today['hours'].':'.$today['minutes'].":".$today['seconds'];

$config = 'pgsql:host=tuxa.sme.utc;port=5432;dbname=dbna18a028';
$dbuser = 'na18a028';
$dbPassword = 'rWoO38Ra';
$conn = new PDO($config,$dbuser,$dbPassword);

$sql = 'UPDATE contrat SET adresse=\''.$_POST['adresse'].'\', quantité='.$_POST['quantité'].', dateajout=\''.$dateToday.'\', expeditiontype=\''.$_POST['expeditiontype'].'\', expeditioncout='.$_POST['expeditioncout'].', paiement=TRUE where loginacheteur=\''.$_SESSION['login'].'\' AND loginvendeur=\''.$loginVendeur.'\' AND annoncetitre=\''.$titreAnnonce.'\'';

$resultset = $conn->prepare($sql);
$exe = $resultset->execute();

if($exe){
    $sql = 'UPDATE panier SET quantité = quantité - 1 WHERE loginacheteur=\''.$_SESSION['login'].'\'';
    $resultset = $conn->prepare($sql);
    $exe = $resultset->execute();
    if($exe){
        $conn = null;
        $_SESSION['nbAnnoncePanier'] = $_SESSION['nbAnnoncePanier'] - 1;
        header('Location: /~na18a028/view/paysuccess.php');
    }else{
        $conn = null;
        echo 'systeme error in Panier';
    }
} else {
    $conn = null;
    var_dump($resultset);
}



?>