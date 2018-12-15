<?php session_start();
$config = 'pgsql:host=tuxa.sme.utc;port=5432;dbname=dbna18a028';
$dbuser = 'na18a028';
$dbPassword = 'rWoO38Ra';
$conn = new PDO($config,$dbuser,$dbPassword);
//check if this annonce is in the contrat. Yes, we can't change it.
$sql0 = 'SELECT * FROM contrat WHERE loginvendeur=\''.$_SESSION['login'].'\' AND annoncetitre=\''.$_POST['supprimerAnnonce'].'\' AND paiement=TRUE';
$resultset = $conn->prepare($sql0);
$exe = $resultset->execute();
$row = $resultset->fetch(PDO::FETCH_ASSOC);
if ($row){
    $_SESSION['supprimerAnnonceError'] = 1;
    $conn = null;
    //var_dump($resultset);
    echo '1';
    header('Location: /~na18a028/view/userHome.php'); 
} else {
    $sql = 'DELETE FROM annonce WHERE loginvendeur=\''.$_SESSION['login'].'\' AND titre=\''.$_POST['supprimerAnnonce'].'\'';
    $resultset = $conn->prepare($sql);
    $exe = $resultset->execute();
    if($exe){
        $conn = null;
        echo '2';
        header('Location: /~na18a028/view/userHome.php'); 
    } else {
        $conn = null;
        var_dump($resultset);
    }
}

?>