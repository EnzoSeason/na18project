<?php session_start();
var_dump($_GET);

$config = 'pgsql:host=tuxa.sme.utc;port=5432;dbname=dbna18a028';
$dbuser = 'na18a028';
$dbPassword = 'rWoO38Ra';
$conn = new PDO($config,$dbuser,$dbPassword);

$sql = 'DELETE FROM notation WHERE loginacheteur=\''.$_SESSION['login'].'\' AND loginvendeur=\''.$_GET['loginvendeur'].'\' AND annoncetitre=\''.$_GET['annoncetitre'].'\' AND dateavis=\''.$_GET['dateavis'].'\'';
$resultset = $conn->prepare($sql);
$exe = $resultset->execute();

if($exe){
    $_SESSION['supprimerCommentaireSuccess'] = 1;
    $conn = null;
    header('Location: /~na18a028/view/contrat.php');
} else {
    $conn = null;
    var_dump($resultset);
}

?>