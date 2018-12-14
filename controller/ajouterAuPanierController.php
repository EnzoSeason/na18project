<?php session_start();
//var_dump($_SESSION);var_dump($_POST);
$annonce = split("_", $_POST['ajouterAuPanier']);
//var_dump($annonce);
$loginVendeur = $annonce[0];
$titreAnnonce = $annonce[1];
$today = getdate();
$dateToday = $today['year'].'-'.$today['mon'].'-'.$today['mday'].' '.$today['hours'].':'.$today['minutes'].":".$today['seconds'];

$config = 'pgsql:host=tuxa.sme.utc;port=5432;dbname=dbna18a028';
$dbuser = 'na18a028';
$dbPassword = 'rWoO38Ra';
$conn = new PDO($config,$dbuser,$dbPassword);

$sql0 = 'SELECT * FROM contrat WHERE loginacheteur=\''.$_SESSION['login'].'\' AND loginvendeur=\''.$loginVendeur.'\' AND annoncetitre=\''.$titreAnnonce.'\' AND paiement=FALSE';
$resultset = $conn->prepare($sql0);
$exe = $resultset->execute();
$row = $resultset->fetch(PDO::FETCH_ASSOC);
var_dump($row);

if(!$row){
    echo "adding..";
    $sql = 'UPDATE panier SET quantité = quantité + 1 WHERE loginacheteur=\''.$_SESSION['login'].'\'';
    $resultset = $conn->prepare($sql);
    $exe = $resultset->execute();
    //var_dump($exe);
    $sql = 'SELECT quantité FROM panier WHERE loginacheteur=\''.$_SESSION['login'].'\'';
    $resultset = $conn->prepare($sql);
    $exe = $resultset->execute();
    $row = $resultset->fetch(PDO::FETCH_ASSOC);
    $_SESSION['nbAnnoncePanier'] = $row['quantité'];

    $sql='INSERT INTO contrat (loginVendeur, annonceTitre, loginAcheteur, dateAjout, quantité, expeditionType, expeditionCout, paiement, adresse) VALUES (\''.$loginVendeur.'\', \''.$titreAnnonce.'\', \''.$_SESSION['login'].'\', \''.$dateToday.'\', '.'1, \'Colissimo\', 0, FALSE, \'\')';
    $resultset = $conn->prepare($sql);
    var_dump($resultset);
    $exe = $resultset->execute();
    if($exe){
        $conn = null;
        header('Location: /~na18a028/view/userHome.php');
    } else{
        $conn = null;
        echo 'error in adding product to panier';
    }
} else {
    echo 'déjà dans panier';
    $conn = null;
    header('Location: /~na18a028/view/userHome.php');
}

?>