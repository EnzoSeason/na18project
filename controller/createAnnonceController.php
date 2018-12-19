<?php session_start();
//var_dump($_SESSION);
//var_dump($_POST);
//var_dump($_FILES);

//check si la nouvelle annonce est dans la BDD
$config = 'pgsql:host=tuxa.sme.utc;port=5432;dbname=dbna18a028';
$dbuser = 'na18a028';
$dbPassword = 'rWoO38Ra';
$conn = new PDO($config,$dbuser,$dbPassword);

$sql0 = 'SELECT * FROM annonce WHERE loginvendeur=\''.$_SESSION['login'].'\' AND titre=\''.$_POST['titre'].'\'';
$resultset = $conn->prepare($sql0);
$exe = $resultset->execute();
$row = $resultset->fetch(PDO::FETCH_ASSOC);
var_dump($row);

if ($row){
    $conn = null;
    $_SESSION['createAnnonceError'] = 1;
    header('Location: /~na18a028/view/createAnnonce.php');
} else {
    //upload image to server
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
            $photo_url = 'http://tuxa.sme.utc/~na18a028/image/'. basename($_FILES["photographie"]["name"]);
            $description = str_replace("'","''",$_POST['description']);
            $sql = 'INSERT INTO annonce (loginvendeur, titre, description, prix,tag, photographie) VALUES (\''.$_SESSION['login'].'\', \''.$_POST['titre'].'\', \''.$description.'\', '.$_POST['prix'].', \''.$_POST['tag'].'\',\''.$photo_url.'\')';
            $resultset = $conn->prepare($sql);
            $exe = $resultset->execute();
            if($exe){
                $conn = null;
                header('Location: /~na18a028/view/userHome.php');
            } else{
                $conn = null;
                var_dump($resultset);
                echo 'error insert';
            }
        } else {
            $conn = null;
            echo "Sorry, there was an error uploading your file.";
        }
    }
    
}


?>