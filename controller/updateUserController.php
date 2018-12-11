<?php 
session_start(); 
var_dump($_SESSION);

$config = 'pgsql:host=tuxa.sme.utc;port=5432;dbname=dbna18a028';
$dbuser = 'na18a028';
$dbPassword = 'rWoO38Ra';
$conn = new PDO($config,$dbuser,$dbPassword);

if($_SESSION['userType'] != 'Admin') {
    $sql = 'UPDATE '.$_SESSION['userType'].' SET nom=\''.$_POST['nom'].'\', prenom=\''.$_POST['prenom'].'\', motdepasse=\''.$_POST['password'].'\', adressemail=\''.$_POST['email'].'\', adresse=\''.$_POST['adresse'].'\', coobanquenum='.$_POST['coobanquenum'].', dateexpiration=\''.$_POST['dateexpiration'].'\', cryptocarte='.$_POST['cryptocarte'].' WHERE login=\''.$_SESSION['login'].'\'';
} else {
    $sql = 'UPDATE '.$_SESSION['userType'].' SET nom=\''.$_POST['nom'].'\', prenom=\''.$_POST['prenom'].'\', motdepasse=\''.$_POST['password'].'\', adressemail=\''.$_POST['email'].'\', adresse=\''.$_POST['adresse'].'\' WHERE login=\''.$_SESSION['login'].'\'';
}

$resultset = $conn->prepare($sql);
var_dump($resultset);
$exe = $resultset->execute();

if($exe){
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
    $conn = null;
    header('Location: /~na18a028/view/account.php');
}

?>
