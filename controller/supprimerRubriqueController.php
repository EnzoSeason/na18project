<?php session_start();
var_dump($_SESSION); var_dump($_POST);

$config = 'pgsql:host=tuxa.sme.utc;port=5432;dbname=dbna18a028';
$dbuser = 'na18a028';
$dbPassword = 'rWoO38Ra';
$conn = new PDO($config,$dbuser,$dbPassword);

$sql = 'DELETE FROM AnnonceDansRubrique WHERE rubriqueNom=\''.$_POST["supprimerRubrique"].'\'';
$resultset = $conn->prepare($sql);
$exe = $resultset->execute();

if($exe){
    $sql0 = 'DELETE FROM rubrique WHERE nom=\''.$_POST["supprimerRubrique"].'\'';
    $resultset = $conn->prepare($sql0);
    $exe = $resultset->execute();
    $conn = null;
    header('Location: /~na18a028/view/userHome.php');    
} else{
    var_dump($resultset);
}

$conn = null;

?>