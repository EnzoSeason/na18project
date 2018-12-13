<?php session_start();//var_dump($_SESSION);?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <title>Panier</title>
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
        <a class="nav-link" href="/~na18a028/view/account.php">
            Bonjour <?php echo $_SESSION['userType']. ' ' . $_SESSION['nom']; ?><span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item active">
        <a class="nav-link" href="/~na18a028/view/userHome.php">Retour</a>
      </li>
    </ul>
  </div>
</nav>

<div class="container" style="margin-top:30px">
    <h5 style="margin-bottom:20px">Votre panier :</h5>
    <?php
        $config = 'pgsql:host=tuxa.sme.utc;port=5432;dbname=dbna18a028';
        $dbuser = 'na18a028';
        $dbPassword = 'rWoO38Ra';
        $conn = new PDO($config,$dbuser,$dbPassword);

        $sql = 'select * from contrat, annonce where contrat.loginvendeur=annonce.loginvendeur and contrat.annoncetitre = annonce.titre and loginacheteur=\''.$_SESSION['login'].'\' AND paiement=FALSE';
        $resultset = $conn->prepare($sql);
        $resultset->execute();
        while ($row = $resultset->fetch(PDO::FETCH_ASSOC)) {
    ?>
    <hr />
    <div class="row" style="height: 225px;">
        <div class="col-sm-3">
        <?php echo '<img height="150px" width="150px" src="'.$row['photographie'].'" alt="image cap">'; ?>
        </div>
        <div class="col-sm-6">
        <?php 
        echo '<h5>'.$row['titre'].'</h5>';
        echo '<p>'.$row['description'].'</p>';
        echo '<span>'.'Vendeur: '.$row['loginvendeur'].'</span>';
        echo '<div style="margin-top:10px"><div class="row"><div class="col-sm-2">';
        echo '<form class="form-inline" action="/~na18a028/controller/acheterController.php" method="post">
        <button class="btn btn-outline-primary" type="submit" name="acheter" value="'.$row['loginvendeur'].'_'.$row['titre'].'">Acheter</button>
        </form>';
        echo '</div>';
        echo '<div class="col-sm-2">';
        echo '<form action="/~na18a028/controller/supprimerContratAuPanierController.php" method="post">
        <button class="btn btn-outline-danger" type="submit" name="supprimerContratAuPanier" value="'.$row['loginvendeur'].'_'.$row['titre'].'">Supprimer</button>
        </form>';
        echo '</div></div></div>';
        ?>
        </div>
        <div class="col-sm-3">
        <?php
        echo '<h6 style="color:red;">EUR '.$row['prix'].'</h6>';
        ?>
        </div>
    </div>
    <?php } ?>
</div>

</body>

</html>