<?php
session_start();
$config = 'pgsql:host=tuxa.sme.utc;port=5432;dbname=dbna18a028';
$dbuser = 'na18a028';
$dbPassword = 'rWoO38Ra';
$conn = new PDO($config,$dbuser,$dbPassword);

if($_POST['userType'] == 'Acheteur'){
    $sql0 = 'SELECT * FROM acheteur WHERE login = \'' . $_POST['login'] . '\' OR adressemail = \'' .$_POST['email']. '\'';

} else if($_POST['userType'] == 'Vendeur'){
    $sql0 = 'SELECT * FROM vendeur WHERE login = \'' . $_POST['login'] . '\' OR adressemail = \'' .$_POST['email'].'\'';

} else { // Admin
    $sql0 = 'SELECT * FROM administrateur WHERE login = \'' . $_POST['login'] .  '\' OR adressemail = \'' .$_POST['email'].'\'';

}
$resultset = $conn->prepare($sql0);
$resultset->execute();

$row = $resultset->fetch(PDO::FETCH_ASSOC);
var_dump($row['login']);
if($row['login'] != NULL){
    $_SESSION['error'] = 1;
    $conn = NULL;
    header('Location: /~na18a028/view/signin.php');
} 
$login = str_replace("'","''",$_POST['login']);
$nom = str_replace("'","''",$_POST['nom']);
$prenom = str_replace("'","''",$_POST['prenom']);
$email = str_replace("'","''",$_POST['email']);
$adresse = str_replace("'","''",$_POST['adresse']);
if($_POST['userType'] == 'Acheteur'){
    $sql = 'INSERT INTO acheteur (login, nom, prenom, motDePasse, adresseMail, adresse, cooBanqueNum, dateExpiration, cryptoCarte) VALUES (\'' . $login . '\', \''. $nom . '\',\''.$prenom. '\', \''. $_POST['password'].'\', \''.$email.'\', \''.$adresse.'\', \''.$_POST['coobanquenum'].'\', \''.$_POST['dateexpiration'].'\', \''.$_POST['cryptocarte'].'\')';

} else if($_POST['userType'] == 'Vendeur'){
    $sql = 'INSERT INTO vendeur (login, nom, prenom, motDePasse, adresseMail, adresse, cooBanqueNum, dateExpiration, cryptoCarte) VALUES (\'' . $login . '\', \''. $nom . '\',\''.$prenom. '\', \''. $_POST['password'].'\', \''.$email.'\', \''.$adresse.'\', \''.$_POST['coobanquenum'].'\', \''.$_POST['dateexpiration'].'\', \''.$_POST['cryptocarte'].'\')';

} else { // Admin
    $sql = 'INSERT INTO administrateur (login, nom, prenom, motDePasse, adresseMail) VALUES (\'' . $login . '\', \''. $nom . '\',\''.$prenom. '\', \''. $_POST['password'].'\', \''.$email.'\')';

}
$resultset = $conn->prepare($sql);
$exe = $resultset->execute();

if(!$exe){
    $_SESSION['error'] = 2;
    $conn = null;
    header('Location: /~na18a028/view/signin.php');
} else{
    if( $_POST['userType'] == 'Acheteur'){
        $sql2 = 'INSERT INTO Panier (loginAcheteur, quantité) VALUES (\''.$login.'\', 0)';
        $resultset = $conn->prepare($sql2);
        $exe = $resultset->execute();
    }
    if($exe){
        session_unset();
        $_SESSION['userType'] = $_POST['userType'];
        $_SESSION['login'] = $login;
        $_SESSION['password'] = $_POST['password'];
        $_SESSION['nom'] = $nom;
        $_SESSION['prenom'] = $prenom;
        $_SESSION['email'] = $email;
        $_SESSION['adresse'] = $adresse;
        $_SESSION['nbAnnoncePanier'] = 0;
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
        $_SESSION['error'] = 3;
        $conn = null;
        header('Location: /~na18a028/view/signin.php');
    }
}


?>