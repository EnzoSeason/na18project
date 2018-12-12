<?php
session_start();
$config = 'pgsql:host=tuxa.sme.utc;port=5432;dbname=dbna18a028';
$dbuser = 'na18a028';
$dbPassword = 'rWoO38Ra';
$conn = new PDO($config,$dbuser,$dbPassword);
if($_POST['userType'] == 'Acheteur'){
    $sql = 'SELECT * FROM acheteur WHERE login = \'' . $_POST['login'] . '\' AND motdepasse = \'' . $_POST['password'] . '\'';

} else if($_POST['userType'] == 'Vendeur'){
    $sql = 'SELECT * FROM vendeur WHERE login = \'' . $_POST['login'] . '\' AND motdepasse = \'' . $_POST['password'] . '\'';

} else { // Admin
    $sql = 'SELECT * FROM administrateur WHERE login = \'' . $_POST['login'] . '\' AND motdepasse = \'' . $_POST['password'] . '\'';

}
$resultset = $conn->prepare($sql);
$resultset->execute();

$row = $resultset->fetch(PDO::FETCH_ASSOC);
//var_dump($resultset);
if($row != TRUE){
    $_SESSION['error'] = 1;
    $conn = NULL;
    header('Location: /~na18a028/index.html');
} else {
    session_unset();
    //var_dump($row);
    $_SESSION['userType'] = $_POST['userType'];
    $_SESSION['login'] = $_POST['login'];
    $_SESSION['password'] = $_POST['password'];
    $_SESSION['nom'] = $row['nom'];
    $_SESSION['prenom'] = $row['prenom'];
    $_SESSION['adressemail'] = $row['adressemail'];
    if(isset($row['adresse'])){
        $_SESSION['adresse'] = $row['adresse'];
    }
    if(isset($row['coobanquenum'])){
        $_SESSION['coobanquenum'] = $row['coobanquenum'];
    }
    if(isset($row['dateexpiration'])){
        $_SESSION['dateexpiration'] = $row['dateexpiration'];
    }
    if(isset($row['cryptocarte'])){
        $_SESSION['cryptocarte'] = $row['cryptocarte'];
    }
    $conn = NULL;
    header('Location: /~na18a028/view/userHome.php');
}

?>