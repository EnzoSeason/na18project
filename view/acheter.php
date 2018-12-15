<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <title>Création du contrat</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script>
        function quantite(price,quantite){
            document.getElementById('total').innerHTML = (price * quantite).toFixed(2);
        }
        function expCout(){
            var cout = document.getElementById("expeditionCout").value;
            document.getElementById('plus').innerHTML =' + '+ cout + '.00';
        }
    </script>
</head>
<body>
<?php session_start(); 
//var_dump($_SESSION); var_dump($_POST);
$annonce = split("_", $_POST['acheter']);
//var_dump($annonce);
$loginVendeur = $annonce[0];
$titreAnnonce = $annonce[1];

$config = 'pgsql:host=tuxa.sme.utc;port=5432;dbname=dbna18a028';
$dbuser = 'na18a028';
$dbPassword = 'rWoO38Ra';
$conn = new PDO($config,$dbuser,$dbPassword);

$sql0 = 'SELECT * FROM contrat, annonce where contrat.loginvendeur=annonce.loginvendeur and contrat.annoncetitre = annonce.titre and loginacheteur=\''.$_SESSION['login'].'\' AND contrat.loginvendeur=\''.$loginVendeur.'\' AND annoncetitre=\''.$titreAnnonce.'\' AND paiement=FALSE';
$resultset = $conn->prepare($sql0);
$exe = $resultset->execute();
$row = $resultset->fetch(PDO::FETCH_ASSOC);
//var_dump($row);
?>
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
        <a class="nav-link" href="/~na18a028/view/panier.php">Retour</a>
      </li>
    </ul>
  </div>
</nav>

<div class="container">
<form action="/~na18a028/controller/acheterController.php" method="POST"> 
    <h4 style="margin-top:30px; margin-bottom:30px;">Votre Commande</h4><br />
    <div id="product" class="row">
        <div class="col-sm-3">
            <?php echo '<img height="150px" width="150px" src="'.$row['photographie'].'" alt="image cap">'; ?>
        </div>
        <div class="col-sm-6">
            <?php 
            echo '<h5>'.$row['titre'].'</h5>';
            echo '<p>'.$row['description'].'</p>';
            echo '<p>'.'Vendeur: '.$row['loginvendeur'].'</p>';
            echo '<div style="margin-top:10px"><div class="row"><div class="col-sm-4">';
            echo '<label for="expeditionType" class="col-form-label">Expedition Type</label>';
            echo '<select class="form-control" id="expeditionType" name="expeditiontype">';
            echo '<option value="Colissimo">Colissimo</option>';
            echo '<option value="TNT">TNT</option>';
            echo '<option value="Retrait">Retrait</option>';
            echo '</select>';
            echo '</div>';
            echo '<div class="col-sm-4">';
            echo '<label for="expeditionCout" class="col-form-label">Expedition Vitesse</label>';
            echo '<select class="form-control" id="expeditionCout" name="expeditioncout" onChange="expCout()">';
            echo '<option value="0">normale + 0€</option>';
            echo '<option value="3">vite + 3€</option>';
            echo '<option value="5">très vite + 5€</option>';
            echo '</select>';
            echo '</div></div></div>';
            ?>
        </div>
        <div class="col-sm-3">
            <?php
            echo '<h6 style="color:red;">EUR '.$row['prix'].'</h6>';
            echo '<label for="quantité" class="col-form-label">Quantité</label>';
            echo '<input style="width:50px;" type="text" class="form-control" id="quantité" name="quantité" placeholder="0" pattern="\d+" onkeyup="quantite('.$row['prix'].', this.value)" required>';
            ?>
        </div>
    </div>
    <hr />
    <h4 style="margin-top:30px; margin-bottom:30px;">Votre adresse de livraison</h4>
    <div class="row" id="adresseInfo">
        <?php
        $sql = 'SELECT * FROM acheteur WHERE login=\''.$_SESSION['login'].'\'';
        $resultset = $conn->prepare($sql);
        $exe = $resultset->execute();
        $acheteurInfo = $resultset->fetch(PDO::FETCH_ASSOC);
        ?>
        <label for="Address" class="col-sm-2 col-form-label">Adresse de livraison</label>
            <div class="col-sm-10">
            <?php
                echo '<input type="text" class="form-control" id="Address" name="adresse" value="'.$acheteurInfo['adresse'].'" required>';
            ?>
            </div>
    </div>
    <hr />
    <h4 style="margin-top:30px; margin-bottom:30px;">Vos informations bancaires</h4>
    <div id='bankInfo' class="row">
        <div class="col">
            <label for="numCarte" class="col-form-label">Numéro de carte: </label>
            <?php
                echo '<input type="text" class="form-control" id="numCarte" name="coobanquenum" placeholder="16 numéros" minlength="16" value="'.$acheteurInfo['coobanquenum'].'" required>';
            ?>
        </div>
        <div class="col">
            <label for="dateExp" class="col-form-label">Date d'expiration: </label>
            <?php
                echo '<input type="text" class="form-control" id="dateExp" name="dateexpiration" placeholder="00/00" pattern="\d\d/\d\d" value="'.$acheteurInfo['dateexpiration'].'" required>';
            ?>
        </div>
        <div class="col">
            <label for="codeSecurity" class="col-form-label">Code de sécurité: </label>
            <?php
                echo '<input type="text" class="form-control" id="codeSecurity" name="cryptocarte" placeholder="3 numéros" minlength="3" value="'.$acheteurInfo['cryptocarte'].'" required>';
            ?>
        </div>
    </div>
    <div class="row" id='pay' style="margin-top:30px;margin-bottom:50px;">
        <div class="col-sm-9">
        <?php
        echo '<button class="btn btn-outline-primary" type="submit" name="payer" value="'.$row['loginvendeur'].'_'.$row['annoncetitre'].'_'.$row['dateajout'].'">Payer</button>';
        $conn = null;
        ?>
        </div>
        <div class="col-sm-3">
            <h5 style="color:red;">Total: EUR <span id='total'>0.00</span><span id='plus'> + 0.00</span></h5>
        </div>
    </div>
</form>
</div>
</body>
</html>