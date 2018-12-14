<?php session_start();
var_dump($_SESSION); var_dump($_POST);

$annonce = split("_", $_POST['supprimerContratAuPanier']);
$loginVendeur = $annonce[0];
$titreAnnonce = $annonce[1];

$config = 'pgsql:host=tuxa.sme.utc;port=5432;dbname=dbna18a028';
$dbuser = 'na18a028';
$dbPassword = 'rWoO38Ra';
$conn = new PDO($config,$dbuser,$dbPassword);

$sql0 = 'DELETE FROM contrat WHERE loginacheteur=\''.$_SESSION['login'].'\' AND loginvendeur=\''.$loginVendeur.'\' AND annoncetitre=\''.$titreAnnonce.'\' AND paiement=FALSE';
$resultset = $conn->prepare($sql0);
$exe = $resultset->execute();

$sql = 'UPDATE panier SET quantité = quantité - 1 WHERE loginacheteur=\''.$_SESSION['login'].'\'';
$resultset = $conn->prepare($sql);
$exe = $resultset->execute();

if($exe){
    $_SESSION['nbAnnoncePanier'] = $_SESSION['nbAnnoncePanier'] - 1; 
    $conn = null;
    header('Location: /~na18a028/view/panier.php');
} else{
    $conn = null;
    echo "error in delection.";
}

?>