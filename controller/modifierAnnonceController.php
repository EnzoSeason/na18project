<?php session_start();
var_dump($_SESSION);var_dump($_POST);
$config = 'pgsql:host=tuxa.sme.utc;port=5432;dbname=dbna18a028';
$dbuser = 'na18a028';
$dbPassword = 'rWoO38Ra';
$conn = new PDO($config,$dbuser,$dbPassword);

//check if this annonce is in the contrat. Yes, we can't change it.
$sql0 = 'SELECT * FROM contrat WHERE loginvendeur=\''.$_SESSION['login'].'\' AND annoncetitre=\''.$_POST['submit'].'\' AND paiement=TRUE';
$resultset = $conn->prepare($sql0);
$exe = $resultset->execute();
$row = $resultset->fetch(PDO::FETCH_ASSOC);
if ($row){
    $_SESSION['modifierAnnonceError'] = 2;
    $_SESSION['modifierAnnonceTitre']= $_POST['submit'];
    $conn = null;
    //var_dump($resultset);
    header('Location: /~na18a028/view/modifierAnnonce.php'); 
} else {
    $target_dir = "/volsme/user1x/users/na18a028/public_html/image/";
    $target_file = $target_dir . basename($_FILES["photographie"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
    // Check if image file is a actual image or fake image
    if(isset($_POST["submit"])) {
        $check = getimagesize($_FILES["photographie"]["tmp_name"]);
        if($check !== false) {
            echo "File is an image - " . $check["mime"] . ".";
            $uploadOk = 1;
        } else {
            echo "File is not an image.";
            $uploadOk = 0;
        }
    }

    // Check file size
    if ($_FILES["photographie"]["size"] > 500000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }
    // Allow certain file formats
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif" ) {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }
    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    // if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($_FILES["photographie"]["tmp_name"], $target_file)) {
            echo "The file ". basename( $_FILES["photographie"]["name"]). " has been uploaded.";
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }

    if($uploadOk == 0){
        $_SESSION['modifierAnnonceError'] = 1;
        $_SESSION['modifierAnnonceTitre'] = $_POST['submit'];
        $conn = null;
        header('Location: /~na18a028/view/modifierAnnonce.php');
    } else {
        $photo_url = 'http://tuxa.sme.utc/~na18a028/image/'. basename($_FILES["photographie"]["name"]);
        $description = str_replace("'","''",$_POST['description']);
        $sql = 'UPDATE annonce SET description=\''.$description.'\', photographie=\''.$photo_url.'\', prix='.$_POST['prix'].', tag=\''.$_POST['tag'].'\' WHERE loginvendeur=\''.$_SESSION['login'].'\' AND titre=\''.$_POST['submit'].'\'';
        $resultset = $conn->prepare($sql);
        $exe = $resultset->execute();
        if($exe){
            $conn = null;
            header('Location: /~na18a028/view/userHome.php');
        } else {
            $conn = null;
            var_dump($resultset);
            $_SESSION['modifierAnnonceError'] = 3;
            $_SESSION['modifierAnnonceTitre'] = $_POST['submit'];
            header('Location: /~na18a028/view/userHome.php');
        }
    }
}
?>