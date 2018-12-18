<?php session_start();
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

$sql0 = 'DELETE FROM annoncedansrubrique WHERE rubriquenom=\''.$_POST["nom"].'\'';
$resultset = $conn->prepare($sql0);
$exe = $resultset->execute();

foreach($annonce as $a){
    $b = split("_", $a);
    $loginVendeur = $b[0];
    $titre = $b[1];

    $sql = 'INSERT INTO AnnonceDansRubrique (rubriqueNom, annonceVendeur, annonceTitre) VALUES (\''.$_POST['nom'].'\', \''.$loginVendeur.'\', \''.$titre.'\')';
    $resultset = $conn->prepare($sql);
    $exe = $resultset->execute();

    if(!$exe){
        $conn = null;
        var_dump($resultset);
        break;
    }
}

if($exe){
    $sql2 = 'UPDATE rubrique SET type=\''.$_POST['type'].'\', description=\''.$_POST['description'].'\' WHERE nom=\''.$_POST['nom'].'\'';
    $resultset = $conn->prepare($sql2);
    $exe = $resultset->execute();
    if ($exe){
        $conn = null;
        header('Location: /~na18a028/view/userHome.php');
    } else {
        var_dump($resultset);
    }
}

?>