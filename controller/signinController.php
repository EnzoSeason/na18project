<?php
session_start();
$config = 'pgsql:host=tuxa.sme.utc;port=5432;dbname=dbna18a028';
$dbuser = 'na18a028';
$dbPassword = 'rWoO38Ra';
$conn = new PDO($config,$dbuser,$dbPassword);
if($_POST['userType'] == 'Acheteur'){
    $sql = 'INSERT INTO acheteur (login, nom, prenom, motDePasse, adresseMail, adresse, cooBanqueNum, dateExpiration, cryptoCarte) VALUES (\'' . $_POST['login'] . '\', \''. $_POST['nom'] . '\',\''.$_POST['prenom']. '\', \''. $_POST['password'].'\', \''.$_POST['email'].'\', \''.$_POST['adresse'].'\', \''.$_POST['numCarte'].'\', \''.$_POST['dateExp'].'\', \''.$_POST['codeSecurity'].'\')';

} else if($_POST['userType'] == 'Vendeur'){
    $sql = 'INSERT INTO vendeur (login, nom, prenom, motDePasse, adresseMail, adresse, cooBanqueNum, dateExpiration, cryptoCarte) VALUES (\'' . $_POST['login'] . '\', \''. $_POST['nom'] . '\',\''.$_POST['prenom']. '\', \''. $_POST['password'].'\', \''.$_POST['email'].'\', \''.$_POST['adresse'].'\', \''.$_POST['numCarte'].'\', \''.$_POST['dateExp'].'\', \''.$_POST['codeSecurity'].'\')';

} else { // Admin
    $sql = 'INSERT INTO administrateur (login, nom, prenom, motDePasse, adresseMail) VALUES (\'' . $_POST['login'] . '\', \''. $_POST['nom'] . '\',\''.$_POST['prenom']. '\', \''. $_POST['password'].'\', \''.$_POST['email'].'\')';

}
$resultset = $conn->prepare($sql);
$resultset->execute();

if($resultset){
    session_unset();
    $_SESSION['userType'] = $_POST['userType'];
    $_SESSION['login'] = $_POST['login'];
    $_SESSION['nom'] = $row['nom'];
    $_SESSION['prenom'] = $row['prenom'];
    $conn = NULL;
    header('Location: /~na18a028/view/userHome.php');
}


?>