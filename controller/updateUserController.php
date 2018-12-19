<?php 
session_start(); 
//var_dump($_SESSION);

$config = 'pgsql:host=tuxa.sme.utc;port=5432;dbname=dbna18a028';
$dbuser = 'na18a028';
$dbPassword = 'rWoO38Ra';
$conn = new PDO($config,$dbuser,$dbPassword);

$nom = str_replace("'","''",$_POST['nom']);
$prenom = str_replace("'","''",$_POST['prenom']);
$email = str_replace("'","''",$_POST['email']);
$adresse = str_replace("'","''",$_POST['adresse']);

if($_SESSION['userType'] != 'Admin') {
    $sql = 'UPDATE '.$_SESSION['userType'].' SET nom=\''.$nom.'\', prenom=\''.$prenom.'\', motdepasse=\''.$_POST['password'].'\', adressemail=\''.$email.'\', adresse=\''.$adresse.'\', coobanquenum='.$_POST['coobanquenum'].', dateexpiration=\''.$_POST['dateexpiration'].'\', cryptocarte='.$_POST['cryptocarte'].' WHERE login=\''.$_SESSION['login'].'\'';
} else {
    $sql = 'UPDATE administrateur SET nom=\''.$nom.'\', prenom=\''.$prenom.'\', motdepasse=\''.$_POST['password'].'\', adressemail=\''.$email.'\' WHERE login=\''.$_SESSION['login'].'\'';
}

$userType = $_SESSION['userType'];
$login = $_SESSION['login'];

$resultset = $conn->prepare($sql);
//var_dump($resultset);
$exe = $resultset->execute();
var_dump($exe);
if($exe){
    session_unset();
    $_SESSION['userType'] = $userType;
    $_SESSION['login'] = $login;
    $_SESSION['password'] = $_POST['password'];
    $_SESSION['nom'] = $nom;
    $_SESSION['prenom'] = $prenom;
    $_SESSION['email'] = $email;
    $_SESSION['adresse'] = $adresse;
    if(isset($_POST['coobanquenum'])){
        $_SESSION['coobanquenum'] = $_POST['coobanquenum'];
    }
    if(isset($_POST['dateexpiration'])){
        $_SESSION['dateexpiration'] = $_POST['dateexpiration'];
    }
    if(isset($_POST['cryptocarte'])){
        $_SESSION['cryptocarte'] = $_POST['cryptocarte'];
    }
    $conn = null;
    header('Location: /~na18a028/view/userHome.php');
} else {
    $_SESSION['userExist'] = 1;
    $conn = null;
    header('Location: /~na18a028/view/account.php');
}

?>
