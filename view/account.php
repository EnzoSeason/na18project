<?php session_start(); //var_dump($_SESSION);?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <title>Sign in Marketplace NA18 Group7</title>
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
    if(isset($_SESSION['userExist'])){
        session_unset();
        echo'<p style="color:red;">Email a déjà existé. Verifiez les informations bancaires si vous avez besoin d\'un compte d\'Acheteur ou Vendeur.</p>';
    }
    ?>
    <form action="/~na18a028/controller/updateUserController.php" method="POST"> 

    <div class="form-group row">
        <label for="Login" class="col-sm-2 col-form-label">Login</label>
        <div class="col-sm-10">
        <?php 
        echo '<input readonly type="text" class="form-control-plaintext" id="Login" name="login" placeholder="Login" value="'.$_SESSION['login'].'" required>';
        ?>
        </div>
    </div>

    <div class="form-group row">
        <label for="Password" class="col-sm-2 col-form-label">Password</label>
        <div class="col-sm-10">
        <?php 
        echo '<input type="password" class="form-control" id="Password" name="password" placeholder="Password" value="'.$_SESSION['password'].'"required>';
        ?>
        </div>
    </div>

    <div class="form-group row">
        <div class="col">
            <label for="Nom" class="col-form-label">Nom</label>
            <?php
            if(isset($_SESSION['nom'])){
                echo '<input type="text" class="form-control" id="Nom" name="nom" placeholder="Nom" value="'.$_SESSION['nom'].'">';
            } else {
                echo '<input type="text" class="form-control" id="Nom" name="nom" placeholder="Nom">';
            }
            ?>
        </div>
        <div class="col">
            <label for="Préom" class="col-form-label">Prénom</label>
            <?php
            if(isset($_SESSION['prenom'])){
                echo '<input type="text" class="form-control" id="Prénom" name="prenom" placeholder="Prénom" value="'.$_SESSION['prenom'].'">';
            } else {
                echo '<input type="text" class="form-control" id="Prénom" name="prenom" placeholder="Prénom">';
            }
            ?>
        </div>
    </div>

    <div class="form-group row">
        <label for="Email" class="col-sm-2 col-form-label">Email</label>
        <div class="col-sm-10">
        <?php 
        echo '<input type="email" class="form-control" id="Email" name="email" placeholder="Email" value="'.$_SESSION['email'].'"required>';
        ?>
        </div>
    </div>

    <?php if($_SESSION['userType']!='Admin'){ ?>

    <h6>Si vous avez besoin de créer un compte de <span style="color:red;">Vendeur ou Acheteur</span>, Vous devez remplir <span style="color:red;">les informations bancaires</span></h6><br />

    <div class="form-group row">
        <label for="Address" class="col-sm-2 col-form-label">Adresse</label>
        <div class="col-sm-10">
        <?php
            if(isset($_SESSION['adresse'])){
                echo '<input type="text" class="form-control" id="Address" name="adresse" placeholder="adresse" value="'.$_SESSION['adresse'].'">';
            } else {
                echo '<input type="text" class="form-control" id="Address" name="adresse" placeholder="adresse">';
            }
        ?>
        </div>
    </div>
    <div class="form-group row">
        <div class="col">
            <label for="numCarte" class="col-form-label">Numéro de carte: </label>
            <?php
            if(isset($_SESSION['coobanquenum'])){
                echo '<input type="text" class="form-control" id="numCarte" name="coobanquenum" placeholder="16 numéros" minlength="16" value="'.$_SESSION['coobanquenum'].'">';
            } else {
                echo '<input type="text" class="form-control" id="numCarte" name="coobanquenum" placeholder="16 numéros" minlength="16">';
            }
            ?>
        </div>
        <div class="col">
            <label for="dateExp" class="col-form-label">Date d'expiration: </label>
            <?php
            if(isset($_SESSION['dateexpiration'])){
                echo '<input type="text" class="form-control" id="dateExp" name="dateexpiration" placeholder="00/00" pattern="\d\d/\d\d" value="'.$_SESSION['dateexpiration'].'">';
            } else {
                echo '<input type="text" class="form-control" id="dateExp" name="dateexpiration" placeholder="00/00" pattern="\d\d/\d\d">';
            }
            ?>
        </div>
        <div class="col">
            <label for="codeSecurity" class="col-form-label">Code de sécurité: </label>
            <?php
            if(isset($_SESSION['cryptocarte'])){
                echo '<input type="text" class="form-control" id="codeSecurity" name="cryptocarte" placeholder="3 numéros" minlength="3" value="'.$_SESSION['cryptocarte'].'">';
            } else {
                echo '<input type="text" class="form-control" id="codeSecurity" name="cryptocarte" placeholder="3 numéros" minlength="3">';
            }
            ?>
        </div>
    </div>
    
    <?php } ?>

    <div class="form-group row">
        <div class="col-sm-10">
        <button type="submit" class="btn btn-primary">Mis à jour</button>
        </div>
    </div>
    </form>
</div>
    
</body>
</html>