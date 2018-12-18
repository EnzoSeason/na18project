<?php session_start();//var_dump($_SESSION);?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <title>Home</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <a class="navbar-brand" href="/~na18a028/index.html">Marketplace NA18 Group 7</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <?php
  if($_SESSION['userType'] == 'Acheteur'){
    $config = 'pgsql:host=tuxa.sme.utc;port=5432;dbname=dbna18a028';
    $dbuser = 'na18a028';
    $dbPassword = 'rWoO38Ra';
    $conn = new PDO($config,$dbuser,$dbPassword);
  ?>
  <div class="collapse navbar-collapse" id="left">
    <ul class="navbar-nav mr-auto">
        <li class="nav-item active">
            <a class="nav-link" href="#">Accueil<span class="sr-only">(current)</span></a>
        </li>
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Sélections
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                <?php
                $sql = 'SELECT * FROM rubrique WHERE type=\'Selection\'';
                $resultset = $conn->prepare($sql);
                $resultset->execute();

                while ($r = $resultset->fetch(PDO::FETCH_ASSOC)) {
                    echo '<form class="dropdown-item" action="/~na18a028/view/rubrique.php" method="post">
                    <button class="btn btn-link" type="submit" name="rubrique" value="'.$r['nom'].'_'.$r['type'].'">'.$r['nom'].'</button>
                    </form>';
                }

                ?>
            </div>
        </li>
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown2" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Blogs
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown2">
                <?php
                $sql = 'SELECT * FROM rubrique WHERE type=\'Blog\'';
                $resultset = $conn->prepare($sql);
                $resultset->execute();

                while ($r = $resultset->fetch(PDO::FETCH_ASSOC)) {
                    echo '<form class="dropdown-item" action="/~na18a028/view/rubrique.php" method="post">
                    <button class="btn btn-link" type="submit" name="rubrique" value="'.$r['nom'].'_'.$r['type'].'">'.$r['nom'].'</button>
                    </form>';
                }

                ?>
            </div>
        </li>
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown3" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Catégories
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown3">
                <?php
                $sql = 'SELECT * FROM rubrique WHERE type=\'Catégorie\'';
                $resultset = $conn->prepare($sql);
                $resultset->execute();

                while ($r = $resultset->fetch(PDO::FETCH_ASSOC)) {
                    echo '<form class="dropdown-item" action="/~na18a028/view/rubrique.php" method="post">
                    <button class="btn btn-link" type="submit" name="rubrique" value="'.$r['nom'].'_'.$r['type'].'">'.$r['nom'].'</button>
                    </form>';
                }
                ?>
            </div>
        </li>
    </ul>
  </div>
  <?php $conn = null;} ?>
  <div class="collapse navbar-collapse" id="navbarNavDropdown">
    <ul class="navbar-nav ml-auto">
      <li class="nav-item active">
        <a class="nav-link" href="/~na18a028/view/account.php">
            <?php 
            echo 'Bonjour '.$_SESSION['userType']. ' ' . $_SESSION['nom']; 
            ?><span class="sr-only">(current)</span></a>
      </li>
      <?php
      if($_SESSION['userType'] == 'Acheteur'){
          echo '<li class="nav-item">';
          echo '<a class="nav-link" href="/~na18a028/view/panier.php">
          <span>Panier + </span> 
          <span id="nav-cart-count" aria-hidden="true">'.$_SESSION['nbAnnoncePanier'].'</span>
          </a>';
          echo '</li>';
      }
      ?>
      <?php
      if($_SESSION['userType'] != 'Admin'){
          echo '<li class="nav-item">';
          echo '<a class="nav-link" href="/~na18a028/view/contrat.php">Contrats </a>';
          echo '</li>';
      }
      ?>
      
      <li class="nav-item">
        <form class="form-inline" action="/~na18a028/controller/logoutController.php" method="post">
            <button class="btn btn-outline-warning" type="submit" name="logout">Log out</button>
        </form>
      </li>
    </ul>
  </div>
