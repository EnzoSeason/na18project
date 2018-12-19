<?php session_start();
var_dump($_SESSION); var_dump($_POST);
$contrat = split("_", $_POST['submit']);
//var_dump($contrat);
$loginvendeur = $contrat[0];
$annoncetitre = $contrat[1];
$dateajout = $contrat[2];

$date = new DateTime("now", new DateTimeZone('Europe/Paris') );
$dateToday=$date->format('Y-m-d H:i:s');

$avis = str_replace("'","''",$_POST['commentaire']);

$config = 'pgsql:host=tuxa.sme.utc;port=5432;dbname=dbna18a028';
$dbuser = 'na18a028';
$dbPassword = 'rWoO38Ra';
$conn = new PDO($config,$dbuser,$dbPassword);

$sql = 'INSERT INTO Notation (loginVendeur, annonceTitre, loginAcheteur, score, avis, dateAvis) VALUES (\''.$loginvendeur.'\', \''.$annoncetitre.'\', \''.$_SESSION['login'].'\', '.$_POST['score'].', \''.$avis.'\', \''.$dateToday.'\')';
$resultset = $conn->prepare($sql);
$exe = $resultset->execute();

if($exe){
    $conn = null;
    $_SESSION['commentaireSuccess'] = 1;
    header('Location: /~na18a028/view/contrat.php');
} else{
    var_dump($resultset);
    $conn = null;
}
?>