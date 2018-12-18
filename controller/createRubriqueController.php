<?php
session_start(); 
//var_dump($_SESSION); var_dump($_POST);
$i = 0;
foreach($_POST as $key => $value){
    if($key != 'nom' && $key != 'type' && $key != 'submit' && $key != 'description'){
        $annonce[$i] = $value;
        $i = $i + 1;
    }
}

$config = 'pgsql:host=tuxa.sme.utc;port=5432;dbname=dbna18a028';
$dbuser = 'na18a028';
$dbPassword = 'rWoO38Ra';
$conn = new PDO($config,$dbuser,$dbPassword);

$sql = 'INSERT INTO Rubrique (nom, type, description, loginAdmin) VALUES (\''.$_POST['nom'].'\', \''.$_POST['type'].'\', \''.$_POST['description'].'\', \''.$_SESSION['login'].'\')';
$resultset = $conn->prepare($sql);
$exe = $resultset->execute();
var_dump($exe);
if (!$exe){
    $conn = null;
    $_SESSION['createRubriqueError'] = 1;
    header('Location: /~na18a028/view/createRubrique.php');
} else{
    foreach($annonce as $a){
        $b = split("_", $a);
        $loginVendeur = $b[0];
        $titre = $b[1];

        $sql = 'INSERT INTO AnnonceDansRubrique (rubriqueNom, annonceVendeur, annonceTitre) VALUES (\''.$_POST['nom'].'\', \''.$loginVendeur.'\', \''.$titre.'\')';
        $resultset = $conn->prepare($sql);
        $exe = $resultset->execute();

        if(!$exe){
            $conn = null;
            $_SESSION['createRubriqueError'] = 2;
            header('Location: /~na18a028/view/createRubrique.php');
            break;
        }
    }
    $conn = null;
    header('Location: /~na18a028/view/userHome.php');
}

?>