</nav>
<div id="home" class="container" style="margin-top:30px">
    <?php
    $config = 'pgsql:host=tuxa.sme.utc;port=5432;dbname=dbna18a028';
    $dbuser = 'na18a028';
    $dbPassword = 'rWoO38Ra';
    $conn = new PDO($config,$dbuser,$dbPassword);

    if($_SESSION['userType'] == 'Acheteur'){
        $sql = 'SELECT * FROM annonce';
        $resultset = $conn->prepare($sql);
        $resultset->execute();
        $i = 0;
        while ($row = $resultset->fetch(PDO::FETCH_ASSOC)) {
            if (($i % 3) == 0){
                echo '<div class="row" style="margin-top:20px">';
            }
            echo '<div class="col-sm-4">';
            echo '<div class="card" style="height: 450px;">';
            echo '<img class="card-img-top" height="300px" width="300px" src="'.$row['photographie'].'" alt="Card image cap">';
            echo '<div class="card-body">';
            echo '<h5 class="card-title">'.$row['titre']."      ".$row['prix'].'€</h5>';
            echo '<p class="card-text">'.'Vendeur: '.$row['loginvendeur'].'</p>';
            echo '<form class="form-inline" action="/~na18a028/controller/ajouterAuPanierController.php" method="post">
            <button class="btn btn-outline-primary" type="submit" name="ajouterAuPanier" value="'.$row['loginvendeur'].'_'.$row['titre'].'">Ajouter au panier</button>
            </form>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
            $i = $i + 1;
            if (($i % 3) == 0){
                echo '</div>';
            }
        }
        $conn = null;
    } else if ($_SESSION['userType'] == 'Vendeur') {
        if(isset($_SESSION['supprimerAnnonceError']) && $_SESSION['supprimerAnnonceError'] == 1){
            $_SESSION['supprimerAnnonceError'] = 0;
            echo '<p style="color:red;">Il y a des clients qui ont achetés ce produit, pour instance, vous ne pouvez pas le modifier.</p>';
        }
        echo '<div id="line"><div class="row">';
        echo '<div class="col-sm-9">';
        echo '<h4>Vos Annonces: </h4>';
        echo '</div>';
        echo '<div class="col-sm-3">';
        echo '<a class="btn btn-success" href="/~na18a028/view/createAnnonce.php" role="button">Créer une annonce ! </a><br />';
        echo '</div>';
        echo '</div></div>';
        $sql = 'SELECT * FROM annonce WHERE loginvendeur=\''.$_SESSION['login'].'\'';
        $resultset = $conn->prepare($sql);
        $resultset->execute();
        
        echo '<div id="annonceList">';
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
            echo '<div style="margin-bottom:10px"><span>'.'Vendeur: '.$row['loginvendeur'].'</span></div>';
            echo '<div style="margin-top:10px"><div class="row"><div class="col-sm-2">';
            echo '<form class="form-inline" action="/~na18a028/view/modifierAnnonce.php" method="post">
            <button class="btn btn-outline-primary" type="submit" name="modifierAnnonce" value="'.$row['titre'].'">Modifier</button>
            </form>';
            echo '</div>';
            echo '<div class="col-sm-2">';
            echo '<form action="/~na18a028/controller/supprimerAnnonceController.php" method="post">
            <button class="btn btn-outline-danger" type="submit" name="supprimerAnnonce" value="'.$row['titre'].'">Supprimer</button>
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
        <?php }
        echo '</div>';
        $conn = null;
    } else { //Admin

        echo '<div id="line"><div class="row">';
        echo '<div class="col-sm-9">';
        echo '<h4>Vos rubriques: </h4>';
        echo '</div>';
        echo '<div class="col-sm-3">';
        echo '<a class="btn btn-success" href="/~na18a028/view/createRubrique.php" role="button">Créer une rubique</a><br />';
        echo '</div>';
        echo '</div></div>';

        $sql = 'SELECT * FROM administrateur, rubrique WHERE administrateur.login=rubrique.loginadmin AND administrateur.login=\''.$_SESSION['login'].'\'';

        $resultset = $conn->prepare($sql);
        $resultset->execute();

        echo '<div id="rubriqueList">';
        while ($row = $resultset->fetch(PDO::FETCH_ASSOC)) {
            ?>
        <hr />
        <div class="row" style="height: 200px;">
            <div class="col-sm-3">
                <?php 
                echo '<h6>Rubrique:<br /></h6>';
                echo '<p>'.$row['nom'].'</p>';
                echo '<h6>Type:<br /></h6>';
                echo '<p>'.$row['type'].'</p>'; 
                ?>
            </div>
            <div class="col-sm-6">
                <?php
                echo '<h6>Description:<br /></h6>';
                echo '<p>'.$row['description'].'</p>';
                ?>
            </div>
            <div class="col-sm-3">
                <div class="row">
                    <div class="col-sm-10">
                        <?php
                        echo '<form class="form-inline" action="/~na18a028/view/modifierRubrique.php" method="post">
                        <button class="btn btn-outline-primary" type="submit" name="modifierRubrique" value="'.$row['nom'].'">Modifier</button>
                        </form>';
                        ?>
                    </div>
                </div>
                <div class="row" style="margin-top:10px">
                    <div class="col-sm-10">
                        <?php
                        echo '<form class="form-inline" action="/~na18a028/controller/supprimerRubriqueController.php" method="post">
                        <button class="btn btn-outline-danger" type="submit" name="supprimerRubrique" value="'.$row['nom'].'">Supprimer</button>
                        </form>';
                        ?>
                    </div>
                </div>
            </div>
        </div>
            
        <?php }
        echo '</div>';
        $conn = null;
    }
        ?>
</div>

</body>
</html>