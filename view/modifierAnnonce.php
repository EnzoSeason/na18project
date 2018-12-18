<?php session_start();
//var_dump($_SESSION);
?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <title>Modification d'annonce</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <a class="navbar-brand" href="/~na18a028/index.html">Marketplace NA18 Group 7</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNavDropdown">
    <ul class="navbar-nav ml-auto">
      <li class="nav-item active">
        <a class="nav-link" href="#">
            Bonjour <?php echo $_SESSION['userType']. ' ' . $_SESSION['nom']; ?><span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item active">
        <a class="nav-link" href="/~na18a028/view/userHome.php">Retour</a>
      </li>
    </ul>
  </div>
</nav>
<div class="container" style="margin-top:30px">
<?php

if(isset($_SESSION['modifierAnnonceError']) && $_SESSION['modifierAnnonceError'] != 0){
    if($_SESSION['modifierAnnonceError'] == 1){
        $titre = $_SESSION['modifierAnnonceTitre'];
        $_SESSION['modifierAnnonceError'] = 0;
        echo '<p style="color:red;">Verifier votre photographie, il doit être en  JPG/JPEG/PNG/GIF et moins de 5MB.</p>';       
    } else if ($_SESSION['modifierAnnonceError'] == 3){
        $titre = $_SESSION['modifierAnnonceTitre'];
        $_SESSION['modifierAnnonceError'] = 0;
        echo '<p style="color:red;">Verifier votre description, il a déjà existé.</p>';       
    } else {
        $titre = $_SESSION['modifierAnnonceTitre'];
        $_SESSION['modifierAnnonceError'] = 0;
        echo '<p style="color:red;">Il y a des clients qui ont achetés ce produit, pour instance, vous ne pouvez pas le modifier.</p>';
    }
 } else {
     $titre = $_POST['modifierAnnonce'];
 }

$config = 'pgsql:host=tuxa.sme.utc;port=5432;dbname=dbna18a028';
$dbuser = 'na18a028';
$dbPassword = 'rWoO38Ra';
$conn = new PDO($config,$dbuser,$dbPassword);

$sql = 'SELECT * FROM annonce WHERE loginvendeur=\''.$_SESSION['login'].'\' AND titre = \''.$titre.'\'';
$resultset = $conn->prepare($sql);
$exe = $resultset->execute();
$row = $resultset->fetch(PDO::FETCH_ASSOC);
//var_dump($row);
$conn = null;
?>
<form action="/~na18a028/controller/modifierAnnonceController.php" method="POST" enctype="multipart/form-data"> 
    <div class="form-group row">
        <div class="col">
            <label for="titre" class="col-form-label">Titre: </label>
            <input readonly type="text" class="form-control-plaintext" id="titre" name="titre" placeholder="titre" <?php echo 'value=\''.$titre.'\'';?>>
        </div>
        <div class="col">
            <label for="tag" class="col-form-label">Tag: </label>
            <input type="text" class="form-control" id="tag" name="tag" placeholder="tag" <?php echo 'value=\''.$row['tag'].'\'';?>>
        </div>
        <div class="col">
            <label for="prix" class="col-form-label">Prix: </label>
            <input type="text" class="form-control" id="prix" name="prix" <?php echo 'value=\''.$row['prix'].'\'';?> required>
        </div>          
    </div>

    <div class="form-group row">
        <label for="description">Description: </label>
        <textarea class="form-control" id="description" name="description" rows="3"><?php echo $row['description'];?></textarea>
    </div>

    <div class="form-group row">
        <label for="photographie">Photographie</label>
        <input type="file" class="form-control-file" id="photographie" name="photographie" required>
    </div>

    <div class="form-group row">
        <div class="col-sm-10">
        <button type="submit" class="btn btn-primary" name="submit" <?php echo 'value=\''.$titre.'\'';?>>Modifier l'annonce</button>
        </div>
    </div>
</form>
    
</body>
</html>