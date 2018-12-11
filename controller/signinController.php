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
$exe = $resultset->execute();

if( $exe && $_POST['userType'] == 'Acheteur'){
    $sql2 = 'INSERT INTO Panier (loginAcheteur, quantité) VALUES (\''.$_POST['login'].'\', 0)';
    $resultset = $conn->prepare($sql2);
    $exe = $resultset->execute();
} else {
    $_SESSION['userExist'] = 1;
    header('Location: /~na18a028/view/signin.php');
}


if($exe){
    session_unset();
    $_SESSION['userType'] = $_POST['userType'];
    $_SESSION['login'] = $_POST['login'];
    $_SESSION['password'] = $_POST['password'];
    $_SESSION['nom'] = $_POST['nom'];
    $_SESSION['prenom'] = $_POST['prenom'];
    $_SESSION['adressemail'] = $_POST['adressemail'];
    if(isset($_POST['adresse'])){
        $_SESSION['adresse'] = $_POST['adresse'];
    }
    if(isset($_POST['coobanquenum'])){
        $_SESSION['coobanquenum'] = $_POST['coobanquenum'];
    }
    if(isset($_POST['dateexpiration'])){
        $_SESSION['dateexpiration'] = $_POST['dateexpiration'];
    }
    if(isset($_POST['cryptocarte'])){
        $_SESSION['cryptocarte'] = $_POST['cryptocarte'];
    }
    $conn = NULL;
    header('Location: /~na18a028/view/userHome.php');
} else {
    $_SESSION['userExist'] = 1;
    header('Location: /~na18a028/view/signin.php');
}


?>